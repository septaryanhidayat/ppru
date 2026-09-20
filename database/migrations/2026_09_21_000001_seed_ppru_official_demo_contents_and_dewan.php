<?php

use App\Services\CmsAutoHealService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jalankan auto-heal resmi agar langsung aktif di MySQL cPanel saat `php artisan migrate --force`
        CmsAutoHealService::ensureOfficialDemoContentsSeeded();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
