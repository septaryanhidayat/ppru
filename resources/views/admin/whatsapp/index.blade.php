@extends('layouts.admin')

@section('title', 'Kelola Nomor WhatsApp Resmi Website')
@section('header_title', 'Kelola Nomor WhatsApp')

@section('content')
<form action="{{ route('admin.whatsapp.update') }}" method="POST" class="space-y-8">
    @csrf

    {{-- 1. HERO HEADER BANNER --}}
    <div class="relative bg-gradient-to-r from-[#072418] via-[#005a28] to-[#00843d] text-white p-6 sm:p-8 rounded-3xl shadow-lg overflow-hidden border border-emerald-800/50">
        <div class="absolute -right-8 -bottom-8 opacity-10 text-9xl text-white pointer-events-none">
            <i class="fa-brands fa-whatsapp"></i>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs text-emerald-200 border border-white/15 text-[11px] font-bold">
                    <span class="w-2 h-2 rounded-full bg-[#25d366] animate-pulse"></span>
                    <span>Pusat Integrasi WhatsApp PPRU</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                    Pengaturan Nomor WhatsApp Antar-Halaman
                </h2>
                <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed font-normal">
                    Atur seluruh nomor WhatsApp dan format template pesan resmi yang disematkan di berbagai halaman website. Setiap saluran dapat dikonfigurasi berbeda (PSB Pusat, PSB 8 Unit, Kirim Artikel Alumni/Santri, Layanan Humas, dan Infaq/Wakaf).
                </p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center space-x-2 bg-[#25d366] hover:bg-[#1ebe5d] text-slate-950 font-black text-xs sm:text-sm px-6 py-3.5 rounded-2xl shadow-xl shadow-emerald-950/40 transition transform hover:scale-[1.02] cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-base"></i>
                    <span>Simpan Semua Perubahan</span>
                </button>
            </div>
        </div>

        {{-- Channel Stat Badges --}}
        <div class="mt-6 pt-6 border-t border-white/10 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
            <div class="bg-black/20 rounded-2xl p-3 border border-white/5">
                <span class="text-[10px] text-emerald-300 block font-semibold">Saluran Utama</span>
                <span class="text-sm font-bold text-white truncate block">{{ $settings['contact_whatsapp'] ?? '0812-7890-1950' }}</span>
                <span class="text-[10px] text-emerald-200/70">Header, Footer, Floating</span>
            </div>
            <div class="bg-black/20 rounded-2xl p-3 border border-white/5">
                <span class="text-[10px] text-amber-300 block font-semibold">PSB Pusat Pondok</span>
                <span class="text-sm font-bold text-white truncate block">{{ $settings['ppdb_hotline_phone'] ?? '0812-7890-1950' }}</span>
                <span class="text-[10px] text-amber-200/70">Halaman &amp; Formulir PSB</span>
            </div>
            <div class="bg-black/20 rounded-2xl p-3 border border-white/5">
                <span class="text-[10px] text-cyan-300 block font-semibold">Unit Pendidikan</span>
                <span class="text-sm font-bold text-white block">{{ $units->count() }} Unit Terdata</span>
                <span class="text-[10px] text-cyan-200/70">TK s/d Perguruan Tinggi</span>
            </div>
            <div class="bg-black/20 rounded-2xl p-3 border border-white/5">
                <span class="text-[10px] text-rose-300 block font-semibold">Alumni &amp; Layanan</span>
                <span class="text-sm font-bold text-white block">Saluran Mandiri</span>
                <span class="text-[10px] text-rose-200/70">Artikel, PTSP &amp; Infaq</span>
            </div>
        </div>
    </div>

    {{-- 2. GRID KONTEN PENGATURAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ========================================================
             CARD 1: WHATSAPP PUSAT & INFO PONDOK
             ======================================================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-tower-broadcast"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-800">1. WA Pusat &amp; Info Pondok</h3>
                        <p class="text-[11px] text-slate-400">Saluran induk komunikasi resmi pesantren</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Pusat &amp; Global
                </span>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Nomor WhatsApp Resmi Pondok <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600 font-bold">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </span>
                        <input type="text" 
                               name="contact_whatsapp" 
                               value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '0812-7890-1950') }}" 
                               required 
                               placeholder="Contoh: 0812-7890-1950" 
                               class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl pl-10 pr-4 py-3 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Bisa format 0812..., 62812..., atau +62812... Sistem otomatis menyesuaikan kode negara.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Label / Nama Admin Narahubung
                    </label>
                    <input type="text" 
                           name="contact_whatsapp_label" 
                           value="{{ old('contact_whatsapp_label', $settings['contact_whatsapp_label'] ?? 'Sekretariat & Info Pondok') }}" 
                           placeholder="Contoh: Sekretariat & Info Pondok" 
                           class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Template Pesan Otomatis (Konsultasi Beranda / Chat Utama)
                    </label>
                    <textarea name="wa_helpdesk_message" 
                              rows="3" 
                              placeholder="Tulis draf pesan pembuka..." 
                              class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('wa_helpdesk_message', $settings['wa_helpdesk_message'] ?? "Assalamu'alaikum Admin Utama PPRU Sakatiga, saya ingin berkonsultasi mengenai informasi pesantren / pendaftaran santri baru...") }}</textarea>
                </div>

                {{-- Tersemat di halaman --}}
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80 space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Tersemat Aktif Di Halaman:</span>
                    <div class="flex flex-wrap gap-1.5 text-[10px]">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-emerald-500 mr-1"></i> Topbar Header</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-emerald-500 mr-1"></i> Footer Website</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-emerald-500 mr-1"></i> Floating Chat (Admin Utama)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-emerald-500 mr-1"></i> Hubungi Kami (/hubungi)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-emerald-500 mr-1"></i> Layanan Pemeliharaan</span>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Verifikasi tautan langsung:</span>
                    <a href="{{ \App\Models\Setting::waUrl($settings['contact_whatsapp'] ?? '081278901950', $settings['wa_helpdesk_message'] ?? null) }}" 
                       target="_blank" 
                       rel="noopener" 
                       class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold text-xs border border-emerald-200 transition">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                        <span>Uji Chat WhatsApp Pusat</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- ========================================================
             CARD 2: WHATSAPP PSB / SPMB PUSAT PONDOK
             ======================================================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <span class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-user-graduate"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-800">2. WA PSB / SPMB Pusat Pondok</h3>
                        <p class="text-[11px] text-slate-400">Hotline pendaftaran santri baru tingkat pesantren</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200">
                    PSB Online
                </span>
            </div>

            <div class="space-y-4 text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Nomor Hotline PSB 1 <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600 font-bold">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </span>
                            <input type="text" 
                                   name="ppdb_hotline_phone" 
                                   value="{{ old('ppdb_hotline_phone', $settings['ppdb_hotline_phone'] ?? '0812-7890-1950') }}" 
                                   required 
                                   placeholder="Contoh: 0812-7890-1950" 
                                   class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl pl-10 pr-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Nama PIC / Petugas Hotline 1
                        </label>
                        <input type="text" 
                               name="ppdb_hotline_name" 
                               value="{{ old('ppdb_hotline_name', $settings['ppdb_hotline_name'] ?? 'Panitia SPMB PPRU') }}" 
                               placeholder="Contoh: Panitia SPMB PPRU" 
                               class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Nomor Hotline PSB 2 (Cadangan)
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600 font-bold">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </span>
                            <input type="text" 
                                   name="ppdb_hotline_2_phone" 
                                   value="{{ old('ppdb_hotline_2_phone', $settings['ppdb_hotline_2_phone'] ?? '0812-7890-1950') }}" 
                                   placeholder="Contoh: 0812-7890-1950" 
                                   class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl pl-10 pr-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">
                            Nama PIC / Petugas Hotline 2
                        </label>
                        <input type="text" 
                               name="ppdb_hotline_2_name" 
                               value="{{ old('ppdb_hotline_2_name', $settings['ppdb_hotline_2_name'] ?? 'Sekretariat Pesantren') }}" 
                               placeholder="Contoh: Sekretariat Pesantren" 
                               class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Template Pesan Konsultasi PSB Pusat
                    </label>
                    <textarea name="ppdb_wa_template" 
                              rows="3" 
                              placeholder="Tulis pesan pembuka pendaftar..." 
                              class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('ppdb_wa_template', $settings['ppdb_wa_template'] ?? "Assalamu'alaikum Panitia PSB Pondok Pesantren Raudhatul Ulum Sakatiga, saya ingin konsultasi pendaftaran santri baru.") }}</textarea>
                </div>

                {{-- Tersemat di halaman --}}
                <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80 space-y-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Tersemat Aktif Di Halaman:</span>
                    <div class="flex flex-wrap gap-1.5 text-[10px]">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-amber-500 mr-1"></i> Halaman Utama PSB (/ppdb)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-amber-500 mr-1"></i> Formulir Online (/form_ppdb)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-amber-500 mr-1"></i> Konfirmasi Bayar Pendaftaran</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-amber-500 mr-1"></i> Banner Spotlight PSB Beranda</span>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400">Verifikasi hotline:</span>
                    <a href="{{ \App\Models\Setting::waUrl($settings['ppdb_hotline_phone'] ?? '081278901950', $settings['ppdb_wa_template'] ?? null) }}" 
                       target="_blank" 
                       rel="noopener" 
                       class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs border border-amber-200 transition">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                        <span>Uji Chat Hotline 1 PSB</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ========================================================
         CARD 3: WHATSAPP MASING-MASING UNIT PENDIDIKAN (8 UNIT)
         ======================================================== --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-lg shadow-inner">
                    <i class="fa-solid fa-school-flag"></i>
                </span>
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base text-slate-800">3. WA PSB &amp; Narahubung Masing-Masing Unit Pendidikan (8 Unit)</h3>
                    <p class="text-[11px] text-slate-500">Nomor ini bisa berbeda untuk setiap jenjang sekolah/madrasah. Otomatis terhubung dengan tab Unit di Floating Chat dan halaman profil masing-masing unit.</p>
                </div>
            </div>
            <span class="self-start sm:self-auto px-3 py-1 rounded-full text-[10px] font-extrabold bg-cyan-50 text-cyan-800 border border-cyan-200">
                8 Unit Pendidikan Resmi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-3 w-10 text-center">No</th>
                        <th class="py-3 px-4">Nama Unit &amp; Jenjang</th>
                        <th class="py-3 px-4">Kepala / Narahubung</th>
                        <th class="py-3 px-4 w-72">Nomor WhatsApp Unit</th>
                        <th class="py-3 px-4 w-36 text-center">Uji Chat Langsung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($units as $idx => $unit)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-3.5 px-3 text-center font-bold text-slate-400">
                            {{ $idx + 1 }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 p-1 flex items-center justify-center shrink-0">
                                    <img src="{{ $unit->logo_url }}" alt="{{ $unit->short_name }}" class="max-w-full max-h-full object-contain">
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center space-x-1.5">
                                        <span class="font-extrabold text-slate-900 text-xs">{{ $unit->short_name }}</span>
                                        <span class="text-[10px] px-1.5 py-0.2 rounded bg-slate-100 text-slate-600 font-semibold">{{ $unit->category_type }}</span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 truncate" title="{{ $unit->name }}">{{ $unit->name }}</p>
                                    <a href="{{ route('pendidikan.show', $unit->slug) }}" target="_blank" class="text-[10px] text-emerald-600 hover:underline flex items-center gap-1 mt-0.5">
                                        <span>Lihat Halaman Unit</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            <span class="font-semibold block text-slate-800">{{ $unit->head_name ?: 'Kepala Unit' }}</span>
                            <span class="text-[10px] text-slate-400">Pimpinan / Narahubung</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600 font-bold">
                                    <i class="fa-brands fa-whatsapp text-xs"></i>
                                </span>
                                <input type="text" 
                                       name="units[{{ $unit->id }}][phone]" 
                                       value="{{ old('units.'.$unit->id.'.phone', $unit->phone) }}" 
                                       placeholder="Contoh: 0812-7890-1951" 
                                       class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl pl-8 pr-3 py-2 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @php
                                $unitMsg = "Assalamu'alaikum Admin {$unit->short_name} PPRU, saya ingin konsultasi mengenai informasi dan pendaftaran {$unit->name}...";
                            @endphp
                            <a href="{{ \App\Models\Setting::waUrl($unit->phone, $unitMsg) }}" 
                               target="_blank" 
                               rel="noopener" 
                               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-[#25d366] text-[#00843d] hover:text-white font-extrabold text-[11px] border border-emerald-200 hover:border-[#25d366] transition shadow-2xs">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>Tes Chat</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data unit pendidikan terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="flex items-center space-x-2 text-slate-600">
                <i class="fa-solid fa-circle-info text-cyan-600"></i>
                <span class="text-[11px]">Setiap nomor unit di atas otomatis tersinkronisasi di <strong>Widget Chat Mengambang (Tab Admin Unit)</strong>, tombol <strong>Konsultasi WhatsApp</strong> di profil unit, serta <strong>Katalog Pendaftaran SPMB</strong>.</span>
            </div>
            <button type="submit" class="shrink-0 bg-[#00843d] hover:bg-[#006e33] text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs cursor-pointer">
                <i class="fa-solid fa-check mr-1"></i> Simpan Nomor Unit
            </button>
        </div>
    </div>

    {{-- 3. GRID BARIS KEDUA: SALURAN KHUSUS (ALUMNI, SANTRI, LAYANAN, DONASI) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ========================================================
             CARD 4: KIRIM TULISAN ALUMNI & KARYA SANTRI
             ======================================================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <span class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-800">4. WA Kirim Artikel Alumni &amp; Santri</h3>
                        <p class="text-[11px] text-slate-400">Narahubung kurasi tulisan &amp; naskah website</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-indigo-50 text-indigo-800 border border-indigo-200">
                    Redaksi Web
                </span>
            </div>

            <div class="space-y-4 text-xs">
                {{-- Bagian Alumni IKARUS --}}
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-graduate text-indigo-600"></i>
                            <span>Redaksi Artikel Alumni (IKARUS)</span>
                        </span>
                        <a href="{{ route('ikarus.index') }}" target="_blank" class="text-[10px] text-indigo-600 hover:underline">Halaman IKARUS &rarr;</a>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 text-[11px] mb-1">Nomor WhatsApp Redaksi Alumni</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600 font-bold">
                                <i class="fa-brands fa-whatsapp text-xs"></i>
                            </span>
                            <input type="text" 
                                   name="wa_alumni_article" 
                                   value="{{ old('wa_alumni_article', $settings['wa_alumni_article'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950')) }}" 
                                   placeholder="Kosongkan jika sama dengan nomor WA pusat" 
                                   class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl pl-8 pr-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 text-[11px] mb-1">Template Pesan Naskah Alumni</label>
                        <textarea name="wa_alumni_article_template" 
                                  rows="2" 
                                  class="w-full bg-white text-xs text-slate-800 rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('wa_alumni_article_template', $settings['wa_alumni_article_template'] ?? "Assalamu'alaikum Redaksi IKARUS PPRU, saya alumni ingin mengirimkan naskah karya tulis untuk website.") }}</textarea>
                    </div>
                    <div class="text-right">
                        @php
                            $alumniWaVal = $settings['wa_alumni_article'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950');
                            $alumniMsgVal = $settings['wa_alumni_article_template'] ?? "Assalamu'alaikum Redaksi IKARUS PPRU...";
                        @endphp
                        <a href="{{ \App\Models\Setting::waUrl($alumniWaVal, $alumniMsgVal) }}" target="_blank" rel="noopener" class="text-[11px] font-bold text-indigo-700 hover:text-indigo-900 inline-flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                            <span>Tes Chat Naskah Alumni</span>
                        </a>
                    </div>
                </div>

                {{-- Bagian Karya Santri & Asatidz --}}
                <div class="p-4 bg-slate-50/80 rounded-2xl border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-book-quran text-emerald-600"></i>
                            <span>Redaksi Karya Santri &amp; Asatidz</span>
                        </span>
                        <a href="{{ route('karya-santri') }}" target="_blank" class="text-[10px] text-emerald-600 hover:underline">Halaman Karya Santri &rarr;</a>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 text-[11px] mb-1">Nomor WhatsApp Karya Santri</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-emerald-600 font-bold">
                                <i class="fa-brands fa-whatsapp text-xs"></i>
                            </span>
                            <input type="text" 
                                   name="wa_santri_article" 
                                   value="{{ old('wa_santri_article', $settings['wa_santri_article'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950')) }}" 
                                   placeholder="Kosongkan jika sama dengan nomor WA pusat" 
                                   class="w-full bg-white text-xs font-bold text-slate-800 rounded-xl pl-8 pr-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 text-[11px] mb-1">Template Pesan Naskah Santri</label>
                        <textarea name="wa_santri_article_template" 
                                  rows="2" 
                                  class="w-full bg-white text-xs text-slate-800 rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('wa_santri_article_template', $settings['wa_santri_article_template'] ?? "Assalamu'alaikum Redaksi Web PPRU, saya santri/asatidz ingin mengirimkan naskah karya tulis untuk website.") }}</textarea>
                    </div>
                    <div class="text-right">
                        @php
                            $santriWaVal = $settings['wa_santri_article'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950');
                            $santriMsgVal = $settings['wa_santri_article_template'] ?? "Assalamu'alaikum Redaksi Web PPRU...";
                        @endphp
                        <a href="{{ \App\Models\Setting::waUrl($santriWaVal, $santriMsgVal) }}" target="_blank" rel="noopener" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-900 inline-flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                            <span>Tes Chat Karya Santri</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================
             CARD 5: LAYANAN TERPADU & HUMAS (PTSP PONDOK)
             ======================================================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 space-y-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <span class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-800">5. WA Layanan Terpadu &amp; Humas</h3>
                        <p class="text-[11px] text-slate-400">Pintu perizinan, kerja sama instansi, dan sewa sarana</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-teal-50 text-teal-800 border border-teal-200">
                    Layanan PTSP
                </span>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Nomor WA Helpdesk Layanan Terpadu
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600 font-bold">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </span>
                        <input type="text" 
                               name="ptsp_helpdesk_phone" 
                               value="{{ old('ptsp_helpdesk_phone', $settings['ptsp_helpdesk_phone'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950')) }}" 
                               placeholder="Contoh: 0812-7890-1950" 
                               class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl pl-10 pr-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Template Pesan Konsultasi Layanan
                    </label>
                    <textarea name="ptsp_helpdesk_wa_template" 
                              rows="2" 
                              class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('ptsp_helpdesk_wa_template', $settings['ptsp_helpdesk_wa_template'] ?? "Assalamu'alaikum Humas PPRU Sakatiga, saya ingin konsultasi layanan terpadu") }}</textarea>
                </div>

                {{-- Opsi Sub-Layanan --}}
                <div class="space-y-3 pt-1">
                    <span class="text-[11px] font-bold text-slate-600 block">Saluran WA Sub-Layanan (Opsional, fallback ke helpdesk):</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs">
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 mb-1">WA Sewa Fasilitas</label>
                            <input type="text" 
                                   name="wa_layanan_sewa" 
                                   value="{{ old('wa_layanan_sewa', $settings['wa_layanan_sewa'] ?? '') }}" 
                                   placeholder="Opsional" 
                                   class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 mb-1">WA Kerja Sama</label>
                            <input type="text" 
                                   name="wa_layanan_kerjasama" 
                                   value="{{ old('wa_layanan_kerjasama', $settings['wa_layanan_kerjasama'] ?? '') }}" 
                                   placeholder="Opsional" 
                                   class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-500 mb-1">WA Izin Kunjungan</label>
                            <input type="text" 
                                   name="wa_layanan_izin" 
                                   value="{{ old('wa_layanan_izin', $settings['wa_layanan_izin'] ?? '') }}" 
                                   placeholder="Opsional" 
                                   class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-2.5 py-1.5 border border-slate-200">
                        </div>
                    </div>
                </div>

                {{-- Tersemat di halaman --}}
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200/80">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-1.5">Tersemat Aktif Di Halaman:</span>
                    <div class="flex flex-wrap gap-1.5 text-[10px]">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-teal-500 mr-1"></i> Portal Layanan (/layanan-terpadu)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-teal-500 mr-1"></i> Sewa Fasilitas (/sewa-barang)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-teal-500 mr-1"></i> Kerja Sama (/permohonan-kerja-sama)</span>
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600 font-medium"><i class="fa-solid fa-check text-teal-500 mr-1"></i> Izin Sekolah (/izin-sekolah)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================================
             CARD 6: KONFIRMASI INFAQ & DONASI (YAPIRUS)
             ======================================================== --}}
        <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xs border border-slate-200/80 space-y-5 lg:col-span-2">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </span>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base text-slate-800">6. WA Konfirmasi Infaq &amp; Wakaf (YAPIRUS)</h3>
                        <p class="text-[11px] text-slate-400">Narahubung bendahara / panitia penerima donasi umat</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    Sosial &amp; Infaq
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Nomor WA Konfirmasi Donasi / Infaq
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600 font-bold">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </span>
                        <input type="text" 
                               name="donation_confirm_phone" 
                               value="{{ old('donation_confirm_phone', $settings['donation_confirm_phone'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950')) }}" 
                               placeholder="Contoh: 0812-7890-1950" 
                               class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl pl-10 pr-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk konfirmasi bukti transfer infaq/wakaf pesantren.</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1.5">
                        Template Pesan Konfirmasi Donasi
                    </label>
                    <input type="text" 
                           name="donation_confirm_text" 
                           value="{{ old('donation_confirm_text', $settings['donation_confirm_text'] ?? 'Assalamu\'alaikum, saya ingin konfirmasi infaq/wakaf untuk Pondok Pesantren Raudhatul Ulum Sakatiga.') }}" 
                           placeholder="Tulis pesan pembuka konfirmasi..." 
                           class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                <div class="flex items-center space-x-2 text-slate-500 text-[11px]">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Tersemat di: <strong>Halaman Donasi (/donasi)</strong> dan tombol <strong>Konfirmasi Infaq di Beranda</strong>.</span>
                </div>
                @php
                    $donasiWaVal = $settings['donation_confirm_phone'] ?? ($settings['contact_whatsapp'] ?? '0812-7890-1950');
                    $donasiMsgVal = $settings['donation_confirm_text'] ?? "Assalamu'alaikum, saya ingin konfirmasi donasi...";
                @endphp
                <a href="{{ \App\Models\Setting::waUrl($donasiWaVal, $donasiMsgVal) }}" 
                   target="_blank" 
                   rel="noopener" 
                   class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold text-xs border border-emerald-200 transition">
                    <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                    <span>Uji Chat Donasi</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- 4. FLOATING SUBMIT BAR --}}
    <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 sm:p-5 rounded-2xl shadow-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center space-x-3 text-xs text-slate-600">
            <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                <i class="fa-solid fa-shield-halved"></i>
            </span>
            <div>
                <span class="font-bold text-slate-800 block">Simpan Konfigurasi WhatsApp</span>
                <span class="text-[11px] text-slate-400">Seluruh perubahan nomor dan template pesan langsung aktif di website tanpa restart server.</span>
            </div>
        </div>
        <div class="flex items-center space-x-2 w-full sm:w-auto">
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-[#006e33] hover:to-[#04883b] text-white px-7 py-3 rounded-xl text-xs font-black shadow-lg shadow-emerald-600/30 transition transform hover:scale-[1.02] cursor-pointer">
                <i class="fa-solid fa-floppy-disk text-sm"></i>
                <span>Simpan Semua Nomor WhatsApp</span>
            </button>
        </div>
    </div>

</form>
@endsection
