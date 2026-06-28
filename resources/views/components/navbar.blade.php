@props(['user'])

@php
    $initials = collect(explode(' ', $user->fullname))->take(2)->map(fn ($s) => mb_strtoupper(mb_substr($s, 0, 1)))->implode('');
@endphp

<header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-[var(--border)] bg-[var(--card-bg)]/90 px-4 backdrop-blur-md sm:px-6">
    <button class="text-slate-500 hover:text-slate-700 lg:hidden" @click="$store.ui.openMobile()" aria-label="Buka menu">
        <x-icon name="menu" class="size-5" />
    </button>

    <button class="hidden text-slate-500 hover:text-slate-700 lg:block" @click="$store.ui.toggleCollapsed()" aria-label="Lipat/buka sidebar">
        <x-icon name="panel-left-close" class="size-5" x-show="!$store.ui.collapsed" />
        <x-icon name="panel-left-open" class="size-5" x-show="$store.ui.collapsed" x-cloak />
    </button>

    {{-- GLOBAL SEARCH — UI siap, pencarian realtime menyusul di fase modul
         Penduduk/KK/Rumah (butuh endpoint /api/v1/search). --}}
    <div class="relative w-full max-w-md">
        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
            <x-icon name="search" class="size-4" />
        </span>
        <input
            type="search" placeholder="Cari NIK, nama, nomor KK, alamat…"
            class="h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--bg)] pl-9 pr-3 text-sm outline-none placeholder:text-slate-400 focus-visible:ring-2 focus-visible:ring-primary-500"
        >
    </div>

    <div class="ml-auto flex items-center gap-1.5">
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="relative flex size-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5" aria-label="Notifikasi">
                <x-icon name="bell" class="size-5" />
                @php $unreadCount = $user->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <span class="absolute right-1.5 top-1.5 flex size-4 items-center justify-center rounded-full bg-danger-500 text-[0.6rem] font-bold text-white">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </button>

            <div x-show="open" x-cloak x-transition class="glass-panel absolute right-0 z-50 mt-2 w-80 rounded-xl p-2 text-sm">
                <div class="flex items-center justify-between px-2 py-1">
                    <p class="font-medium">Notifikasi</p>
                    @if ($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.read-all') }}">
                            @csrf
                            <button type="submit" class="text-xs text-primary-600 hover:underline">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>
                <div class="thin-scrollbar max-h-80 overflow-y-auto">
                    @forelse ($user->notifications()->latest()->take(8)->get() as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit" class="flex w-full flex-col gap-0.5 rounded-lg px-3 py-2 text-left hover:bg-primary-50 dark:hover:bg-white/5 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <span class="font-medium">{{ $notification->data['module_label'] ?? 'Notifikasi' }} — {{ $notification->data['decision_label'] ?? '' }}</span>
                                <span class="truncate text-xs text-slate-500">{{ $notification->data['title'] ?? '' }}</span>
                                <span class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </button>
                        </form>
                    @empty
                        <p class="px-3 py-4 text-center text-xs text-slate-400">Belum ada notifikasi.</p>
                    @endforelse
                </div>
                <a href="{{ route('notifications.index') }}" class="mt-1 block rounded-lg px-3 py-2 text-center text-xs font-medium text-primary-600 hover:bg-primary-50 dark:hover:bg-white/5">Lihat Semua</a>
            </div>
        </div>

        <button type="button" x-data @click="$store.theme.toggle()" class="flex size-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5" aria-label="Ganti tema">
            <x-icon name="moon" class="size-5" x-show="!$store.theme.dark" x-cloak />
            <x-icon name="sun" class="size-5" x-show="$store.theme.dark" x-cloak />
        </button>

        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="ml-1 flex items-center gap-2 rounded-xl p-1.5 pr-3 hover:bg-slate-100 dark:hover:bg-white/5">
                <span class="flex size-8 items-center justify-center rounded-full bg-primary-600 text-xs font-semibold text-white">{{ $initials ?: 'U' }}</span>
                <span class="hidden text-left sm:block">
                    <p class="text-sm font-medium leading-tight">{{ $user->fullname }}</p>
                    <p class="text-xs leading-tight text-slate-500">{{ $user->role->name }}</p>
                </span>
            </button>

            <div x-show="open" x-cloak x-transition class="glass-panel absolute right-0 z-50 mt-2 min-w-[12rem] rounded-xl p-1.5 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 hover:bg-primary-50 dark:hover:bg-white/5">
                    <x-icon name="user" class="size-4" /> Profil Saya
                </a>
                <div class="my-1 h-px bg-[var(--border)]"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-danger-500 hover:bg-danger-500/10">
                        <x-icon name="log-out" class="size-4" /> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
