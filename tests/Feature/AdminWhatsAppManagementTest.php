<?php

use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Setting helper methods formatWaNumber and waUrl work correctly', function () {
    expect(Setting::formatWaNumber('0812-7890-1950'))->toBe('6281278901950');
    expect(Setting::formatWaNumber('+62 812-7890-1950'))->toBe('6281278901950');
    expect(Setting::formatWaNumber('6281278901950'))->toBe('6281278901950');
    expect(Setting::formatWaNumber(''))->toBe('6281278901950');
    expect(Setting::formatWaNumber(null))->toBe('6281278901950');

    $url = Setting::waUrl('0812-7890-1950', 'Halo Admin');
    expect($url)->toBe('https://wa.me/6281278901950?text=Halo+Admin');

    $urlNoText = Setting::waUrl('0812-7890-1950');
    expect($urlNoText)->toBe('https://wa.me/6281278901950');
});

test('unauthenticated users cannot access whatsapp admin menu', function () {
    $this->get('/admin/whatsapp')->assertRedirect('/login');
});

test('unit admin cannot access global whatsapp admin menu', function () {
    $unit = UnitPendidikan::first();
    $unitAdmin = User::create([
        'name' => 'Admin Unit MARU',
        'email' => 'admin.unit.test@ppru.ac.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin_unit',
        'unit_pendidikan_id' => $unit?->id,
    ]);

    $this->actingAs($unitAdmin);
    $this->get('/admin/whatsapp')->assertStatus(403);
});

test('admin can view whatsapp channels and update all numbers and units', function () {
    $admin = User::create([
        'name' => 'Admin Utama PPRU',
        'email' => 'admin.wa.test@ppru.ac.id',
        'password' => Hash::make('Secret12345!'),
        'role' => 'admin',
    ]);

    $this->actingAs($admin);

    // 1. Visit index page
    $response = $this->get('/admin/whatsapp');
    $response->assertStatus(200);
    $response->assertSee('Pengaturan Nomor WhatsApp Antar-Halaman');
    $response->assertSee('Saluran Utama');
    $response->assertSee('PSB Pusat Pondok');
    $response->assertSee('Redaksi Artikel Alumni (IKARUS)');

    // 2. Perform update
    $unit = UnitPendidikan::first();
    $this->assertNotNull($unit);

    $postData = [
        'contact_whatsapp' => '0812-9999-1111',
        'contact_whatsapp_label' => 'Sekretariat Utama Testing',
        'wa_helpdesk_message' => 'Pesan uji coba konsultasi utama',
        'ppdb_hotline_phone' => '0812-8888-2222',
        'ppdb_hotline_name' => 'Ustadz Ahmad PSB',
        'ppdb_hotline_2_phone' => '0812-7777-3333',
        'ppdb_hotline_2_name' => 'Ustadz Budi PSB',
        'ppdb_wa_template' => 'Pesan uji coba pendaftaran santri baru',
        'wa_alumni_article' => '0812-6666-4444',
        'wa_alumni_article_template' => 'Pesan uji coba kirim artikel alumni',
        'wa_santri_article' => '0812-5555-5555',
        'wa_santri_article_template' => 'Pesan uji coba kirim naskah santri',
        'ptsp_helpdesk_phone' => '0812-4444-6666',
        'ptsp_helpdesk_wa_template' => 'Pesan uji coba layanan terpadu',
        'wa_layanan_sewa' => '0812-3333-7777',
        'wa_layanan_kerjasama' => '0812-2222-8888',
        'wa_layanan_izin' => '0812-1111-9999',
        'donation_confirm_phone' => '0812-0000-1234',
        'donation_confirm_text' => 'Pesan uji coba konfirmasi donasi',
        'units' => [
            $unit->id => [
                'phone' => '0813-1234-5678',
            ],
        ],
    ];

    $updateResponse = $this->post('/admin/whatsapp', $postData);
    $updateResponse->assertRedirect();
    $updateResponse->assertSessionHas('success');

    // 3. Verify in database
    $this->assertEquals('0812-9999-1111', Setting::get('contact_whatsapp'));
    $this->assertEquals('0812-8888-2222', Setting::get('ppdb_hotline_phone'));
    $this->assertEquals('0812-6666-4444', Setting::get('wa_alumni_article'));
    $this->assertEquals('0812-5555-5555', Setting::get('wa_santri_article'));
    $this->assertEquals('0812-0000-1234', Setting::get('donation_confirm_phone'));

    $unit->refresh();
    $this->assertEquals('0813-1234-5678', $unit->phone);

    // 4. Verify public pages receive these updated numbers
    $homeResponse = $this->get('/');
    $homeResponse->assertStatus(200);
    $homeResponse->assertSee('6281299991111'); // formatted wa.me in header/footer

    $ikarusResponse = $this->get('/ikarus');
    $ikarusResponse->assertStatus(200);
    $ikarusResponse->assertSee('6281266664444'); // alumni wa.me link

    $ppdbResponse = $this->get('/ppdb');
    $ppdbResponse->assertStatus(200);
    $ppdbResponse->assertSee('6281288882222'); // ppdb hotline wa.me link
});
