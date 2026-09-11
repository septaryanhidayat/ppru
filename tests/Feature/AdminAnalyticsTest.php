<?php

use App\Models\Setting;
use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

test('public page visit records real visitor log in database', function () {
    // Kunjungi beranda
    $response = $this->get('/');
    $response->assertStatus(200);

    // Verifikasi log tercatat di database
    $this->assertDatabaseHas('visitor_logs', [
        'path' => '/',
        'is_bot' => false,
    ]);
});

test('admin analytics page requires authentication', function () {
    $response = $this->get('/admin/analytics');
    $response->assertRedirect('/login');
});

test('authenticated admin can view analytics dashboard with real metrics', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    // Buat data kunjungan riil
    VisitorLog::create([
        'ip_address' => '202.67.40.10',
        'path' => '/sejarah',
        'page_title' => 'Sejarah Partai',
        'referer' => 'https://www.google.com/',
        'referer_source' => 'Google Search',
        'device_type' => 'Mobile',
        'browser' => 'Chrome',
        'platform' => 'Android',
        'city' => 'Indralaya',
        'region' => 'Sumatera Selatan',
        'country' => 'Indonesia',
        'is_bot' => false,
    ]);

    VisitorLog::create([
        'ip_address' => '103.111.20.5',
        'path' => '/artikel/kegiatan-baksos-robbani',
        'page_title' => 'Kegiatan Baksos Santri Robbani',
        'referer' => 'https://www.facebook.com/',
        'referer_source' => 'Facebook',
        'device_type' => 'Desktop',
        'browser' => 'Firefox',
        'platform' => 'Windows 10/11',
        'city' => 'Palembang',
        'region' => 'Sumatera Selatan',
        'country' => 'Indonesia',
        'is_bot' => false,
    ]);

    $response = $this->actingAs($admin)->get('/admin/analytics');
    $response->assertStatus(200);
    $response->assertSee('Statistik Pengunjung');
    $response->assertSee('Indralaya');
    $response->assertSee('Palembang');
    $response->assertSee('Google Search');
    $response->assertSee('Facebook');
    $response->assertSee('/sejarah');
});

test('admin can prune old visitor logs', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    // Buat log lama (100 hari lalu)
    $oldLogId = DB::table('visitor_logs')->insertGetId([
        'ip_address' => '1.1.1.1',
        'path' => '/old-page',
        'created_at' => now()->subDays(100),
        'updated_at' => now()->subDays(100),
    ]);

    // Buat log baru (hari ini)
    $newLogId = DB::table('visitor_logs')->insertGetId([
        'ip_address' => '2.2.2.2',
        'path' => '/new-page',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $response = $this->actingAs($admin)->post('/admin/analytics/prune', ['days' => 90]);
    $response->assertRedirect('/admin/analytics');

    $this->assertDatabaseMissing('visitor_logs', ['id' => $oldLogId]);
    $this->assertDatabaseHas('visitor_logs', ['id' => $newLogId]);
});

test('admin can update analytics settings in database', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post('/admin/settings', [
        'analytics_enabled' => '1',
        'analytics_ignore_admin' => '1',
        'analytics_base_hits' => '60000',
        'analytics_ip_lookup' => '1',
    ]);

    $response->assertRedirect();
    $this->assertEquals('60000', Setting::get('analytics_base_hits'));
    $this->assertEquals('1', Setting::get('analytics_enabled'));
});

test('admin can execute database migration runner', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->post('/admin/migrate');
    $response->assertRedirect();
    $response->assertSessionHas('success');
});

test('dashboard and analytics load gracefully without error if visitor_logs table is missing', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Schema::dropIfExists('visitor_logs');

    $responseDashboard = $this->actingAs($admin)->get('/admin');
    $responseDashboard->assertStatus(200);
    $responseDashboard->assertSee('Tabel Database');

    $responseAnalytics = $this->actingAs($admin)->get('/admin/analytics');
    $responseAnalytics->assertStatus(200);
    $responseAnalytics->assertSee('Tabel Database');

    // Restore table
    Artisan::call('migrate', ['--force' => true]);
});

test('homepage loads successfully with built assets', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('build/assets/');
});
