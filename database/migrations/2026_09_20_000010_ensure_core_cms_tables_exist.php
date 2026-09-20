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
        CmsAutoHealService::ensureAllCoreTablesExist();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe migration
    }
};
