<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('login_at')->useCurrent();
            $table->timestamp('logout_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('browser', 150)->nullable();
            $table->string('device', 100)->nullable();
            $table->boolean('success')->default(true);

            $table->index('login_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
