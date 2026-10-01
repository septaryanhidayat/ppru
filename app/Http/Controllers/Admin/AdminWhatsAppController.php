<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminWhatsAppController extends Controller
{
    /**
     * Display the dedicated WhatsApp management dashboard.
     */
    public function index(): View
    {
        $settings = Setting::allCached();
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.whatsapp.index', compact('settings', 'units'));
    }

    /**
     * Update WhatsApp channel configuration and unit WhatsApp numbers.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_whatsapp_label' => 'nullable|string|max:100',
            'wa_helpdesk_message' => 'nullable|string|max:1000',
            'ppdb_hotline_phone' => 'nullable|string|max:50',
            'ppdb_hotline_name' => 'nullable|string|max:100',
            'ppdb_hotline_2_phone' => 'nullable|string|max:50',
            'ppdb_hotline_2_name' => 'nullable|string|max:100',
            'ppdb_wa_template' => 'nullable|string|max:1000',
            'wa_alumni_article' => 'nullable|string|max:50',
            'wa_alumni_article_template' => 'nullable|string|max:1000',
            'wa_santri_article' => 'nullable|string|max:50',
            'wa_santri_article_template' => 'nullable|string|max:1000',
            'ptsp_helpdesk_phone' => 'nullable|string|max:50',
            'ptsp_helpdesk_wa_template' => 'nullable|string|max:1000',
            'wa_layanan_sewa' => 'nullable|string|max:50',
            'wa_layanan_kerjasama' => 'nullable|string|max:50',
            'wa_layanan_izin' => 'nullable|string|max:50',
            'donation_confirm_phone' => 'nullable|string|max:50',
            'donation_confirm_text' => 'nullable|string|max:1000',
            'units' => 'nullable|array',
            'units.*.phone' => 'nullable|string|max:50',
        ]);

        $settingKeys = [
            'contact_whatsapp',
            'contact_whatsapp_label',
            'wa_helpdesk_message',
            'ppdb_hotline_phone',
            'ppdb_hotline_name',
            'ppdb_hotline_2_phone',
            'ppdb_hotline_2_name',
            'ppdb_wa_template',
            'wa_alumni_article',
            'wa_alumni_article_template',
            'wa_santri_article',
            'wa_santri_article_template',
            'ptsp_helpdesk_phone',
            'ptsp_helpdesk_wa_template',
            'wa_layanan_sewa',
            'wa_layanan_kerjasama',
            'wa_layanan_izin',
            'donation_confirm_phone',
            'donation_confirm_text',
        ];

        foreach ($settingKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, (string) $request->input($key, ''), 'whatsapp');
            }
        }

        // Also sync contact_phone if contact_whatsapp is updated and contact_phone is empty
        if ($request->filled('contact_whatsapp') && ! Setting::get('contact_phone')) {
            Setting::set('contact_phone', (string) $request->input('contact_whatsapp'), 'general');
        }

        // Update each Unit Pendidikan WhatsApp number
        if ($request->has('units') && is_array($request->input('units'))) {
            foreach ($request->input('units') as $unitId => $unitData) {
                if (isset($unitData['phone'])) {
                    UnitPendidikan::where('id', (int) $unitId)->update([
                        'phone' => trim((string) $unitData['phone']),
                    ]);
                }
            }
        }

        Setting::clearCache();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Administrator',
            'action' => 'whatsapp_settings_update',
            'description' => 'Memperbarui konfigurasi nomor WhatsApp website (Pusat, Unit Pendidikan, PSB, Alumni, Layanan, Donasi)',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Konfigurasi nomor WhatsApp dan template pesan berhasil disimpan!');
    }
}
