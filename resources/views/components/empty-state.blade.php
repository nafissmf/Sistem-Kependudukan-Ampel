@props(['icon' => 'circle', 'title', 'description' => null])

<div class="flex flex-col items-center justify-center gap-2 py-16 text-center">
    <div class="flex size-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-white/5">
        <x-icon :name="$icon" class="size-6" />
    </div>
    <p class="font-medium text-slate-600 dark:text-slate-300">{{ $title }}</p>
    @if ($description)
        <p class="max-w-sm text-sm text-slate-400">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-2">{{ $action }}</div>
    @endisset
</div>
