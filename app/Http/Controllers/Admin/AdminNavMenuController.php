<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\NavMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNavMenuController extends Controller
{
    public function index()
    {
        $headerMenus = NavMenu::where('location', 'header')
            ->whereNull('parent_id')
            ->with(['children'])
            ->orderBy('order', 'asc')
            ->get();

        $footerMenus = NavMenu::where('location', 'footer_quick')
            ->orderBy('order', 'asc')
            ->get();

        $allParentCandidates = NavMenu::where('location', 'header')
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();

        return view('admin.nav-menus.index', compact('headerMenus', 'footerMenus', 'allParentCandidates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:100',
            'location' => 'required|string|in:header,footer_quick,footer_info',
            'parent_id' => 'nullable|exists:nav_menus,id',
            'target' => 'nullable|string|in:_self,_blank',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $menu = NavMenu::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?? null,
            'location' => $validated['location'],
            'parent_id' => $validated['parent_id'] ?? null,
            'target' => $validated['target'] ?? '_self',
            'order' => $validated['order'] ?? ((NavMenu::where('location', $validated['location'])->max('order') ?? 0) + 1),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'menu_create',
            'description' => "Menambahkan item menu navigasi: {$menu->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.nav-menus.index')->with('success', "Item menu '{$menu->name}' berhasil ditambahkan.");
    }

    public function update(Request $request, NavMenu $navMenu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:100',
            'location' => 'required|string|in:header,footer_quick,footer_info',
            'parent_id' => 'nullable|exists:nav_menus,id',
            'target' => 'nullable|string|in:_self,_blank',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $navMenu->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?? null,
            'location' => $validated['location'],
            'parent_id' => $validated['parent_id'] ?? null,
            'target' => $validated['target'] ?? '_self',
            'order' => $validated['order'] ?? $navMenu->order,
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : false,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'menu_update',
            'description' => "Memperbarui item menu navigasi: {$navMenu->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.nav-menus.index')->with('success', "Item menu '{$navMenu->name}' berhasil diperbarui.");
    }

    public function destroy(Request $request, NavMenu $navMenu)
    {
        $name = $navMenu->name;
        $navMenu->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'menu_delete',
            'description' => "Menghapus item menu navigasi: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.nav-menus.index')->with('success', "Item menu '{$name}' berhasil dihapus.");
    }
}
