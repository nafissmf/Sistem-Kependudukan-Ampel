<?php

namespace Database\Seeders;

use App\Enums\RoleCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Seeding Super Admin account...');

        $superAdminRole = Role::where('code', RoleCode::SuperAdmin)->first();

        if (! $superAdminRole) {
            $this->command->error('Role SUPER_ADMIN belum ada. Jalankan RoleAndPermissionSeeder dulu.');

            return;
        }

        $defaultPassword = env('SEED_SUPER_ADMIN_PASSWORD', 'Ampel#2026Boyolali');

        $user = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'email' => 'superadmin@sik-ampel.boyolali.go.id',
                'password' => Hash::make($defaultPassword),
                'fullname' => 'Super Administrator',
                'role_id' => $superAdminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        );

        $this->command->newLine();
        $this->command->info('✅ Seeding selesai.');
        $this->command->line('   Login Super Admin:');
        $this->command->line("   - Username : {$user->username}");
        $this->command->line("   - Password : {$defaultPassword}");
        $this->command->warn('   ⚠️  GANTI PASSWORD INI SEGERA SETELAH LOGIN PERTAMA.');
        $this->command->newLine();
    }
}
