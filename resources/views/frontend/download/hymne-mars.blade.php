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
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    Pedoman semangat santri & pendidik Jaringan Sekolah Islam Terpadu (JSIT) se-Indonesia
                </p>
            </div>
            <a href="https://www.youtube.com/watch?v=ijDo1wLvZ6w" target="_blank" class="inline-flex items-center bg-[#da251c] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex-shrink-0">
                <i class="fa-brands fa-youtube mr-2 text-sm"></i> Tonton di YouTube
            </a>
        </div>

        {{-- Video Player Mars JSIT Indonesia --}}
        <div class="bg-slate-950 rounded-2xl p-3 sm:p-4 border border-slate-800 space-y-3">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-2xl">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/ijDo1wLvZ6w?rel=0" 
                    title="Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia Resmi" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="flex items-center justify-between px-2 text-xs text-slate-300">
                <span class="flex items-center"><i class="fa-solid fa-music text-emerald-400 mr-2"></i> Mars Resmi JSIT Indonesia</span>
                <span class="text-slate-400">Audio & Lirik Resmi</span>
            </div>
        </div>

        {{-- Lirik Mars Resmi JSIT Indonesia --}}
        <div class="bg-emerald-50/70 p-8 sm:p-10 rounded-2xl border border-emerald-200 text-center space-y-6 text-sm sm:text-base text-gray-900 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-black text-emerald-900 uppercase tracking-widest mb-6">
                LIRIK MARS RESMI JSIT INDONESIA
            </h3>

            <p class="text-slate-800">
                Dengan berbekal semangat kami melangkah<br>
                Menjalin ukhuwah dengan tekad membaja<br>
                Menuju mutu pendidikan Indonesia<br>
                Melahirkan generasi cerdas mulia <span class="font-bold text-xs text-emerald-700">(2x)</span>
            </p>

            <div class="py-3">
                <span class="inline-block text-xs font-bold text-white bg-[#da251c] px-4 py-1 rounded-full uppercase tracking-wider mb-3 font-sans shadow-sm">Reff</span>
                <p class="font-bold text-gray-900 text-base sm:text-lg">
                    Kami Jaringan Sekolah Islam Terpadu<br>
                    Sambut masa depan wajah Indonesia baru<br>
                    Bersama tinggikan martabat dan citra guru<br>
                    Indonesia pasti maju! <span class="text-xs text-red-700">(pasti maju)</span>
                </p>
            </div>

            <p class="text-slate-800">
                Di sinilah tempat kami berkarya<br>
                Menggapai harapan meraih cita-cita<br>
                Sebagai penggerak dan pemberdaya bangsa<br>
                Wujudkan masyarakat cerdas dan sejahtera <span class="font-bold text-xs text-emerald-700">(2x)</span>
            </p>

            <div class="py-3">
                <span class="inline-block text-xs font-bold text-white bg-[#00913e] px-4 py-1 rounded-full uppercase tracking-wider mb-3 font-sans shadow-sm">Reff</span>
                <p class="font-bold text-gray-900 text-base sm:text-lg">
                    Kami Jaringan Sekolah Islam Terpadu<br>
                    Bangkit serentak menyongsong peradaban baru<br>
                    Bulatkan tekad dan cita membangun bangsa<br>
                    Indonesia maju dan berjaya! <span class="text-xs text-emerald-700">(dan berjaya)</span>
                </p>
            </div>
        </div>

        {{-- Profil JSIT Indonesia --}}
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 sm:p-8 border border-emerald-200">
            <h4 class="text-base font-bold text-emerald-950 flex items-center mb-3">
                <i class="fa-solid fa-shield-halved text-[#00913e] mr-2"></i> 10 Karakter Santri JSIT (Muwashofat)
            </h4>
            <p class="text-xs text-gray-700 mb-4 leading-relaxed font-medium">
                Sebagai sekolah anggota resmi Jaringan Sekolah Islam Terpadu (JSIT) Indonesia, SMA IT Ishlahul Ummah Prabumulih menanamkan 10 standar kompetensi lulusan santri:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-800">
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">1</span>
                    <span><strong>Salimul Aqidah</strong> (Aqidah yang Lurus)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">2</span>
                    <span><strong>Shahihul Ibadah</strong> (Ibadah yang Benar)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">3</span>
                    <span><strong>Matinul Khuluq</strong> (Akhlak yang Kokoh)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">4</span>
                    <span><strong>Qadirun 'alal Kasbi</strong> (Mandiri &amp; Berjiwa Usaha)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">5</span>
                    <span><strong>Mutsaqqaful Fikri</strong> (Berwawasan Luas &amp; Cerdas)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">6</span>
                    <span><strong>Qawiyyul Jismi</strong> (Jasmani yang Sehat &amp; Tangguh)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">7</span>
                    <span><strong>Mujahidun Linafsihi</strong> (Mampu Mengendalikan Diri)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">8</span>
                    <span><strong>Munazzhamun fi Syu'unihi</strong> (Tertib dalam Segala Urusan)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">9</span>
                    <span><strong>Haritsun 'ala Waqtihi</strong> (Disiplin Terhadap Waktu)</span>
                </div>
                <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">10</span>
                    <span><strong>Nafi'un Lighairihi</strong> (Bermanfaat Bagi Sesama)</span>
                </div>
            </div>
        </div>
    </article>

</div>
@endsection
