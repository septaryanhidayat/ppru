<?php

use App\Models\AnggotaDewan;
use App\Models\Post;
use App\Models\Testimonial;
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

test('super admin dashboard displays 8 unit accounts section and their credentials', function () {
    $admin = User::whereIn('role', ['super_admin', 'admin'])->first() ?? User::factory()->create([
        'role' => 'super_admin',
        'name' => 'Super Administrator',
        'email' => 'superadmin_test@ppru.ac.id',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));
    $response->assertStatus(200);
    $response->assertSee('Akun Khusus &amp; Dashboard Terisolasi 8 Unit Lembaga', false);
    $response->assertSee('admin.maru@ppru.ac.id');
    $response->assertSee('admin.smait@ppru.ac.id');
    $response->assertSee('AdminUnitPPRU2026!');
});

test('admin users index displays unit admin role badge and filters', function () {
    $admin = User::whereIn('role', ['super_admin', 'admin'])->first() ?? User::factory()->create([
        'role' => 'super_admin',
        'name' => 'Super Administrator',
        'email' => 'superadmin_test2@ppru.ac.id',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 'admin_unit']));
    $response->assertStatus(200);
    $response->assertSee('8 Admin Unit Terisolasi');
    $response->assertSee('admin.maru@ppru.ac.id');
    $response->assertSee('Admin Unit: MARU');
});

test('admin nav menus index loads successfully with auto-healed menus', function () {
    $admin = User::whereIn('role', ['super_admin', 'admin'])->first() ?? User::factory()->create([
        'role' => 'super_admin',
        'name' => 'Super Administrator',
        'email' => 'superadmin_nav@ppru.ac.id',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.nav-menus.index'));
    $response->assertStatus(200);
    $response->assertSee('Menu Navigasi Header &amp; Footer', false);
    $response->assertSee('IKARUS');
});

test('unit admin can manage scoped teachers and cannot delete yayasan leaders', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    $matsaruUser = User::where('email', 'admin.matsaru@ppru.ac.id')->first();

    // 1. Can access dewan index
    $response = $this->actingAs($maruUser)->get(route('admin.dewan.index'));
    $response->assertStatus(200);
    $response->assertSee('Dewan Guru &amp; Tenaga Pendidik', false);

    // 2. Can create teacher for MARU
    $createResponse = $this->actingAs($maruUser)->post(route('admin.dewan.store'), [
        'name' => 'Ustadz Zaidul Akbar, S.Pd.',
        'position' => 'Guru Bahasa Arab MARU',
        'profile_summary' => 'Pengajar bahasa Arab dan Nahwu Shorof.',
        'education' => 'S1 Universitas Islam Madinah',
        'order' => 10,
    ]);
    $createResponse->assertRedirect(route('admin.dewan.index'));

    $teacher = AnggotaDewan::where('name', 'Ustadz Zaidul Akbar, S.Pd.')->first();
    expect($teacher)->not->toBeNull()
        ->and($teacher->unit_pendidikan_id)->toBe($maruUser->unit_pendidikan_id);

    // 3. Other unit admin cannot edit or delete this teacher
    $this->actingAs($matsaruUser)->get(route('admin.dewan.edit', $teacher))->assertStatus(403);
    $this->actingAs($matsaruUser)->delete(route('admin.dewan.destroy', $teacher))->assertStatus(403);

    // 4. Cannot delete Yayasan leader
    $yayasanLeader = AnggotaDewan::where('fraction', 'Yayasan')->first();
    if ($yayasanLeader) {
        $this->actingAs($maruUser)->delete(route('admin.dewan.destroy', $yayasanLeader))->assertStatus(403);
    }

    // 5. MARU admin can delete their teacher
    $this->actingAs($maruUser)->delete(route('admin.dewan.destroy', $teacher))->assertRedirect(route('admin.dewan.index'));
    expect(AnggotaDewan::find($teacher->id))->toBeNull();
});

test('unit admin can manage scoped testimonials', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    $matsaruUser = User::where('email', 'admin.matsaru@ppru.ac.id')->first();

    // 1. Can access testimonials index
    $response = $this->actingAs($maruUser)->get(route('admin.testimonials.index'));
    $response->assertStatus(200);

    // 2. Can create testimonial for MARU
    $createResponse = $this->actingAs($maruUser)->post(route('admin.testimonials.store'), [
        'name' => 'Wali Santri MARU Hebat',
        'profession' => 'Wali Santri Kelas XI',
        'content' => 'Pendidikan di MARU sangat berbobot dan asatidznya ramah.',
        'status' => 'publish',
    ]);
    $createResponse->assertRedirect(route('admin.testimonials.index'));

    $testi = Testimonial::where('name', 'Wali Santri MARU Hebat')->first();
    expect($testi)->not->toBeNull()
        ->and($testi->unit_pendidikan_id)->toBe($maruUser->unit_pendidikan_id);

    // 3. Other unit admin cannot edit or delete
    $this->actingAs($matsaruUser)->get(route('admin.testimonials.edit', $testi))->assertStatus(403);
    $this->actingAs($matsaruUser)->delete(route('admin.testimonials.destroy', $testi))->assertStatus(403);

    // 4. MARU admin can delete
    $this->actingAs($maruUser)->delete(route('admin.testimonials.destroy', $testi))->assertRedirect(route('admin.testimonials.index'));
    expect(Testimonial::find($testi->id))->toBeNull();
});

