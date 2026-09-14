<?php

use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('public can view spmb landing page and form', function () {
    $response = $this->get('/ppdb');
    $response->assertStatus(200);
    $response->assertSee('7011304251');
    $response->assertSee('PSB PONDOK PESANTREN RAUDHATUL ULUM');

    $formResponse = $this->get('/form_ppdb');
    $formResponse->assertStatus(200);
    $formResponse->assertSee('Formulir Pendaftaran');
    $formResponse->assertSee('Kirim');
});

test('public can register through ppdb form successfully', function () {
    Storage::fake('public');

    $postData = [
        'full_name' => 'Ahmad Rabbani',
        'birth_place' => 'Prabumulih',
        'birth_date' => '2010-05-15',
        'gender' => 'Laki-laki',
        'address' => 'Jl. Jenderal Sudirman No. 45 Prabumulih',
        'living_with' => 'Orang Tua',
        'child_order' => 1,
        'siblings_count' => 3,
        'previous_school' => 'SMP IT Ishlahul Ummah',
        'nisn' => '0098765432',
        'hobby' => 'Membaca',
        'favorite_subject' => 'Matematika',
        'ambition' => 'Dokter',
        'achievements' => 'Juara 1 MTQ Tingkat Kota Prabumulih',
        'phone' => '081234567890',
        'father_name' => 'Bambang Supriyanto',
        'father_birth_place' => 'Palembang',
        'father_birth_date' => '1980-01-01',
        'father_address' => 'Jl. Jenderal Sudirman No. 45 Prabumulih',
        'father_education' => 'S1',
        'father_job' => 'PNS / ASN',
        'father_income' => 'Rp 5.000.000 - Rp 10.000.000',
        'father_phone' => '081298765432',
        'mother_name' => 'Siti Fatimah',
        'mother_birth_place' => 'Prabumulih',
        'mother_birth_date' => '1983-02-02',
        'mother_address' => 'Jl. Jenderal Sudirman No. 45 Prabumulih',
        'mother_education' => 'S1',
        'mother_job' => 'Ibu Rumah Tangga',
        'mother_income' => '< Rp 2.000.000',
        'mother_phone' => '081398765432',
        'birth_certificate' => UploadedFile::fake()->create('akta_kelahiran.pdf', 500, 'application/pdf'),
        'payment_proof' => UploadedFile::fake()->image('bukti_transfer_bsi.jpg', 600, 600),
    ];

    $response = $this->post('/form_ppdb', $postData);

    $registration = PpdbRegistration::where('nisn', '0098765432')->first();
    expect($registration)->not->toBeNull();
    $response->assertRedirect(route('ppdb.success', ['reg' => $registration->registration_number]));
    expect($registration->full_name)->toBe('Ahmad Rabbani');
    expect($registration->status)->toBe('pending');
    expect($registration->registration_number)->toContain('PPDB-');
    expect($registration->birth_certificate_path)->not->toBeNull();
    expect($registration->payment_proof_path)->not->toBeNull();

    // Verify success page shows registration number
    $successResponse = $this->withSession(['ppdb_registered_id' => $registration->id])->get('/ppdb/sukses');
    $successResponse->assertStatus(200);
    $successResponse->assertSee($registration->registration_number);
    $successResponse->assertSee('Ahmad Rabbani');
});

