@extends('layouts.frontend')

@section('title', ($siteSettings['ptsp_page_title'] ?? 'Portal Layanan Terpadu') . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $siteSettings['ptsp_hero_subtitle'] ?? 'Pintu Pelayanan Publik Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga: Izin Kunjungan & Studi Banding, Permohonan Kemitraan Kerja Sama, dan Sewa Peminjaman Fasilitas Pondok.')

@section('content')
@php
    $hdPhone = !empty($siteSettings['ptsp_helpdesk_phone']) ? $siteSettings['ptsp_helpdesk_phone'] : ($siteSettings['contact_phone'] ?? '081278901950');
    $cleanHdWa = preg_replace('/[^0-9]/', '', $hdPhone);
    if (str_starts_with($cleanHdWa, '0')) {
        $cleanHdWa = '62' . substr($cleanHdWa, 1);
    }
    $hdTemplate = $siteSettings['ptsp_helpdesk_wa_template'] ?? "Assalamu'alaikum Humas PPRU Sakatiga, saya ingin konsultasi layanan terpadu";
@endphp

{{-- HERO HEADER --}}
<section class="relative bg-gradient-to-r from-emerald-950 via-[#00843d] to-emerald-900 text-white py-10 sm:py-14 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-6xl mx-auto space-y-3 relative z-10 text-center sm:text-left">
        <nav class="text-xs text-emerald-200 flex items-center justify-center sm:justify-start space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Beranda</span>
            </a>
            <span class="text-emerald-400">/</span>
            <span class="text-[#fcd116] font-bold">Layanan Terpadu</span>
        </nav>

        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-1">
            <div class="w-12 h-12 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-2xl shadow-lg shrink-0">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-white uppercase">
                    {{ $siteSettings['ptsp_page_title'] ?? 'PORTAL LAYANAN TERPADU' }}
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 font-normal max-w-2xl leading-relaxed">
                    {{ $siteSettings['ptsp_hero_subtitle'] ?? 'Satu pintu pelayanan administrasi resmi, perizinan kunjungan edukasi, kemitraan strategis, dan peminjaman fasilitas Pondok Pesantren Raudhatul Ulum Sakatiga.' }}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- MAIN HUB CARDS --}}
