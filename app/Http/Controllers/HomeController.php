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
                'image' => '/uploads/campus-ishum.jpg',
                'btn_text' => 'Profil Singkat Pesantren',
                'btn_link' => route('page.tentang-kami', [], false),
            ],
            [
                'title' => 'Penerimaan Santri Baru (PSB) 2026/2027',
                'subtitle' => 'Mari Bergabung dengan Pesantren Modern Terpadu Berasrama: Al-Qur\'an, Dwi-Bahasa, dan Dirasah Islamiyah.',
                'image' => '/uploads/activities-robbani.webp',
                'btn_text' => 'Daftar PSB Online',
                'btn_link' => route('ppdb.index', [], false),
            ],
            [
                'title' => 'Kurikulum Terpadu & Muadalah Al-Azhar',
                'subtitle' => 'Memadukan Kurikulum Pondok Modern Gontor, Kementerian Agama, dan Dinas Pendidikan Nasional.',
                'image' => '/uploads/campus-ishum.jpg',
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

        // 8. Dewan Guru & Tenaga Kependidikan (Section 6-9 - 4 pendidik)
        $dewan = AnggotaDewan::orderBy('order', 'asc')->take(4)->get();

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
            ['url' => '/uploads/ishum/fasilitas_3427_IMG-20240528-WA0106-scaled.webp', 'title' => 'Gedung Kampus SMA IT Ishlahul Ummah Prabumulih'],
            ['url' => '/uploads/ishum/post_3442_IMG-20241020-WA0006-scaled.webp', 'title' => 'Aktivitas Belajar & Karakter Santri Terpadu'],
            ['url' => '/uploads/ishum/fasilitas_1274_Ruang-Lab-Komputer1.webp', 'title' => 'Laboratorium Komputer & Digital Santri'],
            ['url' => '/uploads/ishum/post_3460_IMG-20241020-WA0007-scaled.webp', 'title' => 'Pembinaan Disiplin & Kesiswaan Santri Ishum'],
            ['url' => '/uploads/ishum/fasilitas_1278_HALL-SIT-Ishlahul-Ummah_.webp', 'title' => 'Aula Pertemuan & Munaqosah Qur\'an SIT'],
            ['url' => '/uploads/ishum/post_3464_IMG-20241020-WA0005-scaled.webp', 'title' => 'Halaqah Tahfidz & Tartil Qur\'an Santri'],
        ];

        $fallbackRow2 = [
            ['url' => '/uploads/ishum/fasilitas_1275_R.-Lab-IPA.webp', 'title' => 'Laboratorium IPA & Eksperimen Sains Terpadu'],
            ['url' => '/uploads/ishum/post_3467_IMG-20241020-WA0004-scaled.webp', 'title' => 'Ibadah Yaumiyah & Pembiasaan Akhlakul Karimah'],
            ['url' => '/uploads/ishum/fasilitas_1377_IMG-20240528-WA0094-scaled.webp', 'title' => 'Gerbang Utama Kampus SMA IT Ishlahul Ummah'],
            ['url' => '/uploads/ishum/post_3472_IMG-20241020-WA0003-scaled.webp', 'title' => 'Muhadharah & Pembinaan Da\'i Muda Santri'],
            ['url' => '/uploads/ishum/fasilitas_2059_IMG-20221101-WA0010.webp', 'title' => 'Sarana Olahraga & Mushola Kampus Ishum'],
            ['url' => '/uploads/ishum/post_3478_IMG-20241020-WA0008-scaled.webp', 'title' => 'Ukhuwah Islamiyah & Kebersamaan Santri'],
            ['url' => '/uploads/ishum/prestasi_3513_IMG-20240928-WA0038.webp', 'title' => 'Apresiasi & Penganugerahan Prestasi Santri'],
            ['url' => '/uploads/ishum/fasilitas_3431_IMG-20241014-WA0013-scaled.webp', 'title' => 'Ruang UKS & Pelayanan Kesehatan Sekolah'],
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
