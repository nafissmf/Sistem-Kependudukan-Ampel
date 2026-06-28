<?php

namespace Database\Seeders;

use App\Models\BloodType;
use App\Models\CitizenStatus;
use App\Models\Education;
use App\Models\FamilyRelationship;
use App\Models\FloorType;
use App\Models\HouseStatus;
use App\Models\Job;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\WallType;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding master reference data...');

        $this->seedTable(Religion::class, [
            'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu',
        ]);

        $this->seedTable(Education::class, [
            'Tidak Sekolah', 'SD', 'SMP', 'SMA', 'Diploma', 'Sarjana', 'Magister', 'Doktor',
        ]);

        $this->seedTable(Job::class, [
            'ASN', 'TNI/Polri', 'Petani', 'Peternak', 'Nelayan', 'Karyawan Swasta',
            'Wiraswasta', 'Buruh', 'Mahasiswa', 'Pelajar', 'Ibu Rumah Tangga', 'Tidak Bekerja', 'Pensiunan',
        ]);

        $this->seedTable(MaritalStatus::class, [
            'Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati',
        ]);

        $this->seedTable(BloodType::class, [
            'A', 'B', 'AB', 'O', 'Tidak Tahu',
        ]);

        $this->seedTable(FamilyRelationship::class, [
            'Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Lainnya',
        ]);

        $this->seedTable(CitizenStatus::class, [
            'Aktif', 'Pindah', 'Meninggal', 'Datang',
        ]);

        $this->seedTable(HouseStatus::class, [
            'Milik Sendiri', 'Sewa/Kontrak', 'Dinas', 'Menumpang', 'Rumah Kosong',
        ]);

        $this->seedTable(FloorType::class, [
            'Keramik', 'Ubin/Tegel', 'Semen', 'Tanah', 'Kayu/Papan',
        ]);

        $this->seedTable(RoofType::class, [
            'Genteng', 'Seng', 'Asbes', 'Beton', 'Lainnya',
        ]);

        $this->seedTable(WallType::class, [
            'Tembok', 'Kayu', 'Bambu', 'Setengah Tembok', 'Lainnya',
        ]);
    }

    /** @param  class-string<\App\Models\ReferenceModel>  $model */
    private function seedTable(string $model, array $names): void
    {
        foreach ($names as $index => $name) {
            $model::query()->withoutGlobalScopes()->updateOrCreate(
                ['code' => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::slug($name, '_'))],
                ['name' => $name, 'sort_order' => $index],
            );
        }
    }
}
