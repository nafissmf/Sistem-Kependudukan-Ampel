<?php

namespace App\Support;

use App\Enums\RoleCode;

/**
 * RBAC PERMISSION MATRIX
 * =======================================================
 * Sumber kebenaran tunggal untuk hak akses tiap role, mengikuti dokumen
 * "ROLE & PERMISSION MATRIX". Dipakai oleh:
 *  - App\Http\Middleware\EnsureModuleAccess -> menolak akses route
 *  - Gate::before() di AppServiceProvider    -> dipakai lewat @can()/authorize()
 *  - Komponen Blade sidebar/menu             -> menyembunyikan menu tak relevan
 *
 * Menambah modul baru di fase berikutnya = tinggal menambah satu baris di
 * ROLE_PERMISSIONS, tidak perlu mengubah logic middleware/komponen manapun.
 */
class Rbac
{
    private const FULL = ['create', 'read', 'update', 'delete', 'approve', 'reject', 'export', 'import', 'restore'];

    private const CRUD_NO_DELETE = ['create', 'read', 'update', 'export', 'import'];

    private const READ_ONLY = ['read'];

    private const CREATE_READ_UPDATE = ['create', 'read', 'update'];

    private const APPROVAL = ['read', 'approve', 'reject'];

    /**
     * ROLE_PERMISSIONS — turunan langsung dari dokumen Role Permission Matrix.
     *
     * - SUPER_ADMIN: akses penuh ke semua modul.
     * - OPERATOR_KECAMATAN: CRUD data inti tapi TIDAK BOLEH hapus permanen,
     *   tidak boleh ubah Role, tidak boleh hapus User.
     * - OPERATOR_DESA: hanya input data desa sendiri (scoping desa ditegakkan
     *   di Service layer, bukan di sini — matrix ini hanya soal modul+aksi).
     * - VALIDATOR_DESA: khusus modul verifikasi (approve/reject/revisi).
     * - CAMAT & KEPALA_DESA: read-only.
     */
    public static function matrix(): array
    {
        return [
            RoleCode::SuperAdmin->value => [
                'dashboard' => self::FULL, 'penduduk' => self::FULL, 'kk' => self::FULL,
                'rumah' => self::FULL, 'gis' => self::FULL, 'verifikasi' => self::FULL,
                'qr' => self::FULL, 'scan' => self::FULL, 'analytics' => self::FULL,
                'laporan' => self::FULL, 'import' => self::FULL, 'export' => self::FULL,
                'audit' => self::FULL, 'backup' => self::FULL, 'restore' => self::FULL,
                'user' => self::FULL, 'role' => self::FULL, 'permission' => self::FULL,
                'notifikasi' => self::FULL, 'setting' => self::FULL, 'profile' => self::FULL,
            ],
            RoleCode::OperatorKecamatan->value => [
                'dashboard' => self::READ_ONLY,
                'penduduk' => self::CRUD_NO_DELETE,
                'kk' => self::CRUD_NO_DELETE,
                'rumah' => self::CRUD_NO_DELETE,
                'gis' => self::READ_ONLY,
                'analytics' => self::READ_ONLY,
                'laporan' => ['read', 'export'],
                'import' => ['create', 'read'],
                'export' => ['create', 'read'],
                'qr' => ['create', 'read'],
                'audit' => self::READ_ONLY,
                'notifikasi' => self::READ_ONLY,
                'profile' => self::CREATE_READ_UPDATE,
            ],
            RoleCode::OperatorDesa->value => [
                'dashboard' => self::READ_ONLY,
                'penduduk' => self::CREATE_READ_UPDATE,
                'kk' => self::CREATE_READ_UPDATE,
                'rumah' => self::CREATE_READ_UPDATE,
                'qr' => ['create', 'read'],
                'scan' => ['create', 'read'],
                'notifikasi' => self::READ_ONLY,
                'profile' => self::CREATE_READ_UPDATE,
            ],
            RoleCode::ValidatorDesa->value => [
                'dashboard' => self::READ_ONLY,
                'verifikasi' => self::APPROVAL,
                'penduduk' => self::READ_ONLY,
                'kk' => self::READ_ONLY,
                'rumah' => self::READ_ONLY,
                'notifikasi' => self::READ_ONLY,
                'profile' => self::CREATE_READ_UPDATE,
            ],
            RoleCode::Camat->value => [
                'dashboard' => self::READ_ONLY,
                'analytics' => self::READ_ONLY,
                'gis' => self::READ_ONLY,
                'laporan' => self::READ_ONLY,
                'notifikasi' => self::READ_ONLY,
                'profile' => self::CREATE_READ_UPDATE,
            ],
            RoleCode::KepalaDesa->value => [
                'dashboard' => self::READ_ONLY,
                'laporan' => self::READ_ONLY,
                'analytics' => self::READ_ONLY,
                'notifikasi' => self::READ_ONLY,
                'profile' => self::CREATE_READ_UPDATE,
            ],
        ];
    }

