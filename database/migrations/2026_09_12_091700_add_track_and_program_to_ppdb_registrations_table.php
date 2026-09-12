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
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->string('track', 100)->nullable()->after('phone'); // Jalur Pendaftaran
            $table->string('program_type', 100)->nullable()->after('track'); // Program (Boarding / Full Day)
            $table->string('wave', 100)->nullable()->after('program_type'); // Gelombang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['track', 'program_type', 'wave']);
        });
    }
};
