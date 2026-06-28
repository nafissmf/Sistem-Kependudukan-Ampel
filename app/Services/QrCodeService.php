<?php

namespace App\Services;

use App\Models\FamilyCard;
use App\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * QR Code generation (Phase 4).
 *
 * CATATAN PRIVASI: brief minta QR untuk Rumah berisi URL publik
 * (`https://domain.go.id/house/{uuid}`). Kita HANYA membuat QR publik
 * untuk House & FamilyCard (data semi-publik seperti alamat/nomor KK),
 * BUKAN untuk Citizen perorangan — supaya tidak membuat endpoint publik
 * yang membocorkan NIK. Halaman publik KK pun menyamarkan sebagian
 * digit nomor KK (lihat resources/views/public/verify-family-card.blade.php).
 *
 * Format SVG dipilih (bukan PNG) karena backend SVG (bacon/bacon-qr-code)
 * murni PHP, tidak butuh extension ext-gd/ext-imagick — lebih portable
 * untuk berbagai environment hosting.
 */
class QrCodeService
{
    public function generateForHouse(House $house): string
    {
        $url = route('public.verify.house', $house);
        $path = "qrcodes/houses/{$house->id}.svg";

        $this->writeSvg($path, $url);
        $house->update(['qr_code' => $path]);

        return $path;
    }

    public function generateForFamilyCard(FamilyCard $familyCard): string
    {
        $url = route('public.verify.family-card', $familyCard);
        $path = "qrcodes/family-cards/{$familyCard->id}.svg";

        $this->writeSvg($path, $url);
        $familyCard->update(['qr_code' => $path]);

        return $path;
    }

    private function writeSvg(string $path, string $data): void
    {
        $svg = QrCode::format('svg')->size(300)->margin(1)->generate($data);
        Storage::disk('public')->put($path, $svg);
    }

    public function urlFor(Model $record): ?string
    {
        return $record->qr_code ? Storage::disk('public')->url($record->qr_code) : null;
    }
}
