@extends('layouts.frontend')

@section('title', 'Download Modul Belajar & E-Book Siswa - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Kumpulan modul kurikulum, e-book materi tahfidz, panduan praktikum sains, dan buku digital gratis untuk siswa SMA IT Ishlahul Ummah Prabumulih.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
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
            Buku panduan siswa, modul tahfidz mutqin, buku saku adab santri, dan materi suplemen sains SMA IT Ishlahul Ummah Prabumulih.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- HEADER KONTEN --}}
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-[#da251c] uppercase tracking-wider block">SUMBER BELAJAR DIGITAL RESMI</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Modul Pembelajaran &amp; Literasi Santri
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Silakan unduh modul resmi pegangan santri dan guru untuk memperluas wawasan keislaman, sains terpadu, dan pembinaan karakter.</p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($ebooks as $idx => $eb)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl border border-gray-100 transition transform hover:-translate-y-1.5 flex flex-col justify-between reveal-fade-up delay-{{ $idx % 3 }}">
                <div class="p-6 sm:p-8 space-y-5">
                    {{-- COVER IMAGE --}}
                    <div class="aspect-[3/4] w-full max-h-80 rounded-2xl overflow-hidden shadow-md bg-slate-100 flex items-center justify-center relative group border border-gray-100">
                        <img src="{{ $eb->cover_image ?: '/uploads/covers/cover-tahfidz-mutqin.webp' }}" 
                             alt="{{ $eb->title }}" 
                             class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-500"
                             onerror="this.src='/uploads/covers/cover-tahfidz-mutqin.webp'">
                        <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $eb->category_type ?? 'E-Book Resmi' }}
                        </span>
                        @if($eb->file_size)
                            <span class="absolute bottom-3 right-3 bg-black/70 backdrop-blur-sm text-white text-[10px] font-medium px-2.5 py-0.5 rounded-lg">
                                <i class="fa-regular fa-file-pdf mr-1 text-red-400"></i>{{ $eb->file_size }}
                            </span>
                        @endif
                    </div>

                    {{-- JUDUL & DESKRIPSI --}}
                    <div>
                        <h3 class="text-base sm:text-lg font-extrabold text-gray-900 leading-snug">
                            {{ $eb->title }}
                        </h3>
                        <p class="text-xs text-gray-600 mt-2.5 line-clamp-3 leading-relaxed font-light">
                            {{ $eb->description ?: 'Buku panduan dan modul pembelajaran resmi siswa SMA IT Ishlahul Ummah Prabumulih berstandar kurikulum JSIT Indonesia.' }}
                        </p>
                    </div>
                </div>

                {{-- FOOTER INFO & BUTTON DOWNLOAD --}}
                <div class="p-6 pt-0 border-t border-gray-100 mt-2 space-y-3">
                    <div class="flex items-center justify-between text-[11px] text-gray-400 pt-3">
                        <span><i class="fa-solid fa-school mr-1 text-[#00913e]"></i>SMA IT Ishum</span>
                        <span><i class="fa-solid fa-download mr-1 text-amber-500"></i>{{ number_format($eb->download_count ?? 150) }} unduhan</span>
                    </div>
                    <a href="{{ route('download.file', $eb->id) }}" class="w-full bg-[#00913e] hover:bg-emerald-800 text-white py-3 rounded-xl text-xs font-bold shadow-md transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-cloud-arrow-down text-sm"></i>
                        <span>Download Modul (PDF)</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                <p>Belum ada e-book yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
