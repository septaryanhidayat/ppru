<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('anggota_dewans') && ! Schema::hasTable('dewan_asatidz')) {
            Schema::rename('anggota_dewans', 'dewan_asatidz');
        }

        if (Schema::hasTable('bidangs') && ! Schema::hasTable('fasilitas')) {
            Schema::rename('bidangs', 'fasilitas');
        }

        if (Schema::hasTable('dpcs') && ! Schema::hasTable('program_unggulans')) {
            Schema::rename('dpcs', 'program_unggulans');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('dewan_asatidz') && ! Schema::hasTable('anggota_dewans')) {
            Schema::rename('dewan_asatidz', 'anggota_dewans');
        }

        if (Schema::hasTable('fasilitas') && ! Schema::hasTable('bidangs')) {
            Schema::rename('fasilitas', 'bidangs');
        }

        if (Schema::hasTable('program_unggulans') && ! Schema::hasTable('dpcs')) {
            Schema::rename('program_unggulans', 'dpcs');
        }
    }
};
