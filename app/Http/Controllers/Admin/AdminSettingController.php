<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\VisitorTrackerService;
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
        $request->validate([
            'og_image_file' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:20480',
            'site_logo_file' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:20480',
            'home_profile_poster_file' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:20480',
            'home_mudir_photo_file' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:20480',
        ]);

        $allowedSettingKeys = [
            'site_name', 'site_tagline', 'site_description', 'site_logo',
            'og_title', 'og_description', 'og_image', 'twitter_card',
            'meta_keywords', 'google_site_verification',
            'contact_address', 'contact_email', 'contact_phone',
            'social_facebook', 'social_instagram', 'social_youtube', 'social_tiktok', 'social_twitter',
            'home_mudir_name', 'home_mudir_role', 'mudir_photo',
            'home_sambutan_badge', 'home_sambutan_title', 'home_sambutan_quote',
            'home_sambutan_text_1', 'home_sambutan_text_2', 'home_sambutan_btn_text', 'home_sambutan_btn_url',
            'home_profile_badge', 'home_profile_headline', 'home_profile_desc',
            'home_profile_video_bg', 'home_profile_video_popup_id', 'home_profile_poster_image',
            'home_profile_overlay_opacity', 'home_profile_btn_text',
            'home_stat_title', 'home_stat_subtitle',
            'home_stat_1_number', 'home_stat_1_label', 'home_stat_1_desc',
            'home_stat_2_number', 'home_stat_2_label', 'home_stat_2_desc',
            'home_stat_3_number', 'home_stat_3_label', 'home_stat_3_desc',
            'home_stat_4_number', 'home_stat_4_label', 'home_stat_4_desc',
            'home_trisula_badge', 'home_trisula_title', 'home_trisula_subtitle',
            'home_trisula_1_badge', 'home_trisula_1_title', 'home_trisula_1_desc', 'home_trisula_1_icon', 'home_trisula_1_footer',
            'home_trisula_2_badge', 'home_trisula_2_title', 'home_trisula_2_desc', 'home_trisula_2_icon', 'home_trisula_2_footer',
            'home_trisula_3_badge', 'home_trisula_3_title', 'home_trisula_3_desc', 'home_trisula_3_icon', 'home_trisula_3_footer',
            'home_psb_badge', 'home_psb_title', 'home_psb_desc',
            'home_psb_btn1_text', 'home_psb_btn1_url', 'home_psb_btn2_text', 'home_psb_btn2_url',
            'home_infaq_badge', 'home_infaq_title', 'home_infaq_desc',
            'home_infaq_btn1_text', 'home_infaq_btn1_url', 'home_infaq_btn2_text', 'home_infaq_btn2_url',
            'donation_intro_text', 'donation_confirm_phone', 'donation_confirm_text',
            'donation_bank_1_name', 'donation_bank_1_rekening', 'donation_bank_1_holder', 'donation_bank_1_code',
            'donation_bank_2_name', 'donation_bank_2_rekening', 'donation_bank_2_holder', 'donation_bank_2_code',
            'analytics_enabled', 'analytics_base_hits', 'analytics_ip_lookup', 'analytics_ignore_admin',
        ];

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

        // Whitelist filter: ensure only recognized setting keys are saved
        $data = array_intersect_key($data, array_flip($allowedSettingKeys));

        foreach ($data as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val ?? '', 'group' => 'general']
            );
        }

        if (isset($data['analytics_base_hits']) && is_numeric($data['analytics_base_hits']) && (int) $data['analytics_base_hits'] > 0) {
            VisitorTrackerService::setBaseHits((int) $data['analytics_base_hits']);
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