    public static function has(RoleCode|string $role, string $module, string $action): bool
    {
        $roleKey = $role instanceof RoleCode ? $role->value : $role;
        $allowed = self::matrix()[$roleKey][$module] ?? [];

        return in_array($action, $allowed, true);
    }

    public static function canAccessModule(RoleCode|string $role, string $module): bool
    {
        $roleKey = $role instanceof RoleCode ? $role->value : $role;

        return ! empty(self::matrix()[$roleKey][$module] ?? []);
    }

    /**
     * Memetakan path dashboard (segmen pertama setelah /dashboard) ke nama
     * modul RBAC. Dipakai middleware untuk tahu modul apa yang sedang
     * diakses dari sebuah URL.
     */
    public static function routeModuleMap(): array
    {
        return [
            '' => 'dashboard',
            'citizens' => 'penduduk',
            'family-cards' => 'kk',
            'houses' => 'rumah',
            'gis' => 'gis',
            'verification' => 'verifikasi',
            'scanner' => 'scan',
            'analytics' => 'analytics',
            'reports' => 'laporan',
            'users' => 'user',
            'roles' => 'role',
            'permissions' => 'permission',
            'notifications' => 'notifikasi',
            'settings' => 'setting',
            'profile' => 'profile',
        ];
    }

    /** Daftar menu sidebar, masing-masing terikat ke satu modul RBAC. */
    public static function sidebarMenu(): array
    {
        return [
            ['label' => 'Dashboard', 'href' => '/dashboard', 'module' => 'dashboard', 'icon' => 'layout-dashboard'],
            ['label' => 'Penduduk', 'href' => '/citizens', 'module' => 'penduduk', 'icon' => 'users'],
            ['label' => 'Kartu Keluarga', 'href' => '/family-cards', 'module' => 'kk', 'icon' => 'id-card'],
            ['label' => 'Rumah', 'href' => '/houses', 'module' => 'rumah', 'icon' => 'home'],
            ['label' => 'Verifikasi', 'href' => '/verification', 'module' => 'verifikasi', 'icon' => 'shield-check'],
            ['label' => 'GIS', 'href' => '/gis', 'module' => 'gis', 'icon' => 'map'],
            ['label' => 'Scan QR', 'href' => '/scanner', 'module' => 'scan', 'icon' => 'qr-code'],
            ['label' => 'Analytics', 'href' => '/analytics', 'module' => 'analytics', 'icon' => 'bar-chart-3'],
            ['label' => 'Laporan', 'href' => '/reports', 'module' => 'laporan', 'icon' => 'file-text'],
            ['label' => 'Backup', 'href' => '/settings/backup', 'module' => 'backup', 'icon' => 'lock'],
            ['label' => 'Audit Log', 'href' => '/audit', 'module' => 'audit', 'icon' => 'shield-check'],
            ['label' => 'Monitoring', 'href' => '/monitoring', 'module' => 'setting', 'icon' => 'settings'],
            ['label' => 'Pengguna', 'href' => '/users', 'module' => 'user', 'icon' => 'user-cog'],
            ['label' => 'Role', 'href' => '/roles', 'module' => 'role', 'icon' => 'lock'],
            ['label' => 'Notifikasi', 'href' => '/notifications', 'module' => 'notifikasi', 'icon' => 'bell'],
            ['label' => 'Pengaturan', 'href' => '/settings', 'module' => 'setting', 'icon' => 'settings'],
        ];
    }
}
