@extends('layouts.frontend')

@section('title', 'Layanan Terpadu - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Portal Layanan Terpadu SMA Islam Terpadu Ishlahul Ummah Prabumulih: Izin Kunjungan, Kerjasama Kelembagaan, dan Sewa Menyewa Sarana.')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Layanan Terpadu</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Portal Layanan Terpadu</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Kemudahan akses pelayanan administrasi, perizinan kunjungan, dan kemitraan SMA IT Ishum.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        {{-- LAYANAN 1: IZIN KUNJUNGAN --}}
        <a href="{{ route('layanan.izin') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center group reveal-fade-up">
            <div class="w-20 h-20 rounded-2xl bg-emerald-50 text-[#00913e] flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-[#00913e] group-hover:text-white transition duration-300 shadow-sm">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <h3 class="font-extrabold text-gray-900 text-lg group-hover:text-[#00913e] transition mb-3">
                Izin Kunjungan Sekolah
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Pengajuan permohonan kunjungan dinas, studi banding, observasi edukasi, atau kegiatan penelitian di lingkungan SMA IT Ishum.
            </p>
            <span class="mt-auto inline-flex items-center space-x-1.5 text-xs font-bold text-[#00913e] group-hover:translate-x-1 transition">
                <span>Ajukan Permohonan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </span>
        </a>

        {{-- LAYANAN 2: KERJASAMA --}}
        <a href="{{ route('layanan.kerjasama') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center group reveal-fade-up delay-1">
            <div class="w-20 h-20 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition duration-300 shadow-sm">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <h3 class="font-extrabold text-gray-900 text-lg group-hover:text-amber-600 transition mb-3">
                Permohonan Kerja Sama
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Kemitraan strategis dengan perguruan tinggi, lembaga dakwah, instansi pemerintah, BUMN, perbankan, dan dunia industri.
            </p>
            <span class="mt-auto inline-flex items-center space-x-1.5 text-xs font-bold text-amber-600 group-hover:translate-x-1 transition">
                <span>Ajukan Kemitraan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </span>
        </a>

        {{-- LAYANAN 3: SEWA MENYEWA --}}
        <a href="{{ route('layanan.sewa') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center group reveal-fade-up delay-2">
            <div class="w-20 h-20 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm">
                <i class="fa-solid fa-building-user"></i>
            </div>
            <h3 class="font-extrabold text-gray-900 text-lg group-hover:text-blue-600 transition mb-3">
                Sewa Sarana &amp; Fasilitas
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Penyewaan fasilitas Hall Ishum, sarana olahraga, ruang multimedia, dan perlengkapan kegiatan bagi masyarakat umum.
            </p>
            <span class="mt-auto inline-flex items-center space-x-1.5 text-xs font-bold text-blue-600 group-hover:translate-x-1 transition">
                <span>Informasi &amp; Sewa</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </span>
        </a>
    </div>

    {{-- KONTEN PANDUAN DARI DATABASE --}}
    @if(!empty($page?->content))
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm prose max-w-none text-gray-700 leading-relaxed">
            {!! $page->content !!}
        </div>
    @endif
</div>
@endsection
