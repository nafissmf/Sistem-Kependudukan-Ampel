<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik', 16)->unique();
            $table->string('fullname', 150);
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P']); // Laki-laki / Perempuan

            $table->foreignUuid('religion_id')->nullable()->references('id')->on('religions')->nullOnDelete();
            $table->foreignUuid('education_id')->nullable()->references('id')->on('educations')->nullOnDelete();
            $table->foreignUuid('job_id')->nullable()->references('id')->on('occupations')->nullOnDelete();
            $table->foreignUuid('blood_type_id')->nullable()->references('id')->on('blood_types')->nullOnDelete();
            $table->foreignUuid('marital_status_id')->nullable()->references('id')->on('marital_statuses')->nullOnDelete();

            $table->foreignUuid('family_card_id')->nullable()->references('id')->on('family_cards')->nullOnDelete();
            $table->foreignUuid('relationship_id')->nullable()->references('id')->on('family_relationships')->nullOnDelete();

            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('photo', 500)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address', 255)->nullable();

            $table->foreignUuid('province_id')->nullable()->references('id')->on('provinces')->nullOnDelete();
            $table->foreignUuid('regency_id')->nullable()->references('id')->on('regencies')->nullOnDelete();
            $table->foreignUuid('district_id')->nullable()->references('id')->on('districts')->nullOnDelete();
            $table->foreignUuid('village_id')->nullable()->references('id')->on('villages')->nullOnDelete();
            $table->foreignUuid('hamlet_id')->nullable()->references('id')->on('hamlets')->nullOnDelete();
            $table->foreignUuid('rt_rw_id')->nullable()->references('id')->on('rt_rw')->nullOnDelete();

            $table->foreignUuid('citizen_status_id')->nullable()->references('id')->on('citizen_statuses')->nullOnDelete();
            $table->string('verification_status', 20)->default('PENDING');

            $table->boolean('is_alive')->default(true);
            $table->date('death_date')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('fullname');
            $table->index('verification_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