test('admin can view and manage ppdb registrations', function () {
    $admin = User::create([
        'name' => 'Admin PPDB',
        'email' => 'admin_ppdb@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    $applicant = PpdbRegistration::create([
        'registration_number' => 'PPDB-2026-9999',
        'full_name' => 'Fatimah Az-Zahra',
        'birth_place' => 'Prabumulih',
        'birth_date' => '2010-08-20',
        'gender' => 'Perempuan',
        'address' => 'Prabumulih Timur',
        'living_with' => 'Orang Tua',
        'child_order' => 2,
        'siblings_count' => 2,
        'previous_school' => 'MTs Negeri 1 Prabumulih',
        'nisn' => '0091122334',
        'hobby' => 'Menulis',
        'ambition' => 'Dosen',
        'phone' => '082188776655',
        'father_name' => 'Muhammad Ali',
        'father_birth_place' => 'Prabumulih',
        'father_birth_date' => '1978-04-12',
        'father_address' => 'Prabumulih Timur',
        'father_education' => 'S1',
        'father_job' => 'Wiraswasta',
        'father_income' => 'Rp 5.000.000 - Rp 10.000.000',
        'father_phone' => '082155443322',
        'mother_name' => 'Khadijah',
        'mother_birth_place' => 'Prabumulih',
        'mother_birth_date' => '1982-06-15',
        'mother_address' => 'Prabumulih Timur',
        'mother_education' => 'SMA',
        'mother_job' => 'Ibu Rumah Tangga',
        'mother_income' => '< Rp 2.000.000',
        'mother_phone' => '082155443311',
        'status' => 'pending',
    ]);

    // 1. Index
    $indexResponse = $this->actingAs($admin)->get('/admin/ppdb');
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('Fatimah Az-Zahra');
    $indexResponse->assertSee('PPDB-2026-9999');

    // 2. Show
    $showResponse = $this->actingAs($admin)->get("/admin/ppdb/{$applicant->id}");
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Fatimah Az-Zahra');
    $showResponse->assertSee('MTs Negeri 1 Prabumulih');

    // 3. Status update
    $statusResponse = $this->actingAs($admin)->put("/admin/ppdb/{$applicant->id}/status", [
        'status' => 'accepted',
        'notes' => 'Berkas pendaftaran lengkap dan pembayaran terverifikasi.',
    ]);
    $statusResponse->assertRedirect();
    expect($applicant->fresh()->status)->toBe('accepted');
    expect($applicant->fresh()->notes)->toBe('Berkas pendaftaran lengkap dan pembayaran terverifikasi.');

    // 4. Print registration proof
    $printResponse = $this->actingAs($admin)->get("/admin/ppdb/{$applicant->id}/print");
    $printResponse->assertStatus(200);
    $printResponse->assertSee('Tanda Bukti Pendaftaran PPDB');
    $printResponse->assertSee('PPDB-2026-9999');

    // 5. Delete
    $deleteResponse = $this->actingAs($admin)->delete("/admin/ppdb/{$applicant->id}");
    $deleteResponse->assertRedirect(route('admin.ppdb.index'));
    $this->assertDatabaseMissing('ppdb_registrations', ['id' => $applicant->id]);
});