<div class="bg-slate-50/70 dark:bg-slate-950 py-10 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-slate-800 px-3.5 py-1 rounded-full border border-emerald-200 dark:border-slate-700">
                {{ $siteSettings['ptsp_section_tag'] ?? 'Pelayanan Terpadu Satu Pintu (PTSP)' }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                {{ $siteSettings['ptsp_section_title'] ?? 'Pilih Layanan yang Anda Butuhkan' }}
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-slate-400">
                {{ $siteSettings['ptsp_section_desc'] ?? 'Ajukan permohonan secara daring, tim Sekretariat dan Humas akan memproses permohonan Anda secara cepat, transparan, dan profesional.' }}
            </p>
        </div>

        {{-- 3 KARTU UTAMA LAYANAN --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7">
            
            {{-- 1. Izin Kunjungan --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-7 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-[#00843d] dark:text-emerald-300 flex items-center justify-center text-2xl group-hover:bg-[#00843d] group-hover:text-white transition duration-300 shadow-xs border border-emerald-100 dark:border-emerald-800">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider bg-emerald-50 dark:bg-slate-800 px-2.5 py-0.5 rounded-full">{{ $siteSettings['ptsp_card1_tag'] ?? 'Layanan Izin' }}</span>
                        <h3 class="text-base sm:text-lg font-black text-gray-900 dark:text-white mt-2 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition">
                            {{ $siteSettings['ptsp_card1_title'] ?? 'Permohonan Izin Kunjungan ke Sekolah' }}
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-300 leading-relaxed">
                        {{ $siteSettings['ptsp_card1_desc'] ?? 'Layanan pengajuan studi banding, observasi kurikulum kepesantrenan, riset ilmiah, atau kunjungan silaturahmi instansi/sekolah ke Pondok Pesantren Raudhatul Ulum.' }}
                    </p>
                    <ul class="text-[11px] text-gray-600 dark:text-slate-300 space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#00843d] dark:text-emerald-400"></i> <span>{{ $siteSettings['ptsp_card1_point1'] ?? 'Bebas Biaya (Gratis)' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#00843d] dark:text-emerald-400"></i> <span>{{ $siteSettings['ptsp_card1_point2'] ?? 'Tur keliling fasilitas pondok' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-[#00843d] dark:text-emerald-400"></i> <span>{{ $siteSettings['ptsp_card1_point3'] ?? 'Respon konfirmasi maks 3 hari' }}</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.izin') }}" class="w-full bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>{{ $siteSettings['ptsp_card1_btn'] ?? 'Ajukan Izin Kunjungan' }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

            {{-- 2. Permohonan Kerja Sama --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-7 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-amber-400 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 flex items-center justify-center text-2xl group-hover:bg-[#f59e0b] group-hover:text-slate-950 transition duration-300 shadow-xs border border-amber-200 dark:border-amber-800">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider bg-amber-50 dark:bg-slate-800 px-2.5 py-0.5 rounded-full">{{ $siteSettings['ptsp_card2_tag'] ?? 'Kemitraan & MoU' }}</span>
                        <h3 class="text-base sm:text-lg font-black text-gray-900 dark:text-white mt-2 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition">
                            {{ $siteSettings['ptsp_card2_title'] ?? 'Permohonan Kerja Sama' }}
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-300 leading-relaxed">
                        {{ $siteSettings['ptsp_card2_desc'] ?? 'Pengajuan kolaborasi program akademik, beasiswa, program CSR dunia usaha, riset bersama, dan kemitraan lembaga keuangan syariah atau universitas.' }}
                    </p>
                    <ul class="text-[11px] text-gray-600 dark:text-slate-300 space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-600 dark:text-amber-400"></i> <span>{{ $siteSettings['ptsp_card2_point1'] ?? 'MoU resmi berkekuatan hukum' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-600 dark:text-amber-400"></i> <span>{{ $siteSettings['ptsp_card2_point2'] ?? 'Kemitraan beasiswa & riset' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-600 dark:text-amber-400"></i> <span>{{ $siteSettings['ptsp_card2_point3'] ?? 'Audiensi langsung pimpinan' }}</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.kerjasama') }}" class="w-full bg-[#f59e0b] hover:bg-amber-500 text-slate-950 font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>{{ $siteSettings['ptsp_card2_btn'] ?? 'Ajukan Kemitraan / MoU' }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

            {{-- 3. Sewa Fasilitas --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-7 border border-slate-200/90 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-sky-400 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-sky-50 dark:bg-sky-950/80 text-sky-700 dark:text-sky-300 flex items-center justify-center text-2xl group-hover:bg-sky-600 group-hover:text-white transition duration-300 shadow-xs border border-sky-200 dark:border-sky-800">
                        <i class="fa-solid fa-boxes-packing"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-sky-700 dark:text-sky-400 uppercase tracking-wider bg-sky-50 dark:bg-slate-800 px-2.5 py-0.5 rounded-full">{{ $siteSettings['ptsp_card3_tag'] ?? 'Sarana & Fasilitas' }}</span>
                        <h3 class="text-base sm:text-lg font-black text-gray-900 dark:text-white mt-2 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition">
                            {{ $siteSettings['ptsp_card3_title'] ?? 'Permohonan Sewa Menyewa Barang Sekolah' }}
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-300 leading-relaxed">
                        {{ $siteSettings['ptsp_card3_desc'] ?? 'Pemanfaatan aula serbaguna, laboratorium komputer CBT, lapangan olahraga terbuka, serta inventaris kegiatan untuk acara kemasyarakatan dan dakwah.' }}
                    </p>
                    <ul class="text-[11px] text-gray-600 dark:text-slate-300 space-y-1.5 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-sky-600 dark:text-sky-400"></i> <span>{{ $siteSettings['ptsp_card3_point1'] ?? 'Aula berkapasitas 1.000 orang' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-sky-600 dark:text-sky-400"></i> <span>{{ $siteSettings['ptsp_card3_point2'] ?? 'Sound system & multimedia lengkap' }}</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-sky-600 dark:text-sky-400"></i> <span>{{ $siteSettings['ptsp_card3_point3'] ?? 'Infaq pemeliharaan terjangkau' }}</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.sewa') }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>{{ $siteSettings['ptsp_card3_btn'] ?? 'Ajukan Sewa Fasilitas' }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- BANTUAN & KONTAK LANGSUNG --}}
        <div class="bg-gradient-to-br from-emerald-900 via-[#005a28] to-emerald-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1.5 text-center sm:text-left">
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-300">{{ $siteSettings['ptsp_helpdesk_tag'] ?? 'Helpdesk Terpadu' }}</span>
                <h3 class="text-lg sm:text-xl font-black">{{ $siteSettings['ptsp_helpdesk_title'] ?? 'Butuh Konsultasi atau Informasi Lebih Lanjut?' }}</h3>
                <p class="text-xs text-emerald-100 max-w-xl">
                    {{ $siteSettings['ptsp_helpdesk_desc'] ?? 'Petugas humas dan sekretariat kami siap membantu menjawab pertanyaan Anda seputar perizinan, administrasi, dan kemitraan pondok.' }}
                </p>
            </div>
            <div class="shrink-0">
                <a href="https://wa.me/{{ $cleanHdWa }}?text={{ urlencode($hdTemplate) }}" target="_blank" rel="noopener" class="bg-[#f59e0b] hover:bg-amber-400 text-slate-950 font-black text-xs px-6 py-3 rounded-full shadow-lg transition flex items-center space-x-2 transform hover:scale-105">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>{{ $siteSettings['ptsp_helpdesk_btn_text'] ?? 'Hubungi Humas via WhatsApp' }}</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
