<?php

namespace App\Notifications;

use App\Enums\VerificationStatus;
use App\Support\VerifiableModuleRegistry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Dikirim ke Operator yang mengajukan data, saat Validator Desa
 * menyetujui/menolak/minta revisi (Phase 4 + Phase 7 terhubung di sini).
 *
 * Channel 'database' -> muncul di Notification Center (bell icon navbar).
 * Channel 'mail'      -> dikirim via Laravel Mail (default driver: log,
 *                        lihat .env MAIL_MAILER — aman untuk development,
 *                        ganti ke smtp di production).
 */
class VerificationDecided extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $module,
        private readonly Model $record,
        private readonly VerificationStatus $decision,
        private readonly ?string $note,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'module' => $this->module,
            'module_label' => VerifiableModuleRegistry::labels()[$this->module] ?? $this->module,
            'title' => VerifiableModuleRegistry::titleFor($this->module, $this->record),
            'decision' => $this->decision->value,
            'decision_label' => $this->decision->label(),
            'note' => $this->note,
            'url' => VerifiableModuleRegistry::routeFor($this->module, $this->record),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $title = VerifiableModuleRegistry::titleFor($this->module, $this->record);
        $label = VerifiableModuleRegistry::labels()[$this->module] ?? $this->module;

        $message = (new MailMessage)
            ->subject("[SIK Ampel] {$label} \"{$title}\" — {$this->decision->label()}")
            ->greeting("Halo {$notifiable->fullname},")
            ->line("Pengajuan {$label} berikut telah {$this->decision->label()}:")
            ->line("**{$title}**");

        if ($this->note) {
            $message->line("Catatan dari Validator: \"{$this->note}\"");
        }

        return $message
            ->action('Lihat Detail', VerifiableModuleRegistry::routeFor($this->module, $this->record))
            ->line('Email ini dikirim otomatis oleh Sistem Informasi Kependudukan Kecamatan Ampel.');
    }
}
