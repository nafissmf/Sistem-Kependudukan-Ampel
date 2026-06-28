<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('province_id')->references('id')->on('provinces')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('code', 10)->unique();
            $table->string('name', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regencies');
    }
};
