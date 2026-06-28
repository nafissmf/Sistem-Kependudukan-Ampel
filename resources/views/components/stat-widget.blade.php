@props(['label', 'icon', 'value' => null, 'accent' => 'primary', 'hint' => null])

@php
    $accentClass = match ($accent) {
        'secondary' => 'bg-secondary-50 text-secondary-600 dark:bg-secondary-600/15 dark:text-secondary-400',
        'warning' => 'bg-amber-50 text-warning-500 dark:bg-warning-500/15',
        'danger' => 'bg-red-50 text-danger-500 dark:bg-danger-500/15',
        default => 'bg-primary-50 text-primary-600 dark:bg-primary-600/15 dark:text-primary-300',
    };
@endphp

<div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
    <div class="flex items-start justify-between gap-4 p-5">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $label }}</p>
            @if ($value === null)
                <p class="mt-1 font-display text-2xl font-bold text-slate-300 dark:text-slate-600" style="font-family: var(--font-display);">—</p>
            @else
                <p class="mt-1 font-display text-2xl font-bold tabular-nums" style="font-family: var(--font-display);">{{ number_format($value, 0, ',', '.') }}</p>
            @endif
            @if ($hint)
                <p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>
            @endif
        </div>
        <div class="flex size-11 shrink-0 items-center justify-center rounded-xl {{ $accentClass }}">
            <x-icon :name="$icon" class="size-5" />
        </div>
    </div>
</div>
