<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

test('ikarus alumni page loads successfully with 200 ok and correct elements', function () {
    $response = $this->get(route('ikarus.index'));

    $response->assertStatus(200);
    $response->assertSee('IKARUS');
    $response->assertSee('Ikatan Keluarga Alumni Raudhatul Ulum');
    $response->assertSee('Karya &amp; Kabar Alumni', false);
    $response->assertSee('Ketik judul, topik, atau nama penulis alumni...');
    $response->assertSee('Punya Tulisan, Opini, atau Liputan Reuni Alumni?');
    $response->assertSee('Kirim Naskah via WhatsApp');
});

test('ikarus category exists in database', function () {
    $category = Category::where('slug', 'ikarus')->first();

    expect($category)->not->toBeNull()
        ->and($category->slug)->toBe('ikarus')
        ->and($category->name)->toBe('IKARUS');
});

test('post tagged with ikarus category automatically appears on ikarus page', function () {
    $author = User::first() ?? User::factory()->create();
    $ikarusCategory = Category::firstOrCreate(
        ['slug' => 'ikarus'],
        ['name' => 'IKARUS', 'is_active' => true]
    );

    $uniqueTitle = 'Kisah Inspiratif Santri Mengabdi di Pelosok Nusantara - '.uniqid();
    $post = Post::create([
        'title' => $uniqueTitle,
        'slug' => Str::slug($uniqueTitle),
        'content' => 'Dedikasi tanpa batas alumni PPRU berkhidmah untuk ummat dan bangsa.',
        'excerpt' => 'Catatan perjalanan khidmah alumni Raudhatul Ulum di perbatasan.',
        'type' => 'berita',
        'status' => 'published',
        'author_id' => $author->id,
        'published_at' => now(),
    ]);

    $post->categories()->attach($ikarusCategory->id);

    $response = $this->get(route('ikarus.index'));
    $response->assertStatus(200);
    $response->assertSee($uniqueTitle);
});

test('post without ikarus category does not appear on ikarus page', function () {
    $author = User::first() ?? User::factory()->create();
    $generalCategory = Category::firstOrCreate(
        ['slug' => 'kabar-umum'],
        ['name' => 'Kabar Umum', 'is_active' => true]
    );

    $nonIkarusTitle = 'Agenda Pengajian Rutin Khusus Wali Santri - '.uniqid();
    $post = Post::create([
        'title' => $nonIkarusTitle,
        'slug' => Str::slug($nonIkarusTitle),
        'content' => 'Pengajian rutin wali santri di Masjid Pondok Pesantren Raudhatul Ulum.',
        'excerpt' => 'Undangan terbuka pengajian bulanan wali santri.',
        'type' => 'berita',
        'status' => 'published',
        'author_id' => $author->id,
        'published_at' => now(),
    ]);

    $post->categories()->attach($generalCategory->id);

    $response = $this->get(route('ikarus.index'));
    $response->assertStatus(200);
    $response->assertDontSee($nonIkarusTitle);
});

test('redirect aliases redirect to ikarus page', function () {
    $aliases = [
        '/alumni',
        '/alumni-ru',
        '/karya-alumni',
        '/alumni-ikarus',
        '/kategori/ikarus',
    ];

    foreach ($aliases as $alias) {
        $response = $this->get($alias);
        $response->assertRedirect(route('ikarus.index'));
    }
});

test('search query filters posts on ikarus page', function () {
    $author = User::first() ?? User::factory()->create();
    $ikarusCategory = Category::where('slug', 'ikarus')->first();

    $uniqueKeyword = 'MutholaahKitabKuning'.rand(1000, 9999);
    $matchedTitle = "Karya Santri Alumni: {$uniqueKeyword}";
    $post = Post::create([
        'title' => $matchedTitle,
        'slug' => Str::slug($matchedTitle),
        'content' => 'Ulasan mendalam kitab klasik oleh alumni pesantren.',
        'excerpt' => 'Ringkasan mutholaah kitab.',
        'type' => 'berita',
        'status' => 'published',
        'author_id' => $author->id,
        'published_at' => now(),
    ]);
    $post->categories()->attach($ikarusCategory->id);

    $searchResponse = $this->get(route('ikarus.index', ['q' => $uniqueKeyword]));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee($matchedTitle);

    $emptySearchResponse = $this->get(route('ikarus.index', ['q' => 'KeywordNonExistentStringXYZ123']));
    $emptySearchResponse->assertStatus(200);
    $emptySearchResponse->assertSee('Tidak Ada Arsip yang Sesuai');
    $emptySearchResponse->assertDontSee($matchedTitle);
});

test('ikarus archive filters by rubrik berita and tulisan correctly', function () {
    $responseBerita = $this->get(route('ikarus.index', ['jenis' => 'berita']));
    $responseBerita->assertStatus(200);
    $responseBerita->assertSee('Berita IKARUS');

    $responseTulisan = $this->get(route('ikarus.index', ['jenis' => 'tulisan']));
    $responseTulisan->assertStatus(200);
    $responseTulisan->assertSee('Karya Alumni');
});

test('ikarus archive filters by year correctly', function () {
    $response2026 = $this->get(route('ikarus.index', ['tahun' => '2026']));
    $response2026->assertStatus(200);

    $response2025 = $this->get(route('ikarus.index', ['tahun' => '2025']));
    $response2025->assertStatus(200);
});

test('ikarus demo articles can be viewed on detail page without 404', function () {
    $demoSlug = 'reuni-akbar-2026-dan-musyawarah-nasional-ikarus-luncurkan-dana-abadi-santri';
    $response = $this->get(route('artikel.show', $demoSlug));
    $response->assertStatus(200);
    $response->assertSee('Reuni Akbar 2026');
});

test('ikarus navigation menu is present on public pages', function () {
    $response = $this->get(route('home'));
    $response->assertStatus(200);
    $response->assertSee(route('ikarus.index'));
    $response->assertSee('IKARUS');
});
