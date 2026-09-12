@extends('layouts.frontend')

@section('title', 'Mars JSIT Indonesia - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Lagu resmi Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia di SMA IT Ishlahul Ummah Prabumulih, membina generasi beriman, cerdas, berakhlak mulia, dan mandiri.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-emerald-200 font-semibold">Mars JSIT Indonesia</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Lagu kebanggaan civitas akademika SMA IT Ishlahul Ummah Prabumulih sebagai bagian dari Jaringan Sekolah Islam Terpadu (JSIT) Indonesia dalam membina generasi Rabbani yang unggul dan berdaya saing global.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- MARS JSIT INDONESIA --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 space-y-8 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-bold text-[#da251c] uppercase tracking-wider block">Lagu Resmi Sekolah Islam Terpadu</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">MARS JSIT INDONESIA</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Pedoman semangat santri & pendidik Jaringan Sekolah Islam Terpadu
                </p>
            </div>
            @php
                $marsDownload = $audioFiles->firstWhere('file_path', '/uploads/mars-ishum.mp3') ?? $audioFiles->first();
            @endphp
            @if($marsDownload)
            <a href="{{ route('download.file', $marsDownload->id) }}" class="inline-flex items-center bg-[#da251c] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex-shrink-0">
                <i class="fa-solid fa-download mr-2"></i> Unduh Audio Mars ({{ $marsDownload->file_size }})
            </a>
            @endif
        </div>

        {{-- Audio Player --}}
        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-[#00913e] flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fa-solid fa-music"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Audio Mars JSIT Indonesia</h4>
                    <p class="text-xs text-gray-500">Format MP3 • Kualitas Studio</p>
                </div>
            </div>
            <audio controls class="w-full sm:w-80">
                <source src="{{ asset('uploads/mars-ishum.mp3') }}" type="audio/mpeg">
                Browser Anda tidak mendukung pemutar audio HTML5.
            </audio>
        </div>

        {{-- Lirik Mars Resmi --}}
        <div class="bg-emerald-50/50 p-8 rounded-2xl border border-emerald-100 text-center space-y-5 text-sm sm:text-base text-gray-800 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-extrabold text-emerald-800 uppercase tracking-widest mb-6">LIRIK MARS JSIT INDONESIA</h3>

            <p>
                Harum semerbak semerbak mewangi<br>
                Kuntum-kuntum melati di taman<br>
                Merekah mekar berseri-seri<br>
                Menyambut mentari pagi
            </p>

            <p>
                Kami generasi dambaan umat<br>
                Tunas harapan bumi pertiwi<br>
                Bersama JSIT kita melangkah<br>
                Menuju ridho Ilahi
            </p>

            <div class="py-3">
                <span class="inline-block text-xs font-bold text-white bg-[#da251c] px-4 py-1 rounded-full uppercase tracking-wider mb-3 font-sans">Reff</span>
                <p class="font-bold text-gray-900 text-base sm:text-lg">
                    Bangkitlah putra-putri Indonesia<br>
                    Gelorakan semangat membaja<br>
                    Tegakkan nilai-nilai Islam mulia<br>
                    Raih prestasi jayakan dunia
                </p>
            </div>

            <p class="font-semibold text-emerald-950">
                Dengan iman, ilmu, dan amal<br>
                Berpadu dalam dada<br>
                Jaringan Sekolah Islam Terpadu<br>
                Untuk Indonesia gemilang!
            </p>
        </div>

        {{-- Profil JSIT Indonesia --}}
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-200/70">
            <h4 class="text-base font-bold text-emerald-900 flex items-center mb-3">
                <i class="fa-solid fa-shield-halved text-[#00913e] mr-2"></i> 10 Karakter Santri JSIT (Muwashofat)
            </h4>
            <p class="text-xs text-gray-600 mb-4 leading-relaxed">
                SMA IT Ishlahul Ummah Prabumulih mendidik santri berlandaskan 10 standar kompetensi lulusan Sekolah Islam Terpadu:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-700">
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">1</span>
                    <span><strong>Salimul Aqidah</strong> (Aqidah yang Lurus)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">2</span>
                    <span><strong>Shahihul Ibadah</strong> (Ibadah yang Benar)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">3</span>
                    <span><strong>Matinul Khuluq</strong> (Akhlak yang Kokoh)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">4</span>
                    <span><strong>Qadirun 'alal Kasbi</strong> (Mandiri & Berjiwa Usaha)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">5</span>
                    <span><strong>Mutsaqqaful Fikri</strong> (Berwawasan Luas)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">6</span>
                    <span><strong>Qawiyyul Jismi</strong> (Jasmani yang Sehat & Tangguh)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">7</span>
                    <span><strong>Mujahidun Linafsihi</strong> (Mampu Mengendalikan Diri)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">8</span>
                    <span><strong>Munazzhamun fi Syu'unihi</strong> (Tertib dalam Urusan)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">9</span>
                    <span><strong>Haritsun 'ala Waqtihi</strong> (Disiplin Waktu)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white/80 p-2.5 rounded-xl border border-emerald-100">
                    <span class="w-5 h-5 rounded-full bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center">10</span>
                    <span><strong>Nafi'un Lighairihi</strong> (Bermanfaat bagi Sesama)</span>
                </div>
            </div>
        </div>
    </article>

</div>
@endsection
