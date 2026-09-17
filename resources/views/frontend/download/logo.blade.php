@extends('layouts.frontend')

@php
    $logoPageTitle = $siteSettings['logo_page_title'] ?? $siteSettings['logo_hero_title'] ?? 'Logo Resmi & Identitas Visual';
    $logoHeroSubtitle = $siteSettings['logo_hero_subtitle'] ?? $siteSettings['logo_hero_desc'] ?? 'Aset resmi logo Pondok Pesantren Raudhatul Ulum Sakatiga, panduan identitas visual, filosofi lambang sekolah, dan unduhan logo resolusi tinggi SVG dan PNG.';
    $logoSectionTag = $siteSettings['logo_section_tag'] ?? $siteSettings['logo_preview_badge'] ?? 'Identitas Visual Resmi';
    $logoSectionTitle = $siteSettings['logo_section_title'] ?? $siteSettings['logo_preview_title'] ?? 'Logo & Lambang Pondok Pesantren Raudhatul Ulum Sakatiga';

    $masterPreview = $siteSettings['logo_preview_image'] ?? $siteSettings['logo_master_preview'] ?? '/uploads/official/logo-ru-berwarna.png';
    $masterDownload = $siteSettings['logo_download_url'] ?? $siteSettings['logo_master_download'] ?? '/uploads/official/master/logo-ru-berwarna.png';
    $downloadBtnText = $siteSettings['logo_download_btn_text'] ?? 'Download Logo Resmi Resolusi Tinggi (Format HD Master PNG)';
    $downloadNote = $siteSettings['logo_download_note'] ?? 'Format Asli Resolusi Ultra HD (2272x2329 px) • Latar Belakang Transparan • Siap Cetak, Spanduk & Desain Grafis';

    $hex1 = $siteSettings['logo_color_1_hex'] ?? '#0D6B38';
    $hex2 = $siteSettings['logo_color_2_hex'] ?? '#F97316';
    $hex3 = $siteSettings['logo_color_3_hex'] ?? '#EAB308';
@endphp

@section('title', $logoPageTitle . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $logoHeroSubtitle)

@section('content')

