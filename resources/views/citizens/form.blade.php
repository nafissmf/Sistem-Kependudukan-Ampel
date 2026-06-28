<x-layouts.app :title="$citizen->exists ? 'Edit Penduduk' : 'Tambah Penduduk'">
    <x-page-header
        :title="$citizen->exists ? 'Edit Data Penduduk' : 'Tambah Penduduk Baru'"
        description="Lengkapi data diri dan alamat. Data akan masuk status menunggu verifikasi setelah disimpan."
    />

    <form
        method="POST"
        action="{{ $citizen->exists ? route('citizens.update', $citizen) : route('citizens.store') }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf
        @if ($citizen->exists) @method('PUT') @endif

        {{-- DATA DIRI --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Data Diri</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-form-group label="NIK" name="nik" required>
                    <x-text-input name="nik" :value="$citizen->nik" maxlength="16" inputmode="numeric" />
                </x-form-group>

                <x-form-group label="Nama Lengkap" name="fullname" required>
                    <x-text-input name="fullname" :value="$citizen->fullname" />
                </x-form-group>

                <x-form-group label="Jenis Kelamin" name="gender" required>
                    <x-select-input name="gender" :options="[['id' => 'L', 'name' => 'Laki-laki'], ['id' => 'P', 'name' => 'Perempuan']]" :value="$citizen->gender?->value" />
                </x-form-group>

                <x-form-group label="Tempat Lahir" name="birth_place">
                    <x-text-input name="birth_place" :value="$citizen->birth_place" />
                </x-form-group>

                <x-form-group label="Tanggal Lahir" name="birth_date">
                    <x-text-input type="date" name="birth_date" :value="$citizen->birth_date?->format('Y-m-d')" />
                </x-form-group>

                <x-form-group label="Golongan Darah" name="blood_type_id">
                    <x-select-input name="blood_type_id" :options="$bloodTypes" :value="$citizen->blood_type_id" />
                </x-form-group>

                <x-form-group label="Agama" name="religion_id">
                    <x-select-input name="religion_id" :options="$religions" :value="$citizen->religion_id" />
                </x-form-group>

                <x-form-group label="Status Kawin" name="marital_status_id">
                    <x-select-input name="marital_status_id" :options="$maritalStatuses" :value="$citizen->marital_status_id" />
                </x-form-group>

                <x-form-group label="Pendidikan" name="education_id">
                    <x-select-input name="education_id" :options="$educations" :value="$citizen->education_id" />
                </x-form-group>

                <x-form-group label="Pekerjaan" name="job_id">
                    <x-select-input name="job_id" :options="$jobs" :value="$citizen->job_id" />
                </x-form-group>

                <x-form-group label="Nomor HP" name="phone">
                    <x-text-input name="phone" :value="$citizen->phone" placeholder="081234567890" />
                </x-form-group>

                <x-form-group label="Email" name="email">
                    <x-text-input type="email" name="email" :value="$citizen->email" />
                </x-form-group>

                <x-form-group label="Kartu Keluarga" name="family_card_id">
                    <x-select-input name="family_card_id" :options="$familyCards" optionLabel="number" :value="$citizen->family_card_id" placeholder="— Belum tergabung KK —" />
                </x-form-group>

                <x-form-group label="Hubungan dalam Keluarga" name="relationship_id">
                    <x-select-input name="relationship_id" :options="$relationships" :value="$citizen->relationship_id" />
                </x-form-group>

                <x-form-group label="Foto" name="photo">
                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500">
                    @if ($citizen->photo)
                        <p class="mt-1 text-xs text-slate-400">Foto saat ini tersimpan — pilih file baru untuk mengganti.</p>
                    @endif
                </x-form-group>
            </div>
        </div>

        {{-- ALAMAT --}}
        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Alamat</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-form-group label="Desa/Kelurahan" name="village_id">
                    <x-select-input name="village_id" :options="$villages" :value="$citizen->village_id" />
                </x-form-group>

                <x-form-group label="Alamat Lengkap" name="address">
                    <x-text-input name="address" :value="$citizen->address" placeholder="Nama jalan, nomor rumah, dst" />
                </x-form-group>

                <x-form-group label="Latitude" name="latitude">
                    <x-text-input name="latitude" :value="$citizen->latitude" placeholder="-7.123456" />
                </x-form-group>

                <x-form-group label="Longitude" name="longitude">
                    <x-text-input name="longitude" :value="$citizen->longitude" placeholder="110.123456" />
                </x-form-group>
            </div>
            <p class="mt-3 text-xs text-slate-400">
                Pemilihan Dusun &amp; RT/RW otomatis menyesuaikan Desa akan tersedia setelah endpoint
                pencarian wilayah bertingkat dibangun (peningkatan UI, tidak menghalangi pengisian data).
            </p>
        </div>

        {{-- DOKUMEN --}}
        @if (! $citizen->exists)
            <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
                <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Dokumen Pendukung</h2>
                <p class="mt-1 text-xs text-slate-400">Unggah KTP, Akta, atau dokumen pendukung lain (PDF/JPG/PNG, maks 5MB per file).</p>
                <input type="file" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="mt-3 block w-full text-sm text-slate-500">
            </div>
        @endif

        <div class="flex justify-end gap-2">
            <a href="{{ route('citizens.index') }}" class="flex h-10 items-center rounded-xl border border-[var(--border)] px-4 text-sm hover:bg-slate-50 dark:hover:bg-white/5">Batal</a>
            <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                <x-icon name="check-circle-2" class="size-4" /> Simpan
            </button>
        </div>
    </form>
</x-layouts.app>
