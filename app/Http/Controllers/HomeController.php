<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Download;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hero slides data - Pondok Pesantren Raudhatul Ulum Sakatiga
        $heroSlides = [
            [
                'title' => 'Pondok Pesantren Raudhatul Ulum',
                'subtitle' => 'Basis Kaderisasi Generasi Terbaik (Khoiru Ummah) yang Bermanfaat Luas dan Berdaya Saing Global di Sakatiga Ogan Ilir.',
                'image' => '/uploads/campus-ppru-sakatiga.webp',
                'btn_text' => 'Profil Singkat Pesantren',
                'btn_link' => route('page.tentang-kami', [], false),
            ],
            [
                'title' => 'Penerimaan Santri Baru (PSB) 2026/2027',
                'subtitle' => 'Mari Bergabung dengan Pesantren Modern Terpadu Berasrama: Al-Qur\'an, Dwi-Bahasa, dan Dirasah Islamiyah.',
                'image' => '/uploads/activities-ppru-sakatiga.webp',
                'btn_text' => 'Daftar PSB Online',
                'btn_link' => route('ppdb.index', [], false),
            ],
            [
                'title' => 'Kurikulum Terpadu & Muadalah Al-Azhar',
                'subtitle' => 'Memadukan Kurikulum Pondok Modern Gontor, Kementerian Agama, dan Dinas Pendidikan Nasional.',
                'image' => '/uploads/campus-ppru-sakatiga.webp',
                'btn_text' => 'Sambutan Mudir PPRU',
                'btn_link' => route('page.sambutan', [], false),
            ],
        ];

        // 2. Sambutan Mudir Pesantren
        $sambutan = Post::where('type', 'page')->where('slug', 'sambutan-kepala-sekolah')->first();

        // 3. Ambil semua post publik untuk fallback
        $allPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(50)
            ->get();

        $featuredPost = $allPosts->first();
        $sidePosts = $allPosts->slice(1, 4);

        // 4. Program Unggulan & Ekstrakurikuler (Section 5 - 8 posts)
        $senayanPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->where(function ($q) {
                $q->whereHas('categories', fn ($c) => $c->whereIn('slug', ['kesiswaan-ekskul', 'tahfidz-keislaman', 'akademik-riset']))
                    ->orWhereHas('tags', fn ($t) => $t->whereIn('slug', ['ekskul', 'pramuka', 'tahfidz', 'robotika']));
            })
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        if ($senayanPosts->count() < 8) {
            $senayanPosts = $senayanPosts->merge($allPosts)->unique('id')->take(8);
        }

        // 5. Berita Prestasi Siswa (Section 3 - 8 posts)
        $fraksiPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->where(function ($q) {
                $q->whereHas('categories', fn ($c) => $c->whereIn('slug', ['prestasi-siswa', 'akademik-riset']))
                    ->orWhereHas('tags', fn ($t) => $t->whereIn('slug', ['prestasi', 'juara', 'olimpiade', 'sains']));
            })
            ->whereNotIn('id', $senayanPosts->pluck('id'))
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(8)
            ->get();

        if ($fraksiPosts->count() < 8) {
            $fallbackPosts = $allPosts->whereNotIn('id', $senayanPosts->pluck('id'));
            $fraksiPosts = $fraksiPosts->merge($fallbackPosts)->unique('id')->take(8);
        }

        // 6. Kabar Akademik & Kurikulum (Section 4 Kolom 1 - 6 posts)
        $nasionalPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->whereHas('categories', fn ($c) => $c->whereIn('slug', ['akademik-riset', 'prestasi-siswa']))
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        if ($nasionalPosts->count() < 4) {
            $nasionalPosts = $allPosts->sortByDesc('published_at')->take(6);
        }

        // 7. Kegiatan Kesiswaan & Karakter (Section 4 Kolom 2 - 6 posts)
        $daerahPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->whereHas('categories', fn ($c) => $c->whereIn('slug', ['kesiswaan-ekskul', 'tahfidz-keislaman', 'kabar-kampus']))
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        if ($daerahPosts->count() < 4) {
            $daerahPosts = $allPosts->sortByDesc('published_at')->slice(2, 6);
        }

        // 8. Pengurus Yayasan (YAPIRUS) & Pimpinan Pesantren (Section 8)
        $dewan = AnggotaDewan::whereIn('fraction', ['Yayasan', 'Pimpinan Pesantren'])
            ->orderBy('order', 'asc')
            ->take(8)
            ->get();

        if ($dewan->isEmpty()) {
            $dewan = AnggotaDewan::orderBy('order', 'asc')->take(8)->get();
        }

        // 9. Video Profil & Kegiatan Sekolah (Section 10 - 6 videos)
        $videos = Video::latest()->take(6)->get();

        // 10. Pengumuman & Agenda (Section 12 - 4 items each)
        $announcements = Pengumuman::where('status', 'publish')->latest()->take(4)->get();
        $agendas = Agenda::where('status', 'publish')->orderBy('event_date', 'desc')->take(4)->get();

        // 11. Galeri Foto Kegiatan Siswa & Sekolah
        $dbGallery = Post::whereIn('type', ['gallery', 'attachment'])
            ->where('status', 'publish')
            ->whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->latest('created_at')
            ->take(16)
            ->get()
            ->map(fn ($p) => ['url' => $p->featured_image, 'title' => $p->title])
            ->toArray();

        $fallbackRow1 = [
            ['url' => '/uploads/ppru-haflah.webp', 'title' => 'Haflah Takhtiman & Wisuda Akbar Santri Pondok Pesantren Raudhatul Ulum'],
            ['url' => '/uploads/ppru-muhadharah.webp', 'title' => 'Muhadharah 3 Bahasa: Arab, Inggris & Indonesia Santri PPRU'],
            ['url' => '/uploads/ppru-mtq.webp', 'title' => 'Kafilah Musabaqah Tilawatil Qur\'an (MTQ) Santri Raudhatul Ulum'],
            ['url' => '/uploads/ppru-pramuka.webp', 'title' => 'Perkemahan Pramuka Santri Pondok Pesantren Raudhatul Ulum Sakatiga'],
            ['url' => '/uploads/ppru-alazhar.webp', 'title' => 'Kunjungan Delegasi Muadalah Universitas Al-Azhar Kairo Mesir'],
            ['url' => '/uploads/ppru-tahfidz.webp', 'title' => 'Halaqah Tahfizhul Qur\'an 30 Juz Santri MATQULARU'],
        ];

        $fallbackRow2 = [
            ['url' => '/uploads/ppru-sarasehan.webp', 'title' => 'Sarasehan Asatidz & Halaqah Keilmuan Ulama Pesantren Raudhatul Ulum'],
            ['url' => '/uploads/ppru-debat.webp', 'title' => 'Debat Ilmiah Bahasa Arab & Bahasa Inggris Santri PPRU'],
            ['url' => '/uploads/ppru-ksm.webp', 'title' => 'Kompetisi Sains Madrasah (KSM) Santri MARU & MTs RU'],
            ['url' => '/uploads/ppru-ppsn.webp', 'title' => 'Kontingen Perkemahan Pramuka Santri Nusantara (PPSN) PPRU'],
            ['url' => '/uploads/ppru-jatidiri.webp', 'title' => 'Pembinaan 10 Jati Diri Santri Pondok Pesantren Raudhatul Ulum'],
            ['url' => '/uploads/campus-ppru-sakatiga.webp', 'title' => 'Kampus Terpadu & Masjid Utama Pondok Pesantren Raudhatul Ulum Sakatiga'],
            ['url' => '/uploads/activities-ppru-sakatiga.webp', 'title' => 'Latihan Memanah & Olahraga Sunnah Santri Raudhatul Ulum'],
        ];

        if (! empty($dbGallery)) {
            $half = (int) ceil(count($dbGallery) / 2);
            $galleryRow1 = array_slice($dbGallery, 0, $half);
            $galleryRow2 = array_slice($dbGallery, $half);
        } else {
            $galleryRow1 = $fallbackRow1;
            $galleryRow2 = $fallbackRow2;
        }

        $galleryPhotos = array_merge($galleryRow1, $galleryRow2);

        // 12. E-Library & Modul Pembelajaran Siswa (Section 15)
        $ebookDownloads = Download::where('category_type', 'E-Book')->orderBy('id', 'asc')->get();

        if ($ebookDownloads->isNotEmpty()) {
            $ebooks = $ebookDownloads->map(function ($dl) {
                return [
                    'id' => $dl->id,
                    'title' => $dl->title,
                    'cover' => $dl->cover_image ?: '/uploads/covers/cover-tahfidz-mutqin.webp',
                    'pdf' => route('download.file', $dl->id, false),
                    'direct_file' => $dl->file_path,
                ];
            })->toArray();
        } else {
            $ebooks = [];
        }

        // 13. Testimonials (Section 16)
        $testimonials = Testimonial::where('status', 'publish')->take(4)->get();

        // 14. Unit Pendidikan PPRU
        $unitPendidikans = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        // 15. Taujih & Nasihat Pimpinan Pesantren
        $taujihPosts = Post::posts()
            ->published()
            ->with(['categories'])
            ->whereHas('categories', fn ($c) => $c->where('slug', 'taujih'))
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();
        if ($taujihPosts->isEmpty()) {
            $taujihPosts = $allPosts->take(4);
        }

        // 16. Visitor counter hits
        $visitorHits = view()->shared('visitorHits') ?? '53.512';

        // 17. Popup Banner Settings
        $popupSettings = [
            'active' => Setting::get('popup_active', '1'),
            'image' => Setting::get('popup_image', '/uploads/popup/popup-ppdb.webp'),
            'title' => Setting::get('popup_title', 'Penerimaan Peserta Didik Baru (PPDB) TP 2026/2027'),
            'subtitle' => Setting::get('popup_subtitle', 'Pondok Pesantren Raudhatul Ulum Sakatiga Ogan Ilir'),
            'link' => Setting::get('popup_link', '/ppdb'),
            'target' => Setting::get('popup_target', '_self'),
            'button_text' => Setting::get('popup_button_text', 'Daftar PSB Sekarang'),
        ];

        return view('frontend.home', compact(
            'heroSlides',
            'sambutan',
            'featuredPost',
            'sidePosts',
            'fraksiPosts',
            'nasionalPosts',
            'daerahPosts',
            'senayanPosts',
            'dewan',
            'videos',
            'announcements',
            'agendas',
            'galleryPhotos',
            'galleryRow1',
            'galleryRow2',
            'ebooks',
            'testimonials',
            'unitPendidikans',
            'taujihPosts',
            'visitorHits',
            'popupSettings'
        ));
    }
}
