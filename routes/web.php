<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CitizenImportExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicVerificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

// ============================================================
// PUBLIC QR VERIFICATION (tanpa login) — sesuai dokumen "SCAN QR".
// Lihat catatan privasi di App\Services\QrCodeService: hanya House &
// FamilyCard yang punya halaman publik, bukan Citizen perorangan.
// ============================================================
Route::get('/verify/house/{house}', [PublicVerificationController::class, 'house'])->name('public.verify.house');
Route::get('/verify/family-card/{familyCard}', [PublicVerificationController::class, 'familyCard'])->name('public.verify.family-card');

// ============================================================
// AUTH (guest only)
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // ============================================================
    // DASHBOARD — setiap modul dilindungi middleware('module:<nama>,read').
    // ============================================================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('module:dashboard,read')
        ->name('dashboard');

    // ============================================================
    // PENDUDUK (Phase 3) — pengecekan permission per-aksi dilakukan di
    // dalam Controller/Form Request, bukan cuma di middleware, supaya
    // granular per CRUD action (create vs delete beda izin).
    //
    // Route import/export HARUS didaftarkan SEBELUM Route::resource,
    // supaya '/citizens/import' tidak ketangkap sebagai wildcard
    // {citizen} milik route show().
    // ============================================================
    Route::get('/citizens/import', [CitizenImportExportController::class, 'showImport'])->name('citizens.import');
    Route::post('/citizens/import/preview', [CitizenImportExportController::class, 'preview'])->name('citizens.import.preview');
    Route::post('/citizens/import/store', [CitizenImportExportController::class, 'store'])->name('citizens.import.store');
    Route::get('/citizens/export', [CitizenImportExportController::class, 'export'])->name('citizens.export');

    Route::resource('citizens', CitizenController::class)->parameters(['citizens' => 'citizen']);
    Route::resource('family-cards', FamilyCardController::class)->parameters(['family-cards' => 'family_card']);
    Route::resource('houses', HouseController::class)->parameters(['houses' => 'house']);

    Route::post('/houses/{house}/qr-code', [HouseController::class, 'generateQrCode'])->name('houses.qr-code');
    Route::post('/family-cards/{family_card}/qr-code', [FamilyCardController::class, 'generateQrCode'])->name('family-cards.qr-code');

    // ============================================================
    // VERIFIKASI (Phase 4) — generik untuk Penduduk/KK/Rumah, lihat
    // App\Support\VerifiableModuleRegistry.
    // ============================================================
    Route::get('/verification', [VerificationController::class, 'index'])->name('verification.index');
    Route::get('/verification/{module}/{reference}', [VerificationController::class, 'show'])->name('verification.show');
    Route::post('/verification/{module}/{reference}/decide', [VerificationController::class, 'decide'])->name('verification.decide');

    // ============================================================
    // SCANNER, GIS, ANALYTICS (Phase 4-5)
    // ============================================================
    Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner.index');
    Route::get('/gis', [GisController::class, 'index'])->name('gis.index');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // ============================================================
    // LAPORAN (Phase 6 + 8)
    // ============================================================
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/family-cards', [ReportController::class, 'exportFamilyCards'])->name('reports.family-cards');
    Route::get('/reports/houses', [ReportController::class, 'exportHouses'])->name('reports.houses');

    // ============================================================
    // BACKUP & RESTORE (Phase 6) — Super Admin saja, lihat App\Support\Rbac.
    // ============================================================
    Route::get('/settings/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/settings/backup', [BackupController::class, 'store'])->name('backup.store');
    Route::get('/settings/backup/{backup}/download', [BackupController::class, 'download'])->name('backup.download');
    Route::post('/settings/backup/{backup}/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::delete('/settings/backup/{backup}', [BackupController::class, 'destroy'])->name('backup.destroy');

    // ============================================================
    // NOTIFICATIONS (Phase 7)
    // ============================================================
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // ============================================================
    // AUDIT LOG & MONITORING (Phase 8)
    // ============================================================
    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    // ============================================================
    // USER MANAGEMENT
    // ============================================================
    Route::resource('users', UserController::class)->parameters(['users' => 'user'])->except(['show']);

    // ============================================================
    // ROLE MANAGEMENT (read-only)
    // ============================================================
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');

    // ============================================================
    // SETTINGS (hub page)
    // ============================================================
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
});
