<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnggotaDewan;
use App\Models\Post;
use App\Models\Setting;
use App\Services\HtmlSanitizer;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStaticPageController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    /**
     * Halaman Pengelolaan Khusus Struktur Organisasi & Bagan
     */
    public function struktur()
    {
        $page = Post::pages()->whereIn('slug', ['struktur-organisasi', 'struktur-kepengurusan'])->first();
        if (! $page) {
            $page = Post::create([
                'title' => 'Struktur Organisasi & Kepengurusan',
                'slug' => 'struktur-organisasi',
                'excerpt' => 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
                'content' => '',
                'status' => 'publish',
                'type' => 'page',
                'author_id' => Auth::id() ?? 1,
                'author_name' => Auth::user()?->name ?? 'Administrator',
                'published_at' => now(),
            ]);
        }

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $pengurus = AnggotaDewan::orderBy('order', 'asc')->get();

        return view('admin.pages.struktur', compact('page', 'settings', 'pengurus'));
    }

    /**
     * Simpan Perubahan Halaman Khusus Struktur Organisasi & Bagan
     */
    public function updateStruktur(Request $request)
    {
        $page = Post::pages()->whereIn('slug', ['struktur-organisasi', 'struktur-kepengurusan'])->first();
        if (! $page) {
            $page = Post::create([
                'title' => 'Struktur Organisasi & Kepengurusan',
                'slug' => 'struktur-organisasi',
                'excerpt' => 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
                'content' => '',
                'type' => 'page',
                'status' => 'published',
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'struktur_intro' => 'nullable|string',
            'struktur_chart_image_url' => 'nullable|string|max:500',
            'struktur_chart_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:15360',
            'struktur_chart_mode' => 'nullable|string|in:image,chart,dynamic,both',
            'struktur_show_facilities' => 'nullable|boolean',
            'struktur_show_programs' => 'nullable|boolean',
            'remove_chart_image' => 'nullable|boolean',
        ]);

        $page->update([
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? '',
            'content' => HtmlSanitizer::clean($validated['content'] ?? ''),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        if ($request->has('struktur_intro')) {
            Setting::set('struktur_intro', $request->input('struktur_intro') ?? '', 'struktur');
        }

        Setting::set('struktur_chart_mode', $request->input('struktur_chart_mode', 'image'), 'struktur');
        Setting::set('struktur_show_facilities', $request->has('struktur_show_facilities') ? '1' : '0', 'struktur');
        Setting::set('struktur_show_programs', $request->has('struktur_show_programs') ? '1' : '0', 'struktur');

        if ($request->boolean('remove_chart_image')) {
            Setting::set('struktur_chart_image_url', '', 'struktur');
            $page->update(['featured_image' => null]);
        } elseif ($request->hasFile('struktur_chart_image_file')) {
            $converted = $this->webpService->processUploadedFile(
                $request->file('struktur_chart_image_file'),
                'struktur',
                92,
                2500
            );
            if ($converted['success']) {
                $chartUrl = $converted['url'];
                Setting::set('struktur_chart_image_url', $chartUrl, 'struktur');
                $page->update(['featured_image' => $chartUrl]);
            }
        } elseif (! empty($validated['struktur_chart_image_url'])) {
            Setting::set('struktur_chart_image_url', $validated['struktur_chart_image_url'], 'struktur');
            $page->update(['featured_image' => $validated['struktur_chart_image_url']]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_update',
            'description' => "Memperbarui halaman Struktur Organisasi: {$page->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.struktur')->with('success', 'Halaman Struktur Organisasi & Bagan berhasil diperbarui.');
    }

    /**
     * Halaman Pengelolaan Konten Dinamis Donasi & Infaq
     */
    public function donasi()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.pages.donasi', compact('settings'));
    }

    /**
     * Simpan Perubahan Konten Dinamis Donasi & Infaq
     */
    public function updateDonasi(Request $request)
    {
        $validated = $request->validate([
            'donation_hero_badge' => 'nullable|string|max:255',
            'donation_hero_title' => 'nullable|string|max:255',
            'donation_hero_desc' => 'nullable|string',
            'donation_quote_text' => 'nullable|string',
            'donation_quote_source' => 'nullable|string|max:255',
            'donation_section_badge' => 'nullable|string|max:255',
            'donation_section_title' => 'nullable|string|max:255',
            'donation_section_subtitle' => 'nullable|string',

            // Bank 1
            'donation_bank_1_name' => 'nullable|string|max:255',
            'donation_bank_1_code' => 'nullable|string|max:20',
            'donation_bank_1_rekening' => 'nullable|string|max:100',
            'donation_bank_1_holder' => 'nullable|string|max:255',
            'donation_bank_1_subtitle' => 'nullable|string|max:255',
            'donation_bank_1_badge' => 'nullable|string|max:255',
            'donation_bank_1_btn_text' => 'nullable|string|max:100',

            // Bank 2
            'donation_bank_2_name' => 'nullable|string|max:255',
            'donation_bank_2_code' => 'nullable|string|max:20',
            'donation_bank_2_rekening' => 'nullable|string|max:100',
            'donation_bank_2_holder' => 'nullable|string|max:255',
            'donation_bank_2_subtitle' => 'nullable|string|max:255',
            'donation_bank_2_badge' => 'nullable|string|max:255',
            'donation_bank_2_btn_text' => 'nullable|string|max:100',

            // Bank 3 (Opsional)
            'donation_bank_3_name' => 'nullable|string|max:255',
            'donation_bank_3_code' => 'nullable|string|max:20',
            'donation_bank_3_rekening' => 'nullable|string|max:100',
            'donation_bank_3_holder' => 'nullable|string|max:255',
            'donation_bank_3_subtitle' => 'nullable|string|max:255',
            'donation_bank_3_badge' => 'nullable|string|max:255',
            'donation_bank_3_btn_text' => 'nullable|string|max:100',

            // Konfirmasi WhatsApp
            'donation_confirm_badge' => 'nullable|string|max:255',
            'donation_confirm_title' => 'nullable|string|max:255',
            'donation_confirm_desc' => 'nullable|string',
            'donation_confirm_phone' => 'nullable|string|max:50',
            'donation_confirm_text' => 'nullable|string',
            'donation_confirm_btn_text' => 'nullable|string|max:100',
            'donation_confirm_footer_note' => 'nullable|string|max:255',

            // 3 Langkah Berinfaq
            'donation_steps_title' => 'nullable|string|max:255',
            'donation_steps_subtitle' => 'nullable|string',
            'donation_step_1_title' => 'nullable|string|max:255',
            'donation_step_1_desc' => 'nullable|string',
            'donation_step_2_title' => 'nullable|string|max:255',
            'donation_step_2_desc' => 'nullable|string',
            'donation_step_3_title' => 'nullable|string|max:255',
            'donation_step_3_desc' => 'nullable|string',

            // Transparansi
            'donation_transparency_title' => 'nullable|string|max:255',
            'donation_transparency_desc' => 'nullable|string',
            'donation_transparency_points' => 'nullable|string',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val ?? '', 'donation');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_update',
            'description' => 'Memperbarui konten dinamis halaman Donasi & Infaq',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.donasi')->with('success', 'Konten halaman Donasi & Infaq berhasil diperbarui secara menyeluruh.');
    }

    /**
     * Halaman Pengelolaan Konten Dinamis Mars & Hymne
     */
    public function hymneMars()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.pages.hymne-mars', compact('settings'));
    }

    /**
     * Simpan Perubahan Konten Dinamis Mars & Hymne
     */
    public function updateHymneMars(Request $request)
    {
        $validated = $request->validate([
            'hymne_mars_hero_badge' => 'nullable|string|max:255',
            'hymne_mars_hero_title' => 'nullable|string|max:255',
            'hymne_mars_hero_desc' => 'nullable|string',

            'hymne_mars_badge' => 'nullable|string|max:255',
            'hymne_mars_title' => 'nullable|string|max:255',
            'hymne_mars_subtitle' => 'nullable|string',
            'hymne_mars_youtube_url' => 'nullable|string|max:500',
            'hymne_mars_youtube_btn_text' => 'nullable|string|max:100',

            // Lirik Lengkap
            'hymne_mars_lyrics_title' => 'nullable|string|max:255',
            'hymne_mars_lyrics_stanza_1' => 'nullable|string',
            'hymne_mars_lyrics_reff_1' => 'nullable|string',
            'hymne_mars_lyrics_stanza_2' => 'nullable|string',
            'hymne_mars_lyrics_reff_2' => 'nullable|string',

            // Makna & Profil
            'hymne_mars_philo_title' => 'nullable|string|max:255',
            'hymne_mars_philo_desc' => 'nullable|string',
            'hymne_mars_creator_name' => 'nullable|string|max:255',
            'hymne_mars_year' => 'nullable|string|max:50',

            // Audio Download
            'hymne_mars_audio_url' => 'nullable|string|max:500',
            'hymne_mars_audio_btn_text' => 'nullable|string|max:100',
            'hymne_mars_audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:20480',

            // Flexible aliases
            'mars_page_title' => 'nullable|string|max:255',
            'mars_title' => 'nullable|string|max:255',
            'mars_youtube_url' => 'nullable|string|max:500',
            'mars_youtube_embed' => 'nullable|string|max:500',
            'mars_youtube_btn_text' => 'nullable|string|max:100',
            'mars_lyrics_heading' => 'nullable|string|max:255',
            'mars_lyrics_content' => 'nullable|string',
            'mars_characters_title' => 'nullable|string|max:255',
            'mars_characters_subtitle' => 'nullable|string',
        ]);

        if ($request->hasFile('hymne_mars_audio_file')) {
            $file = $request->file('hymne_mars_audio_file');
            $filename = 'mars-hymne-ppru-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/downloads'), $filename);
            $validated['hymne_mars_audio_url'] = '/uploads/downloads/'.$filename;
        }
        unset($validated['hymne_mars_audio_file']);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val ?? '', 'hymne_mars');
        }

        // Keep standard keys synced with aliases
        if (! empty($validated['hymne_mars_hero_title'])) {
            Setting::set('mars_page_title', $validated['hymne_mars_hero_title'], 'hymne_mars');
        } elseif (! empty($validated['mars_page_title'])) {
            Setting::set('hymne_mars_hero_title', $validated['mars_page_title'], 'hymne_mars');
        }

        if (! empty($validated['hymne_mars_title'])) {
            Setting::set('mars_title', $validated['hymne_mars_title'], 'hymne_mars');
        } elseif (! empty($validated['mars_title'])) {
            Setting::set('hymne_mars_title', $validated['mars_title'], 'hymne_mars');
        }

        if (! empty($validated['hymne_mars_youtube_url'])) {
            Setting::set('mars_youtube_url', $validated['hymne_mars_youtube_url'], 'hymne_mars');
        } elseif (! empty($validated['mars_youtube_url'])) {
            Setting::set('hymne_mars_youtube_url', $validated['mars_youtube_url'], 'hymne_mars');
        }

        if (! empty($validated['hymne_mars_youtube_btn_text'])) {
            Setting::set('mars_youtube_btn_text', $validated['hymne_mars_youtube_btn_text'], 'hymne_mars');
        } elseif (! empty($validated['mars_youtube_btn_text'])) {
            Setting::set('hymne_mars_youtube_btn_text', $validated['mars_youtube_btn_text'], 'hymne_mars');
        }

        if (! empty($validated['hymne_mars_lyrics_title'])) {
            Setting::set('mars_lyrics_heading', $validated['hymne_mars_lyrics_title'], 'hymne_mars');
        } elseif (! empty($validated['mars_lyrics_heading'])) {
            Setting::set('hymne_mars_lyrics_title', $validated['mars_lyrics_heading'], 'hymne_mars');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_update',
            'description' => 'Memperbarui konten dinamis halaman Mars & Hymne',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.hymne-mars')->with('success', 'Konten halaman Mars & Hymne berhasil diperbarui.');
    }

    /**
     * Halaman Pengelolaan Konten Dinamis Logo Resmi & Identitas Visual
     */
    public function logo()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.pages.logo', compact('settings'));
    }

    /**
     * Simpan Perubahan Konten Dinamis Logo Resmi & Identitas Visual
     */
    public function updateLogo(Request $request)
    {
        $validated = $request->validate([
            'logo_hero_badge' => 'nullable|string|max:255',
            'logo_hero_title' => 'nullable|string|max:255',
            'logo_hero_desc' => 'nullable|string',

            'logo_preview_badge' => 'nullable|string|max:255',
            'logo_preview_title' => 'nullable|string|max:255',
            'logo_preview_image' => 'nullable|string|max:500',
            'logo_download_btn_text' => 'nullable|string|max:255',
            'logo_download_url' => 'nullable|string|max:500',
            'logo_download_filename' => 'nullable|string|max:255',
            'logo_download_note' => 'nullable|string|max:500',

            // Filosofi 4 Elemen
            'logo_philo_title' => 'nullable|string|max:255',
            'logo_philo_1_icon' => 'nullable|string|max:100',
            'logo_philo_1_title' => 'nullable|string|max:255',
            'logo_philo_1_desc' => 'nullable|string',
            'logo_philo_2_icon' => 'nullable|string|max:100',
            'logo_philo_2_title' => 'nullable|string|max:255',
            'logo_philo_2_desc' => 'nullable|string',
            'logo_philo_3_icon' => 'nullable|string|max:100',
            'logo_philo_3_title' => 'nullable|string|max:255',
            'logo_philo_3_desc' => 'nullable|string',
            'logo_philo_4_icon' => 'nullable|string|max:100',
            'logo_philo_4_title' => 'nullable|string|max:255',
            'logo_philo_4_desc' => 'nullable|string',

            // Palet Warna
            'logo_color_title' => 'nullable|string|max:255',
            'logo_color_1_name' => 'nullable|string|max:255',
            'logo_color_1_hex' => 'nullable|string|max:20',
            'logo_color_1_desc' => 'nullable|string',
            'logo_color_2_name' => 'nullable|string|max:255',
            'logo_color_2_hex' => 'nullable|string|max:20',
            'logo_color_2_desc' => 'nullable|string',
            'logo_color_3_name' => 'nullable|string|max:255',
            'logo_color_3_hex' => 'nullable|string|max:20',
            'logo_color_3_desc' => 'nullable|string',

            // Paket Varian Logo
            'logo_variant_title' => 'nullable|string|max:255',
            'logo_variant_subtitle' => 'nullable|string',
            'logo_variant_badge' => 'nullable|string|max:255',

            // Varian 1
            'logo_var_1_title' => 'nullable|string|max:255',
            'logo_var_1_format' => 'nullable|string|max:255',
            'logo_var_1_tag' => 'nullable|string|max:100',
            'logo_var_1_image' => 'nullable|string|max:500',
            'logo_var_1_file' => 'nullable|string|max:500',
            'logo_var_1_filename' => 'nullable|string|max:255',
            'logo_var_1_btn' => 'nullable|string|max:100',

            // Varian 2
            'logo_var_2_title' => 'nullable|string|max:255',
            'logo_var_2_format' => 'nullable|string|max:255',
            'logo_var_2_tag' => 'nullable|string|max:100',
            'logo_var_2_image' => 'nullable|string|max:500',
            'logo_var_2_file' => 'nullable|string|max:500',
            'logo_var_2_filename' => 'nullable|string|max:255',
            'logo_var_2_btn' => 'nullable|string|max:100',

            // Varian 3
            'logo_var_3_title' => 'nullable|string|max:255',
            'logo_var_3_format' => 'nullable|string|max:255',
            'logo_var_3_tag' => 'nullable|string|max:100',
            'logo_var_3_image' => 'nullable|string|max:500',
            'logo_var_3_file' => 'nullable|string|max:500',
            'logo_var_3_filename' => 'nullable|string|max:255',
            'logo_var_3_btn' => 'nullable|string|max:100',

            // Varian 4
            'logo_var_4_title' => 'nullable|string|max:255',
            'logo_var_4_format' => 'nullable|string|max:255',
            'logo_var_4_tag' => 'nullable|string|max:100',
            'logo_var_4_image' => 'nullable|string|max:500',
            'logo_var_4_file' => 'nullable|string|max:500',
            'logo_var_4_filename' => 'nullable|string|max:255',
            'logo_var_4_btn' => 'nullable|string|max:100',

            'logo_main_file' => 'nullable|file|mimes:png,jpg,jpeg,webp,svg|max:10240',

            // Flexible aliases
            'logo_page_title' => 'nullable|string|max:255',
            'logo_section_title' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo_main_file')) {
            $file = $request->file('logo_main_file');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'logo-ru-master-'.time().'.'.$ext;
            $file->move(public_path('uploads/official/master'), $filename);
            $validated['logo_download_url'] = '/uploads/official/master/'.$filename;
            $validated['logo_preview_image'] = '/uploads/official/master/'.$filename;
        }
        unset($validated['logo_main_file']);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val ?? '', 'official_logo');
        }

        // Keep aliases synced
        if (! empty($validated['logo_hero_title'])) {
            Setting::set('logo_page_title', $validated['logo_hero_title'], 'official_logo');
        } elseif (! empty($validated['logo_page_title'])) {
            Setting::set('logo_hero_title', $validated['logo_page_title'], 'official_logo');
        }

        if (! empty($validated['logo_preview_title'])) {
            Setting::set('logo_section_title', $validated['logo_preview_title'], 'official_logo');
        } elseif (! empty($validated['logo_section_title'])) {
            Setting::set('logo_preview_title', $validated['logo_section_title'], 'official_logo');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'page_update',
            'description' => 'Memperbarui konten dinamis halaman Logo Resmi & Identitas',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.pages.logo')->with('success', 'Konten halaman Logo Resmi & Identitas Visual berhasil diperbarui.');
    }
}
