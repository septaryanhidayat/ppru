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
            'hero_title' => Setting::get('ppdb_hero_title', 'PSB PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA OGAN ILIR'),
            'tagline' => Setting::get('ppdb_tagline', 'Kaderisasi Generasi Khairu Ummah: Beraqidah Lurus, Berakhlak Mulia, Cerdas Sains, Mandiri, dan Berwawasan Global dengan Muadalah Al-Azhar Kairo Mesir.'),
            'hero_bg' => Setting::get('ppdb_hero_bg', '/uploads/campus-ppru-sakatiga.webp'),

            // 4 Stat Counters
            'stat_1_val' => Setting::get('ppdb_stat_1_val', '8 Unit'),
            'stat_1_lbl' => Setting::get('ppdb_stat_1_lbl', 'Jenjang Terpadu'),
            'stat_2_val' => Setting::get('ppdb_stat_2_val', 'Muadalah'),
            'stat_2_lbl' => Setting::get('ppdb_stat_2_lbl', 'Al-Azhar Kairo'),
            'stat_3_val' => Setting::get('ppdb_stat_3_val', '30 Juz'),
            'stat_3_lbl' => Setting::get('ppdb_stat_3_lbl', 'Tahfidz Mutqin'),
            'stat_4_val' => Setting::get('ppdb_stat_4_val', '24 Jam'),
            'stat_4_lbl' => Setting::get('ppdb_stat_4_lbl', 'Pembinaan Asrama'),

            // Flyer / Brosur Resmi
            'flyer_image' => Setting::get('ppdb_flyer_image', '/uploads/popup/popup-ppdb.webp'),
            'flyer_title' => Setting::get('ppdb_flyer_title', 'Brosur & Poster Resmi PSB Online'),
            'flyer_desc' => Setting::get('ppdb_flyer_desc', 'Dapatkan panduan lengkap penerimaan santri baru, profil keunggulan, rincian biaya, serta tata cara pendaftaran santri baru.'),

            // Unit Section Header
            'unit_badge' => Setting::get('ppdb_unit_badge', 'Multi-Unit Pendidikan Terpadu'),
            'unit_title' => Setting::get('ppdb_unit_title', 'PILIH UNIT PENDIDIKAN TUJUAN'),
            'unit_desc' => Setting::get('ppdb_unit_desc', 'Pondok Pesantren Raudhatul Ulum Sakatiga menaungi 8 unit pendidikan resmi yang terstruktur mulai dari Madrasah, TK Islam, Sekolah Islam Terpadu (JSIT), hingga Perguruan Tinggi Islam.'),

            // Alur Section
            'alur_title' => Setting::get('ppdb_alur_title', 'ALUR PENDAFTARAN SANTRI BARU (PSB)'),
            'alur_desc' => Setting::get('ppdb_alur_desc', '5 Tahapan mudah dan transparan pendaftaran santri baru Pondok Pesantren Raudhatul Ulum Sakatiga'),
            'step_1_title' => Setting::get('ppdb_step_1_title', 'Pendaftaran Online'),
            'step_1_desc' => Setting::get('ppdb_step_1_desc', 'Mengisi formulir PSB melalui portal website resmi ini dengan data calon santri dan orang tua secara lengkap.'),
            'step_1_sub' => Setting::get('ppdb_step_1_sub', 'Portal aktif 24 jam'),
            'step_2_title' => Setting::get('ppdb_step_2_title', 'Transfer & Berkas'),
            'step_2_desc' => Setting::get('ppdb_step_2_desc', 'Membayar biaya pendaftaran ke rekening BSI resmi pesantren dan mengunggah bukti transfer serta berkas KK/Akta.'),
            'step_2_sub' => Setting::get('ppdb_step_2_sub', 'Biaya Rp 250.000,- via Bank BSI'),
            'step_3_title' => Setting::get('ppdb_step_3_title', 'Ujian Seleksi & Wawancara'),
            'step_3_desc' => Setting::get('ppdb_step_3_desc', 'Mengikuti tes potensi akademik, tes membaca Al-Qur\'an/tahfidz, dan wawancara kesiapan orang tua serta santri.'),
            'step_3_sub' => Setting::get('ppdb_step_3_sub', 'Jadwal diinfokan via WhatsApp'),
            'step_4_title' => Setting::get('ppdb_step_4_title', 'Pengumuman Kelulusan'),
            'step_4_desc' => Setting::get('ppdb_step_4_desc', 'Mengecek hasil seleksi kelulusan melalui website dan notifikasi resmi WhatsApp panitia PSB.'),
            'step_4_sub' => Setting::get('ppdb_step_4_sub', 'Daftar ulang & fitting seragam'),
            'step_5_title' => Setting::get('ppdb_step_5_title', 'Masuk Asrama (P2SB)'),
            'step_5_desc' => Setting::get('ppdb_step_5_desc', 'Kedatangan santri ke asrama, serah terima dengan Mudir dan pengasuh, serta mengikuti Pekan Perkenalan Santri Baru (P2SB).'),
            'step_5_sub' => Setting::get('ppdb_step_5_sub', 'Khutbatul Arsy & pembagian kamar santri'),
            'alur' => Setting::get('ppdb_alur', "Siapkan berkas foto/scan bukti transfer biaya pendaftaran melalui Bank Syariah Indonesia (BSI) nomor rekening 7011304251 a.n. Pondok Pesantren Raudhatul Ulum.\nSiapkan berkas foto/scan akta kelahiran dan kartu keluarga.\nMengisi formulir PPDB secara online pada website resmi.\nKonfirmasi pengisian formulir kepada panitia melalui WhatsApp (0812-7890-1950).\nPendaftaran selesai dan berkas diverifikasi tim panitia untuk tahapan tes wawancara dan tahfidz."),

            // Jalur Section
            'jalur_title' => Setting::get('ppdb_jalur_title', 'JALUR PENERIMAAN SANTRI BARU'),
            'jalur_desc' => Setting::get('ppdb_jalur_desc', 'Tersedia berbagai pilihan jalur penerimaan sesuai bakat, hafalan Al-Qur\'an, dan prestasi santri'),
            'jalur_reguler_title' => Setting::get('ppdb_jalur_reguler_title', 'Jalur Reguler (Mandiri)'),
            'mandiri' => Setting::get('ppdb_mandiri', "Jalur umum melalui tahapan tes potensi akademik, tes membaca Al-Qur'an (tahsin & tajwid), dan wawancara kesiapan santri & orang tua."),
            'jalur_tahfidz_title' => Setting::get('ppdb_jalur_tahfidz_title', "Jalur Hafizh Al-Qur'an"),
            'tahfidz' => Setting::get('ppdb_tahfidz', "Keringanan biaya dan beasiswa khusus santri penghafal Al-Qur'an minimal 3 Juz s/d 30 Juz mutqin, serta bimbingan sanad Al-Qur'an di MATQULARU."),
            'jalur_prestasi_title' => Setting::get('ppdb_jalur_prestasi_title', 'Jalur Prestasi Sains'),
            'prestasi' => Setting::get('ppdb_prestasi', 'Bebas tes tulis akademik bagi pemenang juara 1, 2, atau 3 lomba sains (KSM/OSN), MTQ/MHQ, pidato, dan olahraga tingkat kota, provinsi, atau nasional.'),
            'jalur_alumni_title' => Setting::get('ppdb_jalur_alumni_title', 'Jalur Alumni Internal'),
            'alumni' => Setting::get('ppdb_alumni', 'Khusus bagi lulusan MTs Raudhatul Ulum dan SMPIT Raudhatul Ulum yang melanjutkan studi ke MARU atau SMAIT RU dengan potongan biaya uang pangkal.'),

            // Rekening & Kontak
            'operational_weekday' => Setting::get('ppdb_operational_weekday', "Senin – Jum'at: Pukul 08.00 – 15.00 WIB"),
            'operational_weekend' => Setting::get('ppdb_operational_weekend', 'Sabtu: Pukul 08.00 – 12.00 WIB'),
            'secretariat' => Setting::get('ppdb_secretariat', 'Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kecamatan Indralaya, Ogan Ilir, Sumatera Selatan'),
            'registration_fee' => Setting::get('ppdb_registration_fee', 'Rp 250.000,-'),
            'bank_name' => Setting::get('ppdb_bank_name', 'Bank Syariah Indonesia (BSI)'),
            'bank_code' => Setting::get('ppdb_bank_code', '451'),
            'bank_account' => Setting::get('ppdb_bank_account', '7011304251'),
            'bank_holder' => Setting::get('ppdb_bank_holder', 'YL. Fatmawati'),
            'hotline_phone' => Setting::get('ppdb_hotline_phone', '0812-7890-1950'),
            'hotline_name' => Setting::get('ppdb_hotline_name', 'Panitia SPMB PPRU'),
            'hotline_2_phone' => Setting::get('ppdb_hotline_2_phone', '0812-7890-1950'),
            'hotline_2_name' => Setting::get('ppdb_hotline_2_name', 'Sekretariat Pesantren'),

            // Video Profil
            'youtube_id' => Setting::get('ppdb_youtube_id', 'LXtIbizPVvE'),
            'video_title' => Setting::get('ppdb_video_title', 'Profil & Suasana Kehidupan Santri Pondok Pesantren Raudhatul Ulum Sakatiga'),
            'video_desc' => Setting::get('ppdb_video_desc', 'Saksikan lingkungan belajar, masjid agung, asrama santri, laboratorium, dan aktivitas harian di Pondok Pesantren Raudhatul Ulum Sakatiga'),
            'video_channel' => Setting::get('ppdb_video_channel', 'Channel Resmi TVRU Sakatiga (@tvrusakatiga)'),

            // FAQ
            'faq_title' => Setting::get('ppdb_faq_title', 'PERTANYAAN SERING DIAJUKAN (FAQ)'),
            'faq_desc' => Setting::get('ppdb_faq_desc', 'Jawaban seputar kehidupan berasrama dan pendaftaran santri baru di PPRU Sakatiga'),
            'faq' => Setting::get('ppdb_faq', "Apakah santri wajib tinggal di asrama (Boarding)? | Untuk jenjang Madrasah Aliyah (MARU), Madrasah Tsanawiyah (MATSARU), SMAIT RU, SMPIT RU, dan MATQULARU, seluruh santri diwajibkan tinggal di asrama (Boarding School) dengan pengawasan 24 jam bersama musyrif/musyrifah asrama. Sedangkan untuk jenjang MI (MIRU) dan TK (TAKIRU) bersifat Full Day School (non-asrama).\nBagaimana aturan kunjungan orang tua dan izin pulang santri? | Kunjungan orang tua dijadwalkan pada hari Ahad sesuai kalender kepesantrenan tanpa mengganggu jadwal belajar santri. Perizinan pulang diberikan pada liburan semester resmi pesantren atau urusan mendesak dengan izin pengasuhan asrama.\nApakah lulusan MARU dan SMAIT dapat melanjutkan ke universitas luar negeri? | Ya, benar. Madrasah Aliyah Raudhatul Ulum (MARU) memiliki piagam muadalah (penyetaraan ijazah) resmi dari Universitas Al-Azhar Kairo Mesir, sehingga alumni dapat langsung mendaftar ke Al-Azhar Kairo dan Universitas Islam Madinah. Selain itu, ijazah nasional Kemenag dan Kemendikbud diakui penuh untuk masuk PTN (SNBP, SNBT, SPAN-PTKIN) di seluruh Indonesia.\nBagaimana program pembinaan tahfidz Al-Qur'an di pesantren? | Setiap santri mendapatkan halaqah tahfidz harian ba'da Subuh dan ba'da Maghrib. Khusus santri unit MATQULARU, pembinaan dilakukan secara intensif dengan target mutqin 30 juz dan sanad."),

            // Pesan Penutup & CTA
            'closing_title' => Setting::get('ppdb_closing_title', 'SIAP MEMULAI LANGKAH MENJADI SANTRI KHOIRU UMMAH?'),
            'closing_desc' => Setting::get('ppdb_closing_desc', 'Jangan lewatkan kesempatan emas bergabung dengan keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga. Kuota kelas terbatas setiap tahunnya.'),
            'closing_btn_text' => Setting::get('ppdb_closing_btn_text', 'Isi Formulir Pendaftaran Sekarang'),
        ];

        // Parse FAQs
        $rawFaq = $settings['faq'] ?? '';
        $faqs = [];
        foreach (explode("\n", (string) $rawFaq) as $line) {
            $line = trim($line);
            if (! empty($line) && str_contains($line, '|')) {
                [$q, $a] = explode('|', $line, 2);
                $faqs[] = [
                    'question' => trim($q),
                    'answer' => trim($a),
                ];
            }
        }

        $unitPendidikans = UnitPendidikan::active()->orderBy('order', 'asc')->get();

        return view('frontend.ppdb.index', compact('settings', 'unitPendidikans', 'faqs'));
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
