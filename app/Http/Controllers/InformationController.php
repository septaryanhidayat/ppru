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
}
