<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Skema mengikuti dokumen "users" table di brief, ditambah konvensi
     * wajib seluruh project: UUID PK, soft delete, createdBy/updatedBy.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->unique();
            $table->string('email', 150)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('fullname', 150);
            $table->string('phone', 20)->unique()->nullable();
            $table->string('photo', 500)->nullable();

            $table->foreignUuid('role_id')->references('id')->on('roles')->restrictOnDelete()->cascadeOnUpdate();

            // Scope wilayah untuk Operator Desa / Kepala Desa. Akan menjadi
            // foreign key sungguhan ke tabel `villages` pada Phase 2 (Master
            // Data Wilayah). Untuk sekarang disimpan longgar (tanpa FK) agar
            // struktur RBAC tidak menunggu modul wilayah selesai dulu.
            $table->uuid('village_id')->nullable()->index();

            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
