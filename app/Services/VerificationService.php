<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\VerificationStatus;
use App\Exceptions\VerificationTargetNotFoundException;
use App\Models\User;
use App\Models\Verification;
use App\Notifications\VerificationDecided;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use App\Support\VerifiableModuleRegistry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Service Layer untuk modul Verifikasi (Phase 4).
 *
 * Sengaja ditulis GENERIK (bukan VerifyCitizenService, VerifyHouseService,
 * dst terpisah) karena workflow approve/reject/revisi-nya identik untuk
 * Penduduk/KK/Rumah — hanya target model-nya yang beda (lihat
 * VerifiableModuleRegistry). Ini mengikuti prinsip DRY dari brief:
 * "Tidak membuat kode duplikat."
 */
class VerificationService
{
    public function __construct(
        private readonly AuditService $audit,
        private readonly WhatsAppServiceInterface $whatsApp,
    ) {}

    /**
     * Daftar semua data yang masih PENDING atau REVISION, dari ketiga
     * modul sekaligus (atau difilter satu modul), untuk halaman utama
     * Validator Desa.
     */
    public function listPending(?string $moduleFilter = null): Collection
    {
        $modules = $moduleFilter ? [$moduleFilter => VerifiableModuleRegistry::modelFor($moduleFilter)] : VerifiableModuleRegistry::map();
        $items = collect();

        foreach ($modules as $module => $modelClass) {
            if (! $modelClass) {
                continue;
            }

            $records = $modelClass::query()
                ->whereIn('verification_status', [VerificationStatus::Pending->value, VerificationStatus::Revision->value])
                ->orderByDesc('created_at')
                ->get();

            foreach ($records as $record) {
                $items->push([
                    'module' => $module,
                    'module_label' => VerifiableModuleRegistry::labels()[$module],
                    'record' => $record,
                    'title' => VerifiableModuleRegistry::titleFor($module, $record),
                    'url' => VerifiableModuleRegistry::routeFor($module, $record),
                    'status' => $record->verification_status,
                    'created_at' => $record->created_at,
                ]);
            }
        }

        return $items->sortByDesc('created_at')->values();
    }

    public function findTarget(string $module, string $referenceId): Model
    {
        $modelClass = VerifiableModuleRegistry::modelFor($module);

        if (! $modelClass) {
            throw new VerificationTargetNotFoundException("Modul '{$module}' tidak dikenal.");
        }

        $record = $modelClass::find($referenceId);

        if (! $record) {
            throw new VerificationTargetNotFoundException;
        }

        return $record;
    }

    public function decide(
        string $module,
        string $referenceId,
        VerificationStatus $decision,
        string $validatorId,
        ?string $note,
        ?string $signatureDataUrl,
        ?Request $request = null,
    ): Verification {
        $record = $this->findTarget($module, $referenceId);

        $signaturePath = $signatureDataUrl ? $this->storeSignature($signatureDataUrl, $validatorId) : null;

        $verification = Verification::create([
            'module' => $module,
            'reference_id' => $referenceId,
            'validator_id' => $validatorId,
            'status' => $decision,
            'note' => $note,
            'signature' => $signaturePath,
            'verified_at' => now(),
        ]);

        $record->update(['verification_status' => $decision]);

        $this->notifySubmitter($module, $record, $decision, $note);

        $this->audit->record(
            userId: $validatorId,
            module: $module,
            action: $decision === VerificationStatus::Approved ? AuditAction::Approve : AuditAction::Reject,
            newValue: ['verification_status' => $decision->value, 'note' => $note],
            request: $request,
        );

        return $verification;
    }

    /** Tanda tangan digital dikirim dari <canvas> sebagai data URL base64, lihat resources/js/signature-pad.js. */
    private function storeSignature(string $dataUrl, string $validatorId): string
    {
        [, $encoded] = explode(',', $dataUrl, 2) + [null, $dataUrl];
        $binary = base64_decode($encoded);
        $filename = 'signatures/'.$validatorId.'-'.now()->timestamp.'.png';

        Storage::disk('public')->put($filename, $binary);

        return $filename;
    }

    /**
     * Beri tahu pengajunya (created_by) lewat Notification Center + Email
     * + WhatsApp (Phase 7). Kalau created_by null (data lama/seed), lewati
     * saja — tidak ada yang perlu diberi tahu.
     */
    private function notifySubmitter(string $module, Model $record, VerificationStatus $decision, ?string $note): void
    {
        $submitterId = $record->created_by ?? null;

        if (! $submitterId) {
            return;
        }

        $submitter = User::find($submitterId);

        if (! $submitter) {
            return;
        }

        $submitter->notify(new VerificationDecided($module, $record, $decision, $note));

        if ($submitter->phone) {
            $title = VerifiableModuleRegistry::titleFor($module, $record);
            $this->whatsApp->send(
                $submitter->phone,
                "Halo {$submitter->fullname}, pengajuan \"{$title}\" telah {$decision->label()}.".($note ? " Catatan: {$note}" : ''),
            );
        }
    }
}
