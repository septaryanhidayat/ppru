@extends('layouts.admin')

@section('title', 'Kelola Konten Dinamis Halaman Donasi & Infaq')
@section('header_title', 'Kelola Halaman Donasi & Infaq')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    {{-- TOP NAVIGATION & STATUS BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <div class="flex items-center space-x-3 text-xs">
            <span class="text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/donasi</code></span>
            <a href="{{ route('donasi') }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold px-3.5 py-1.5 rounded-xl border border-emerald-200 transition shadow-xs" title="Buka Halaman Donasi di Web Publik">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>Lihat di Web Publik</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.pages.donasi.update') }}" method="POST" class="space-y-6">
        @csrf

        {{-- CARD 1: HEADER & NARASI HERO DONASI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Header &amp; Narasi Utama Donasi</h3>
                    <p class="text-xs text-slate-500">Sesuaikan judul, badge, dan pengantar infaq di bagian atas halaman.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header</label>
                    <input type="text" name="donation_hero_badge" value="{{ $settings['donation_hero_badge'] ?? 'Infaq & Shadaqah Jariyah' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Hero</label>
                    <input type="text" name="donation_hero_title" value="{{ $settings['donation_hero_title'] ?? 'Infaq Pembangunan & Beasiswa PPRU' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hero</label>
                    <textarea name="donation_hero_desc" rows="3" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['donation_hero_desc'] ?? 'Mari bergotong royong membangun sarana laboratorium riset modern, masjid pondok, fasilitas asrama tahfidz, dan program beasiswa bagi santri berprestasi di Pondok Pesantren Raudhatul Ulum Sakatiga.' }}</textarea>
                </div>
            </div>

            {{-- KUTIPAN AYAT / HADITS --}}
            <div class="pt-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Kutipan Inspiratif (Ayat / Hadits)</label>
                    <textarea name="donation_quote_text" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['donation_quote_text'] ?? '"Perumpamaan orang-orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan sebutir benih yang menumbuhkan tujuh bulir, pada tiap-tiap bulir seratus biji. Allah melipatgandakan bagi siapa yang Dia kehendaki."' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sumber / Surah</label>
                    <input type="text" name="donation_quote_source" value="{{ $settings['donation_quote_source'] ?? '(QS. Al-Baqarah: 261)' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>
        </div>

        {{-- CARD 2: REKENING PERBANKAN RESMI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Rekening Bank Resmi Penyaluran Infaq</h3>
                    <p class="text-xs text-slate-500">Nomor rekening, kode bank transfer, atas nama pemilik, dan teks tombol salin.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Seksi Rekening</label>
                    <input type="text" name="donation_section_badge" value="{{ $settings['donation_section_badge'] ?? 'Rekening Resmi Sekolah' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Rekening</label>
                    <input type="text" name="donation_section_title" value="{{ $settings['donation_section_title'] ?? 'Penyaluran Infaq & Wakaf Pendidikan' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            {{-- BANK 1 --}}
            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase text-[#00843d] flex items-center gap-1.5">
                        <i class="fa-solid fa-building-columns"></i> Rekening Bank 1 (Utama)
                    </span>
                    <span class="text-[10px] bg-emerald-200/80 text-emerald-900 px-2 py-0.5 rounded font-bold">Prioritas 1</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Bank</label>
                        <input type="text" name="donation_bank_1_name" value="{{ $settings['donation_bank_1_name'] ?? 'Bank Sumsel Babel Syariah' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nomor Rekening</label>
                        <input type="text" name="donation_bank_1_rekening" value="{{ $settings['donation_bank_1_rekening'] ?? '801-0900-1950' }}" class="w-full bg-white text-xs font-mono font-bold text-slate-900 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Kode Bank</label>
                        <input type="text" name="donation_bank_1_code" value="{{ $settings['donation_bank_1_code'] ?? '120' }}" class="w-full bg-white text-xs font-mono text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Atas Nama Rekening (Holder)</label>
                        <input type="text" name="donation_bank_1_holder" value="{{ $settings['donation_bank_1_holder'] ?? 'YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Tag Kartu</label>
                        <input type="text" name="donation_bank_1_badge" value="{{ $settings['donation_bank_1_badge'] ?? 'Bank Utama Wilayah' }}" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Keterangan Subtitle Bank</label>
                        <input type="text" name="donation_bank_1_subtitle" value="{{ $settings['donation_bank_1_subtitle'] ?? 'Mitra Resmi Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS)' }}" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Teks Tombol Salin</label>
                        <input type="text" name="donation_bank_1_btn_text" value="{{ $settings['donation_bank_1_btn_text'] ?? 'Salin Nomor Rekening' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                </div>
            </div>

            {{-- BANK 2 --}}
            <div class="p-5 rounded-2xl bg-orange-50/60 border border-orange-200 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase text-orange-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-building-columns"></i> Rekening Bank 2 (Nasional / BSI)
                    </span>
                    <span class="text-[10px] bg-orange-200/80 text-orange-900 px-2 py-0.5 rounded font-bold">Prioritas 2</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Bank</label>
                        <input type="text" name="donation_bank_2_name" value="{{ $settings['donation_bank_2_name'] ?? 'Bank Syariah Indonesia (BSI)' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nomor Rekening</label>
                        <input type="text" name="donation_bank_2_rekening" value="{{ $settings['donation_bank_2_rekening'] ?? '718-899-2211' }}" class="w-full bg-white text-xs font-mono font-bold text-slate-900 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Kode Bank</label>
                        <input type="text" name="donation_bank_2_code" value="{{ $settings['donation_bank_2_code'] ?? '451' }}" class="w-full bg-white text-xs font-mono text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Atas Nama Rekening (Holder)</label>
                        <input type="text" name="donation_bank_2_holder" value="{{ $settings['donation_bank_2_holder'] ?? 'PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Tag Kartu</label>
                        <input type="text" name="donation_bank_2_badge" value="{{ $settings['donation_bank_2_badge'] ?? 'Bank Syariah Nasional' }}" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Keterangan Subtitle Bank</label>
                        <input type="text" name="donation_bank_2_subtitle" value="{{ $settings['donation_bank_2_subtitle'] ?? 'Jaringan Perbankan Syariah Nasional Terbesar' }}" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Teks Tombol Salin</label>
                        <input type="text" name="donation_bank_2_btn_text" value="{{ $settings['donation_bank_2_btn_text'] ?? 'Salin Nomor Rekening' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>

            {{-- BANK 3 (OPSIONAL) --}}
            <div class="p-5 rounded-2xl bg-teal-50/60 border border-teal-200 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase text-teal-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-building-columns"></i> Rekening Bank 3 (Opsional / Tambahan)
                    </span>
                    <span class="text-[10px] bg-teal-200/80 text-teal-900 px-2 py-0.5 rounded font-bold">Opsional</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Bank (Kosongkan jika tidak dipakai)</label>
                        <input type="text" name="donation_bank_3_name" value="{{ $settings['donation_bank_3_name'] ?? '' }}" placeholder="Contoh: Bank Muamalat" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nomor Rekening</label>
                        <input type="text" name="donation_bank_3_rekening" value="{{ $settings['donation_bank_3_rekening'] ?? '' }}" placeholder="Contoh: 341-0088-772" class="w-full bg-white text-xs font-mono font-bold text-slate-900 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Kode Bank</label>
                        <input type="text" name="donation_bank_3_code" value="{{ $settings['donation_bank_3_code'] ?? '' }}" placeholder="Contoh: 147" class="w-full bg-white text-xs font-mono text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Atas Nama Rekening</label>
                        <input type="text" name="donation_bank_3_holder" value="{{ $settings['donation_bank_3_holder'] ?? '' }}" placeholder="YAYASAN RAUDHATUL ULUM" class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Tag Kartu</label>
                        <input type="text" name="donation_bank_3_badge" value="{{ $settings['donation_bank_3_badge'] ?? '' }}" placeholder="Bank Tambahan" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3: KONFIRMASI WHATSAPP & TOMBOL KONFIRMASI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Pengaturan Konfirmasi Donasi via WhatsApp</h3>
                    <p class="text-xs text-slate-500">Nomor kontak bendahara, teks tombol kirim bukti transfer, dan template pesan WhatsApp otomatis.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp Bendahara</label>
                    <input type="text" name="donation_confirm_phone" value="{{ $settings['donation_confirm_phone'] ?? '081278901950' }}" placeholder="081278901950" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol WhatsApp</label>
                    <input type="text" name="donation_confirm_btn_text" value="{{ $settings['donation_confirm_btn_text'] ?? 'Kirim Bukti Transfer' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Kartu Konfirmasi</label>
                    <input type="text" name="donation_confirm_badge" value="{{ $settings['donation_confirm_badge'] ?? 'Konfirmasi Infaq Cepat' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Kartu Konfirmasi</label>
                    <input type="text" name="donation_confirm_title" value="{{ $settings['donation_confirm_title'] ?? 'Sudah Menyalurkan Infaq? Konfirmasi Sekarang' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Kaki Layanan</label>
                    <input type="text" name="donation_confirm_footer_note" value="{{ $settings['donation_confirm_footer_note'] ?? 'Layanan Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga' }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Ajakan Konfirmasi</label>
                    <textarea name="donation_confirm_desc" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['donation_confirm_desc'] ?? 'Kirimkan bukti transfer Anda ke nomor WhatsApp bendahara sekolah agar donasi Anda tercatat secara akuntabel dan mendapatkan laporan berkala.' }}</textarea>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Template Pesan WhatsApp Otomatis (Saat Diklik Pengunjung)</label>
                    <textarea name="donation_confirm_text" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['donation_confirm_text'] ?? "Assalamu'alaikum Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga, saya telah menyalurkan infaq / donasi pendidikan untuk kemaslahatan sekolah." }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 4: PANDUAN 3 LANGKAH MUDAH BERINFAQ --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-list-ol"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Panduan 3 Langkah Mudah Berinfaq</h3>
                    <p class="text-xs text-slate-500">Judul langkah dan petunjuk praktis proses pengiriman serta konfirmasi infaq.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Panduan</label>
                    <input type="text" name="donation_steps_title" value="{{ $settings['donation_steps_title'] ?? '3 Langkah Mudah Berinfaq Jariyah' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subjudul Seksi Panduan</label>
                    <input type="text" name="donation_steps_subtitle" value="{{ $settings['donation_steps_subtitle'] ?? 'Panduan singkat proses pengiriman dan konfirmasi infaq pendidikan' }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Step 1 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-black text-[#00843d] uppercase block">Langkah 1</span>
                    <input type="text" name="donation_step_1_title" value="{{ $settings['donation_step_1_title'] ?? 'Transfer Dana Infaq' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-lg px-3 py-2 border border-slate-200">
                    <textarea name="donation_step_1_desc" rows="3" class="w-full bg-white text-xs text-slate-700 rounded-lg p-2.5 border border-slate-200">{{ $settings['donation_step_1_desc'] ?? 'Kirimkan donasi melalui Bank Sumsel Babel Syariah atau BSI rekening resmi sekolah.' }}</textarea>
                </div>

                {{-- Step 2 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-black text-[#00843d] uppercase block">Langkah 2</span>
                    <input type="text" name="donation_step_2_title" value="{{ $settings['donation_step_2_title'] ?? 'Simpan Bukti Mutasi' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-lg px-3 py-2 border border-slate-200">
                    <textarea name="donation_step_2_desc" rows="3" class="w-full bg-white text-xs text-slate-700 rounded-lg p-2.5 border border-slate-200">{{ $settings['donation_step_2_desc'] ?? 'Ambil tangkapan layar (screenshot) struk mutasi perbankan mobile banking atau ATM Anda.' }}</textarea>
                </div>

                {{-- Step 3 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-black text-[#00843d] uppercase block">Langkah 3</span>
                    <input type="text" name="donation_step_3_title" value="{{ $settings['donation_step_3_title'] ?? 'Konfirmasi via WA' }}" class="w-full bg-white text-xs font-bold text-slate-800 rounded-lg px-3 py-2 border border-slate-200">
                    <textarea name="donation_step_3_desc" rows="3" class="w-full bg-white text-xs text-slate-700 rounded-lg p-2.5 border border-slate-200">{{ $settings['donation_step_3_desc'] ?? 'Kirimkan bukti ke nomor WhatsApp sekolah untuk pencatatan dan penerbitan tanda terima resmi.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 5: TRANSPARANSI & AKUNTABILITAS TATA KELOLA --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Transparansi &amp; Akuntabilitas Tata Kelola Yayasan</h3>
                    <p class="text-xs text-slate-500">Prinsip amanah, laporan berkala, dan rincian alokasi dana donasi.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Transparansi</label>
                    <input type="text" name="donation_transparency_title" value="{{ $settings['donation_transparency_title'] ?? 'Akuntabilitas & Tata Kelola Infaq Yayasan' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Paragraf Deskripsi Pengantar</label>
                    <textarea name="donation_transparency_desc" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['donation_transparency_desc'] ?? 'Pengelolaan infaq pembangunan dan beasiswa pendidikan santri diatur secara profesional oleh Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS) dengan prinsip amanah, transparan, dan dapat dipertanggungjawabkan secara berkala.' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Poin-Poin Komitmen Transparansi (1 Baris = 1 Poin Bullet)</label>
                    <textarea name="donation_transparency_points" rows="4" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]" placeholder="1 baris = 1 poin">{{ $settings['donation_transparency_points'] ?? "100% dana infaq pembangunan dialokasikan langsung untuk sarana belajar, laboratorium, dan masjid pondok.\nProgram beasiswa disalurkan langsung kepada santri berprestasi dari keluarga prasejahtera dan dhuafa.\nLaporan keuangan disajikan secara berkala dalam forum komite dan rapat tahunan yayasan." }}</textarea>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-emerald-700 hover:to-emerald-800 text-white font-bold text-xs px-7 py-3 rounded-xl shadow-lg transition flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Seluruh Konten Donasi</span>
            </button>
        </div>

    </form>
</div>
@endsection
