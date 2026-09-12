<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index(Request $request)
    {
        $type = $request->input('type', 'post');
        $allowedTypes = ['post', 'prestasi', 'ekskul', 'alumni'];
        if (! in_array($type, $allowedTypes)) {
            $type = 'post';
        }

        $query = Post::where('type', $type)->with(['categories', 'author']);

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(15)->withQueryString();

        $counts = [
            'post' => Post::where('type', 'post')->count(),
            'prestasi' => Post::where('type', 'prestasi')->count(),
            'ekskul' => Post::where('type', 'ekskul')->count(),
            'alumni' => Post::where('type', 'alumni')->count(),
        ];

        return view('admin.posts.index', compact('posts', 'type', 'counts'));
    }

    public function create()
    {
        $type = request('type', 'post');
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:post,prestasi,ekskul,alumni',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:publish,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'categories' => 'nullable|array',
            'tags' => 'nullable|string',
        ]);

        $featuredImageUrl = null;
        $type = $validated['type'] ?? 'post';

        // Auto-convert to WebP on upload with high quality and compact size!
        if ($request->hasFile('featured_image')) {
            $subfolder = date('Y/m');
            $converted = $this->webpService->processUploadedFile(
                $request->file('featured_image'),
                $subfolder,
                80,
                1600
            );

            if ($converted['success']) {
                $featuredImageUrl = $converted['url'];
            }
        }

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'content' => $validated['content'],
            'excerpt' => ($validated['excerpt'] ?? null) ?: Str::limit(strip_tags($validated['content']), 180),
            'status' => $validated['status'],
            'type' => $type,
            'featured_image' => $featuredImageUrl,
            'author_id' => Auth::id(),
            'published_at' => now(),
        ]);

        if (! empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        // Process tags
        if (! empty($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);
            $tagIds = [];
            foreach ($tagNames as $tName) {
                $tName = trim($tName);
                if ($tName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tName)],
                        ['name' => $tName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        $redirectParams = ($type === 'post') ? [] : ['type' => $type];

        return redirect()->route('admin.posts.index', $redirectParams)->with('success', 'Konten berhasil diterbitkan dengan gambar teroptimasi WebP!');
    }

    public function edit(Post $post)
    {
        $type = $post->type;
        $categories = Category::all();
        $tags = Tag::all();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $selectedTags = $post->tags->pluck('name')->implode(', ');

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'selectedCategories', 'selectedTags', 'type'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:post,prestasi,ekskul,alumni',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:publish,draft',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'categories' => 'nullable|array',
            'tags' => 'nullable|string',
        ]);

        $featuredImageUrl = $post->featured_image;

        // Auto-convert new image to WebP on update!
        if ($request->hasFile('featured_image')) {
            $subfolder = date('Y/m');
            $converted = $this->webpService->processUploadedFile(
                $request->file('featured_image'),
                $subfolder,
                80,
                1600
            );

            if ($converted['success']) {
                $featuredImageUrl = $converted['url'];
            }
        }

        $post->update([
            'title' => $validated['title'],
            'type' => $validated['type'] ?? $post->type,
            'content' => $validated['content'],
            'excerpt' => ($validated['excerpt'] ?? null) ?: Str::limit(strip_tags($validated['content']), 180),
            'status' => $validated['status'],
            'featured_image' => $featuredImageUrl,
        ]);

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        if (isset($validated['tags'])) {
            $tagNames = explode(',', $validated['tags']);
            $tagIds = [];
            foreach ($tagNames as $tName) {
                $tName = trim($tName);
                if ($tName) {
                    $tag = Tag::firstOrCreate(
                        ['slug' => Str::slug($tName)],
                        ['name' => $tName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        $redirectParams = ($post->type === 'post') ? [] : ['type' => $post->type];

        return redirect()->route('admin.posts.index', $redirectParams)->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $type = $post->type;
        $post->delete();

        $redirectParams = ($type === 'post') ? [] : ['type' => $type];

        return redirect()->route('admin.posts.index', $redirectParams)->with('success', 'Konten berhasil dihapus!');
    }
}
