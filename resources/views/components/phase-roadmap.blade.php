@php
    $phases = [
        ['no' => 1, 'label' => 'Fondasi — Setup, Auth, RBAC', 'done' => true],
        ['no' => 2, 'label' => 'Master Data Wilayah & Referensi', 'done' => true],
        ['no' => 3, 'label' => 'Modul Penduduk, KK, Rumah', 'done' => true],
        ['no' => 4, 'label' => 'Verifikasi, Digital Signature, QR', 'done' => true],
        ['no' => 5, 'label' => 'Dashboard Analytics & GIS', 'done' => true],
        ['no' => 6, 'label' => 'Import, Export, Backup, Restore', 'done' => true],
        ['no' => 7, 'label' => 'Notifikasi, Email, WhatsApp', 'done' => true],
        ['no' => 8, 'label' => 'Audit Log, Monitoring, Laporan', 'done' => true],
        ['no' => 9, 'label' => 'Optimasi, Security Hardening, Deployment', 'done' => true],
    ];
@endphp

<div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
    <div class="flex flex-col gap-1 p-5 pb-3">
        <h3 class="font-display text-base font-semibold tracking-tight" style="font-family: var(--font-display);">Progres Pembangunan Sistem</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400">Dibangun bertahap sesuai roadmap Phase 1–9.</p>
    </div>
    <div class="space-y-2.5 p-5 pt-0">
        @foreach ($phases as $phase)
            <div class="flex items-center gap-3 text-sm">
                @if ($phase['done'])
                    <x-icon name="check-circle-2" class="size-4 shrink-0 text-primary-600" />
                @else
                    <x-icon name="circle" class="size-4 shrink-0 text-slate-300 dark:text-slate-600" />
                @endif
                <span class="{{ $phase['done'] ? 'font-medium' : 'text-slate-500 dark:text-slate-400' }}">
                    Phase {{ $phase['no'] }}: {{ $phase['label'] }}
                </span>
            </div>
        @endforeach
    </div>
</div>