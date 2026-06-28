<x-layouts.guest title="Verifikasi Kartu Keluarga">
    <div class="flex min-h-screen items-center justify-center bg-[var(--bg)] px-4 py-10">
        <div class="w-full max-w-md">
            <div class="glass-panel rounded-card p-6 text-center">
                <div class="mx-auto flex size-14 items-center justify-center rounded-full bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="users" class="size-7" />
                </div>
                <h1 class="mt-3 font-display text-lg font-bold" style="font-family: var(--font-display);">Verifikasi Kartu Keluarga</h1>
                <p class="mt-1 text-xs text-slate-400">Sistem Informasi Kependudukan Kecamatan Ampel</p>

                <div class="mt-5">
                    <x-status-badge :status="$familyCard->verification_status" />
                </div>

                <dl class="mt-5 space-y-3 text-left text-sm">
                    <div class="flex justify-between border-b border-[var(--border)] pb-2">
                        <dt class="text-slate-400">No. KK</dt>
                        <dd class="font-medium">{{ $familyCard->number ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-[var(--border)] pb-2">
                        <dt class="text-slate-400">Kepala Keluarga</dt>
                        <dd class="font-medium">{{ $familyCard->headCitizen?->fullname ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between border-b border-[var(--border)] pb-2">
                        <dt class="text-slate-400">Desa</dt>
                        <dd class="font-medium">{{ $familyCard->village?->name ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-400">Terdaftar Sejak</dt>
                        <dd class="font-medium">{{ $familyCard->created_at->translatedFormat('d F Y') }}</dd>
                    </div>
                </dl>

                <p class="mt-6 text-xs text-slate-400">
                    © {{ now()->year }} Pemerintah Kabupaten Boyolali — Kecamatan Ampel.
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest>
