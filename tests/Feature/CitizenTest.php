<?php

namespace Tests\Feature;

use App\Enums\RoleCode;
use App\Models\Citizen;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitizenTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(RoleCode $code): User
    {
        $role = Role::create(['code' => $code, 'name' => $code->label(), 'description' => $code->description()]);

        return User::create([
            'username' => 'user.'.strtolower($code->value),
            'email' => strtolower($code->value).'@ampel.test',
            'password' => bcrypt('password123'),
            'fullname' => $code->label(),
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_operator_desa_dapat_menambah_penduduk_baru(): void
    {
        $operator = $this->userWithRole(RoleCode::OperatorDesa);

        $response = $this->actingAs($operator)->post(route('citizens.store'), [
            'nik' => '3309011234567890',
            'fullname' => 'Budi Santoso',
            'gender' => 'L',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('citizens', ['nik' => '3309011234567890', 'fullname' => 'Budi Santoso']);
    }

    public function test_nik_duplikat_ditolak(): void
    {
        $operator = $this->userWithRole(RoleCode::OperatorDesa);

        Citizen::create([
            'nik' => '3309011111111111',
            'fullname' => 'Penduduk Pertama',
            'gender' => 'L',
        ]);

        $response = $this->actingAs($operator)->post(route('citizens.store'), [
            'nik' => '3309011111111111',
            'fullname' => 'Penduduk Kedua',
            'gender' => 'P',
        ]);

        $response->assertSessionHasErrors('nik');
        $this->assertSame(1, Citizen::where('nik', '3309011111111111')->count());
    }

    public function test_camat_tidak_bisa_menambah_penduduk_karena_read_only(): void
    {
        $camat = $this->userWithRole(RoleCode::Camat);

        $response = $this->actingAs($camat)->post(route('citizens.store'), [
            'nik' => '3309012222222222',
            'fullname' => 'Test Forbidden',
            'gender' => 'L',
        ]);

        $response->assertForbidden();
    }

    public function test_operator_desa_hanya_melihat_penduduk_di_desanya_sendiri(): void
    {
        $village = \App\Models\Village::create([
            'district_id' => \App\Models\District::create([
                'regency_id' => \App\Models\Regency::create([
                    'province_id' => \App\Models\Province::create(['code' => '33', 'name' => 'Jawa Tengah'])->id,
                    'code' => '3309',
                    'name' => 'Boyolali',
                ])->id,
                'code' => '330905',
                'name' => 'Ampel',
            ])->id,
            'code' => '330905001',
            'name' => 'Desa Satu',
        ]);

        $otherVillage = \App\Models\Village::create([
            'district_id' => $village->district_id,
            'code' => '330905002',
            'name' => 'Desa Dua',
        ]);

        $operator = $this->userWithRole(RoleCode::OperatorDesa);
        $operator->update(['village_id' => $village->id]);

        Citizen::create(['nik' => '3309013333333331', 'fullname' => 'Warga Desa Satu', 'gender' => 'L', 'village_id' => $village->id]);
        Citizen::create(['nik' => '3309013333333332', 'fullname' => 'Warga Desa Dua', 'gender' => 'L', 'village_id' => $otherVillage->id]);

        $response = $this->actingAs($operator)->get(route('citizens.index'));

        $response->assertSee('Warga Desa Satu');
        $response->assertDontSee('Warga Desa Dua');
    }
}
