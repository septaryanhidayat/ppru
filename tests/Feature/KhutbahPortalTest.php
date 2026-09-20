<?php

use App\Models\Category;
use App\Models\Post;
use App\Services\KhutbahService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('halaman portal khutbah dapat diakses dengan sukses', function () {
    $response = $this->get(route('khutbah.index'));

    $response->assertStatus(200);
    $response->assertSee('Naskah Khutbah');
    $response->assertSee('Khutbah');
});

test('artikel otomatis tampil di halaman khutbah cukup dengan memilih kategori khutbah', function () {
    $category = Category::firstOrCreate(
        ['slug' => 'khutbah'],
        ['name' => 'Khutbah Jum\'at', 'description' => 'Kategori Khutbah']
    );

    $post = Post::create([
        'title' => 'Khutbah Istimewa Santri Menjaga Kemurnian Niat',
        'slug' => 'khutbah-istimewa-santri-menjaga-kemurnian-niat',
        'content' => '<p>Isi naskah khutbah tentang kemurnian niat dalam menuntut ilmu.</p>',
        'excerpt' => 'Ringkasan naskah khutbah kemurnian niat.',
        'status' => 'publish',
        'type' => 'post',
        'published_at' => now(),
    ]);

    $post->categories()->attach($category->id);

    $response = $this->get(route('khutbah.index'));

    $response->assertStatus(200);
    $response->assertSee('Khutbah Istimewa Santri Menjaga Kemurnian Niat');
});

test('artikel dengan kategori taujih lama otomatis tampil di halaman khutbah', function () {
    $category = Category::firstOrCreate(
        ['slug' => 'taujih'],
        ['name' => 'Tausiyah & Khutbah Jum\'at', 'description' => 'Kategori Taujih']
    );

    $post = Post::create([
        'title' => 'Tausiyah Mudir Menjaga Kedisiplinan Pesantren',
        'slug' => 'tausiyah-mudir-menjaga-kedisiplinan-pesantren',
        'content' => '<p>Isi tausiyah dan khutbah kedisiplinan santri.</p>',
        'excerpt' => 'Ringkasan tausiyah kedisiplinan.',
        'status' => 'publish',
        'type' => 'post',
        'published_at' => now(),
    ]);

    $post->categories()->attach($category->id);

    $response = $this->get(route('khutbah.index'));

    $response->assertStatus(200);
    $response->assertSee('Tausiyah Mudir Menjaga Kedisiplinan Pesantren');
});

test('halaman detail naskah khutbah dapat dibuka dengan mode baca mimbar', function () {
    $category = KhutbahService::ensureCategoryAndDemos();
    $post = Post::whereHas('categories', fn ($q) => $q->where('id', $category->id))->first();

    expect($post)->not->toBeNull();

    $response = $this->get(route('khutbah.show', $post->slug));

    $response->assertStatus(200);
    $response->assertSee($post->title);
    $response->assertSee('Cetak Naskah');
    $response->assertSee('Salin Teks');
});

test('pencarian naskah khutbah berfungsi menyaring judul atau materi', function () {
    KhutbahService::ensureCategoryAndDemos();

    $response = $this->get(route('khutbah.index', ['q' => 'Istiqamah']));

    $response->assertStatus(200);
    $response->assertSee('Istiqamah');
});

test('url alias tausiyah dan khutbah-jumat dialihkan ke halaman portal khutbah', function () {
    $this->get('/tausiyah')->assertRedirect(route('khutbah.index'));
    $this->get('/khutbah-jumat')->assertRedirect(route('khutbah.index'));
});
