@extends('layouts.frontend')

@php
    $marsPageTitle = $siteSettings['mars_page_title'] ?? $siteSettings['hymne_mars_hero_title'] ?? 'Mars JSIT Indonesia';
    $marsHeroSubtitle = $siteSettings['mars_hero_subtitle'] ?? $siteSettings['hymne_mars_hero_desc'] ?? 'Lagu resmi Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia di Pondok Pesantren Raudhatul Ulum Sakatiga, membina generasi beriman, cerdas, berakhlak mulia, dan mandiri.';
    $marsTitle = $siteSettings['mars_title'] ?? $siteSettings['hymne_mars_title'] ?? 'MARS JSIT INDONESIA';
    $marsBadge = $siteSettings['mars_badge'] ?? $siteSettings['hymne_mars_badge'] ?? 'Lagu Resmi Sekolah Islam Terpadu';
    $marsSubtitle = $siteSettings['mars_subtitle'] ?? $siteSettings['hymne_mars_subtitle'] ?? 'Pedoman semangat santri & pendidik Jaringan Sekolah Islam Terpadu (JSIT) se-Indonesia';
    $ytUrl = $siteSettings['mars_youtube_url'] ?? $siteSettings['hymne_mars_youtube_url'] ?? 'https://www.youtube.com/watch?v=ijDo1wLvZ6w';
    $ytBtn = $siteSettings['mars_youtube_btn_text'] ?? $siteSettings['hymne_mars_youtube_btn_text'] ?? 'Tonton di YouTube';

    $ytEmbed = $siteSettings['mars_youtube_embed'] ?? '';
    if (empty($ytEmbed)) {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $ytUrl, $match)) {
            $ytEmbed = 'https://www.youtube.com/embed/' . $match[1] . '?rel=0';
        } else {
            $ytEmbed = $ytUrl;
        }
    }

    $audioUrl = $siteSettings['mars_audio_url'] ?? $siteSettings['hymne_mars_audio_url'] ?? '';
    $lyricsHeading = $siteSettings['mars_lyrics_heading'] ?? $siteSettings['hymne_mars_lyrics_title'] ?? 'LIRIK MARS RESMI JSIT INDONESIA';
    $customLyrics = $siteSettings['mars_lyrics_content'] ?? '';
    $charsTitle = $siteSettings['mars_characters_title'] ?? '10 Karakter Santri JSIT (Muwashofat)';
    $charsSubtitle = $siteSettings['mars_characters_subtitle'] ?? 'Sebagai sekolah anggota resmi Jaringan Sekolah Islam Terpadu (JSIT) Indonesia, Pondok Pesantren Raudhatul Ulum Sakatiga menanamkan 10 standar kompetensi lulusan santri:';

    $defaultChars = [
        1 => ['Salimul Aqidah', 'Aqidah yang Lurus'],
        2 => ['Shahihul Ibadah', 'Ibadah yang Benar'],
        3 => ['Matinul Khuluq', 'Akhlak yang Kokoh'],
        4 => ['Qadirun \'alal Kasbi', 'Mandiri & Berjiwa Usaha'],
        5 => ['Mutsaqqaful Fikri', 'Berwawasan Luas & Cerdas'],
        6 => ['Qawiyyul Jismi', 'Jasmani yang Sehat & Tangguh'],
        7 => ['Mujahidun Linafsihi', 'Mampu Mengendalikan Diri'],
        8 => ['Munazzhamun fi Syu\'unihi', 'Tertib dalam Segala Urusan'],
        9 => ['Haritsun \'ala Waqtihi', 'Disiplin Terhadap Waktu'],
        10 => ['Nafi\'un Lighairihi', 'Bermanfaat Bagi Sesama'],
    ];
@endphp

@section('title', $marsPageTitle . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $marsHeroSubtitle)

@section('content')

