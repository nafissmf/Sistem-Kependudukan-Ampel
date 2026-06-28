<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Models\AuditLog;
use Illuminate\Http\Request;

/**
 * Mencatat satu baris audit log. Dipanggil dari Service Layer setiap kali
 * ada perubahan data (Create/Update/Delete/Approve/Reject/dll), sesuai
 * dokumen "AUDIT TRAIL": "Catat semua aktivitas ... Simpan: User, Role,
 * IP, Browser, OS, Tanggal, Jam, Lokasi".
 *
 * Lokasi geografis (dari IP) SENGAJA tidak diisi otomatis di Phase 1 —
 * itu butuh layanan IP geolocation pihak ketiga yang akan dikonfigurasi
 * di modul Pengaturan pada fase berikutnya.
 */
class AuditService
{
    public function record(
        ?string $userId,
        string $module,
        AuditAction $action,
        mixed $oldValue = null,
        mixed $newValue = null,
        ?Request $request = null,
    ): AuditLog {
        return AuditLog::create([
            'user_id' => $userId,
            'module' => $module,
            'action' => $action,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'browser' => $request?->userAgent(),
            'ip_address' => $request?->ip(),
        ]);
    }
}
