<x-layouts.app :title="$familyCard->exists ? 'Edit KK' : 'Tambah KK'">
    <x-page-header
        :title="$familyCard->exists ? 'Edit Kartu Keluarga' : 'Tambah Kartu Keluarga'"
        description="Nomor KK harus 16 digit dan unik. Anggota keluarga bisa dipilih dari penduduk yang sudah terdaftar."
    />

    <form method="POST" action="{{ $familyCard->exists ? route('family-cards.update', $familyCard) : route('family-cards.store') }}" class="space-y-6">
        @csrf
        @if ($familyCard->exists) @method('PUT') @endif

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Informasi KK</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-form-group label="Nomor KK" name="number" required>
                    <x-text-input name="number" :value="$familyCard->number" maxlength="16" inputmode="numeric" />
                </x-form-group>

                <x-form-group label="Kepala Keluarga" name="head_citizen_id">
                    <x-select-input name="head_citizen_id" :options="$citizens" optionLabel="fullname" :value="$familyCard->head_citizen_id" />
                </x-form-group>

                <x-form-group label="Rumah" name="house_id">
                    <x-select-input name="house_id" :options="$houses" optionLabel="house_number" :value="$familyCard->house_id" placeholder="— Belum ditentukan —" />
                </x-form-group>

                <x-form-group label="Desa/Kelurahan" name="village_id">
                    <x-select-input name="village_id" :options="$villages" :value="$familyCard->village_id" />
                </x-form-group>

                <x-form-group label="Alamat" name="address">
                    <x-text-input name="address" :value="$familyCard->address" />
                </x-form-group>

                <x-form-group label="Tanggal Terbit" name="issued_date">
                    <x-text-input type="date" name="issued_date" :value="$familyCard->issued_date?->format('Y-m-d')" />
                </x-form-group>
            </div>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Anggota Keluarga</h2>
            <p class="mt-1 text-xs text-slate-400">Pilih penduduk yang menjadi anggota KK ini (centang satu atau lebih).</p>
            <div class="mt-3 max-h-64 space-y-1 overflow-y-auto thin-scrollbar rounded-xl border border-[var(--border)] p-3">
                @php $currentMembers = $familyCard->exists ? $familyCard->members->pluck('id')->all() : []; @endphp
                @foreach ($citizens as $citizen)
                    <label class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm hover:bg-slate-50 dark:hover:bg-white/5">
                        <input type="checkbox" name="member_ids[]" value="{{ $citizen->id }}" class="size-4 rounded border-[var(--border)]" @checked(in_array($citizen->id, $currentMembers))>
                        {{ $citizen->fullname }} <span class="font-mono text-xs text-slate-400" style="font-family: var(--font-mono);">({{ $citizen->nik }})</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('family-cards.index') }}" class="flex h-10 items-center rounded-xl border border-[var(--border)] px-4 text-sm hover:bg-slate-50 dark:hover:bg-white/5">Batal</a>
            <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                <x-icon name="check-circle-2" class="size-4" /> Simpan
            </button>
        </div>
    </form>
</x-layouts.app>
