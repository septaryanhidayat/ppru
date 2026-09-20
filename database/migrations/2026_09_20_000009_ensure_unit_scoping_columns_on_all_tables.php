<?php

use App\Services\UnitAccountService;
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
        // 1. Users table
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'unit_pendidikan_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('role');
                $table->index('unit_pendidikan_id');
            });
        }

        // 2. Posts table
        if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'unit_pendidikan_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('author_id');
                $table->index('unit_pendidikan_id');
            });
        }

        // 3. Videos table
        if (Schema::hasTable('videos') && ! Schema::hasColumn('videos', 'unit_pendidikan_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                $table->index('unit_pendidikan_id');
            });
        }

        // 4. Ensure all 8 unit admin accounts exist
        UnitAccountService::ensureUnitAccountsExist();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe migration
    }
};
