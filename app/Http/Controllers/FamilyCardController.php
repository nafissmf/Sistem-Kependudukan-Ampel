<?php

namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Exceptions\DuplicateFamilyCardNumberException;
use App\Exceptions\FamilyCardNotFoundException;
use App\Http\Requests\StoreFamilyCardRequest;
use App\Http\Requests\UpdateFamilyCardRequest;
use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\House;
use App\Models\Village;
use App\Services\FamilyCardService;
use App\Services\QrCodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FamilyCardController extends Controller
{
    public function __construct(
        private readonly FamilyCardService $familyCards,
        private readonly QrCodeService $qrCodes,
    ) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('kk.read'), 403);

        return view('family-cards.index', [
            'familyCards' => $this->familyCards->list(15, $request->only(['search', 'village_id', 'verification_status'])),
            'villages' => Village::orderBy('name')->get(['id', 'name']),
            'statuses' => VerificationStatus::cases(),
            'filters' => $request->only(['search', 'village_id', 'verification_status']),
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('kk.create'), 403);

        return view('family-cards.form', ['familyCard' => new FamilyCard, ...$this->formOptions()]);
    }

    public function store(StoreFamilyCardRequest $request): RedirectResponse
    {
        try {
            $familyCard = $this->familyCards->create($request->validated(), $request->user()->id, $request);

            return redirect()->route('family-cards.show', $familyCard)->with('success', 'Kartu Keluarga berhasil ditambahkan dan menunggu verifikasi.');
        } catch (DuplicateFamilyCardNumberException $e) {
            return back()->withInput()->withErrors(['number' => $e->getMessage()]);
        }
    }

    public function show(Request $request, string $family_card): View
    {
        abort_unless($request->user()->can('kk.read'), 403);

        try {
            return view('family-cards.show', ['familyCard' => $this->familyCards->find($family_card)]);
        } catch (FamilyCardNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit(Request $request, string $family_card): View
    {
        abort_unless($request->user()->can('kk.update'), 403);

        try {
            return view('family-cards.form', [
                'familyCard' => $this->familyCards->find($family_card),
                ...$this->formOptions(),
            ]);
        } catch (FamilyCardNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function update(UpdateFamilyCardRequest $request, string $family_card): RedirectResponse
    {
        try {
            $updated = $this->familyCards->update($family_card, $request->validated(), $request->user()->id, $request);

            return redirect()->route('family-cards.show', $updated)->with('success', 'Kartu Keluarga berhasil diperbarui dan menunggu verifikasi ulang.');
        } catch (FamilyCardNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (DuplicateFamilyCardNumberException $e) {
            return back()->withInput()->withErrors(['number' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, string $family_card): RedirectResponse
    {
        abort_unless($request->user()->can('kk.delete'), 403);

        try {
            $this->familyCards->delete($family_card, $request->user()->id, $request);

            return redirect()->route('family-cards.index')->with('success', 'Kartu Keluarga berhasil dihapus.');
        } catch (FamilyCardNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function generateQrCode(Request $request, string $family_card): RedirectResponse
    {
        abort_unless($request->user()->can('qr.create'), 403);

        $record = $this->familyCards->find($family_card);
        $this->qrCodes->generateForFamilyCard($record);

        return redirect()->route('family-cards.show', $record)->with('success', 'QR Code berhasil dibuat.');
    }

    private function formOptions(): array
    {
        return [
            'citizens' => Citizen::orderBy('fullname')->limit(300)->get(['id', 'fullname', 'nik']),
            'houses' => House::orderBy('house_number')->limit(300)->get(['id', 'house_number', 'address']),
            'villages' => Village::orderBy('name')->get(['id', 'name']),
        ];
    }
}
