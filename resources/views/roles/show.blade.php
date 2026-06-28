<x-layouts.app :title="$role->name . ' — Role'">
    <x-page-header :title="$role->name" description="Detail hak akses dan pengguna dengan role ini.">
        <x-slot:actions>
            <a href="{{ route('roles.index') }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                <x-icon name="arrow-left" class="size-4" /> Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- PERMISSION MATRIX --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h2 class="mb-4 font-semibold">Hak Akses Modul</h2>
            @if (empty($matrix))
                <p class="text-sm text-slate-400">Tidak ada hak akses yang didefinisikan.</p>
            @else
                <div class="space-y-2">
                    @foreach ($matrix as $module => $actions)
                        <div class="rounded-xl border border-[var(--border)] p-3">
                            <div class="mb-2 font-medium text-sm capitalize">{{ $module }}</div>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($actions as $action)
                                    <span class="rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">
                                        {{ $action }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- USERS WITH THIS ROLE --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
            <h2 class="mb-4 font-semibold">Pengguna ({{ $role->users->count() }})</h2>
            @if ($role->users->isEmpty())
                <p class="text-sm text-slate-400">Belum ada pengguna dengan role ini.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($role->users as $u)
                        <li class="flex items-center justify-between rounded-xl border border-[var(--border)] px-3 py-2.5 text-sm">
                            <div>
                                <div class="font-medium">{{ $u->fullname }}</div>
                                <div class="text-xs text-slate-400">{{ $u->username }} — {{ $u->village?->name ?? 'Tanpa Desa' }}</div>
                            </div>
                            @if ($u->is_active)
                                <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs text-green-700">Aktif</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-500">Nonaktif</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layouts.app>
