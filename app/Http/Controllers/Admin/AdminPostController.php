<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\KhutbahService;
use App\Services\WebpService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        $user = $request->user();
        $type = $request->input('type', 'post');
        $allowedTypes = ['post', 'prestasi', 'ekskul', 'alumni'];
        if (! in_array($type, $allowedTypes)) {
            $type = 'post';
        }

        $query = Post::where('type', $type)->with(['categories', 'author']);

        if ($user?->isUnitAdmin()) {
            $query->where('unit_pendidikan_id', $user->unit_pendidikan_id);
        }

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($catId = $request->input('category_id')) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $catId));
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(15)->withQueryString();

        $unitId = $user?->isUnitAdmin() ? $user->unit_pendidikan_id : null;
        $counts = [
            'post' => Post::where('type', 'post')->when($unitId, fn ($q) => $q->where('unit_pendidikan_id', $unitId))->count(),
            'prestasi' => Post::where('type', 'prestasi')->when($unitId, fn ($q) => $q->where('unit_pendidikan_id', $unitId))->count(),
            'ekskul' => Post::where('type', 'ekskul')->when($unitId, fn ($q) => $q->where('unit_pendidikan_id', $unitId))->count(),
            'alumni' => Post::where('type', 'alumni')->when($unitId, fn ($q) => $q->where('unit_pendidikan_id', $unitId))->count(),
        ];

        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.posts.index', compact('posts', 'type', 'counts', 'categories'));
    }

    public function create()
    {
        KhutbahService::ensureCategoryAndDemos();

        $type = request('type', 'post');
        $categories = Category::orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();

        return view('admin.posts.create', compact('categories', 'tags', 'users', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:post,prestasi,ekskul,alumni',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:publish,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'author_id' => 'nullable|exists:users,id',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'featured_image_caption' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'new_category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
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

        // Tanggal terbit kustom atau default waktu sekarang
        $publishedAt = ! empty($validated['published_at'])
            ? Carbon::parse($validated['published_at'])
            : now();

        $this->ensureEditorialColumns();
        $tableColumns = Schema::getColumnListing('posts');

        $user = $request->user();
        $postData = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.time(),
            'content' => $validated['content'],
            'excerpt' => ($validated['excerpt'] ?? null) ?: Str::limit(strip_tags($validated['content']), 180),
            'status' => $validated['status'],
            'type' => $type,
            'featured_image' => $featuredImageUrl,
            'author_id' => $validated['author_id'] ?? Auth::id(),
            'published_at' => $publishedAt,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'unit_pendidikan_id' => $user?->isUnitAdmin() ? $user->unit_pendidikan_id : ($request->input('unit_pendidikan_id') ?: null),
        ];

        if (in_array('is_featured', $tableColumns)) {
            $postData['is_featured'] = $request->boolean('is_featured');
        }
        if (in_array('featured_image_caption', $tableColumns)) {
            $postData['featured_image_caption'] = $validated['featured_image_caption'] ?? null;
        }
        if (in_array('author_name', $tableColumns)) {
            $postData['author_name'] = $validated['author_name'] ?? null;
        }

        $post = Post::create($postData);

        // Kategori (gabungkan checklist + new_category jika diinput)
        $categoryIds = $request->input('categories', []);
        if (! empty($validated['new_category'])) {
            $newCatName = trim($validated['new_category']);
            $newCat = Category::firstOrCreate(
                ['slug' => Str::slug($newCatName)],
                ['name' => $newCatName]
            );
            if (! in_array($newCat->id, $categoryIds)) {
                $categoryIds[] = $newCat->id;
            }
        }

        if (! empty($categoryIds)) {
            $post->categories()->sync($categoryIds);
        }

        // Process tags
        if (! empty($validated['tags'])) {
            $tagNames = array_filter(array_map('trim', explode(',', $validated['tags'])));
            $tagIds = [];
            foreach ($tagNames as $tName) {
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

        return redirect()->route('admin.posts.index', $redirectParams)->with('success', 'Konten berhasil disimpan dan diterbitkan!');
    }

    public function edit(Request $request, Post $post)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $post->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda tidak memiliki izin mengedit konten unit lain.');
        }

        KhutbahService::ensureCategoryAndDemos();

        $type = $post->type;
        $categories = Category::orderBy('name', 'asc')->get();
        $tags = Tag::orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        $selectedTags = $post->tags->pluck('name')->implode(', ');

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'users', 'selectedCategories', 'selectedTags', 'type'));
    }

    public function update(Request $request, Post $post)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $post->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda tidak memiliki izin mengedit konten unit lain.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:post,prestasi,ekskul,alumni',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:publish,draft',
            'is_featured' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'author_id' => 'nullable|exists:users,id',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'featured_image_caption' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'new_category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
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

        // Tanggal terbit kustom atau pertahankan tanggal yang ada
        $publishedAt = ! empty($validated['published_at'])
            ? Carbon::parse($validated['published_at'])
            : ($post->published_at ?? now());

        $this->ensureEditorialColumns();
        $tableColumns = Schema::getColumnListing('posts');

        $updateData = [
            'title' => $validated['title'],
            'type' => $validated['type'] ?? $post->type,
            'content' => $validated['content'],
            'excerpt' => ($validated['excerpt'] ?? null) ?: Str::limit(strip_tags($validated['content']), 180),
            'status' => $validated['status'],
            'featured_image' => $featuredImageUrl,
            'author_id' => $validated['author_id'] ?? $post->author_id,
            'published_at' => $publishedAt,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
        ];

        if ($user?->isUnitAdmin()) {
            $updateData['unit_pendidikan_id'] = $user->unit_pendidikan_id;
        } elseif ($request->filled('unit_pendidikan_id')) {
            $updateData['unit_pendidikan_id'] = $request->input('unit_pendidikan_id');
        }

        if (in_array('is_featured', $tableColumns)) {
            $updateData['is_featured'] = $request->boolean('is_featured');
        }
        if (in_array('featured_image_caption', $tableColumns)) {
            $updateData['featured_image_caption'] = $validated['featured_image_caption'] ?? null;
        }
        if (in_array('author_name', $tableColumns)) {
            $updateData['author_name'] = $validated['author_name'] ?? null;
        }

        $post->update($updateData);

        // Kategori (sinkronkan daftar terpilih + new_category jika diinput)
        $categoryIds = $request->input('categories', []);
        if (! empty($validated['new_category'])) {
            $newCatName = trim($validated['new_category']);
            $newCat = Category::firstOrCreate(
                ['slug' => Str::slug($newCatName)],
                ['name' => $newCatName]
            );
            if (! in_array($newCat->id, $categoryIds)) {
                $categoryIds[] = $newCat->id;
            }
        }
        $post->categories()->sync($categoryIds);

        // Tags
        if ($request->has('tags')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->input('tags', ''))));
            $tagIds = [];
            foreach ($tagNames as $tName) {
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

    public function destroy(Request $request, Post $post)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $post->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda tidak memiliki izin menghapus konten unit lain.');
        }

        $type = $post->type;
        $post->delete();

        $redirectParams = ($type === 'post') ? [] : ['type' => $type];

        return redirect()->route('admin.posts.index', $redirectParams)->with('success', 'Konten berhasil dihapus!');
    }

    /**
     * Ensure editorial columns exist in the database; self-heal with migration if missing.
     */
    private function ensureEditorialColumns(): void
    {
        try {
            if (! Schema::hasColumn('posts', 'is_featured')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            // Gracefully continue on web execution
        }
    }
}
