<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

/**
 * Captcha matematika sederhana, disimpan di session server-side.
 *
 * CATATAN PRODUKSI: ini cukup untuk Phase 1 (mencegah bot paling dasar &
 * submit form otomatis), tapi BUKAN pengganti captcha sungguhan. Sebelum
 * go-live, ganti dengan layanan seperti Cloudflare Turnstile atau hCaptcha
 * (key-nya nanti disimpan di tabel `settings`, modul Pengaturan pada fase
 * Security Hardening).
 */
class CaptchaService
{
    private const SESSION_KEY = 'login_captcha_answer';

    /** Generate soal baru, simpan jawabannya di session, kembalikan teks soal untuk ditampilkan. */
    public function generate(): array
    {
        $a = random_int(1, 8);
        $b = random_int(1, 8);

        Session::put(self::SESSION_KEY, $a + $b);

        return ['a' => $a, 'b' => $b];
    }

    public function verify(string $answer): bool
    {
        $expected = Session::get(self::SESSION_KEY);
        $isValid = $expected !== null && (int) $answer === (int) $expected;

        // Soal selalu dipakai sekali, supaya tidak bisa di-replay.
        Session::forget(self::SESSION_KEY);

        return $isValid;
    }
}
