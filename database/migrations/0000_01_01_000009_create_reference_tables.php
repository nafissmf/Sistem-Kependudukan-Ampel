<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mengikuti dokumen "MASTER REFERENCE": tabel-tabel kecil berisi data
     * acuan yang jarang berubah (agama, pendidikan, pekerjaan, dst).
     * Digabung dalam satu file migration karena strukturnya identik
     * (id, code, name) dan secara konseptual satu kesatuan "data acuan" —
     * bukan kelalaian, tapi pilihan sadar supaya tidak ada 11 file
     * migration nyaris kosong untuk hal yang sama.
     */
    public function up(): void
    {
        $referenceTable = function (string $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('code', 30)->unique();
                $table->string('name', 100);
                $table->unsignedSmallInteger('sort_order')->default(0);
                $table->timestamps();
            });
        };

        $referenceTable('religions'); // agama
        $referenceTable('educations'); // pendidikan
        $referenceTable('occupations'); // pekerjaan
        $referenceTable('marital_statuses'); // status_perkawinan
        $referenceTable('blood_types'); // golongan_darah
        $referenceTable('family_relationships'); // hubungan_keluarga
        $referenceTable('citizen_statuses'); // status_penduduk (aktif, pindah, meninggal, dll)
        $referenceTable('house_statuses'); // status_rumah
        $referenceTable('floor_types'); // jenis_lantai
        $referenceTable('roof_types'); // jenis_atap
        $referenceTable('wall_types'); // jenis_dinding
    }

    public function down(): void
    {
        Schema::dropIfExists('religions');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('occupations');
        Schema::dropIfExists('marital_statuses');
        Schema::dropIfExists('blood_types');
        Schema::dropIfExists('family_relationships');
        Schema::dropIfExists('citizen_statuses');
        Schema::dropIfExists('house_statuses');
        Schema::dropIfExists('floor_types');
        Schema::dropIfExists('roof_types');
        Schema::dropIfExists('wall_types');
    }
};
