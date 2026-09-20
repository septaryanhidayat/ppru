<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\Video;
use App\Services\CmsAutoHealService;
use App\Services\UnitDemoContentService;
use Illuminate\Support\Facades\Schema;

class UnitPendidikanController extends Controller
{
    public function index()
    {
        $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.pendidikan.index', compact('units'));
    }

    public function show(string $slug)
    {
        // Auto-heal schema if running on an unmigrated database
        CmsAutoHealService::ensureUnitPendidikanSchemaExists();

        $unit = UnitPendidikan::where('slug', $slug)->firstOrFail();

        // Ensure this unit is fully seeded with 8 teachers, 4 videos, 4 prestasi, 4 ekskul, 4 testimoni, 4 posts
        UnitDemoContentService::seedUnitIfEmpty($unit);

        $hasDewanUnitCol = Schema::hasTable('dewan_asatidz') && Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id');
        $teacherQuery = AnggotaDewan::query();
        if ($hasDewanUnitCol) {
            $teacherQuery->where(function ($q) use ($unit) {
                $q->where('unit_pendidikan_id', $unit->id)
                    ->orWhere('fraction', $unit->short_name)
                    ->orWhere('fraction', $unit->name);
            });
        } else {
            $teacherQuery->where(function ($q) use ($unit) {
                $q->where('fraction', $unit->short_name)
                    ->orWhere('fraction', $unit->name);
            });
        }
        $teachers = $teacherQuery->orderBy('order', 'asc')->take(8)->get();

        $otherUnits = UnitPendidikan::active()->where('id', '!=', $unit->id)->orderBy('order', 'asc')->get();

        // Unit-specific or latest authentic pesantren agendas
        $agendas = Agenda::orderBy('event_date', 'desc')->take(3)->get();

        // Unit-specific or latest authentic pesantren announcements
        $pengumumen = Pengumuman::orderBy('created_at', 'desc')->take(3)->get();

        $hasPostUnitCol = Schema::hasTable('posts') && Schema::hasColumn('posts', 'unit_pendidikan_id');

        // Unit-specific news / posts (4 items)
        $unitPosts = collect();
        if ($hasPostUnitCol) {
            $unitPosts = Post::where('type', 'post')
                ->where('unit_pendidikan_id', $unit->id)
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        if ($unitPosts->isEmpty()) {
            $unitPosts = Post::where('type', 'post')
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        // Unit-specific achievements (4 items)
        $prestasi = collect();
        if ($hasPostUnitCol) {
            $prestasi = Post::where('type', 'prestasi')
                ->where('unit_pendidikan_id', $unit->id)
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        if ($prestasi->isEmpty()) {
            $prestasi = Post::whereHas('categories', function ($q) {
                $q->where('slug', 'prestasi');
            })->where(function ($q) use ($unit) {
                $q->where('title', 'like', '%'.$unit->short_name.'%')
                    ->orWhere('content', 'like', '%'.$unit->short_name.'%');
            })->latest()->take(4)->get();
        }

        if ($prestasi->isEmpty()) {
            $prestasi = Post::whereHas('categories', function ($q) {
                $q->where('slug', 'prestasi');
            })->latest()->take(4)->get();
        }

        // Unit-specific extracurriculars (4 items)
        $ekskuls = collect();
        if ($hasPostUnitCol) {
            $ekskuls = Post::where('type', 'ekskul')
                ->where('unit_pendidikan_id', $unit->id)
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        if ($ekskuls->isEmpty()) {
            $ekskuls = Post::where('type', 'ekskul')->where('status', 'publish')->take(4)->get();
        }

        // Unit-specific testimonials (4 items)
        $unitTestimonials = collect();
        if (Schema::hasTable('testimonials')) {
            $hasTestimonialUnitCol = Schema::hasColumn('testimonials', 'unit_pendidikan_id');
            if ($hasTestimonialUnitCol) {
                $unitTestimonials = Testimonial::where('unit_pendidikan_id', $unit->id)
                    ->where('status', 'publish')
                    ->latest()
                    ->take(4)
                    ->get();
            }
            if ($unitTestimonials->isEmpty()) {
                $unitTestimonials = Testimonial::where('status', 'publish')->take(4)->get();
            }
        }

        // Unit-specific videos (Kanal Resmi YouTube TVRU Sakatiga @tvrusakatiga - 4 items)
        $unitVideos = collect();
        if (Schema::hasTable('videos')) {
            // Self-heal: hapus residu video placeholder demo lama jika masih ada
            Video::where('youtube_id', 'dQw4w9WgXcQ')->delete();

            $hasVideoUnitCol = Schema::hasColumn('videos', 'unit_pendidikan_id');
            if ($hasVideoUnitCol) {
                $unitVideos = Video::where('unit_pendidikan_id', $unit->id)
                    ->where('youtube_id', '!=', 'dQw4w9WgXcQ')
                    ->latest()
                    ->take(4)
                    ->get();
            }
            if ($unitVideos->isEmpty()) {
                $unitVideos = Video::where('youtube_id', '!=', 'dQw4w9WgXcQ')->latest()->take(4)->get();
            }
        }

        $unitGalleriesMap = [
            'MATQULARU' => [
                ['title' => 'Halaqah Tahfidzul Qur\'an & Pengajian Kitab', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Tahfidz'],
                ['title' => 'Pembelajaran Mutqin & Setoran Hafalan Santri', 'image' => '/uploads/official/kbm-santri-0098.webp', 'badge' => 'Mutqin'],
                ['title' => 'Pembinaan Karakter & Akhlaq Santri Tahfidz', 'image' => '/uploads/official/kegiatan-santri-waw1985.webp', 'badge' => 'Adab'],
                ['title' => 'Kawasan Pesantren & Asrama Santri Tahfidz', 'image' => '/uploads/official/drone-raudhatul-ulum.webp', 'badge' => 'Lingkungan'],
            ],
            'TAKIRU' => [
                ['title' => 'Aktivitas Ceria Belajar Santri Cilik', 'image' => '/uploads/official/kbm-santri-0054.webp', 'badge' => 'Ceria'],
                ['title' => 'Latihan Olahraga Sunnah & Motorik Santri', 'image' => '/uploads/official/panahan-santri.webp', 'badge' => 'Motorik'],
                ['title' => 'Kreativitas & Pengenalan Huruf Hijaiyah', 'image' => '/uploads/official/kegiatan-santri-waw1981.webp', 'badge' => 'Karakter'],
                ['title' => 'Lingkungan Ramah Anak Pesantren Raudhatul Ulum', 'image' => '/uploads/official/drone-danau-telok-putih.webp', 'badge' => 'Kawasan'],
            ],
            'MARU' => [
                ['title' => 'Kegiatan Pembelajaran & Pembinaan MARU', 'image' => '/uploads/official/kbm-santri-0054.webp', 'badge' => 'Akademik'],
                ['title' => 'Halaqah Dirasah Islamiyyah & Tahfidzul Qur\'an', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Dirasah'],
                ['title' => 'Latihan Olahraga Sunnah Panahan Santri', 'image' => '/uploads/official/panahan-santri.webp', 'badge' => 'Sunnah'],
                ['title' => 'Kampus Terpadu & Kawasan Asrama MARU', 'image' => '/uploads/official/drone-raudhatul-ulum.webp', 'badge' => 'Lingkungan'],
            ],
            'SMAIT RU' => [
                ['title' => 'Pembelajaran Sains Terpadu & Riset Santri', 'image' => '/uploads/official/kbm-santri-0152.webp', 'badge' => 'Sains'],
                ['title' => 'Kajian Kitab Kuning & Halaqah Al-Qur\'an', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Tsaqafah'],
                ['title' => 'Ekstrakurikuler Olahraga Sunnah Panahan', 'image' => '/uploads/official/panahan-santri.webp', 'badge' => 'Bakat'],
                ['title' => 'Lanskap Kampus & Fasilitas Belajar SMAIT', 'image' => '/uploads/official/drone-lingkungan-9936.webp', 'badge' => 'Fasilitas'],
            ],
            'MATSARU' => [
                ['title' => 'Dinamika Belajar & Pembiasaan Karakter Santri', 'image' => '/uploads/official/kbm-santri-0098.webp', 'badge' => 'KBM'],
                ['title' => 'Halaqah Tahfidz & Tilawah Bersama Asatidz', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Tahfidz'],
                ['title' => 'Apel Disiplin & Kepanduan Santri MATSARU', 'image' => '/uploads/official/upacara-santri-4680.webp', 'badge' => 'Kedisiplinan'],
                ['title' => 'Lingkungan Asri Kampus Pesantren Raudhatul Ulum', 'image' => '/uploads/official/drone-lingkungan-9941.webp', 'badge' => 'Lingkungan'],
            ],
            'SMPIT RU' => [
                ['title' => 'Pembelajaran Terpadu Kurikulum Islam & Nasional', 'image' => '/uploads/official/kbm-santri-0054.webp', 'badge' => 'Kurikulum'],
                ['title' => 'Halaqah Sore & Bimbingan Ibadah Praktis', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Ibadah'],
                ['title' => 'Apresiasi Prestasi & Minat Bakat Santri', 'image' => '/uploads/official/kegiatan-santri-waw1985.webp', 'badge' => 'Prestasi'],
                ['title' => 'Panorama Kampus Pesantren & Danau Telok Putih', 'image' => '/uploads/official/drone-danau-telok-putih.webp', 'badge' => 'Kampus'],
            ],
            'MIRU' => [
                ['title' => 'Suasana Belajar Aktif & Menyenangkan Santri MI', 'image' => '/uploads/official/kbm-santri-0152.webp', 'badge' => 'Aktif'],
                ['title' => 'Pembiasaan Adab, Doa Harian & Tahfidz Juz 30', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Tahfidz'],
                ['title' => 'Latihan Olahraga Panahan Santri Ibtidaiyah', 'image' => '/uploads/official/panahan-santri.webp', 'badge' => 'Olahraga'],
                ['title' => 'Area Belajar Terpadu Pesantren Raudhatul Ulum', 'image' => '/uploads/official/drone-raudhatul-ulum.webp', 'badge' => 'Pesantren'],
            ],
            'IAI NRU' => [
                ['title' => 'Perkuliahan & Diskusi Akademik Mahasiswa IAI NRU', 'image' => '/uploads/official/kbm-santri-0054.webp', 'badge' => 'Akademik'],
                ['title' => 'Halaqah Kajian Fiqih & Bahtsul Masail Peradaban', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Dirasah'],
                ['title' => 'Sidang Karya Ilmiah & Prestasi Mahasiswa', 'image' => '/uploads/official/kegiatan-santri-waw1985.webp', 'badge' => 'Prestasi'],
                ['title' => 'Kompleks Kampus Perguruan Tinggi Pesantren', 'image' => '/uploads/official/drone-lingkungan-9941.webp', 'badge' => 'Kampus'],
            ],
        ];

        $unitGallery = $unitGalleriesMap[$unit->short_name] ?? [
            ['title' => 'Kegiatan Pembelajaran Santri '.$unit->short_name, 'image' => '/uploads/official/kbm-santri-0054.webp', 'badge' => 'Akademik'],
            ['title' => 'Halaqah Tahfidzul Qur\'an & Pengajian Kitab', 'image' => '/uploads/official/ngaji-sore.webp', 'badge' => 'Tahfidz'],
            ['title' => 'Latihan Olahraga Sunnah Panahan Santri', 'image' => '/uploads/official/panahan-santri.webp', 'badge' => 'Sunnah'],
            ['title' => 'Kampus Terpadu & Kawasan Asrama '.$unit->short_name, 'image' => '/uploads/official/drone-raudhatul-ulum.webp', 'badge' => 'Lingkungan'],
        ];

        return view('frontend.pendidikan.show', compact('unit', 'teachers', 'otherUnits', 'agendas', 'pengumumen', 'prestasi', 'unitGallery', 'unitPosts', 'ekskuls', 'unitTestimonials', 'unitVideos'));
    }
}
