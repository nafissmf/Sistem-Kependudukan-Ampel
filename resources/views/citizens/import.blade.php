<x-layouts.app title="Import Penduduk">
    <x-page-header title="Import Data Penduduk" description="Upload file Excel (.xlsx/.xls/.csv) untuk import massal. Preview ditampilkan sebelum data disimpan." />

    <div class="max-w-xl rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
        <form method="POST" action="{{ route('citizens.import.preview') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <x-form-group label="File Excel" name="file" required>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="block w-full text-sm text-slate-500">
            </x-form-group>
            <p class="text-xs text-slate-400">
                Format kolom yang diharapkan (baris pertama = header): <code>nik, fullname, gender, birth_place, birth_date, phone, address</code>.
                Nilai <code>gender</code> harus <code>L</code> atau <code>P</code>.
            </p>
            <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                <x-icon name="file-text" class="size-4" /> Lihat Preview
            </button>
        </form>
    </div>
</x-layouts.app>
