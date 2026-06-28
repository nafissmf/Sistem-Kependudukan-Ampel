<?php

namespace App\Services\WhatsApp;

use App\Models\WhatsappLog;
use Illuminate\Support\Facades\Log;

/**
 * Implementasi DEFAULT — hanya mencatat ke log + tabel whatsapp_logs,
 * TIDAK benar-benar mengirim WhatsApp sungguhan.
 *
 * Brief minta integrasi WhatsApp Business API, tapi itu butuh akun &
 * API key resmi yang tidak saya punya. Supaya kodenya tetap berguna dan
 * mudah di-upgrade nanti, logic pengiriman WhatsApp di seluruh aplikasi
 * SELALU lewat WhatsAppServiceInterface ini — untuk pasang provider asli
 * (Fonnte, Twilio, WhatsApp Cloud API resmi, dst), cukup:
 *
 *   1. Buat class baru, contoh: FonnteWhatsAppService implements WhatsAppServiceInterface
 *   2. Daftarkan binding-nya di AppServiceProvider::register():
 *        $this->app->bind(WhatsAppServiceInterface::class, FonnteWhatsAppService::class);
 *
 * Tidak ada controller/service lain yang perlu diubah.
 */
class LogWhatsAppService implements WhatsAppServiceInterface
{
    public function send(string $phone, string $message): bool
    {
        Log::info("[WhatsApp:LOG] Ke {$phone}: {$message}");

        WhatsappLog::create([
            'phone' => $phone,
            'message' => $message,
            'status' => 'SENT',
        ]);

        return true;
    }
}
