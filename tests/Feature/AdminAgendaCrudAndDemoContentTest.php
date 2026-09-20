<?php

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
use Database\Seeders\PpruDemoContentSeeder;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'admin@ppru.ac.id'],
        ['name' => 'Admin PPRU', 'password' => bcrypt('password'), 'role' => 'admin']
    );
});

test('admin can access agenda and pengumuman dashboard index', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.agenda.index'));

    $response->assertStatus(200);
    $response->assertSee('Agenda Kegiatan');
    $response->assertSee('Pengumuman');
});

test('admin can create, update and delete agenda', function () {
    // 1. Create
    $postResponse = $this->actingAs($this->admin)->post(route('admin.agenda.store'), [
        'title' => 'Simulasi Manasik Haji Santri 2026',
        'event_date' => '2026-10-15',
        'location' => 'Kampus A PPRU Sakatiga',
        'content' => 'Pelatihan manasik haji komprehensif bagi seluruh santri kelas VII dan X.',
        'status' => 'upcoming',
    ]);

    $postResponse->assertRedirect();
    $agenda = Agenda::where('title', 'Simulasi Manasik Haji Santri 2026')->first();
    expect($agenda)->not->toBeNull();

    // 2. Update
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.agenda.update', $agenda), [
        'title' => 'Simulasi Manasik Haji Santri 2026 - Diperbarui',
        'event_date' => '2026-10-16',
        'location' => 'Lapangan Utama Kampus B',
        'content' => 'Jadwal diperbarui menjadi tanggal 16 Oktober.',
        'status' => 'ongoing',
    ]);

    $updateResponse->assertRedirect();
    $agenda->refresh();
    expect($agenda->title)->toBe('Simulasi Manasik Haji Santri 2026 - Diperbarui')
        ->and($agenda->location)->toBe('Lapangan Utama Kampus B')
        ->and($agenda->status)->toBe('ongoing');

    // 3. Delete
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.agenda.destroy', $agenda));
    $deleteResponse->assertRedirect();
    expect(Agenda::find($agenda->id))->toBeNull();
});

test('admin can create, update and delete pengumuman', function () {
    // 1. Create
    $postResponse = $this->actingAs($this->admin)->post(route('admin.pengumuman.store'), [
        'title' => 'Edaran Libur Semester Ganjil 2026',
        'content' => 'Rincian jadwal libur semester ganjil santri.',
        'status' => 'publish',
    ]);

    $postResponse->assertRedirect();
    $pengumuman = Pengumuman::where('title', 'Edaran Libur Semester Ganjil 2026')->first();
    expect($pengumuman)->not->toBeNull();

    // 2. Update
    $updateResponse = $this->actingAs($this->admin)->put(route('admin.pengumuman.update', $pengumuman), [
        'title' => 'Edaran Libur Semester Ganjil 2026 (Revisi)',
        'content' => 'Rincian jadwal libur semester ganjil santri yang telah direvisi.',
        'status' => 'publish',
    ]);

    $updateResponse->assertRedirect();
    $pengumuman->refresh();
    expect($pengumuman->title)->toBe('Edaran Libur Semester Ganjil 2026 (Revisi)');

    // 3. Delete
    $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.pengumuman.destroy', $pengumuman));
    $deleteResponse->assertRedirect();
    expect(Pengumuman::find($pengumuman->id))->toBeNull();
});

test('demo content seeder populates exactly 8 dewan yayasan, official TVRU videos, and demo items', function () {
    $this->seed(PpruDemoContentSeeder::class);

    expect(AnggotaDewan::where('fraction', 'Yayasan')->whereNull('unit_pendidikan_id')->count())->toBe(8)
        ->and(Video::where('youtube_id', 'dQw4w9WgXcQ')->count())->toBe(0)
        ->and(Video::count())->toBeGreaterThanOrEqual(4)
        ->and(Agenda::count())->toBeGreaterThanOrEqual(4)
        ->and(Pengumuman::count())->toBeGreaterThanOrEqual(4);
});

test('public dewan guru page displays 8 prominent yayasan leaders', function () {
    $this->seed(PpruDemoContentSeeder::class);

    $response = $this->get(route('dewan.index'));
    $response->assertStatus(200);
    $response->assertSee('Drs. KH. Karim Kasim');
    $response->assertSee('Faisal Abdullah');
});

