<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'testadmin@ppru.ac.id'],
        [
            'name' => 'Ustadz Penguji',
            'password' => Hash::make('Password123!'),
            'role' => 'admin',
        ]
    );
});

test('admin can create post with custom publish date, custom author, caption, headline, and seo fields', function () {
    $customDate = Carbon::now()->subDays(10)->startOfMinute();

    $response = $this->actingAs($this->admin)->post('/admin/posts', [
        'title' => 'Santri PPRU Juara 1 Olimpiade Sains Nasional',
        'content' => '<p class="ql-align-center">Alhamdulillah santri berhasil meraih medali emas pada ajang bergengsi tingkat nasional.</p>',
        'excerpt' => 'Prestasi membanggakan kembali diraih oleh santri PPRU Sakatiga.',
        'status' => 'publish',
        'is_featured' => 1,
        'published_at' => $customDate->format('Y-m-d\TH:i'),
        'author_name' => 'Tim Media Humas PPRU',
        'featured_image_caption' => 'Foto: Penyerahan medali emas kepada santri PPRU',
        'meta_title' => 'Santri PPRU Raih Emas OSN 2026',
        'meta_description' => 'Kabar gembira dari ajang OSN tingkat nasional santri PPRU Sakatiga.',
        'meta_keywords' => 'santri, prestasi, osn, ppru',
    ]);

    $response->assertRedirect('/admin/posts');
    $response->assertSessionHas('success');

    $post = Post::where('title', 'Santri PPRU Juara 1 Olimpiade Sains Nasional')->first();
    expect($post)->not->toBeNull();
    expect($post->is_featured)->toBeTrue();
    expect($post->author_name)->toBe('Tim Media Humas PPRU');
    expect($post->display_author)->toBe('Tim Media Humas PPRU');
    expect($post->featured_image_caption)->toBe('Foto: Penyerahan medali emas kepada santri PPRU');
    expect($post->meta_title)->toBe('Santri PPRU Raih Emas OSN 2026');
    expect($post->published_at->format('Y-m-d H:i'))->toBe($customDate->format('Y-m-d H:i'));
});

test('admin can update post publish date to any date and format is preserved', function () {
    $initialDate = Carbon::now()->subMonths(2)->startOfMinute();
    $post = Post::create([
        'title' => 'Kunjungan Silaturahmi Alumni Sakatiga',
        'slug' => 'kunjungan-silaturahmi-alumni-sakatiga-'.time(),
        'content' => '<p>Pertemuan hangat para alumni dari berbagai daerah.</p>',
        'status' => 'publish',
        'type' => 'post',
        'published_at' => $initialDate,
        'author_id' => $this->admin->id,
    ]);

    $newDate = Carbon::now()->addDays(5)->startOfMinute();

    $response = $this->actingAs($this->admin)->put("/admin/posts/{$post->id}", [
        'title' => 'Kunjungan Silaturahmi Akbar Alumni Sakatiga',
        'content' => '<p>Pertemuan hangat para alumni dari berbagai daerah yang telah diperbarui.</p>',
        'status' => 'publish',
        'published_at' => $newDate->format('Y-m-d\TH:i'),
        'author_name' => 'Ikatan Alumni PPRU',
        'is_featured' => 1,
    ]);

    $response->assertRedirect('/admin/posts');
    $post->refresh();

    expect($post->title)->toBe('Kunjungan Silaturahmi Akbar Alumni Sakatiga');
    expect($post->published_at->format('Y-m-d H:i'))->toBe($newDate->format('Y-m-d H:i'));
    expect($post->author_name)->toBe('Ikatan Alumni PPRU');
    expect($post->is_featured)->toBeTrue();
});

test('admin can quick store category via ajax endpoint', function () {
    $categoryName = 'Tahfidz & Qiraah Mutawatir '.time();

    $response = $this->actingAs($this->admin)->postJson('/admin/categories/quick', [
        'name' => $categoryName,
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
    ]);

    $this->assertDatabaseHas('categories', [
        'name' => $categoryName,
    ]);

    // Test idempotent / existing category
    $repeatResponse = $this->actingAs($this->admin)->postJson('/admin/categories/quick', [
        'name' => $categoryName,
    ]);

    $repeatResponse->assertOk();
    $repeatResponse->assertJson([
        'success' => true,
        'already_exists' => true,
    ]);
});

