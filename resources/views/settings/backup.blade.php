<x-layouts.app title="Backup & Restore">
    <x-page-header title="Backup &amp; Restore Database" description="Hanya Super Admin. Restore akan MENGGANTI seluruh data saat ini — gunakan dengan sangat hati-hati.">
        <x-slot:actions>
            <form method="POST" action="{{ route('backup.store') }}" onsubmit="return confirm('Buat backup database sekarang?')">
                @csrf
                <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="check-circle-2" class="size-4" /> Backup Sekarang
                </button>
            </form>
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-danger-500/10 px-4 py-3 text-sm text-danger-600 dark:text-danger-400">{{ $errors->first() }}</div>
    @endif

    <div class="mb-4 rounded-xl bg-danger-500/10 px-4 py-3 text-xs text-danger-600 dark:text-danger-400">
        ⚠️ Fitur ini menjalankan <code>mysqldump</code>/<code>mysql</code> lewat shell server. Pastikan kedua binary
        tersedia di PATH server produksi. Banyak shared hosting membatasi shell exec — kalau gagal terus,
        gunakan tool backup bawaan hosting/cPanel sebagai gantinya.
    </div>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($backups->isEmpty())
            <x-empty-state icon="file-text" title="Belum ada riwayat backup" />
        @else
            <table class="w-full text-left text-sm">
                <thead class="border-b border-[var(--border)] bg-slate-50 text-xs uppercase text-slate-500 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nama File</th>
                        <th class="px-4 py-3 font-medium">Ukuran</th>
                        <th class="px-4 py-3 font-medium">Dibuat Oleh</th>
                        <th class="px-4 py-3 font-medium">Tanggal</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @foreach ($backups as $backup)
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs" style="font-family: var(--font-mono);">{{ $backup->filename }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $backup->humanSize() }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $backup->creator?->fullname ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $backup->backup_date->translatedFormat('d M Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('backup.download', $backup) }}" class="flex h-8 items-center rounded-lg px-2 text-xs font-medium text-secondary-600 hover:bg-secondary-50 dark:hover:bg-white/5">Download SQL</a>
                                    <form method="POST" action="{{ route('backup.restore', $backup) }}" onsubmit="return confirm('PERINGATAN: Restore akan MENGGANTI seluruh data saat ini dengan isi backup ini. Lanjutkan?')">
                                        @csrf
                                        <button type="submit" class="flex h-8 items-center rounded-lg px-2 text-xs font-medium text-warning-500 hover:bg-amber-50">Restore</button>
                                    </form>
                                    <form method="POST" action="{{ route('backup.destroy', $backup) }}" onsubmit="return confirm('Hapus file backup ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="flex h-8 items-center rounded-lg px-2 text-xs font-medium text-danger-500 hover:bg-danger-500/10">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t border-[var(--border)] p-4">{{ $backups->links() }}</div>
        @endif
    </div>
</x-layouts.app>
