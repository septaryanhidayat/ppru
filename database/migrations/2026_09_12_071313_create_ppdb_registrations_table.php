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
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 50)->unique();
            $table->string('full_name', 255);
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('gender', 20); // Laki-laki / Perempuan
            $table->text('address');
            $table->string('living_with', 100)->default('Orang Tua');
            $table->integer('child_order')->nullable();
            $table->integer('siblings_count')->nullable();
            $table->string('previous_school', 255);
            $table->string('nisn', 50)->nullable();
            $table->string('hobby', 255)->nullable();
            $table->string('favorite_subject', 255)->nullable();
            $table->string('ambition', 255)->nullable();
            $table->text('achievements')->nullable();
            $table->string('phone', 50);

            // Data Ayah / Wali
            $table->string('father_name', 255);
            $table->string('father_birth_place', 100)->nullable();
            $table->date('father_birth_date')->nullable();
            $table->text('father_address')->nullable();
            $table->string('father_education', 100)->nullable();
            $table->string('father_job', 100)->nullable();
            $table->string('father_income', 100)->nullable();
            $table->string('father_phone', 50)->nullable();

            // Data Ibu / Wali
            $table->string('mother_name', 255);
            $table->string('mother_birth_place', 100)->nullable();
            $table->date('mother_birth_date')->nullable();
            $table->text('mother_address')->nullable();
            $table->string('mother_education', 100)->nullable();
            $table->string('mother_job', 100)->nullable();
            $table->string('mother_income', 100)->nullable();
            $table->string('mother_phone', 50)->nullable();

            // Berkas Pendaftaran
            $table->string('birth_certificate_path', 255)->nullable();
            $table->string('payment_proof_path', 255)->nullable();

            // Status Pendaftaran
            $table->string('status', 50)->default('pending'); // pending, verified, accepted, rejected
            $table->string('academic_year', 20)->default('2026/2027');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
