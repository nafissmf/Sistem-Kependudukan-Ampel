<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header keamanan tambahan di luar yang sudah otomatis ditangani Laravel
 * (CSRF, XSS escaping di Blade, dst), sesuai dokumen "SECURITY REQUIREMENT".
 *
 * CSP sengaja masih cukup permisif (unsafe-inline untuk script/style)
 * karena Alpine.js dan beberapa inline `<script>` di Blade kita butuh
 * itu. Untuk hardening lebih jauh di production sungguhan, pertimbangkan
 * memindahkan semua inline script ke file terpisah + pakai nonce.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(self), geolocation=(self), microphone=()');

        if (! $request->is('verify/*')) {
            // Endpoint publik /verify/* perlu lebih longgar (diakses dari
            // luar lewat hasil scan QR di banyak jenis browser/aplikasi
            // kamera HP); selain itu, terapkan CSP standar.
            $response->headers->set(
                'Content-Security-Policy',
                "default-src 'self'; ".
                "script-src 'self' 'unsafe-inline' 'unsafe-eval'; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; ".
                "font-src 'self' https://fonts.gstatic.com; ".
                "img-src 'self' data: https://unpkg.com https://*.tile.openstreetmap.org; ".
                "connect-src 'self';",
            );
        }

        return $response;
    }
}
