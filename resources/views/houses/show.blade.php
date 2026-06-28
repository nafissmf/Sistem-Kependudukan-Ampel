<x-layouts.app title="Detail Rumah">
    <x-page-header :title="$house->house_number ?? 'Rumah'" :description="$house->address ?? '—'">
        <x-slot:actions>
            <x-status-badge :status="$house->verification_status" />
            @can('rumah.update')
                <a href="{{ route('houses.edit', $house) }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    <x-icon name="settings" class="size-4" /> Edit
                </a>
            @endcan
        </x-slot:actions>
    </x-page-header>

    @if (session('success'))
        <div class="mb-4 rounded-xl bg-primary-50 px-4 py-3 text-sm text-primary-700 dark:bg-primary-600/15 dark:text-primary-300">{{ session('success') }}</div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Lokasi</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $house->village?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Dusun / RT-RW</dt><dd class="mt-0.5 text-sm">{{ $house->hamlet?->name ?? '—' }} / {{ $house->rtRw?->label() ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Koordinat</dt>
                        <dd class="mt-0.5 font-mono text-sm" style="font-family: var(--font-mono);">
                            @if ($house->latitude && $house->longitude)
                                {{ $house->latitude }}, {{ $house->longitude }}
                                <a href="https://maps.google.com/?q={{ $house->latitude }},{{ $house->longitude }}" target="_blank" class="ml-2 text-primary-600 hover:underline">Lihat di Maps</a>
                            @else
                                — belum ada GPS —
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Spesifikasi Bangunan</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Luas Tanah</dt><dd class="mt-0.5 text-sm">{{ $house->land_area ?? '—' }} m²</dd></div>
                    <div><dt class="text-xs text-slate-400">Luas Bangunan</dt><dd class="mt-0.5 text-sm">{{ $house->building_area ?? '—' }} m²</dd></div>
                    <div><dt class="text-xs text-slate-400">Atap / Dinding / Lantai</dt><dd class="mt-0.5 text-sm">{{ $house->roofType?->name ?? '—' }} / {{ $house->wallType?->name ?? '—' }} / {{ $house->floorType?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Kamar Tidur / Mandi</dt><dd class="mt-0.5 text-sm">{{ $house->bedroom_count ?? '—' }} / {{ $house->bathroom_count ?? '—' }}</dd></div>
                </dl>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 text-center">
                @if ($house->photo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($house->photo) }}" alt="Foto rumah" class="mx-auto h-40 w-full rounded-xl object-cover">
                @else
                    <div class="mx-auto flex h-40 items-center justify-center rounded-xl bg-slate-100 text-slate-400 dark:bg-white/5">
                        <x-icon name="home" class="size-12" />
                    </div>
                @endif
            </div>
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Kartu Keluarga Terkait</h2>
                <p class="mt-2 text-sm">{{ $house->familyCard?->number ?? '— Belum ada KK terhubung —' }}</p>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 text-center">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">QR Code Verifikasi</h2>
                @if ($house->qr_code)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($house->qr_code) }}" alt="QR Rumah" class="mx-auto size-40">
                    <p class="mt-2 text-xs text-slate-400">Scan untuk membuka halaman verifikasi publik.</p>
                @else
                    <p class="text-sm text-slate-400">Belum ada QR Code.</p>
                @endif
                @can('qr.create')
                    <form method="POST" action="{{ route('houses.qr-code', $house) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="flex h-9 w-full items-center justify-center gap-2 rounded-xl bg-secondary-600 px-4 text-sm font-medium text-white hover:bg-secondary-700">
                            <x-icon name="qr-code" class="size-4" /> {{ $house->qr_code ? 'Buat Ulang QR' : 'Generate QR' }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>
