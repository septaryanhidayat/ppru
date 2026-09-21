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
        if (! Schema::hasTable('hero_slides')) {
            Schema::create('hero_slides', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('subtitle')->nullable();
                $table->string('badge')->nullable()->default('Pondok Pesantren Raudhatul Ulum Sakatiga');
                $table->string('image')->default('/uploads/official/drone-raudhatul-ulum.webp');
                $table->string('btn_primary_text')->nullable()->default('Profil Singkat Pesantren');
                $table->string('btn_primary_url')->nullable()->default('/tentang-kami');
                $table->string('btn_secondary_text')->nullable()->default('Pendaftaran PSB');
                $table->string('btn_secondary_url')->nullable()->default('/ppdb');
                $table->integer('order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
