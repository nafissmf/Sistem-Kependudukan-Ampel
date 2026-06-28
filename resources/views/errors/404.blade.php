<x-layouts.guest title="404 - Halaman Tidak Ditemukan">
    <div class="flex min-h-screen flex-col items-center justify-center bg-[var(--bg)] px-6 text-center">
        <div class="flex size-16 items-center justify-center rounded-full bg-secondary-50 text-secondary-600 dark:bg-secondary-600/15">
            <x-icon name="compass" class="size-8" />
        </div>
        <h1 class="mt-4 font-display text-2xl font-bold" style="font-family: var(--font-display);">404 — Halaman Tidak Ditemukan</h1>
        <p class="mt-2 max-w-sm text-sm text-slate-500 dark:text-slate-400">
            Halaman yang Anda cari mungkin belum dibangun (lihat roadmap pengembangan) atau alamatnya sudah berubah.
        </p>
        <a href="{{ route('dashboard') }}" class="mt-6 flex h-10 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
            Kembali ke Dashboard
        </a>
    </div>
</x-layouts.guest>
