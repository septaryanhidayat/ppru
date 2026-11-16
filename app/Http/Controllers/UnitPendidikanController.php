<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\Video;
use Illuminate\Support\Facades\Schema;

class UnitPendidikanController extends Controller
{
    public function index()
    {
        $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.pendidikan.index', compact('units'));
    }

    /**
     * Map old verbose slugs and short abbreviations to canonical short URLs.
     */
    public static function resolveSlug(string $slug): string
    {
        $normalized = strtolower(trim($slug));
        $aliases = [
            'taman-kanak-kanak-islam-raudhatul-ulum' => 'takiru',
            'taman-kanak-kanak' => 'takiru',
            'tk' => 'takiru',
            'tk-islam' => 'takiru',
            'madrasah-ibtidaiyah-raudhatul-ulum' => 'miru',
            'madrasah-ibtidaiyah' => 'miru',
            'mi' => 'miru',
            'madrasah-tsanawiyah-raudhatul-ulum' => 'matsaru',
            'madrasah-tsanawiyah' => 'matsaru',
            'mts' => 'matsaru',
            'madrasah-aliyah-raudhatul-ulum' => 'maru',
            'madrasah-aliyah' => 'maru',
            'ma' => 'maru',
            'smp-islam-terpadu-raudhatul-ulum' => 'smpitru',
            'smp-islam-terpadu' => 'smpitru',
            'smpit-ru' => 'smpitru',
            'smpit' => 'smpitru',
            'sma-islam-terpadu-raudhatul-ulum' => 'smaitru',
            'sma-islam-terpadu' => 'smaitru',
            'smait-ru' => 'smaitru',
            'smait' => 'smaitru',
            'institut-agama-islam-nur-raudhatul-ulum' => 'iainru',
            'institut-agama-islam' => 'iainru',
            'iai-nru' => 'iainru',
            'iain-ru' => 'iainru',
            'madrasah-tahfizhul-quran-raudhatul-ulum' => 'matqularu',
            'madrasah-tahfizhul-quran-lil-aulad' => 'matqularu',
            'tahfizhul-quran' => 'matqularu',
            'matqula' => 'matqularu',
        ];

        return $aliases[$normalized] ?? $normalized;
    }

    public function show(string $slug)
    {
        $resolvedSlug = self::resolveSlug($slug);

        $unit = UnitPendidikan::where('slug', $resolvedSlug)
            ->orWhere('slug', $slug)
            ->first();

        if (! $unit) {
            $unit = UnitPendidikan::all()->first(function ($u) use ($resolvedSlug, $slug) {
                $uClean = str_replace([' ', '-', '_'], '', strtolower((string) $u->short_name));

                return $uClean === $resolvedSlug || $uClean === $slug;
            });
        }

        if (! $unit) {
            abort(404);
        }

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

        // Unit-specific dynamic photo gallery (4 items from database - CRUD via Admin Media)
        $unitGallery = collect();
        if ($hasPostUnitCol) {
            $unitGallery = Post::where('type', 'gallery')
                ->where('unit_pendidikan_id', $unit->id)
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        if ($unitGallery->isEmpty()) {
            $unitGallery = Post::where('type', 'gallery')
                ->where('status', 'publish')
                ->latest()
                ->take(4)
                ->get();
        }

        return view('frontend.pendidikan.show', compact('unit', 'teachers', 'otherUnits', 'agendas', 'pengumumen', 'prestasi', 'unitGallery', 'unitPosts', 'ekskuls', 'unitTestimonials', 'unitVideos'));
    }
}
