<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'audit_admin@ppru.ac.id'],
        [
            'name' => 'Audit Admin PPRU',
            'password' => Hash::make('AuditSecret2026!'),
            'role' => 'super_admin',
        ]
    );
});

test('frontend homepage renders cinematic video background with top and bottom convex arc dividers', function () {
    Setting::updateOrCreate(
        ['key' => 'home_profile_video_bg'],
        ['value' => 'https://www.youtube.com/watch?v=BG311kT-yXc', 'group' => 'general']
    );

    $response = $this->get('/');
    $response->assertStatus(200);

    // Assert Section 2 presence, convex arc dividers, and non-negative z-index layering
    $response->assertSee('Profil Pesantren');
    $response->assertSee('Tonton Video Profil');
    $response->assertSee('Mendidik dengan Kasih Sayang, Membentuk Generasi Khairu Ummah');
    $response->assertSee('embed/BG311kT-yXc', false);
    $response->assertSee('preserveAspectRatio="none"', false);
    $response->assertSee('viewBox="0 0 1200 120"', false);
    $response->assertSee('Q600,-120 0,120', false);
    $response->assertSee('Q600,240 0,0', false);
    $response->assertSee('absolute inset-0 z-0 overflow-hidden', false);
    $response->assertDontSee('absolute inset-0 -z-10', false);
});

test('admin pages table uses compact icon-only action buttons without text truncation', function () {
    $this->actingAs($this->admin);

    Post::firstOrCreate(
        ['slug' => 'tentang-kami'],
        ['title' => 'Tentang Kami', 'content' => '<p>Konten tentang kami</p>', 'type' => 'page', 'author_id' => $this->admin->id]
    );

    $response = $this->get(route('admin.pages.index'));
    $response->assertStatus(200);
    $response->assertSee('fa-eye');
    $response->assertSee('fa-pen-to-square');
    $response->assertDontSee('<span>Edit Konten</span>', false);
    $response->assertDontSee('Lihat Web</span>', false);
});

test('spmb landing page displays clean badges and proportional official logo without overlapping', function () {
    $response = $this->get(route('ppdb.index'));
    $response->assertStatus(200);
    $response->assertSee('/uploads/official/logo-spmb-2027.png', false);
    $response->assertSee('Pendaftaran Santri Baru TP', false);
    $response->assertDontSee('-mb-1', false);
});

test('article editor supports left, center, right, and justify alignments and renders properly on public view', function () {
    $this->actingAs($this->admin);

    $category = Category::firstOrCreate(
        ['slug' => 'berita-pesantren'],
        ['name' => 'Berita Pesantren']
    );

    $alignedContent = '
        <p class="ql-align-left">Paragraf Rata Kiri standar dengan informasi pembuka.</p>
        <p class="ql-align-center"><strong>Kutipan Utama Santri - Rata Tengah</strong></p>
        <p class="ql-align-right"><em>Tanda Tangan Pengasuh - Rata Kanan</em></p>
        <p class="ql-align-justify">Penjelasan mendalam dan terperinci mengenai program kepesantrenan yang diatur rata kanan-kiri (justify) agar tampak rapi, terstruktur, dan mudah dibaca oleh seluruh wali santri dan masyarakat luas.</p>
    ';

    // Store post with alignments
    $response = $this->post(route('admin.posts.store'), [
        'title' => 'Pengujian Format Rata Teks Komprehensif Santri',
        'content' => $alignedContent,
        'excerpt' => 'Uji coba perataan teks kiri, tengah, kanan, dan justify.',
        'status' => 'publish',
        'categories' => [$category->id],
        'is_featured' => 0,
        'author_name' => 'Redaksi PPRU',
        'published_at' => now()->format('Y-m-d H:i:s'),
    ]);

    $response->assertRedirect(route('admin.posts.index'));

    $post = Post::where('title', 'Pengujian Format Rata Teks Komprehensif Santri')->first();
    expect($post)->not->toBeNull();
    expect($post->content)->toContain('ql-align-left');
    expect($post->content)->toContain('ql-align-center');
    expect($post->content)->toContain('ql-align-right');
    expect($post->content)->toContain('ql-align-justify');

    // Public view renders content and alignment classes
    $publicResponse = $this->get(route('artikel.show', $post->slug));
    $publicResponse->assertStatus(200);
    $publicResponse->assertSee('ql-align-left', false);
    $publicResponse->assertSee('ql-align-center', false);
    $publicResponse->assertSee('ql-align-right', false);
    $publicResponse->assertSee('ql-align-justify', false);
});

