<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename', 255);
            $table->string('module', 30);
            $table->unsignedInteger('total_data')->default(0);
            $table->unsignedInteger('success')->default(0);
            $table->unsignedInteger('failed')->default(0);
            $table->foreignUuid('created_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('exports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename', 255);
            $table->string('module', 30);
            $table->string('format', 10); // pdf, xlsx, csv
            $table->foreignUuid('created_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exports');
        Schema::dropIfExists('imports');
    }
};
