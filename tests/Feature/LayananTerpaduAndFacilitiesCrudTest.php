<?php

use App\Models\Bidang;
use App\Models\Dpc;
use App\Models\ServiceSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('layanan terpadu portal page loads successfully with all services', function () {
    $response = $this->get('/layanan-terpadu-2');
    $response->assertStatus(200);
    $response->assertSee('LAYANAN TERPADU');
    $response->assertSee('Permohonan Izin Kunjungan ke Sekolah');
    $response->assertSee('Permohonan Kerja Sama');
    $response->assertSee('Permohonan Sewa Menyewa Barang Sekolah');
});

test('layanan izin kunjungan sekolah page displays exact requirements and accordions from original site', function () {
    $response = $this->get('/izin-sekolah');
    $response->assertStatus(200);
    $response->assertSee('PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH');
    $response->assertSee('Persyaratan Pelayanan');
    $response->assertSee('Pemohon memiliki akun pada system untuk melakukan permohonan kunjungan');
    $response->assertSee('Maksimal pengunjung 100 orang');
    $response->assertSee('Hari kunjungan adalah hari senin dan kamis');
    $response->assertSee('Waktu kunjungan adalah pukul 09.00-11.00 wib');
    $response->assertSee('Jangka Waktu Penyelesaian');
    $response->assertSee('Biaya dan Tarif');
    $response->assertSee('Produk Layanan');
    $response->assertSee('Pengaduan, Saran dan Masukan');
    $response->assertSee('Sertakan Surat');
    $response->assertSee('Sertakan KTP');
});

test('layanan permohonan kerja sama page displays exact requirements and accordions from original site', function () {
    $response = $this->get('/permohonan-kerja-sama');
    $response->assertStatus(200);
    $response->assertSee('PERMOHONAN KERJA SAMA');
    $response->assertSee('Persyaratan Pelayanan');
    $response->assertSee('Surat permohonan dari Pemerintah/Swasta/Industri/Yayasan/Organisasi/Instansi lainnya');
    $response->assertSee('Surat permohonan dari Individu (perorangan)');
    $response->assertSee('Sistem Mekanisme dan Prosedur');
    $response->assertSee('Jangka Waktu Penyelesaian');
    $response->assertSee('Biaya dan Tarif');
    $response->assertSee('Produk Layanan');
    $response->assertSee('Pengaduan, Saran dan Masukan');
});

test('layanan sewa menyewa barang page displays exact requirements and accordions from original site', function () {
    $response = $this->get('/sewa-barang');
    $response->assertStatus(200);
    $response->assertSee('PERMOHONAN SEWA MENYEWA BARANG MILIK SEKOLAH');
    $response->assertSee('Persyaratan Pelayanan');
    $response->assertSee('Individu (perorangan)');
    $response->assertSee('Fotokopi KTP');
    $response->assertSee('Fotokopi NPWP');
    $response->assertSee('Lembaga Organisasi');
    $response->assertSee('Sistem Mekanisme dan Prosedur');
    $response->assertSee('Jangka Waktu Penyelesaian');
    $response->assertSee('Biaya dan Tarif');
    $response->assertSee('Produk Layanan');
    $response->assertSee('Pengaduan, Saran dan Masukan');
});

test('layanan izin kunjungan sekolah form submission creates ServiceSubmission record with secure file uploads', function () {
    $fileSurat = UploadedFile::fake()->create('surat_permohonan.pdf', 150, 'application/pdf');
    $fileKtp = UploadedFile::fake()->image('ktp_pemohon.jpg', 600, 400);

    $postData = [
        'name' => 'Ahmad Santoso',
        'whatsapp' => '081234567890',
        'agency' => 'Universitas Sriwijaya',
        'purpose' => 'Studi tiru kurikulum tahfidz dan teknologi sekolah',
        'letter_file' => $fileSurat,
        'ktp_file' => $fileKtp,
    ];

    $submit = $this->post(route('layanan.izin.submit'), $postData);
    $submit->assertSessionHas('success');
    $submit->assertSessionHas('wa_url');
    $submit->assertRedirect(route('layanan.izin'));

    $this->assertDatabaseHas('service_submissions', [
        'service_type' => 'izin_kunjungan',
        'name' => 'Ahmad Santoso',
        'whatsapp' => '081234567890',
        'agency' => 'Universitas Sriwijaya',
        'status' => 'pending',
    ]);

    $submission = ServiceSubmission::where('name', 'Ahmad Santoso')->first();
    expect($submission->letter_path)->not->toBeNull();
    expect($submission->ktp_path)->not->toBeNull();
    expect(file_exists(public_path(ltrim($submission->letter_path, '/'))))->toBeTrue();

    // Clean up created fake file
    @unlink(public_path(ltrim($submission->letter_path, '/')));
    @unlink(public_path(ltrim($submission->ktp_path, '/')));
});

test('layanan permohonan kerja sama form submission creates ServiceSubmission record', function () {
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

    $this->assertDatabaseHas('service_submissions', [
        'service_type' => 'kerja_sama',
        'name' => 'Budi Pratama',
        'whatsapp' => '081298765432',
        'agency' => 'PT Mitra Edukasi Digital',
        'status' => 'pending',
    ]);
});

