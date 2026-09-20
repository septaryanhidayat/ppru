<?php

use App\Services\KhutbahService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            KhutbahService::ensureCategoryAndDemos();
        } catch (Throwable $e) {
            // Fail-safe silent catch if tables are still migrating
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse
    }
};
