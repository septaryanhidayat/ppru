<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\IkarusDemoService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::posts()->published()->with(['categories', 'author']);

        // Search filter
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Category filter
        $activeCategory = null;
        if ($categorySlug = $request->input('kategori')) {
            $activeCategory = Category::where('slug', $categorySlug)->first();
            if ($activeCategory) {
                $query->whereHas('categories', function ($q) use ($activeCategory) {
                    $q->where('categories.id', $activeCategory->id);
                });
            }
        }

        // Tag filter
        $activeTag = null;
        if ($tagSlug = $request->input('tag')) {
            $activeTag = Tag::where('slug', $tagSlug)->first();
            if ($activeTag) {
                $query->whereHas('tags', function ($q) use ($activeTag) {
                    $q->where('tags.id', $activeTag->id);
                });
            }
        }

        $posts = $query->orderBy('published_at', 'desc')->orderBy('id', 'desc')->paginate(9)->withQueryString();
        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
        $recentPosts = Post::posts()->published()->orderBy('published_at', 'desc')->orderBy('id', 'desc')->take(5)->get();
        $tags = Tag::all();

        return view('frontend.artikel.index', compact(
            'posts',
            'categories',
            'recentPosts',
            'tags',
            'activeCategory',
            'activeTag'
        ));
    }

    public function show(string $slug)
    {
        $post = Post::posts()
            ->published()
            ->where('slug', $slug)
            ->with(['categories', 'tags', 'author'])
            ->first();

        if (! $post) {
            $post = IkarusDemoService::findOrCreateDemoArticle($slug);
        }

        if (! $post) {
            abort(404);
        }

        // Increment views count
        $post->increment('views_count');

        // Related posts by category
        $categoryIds = $post->categories->pluck('id');
        $relatedPosts = Post::posts()
            ->published()
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = Post::posts()
                ->published()
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
        $recentPosts = Post::posts()->published()->latest('published_at')->take(5)->get();

        return view('frontend.artikel.show', compact(
            'post',
            'relatedPosts',
            'categories',
            'recentPosts'
        ));
    }

    public function category(string $slug)
    {
        if (strtolower($slug) === 'ikarus') {
            return redirect()->route('ikarus.index');
        }

        return redirect()->route('artikel.index', ['kategori' => $slug]);
    }

    public function karyaSantri(Request $request)
    {
        // Ensure category karya-santri exists
        $karyaCategory = Category::firstOrCreate(
            ['slug' => 'karya-santri'],
            [
                'name' => 'Karya Santri & Asatidz',
                'description' => 'Kumpulan artikel, opini, riset, dan karya tulis ilmiah santri serta dewan asatidz Pondok Pesantren Raudhatul Ulum Sakatiga.',
            ]
        );

        $search = $request->input('q');

        $query = Post::whereIn('status', ['publish', 'published'])
            ->where(function ($q) use ($karyaCategory) {
                $q->whereHas('categories', function ($catQ) use ($karyaCategory) {
                    $catQ->where('categories.id', $karyaCategory->id)
                        ->orWhere('categories.slug', 'karya-santri');
                })
                    ->orWhereHas('tags', function ($tagQ) {
                        $tagQ->where('slug', 'like', '%santri%')
                            ->orWhere('slug', 'like', '%karya%');
                    })
                    ->orWhere('title', 'like', '%santri%')
                    ->orWhere('title', 'like', '%karya%')
                    ->orWhere('type', 'post');
            })
            ->with(['categories', 'tags', 'author']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->orderBy('id', 'desc')->paginate(9)->withQueryString();
        $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
        $recentPosts = Post::posts()->published()->orderBy('published_at', 'desc')->orderBy('id', 'desc')->take(5)->get();
        $tags = Tag::all();
        $activeCategory = $karyaCategory;
        $activeTag = null;

        return view('frontend.artikel.karya_santri', compact(
            'posts',
            'categories',
            'recentPosts',
            'tags',
            'activeCategory',
            'activeTag'
        ));
    }

    public function tag(string $slug)
    {
        return redirect()->route('artikel.index', ['tag' => $slug]);
    }
}