test('comprehensive sweep: all admin sidebar modules are operational and load with HTTP 200', function () {
    $this->actingAs($this->admin);

    $routes = [
        'admin.dashboard' => route('admin.dashboard'),
        'admin.analytics.index' => route('admin.analytics.index'),
        'admin.posts.index' => route('admin.posts.index'),
        'admin.posts.create' => route('admin.posts.create'),
        'admin.categories.index' => route('admin.categories.index'),
        'admin.pages.index' => route('admin.pages.index'),
        'admin.quick-menus.index' => route('admin.quick-menus.index'),
        'admin.unit-pendidikan.index' => route('admin.unit-pendidikan.index'),
        'admin.dewan.index' => route('admin.dewan.index'),
        'admin.bidang.index' => route('admin.bidang.index'),
        'admin.dpc.index' => route('admin.dpc.index'),
        'admin.popup.index' => route('admin.popup.index'),
        'admin.media.index' => route('admin.media.index'),
        'admin.agenda.index' => route('admin.agenda.index'),
        'admin.downloads.index' => route('admin.downloads.index'),
        'admin.ppdb.index' => route('admin.ppdb.index'),
        'admin.ppdb.content' => route('admin.ppdb.content'),
        'admin.testimonials.index' => route('admin.testimonials.index'),
        'admin.feedbacks.index' => route('admin.feedbacks.index'),
        'admin.layanan.index' => route('admin.layanan.index'),
        'admin.layanan.content' => route('admin.layanan.content'),
        'admin.settings.index' => route('admin.settings.index'),
        'admin.users.index' => route('admin.users.index'),
        'admin.security.index' => route('admin.security.index'),
        'admin.backup.index' => route('admin.backup.index'),
    ];

    foreach ($routes as $name => $url) {
        $res = $this->get($url);
        expect($res->status())->toBe(200, "Module [{$name}] at [{$url}] failed with status {$res->status()}");
    }
});

test('admin can update video background settings in admin settings and persist to database', function () {
    $this->actingAs($this->admin);

    $response = $this->post(route('admin.settings.update'), [
        'home_profile_video_bg' => 'https://www.youtube.com/watch?v=UGc6hUcwSXk',
        'home_profile_badge' => 'Pendidikan Akhlaqul Karimah',
        'home_profile_headline' => 'Membangun Generasi Emas Berkarakter Luhur',
        'home_profile_desc' => 'Deskripsi profil teruji di PPRU Sakatiga.',
        'home_profile_btn_text' => 'Lihat Video Singkat',
        'home_profile_poster_image' => '/uploads/custom-campus-poster.webp',
        'home_profile_overlay_opacity' => '80',
    ]);

    $response->assertSessionHasNoErrors();
    expect(Setting::get('home_profile_video_bg'))->toBe('https://www.youtube.com/watch?v=UGc6hUcwSXk');
    expect(Setting::get('home_profile_badge'))->toBe('Pendidikan Akhlaqul Karimah');
    expect(Setting::get('home_profile_headline'))->toBe('Membangun Generasi Emas Berkarakter Luhur');
    expect(Setting::get('home_profile_poster_image'))->toBe('/uploads/custom-campus-poster.webp');
    expect(Setting::get('home_profile_overlay_opacity'))->toBe('80');
});

test('unauthenticated guests are blocked and redirected to login from admin routes', function () {
    $protectedUrls = [
        '/admin',
        '/admin/posts',
        '/admin/settings',
        '/admin/users',
        '/admin/security',
        '/admin/backup',
        '/admin/ppdb',
    ];

    foreach ($protectedUrls as $url) {
        $res = $this->get($url);
        $res->assertRedirect('/login');
    }
});
