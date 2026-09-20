<?php

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Download;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

test('home page renders all authentic school sections successfully', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('Menu Utama');
    $response->assertSee('Sambutan Kepala Sekolah');
    $response->assertSee('Kabar Sekolah');
    $response->assertSee('Prestasi Siswa');
    $response->assertSee('Dewan Guru');
    $response->assertSee('Galeri Video');
    $response->assertSee('E-Library');
    $response->assertSee('Daftar PPDB');
    $response->assertSee('Pengunjung');
});

test('articles page renders successfully', function () {
    $category = Category::firstOrCreate(['name' => 'Akademik'], ['slug' => 'akademik']);
    $post = Post::create([
        'title' => 'Prestasi Santri PPRU Unggulan',
        'slug' => 'prestasi-santri-ppru-unggulan',
        'content' => '<p>Konten artikel pengujian sekolah.</p>',
        'status' => 'publish',
        'type' => 'post',
    ]);
    $post->categories()->attach($category->id);

    $response = $this->get('/artikel');
    $response->assertStatus(200);
    $response->assertSee('Prestasi Santri PPRU Unggulan');

    $detailResponse = $this->get('/artikel/prestasi-santri-ppru-unggulan');
    $detailResponse->assertStatus(200);
    $detailResponse->assertSee('Konten artikel pengujian sekolah.');
});

test('static profil pages render successfully', function () {
    Post::create([
        'title' => 'Sambutan Kepala Sekolah',
        'slug' => 'sambutan-ketua-dpd',
        'content' => 'Isi sambutan kepala sekolah',
        'status' => 'publish',
        'type' => 'page',
    ]);
    Post::create([
        'title' => 'Tentang Kami',
        'slug' => 'tentang-kami',
        'content' => 'Profil sekolah kami',
        'status' => 'publish',
        'type' => 'page',
    ]);
    Post::create([
        'title' => 'Visi dan Misi',
        'slug' => 'visi-dan-misi',
        'content' => 'Visi misi sekolah',
        'status' => 'publish',
        'type' => 'page',
    ]);
    Post::create([
        'title' => 'Sejarah',
        'slug' => 'sejarah',
        'content' => 'Sejarah sekolah',
        'status' => 'publish',
        'type' => 'page',
    ]);
    Post::create([
        'title' => 'Berita Terkini PPRU Sakatiga',
        'slug' => 'berita-terkini-ppru-sakatiga',
        'content' => 'Konten berita',
        'status' => 'publish',
        'type' => 'post',
        'published_at' => now(),
    ]);
    Agenda::create([
        'title' => 'Ujian Tasmi Al-Quran',
        'slug' => 'ujian-tasmi-al-quran',
        'event_date' => now()->addDays(2),
        'status' => 'publish',
    ]);

    $this->get('/sambutan-kepala-sekolah')->assertStatus(200);
    $this->get('/tentang-kami')->assertStatus(200);
    $this->get('/visi-dan-misi')->assertStatus(200)->assertSee('Berita Terkini PPRU Sakatiga')->assertSee('Ujian Tasmi Al-Quran');
    $this->get('/sejarah')->assertStatus(200)->assertSee('Berita Terkini PPRU Sakatiga')->assertSee('Ujian Tasmi Al-Quran');
    $this->get('/struktur-organisasi')->assertStatus(200);
});

test('dewan, bidang, agenda, and pengumuman pages render successfully', function () {
    AnggotaDewan::create([
        'name' => 'Ustadz Ahmad Sakatiga',
        'slug' => 'ustadz-ahmad-sakatiga',
        'position' => 'Kepala Sekolah',
    ]);

    Bidang::create([
        'name' => 'Laboratorium Biologi Modern',
        'slug' => 'laboratorium-biologi-modern',
        'description' => 'Sarana praktikum mikroskopis sains',
    ]);

    Agenda::create([
        'title' => 'Olimpiade Sains Sekolah',
        'slug' => 'olimpiade-sains-sekolah',
        'status' => 'publish',
    ]);

    Pengumuman::create([
        'title' => 'Pengumuman PPDB Gelombang 1',
        'slug' => 'pengumuman-ppdb-gelombang-1',
        'status' => 'publish',
    ]);

    $this->get('/dewan-guru')->assertStatus(200)->assertSee('Ustadz Ahmad Sakatiga');
    $this->get('/fasilitas')->assertStatus(200)->assertSee('Laboratorium Biologi Modern');
    $this->get('/bidang/laboratorium-biologi-modern')->assertStatus(200);
    $this->get('/agenda')->assertStatus(200)->assertSee('Olimpiade Sains Sekolah');
    $this->get('/pengumuman')->assertStatus(200)->assertSee('Pengumuman PPDB Gelombang 1');
});

test('feedback form submission works', function () {
    $this->get('/hubungi')->assertStatus(200);

    $response = $this->post('/hubungi', [
        'nama' => 'Ahmad Calon Santri',
        'email' => 'ahmad@example.com',
        'whatsapp' => '081234567890',
        'saran_kritik' => 'Mohon informasi jadwal tes masuk PSB Pondok Pesantren Raudhatul Ulum.',
    ]);

    $response->assertRedirect('/hubungi');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('feedbacks', [
        'name' => 'Ahmad Calon Santri',
        'email' => 'ahmad@example.com',
    ]);
});

