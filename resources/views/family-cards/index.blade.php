<x-layouts.app title="Kartu Keluarga">
    <x-page-header title="Kartu Keluarga" description="Kelola data Kartu Keluarga (KK) Kecamatan Ampel.">
        <x-slot:actions>
            @can('kk.create')
                <a href="{{ route('family-cards.create') }}" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="id-card" class="size-4" /> Tambah KK
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 sm:grid-cols-2 lg:grid-cols-4">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nomor KK…"
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
            <a href="{{ route('family-cards.index') }}" class="flex h-10 items-center justify-center rounded-xl border border-[var(--border)] px-3 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($familyCards->isEmpty())
            <x-empty-state icon="id-card" title="Belum ada Kartu Keluarga" description="Data akan muncul di sini setelah Operator Desa menambahkan KK." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium">Nomor KK</th>
                            <th class="px-4 py-3 font-medium">Kepala Keluarga</th>
                            <th class="px-4 py-3 font-medium">Desa</th>
                            <th class="px-4 py-3 font-medium">Anggota</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($familyCards as $familyCard)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3 font-mono text-xs" style="font-family: var(--font-mono);">{{ $familyCard->number }}</td>
                                <td class="px-4 py-3 font-medium">{{ $familyCard->headCitizen?->fullname ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $familyCard->village?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $familyCard->members_count }} orang</td>
                                <td class="px-4 py-3"><x-status-badge :status="$familyCard->verification_status" /></td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('family-cards.show', $familyCard) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5"><x-icon name="eye" class="size-4" /></a>
                                        @can('kk.update')
                                            <a href="{{ route('family-cards.edit', $familyCard) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5"><x-icon name="settings" class="size-4" /></a>
                                        @endcan
                                        @can('kk.delete')
                                            <form method="POST" action="{{ route('family-cards.destroy', $familyCard) }}" onsubmit="return confirm('Hapus Kartu Keluarga ini?')">
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
            <div class="border-t border-[var(--border)] p-4">{{ $familyCards->links() }}</div>
        @endif
    </div>
</x-layouts.app>
