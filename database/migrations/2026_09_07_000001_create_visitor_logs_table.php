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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('session_id', 80)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('device_type', 30)->default('Desktop')->index();
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->text('referer')->nullable();
            $table->string('referer_source', 50)->nullable()->index();
            $table->text('url')->nullable();
            $table->string('path', 255)->nullable()->index();
            $table->string('page_title', 255)->nullable();
            $table->string('country', 100)->nullable()->index();
            $table->string('country_code', 10)->nullable();
            $table->string('city', 100)->nullable()->index();
            $table->string('region', 100)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamps();

            $table->index(['created_at', 'is_bot']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
