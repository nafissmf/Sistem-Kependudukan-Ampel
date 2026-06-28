<?php

namespace App\Providers;

use App\Models\EmailLog;
use App\Models\User;
use App\Repositories\Contracts\CitizenRepositoryInterface;
use App\Repositories\Contracts\FamilyCardRepositoryInterface;
use App\Repositories\Contracts\HouseRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\CitizenRepository;
use App\Repositories\Eloquent\FamilyCardRepository;
use App\Repositories\Eloquent\HouseRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\WhatsApp\LogWhatsAppService;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use App\Support\Rbac;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CitizenRepositoryInterface::class, CitizenRepository::class);
        $this->app->bind(FamilyCardRepositoryInterface::class, FamilyCardRepository::class);
        $this->app->bind(HouseRepositoryInterface::class, HouseRepository::class);
        $this->app->bind(WhatsAppServiceInterface::class, LogWhatsAppService::class);
    }

    public function boot(): void
    {
        /**
         * Menjembatani Rbac::matrix() ke sistem otorisasi native Laravel.
         * Setelah ini, di Controller bisa pakai:
         *
         *   $this->authorize('penduduk.create');
         *
         * dan di Blade bisa pakai:
         *
         *   @can('penduduk.create') ... @endcan
         *
         * Ability ditulis dengan format "module.action". Kalau formatnya
         * tidak cocok (tidak ada titik), kembalikan null supaya Laravel
         * lanjut mengecek Gate/Policy lain seperti biasa.
         */
        Gate::before(function (User $user, string $ability) {
            if (! str_contains($ability, '.')) {
                return null;
            }

            [$module, $action] = explode('.', $ability, 2);

            return Rbac::has($user->role?->code ?? '', $module, $action) ?: null;
        });

        /**
         * Mencatat SETIAP email yang terkirim (lewat channel mail apa pun,
         * termasuk Notification::toMail()) ke tabel `email_logs`, sesuai
         * dokumen "EMAIL LOG". Dipasang di sini (bukan di tiap Mailable
         * satu-satu) supaya otomatis mencakup email baru di fase
         * berikutnya tanpa perlu diingat-ingat lagi.
         */
        Event::listen(MessageSent::class, function (MessageSent $event) {
            $to = $event->message->getTo();
            $recipient = isset($to[0]) ? $to[0]->getAddress() : 'unknown';

            EmailLog::create([
                'recipient' => $recipient,
                'subject' => $event->message->getSubject() ?? '(tanpa subjek)',
                'status' => 'SENT',
            ]);
        });
    }
}
