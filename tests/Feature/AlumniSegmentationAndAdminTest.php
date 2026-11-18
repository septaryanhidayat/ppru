<?php

use App\Models\Alumni;
use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::firstOrCreate(
        ['email' => 'admin_alumni_test@ppru.ac.id'],
        ['name' => 'Admin Test Alumni', 'password' => Hash::make('password123'), 'role' => 'admin']
    );
});

test('admin can access alumni index page with statistics and segmentation filters', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.alumni.index'));

    $response->assertStatus(200);
    $response->assertSee('Kelola Data Alumni');
    $response->assertSee('Total Alumni');
    $response->assertSee('Santriwan (Putra)');
    $response->assertSee('Santriwati (Putri)');
    $response->assertSee('Tahun Lulus');
    $response->assertSee('Tambah Data Alumni');
});

test('admin can create new alumni with simple form like data guru', function () {
    Storage::fake('public');
    $unit = UnitPendidikan::first();

    $response = $this->actingAs($this->admin)->post(route('admin.alumni.store'), [
        'name' => 'Fulan bin Fulan, Lc., M.Hum.',
        'gender' => 'putra',
        'graduation_year' => '2023',
        'unit_pendidikan_id' => $unit?->id,
        'activity' => 'Dosen Bahasa Arab di Universitas Al-Azhar Kairo',
        'bio' => 'Belajar tekun dan amalkan ilmu untuk kejayaan umat.',
        'phone' => '081298765432',
        'social_media' => '@fulan_alumni',
        'order' => 1,
        'is_published' => 1,
    ]);

    $response->assertRedirect(route('admin.alumni.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('alumnis', [
        'name' => 'Fulan bin Fulan, Lc., M.Hum.',
        'gender' => 'putra',
        'graduation_year' => '2023',
        'activity' => 'Dosen Bahasa Arab di Universitas Al-Azhar Kairo',
    ]);
});

test('admin can edit and update existing alumni data', function () {
    $alumni = Alumni::create([
        'name' => 'Siti Aisyah, S.Ked.',
        'gender' => 'putri',
        'graduation_year' => '2022',
        'activity' => 'Dokter Muda FK UNSRI',
    ]);

    $response = $this->actingAs($this->admin)->put(route('admin.alumni.update', $alumni), [
        'name' => 'dr. Siti Aisyah, Sp.A.',
        'gender' => 'putri',
        'graduation_year' => '2022',
        'activity' => 'Dokter Spesialis Anak di Palembang',
    ]);

    $response->assertRedirect(route('admin.alumni.index'));
    $response->assertSessionHas('success');

    expect($alumni->fresh()->name)->toBe('dr. Siti Aisyah, Sp.A.');
    expect($alumni->fresh()->activity)->toBe('Dokter Spesialis Anak di Palembang');
});

test('admin can delete alumni', function () {
    $alumni = Alumni::create([
        'name' => 'Alumni Hapus Test',
        'gender' => 'putra',
        'graduation_year' => '2019',
        'activity' => 'Testing activity',
    ]);

    $response = $this->actingAs($this->admin)->delete(route('admin.alumni.destroy', $alumni));

    $response->assertRedirect(route('admin.alumni.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('alumnis', ['id' => $alumni->id]);
});

test('public alumni page displays segmen tahun lulus, putra putri, and data alumni', function () {
    // Pastikan ada data putra & putri
    Alumni::create([
        'name' => 'Zaidan Santriwan Teladan',
        'gender' => 'putra',
        'graduation_year' => '2024',
        'activity' => 'Mahasiswa Teknik Elektro ITB Bandung',
        'is_published' => true,
    ]);

    Alumni::create([
        'name' => 'Maryam Santriwati Berprestasi',
        'gender' => 'putri',
        'graduation_year' => '2024',
        'activity' => 'Mahasiswi Kedokteran UGM Yogyakarta',
        'is_published' => true,
    ]);

    // Akses halaman publik tanpa filter (Semua)
    $responseAll = $this->get(route('alumni.index'));
    $responseAll->assertStatus(200);
    $responseAll->assertSee('Data &amp; Rekam Jejak Alumni', false);
    $responseAll->assertSee('Pilih Tahun Lulus (Angkatan)');
    $responseAll->assertSee('Segmen Santriwan (Putra) &amp; Santriwati (Putri)', false);
    $responseAll->assertSee('Zaidan Santriwan Teladan');
    $responseAll->assertSee('Maryam Santriwati Berprestasi');
    $responseAll->assertSee('Tahun 2024');

    // Filter Segmen Putra
    $responsePutra = $this->get(route('alumni.index', ['gender' => 'putra', 'year' => '2024']));
    $responsePutra->assertStatus(200);
    $responsePutra->assertSee('Zaidan Santriwan Teladan');
    $responsePutra->assertDontSee('Maryam Santriwati Berprestasi');

    // Filter Segmen Putri
    $responsePutri = $this->get(route('alumni.index', ['gender' => 'putri', 'year' => '2024']));
    $responsePutri->assertStatus(200);
    $responsePutri->assertSee('Maryam Santriwati Berprestasi');
    $responsePutri->assertDontSee('Zaidan Santriwan Teladan');
});
