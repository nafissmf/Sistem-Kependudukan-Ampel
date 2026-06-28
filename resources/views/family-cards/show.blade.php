<x-layouts.app title="Detail KK">
    <x-page-header :title="'KK ' . $familyCard->number" :description="'Kepala Keluarga: ' . ($familyCard->headCitizen?->fullname ?? '—')">
        <x-slot:actions>
            <x-status-badge :status="$familyCard->verification_status" />
            @can('kk.update')
                <a href="{{ route('family-cards.edit', $familyCard) }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
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
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Informasi KK</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-xs text-slate-400">Nomor KK</dt><dd class="mt-0.5 font-mono text-sm" style="font-family: var(--font-mono);">{{ $familyCard->number }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Tanggal Terbit</dt><dd class="mt-0.5 text-sm">{{ $familyCard->issued_date?->translatedFormat('d F Y') ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $familyCard->village?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Rumah</dt><dd class="mt-0.5 text-sm">{{ $familyCard->house?->house_number ?? '— Belum ditentukan —' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs text-slate-400">Alamat</dt><dd class="mt-0.5 text-sm">{{ $familyCard->address ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Anggota Keluarga ({{ $familyCard->members->count() }})</h2>
                @if ($familyCard->members->isEmpty())
                    <p class="mt-2 text-sm text-slate-400">Belum ada anggota terdaftar.</p>
                @else
                    <ul class="mt-3 divide-y divide-[var(--border)]">
                        @foreach ($familyCard->members as $member)
                            <li class="flex items-center justify-between py-2.5 text-sm">
                                <div>
                                    <a href="{{ route('citizens.show', $member) }}" class="font-medium text-primary-600 hover:underline">{{ $member->fullname }}</a>
                                    <span class="ml-2 font-mono text-xs text-slate-400" style="font-family: var(--font-mono);">{{ $member->nik }}</span>
                                </div>
                                <span class="text-xs text-slate-400">{{ $member->pivot->relationship_id ? \App\Models\FamilyRelationship::find($member->pivot->relationship_id)?->name : '—' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Riwayat</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-400">Dibuat</dt><dd>{{ $familyCard->created_at->translatedFormat('d M Y H:i') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-400">Diperbarui</dt><dd>{{ $familyCard->updated_at->translatedFormat('d M Y H:i') }}</dd></div>
                </dl>
            </div>

            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 text-center">
                <h2 class="mb-3 font-display text-sm font-semibold" style="font-family: var(--font-display);">QR Code Verifikasi</h2>
                @if ($familyCard->qr_code)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($familyCard->qr_code) }}" alt="QR KK" class="mx-auto size-40">
                    <p class="mt-2 text-xs text-slate-400">Scan untuk membuka halaman verifikasi publik.</p>
                @else
                    <p class="text-sm text-slate-400">Belum ada QR Code.</p>
                @endif
                @can('qr.create')
                    <form method="POST" action="{{ route('family-cards.qr-code', $familyCard) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="flex h-9 w-full items-center justify-center gap-2 rounded-xl bg-secondary-600 px-4 text-sm font-medium text-white hover:bg-secondary-700">
                            <x-icon name="qr-code" class="size-4" /> {{ $familyCard->qr_code ? 'Buat Ulang QR' : 'Generate QR' }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>
