<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('module', 50)->index();
            $table->string('action', 30); // LOGIN, LOGOUT, CREATE, UPDATE, DELETE, RESTORE, APPROVE, REJECT, IMPORT, EXPORT, BACKUP, PRINT
            $table->json('old_value')->nullable();
            $table->json('new_value')->nullable();
            $table->string('browser', 150)->nullable();
            $table->string('platform', 100)->nullable();
            $table->string('device', 100)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('location', 150)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
