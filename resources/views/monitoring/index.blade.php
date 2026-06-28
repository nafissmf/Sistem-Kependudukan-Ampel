<x-layouts.app title="Monitoring Sistem">
    <x-page-header title="Monitoring Sistem" description="Status kesehatan aplikasi secara real-time." />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Database</p>
                <span class="size-2.5 rounded-full {{ $database['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500' }}"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);">{{ $database['status'] }}</p>
            <p class="mt-0.5 text-xs text-slate-400">{{ $database['driver'] ?? $database['message'] ?? '' }}</p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Queue</p>
                <span class="size-2.5 rounded-full {{ $queue['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500' }}"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);">{{ $queue['pending'] ?? 0 }} pending</p>
            <p class="mt-0.5 text-xs text-slate-400">{{ $queue['failed'] ?? 0 }} gagal</p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-500">Storage Publik</p>
                <span class="size-2.5 rounded-full {{ $storage['status'] === 'OK' ? 'bg-primary-600' : 'bg-danger-500' }}"></span>
            </div>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);">{{ number_format(($storage['total_size'] ?? 0) / 1048576, 2) }} MB</p>
            <p class="mt-0.5 text-xs text-slate-400">{{ $storage['file_count'] ?? 0 }} file</p>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <p class="text-sm text-slate-500">Backup Terakhir</p>
            <p class="mt-1 font-display text-lg font-bold" style="font-family: var(--font-display);">{{ $lastBackup?->backup_date->diffForHumans() ?? 'Belum ada' }}</p>
            <a href="{{ route('backup.index') }}" class="mt-0.5 text-xs text-primary-600 hover:underline">Kelola Backup →</a>
        </div>
    </div>

    <div class="mt-4 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
        <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">Informasi Aplikasi</h2>
        <dl class="grid grid-cols-2 gap-4 text-sm sm:grid-cols-4">
            <div><dt class="text-xs text-slate-400">PHP Version</dt><dd class="mt-0.5 font-mono" style="font-family: var(--font-mono);">{{ $phpVersion }}</dd></div>
            <div><dt class="text-xs text-slate-400">Laravel Version</dt><dd class="mt-0.5 font-mono" style="font-family: var(--font-mono);">{{ $laravelVersion }}</dd></div>
            <div><dt class="text-xs text-slate-400">Environment</dt><dd class="mt-0.5">{{ config('app.env') }}</dd></div>
            <div><dt class="text-xs text-slate-400">Debug Mode</dt><dd class="mt-0.5">{{ config('app.debug') ? 'ON ⚠️' : 'OFF' }}</dd></div>
        </dl>
    </div>
</x-layouts.app>
