<?php

namespace Tests\Feature;

use App\Enums\RoleCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EnsureModuleAccessMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Route sementara khusus untuk menguji middleware 'module' secara
        // terisolasi, tanpa bergantung pada route /dashboard sungguhan
        // (yang aksesnya sama untuk semua role, jadi tidak representatif
        // untuk menguji kasus "ditolak").
        Route::middleware(['web', 'auth', 'module:user,delete'])
            ->get('/__test/users/delete-only', fn () => 'ok');
    }

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

    public function test_super_admin_boleh_akses_route_yang_butuh_permission_user_delete(): void
    {
        $user = $this->userWithRole(RoleCode::SuperAdmin);

        $response = $this->actingAs($user)->get('/__test/users/delete-only');

        $response->assertOk();
    }

    public function test_operator_kecamatan_ditolak_403_karena_tidak_punya_permission_user_delete(): void
    {
        $user = $this->userWithRole(RoleCode::OperatorKecamatan);

        $response = $this->actingAs($user)->get('/__test/users/delete-only');

        $response->assertForbidden();
    }

    public function test_tamu_tanpa_login_diarahkan_ke_halaman_login(): void
    {
        $response = $this->get('/__test/users/delete-only');

        $response->assertRedirect(route('login'));
    }
}
