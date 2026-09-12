<?php

use App\Models\Category;
use App\Models\Download;
use App\Models\Dpc;
use App\Models\Post;

test('halaman program unggulan / dpc menampilkan program sekolah', function () {
    Dpc::create([
        'name' => 'Program Tahfidz Mutqin 30 Juz',
        'slug' => 'program-tahfidz-mutqin-30-juz',
        'head_name' => 'Ustadz Salman',
        'address' => 'Kurikulum Khusus Diniyah',
        'description' => 'Bimbingan intensif menghafal Al-Qur\'an.',
    ]);

    $response = $this->get(route('dpc.index'));

    $response->assertStatus(200);
    $response->assertSee('Program Tahfidz Mutqin 30 Juz');
    $response->assertDontSee('Ketua:');
});

test('halaman home menampilkan kabar sekolah dan showcase e-library', function () {
    $category = Category::firstOrCreate(['name' => 'Kabar Kampus'], ['slug' => 'kabar-kampus']);
    for ($i = 1; $i <= 6; $i++) {
        $post = Post::create([
            'title' => "Kabar Prestasi Sekolah $i",
            'slug' => "kabar-prestasi-sekolah-$i",
            'type' => 'post',
            'status' => 'publish',
            'content' => "Konten Berita Uji Coba $i",
            'excerpt' => "Cuplikan Berita Uji Coba $i",
            'published_at' => now(),
        ]);
        $post->categories()->attach($category->id);
    }

    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('E-Library & Modul Siswa');
    $response->assertSee(route('download.ebook'));
    $response->assertSee('gtranslate_wrapper');
    $response->assertSee('back-to-top');
});

test('counter pengunjung bertambah pada setiap request get web', function () {
    $counterFile = storage_path('app/visitor_hits.txt');
    @unlink($counterFile);

    // Request 1: hits awal (12850) di-increment jadi 12851
    $this->get(route('home'));
    $hits1 = (int) file_get_contents($counterFile);
    expect($hits1)->toBe(12851);

    // Request 2: hits di-increment lagi jadi 12852
    $this->get(route('page.tentang-kami'));
    $hits2 = (int) file_get_contents($counterFile);
    expect($hits2)->toBe(12852);

    // Request 3: hits di-increment lagi jadi 12853
    $this->get(route('dpc.index'));
    $hits3 = (int) file_get_contents($counterFile);
    expect($hits3)->toBe(12853);
});

test('halaman download ebook memuat tombol unduh modul', function () {
    Download::create([
        'title' => 'Panduan Mutqin Tahfidz & Ziyadah Qur\'an',
        'category_type' => 'E-Book',
        'file_path' => '/uploads/downloads/panduan-mutqin-tahfidz-ishum.pdf',
        'file_type' => 'PDF',
        'file_size' => '2.4 MB',
        'download_count' => 120,
        'cover_image' => '/uploads/covers/cover-tahfidz-mutqin.webp',
        'description' => 'Buku panduan kurikulum tahfidz mutqin.',
    ]);

    $response = $this->get(route('download.ebook'));

    $response->assertStatus(200);
    $response->assertSee('Panduan Mutqin Tahfidz');
    $response->assertSee('Download Modul (PDF)');
});

test('footer memuat live counter pengunjung dan copyright sekolah', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('SMA Islam Terpadu Ishlahul Ummah Prabumulih');
    $response->assertSee('Pengunjung');
    $response->assertSee('Galeri');
    $response->assertSee('Kabar Sekolah');
});
