<?php

use App\Models\HomeStatistic;
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
        if (! Schema::hasTable('home_statistics')) {
            Schema::create('home_statistics', function (Blueprint $table) {
                $table->id();
                $table->string('number');
                $table->string('label');
                $table->string('description')->nullable();
                $table->string('icon')->nullable()->default('fa-solid fa-chart-simple');
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Seed initial 4 statistics matching the official design
        if (HomeStatistic::count() === 0) {
            $defaultStats = [
                [
                    'number' => '3.500+',
                    'label' => 'SANTRI AKTIF MUKIM',
                    'description' => 'Dari berbagai provinsi nusantara',
                    'icon' => 'fa-solid fa-users',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'number' => '15.000+',
                    'label' => 'ALUMNI BERKHIDMAT',
                    'description' => 'Kiprah dakwah nasional & global',
                    'icon' => 'fa-solid fa-user-graduate',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'number' => '100%',
                    'label' => 'MUADALAH AL-AZHAR',
                    'description' => 'Akses studi langsung ke Mesir & Timur Tengah',
                    'icon' => 'fa-solid fa-certificate',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'number' => '75+',
                    'label' => 'TAHUN PENGABDIAN',
                    'description' => 'Sejak 1950 di bumi Sakatiga Mekkah Kecil',
                    'icon' => 'fa-solid fa-landmark',
                    'order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($defaultStats as $stat) {
                HomeStatistic::create($stat);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_statistics');
    }
};
