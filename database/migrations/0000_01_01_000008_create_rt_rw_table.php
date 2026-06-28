<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rt_rw', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('hamlet_id')->references('id')->on('hamlets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['hamlet_id', 'rt', 'rw']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rt_rw');
    }
};
