@props(['role'])

@php
    $menu = collect(\App\Support\Rbac::sidebarMenu())
        ->filter(fn ($item) => \App\Support\Rbac::canAccessModule($role, $item['module']))
        ->values();
@endphp

<div x-show="$store.ui.mobileOpen" x-cloak @click="$store.ui.closeMobile()" class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col border-r border-[var(--border)] bg-[var(--card-bg)] transition-all duration-200"
    :class="$store.ui.collapsed ? 'w-20' : 'w-64'"
    x-bind:class="($store.ui.mobileOpen ? 'translate-x-0' : '-translate-x-full') + ' lg:translate-x-0'"
>
    <div class="flex h-16 items-center justify-between gap-2 border-b border-[var(--border)] px-4">
        <div class="flex items-center gap-2 overflow-hidden">
            <img src="{{ asset('images/logo-boyolali.png') }}"
                 alt="Logo Kabupaten Boyolali"
                 class="size-9 shrink-0 object-contain" />
            <span x-show="!$store.ui.collapsed" class="truncate font-display text-sm font-bold leading-tight" style="font-family: var(--font-display);">SIK Ampel</span>
        </div>
        <button class="text-slate-400 hover:text-slate-600 lg:hidden" @click="$store.ui.closeMobile()" aria-label="Tutup menu">
            <x-icon name="x" class="size-5" />
        </button>
    </div>

    <nav class="thin-scrollbar flex-1 space-y-1 overflow-y-auto p-3">
        @foreach ($menu as $item)
            @php $active = request()->is(trim($item['href'], '/').'*'); @endphp
            <a
                href="{{ $item['href'] }}"
                @click="$store.ui.closeMobile()"
                title="{{ $item['label'] }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-primary-50 text-primary-700 dark:bg-primary-600/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/5' }}"
                :class="$store.ui.collapsed && 'justify-center'"
            >
                <x-icon :name="$item['icon']" class="size-[1.15rem] shrink-0" />
                <span x-show="!$store.ui.collapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</aside>
