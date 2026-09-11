<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Dpc;
use App\Models\Post;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function sambutan()
    {
        $page = Post::pages()->where('slug', 'sambutan-ketua-dpd')->first();

        return view('frontend.pages.sambutan', compact('page'));
    }

    public function tentangKami()
    {
        $page = Post::pages()->where('slug', 'tentang-kami')->first();
        $testimonials = Testimonial::all();

        return view('frontend.pages.tentang-kami', compact('page', 'testimonials'));
    }

    public function visiMisi()
    {
        $page = Post::pages()->where('slug', 'visi-dan-misi')->first();
        $latestPosts = Post::articles()->published()->latest('published_at')->take(5)->get();
        $latestAgendas = Agenda::where('status', 'publish')->orderBy('event_date', 'desc')->take(5)->get();

        return view('frontend.pages.visi-misi', compact('page', 'latestPosts', 'latestAgendas'));
    }

    public function sejarah()
    {
        $page = Post::pages()->where('slug', 'sejarah')->first();
        $latestPosts = Post::articles()->published()->latest('published_at')->take(5)->get();
        $latestAgendas = Agenda::where('status', 'publish')->orderBy('event_date', 'desc')->take(5)->get();

        return view('frontend.pages.sejarah', compact('page', 'latestPosts', 'latestAgendas'));
    }

    public function struktur()
    {
        $page = Post::pages()->where('slug', 'struktur-kepengurusan')->first();
        $bidangs = Bidang::orderBy('order', 'asc')->get();
        $dpcs = Dpc::orderBy('order', 'asc')->get();
        $dewan = AnggotaDewan::orderBy('order', 'asc')->get();

        return view('frontend.pages.struktur', compact('page', 'bidangs', 'dpcs', 'dewan'));
    }

    public function privacyPolicy()
    {
        $page = Post::pages()->where('slug', 'privacy-policy')->first();

        return view('frontend.pages.privacy-policy', compact('page'));
    }

    public function dpc()
    {
        $dpcs = Dpc::orderBy('order', 'asc')->get();

        return view('frontend.dpc.index', compact('dpcs'));
    }

    public function show(string $slug)
    {
        $page = Post::pages()->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.default', compact('page'));
    }
}
