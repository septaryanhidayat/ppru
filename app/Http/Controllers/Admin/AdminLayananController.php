<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InformationController;
use App\Models\ActivityLog;
use App\Models\ServiceSubmission;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLayananController extends Controller
{
    /**
     * Display list of service submissions with filtering & search
     */
    public function index(Request $request)
    {
        $query = ServiceSubmission::query()->latest();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('service_type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('agency', 'like', "%{$s}%")
                    ->orWhere('whatsapp', 'like', "%{$s}%")
                    ->orWhere('purpose', 'like', "%{$s}%");
            });
        }

        $submissions = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => ServiceSubmission::count(),
            'pending' => ServiceSubmission::where('status', 'pending')->count(),
            'approved' => ServiceSubmission::where('status', 'approved')->count(),
            'completed' => ServiceSubmission::where('status', 'completed')->count(),
            'izin' => ServiceSubmission::where('service_type', 'izin_kunjungan')->count(),
            'kerjasama' => ServiceSubmission::where('service_type', 'kerja_sama')->count(),
            'sewa' => ServiceSubmission::where('service_type', 'sewa_barang')->count(),
        ];

        return view('admin.layanan.index', compact('submissions', 'stats'));
    }

    /**
     * Show single submission detail
     */
    public function show(ServiceSubmission $submission)
    {
        return view('admin.layanan.show', compact('submission'));
    }

    /**
     * Update submission status and administrative notes
     */
    public function updateStatus(Request $request, ServiceSubmission $submission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $submission->status;
        $submission->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'layanan_status_update',
            'description' => "Memperbarui status permohonan #{$submission->id} ({$submission->name}) dari {$oldStatus} ke {$validated['status']}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', "Status permohonan #{$submission->id} berhasil diperbarui menjadi: {$submission->status_label}.");
    }

    /**
     * Delete submission and cleanup uploaded files
     */
    public function destroy(Request $request, ServiceSubmission $submission)
    {
        $applicantName = $submission->name;
        $id = $submission->id;

        // Cleanup files safely
        foreach ([$submission->letter_path, $submission->ktp_path, $submission->npwp_path] as $path) {
            if ($path) {
                $cleanPath = ltrim($path, '/');
                $fullPath = public_path($cleanPath);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
        }

        $submission->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'layanan_delete',
            'description' => "Menghapus permohonan layanan #{$id} dari {$applicantName}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.layanan.index')->with('success', "Permohonan #{$id} dari '{$applicantName}' berhasil dihapus.");
    }

    /**
     * Show editor for accordions & terms content
     */
    public function content()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $storedIzin = json_decode(Setting::get('layanan_izin_accordions', '[]'), true) ?: [];
        $izinAccordions = ! empty($storedIzin) ? $storedIzin : InformationController::getDefaultAccordions('izin');

        $storedKerjasama = json_decode(Setting::get('layanan_kerjasama_accordions', '[]'), true) ?: [];
        $kerjasamaAccordions = ! empty($storedKerjasama) ? $storedKerjasama : InformationController::getDefaultAccordions('kerjasama');

        $storedSewa = json_decode(Setting::get('layanan_sewa_accordions', '[]'), true) ?: [];
        $sewaAccordions = ! empty($storedSewa) ? $storedSewa : InformationController::getDefaultAccordions('sewa');

        return view('admin.layanan.content', compact('settings', 'izinAccordions', 'kerjasamaAccordions', 'sewaAccordions'));
    }

    /**
     * Save updated accordions & terms content or portal cards
     */
    public function updateContent(Request $request)
    {
        $type = $request->input('service_type');

        if ($type === 'portal') {
            $allowedLayananKeys = [
                'layanan_portal_hero_badge',
                'layanan_portal_hero_title',
                'layanan_portal_hero_desc',
                'layanan_section_badge',
                'layanan_section_title',
                'layanan_section_desc',
                'layanan_card_1_badge',
                'layanan_card_1_title',
                'layanan_card_1_desc',
                'layanan_card_1_benefits',
                'layanan_card_1_btn_text',
                'layanan_card_2_badge',
                'layanan_card_2_title',
                'layanan_card_2_desc',
                'layanan_card_2_benefits',
                'layanan_card_2_btn_text',
                'layanan_card_3_badge',
                'layanan_card_3_title',
                'layanan_card_3_desc',
                'layanan_card_3_benefits',
                'layanan_card_3_btn_text',
                'layanan_ptsp_hours',
                'layanan_ptsp_wa',
                'layanan_ptsp_email',
                'layanan_ptsp_note',
                'ptsp_page_title',
                'ptsp_hero_subtitle',
                'ptsp_section_tag',
                'ptsp_section_title',
                'ptsp_section_desc',
                'ptsp_card1_tag',
                'ptsp_card1_title',
                'ptsp_card1_desc',
                'ptsp_card1_point1',
                'ptsp_card1_point2',
                'ptsp_card1_point3',
                'ptsp_card1_btn',
                'ptsp_card2_tag',
                'ptsp_card2_title',
                'ptsp_card2_desc',
                'ptsp_card2_point1',
                'ptsp_card2_point2',
                'ptsp_card2_point3',
                'ptsp_card2_btn',
                'ptsp_card3_tag',
                'ptsp_card3_title',
                'ptsp_card3_desc',
                'ptsp_card3_point1',
                'ptsp_card3_point2',
                'ptsp_card3_point3',
                'ptsp_card3_btn',
                'ptsp_helpdesk_tag',
                'ptsp_helpdesk_title',
                'ptsp_helpdesk_desc',
                'ptsp_helpdesk_phone',
                'ptsp_helpdesk_btn_text',
                'ptsp_helpdesk_wa_template',
            ];

            $portalData = $request->only($allowedLayananKeys);

            foreach ($portalData as $field => $val) {
                Setting::set($field, $val ?? '', 'layanan');
            }

            // Sync aliases between portal and ptsp keys
            if ($request->filled('layanan_portal_hero_title')) {
                Setting::set('ptsp_page_title', $request->input('layanan_portal_hero_title'), 'layanan');
            } elseif ($request->filled('ptsp_page_title')) {
                Setting::set('layanan_portal_hero_title', $request->input('ptsp_page_title'), 'layanan');
            }

            if ($request->filled('layanan_card_1_title')) {
                Setting::set('ptsp_card1_title', $request->input('layanan_card_1_title'), 'layanan');
            } elseif ($request->filled('ptsp_card1_title')) {
                Setting::set('layanan_card_1_title', $request->input('ptsp_card1_title'), 'layanan');
            }

            if ($request->filled('layanan_card_1_btn_text')) {
                Setting::set('ptsp_card1_btn', $request->input('layanan_card_1_btn_text'), 'layanan');
            } elseif ($request->filled('ptsp_card1_btn')) {
                Setting::set('layanan_card_1_btn_text', $request->input('ptsp_card1_btn'), 'layanan');
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'action' => 'layanan_content_update',
                'description' => 'Memperbarui informasi kartu & portal utama Layanan Terpadu',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'info',
            ]);

            return redirect()->route('admin.layanan.content', ['tab' => 'portal'])->with('success', 'Pengaturan portal utama Layanan Terpadu berhasil diperbarui.');
        }

        if (! in_array($type, ['izin', 'kerjasama', 'sewa'], true)) {
            return back()->with('error', 'Jenis layanan tidak valid.');
        }

        $titles = $request->input('titles', []);
        $contents = $request->input('contents', []);

        $accordions = [];
        foreach ($titles as $idx => $title) {
            $t = trim($title);
            $c = trim($contents[$idx] ?? '');
            if ($t !== '') {
                $accordions[] = [
                    'title' => $t,
                    'content' => $c,
                ];
            }
        }

        $key = match ($type) {
            'izin' => 'layanan_izin_accordions',
            'kerjasama' => 'layanan_kerjasama_accordions',
            'sewa' => 'layanan_sewa_accordions',
        };

        Setting::set($key, json_encode($accordions), 'layanan');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'layanan_content_update',
            'description' => "Memperbarui pengaturan konten & persyaratan layanan: {$type}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Persyaratan & ketentuan layanan berhasil diperbarui!');
    }
}