{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-emerald-200 font-semibold">{{ $marsPageTitle }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $marsPageTitle }}</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            {{ $marsHeroSubtitle }}
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- MARS JSIT INDONESIA --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 space-y-8 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-bold text-[#da251c] uppercase tracking-wider block">{{ $marsBadge }}</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $marsTitle }}</h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    {{ $marsSubtitle }}
                </p>
            </div>
            @if(!empty($ytUrl))
                <a href="{{ $ytUrl }}" target="_blank" class="inline-flex items-center bg-[#da251c] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex-shrink-0">
                    <i class="fa-brands fa-youtube mr-2 text-sm"></i> {{ $ytBtn }}
                </a>
            @endif
        </div>

        {{-- Video Player Mars JSIT Indonesia --}}
        <div class="bg-slate-950 rounded-2xl p-3 sm:p-4 border border-slate-800 space-y-3">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-2xl">
                <iframe 
                    class="w-full h-full"
                    src="{{ $ytEmbed }}" 
                    title="{{ $marsTitle }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="flex items-center justify-between px-2 text-xs text-slate-300">
                <span class="flex items-center"><i class="fa-solid fa-music text-emerald-400 mr-2"></i> {{ $marsTitle }}</span>
                <span class="text-slate-400">Audio &amp; Lirik Resmi</span>
            </div>
        </div>

        {{-- Audio Player (Jika Diunggah di Admin) --}}
        @if(!empty($audioUrl))
            <div class="bg-emerald-900/90 text-white rounded-2xl p-5 border border-emerald-700 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-headphones"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Audio Rekaman Mars</h4>
                        <span class="text-[10px] text-emerald-200">Putar audio langsung tanpa membuka video</span>
                    </div>
                </div>
                <audio controls class="w-full sm:w-72 h-9 rounded-lg">
                    <source src="{{ asset($audioUrl) }}" type="audio/mpeg">
                    Browser Anda tidak mendukung pemutar audio.
                </audio>
            </div>
        @endif

        {{-- Lirik Mars Resmi JSIT Indonesia --}}
        <div class="bg-emerald-50/70 p-8 sm:p-10 rounded-2xl border border-emerald-200 text-center space-y-6 text-sm sm:text-base text-gray-900 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-black text-emerald-900 uppercase tracking-widest mb-6">
                {{ $lyricsHeading }}
            </h3>

            @if(!empty(trim($customLyrics)))
                <div class="text-slate-800 space-y-4 font-serif leading-relaxed text-sm sm:text-base whitespace-pre-line">
                    {!! nl2br(e($customLyrics)) !!}
                </div>
            @elseif(!empty($siteSettings['hymne_mars_lyrics_stanza_1']))
                <div class="text-slate-800 space-y-4 font-serif leading-relaxed text-sm sm:text-base">
                    <p class="whitespace-pre-line">{!! nl2br(e($siteSettings['hymne_mars_lyrics_stanza_1'])) !!}</p>
                    @if(!empty($siteSettings['hymne_mars_lyrics_reff_1']))
                        <div class="py-3">
                            <span class="inline-block text-xs font-bold text-white bg-[#da251c] px-4 py-1 rounded-full uppercase tracking-wider mb-3 font-sans shadow-sm">Reff</span>
                            <p class="font-bold text-gray-900 text-base sm:text-lg whitespace-pre-line">{!! nl2br(e($siteSettings['hymne_mars_lyrics_reff_1'])) !!}</p>
                        </div>
                    @endif
                    @if(!empty($siteSettings['hymne_mars_lyrics_stanza_2']))
                        <p class="whitespace-pre-line">{!! nl2br(e($siteSettings['hymne_mars_lyrics_stanza_2'])) !!}</p>
                    @endif
                    @if(!empty($siteSettings['hymne_mars_lyrics_reff_2']))
                        <div class="py-3">
                            <span class="inline-block text-xs font-bold text-white bg-[#00913e] px-4 py-1 rounded-full uppercase tracking-wider mb-3 font-sans shadow-sm">Reff</span>
                            <p class="font-bold text-gray-900 text-base sm:text-lg whitespace-pre-line">{!! nl2br(e($siteSettings['hymne_mars_lyrics_reff_2'])) !!}</p>
                        </div>
                    @endif
                </div>
            @else
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
            @endif
        </div>

        {{-- Profil JSIT Indonesia --}}
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 sm:p-8 border border-emerald-200">
            <h4 class="text-base font-bold text-emerald-950 flex items-center mb-3">
                <i class="fa-solid fa-shield-halved text-[#00913e] mr-2"></i> {{ $charsTitle }}
            </h4>
            <p class="text-xs text-gray-700 mb-4 leading-relaxed font-medium">
                {{ $charsSubtitle }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-800">
                @for($i = 1; $i <= 10; $i++)
                    @php
                        $cTitle = $siteSettings["mars_char_{$i}_title"] ?? ($defaultChars[$i][0] ?? '');
                        $cDesc = $siteSettings["mars_char_{$i}_desc"] ?? ($defaultChars[$i][1] ?? '');
                    @endphp
                    <div class="flex items-center space-x-2 bg-white p-3 rounded-xl border border-emerald-100 shadow-xs">
                        <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-bold text-[11px] flex items-center justify-center flex-shrink-0">{{ $i }}</span>
                        <span><strong>{{ $cTitle }}</strong> ({{ $cDesc }})</span>
                    </div>
                @endfor
            </div>
        </div>
    </article>

</div>
@endsection
