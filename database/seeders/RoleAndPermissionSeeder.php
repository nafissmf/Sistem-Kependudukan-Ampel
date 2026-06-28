<?php

namespace Database\Seeders;

use App\Enums\RoleCode;
use App\Models\Permission;
use App\Models\Role;
use App\Support\Rbac;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding roles...');

        /** @var array<string, Role> $roles */
        $roles = [];
        foreach (RoleCode::cases() as $code) {
            $roles[$code->value] = Role::updateOrCreate(
                ['code' => $code],
                ['name' => $code->label(), 'description' => $code->description()],
            );
        }

        $this->command->info('🌱 Seeding permissions...');

        // Kumpulkan semua kombinasi (module, action) unik yang dipakai di
        // Rbac::matrix(), supaya tabel `permissions` selalu sinkron dengan
        // app/Support/Rbac.php (satu sumber kebenaran).
        $uniqueCombos = [];
        foreach (Rbac::matrix() as $permMap) {
            foreach ($permMap as $module => $actions) {
                foreach ($actions as $action) {
                    $uniqueCombos["{$module}:{$action}"] = [$module, $action];
                }
            }
        }

        /** @var array<string, Permission> $permissions */
        $permissions = [];
        foreach ($uniqueCombos as $key => [$module, $action]) {
            $permissions[$key] = Permission::updateOrCreate(
                ['module' => $module, 'action' => $action],
                ['name' => "{$action} {$module}"],
            );
        }

        $this->command->info('🌱 Linking role <-> permission...');

        foreach (Rbac::matrix() as $roleCode => $permMap) {
            $role = $roles[$roleCode];
            $permissionIds = [];

            foreach ($permMap as $module => $actions) {
                foreach ($actions as $action) {
                    $permissionIds[] = $permissions["{$module}:{$action}"]->id;
                }
            }

            $role->permissions()->sync($permissionIds);
        }
    }
}
