<?php

namespace App\Support;

use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\House;
use Illuminate\Database\Eloquent\Model;

/**
 * Satu tempat untuk memetakan nama modul RBAC ('penduduk', 'kk', 'rumah')
 * ke Eloquent model yang sebenarnya. Dipakai oleh VerificationService dan
 * QrCodeService supaya logic approve/reject/generate-QR tidak perlu
 * tahu detail tiap modul satu per satu.
 */
class VerifiableModuleRegistry
{
    /** @return array<string, class-string<Model>> */
    public static function map(): array
    {
        return [
            'penduduk' => Citizen::class,
            'kk' => FamilyCard::class,
            'rumah' => House::class,
        ];
    }

    public static function labels(): array
    {
        return [
            'penduduk' => 'Penduduk',
            'kk' => 'Kartu Keluarga',
            'rumah' => 'Rumah',
        ];
    }

    public static function modelFor(string $module): ?string
    {
        return self::map()[$module] ?? null;
    }

    public static function routeFor(string $module, Model $record): string
    {
        return match ($module) {
            'penduduk' => route('citizens.show', $record),
            'kk' => route('family-cards.show', $record),
            'rumah' => route('houses.show', $record),
            default => '#',
        };
    }

    public static function titleFor(string $module, Model $record): string
    {
        return match ($module) {
            'penduduk' => $record->fullname,
            'kk' => 'KK '.$record->number,
            'rumah' => $record->house_number ?? 'Rumah',
            default => (string) $record->id,
        };
    }
}