test('layanan sewa barang form submission creates ServiceSubmission record with npwp', function () {
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

    $this->assertDatabaseHas('service_submissions', [
        'service_type' => 'sewa_barang',
        'name' => 'Ustadz Ridwan',
        'whatsapp' => '082187654321',
        'agency' => 'Yayasan Sahabat Ummah',
        'status' => 'pending',
    ]);
});

test('admin can view layanan submissions, filter, update status, and delete', function () {
    $admin = User::factory()->create([
        'email' => 'admin_layanan@ishum.sch.id',
    ]);

    $submission = ServiceSubmission::create([
        'service_type' => 'izin_kunjungan',
        'name' => 'Dr. Hendra Wijaya',
        'agency' => 'Dinas Pendidikan',
        'whatsapp' => '081200001111',
        'purpose' => 'Kunjungan monitoring evaluasi kurikulum',
        'status' => 'pending',
    ]);

    // 1. Index page
    $indexResponse = $this->actingAs($admin)->get(route('admin.layanan.index'));
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('Kelola Permohonan Layanan Terpadu Sekolah');
    $indexResponse->assertSee('Dr. Hendra Wijaya');
    $indexResponse->assertSee('Dinas Pendidikan');

    // 2. Filter by type
    $filterResponse = $this->actingAs($admin)->get(route('admin.layanan.index', ['type' => 'izin_kunjungan']));
    $filterResponse->assertStatus(200);
    $filterResponse->assertSee('Dr. Hendra Wijaya');

    // 3. Show page
    $showResponse = $this->actingAs($admin)->get(route('admin.layanan.show', $submission));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Dr. Hendra Wijaya');
    $showResponse->assertSee('Kunjungan monitoring evaluasi kurikulum');

    // 4. Update status
    $updateResponse = $this->actingAs($admin)->post(route('admin.layanan.status', $submission), [
        'status' => 'approved',
        'admin_notes' => 'Disetujui untuk hari Kamis jam 09.30 WIB.',
    ]);
    $updateResponse->assertSessionHas('success');
    $this->assertDatabaseHas('service_submissions', [
        'id' => $submission->id,
        'status' => 'approved',
        'admin_notes' => 'Disetujui untuk hari Kamis jam 09.30 WIB.',
    ]);

    // 5. Delete submission
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.layanan.destroy', $submission));
    $deleteResponse->assertRedirect(route('admin.layanan.index'));
    $this->assertDatabaseMissing('service_submissions', ['id' => $submission->id]);
});

test('admin can manage and customize accordion contents and sentences for all services', function () {
    $admin = User::factory()->create([
        'email' => 'admin_content@ishum.sch.id',
    ]);

    // 1. View content editor
    $contentResponse = $this->actingAs($admin)->get(route('admin.layanan.content'));
    $contentResponse->assertStatus(200);
    $contentResponse->assertSee('Persyaratan, Prosedur &amp; Konten Layanan Terpadu', false);
    $contentResponse->assertSee('Persyaratan Pelayanan');

    // 2. Update accordions for izin sekolah
    $updateResponse = $this->actingAs($admin)->post(route('admin.layanan.content.update'), [
        'service_type' => 'izin',
        'titles' => ['Persyaratan Kunjungan Resmi Khusus', 'Waktu dan Ketentuan Khusus'],
        'contents' => [
            '<ul><li>Membawa surat tugas resmi dari kepala dinas</li></ul>',
            '<p>Kunjungan hanya dibuka pada jam kerja efektif.</p>',
        ],
    ]);
    $updateResponse->assertSessionHas('success');

    // Verify updated on public page
    $publicResponse = $this->get('/izin-sekolah');
    $publicResponse->assertStatus(200);
    $publicResponse->assertSee('Persyaratan Kunjungan Resmi Khusus');
    $publicResponse->assertSee('Membawa surat tugas resmi dari kepala dinas');
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
    $this->assertDatabaseHas('fasilitas', [
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
    $this->assertDatabaseHas('fasilitas', [
        'id' => $bidang->id,
        'name' => 'Laboratorium Multimedia Modern',
        'thumbnail' => '/uploads/lab-multimedia-v2.webp',
    ]);

    // Delete
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.bidang.destroy', $bidang));
    $deleteResponse->assertRedirect(route('admin.bidang.index'));
    $this->assertDatabaseMissing('fasilitas', ['id' => $bidang->id]);
});

test('admin can manage dpc (program unggulan sekolah) with thumbnail', function () {
    $admin = User::factory()->create([
        'email' => 'admin_dpc@ppru.ac.id',
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
    $this->assertDatabaseHas('program_unggulans', [
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
    $this->assertDatabaseHas('program_unggulans', [
        'id' => $dpc->id,
        'name' => 'Kelas Riset & KIR Nasional',
        'thumbnail' => '/uploads/kelas-riset-updated.webp',
    ]);

    // Delete
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.dpc.destroy', $dpc));
    $deleteResponse->assertRedirect(route('admin.dpc.index'));
    $this->assertDatabaseMissing('program_unggulans', ['id' => $dpc->id]);
});
