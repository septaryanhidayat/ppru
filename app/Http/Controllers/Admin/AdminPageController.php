<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Post::where('type', 'page')->latest('updated_at')->paginate(20);

        return view('admin.pages.index', compact('pages'));
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
        ]);

        $page->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? '',
            'excerpt' => $validated['excerpt'] ?? '',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        // Handle Mudir & Sambutan Settings if present
        $mudirKeys = [
            'mudir_name', 'mudir_position', 'mudir_quote', 'mudir_badge',
            'sambutan_cta_title', 'sambutan_cta_subtitle',
            'sambutan_cta_btn1_text', 'sambutan_cta_btn1_url',
            'sambutan_cta_btn2_text', 'sambutan_cta_btn2_url',
        ];

        foreach ($mudirKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'sambutan');
            }
        }

        if ($request->hasFile('mudir_photo_file')) {
            $file = $request->file('mudir_photo_file');
            $filename = 'foto-mudir-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/official'), $filename);
            Setting::set('mudir_photo', '/uploads/official/'.$filename, 'sambutan');
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
}
