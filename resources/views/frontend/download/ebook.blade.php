@extends('layouts.frontend')

@section('title', 'Download Modul Belajar & E-Book Siswa - SMA IT Plus Robbani')
@section('meta_description', 'Kumpulan modul kurikulum, e-book materi tahfidz, panduan praktikum sains, dan buku digital gratis untuk siswa SMA IT Plus Robbani.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Modul & E-Book</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">E-Book & Modul Pembelajaran Digital</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Buku panduan siswa, modul tahfidz mutqin, buku saku adab santri, dan materi suplemen sains SMA IT Plus Robbani.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- HEADER KONTEN --}}
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">SUMBER BELAJAR DIGITAL</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Modul Pembelajaran & Literasi Siswa
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Silakan unduh materi pegangan siswa untuk memperluas wawasan keilmuan Islam, sains, dan bahasa.</p>
        <div class="w-16 h-1 bg-[#0d6b38] mx-auto rounded-full mt-3"></div>
    </div>

    @php
        $ebooks = [
            [
                'id' => 4,
                'title' => "Panduan Mutqin Tahfidz Al-Qur'an",
                'cover' => '/uploads/tahfidz-robbani.jpg',
                'description' => "Modul panduan tahfidz mutqin SMA IT Plus Robbani yang memuat metode menghafal cepat, jadwal muraja'ah harian, target juz kelulusan, dan adab penghafal Al-Qur'an.",
                'pdf' => '#',
                'badge' => 'Tahfidz Al-Qur\'an'
            ],
            [
                'id' => 5,
                'title' => "Buku Saku Adab & Karakter Santri Robbani",
                'cover' => '/uploads/campus-robbani.jpg',
                'description' => "Panduan pembiasaan karakter islami, akhlak kepada guru dan orang tua, adab pergaulan islami di asrama dan sekolah, serta panduan ibadah yaumiyah.",
                'pdf' => '#',
                'badge' => 'Bina Karakter'
            ],
            [
                'id' => 6,
                'title' => "Petunjuk Praktikum Laboratorium Sains Terpadu",
                'cover' => '/uploads/lab-robbani.jpg',
                'description' => "Buku pedoman eksperimen laboratorium biologi, kimia, dan fisika untuk siswa kelas X-XII yang dilengkapi keselamatan kerja lab dan metode analisis data ilmiah.",
                'pdf' => '#',
                'badge' => 'Sains & Riset'
            ],
            [
                'id' => 7,
                'title' => "Kurikulum Pembinaan Da'i Muda & Khitabah",
                'cover' => '/uploads/library-robbani.jpg',
                'description' => "Kumpulan materi public speaking, retorika dakwah, dasar-dasar aqidah dan fiqih dakwah praktis untuk melatih santri menjadi da'i dan orator andal.",
                'pdf' => '#',
                'badge' => 'Kepemimpinan'
            ],
            [
                'id' => 8,
                'title' => "Buku Saku Kosakata Bahasa Arab & Inggris",
                'cover' => '/uploads/campus-robbani.jpg',
                'description' => "Modul percakapan bilingual harian asrama santri untuk mempercepat penguasaan active speaking bahasa Arab dan Inggris.",
                'pdf' => '#',
                'badge' => 'Bilingual Program'
            ],
            [
                'id' => 9,
                'title' => "Panduan Sukses Seleksi SNBT & Masuk PTN",
                'cover' => '/uploads/lab-robbani.jpg',
                'description' => "Strategi sukses menembus perguruan tinggi negeri impian, tips penalaran matematika, literasi bahasa, dan pembahasan soal SNBT terstandar.",
                'pdf' => '#',
                'badge' => 'Karier & PTN'
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($ebooks as $idx => $eb)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl border border-gray-100 transition transform hover:-translate-y-1.5 flex flex-col justify-between reveal-fade-up delay-{{ $idx % 3 }}">
                <div class="p-6 sm:p-8 space-y-5">
                    {{-- COVER IMAGE --}}
                    <div class="h-60 rounded-2xl overflow-hidden shadow-md bg-gray-100 flex items-center justify-center relative group">
                        <img src="{{ $eb['cover'] }}" alt="{{ $eb['title'] }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 bg-[#0d6b38] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow">
                            {{ $eb['badge'] }}
                        </span>
                    </div>

                    {{-- JUDUL & DESKRIPSI --}}
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900 leading-snug">
                            {{ $eb['title'] }}
                        </h3>
                        <p class="text-xs text-gray-600 mt-2 line-clamp-4 leading-relaxed font-light">
                            {{ $eb['description'] }}
                        </p>
                    </div>
                </div>

                {{-- BUTTON DOWNLOAD --}}
                <div class="p-6 pt-0 border-t border-gray-100 mt-2">
                    <a href="{{ $eb['pdf'] }}" class="w-full bg-[#0d6b38] hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold shadow transition flex items-center justify-center space-x-2">
                        <i class="fa-regular fa-circle-down text-base"></i>
                        <span>Download Modul (PDF)</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
