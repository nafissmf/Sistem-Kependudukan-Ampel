<x-layouts.app title="Manajemen Role">
    <x-page-header title="Manajemen Role" description="Daftar role dan hak akses dalam sistem." />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($roles as $role)
            <a href="{{ route('roles.show', $role) }}"
               class="group rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 shadow-sm transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="flex size-10 items-center justify-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-600/15">
                        <x-icon name="lock" class="size-5" />
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 dark:bg-white/10 dark:text-slate-300">
                        {{ $role->users_count }} pengguna
                    </span>
                </div>
                <h3 class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">{{ $role->name }}</h3>
                <p class="mt-1 text-sm text-slate-500">{{ $role->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="mt-3 flex items-center gap-1 text-xs font-medium text-primary-600 group-hover:text-primary-700 dark:text-primary-400">
                    Lihat hak akses <x-icon name="arrow-right" class="size-3" />
                </div>
            </a>
        @endforeach
    </div>
</x-layouts.app>
