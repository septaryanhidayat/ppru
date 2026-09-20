<?php

use App\Models\Feedback;
use App\Models\PpdbRegistration;
use App\Models\Setting;
use App\Models\User;
use App\Services\HtmlSanitizer;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('author role is strictly restricted to dashboard, posts, and media', function () {
    $author = User::create([
        'name' => 'Penulis Berita',
        'email' => 'author@ppru.ac.id',
        'password' => Hash::make('Password123!'),
        'role' => 'author',
    ]);

    // Allowed routes
    $this->actingAs($author)->get('/admin/posts')->assertStatus(200);

    // Blocked routes
    $blocked = [
        '/admin/settings',
        '/admin/backup',
        '/admin/users',
        '/admin/security',
        '/admin/unit-pendidikan',
        '/admin/dewan',
        '/admin/bidang',
        '/admin/program-unggulan',
        '/admin/ppdb',
        '/admin/layanan',
    ];

    foreach ($blocked as $uri) {
        $this->actingAs($author)->get($uri)->assertStatus(403);
    }
});

test('editor role cannot access settings, backup, users, security, and migrations', function () {
    $editor = User::create([
        'name' => 'Editor Berita',
        'email' => 'editor@ppru.ac.id',
        'password' => Hash::make('Password123!'),
        'role' => 'editor',
    ]);

    // Editor can access posts and categories
    $this->actingAs($editor)->get('/admin/posts')->assertStatus(200);

    // Editor is blocked from critical system administration
    $blocked = [
        '/admin/settings',
        '/admin/backup',
        '/admin/users',
        '/admin/security',
        '/admin/unit-pendidikan',
    ];

    foreach ($blocked as $uri) {
        $this->actingAs($editor)->get($uri)->assertStatus(403);
    }

    $this->actingAs($editor)->post('/admin/migrate')->assertStatus(403);
});

test('html sanitizer cleans dangerous scripts and event handlers while preserving safe formatting', function () {
    $dirtyHtml = '<p>Halo santri!</p><script>alert("hacked")</script><a href="javascript:stealCookie()">Klik</a><img src="/foto.jpg" onerror="alert(1)"><b>Tebal</b>';
    $clean = HtmlSanitizer::clean($dirtyHtml);

    expect($clean)->not->toContain('<script>')
        ->and($clean)->not->toContain('alert')
        ->and($clean)->not->toContain('javascript:')
        ->and($clean)->not->toContain('onerror=')
        ->and($clean)->toContain('<p>Halo santri!</p>')
        ->and($clean)->toContain('<b>Tebal</b>');
});

test('admin settings update ignores arbitrary unwhitelisted keys', function () {
    $admin = User::create([
        'name' => 'Admin Utama',
        'email' => 'admin@ppru.ac.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post('/admin/settings', [
        'site_name' => 'PPRU Sakatiga Unggul',
        'arbitrary_injected_key' => 'evil_value',
        'malicious_backdoor' => 'shell',
    ]);

    $response->assertRedirect();
    expect(Setting::get('site_name'))->toBe('PPRU Sakatiga Unggul');
    expect(Setting::get('arbitrary_injected_key'))->toBeNull();
    expect(Setting::get('malicious_backdoor'))->toBeNull();
});

test('layanan content update portal mode ignores unwhitelisted keys', function () {
    $admin = User::create([
        'name' => 'Admin Layanan',
        'email' => 'admin_layanan@ppru.ac.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.layanan.content.update'), [
        'service_type' => 'portal',
        'layanan_portal_hero_title' => 'Portal Layanan Terpadu PPRU Baru',
        'hacked_config' => 'override',
    ]);

    $response->assertRedirect();
    expect(Setting::get('layanan_portal_hero_title'))->toBe('Portal Layanan Terpadu PPRU Baru');
    expect(Setting::get('hacked_config'))->toBeNull();
});

test('feedback controller creates activity log on markAsRead and destroy', function () {
    $admin = User::create([
        'name' => 'Admin Feedback',
        'email' => 'admin_fb@ppru.ac.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    $feedback = Feedback::create([
        'name' => 'Wali Santri Ahmad',
        'email' => 'ahmad@example.com',
        'phone' => '081234567890',
        'subject' => 'Pertanyaan Kurikulum',
        'message' => 'Mohon info kurikulum tahfidz',
        'status' => 'unread',
    ]);

    $this->actingAs($admin)->post(route('admin.feedbacks.read', $feedback));
    $this->assertDatabaseHas('activity_logs', [
        'action' => 'feedback_read',
        'status' => 'info',
    ]);

    $this->actingAs($admin)->delete(route('admin.feedbacks.destroy', $feedback));
    $this->assertDatabaseHas('activity_logs', [
        'action' => 'feedback_delete',
        'status' => 'warning',
    ]);
});

test('ppdb sequential registration number generation avoids duplicates', function () {
    $num1 = PpdbRegistration::generateRegistrationNumber();
    $year = date('Y');
    expect($num1)->toBe("PPDB-{$year}-0001");

    PpdbRegistration::create([
        'registration_number' => $num1,
        'full_name' => 'Santri 1',
        'birth_place' => 'Prabumulih',
        'birth_date' => '2010-08-20',
        'gender' => 'Perempuan',
        'address' => 'Prabumulih Timur',
        'living_with' => 'Orang Tua',
        'child_order' => 1,
        'siblings_count' => 1,
        'previous_school' => 'MTs Negeri 1',
        'nisn' => '0091122334',
        'phone' => '082188776655',
        'father_name' => 'Muhammad',
        'father_birth_place' => 'Prabumulih',
        'father_birth_date' => '1978-04-12',
        'father_address' => 'Prabumulih Timur',
        'father_education' => 'S1',
        'father_job' => 'Wiraswasta',
        'father_income' => 'Rp 5.000.000',
        'father_phone' => '082155443322',
        'mother_name' => 'Khadijah',
        'mother_birth_place' => 'Prabumulih',
        'mother_birth_date' => '1982-06-15',
        'mother_address' => 'Prabumulih Timur',
        'mother_education' => 'SMA',
        'mother_job' => 'Ibu Rumah Tangga',
        'mother_income' => '< Rp 2.000.000',
        'mother_phone' => '082155443311',
        'status' => 'pending',
    ]);

    $num2 = PpdbRegistration::generateRegistrationNumber();
    expect($num2)->toBe("PPDB-{$year}-0002");
});

test('security headers middleware attaches content security policy', function () {
    $response = $this->get('/');
    $response->assertHeader('Content-Security-Policy');
    expect($response->headers->get('Content-Security-Policy'))->toContain("default-src 'self'");
});

test('post too large exception is handled gracefully with error flash message', function () {
    $request = Request::create('/admin/settings', 'POST');
    $session = app('session.store');
    $request->setLaravelSession($session);

    $e = new PostTooLargeException('Content Too Large');
    $handler = app(ExceptionHandler::class);
    $rendered = $handler->render($request, $e);

    expect($rendered->getStatusCode())->toBe(302);
    expect($session->get('error'))->toContain('Ukuran total berkas yang Anda unggah terlalu besar');
});