test('admin can manage ppdb content and form flexibility settings', function () {
    $admin = User::create([
        'name' => 'Admin PPDB',
        'email' => 'admin_content@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    // 1. View content settings page
    $contentView = $this->actingAs($admin)->get('/admin/ppdb/content');
    $contentView->assertStatus(200);
    $contentView->assertSee('Konten &amp; 10 Menu PPDB', false);
    $contentView->assertSee('Kustomisasi Formulir Online');

    // 2. Update content & 10 menus
    $postData = [
        'ppdb_status' => '1',
        'ppdb_year' => '2026/2027',
        'ppdb_wave' => 'Gelombang 1 Unggulan',
        'ppdb_promo' => 'Diskon 50% Khusus Pendaftar Awal',
        'ppdb_tagline' => 'Sekolah Islam Terpadu Pilihan Utama.',
        'ppdb_youtube_id' => 'IrPVG8CYjRc',
        'ppdb_video_title' => 'Video Profil Kampus SMA IT Ishum',
        'ppdb_operational_weekday' => 'Senin - Jumat: 08.00 - 15.00 WIB',
        'ppdb_operational_weekend' => 'Sabtu: 08.00 - 12.00 WIB',
        'ppdb_secretariat' => 'Gedung SMA IT Ishum Karang Raja',
        'ppdb_registration_fee' => 'Rp 250.000,-',
        'ppdb_bank_name' => 'Bank Syariah Indonesia (BSI)',
        'ppdb_bank_code' => '451',
        'ppdb_bank_account' => '7011304251',
        'ppdb_bank_holder' => 'YL. Fatmawati',
        'ppdb_hotline_phone' => '0821-8268-0647',
        'ppdb_hotline_name' => 'Admin Hotline PPDB',
        'ppdb_hotline_2_phone' => '0822-8157-3615',
        'ppdb_hotline_2_name' => 'Ust. Agi',
        'ppdb_alur' => "Langkah 1: Transfer biaya pendaftaran\nLangkah 2: Isi formulir online\nLangkah 3: Konfirmasi via WA",
        'ppdb_syarat' => "Syarat 1: Akta kelahiran\nSyarat 2: Kartu Keluarga\nSyarat 3: Foto 3x4",
        'ppdb_prestasi' => 'Jalur Juara 1-3 OSN dan Tahfidz',
        'ppdb_tahfidz' => 'Jalur minimal 3 Juz',
        'ppdb_alumni' => 'Keringanan khusus lulusan SMPIT Ishum',
        'ppdb_mandiri' => 'Jalur tes akademik dan tahsin',
        'ppdb_jadwal_gelombang' => "Gelombang 1: Oktober - Desember\nGelombang 2: Januari - April",
        'ppdb_biaya' => 'Biaya formulir Rp 250.000 dan seragam lengkap',
        'ppdb_boarding' => 'Pilihan Boarding Asrama dan Full Day School',
        'ppdb_kelulusan' => 'Pengumuman via website dan WA',
        'ppdb_closing_title' => 'Terima Kasih Atas Kepercayaan Anda',
        'ppdb_closing_desc' => 'Semoga barokah dan sukses dunia akhirat.',
        'ppdb_form_status' => '1',
        'ppdb_form_closed_message' => 'Pendaftaran gelombang ini telah ditutup.',
        'ppdb_form_announcement' => 'Simpan nomor WhatsApp panitia.',
        'ppdb_form_waves' => "Gelombang 1\nGelombang 2",
        'ppdb_form_tracks' => "Reguler\nTahfidz\nPrestasi",
        'ppdb_form_programs' => "Boarding School\nFull Day School",
        'ppdb_form_require_payment' => '1',
        'ppdb_form_require_birth_cert' => '1',
        'ppdb_form_nisn_rule' => 'optional',
        'ppdb_form_show_achievements' => '1',
        'ppdb_form_show_hobbies' => '1',
        'ppdb_form_require_parent_income' => '1',
        'ppdb_form_wa_confirm' => '1',
    ];

    $updateResponse = $this->actingAs($admin)->post('/admin/ppdb/content', $postData);
    $updateResponse->assertRedirect();

    // Verify public page reflects updated content
    $publicResponse = $this->get('/ppdb');
    $publicResponse->assertStatus(200);
    $publicResponse->assertSee('Gelombang 1 Unggulan');
    $publicResponse->assertSee('Diskon 50% Khusus Pendaftar Awal');
    $publicResponse->assertSee('Langkah 1: Transfer biaya pendaftaran');
    $publicResponse->assertSee('Keringanan khusus lulusan SMPIT Ishum');
    $publicResponse->assertSee('Jalur Juara 1-3 OSN dan Tahfidz');

    // Verify exports
    $excelResponse = $this->actingAs($admin)->get('/admin/ppdb/export/excel');
    $excelResponse->assertStatus(200);
    $excelResponse->assertHeader('content-type', 'text/csv; charset=UTF-8');

    $pdfResponse = $this->actingAs($admin)->get('/admin/ppdb/export/pdf');
    $pdfResponse->assertStatus(200);
    $pdfResponse->assertSee('REKAPITULASI PENDAFTARAN PESERTA DIDIK BARU');
});

test('public logo page renders properly', function () {
    $response = $this->get('/logo');
    $response->assertStatus(200);
    $response->assertSee('Filosofi Lambang Sekolah');
    $response->assertSee('Palet Warna Resmi');
    $response->assertSee('Varian Logo Sekolah Lainnya');

    $redirectResponse = $this->get('/download/logo');
    $redirectResponse->assertRedirect(route('download.logo'));
});
