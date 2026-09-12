<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PpdbRegistration;
use App\Models\Setting;
use App\Services\PpdbFormService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPpdbController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('previous_school', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $registrations = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'verified' => PpdbRegistration::where('status', 'verified')->count(),
            'accepted' => PpdbRegistration::where('status', 'accepted')->count(),
            'rejected' => PpdbRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.ppdb.index', compact('registrations', 'stats'));
    }

    public function show(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.show', compact('ppdb'));
    }

    public function updateStatus(Request $request, PpdbRegistration $ppdb)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $ppdb->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ppdb_status_update',
            'description' => "Memperbarui status pendaftaran {$ppdb->full_name} ({$ppdb->registration_number}) menjadi {$ppdb->status_label}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', "Status pendaftaran {$ppdb->full_name} berhasil diperbarui.");
    }

    public function destroy(PpdbRegistration $ppdb)
    {
        $name = $ppdb->full_name;

        // Delete uploaded files if any
        if ($ppdb->birth_certificate_path && file_exists(public_path($ppdb->birth_certificate_path))) {
            @unlink(public_path($ppdb->birth_certificate_path));
        }
        if ($ppdb->payment_proof_path && file_exists(public_path($ppdb->payment_proof_path))) {
            @unlink(public_path($ppdb->payment_proof_path));
        }

        $ppdb->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ppdb_delete',
            'description' => "Menghapus berkas pendaftaran calon santri: {$name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.ppdb.index')->with('success', "Data pendaftaran {$name} berhasil dihapus.");
    }

    public function print(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.print', compact('ppdb'));
    }

    /**
     * Display the PPDB Page Content & Dynamic Form Settings view.
     */
    public function content()
    {
        $settings = [
            'status' => Setting::get('ppdb_status', '1'),
            'year' => Setting::get('ppdb_year', '2026/2027'),
            'wave' => Setting::get('ppdb_wave', 'Gelombang 1 (Aktif)'),
            'promo' => Setting::get('ppdb_promo', 'Potongan Biaya Masuk Up to 50% OFF (*S&K berlaku)'),
            'tagline' => Setting::get('ppdb_tagline', "Mendidik Sepenuh Cinta. Mewujudkan generasi Qur'ani berkarakter tangguh, cerdas sains, mandiri, dan berwawasan global di bawah naungan JSIT Indonesia."),
            'youtube_id' => Setting::get('ppdb_youtube_id', 'IrPVG8CYjRc'),
            'video_title' => Setting::get('ppdb_video_title', 'Video Profil & Dokumentasi SMA IT Ishum'),
            'operational_weekday' => Setting::get('ppdb_operational_weekday', "Senin – Jum'at: Pukul 08.00 – 15.00 WIB"),
            'operational_weekend' => Setting::get('ppdb_operational_weekend', 'Sabtu: Pukul 08.00 – 12.00 WIB'),
            'secretariat' => Setting::get('ppdb_secretariat', 'Kompleks SMA IT Ishum, Jl. Sadewa RT 01 RW 04 Karang Raja'),
            'registration_fee' => Setting::get('ppdb_registration_fee', 'Rp 250.000,-'),
            'bank_name' => Setting::get('ppdb_bank_name', 'Bank Syariah Indonesia (BSI)'),
            'bank_code' => Setting::get('ppdb_bank_code', '451'),
            'bank_account' => Setting::get('ppdb_bank_account', '7011304251'),
            'bank_holder' => Setting::get('ppdb_bank_holder', 'YL. Fatmawati'),
            'hotline_phone' => Setting::get('ppdb_hotline_phone', '0821-8268-0647'),
            'hotline_name' => Setting::get('ppdb_hotline_name', 'Admin Hotline PPDB'),
            'hotline_2_phone' => Setting::get('ppdb_hotline_2_phone', '0822-8157-3615'),
            'hotline_2_name' => Setting::get('ppdb_hotline_2_name', 'Ust. Agi (Kepala Sekolah)'),
            'alur' => Setting::get('ppdb_alur', "Siapkan berkas foto/scan bukti transfer biaya pendaftaran melalui Bank Syariah Indonesia (BSI) nomor rekening 7011304251 a.n. YL. Fatmawati.\nSiapkan berkas foto/scan akta kelahiran dan kartu keluarga.\nMengisi formulir PPDB secara online pada website resmi.\nKonfirmasi pengisian formulir kepada panitia melalui WhatsApp (0821-8268-0647).\nPendaftaran selesai dan berkas diverifikasi tim panitia untuk tahapan tes wawancara dan tahfidz."),
            'syarat' => Setting::get('ppdb_syarat', "Mengisi Formulir Pendaftaran online dengan data yang benar dan lengkap.\nMelampirkan bukti transfer biaya pendaftaran.\nMelampirkan scan/fotokopi Akta Kelahiran dan Kartu Keluarga (KK).\nMelampirkan fotokopi rapor SMP/MTs semester 1-5.\nPas foto terbaru calon santri ukuran 3x4 berwarna."),
            'prestasi' => Setting::get('ppdb_prestasi', "Bebas tes tulis akademik bagi Juara 1, 2, atau 3 tingkat Kota/Kabupaten, Provinsi, maupun Nasional.\nDiskon khusus biaya pendaftaran dan prioritas penerimaan."),
            'tahfidz' => Setting::get('ppdb_tahfidz', "Tahfidz minimal 3 Juz: Beasiswa potongan biaya pendaftaran & SPP.\nTahfidz 5 Juz atau lebih: Beasiswa SPP berkala dan pembinaan khusus Sanad/Mutqin.\nMengikuti tes sima'an tahfidz bersama dewan musyrif Al-Qur'an Ishum."),
            'alumni' => Setting::get('ppdb_alumni', 'Keringanan istimewa bagi lulusan SMPIT Ishlahul Ummah Prabumulih yang melanjutkan ke SMA IT Ishlahul Ummah Prabumulih berupa potongan biaya uang pangkal & pendaftaran langsung tanpa biaya seleksi.'),
            'mandiri' => Setting::get('ppdb_mandiri', "Jalur seleksi reguler melalui tahapan:\nTes Potensi Akademik (Matematika, Bahasa Indonesia, PAI).\nTes Kemampuan Membaca Al-Qur'an (Tahsin & Tajwid).\nWawancara Komitmen Orang Tua & Santri."),
            'jadwal_gelombang' => Setting::get('ppdb_jadwal_gelombang', "Gelombang 1: Oktober s/d Desember (Diskon Biaya Masuk s/d 50%)\nGelombang 2: Januari s/d April\nGelombang 3: Mei s/d Juli (Khusus sisa kuota)\n* Pendaftaran akan ditutup otomatis apabila kuota per kelas telah terpenuhi."),
            'biaya' => Setting::get('ppdb_biaya', "Biaya Formulir Pendaftaran: Ditransfer ke rekening BSI sekolah 7011304251.\nPaket Seragam Sekolah (4 stel seragam lengkap + atribut dan jilbab/peci).\nBiaya Orientasi Santri (MPLS) & Baitul Maqdis Leadership Camp.\nUntuk rincian lengkap uang pangkal dan SPP bulanan, hubungi langsung panitia PPDB."),
            'boarding' => Setting::get('ppdb_boarding', "Program Boarding (Asrama): Fasilitas asrama bersih, ber-AC/ventilasi sehat, makan 3x sehari, pendampingan tahfidz 24 jam bersama musyrif.\nProgram Full Day School: Pembelajaran terpadu hingga sore hari, shalat berjamaah, makan siang sehat, dan ekstrakurikuler."),
            'kelulusan' => Setting::get('ppdb_kelulusan', 'Hasil seleksi diumumkan melalui website resmi dan notifikasi WhatsApp kepada orang tua calon santri. Calon santri yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang ditentukan panitia.'),
            'closing_title' => Setting::get('ppdb_closing_title', 'Terima Kasih Sudah Mendaftar di SMA Islam Terpadu Ishlahul Ummah Prabumulih'),
            'closing_desc' => Setting::get('ppdb_closing_desc', 'Semoga Ananda kelak bisa menjadi anak yang cerdas, sholeh/ah, berbakti kepada orang tua dan menjadi kebanggaan bagi agama, bangsa dan negara. Aamiin'),

            // PENGATURAN & FLEKSIBILITAS FORMULIR ONLINE
            'form_status' => Setting::get('ppdb_form_status', '1'),
            'form_closed_message' => Setting::get('ppdb_form_closed_message', 'Pendaftaran PPDB online saat ini sedang ditutup sementara atau kuota telah terpenuhi. Silakan hubungi panitia melalui WhatsApp untuk informasi gelombang berikutnya.'),
            'form_announcement' => Setting::get('ppdb_form_announcement', 'Pastikan nomor WhatsApp yang diisi aktif untuk pengiriman kartu peserta ujian dan informasi jadwal seleksi.'),
            'form_wa_confirm' => Setting::get('ppdb_form_wa_confirm', '1'),
            'form_waves' => Setting::get('ppdb_form_waves', "Gelombang 1 (Early Bird)\nGelombang 2 (Reguler)\nGelombang 3 (Prestasi)"),
            'form_tracks' => Setting::get('ppdb_form_tracks', "Jalur Reguler / Tes Mandiri\nJalur Prestasi Akademik & Non-Akademik\nJalur Hafizh Al-Qur'an (Tahfidz)\nJalur Alumni SMPIT Ishum\nJalur Beasiswa / Afirmasi"),
            'form_programs' => Setting::get('ppdb_form_programs', "Boarding School (Asrama Santri)\nFull Day School (Sekolah Terpadu)"),
            'form_require_payment' => Setting::get('ppdb_form_require_payment', '1'),
            'form_require_birth_cert' => Setting::get('ppdb_form_require_birth_cert', '1'),
            'form_nisn_rule' => Setting::get('ppdb_form_nisn_rule', 'optional'),
            'form_show_achievements' => Setting::get('ppdb_form_show_achievements', '1'),
            'form_show_hobbies' => Setting::get('ppdb_form_show_hobbies', '1'),
            'form_require_parent_income' => Setting::get('ppdb_form_require_parent_income', '1'),
        ];

        $schema = PpdbFormService::getSchema();
        $sections = PpdbFormService::getSections();

        return view('admin.ppdb.content', compact('settings', 'schema', 'sections'));
    }

    /**
     * Update PPDB Page Content & Form Settings.
     */
    public function updateContent(Request $request)
    {
        $validated = $request->validate([
            'ppdb_status' => 'nullable|string',
            'ppdb_year' => 'required|string|max:100',
            'ppdb_wave' => 'nullable|string|max:100',
            'ppdb_promo' => 'nullable|string|max:255',
            'ppdb_tagline' => 'nullable|string|max:1000',
            'ppdb_youtube_id' => 'required|string|max:255',
            'ppdb_video_title' => 'nullable|string|max:255',
            'ppdb_operational_weekday' => 'required|string|max:255',
            'ppdb_operational_weekend' => 'required|string|max:255',
            'ppdb_secretariat' => 'required|string|max:500',
            'ppdb_registration_fee' => 'nullable|string|max:100',
            'ppdb_bank_name' => 'required|string|max:100',
            'ppdb_bank_code' => 'required|string|max:20',
            'ppdb_bank_account' => 'required|string|max:50',
            'ppdb_bank_holder' => 'required|string|max:100',
            'ppdb_hotline_phone' => 'required|string|max:50',
            'ppdb_hotline_name' => 'nullable|string|max:100',
            'ppdb_hotline_2_phone' => 'nullable|string|max:50',
            'ppdb_hotline_2_name' => 'nullable|string|max:100',
            'ppdb_alur' => 'nullable|string',
            'ppdb_syarat' => 'nullable|string',
            'ppdb_prestasi' => 'nullable|string',
            'ppdb_tahfidz' => 'nullable|string',
            'ppdb_alumni' => 'nullable|string',
            'ppdb_mandiri' => 'nullable|string',
            'ppdb_jadwal_gelombang' => 'nullable|string',
            'ppdb_biaya' => 'nullable|string',
            'ppdb_boarding' => 'nullable|string',
            'ppdb_kelulusan' => 'nullable|string',
            'ppdb_closing_title' => 'nullable|string|max:255',
            'ppdb_closing_desc' => 'nullable|string|max:1000',

            // Form settings
            'ppdb_form_status' => 'nullable|string',
            'ppdb_form_closed_message' => 'nullable|string',
            'ppdb_form_announcement' => 'nullable|string',
            'ppdb_form_wa_confirm' => 'nullable|string',
            'ppdb_form_waves' => 'nullable|string',
            'ppdb_form_tracks' => 'nullable|string',
            'ppdb_form_programs' => 'nullable|string',
            'ppdb_form_require_payment' => 'nullable|string',
            'ppdb_form_require_birth_cert' => 'nullable|string',
            'ppdb_form_nisn_rule' => 'nullable|string',
            'ppdb_form_show_achievements' => 'nullable|string',
            'ppdb_form_show_hobbies' => 'nullable|string',
            'ppdb_form_require_parent_income' => 'nullable|string',
        ]);

        // Extract YouTube ID if full URL provided
        $yt = $validated['ppdb_youtube_id'];
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $yt, $matches)) {
            $validated['ppdb_youtube_id'] = $matches[1];
        }

        foreach ($validated as $key => $val) {
            Setting::set($key, $val ?? '', 'ppdb');
        }

        // Handle dynamic fields batch update if submitted
        if ($request->has('fields') && is_array($request->input('fields'))) {
            $currentSchema = PpdbFormService::getSchema();
            $inputFields = $request->input('fields');

            foreach ($currentSchema as &$field) {
                $k = $field['key'];
                if (isset($inputFields[$k])) {
                    $item = $inputFields[$k];
                    $field['label'] = $item['label'] ?? $field['label'];
                    $field['placeholder'] = $item['placeholder'] ?? ($field['placeholder'] ?? '');
                    $field['required'] = ! empty($item['required']);
                    $field['enabled'] = ! empty($item['enabled']);
                    if (isset($item['options'])) {
                        if (is_array($item['options'])) {
                            $field['options'] = $item['options'];
                        } else {
                            $field['options'] = array_values(array_filter(array_map('trim', explode("\n", (string) $item['options']))));
                        }
                    }
                }
            }
            unset($field);
            PpdbFormService::saveSchema($currentSchema);
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'action' => 'ppdb_content_update',
            'description' => 'Memperbarui konten informasi PPDB dan konfigurasi fleksibilitas formulir pendaftaran',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', 'Seluruh pengaturan konten PPDB dan konfigurasi formulir online berhasil disimpan!');
    }

    /**
     * Add a new dynamic field to PPDB online form.
     */
    public function addField(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'type' => 'required|in:text,number,date,select,textarea,tel,file',
            'section' => 'required|in:pilihan,siswa,ayah,ibu,berkas,tambahan',
            'required' => 'nullable',
            'options' => 'nullable|string',
            'placeholder' => 'nullable|string|max:255',
        ]);

        $newField = PpdbFormService::addField($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'action' => 'ppdb_field_add',
            'description' => "Menambahkan kolom isian formulir PPDB baru: {$newField['label']}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.ppdb.content', ['tab' => 'formulir'])->with('success', "Kolom isian '{$newField['label']}' berhasil ditambahkan ke formulir PPDB!");
    }

    /**
     * Delete / remove a dynamic field from PPDB online form.
     */
    public function deleteField(Request $request, string $key)
    {
        $deleted = PpdbFormService::deleteField($key);

        if ($deleted) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name ?? 'Admin',
                'action' => 'ppdb_field_delete',
                'description' => "Menghapus kolom isian formulir PPDB: {$key}",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'info',
            ]);

            return redirect()->route('admin.ppdb.content', ['tab' => 'formulir'])->with('success', 'Kolom isian berhasil dihapus dari struktur formulir PPDB!');
        }

        return redirect()->route('admin.ppdb.content', ['tab' => 'formulir'])->with('error', 'Kolom tidak ditemukan atau gagal dihapus.');
    }

    /**
     * Reset form fields back to default schema.
     */
    public function resetFields(Request $request)
    {
        PpdbFormService::resetToDefault();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name ?? 'Admin',
            'action' => 'ppdb_field_reset',
            'description' => 'Mereset struktur kolom formulir PPDB kembali ke pengaturan standar.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.ppdb.content', ['tab' => 'formulir'])->with('success', 'Struktur kolom formulir PPDB berhasil dikembalikan ke standar awal.');
    }

    /**
     * Export all PPDB registrations to Excel (CSV with UTF-8 BOM).
     */
    public function exportExcel()
    {
        $registrations = PpdbRegistration::latest()->get();
        $filename = 'Data_Pendaftar_PPDB_SMAIT_Ishlahul_Ummah_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // Discover all extra field keys present across registrations
        $extraFieldKeys = [];
        foreach ($registrations as $r) {
            if (! empty($r->extra_fields) && is_array($r->extra_fields)) {
                foreach ($r->extra_fields as $k => $item) {
                    $label = is_array($item) ? ($item['label'] ?? $k) : $k;
                    $extraFieldKeys[$k] = $label;
                }
            }
        }

        $callback = function () use ($registrations, $extraFieldKeys) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            $csvHeaders = [
                'No',
                'No. Registrasi',
                'Tanggal Pendaftaran',
                'Status Berkas',
                'Gelombang',
                'Jalur Pendaftaran',
                'Program Pilihan',
                'Nama Lengkap',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Alamat Domisili',
                'Tinggal Bersama',
                'Anak Ke',
                'Dari Bersaudara',
                'Asal Sekolah',
                'NISN',
                'Hobi',
                'Cita-cita',
                'Prestasi',
                'No. HP / WA Siswa',
                'Nama Ayah / Wali',
                'Pendidikan Ayah',
                'Pekerjaan Ayah',
                'Penghasilan Ayah',
                'No. HP Ayah',
                'Nama Ibu / Wali',
                'Pendidikan Ibu',
                'Pekerjaan Ibu',
                'Penghasilan Ibu',
                'No. HP Ibu',
                'Link Akta Kelahiran',
                'Link Bukti Pembayaran',
            ];

            foreach ($extraFieldKeys as $k => $label) {
                $csvHeaders[] = $label;
            }

            fputcsv($file, $csvHeaders, ';');

            $index = 1;
            foreach ($registrations as $r) {
                $row = [
                    $index++,
                    $r->registration_number,
                    $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-',
                    $r->status_label,
                    $r->wave ?: 'Gelombang 1',
                    $r->track ?: 'Reguler',
                    $r->program_type ?: 'Boarding School',
                    $r->full_name,
                    $r->birth_place,
                    $r->birth_date ? date('d/m/Y', strtotime($r->birth_date)) : '-',
                    $r->gender,
                    $r->address,
                    $r->living_with,
                    $r->child_order,
                    $r->siblings_count,
                    $r->previous_school,
                    $r->nisn ?: '-',
                    $r->hobby ?: '-',
                    $r->ambition ?: '-',
                    $r->achievements ?: '-',
                    $r->phone,
                    $r->father_name,
                    $r->father_education,
                    $r->father_job,
                    $r->father_income,
                    $r->father_phone ?: '-',
                    $r->mother_name,
                    $r->mother_education,
                    $r->mother_job,
                    $r->mother_income,
                    $r->mother_phone ?: '-',
                    $r->birth_certificate_path ? url($r->birth_certificate_path) : '-',
                    $r->payment_proof_path ? url($r->payment_proof_path) : '-',
                ];

                foreach ($extraFieldKeys as $k => $label) {
                    $val = '-';
                    if (! empty($r->extra_fields[$k])) {
                        $item = $r->extra_fields[$k];
                        $val = is_array($item) ? ($item['value'] ?? '-') : $item;
                    }
                    $row[] = $val;
                }

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export / Print all PPDB registrations to PDF format.
     */
    public function exportPdf()
    {
        $registrations = PpdbRegistration::latest()->get();
        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'verified' => PpdbRegistration::where('status', 'verified')->count(),
            'accepted' => PpdbRegistration::where('status', 'accepted')->count(),
            'rejected' => PpdbRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.ppdb.export_pdf', compact('registrations', 'stats'));
    }
}
