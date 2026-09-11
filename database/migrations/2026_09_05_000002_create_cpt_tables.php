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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('status')->default('publish');
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });

        Schema::create('pengumumen', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('file_attachment')->nullable();
            $table->string('status')->default('publish');
            $table->string('featured_image')->nullable();
            $table->timestamps();
        });

        Schema::create('anggota_dewans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('position'); // e.g. Ketua Fraksi PKS DPRD OI
            $table->string('fraction')->nullable()->default('Fraksi PKS');
            $table->text('profile_summary')->nullable();
            $table->text('education')->nullable();
            $table->string('photo')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('icon')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('dpcs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('head_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profession')->nullable();
            $table->text('content');
            $table->string('photo')->nullable();
            $table->string('status')->default('publish');
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('youtube_url');
            $table->string('youtube_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category_type')->default('Dokumen'); // Logo, MP3, E-Book, Leaflet, Dokumen
            $table->string('file_path');
            $table->string('file_type')->nullable(); // PNG, MP3, PDF, etc.
            $table->string('file_size')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->timestamps();
        });

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('message');
            $table->string('status')->default('unread'); // unread, read, archived
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('downloads');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('dpcs');
        Schema::dropIfExists('bidangs');
        Schema::dropIfExists('anggota_dewans');
        Schema::dropIfExists('pengumumen');
        Schema::dropIfExists('agendas');
    }
};
