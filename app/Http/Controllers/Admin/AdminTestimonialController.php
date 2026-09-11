<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'photo' => 'nullable|string|max:255',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:publish,draft',
        ]);

        $photoPath = $validated['photo'] ?? null;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'testimonial_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $filename);
            $photoPath = '/uploads/testimonials/'.$filename;
        }

        $testimonial = Testimonial::create([
            'name' => $validated['name'],
            'profession' => $validated['profession'] ?? '',
            'content' => $validated['content'],
            'photo' => $photoPath,
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_create',
            'description' => "Menambahkan Testimonial baru dari: {$testimonial->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'photo' => 'nullable|string|max:255',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:publish,draft',
        ]);

        $photoPath = $testimonial->photo;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'testimonial_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $filename);
            $photoPath = '/uploads/testimonials/'.$filename;
        } elseif ($request->filled('photo')) {
            $photoPath = $validated['photo'];
        }

        $testimonial->update([
            'name' => $validated['name'],
            'profession' => $validated['profession'] ?? '',
            'content' => $validated['content'],
            'photo' => $photoPath,
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_update',
            'description' => "Memperbarui Testimonial dari: {$testimonial->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Request $request, Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $testimonial->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_delete',
            'description' => "Menghapus Testimonial dari: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }
}
