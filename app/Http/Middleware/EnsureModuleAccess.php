<?php

namespace App\Http\Middleware;

use App\Support\Rbac;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Dipasang lewat alias 'module' (lihat bootstrap/app.php), dipakai di
 * routes seperti:
 *
 *   Route::get('/users', [UserController::class, 'index'])
 *       ->middleware('module:user,read');
 *
 * Logic "siapa boleh apa" SENGAJA tidak ditulis di sini — itu semua ada di
 * App\Support\Rbac, supaya saat menambah role/modul baru di fase
 * berikutnya kita tidak perlu menyentuh file ini.
 */
class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module, string $action = 'read'): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->role || ! Rbac::has($user->role->code, $module, $action)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
