<?php

use Database\Seeders\PpruDemoContentSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jalankan seeder resmi agar langsung aktif di MySQL cPanel saat `php artisan migrate --force`
        (new PpruDemoContentSeeder)->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