test('admin can create post with inline new_category and category is attached', function () {
    $newCatName = 'Kajian Hadits Arba\'in '.time();

    $response = $this->actingAs($this->admin)->post('/admin/posts', [
        'title' => 'Pengajian Rutin Hadits Arba\'in An-Nawawi',
        'content' => '<p>Kajian rutin setiap malam Rabu bersama Mudir Pesantren.</p>',
        'status' => 'publish',
        'new_category' => $newCatName,
    ]);

    $response->assertRedirect('/admin/posts');

    $post = Post::where('title', 'Pengajian Rutin Hadits Arba\'in An-Nawawi')->first();
    expect($post)->not->toBeNull();
    expect($post->categories->pluck('name'))->toContain($newCatName);
});

test('admin can manage categories in dedicated admin category management', function () {
    $catName = 'Wirausaha Santri '.time();

    // Store
    $createResponse = $this->actingAs($this->admin)->post('/admin/categories', [
        'name' => $catName,
        'description' => 'Program kemandirian santri di bidang kewirausahaan.',
    ]);
    $createResponse->assertRedirect('/admin/categories');

    $category = Category::where('name', $catName)->first();
    expect($category)->not->toBeNull();

    // Update
    $updateResponse = $this->actingAs($this->admin)->put("/admin/categories/{$category->id}", [
        'name' => $catName.' Unggulan',
        'description' => 'Deskripsi yang diperbarui.',
    ]);
    $updateResponse->assertRedirect('/admin/categories');
    expect($category->fresh()->name)->toBe($catName.' Unggulan');

    // Destroy
    $deleteResponse = $this->actingAs($this->admin)->delete("/admin/categories/{$category->id}");
    $deleteResponse->assertRedirect('/admin/categories');
    expect(Category::find($category->id))->toBeNull();
});

test('public web correctly displays custom date, author, reading time, caption, and content format', function () {
    $category = Category::firstOrCreate(
        ['slug' => 'prestasi-internasional-test'],
        ['name' => 'Prestasi Internasional Test']
    );

    $publishedDate = now()->addHour();

    $post = Post::create([
        'title' => 'Santri PPRU Raih Medali Emas Kompetisi Robotik Turki',
        'slug' => 'santri-ppru-raih-medali-emas-kompetisi-robotik-turki-'.time(),
        'content' => '<p class="ql-align-center">Santri Pondok Pesantren Raudhatul Ulum Sakatiga kembali menorehkan tinta emas di kancah internasional.</p>',
        'excerpt' => 'Kompetisi internasional robotik di Istanbul berhasil dimenangkan santri PPRU.',
        'status' => 'publish',
        'is_featured' => true,
        'type' => 'post',
        'published_at' => $publishedDate,
        'author_name' => 'Ustadz Fauzi Al-Hafizh',
        'featured_image' => '/uploads/test-robotik.webp',
        'featured_image_caption' => 'Foto: Tim Robotik PPRU memegang piala kejuaraan',
    ]);
    $post->categories()->sync([$category->id]);

    // 1. Check index page /artikel
    $indexResponse = $this->get('/artikel');
    $indexResponse->assertOk();
    $indexResponse->assertSee('Santri PPRU Raih Medali Emas Kompetisi Robotik Turki');
    $indexResponse->assertSee($publishedDate->translatedFormat('d M Y'));
    $indexResponse->assertSee('Headline');

    // 2. Check detail page /artikel/{slug}
    $detailResponse = $this->get('/artikel/'.$post->slug);
    $detailResponse->assertOk();
    $detailResponse->assertSee('Santri PPRU Raih Medali Emas Kompetisi Robotik Turki');
    $detailResponse->assertSee('Ustadz Fauzi Al-Hafizh');
    $detailResponse->assertSee('Foto: Tim Robotik PPRU memegang piala kejuaraan');
    $detailResponse->assertSee($publishedDate->translatedFormat('l, d F Y - H:i'));
    $detailResponse->assertSee('menit baca');
    $detailResponse->assertSee('ql-align-center');
    $detailResponse->assertSee('Berita Utama');

    // 3. Check category filtering
    $categoryFilterResponse = $this->get('/artikel?kategori='.$category->slug);
    $categoryFilterResponse->assertOk();
    $categoryFilterResponse->assertSee('Santri PPRU Raih Medali Emas Kompetisi Robotik Turki');
});
