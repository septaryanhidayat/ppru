<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HeroSlide;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHeroSlideController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    public function index()
    {
        $slides = HeroSlide::orderBy('order', 'asc')->get();

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        $nextOrder = (HeroSlide::max('order') ?? 0) + 1;

        return view('admin.hero-slides.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'btn_primary_text' => 'nullable|string|max:100',
            'btn_primary_url' => 'nullable|string|max:255',
            'btn_secondary_text' => 'nullable|string|max:100',
            'btn_secondary_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $validated['image'] ?? '/uploads/official/drone-raudhatul-ulum.webp';

        if ($request->hasFile('image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('image_file'), 'hero', 85, 1920);
            if ($converted['success']) {
                $imagePath = $converted['url'];
            }
        }

        $slide = HeroSlide::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? '',
            'badge' => $validated['badge'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga',
            'image' => $imagePath,
            'btn_primary_text' => $validated['btn_primary_text'] ?: 'Profil Singkat Pesantren',
            'btn_primary_url' => $validated['btn_primary_url'] ?: '/tentang-kami',
            'btn_secondary_text' => $validated['btn_secondary_text'] ?: 'Pendaftaran PSB',
            'btn_secondary_url' => $validated['btn_secondary_url'] ?: '/ppdb',
            'order' => $validated['order'] ?? ((HeroSlide::max('order') ?? 0) + 1),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'hero_slide_create',
            'description' => "Menambahkan banner hero slider: {$slide->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.hero-slides.index')->with('success', "Banner hero '{$slide->title}' berhasil ditambahkan.");
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'btn_primary_text' => 'nullable|string|max:100',
            'btn_primary_url' => 'nullable|string|max:255',
            'btn_secondary_text' => 'nullable|string|max:100',
            'btn_secondary_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $heroSlide->image;

        if ($request->hasFile('image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('image_file'), 'hero', 85, 1920);
            if ($converted['success']) {
                $imagePath = $converted['url'];
            }
        } elseif (! empty($validated['image'])) {
            $imagePath = $validated['image'];
        }

        $heroSlide->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? '',
            'badge' => $validated['badge'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga',
            'image' => $imagePath,
            'btn_primary_text' => $validated['btn_primary_text'] ?: 'Profil Singkat Pesantren',
            'btn_primary_url' => $validated['btn_primary_url'] ?: '/tentang-kami',
            'btn_secondary_text' => $validated['btn_secondary_text'] ?: 'Pendaftaran PSB',
            'btn_secondary_url' => $validated['btn_secondary_url'] ?: '/ppdb',
            'order' => $validated['order'] ?? $heroSlide->order,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'hero_slide_update',
            'description' => "Memperbarui banner hero slider: {$heroSlide->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.hero-slides.index')->with('success', "Banner hero '{$heroSlide->title}' berhasil diperbarui.");
    }

    public function destroy(Request $request, HeroSlide $heroSlide)
    {
        $title = $heroSlide->title;
        $heroSlide->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'hero_slide_delete',
            'description' => "Menghapus banner hero slider: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.hero-slides.index')->with('success', "Banner hero '{$title}' berhasil dihapus.");
    }
}
