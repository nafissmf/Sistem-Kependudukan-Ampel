<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Extends Tests\TestCase (bukan PHPUnit murni) karena butuh bootstrap
 * Laravel agar facade Hash:: bisa di-resolve dari container.
 */
class PasswordHashingTest extends TestCase
{
    public function test_hash_tidak_pernah_sama_dengan_plain_text(): void
    {
        $hash = Hash::make('SuperSecret123');

        $this->assertNotEquals('SuperSecret123', $hash);
        $this->assertGreaterThan(20, strlen($hash));
    }

    public function test_hash_check_mengembalikan_true_untuk_password_yang_benar(): void
    {
        $hash = Hash::make('SuperSecret123');

        $this->assertTrue(Hash::check('SuperSecret123', $hash));
    }

    public function test_hash_check_mengembalikan_false_untuk_password_yang_salah(): void
    {
        $hash = Hash::make('SuperSecret123');

        $this->assertFalse(Hash::check('PasswordSalah', $hash));
    }

    public function test_dua_hash_dari_password_yang_sama_tetap_berbeda_karena_salt_acak(): void
    {
        $hashA = Hash::make('SamaSamaIni');
        $hashB = Hash::make('SamaSamaIni');

        $this->assertNotEquals($hashA, $hashB);
    }
}
