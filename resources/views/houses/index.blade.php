<x-layouts.app title="Data Rumah">
    <x-page-header title="Data Rumah" description="Kelola data rumah dan koordinat GPS-nya.">
        <x-slot:actions>
            @can('rumah.create')
                <a href="{{ route('houses.create') }}" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="home" class="size-4" /> Tambah Rumah
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 sm:grid-cols-2 lg:grid-cols-4">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nomor rumah/alamat…"
               class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <select name="village_id" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Desa</option>
            @foreach ($villages as $village)
                <option value="{{ $village->id }}" @selected(($filters['village_id'] ?? null) === $village->id)>{{ $village->name }}</option>
            @endforeach
        </select>
        <select name="verification_status" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(($filters['verification_status'] ?? null) === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <div class="flex gap-2">
            <button type="submit" class="flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white hover:bg-primary-700"><x-icon name="search" class="size-4" /> Cari</button>
            <a href="{{ route('houses.index') }}" class="flex h-10 items-center justify-center rounded-xl border border-[var(--border)] px-3 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($houses->isEmpty())
            <x-empty-state icon="home" title="Belum ada data rumah" description="Data akan muncul di sini setelah Operator Desa menambahkan rumah." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium">Nomor Rumah</th>
                            <th class="px-4 py-3 font-medium">Alamat</th>
                            <th class="px-4 py-3 font-medium">Desa</th>
                            <th class="px-4 py-3 font-medium">Koordinat</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($houses as $house)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3 font-medium">{{ $house->house_number ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $house->address ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $house->village?->name ?? '—' }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-slate-500" style="font-family: var(--font-mono);">
                                    @if ($house->latitude && $house->longitude)
                                        {{ $house->latitude }}, {{ $house->longitude }}
                                    @else
                                        — belum ada GPS —
                                    @endif
                                </td>
                                <td class="px-4 py-3"><x-status-badge :status="$house->verification_status" /></td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('houses.show', $house) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5"><x-icon name="eye" class="size-4" /></a>
                                        @can('rumah.update')
                                            <a href="{{ route('houses.edit', $house) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5"><x-icon name="settings" class="size-4" /></a>
                                        @endcan
                                        @can('rumah.delete')
                                            <form method="POST" action="{{ route('houses.destroy', $house) }}" onsubmit="return confirm('Hapus data rumah ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex size-8 items-center justify-center rounded-lg text-danger-400 hover:bg-danger-500/10"><x-icon name="x" class="size-4" /></button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--border)] p-4">{{ $houses->links() }}</div>
        @endif
    </div>
</x-layouts.app>
