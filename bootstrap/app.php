<?php

use App\Http\Middleware\EnsureModuleAccess;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias 'module' dipakai di routes/web.php, contoh:
        //   Route::get('/users', ...)->middleware('module:user,read');
        // Lihat App\Http\Middleware\EnsureModuleAccess untuk logic-nya, dan
        // App\Support\Rbac untuk matrix permission-nya (single source of truth).
        $middleware->alias([
            'module' => EnsureModuleAccess::class,
        ]);

        // Phase 9: Security Hardening — header keamanan tambahan di setiap
        // response web (lihat App\Http\Middleware\SecurityHeaders).
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
