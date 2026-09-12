@extends('layouts.admin')

@section('title', 'Kelola Konten & Fleksibilitas Formulir PPDB')
@section('header_title', 'Kelola Konten & Fleksibilitas Formulir PPDB')

@section('content')
<div class="space-y-6" x-data="{ 
    currentTab: '{{ request('tab', 'konten') }}', 
    showAddFieldModal: false, 
    newFieldType: 'text',
    activeCategory: 'all',
    searchQuery: '',
    expandedField: null
}">

    {{-- TOP NAVIGATION TABS --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.ppdb.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs transition {{ request()->routeIs('admin.ppdb.index') ? 'bg-[#da251c] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <i class="fa-solid fa-users mr-1.5"></i> Data Calon Santri (Pendaftar)
            </a>
            <button type="button" @click="currentTab = 'konten'" :class="currentTab === 'konten' ? 'bg-[#00913e] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition cursor-pointer flex items-center space-x-1.5">
                <i class="fa-solid fa-sliders"></i>
                <span>Konten &amp; 10 Menu PPDB</span>
            </button>
            <button type="button" @click="currentTab = 'formulir'" :class="currentTab === 'formulir' ? 'bg-[#00913e] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition cursor-pointer flex items-center space-x-1.5">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Kustomisasi Formulir Online</span>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.ppdb.export.excel') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-700 hover:bg-emerald-800 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
            <a href="{{ route('admin.ppdb.export.pdf') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-red-700 hover:bg-red-800 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('ppdb.index') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-slate-800 hover:bg-slate-900 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Pratinjau Web PPDB</span>
            </a>
        </div>
    </div>

    {{-- FORM PENGATURAN KONTEN & FORMULIR PPDB --}}
    <form action="{{ route('admin.ppdb.content.update') }}" method="POST" class="space-y-8">
        @csrf

        {{-- TAB 1: PENGATURAN KONTEN & 10 MENU PPDB --}}
        <div x-show="currentTab === 'konten'" class="space-y-8">

            {{-- SECTION 1: STATUS & HERO PPDB --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">1. Status Gelombang &amp; Hero PPDB</h3>
                        <p class="text-xs text-slate-500">Atur periode penerimaan, tahun ajaran, nominal formulir, dan teks promo utama.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Pelajaran <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_year" required value="{{ old('ppdb_year', $settings['year']) }}" placeholder="Contoh: 2026/2027" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Gelombang Aktif</label>
                        <input type="text" name="ppdb_wave" value="{{ old('ppdb_wave', $settings['wave']) }}" placeholder="Contoh: Gelombang 1 (Aktif)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nominal Biaya Formulir <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_registration_fee" required value="{{ old('ppdb_registration_fee', $settings['registration_fee']) }}" placeholder="Contoh: Rp 250.000,-" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Promo / Potongan Biaya</label>
                        <input type="text" name="ppdb_promo" value="{{ old('ppdb_promo', $settings['promo']) }}" placeholder="Contoh: Potongan Biaya Masuk Up to 50% OFF (*S&K berlaku)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Singkat SPMB PPDB</label>
                        <textarea name="ppdb_tagline" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_tagline', $settings['tagline']) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: VIDEO PROFIL YOUTUBE --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">2. Video Profil YouTube Halaman PPDB</h3>
                        <p class="text-xs text-slate-500">Video resmi yang disematkan (embed) pada halaman informasi PPDB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">YouTube Video ID atau URL Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_youtube_id" required value="{{ old('ppdb_youtube_id', $settings['youtube_id']) }}" placeholder="Contoh: IrPVG8CYjRc atau https://www.youtube.com/watch?v=IrPVG8CYjRc" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Teks Video</label>
                        <input type="text" name="ppdb_video_title" value="{{ old('ppdb_video_title', $settings['video_title']) }}" placeholder="Video Profil & Dokumentasi SMA IT Ishum" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: JAM OPERASIONAL & SEKRETARIAT --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">3. Jam Operasional SPMB &amp; Sekretariat</h3>
                        <p class="text-xs text-slate-500">Jadwal layanan pendaftaran offline dan alamat sekretariat panitia.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hari Kerja (Senin - Jum'at) <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_operational_weekday" required value="{{ old('ppdb_operational_weekday', $settings['operational_weekday']) }}" placeholder="Senin – Jum'at: Pukul 08.00 – 15.00 WIB" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hari Sabtu <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_operational_weekend" required value="{{ old('ppdb_operational_weekend', $settings['operational_weekend']) }}" placeholder="Sabtu: Pukul 08.00 – 12.00 WIB" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Sekretariat SPMB <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_secretariat" required value="{{ old('ppdb_secretariat', $settings['secretariat']) }}" placeholder="Kompleks SMA IT Ishum, Jl. Sadewa RT 01 RW 04 Karang Raja" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 4: REKENING PEMBAYARAN FORMULIR --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">4. Rekening Pembayaran Biaya Formulir</h3>
                        <p class="text-xs text-slate-500">Rekening tujuan transfer biaya formulir pendaftaran PPDB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Bank <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_name" required value="{{ old('ppdb_bank_name', $settings['bank_name']) }}" placeholder="Bank Syariah Indonesia (BSI)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Bank <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_code" required value="{{ old('ppdb_bank_code', $settings['bank_code']) }}" placeholder="451" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_account" required value="{{ old('ppdb_bank_account', $settings['bank_account']) }}" placeholder="7011304251" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atas Nama Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_holder" required value="{{ old('ppdb_bank_holder', $settings['bank_holder']) }}" placeholder="YL. Fatmawati" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 5: KONTAK HOTLINE WHATSAPP --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-green-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">5. Kontak WhatsApp Panitia PPDB</h3>
                        <p class="text-xs text-slate-500">Nomor admin dan panitia yang menerima forwarding pendaftaran calon santri.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp Admin Utama <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_hotline_phone" required value="{{ old('ppdb_hotline_phone', $settings['hotline_phone']) }}" placeholder="0821-8268-0647" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label Kontak Utama</label>
                        <input type="text" name="ppdb_hotline_name" value="{{ old('ppdb_hotline_name', $settings['hotline_name']) }}" placeholder="Admin Hotline PPDB" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp CS 2 / Kepala Sekolah</label>
                        <input type="text" name="ppdb_hotline_2_phone" value="{{ old('ppdb_hotline_2_phone', $settings['hotline_2_phone']) }}" placeholder="0822-8157-3615" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label Kontak 2</label>
                        <input type="text" name="ppdb_hotline_2_name" value="{{ old('ppdb_hotline_2_name', $settings['hotline_2_name']) }}" placeholder="Ust. Agi (Kepala Sekolah)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 6: KONTEN LENGKAP 10 ACCORDION MENU PPDB --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">6. Seluruh 10 Menu Accordion Informasi PPDB</h3>
                        <p class="text-xs text-slate-500">Semua isi teks accordion pada halaman informasi PPDB dapat diedit di sini secara lengkap.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- KOLOM KIRI (6 MENU) --}}
                    <div class="space-y-5">
                        <div class="p-3 bg-emerald-50 text-[#00913e] rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-columns"></i>
                            <span>Kolom Kiri (Jalur &amp; Persyaratan)</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">1. Alur Pendaftaran</label>
                            <textarea name="ppdb_alur" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_alur', $settings['alur']) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1">Gunakan baris baru untuk memisahkan setiap tahapan alur.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">2. Syarat Pendaftaran</label>
                            <textarea name="ppdb_syarat" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_syarat', $settings['syarat']) }}</textarea>
                            <p class="text-[10px] text-slate-400 mt-1">Gunakan baris baru untuk memisahkan setiap poin syarat berkas.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">3. Jalur Prestasi &amp; Keringanan</label>
                            <textarea name="ppdb_prestasi" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_prestasi', $settings['prestasi']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">4. Jalur Hafizh Al-Qur'an (Tahfidz)</label>
                            <textarea name="ppdb_tahfidz" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_tahfidz', $settings['tahfidz']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">5. Jalur Alumni SMPIT Ishum</label>
                            <textarea name="ppdb_alumni" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_alumni', $settings['alumni']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">6. Jalur Reguler / Tes Mandiri</label>
                            <textarea name="ppdb_mandiri" rows="4" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_mandiri', $settings['mandiri']) }}</textarea>
                        </div>
                    </div>

                    {{-- KOLOM KANAN (4 MENU) --}}
                    <div class="space-y-5">
                        <div class="p-3 bg-emerald-50 text-[#00913e] rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-columns"></i>
                            <span>Kolom Kanan (Jadwal &amp; Biaya)</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">7. Jadwal Gelombang PPDB</label>
                            <textarea name="ppdb_jadwal_gelombang" rows="5" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_jadwal_gelombang', $settings['jadwal_gelombang']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">8. Rincian Biaya &amp; Fasilitas Seragam</label>
                            <textarea name="ppdb_biaya" rows="5" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_biaya', $settings['biaya']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">9. Pilihan Program: Boarding (Asrama) &amp; Full Day</label>
                            <textarea name="ppdb_boarding" rows="5" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_boarding', $settings['boarding']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">10. Pengumuman Kelulusan &amp; Daftar Ulang</label>
                            <textarea name="ppdb_kelulusan" rows="5" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_kelulusan', $settings['kelulusan']) }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            {{-- SECTION 7: UCAPAN PENUTUP & DOA --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-hands-praying"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">7. Pesan Penutup &amp; Doa Harapan</h3>
                        <p class="text-xs text-slate-500">Teks ucapan terima kasih dan doa yang tampil di bagian bawah halaman PPDB.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Ucapan Penutup</label>
                        <input type="text" name="ppdb_closing_title" value="{{ old('ppdb_closing_title', $settings['closing_title']) }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Doa &amp; Harapan</label>
                        <textarea name="ppdb_closing_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_closing_desc', $settings['closing_desc']) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- TAB 2: PENGATURAN & KUSTOMISASI FORMULIR ONLINE --}}
        <div x-show="currentTab === 'formulir'" class="space-y-6" style="display: none;">

            {{-- 1. STATUS & PENGUMUMAN FORMULIR (KOMPAK & BERSIH) --}}
            <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-power-off"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">1. Status Penerimaan &amp; Pengumuman Formulir</h3>
                        <p class="text-xs text-slate-500">Kontrol cepat buka/tutup pendaftaran online dan notifikasi untuk calon pendaftar.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Formulir PPDB Online</label>
                        <select name="ppdb_form_status" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="1" {{ ($settings['form_status'] ?? '1') === '1' ? 'selected' : '' }}>🟢 BUKA PENDAFTARAN (Formulir Aktif Dapat Diisi)</option>
                            <option value="0" {{ ($settings['form_status'] ?? '1') === '0' ? 'selected' : '' }}>🔴 TUTUP PENDAFTARAN (Tampilkan Pemberitahuan Tutup)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi WhatsApp Otomatis</label>
                        <select name="ppdb_form_wa_confirm" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="1" {{ ($settings['form_wa_confirm'] ?? '1') === '1' ? 'selected' : '' }}>🟢 Aktif (Arahkan otomatis ke WA Panitia setelah submit)</option>
                            <option value="0" {{ ($settings['form_wa_confirm'] ?? '1') === '0' ? 'selected' : '' }}>⚪ Simpan di Database Saja (Tanpa redirect WhatsApp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pesan Saat Formulir Ditutup</label>
                        <textarea name="ppdb_form_closed_message" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_form_closed_message', $settings['form_closed_message']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kotak Pengumuman / Info di Atas Formulir</label>
                        <textarea name="ppdb_form_announcement" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_form_announcement', $settings['form_announcement']) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 2. PENGATUR STRUKTUR KOLOM ISIAN FORMULIR (NOTION-STYLE LIST) --}}
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden space-y-0">
                
                {{-- Form Builder Header --}}
                <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-white to-slate-50/60">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-layer-group"></i>
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-base">2. Struktur &amp; Kolom Isian Formulir Online</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-50 text-[#00913e] border border-emerald-200">
                                {{ count($schema) }} Kolom
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Atur nama judul isian, tampilkan/sembunyikan kolom, atau tentukan kolom yang wajib diisi calon pendaftar.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="showAddFieldModal = true" class="bg-[#00913e] hover:bg-[#007a34] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-plus-circle"></i>
                            <span>Tambah Kolom Baru</span>
                        </button>
                        <button type="button" onclick="if(confirm('Apakah Anda yakin ingin mengembalikan seluruh kolom formulir ke susunan standar awal sekolah?')) { document.getElementById('resetFieldsForm').submit(); }" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 cursor-pointer" title="Reset ke Standar">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="hidden sm:inline">Reset Standar</span>
                        </button>
                    </div>
                </div>

                {{-- Filter Kategori Tabs & Search Bar --}}
                <div class="p-4 bg-slate-50/70 border-b border-slate-100 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 sm:pb-0">
                            <button type="button" @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition shrink-0 cursor-pointer">
                                Semua ({{ count($schema) }})
                            </button>
                            @foreach($sections as $sKey => $sInfo)
                                @php
                                    $countInSec = collect($schema)->where('section', $sKey)->count();
                                @endphp
                                <button type="button" @click="activeCategory = '{{ $sKey }}'" :class="activeCategory === '{{ $sKey }}' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition shrink-0 cursor-pointer flex items-center gap-1.5">
                                    <i class="{{ $sInfo['icon'] }} text-[10px]"></i>
                                    <span>{{ $sInfo['name'] }}</span>
                                    <span class="text-[10px] opacity-80 font-normal">({{ $countInSec }})</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="relative w-full sm:w-64 shrink-0">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" x-model="searchQuery" placeholder="Cari nama kolom..." class="w-full bg-white text-xs rounded-xl pl-8 pr-3 py-1.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>
                    </div>
                </div>

                {{-- Field List Rows --}}
                <div class="divide-y divide-slate-100">
                    @foreach($schema as $f)
                        @php
                            $isCustom = empty($f['is_system']);
                            $secKey = $f['section'] ?? 'tambahan';
                            $secInfo = $sections[$secKey] ?? ['name' => 'Lainnya', 'icon' => 'fa-solid fa-folder', 'color' => 'bg-slate-100 text-slate-700'];
                            $typeMeta = match($f['type']) {
                                'select' => ['label' => 'Pilihan', 'icon' => 'fa-solid fa-list', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                'file' => ['label' => 'Upload File', 'icon' => 'fa-solid fa-paperclip', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                'date' => ['label' => 'Tanggal', 'icon' => 'fa-solid fa-calendar', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                                'number' => ['label' => 'Angka', 'icon' => 'fa-solid fa-hashtag', 'color' => 'bg-cyan-50 text-cyan-700 border-cyan-200'],
                                'textarea' => ['label' => 'Paragraf', 'icon' => 'fa-solid fa-align-left', 'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                'tel' => ['label' => 'Telepon/WA', 'icon' => 'fa-solid fa-phone', 'color' => 'bg-teal-50 text-teal-700 border-teal-200'],
                                default => ['label' => 'Teks', 'icon' => 'fa-solid fa-font', 'color' => 'bg-slate-100 text-slate-700 border-slate-200'],
                            };
                            $labelSafe = strtolower(addcslashes($f['label'], "'\r\n\\"));
                            $keySafe = strtolower(addcslashes($f['key'], "'\r\n\\"));
                        @endphp
                        <div x-show="(activeCategory === 'all' || activeCategory === '{{ $secKey }}') && (!searchQuery || '{{ $labelSafe }}'.includes(searchQuery.toLowerCase()) || '{{ $keySafe }}'.includes(searchQuery.toLowerCase()))" 
                             class="p-4 sm:px-6 hover:bg-slate-50/80 transition space-y-3"
                             :class="{ 'bg-slate-50/90': expandedField === '{{ $f['key'] }}' }">
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                
                                {{-- Left Column: Type Icon & Editable Label & Meta --}}
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <span class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs font-bold border {{ $typeMeta['color'] }}" title="Tipe: {{ $typeMeta['label'] }}">
                                        <i class="{{ $typeMeta['icon'] }}"></i>
                                    </span>

                                    <div class="flex-1 min-w-0 flex flex-wrap items-center gap-2">
                                        <input type="text" name="fields[{{ $f['key'] }}][label]" value="{{ $f['label'] }}" 
                                               class="bg-slate-50 hover:bg-white focus:bg-white text-xs sm:text-sm font-bold text-slate-800 rounded-lg px-2.5 py-1.5 border border-slate-200 focus:border-[#00913e] focus:outline-none focus:ring-1 focus:ring-[#00913e] transition w-full sm:w-72 max-w-full"
                                               title="Klik untuk mengubah label/judul isian">
                                        
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border uppercase {{ $typeMeta['color'] }}">
                                            {{ $typeMeta['label'] }}
                                        </span>

                                        @if($isCustom)
                                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-purple-100 text-purple-700 border border-purple-200">
                                                Kustom
                                            </span>
                                        @endif

                                        <span class="text-[10px] text-slate-400 font-mono hidden lg:inline">
                                            {{ $f['key'] }}
                                        </span>

                                        <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md hidden sm:inline-flex items-center gap-1">
                                            <i class="{{ $secInfo['icon'] }} text-[9px] text-slate-400"></i>
                                            <span>{{ $secInfo['name'] }}</span>
                                        </span>
                                    </div>
                                </div>

                                {{-- Right Column: Tampil, Wajib, Pengaturan Detail & Hapus --}}
                                <div class="flex items-center gap-2 sm:gap-3 shrink-0 pl-11 md:pl-0">
                                    {{-- Toggle Tampil --}}
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer select-none bg-white hover:bg-slate-50 px-2.5 py-1.5 rounded-xl border border-slate-200 shadow-2xs transition text-xs font-semibold text-slate-700">
                                        <input type="checkbox" name="fields[{{ $f['key'] }}][enabled]" value="1" {{ !empty($f['enabled']) ? 'checked' : '' }} class="w-3.5 h-3.5 rounded text-[#00913e] focus:ring-[#00913e] border-slate-300">
                                        <span>Tampil</span>
                                    </label>

                                    {{-- Toggle Wajib --}}
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer select-none bg-white hover:bg-slate-50 px-2.5 py-1.5 rounded-xl border border-slate-200 shadow-2xs transition text-xs font-semibold text-slate-700">
                                        <input type="checkbox" name="fields[{{ $f['key'] }}][required]" value="1" {{ !empty($f['required']) ? 'checked' : '' }} class="w-3.5 h-3.5 rounded text-red-600 focus:ring-red-500 border-slate-300">
                                        <span>Wajib <span class="text-red-500 font-bold">*</span></span>
                                    </label>

                                    {{-- Tombol Detail / Pengaturan Opsi --}}
                                    <button type="button" @click="expandedField = (expandedField === '{{ $f['key'] }}' ? null : '{{ $f['key'] }}')" 
                                            :class="expandedField === '{{ $f['key'] }}' ? 'bg-slate-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'" 
                                            class="p-1.5 px-2 rounded-xl text-xs font-bold transition cursor-pointer flex items-center gap-1"
                                            title="Pengaturan Placeholder / Opsi Dropdown">
                                        <i class="fa-solid fa-gear text-[11px]"></i>
                                        <i class="fa-solid fa-chevron-down text-[9px] transition" :class="expandedField === '{{ $f['key'] }}' ? 'rotate-180' : ''"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" onclick="if(confirm('Hapus kolom \'{{ addslashes($f['label']) }}\' dari formulir PPDB?')) { document.getElementById('deleteFieldForm').action = '{{ route('admin.ppdb.fields.delete', $f['key']) }}'; document.getElementById('deleteFieldForm').submit(); }" 
                                            class="text-slate-400 hover:text-red-600 p-1.5 rounded-xl hover:bg-red-50 transition cursor-pointer text-xs" 
                                            title="Hapus Kolom Ini">
                                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                                    </button>
                                </div>

                            </div>

                            {{-- Inline Detail Drawer: Placeholder & Dropdown Options --}}
                            <div x-show="expandedField === '{{ $f['key'] }}'" class="pt-3 pb-2 px-4 bg-white rounded-2xl border border-slate-200 space-y-3 mt-2 shadow-inner">
                                <div class="grid grid-cols-1 {{ $f['type'] === 'select' ? 'md:grid-cols-2' : '' }} gap-3">
                                    @if($f['type'] !== 'file' && $f['type'] !== 'select')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Teks Bantuan / Placeholder
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Contoh teks bantuan saat kosong..." class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>
                                    @endif

                                    @if($f['type'] === 'file')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Petunjuk Upload Dokumen
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Format JPG, PNG, atau PDF (Maks 5 MB)" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>
                                    @endif

                                    @if($f['type'] === 'select')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Placeholder Pilihan Awal
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Pilih salah satu..." class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Daftar Pilihan Dropdown <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                                            </label>
                                            <textarea name="fields[{{ $f['key'] }}][options]" rows="4" class="w-full bg-slate-50 text-xs font-mono rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ implode("\n", $f['options'] ?? []) }}</textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>

            {{-- 3. ACCORDION PENGATURAN LANJUTAN (OPSI TEKS GELOMBANG, JALUR & PROGRAM) --}}
            <details class="group bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
                <summary class="p-5 sm:p-6 flex items-center justify-between font-extrabold text-slate-800 text-sm cursor-pointer hover:bg-slate-50 transition select-none">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-sliders"></i>
                        </span>
                        <div>
                            <span class="block">3. Pengaturan Lanjutan (Opsi Teks Gelombang, Jalur &amp; Program)</span>
                            <span class="text-xs font-normal text-slate-500">Klik untuk melihat atau mengubah daftar opsi teks gelombang, jalur masuk, dan program belajar.</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-400 group-open:rotate-180 transition"></i>
                </summary>

                <div class="p-6 pt-2 border-t border-slate-100 space-y-6 bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Gelombang <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_waves" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_waves', $settings['form_waves']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Jalur Masuk <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_tracks" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_tracks', $settings['form_tracks']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Program Belajar <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_programs" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_programs', $settings['form_programs']) }}</textarea>
                        </div>
                    </div>

                    {{-- Hidden inputs for legacy requirements to preserve backwards-compatibility --}}
                    <input type="hidden" name="ppdb_form_require_payment" value="{{ $settings['form_require_payment'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_require_birth_cert" value="{{ $settings['form_require_birth_cert'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_nisn_rule" value="{{ $settings['form_nisn_rule'] ?? 'optional' }}">
                    <input type="hidden" name="ppdb_form_show_achievements" value="{{ $settings['form_show_achievements'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_show_hobbies" value="{{ $settings['form_show_hobbies'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_require_parent_income" value="{{ $settings['form_require_parent_income'] ?? '1' }}">
                </div>
            </details>

        </div>

        {{-- SUBMIT BAR STICKY --}}
        <div class="sticky bottom-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-200 flex items-center justify-between z-20">
            <div class="text-xs text-slate-500 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-[#00913e]"></i>
                <span>Semua perubahan konten &amp; pengaturan formulir langsung diterapkan ke halaman website.</span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.ppdb.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#007a34] text-white font-black text-xs sm:text-sm px-8 py-3 rounded-xl shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Seluruh Pengaturan PPDB</span>
                </button>
            </div>
        </div>

    </form>

    {{-- HIDDEN FORM UNTUK DELETE FIELD --}}
    <form id="deleteFieldForm" method="POST" action="" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- HIDDEN FORM UNTUK RESET FIELDS --}}
    <form id="resetFieldsForm" method="POST" action="{{ route('admin.ppdb.fields.reset') }}" style="display: none;">
        @csrf
    </form>

    {{-- MODAL TAMBAH KOLOM ISIAN BARU --}}
    <div x-show="showAddFieldModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showAddFieldModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6" @click.away="showAddFieldModal = false">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Tambah Kolom Isian Baru</h3>
                            <p class="text-xs text-slate-500">Buat kolom kustom baru untuk formulir PPDB online.</p>
                        </div>
                    </div>
                    <button type="button" @click="showAddFieldModal = false" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('admin.ppdb.fields.add') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama / Label Kolom <span class="text-red-500">*</span></label>
                        <input type="text" name="label" required placeholder="Contoh: Nomor Kartu Keluarga, Ukuran Baju, dsb..." class="w-full bg-slate-50 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori / Bagian <span class="text-red-500">*</span></label>
                            <select name="section" required class="w-full bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                                @foreach($sections as $sKey => $sInfo)
                                    <option value="{{ $sKey }}">{{ $sInfo['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Input <span class="text-red-500">*</span></label>
                            <select name="type" x-model="newFieldType" required class="w-full bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                                <option value="text">Teks Pendek</option>
                                <option value="number">Angka / Nomor</option>
                                <option value="date">Tanggal</option>
                                <option value="select">Pilihan Dropdown (Select)</option>
                                <option value="textarea">Teks Panjang (Paragraf)</option>
                                <option value="tel">Nomor Telepon / WA</option>
                                <option value="file">Upload Berkas / File</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Placeholder / Petunjuk Isian</label>
                        <input type="text" name="placeholder" placeholder="Contoh: Masukkan 16 digit no KK..." class="w-full bg-slate-50 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs">
                    </div>

                    <div x-show="newFieldType === 'select'" style="display: none;">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Opsi Pilihan Dropdown <span class="text-emerald-700 font-normal">(1 baris = 1 opsi)</span> <span class="text-red-500">*</span>
                        </label>
                        <textarea name="options" rows="3" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3" class="w-full bg-slate-50 font-mono rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs"></textarea>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Wajib Diisi oleh Pendaftar?</span>
                            <span class="text-[10px] text-slate-500">Jika aktif, formulir tidak dapat dikirim sebelum kolom ini diisi.</span>
                        </div>
                        <input type="checkbox" name="required" value="1" class="w-5 h-5 rounded text-[#00913e] focus:ring-[#00913e] border-slate-300">
                    </div>

                    <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                        <button type="button" @click="showAddFieldModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="bg-[#00913e] hover:bg-[#007a34] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md shadow-emerald-500/25 transition flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tambahkan Kolom</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
