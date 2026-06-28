<?php

namespace Database\Seeders;

use App\Enums\RoleCode;
use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\House;
use App\Models\Role;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Mengisi data CONTOH yang representatif (bukan volume produksi penuh).
 *
 * Brief asli minta volume seed besar (5.000 Penduduk, 1.500 KK, 1.500
 * Rumah, dst — lihat dokumen "SEED DATA"). Untuk Phase 3 ini saya isi
 * jumlah yang lebih kecil (cukup untuk membuktikan semua CRUD, filter,
 * dan relasi benar-benar berfungsi), supaya seeding tidak berjalan
 * sangat lama tiap kali `migrate:fresh --seed`.
 *
 * Untuk perbesar ke volume mendekati brief, tinggal ubah angka di
 * `Citizen::factory(60)` dst menjadi `Citizen::factory(5000)` dan
 * jalankan `php artisan db:seed --class=DemoDataSeeder`.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $villages = Village::all();

        if ($villages->isEmpty()) {
            $this->command->warn('Belum ada data wilayah — jalankan WilayahSeeder dulu.');

            return;
        }

        $this->command->info('🌱 Seeding contoh user per role...');
        $this->seedSampleUsers($villages);

        $this->command->info('🌱 Seeding contoh data Penduduk, KK, Rumah...');
        $houses = House::factory(20)->create();
        $citizens = Citizen::factory(60)->create();

        $familyCards = FamilyCard::factory(20)->create([
            // Sebagian KK dikaitkan ke rumah yang sudah ada (relasi 1:1).
        ]);

        foreach ($familyCards as $index => $familyCard) {
            $house = $houses->get($index % $houses->count());
            $members = $citizens->slice(($index * 3) % $citizens->count(), 3);

            if ($members->isEmpty()) {
                continue;
            }

            $head = $members->first();

            $familyCard->update([
                'house_id' => $house->id,
                'head_citizen_id' => $head->id,
                'village_id' => $house->village_id,
            ]);

            $familyCard->members()->sync($members->pluck('id')->all());
            Citizen::whereIn('id', $members->pluck('id'))->update(['family_card_id' => $familyCard->id]);
        }

        $this->command->info('   → '.$houses->count().' rumah, '.$citizens->count().' penduduk, '.$familyCards->count().' KK dibuat.');
    }

    private function seedSampleUsers($villages): void
    {
        $roles = Role::all()->keyBy(fn ($role) => $role->code->value);
        $password = Hash::make(env('SEED_SUPER_ADMIN_PASSWORD', 'Ampel#2026Boyolali'));

        $singleRoleUsers = [
            ['username' => 'kecamatan.ampel', 'fullname' => 'Operator Kecamatan Ampel', 'role' => RoleCode::OperatorKecamatan],
            ['username' => 'validator.ampel', 'fullname' => 'Validator Desa Ampel', 'role' => RoleCode::ValidatorDesa],
            ['username' => 'camat.ampel', 'fullname' => 'Camat Ampel', 'role' => RoleCode::Camat],
        ];

        foreach ($singleRoleUsers as $data) {
            User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'email' => $data['username'].'@sik-ampel.boyolali.go.id',
                    'password' => $password,
                    'fullname' => $data['fullname'],
                    'role_id' => $roles[$data['role']->value]->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
            );
        }

        // 3 Operator Desa + 1 Kepala Desa, masing-masing terikat ke desa
        // berbeda — supaya scoping data per-desa bisa langsung dites.
        foreach ($villages->take(3) as $index => $village) {
            $slug = Str::slug($village->name);

            User::updateOrCreate(
                ['username' => "operator.{$slug}"],
                [
                    'email' => "operator.{$slug}@sik-ampel.boyolali.go.id",
                    'password' => $password,
                    'fullname' => "Operator Desa {$village->name}",
                    'role_id' => $roles[RoleCode::OperatorDesa->value]->id,
                    'village_id' => $village->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
            );
        }

        $firstVillage = $villages->first();
        User::updateOrCreate(
            ['username' => 'kepaladesa.'.Str::slug($firstVillage->name)],
            [
                'email' => 'kepaladesa.'.Str::slug($firstVillage->name).'@sik-ampel.boyolali.go.id',
                'password' => $password,
                'fullname' => "Kepala Desa {$firstVillage->name}",
                'role_id' => $roles[RoleCode::KepalaDesa->value]->id,
                'village_id' => $firstVillage->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
