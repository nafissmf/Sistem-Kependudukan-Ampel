<x-layouts.app title="Data Penduduk">
    <x-page-header title="Data Penduduk" description="Kelola data penduduk Kecamatan Ampel.">
        <x-slot:actions>
            @can('import.create')
                <a href="{{ route('citizens.import') }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <x-icon name="file-text" class="size-4" /> Import
                </a>
            @endcan
            @can('export.create')
                <a href="{{ route('citizens.export', ['format' => 'xlsx', ...$filters]) }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <x-icon name="file-text" class="size-4" /> Excel
                </a>
                <a href="{{ route('citizens.export', ['format' => 'pdf', ...$filters]) }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <x-icon name="file-text" class="size-4" /> PDF
                </a>
            @endcan
            @can('penduduk.create')
                <a href="{{ route('citizens.create') }}" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="users" class="size-4" /> Tambah Penduduk
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
    <form method="GET" class="mb-4 grid grid-cols-1 gap-3 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-4 sm:grid-cols-2 lg:grid-cols-5">
        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari nama atau NIK…"
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

        <select name="gender" class="h-10 rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Semua Gender</option>
            <option value="L" @selected(($filters['gender'] ?? null) === 'L')>Laki-laki</option>
            <option value="P" @selected(($filters['gender'] ?? null) === 'P')>Perempuan</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="flex h-10 flex-1 items-center justify-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white hover:bg-primary-700">
                <x-icon name="search" class="size-4" /> Cari
            </button>
            <a href="{{ route('citizens.index') }}" class="flex h-10 items-center justify-center rounded-xl border border-[var(--border)] px-3 text-sm text-slate-500 hover:bg-slate-50 dark:hover:bg-white/5">Reset</a>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($citizens->isEmpty())
            <x-empty-state icon="users" title="Belum ada data penduduk"
                description="Data akan muncul di sini setelah Operator Desa menambahkan penduduk." />
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                        <tr>
                            <th class="px-4 py-3 font-medium">NIK</th>
                            <th class="px-4 py-3 font-medium">Nama</th>
                            <th class="px-4 py-3 font-medium">Gender</th>
                            <th class="px-4 py-3 font-medium">Umur</th>
                            <th class="px-4 py-3 font-medium">Desa</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @foreach ($citizens as $citizen)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5">
                                <td class="px-4 py-3 font-mono text-xs" style="font-family: var(--font-mono);">{{ $citizen->nik }}</td>
                                <td class="px-4 py-3 font-medium">{{ $citizen->fullname }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $citizen->gender->label() }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $citizen->age ?? '—' }} th</td>
                                <td class="px-4 py-3 text-slate-500">{{ $citizen->village?->name ?? '—' }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$citizen->verification_status" /></td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('citizens.show', $citizen) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5" aria-label="Lihat">
                                            <x-icon name="eye" class="size-4" />
                                        </a>
                                        @can('penduduk.update')
                                            <a href="{{ route('citizens.edit', $citizen) }}" class="flex size-8 items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/5" aria-label="Edit">
                                                <x-icon name="settings" class="size-4" />
                                            </a>
                                        @endcan
                                        @can('penduduk.delete')
                                            <form method="POST" action="{{ route('citizens.destroy', $citizen) }}" onsubmit="return confirm('Hapus data penduduk ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex size-8 items-center justify-center rounded-lg text-danger-400 hover:bg-danger-500/10" aria-label="Hapus">
                                                    <x-icon name="x" class="size-4" />
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-[var(--border)] p-4">
                {{ $citizens->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
