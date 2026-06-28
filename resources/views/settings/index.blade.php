<x-layouts.app title="Pengaturan Sistem">
    <x-page-header title="Pengaturan Sistem" description="Konfigurasi umum sistem." />

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Backup & Restore --}}
        @can('backup.read')
            <a href="{{ route('backup.index') }}" class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="database" class="size-5" />
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">Backup & Restore</h3>
                <p class="mt-1 text-sm text-slate-500">Kelola cadangan dan pemulihan data sistem.</p>
            </a>
        @endcan

        {{-- User Management --}}
        @can('user.read')
            <a href="{{ route('users.index') }}" class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="users" class="size-5" />
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">Manajemen Pengguna</h3>
                <p class="mt-1 text-sm text-slate-500">Tambah, edit, dan nonaktifkan akun pengguna.</p>
            </a>
        @endcan

        {{-- Role Management --}}
        @can('role.read')
            <a href="{{ route('roles.index') }}" class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="lock" class="size-5" />
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">Role & Hak Akses</h3>
                <p class="mt-1 text-sm text-slate-500">Lihat konfigurasi role dan permission sistem.</p>
            </a>
        @endcan

        {{-- Monitoring --}}
        @can('setting.read')
            <a href="{{ route('monitoring.index') }}" class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="activity" class="size-5" />
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">Monitoring Sistem</h3>
                <p class="mt-1 text-sm text-slate-500">Pantau antrian, jadwal, dan kesehatan sistem.</p>
            </a>
        @endcan

        {{-- Audit Log --}}
        @can('audit.read')
            <a href="{{ route('audit.index') }}" class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                    <x-icon name="shield-check" class="size-5" />
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">Audit Log</h3>
                <p class="mt-1 text-sm text-slate-500">Lacak semua aktivitas dan perubahan data.</p>
            </a>
        @endcan
    </div>

    {{-- System Info --}}
    <div class="mt-6 rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm">
        <h2 class="mb-4 font-semibold">Informasi Sistem</h2>
        <dl class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 text-sm">
            <div class="rounded-xl border border-[var(--border)] p-3">
                <dt class="text-xs text-slate-400 uppercase">Versi Laravel</dt>
                <dd class="mt-1 font-medium font-mono" style="font-family: var(--font-mono);">{{ app()->version() }}</dd>
            </div>
            <div class="rounded-xl border border-[var(--border)] p-3">
                <dt class="text-xs text-slate-400 uppercase">Versi PHP</dt>
                <dd class="mt-1 font-medium font-mono" style="font-family: var(--font-mono);">{{ PHP_VERSION }}</dd>
            </div>
            <div class="rounded-xl border border-[var(--border)] p-3">
                <dt class="text-xs text-slate-400 uppercase">Environment</dt>
                <dd class="mt-1 font-medium">{{ app()->environment() }}</dd>
            </div>
            <div class="rounded-xl border border-[var(--border)] p-3">
                <dt class="text-xs text-slate-400 uppercase">Timezone</dt>
                <dd class="mt-1 font-medium">{{ config('app.timezone') }}</dd>
            </div>
        </dl>
    </div>
</x-layouts.app>