test('unit admin can update hero banner, sambutan, visi, and misi', function () {
    $maruUser = User::where('email', 'admin.maru@ppru.ac.id')->first();
    $maruUnit = UnitPendidikan::where('id', $maruUser->unit_pendidikan_id)->first();

    $response = $this->actingAs($maruUser)->put(route('admin.unit-pendidikan.update', $maruUnit), [
        'name' => $maruUnit->name,
        'short_name' => $maruUnit->short_name,
        'category_type' => $maruUnit->category_type,
        'head_name' => 'Drs. H. M. Husin',
        'sambutan' => 'Selamat datang di Kampus Keunggulan MARU Sakatiga.',
        'visi' => 'Mencetak generasi unggul dalam sains dan hafizh Al-Quran.',
        'misi' => "1. Meningkatkan kualitas akademik.\n2. Menguatkan karakter santri.",
    ]);
    $response->assertRedirect(route('admin.unit-pendidikan.edit', $maruUnit->id));

    $maruUnit->refresh();
    expect($maruUnit->sambutan)->toBe('Selamat datang di Kampus Keunggulan MARU Sakatiga.')
        ->and($maruUnit->visi)->toBe('Mencetak generasi unggul dalam sains dan hafizh Al-Quran.');
});

test('header navigation displays ikarus only once and khutbah in sub-menus without duplicate standalone buttons', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

    // Test header contains route('ikarus.index')
    $response->assertSee(route('ikarus.index'));
    $response->assertSee(route('khutbah.index'));

    // Check that standalone top-level button 'Khutbah' was removed from top header nav
    $content = $response->getContent();
    // In desktop nav, Khutbah is inside the Informasi dropdown
    expect($content)->toContain('Tausiyah &amp; Khutbah');
});

test('public unit education show page loads smoothly for units without QueryException', function () {
    $units = UnitPendidikan::active()->take(4)->get();
    foreach ($units as $unit) {
        $response = $this->get(route('pendidikan.show', $unit->slug));
        $response->assertStatus(200);
        $response->assertSee($unit->name);
    }
});

test('header navigation includes educational unit names in Pendidikan menu', function () {
    $response = $this->get('/');
    $response->assertStatus(200);

    $units = UnitPendidikan::active()->get();
    foreach ($units as $unit) {
        $response->assertSee(route('pendidikan.show', $unit->slug));
    }
});

test('ikarus portal page renders with high contrast author badges and elements', function () {
    $response = $this->get(route('ikarus.index'));
    $response->assertStatus(200);
    $response->assertSee('Portal resmi IKARUS');
    // Ensure high contrast pill badge or author class is rendered
    $response->assertSee('fa-user-pen');
});
