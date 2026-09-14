<?php

use App\Models\ActivityLog;
use App\Models\Bidang;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin can manage users with multi roles', function () {
    $superAdmin = User::create([
        'name' => 'Super Admin Robbani',
        'email' => 'superadmin@robbani.sch.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'super_admin',
    ]);

    $this->actingAs($superAdmin);

    // List users
    $this->get('/admin/users')->assertStatus(200)->assertSee('Super Admin Robbani');

    // Create editor user
    $response = $this->post('/admin/users', [
        'name' => 'Editor Berita',
        'email' => 'editor@robbani.sch.id',
        'password' => 'Password123!',
        'role' => 'editor',
    ]);

    $response->assertRedirect('/admin/users');
    $this->assertDatabaseHas('users', [
        'email' => 'editor@robbani.sch.id',
        'role' => 'editor',
    ]);
});

test('admin can manage static profile pages with rich content', function () {
    $admin = User::create([
        'name' => 'Admin Content',
        'email' => 'content@robbani.sch.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin',
    ]);

    $page = Post::create([
        'title' => 'Visi Misi Sekolah Robbani',
        'slug' => 'visi-misi-sekolah',
        'content' => '<p>Visi dan misi sekolah mencetak generasi Qurani.</p>',
        'type' => 'page',
        'status' => 'publish',
    ]);

    $this->actingAs($admin);

    $this->get('/admin/pages')->assertStatus(200)->assertSee('Visi Misi Sekolah Robbani');

    // Edit page
    $response = $this->put("/admin/pages/{$page->id}", [
        'title' => 'Visi Misi SMA IT Plus Robbani Terbaru',
        'content' => '<p>Konten baru yang telah diedit via WYSIWYG.</p>',
        'status' => 'publish',
    ]);

    $response->assertRedirect('/admin/pages');
    $this->assertDatabaseHas('posts', [
        'id' => $page->id,
        'title' => 'Visi Misi SMA IT Plus Robbani Terbaru',
    ]);
});

test('admin can view activity and security logs and download backup', function () {
    $admin = User::create([
        'name' => 'Admin Security',
        'email' => 'sec@robbani.sch.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin',
    ]);

    ActivityLog::create([
        'user_name' => 'Admin Security',
        'action' => 'test_action',
        'description' => 'Log pengujian sistem',
        'ip_address' => '127.0.0.1',
        'status' => 'info',
    ]);

    $this->actingAs($admin);

    $this->get('/admin/security')->assertStatus(200)->assertSee('Log pengujian sistem');

    // Database backup view & download stream
    $this->get('/admin/backup')->assertStatus(200)->assertSee('Download File Backup');
    $backupResponse = $this->get('/admin/backup/download');
    $backupResponse->assertStatus(200);
    $backupResponse->assertHeader('content-type', 'application/sql');
});

test('admin can update seo and opengraph settings', function () {
    $admin = User::create([
        'name' => 'Admin SEO',
        'email' => 'seo@robbani.sch.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    $this->get('/admin/settings')->assertStatus(200)->assertSee('SEO & Social Share (OpenGraph)', false);

    $response = $this->post('/admin/settings', [
        'site_name' => 'SMA IT Plus Robbani Official',
        'og_title' => 'Official SMA IT Plus Robbani',
        'og_description' => 'Website Resmi SMA IT Plus Robbani',
        'twitter_card' => 'summary_large_image',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('settings', [
        'key' => 'site_name',
        'value' => 'SMA IT Plus Robbani Official',
    ]);
    $this->assertDatabaseHas('settings', [
        'key' => 'og_title',
        'value' => 'Official SMA IT Plus Robbani',
    ]);
});

test('gallery displays uploaded photos on galeri page and home page', function () {
    $photo = Post::create([
        'title' => 'Dokumentasi Wisuda Tahfidz Robbani Terkini',
        'slug' => 'dokumentasi-wisuda-tahfidz-robbani-terkini',
        'type' => 'gallery',
        'status' => 'publish',
        'featured_image' => '/uploads/galeri/test_tahfidz.webp',
        'content' => 'Dokumentasi wisuda santri penghafal Quran.',
        'published_at' => now(),
    ]);

    // Check on /galeri page
    $this->get('/galeri')
        ->assertStatus(200)
        ->assertSee('Dokumentasi Wisuda Tahfidz Robbani Terkini')
        ->assertSee('/uploads/galeri/test_tahfidz.webp');

    // Check on homepage
    $this->get('/')
        ->assertStatus(200)
        ->assertSee('test_tahfidz.webp');
});

test('admin can manage bidang with rich content', function () {
    $admin = User::create([
        'name' => 'Admin Sarana',
        'email' => 'sarana@robbani.sch.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin',
    ]);

    $bidang = Bidang::create([
        'name' => 'Laboratorium Komputer & Riset IT',
        'slug' => 'lab-komputer',
        'description' => '<p>Fasilitas komputasi modern untuk santri.</p>',
        'order' => 1,
    ]);

    $this->actingAs($admin);

    $this->get('/admin/bidang')->assertStatus(200)->assertSee('Laboratorium Komputer & Riset IT');
    $this->get("/admin/bidang/{$bidang->id}/edit")->assertStatus(200)->assertSee('bidang_desc');

    $response = $this->put("/admin/bidang/{$bidang->id}", [
        'name' => 'Laboratorium Komputer & Riset IT Updated',
        'description' => '<p><strong>Fasilitas Unggulan:</strong> Pembelajaran coding dan AI.</p>',
        'order' => 1,
    ]);

    $response->assertRedirect('/admin/bidang');
    $this->assertDatabaseHas('fasilitas', [
        'id' => $bidang->id,
        'name' => 'Laboratorium Komputer & Riset IT Updated',
    ]);
});
