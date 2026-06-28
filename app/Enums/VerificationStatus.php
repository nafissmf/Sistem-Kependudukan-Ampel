<?php

namespace App\Enums;

/**
 * Status pengajuan data Penduduk/KK/Rumah, sesuai dokumen "VERIFIKASI":
 * Pending -> Approved / Rejected / Revision.
 */
enum VerificationStatus: string
{
    case Pending = 'PENDING';
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
    case Revision = 'REVISION';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Verifikasi',
            self::Approved => 'Disetujui',
            self::Rejected => 'Ditolak',
            self::Revision => 'Perlu Revisi',
        };
    }

    /** Kelas warna Tailwind untuk badge status, dipakai di Blade. */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-50 text-warning-600 dark:bg-warning-500/15',
            self::Approved => 'bg-primary-50 text-primary-700 dark:bg-primary-600/15 dark:text-primary-300',
            self::Rejected => 'bg-red-50 text-danger-600 dark:bg-danger-500/15',
            self::Revision => 'bg-secondary-50 text-secondary-700 dark:bg-secondary-600/15 dark:text-secondary-400',
        };
    }
}
