<?php

use App\Models\Category;
use App\Models\Download;
use App\Models\Dpc;
use App\Models\NavMenu;
use App\Models\Post;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Services\VisitorTrackerService;

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
    $initialHits = VisitorTrackerService::getVisitorHits();

    // Request 1: hits awal di-increment jadi +1
    $this->get(route('home'));
    $hits1 = (int) file_get_contents($counterFile);
    expect($hits1)->toBe($initialHits + 1);

    // Request 2: hits di-increment lagi jadi +2
    $this->get(route('page.tentang-kami'));
    $hits2 = (int) file_get_contents($counterFile);
    expect($hits2)->toBe($hits1 + 1);

    // Request 3: hits di-increment lagi jadi +3
    $this->get(route('dpc.index'));
    $hits3 = (int) file_get_contents($counterFile);
    expect($hits3)->toBe($hits2 + 1);
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

test('footer memuat live counter pengunjung dan identitas pesantren', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Pondok Pesantren Raudhatul Ulum');
    $response->assertSee('Pengunjung');
    $response->assertSee('Galeri');
});

test('header navigation renders all 8 educational units linking directly to unit profile', function () {
    $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
    expect($units->count())->toBeGreaterThanOrEqual(8);

    $response = $this->get(route('home'));
    $response->assertStatus(200);

    foreach ($units as $unit) {
        $expectedUrl = route('pendidikan.show', $unit->slug);
        $response->assertSee($expectedUrl, false);

        // Verify that navigating to the unit profile page succeeds
        $unitPage = $this->get($expectedUrl);
        $unitPage->assertStatus(200);
        $unitPage->assertSee($unit->name);
    }
});

test('artikel page renders redesigned modern kategori pilihan widget', function () {
    $category = Category::firstOrCreate(['name' => 'Kabar Kampus'], ['slug' => 'kabar-kampus']);

    $response = $this->get(route('artikel.index'));
    $response->assertStatus(200);
    $response->assertSee('Kategori Pilihan');
    $response->assertSee('fa-shapes');
    $response->assertSee('Jelajahi rubrik &amp; topik', false);
    $response->assertSee(route('artikel.index', ['kategori' => $category->slug]));
});

test('unit education heads use neutral gray avatar and ignore random activity photos', function () {
    $units = UnitPendidikan::active()->get();
    expect($units->isNotEmpty())->toBeTrue();

    foreach ($units as $unit) {
        // Assert that the head_photo_url returns neutral gray avatar
        expect($unit->head_photo_url)->toContain('avatar-neutral-gray.svg');

        // Assert that visiting the unit page displays the neutral gray avatar
        $page = $this->get(route('pendidikan.show', $unit->slug));
        $page->assertStatus(200);
        $page->assertSee('avatar-neutral-gray.svg');
    }

    // Verify fallback when head_photo was set to a santri activity photo
    $testUnit = $units->first();
    $testUnit->head_photo = '/uploads/official/panahan-santri.webp';
    expect($testUnit->head_photo_url)->toBe('/uploads/avatar-neutral-gray.svg');
});

test('header navigation maintains clean 5 core desktop sections and daftar psb button', function () {
    $response = $this->get(route('home'));
    $response->assertStatus(200);

    // Desktop nav must have the 5 canonical sections
    $response->assertSee('Beranda');
    $response->assertSee('Profil');
    $response->assertSee('Pendidikan');
    $response->assertSee('Informasi');
    $response->assertSee('Layanan');
    $response->assertSee('Daftar PSB');

    // Root items in database must not have standalone Khutbah or Ikarus at top level
    $rootMenus = NavMenu::where('location', 'header')->whereNull('parent_id')->get();
    foreach ($rootMenus as $rm) {
        expect($rm->name)->not->toContain('Khutbah')
            ->and($rm->name)->not->toContain('IKARUS Alumni')
            ->and($rm->url)->not->toBe('/khutbah')
            ->and($rm->url)->not->toBe('/ikarus');
    }
});

test('header navigation includes Layanan with dynamic public service submenus based on setting', function () {
    // 1. By default / when hidden (layanan_sewa_active = 0): only 2 public services shown
    Setting::set('layanan_sewa_active', '0', 'layanan');
    $responseDefault = $this->get(route('home'));
    $responseDefault->assertStatus(200);
    $responseDefault->assertSee('2 Layanan Publik');
    $responseDefault->assertSee('Izin Kunjungan Sekolah');
    $responseDefault->assertSee('Permohonan Kerja Sama');
    $responseDefault->assertDontSee('Sewa Fasilitas &amp; Sarana', false);

    // 2. When enabled (layanan_sewa_active = 1): 3 public services shown
    Setting::set('layanan_sewa_active', '1', 'layanan');
    $response = $this->get(route('home'));
    $response->assertStatus(200);

    // 3 Layanan Publik must be rendered in Layanan menu
    $response->assertSee('3 Layanan Publik');
    $response->assertSee('Izin Kunjungan Sekolah');
    $response->assertSee(route('layanan.izin'));
    $response->assertSee('Permohonan Kerja Sama');
    $response->assertSee(route('layanan.kerjasama'));
    $response->assertSee('Sewa Fasilitas &amp; Sarana', false);
    $response->assertSee(route('layanan.sewa'));
    $response->assertSee('Portal Layanan Terpadu');
    $response->assertSee(route('layanan.index'));

    // Test that redirect from /layanan works
    $redirectResponse = $this->get('/layanan');
    $redirectResponse->assertRedirect(route('layanan.index'));

    // Test that all 3 public service pages load successfully when active
    $izinPage = $this->get(route('layanan.izin'));
    $izinPage->assertStatus(200);

    $kerjasamaPage = $this->get(route('layanan.kerjasama'));
    $kerjasamaPage->assertStatus(200);

    $sewaPage = $this->get(route('layanan.sewa'));
    $sewaPage->assertStatus(200);

    // Database test: Layanan root menu has 3 public services as children
    $layananMenu = NavMenu::where('location', 'header')
        ->whereNull('parent_id')
        ->where('name', 'Layanan')
        ->with('children')
        ->first();

    expect($layananMenu)->not->toBeNull();
    $childUrls = $layananMenu->children->pluck('url')->all();
    expect($childUrls)->toContain('/izin-sekolah')
        ->and($childUrls)->toContain('/permohonan-kerja-sama')
        ->and($childUrls)->toContain('/sewa-barang');
});
