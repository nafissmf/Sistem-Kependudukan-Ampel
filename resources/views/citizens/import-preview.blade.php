<x-layouts.app title="Preview Import">
    <x-page-header title="Preview Import" :description="'File: ' . $originalName . ' — ' . $totalRows . ' baris data ditemukan.'" />

    <div class="mb-4 rounded-xl bg-secondary-50 px-4 py-3 text-sm text-secondary-700 dark:bg-secondary-600/15 dark:text-secondary-400">
        Ini PREVIEW saja — belum ada data yang disimpan. Periksa dulu, lalu klik "Konfirmasi Import" di bawah.
        Maksimal 50 baris pertama ditampilkan di preview ini; semua baris akan diproses saat konfirmasi.
    </div>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-[var(--border)] bg-slate-50 uppercase text-slate-500 dark:bg-white/5">
                    <tr>
                        @foreach ($headings as $heading)
                            <th class="px-3 py-2 font-medium">{{ $heading }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @foreach ($previewRows as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td class="px-3 py-2">{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form method="POST" action="{{ route('citizens.import.store') }}" class="mt-4 flex justify-end gap-2">
        @csrf
        <input type="hidden" name="temp_path" value="{{ $tempPath }}">
        <input type="hidden" name="original_name" value="{{ $originalName }}">
        <a href="{{ route('citizens.import') }}" class="flex h-10 items-center rounded-xl border border-[var(--border)] px-4 text-sm hover:bg-slate-50 dark:hover:bg-white/5">Batal</a>
        <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
            <x-icon name="check-circle-2" class="size-4" /> Konfirmasi Import
        </button>
    </form>
</x-layouts.app>
