<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('recipient', 150);
            $table->string('subject', 255);
            $table->string('status', 20)->default('SENT'); // SENT, FAILED
            $table->timestamp('sent_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
