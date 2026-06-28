<?php

namespace App\Http\Controllers;

use App\Enums\AuditAction;
use App\Models\DatabaseBackup;
use App\Services\AuditService;
use App\Services\BackupService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function __construct(
        private readonly BackupService $backups,
        private readonly AuditService $audit,
    ) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('backup.read'), 403);

        return view('settings.backup', [
            'backups' => DatabaseBackup::with('creator')->orderByDesc('backup_date')->paginate(10),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->can('backup.create'), 403);

        try {
            $backup = $this->backups->create($request->user()->id);

            $this->audit->record(userId: $request->user()->id, module: 'backup', action: AuditAction::Backup, newValue: ['filename' => $backup->filename], request: $request);

            return back()->with('success', "Backup berhasil dibuat: {$backup->filename} ({$backup->humanSize()}).");
        } catch (ProcessFailedException|RuntimeException $e) {
            return back()->withErrors(['backup' => 'Backup gagal: '.$e->getMessage()]);
        }
    }

    public function download(Request $request, DatabaseBackup $backup): Response
    {
        abort_unless($request->user()->can('backup.read'), 403);

        return response()->download($this->backups->downloadPath($backup));
    }

    public function restore(Request $request, DatabaseBackup $backup): RedirectResponse
    {
        // Restore SENGAJA pakai permission 'restore' yang berbeda dari
        // 'backup' — keduanya sama-sama hanya dimiliki SUPER_ADMIN di
        // matrix, tapi dipisah supaya jelas mana yang aksi DESTRUKTIF.
        abort_unless($request->user()->can('restore.create'), 403);

        try {
            $this->backups->restore($backup);

            $this->audit->record(userId: $request->user()->id, module: 'restore', action: AuditAction::Restore, newValue: ['filename' => $backup->filename], request: $request);

            return back()->with('success', "Database berhasil di-restore dari {$backup->filename}.");
        } catch (ProcessFailedException|RuntimeException $e) {
            return back()->withErrors(['restore' => 'Restore gagal: '.$e->getMessage()]);
        }
    }

    public function destroy(Request $request, DatabaseBackup $backup): RedirectResponse
    {
        abort_unless($request->user()->can('backup.delete'), 403);

        $this->backups->delete($backup);

        return back()->with('success', 'File backup berhasil dihapus.');
    }
}
