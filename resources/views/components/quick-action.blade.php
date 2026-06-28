@props(['label', 'icon', 'available' => false, 'href' => '#'])

@if ($available)
    <a href="{{ $href }}">
        <div class="flex flex-col items-start gap-2.5 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 shadow-sm transition-shadow hover:shadow-md">
            <span class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15 dark:text-primary-300">
                <x-icon :name="$icon" class="size-5" />
            </span>
            <span class="text-sm font-medium">{{ $label }}</span>
        </div>
    </a>
@else
    <button
        type="button"
        x-data
        @click="$store.toast.show('{{ $label }} belum tersedia', 'Modul ini akan dibangun pada fase pengembangan berikutnya.')"
        class="text-left"
    >
        <div class="flex flex-col items-start gap-2.5 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 opacity-60 shadow-sm transition-shadow hover:shadow-md">
            <span class="flex size-10 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-white/5">
                <x-icon :name="$icon" class="size-5" />
            </span>
            <span class="text-sm font-medium">{{ $label }}</span>
            <span class="text-xs text-slate-400">Segera hadir</span>
        </div>
    </button>
@endif
