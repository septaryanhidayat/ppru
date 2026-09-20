<?php

use App\Services\IkarusDemoService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        IkarusDemoService::seedDemoArticles();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destructive reverse needed for demo articles
    }
};
