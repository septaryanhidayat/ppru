<?php

use App\Models\Bidang;
use App\Models\QuickMenu;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('donation page renders bank information', function () {
    Setting::updateOrCreate(['key' => 'donation_bank_1_name'], ['value' => 'Bank Syariah Indonesia (BSI)', 'group' => 'general']);
    Setting::updateOrCreate(['key' => 'donation_bank_1_rekening'], ['value' => '7188992211', 'group' => 'general']);

    $response = $this->get('/donasi');
    $response->assertStatus(200);
    $response->assertSee('Bank Syariah Indonesia (BSI)');
    $response->assertSee('7188992211');
});

test('donation page renders account number when configured in settings', function () {
    Setting::updateOrCreate(['key' => 'donation_bank_1_rekening'], ['value' => '7188992211', 'group' => 'general']);

    $response = $this->get('/donasi');
    $response->assertStatus(200);
    $response->assertSee('7188992211');
    $response->assertSee('Salin Nomor Rekening');
});

test('admin can update donation settings', function () {
    $admin = User::create([
        'name' => 'Admin Settings',
        'email' => 'admin_donasi@robbani.sch.id',
        'password' => Hash::make('Secret123!'),
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post('/admin/settings', [
        'donation_bank_1_name' => 'Bank Syariah Indonesia (BSI)',
        'donation_bank_1_rekening' => '7188992211',
        'donation_bank_1_holder' => 'YAYASAN SMA IT PLUS ROBBANI',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('settings', [
        'key' => 'donation_bank_1_rekening',
        'value' => '7188992211',
    ]);
});

test('admin can perform full CRUD on testimonials', function () {
    $admin = User::create([
        'name' => 'Admin Testi',
        'email' => 'admin_testi@robbani.sch.id',
        'password' => Hash::make('Secret123!'),
        'role' => 'admin',
    ]);

    // 1. Index
    $this->actingAs($admin)->get('/admin/testimonials')
        ->assertStatus(200)
        ->assertSee('Daftar Testimonial');

    // 2. Create / Store
    $response = $this->actingAs($admin)->post('/admin/testimonials', [
        'name' => 'Ustadz Ahmad Fauzi',
        'profession' => 'Wali Santri Angkatan I',
        'content' => 'SMA IT Plus Robbani sangat amanah dalam mendidik karakter dan hafalan Al-Quran santri.',
        'status' => 'publish',
    ]);
    $response->assertRedirect('/admin/testimonials');

    $testi = Testimonial::where('name', 'Ustadz Ahmad Fauzi')->first();
    expect($testi)->not->toBeNull();
    expect($testi->status)->toBe('publish');

    // 3. Update
    $response = $this->actingAs($admin)->put("/admin/testimonials/{$testi->id}", [
        'name' => 'Ustadz Ahmad Fauzi, M.Pd.I',
        'profession' => 'Wali Santri & Tokoh Pendidikan',
        'content' => 'Pendidikan di SMA IT Plus Robbani unggul dalam akhlak dan sains.',
        'status' => 'publish',
    ]);
    $response->assertRedirect('/admin/testimonials');
    expect($testi->fresh()->name)->toBe('Ustadz Ahmad Fauzi, M.Pd.I');

    // 4. Delete
    $response = $this->actingAs($admin)->delete("/admin/testimonials/{$testi->id}");
    $response->assertRedirect('/admin/testimonials');
    $this->assertDatabaseMissing('testimonials', ['id' => $testi->id]);
});

test('admin can perform full CRUD on quick menus', function () {
    $admin = User::create([
        'name' => 'Admin Quick Menu',
        'email' => 'admin_qm@robbani.sch.id',
        'password' => Hash::make('Secret123!'),
        'role' => 'admin',
    ]);

    // 1. Index
    $this->actingAs($admin)->get('/admin/quick-menus')
        ->assertStatus(200)
        ->assertSee('Menu Cepat');

    // 2. Create
    $response = $this->actingAs($admin)->post('/admin/quick-menus', [
        'name' => 'Konsultasi PPDB',
        'url' => '/hubungi',
        'icon' => 'fa-solid fa-graduation-cap',
        'order' => 10,
        'is_active' => '1',
    ]);
    $response->assertRedirect('/admin/quick-menus');

    $menu = QuickMenu::where('name', 'Konsultasi PPDB')->first();
    expect($menu)->not->toBeNull();
    expect($menu->is_active)->toBeTrue();

    // 3. Update
    $response = $this->actingAs($admin)->put("/admin/quick-menus/{$menu->id}", [
        'name' => 'PPDB Online',
        'url' => '/hubungi',
        'icon' => 'fa-solid fa-school',
        'order' => 11,
        'is_active' => '1',
    ]);
    $response->assertRedirect('/admin/quick-menus');
    expect($menu->fresh()->name)->toBe('PPDB Online');

    // 4. Delete
    $response = $this->actingAs($admin)->delete("/admin/quick-menus/{$menu->id}");
    $response->assertRedirect('/admin/quick-menus');
    $this->assertDatabaseMissing('quick_menus', ['id' => $menu->id]);
});

test('admin can update bidang icon and it displays on public page', function () {
    $admin = User::create([
        'name' => 'Admin Bidang',
        'email' => 'admin_bidang@robbani.sch.id',
        'password' => Hash::make('Secret123!'),
        'role' => 'admin',
    ]);

    $bidang = Bidang::create([
        'name' => 'Laboratorium Komputer',
        'slug' => 'lab-komputer-test',
        'icon' => 'fa-solid fa-laptop-code',
    ]);

    $response = $this->actingAs($admin)->put("/admin/bidang/{$bidang->id}", [
        'name' => $bidang->name,
        'icon' => 'fa-solid fa-server',
        'order' => 1,
    ]);

    $response->assertRedirect('/admin/bidang');
    expect($bidang->fresh()->icon)->toBe('fa-solid fa-server');

    // Check frontend public page
    $frontResponse = $this->get('/bidang');
    $frontResponse->assertStatus(200);
    $frontResponse->assertSee('Laboratorium Komputer');
});

test('home page renders at most 8 quick menu items in responsive grid', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('grid grid-cols-4 md:grid-cols-8', false);
    $response->assertSee('Menu Utama Sekolah');
    $response->assertSee('PPDB Online');
});
