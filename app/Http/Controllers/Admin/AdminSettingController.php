<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'og_image_file', 'site_logo_file', 'home_profile_poster_file', 'home_mudir_photo_file']);

        // Handle OG Image file upload
        if ($request->hasFile('og_image_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('og_image_file'), 'settings', 90, 1200);
            if ($converted['success']) {
                $data['og_image'] = $converted['url'];
            }
        }

        // Handle Site Logo file upload
        if ($request->hasFile('site_logo_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('site_logo_file'), 'settings', 95, 800);
            if ($converted['success']) {
                $data['site_logo'] = $converted['url'];
            }
        }

        // Handle Home Profile Poster file upload
        if ($request->hasFile('home_profile_poster_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('home_profile_poster_file'), 'settings', 85, 1920);
            if ($converted['success']) {
                $data['home_profile_poster_image'] = $converted['url'];
            }
        }

        // Handle Home Mudir Photo upload
        if ($request->hasFile('home_mudir_photo_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('home_mudir_photo_file'), 'official', 90, 1000);
            if ($converted['success']) {
                $data['mudir_photo'] = $converted['url'];
            }
        }

        foreach ($data as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val ?? '', 'group' => 'general']
            );
        }

        if (isset($data['analytics_base_hits']) && is_numeric($data['analytics_base_hits'])) {
            @file_put_contents(storage_path('app/visitor_hits.txt'), (string) (int) $data['analytics_base_hits']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'settings_update',
            'description' => 'Memperbarui konfigurasi website dan pengaturan SEO & OpenGraph',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Pengaturan website dan SEO berhasil disimpan!');
    }
}
