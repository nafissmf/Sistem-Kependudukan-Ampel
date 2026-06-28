<x-layouts.app title="Laporan">
    <x-page-header title="Laporan" description="Cetak laporan data dalam format Excel atau PDF." />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15"><x-icon name="users" class="size-5" /></div>
            <h2 class="mt-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Laporan Penduduk</h2>
            <p class="mt-1 text-xs text-slate-400">Daftar seluruh data Penduduk terdaftar.</p>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('citizens.export', ['format' => 'xlsx']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">Excel</a>
                <a href="{{ route('citizens.export', ['format' => 'pdf']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">PDF</a>
            </div>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex size-10 items-center justify-center rounded-xl bg-secondary-50 text-secondary-600 dark:bg-secondary-600/15"><x-icon name="id-card" class="size-5" /></div>
            <h2 class="mt-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Laporan Kartu Keluarga</h2>
            <p class="mt-1 text-xs text-slate-400">Daftar seluruh Kartu Keluarga terdaftar.</p>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('reports.family-cards', ['format' => 'xlsx']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">Excel</a>
                <a href="{{ route('reports.family-cards', ['format' => 'pdf']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">PDF</a>
            </div>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex size-10 items-center justify-center rounded-xl bg-amber-50 text-warning-600"><x-icon name="home" class="size-5" /></div>
            <h2 class="mt-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Laporan Rumah</h2>
            <p class="mt-1 text-xs text-slate-400">Daftar seluruh data Rumah terdaftar.</p>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('reports.houses', ['format' => 'xlsx']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">Excel</a>
                <a href="{{ route('reports.houses', ['format' => 'pdf']) }}" class="flex h-9 flex-1 items-center justify-center rounded-xl border border-[var(--border)] text-xs font-medium hover:bg-slate-50 dark:hover:bg-white/5">PDF</a>
            </div>
        </div>
    </div>
</x-layouts.app>
