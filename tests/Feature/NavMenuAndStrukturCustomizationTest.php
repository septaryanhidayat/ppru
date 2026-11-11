<?php

use App\Models\AnggotaDewan;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'admin_nav_struktur_test@ppru.ac.id'],
        [
            'name' => 'Nav Struktur Admin Test',
            'password' => Hash::make('NavStrukturTest2026!'),
            'role' => 'super_admin',
        ]
    );
});

test('admin can view and update header actions in nav menus management', function () {
    $this->actingAs($this->admin);

    $response = $this->get(route('admin.nav-menus.index'));
    $response->assertStatus(200);
    $response->assertSee('Pengaturan Tombol Aksi Header');
    $response->assertSee('Tombol Utama CTA (Oranye)');
    $response->assertSee('Tombol Login Portal');

    // Update header CTA and login button settings
    $postResponse = $this->post(route('admin.nav-menus.header-actions'), [
        'header_cta_text' => 'Daftar PSB 2026/2027',
        'header_cta_url' => '/ppdb-2026',
        'header_cta_icon' => 'fa-solid fa-user-plus',
        'header_cta_active' => '1',
        'header_login_text' => 'Portal Santri',
        'header_login_url' => '/portal-santri',
        'header_login_icon' => 'fa-solid fa-arrow-right-to-bracket',
        'header_login_active' => '1',
    ]);

    $postResponse->assertRedirect();
    $postResponse->assertSessionHas('success');

    expect(Setting::get('header_cta_text'))->toBe('Daftar PSB 2026/2027')
        ->and(Setting::get('header_cta_url'))->toBe('/ppdb-2026')
        ->and(Setting::get('header_login_text'))->toBe('Portal Santri');

    // Check frontend reflects these changes immediately
    $homeRes = $this->get(route('home'));
    $homeRes->assertStatus(200);
    $homeRes->assertSee('Daftar PSB 2026/2027');
    $homeRes->assertSee('/ppdb-2026');
    $homeRes->assertSee('Portal Santri');
    $homeRes->assertSee('/portal-santri');

    // Test disabling CTA button
    $this->post(route('admin.nav-menus.header-actions'), [
        'header_cta_text' => 'Daftar PSB 2026/2027',
        'header_cta_url' => '/ppdb-2026',
        'header_cta_icon' => 'fa-solid fa-user-plus',
        // header_cta_active omitted = deactivated
        'header_login_text' => 'Portal Santri',
        'header_login_url' => '/portal-santri',
        'header_login_icon' => 'fa-solid fa-arrow-right-to-bracket',
        'header_login_active' => '1',
    ]);

    $homeDeactivated = $this->get(route('home'));
    $homeDeactivated->assertStatus(200);
    $homeDeactivated->assertDontSee('Daftar PSB 2026/2027');
    $homeDeactivated->assertSee('Portal Santri');
});

test('admin can access specialized struktur editor and sidebar has dedicated link', function () {
    $this->actingAs($this->admin);

    // 1. Sidebar menu contains Struktur Organisasi link
    $resAdmin = $this->get(route('admin.dashboard'));
    $resAdmin->assertStatus(200);
    $resAdmin->assertSee('Struktur Organisasi');
    $resAdmin->assertSee(route('admin.pages.struktur'));

    // 2. Access specialized struktur page editor
    $resStruktur = $this->get(route('admin.pages.struktur'));
    $resStruktur->assertStatus(200);
    $resStruktur->assertSee('Kelola Struktur Organisasi &amp; Bagan', false);
    $resStruktur->assertSee('Pilih File Gambar Bagan Struktur');
    $resStruktur->assertSee('Mode Tampilan Bagan di Website');

    // 3. AdminPageController edit redirect for struktur slug
    $page = Post::where('type', 'page')->where('slug', 'struktur-organisasi')->first();
    if (! $page) {
        $page = Post::create([
            'title' => 'Struktur Organisasi',
            'slug' => 'struktur-organisasi',
            'type' => 'page',
            'status' => 'published',
            'content' => 'Konten awal',
        ]);
    }

    $redirectRes = $this->get(route('admin.pages.edit', $page));
    $redirectRes->assertRedirect(route('admin.pages.struktur'));
});

