<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('phone', 20);
            $table->text('message');
            $table->string('status', 20)->default('SENT'); // SENT, FAILED
            $table->timestamp('sent_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
