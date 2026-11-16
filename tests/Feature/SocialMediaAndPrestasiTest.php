<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin dashboard provides shortcuts for social media and prestasi santri', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin_test@ppru.ac.id'],
        ['name' => 'Admin Test', 'password' => Hash::make('password123')]
    );

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Prestasi Santri');
    $response->assertSee(route('admin.posts.index', ['type' => 'prestasi']));
    $response->assertSee('Media Sosial');
    $response->assertSee(route('admin.settings.index').'#social-media');
});

test('admin can update social media settings and they appear in footer', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin_test@ppru.ac.id'],
        ['name' => 'Admin Test', 'password' => Hash::make('password123')]
    );

    $postData = [
        'site_title' => 'Pondok Pesantren Raudhatul Ulum Sakatiga',
        'social_facebook' => 'https://facebook.com/ppru_custom',
        'social_instagram' => 'https://instagram.com/ppru_custom',
        'social_youtube' => 'https://youtube.com/@ppru_custom',
        'social_tiktok' => 'https://tiktok.com/@ppru_custom',
        'social_whatsapp' => '081234567890',
        'social_twitter' => 'https://x.com/ppru_custom',
        'social_telegram' => 'https://t.me/ppru_custom',
        'social_threads' => 'https://threads.net/@ppru_custom',
    ];

    $response = $this->actingAs($admin)->post(route('admin.settings.update'), $postData);
    $response->assertSessionHas('success');

    $homeResponse = $this->get('/');
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('https://facebook.com/ppru_custom');
    $homeResponse->assertSee('https://instagram.com/ppru_custom');
    $homeResponse->assertSee('https://youtube.com/@ppru_custom');
    $homeResponse->assertSee('https://tiktok.com/@ppru_custom');
    $homeResponse->assertSee('6281234567890');
    $homeResponse->assertSee('https://x.com/ppru_custom');
    $homeResponse->assertSee('https://t.me/ppru_custom');
    $homeResponse->assertSee('https://threads.net/@ppru_custom');
});

test('prestasi section on homepage only displays actual prestasi without unrelated news fallback', function () {
    // Buat post berita biasa (tanpa kategori prestasi)
    $beritaBiasa = Post::create([
        'title' => 'Rapat Evaluasi Semester Santri Baru 2026',
        'slug' => 'rapat-evaluasi-semester-santri-baru-2026',
        'type' => 'post',
        'status' => 'publish',
        'content' => 'Rapat internal asatidz.',
        'published_at' => now(),
    ]);

    // Buat post prestasi santri (type = prestasi)
    $prestasiSantri = Post::create([
        'title' => 'Juara 1 Lomba Pidato Bahasa Arab Internasional 2026',
        'slug' => 'juara-1-lomba-pidato-bahasa-arab-internasional-2026',
        'type' => 'prestasi',
        'status' => 'publish',
        'content' => 'Santri meraih medali emas.',
        'published_at' => now(),
    ]);

    $response = $this->get('/');
    $response->assertStatus(200);

    // Bagian Capaian Membanggakan harus melihat prestasi santri dan link yang benar
    $response->assertSee('Juara 1 Lomba Pidato Bahasa Arab Internasional 2026');
    $response->assertSee(route('prestasi.show', 'juara-1-lomba-pidato-bahasa-arab-internasional-2026'));

    // Halaman show artikel juga dapat membuka post prestasi tanpa 404
    $showResponse = $this->get(route('artikel.show', 'juara-1-lomba-pidato-bahasa-arab-internasional-2026'));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Juara 1 Lomba Pidato Bahasa Arab Internasional 2026');
});
