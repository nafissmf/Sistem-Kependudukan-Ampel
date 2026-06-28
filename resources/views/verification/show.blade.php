<x-layouts.app title="Tinjau Verifikasi">
    <x-page-header :title="$title" :description="'Modul: ' . $moduleLabel">
        <x-slot:actions>
            <x-status-badge :status="$record->verification_status" />
        </x-slot:actions>
    </x-page-header>

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-danger-500/10 px-4 py-3 text-sm text-danger-600 dark:text-danger-400">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        {{-- RINGKASAN DATA — disesuaikan per modul --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5 lg:col-span-2">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Ringkasan Data</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                @if ($module === 'penduduk')
                    <div><dt class="text-xs text-slate-400">NIK</dt><dd class="mt-0.5 font-mono text-sm" style="font-family: var(--font-mono);">{{ $record->nik }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Nama</dt><dd class="mt-0.5 text-sm">{{ $record->fullname }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Gender</dt><dd class="mt-0.5 text-sm">{{ $record->gender->label() }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $record->village?->name ?? '—' }}</dd></div>
                @elseif ($module === 'kk')
                    <div><dt class="text-xs text-slate-400">Nomor KK</dt><dd class="mt-0.5 font-mono text-sm" style="font-family: var(--font-mono);">{{ $record->number }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Kepala Keluarga</dt><dd class="mt-0.5 text-sm">{{ $record->headCitizen?->fullname ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Jumlah Anggota</dt><dd class="mt-0.5 text-sm">{{ $record->members()->count() }} orang</dd></div>
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $record->village?->name ?? '—' }}</dd></div>
                @else
                    <div><dt class="text-xs text-slate-400">Nomor Rumah</dt><dd class="mt-0.5 text-sm">{{ $record->house_number ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Alamat</dt><dd class="mt-0.5 text-sm">{{ $record->address ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Desa</dt><dd class="mt-0.5 text-sm">{{ $record->village?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-slate-400">Koordinat</dt><dd class="mt-0.5 text-sm">{{ $record->latitude ?? '—' }}, {{ $record->longitude ?? '—' }}</dd></div>
                @endif
            </dl>
            <a href="{{ \App\Support\VerifiableModuleRegistry::routeFor($module, $record) }}" class="mt-4 inline-flex items-center gap-1.5 text-sm text-primary-600 hover:underline">
                Lihat detail lengkap <x-icon name="eye" class="size-3.5" />
            </a>
        </div>

        {{-- FORM KEPUTUSAN --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Keputusan Verifikasi</h2>

            <form
                method="POST"
                action="{{ route('verification.decide', ['module' => $module, 'reference' => $record->id]) }}"
                class="mt-4 space-y-4"
                x-data="{ ...signaturePad(), decision: 'APPROVED' }"
                x-init="init($refs.signatureCanvas)"
            >
                @csrf

                <div>
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-200">Keputusan</label>
                    <select name="decision" x-model="decision" class="mt-1.5 flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="APPROVED">Setujui</option>
                        <option value="REJECTED">Tolak</option>
                        <option value="REVISION">Minta Revisi</option>
                    </select>
                </div>

                <x-form-group label="Catatan" name="note">
                    <textarea name="note" rows="3" class="flex w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Wajib diisi untuk Tolak/Revisi"></textarea>
                </x-form-group>

                {{-- DIGITAL SIGNATURE — wajib hanya untuk Setujui. --}}
                <div x-show="decision === 'APPROVED'">
                    <label class="text-sm font-medium text-slate-700 dark:text-slate-200">Tanda Tangan Digital</label>
                    <canvas
                        x-ref="signatureCanvas"
                        width="320" height="140"
                        class="mt-1.5 w-full touch-none rounded-xl border border-dashed border-[var(--border)] bg-white"
                    ></canvas>
                    <div class="mt-1.5 flex items-center justify-between">
                        <p class="text-xs text-slate-400">Gambar tanda tangan dengan mouse/jari di kotak di atas.</p>
                        <button type="button" @click="clear()" class="text-xs font-medium text-secondary-600 hover:underline">Hapus</button>
                    </div>
                    <input type="hidden" name="signature" x-model="dataUrl">
                    @error('signature')
                        <p class="mt-1 text-xs text-danger-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="flex h-10 w-full items-center justify-center gap-2 rounded-xl bg-primary-600 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                    <x-icon name="check-circle-2" class="size-4" /> Kirim Keputusan
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
