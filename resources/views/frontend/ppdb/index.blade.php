@extends('layouts.frontend')

@section('title', 'PSB Online Terpadu ' . ($settings['year'] ?? '2026/2027') . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Penerimaan Santri Baru (PSB/PPDB) Online Terpadu Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga Tahun Pelajaran ' . ($settings['year'] ?? '2026/2027') . '. Pilihan unit: MARU, MATSARU, MIRU, MATQULARU, TAKIRU, SMPIT RU, SMAIT RU, dan STITRU.')

@section('content')
<div class="bg-slate-50 font-['Poppins',sans-serif]">

    {{-- 1. HERO SECTION PESANTREN --}}
    <section class="relative bg-gradient-to-br from-[#072418] via-[#004d25] to-[#041d13] text-white overflow-hidden py-14 sm:py-20 lg:py-24 border-b border-emerald-800/40">
        {{-- Background Image Overlay with subtle zoom --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $settings['hero_bg'] ?? '/uploads/official/drone-danau-telok-putih.webp' }}" alt="Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full h-full object-cover object-center opacity-25 filter blur-[1px] transform scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-[#072418] via-[#072418]/80 to-[#072418]/60"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto space-y-6">
                
                {{-- Logo Resmi SPMB PPRU --}}
                <div class="flex justify-center -mb-1">
                    <div class="inline-flex items-center justify-center bg-white/95 backdrop-blur-md rounded-3xl p-3.5 sm:p-5 shadow-2xl border-2 border-amber-300 transform hover:scale-105 transition duration-300">
                        <img src="/uploads/official/logo-spmb-2027.png" alt="Logo Resmi SPMB 2027 Pondok Pesantren Raudhatul Ulum" class="h-24 sm:h-32 md:h-40 w-auto object-contain drop-shadow-md">
                    </div>
                </div>

                {{-- Badges --}}
                <div class="inline-flex flex-wrap items-center justify-center gap-2">
                    <span class="inline-flex items-center gap-2 bg-emerald-500/20 text-emerald-300 border border-emerald-400/40 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Pendaftaran Santri Baru TP {{ $settings['year'] ?? '2026/2027' }}</span>
                    </span>
                    <span class="bg-[#f59e0b] text-slate-950 font-black text-xs px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                        {{ $settings['wave'] ?? 'Gelombang 1 Aktif' }}
                    </span>
                    @if(!empty($settings['promo']))
                        <span class="bg-red-600/90 text-white font-black text-xs px-3 py-1.5 rounded-full shadow-sm border border-red-400/40 flex items-center gap-1.5">
                            <i class="fa-solid fa-tag text-[10px]"></i>
                            <span>{{ $settings['promo'] }}</span>
                        </span>
                    @endif
                </div>

                {{-- Headline --}}
                <div class="space-y-2">
                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight uppercase leading-tight drop-shadow-md">
                        {{ $settings['hero_title'] ?? 'PSB PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA OGAN ILIR' }}
                    </h1>
                    <p class="text-xs sm:text-sm md:text-base text-emerald-100/90 font-medium max-w-2xl mx-auto leading-relaxed pt-2">
                        {{ $settings['tagline'] ?? "Kaderisasi Generasi Khairu Ummah: Beraqidah Lurus, Berakhlak Mulia, Cerdas Sains, Mandiri, dan Berwawasan Global dengan Muadalah Al-Azhar Kairo Mesir." }}
                    </p>
                </div>

                {{-- Stat Counters --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-3xl mx-auto pt-2">
                    <div class="bg-black/35 backdrop-blur-md border border-emerald-500/20 rounded-2xl p-3.5 text-center">
                        <span class="block text-xl sm:text-2xl font-black text-[#fcd116]">{{ $settings['stat_1_val'] ?? '8 Unit' }}</span>
                        <span class="text-[11px] text-emerald-200 font-medium">{{ $settings['stat_1_lbl'] ?? 'Jenjang Terpadu' }}</span>
                    </div>
                    <div class="bg-black/35 backdrop-blur-md border border-emerald-500/20 rounded-2xl p-3.5 text-center">
                        <span class="block text-xl sm:text-2xl font-black text-[#fcd116]">{{ $settings['stat_2_val'] ?? 'Muadalah' }}</span>
                        <span class="text-[11px] text-emerald-200 font-medium">{{ $settings['stat_2_lbl'] ?? 'Al-Azhar Kairo' }}</span>
                    </div>
                    <div class="bg-black/35 backdrop-blur-md border border-emerald-500/20 rounded-2xl p-3.5 text-center">
                        <span class="block text-xl sm:text-2xl font-black text-[#fcd116]">{{ $settings['stat_3_val'] ?? '30 Juz' }}</span>
                        <span class="text-[11px] text-emerald-200 font-medium">{{ $settings['stat_3_lbl'] ?? 'Tahfidz Mutqin' }}</span>
                    </div>
                    <div class="bg-black/35 backdrop-blur-md border border-emerald-500/20 rounded-2xl p-3.5 text-center">
                        <span class="block text-xl sm:text-2xl font-black text-[#fcd116]">{{ $settings['stat_4_val'] ?? '24 Jam' }}</span>
                        <span class="text-[11px] text-emerald-200 font-medium">{{ $settings['stat_4_lbl'] ?? 'Pembinaan Asrama' }}</span>
                    </div>
                </div>

                {{-- Action CTA Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
                    <a href="{{ route('ppdb.form') }}" class="inline-flex items-center space-x-2.5 bg-gradient-to-r from-[#f59e0b] to-[#d97706] hover:from-[#d97706] hover:to-[#b45309] text-slate-950 font-black px-7 py-3.5 rounded-2xl text-xs sm:text-sm transition duration-300 shadow-xl shadow-amber-500/20 transform hover:scale-105">
                        <i class="fa-solid fa-file-pen text-base"></i>
                        <span>Daftar PSB Online Sekarang</span>
                    </a>
                    <a href="#katalog-unit" class="inline-flex items-center space-x-2 bg-emerald-800/80 hover:bg-emerald-700 text-white font-bold px-6 py-3.5 rounded-2xl text-xs sm:text-sm transition border border-emerald-500/30">
                        <i class="fa-solid fa-building-columns text-sm"></i>
                        <span>Pilih Unit Pendidikan</span>
                    </a>
                    @php
                        $cleanHotline = preg_replace('/[^0-9]/', '', (string) ($settings['hotline_phone'] ?? '081278901950'));
                        if (str_starts_with($cleanHotline, '0')) {
                            $cleanHotline = '62' . substr($cleanHotline, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $cleanHotline }}?text={{ urlencode('Assalamu\'alaikum Panitia PSB Pondok Pesantren Raudhatul Ulum Sakatiga, saya ingin konsultasi pendaftaran santri baru.') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold px-5 py-3.5 rounded-2xl text-xs sm:text-sm transition shadow-md">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>WhatsApp Panitia</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- 2. KATALOG MULTI-UNIT PENDIDIKAN PESANTREN --}}
    <section id="katalog-unit" class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10" x-data="{ selectedCategory: 'all' }">
        
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="inline-block text-xs font-black uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200">
                {{ $settings['unit_badge'] ?? 'Multi-Unit Pendidikan Terpadu' }}
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ $settings['unit_title'] ?? 'PILIH UNIT PENDIDIKAN TUJUAN' }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ $settings['unit_desc'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga menaungi 8 unit pendidikan resmi yang terstruktur mulai dari Madrasah, TK Islam, Sekolah Islam Terpadu (JSIT), hingga Perguruan Tinggi Islam.' }}
            </p>

            {{-- Category Filter Tabs (Madrasah, TK, Sekolah IT, Sekolah Tinggi) --}}
            <div class="flex flex-wrap items-center justify-center gap-2 pt-4">
                <button 
                    @click="selectedCategory = 'all'" 
                    :class="selectedCategory === 'all' ? 'bg-[#00843d] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
                    Semua Unit (8)
                </button>
                <button 
                    @click="selectedCategory = 'Madrasah'" 
                    :class="selectedCategory === 'Madrasah' ? 'bg-[#00843d] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
                    1. Madrasah (4)
                </button>
                <button 
                    @click="selectedCategory = 'TK Islam'" 
                    :class="selectedCategory === 'TK Islam' ? 'bg-[#00843d] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
                    2. TK Islam (1)
                </button>
                <button 
                    @click="selectedCategory = 'Sekolah IT'" 
                    :class="selectedCategory === 'Sekolah IT' ? 'bg-[#00843d] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
                    3. Sekolah IT (2)
                </button>
                <button 
                    @click="selectedCategory = 'Sekolah Tinggi'" 
                    :class="selectedCategory === 'Sekolah Tinggi' ? 'bg-[#00843d] text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition cursor-pointer">
                    4. Sekolah Tinggi (1)
                </button>
            </div>
        </div>

        {{-- Units Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(isset($unitPendidikans) && $unitPendidikans->isNotEmpty())
                @foreach($unitPendidikans as $u)
                    @php
                        $cleanTitle = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $u->name));
                    @endphp
                    <div 
                        x-show="selectedCategory === 'all' || selectedCategory === '{{ $u->category_type }}'" 
                        x-transition
                        class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/80 flex flex-col justify-between transition-all duration-300 transform hover:-translate-y-1 group">
                        
                        <div>
                            {{-- Image Cover --}}
                            <div class="relative h-44 overflow-hidden bg-slate-900">
                                <img src="{{ $u->thumbnail_url }}" alt="{{ $cleanTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>
                                
                                {{-- Badges --}}
                                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                    <span class="bg-[#00843d] text-white text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider shadow">
                                        {{ $u->category_type }}
                                    </span>
                                </div>
                                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                    <span class="text-[11px] font-extrabold text-[#fcd116] bg-black/60 px-2.5 py-0.5 rounded-md backdrop-blur-xs">
                                        {{ $u->badge }}
                                    </span>
                                    @if($u->short_name)
                                        <span class="text-[11px] font-bold bg-white/20 px-2 py-0.5 rounded-md backdrop-blur-xs">
                                            {{ $u->short_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5 space-y-3">
                                <h3 class="font-black text-base text-slate-900 group-hover:text-[#00843d] transition-colors line-clamp-2 leading-snug">
                                    {{ $cleanTitle }}
                                </h3>
                                
                                <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                    {{ $u->description }}
                                </p>

                                <div class="pt-2 border-t border-slate-100 text-[11px] text-slate-500 space-y-1">
                                    <div class="flex items-center gap-1.5 text-slate-700 font-semibold">
                                        <i class="fa-solid fa-graduation-cap text-[#00843d]"></i>
                                        <span class="truncate">{{ $u->curriculum }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-user-tie text-slate-400"></i>
                                        <span class="truncate">Pimpinan: {{ $u->head_name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Actions --}}
                        <div class="p-5 pt-0 flex items-center gap-2">
                            <a href="{{ route('ppdb.form') }}?unit={{ $u->slug }}" class="flex-1 bg-[#00843d] hover:bg-[#006a31] text-white text-xs font-extrabold py-2.5 px-3 rounded-xl text-center transition shadow-sm">
                                <span>Daftar Unit Ini</span>
                            </a>
                            <a href="{{ route('pendidikan.show', $u->slug) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 px-3 rounded-xl transition" title="Lihat Profil Unit">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            @endif
        </div>

    </section>

    {{-- BROSUR & POSTER RESMI PSB (DIGITAL SHOWCASE) --}}
    @if(!empty($settings['flyer_image']))
    <section class="py-12 bg-slate-900 text-white border-y border-emerald-800/40 relative overflow-hidden" x-data="{ showFlyerModal: false }">
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-br from-emerald-950 via-[#072418] to-slate-950 rounded-3xl p-6 sm:p-10 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8 border-2 border-emerald-500/30">
                <div class="space-y-4 max-w-xl text-center md:text-left">
                    <span class="inline-flex items-center gap-2 bg-[#f59e0b] text-slate-950 px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-wider shadow-sm">
                        <i class="fa-solid fa-file-arrow-down"></i>
                        <span>Brosur Resmi Pesantren</span>
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-snug">
                        {{ $settings['flyer_title'] ?? 'Brosur & Poster Resmi PSB Online' }}
                    </h3>
                    <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
                        {{ $settings['flyer_desc'] ?? 'Dapatkan panduan lengkap penerimaan santri baru, profil keunggulan, rincian biaya, serta tata cara pendaftaran santri baru.' }}
                    </p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 pt-2">
                        <button @click="showFlyerModal = true" class="inline-flex items-center gap-2 bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 text-xs sm:text-sm font-black px-6 py-3 rounded-xl transition shadow-lg cursor-pointer transform hover:scale-105">
                            <i class="fa-solid fa-expand"></i>
                            <span>Buka Ukuran Penuh</span>
                        </button>
                        <a href="{{ $settings['flyer_image'] }}" download="Brosur-PSB-PPRU.webp" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold px-5 py-3 rounded-xl transition border border-white/20">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh Brosur</span>
                        </a>
                    </div>
                </div>
                <div class="shrink-0 w-full max-w-xs md:max-w-sm rounded-2xl overflow-hidden shadow-2xl border-2 border-emerald-400/40 transform hover:scale-[1.02] transition cursor-pointer group" @click="showFlyerModal = true">
                    <img src="{{ $settings['flyer_image'] }}" alt="{{ $settings['flyer_title'] ?? 'Brosur PSB' }}" class="w-full h-auto object-cover group-hover:brightness-105 transition">
                </div>
            </div>
        </div>

        {{-- Lightbox Modal Brosur --}}
        <div x-show="showFlyerModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-sm" style="display: none;" x-cloak>
            <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-700" @click.away="showFlyerModal = false">
                <div class="p-4 bg-slate-950 flex items-center justify-between border-b border-slate-800 text-white">
                    <span class="text-xs font-bold text-emerald-300">{{ $settings['flyer_title'] ?? 'Brosur Resmi PSB' }}</span>
                    <button @click="showFlyerModal = false" class="text-slate-400 hover:text-white text-lg cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-3 max-h-[82vh] overflow-y-auto flex items-center justify-center bg-black">
                    <img src="{{ $settings['flyer_image'] }}" alt="Flyer PSB" class="max-w-full h-auto rounded-xl">
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 3. ALUR KERJA PENDAFTARAN PESANTREN (VISUAL STEPPER) --}}
    <section class="py-14 sm:py-20 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200">
                    Proses Pendaftaran Terstruktur
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $settings['alur_title'] ?? 'ALUR PENDAFTARAN SANTRI BARU (PSB)' }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    {{ $settings['alur_desc'] ?? '5 Tahapan mudah dan transparan pendaftaran santri baru Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                </p>
            </div>

            {{-- 5 Steps Visual Timeline --}}
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                
                {{-- Step 1 --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between relative hover:border-emerald-500 transition">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#00843d] font-black text-base flex items-center justify-center">
                            1
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $settings['step_1_title'] ?? 'Pendaftaran Online' }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $settings['step_1_desc'] ?? 'Mengisi formulir PSB melalui portal website resmi ini dengan data calon santri dan orang tua secara lengkap.' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-200/80 text-[10px] text-slate-500 font-medium">
                        {{ $settings['step_1_sub'] ?? 'Portal aktif 24 jam' }}
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between relative hover:border-emerald-500 transition">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 font-black text-base flex items-center justify-center">
                            2
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $settings['step_2_title'] ?? 'Transfer & Berkas' }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $settings['step_2_desc'] ?? 'Membayar biaya pendaftaran ke rekening BSI resmi pesantren dan mengunggah bukti transfer serta berkas KK/Akta.' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-200/80 text-[10px] text-slate-500 font-medium">
                        {{ $settings['step_2_sub'] ?? 'Biaya Rp 250.000,- via Bank BSI' }}
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between relative hover:border-emerald-500 transition">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-800 font-black text-base flex items-center justify-center">
                            3
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $settings['step_3_title'] ?? 'Ujian Seleksi & Wawancara' }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $settings['step_3_desc'] ?? 'Mengikuti tes potensi akademik, tes membaca Al-Qur\'an/tahfidz, dan wawancara kesiapan orang tua serta santri.' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-200/80 text-[10px] text-slate-500 font-medium">
                        {{ $settings['step_3_sub'] ?? 'Jadwal diinfokan via WhatsApp' }}
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between relative hover:border-emerald-500 transition">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-800 font-black text-base flex items-center justify-center">
                            4
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $settings['step_4_title'] ?? 'Pengumuman Kelulusan' }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $settings['step_4_desc'] ?? 'Mengecek hasil seleksi kelulusan melalui website dan notifikasi resmi WhatsApp panitia PSB.' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-200/80 text-[10px] text-slate-500 font-medium">
                        {{ $settings['step_4_sub'] ?? 'Daftar ulang & fitting seragam' }}
                    </div>
                </div>

                {{-- Step 5 --}}
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col justify-between relative hover:border-emerald-500 transition">
                    <div class="space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-base flex items-center justify-center">
                            5
                        </div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $settings['step_5_title'] ?? 'Masuk Asrama (P2SB)' }}</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $settings['step_5_desc'] ?? 'Kedatangan santri ke asrama, serah terima dengan Mudir dan pengasuh, serta mengikuti Pekan Perkenalan Santri Baru (P2SB).' }}
                        </p>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-200/80 text-[10px] text-slate-500 font-medium">
                        {{ $settings['step_5_sub'] ?? 'Khutbatul Arsy & pembagian kamar santri' }}
                    </div>
                </div>

            </div>

            @if(!empty($settings['alur']))
                <div class="mt-8 bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-3">
                    <div class="flex items-center space-x-2 text-[#00843d] font-black text-sm">
                        <i class="fa-solid fa-clipboard-list text-base"></i>
                        <span>Petunjuk &amp; Alur Lengkap Pendaftaran:</span>
                    </div>
                    <div class="text-xs sm:text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                        {{ $settings['alur'] }}
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- 4. JALUR PENDAFTARAN & KERINGANAN BIAYA --}}
    <section class="py-14 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <div class="text-center max-w-3xl mx-auto space-y-2">
            <span class="text-xs font-black uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200">
                Pilihan Jalur Masuk
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ $settings['jalur_title'] ?? 'JALUR PENERIMAAN SANTRI BARU' }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600">
                {{ $settings['jalur_desc'] ?? 'Tersedia berbagai pilihan jalur penerimaan sesuai bakat, hafalan Al-Qur\'an, dan prestasi santri' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Jalur 1: Reguler --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-3 hover:border-emerald-500 transition">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <h3 class="font-extrabold text-base text-slate-900">{{ $settings['jalur_reguler_title'] ?? 'Jalur Reguler (Mandiri)' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['mandiri'] ?? 'Jalur umum melalui tahapan tes potensi akademik, tes membaca Al-Qur\'an (tahsin & tajwid), dan wawancara kesiapan santri & orang tua.' }}
                </p>
                <div class="text-[11px] text-[#00843d] font-bold pt-2 border-t border-slate-100 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Terbuka untuk semua jenjang</span>
                </div>
            </div>

            {{-- Jalur 2: Tahfidz Qur'an --}}
            <div class="bg-white rounded-3xl p-6 border-2 border-emerald-400 shadow-md space-y-3 relative overflow-hidden">
                <div class="absolute top-3 right-3 bg-amber-400 text-slate-950 text-[9px] font-black px-2 py-0.5 rounded-md uppercase">
                    Favorit
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-book-quran"></i>
                </div>
                <h3 class="font-extrabold text-base text-slate-900">{{ $settings['jalur_tahfidz_title'] ?? 'Jalur Hafizh Al-Qur\'an' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['tahfidz'] ?? 'Keringanan biaya dan beasiswa khusus santri penghafal Al-Qur\'an minimal 3 Juz s/d 30 Juz mutqin, serta bimbingan sanad Al-Qur\'an di MATQULARU.' }}
                </p>
                <div class="text-[11px] text-[#00843d] font-bold pt-2 border-t border-slate-100 flex items-center gap-1">
                    <i class="fa-solid fa-award text-[10px]"></i>
                    <span>Beasiswa SPP &amp; Sanad Mutqin</span>
                </div>
            </div>

            {{-- Jalur 3: Prestasi Sains & Olahraga --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-3 hover:border-emerald-500 transition">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <h3 class="font-extrabold text-base text-slate-900">{{ $settings['jalur_prestasi_title'] ?? 'Jalur Prestasi Sains' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['prestasi'] ?? 'Bebas tes tulis akademik bagi pemenang juara 1, 2, atau 3 lomba sains (KSM/OSN), MTQ/MHQ, pidato, dan olahraga tingkat kota, provinsi, atau nasional.' }}
                </p>
                <div class="text-[11px] text-[#00843d] font-bold pt-2 border-t border-slate-100 flex items-center gap-1">
                    <i class="fa-solid fa-certificate text-[10px]"></i>
                    <span>Bebas Tes Akademik</span>
                </div>
            </div>

            {{-- Jalur 4: Alumni Internal --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-3 hover:border-emerald-500 transition">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-people-roof"></i>
                </div>
                <h3 class="font-extrabold text-base text-slate-900">{{ $settings['jalur_alumni_title'] ?? 'Jalur Alumni Internal' }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $settings['alumni'] ?? 'Khusus bagi lulusan MTs Raudhatul Ulum dan SMPIT Raudhatul Ulum yang melanjutkan studi ke MARU atau SMAIT RU dengan potongan biaya uang pangkal.' }}
                </p>
                <div class="text-[11px] text-[#00843d] font-bold pt-2 border-t border-slate-100 flex items-center gap-1">
                    <i class="fa-solid fa-hand-holding-dollar text-[10px]"></i>
                    <span>Potongan Biaya Masuk Khusus</span>
                </div>
            </div>

        </div>

    </section>

    {{-- 5. REKENING RESMI & INFORMASI BIAYA FORMULIR --}}
    <section class="py-14 sm:py-20 bg-slate-900 text-white relative overflow-hidden" x-data="{ copied: false }">
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                
                {{-- Rekening BSI Box --}}
                <div class="bg-gradient-to-br from-[#064e3b] via-[#043d2e] to-[#022c22] rounded-3xl p-7 sm:p-9 border-2 border-emerald-400/40 shadow-2xl space-y-5">
                    <div class="flex items-center justify-between">
                        <span class="bg-[#f59e0b] text-slate-950 text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider">
                            Rekening Resmi Panitia PSB
                        </span>
                        <span class="text-xs font-bold text-emerald-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Verifikasi Resmi Pesantren</span>
                        </span>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                            Pembayaran Biaya Formulir ({{ $settings['registration_fee'] ?? 'Rp 250.000,-' }})
                        </h3>
                        <p class="text-xs text-emerald-200">
                            Transfer biaya formulir pendaftaran melalui nomor rekening resmi di bawah ini:
                        </p>
                    </div>

                    <div class="bg-black/40 backdrop-blur-md rounded-2xl p-5 border border-emerald-400/30 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-emerald-200 font-extrabold uppercase tracking-wider">Bank Syariah Indonesia (BSI)</span>
                            <span class="text-xs text-amber-300 font-black bg-emerald-950 px-2.5 py-0.5 rounded-lg border border-emerald-500/40">
                                Kode Bank: {{ $settings['bank_code'] ?? '451' }}
                            </span>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-[#fcd116] font-mono tracking-wider">
                            {{ $settings['bank_account'] ?? '7011304251' }}
                        </div>
                        <div class="text-xs text-emerald-100 font-medium pt-2 flex items-center justify-between border-t border-white/10">
                            <span>Atas Nama Rekening:</span>
                            <strong class="text-white font-black text-sm uppercase">{{ $settings['bank_holder'] ?? 'YL. Fatmawati' }}</strong>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <button 
                            @click="navigator.clipboard.writeText('{{ $settings['bank_account'] ?? '7011304251' }}'); copied = true; setTimeout(() => copied = false, 2500)"
                            class="inline-flex items-center space-x-2 bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 text-xs font-black px-5 py-3 rounded-xl transition shadow-lg cursor-pointer">
                            <i class="fa-regular" :class="copied ? 'fa-check' : 'fa-copy'"></i>
                            <span x-text="copied ? 'Nomor BSI Tersalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                        <span class="text-xs text-emerald-300 font-medium flex items-center gap-1.5">
                            <i class="fa-solid fa-receipt text-amber-400"></i>
                            <span>Simpan bukti transfer untuk upload formulir</span>
                        </span>
                    </div>
                </div>

                {{-- Jam Operasional & Layanan Sekretariat --}}
                <div class="space-y-5">
                    <div class="space-y-2">
                        <span class="text-xs font-black uppercase tracking-wider text-[#fcd116]">Sekretariat Panitia</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                            LAYANAN KONSULTASI &amp; PENDAFTARAN
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">
                            Panitia SPMB siap melayani pertanyaan seputar kurikulum, kehidupan santri di asrama, dan panduan pengisian formulir online maupun offline di sekretariat.
                        </p>
                    </div>

                    <div class="bg-slate-800/80 rounded-2xl p-5 border border-slate-700/80 space-y-3 text-xs text-gray-300">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold shrink-0 mt-0.5">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <strong class="block text-white">Jam Kerja Pelayanan:</strong>
                                <span>{{ $settings['operational_weekday'] ?? "Senin – Jum'at: Pukul 08.00 – 15.00 WIB" }}</span><br>
                                <span>{{ $settings['operational_weekend'] ?? 'Sabtu: Pukul 08.00 – 12.00 WIB' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 pt-2 border-t border-slate-700">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold shrink-0 mt-0.5">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <strong class="block text-white">Lokasi Sekretariat:</strong>
                                <span>{{ $settings['secretariat'] ?? 'Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kecamatan Indralaya, Ogan Ilir, Sumatera Selatan' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 pt-2 border-t border-slate-700">
                            <div class="w-7 h-7 rounded-lg bg-green-500/20 text-green-400 flex items-center justify-center font-bold shrink-0 mt-0.5">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <strong class="block text-white">Hotline Panitia:</strong>
                                <span>{{ $settings['hotline_phone'] ?? '0812-7890-1950' }} ({{ $settings['hotline_name'] ?? 'Panitia SPMB PPRU' }})</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- 6. VIDEO PROFIL PESANTREN --}}
    @if(!empty($settings['youtube_id']))
    <section class="py-14 sm:py-20 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="text-center space-y-2">
            <span class="text-xs font-black uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200">
                Dokumentasi &amp; Suasana Asrama
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                SEKILAS KEHIDUPAN SANTRI RAUDHATUL ULUM
            </h2>
            <p class="text-xs sm:text-sm text-slate-600">
                {{ $settings['video_desc'] ?? 'Saksikan lingkungan belajar, masjid agung, asrama santri, laboratorium, dan aktivitas harian di Pondok Pesantren Raudhatul Ulum Sakatiga' }}
            </p>
        </div>

        <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-xl border border-slate-200 overflow-hidden space-y-4">
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-950 shadow-2xl border border-slate-800">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $settings['youtube_id'] }}?rel=0" 
                    title="{{ $settings['video_title'] ?? 'Video Profil Resmi Pondok Pesantren Raudhatul Ulum Sakatiga' }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-2">
                <div class="flex items-center space-x-3 text-left">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $settings['video_title'] ?? 'Video Profil & Dokumentasi Pesantren' }}</h4>
                        <p class="text-xs text-slate-500 font-medium">{{ $settings['video_channel'] ?? 'Channel Resmi TVRU Sakatiga (@tvrusakatiga)' }}</p>
                    </div>
                </div>
                <a href="https://www.youtube.com/watch?v={{ $settings['youtube_id'] }}" target="_blank" class="inline-flex items-center space-x-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition flex-shrink-0">
                    <span>Tonton di YouTube</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- 7. FAQ & CALL TO ACTION FINAL --}}
    <section class="py-14 sm:py-20 bg-emerald-50/60 border-t border-emerald-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10" x-data="{ openFaq: 0 }">
            
            <div class="text-center space-y-2">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $settings['faq_title'] ?? 'PERTANYAAN SERING DIAJUKAN (FAQ)' }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-600">
                    {{ $settings['faq_desc'] ?? 'Jawaban seputar kehidupan berasrama dan pendaftaran santri baru di PPRU Sakatiga' }}
                </p>
            </div>

            @if(!empty($faqs))
            <div class="space-y-3">
                @foreach($faqs as $index => $faq)
                <div class="bg-white rounded-2xl border border-emerald-200 overflow-hidden shadow-xs">
                    <button @click="openFaq = (openFaq === {{ $index }} ? null : {{ $index }})" class="w-full px-5 py-4 flex items-center justify-between text-left font-bold text-xs sm:text-sm text-slate-900 cursor-pointer">
                        <span>{!! strip_tags($faq['question'], '<b><strong><i><em><u><center><span>') !!}</span>
                        <i class="fa-solid" :class="openFaq === {{ $index }} ? 'fa-chevron-up text-[#00843d]' : 'fa-chevron-down text-gray-400'"></i>
                    </button>
                    <div x-show="openFaq === {{ $index }}" x-collapse class="px-5 pb-4 text-xs text-slate-600 leading-relaxed border-t border-emerald-50 pt-3">
                        {!! strip_tags($faq['answer'], '<p><br><b><strong><i><em><u><center><ul><ol><li><a><span>') !!}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Closing Banner --}}
            <div class="bg-gradient-to-r from-[#00843d] to-[#072418] text-white rounded-3xl p-8 text-center space-y-4 shadow-xl">
                <h3 class="text-xl sm:text-2xl font-black tracking-tight">
                    {{ $settings['closing_title'] ?? 'SIAP MEMULAI LANGKAH MENJADI SANTRI KHOIRU UMMAH?' }}
                </h3>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-xl mx-auto leading-relaxed">
                    {{ $settings['closing_desc'] ?? 'Jangan lewatkan kesempatan emas bergabung dengan keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga. Kuota kelas terbatas setiap tahunnya.' }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('ppdb.form') }}" class="inline-flex items-center space-x-2 bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 font-black px-8 py-3.5 rounded-2xl text-xs sm:text-sm transition shadow-lg transform hover:scale-105">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>{{ $settings['closing_btn_text'] ?? 'Isi Formulir Pendaftaran Sekarang' }}</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
