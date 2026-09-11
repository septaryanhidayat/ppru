@extends('layouts.frontend')

@section('title', 'Logo Resmi & Identitas Visual - SMA IT Plus Robbani')
@section('meta_description', 'Aset resmi logo SMA IT Plus Robbani, panduan identitas visual, filosofi lambang sekolah, dan unduhan logo resolusi tinggi SVG dan PNG.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Logo</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Logo Resmi SMA IT Plus Robbani</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Identitas visual, filosofi lambang sekolah, panduan palet warna, dan aset unduhan resmi SMA IT Plus Robbani.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- CARD PREVIEW LOGO UTAMA --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up text-center space-y-8">
        <div class="max-w-2xl mx-auto">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Identitas Visual Resmi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Logo & Lambang SMA IT Plus Robbani
            </h2>
            <div class="w-16 h-1 bg-[#0d6b38] mx-auto rounded-full mt-3"></div>
        </div>

        {{-- DISPLAY EMBLEM LOGO --}}
        <div class="w-64 h-64 sm:w-80 sm:h-80 mx-auto rounded-3xl bg-emerald-50/50 p-8 shadow-inner border border-emerald-100 flex items-center justify-center relative group">
            <img src="/uploads/logo-robbani-emblem.svg" alt="Logo Resmi SMA IT Plus Robbani" class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-500">
        </div>

        <div>
            <a href="/uploads/logo-robbani-emblem.svg" download="logo-robbani-emblem.svg" class="inline-flex items-center bg-[#0d6b38] hover:bg-emerald-800 text-white px-8 py-3.5 rounded-2xl text-xs sm:text-sm font-bold shadow-lg hover:shadow-xl transition space-x-2 transform hover:scale-105">
                <i class="fa-solid fa-download text-sm"></i>
                <span>Download Lambang Emblem (Format Vektor SVG)</span>
            </a>
            <p class="text-[11px] text-gray-400 mt-2 font-medium">Format Asli Vektor SVG Resolusi Tinggi &bull; Latar Belakang Transparan &bull; Siap Cetak & Desain</p>
        </div>
    </article>

    {{-- FILOSOFI DAN WARNA RESMI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- FILOSOFI MAKNA --}}
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 reveal-fade-up space-y-5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0d6b38] flex items-center justify-center font-bold text-base shadow-inner">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900">Filosofi Lambang Sekolah</h3>
            </div>
            <div class="w-12 h-1 bg-[#0d6b38] rounded-full"></div>

            <ul class="space-y-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 text-[#0d6b38] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Perisai Segi Lima:</strong>
                        Melambangkan benteng keimanan yang kokoh, rukun Islam, serta kesetiaan pada dasar negara Pancasila.
                    </div>
                </div>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Mushaf Al-Qur'an Terbuka:</strong>
                        Sumber mata air ilmu pengetahuan, pedoman adab, dan lentera pembimbing setiap langkah santri.
                    </div>
                </div>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-fire-flame-curved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Obor Sains & Inovasi:</strong>
                        Semangat pantang padam dalam mempelajari sains, matematika, teknologi modern, dan riset ilmiah.
                    </div>
                </div>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Bintang Emas:</strong>
                        Cita-cita prestasi puncak, kemuliaan budi pekerti, dan kepemimpinan Robbani masa depan.
                    </div>
                </div>
            </ul>
        </div>

        {{-- PALET WARNA RESMI --}}
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 reveal-fade-up delay-1 space-y-5">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center font-bold text-base shadow-inner">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900">Palet Warna Resmi</h3>
            </div>
            <div class="w-12 h-1 bg-[#0d6b38] rounded-full"></div>

            <div class="space-y-4 text-xs sm:text-sm">
                {{-- Hijau Utama --}}
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#0d6b38] shadow-md flex-shrink-0"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">Hijau Robbani (Dominan)</span>
                        <code class="text-xs text-[#0d6b38] font-mono font-bold">HEX: #0D6B38</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">Kedamaian spiritual, keberkahan ilmu, dan naungan Qur'ani.</p>
                    </div>
                </div>

                {{-- Oranye Sekunder --}}
                <div class="p-4 rounded-2xl bg-orange-50 border border-orange-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#f97316] shadow-md flex-shrink-0"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">Oranye Dinamis (Sekunder)</span>
                        <code class="text-xs text-orange-600 font-mono font-bold">HEX: #F97316</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">Semangat muda, kreativitas, energi riset, dan optimisme prestasi.</p>
                    </div>
                </div>

                {{-- Emas Keagungan --}}
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#eab308] shadow-md flex-shrink-0"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">Emas Prestasi</span>
                        <code class="text-xs text-amber-700 font-mono font-bold">HEX: #EAB308</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">Kemuliaan akhlakul karimah dan prestasi akademik membanggakan.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- KARTU VARIAN UNDUHAN LAINNYA --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <h3 class="text-lg sm:text-xl font-extrabold text-gray-900">Varian Logo Sekolah Lainnya</h3>
            <span class="text-xs bg-emerald-100 text-[#0d6b38] font-bold px-3 py-1 rounded-full">Format Vektor & Raster</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Logo Header Horizontal --}}
            <div class="p-6 rounded-2xl bg-gray-50/80 border border-gray-200 flex flex-col justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-14 rounded-xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/logo-robbani.svg" alt="Logo Horizontal" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900">Logo Horizontal (Header & Surat)</h4>
                        <span class="text-[11px] text-gray-400">Vektor SVG Transparan</span>
                    </div>
                </div>
                <a href="/uploads/logo-robbani.svg" download="logo-robbani-horizontal.svg" class="w-full text-center bg-[#0d6b38] hover:bg-emerald-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-[11px]"></i>
                    <span>Unduh Logo Horizontal</span>
                </a>
            </div>

            {{-- Emblem Lingkaran --}}
            <div class="p-6 rounded-2xl bg-gray-50/80 border border-gray-200 flex flex-col justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-14 rounded-xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/logo-robbani-emblem.svg" alt="Logo Emblem" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900">Emblem Bulat (Badge / Stempel)</h4>
                        <span class="text-[11px] text-gray-400">Vektor SVG Transparan</span>
                    </div>
                </div>
                <a href="/uploads/logo-robbani-emblem.svg" download="logo-robbani-emblem.svg" class="w-full text-center bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-[11px]"></i>
                    <span>Unduh Emblem Bulat</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
