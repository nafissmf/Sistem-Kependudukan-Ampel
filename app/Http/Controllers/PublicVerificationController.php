<?php

namespace App\Http\Controllers;

use App\Models\FamilyCard;
use App\Models\House;
use Illuminate\Contracts\View\View;

/**
 * Halaman publik yang muncul saat QR Code di-scan (sesuai dokumen
 * "SCAN QR": "Scan berhasil -> Redirect ke halaman detail rumah").
 * TIDAK memerlukan login — tapi HANYA menampilkan data yang aman untuk
 * publik (lihat catatan privasi di App\Services\QrCodeService).
 */
class PublicVerificationController extends Controller
{
    public function house(string $house): View
    {
        $record = House::with(['village', 'hamlet', 'rtRw'])->findOrFail($house);

        return view('public.verify-house', ['house' => $record]);
    }

    public function familyCard(string $familyCard): View
    {
        $record = FamilyCard::with(['headCitizen', 'village'])->findOrFail($familyCard);

        return view('public.verify-family-card', ['familyCard' => $record]);
    }
}
