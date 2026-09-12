<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

test('all blade view route calls are valid and exist in route registry', function () {
    $viewPath = resource_path('views');
    $files = File::allFiles($viewPath);
    $brokenRoutes = [];

    foreach ($files as $file) {
        if ($file->getExtension() !== 'php' || $file->getFilename() === 'welcome.blade.php') {
            continue;
        }

        $content = $file->getContents();
        $relPath = $file->getRelativePathname();

        // Match route('name' ...) or route("name" ...)
        preg_match_all('/route\(\s*[\'"]([a-zA-Z0-9\.\_\-]+)[\'"]/', $content, $matches);
        foreach ($matches[1] as $name) {
            if (! Route::has($name)) {
                $brokenRoutes[] = "{$relPath} -> route('{$name}')";
            }
        }
    }

    if (! empty($brokenRoutes)) {
        dump($brokenRoutes);
    }
    expect($brokenRoutes)->toBeEmpty();
});

test('all post/put/patch/delete forms in blade views have csrf token', function () {
    $viewPath = resource_path('views');
    $files = File::allFiles($viewPath);
    $missingCsrf = [];

    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }

        $content = $file->getContents();
        $relPath = $file->getRelativePathname();

        // Find all <form tags that have method="post" or method="POST"
        preg_match_all('/<form\b[^>]*method=[\'"]post[\'"][^>]*>(.*?)<\/form>/is', $content, $matches);
        foreach ($matches[1] as $idx => $formBody) {
            if (! str_contains($formBody, '@csrf') && ! preg_match('/name=[\'"]_token[\'"]/', $formBody)) {
                $missingCsrf[] = "{$relPath} form #{$idx}";
            }
        }
    }

    expect($missingCsrf)->toBeEmpty();
});

test('all main public frontend routes return 200 ok', function () {
    $routes = [
        '/',
        '/beranda',
        '/artikel',
        '/sambutan-kepala-sekolah',
        '/tentang-kami',
        '/visi-dan-misi',
        '/sejarah',
        '/struktur-organisasi',
        '/privacy-policy',
        '/dewan-guru',
        '/fasilitas',
        '/agenda',
        '/pengumuman',
        '/prestasi',
        '/ekstrakurikuler',
        '/data-alumni',
        '/layanan-terpadu',
        '/izin-sekolah',
        '/permohonan-kerja-sama',
        '/sewa-barang',
        '/testimonial',
        '/video',
        '/galeri',
        '/ppdb',
        '/form_ppdb',
        '/download',
        '/e-book',
        '/hymne-mars',
        '/logo',
        '/program-unggulan',
        '/hubungi',
        '/donasi',
    ];

    foreach ($routes as $uri) {
        $response = $this->get($uri);
        $status = $response->status();
        expect(in_array($status, [200, 301, 302]))
            ->toBeTrue("Route '{$uri}' returned unexpected HTTP status {$status}");
    }
});

test('all admin panel routes require authentication', function () {
    $adminRoutes = [
        '/admin',
        '/admin/analytics',
        '/admin/posts',
        '/admin/pages',
        '/admin/dewan',
        '/admin/bidang',
        '/admin/dpc',
        '/admin/media',
        '/admin/agenda',
        '/admin/downloads',
        '/admin/quick-menus',
        '/admin/ppdb',
        '/admin/ppdb/content',
        '/admin/popup',
        '/admin/testimonials',
        '/admin/users',
        '/admin/feedbacks',
        '/admin/security',
        '/admin/backup',
        '/admin/settings',
    ];

    foreach ($adminRoutes as $uri) {
        $response = $this->get($uri);
        $response->assertRedirect('/login');
    }
});

test('authenticated admin can access all admin panel pages', function () {
    $admin = User::create([
        'name' => 'Super Admin',
        'email' => 'admin_audit@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    $adminRoutes = [
        '/admin',
        '/admin/analytics',
        '/admin/posts',
        '/admin/pages',
        '/admin/dewan',
        '/admin/bidang',
        '/admin/dpc',
        '/admin/media',
        '/admin/agenda',
        '/admin/downloads',
        '/admin/quick-menus',
        '/admin/ppdb',
        '/admin/ppdb/content',
        '/admin/popup',
        '/admin/testimonials',
        '/admin/users',
        '/admin/feedbacks',
        '/admin/security',
        '/admin/backup',
        '/admin/settings',
    ];

    foreach ($adminRoutes as $uri) {
        $response = $this->actingAs($admin)->get($uri);
        expect($response->status())->toBe(200, "Admin route '{$uri}' failed with status {$response->status()}");
    }
});
