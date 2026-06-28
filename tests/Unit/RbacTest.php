<?php

namespace Tests\Unit;

use App\Enums\RoleCode;
use App\Support\Rbac;
use PHPUnit\Framework\TestCase;

class RbacTest extends TestCase
{
    public function test_super_admin_dapat_melakukan_apa_saja_pada_modul_user(): void
    {
        $this->assertTrue(Rbac::has(RoleCode::SuperAdmin, 'user', 'delete'));
        $this->assertTrue(Rbac::has(RoleCode::SuperAdmin, 'user', 'create'));
    }

    public function test_operator_kecamatan_tidak_boleh_menghapus_user(): void
    {
        // Sesuai brief: Operator Kecamatan tidak boleh hapus permanen.
        $this->assertFalse(Rbac::has(RoleCode::OperatorKecamatan, 'user', 'delete'));
    }

    public function test_operator_kecamatan_boleh_crud_penduduk_kecuali_delete(): void
    {
        $this->assertTrue(Rbac::has(RoleCode::OperatorKecamatan, 'penduduk', 'create'));
        $this->assertTrue(Rbac::has(RoleCode::OperatorKecamatan, 'penduduk', 'update'));
        $this->assertFalse(Rbac::has(RoleCode::OperatorKecamatan, 'penduduk', 'delete'));
    }

    public function test_camat_hanya_boleh_membaca_di_semua_modul_yang_dimilikinya(): void
    {
        $this->assertTrue(Rbac::has(RoleCode::Camat, 'analytics', 'read'));
        $this->assertFalse(Rbac::has(RoleCode::Camat, 'analytics', 'update'));
        $this->assertFalse(Rbac::canAccessModule(RoleCode::Camat, 'user'));
    }

    public function test_validator_desa_dapat_approve_reject_tapi_tidak_crud_penduduk(): void
    {
        $this->assertTrue(Rbac::has(RoleCode::ValidatorDesa, 'verifikasi', 'approve'));
        $this->assertTrue(Rbac::has(RoleCode::ValidatorDesa, 'verifikasi', 'reject'));
        $this->assertFalse(Rbac::has(RoleCode::ValidatorDesa, 'penduduk', 'create'));
    }

    public function test_role_yang_tidak_punya_modul_mengembalikan_false_bukan_error(): void
    {
        $this->assertFalse(Rbac::has(RoleCode::KepalaDesa, 'backup', 'read'));
    }

    public function test_bisa_menerima_string_role_code_selain_enum(): void
    {
        $this->assertTrue(Rbac::has('SUPER_ADMIN', 'user', 'delete'));
        $this->assertFalse(Rbac::has('ROLE_TIDAK_ADA', 'user', 'delete'));
    }
}