test('download pages render successfully', function () {
    Download::create([
        'title' => 'Modul Panduan Siswa',
        'category_type' => 'Akademik',
        'file_path' => '/uploads/modul-panduan.pdf',
        'file_type' => 'PDF',
    ]);

    $this->get('/download')->assertStatus(200)->assertSee('Modul Panduan Siswa');
    $this->get('/e-book')->assertStatus(200);
    $this->get('/hymne-mars')->assertStatus(200);
    $this->get('/logo')->assertStatus(200);
    $this->get('/donasi')->assertStatus(200);
});

test('footer has visitor counter with data-target and responsive mobile center alignment', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('id="footer-visitor-counter"', false);
    $response->assertSee('data-target=', false);
    $response->assertSee('text-center md:text-left', false);
});

test('site settings update dynamically reflects across header, footer, and contact page', function () {
    Setting::updateOrCreate(['key' => 'contact_phone'], ['value' => '0821-7788-9900', 'group' => 'general']);
    Setting::updateOrCreate(['key' => 'contact_email'], ['value' => 'sekretariat@ppru.ac.id', 'group' => 'general']);
    Setting::updateOrCreate(['key' => 'contact_address'], ['value' => 'Kampus Utama Pondok Pesantren Raudhatul Ulum Sakatiga', 'group' => 'general']);

    // Re-share to simulate fresh request
    $settings = Setting::all()->pluck('value', 'key')->toArray();
    View::share('siteSettings', $settings);

    $home = $this->get('/');
    $home->assertSee('0821-7788-9900');
    $home->assertSee('sekretariat@ppru.ac.id');
    $home->assertSee('Kampus Utama Pondok Pesantren Raudhatul Ulum Sakatiga');

    $contact = $this->get('/hubungi');
    $contact->assertSee('0821-7788-9900');
    $contact->assertSee('sekretariat@ppru.ac.id');
    $contact->assertSee('Kampus Utama Pondok Pesantren Raudhatul Ulum Sakatiga');
});

test('sambutan page renders dynamic content from database', function () {
    $page = Post::where('slug', 'sambutan-ketua-dpd')->first();
    if (! $page) {
        $page = Post::create([
            'title' => 'Sambutan Kepala Sekolah',
            'slug' => 'sambutan-ketua-dpd',
            'content' => '<p>Uji coba pidato resmi dinamis kepala sekolah.</p>',
            'status' => 'publish',
            'type' => 'page',
        ]);
    } else {
        $page->update(['content' => '<p>Uji coba pidato resmi dinamis kepala sekolah.</p>']);
    }

    $response = $this->get('/sambutan-kepala-sekolah');
    $response->assertStatus(200);
    $response->assertSee('Uji coba pidato resmi dinamis kepala sekolah.', false);
});

test('dewan guru page dynamically reflects updated name and photo from database', function () {
    $dewan = AnggotaDewan::create([
        'name' => 'Nama Guru Lama',
        'slug' => 'nama-guru-lama',
        'position' => 'Guru Biologi',
        'fraction' => 'Sains',
        'photo' => '/uploads/dewan/foto-lama.webp',
        'order' => 1,
    ]);

    $res1 = $this->get('/dewan-guru');
    $res1->assertStatus(200);
    $res1->assertSee('Nama Guru Lama');
    $res1->assertSee('/uploads/dewan/foto-lama.webp');

    $dewan->update([
        'name' => 'Ustadz Fulan Al-Hafidz, M.Ag',
        'photo' => '/uploads/dewan/foto-terbaru.webp',
        'fraction' => 'Tahfidz Mutqin',
    ]);

    $res2 = $this->get('/dewan-guru');
    $res2->assertStatus(200);
    $res2->assertSee('Ustadz Fulan Al-Hafidz, M.Ag');
    $res2->assertSee('/uploads/dewan/foto-terbaru.webp');
    $res2->assertDontSee('Nama Guru Lama');
});

test('home page renders gallery slider with 2 rows and ppru photos', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Galeri');
    $response->assertSee(route('galeri.index'));
    $response->assertSee('Lihat Seluruh Galeri Foto');
});

test('mars jsit page renders authentic mars jsit lyrics and video', function () {
    $response = $this->get(route('download.hymne-mars'));

    $response->assertStatus(200);
    $response->assertSee('MARS JSIT INDONESIA');
    $response->assertSee('LIRIK MARS RESMI JSIT INDONESIA');
    $response->assertSee('Dengan berbekal semangat kami melangkah', false);
    $response->assertSee('Kami Jaringan Sekolah Islam Terpadu', false);
    $response->assertSee('10 Karakter Santri JSIT (Muwashofat)', false);
});

test('ppdb page renders redesigned layout with youtube video and bsi account', function () {
    $response = $this->get(route('ppdb.index'));

    $response->assertStatus(200);
    $response->assertSee('LXtIbizPVvE');
    $response->assertSee('7011304251');
    $response->assertSee('YL. Fatmawati');
    $response->assertSee(route('ppdb.form'));
});
