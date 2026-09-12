<?php

use App\Models\PpdbRegistration;
use App\Models\User;
use App\Services\PpdbFormService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can add, customize, and delete dynamic fields for ppdb online form', function () {
    $admin = User::create([
        'name' => 'Admin PPDB',
        'email' => 'admin_dynamic@ishum.sch.id',
        'password' => Hash::make('Password123!'),
        'role' => 'admin',
    ]);

    // 1. Initial schema has standard fields
    $schema = PpdbFormService::getSchema();
    expect(count($schema))->toBeGreaterThan(10);

    // 2. Admin adds a custom text field: "Nomor Kartu Keluarga"
    $addResponse = $this->actingAs($admin)->post('/admin/ppdb/fields', [
        'label' => 'Nomor Kartu Keluarga',
        'section' => 'siswa',
        'type' => 'text',
        'placeholder' => 'Masukkan 16 digit no KK',
        'required' => '1',
    ]);
    $addResponse->assertRedirect(route('admin.ppdb.content', ['tab' => 'formulir']));

    $updatedSchema = PpdbFormService::getSchema();
    $customField = collect($updatedSchema)->firstWhere('label', 'Nomor Kartu Keluarga');
    expect($customField)->not->toBeNull();
    expect($customField['section'])->toBe('siswa');
    expect($customField['type'])->toBe('text');
    expect($customField['required'])->toBeTrue();

    // 3. Admin adds a custom select field: "Ukuran Seragam"
    $addSelectResponse = $this->actingAs($admin)->post('/admin/ppdb/fields', [
        'label' => 'Ukuran Seragam Siswa',
        'section' => 'tambahan',
        'type' => 'select',
        'options' => "S\nM\nL\nXL\nXXL",
        'required' => '0',
    ]);
    $addSelectResponse->assertRedirect(route('admin.ppdb.content', ['tab' => 'formulir']));

    $customSelectField = collect(PpdbFormService::getSchema())->firstWhere('label', 'Ukuran Seragam Siswa');
    expect($customSelectField)->not->toBeNull();
    expect($customSelectField['options'])->toContain('M');

    // 4. Public form renders the dynamic fields
    $formView = $this->get('/form_ppdb');
    $formView->assertStatus(200);
    $formView->assertSee('Nomor Kartu Keluarga');
    $formView->assertSee('Ukuran Seragam Siswa');

    // 5. Public user registers with dynamic custom fields
    Storage::fake('public');

    $postData = [
        'full_name' => 'Muhammad Bilal',
        'birth_place' => 'Prabumulih',
        'birth_date' => '2010-01-10',
        'gender' => 'Laki-laki',
        'address' => 'Jl. Anggrek No. 12',
        'living_with' => 'Orang Tua',
        'child_order' => 1,
        'siblings_count' => 2,
        'previous_school' => 'SMP IT Ishum',
        'phone' => '081234567899',
        'father_name' => 'Abdullah',
        'father_birth_place' => 'Prabumulih',
        'father_birth_date' => '1975-01-01',
        'father_address' => 'Jl. Anggrek No. 12',
        'father_education' => 'S1',
        'father_job' => 'PNS / Polisi / TNI',
        'father_income' => 'Rp 3.000.000 - Rp 5.000.000',
        'mother_name' => 'Aminah',
        'mother_birth_place' => 'Prabumulih',
        'mother_birth_date' => '1978-01-01',
        'mother_address' => 'Jl. Anggrek No. 12',
        'mother_education' => 'S1',
        'mother_job' => 'Ibu Rumah Tangga',
        'mother_income' => 'Tidak Berpenghasilan',
        'birth_certificate' => UploadedFile::fake()->create('akta.pdf', 200, 'application/pdf'),
        'payment_proof' => UploadedFile::fake()->image('bukti.jpg', 200, 200),
        $customField['key'] => '1671010101900001',
        $customSelectField['key'] => 'L',
    ];

    $submitResponse = $this->post('/form_ppdb', $postData);
    $registration = PpdbRegistration::where('full_name', 'Muhammad Bilal')->first();
    expect($registration)->not->toBeNull();
    $submitResponse->assertRedirect(route('ppdb.success', ['reg' => $registration->registration_number]));

    // Check extra_fields JSON column
    expect($registration->extra_fields)->not->toBeNull();
    expect($registration->extra_fields[$customField['key']]['value'])->toBe('1671010101900001');
    expect($registration->extra_fields[$customSelectField['key']]['value'])->toBe('L');

    // 6. Admin detail view shows extra fields
    $showResponse = $this->actingAs($admin)->get("/admin/ppdb/{$registration->id}");
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Data Isian Tambahan / Kustom');
    $showResponse->assertSee('1671010101900001');
    $showResponse->assertSee('Ukuran Seragam Siswa');

    // 7. Admin can delete a dynamic field
    $deleteResponse = $this->actingAs($admin)->delete("/admin/ppdb/fields/{$customField['key']}");
    $deleteResponse->assertRedirect(route('admin.ppdb.content', ['tab' => 'formulir']));

    $schemaAfterDelete = PpdbFormService::getSchema();
    expect(collect($schemaAfterDelete)->firstWhere('key', $customField['key']))->toBeNull();

    // 8. Admin can reset schema to default
    $resetResponse = $this->actingAs($admin)->post('/admin/ppdb/fields/reset');
    $resetResponse->assertRedirect(route('admin.ppdb.content', ['tab' => 'formulir']));

    $resetSchema = PpdbFormService::getSchema();
    expect(collect($resetSchema)->firstWhere('key', $customSelectField['key']))->toBeNull();
});