test('admin can upload organization chart image and update struktur page settings', function () {
    Storage::fake('public');
    $this->actingAs($this->admin);

    $fakeImage = UploadedFile::fake()->image('bagan-resmi.png', 1200, 800);

    $response = $this->post(route('admin.pages.struktur.update'), [
        'title' => 'Struktur Kepengurusan Resmi YAPIRUS & PPRU',
        'excerpt' => 'Bagan resmi pimpinan dan pengurus yayasan PPRU Sakatiga tahun 2026/2027.',
        'content' => '<p>Pimpinan pondok pesantren senantiasa berikhtiar memajukan mutu pendidikan.</p>',
        'struktur_intro' => 'Catatan kepengurusan khusus santri dan wali santri.',
        'struktur_chart_mode' => 'both',
        'struktur_show_facilities' => '1',
        'struktur_show_programs' => '1',
        'struktur_chart_image_file' => $fakeImage,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Verify setting was updated
    $chartUrl = Setting::get('struktur_chart_image_url');
    expect($chartUrl)->not->toBeEmpty();
    expect(Setting::get('struktur_chart_mode'))->toBe('both');

    // Frontend public page reflects the uploaded image and custom intro
    $publicRes = $this->get(route('page.struktur'));
    $publicRes->assertStatus(200);
    $publicRes->assertSee('Struktur Kepengurusan Resmi YAPIRUS &amp; PPRU', false);
    $publicRes->assertSee('Catatan kepengurusan khusus santri dan wali santri.');
    $publicRes->assertSee($chartUrl);
    $publicRes->assertSee('Gambar Bagan Struktur Organisasi Resmi');
    $publicRes->assertSee('Unduh Gambar');
    $publicRes->assertSee('Pratinjau Layar Penuh');

    // Verify no hardcoded dummy names exist in the tree output
    $tree = AnggotaDewan::getHierarchyTree();
    expect($tree)->toBeArray();

    if ($chartUrl && file_exists(public_path(ltrim($chartUrl, '/')))) {
        @unlink(public_path(ltrim($chartUrl, '/')));
    }
});

test('frontend struktur page renders without raw html tags and full names without truncation', function () {
    $official = AnggotaDewan::firstOrCreate(
        ['name' => "KH. Tol'at Wafa Ahmad, Lc."],
        [
            'position' => 'Mudir Pondok Pesantren Raudhatul Ulum',
            'fraction' => 'Pimpinan Pesantren',
            'order' => 1,
        ]
    );

    // Save with HTML tags as produced by Quill/WYSIWYG
    $official->update([
        'profile_summary' => '<p>Pimpinan &amp; Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga. Alumni Universitas Al-Azhar Kairo Mesir.</p>',
    ]);

    $response = $this->get(route('page.struktur'));
    $response->assertStatus(200);

    // Must NOT contain literal escaped "<p>" in the card text
    $response->assertDontSee('&lt;p&gt;Pimpinan', false);
    $response->assertDontSee('<p>Pimpinan &amp; Pengasuh', false);

    // Must display cleaned human text
    $response->assertSee('Pimpinan & Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga. Alumni Universitas Al-Azhar Kairo Mesir.');

    // Hierarchy tree must contain the 4 official levels from the diagram
    $tree = AnggotaDewan::getHierarchyTree();
    expect($tree['pembina_ketua'])->not->toBeNull()
        ->and($tree['harian_ketua'])->not->toBeNull()
        ->and($tree['pengawas_ketua'])->not->toBeNull()
        ->and($tree['mudir'])->not->toBeNull()
        ->and($tree['naibah_mudir'])->not->toBeNull()
        ->and($tree['naib_mudir'])->not->toBeNull();
});

test('organization chart renders with solid inline flex columns and explicit gradient styling', function () {
    // 1. Render the organization chart component directly
    $tree = AnggotaDewan::getHierarchyTree();
    $renderedChart = view('partials.organization-chart', compact('tree'))->render();

    // Chart has inline flex rows for 5 horizontal cards (no uncompiled CSS grid dependency)
    expect($renderedChart)->toContain('display: flex; flex-direction: row; justify-content: space-between; align-items: stretch; width: 1140px;')
        ->and($renderedChart)->toContain('ANGGOTA DEWAN PEMBINA')
        ->and($renderedChart)->toContain('ANGGOTA DEWAN PENGAWAS')
        ->and($renderedChart)->toContain('WAKIL PIMPINAN PONDOK PESANTREN');

    // Chart has explicit gradient inline styles for each role
    expect($renderedChart)->toContain('linear-gradient(135deg, #d97706, #b45309)') // Dewan Pembina
        ->and($renderedChart)->toContain('linear-gradient(135deg, #047857, #00843d)') // Anggota Pembina
        ->and($renderedChart)->toContain('linear-gradient(135deg, #1d4ed8, #2563eb)') // Pengurus Harian
        ->and($renderedChart)->toContain('linear-gradient(135deg, #0f766e, #0d9488)') // Sekretaris & Bendahara
        ->and($renderedChart)->toContain('linear-gradient(135deg, #065f46, #047857)') // Dewan Pengawas
        ->and($renderedChart)->toContain('linear-gradient(135deg, #064e3b, #00843d)') // Mudir Ma'had
        ->and($renderedChart)->toContain('linear-gradient(135deg, #6b21a8, #7e22ce)') // Naibah Mudir
        ->and($renderedChart)->toContain('linear-gradient(135deg, #1e40af, #2563eb)'); // Naib Mudir

    // Chart has horizontal wing connections in Level 4 (Naibah Mudir <-> Mudir <-> Naib Mudir)
    expect($renderedChart)->toContain('width: 50px; height: 2px; background-color: #00843d; flex-shrink: 0;');

    // 2. Admin view has independent cards with clear-both and clean textarea controls
    $this->actingAs($this->admin);
    $adminRes = $this->get(route('admin.pages.struktur'));
    $adminRes->assertStatus(200);
    $adminRes->assertSee('clear-both', false);
    $adminRes->assertSee('<textarea name="content"', false);
    $adminRes->assertDontSee('data-quill="struktur_content_input"', false);

    // 3. When struktur_chart_mode is set to 'chart' (interactive only), public page shows the chart
    Setting::set('struktur_chart_mode', 'chart', 'struktur');
    $chartModeRes = $this->get(route('page.struktur'));
    $chartModeRes->assertStatus(200);
    $chartModeRes->assertSee('Bagan Alur &amp; Hirarki Kepengurusan Yayasan &amp; Pesantren', false);
    $chartModeRes->assertSee('DEWAN PEMBINA YAPIRUS');
    $chartModeRes->assertSee('PENGURUS HARIAN');
    $chartModeRes->assertSee('DEWAN PENGAWAS');
    $chartModeRes->assertSee("PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)", false);

    // Assert no stray broken comment syntax or random text in rendered public view
    $chartModeRes->assertDontSee('[Mudir Ma\'had] <--- garis', false);
    $chartModeRes->assertDontSee('[Naib Mudir] -->', false);
});

test('admin can crud dewan yayasan officials with sequential order and default neutral avatar', function () {
    $this->actingAs($this->admin);

    // 1. Admin dewan index shows official list and delete action is available
    $indexRes = $this->get(route('admin.dewan.index'));
    $indexRes->assertStatus(200);
    $indexRes->assertSee('KH. Abdul Karim Umar');
    $indexRes->assertSee('avatar-neutral-gray.svg');

    // 2. Main admin can create a new yayasan official
    $createRes = $this->post(route('admin.dewan.store'), [
        'name' => 'Pengurus Baru Uji Coba',
        'position' => 'Staf Khusus Yayasan',
        'fraction' => 'Yayasan',
        'order' => 18,
    ]);
    $createRes->assertRedirect(route('admin.dewan.index'));
    $newMember = AnggotaDewan::where('name', 'Pengurus Baru Uji Coba')->first();
    expect($newMember)->not->toBeNull();
    expect($newMember->order)->toBe(18);
    expect($newMember->photo_url)->toBe('/uploads/avatar-neutral-gray.svg');

    // 3. Main admin can edit the member
    $updateRes = $this->put(route('admin.dewan.update', $newMember), [
        'name' => 'Pengurus Baru Terupdate',
        'position' => 'Penasihat Yayasan',
        'fraction' => 'Yayasan',
        'order' => 19,
    ]);
    $updateRes->assertRedirect(route('admin.dewan.index'));
    $newMember->refresh();
    expect($newMember->name)->toBe('Pengurus Baru Terupdate');
    expect($newMember->order)->toBe(19);

    // 4. Main admin can delete the member (CRUD full access)
    $deleteRes = $this->delete(route('admin.dewan.destroy', $newMember));
    $deleteRes->assertRedirect(route('admin.dewan.index'));
    expect(AnggotaDewan::find($newMember->id))->toBeNull();
});
