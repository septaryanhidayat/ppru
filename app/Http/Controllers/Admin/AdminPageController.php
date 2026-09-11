<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Post;
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
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Post $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $page->update([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? '',
            'excerpt' => $validated['excerpt'] ?? '',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

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
