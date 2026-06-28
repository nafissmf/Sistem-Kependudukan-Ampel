<?php

namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Exceptions\HouseNotFoundException;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\FloorType;
use App\Models\House;
use App\Models\HouseStatus;
use App\Models\RoofType;
use App\Models\Village;
use App\Models\WallType;
use App\Services\HouseService;
use App\Services\QrCodeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function __construct(
        private readonly HouseService $houses,
        private readonly QrCodeService $qrCodes,
    ) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('rumah.read'), 403);

        return view('houses.index', [
            'houses' => $this->houses->list(15, $request->only(['search', 'village_id', 'verification_status'])),
            'villages' => Village::orderBy('name')->get(['id', 'name']),
            'statuses' => VerificationStatus::cases(),
            'filters' => $request->only(['search', 'village_id', 'verification_status']),
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('rumah.create'), 403);

        return view('houses.form', ['house' => new House, ...$this->formOptions()]);
    }

    public function store(StoreHouseRequest $request): RedirectResponse
    {
        $house = $this->houses->create($request->validated(), $request->user()->id, $request);

        return redirect()->route('houses.show', $house)->with('success', 'Data rumah berhasil ditambahkan dan menunggu verifikasi.');
    }

    public function show(Request $request, string $house): View
    {
        abort_unless($request->user()->can('rumah.read'), 403);

        try {
            return view('houses.show', ['house' => $this->houses->find($house)]);
        } catch (HouseNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit(Request $request, string $house): View
    {
        abort_unless($request->user()->can('rumah.update'), 403);

        try {
            return view('houses.form', ['house' => $this->houses->find($house), ...$this->formOptions()]);
        } catch (HouseNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function update(UpdateHouseRequest $request, string $house): RedirectResponse
    {
        try {
            $updated = $this->houses->update($house, $request->validated(), $request->user()->id, $request);

            return redirect()->route('houses.show', $updated)->with('success', 'Data rumah berhasil diperbarui dan menunggu verifikasi ulang.');
        } catch (HouseNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function destroy(Request $request, string $house): RedirectResponse
    {
        abort_unless($request->user()->can('rumah.delete'), 403);

        try {
            $this->houses->delete($house, $request->user()->id, $request);

            return redirect()->route('houses.index')->with('success', 'Data rumah berhasil dihapus.');
        } catch (HouseNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function generateQrCode(Request $request, string $house): RedirectResponse
    {
        abort_unless($request->user()->can('qr.create'), 403);

        $record = $this->houses->find($house);
        $this->qrCodes->generateForHouse($record);

        return redirect()->route('houses.show', $record)->with('success', 'QR Code berhasil dibuat.');
    }

    private function formOptions(): array
    {
        return [
            'villages' => Village::orderBy('name')->get(['id', 'name']),
            'roofTypes' => RoofType::all(['id', 'name']),
            'wallTypes' => WallType::all(['id', 'name']),
            'floorTypes' => FloorType::all(['id', 'name']),
            'houseStatuses' => HouseStatus::all(['id', 'name']),
        ];
    }
}
