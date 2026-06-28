<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Di Phase 1, users.village_id sengaja disimpan TANPA foreign key
     * (lihat komentar di migration create_users_table) karena tabel
     * `villages` belum ada. Sekarang tabel itu sudah ada (Phase 2),
     * jadi kita tegakkan integritas datanya di sini.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('village_id')->references('id')->on('villages')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['village_id']);
        });
    }
};
