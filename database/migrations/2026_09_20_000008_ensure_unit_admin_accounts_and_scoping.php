<?php

use App\Services\UnitAccountService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        UnitAccountService::ensureUnitAccountsExist();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reversal needed for unit accounts
    }
};
