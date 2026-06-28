<x-layouts.app :title="$house->exists ? 'Edit Rumah' : 'Tambah Rumah'">
    <x-page-header
        :title="$house->exists ? 'Edit Data Rumah' : 'Tambah Rumah Baru'"
        description="Gunakan tombol Ambil Lokasi untuk mengisi koordinat GPS otomatis dari perangkatmu."
    />

    <form method="POST" action="{{ $house->exists ? route('houses.update', $house) : route('houses.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if ($house->exists) @method('PUT') @endif

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Identitas &amp; Lokasi</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-form-group label="Nomor Rumah" name="house_number">
                    <x-text-input name="house_number" :value="$house->house_number" />
                </x-form-group>

                <x-form-group label="Desa/Kelurahan" name="village_id">
                    <x-select-input name="village_id" :options="$villages" :value="$house->village_id" />
                </x-form-group>

                <x-form-group label="Alamat" name="address">
                    <x-text-input name="address" :value="$house->address" />
                </x-form-group>
            </div>

            {{-- GPS LOCATION — sesuai brief: "Sediakan tombol Ambil Lokasi Saat Ini,
                 menggunakan HTML5 Geolocation API". Kalau gagal, operator tetap bisa
                 mengisi manual lewat input Latitude/Longitude di bawah. --}}
            <div
                x-data="{
                    status: 'idle',
                    errorMessage: '',
                    getLocation() {
                        this.status = 'loading';
                        if (!('geolocation' in navigator)) {
                            this.status = 'error';
                            this.errorMessage = 'Browser ini tidak mendukung GPS. Isi koordinat manual.';
                            return;
                        }
                        navigator.geolocation.getCurrentPosition(
                            (pos) => {
                                document.getElementById('latitude').value = pos.coords.latitude.toFixed(7);
                                document.getElementById('longitude').value = pos.coords.longitude.toFixed(7);
                                document.getElementById('gps_accuracy').value = pos.coords.accuracy.toFixed(2);
                                this.status = 'success';
                            },
                            (err) => {
                                this.status = 'error';
                                this.errorMessage = 'Gagal mengambil lokasi (' + err.message + '). Isi koordinat manual atau pilih di peta (Phase 5).';
                            },
                            { enableHighAccuracy: true, timeout: 10000 },
                        );
                    },
                }"
                class="mt-4 rounded-xl border border-dashed border-[var(--border)] p-4"
            >
                <button type="button" @click="getLocation()" class="flex h-10 items-center gap-2 rounded-xl bg-secondary-600 px-4 text-sm font-medium text-white shadow-sm hover:bg-secondary-700">
                    <x-icon name="map" class="size-4" />
                    <span x-show="status !== 'loading'">📍 Ambil Lokasi Saat Ini</span>
                    <span x-show="status === 'loading'" x-cloak>Mengambil lokasi…</span>
                </button>
                <p class="mt-2 text-xs text-primary-600" x-show="status === 'success'" x-cloak>✓ Lokasi berhasil diambil.</p>
                <p class="mt-2 text-xs text-danger-500" x-show="status === 'error'" x-cloak x-text="errorMessage"></p>

                <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <x-form-group label="Latitude" name="latitude">
                        <x-text-input name="latitude" :value="$house->latitude" placeholder="-7.123456" />
                    </x-form-group>
                    <x-form-group label="Longitude" name="longitude">
                        <x-text-input name="longitude" :value="$house->longitude" placeholder="110.123456" />
                    </x-form-group>
                    <x-form-group label="Akurasi GPS (meter)" name="gps_accuracy">
                        <x-text-input name="gps_accuracy" :value="$house->gps_accuracy" />
                    </x-form-group>
                </div>
            </div>
        </div>

        <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-5">
            <h2 class="font-display text-sm font-semibold" style="font-family: var(--font-display);">Spesifikasi Bangunan</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-form-group label="Luas Tanah (m²)" name="land_area">
                    <x-text-input type="number" step="0.01" name="land_area" :value="$house->land_area" />
                </x-form-group>
                <x-form-group label="Luas Bangunan (m²)" name="building_area">
                    <x-text-input type="number" step="0.01" name="building_area" :value="$house->building_area" />
                </x-form-group>
                <x-form-group label="Jenis Atap" name="roof_type_id">
                    <x-select-input name="roof_type_id" :options="$roofTypes" :value="$house->roof_type_id" />
                </x-form-group>
                <x-form-group label="Jenis Dinding" name="wall_type_id">
                    <x-select-input name="wall_type_id" :options="$wallTypes" :value="$house->wall_type_id" />
                </x-form-group>
                <x-form-group label="Jenis Lantai" name="floor_type_id">
                    <x-select-input name="floor_type_id" :options="$floorTypes" :value="$house->floor_type_id" />
                </x-form-group>
                <x-form-group label="Status Rumah" name="house_status_id">
                    <x-select-input name="house_status_id" :options="$houseStatuses" :value="$house->house_status_id" />
                </x-form-group>
                <x-form-group label="Jumlah Kamar Tidur" name="bedroom_count">
                    <x-text-input type="number" name="bedroom_count" :value="$house->bedroom_count" />
                </x-form-group>
                <x-form-group label="Jumlah Kamar Mandi" name="bathroom_count">
                    <x-text-input type="number" name="bathroom_count" :value="$house->bathroom_count" />
                </x-form-group>
                <x-form-group label="Foto Rumah" name="photo">
                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-slate-500">
                </x-form-group>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('houses.index') }}" class="flex h-10 items-center rounded-xl border border-[var(--border)] px-4 text-sm hover:bg-slate-50 dark:hover:bg-white/5">Batal</a>
            <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                <x-icon name="check-circle-2" class="size-4" /> Simpan
            </button>
        </div>
    </form>
</x-layouts.app>
