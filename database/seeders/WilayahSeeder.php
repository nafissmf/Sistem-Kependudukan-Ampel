<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Hamlet;
use App\Models\Province;
use App\Models\Regency;
use App\Models\RtRw;
use App\Models\Village;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Daftar 20 desa di Kecamatan Ampel + kode pos — data NYATA (dicek
     * lewat pencarian web saat membangun seeder ini, bukan dikarang),
     * supaya demo data terasa seperti kecamatan sungguhan, bukan
     * "Desa A, Desa B, Desa C".
     *
     * Kode wilayah (province/regency/district) di bawah ini APPROKSIMASI
     * untuk keperluan development — sebelum dipakai untuk integrasi resmi
     * (Dukcapil/BPS/Satu Data Indonesia, lihat Phase "Interoperability"),
     * ganti dengan kode resmi Kemendagri/BPS.
     */
    private const VILLAGES = [
        ['name' => 'Banyuanyar', 'postal_code' => '57352'],
        ['name' => 'Candi', 'postal_code' => '57352'],
        ['name' => 'Candisari', 'postal_code' => '57352'],
        ['name' => 'Gladagsari', 'postal_code' => '57352'],
        ['name' => 'Gondang Slamet', 'postal_code' => '57352'],
        ['name' => 'Jlarem', 'postal_code' => '57352'],
        ['name' => 'Kaligentong', 'postal_code' => '57352'],
        ['name' => 'Kembang', 'postal_code' => '57352'],
        ['name' => 'Ngadirojo', 'postal_code' => '57352'],
        ['name' => 'Ngagrong', 'postal_code' => '57352'],
        ['name' => 'Ngampon', 'postal_code' => '57352'],
        ['name' => 'Ngargoloko', 'postal_code' => '57352'],
        ['name' => 'Ngargosari', 'postal_code' => '57352'],
        ['name' => 'Ngenden', 'postal_code' => '57352'],
        ['name' => 'Sampetan', 'postal_code' => '57352'],
        ['name' => 'Seboto', 'postal_code' => '57352'],
        ['name' => 'Selodoko', 'postal_code' => '57352'],
        ['name' => 'Sidomulyo', 'postal_code' => '57316'],
        ['name' => 'Tanduk', 'postal_code' => '57352'],
        ['name' => 'Urutsewu', 'postal_code' => '57352'],
    ];

    public function run(): void
    {
        $this->command->info('🌱 Seeding wilayah: Provinsi → Kabupaten → Kecamatan → Desa...');

        $province = Province::updateOrCreate(
            ['code' => '33'],
            ['name' => 'Jawa Tengah'],
        );

        $regency = Regency::updateOrCreate(
            ['code' => '3309'],
            ['province_id' => $province->id, 'name' => 'Boyolali'],
        );

        $district = District::updateOrCreate(
            ['code' => '330905'],
            ['regency_id' => $regency->id, 'name' => 'Ampel'],
        );

        $this->command->info('🌱 Seeding 20 desa Kecamatan Ampel (data riil)...');

        $hamletCount = 0;
        $rtRwCount = 0;

        foreach (self::VILLAGES as $index => $villageData) {
            $village = Village::updateOrCreate(
                ['code' => '330905'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'district_id' => $district->id,
                    'name' => $villageData['name'],
                    'postal_code' => $villageData['postal_code'],
                ],
            );

            // ~7-8 dusun per desa supaya total mendekati 150 dusun se-kecamatan
            // (lihat dokumen brief "SEED DATA": "150 Dusun"). Nama digenerate
            // ("Dusun I, II, ...") karena nama dusun riil per desa tidak
            // tersedia di sumber publik yang saya akses.
            $hamletsInVillage = 7 + ($index % 2); // selang-seling 7 dan 8

            for ($h = 1; $h <= $hamletsInVillage; $h++) {
                $hamlet = Hamlet::create([
                    'village_id' => $village->id,
                    'name' => 'Dusun '.$this->toRoman($h),
                ]);
                $hamletCount++;

                // 4 RT per dusun, 1 RW per dusun — total ≈ 600 RT/RW se-kecamatan.
                for ($rt = 1; $rt <= 4; $rt++) {
                    RtRw::create([
                        'hamlet_id' => $hamlet->id,
                        'rt' => str_pad((string) $rt, 3, '0', STR_PAD_LEFT),
                        'rw' => str_pad((string) $h, 3, '0', STR_PAD_LEFT),
                    ]);
                    $rtRwCount++;
                }
            }
        }

        $this->command->info("   → {$hamletCount} dusun, {$rtRwCount} RT/RW dibuat.");
    }

    private function toRoman(int $number): string
    {
        $map = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];

        return $map[$number - 1] ?? (string) $number;
    }
}
