<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PpdbRegistration;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Services\PpdbFormService;
use App\Services\WebpService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    /**
     * Display the SPMB / PPDB Info Page.
     */
    public function index()
    {
        $settings = [
            'status' => Setting::get('ppdb_status', '1'),
            'year' => Setting::get('ppdb_year', '2026/2027'),
            'wave' => Setting::get('ppdb_wave', 'Gelombang 1 (Aktif)'),
            'promo' => Setting::get('ppdb_promo', 'Potongan Biaya Masuk Up to 50% OFF (*S&K berlaku)'),
            'tagline' => Setting::get('ppdb_tagline', 'Mendidik Sepenuh Cinta. Membina Generasi Khairu Ummah yang Beraqidah Lurus, Berakhlak Mulia, Cerdas Sains, dan Berwawasan Global dengan Muadalah Al-Azhar Kairo.'),
            'youtube_id' => Setting::get('ppdb_youtube_id', 'LXtIbizPVvE'),
            'video_title' => Setting::get('ppdb_video_title', 'Profil & Suasana Kehidupan Santri Pondok Pesantren Raudhatul Ulum Sakatiga'),
            'operational_weekday' => Setting::get('ppdb_operational_weekday', "Senin – Jum'at: Pukul 08.00 – 15.00 WIB"),
            'operational_weekend' => Setting::get('ppdb_operational_weekend', 'Sabtu: Pukul 08.00 – 12.00 WIB'),
            'secretariat' => Setting::get('ppdb_secretariat', 'Kompleks Sekretariat SPMB Pondok Pesantren Raudhatul Ulum, Sakatiga, Ogan Ilir'),
            'registration_fee' => Setting::get('ppdb_registration_fee', 'Rp 250.000,-'),
            'bank_name' => Setting::get('ppdb_bank_name', 'Bank Syariah Indonesia (BSI)'),
            'bank_code' => Setting::get('ppdb_bank_code', '451'),
            'bank_account' => Setting::get('ppdb_bank_account', '7011304251'),
            'bank_holder' => Setting::get('ppdb_bank_holder', 'YL. Fatmawati'),
            'hotline_phone' => Setting::get('ppdb_hotline_phone', '0812-7890-1950'),
            'hotline_name' => Setting::get('ppdb_hotline_name', 'Panitia SPMB PPRU'),
            'hotline_2_phone' => Setting::get('ppdb_hotline_2_phone', '0812-7890-1950'),
            'hotline_2_name' => Setting::get('ppdb_hotline_2_name', 'Sekretariat Pesantren'),
            'alur' => Setting::get('ppdb_alur', "Siapkan berkas foto/scan bukti transfer biaya pendaftaran melalui Bank Syariah Indonesia (BSI) nomor rekening 7011304251 a.n. YL. Fatmawati.\nSiapkan berkas foto/scan akta kelahiran dan kartu keluarga.\nMengisi formulir PPDB secara online pada website resmi.\nKonfirmasi pengisian formulir kepada panitia melalui WhatsApp (0812-7890-1950).\nPendaftaran selesai dan berkas diverifikasi tim panitia untuk tahapan tes wawancara dan tahfidz."),
            'syarat' => Setting::get('ppdb_syarat', "Mengisi Formulir Pendaftaran online dengan data yang benar dan lengkap.\nMelampirkan bukti transfer biaya pendaftaran.\nMelampirkan scan/fotokopi Akta Kelahiran dan Kartu Keluarga (KK).\nMelampirkan fotokopi rapor sekolah/madrasah asal semester 1-5.\nPas foto terbaru calon santri ukuran 3x4 berwarna."),
            'prestasi' => Setting::get('ppdb_prestasi', "Bebas tes tulis akademik bagi Juara 1, 2, atau 3 tingkat Kota/Kabupaten, Provinsi, maupun Nasional.\nDiskon khusus biaya pendaftaran dan prioritas penerimaan."),
            'tahfidz' => Setting::get('ppdb_tahfidz', "Tahfidz minimal 3 Juz: Beasiswa potongan biaya pendaftaran & SPP.\nTahfidz 10 Juz atau lebih: Beasiswa SPP berkala dan pembinaan khusus Sanad/Mutqin di MATQULARU.\nMengikuti tes sima'an tahfidz bersama dewan musyrif Al-Qur'an PPRU Sakatiga."),
            'alumni' => Setting::get('ppdb_alumni', 'Keringanan istimewa bagi lulusan MTs / SMPIT Raudhatul Ulum yang melanjutkan ke MA / SMAIT Raudhatul Ulum Sakatiga berupa potongan biaya uang pangkal & pendaftaran prioritas.'),
            'mandiri' => Setting::get('ppdb_mandiri', "Jalur seleksi reguler melalui tahapan:\nTes Potensi Akademik (Matematika, Bahasa Indonesia, PAI).\nTes Kemampuan Membaca Al-Qur'an (Tahsin & Tajwid).\nWawancara Komitmen Orang Tua & Santri."),
            'jadwal_gelombang' => Setting::get('ppdb_jadwal_gelombang', "Gelombang 1: Oktober s/d Desember (Diskon Biaya Masuk s/d 50%)\nGelombang 2: Januari s/d April\nGelombang 3: Mei s/d Juli (Khusus sisa kuota)\n* Pendaftaran akan ditutup otomatis apabila kuota per kelas telah terpenuhi."),
            'biaya' => Setting::get('ppdb_biaya', "Biaya Formulir Pendaftaran: Ditransfer ke rekening BSI sekolah 7011304251 a.n. YL. Fatmawati.\nPaket Seragam Pesantren (4 stel seragam lengkap + atribut dan jilbab/peci).\nBiaya Orientasi Santri (Khutbatul Arsy) & Kepesantrenan.\nUntuk rincian lengkap uang pangkal dan SPP asrama bulanan, hubungi langsung panitia SPMB."),
            'boarding' => Setting::get('ppdb_boarding', "Program Boarding (Asrama Santri): Fasilitas asrama representatif, makan 3x sehari, pendampingan ibadah & tahfidz 24 jam bersama musyrif/musyrifah asrama.\nProgram Fullday: Khusus jenjang tertentu sesuai ketentuan pesantren."),
            'kelulusan' => Setting::get('ppdb_kelulusan', 'Hasil seleksi diumumkan melalui website resmi dan notifikasi WhatsApp kepada orang tua calon santri. Calon santri yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang ditentukan panitia.'),
            'closing_title' => Setting::get('ppdb_closing_title', 'Terima Kasih Sudah Mendaftar di Pondok Pesantren Raudhatul Ulum Sakatiga'),
            'closing_desc' => Setting::get('ppdb_closing_desc', 'Semoga Ananda kelak bisa menjadi santri berilmu, beramal, berakhlak mulia, dan berbakti kepada orang tua serta umat. Aamiin'),
        ];

        $unitPendidikans = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.ppdb.index', compact('settings', 'unitPendidikans'));
    }

    /**
     * Display the PPDB Registration Form.
     */
    public function form()
    {
        $rawWaves = Setting::get('ppdb_form_waves', "Gelombang 1 (Early Bird)\nGelombang 2 (Reguler)\nGelombang 3 (Prestasi)");
        $rawTracks = Setting::get('ppdb_form_tracks', "Jalur Reguler / Tes Mandiri\nJalur Prestasi Akademik & Non-Akademik\nJalur Hafizh Al-Qur'an (Tahfidz)\nJalur Alumni MTs/SMPIT Raudhatul Ulum\nJalur Beasiswa / Afirmasi");
        $rawPrograms = Setting::get('ppdb_form_programs', "Boarding School (Asrama Santri)\nFull Day School (Sekolah Terpadu)");

        $waves = array_values(array_filter(array_map('trim', explode("\n", (string) $rawWaves))));
        $tracks = array_values(array_filter(array_map('trim', explode("\n", (string) $rawTracks))));
        $programs = array_values(array_filter(array_map('trim', explode("\n", (string) $rawPrograms))));

        $formSettings = [
            'status' => Setting::get('ppdb_form_status', '1'),
            'year' => Setting::get('ppdb_year', '2026/2027'),
            'closed_message' => Setting::get('ppdb_form_closed_message', 'Pendaftaran PPDB online saat ini sedang ditutup sementara atau kuota telah terpenuhi. Silakan hubungi panitia melalui WhatsApp untuk informasi gelombang berikutnya.'),
            'announcement' => Setting::get('ppdb_form_announcement', 'Pastikan nomor WhatsApp yang diisi aktif untuk pengiriman kartu peserta ujian dan informasi jadwal seleksi.'),
            'waves' => $waves,
            'tracks' => $tracks,
            'programs' => $programs,
            'require_payment' => Setting::get('ppdb_form_require_payment', '1') === '1',
            'require_birth_cert' => Setting::get('ppdb_form_require_birth_cert', '1') === '1',
            'nisn_rule' => Setting::get('ppdb_form_nisn_rule', 'optional'),
            'show_achievements' => Setting::get('ppdb_form_show_achievements', '1') === '1',
            'show_hobbies' => Setting::get('ppdb_form_show_hobbies', '1') === '1',
            'require_parent_income' => Setting::get('ppdb_form_require_parent_income', '1') === '1',
            'wa_confirm' => Setting::get('ppdb_form_wa_confirm', '1') === '1',
            'bank_name' => Setting::get('ppdb_bank_name', 'Bank Syariah Indonesia (BSI)'),
            'bank_code' => Setting::get('ppdb_bank_code', '451'),
            'bank_account' => Setting::get('ppdb_bank_account', '7011304251'),
            'bank_holder' => Setting::get('ppdb_bank_holder', 'YL. Fatmawati'),
            'registration_fee' => Setting::get('ppdb_registration_fee', 'Rp 250.000,-'),
            'hotline_phone' => Setting::get('ppdb_hotline_phone', '0812-7890-1950'),
        ];

        $groupedFields = PpdbFormService::getActiveFieldsGrouped();
        $sections = PpdbFormService::getSections();
        $unitPendidikans = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.ppdb.form', compact('formSettings', 'groupedFields', 'sections', 'unitPendidikans'));
    }

    /**
     * Store a new PPDB Registration from online form submission.
     */
    public function store(Request $request)
    {
        $formStatus = Setting::get('ppdb_form_status', '1');
        if ($formStatus === '0') {
            return back()->with('error', Setting::get('ppdb_form_closed_message', 'Pendaftaran PPDB online saat ini sedang ditutup.'));
        }

        $activeFields = PpdbFormService::getActiveFields();
        $rules = [];
        $customAttributes = [];

        // Known standard column keys in ppdb_registrations table
        $standardKeys = [
            'wave', 'track', 'program_type',
            'full_name', 'birth_place', 'birth_date', 'gender', 'address', 'living_with',
            'child_order', 'siblings_count', 'previous_school', 'nisn', 'hobby', 'favorite_subject',
            'ambition', 'achievements', 'phone',
            'father_name', 'father_birth_place', 'father_birth_date', 'father_address',
            'father_education', 'father_job', 'father_income', 'father_phone',
            'mother_name', 'mother_birth_place', 'mother_birth_date', 'mother_address',
            'mother_education', 'mother_job', 'mother_income', 'mother_phone',
            'birth_certificate', 'payment_proof',
        ];

        foreach ($activeFields as $field) {
            $key = $field['key'];
            $req = ! empty($field['required']) ? 'required' : 'nullable';
            $type = $field['type'] ?? 'text';
            $customAttributes[$key] = $field['label'] ?? $key;

            switch ($type) {
                case 'file':
                    $rules[$key] = "{$req}|file|mimes:jpeg,png,jpg,webp,pdf|max:5120";
                    break;
                case 'number':
                    $rules[$key] = "{$req}|numeric";
                    break;
                case 'date':
                    $rules[$key] = "{$req}|date";
                    break;
                case 'select':
                    $rules[$key] = "{$req}|string|max:255";
                    break;
                case 'textarea':
                    $rules[$key] = "{$req}|string|max:2000";
                    break;
                case 'tel':
                    $rules[$key] = "{$req}|string|max:50";
                    break;
                default: // text
                    $rules[$key] = "{$req}|string|max:255";
                    break;
            }
        }

        $validated = $request->validate($rules, [], $customAttributes);

        // Process Standard Birth Certificate File
        $birthCertPath = null;
        if ($request->hasFile('birth_certificate')) {
            $file = $request->file('birth_certificate');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'pdf') {
                $filename = 'akta_'.time().'_'.uniqid().'.pdf';
                $file->move(public_path('uploads/ppdb/akta'), $filename);
                $birthCertPath = '/uploads/ppdb/akta/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'ppdb/akta', 82, 1600);
                $birthCertPath = $converted['success'] ? $converted['url'] : null;
            }
        }

        // Process Standard Payment Proof File
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext === 'pdf') {
                $filename = 'bukti_bayar_'.time().'_'.uniqid().'.pdf';
                $file->move(public_path('uploads/ppdb/bukti'), $filename);
                $paymentProofPath = '/uploads/ppdb/bukti/'.$filename;
            } else {
                $converted = $this->webpService->processUploadedFile($file, 'ppdb/bukti', 82, 1600);
                $paymentProofPath = $converted['success'] ? $converted['url'] : null;
            }
        }

        // Collect extra fields (custom fields added dynamically)
        $extraFields = [];
        foreach ($activeFields as $field) {
            $key = $field['key'];
            if (! in_array($key, $standardKeys, true)) {
                if ($field['type'] === 'file') {
                    if ($request->hasFile($key)) {
                        $file = $request->file($key);
                        $ext = strtolower($file->getClientOriginalExtension());
                        if ($ext === 'pdf') {
                            $filename = $key.'_'.time().'_'.uniqid().'.pdf';
                            $file->move(public_path('uploads/ppdb/extra'), $filename);
                            $filePath = '/uploads/ppdb/extra/'.$filename;
                        } else {
                            $converted = $this->webpService->processUploadedFile($file, 'ppdb/extra', 82, 1600);
                            $filePath = $converted['success'] ? $converted['url'] : null;
                        }
                        $extraFields[$key] = [
                            'label' => $field['label'],
                            'value' => $filePath,
                            'type' => 'file',
                        ];
                    }
                } else {
                    $extraFields[$key] = [
                        'label' => $field['label'],
                        'value' => $validated[$key] ?? null,
                        'type' => $field['type'],
                    ];
                }
            }
        }

        $regNumber = PpdbRegistration::generateRegistrationNumber();
        $academicYear = Setting::get('ppdb_year', '2026/2027');

        // Safe registration attributes with defaults for non-nullable columns
        $registration = PpdbRegistration::create([
            'registration_number' => $regNumber,
            'wave' => $validated['wave'] ?? Setting::get('ppdb_wave', 'Gelombang 1'),
            'track' => $validated['track'] ?? 'Reguler',
            'program_type' => $validated['program_type'] ?? 'Boarding School',
            'full_name' => $validated['full_name'] ?? 'Calon Santri',
            'birth_place' => $validated['birth_place'] ?? '-',
            'birth_date' => $validated['birth_date'] ?? '2008-01-01',
            'gender' => $validated['gender'] ?? 'Laki-laki',
            'address' => $validated['address'] ?? '-',
            'living_with' => $validated['living_with'] ?? 'Orang Tua',
            'child_order' => isset($validated['child_order']) ? (int) $validated['child_order'] : 1,
            'siblings_count' => isset($validated['siblings_count']) ? (int) $validated['siblings_count'] : 1,
            'previous_school' => $validated['previous_school'] ?? '-',
            'nisn' => $validated['nisn'] ?? null,
            'hobby' => $validated['hobby'] ?? '-',
            'favorite_subject' => $validated['favorite_subject'] ?? null,
            'ambition' => $validated['ambition'] ?? '-',
            'achievements' => $validated['achievements'] ?? null,
            'phone' => $validated['phone'] ?? '-',

            'father_name' => $validated['father_name'] ?? '-',
            'father_birth_place' => $validated['father_birth_place'] ?? null,
            'father_birth_date' => $validated['father_birth_date'] ?? null,
            'father_address' => $validated['father_address'] ?? null,
            'father_education' => $validated['father_education'] ?? null,
            'father_job' => $validated['father_job'] ?? null,
            'father_income' => $validated['father_income'] ?? null,
            'father_phone' => $validated['father_phone'] ?? null,

            'mother_name' => $validated['mother_name'] ?? '-',
            'mother_birth_place' => $validated['mother_birth_place'] ?? null,
            'mother_birth_date' => $validated['mother_birth_date'] ?? null,
            'mother_address' => $validated['mother_address'] ?? null,
            'mother_education' => $validated['mother_education'] ?? null,
            'mother_job' => $validated['mother_job'] ?? null,
            'mother_income' => $validated['mother_income'] ?? null,
            'mother_phone' => $validated['mother_phone'] ?? null,

            'birth_certificate_path' => $birthCertPath,
            'payment_proof_path' => $paymentProofPath,
            'extra_fields' => ! empty($extraFields) ? $extraFields : null,
            'status' => 'pending',
            'academic_year' => $academicYear,
        ]);

        ActivityLog::create([
            'user_id' => null,
            'user_name' => 'Calon Santri: '.$registration->full_name,
            'action' => 'ppdb_registration',
            'description' => "Pendaftaran PPDB Baru: {$registration->full_name} ({$registration->registration_number}) - {$registration->track} / {$registration->program_type}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('ppdb.success', ['reg' => $registration->registration_number])
            ->with('ppdb_success', [
                'name' => $registration->full_name,
                'reg_number' => $registration->registration_number,
                'phone' => $registration->phone,
            ]);
    }

    /**
     * Display registration success page.
     */
    public function success(Request $request)
    {
        $regNumber = $request->query('reg');
        $regId = session('ppdb_registered_id');

        $registration = null;
        if ($regNumber) {
            $registration = PpdbRegistration::where('registration_number', $regNumber)->first();
        } elseif ($regId) {
            $registration = PpdbRegistration::find($regId);
        }

        if (! $registration) {
            abort(404, 'Data pendaftaran tidak ditemukan.');
        }

        $waUrl = $this->buildWhatsAppUrl($registration);

        return view('frontend.ppdb.success', compact('registration', 'waUrl'));
    }

    /**
     * Build comprehensive WhatsApp forward URL containing all form data.
     */
    public function buildWhatsAppUrl(PpdbRegistration $registration): string
    {
        $adminPhone = Setting::get('ppdb_hotline_phone', Setting::get('contact_whatsapp', Setting::get('contact_phone', '081278901950')));
        $cleanPhone = preg_replace('/[^0-9]/', '', (string) $adminPhone);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62'.substr($cleanPhone, 1);
        }
        if (empty($cleanPhone)) {
            $cleanPhone = '6281278901950';
        }

        $text = "*FORMULIR PENDAFTARAN SANTRI BARU (PSB)*\n";
        $text .= "*PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA*\n";
        $text .= "----------------------------------------\n";
        $text .= '📋 *No. Registrasi:* '.$registration->registration_number."\n";
        $text .= '📅 *Tanggal Daftar:* '.$registration->created_at->translatedFormat('d F Y, H:i')." WIB\n";
        $text .= '🌊 *Gelombang:* '.($registration->wave ?: 'Gelombang 1')."\n";
        $text .= '🎯 *Jalur Pendaftaran:* '.($registration->track ?: 'Reguler')."\n";
        $text .= '🏫 *Program Pilihan:* '.($registration->program_type ?: 'Boarding School')."\n\n";

        $text .= "👤 *1. DATA CALON SISWA*\n";
        $text .= '• *Nama Lengkap:* '.$registration->full_name."\n";
        $birthDateStr = $registration->birth_date ? Carbon::parse($registration->birth_date)->translatedFormat('d F Y') : '-';
        $text .= '• *Tempat, Tgl Lahir:* '.$registration->birth_place.', '.$birthDateStr."\n";
        $text .= '• *Jenis Kelamin:* '.$registration->gender."\n";
        $text .= '• *Alamat Lengkap:* '.$registration->address."\n";
        $text .= '• *Tinggal Bersama:* '.$registration->living_with."\n";
        $text .= '• *Anak Ke:* '.$registration->child_order.' dari '.$registration->siblings_count." bersaudara\n";
        $text .= '• *Asal Sekolah:* '.$registration->previous_school."\n";
        $text .= '• *NISN:* '.($registration->nisn ?: '-')."\n";
        $text .= '• *Hobi:* '.$registration->hobby."\n";
        $text .= '• *Bidang Disukai:* '.($registration->favorite_subject ?: '-')."\n";
        $text .= '• *Cita-cita:* '.$registration->ambition."\n";
        $text .= '• *Prestasi:* '.($registration->achievements ?: '-')."\n";
        $text .= '• *No. HP/WA Siswa:* '.$registration->phone."\n\n";

        $text .= "👨 *2. DATA AYAH / WALI*\n";
        $text .= '• *Nama Ayah:* '.$registration->father_name."\n";
        $fatherBirthDateStr = $registration->father_birth_date ? Carbon::parse($registration->father_birth_date)->translatedFormat('d F Y') : '-';
        $text .= '• *TTL Ayah:* '.$registration->father_birth_place.', '.$fatherBirthDateStr."\n";
        $text .= '• *Alamat Ayah:* '.$registration->father_address."\n";
        $text .= '• *Pendidikan Terakhir:* '.$registration->father_education."\n";
        $text .= '• *Pekerjaan:* '.$registration->father_job."\n";
        $text .= '• *Penghasilan:* '.$registration->father_income."\n";
        $text .= '• *No. HP/WA Ayah:* '.($registration->father_phone ?: '-')."\n\n";

        $text .= "👩 *3. DATA IBU / WALI*\n";
        $text .= '• *Nama Ibu:* '.$registration->mother_name."\n";
        $motherBirthDateStr = $registration->mother_birth_date ? Carbon::parse($registration->mother_birth_date)->translatedFormat('d F Y') : '-';
        $text .= '• *TTL Ibu:* '.$registration->mother_birth_place.', '.$motherBirthDateStr."\n";
        $text .= '• *Alamat Ibu:* '.$registration->mother_address."\n";
        $text .= '• *Pendidikan Terakhir:* '.$registration->mother_education."\n";
        $text .= '• *Pekerjaan:* '.$registration->mother_job."\n";
        $text .= '• *Penghasilan:* '.$registration->mother_income."\n";
        $text .= '• *No. HP/WA Ibu:* '.($registration->mother_phone ?: '-')."\n\n";

        $text .= "📎 *4. BERKAS TERUNGGAH*\n";
        $text .= '• *Scan Akta Kelahiran:* '.($registration->birth_certificate_path ? url($registration->birth_certificate_path) : 'Tersimpan di sistem')."\n";
        $text .= '• *Bukti Pembayaran:* '.($registration->payment_proof_path ? url($registration->payment_proof_path) : 'Tersimpan di sistem')."\n\n";

        if (! empty($registration->extra_fields) && is_array($registration->extra_fields)) {
            $text .= "📝 *5. DATA TAMBAHAN LAINNYA*\n";
            foreach ($registration->extra_fields as $key => $item) {
                $lbl = is_array($item) ? ($item['label'] ?? ucfirst(str_replace('_', ' ', $key))) : ucfirst(str_replace('_', ' ', $key));
                $val = is_array($item) ? ($item['value'] ?? '-') : $item;
                $fType = is_array($item) ? ($item['type'] ?? 'text') : 'text';
                if ($fType === 'file' && $val && $val !== '-') {
                    $text .= "• *{$lbl}:* ".url($val)."\n";
                } else {
                    $text .= "• *{$lbl}:* ".($val ?: '-')."\n";
                }
            }
            $text .= "\n";
        }

        $text .= "Mohon untuk memverifikasi pendaftaran calon santri baru kami. Terima kasih.\nWassalamu'alaikum Wr. Wb.";

        return 'https://api.whatsapp.com/send?phone='.$cleanPhone.'&text='.rawurlencode($text);
    }
}
