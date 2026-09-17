<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'admin_static_test@ppru.ac.id'],
        [
            'name' => 'Static Page Admin',
            'password' => Hash::make('StaticPassword2026!'),
            'role' => 'super_admin',
        ]
    );
});

test('admin can access specialized static pages management views and see reorganized sidebar', function () {
    $this->actingAs($this->admin);

    // 1. Pages Index
    $resPages = $this->get(route('admin.pages.index'));
    $resPages->assertStatus(200);
    $resPages->assertSee('Daftar Halaman Profil');
    $resPages->assertSee('Halaman Donasi');
    $resPages->assertSee('Mars &amp; Hymne', false);
    $resPages->assertSee('Logo &amp; Identitas', false);
    $resPages->assertSee('Portal Layanan', false);
    $resPages->assertSee('Halaman &amp; Konten Dinamis', false);

    // 2. Donasi Editor
    $resDonasi = $this->get(route('admin.pages.donasi'));
    $resDonasi->assertStatus(200);
    $resDonasi->assertSee('Kelola Halaman Donasi &amp; Infaq', false);
    $resDonasi->assertSee('Rekening Bank 1 (Utama)');

    // 3. Hymne & Mars Editor
    $resMars = $this->get(route('admin.pages.hymne-mars'));
    $resMars->assertStatus(200);
    $resMars->assertSee('Kelola Mars &amp; Hymne', false);
    $resMars->assertSee('Video Player Mars YouTube');

    // 4. Logo & Identitas Editor
    $resLogo = $this->get(route('admin.pages.logo'));
    $resLogo->assertStatus(200);
    $resLogo->assertSee('Kelola Logo &amp; Identitas Visual', false);
    $resLogo->assertSee('Filosofi Lambang Sekolah');

    // 5. Layanan Content Editor (including Portal Utama tab)
    $resLayanan = $this->get(route('admin.layanan.content'));
    $resLayanan->assertStatus(200);
    $resLayanan->assertSee('Portal Utama &amp; 3 Kartu Layanan', false);
});

test('admin can update donation page settings and see them reflected dynamically on frontend', function () {
    $this->actingAs($this->admin);

    $updatePayload = [
        'donation_hero_title' => 'Infaq Wakaf Pembangunan Laboratorium PPRU',
        'donation_bank_1_name' => 'Bank Sumsel Babel Syariah Cabang Ogan Ilir',
        'donation_bank_1_code' => '120',
        'donation_bank_1_rekening' => '801-9999-8888',
        'donation_bank_1_holder' => 'YAPIRUS WAKAF LAB PENDIDIKAN',
        'donation_bank_1_badge' => 'Rekening Resmi Prioritas',
        'donation_bank_1_btn_text' => 'Salin Rekening Sumsel Babel',
        'donation_confirm_phone' => '081299998888',
        'donation_confirm_btn_text' => 'Kirim Bukti ke Bendahara',
    ];

    $res = $this->post(route('admin.pages.donasi.update'), $updatePayload);
    $res->assertRedirect(route('admin.pages.donasi'));
    $res->assertSessionHas('success');

    // Check frontend /donasi
    $frontend = $this->get('/donasi');
    $frontend->assertStatus(200);
    $frontend->assertSee('Infaq Wakaf Pembangunan Laboratorium PPRU');
    $frontend->assertSee('Bank Sumsel Babel Syariah Cabang Ogan Ilir');
    $frontend->assertSee('801-9999-8888');
    $frontend->assertSee('YAPIRUS WAKAF LAB PENDIDIKAN');
    $frontend->assertSee('Rekening Resmi Prioritas');
    $frontend->assertSee('Salin Rekening Sumsel Babel');
    $frontend->assertSee('Kirim Bukti ke Bendahara');
    $frontend->assertSee('081299998888');
});

test('admin can update mars & hymne settings and see them reflected dynamically on frontend', function () {
    $this->actingAs($this->admin);

    $updatePayload = [
        'mars_page_title' => 'Lagu Kebangsaan Santri Raudhatul Ulum',
        'mars_title' => 'MARS RESMI SANTRI PPRU',
        'mars_youtube_url' => 'https://www.youtube.com/watch?v=customPPRUVid',
        'mars_youtube_embed' => 'https://www.youtube.com/embed/customPPRUVid',
        'mars_youtube_btn_text' => 'Tonton Video Mars Resmi',
        'mars_lyrics_heading' => 'TEKS LIRIK LENGKAP MARS PPRU',
        'mars_lyrics_content' => "Bangkitlah santri Raudhatul Ulum\nMenuntut ilmu berakhlak Qur'ani\nBerjuang membina umat",
        'mars_characters_title' => 'Karakter Unggul Santri Rabbani',
    ];

    $res = $this->post(route('admin.pages.hymne-mars.update'), $updatePayload);
    $res->assertRedirect(route('admin.pages.hymne-mars'));
    $res->assertSessionHas('success');

    // Check frontend /hymne-mars
    $frontend = $this->get('/hymne-mars');
    $frontend->assertStatus(200);
    $frontend->assertSee('Lagu Kebangsaan Santri Raudhatul Ulum');
    $frontend->assertSee('MARS RESMI SANTRI PPRU');
    $frontend->assertSee('customPPRUVid');
    $frontend->assertSee('Tonton Video Mars Resmi');
    $frontend->assertSee('TEKS LIRIK LENGKAP MARS PPRU');
    $frontend->assertSee('Bangkitlah santri Raudhatul Ulum');
    $frontend->assertSee('Karakter Unggul Santri Rabbani');
});

