<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\WebpService;
use Illuminate\Http\Request;

class AdminPopupController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    public function index()
    {
        $popup = [
            'active' => Setting::get('popup_active', '1'),
            'image' => Setting::get('popup_image', '/uploads/popup/popup-ppdb.webp'),
            'title' => Setting::get('popup_title', 'Penerimaan Peserta Didik Baru (PPDB) TP 2025/2026'),
            'subtitle' => Setting::get('popup_subtitle', 'Potongan Biaya Masuk s.d 50% - Kuota Terbatas!'),
            'link' => Setting::get('popup_link', '/ppdb'),
            'target' => Setting::get('popup_target', '_self'),
            'button_text' => Setting::get('popup_button_text', 'Daftar PPDB Sekarang'),
        ];

        return view('admin.popup.index', compact('popup'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'popup_active' => 'nullable|in:0,1',
            'popup_title' => 'required|string|max:255',
            'popup_subtitle' => 'nullable|string|max:255',
            'popup_link' => 'required|string|max:255',
            'popup_button_text' => 'required|string|max:100',
            'popup_target' => 'nullable|string|in:_self,_blank',
            'popup_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $active = $request->has('popup_active') ? $request->input('popup_active') : '0';
        Setting::set('popup_active', (string) $active, 'popup');
        Setting::set('popup_title', $validated['popup_title'], 'popup');
        Setting::set('popup_subtitle', $validated['popup_subtitle'] ?? '', 'popup');
        Setting::set('popup_link', $validated['popup_link'], 'popup');
        Setting::set('popup_button_text', $validated['popup_button_text'], 'popup');
        Setting::set('popup_target', $validated['popup_target'] ?? '_self', 'popup');

        if ($request->hasFile('popup_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('popup_image_file'), 'popup', 90, 1000);
            if ($converted['success']) {
                Setting::set('popup_image', $converted['url'], 'popup');
            }
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'action' => 'popup_settings_update',
            'description' => 'Memperbarui pengaturan Popup Banner Beranda (Status: '.($active ? 'Aktif' : 'Nonaktif').')',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Pengaturan Popup Banner Beranda berhasil disimpan!');
    }
}
