<?php

namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Exceptions\CitizenNotFoundException;
use App\Exceptions\DuplicateNikException;
use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\BloodType;
use App\Models\Citizen;
use App\Models\Education;
use App\Models\FamilyCard;
use App\Models\FamilyRelationship;
use App\Models\Job;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\Village;
use App\Services\CitizenService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controller Layer — hanya menerima request & mengembalikan response,
 * semua logic ada di CitizenService (lihat app/Services/CitizenService.php).
 */
class CitizenController extends Controller
{
    public function __construct(private readonly CitizenService $citizens) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('penduduk.read'), 403);

        $citizens = $this->citizens->list(
            perPage: 15,
            filters: $request->only(['search', 'village_id', 'verification_status', 'gender']),
        );

        return view('citizens.index', [
            'citizens' => $citizens,
            'villages' => Village::orderBy('name')->get(['id', 'name']),
            'statuses' => VerificationStatus::cases(),
            'filters' => $request->only(['search', 'village_id', 'verification_status', 'gender']),
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('penduduk.create'), 403);

        return view('citizens.form', [
            'citizen' => new Citizen,
            ...$this->formOptions(),
        ]);
    }

    public function store(StoreCitizenRequest $request): RedirectResponse
    {
        try {
            $citizen = $this->citizens->create($request->validated(), $request->user()->id, $request);

            return redirect()->route('citizens.show', $citizen)->with('success', 'Data penduduk berhasil ditambahkan dan menunggu verifikasi.');
        } catch (DuplicateNikException $e) {
            return back()->withInput()->withErrors(['nik' => $e->getMessage()]);
        }
    }

    public function show(Request $request, string $citizen): View
    {
        abort_unless($request->user()->can('penduduk.read'), 403);

        try {
            return view('citizens.show', ['citizen' => $this->citizens->find($citizen)]);
        } catch (CitizenNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit(Request $request, string $citizen): View
    {
        abort_unless($request->user()->can('penduduk.update'), 403);

        try {
            return view('citizens.form', [
                'citizen' => $this->citizens->find($citizen),
                ...$this->formOptions(),
            ]);
        } catch (CitizenNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function update(UpdateCitizenRequest $request, string $citizen): RedirectResponse
    {
        try {
            $updated = $this->citizens->update($citizen, $request->validated(), $request->user()->id, $request);

            return redirect()->route('citizens.show', $updated)->with('success', 'Data penduduk berhasil diperbarui dan menunggu verifikasi ulang.');
        } catch (CitizenNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (DuplicateNikException $e) {
            return back()->withInput()->withErrors(['nik' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, string $citizen): RedirectResponse
    {
        abort_unless($request->user()->can('penduduk.delete'), 403);

        try {
            $this->citizens->delete($citizen, $request->user()->id, $request);

            return redirect()->route('citizens.index')->with('success', 'Data penduduk berhasil dihapus.');
        } catch (CitizenNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    /**
     * Opsi dropdown yang dipakai form create & edit.
     *
     * Data referensi (agama/pendidikan/dst) di-cache 1 jam — sesuai
     * dokumen "CACHE: Master Data" (Phase 9 performance). Cache otomatis
     * usang sendiri (tidak perlu invalidasi manual) karena tabel-tabel
     * ini nyaris tidak pernah berubah di luar proses seeding awal.
     */
    private function formOptions(): array
    {
        return [
            'religions' => \Illuminate\Support\Facades\Cache::remember('ref:religions', 3600, fn () => Religion::all(['id', 'name'])),
            'educations' => \Illuminate\Support\Facades\Cache::remember('ref:educations', 3600, fn () => Education::all(['id', 'name'])),
            'jobs' => \Illuminate\Support\Facades\Cache::remember('ref:jobs', 3600, fn () => Job::all(['id', 'name'])),
            'bloodTypes' => \Illuminate\Support\Facades\Cache::remember('ref:blood_types', 3600, fn () => BloodType::all(['id', 'name'])),
            'maritalStatuses' => \Illuminate\Support\Facades\Cache::remember('ref:marital_statuses', 3600, fn () => MaritalStatus::all(['id', 'name'])),
            'relationships' => \Illuminate\Support\Facades\Cache::remember('ref:relationships', 3600, fn () => FamilyRelationship::all(['id', 'name'])),
            'villages' => \Illuminate\Support\Facades\Cache::remember('ref:villages', 3600, fn () => Village::orderBy('name')->get(['id', 'name'])),
            'familyCards' => FamilyCard::orderBy('number')->limit(200)->get(['id', 'number']),
        ];
    }
}
