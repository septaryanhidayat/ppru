<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PpdbRegistration;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Services\PpdbFormService;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPpdbController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

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
            'bank_holder' => Setting::get('ppdb_bank_holder', 'Pondok Pesantren Raudhatul Ulum'),
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

            // Legacy & accordion fallback
            'syarat' => Setting::get('ppdb_syarat', "Mengisi Formulir Pendaftaran online dengan data yang benar dan lengkap.\nMelampirkan bukti transfer biaya pendaftaran.\nMelampirkan scan/fotokopi Akta Kelahiran dan Kartu Keluarga (KK).\nMelampirkan fotokopi rapor sekolah asal semester 1-5.\nPas foto terbaru calon santri ukuran 3x4 berwarna."),
            'jadwal_gelombang' => Setting::get('ppdb_jadwal_gelombang', "Gelombang 1: Oktober s/d Desember (Diskon Biaya Masuk s/d 50%)\nGelombang 2: Januari s/d April\nGelombang 3: Mei s/d Juli (Khusus sisa kuota)\n* Pendaftaran akan ditutup otomatis apabila kuota per kelas telah terpenuhi."),
            'biaya' => Setting::get('ppdb_biaya', "Biaya Formulir Pendaftaran: Ditransfer ke rekening BSI sekolah 7011304251 a.n. Pondok Pesantren Raudhatul Ulum.\nPaket Seragam Pesantren (4 stel seragam lengkap + atribut dan jilbab/peci).\nBiaya Orientasi Santri (P2SB/Khutbatul Arsy) & Kepesantrenan.\nUntuk rincian lengkap uang pangkal dan SPP asrama bulanan, hubungi langsung panitia SPMB."),
            'boarding' => Setting::get('ppdb_boarding', "Program Boarding (Asrama Santri): Fasilitas asrama representatif, makan 3x sehari, pendampingan ibadah & tahfidz 24 jam bersama musyrif/musyrifah asrama.\nProgram Fullday: Khusus jenjang tertentu sesuai ketentuan pesantren."),
            'kelulusan' => Setting::get('ppdb_kelulusan', 'Hasil seleksi diumumkan melalui website resmi dan notifikasi WhatsApp kepada orang tua calon santri. Calon santri yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang ditentukan panitia.'),

            // PENGATURAN & FLEKSIBILITAS FORMULIR ONLINE
            'form_status' => Setting::get('ppdb_form_status', '1'),
            'form_closed_message' => Setting::get('ppdb_form_closed_message', 'Pendaftaran PPDB online saat ini sedang ditutup sementara atau kuota telah terpenuhi. Silakan hubungi panitia melalui WhatsApp untuk informasi gelombang berikutnya.'),
            'form_announcement' => Setting::get('ppdb_form_announcement', 'Pastikan nomor WhatsApp yang diisi aktif untuk pengiriman kartu peserta ujian dan informasi jadwal seleksi.'),
            'form_wa_confirm' => Setting::get('ppdb_form_wa_confirm', '1'),
            'form_waves' => Setting::get('ppdb_form_waves', "Gelombang 1 (Early Bird)\nGelombang 2 (Reguler)\nGelombang 3 (Prestasi)"),
            'form_tracks' => Setting::get('ppdb_form_tracks', "Jalur Reguler / Tes Mandiri\nJalur Prestasi Akademik & Non-Akademik\nJalur Hafizh Al-Qur'an (Tahfidz)\nJalur Alumni MTs/SMPIT Raudhatul Ulum\nJalur Beasiswa / Afirmasi"),
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
        $unitPendidikans = UnitPendidikan::orderBy('order')->orderBy('id')->get();

        return view('admin.ppdb.content', compact('settings', 'schema', 'sections', 'unitPendidikans'));
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
            'ppdb_hero_title' => 'nullable|string|max:255',
            'ppdb_tagline' => 'nullable|string|max:1000',
            'ppdb_hero_bg' => 'nullable|string|max:500',
            'ppdb_stat_1_val' => 'nullable|string|max:50',
            'ppdb_stat_1_lbl' => 'nullable|string|max:100',
            'ppdb_stat_2_val' => 'nullable|string|max:50',
            'ppdb_stat_2_lbl' => 'nullable|string|max:100',
            'ppdb_stat_3_val' => 'nullable|string|max:50',
            'ppdb_stat_3_lbl' => 'nullable|string|max:100',
            'ppdb_stat_4_val' => 'nullable|string|max:50',
            'ppdb_stat_4_lbl' => 'nullable|string|max:100',

            'ppdb_flyer_title' => 'nullable|string|max:255',
            'ppdb_flyer_desc' => 'nullable|string|max:1000',
            'ppdb_flyer_image' => 'nullable|string|max:500',

            'ppdb_unit_badge' => 'nullable|string|max:100',
            'ppdb_unit_title' => 'nullable|string|max:255',
            'ppdb_unit_desc' => 'nullable|string|max:1000',

            'ppdb_alur_title' => 'nullable|string|max:255',
            'ppdb_alur_desc' => 'nullable|string|max:1000',
            'ppdb_step_1_title' => 'nullable|string|max:100',
            'ppdb_step_1_desc' => 'nullable|string|max:500',
            'ppdb_step_1_sub' => 'nullable|string|max:100',
            'ppdb_step_2_title' => 'nullable|string|max:100',
            'ppdb_step_2_desc' => 'nullable|string|max:500',
            'ppdb_step_2_sub' => 'nullable|string|max:100',
            'ppdb_step_3_title' => 'nullable|string|max:100',
            'ppdb_step_3_desc' => 'nullable|string|max:500',
            'ppdb_step_3_sub' => 'nullable|string|max:100',
            'ppdb_step_4_title' => 'nullable|string|max:100',
            'ppdb_step_4_desc' => 'nullable|string|max:500',
            'ppdb_step_4_sub' => 'nullable|string|max:100',
            'ppdb_step_5_title' => 'nullable|string|max:100',
            'ppdb_step_5_desc' => 'nullable|string|max:500',
            'ppdb_step_5_sub' => 'nullable|string|max:100',
            'ppdb_alur' => 'nullable|string',

            'ppdb_jalur_title' => 'nullable|string|max:255',
            'ppdb_jalur_desc' => 'nullable|string|max:1000',
            'ppdb_jalur_reguler_title' => 'nullable|string|max:100',
            'ppdb_mandiri' => 'nullable|string',
            'ppdb_jalur_tahfidz_title' => 'nullable|string|max:100',
            'ppdb_tahfidz' => 'nullable|string',
            'ppdb_jalur_prestasi_title' => 'nullable|string|max:100',
            'ppdb_prestasi' => 'nullable|string',
            'ppdb_jalur_alumni_title' => 'nullable|string|max:100',
            'ppdb_alumni' => 'nullable|string',

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

            'ppdb_youtube_id' => 'required|string|max:255',
            'ppdb_video_title' => 'nullable|string|max:255',
            'ppdb_video_desc' => 'nullable|string|max:1000',
            'ppdb_video_channel' => 'nullable|string|max:255',

            'ppdb_faq_title' => 'nullable|string|max:255',
            'ppdb_faq_desc' => 'nullable|string|max:1000',
            'ppdb_faq' => 'nullable|string',

            'ppdb_closing_title' => 'nullable|string|max:255',
            'ppdb_closing_desc' => 'nullable|string|max:1000',
            'ppdb_closing_btn_text' => 'nullable|string|max:100',

            'ppdb_syarat' => 'nullable|string',
            'ppdb_jadwal_gelombang' => 'nullable|string',
            'ppdb_biaya' => 'nullable|string',
            'ppdb_boarding' => 'nullable|string',
            'ppdb_kelulusan' => 'nullable|string',

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

        // Handle flyer image file upload
        if ($request->hasFile('ppdb_flyer_file')) {
            $file = $request->file('ppdb_flyer_file');
            if ($file->isValid()) {
                $uploadRes = $this->webpService->processUploadedFile($file, 'ppdb', 85, 1600);
                if ($uploadRes['success']) {
                    $validated['ppdb_flyer_image'] = $uploadRes['url'];
                }
            }
        }

        // Handle hero background file upload
        if ($request->hasFile('ppdb_hero_bg_file')) {
            $file = $request->file('ppdb_hero_bg_file');
            if ($file->isValid()) {
                $uploadRes = $this->webpService->processUploadedFile($file, 'ppdb', 85, 1920);
                if ($uploadRes['success']) {
                    $validated['ppdb_hero_bg'] = $uploadRes['url'];
                }
            }
        }

        // Handle unit photos uploads from PSB content dashboard
        if ($request->hasFile('unit_photos') && is_array($request->file('unit_photos'))) {
            foreach ($request->file('unit_photos') as $unitId => $photoFile) {
                if ($photoFile && $photoFile->isValid()) {
                    $uploadRes = $this->webpService->processUploadedFile($photoFile, 'units', 85, 1200);
                    if ($uploadRes['success']) {
                        $unit = UnitPendidikan::find($unitId);
                        if ($unit) {
                            $unit->update(['thumbnail' => $uploadRes['url']]);
                        }
                    }
                }
            }
        }

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
        $filename = 'Data_Pendaftar_PSB_PPRU_'.date('Ymd_His').'.csv';

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
