<?php

use App\Models\Bidang;
use App\Models\Dpc;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('layanan terpadu portal page loads successfully with all services', function () {
    $response = $this->get('/layanan-terpadu-2');
    $response->assertStatus(200);
    $response->assertSee('LAYANAN TERPADU');
    $response->assertSee('Permohonan Izin Kunjungan ke Sekolah');
    $response->assertSee('Permohonan Kerja Sama');
    $response->assertSee('Permohonan Sewa Menyewa Barang Sekolah');
});

test('layanan izin kunjungan sekolah page loads and form submission works', function () {
    $response = $this->get('/izin-sekolah');
    $response->assertStatus(200);
    $response->assertSee('Permohonan Izin Kunjungan');

    $postData = [
        'name' => 'Ahmad Santoso',
        'whatsapp' => '081234567890',
        'agency' => 'Universitas Sriwijaya',
        'purpose' => 'Studi tiru kurikulum tahfidz dan teknologi sekolah',
    ];

    $submit = $this->post(route('layanan.izin.submit'), $postData);
    $submit->assertSessionHas('success');
    $submit->assertSessionHas('wa_url');
    $submit->assertRedirect(route('layanan.izin'));
});

test('layanan permohonan kerja sama page loads and form submission works', function () {
    $response = $this->get('/permohonan-kerja-sama');
    $response->assertStatus(200);
    $response->assertSee('Permohonan Kerja Sama');

    $postData = [
        'name' => 'Budi Pratama',
        'whatsapp' => '081298765432',
        'agency' => 'PT Mitra Edukasi Digital',
        'purpose' => 'Program kemitraan pelatihan coding dan beasiswa prestasi',
    ];

    $submit = $this->post(route('layanan.kerjasama.submit'), $postData);
    $submit->assertSessionHas('success');
    $submit->assertSessionHas('wa_url');
    $submit->assertRedirect(route('layanan.kerjasama'));
});

test('layanan sewa barang page loads and form submission works', function () {
    $response = $this->get('/sewa-barang');
    $response->assertStatus(200);
    $response->assertSee('Permohonan Sewa');

    $postData = [
        'name' => 'Ustadz Ridwan',
        'whatsapp' => '082187654321',
        'agency' => 'Yayasan Sahabat Ummah',
        'purpose' => 'Sewa Aula Serbaguna dan Sound System untuk Seminar Parenting Islami',
    ];

    $submit = $this->post(route('layanan.sewa.submit'), $postData);
    $submit->assertSessionHas('success');
    $submit->assertSessionHas('wa_url');
    $submit->assertRedirect(route('layanan.sewa'));
});

test('struktur organisasi page does not contain fabricated leader names', function () {
    $response = $this->get('/struktur-organisasi');
    $response->assertStatus(200);
    $response->assertSee('Struktur Organisasi');
    // Ensure no made up names
    $response->assertDontSee('Dr. H. Ahmad Dahlan, M.Pd');
    $response->assertDontSee('Ustadz Fulan bin Fulan');
});

test('admin can manage bidang (fasilitas & sarana sekolah) with thumbnail', function () {
    $admin = User::factory()->create([
        'email' => 'admin_bidang@ishum.sch.id',
    ]);

    // Create
    $response = $this->actingAs($admin)->post(route('admin.bidang.store'), [
        'name' => 'Laboratorium Multimedia dan Robotika',
        'description' => 'Sarana riset dan praktikum komputer coding.',
        'icon' => 'fa-solid fa-laptop-code',
        'thumbnail' => '/uploads/lab-multimedia.webp',
        'order' => 1,
    ]);

    $response->assertRedirect(route('admin.bidang.index'));
    $this->assertDatabaseHas('bidangs', [
        'name' => 'Laboratorium Multimedia dan Robotika',
        'thumbnail' => '/uploads/lab-multimedia.webp',
    ]);

    $bidang = Bidang::where('name', 'Laboratorium Multimedia dan Robotika')->first();

    // Update
    $updateResponse = $this->actingAs($admin)->put(route('admin.bidang.update', $bidang), [
        'name' => 'Laboratorium Multimedia Modern',
        'description' => 'Sarana riset komputer dan robotika santri terkini.',
        'icon' => 'fa-solid fa-microchip',
        'thumbnail' => '/uploads/lab-multimedia-v2.webp',
        'order' => 2,
    ]);

    $updateResponse->assertRedirect(route('admin.bidang.index'));
    $this->assertDatabaseHas('bidangs', [
        'id' => $bidang->id,
        'name' => 'Laboratorium Multimedia Modern',
        'thumbnail' => '/uploads/lab-multimedia-v2.webp',
    ]);

    // Delete
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.bidang.destroy', $bidang));
    $deleteResponse->assertRedirect(route('admin.bidang.index'));
    $this->assertDatabaseMissing('bidangs', ['id' => $bidang->id]);
});

test('admin can manage dpc (program unggulan sekolah) with thumbnail', function () {
    $admin = User::factory()->create([
        'email' => 'admin_dpc@ishum.sch.id',
    ]);

    // Create
    $response = $this->actingAs($admin)->post(route('admin.dpc.store'), [
        'name' => 'Kelas Riset Ilmiah dan Olimpiade Sains',
        'head_name' => 'Ustadzah Nurul Hidayati, M.Si.',
        'address' => 'Sains & Teknologi',
        'description' => 'Bimbingan intensif persiapan KSN dan karya ilmiah remaja.',
        'thumbnail' => '/uploads/kelas-riset.webp',
        'order' => 1,
    ]);

    $response->assertRedirect(route('admin.dpc.index'));
    $this->assertDatabaseHas('dpcs', [
        'name' => 'Kelas Riset Ilmiah dan Olimpiade Sains',
        'address' => 'Sains & Teknologi',
        'thumbnail' => '/uploads/kelas-riset.webp',
    ]);

    $dpc = Dpc::where('name', 'Kelas Riset Ilmiah dan Olimpiade Sains')->first();

    // Update
    $updateResponse = $this->actingAs($admin)->put(route('admin.dpc.update', $dpc), [
        'name' => 'Kelas Riset & KIR Nasional',
        'head_name' => 'Ustadzah Nurul Hidayati, M.Si.',
        'address' => 'Akademik & Riset',
        'description' => 'Bimbingan juara olimpiade sains dan publikasi karya ilmiah remaja.',
        'thumbnail' => '/uploads/kelas-riset-updated.webp',
        'order' => 3,
    ]);

    $updateResponse->assertRedirect(route('admin.dpc.index'));
    $this->assertDatabaseHas('dpcs', [
        'id' => $dpc->id,
        'name' => 'Kelas Riset & KIR Nasional',
        'thumbnail' => '/uploads/kelas-riset-updated.webp',
    ]);

    // Delete
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.dpc.destroy', $dpc));
    $deleteResponse->assertRedirect(route('admin.dpc.index'));
    $this->assertDatabaseMissing('dpcs', ['id' => $dpc->id]);
});
