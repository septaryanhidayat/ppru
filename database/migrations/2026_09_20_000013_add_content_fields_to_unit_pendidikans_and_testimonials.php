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
        // 1. Unit Pendidikans table additional rich content fields
        if (Schema::hasTable('unit_pendidikans')) {
            Schema::table('unit_pendidikans', function (Blueprint $table) {
                if (! Schema::hasColumn('unit_pendidikans', 'sambutan')) {
                    $table->longText('sambutan')->nullable()->after('description');
                }
                if (! Schema::hasColumn('unit_pendidikans', 'visi')) {
                    $table->text('visi')->nullable()->after('sambutan');
                }
                if (! Schema::hasColumn('unit_pendidikans', 'misi')) {
                    $table->text('misi')->nullable()->after('visi');
                }
                if (! Schema::hasColumn('unit_pendidikans', 'hero_image')) {
                    $table->string('hero_image')->nullable()->after('thumbnail');
                }
                if (! Schema::hasColumn('unit_pendidikans', 'head_photo')) {
                    $table->string('head_photo')->nullable()->after('head_name');
                }
            });
        }

        // 2. Testimonials unit scoping
        if (Schema::hasTable('testimonials') && ! Schema::hasColumn('testimonials', 'unit_pendidikan_id')) {
            Schema::table('testimonials', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                $table->index('unit_pendidikan_id');
            });
        }

        // 3. Dewan Asatidz unit linking
        if (Schema::hasTable('dewan_asatidz') && ! Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id')) {
            Schema::table('dewan_asatidz', function (Blueprint $table) {
                $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                $table->index('unit_pendidikan_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe migration
    }
};