{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Logo</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $logoPageTitle }}</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            {{ $logoHeroSubtitle }}
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- CARD PREVIEW LOGO UTAMA --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up text-center space-y-8">
        <div class="max-w-2xl mx-auto">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">{{ $logoSectionTag }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                {{ $logoSectionTitle }}
            </h2>
            <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        </div>

        {{-- DISPLAY EMBLEM LOGO --}}
        <div class="w-64 h-64 sm:w-80 sm:h-80 mx-auto rounded-3xl bg-emerald-50/50 p-8 shadow-inner border border-emerald-100 flex items-center justify-center relative group">
            <img src="{{ asset($masterPreview) }}" alt="{{ $logoSectionTitle }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/official/logo-ru-berwarna.png'">
        </div>

        <div>
            <a href="{{ asset($masterDownload) }}" download="{{ $siteSettings['logo_download_filename'] ?? 'logo-resmi-ppru-berwarna.png' }}" class="inline-flex items-center bg-[#00913e] hover:bg-emerald-800 text-white px-8 py-3.5 rounded-2xl text-xs sm:text-sm font-bold shadow-lg hover:shadow-xl transition space-x-2 transform hover:scale-105">
                <i class="fa-solid fa-download text-sm"></i>
                <span>{{ $downloadBtnText }}</span>
            </a>
            <p class="text-[11px] text-gray-400 mt-2 font-medium">{{ $downloadNote }}</p>
        </div>
    </article>

    {{-- FILOSOFI DAN WARNA RESMI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- FILOSOFI MAKNA --}}
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 reveal-fade-up space-y-5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-base shadow-inner">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900">{{ $siteSettings['logo_philo_title'] ?? 'Filosofi Lambang Sekolah' }}</h3>
            </div>
            <div class="w-12 h-1 bg-[#00913e] rounded-full"></div>

            <ul class="space-y-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">{{ $siteSettings['logo_philo_1_title'] ?? 'Perisai Segi Lima' }}:</strong>
                        {{ $siteSettings['logo_philo_1_desc'] ?? 'Melambangkan benteng keimanan yang kokoh, rukun Islam, serta kesetiaan pada dasar negara Pancasila.' }}
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">{{ $siteSettings['logo_philo_2_title'] ?? 'Mushaf Al-Qur\'an Terbuka' }}:</strong>
                        {{ $siteSettings['logo_philo_2_desc'] ?? 'Sumber mata air ilmu pengetahuan, pedoman adab, dan lentera pembimbing setiap langkah santri.' }}
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-fire-flame-curved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">{{ $siteSettings['logo_philo_3_title'] ?? 'Obor Sains & Inovasi' }}:</strong>
                        {{ $siteSettings['logo_philo_3_desc'] ?? 'Semangat pantang padam dalam mempelajari sains, matematika, teknologi modern, dan riset ilmiah.' }}
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">{{ $siteSettings['logo_philo_4_title'] ?? 'Bintang Emas' }}:</strong>
                        {{ $siteSettings['logo_philo_4_desc'] ?? 'Cita-cita prestasi puncak, kemuliaan budi pekerti, dan kepemimpinan PPRU masa depan.' }}
                    </div>
                </li>
            </ul>
        </div>

        {{-- PALET WARNA RESMI --}}
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 reveal-fade-up delay-1 space-y-5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center font-bold text-base shadow-inner">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900">{{ $siteSettings['logo_color_title'] ?? 'Palet Warna Resmi' }}</h3>
            </div>
            <div class="w-12 h-1 bg-[#00913e] rounded-full"></div>

            <div class="space-y-4 text-xs sm:text-sm">
                {{-- Hijau Utama --}}
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl shadow-md flex-shrink-0" style="background-color: {{ $hex1 }}"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">{{ $siteSettings['logo_color_1_name'] ?? 'Hijau PPRU (Dominan)' }}</span>
                        <code class="text-xs text-[#00913e] font-mono font-bold">HEX: {{ $hex1 }}</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $siteSettings['logo_color_1_desc'] ?? 'Kedamaian spiritual, keberkahan ilmu, dan naungan Qur\'ani.' }}</p>
                    </div>
                </div>

                {{-- Oranye Sekunder --}}
                <div class="p-4 rounded-2xl bg-orange-50 border border-orange-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl shadow-md flex-shrink-0" style="background-color: {{ $hex2 }}"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">{{ $siteSettings['logo_color_2_name'] ?? 'Oranye Dinamis (Sekunder)' }}</span>
                        <code class="text-xs text-orange-600 font-mono font-bold">HEX: {{ $hex2 }}</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $siteSettings['logo_color_2_desc'] ?? 'Semangat muda, kreativitas, energi riset, dan optimisme prestasi.' }}</p>
                    </div>
                </div>

                {{-- Emas Keagungan --}}
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl shadow-md flex-shrink-0" style="background-color: {{ $hex3 }}"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">{{ $siteSettings['logo_color_3_name'] ?? 'Emas Prestasi' }}</span>
                        <code class="text-xs text-amber-700 font-mono font-bold">HEX: {{ $hex3 }}</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">{{ $siteSettings['logo_color_3_desc'] ?? 'Kemuliaan akhlakul karimah dan prestasi akademik membanggakan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- KARTU VARIAN UNDUHAN RESMI LENGKAP --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div>
                <h3 class="text-lg sm:text-xl font-extrabold text-gray-900">{{ $siteSettings['logo_variants_title'] ?? 'Varian Logo Sekolah Lainnya & Paket Aset Resmi' }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $siteSettings['logo_variants_subtitle'] ?? 'Seluruh file asli beresolusi tinggi, siap untuk publikasi digital, dokumen resmi, seragam, dan percetakan.' }}</p>
            </div>
            <span class="text-xs bg-emerald-100 text-[#00913e] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-emerald-600"></i> {{ $siteSettings['logo_variants_badge'] ?? 'Master File Asli' }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
            {{-- 1. Logo & Branding Lengkap --}}
            @php
                $v1Title = $siteSettings['logo_var_1_title'] ?? 'Logo & Branding Raudhatul Ulum';
                $v1Preview = $siteSettings['logo_var_1_preview'] ?? '/uploads/official/logo-branding-ru.png';
                $v1Format = $siteSettings['logo_var_1_format'] ?? 'Format PNG Master Resolusi Tinggi (3375x6000 px)';
                $v1Tag = $siteSettings['logo_var_1_tag'] ?? 'Branding Lengkap';
                $v1File = $siteSettings['logo_var_1_file'] ?? '/uploads/official/master/logo-branding-ru.png';
                $v1Btn = $siteSettings['logo_var_1_btn'] ?? 'Unduh Master Logo & Branding';
            @endphp
            <div class="p-6 rounded-2xl bg-gray-50/90 border border-gray-200 flex flex-col justify-between gap-5 hover:border-emerald-300 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="{{ asset($v1Preview) }}" alt="{{ $v1Title }}" class="max-h-full max-w-full object-contain" onerror="this.src='/uploads/official/logo-branding-ru.png'">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">{{ $v1Title }}</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">{{ $v1Format }}</span>
                        <span class="inline-block bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">{{ $v1Tag }}</span>
                    </div>
                </div>
                <a href="{{ asset($v1File) }}" download="{{ $siteSettings['logo_var_1_filename'] ?? 'logo-branding-raudhatul-ulum.png' }}" class="w-full text-center bg-[#00913e] hover:bg-emerald-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>{{ $v1Btn }}</span>
                </a>
            </div>

            {{-- 2. Branding Monokrom --}}
            @php
                $v2Title = $siteSettings['logo_var_2_title'] ?? 'Branding PPRU Monokrom (Hitam-Putih)';
                $v2Preview = $siteSettings['logo_var_2_preview'] ?? '/uploads/official/branding-ru-monokrom.png';
                $v2Format = $siteSettings['logo_var_2_format'] ?? 'Format PNG Master Monokrom (3375x4219 px)';
                $v2Tag = $siteSettings['logo_var_2_tag'] ?? 'Stempel, Kop & Fotokopi';
                $v2File = $siteSettings['logo_var_2_file'] ?? '/uploads/official/master/branding-ru-monokrom.png';
                $v2Btn = $siteSettings['logo_var_2_btn'] ?? 'Unduh Master Monokrom';
            @endphp
            <div class="p-6 rounded-2xl bg-gray-50/90 border border-gray-200 flex flex-col justify-between gap-5 hover:border-gray-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="{{ asset($v2Preview) }}" alt="{{ $v2Title }}" class="max-h-full max-w-full object-contain" onerror="this.src='/uploads/official/branding-ru-monokrom.png'">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">{{ $v2Title }}</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">{{ $v2Format }}</span>
                        <span class="inline-block bg-gray-100 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">{{ $v2Tag }}</span>
                    </div>
                </div>
                <a href="{{ asset($v2File) }}" download="{{ $siteSettings['logo_var_2_filename'] ?? 'branding-ppru-monokrom.png' }}" class="w-full text-center bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>{{ $v2Btn }}</span>
                </a>
            </div>

            {{-- 3. Logo SPMB 2027 --}}
            @php
                $v3Title = $siteSettings['logo_var_3_title'] ?? 'Logo Resmi SPMB / PPDB 2027';
                $v3Preview = $siteSettings['logo_var_3_preview'] ?? '/uploads/official/logo-spmb-2027.png';
                $v3Format = $siteSettings['logo_var_3_format'] ?? 'Format PNG Master Berwarna (3375x4219 px)';
                $v3Tag = $siteSettings['logo_var_3_tag'] ?? 'Penerimaan Santri Baru';
                $v3File = $siteSettings['logo_var_3_file'] ?? '/uploads/official/master/logo-spmb-2027.png';
                $v3Btn = $siteSettings['logo_var_3_btn'] ?? 'Unduh Master Logo SPMB';
            @endphp
            <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-200 flex flex-col justify-between gap-5 hover:border-amber-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-amber-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="{{ asset($v3Preview) }}" alt="{{ $v3Title }}" class="max-h-full max-w-full object-contain" onerror="this.src='/uploads/official/logo-spmb-2027.png'">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">{{ $v3Title }}</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">{{ $v3Format }}</span>
                        <span class="inline-block bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">{{ $v3Tag }}</span>
                    </div>
                </div>
                <a href="{{ asset($v3File) }}" download="{{ $siteSettings['logo_var_3_filename'] ?? 'logo-spmb-ppru-2027.png' }}" class="w-full text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>{{ $v3Btn }}</span>
                </a>
            </div>

            {{-- 4. Logo Emblem Lingkaran Berwarna --}}
            @php
                $v4Title = $siteSettings['logo_var_4_title'] ?? 'Logo Emblem Utama Berwarna';
                $v4Preview = $siteSettings['logo_var_4_preview'] ?? '/uploads/official/logo-ru-berwarna.png';
                $v4Format = $siteSettings['logo_var_4_format'] ?? 'Format PNG Transparan Ultra HD (2272x2329 px)';
                $v4Tag = $siteSettings['logo_var_4_tag'] ?? 'Logo Resmi Pesantren';
                $v4File = $siteSettings['logo_var_4_file'] ?? '/uploads/official/master/logo-ru-berwarna.png';
                $v4Btn = $siteSettings['logo_var_4_btn'] ?? 'Unduh Master Logo Emblem';
            @endphp
            <div class="p-6 rounded-2xl bg-emerald-50/50 border border-emerald-200 flex flex-col justify-between gap-5 hover:border-emerald-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-emerald-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="{{ asset($v4Preview) }}" alt="{{ $v4Title }}" class="max-h-full max-w-full object-contain" onerror="this.src='/uploads/official/logo-ru-berwarna.png'">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">{{ $v4Title }}</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">{{ $v4Format }}</span>
                        <span class="inline-block bg-emerald-100 text-[#00913e] text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">{{ $v4Tag }}</span>
                    </div>
                </div>
                <a href="{{ asset($v4File) }}" download="{{ $siteSettings['logo_var_4_filename'] ?? 'logo-resmi-ppru-berwarna.png' }}" class="w-full text-center bg-[#00913e] hover:bg-emerald-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>{{ $v4Btn }}</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
