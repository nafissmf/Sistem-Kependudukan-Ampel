<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Lihat catatan circular FK di migration create_family_cards_table. */
    public function up(): void
    {
        Schema::table('family_cards', function (Blueprint $table) {
            $table->foreign('head_citizen_id')->references('id')->on('citizens')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('family_cards', function (Blueprint $table) {
            $table->dropForeign(['head_citizen_id']);
        });
    }
};
