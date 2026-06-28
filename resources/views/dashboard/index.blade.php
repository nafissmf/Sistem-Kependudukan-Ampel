<x-layouts.app title="Dashboard">
@php
    $laki      = $genderData->get('L', 0);
    $perempuan = $genderData->get('P', 0);
    $totalG    = $laki + $perempuan;
    $pctL      = $totalG ? round($laki / $totalG * 100) : 0;
    $pctP      = $totalG ? 100 - $pctL : 0;

    $verifTotal    = $verifBreakdown->sum();
    $verifVerified = $verifBreakdown->get('verified', 0);
    $verifPending  = $verifBreakdown->get('pending', 0);
    $verifRejected = $verifBreakdown->get('rejected', 0);
    $verifRevision = $verifBreakdown->get('revision', 0);

    $pctVerified = $verifTotal ? round($verifVerified / $verifTotal * 100) : 0;
    $pctPending  = $verifTotal ? round($verifPending  / $verifTotal * 100) : 0;
    $pctRejected = $verifTotal ? round($verifRejected / $verifTotal * 100) : 0;
    $pctRevision = $verifTotal ? 100 - $pctVerified - $pctPending - $pctRejected : 0;

    $role = auth()->user()->role->code;
@endphp

<div class="space-y-5">

    {{-- ══════════════════════════════════════════
         HERO BANNER
    ══════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-primary-800 via-primary-700 to-primary-600 shadow-lg">
        {{-- Decorative circles --}}
        <div class="pointer-events-none absolute -right-16 -top-16 size-64 rounded-full bg-white/5"></div>
        <div class="pointer-events-none absolute -bottom-12 right-40 size-48 rounded-full bg-white/5"></div>

        <div class="relative flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between">
            {{-- Kiri: identitas --}}
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-boyolali.png') }}"
                     alt="Logo Boyolali"
                     class="size-16 shrink-0 object-contain drop-shadow" />
                <div>
                    <p class="text-xs font-medium uppercase tracking-widest text-white/60">{{ $today }}</p>
                    <h1 class="mt-0.5 font-display text-xl font-bold text-white sm:text-2xl" style="font-family:var(--font-display)">
                        {{ $greeting }}, {{ auth()->user()->fullname }}
                    </h1>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-0.5 text-xs font-semibold text-white backdrop-blur-sm">
                            <x-icon name="shield-check" class="size-3" />
                            {{ auth()->user()->role->name }}
                        </span>
                        <span class="rounded-full bg-accent-400/25 px-3 py-0.5 text-xs font-semibold text-accent-300">
                            Sistem Aktif
                        </span>
                    </div>
                    <p class="mt-1.5 text-xs text-white/50">Kecamatan Ampel · Kabupaten Boyolali</p>
                </div>
            </div>

            {{-- Kanan: 4 angka kunci --}}
            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                @if ($totalCitizens !== null)
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)">{{ number_format($totalCitizens,0,',','.') }}</p>
                    <p class="mt-0.5 text-xs text-white/60">Penduduk</p>
                </div>
                @endif
                @if ($totalFamilyCards !== null)
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)">{{ number_format($totalFamilyCards,0,',','.') }}</p>
                    <p class="mt-0.5 text-xs text-white/60">Kartu Keluarga</p>
                </div>
                @endif
                @if ($totalHouses !== null)
                <div class="rounded-xl bg-white/10 px-4 py-3 text-center backdrop-blur-sm">
                    <p class="font-display text-2xl font-bold text-white tabular-nums" style="font-family:var(--font-display)">{{ number_format($totalHouses,0,',','.') }}</p>
                    <p class="mt-0.5 text-xs text-white/60">Rumah</p>
                </div>
                @endif
                @if ($pendingVerif !== null)
                <div class="rounded-xl px-4 py-3 text-center ring-1 ring-amber-300/30" style="background:rgba(251,140,0,.18)">
                    <p class="font-display text-2xl font-bold tabular-nums text-amber-200" style="font-family:var(--font-display)">{{ number_format($pendingVerif,0,',','.') }}</p>
                    <p class="mt-0.5 text-xs text-amber-200/70">Perlu Verifikasi</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         AKSI CEPAT
    ══════════════════════════════════════════ --}}
    <section>
        <p class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi Cepat</p>
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">

            @if (\App\Support\Rbac::has($role,'penduduk','create'))
            <a href="{{ route('citizens.create') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl bg-primary-600 text-white shadow-sm">
                    <x-icon name="user-plus" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>Penduduk</span>
            </a>
            @endif

            @if (\App\Support\Rbac::has($role,'kk','create'))
            <a href="{{ route('family-cards.create') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:border-secondary-300 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl bg-secondary-600 text-white shadow-sm">
                    <x-icon name="id-card" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>KK</span>
            </a>
            @endif

            @if (\App\Support\Rbac::has($role,'rumah','create'))
            <a href="{{ route('houses.create') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md" style="--tw-hover-border-color:#0d9488">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#0f766e">
                    <x-icon name="home" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Tambah<br>Rumah</span>
            </a>
            @endif

            @if (\App\Support\Rbac::has($role,'scan','read'))
            <a href="{{ route('scanner.index') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#7c3aed">
                    <x-icon name="scan-line" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Scan<br>QR</span>
            </a>
            @endif

            @if (\App\Support\Rbac::has($role,'gis','read'))
            <a href="{{ route('gis.index') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#0284c7">
                    <x-icon name="map" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Peta<br>GIS</span>
            </a>
            @endif

            @if (\App\Support\Rbac::has($role,'laporan','export'))
            <a href="{{ route('reports.index') }}"
               class="group flex flex-col items-center gap-2 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] py-4 text-center shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex size-10 items-center justify-center rounded-xl text-white shadow-sm" style="background:#ea580c">
                    <x-icon name="file-text" class="size-5" />
                </span>
                <span class="text-xs font-semibold leading-tight text-slate-600 dark:text-slate-300">Laporan<br>Export</span>
            </a>
            @endif

        </div>
    </section>

    {{-- ══════════════════════════════════════════
         STAT CARDS (4 kolom)
    ══════════════════════════════════════════ --}}
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        {{-- Penduduk --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-primary-50 dark:bg-primary-900/30">
                    <x-icon name="users" class="size-5 text-primary-600 dark:text-primary-400" />
                </div>
                <span class="text-xs font-medium text-primary-600 dark:text-primary-400">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                {{ $totalCitizens !== null ? number_format($totalCitizens,0,',','.') : '—' }}
            </p>
            <p class="mt-1 text-sm text-slate-500">Total Penduduk</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full bg-primary-500" style="width:{{ $totalCitizens ? min(100, $totalCitizens/100) : 0 }}%"></div>
            </div>
        </div>

        {{-- KK --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-secondary-50 dark:bg-secondary-900/20">
                    <x-icon name="id-card" class="size-5 text-secondary-600 dark:text-secondary-400" />
                </div>
                <span class="text-xs font-medium text-secondary-600 dark:text-secondary-400">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                {{ $totalFamilyCards !== null ? number_format($totalFamilyCards,0,',','.') : '—' }}
            </p>
            <p class="mt-1 text-sm text-slate-500">Kartu Keluarga</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full bg-secondary-500" style="width:{{ $totalFamilyCards ? min(100, $totalFamilyCards/10) : 0 }}%"></div>
            </div>
        </div>

        {{-- Rumah --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl" style="background:#f0fdf4">
                    <x-icon name="home" class="size-5" style="color:#0f766e" />
                </div>
                <span class="text-xs font-medium" style="color:#0f766e">↑ Data</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums" style="font-family:var(--font-display)">
                {{ $totalHouses !== null ? number_format($totalHouses,0,',','.') : '—' }}
            </p>
            <p class="mt-1 text-sm text-slate-500">Total Rumah</p>
            <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-white/10">
                <div class="h-full rounded-full" style="background:#0f766e; width:{{ $totalHouses ? min(100, $totalHouses/5) : 0 }}%"></div>
            </div>
        </div>

        {{-- Verifikasi --}}
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-900/30 dark:bg-amber-900/10">
            <div class="flex items-center justify-between">
                <div class="flex size-11 items-center justify-center rounded-xl bg-amber-100 dark:bg-amber-900/30">
                    <x-icon name="clock" class="size-5 text-amber-600 dark:text-amber-400" />
                </div>
                <span class="text-xs font-medium text-amber-600 dark:text-amber-400">Perlu Aksi</span>
            </div>
            <p class="mt-4 font-display text-3xl font-bold tabular-nums text-amber-700 dark:text-amber-300" style="font-family:var(--font-display)">
                {{ $pendingVerif !== null ? number_format($pendingVerif,0,',','.') : '—' }}
            </p>
            <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">Menunggu Verifikasi</p>
            <a href="{{ route('verification.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:underline dark:text-amber-400">
                Lihat semua <x-icon name="arrow-right" class="size-3" />
            </a>
        </div>

    </section>

    {{-- ══════════════════════════════════════════
         BARIS BAWAH: Verifikasi + Gender + Aktivitas
    ══════════════════════════════════════════ --}}
    <section class="grid gap-4 lg:grid-cols-3">

        {{-- Status Verifikasi --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h3 class="mb-4 font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                Status Verifikasi Penduduk
            </h3>
            @if ($verifTotal > 0)
                {{-- Stacked bar --}}
                <div class="mb-4 flex h-4 w-full overflow-hidden rounded-full">
                    @if ($pctVerified > 0)<div class="h-full" style="width:{{ $pctVerified }}%;background:#2e7d32" title="Terverifikasi"></div>@endif
                    @if ($pctPending  > 0)<div class="h-full" style="width:{{ $pctPending  }}%;background:#fb8c00" title="Menunggu"></div>@endif
                    @if ($pctRejected > 0)<div class="h-full" style="width:{{ $pctRejected }}%;background:#e53935" title="Ditolak"></div>@endif
                    @if ($pctRevision > 0)<div class="h-full" style="width:{{ $pctRevision }}%;background:#1565c0" title="Revisi"></div>@endif
                </div>

                <ul class="space-y-2.5">
                    @foreach ([
                        ['Terverifikasi', $verifVerified, $pctVerified, '#2e7d32'],
                        ['Menunggu',      $verifPending,  $pctPending,  '#fb8c00'],
                        ['Ditolak',       $verifRejected, $pctRejected, '#e53935'],
                        ['Revisi',        $verifRevision, $pctRevision, '#1565c0'],
                    ] as [$lbl, $val, $pct, $clr])
                        @if ($val > 0)
                        <li class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2.5">
                                <span class="size-2.5 shrink-0 rounded-full" style="background:{{ $clr }}"></span>
                                <span class="text-slate-600 dark:text-slate-300">{{ $lbl }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-semibold tabular-nums">{{ number_format($val,0,',','.') }}</span>
                                <span class="w-8 text-right text-xs text-slate-400">{{ $pct }}%</span>
                            </div>
                        </li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p class="py-6 text-center text-sm text-slate-400">Belum ada data verifikasi.</p>
            @endif
        </div>

        {{-- Distribusi Gender --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h3 class="mb-4 font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                Distribusi Gender
            </h3>
            @if ($totalG > 0)
                {{-- Bar stacked gender --}}
                <div class="mb-4 flex h-4 overflow-hidden rounded-full">
                    <div class="h-full bg-primary-500 transition-all" style="width:{{ $pctL }}%"></div>
                    <div class="h-full" style="width:{{ $pctP }}%; background:#ec4899"></div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-primary-50 p-4 text-center dark:bg-primary-900/20">
                        <p class="font-display text-2xl font-bold text-primary-700 tabular-nums dark:text-primary-300" style="font-family:var(--font-display)">
                            {{ number_format($laki,0,',','.') }}
                        </p>
                        <p class="mt-1 text-xs font-medium text-primary-600 dark:text-primary-400">Laki-laki</p>
                        <p class="text-xs text-primary-400">{{ $pctL }}%</p>
                    </div>
                    <div class="rounded-xl p-4 text-center" style="background:#fdf2f8">
                        <p class="font-display text-2xl font-bold tabular-nums" style="font-family:var(--font-display);color:#be185d">
                            {{ number_format($perempuan,0,',','.') }}
                        </p>
                        <p class="mt-1 text-xs font-medium" style="color:#db2777">Perempuan</p>
                        <p class="text-xs" style="color:#f9a8d4">{{ $pctP }}%</p>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 dark:bg-white/5">
                    <span class="text-xs text-slate-500">Total Penduduk</span>
                    <span class="font-display text-sm font-bold tabular-nums" style="font-family:var(--font-display)">{{ number_format($totalG,0,',','.') }}</span>
                </div>
            @else
                <p class="py-6 text-center text-sm text-slate-400">Belum ada data gender.</p>
            @endif
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="rounded-xl border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-display text-sm font-semibold text-slate-700 dark:text-slate-200" style="font-family:var(--font-display)">
                    Aktivitas Terbaru
                </h3>
                @can('audit.read')
                    <a href="{{ route('audit.index') }}" class="text-xs font-medium text-primary-600 hover:underline dark:text-primary-400">
                        Semua log
                    </a>
                @endcan
            </div>

            @if ($recentActivity->isEmpty())
                <p class="py-6 text-center text-sm text-slate-400">Belum ada aktivitas.</p>
            @else
                <ul class="space-y-3">
                    @php
                        $dotColor = [
                            'create'  => '#2e7d32',
                            'update'  => '#1565c0',
                            'delete'  => '#e53935',
                            'approve' => '#0f766e',
                            'reject'  => '#fb8c00',
                            'backup'  => '#7c3aed',
                            'restore' => '#ea580c',
                        ];
                    @endphp
                    @foreach ($recentActivity as $log)
                    <li class="flex items-start gap-3">
                        <span class="mt-1.5 size-2 shrink-0 rounded-full"
                              style="background:{{ $dotColor[$log->action->value] ?? '#94a3b8' }}"></span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-700 dark:text-slate-200">
                                {{ $log->user?->fullname ?? 'Sistem' }}
                                <span class="font-normal text-slate-400">·</span>
                                <span class="capitalize text-slate-500">{{ $log->module }}</span>
                            </p>
                            <p class="text-xs text-slate-400">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </section>

</div>
</x-layouts.app>
