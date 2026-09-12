<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Video;

class InformationController extends Controller
{
    public function agenda()
    {
        $agendas = Agenda::where('status', 'publish')
            ->orderBy('event_date', 'desc')
            ->paginate(8);

        return view('frontend.agenda.index', compact('agendas'));
    }

    public function agendaShow(string $slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();
        $otherAgendas = Agenda::where('id', '!=', $agenda->id)
            ->where('status', 'publish')
            ->orderBy('event_date', 'desc')
            ->take(4)
            ->get();

        return view('frontend.agenda.show', compact('agenda', 'otherAgendas'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::where('status', 'publish')
            ->latest()
            ->paginate(8);

        return view('frontend.pengumuman.index', compact('pengumuman'));
    }

    public function pengumumanShow(string $slug)
    {
        $announcement = Pengumuman::where('slug', $slug)->firstOrFail();
        $otherAnnouncements = Pengumuman::where('id', '!=', $announcement->id)
            ->where('status', 'publish')
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.pengumuman.show', compact('announcement', 'otherAnnouncements'));
    }

    public function testimonial()
    {
        $testimonials = Testimonial::where('status', 'publish')->get();

        return view('frontend.testimonial.index', compact('testimonials'));
    }

    public function video()
    {
        $videos = Video::latest()->paginate(9);

        return view('frontend.video.index', compact('videos'));
    }

    public function galeri()
    {
        $page = Post::pages()->where('slug', 'galeri')->first();

        // Ambil semua foto galeri yang diunggah dan foto berita
        $galleryImages = Post::whereIn('type', ['gallery', 'attachment', 'post'])
            ->where('status', 'publish')
            ->whereNotNull('featured_image')
            ->where('featured_image', '!=', '')
            ->orderByRaw("CASE WHEN type = 'gallery' THEN 0 WHEN type = 'attachment' THEN 1 ELSE 2 END")
            ->latest('created_at')
            ->paginate(24);

        return view('frontend.galeri.index', compact('page', 'galleryImages'));
    }

    public function prestasi()
    {
        $prestasi = Post::where('type', 'prestasi')
            ->where('status', 'publish')
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.prestasi.index', compact('prestasi'));
    }

    public function prestasiShow(string $slug)
    {
        $item = Post::where('type', 'prestasi')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Post::where('type', 'prestasi')
            ->where('id', '!=', $item->id)
            ->where('status', 'publish')
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.prestasi.show', compact('item', 'related'));
    }

    public function ekskul()
    {
        $ekskul = Post::where('type', 'ekskul')
            ->where('status', 'publish')
            ->latest('created_at')
            ->get();

        return view('frontend.ekskul.index', compact('ekskul'));
    }

    public function alumni()
    {
        $alumni = Post::where('type', 'alumni')
            ->where('status', 'publish')
            ->latest('created_at')
            ->paginate(16);

        return view('frontend.alumni.index', compact('alumni'));
    }

    public function layanan()
    {
        $page = Post::pages()->whereIn('slug', ['layanan-terpadu-2', 'layanan-terpadu'])->first();

        return view('frontend.layanan.index', compact('page'));
    }

    public function izinSekolah()
    {
        $page = Post::pages()->where('slug', 'izin-sekolah')->first();

        return view('frontend.layanan.izin', compact('page'));
    }

    public function kerjasama()
    {
        $page = Post::pages()->where('slug', 'permohonan-kerja-sama')->first();

        return view('frontend.layanan.kerjasama', compact('page'));
    }

    public function sewaBarang()
    {
        $page = Post::pages()->where('slug', 'sewa-barang')->first();

        return view('frontend.layanan.sewa', compact('page'));
    }
}
