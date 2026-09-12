<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('service_type', 50)->index(); // izin_kunjungan, kerja_sama, sewa_barang
            $table->string('name');
            $table->string('agency');
            $table->string('whatsapp', 30);
            $table->text('purpose');
            $table->string('letter_path')->nullable();
            $table->string('ktp_path')->nullable();
            $table->string('npwp_path')->nullable();
            $table->string('status', 30)->default('pending')->index(); // pending, approved, rejected, completed
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_submissions');
    }
};