test('admin can update logo settings and see them reflected dynamically on frontend', function () {
    $this->actingAs($this->admin);

    $updatePayload = [
        'logo_page_title' => 'Identitas Grafis & Logo Resmi PPRU',
        'logo_section_title' => 'Lambang Kehormatan Pondok Pesantren Raudhatul Ulum',
        'logo_download_btn_text' => 'Unduh Logo Resolusi Master Asli PNG',
        'logo_philo_1_title' => 'Perisai Keimanan Kokoh',
        'logo_philo_1_desc' => 'Melambangkan aqidah yang lurus dan kokoh bagai benteng baja.',
        'logo_color_1_name' => 'Hijau Khairu Ummah',
        'logo_color_1_hex' => '#0A5C2D',
    ];

    $res = $this->post(route('admin.pages.logo.update'), $updatePayload);
    $res->assertRedirect(route('admin.pages.logo'));
    $res->assertSessionHas('success');

    // Check frontend /logo (route: download.logo)
    $frontend = $this->get(route('download.logo'));
    $frontend->assertStatus(200);
    $frontend->assertSee('Identitas Grafis &amp; Logo Resmi PPRU', false);
    $frontend->assertSee('Lambang Kehormatan Pondok Pesantren Raudhatul Ulum');
    $frontend->assertSee('Unduh Logo Resolusi Master Asli PNG');
    $frontend->assertSee('Perisai Keimanan Kokoh');
    $frontend->assertSee('Melambangkan aqidah yang lurus dan kokoh bagai benteng baja.');
    $frontend->assertSee('Hijau Khairu Ummah');
    $frontend->assertSee('#0A5C2D');
});

test('admin can update portal layanan settings and see them reflected dynamically on frontend', function () {
    $this->actingAs($this->admin);

    $updatePayload = [
        'service_type' => 'portal',
        'ptsp_page_title' => 'PORTAL RESMI LAYANAN TERPADU PPRU',
        'ptsp_card1_title' => 'Layanan Kunjungan Edukatif & Studi Tiru',
        'ptsp_card1_btn' => 'Daftar Kunjungan Sekarang',
        'ptsp_helpdesk_btn_text' => 'WhatsApp Customer Care Humas',
    ];

    $res = $this->post(route('admin.layanan.content.update'), $updatePayload);
    $res->assertRedirect(route('admin.layanan.content', ['tab' => 'portal']));
    $res->assertSessionHas('success');

    // Check frontend /layanan-terpadu
    $frontend = $this->get('/layanan-terpadu');
    $frontend->assertStatus(200);
    $frontend->assertSee('PORTAL RESMI LAYANAN TERPADU PPRU');
    $frontend->assertSee('Layanan Kunjungan Edukatif &amp; Studi Tiru', false);
    $frontend->assertSee('Daftar Kunjungan Sekarang');
    $frontend->assertSee('WhatsApp Customer Care Humas');
});

test('admin can update sambutan mudir metadata and see it reflected dynamically on frontend', function () {
    $this->actingAs($this->admin);

    $page = Post::firstOrCreate(
        ['slug' => 'sambutan'],
        [
            'title' => 'Kata Sambutan Mudir Pesantren',
            'type' => 'page',
            'author_id' => $this->admin->id,
            'content' => '<p>Selamat datang di PPRU Sakatiga.</p>',
        ]
    );

    $updatePayload = [
        'title' => 'Kata Sambutan Mudir Pesantren PPRU',
        'content' => '<p>Sambutan resmi pimpinan pondok.</p>',
        'mudir_name' => 'KH. Tol\'at Wafa Ahmad, Lc., M.H.',
        'mudir_position' => 'Pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga',
        'mudir_quote' => 'Mendidik dengan hati untuk kemuliaan peradaban Islam.',
        'mudir_badge' => 'Akreditasi Paripurna A & Piagam Al-Azhar',
        'sambutan_cta_btn1_text' => 'Daftar Santri Baru Sekarang',
    ];

    $res = $this->put(route('admin.pages.update', $page), $updatePayload);
    $res->assertRedirect(route('admin.pages.index'));
    $res->assertSessionHas('success');

    // Check frontend /sambutan
    $frontend = $this->get('/sambutan');
    $frontend->assertStatus(200);
    $frontend->assertSee('KH. Tol\'at Wafa Ahmad, Lc., M.H.');
    $frontend->assertSee('Pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga');
    $frontend->assertSee('Mendidik dengan hati untuk kemuliaan peradaban Islam.');
    $frontend->assertSee('Akreditasi Paripurna A &amp; Piagam Al-Azhar', false);
    $frontend->assertSee('Daftar Santri Baru Sekarang');
});
