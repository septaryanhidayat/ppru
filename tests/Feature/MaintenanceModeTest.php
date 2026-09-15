<?php

use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    Setting::set('maintenance_mode', '0', 'system');
});

afterEach(function () {
    Setting::set('maintenance_mode', '0', 'system');
});

test('public website loads normally when maintenance mode is off', function () {
    Setting::set('maintenance_mode', '0', 'system');

    $response = $this->get('/');

    $response->assertStatus(200);
});

test('guest visitors are blocked with 503 maintenance page when maintenance mode is on', function () {
    Setting::set('maintenance_mode', '1', 'system');

    $response = $this->get('/');

    $response->assertStatus(503);
    $response->assertSee('Pemeliharaan');
    $response->assertSee('Pondok Pesantren Raudhatul Ulum');
});

test('login page remains accessible for administrators when maintenance mode is on', function () {
    Setting::set('maintenance_mode', '1', 'system');

    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('authenticated administrators can browse the entire website when maintenance mode is on', function () {
    Setting::set('maintenance_mode', '1', 'system');
    $admin = User::first() ?? User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/');

    $response->assertStatus(200);
    $response->assertSee('MODE MAINTENANCE AKTIF');
});

test('administrator can toggle maintenance mode on and off via dashboard action', function () {
    $admin = User::first() ?? User::factory()->create(['role' => 'admin']);

    expect((string) Setting::get('maintenance_mode', '0'))->toBe('0');

    // Toggle ON
    $response = $this->actingAs($admin)->post('/admin/maintenance/toggle');
    $response->assertRedirect();
    $response->assertSessionHas('success');
    expect((string) Setting::get('maintenance_mode', '0'))->toBe('1');

    // Toggle OFF
    $response = $this->actingAs($admin)->post('/admin/maintenance/toggle');
    $response->assertRedirect();
    $response->assertSessionHas('success');
    expect((string) Setting::get('maintenance_mode', '0'))->toBe('0');
});

test('guests cannot toggle maintenance mode', function () {
    $response = $this->post('/admin/maintenance/toggle');

    $response->assertRedirect('/login');
});