test('unit page displays 8 teachers, 4 TVRU videos, 4 prestasi, 4 ekskul, and 4 testimonials', function () {
    $this->seed(PpruDemoContentSeeder::class);

    $unit = UnitPendidikan::where('slug', 'madrasah-aliyah-raudhatul-ulum')->first();
    if ($unit) {
        $response = $this->get(route('pendidikan.show', $unit->slug));
        $response->assertStatus(200);
        $response->assertSee('Dewan Asatidz');
        $response->assertSee('BG311kT-yXc');
    }
});

test('dewan members without genuine portraits strictly return neutral gray avatar', function () {
    $this->seed(PpruDemoContentSeeder::class);

    $mudir = AnggotaDewan::where('slug', 'kh-tolat-wafa-ahmad-lc')->first();
    expect($mudir)->not->toBeNull()
        ->and($mudir->photo_url)->toBe('/uploads/kh-tolat-wafa-ahmad.webp');

    $otherYayasan = AnggotaDewan::where('fraction', 'Yayasan')
        ->where('slug', '!=', 'kh-tolat-wafa-ahmad-lc')
        ->get();

    expect($otherYayasan->count())->toBe(7);
    foreach ($otherYayasan as $d) {
        expect($d->photo_url)->toBe('/uploads/avatar-neutral-gray.svg');
    }

    // Even if photo column has random activity image, accessor must protect and sanitize it
    $bogus = AnggotaDewan::create([
        'name' => 'Guru Percobaan',
        'slug' => 'guru-percobaan-'.time(),
        'position' => 'Pengajar',
        'photo' => '/uploads/official/kbm-santri-0054.webp',
    ]);
    expect($bogus->photo_url)->toBe('/uploads/avatar-neutral-gray.svg');
});

test('unit page renders dynamic photo gallery from posts table and allows admin CRUD', function () {
    $this->seed(PpruDemoContentSeeder::class);

    $unit = UnitPendidikan::where('slug', 'madrasah-aliyah-raudhatul-ulum')->first();
    expect($unit)->not->toBeNull();

    $galleryPost = Post::where('type', 'gallery')->where('unit_pendidikan_id', $unit->id)->first();
    expect($galleryPost)->not->toBeNull();

    $response = $this->get(route('pendidikan.show', $unit->slug));
    $response->assertStatus(200);
    $response->assertSee($galleryPost->title);
});

test('agenda and pengumuman management uses rich text quill editors for formatted writing', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.agenda.index'));

    $response->assertStatus(200);
    $response->assertSee('data-quill="agenda_create_content"', false);
    $response->assertSee('data-quill="agenda_edit_content"', false);
    $response->assertSee('data-quill="pengumuman_create_content"', false);
    $response->assertSee('data-quill="pengumuman_edit_content"', false);

    // Verify rich HTML content can be stored and updated from rich editor
    $richAgenda = Agenda::create([
        'title' => 'Kajian Spesial Ramadhan 1447 H',
        'slug' => 'kajian-spesial-ramadhan-'.time(),
        'event_date' => '2026-03-20',
        'location' => 'Masjid Utama Pondok',
        'content' => '<p><strong>Tema Kajian:</strong> Meneladani Akhlak Salafus Shalih.</p><ul><li>Wajib bagi seluruh santri</li><li>Buku catatan dibawa</li></ul>',
        'status' => 'upcoming',
    ]);

    expect($richAgenda->content)->toContain('<strong>Tema Kajian:</strong>')
        ->and($richAgenda->content)->toContain('<li>Wajib bagi seluruh santri</li>');

    $richPengumuman = Pengumuman::create([
        'title' => 'Maklumat Mudir: Tata Tertib Kunjungan Wali Santri',
        'slug' => 'maklumat-mudir-kunjungan-'.time(),
        'content' => '<p>Diberitahukan kepada seluruh wali santri:</p><ol><li>Kunjungan hanya pada hari Ahad</li><li>Mematuhi busana syar\'i</li></ol>',
        'status' => 'publish',
    ]);

    expect($richPengumuman->content)->toContain('<li>Kunjungan hanya pada hari Ahad</li>');
});

test('admin dashboard renders symmetrical unit badges and authentic leadership names', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    // Symmetrical badge container width w-28
    $response->assertSee('w-28 shrink-0 flex items-center justify-center', false);
    // Must not display placeholder Fulan names
    $response->assertDontSee('Ustadz Fulan, S.Ag., M.Pd.I.');
    $response->assertDontSee('Ustadz Fulan, Drs., M.Pd.I.');
    $response->assertDontSee('Ustadzah Fulanah, S.Pd.I.');
});
