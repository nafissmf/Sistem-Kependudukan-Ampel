<?php

namespace App\Enums;

/**
 * Mengikuti dokumen "ROLE & PERMISSION MATRIX": 6 role resmi.
 */
enum RoleCode: string
{
    case SuperAdmin = 'SUPER_ADMIN';
    case OperatorKecamatan = 'OPERATOR_KECAMATAN';
    case OperatorDesa = 'OPERATOR_DESA';
    case ValidatorDesa = 'VALIDATOR_DESA';
    case Camat = 'CAMAT';
    case KepalaDesa = 'KEPALA_DESA';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::OperatorKecamatan => 'Operator Kecamatan',
            self::OperatorDesa => 'Operator Desa',
            self::ValidatorDesa => 'Validator Desa',
            self::Camat => 'Camat',
            self::KepalaDesa => 'Kepala Desa',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Akses penuh ke seluruh modul, pengguna, dan konfigurasi sistem.',
            self::OperatorKecamatan => 'Mengelola data seluruh desa di Kecamatan Ampel, tanpa hak hapus permanen.',
            self::OperatorDesa => 'Menginput data Penduduk/KK/Rumah untuk desanya masing-masing.',
            self::ValidatorDesa => 'Memverifikasi (approve/reject/revisi) pengajuan data dengan tanda tangan digital.',
            self::Camat => 'Akses baca untuk monitoring dashboard, analytics, GIS, dan laporan.',
            self::KepalaDesa => 'Akses baca untuk dashboard dan laporan, terbatas pada desanya sendiri.',
        };
    }
}
