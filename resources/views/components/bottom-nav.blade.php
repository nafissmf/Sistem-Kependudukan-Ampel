@props(['role'])

@php
    $items = [
        ['href' => '/dashboard', 'label' => 'Beranda', 'icon' => 'layout-dashboard', 'module' => 'dashboard'],
        ['href' => '/citizens', 'label' => 'Penduduk', 'icon' => 'users', 'module' => 'penduduk'],
        ['href' => '/gis', 'label' => 'GIS', 'icon' => 'map', 'module' => 'gis'],
        ['href' => '/notifications', 'label' => 'Notifikasi', 'icon' => 'bell', 'module' => 'notifikasi'],
    ];
    $visible = collect($items)->filter(fn ($i) => \App\Support\Rbac::canAccessModule($role, $i['module']))->values();
    $canScan = \App\Support\Rbac::canAccessModule($role, 'scan');
@endphp

<nav class="fixed inset-x-0 bottom-0 z-40 flex h-16 items-center justify-around border-t border-[var(--border)] bg-[var(--card-bg)] px-2 lg:hidden">
    @foreach ($visible as $index => $item)
        @php $active = request()->is(trim($item['href'], '/')); @endphp
        <a href="{{ $item['href'] }}" class="flex flex-1 flex-col items-center gap-0.5 py-1.5 text-[0.65rem] font-medium {{ $active ? 'text-primary-600' : 'text-slate-400' }}">
            <x-icon :name="$item['icon']" class="size-5" />
            {{ $item['label'] }}
        </a>

        @if ($index === 1 && $canScan)
            <a href="/scanner" class="relative -mt-8 flex size-14 items-center justify-center rounded-full bg-primary-600 text-white shadow-lg shadow-primary-600/40 ring-4 ring-[var(--bg)]" aria-label="Scan QR">
                <x-icon name="scan-line" class="size-6" />
            </a>
        @endif
    @endforeach
</nav>
