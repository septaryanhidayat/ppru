<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\KhutbahService;
use Illuminate\Http\Request;

class KhutbahController extends Controller
{
    /**
     * Tampilan utama katalog / arsip khutbah Jum'at & dakwah PPRU.
     */
    public function index(Request $request)
    {
        // Pastikan kategori dan naskah demo tersedia jika database masih baru
        KhutbahService::ensureCategoryAndDemos();

        $search = $request->input('q');
        $tema = $request->input('tema');

        $query = KhutbahService::getKhutbahQuery($request);

        $totalKhutbah = (clone $query)->count();

        // Naskah Pilihan (Featured)
        $featured = (clone $query)->where('is_featured', true)->latest('published_at')->first();
        if (! $featured && ! $search && ! $tema) {
            $featured = (clone $query)->latest('published_at')->first();
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(9)->withQueryString();
        $themes = KhutbahService::getKhutbahThemes();

        return view('frontend.khutbah.index', compact(
            'posts',
            'featured',
            'search',
            'tema',
            'totalKhutbah',
            'themes'
        ));
    }

    /**
     * Tampilan naskah khutbah lengkap dengan mode pembaca mimbar dan print layout.
     */
    public function show(string $slug)
    {
        KhutbahService::ensureCategoryAndDemos();

        $post = Post::where('slug', $slug)
            ->whereIn('status', ['publish', 'published'])
            ->with(['categories', 'tags', 'author', 'unitPendidikan'])
            ->firstOrFail();

        // Increment hit counter
        $post->increment('views_count');

        // Naskah khutbah terkait
        $related = Post::where('id', '!=', $post->id)
            ->whereIn('status', ['publish', 'published'])
            ->where(function ($q) {
                $q->whereHas('categories', function ($catQ) {
                    $catQ->whereIn('slug', ['khutbah', 'khutbah-jumat', 'taujih'])
                        ->orWhere('name', 'like', '%khutbah%');
                })->orWhere('type', 'khutbah');
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.khutbah.show', compact('post', 'related'));
    }
}
