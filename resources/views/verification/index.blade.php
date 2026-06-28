<x-layouts.app title="Verifikasi">
    <x-page-header title="Verifikasi Data" description="Daftar pengajuan Penduduk, KK, dan Rumah yang menunggu persetujuan." />

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif

    <div class="mb-4 flex flex-wrap gap-2">
        <a href="{{ route('verification.index') }}" class="rounded-full px-3 py-1.5 text-sm {{ ! $activeModule ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600 dark:bg-white/5' }}">Semua</a>
        @foreach ($moduleLabels as $key => $label)
            <a href="{{ route('verification.index', ['module' => $key]) }}" class="rounded-full px-3 py-1.5 text-sm {{ $activeModule === $key ? 'bg-primary-600 text-white' : 'bg-slate-100 text-slate-600 dark:bg-white/5' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-hidden rounded-card border border-[var(--border)] bg-[var(--card-bg)] shadow-sm">
        @if ($items->isEmpty())
            <x-empty-state icon="shield-check" title="Tidak ada pengajuan menunggu" description="Semua data Penduduk/KK/Rumah sudah diverifikasi." />
        @else
            <ul class="divide-y divide-[var(--border)]">
                @foreach ($items as $item)
                    <li class="flex items-center justify-between gap-4 p-4">
                        <div class="flex items-center gap-3">
                            <span class="flex size-10 items-center justify-center rounded-xl bg-secondary-50 text-secondary-600 dark:bg-secondary-600/15">
                                <x-icon name="{{ $item['module'] === 'penduduk' ? 'users' : ($item['module'] === 'kk' ? 'id-card' : 'home') }}" class="size-5" />
                            </span>
                            <div>
                                <p class="font-medium">{{ $item['title'] }}</p>
                                <p class="text-xs text-slate-400">{{ $item['module_label'] }} · diajukan {{ $item['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-status-badge :status="$item['status']" />
                            <a href="{{ route('verification.show', ['module' => $item['module'], 'reference' => $item['record']->id]) }}" class="flex h-9 items-center gap-1.5 rounded-xl bg-primary-600 px-3 text-sm font-medium text-white hover:bg-primary-700">
                                Tinjau <x-icon name="eye" class="size-4" />
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
