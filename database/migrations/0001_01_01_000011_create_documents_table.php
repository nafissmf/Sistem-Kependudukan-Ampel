<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('citizen_id')->nullable()->references('id')->on('citizens')->cascadeOnDelete();
            $table->foreignUuid('family_card_id')->nullable()->references('id')->on('family_cards')->cascadeOnDelete();
            $table->foreignUuid('house_id')->nullable()->references('id')->on('houses')->cascadeOnDelete();
            $table->string('type', 30); // KTP, KK, AKTA, IJAZAH, FOTO, dst
            $table->string('filename', 255);
            $table->string('path', 500);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable(); // bytes
            $table->foreignUuid('uploaded_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
