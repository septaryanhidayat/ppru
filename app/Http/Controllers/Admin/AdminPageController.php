<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\Setting;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    public function index()
    {
        $pages = Post::where('type', 'page')->orderBy('title', 'asc')->paginate(25);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'nullable|string|in:publish,draft',
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);

        // Prevent duplicate slug
        $baseSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $page = Post::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? '',
            'content' => $validated['content'] ?? '',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'status' => $validated['status'] ?? 'publish',
            'type' => 'page',
            'user_id' => Auth::id() ?? 1,
            'published_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_create',
            'description' => "Membuat halaman statis baru: {$page->title} (/{$page->slug})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$page->title}' berhasil dibuat.");
    }

    public function edit(Post $page)
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.pages.edit', compact('page', 'settings'));
    }

    public function update(Request $request, Post $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',

            // Sambutan Mudir Fields
            'mudir_photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'mudir_name' => 'nullable|string|max:255',
            'mudir_position' => 'nullable|string|max:255',
            'mudir_quote' => 'nullable|string|max:500',
            'mudir_badge' => 'nullable|string|max:255',
            'sambutan_cta_title' => 'nullable|string|max:255',
            'sambutan_cta_subtitle' => 'nullable|string|max:500',
            'sambutan_cta_btn1_text' => 'nullable|string|max:100',
            'sambutan_cta_btn1_url' => 'nullable|string|max:255',
            'sambutan_cta_btn2_text' => 'nullable|string|max:100',
            'sambutan_cta_btn2_url' => 'nullable|string|max:255',

            // Visi & Misi Fields
            'visimisi_visi_text' => 'nullable|string',
            'visimisi_misi_1_title' => 'nullable|string|max:255',
            'visimisi_misi_1_desc' => 'nullable|string',
            'visimisi_misi_2_title' => 'nullable|string|max:255',
            'visimisi_misi_2_desc' => 'nullable|string',
            'visimisi_misi_3_title' => 'nullable|string|max:255',
            'visimisi_misi_3_desc' => 'nullable|string',
            'visimisi_10_jatidiri' => 'nullable|string',

            // Sejarah Fields
            'sejarah_subtitle' => 'nullable|string|max:255',
            'sejarah_image_url' => 'nullable|string|max:500',
            'sejarah_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',

            // Struktur Organisasi Fields
            'struktur_intro' => 'nullable|string',
            'struktur_chart_image_url' => 'nullable|string|max:500',
            'struktur_chart_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $page->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? '',
            'excerpt' => $validated['excerpt'] ?? '',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        // Handle Mudir Settings
        $mudirKeys = [
            'mudir_name', 'mudir_position', 'mudir_quote', 'mudir_badge',
            'sambutan_cta_title', 'sambutan_cta_subtitle',
            'sambutan_cta_btn1_text', 'sambutan_cta_btn1_url',
            'sambutan_cta_btn2_text', 'sambutan_cta_btn2_url',
        ];
        foreach ($mudirKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key) ?? '', 'sambutan');
            }
        }
        if ($request->hasFile('mudir_photo_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('mudir_photo_file'), 'official', 90, 1000);
            if ($converted['success']) {
                Setting::set('mudir_photo', $converted['url'], 'sambutan');
            }
        }

        // Handle Visi Misi Settings
        $visiMisiKeys = [
            'visimisi_visi_text',
            'visimisi_misi_1_title', 'visimisi_misi_1_desc',
            'visimisi_misi_2_title', 'visimisi_misi_2_desc',
            'visimisi_misi_3_title', 'visimisi_misi_3_desc',
            'visimisi_10_jatidiri',
        ];
        foreach ($visiMisiKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key) ?? '', 'visimisi');
            }
        }

        // Handle Sejarah Settings
        if ($request->has('sejarah_subtitle')) {
            Setting::set('sejarah_subtitle', $request->input('sejarah_subtitle') ?? '', 'sejarah');
        }
        if ($request->hasFile('sejarah_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('sejarah_image_file'), 'sejarah', 85, 1600);
            if ($converted['success']) {
                Setting::set('sejarah_image_url', $converted['url'], 'sejarah');
            }
        } elseif (! empty($validated['sejarah_image_url'])) {
            Setting::set('sejarah_image_url', $validated['sejarah_image_url'], 'sejarah');
        }

        // Handle Struktur Organisasi Settings
        if ($request->has('struktur_intro')) {
            Setting::set('struktur_intro', $request->input('struktur_intro') ?? '', 'struktur');
        }
        if ($request->hasFile('struktur_chart_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('struktur_chart_image_file'), 'struktur', 90, 2000);
            if ($converted['success']) {
                Setting::set('struktur_chart_image_url', $converted['url'], 'struktur');
            }
        } elseif (! empty($validated['struktur_chart_image_url'])) {
            Setting::set('struktur_chart_image_url', $validated['struktur_chart_image_url'], 'struktur');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'page_update',
            'description' => "Memperbarui konten halaman profil: {$page->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$page->title}' berhasil diperbarui.");
    }

    public function destroy(Post $page)
    {
        $title = $page->title;
        $page->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_delete',
            'description' => "Menghapus halaman: {$title}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.pages.index')->with('success', "Halaman '{$title}' berhasil dihapus.");
    }
}
