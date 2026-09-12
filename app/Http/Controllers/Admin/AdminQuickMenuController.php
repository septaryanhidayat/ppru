<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\QuickMenu;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminQuickMenuController extends Controller
{
    public function __construct(
        protected WebpService $webpService
    ) {}

    public function index()
    {
        $quickMenus = QuickMenu::orderBy('order', 'asc')->get();

        return view('admin.quick_menus.index', compact('quickMenus'));
    }

    public function create()
    {
        return view('admin.quick_menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $iconPath = $validated['icon'] ?? 'fa-solid fa-link';
        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'svg') {
                $filename = 'icon_'.time().'_'.uniqid().'.svg';
                $file->move(public_path('uploads/icons'), $filename);
                $iconPath = '/uploads/icons/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'icons', 85, 400);
                $iconPath = $converted['url'];
            }
        }

        $menu = QuickMenu::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'icon' => $iconPath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'quick_menu_create',
            'description' => "Menambahkan Quick Menu Beranda: {$menu->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.quick-menus.index')->with('success', 'Menu Cepat berhasil ditambahkan.');
    }

    public function edit(QuickMenu $quickMenu)
    {
        return view('admin.quick_menus.edit', compact('quickMenu'));
    }

    public function update(Request $request, QuickMenu $quickMenu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $iconPath = $quickMenu->icon;
        if ($request->hasFile('icon_file')) {
            $file = $request->file('icon_file');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'svg') {
                $filename = 'icon_'.time().'_'.uniqid().'.svg';
                $file->move(public_path('uploads/icons'), $filename);
                $iconPath = '/uploads/icons/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'icons', 85, 400);
                $iconPath = $converted['url'];
            }
        } elseif ($request->filled('icon')) {
            $iconPath = $validated['icon'];
        }

        $quickMenu->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'icon' => $iconPath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'quick_menu_update',
            'description' => "Memperbarui Quick Menu Beranda: {$quickMenu->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.quick-menus.index')->with('success', 'Menu Cepat berhasil diperbarui.');
    }

    public function destroy(Request $request, QuickMenu $quickMenu)
    {
        $name = $quickMenu->name;
        $quickMenu->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'quick_menu_delete',
            'description' => "Menghapus Quick Menu Beranda: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.quick-menus.index')->with('success', 'Menu Cepat berhasil dihapus.');
    }
}
