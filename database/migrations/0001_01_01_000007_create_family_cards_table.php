<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number', 20)->unique(); // Nomor KK, 16 digit

            // FK ke citizens ditambahkan di migration terpisah SETELAH
            // tabel citizens ada (lihat catatan circular FK di migration
            // create_houses_table — kasus yang sama terjadi di sini).
            $table->uuid('head_citizen_id')->nullable();

            $table->foreignUuid('house_id')->nullable()->references('id')->on('houses')->nullOnDelete();

            $table->string('address', 255)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->foreignUuid('province_id')->nullable()->references('id')->on('provinces')->nullOnDelete();
            $table->foreignUuid('regency_id')->nullable()->references('id')->on('regencies')->nullOnDelete();
            $table->foreignUuid('district_id')->nullable()->references('id')->on('districts')->nullOnDelete();
            $table->foreignUuid('village_id')->nullable()->references('id')->on('villages')->nullOnDelete();
            $table->foreignUuid('hamlet_id')->nullable()->references('id')->on('hamlets')->nullOnDelete();
            $table->foreignUuid('rt_rw_id')->nullable()->references('id')->on('rt_rw')->nullOnDelete();

            $table->string('qr_code', 100)->nullable()->unique();
            $table->string('barcode', 100)->nullable()->unique();

            $table->string('verification_status', 20)->default('PENDING');
            $table->date('issued_date')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_cards');
    }
};
