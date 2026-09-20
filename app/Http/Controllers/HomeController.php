<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Download;
use App\Models\Dpc;
use App\Models\HeroSlide;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\ProgramUnggulan;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\Video;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Dynamic Hero Slides from Database (Defensive fallback if migration pending)
        $dbHeroSlides = collect();
        if (Schema::hasTable('hero_slides')) {
            $dbHeroSlides = HeroSlide::active()->orderBy('order', 'asc')->get();
        }

        if ($dbHeroSlides->isNotEmpty()) {
            $heroSlides = $dbHeroSlides->map(fn ($s) => [
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'badge' => $s->badge ?: (Setting::get('home_hero_badge', 'Pondok Pesantren Raudhatul Ulum Sakatiga')),
                'image' => $s->image_url,
                'btn_text' => $s->btn_primary_text ?: 'Profil Singkat Pesantren',
                'btn_link' => $s->btn_primary_url ?: route('page.tentang-kami', [], false),
                'btn_sec_text' => $s->btn_secondary_text ?: 'Pendaftaran PSB',
                'btn_sec_link' => $s->btn_secondary_url ?: route('ppdb.index', [], false),
            ])->toArray();
        } else {
            $heroSlides = [
                [
                    'title' => 'Pondok Pesantren Raudhatul Ulum',
                    'subtitle' => 'Basis Kaderisasi Generasi Terbaik (Khoiru Ummah) yang Bermanfaat Luas dan Berdaya Saing Global di Sakatiga Ogan Ilir.',
                    'badge' => 'Pondok Pesantren Raudhatul Ulum Sakatiga',
                    'image' => '/uploads/official/drone-raudhatul-ulum.webp',
                    'btn_text' => 'Profil Singkat Pesantren',
                    'btn_link' => route('page.tentang-kami', [], false),
                    'btn_sec_text' => 'Pendaftaran PSB',
                    'btn_sec_link' => route('ppdb.index', [], false),
                ],
                [
                    'title' => 'Penerimaan Santri Baru (PSB) 2026/2027',
                    'subtitle' => 'Mari Bergabung dengan Pesantren Modern Terpadu Berasrama: Al-Qur\'an, Dwi-Bahasa, dan Dirasah Islamiyah.',
                    'badge' => 'PSB Gelombang 1 Dibuka',
                    'image' => '/uploads/official/drone-danau-telok-putih.webp',
                    'btn_text' => 'Daftar PSB Online',
                    'btn_link' => route('ppdb.index', [], false),
                    'btn_sec_text' => 'Brosur & Biaya',
                    'btn_sec_link' => route('download.index', [], false),
                ],
                [
                    'title' => 'Kurikulum Terpadu & Muadalah Al-Azhar',
                    'subtitle' => 'Memadukan Kurikulum Pondok Modern Gontor, Kementerian Agama, dan Dinas Pendidikan Nasional.',
                    'badge' => 'Muadalah Al-Azhar Kairo Mesir',
                    'image' => '/uploads/official/ngaji-sore.webp',
                    'btn_text' => 'Sambutan Mudir PPRU',
                    'btn_link' => route('page.sambutan', [], false),
                    'btn_sec_text' => 'Unit Pendidikan',
                    'btn_sec_link' => route('pendidikan.index', [], false),
                ],
            ];
        }

        // 2. Sambutan Mudir Pesantren
        $sambutan = Post::where('type', 'page')->whereIn('slug', ['sambutan-mudir', 'sambutan-kepala-sekolah'])->first();

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
        $prestasiPosts = Post::posts()
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

        if ($prestasiPosts->count() < 8) {
            $fallbackPosts = $allPosts->whereNotIn('id', $senayanPosts->pluck('id'));
            $prestasiPosts = $prestasiPosts->merge($fallbackPosts)->unique('id')->take(8);
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
            ->orderByDesc('id')
            ->take(16)
            ->get()
            ->map(fn ($p) => ['url' => $p->featured_image, 'title' => $p->title])
            ->toArray();

        $fallbackRow1 = [
            ['url' => '/uploads/official/drone-raudhatul-ulum.webp', 'title' => 'Panorama Kawasan Kampus Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga'],
            ['url' => '/uploads/official/ngaji-sore.webp', 'title' => 'Kajian Kitab Turats & Halaqah Ngaji Sore Santri di Masjid Jami\' PPRU'],
            ['url' => '/uploads/official/panahan-santri.webp', 'title' => 'Latihan Olahraga Sunnah Memanah (Archery) Santri Raudhatul Ulum'],
            ['url' => '/uploads/official/drone-danau-telok-putih.webp', 'title' => 'Pemandangan Asri Danau Telok Putih Kawasan Kampus Pesantren'],
            ['url' => '/uploads/official/kegiatan-santri-waw1981.webp', 'title' => 'Keluarga Besar Asatidz & Santri dalam Agenda Tahunan Pesantren'],
            ['url' => '/uploads/official/kegiatan-santri-waw1985.webp', 'title' => 'Apresiasi & Penghargaan Prestasi Akademik Santri Raudhatul Ulum'],
        ];

        $fallbackRow2 = [
            ['url' => '/uploads/official/kbm-santri-0054.webp', 'title' => 'Dinamika Belajar Mengajar & Diskusi Interaktif Santri di Kelas'],
            ['url' => '/uploads/official/kbm-santri-0098.webp', 'title' => 'Kajian Ilmiah Kolaboratif Santri Raudhatul Ulum Sakatiga'],
            ['url' => '/uploads/official/kbm-santri-0152.webp', 'title' => 'Kedisiplinan & Kesungguhan Santri dalam Pembelajaran Harian'],
            ['url' => '/uploads/official/upacara-santri-4680.webp', 'title' => 'Apel Akbar & Barisan Disiplin Santri Pondok Pesantren Raudhatul Ulum'],
            ['url' => '/uploads/official/drone-lingkungan-9936.webp', 'title' => 'Lanskap Hijau Kawasan Asrama dan Ruang Terbuka Hijau Pesantren'],
            ['url' => '/uploads/official/drone-lingkungan-9941.webp', 'title' => 'Sarana Lapangan Olahraga Terpadu Santri Raudhatul Ulum'],
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

        // 18. Program Unggulan Pesantren
        $programUnggulan = collect();
        if (Schema::hasTable('program_unggulans')) {
            $programUnggulan = ProgramUnggulan::orderBy('order', 'asc')->get();
        } elseif (Schema::hasTable('dpcs')) {
            $programUnggulan = Dpc::orderBy('order', 'asc')->get();
        }

        return view('frontend.home', compact(
            'heroSlides',
            'sambutan',
            'featuredPost',
            'sidePosts',
            'prestasiPosts',
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
            'programUnggulan',
            'taujihPosts',
            'visitorHits',
            'popupSettings'
        ));
    }
}
