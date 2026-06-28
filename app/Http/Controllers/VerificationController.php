<?php

namespace App\Http\Controllers;

use App\Enums\VerificationStatus;
use App\Exceptions\VerificationTargetNotFoundException;
use App\Http\Requests\VerificationDecisionRequest;
use App\Services\VerificationService;
use App\Support\VerifiableModuleRegistry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(private readonly VerificationService $verifications) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('verifikasi.read'), 403);

        return view('verification.index', [
            'items' => $this->verifications->listPending($request->query('module')),
            'moduleLabels' => VerifiableModuleRegistry::labels(),
            'activeModule' => $request->query('module'),
        ]);
    }

    public function show(Request $request, string $module, string $reference): View
    {
        abort_unless($request->user()->can('verifikasi.read'), 403);

        try {
            $record = $this->verifications->findTarget($module, $reference);
        } catch (VerificationTargetNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return view('verification.show', [
            'module' => $module,
            'moduleLabel' => VerifiableModuleRegistry::labels()[$module] ?? $module,
            'record' => $record,
            'title' => VerifiableModuleRegistry::titleFor($module, $record),
        ]);
    }

    public function decide(VerificationDecisionRequest $request, string $module, string $reference): RedirectResponse
    {
        $decision = VerificationStatus::from($request->validated('decision'));

        if ($decision === VerificationStatus::Approved && empty($request->validated('signature'))) {
            return back()->withErrors(['signature' => 'Tanda tangan digital wajib diisi untuk menyetujui data.']);
        }

        try {
            $this->verifications->decide(
                module: $module,
                referenceId: $reference,
                decision: $decision,
                validatorId: $request->user()->id,
                note: $request->validated('note'),
                signatureDataUrl: $request->validated('signature'),
                request: $request,
            );
        } catch (VerificationTargetNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return redirect()->route('verification.index')->with('success', match ($decision) {
            VerificationStatus::Approved => 'Data berhasil disetujui.',
            VerificationStatus::Rejected => 'Data ditolak.',
            VerificationStatus::Revision => 'Permintaan revisi telah dikirim.',
            default => 'Keputusan tersimpan.',
        });
    }
}
