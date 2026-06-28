<x-layouts.guest title="403 - Akses Ditolak">
    <div class="flex min-h-screen flex-col items-center justify-center bg-[var(--bg)] px-6 text-center">
        <div class="flex size-16 items-center justify-center rounded-full bg-danger-500/10 text-danger-500">
            <x-icon name="shield-alert" class="size-8" />
        </div>
        <h1 class="mt-4 font-display text-2xl font-bold" style="font-family: var(--font-display);">Akses Ditolak</h1>
        <p class="mt-2 max-w-sm text-sm text-slate-500 dark:text-slate-400">
            {{ $exception->getMessage() ?: 'Role Anda tidak memiliki izin untuk membuka halaman ini.' }}
            Jika menurut Anda ini keliru, hubungi Super Admin atau Operator Kecamatan.
        </p>
        <a href="{{ route('dashboard') }}" class="mt-6 flex h-10 items-center justify-center rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
            Kembali ke Dashboard
        </a>
    </div>
</x-layouts.guest>
