<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->foreignUuid('family_card_id')->references('id')->on('family_cards')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('citizen_id')->references('id')->on('citizens')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('relationship_id')->nullable()->references('id')->on('family_relationships')->nullOnDelete();
            $table->timestamps();

            $table->primary(['family_card_id', 'citizen_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
