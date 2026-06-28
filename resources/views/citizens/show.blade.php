<x-layouts.app title="Detail Penduduk">
    <x-page-header :title="$citizen->fullname" :description="'NIK: ' . $citizen->nik">
        <x-slot:actions>
            <x-status-badge :status="$citizen->verification_status" />
            @can('penduduk.update')
                <a href="{{ route('citizens.edit', $citizen) }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <x-icon name="settings" class="size-4" /> Edit
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Data Diri</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Jenis Kelamin</dt><dd class="mt-0.5 text-sm">{{ $citizen->gender->label() }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Umur</dt><dd class="mt-0.5 text-sm">{{ $citizen->age ?? '—' }} tahun</dd></div>
                    <div><dt class="text-xs text-slate-400">Tempat, Tanggal Lahir</dt><dd class="mt-0.5 text-sm">{{ $citizen->birth_place ?? '—' }}, {{ $citizen->birth_date?->translatedFormat('d F Y') ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Golongan Darah</dt><dd class="mt-0.5 text-sm">{{ $citizen->bloodType?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Agama</dt><dd class="mt-0.5 text-sm">{{ $citizen->religion?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Status Kawin</dt><dd class="mt-0.5 text-sm">{{ $citizen->maritalStatus?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Pendidikan</dt><dd class="mt-0.5 text-sm">{{ $citizen->education?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Pekerjaan</dt><dd class="mt-0.5 text-sm">{{ $citizen->job?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Nomor HP</dt><dd class="mt-0.5 text-sm">{{ $citizen->phone ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Email</dt><dd class="mt-0.5 text-sm">{{ $citizen->email ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Alamat &amp; Keluarga</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $citizen->village?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Dusun / RT-RW</dt><dd class="mt-0.5 text-sm">{{ $citizen->hamlet?->name ?? '—' }} / {{ $citizen->rtRw?->label() ?? '—' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs text-slate-400">Alamat Lengkap</dt><dd class="mt-0.5 text-sm">{{ $citizen->address ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Kartu Keluarga</dt><dd class="mt-0.5 text-sm">{{ $citizen->familyCard?->number ?? '— Belum tergabung —' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Hubungan Keluarga</dt><dd class="mt-0.5 text-sm">{{ $citizen->relationship?->name ?? '—' }}</dd></div>
                </dl>
            </div>

            @if ($citizen->documents->isNotEmpty())
                <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                    <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Dokumen</h2>
                    <ul class="mt-3 space-y-2">
                        @foreach ($citizen->documents as $document)
                            <li class="flex items-center gap-2 text-sm">
                                <x-icon name="file-text" class="size-4 text-slate-400" />
                                <a href="{{ $document->url() }}" target="_blank" class="text-primary-600 hover:underline">{{ $document->filename }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 text-center">
                @if ($citizen->photo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($citizen->photo) }}" alt="Foto {{ $citizen->fullname }}" class="mx-auto size-32 rounded-full object-cover">
                @else
                    <div class="mx-auto flex size-32 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-white/5">
                        <x-icon name="user" class="size-12" />
                    </div>
                @endif
                <p class="mt-3 font-display font-semibold" style="font-family: var(--font-display);">{{ $citizen->fullname }}</p>
                <p class="font-mono text-xs text-slate-400" style="font-family: var(--font-mono);">{{ $citizen->nik }}</p>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Riwayat</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-400">Dibuat</dt><dd>{{ $citizen->created_at->translatedFormat('d M Y H:i') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Diperbarui</dt><dd>{{ $citizen->updated_at->translatedFormat('d M Y H:i') }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-layouts.app>
