<?php

namespace Tests\Feature\Auth;

use App\Enums\RoleCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(string $password = 'password123'): User
    {
        $role = Role::create([
            'code' => RoleCode::OperatorDesa,
            'name' => RoleCode::OperatorDesa->label(),
            'description' => RoleCode::OperatorDesa->description(),
        ]);

        return User::create([
            'username' => 'operator.ampel',
            'email' => 'operator@ampel.test',
            'password' => Hash::make($password),
            'fullname' => 'Operator Desa Test',
            'role_id' => $role->id,
            'is_active' => true,
        ]);
    }

    public function test_halaman_login_bisa_dibuka_dan_menampilkan_soal_captcha(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('Selamat Datang');
    }

    public function test_login_berhasil_dengan_kredensial_dan_captcha_yang_benar(): void
    {
        $user = $this->makeUser();

        $response = $this->withSession(['login_captcha_answer' => 7])
            ->post(route('login'), [
                'identifier' => 'operator.ampel',
                'password' => 'password123',
                'captcha_answer' => '7',
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_bisa_pakai_email_selain_username(): void
    {
        $this->makeUser();

        $response = $this->withSession(['login_captcha_answer' => 7])
            ->post(route('login'), [
                'identifier' => 'operator@ampel.test',
                'password' => 'password123',
                'captcha_answer' => '7',
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_gagal_jika_password_salah(): void
    {
        $this->makeUser();

        $response = $this->withSession(['login_captcha_answer' => 7])
            ->post(route('login'), [
                'identifier' => 'operator.ampel',
                'password' => 'password-salah',
                'captcha_answer' => '7',
            ]);

        $response->assertSessionHasErrors('identifier');
        $this->assertGuest();
    }

    public function test_login_gagal_jika_jawaban_captcha_salah(): void
    {
        $this->makeUser();

        $response = $this->withSession(['login_captcha_answer' => 7])
            ->post(route('login'), [
                'identifier' => 'operator.ampel',
                'password' => 'password123',
                'captcha_answer' => '999',
            ]);

        $response->assertSessionHasErrors('captcha_answer');
        $this->assertGuest();
    }

    public function test_login_gagal_jika_user_tidak_aktif(): void
    {
        $user = $this->makeUser();
        $user->update(['is_active' => false]);

        $response = $this->withSession(['login_captcha_answer' => 7])
            ->post(route('login'), [
                'identifier' => 'operator.ampel',
                'password' => 'password123',
                'captcha_answer' => '7',
            ]);

        $response->assertSessionHasErrors('identifier');
        $this->assertGuest();
    }
}
