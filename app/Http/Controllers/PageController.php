<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Dpc;
use App\Models\Post;
use App\Models\ProgramUnggulan;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function sambutan()
    {
        $page = Post::pages()->whereIn('slug', ['sambutan-mudir', 'sambutan-kepala-sekolah', 'sambutan-ketua-dpd'])->first();

        $kepsek = AnggotaDewan::where('position', 'like', '%Mudir%')
            ->orWhere('position', 'like', '%Pimpinan%')
            ->orWhere('position', 'like', '%Kepala%')
            ->first();

        return view('frontend.pages.sambutan', compact('page', 'kepsek'));
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
        $page = Post::pages()->whereIn('slug', ['struktur-organisasi', 'struktur-kepengurusan'])->first();
        $bidangs = Bidang::orderBy('order', 'asc')->get();
        $dpcs = collect();
        if (Schema::hasTable('program_unggulans')) {
            $dpcs = ProgramUnggulan::orderBy('order', 'asc')->get();
        } elseif (Schema::hasTable('dpcs')) {
            $dpcs = Dpc::orderBy('order', 'asc')->get();
        }
        $dewan = AnggotaDewan::whereIn('fraction', ['Yayasan', 'Pimpinan Pesantren'])->orderBy('order', 'asc')->get();
        if ($dewan->isEmpty()) {
            $dewan = AnggotaDewan::orderBy('order', 'asc')->get();
        }
        $tree = AnggotaDewan::getHierarchyTree();

        return view('frontend.pages.struktur', compact('page', 'bidangs', 'dpcs', 'dewan', 'tree'));
    }

    public function privacyPolicy()
    {
        $page = Post::pages()->where('slug', 'privacy-policy')->first();

        return view('frontend.pages.privacy-policy', compact('page'));
    }

    public function programUnggulan()
    {
        $programs = collect();
        if (Schema::hasTable('program_unggulans')) {
            $programs = ProgramUnggulan::orderBy('order', 'asc')->get();
        } elseif (Schema::hasTable('dpcs')) {
            $programs = Dpc::orderBy('order', 'asc')->get();
        }

        return view('frontend.program-unggulan.index', compact('programs'));
    }

    /**
     * Backward compatibility route handler for /dpc
     */
    public function dpc()
    {
        return redirect()->route('program-unggulan.index', [], 301);
    }

    public function show(string $slug)
    {
        $page = Post::pages()->where('slug', $slug)->firstOrFail();

        return view('frontend.pages.default', compact('page'));
    }
}
