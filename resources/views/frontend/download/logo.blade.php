@extends('layouts.frontend')

@section('title', 'Logo Resmi & Identitas Visual - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Aset resmi logo Pondok Pesantren Raudhatul Ulum Sakatiga, panduan identitas visual, filosofi lambang sekolah, dan unduhan logo resolusi tinggi SVG dan PNG.')

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
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Logo Resmi Pondok Pesantren Raudhatul Ulum Sakatiga</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Identitas visual, filosofi lambang sekolah, panduan palet warna, dan aset unduhan resmi Pondok Pesantren Raudhatul Ulum Sakatiga.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- CARD PREVIEW LOGO UTAMA --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up text-center space-y-8">
        <div class="max-w-2xl mx-auto">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Identitas Visual Resmi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Logo & Lambang Pondok Pesantren Raudhatul Ulum Sakatiga
            </h2>
            <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        </div>

        {{-- DISPLAY EMBLEM LOGO --}}
        <div class="w-64 h-64 sm:w-80 sm:h-80 mx-auto rounded-3xl bg-emerald-50/50 p-8 shadow-inner border border-emerald-100 flex items-center justify-center relative group">
            <img src="/uploads/official/logo-ru-berwarna.png" alt="Logo Resmi Pondok Pesantren Raudhatul Ulum Sakatiga" class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-500">
        </div>

        <div>
            <a href="/uploads/official/master/logo-ru-berwarna.png" download="logo-resmi-ppru-berwarna.png" class="inline-flex items-center bg-[#00913e] hover:bg-emerald-800 text-white px-8 py-3.5 rounded-2xl text-xs sm:text-sm font-bold shadow-lg hover:shadow-xl transition space-x-2 transform hover:scale-105">
                <i class="fa-solid fa-download text-sm"></i>
                <span>Download Logo Resmi Resolusi Tinggi (Format HD Master PNG)</span>
            </a>
            <p class="text-[11px] text-gray-400 mt-2 font-medium">Format Asli Resolusi Ultra HD (2272x2329 px) &bull; Latar Belakang Transparan &bull; Siap Cetak, Spanduk &amp; Desain Grafis</p>
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
                <h3 class="text-xl font-extrabold text-gray-900">Filosofi Lambang Sekolah</h3>
            </div>
            <div class="w-12 h-1 bg-[#00913e] rounded-full"></div>

            <ul class="space-y-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Perisai Segi Lima:</strong>
                        Melambangkan benteng keimanan yang kokoh, rukun Islam, serta kesetiaan pada dasar negara Pancasila.
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Mushaf Al-Qur'an Terbuka:</strong>
                        Sumber mata air ilmu pengetahuan, pedoman adab, dan lentera pembimbing setiap langkah santri.
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-fire-flame-curved"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Obor Sains & Inovasi:</strong>
                        Semangat pantang padam dalam mempelajari sains, matematika, teknologi modern, dan riset ilmiah.
                    </div>
                </li>
                <li class="flex items-start space-x-3">
                    <div class="w-6 h-6 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <strong class="text-gray-900 font-bold block">Bintang Emas:</strong>
                        Cita-cita prestasi puncak, kemuliaan budi pekerti, dan kepemimpinan PPRU masa depan.
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
                <h3 class="text-xl font-extrabold text-gray-900">Palet Warna Resmi</h3>
            </div>
            <div class="w-12 h-1 bg-[#00913e] rounded-full"></div>

            <div class="space-y-4 text-xs sm:text-sm">
                {{-- Hijau Utama --}}
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#00913e] shadow-md flex-shrink-0"></div>
                    <div>
                        <span class="font-extrabold text-gray-900 block text-sm">Hijau PPRU (Dominan)</span>
                        <code class="text-xs text-[#00913e] font-mono font-bold">HEX: #0D6B38</code>
                        <p class="text-[11px] text-gray-500 mt-0.5">Kedamaian spiritual, keberkahan ilmu, dan naungan Qur'ani.</p>
                    </div>
                </div>

                {{-- Oranye Sekunder --}}
                <div class="p-4 rounded-2xl bg-orange-50 border border-orange-200 flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-[#da251c] shadow-md flex-shrink-0"></div>
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

    {{-- KARTU VARIAN UNDUHAN RESMI LENGKAP --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
        <div class="flex items-center justify-between flex-wrap gap-2">
            <div>
                <h3 class="text-lg sm:text-xl font-extrabold text-gray-900">Varian Logo Sekolah Lainnya &amp; Paket Aset Resmi</h3>
                <p class="text-xs text-gray-500 mt-0.5">Seluruh file asli beresolusi tinggi, siap untuk publikasi digital, dokumen resmi, seragam, dan percetakan.</p>
            </div>
            <span class="text-xs bg-emerald-100 text-[#00913e] font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-emerald-600"></i> Master File Asli
            </span>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
            {{-- 1. Logo & Branding Lengkap --}}
            <div class="p-6 rounded-2xl bg-gray-50/90 border border-gray-200 flex flex-col justify-between gap-5 hover:border-emerald-300 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/official/logo-branding-ru.png" alt="Logo & Branding Raudhatul Ulum" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">Logo &amp; Branding Raudhatul Ulum</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">Format PNG Master Resolusi Tinggi (3375x6000 px)</span>
                        <span class="inline-block bg-blue-50 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">Branding Lengkap</span>
                    </div>
                </div>
                <a href="/uploads/official/master/logo-branding-ru.png" download="logo-branding-raudhatul-ulum.png" class="w-full text-center bg-[#00913e] hover:bg-emerald-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Unduh Master Logo &amp; Branding</span>
                </a>
            </div>

            {{-- 2. Branding Monokrom --}}
            <div class="p-6 rounded-2xl bg-gray-50/90 border border-gray-200 flex flex-col justify-between gap-5 hover:border-gray-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-gray-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/official/branding-ru-monokrom.png" alt="Branding RU Monokrom" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">Branding PPRU Monokrom (Hitam-Putih)</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">Format PNG Master Monokrom (3375x4219 px)</span>
                        <span class="inline-block bg-gray-100 text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">Stempel, Kop &amp; Fotokopi</span>
                    </div>
                </div>
                <a href="/uploads/official/master/branding-ru-monokrom.png" download="branding-ppru-monokrom.png" class="w-full text-center bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Unduh Master Monokrom</span>
                </a>
            </div>

            {{-- 3. Logo SPMB 2027 --}}
            <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-200 flex flex-col justify-between gap-5 hover:border-amber-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-amber-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/official/logo-spmb-2027.png" alt="Logo SPMB 2027" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">Logo Resmi SPMB / PPDB 2027</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">Format PNG Master Berwarna (3375x4219 px)</span>
                        <span class="inline-block bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">Penerimaan Santri Baru</span>
                    </div>
                </div>
                <a href="/uploads/official/master/logo-spmb-2027.png" download="logo-spmb-ppru-2027.png" class="w-full text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Unduh Master Logo SPMB</span>
                </a>
            </div>

            {{-- 4. Logo Emblem Lingkaran Berwarna --}}
            <div class="p-6 rounded-2xl bg-emerald-50/50 border border-emerald-200 flex flex-col justify-between gap-5 hover:border-emerald-400 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-20 h-20 rounded-2xl bg-white p-2 border border-emerald-200 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <img src="/uploads/official/logo-ru-berwarna.png" alt="Logo Emblem PPRU" class="max-h-full max-w-full object-contain">
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900 leading-snug">Logo Emblem Utama Berwarna</h4>
                        <span class="text-[11px] text-gray-500 block mt-0.5">Format PNG Transparan Ultra HD (2272x2329 px)</span>
                        <span class="inline-block bg-emerald-100 text-[#00913e] text-[10px] font-bold px-2 py-0.5 rounded-md mt-1.5">Logo Resmi Pesantren</span>
                    </div>
                </div>
                <a href="/uploads/official/master/logo-ru-berwarna.png" download="logo-resmi-ppru-berwarna.png" class="w-full text-center bg-[#00913e] hover:bg-emerald-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Unduh Master Logo Emblem</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
