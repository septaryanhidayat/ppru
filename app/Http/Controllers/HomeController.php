<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Download;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Video;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hero slides data - SMA IT Plus Robbani
        $heroSlides = [
            [
                'title' => 'Selamat Datang di Website Resmi',
                'subtitle' => 'SMA IT Plus Robbani Kabupaten Ogan Ilir',
                'image' => '/uploads/campus-robbani.jpg',
                'btn_text' => 'Sambutan Kepala Sekolah',
                'btn_link' => route('page.sambutan', [], false),
            ],
            [
                'title' => 'Membina Generasi Qur\'ani & Unggul Berprestasi',
                'subtitle' => 'Memadukan Kurikulum Nasional, Pendalaman Sains Modern, dan Tahfidzul Qur\'an Bersanad.',
                'image' => '/uploads/lab-robbani.jpg',
                'btn_text' => 'Profil Singkat Sekolah',
                'btn_link' => route('page.tentang-kami', [], false),
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB)',
                'subtitle' => 'Mari Bergabung Bersama Keluarga Besar Robbani. Wujudkan Cita-cita Menjadi Generasi Emas Berakhlak Mulia.',
                'image' => '/uploads/tahfidz-robbani.jpg',
                'btn_text' => 'Daftar PPDB Online',
                'btn_link' => route('hubungi', ['type' => 'ppdb'], false),
            ],
        ];

        // 2. Sambutan Kepala Sekolah
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
            ['url' => '/uploads/campus-robbani.jpg', 'title' => 'Gedung Kampus & Kompleks Pembelajaran Robbani'],
            ['url' => '/uploads/library-robbani.jpg', 'title' => 'Suasana Belajar Mengajar Interaktif di Kelas & Perpustakaan'],
            ['url' => '/uploads/lab-robbani.jpg', 'title' => 'Praktikum Sains & Riset Laboratorium Terpadu Siswa'],
            ['url' => '/uploads/tahfidz-robbani.jpg', 'title' => 'Wisuda Tahfidzul Qur\'an & Khotmil Qur\'an Santri'],
            ['url' => '/uploads/activities-robbani.jpg', 'title' => 'Pembinaan Karakter & Latihan Olahraga Sunnah Memanah'],
            ['url' => '/uploads/robotics-robbani.jpg', 'title' => 'Laboratorium Komputer & Riset Teknologi Robotika'],
        ];

        $fallbackRow2 = [
            ['url' => '/uploads/library-robbani.jpg', 'title' => 'Perpustakaan Sekolah & Pojok Literasi Digital'],
            ['url' => '/uploads/tahfidz-robbani.jpg', 'title' => 'Kegiatan Halaqah Tahfidz & Pembinaan Akhlakul Karimah'],
            ['url' => '/uploads/campus-robbani.jpg', 'title' => 'Upacara Peringatan Hari Santri & Hari Guru'],
            ['url' => '/uploads/activities-robbani.jpg', 'title' => 'Latihan Rutin Memanah & Olahraga Prestasi'],
            ['url' => '/uploads/robotics-robbani.jpg', 'title' => 'Inovasi Robotika & Pemrograman Internet of Things'],
            ['url' => '/uploads/lab-robbani.jpg', 'title' => 'Eksperimen Biologi & Kimia Terapan Siswa Robbani'],
        ];

        if (! empty($dbGallery)) {
            $half = (int) ceil(count($dbGallery) / 2);
            $dbRow1 = array_slice($dbGallery, 0, $half);
            $dbRow2 = array_slice($dbGallery, $half);

            $galleryRow1 = array_merge($dbRow1, $fallbackRow1);
            $galleryRow2 = array_merge($dbRow2, $fallbackRow2);
        } else {
            $galleryRow1 = $fallbackRow1;
            $galleryRow2 = $fallbackRow2;
        }

        $galleryPhotos = array_merge($galleryRow1, $galleryRow2);

        // 12. E-Library & Modul Pembelajaran Siswa (Section 15)
        $ebookDownloads = Download::where('category_type', 'E-Book')->get();
        $ebookCovers = [
            'Tahfidz' => '/uploads/tahfidz-robbani.jpg',
            'Kurikulum' => '/uploads/campus-robbani.jpg',
            'Sains' => '/uploads/lab-robbani.jpg',
            'Qur\'an' => '/uploads/tahfidz-robbani.jpg',
            'Olahraga' => '/uploads/activities-robbani.jpg',
            'Karakter' => '/uploads/library-robbani.jpg',
            'Robotika' => '/uploads/robotics-robbani.jpg',
            'PPDB' => '/uploads/campus-robbani.jpg',
        ];

        if ($ebookDownloads->isNotEmpty()) {
            $ebooks = $ebookDownloads->map(function ($dl) use ($ebookCovers) {
                $cover = '/uploads/campus-robbani.jpg';
                foreach ($ebookCovers as $key => $img) {
                    if (stripos($dl->title, $key) !== false) {
                        $cover = $img;
                        break;
                    }
                }

                return [
                    'id' => $dl->id,
                    'title' => $dl->title,
                    'cover' => $cover,
                    'pdf' => route('download.file', $dl->id, false),
                    'direct_file' => $dl->file_path,
                ];
            })->toArray();
        } else {
            $ebooks = [
                [
                    'id' => 1,
                    'title' => 'Buku Panduan Akademik & Kurikulum SMA IT Plus Robbani',
                    'cover' => '/uploads/campus-robbani.jpg',
                    'pdf' => '#',
                ],
                [
                    'id' => 2,
                    'title' => "Modul Tahsin & Tahfidzul Qur'an Bersanad",
                    'cover' => '/uploads/tahfidz-robbani.jpg',
                    'pdf' => '#',
                ],
                [
                    'id' => 3,
                    'title' => 'Panduan Riset Ilmiah Remaja & Inovasi Teknologi Robotika',
                    'cover' => '/uploads/robotics-robbani.jpg',
                    'pdf' => '#',
                ],
                [
                    'id' => 4,
                    'title' => "Buku Saku Adab & Karakter Generasi Qur'ani",
                    'cover' => '/uploads/library-robbani.jpg',
                    'pdf' => '#',
                ],
                [
                    'id' => 5,
                    'title' => 'Panduan Sukses Seleksi Nasional Masuk PTN (SNBT/UTBK)',
                    'cover' => '/uploads/activities-robbani.jpg',
                    'pdf' => '#',
                ],
            ];
        }

        // 13. Testimonials (Section 16)
        $testimonials = Testimonial::where('status', 'publish')->take(4)->get();

        // 14. Visitor counter hits
        $visitorHits = view()->shared('visitorHits') ?? '53.512';

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
            'visitorHits'
        ));
    }
}
