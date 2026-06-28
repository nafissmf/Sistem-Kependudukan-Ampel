<x-layouts.app title="Manajemen Pengguna">
    <x-page-header title="Manajemen Pengguna" description="Kelola akun pengguna sistem.">
        <x-slot:actions>
            @can('user.create')
                <a href="{{ route('users.create') }}" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="user-plus" class="size-4" /> Tambah Pengguna
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 sm:grid-cols-3">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama, username, atau email…"
               class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500">

        <select name="role_id" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(($filters['role_id'] ?? null) === $role->id)>{{ $role->name }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white hover:bg-primary-700">
                <x-icon name="search" class="size-4" /> Cari
            </button>
            <a href="{{ route('users.index') }}" class="flex h-10 items-center justify-center rounded-xl border border-[var(--border)] px-3 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5">Reset</a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($users->isEmpty())
            <x-empty-state icon="users" title="Belum ada pengguna" description="Tambahkan pengguna baru untuk memulai." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium">Nama / Username</th>
                            <th class="px-4 py-3 font-medium">Email</th>
                            <th class="px-4 py-3 font-medium">Role</th>
                            <th class="px-4 py-3 font-medium">Desa</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Login Terakhir</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($users as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $user->fullname }}</div>
                                    <div class="text-xs text-slate-400 font-mono" style="font-family: var(--font-mono);">{{ $user->username }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">
                                        {{ $user->role?->name ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-500">{{ $user->village?->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($user->is_active)
                                        <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700 dark:bg-green-600/15 dark:text-green-300">Aktif</span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500 dark:bg-white/10">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500 text-xs">{{ $user->last_login?->diffForHumans() ?? 'Belum pernah' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        @can('user.update')
                                            <a href="{{ route('users.edit', $user) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5" aria-label="Edit">
                                                <x-icon name="settings" class="size-4" />
                                            </a>
                                        @endcan
                                        @can('user.delete')
                                            @if ($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna {{ $user->username }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-600/15" aria-label="Hapus">
                                                        <x-icon name="trash" class="size-4" />
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--border)] p-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
