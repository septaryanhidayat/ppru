<?php

use App\Models\Post;
use App\Models\UnitPendidikan;
use App\Models\User;

test('all 8 educational unit admin accounts exist with proper unit mapping', function () {
    $expectedAccounts = [
        'admin.maru@ppru.ac.id' => 'MARU',
        'admin.matsaru@ppru.ac.id' => 'MATSARU',
        'admin.miru@ppru.ac.id' => 'MIRU',
        'admin.matqularu@ppru.ac.id' => 'MATQULARU',
        'admin.takiru@ppru.ac.id' => 'TAKIRU',
        'admin.smpit@ppru.ac.id' => 'SMPIT RU',
        'admin.smait@ppru.ac.id' => 'SMAIT RU',
        'admin.iainru@ppru.ac.id' => 'IAI NRU',
    ];

    foreach ($expectedAccounts as $email => $shortName) {
        $user = User::where('email', $email)->first();
        expect($user)->not->toBeNull()
            ->and($user->role)->toBe('admin_unit')
            ->and($user->unit_pendidikan_id)->not->toBeNull()
            ->and($user->unit->short_name)->toBe($shortName)
            ->and($user->isUnitAdmin())->toBeTrue();
    }
});

test('unit admin can access scoped dashboard and see their unit name', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    expect($maruUser)->not->toBeNull();

    $response = $this->actingAs($maruUser)->get(route('admin.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Dashboard Unit: MARU');
    $response->assertSee('Madrasah Aliyah Raudhatul Ulum');
    $response->assertSee(route('admin.profil-unit'));
});

test('unit admin is blocked with 403 when attempting to access global settings and maintenance', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();

    $restrictedPaths = [
        '/admin/settings',
        '/admin/hero-slides',
        '/admin/nav-menus',
        '/admin/security',
        '/admin/backup',
        '/admin/users',
        '/admin/quick-menus',
    ];

    foreach ($restrictedPaths as $path) {
        $response = $this->actingAs($maruUser)->get($path);
        $response->assertStatus(403);
    }
});

test('unit admin can edit their own unit profile but is blocked from editing other units', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    $maruUnit = UnitPendidikan::where('id', $maruUser->unit_pendidikan_id)->first();
    $matsaruUnit = UnitPendidikan::where('short_name', 'MATSARU')->first();

    // 1. Can access own unit edit form
    $ownResponse = $this->actingAs($maruUser)->get(route('admin.unit-pendidikan.edit', $maruUnit));
    $ownResponse->assertStatus(200);

    // 2. Can update own unit profile
    $updateResponse = $this->actingAs($maruUser)->put(route('admin.unit-pendidikan.update', $maruUnit), [
        'name' => 'Madrasah Aliyah Raudhatul Ulum',
        'short_name' => 'MARU',
        'category_type' => 'Madrasah Aliyah / SMA',
        'head_name' => 'K.H. M. Said, S.Ag.',
        'phone' => '081234567890',
        'description' => 'Unit MA Unggulan Pesantren PPRU Sakatiga.',
    ]);
    $updateResponse->assertRedirect(route('admin.unit-pendidikan.edit', $maruUnit->id));

    // 3. Blocked from editing other unit
    $otherResponse = $this->actingAs($maruUser)->get(route('admin.unit-pendidikan.edit', $matsaruUnit));
    $otherResponse->assertStatus(403);

    // 4. Blocked from updating other unit
    $otherUpdateResponse = $this->actingAs($maruUser)->put(route('admin.unit-pendidikan.update', $matsaruUnit), [
        'name' => 'Perubahan Ilegal',
        'category_type' => 'MTs',
    ]);
    $otherUpdateResponse->assertStatus(403);
});

test('posts created by unit admin are automatically isolated and tagged with their unit_pendidikan_id', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    $matsaruUser = User::where('email', 'admin.matsaru@ppru.ac.id')->first();

    // Create post by MARU admin
    $response = $this->actingAs($maruUser)->post(route('admin.posts.store'), [
        'title' => 'Olimpiade Sains Santri MA Raudhatul Ulum 2026',
        'content' => 'Santri MA berhasil meraih medali emas pada ajang kompetisi sains nasional.',
        'status' => 'publish',
        'type' => 'post',
    ]);
    $response->assertRedirect(route('admin.posts.index'));

    $post = Post::where('title', 'Olimpiade Sains Santri MA Raudhatul Ulum 2026')->first();
    expect($post)->not->toBeNull()
        ->and($post->unit_pendidikan_id)->toBe($maruUser->unit_pendidikan_id);

    // MARU admin can edit
    $this->actingAs($maruUser)->get(route('admin.posts.edit', $post))->assertStatus(200);

    // MATSARU admin is forbidden from editing MARU's post
    $this->actingAs($matsaruUser)->get(route('admin.posts.edit', $post))->assertStatus(403);

    // MATSARU admin is forbidden from deleting MARU's post
    $this->actingAs($matsaruUser)->delete(route('admin.posts.destroy', $post))->assertStatus(403);

    // MARU admin can delete their own post
    $this->actingAs($maruUser)->delete(route('admin.posts.destroy', $post))->assertRedirect(route('admin.posts.index'));
    expect(Post::find($post->id))->toBeNull();
});

test('organization chart displays dynamic unit names and leaders from database', function () {
    $response = $this->get(route('page.struktur'));
    $response->assertStatus(200);

    $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
    foreach ($units as $u) {
        $response->assertSee($u->short_name);
    }
});

test('legacy dpc route displays program unggulan page without party terms', function () {
    $response = $this->get('/dpc');
    $response->assertStatus(200);
    $response->assertSee('Program Unggulan');
    $response->assertDontSee('DPC');
    $response->assertDontSee('Partai');
});
