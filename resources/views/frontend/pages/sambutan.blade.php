@extends('layouts.frontend')

@section('title', 'Kata Sambutan Mudir / Sambutan Kepala Sekolah - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Sambutan resmi Mudir Pondok Pesantren Raudhatul Ulum Sakatiga, KH. Tol\'at Wafa Ahmad, Lc.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-gray-900 via-emerald-900 to-[#00843d] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-gray-300 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-[#fcd116] font-semibold">Kata Sambutan Mudir Pesantren</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kata Sambutan Mudir Pesantren</h1>
        <p class="text-sm text-gray-200 mt-2 font-light">
            Amanat dan risalah pendidikan dari Pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        @php
            $kepsekPhoto = '/uploads/kh-tolat-wafa-ahmad.webp';
            $kepsekName = 'KH. Tol\'at Wafa Ahmad, Lc.';
            $kepsekPos = 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga';
        @endphp

        {{-- PROFIL PIMPINAN HEADER --}}
        <div class="flex flex-col md:flex-row items-center gap-8 mb-8 pb-8 border-b border-gray-100 text-center md:text-left">
            <div class="w-48 h-56 sm:w-56 sm:h-68 rounded-3xl overflow-hidden shadow-2xl border-4 border-white ring-4 ring-emerald-100 flex-shrink-0 bg-emerald-50 mx-auto md:mx-0">
                <img src="{{ asset($kepsekPhoto) }}" alt="{{ $kepsekName }} - {{ $kepsekPos }}" class="w-full h-full object-cover object-top" onerror="this.src='/uploads/logo-ppru-square.png'">
            </div>
            <div class="space-y-2 text-center md:text-left">
                <span class="inline-block bg-emerald-100 text-school-green text-xs font-black px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                    Pimpinan Pesantren
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    {{ $kepsekName }}
                </h2>
                <p class="text-xs sm:text-sm text-school-green font-bold">{{ $kepsekPos }}</p>
                <p class="text-xs sm:text-sm text-gray-600 italic pt-1">"Mendidik Generasi Khairu Ummah, Berilmu Amaliah, Beramal Ilmiah, dan Berakhlak Qur'ani."</p>
            </div>
        </div>

        {{-- KONTEN PIDATO RESMI --}}
        <div class="prose-content text-gray-800 text-sm sm:text-base leading-relaxed space-y-5 text-justify max-w-4xl mx-auto">
            @if(!empty($page->content) && strlen(trim(strip_tags($page->content))) > 0 && !str_contains($page->content, 'Raudhatul Ulum'))
                {!! $page->content !!}
            @else
                <p class="font-semibold text-gray-900 text-base sm:text-lg">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

                <p class="font-arabic text-xl text-school-green leading-relaxed text-right py-2" dir="rtl">
                    بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ • كُنتُمْ خَيْرَ أُمَّةٍ أُخْرِجَتْ لِلنَّاسِ تَأْمُرُونَ بِالْمَعْرُوفِ وَتَنْهَوْنَ عَنِ الْمُنكَرِ وَتُؤْمِنُونَ بِاللَّهِ
                </p>

                <p>Alhamdulillahirabbil'alamin, segala puji dan syukur senantiasa kita panjatkan ke hadirat Allah Subhanahu Wa Ta'ala atas limpahan rahmat, taufik, serta hidayah-Nya. Shalawat beriring salam semoga senantiasa tercurah kepada uswah hasanah kita, Nabi Besar Muhammad Shallallahu 'Alaihi Wasallam, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.</p>

                <p>Selamat datang di website resmi <strong>Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga</strong>, Ogan Ilir, Sumatera Selatan. Sejak awal dirintisnya madrasah cikal bakal pada tahun 1930 hingga resmi berdirinya pesantren pada 1 Agustus 1950 di bawah naungan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS), lembaga ini senantiasa berkomitmen teguh mengemban amanah dakwah dan kaderisasi generasi terbaik umat (<em>Khairu Ummah</em>).</p>

                <p>PPRU memadukan kurikulum terpadu kepesantrenan (Pondok Modern Gontor), Kementerian Agama RI, dan Kurikulum Nasional, serta mengantongi piagam muadalah resmi dari Universitas Al-Azhar Kairo Mesir. Dalam sistem asrama penuh (boarding school) 24 jam, santri ditempa penguasaan bahasa Arab dan Inggris aktif, hafalan dan pemahaman Al-Qur'an (Tahfidz), pengkajian kitab-kitab turats (Kuning), pembiasaan sains dan riset teknologi, serta penanaman 10 Jati Diri Santri Raudhatul Ulum.</p>

                <p>Kami menyambut gembira kehadiran para wali santri dan masyarakat luas yang mempercayakan amanah pendidikan putra-putrinya di pondok tercinta ini. Semoga Allah SWT senantiasa meridhoi setiap langkah ikhtiar kita dalam menegakkan syiar Islam.</p>

                <p class="font-semibold text-gray-900 pt-2">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">{{ $kepsekName }}</h3>
                        <p class="text-xs text-gray-500">{{ $kepsekPos }}</p>
                    </div>
                    <div class="inline-flex items-center space-x-2 bg-emerald-50 px-4 py-2 rounded-xl text-xs text-school-green border border-emerald-200">
                        <i class="fa-solid fa-certificate text-amber-500"></i>
                        <span>Muadalah Al-Azhar Kairo &amp; Akreditasi A</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- CTA DAFTAR PPDB / PSB --}}
        <div class="mt-10 pt-8 border-t border-gray-100 bg-gradient-to-r from-school-green via-emerald-800 to-gray-900 rounded-3xl p-6 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
            <div>
                <h4 class="text-xl font-extrabold">Penerimaan Santri Baru (PSB Online)</h4>
                <p class="text-xs sm:text-sm text-green-100 mt-1">Mari bergabung bersama ribuan santri dari seluruh penjuru nusantara di Pondok Pesantren Raudhatul Ulum Sakatiga.</p>
            </div>
            <div class="flex flex-wrap gap-3 flex-shrink-0">
                <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-gray-950 px-5 py-2.5 rounded-xl font-black text-xs shadow-md transition flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-1.5"></i> Daftar PPDB &amp; PSB Online
                </a>
                <a href="{{ route('hubungi') }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow transition flex items-center">
                    <i class="fa-solid fa-phone mr-1.5"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
