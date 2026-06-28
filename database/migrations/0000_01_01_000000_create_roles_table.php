<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dijalankan SEBELUM tabel users (lihat penamaan file: 0000_xxx vs
     * 0001_xxx) karena users.role_id punya foreign key ke tabel ini.
     *
     * Semua tabel di project ini memakai UUID sebagai primary key, sesuai
     * dokumen "DATABASE ARCHITECTURE": "Semua Primary Key menggunakan UUID."
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 30)->unique(); // SUPER_ADMIN, OPERATOR_DESA, dst — lihat App\Enums\RoleCode
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
