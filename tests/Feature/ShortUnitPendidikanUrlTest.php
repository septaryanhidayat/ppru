<?php

use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('all 8 unit pendidikan are accessible directly via root short urls', function (string $shortSlug, string $expectedNameKeyword) {
    $response = $this->get('/'.$shortSlug);

    $response->assertStatus(200);
    $response->assertSee($expectedNameKeyword);
})->with([
    ['takiru', 'Taman Kanak-Kanak'],
    ['miru', 'Madrasah Ibtidaiyah'],
    ['matsaru', 'Madrasah Tsanawiyah'],
    ['maru', 'Madrasah Aliyah'],
    ['smpitru', 'SMP Islam Terpadu'],
    ['smaitru', 'SMA Islam Terpadu'],
    ['iainru', 'Institut Agama Islam'],
    ['matqularu', 'Lil Aulad'],
]);

test('route pendidikan.show generates root short url and unit model generates url attribute', function () {
    expect(route('pendidikan.show', 'miru'))->toBe(url('/miru'));
    expect(route('pendidikan.show', 'maru'))->toBe(url('/maru'));
    expect(route('pendidikan.show', 'takiru'))->toBe(url('/takiru'));
    expect(route('pendidikan.show', 'smpitru'))->toBe(url('/smpitru'));

    $miru = UnitPendidikan::where('slug', 'miru')->first();
    expect($miru->url)->toBe(url('/miru'));
});

test('legacy verbose urls and /pendidikan/ urls are seamlessly supported', function () {
    // Old long slug
    $responseOld = $this->get('/pendidikan/madrasah-ibtidaiyah-raudhatul-ulum');
    $responseOld->assertStatus(200);
    $responseOld->assertSee('Madrasah Ibtidaiyah');

    // /pendidikan/{shortSlug}
    $responsePendidikanShort = $this->get('/pendidikan/miru');
    $responsePendidikanShort->assertStatus(200);
    $responsePendidikanShort->assertSee('Madrasah Ibtidaiyah');
});

test('homepage and footer display the new short urls for unit pendidikan', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee(url('/miru'), false);
    $response->assertSee(url('/maru'), false);
    $response->assertSee(url('/takiru'), false);
    $response->assertSee(url('/matsaru'), false);
});

test('admin can update unit slug and still access via new slug', function () {
    $admin = User::firstOrCreate(
        ['email' => 'admin_unit_test@ppru.ac.id'],
        ['name' => 'Admin Test', 'password' => Hash::make('password123'), 'role' => 'admin']
    );

    $unit = UnitPendidikan::where('slug', 'miru')->first();
    expect($unit)->not->toBeNull();

    $response = $this->actingAs($admin)->put(route('admin.unit-pendidikan.update', $unit), [
        'name' => $unit->name,
        'slug' => 'miru-kampus',
        'category_type' => $unit->category_type,
    ]);

    $response->assertSessionHas('success');
    expect($unit->fresh()->slug)->toBe('miru-kampus');

    // Restore back to miru
    $this->actingAs($admin)->put(route('admin.unit-pendidikan.update', $unit), [
        'name' => $unit->name,
        'slug' => 'miru',
        'category_type' => $unit->category_type,
    ]);
    expect($unit->fresh()->slug)->toBe('miru');
});
