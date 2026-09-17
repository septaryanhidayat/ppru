<?php

use App\Models\Post;
use App\Models\User;

test('updating static profile pages reflects immediately on public frontend', function () {
    // 1. Sambutan
    $sambutan = Post::updateOrCreate(
        ['slug' => 'sambutan-kepala-sekolah', 'type' => 'page'],
        [
            'title' => 'Sambutan Mudir PPRU Sakatiga',
            'content' => '<p>Sambutan terupdate dengan risalah terbaru santri Raudhatul Ulum.</p>',
            'status' => 'publish',
        ]
    );

    $this->get('/sambutan')
        ->assertStatus(200)
        ->assertSee('Sambutan terupdate dengan risalah terbaru santri Raudhatul Ulum.');

    // 2. Visi dan Misi
    $visiMisi = Post::updateOrCreate(
        ['slug' => 'visi-dan-misi', 'type' => 'page'],
        [
            'title' => 'Visi & Misi Terkini Pesantren',
            'content' => '<p>Visi terupdate: Menjadi pusat keunggulan pendidikan islam global terdepan.</p>',
            'status' => 'publish',
        ]
    );

    $this->get('/visi-dan-misi')
        ->assertStatus(200)
        ->assertSee('Visi terupdate: Menjadi pusat keunggulan pendidikan islam global terdepan.');

    // 3. Tentang Kami
    $tentangKami = Post::updateOrCreate(
        ['slug' => 'tentang-kami', 'type' => 'page'],
        [
            'title' => 'Tentang Pondok Pesantren Raudhatul Ulum Sakatiga',
            'content' => '<p>Profil pesantren terupdate dengan kampus terpadu 60 hektar.</p>',
            'status' => 'publish',
        ]
    );

    $this->get('/tentang-kami')
        ->assertStatus(200)
        ->assertSee('Profil pesantren terupdate dengan kampus terpadu 60 hektar.');

    // 4. Sejarah
    $sejarah = Post::updateOrCreate(
        ['slug' => 'sejarah', 'type' => 'page'],
        [
            'title' => 'Sejarah Perkembangan Pesantren',
            'content' => '<p>Sejarah terupdate: Berawal dari madrasah al-falah tahun 1930 di Sakatiga.</p>',
            'status' => 'publish',
        ]
    );

    $this->get('/sejarah')
        ->assertStatus(200)
        ->assertSee('Sejarah terupdate: Berawal dari madrasah al-falah tahun 1930 di Sakatiga.');

    // 5. Struktur Organisasi
    $struktur = Post::updateOrCreate(
        ['slug' => 'struktur-organisasi', 'type' => 'page'],
        [
            'title' => 'Struktur Kepengurusan Yayasan',
            'content' => '<p>Bagan manajemen terupdate di bawah kepemimpinan Mudir KH Tolat Wafa.</p>',
            'status' => 'publish',
        ]
    );

    $this->get('/struktur-organisasi')
        ->assertStatus(200)
        ->assertSee('Bagan manajemen terupdate di bawah kepemimpinan Mudir KH Tolat Wafa.');
});

test('admin can update page content and verify public url attribute', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $page = Post::updateOrCreate(
        ['slug' => 'visi-dan-misi', 'type' => 'page'],
        [
            'title' => 'Visi Misi Lama',
            'content' => '<p>Konten lama.</p>',
            'status' => 'publish',
        ]
    );

    // Verify public_url accessor
    expect($page->public_url)->toBe(route('page.visi-misi'));

    // Admin updates page via PUT
    $response = $this->actingAs($admin)->put(route('admin.pages.update', $page), [
        'title' => 'Visi Misi Baru 2026',
        'content' => '<p>Konten baru berhasil diupdate oleh administrator.</p>',
        'excerpt' => 'Ringkasan visi misi baru',
    ]);

    $response->assertRedirect(route('admin.pages.index'));

    // Check public page
    $this->get('/visi-dan-misi')
        ->assertStatus(200)
        ->assertSee('Konten baru berhasil diupdate oleh administrator.')
        ->assertSee('Visi Misi Baru 2026');
});
