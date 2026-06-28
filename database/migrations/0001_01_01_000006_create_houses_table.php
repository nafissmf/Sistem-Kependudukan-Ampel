<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * CATATAN DESAIN: dokumen brief menulis relasi houses <-> family_cards
     * secara dua arah (family_cards.houseId DAN houses.familyCardId),
     * yang kalau diikuti persis akan jadi circular foreign key. Kita
     * sederhanakan: FK hanya satu arah, di family_cards.house_id
     * (lihat migration create_family_cards_table). Relasi tetap 1:1
     * secara logis, hanya arah FK-nya yang dirapikan.
     */
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('house_number', 30)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('gps_accuracy', 8, 2)->nullable();
            $table->string('address', 255)->nullable();

            $table->foreignUuid('province_id')->nullable()->references('id')->on('provinces')->nullOnDelete();
            $table->foreignUuid('regency_id')->nullable()->references('id')->on('regencies')->nullOnDelete();
            $table->foreignUuid('district_id')->nullable()->references('id')->on('districts')->nullOnDelete();
            $table->foreignUuid('village_id')->nullable()->references('id')->on('villages')->nullOnDelete();
            $table->foreignUuid('hamlet_id')->nullable()->references('id')->on('hamlets')->nullOnDelete();
            $table->foreignUuid('rt_rw_id')->nullable()->references('id')->on('rt_rw')->nullOnDelete();

            $table->decimal('land_area', 8, 2)->nullable(); // luas tanah (m2)
            $table->decimal('building_area', 8, 2)->nullable(); // luas bangunan (m2)
            $table->foreignUuid('roof_type_id')->nullable()->references('id')->on('roof_types')->nullOnDelete();
            $table->foreignUuid('wall_type_id')->nullable()->references('id')->on('wall_types')->nullOnDelete();
            $table->foreignUuid('floor_type_id')->nullable()->references('id')->on('floor_types')->nullOnDelete();
            $table->unsignedTinyInteger('bedroom_count')->nullable();
            $table->unsignedTinyInteger('bathroom_count')->nullable();
            $table->string('photo', 500)->nullable();
            $table->string('google_map_url', 500)->nullable();

            $table->foreignUuid('house_status_id')->nullable()->references('id')->on('house_statuses')->nullOnDelete();

            // Status pengajuan/verifikasi (lihat App\Enums\VerificationStatus)
            $table->string('verification_status', 20)->default('PENDING');

            $table->string('qr_code', 100)->nullable()->unique();
            $table->string('barcode', 100)->nullable()->unique();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
