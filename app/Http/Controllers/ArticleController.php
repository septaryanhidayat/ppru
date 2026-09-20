<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
            ->firstOrFail();

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

    public function tag(string $slug)
    {
        return redirect()->route('artikel.index', ['tag' => $slug]);
    }
}
