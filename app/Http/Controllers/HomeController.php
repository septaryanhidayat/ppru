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
        $sambutan = Post::where('type', 'page')->whereIn('slug', ['sambutan-kepala-sekolah', 'sambutan-ketua-dpd'])->first();

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
                $q->whereHas('categories', fn ($c) => $c->whereIn('slug', ['program-unggulan', 'ekstrakurikuler', 'tahfidz', 'senayan', 'dpr-ri']))
                    ->orWhereHas('tags', fn ($t) => $t->whereIn('slug', ['ekskul', 'pramuka', 'tahfidz', 'robotik', 'bpi']));
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
                $q->whereHas('categories', fn ($c) => $c->whereIn('slug', ['prestasi', 'kejuaraan', 'olimpiade', 'fraksi', 'dprd-oi']))
                    ->orWhereHas('tags', fn ($t) => $t->whereIn('slug', ['prestasi', 'juara', 'lomba']));
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
            ->whereHas('categories', fn ($c) => $c->whereIn('slug', ['akademik', 'kurikulum', 'pembelajaran', 'nasional']))
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
            ->whereHas('categories', fn ($c) => $c->whereIn('slug', ['kesiswaan', 'osis', 'kegiatan', 'daerah', 'ogan-ilir']))
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
            ['url' => '/uploads/2023/07/banner-faculty.webp', 'title' => 'Gedung Kampus & Kompleks Pembelajaran Robbani'],
            ['url' => '/uploads/2023/07/1.webp', 'title' => 'Suasana Belajar Mengajar Interaktif di Kelas'],
            ['url' => '/uploads/2023/07/2.webp', 'title' => 'Praktikum Sains & Laboratorium Biologi Siswa'],
            ['url' => '/uploads/2023/07/event-3.webp', 'title' => 'Wisuda Tahfidzul Qur\'an & Khotmil Qur\'an'],
            ['url' => '/uploads/2023/08/fak-ib.webp', 'title' => 'Pembinaan Karakter & Halaqah Al-Qur\'an'],
            ['url' => '/uploads/2023/08/farmasi.webp', 'title' => 'Laboratorium Komputer & Riset Teknologi'],
        ];

        $fallbackRow2 = [
            ['url' => '/uploads/2023/08/feb.webp', 'title' => 'Perpustakaan Sekolah & Pojok Literasi Digital'],
            ['url' => '/uploads/2023/08/filsafat.webp', 'title' => 'Kegiatan Keputrian & Pembinaan Akhlakul Karimah'],
            ['url' => '/uploads/2023/08/fasi.webp', 'title' => 'Upacara Peringatan Hari Santri & Hari Guru'],
            ['url' => '/uploads/2023/08/fak-geo.webp', 'title' => 'Latihan Rutin Memanah & Olahraga Prestasi'],
            ['url' => '/uploads/2023/08/edu-4.webp', 'title' => 'Kemah Ukhuwah Pramuka SIT Robbani'],
            ['url' => '/uploads/2023/08/edu-1.webp', 'title' => 'Bakti Sosial & Safari Dakwah Siswa Robbani'],
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
            'Tahfidz' => '/uploads/2025/09/Marifatul-Quran-320x448.jpg.webp',
            'Kurikulum' => '/uploads/2025/09/Cover-Kurikulum-Pembinaan-Dai-Muda-320x455.jpg.webp',
            'Sains' => '/uploads/2025/09/Ghazwul-Fikri-320x448.jpg.webp',
            'Qur\'an' => '/uploads/2025/09/Marifatul-Quran-320x448.jpg.webp',
            'Olahraga' => '/uploads/2025/10/ADAB-OLAHRAGA.webp',
            'Karakter' => '/uploads/2025/09/Marifatullah.jpg.webp',
        ];

        if ($ebookDownloads->isNotEmpty()) {
            $ebooks = $ebookDownloads->map(function ($dl) use ($ebookCovers) {
                $cover = '/uploads/2025/09/Marifatul-Quran-320x448.jpg.webp';
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
                    'cover' => '/uploads/2025/09/Cover-Kurikulum-Pembinaan-Dai-Muda-320x455.jpg.webp',
                    'pdf' => '#',
                ],
                [
                    'id' => 2,
                    'title' => "Modul Tahsin & Tahfidzul Qur'an Bersanad",
                    'cover' => '/uploads/2025/09/Marifatul-Quran-320x448.jpg.webp',
                    'pdf' => '#',
                ],
                [
                    'id' => 3,
                    'title' => 'Panduan Riset Ilmiah Remaja & Inovasi Teknologi',
                    'cover' => '/uploads/2025/09/Ghazwul-Fikri-320x448.jpg.webp',
                    'pdf' => '#',
                ],
                [
                    'id' => 4,
                    'title' => "Buku Saku Adab & Karakter Generasi Qur'ani",
                    'cover' => '/uploads/2025/09/Marifatullah.jpg.webp',
                    'pdf' => '#',
                ],
                [
                    'id' => 5,
                    'title' => 'Panduan Sukses Seleksi Nasional Masuk PTN (SNBT/UTBK)',
                    'cover' => '/uploads/2025/10/ADAB-OLAHRAGA.webp',
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
