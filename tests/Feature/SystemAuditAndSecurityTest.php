<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

test('cpanel_setup script does not leak master token in unauthorized error response', function () {
    $cpanelScript = public_path('cpanel_setup.php');
    if (! File::exists($cpanelScript)) {
        return;
    }

    $content = File::get($cpanelScript);
    expect($content)->not->toContain('token=Ppru2026Setup');
    expect($content)->not->toContain('token=PksOi2026Setup');
});

test('non super-admin cannot escalate privileges to super-admin or modify super-admin accounts', function () {
    $superAdmin = User::create([
        'name' => 'Root Super Admin',
        'email' => 'superadmin@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'super_admin',
    ]);

    $regularAdmin = User::create([
        'name' => 'Regular Admin',
        'email' => 'regularadmin@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    // Regular admin tries to create a super_admin user -> forbidden (403)
    $createResponse = $this->actingAs($regularAdmin)->post(route('admin.users.store'), [
        'name' => 'Hacker Admin',
        'email' => 'hacker@ishum.sch.id',
        'password' => 'HackedPassword123!',
        'password_confirmation' => 'HackedPassword123!',
        'role' => 'super_admin',
    ]);
    expect($createResponse->status())->toBe(403);

    // Regular admin tries to edit super_admin account -> forbidden (403)
    $editResponse = $this->actingAs($regularAdmin)->get(route('admin.users.edit', $superAdmin));
    expect($editResponse->status())->toBe(403);

    // Regular admin tries to delete super_admin account -> forbidden (403)
    $deleteResponse = $this->actingAs($regularAdmin)->delete(route('admin.users.destroy', $superAdmin));
    expect($deleteResponse->status())->toBe(403);
});

test('admin download upload blocks dangerous executable files', function () {
    $admin = User::create([
        'name' => 'Admin Download Tester',
        'email' => 'admin_download@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    Storage::fake('public');

    $dangerousFile = UploadedFile::fake()->create('malicious.php', 10, 'application/x-php');

    $response = $this->actingAs($admin)->post(route('admin.downloads.store'), [
        'title' => 'Malicious File',
        'file' => $dangerousFile,
        'category' => 'dokumen',
    ]);

    $response->assertSessionHasErrors('file');
});

test('all registered controller routes map to valid callable methods', function () {
    $routes = Route::getRoutes()->getRoutes();
    $invalidRoutes = [];

    foreach ($routes as $route) {
        $action = $route->getAction();
        if (isset($action['controller'])) {
            $controllerAction = $action['controller'];
            if (is_string($controllerAction) && str_contains($controllerAction, '@')) {
                [$controller, $method] = explode('@', $controllerAction);
                if (! class_exists($controller)) {
                    $invalidRoutes[] = "Class missing: {$controller} for route {$route->uri()}";
                } elseif (! method_exists($controller, $method)) {
                    $invalidRoutes[] = "Method missing: {$controller}@{$method} for route {$route->uri()}";
                }
            }
        }
    }

    expect($invalidRoutes)->toBeEmpty();
});
