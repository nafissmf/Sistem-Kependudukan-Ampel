<x-layouts.guest title="500 - Terjadi Kesalahan">
    <div class="flex min-h-screen flex-col items-center justify-center bg-[var(--bg)] px-6 text-center">
        <div class="flex size-16 items-center justify-center rounded-full bg-danger-500/10 text-danger-500">
            <x-icon name="alert-triangle" class="size-8" />
        </div>
        <h1 class="mt-4 font-display text-2xl font-bold" style="font-family: var(--font-display);">Terjadi Kesalahan</h1>
        <p class="mt-2 max-w-sm text-sm text-slate-500 dark:text-slate-400">
            Halaman ini gagal dimuat. Tim teknis sudah otomatis menerima catatan error ini.
        </p>
        <a href="{{ route('dashboard') }}" class="mt-6 flex h-10 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
            Coba Lagi
        </a>
    </div>
</x-layouts.guest>
