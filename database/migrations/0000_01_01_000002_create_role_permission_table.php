<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignUuid('role_id')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('permission_id')->references('id')->on('permissions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->primary(['role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
