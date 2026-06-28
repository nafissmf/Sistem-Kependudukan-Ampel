<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Semua endpoint API v1 memakai guard session yang sama dengan web (cocok
 * untuk monolith Blade + AJAX). Kalau nanti perlu dikonsumsi aplikasi
 * mobile terpisah (lihat brief "MOBILE READY", Phase 9), tinggal tambah
 * guard token (Sanctum) di middleware grup ini tanpa mengubah controller.
 *
 * Rate limit 100 request/menit per user, sesuai dokumen "RATE LIMITER".
 */
Route::middleware(['auth', 'throttle:100,1'])->prefix('v1')->name('api.v1.')->group(function () {
    Route::apiResource('users', UserController::class);
});
