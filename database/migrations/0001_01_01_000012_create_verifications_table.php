<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module', 30); // 'penduduk', 'kk', 'rumah'
            $table->uuid('reference_id'); // id citizen/family_card/house yang diverifikasi
            $table->foreignUuid('validator_id')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->string('status', 20); // sesuai App\Enums\VerificationStatus
            $table->text('note')->nullable();
            $table->string('signature', 500)->nullable(); // path PNG tanda tangan digital
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['module', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
