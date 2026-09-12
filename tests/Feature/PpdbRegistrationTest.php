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
    $response->assertSee('SPMB SMA IT ISHLAHUL UMMAH');

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
