<?php

use App\Models\NavMenu;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        NavMenu::where('url', '/khutbah')
            ->orWhere('url', '/kategori/taujih')
            ->orWhere('name', 'like', '%Khutbah%')
            ->update(['name' => "Tausiyah & Khutbah Jum'at"]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
