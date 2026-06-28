<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuditAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\AuditService;
use App\Services\CaptchaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function __construct(
        private readonly CaptchaService $captcha,
        private readonly AuditService $audit,
    ) {}

    public function create(): View
    {
        $challenge = $this->captcha->generate();

        return view('auth.login', ['challenge' => $challenge]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        if (! $this->captcha->verify($request->input('captcha_answer'))) {
            $request->hitRateLimiter();

            throw ValidationException::withMessages([
                'captcha_answer' => 'Jawaban verifikasi keamanan salah.',
            ]);
        }

        $identifier = $request->input('identifier');

        // Cari dulu apakah identifier itu username atau email, supaya
        // Auth::attempt() bisa dipanggil dengan nama kolom yang benar.
        $user = User::query()
            ->where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        // Pesan generik dengan sengaja: jangan beri tahu penyerang apakah
        // username/email ada tapi password salah, atau tidak ada sama
        // sekali (mencegah user enumeration).
        $genericError = 'Username/email atau password salah.';

        if (! $user || ! $user->is_active || $user->trashed()) {
            $request->hitRateLimiter();
            $this->logFailedAttempt($user, $request);

            throw ValidationException::withMessages(['identifier' => $genericError]);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            $request->hitRateLimiter();
            $this->logFailedAttempt($user, $request);

            throw ValidationException::withMessages(['identifier' => $genericError]);
        }

        $request->clearRateLimiter();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $user->forceFill(['last_login' => now()])->save();

        $user->loginHistories()->create([
            'login_at' => now(),
            'ip_address' => $request->ip(),
            'browser' => $request->userAgent(),
            'success' => true,
        ]);

        $this->audit->record(
            userId: $user->id,
            module: 'auth',
            action: AuditAction::Login,
            request: $request,
        );

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            $this->audit->record(
                userId: $user->id,
                module: 'auth',
                action: AuditAction::Logout,
                request: $request,
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function logFailedAttempt(?User $user, Request $request): void
    {
        if ($user) {
            $user->loginHistories()->create([
                'login_at' => now(),
                'ip_address' => $request->ip(),
                'browser' => $request->userAgent(),
                'success' => false,
            ]);
        }

        $this->audit->record(
            userId: $user?->id,
            module: 'auth',
            action: AuditAction::LoginFailed,
            request: $request,
        );
    }
}
