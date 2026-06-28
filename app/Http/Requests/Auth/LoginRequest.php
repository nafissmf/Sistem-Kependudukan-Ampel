<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string', 'min:3', 'max:150'],
            'password' => ['required', 'string'],
            'captcha_answer' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'identifier.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'captcha_answer.required' => 'Jawab pertanyaan keamanan dahulu.',
        ];
    }

    /**
     * Rate limit sesuai dokumen SECURITY: "Login 5x / menit".
     * Kunci limiter digabung dari identifier + IP, supaya satu IP tidak
     * bisa brute-force banyak akun sekaligus, dan satu akun tidak bisa
     * di-brute-force dari banyak IP berbeda tanpa kena limit per IP juga.
     */
    public function ensureIsNotRateLimited(): void
    {
        $key = $this->throttleKey();

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'identifier' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
        ]);
    }

    public function hitRateLimiter(): void
    {
        RateLimiter::hit($this->throttleKey(), 60);
    }

    public function clearRateLimiter(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    public function throttleKey(): string
    {
        return mb_strtolower($this->input('identifier', '')).'|'.$this->ip();
    }
}
