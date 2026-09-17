@extends('layouts.frontend')

@section('title', ($page?->meta_title ?: ($page?->title ?: 'Sejarah Pesantren')) . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $page?->meta_description ?: 'Sejarah perjalanan dan perkembangan Pondok Pesantren Raudhatul Ulum Sakatiga sejak 1950 dalam melahirkan generasi Khairu Ummah dan santri berprestasi.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $page?->title ?: 'Sejarah' }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $page?->title ?: 'Sejarah Pondok Pesantren Raudhatul Ulum' }}</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            {{ $page?->excerpt ?: 'Jejak langkah pengabdian para ulama, perjuangan mendirikan madrasah, dan transformasi menuju pesantren modern muadalah Al-Azhar di Sakatiga, Ogan Ilir.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- KOLOM UTAMA (2/3) --}}
        <div class="lg:col-span-8 space-y-8">
            <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
                
                {{-- GAMBAR ILUSTRASI SEJARAH --}}
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 max-h-96">
                    <img src="/uploads/logo-ppru-banner.png" alt="Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full h-full object-cover">
                </div>

                <div class="border-b border-gray-100 pb-4">
                    <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Jejak Langkah &amp; Perkembangan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                        {{ $page?->title ?: 'Menegakkan Risalah Islam di Bumi Sakatiga "Mekkah Kecil"' }}
                    </h2>
                    <div class="w-16 h-1 bg-[#00913e] rounded-full mt-3"></div>
                </div>

                {{-- SEJARAH LENGKAP SEKOLAH --}}
                <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-5">
                    @if(!empty($page?->content) && strlen(trim(strip_tags($page->content))) > 0)
                        {!! $page->content !!}
                    @else
                        <h4>1. Era Cikal Bakal (1930 - 1950 M)</h4>
                        <p>
                            Pondok Pesantren Raudhatul Ulum Sakatiga berakar dari dua madrasah bersejarah di Sakatiga sebelum masa kemerdekaan RI: Madrasah Al-Falah yang dirintis pada tahun 1930 oleh KH. Bahri bin Bunga (dilanjutkan oleh KH. Abdul Ghanie Bahri) dan Madrasah Al-Shibyan yang didirikan pada tahun 1936 oleh KH. Abd. Rahim Mandung dan KH. Abdullah Kenalim. Desa Sakatiga sejak dahulu kala telah dikenal dengan julukan "Mekkah Kecil" di Sumatera Selatan karena banyaknya para ulama Sakatiga yang menuntut ilmu di tanah suci Makkah Al-Mukarramah.
                        </p>

                        <h4>2. Era Kebangkitan &amp; Pendirian Yayasan (1950 - 1986 M)</h4>
                        <p>
                            Pada tanggal 1 Agustus 1950, para alim ulama dan tokoh masyarakat Sakatiga bermufakat menghidupkan kembali madrasah dengan mendirikan Sekolah Rakyat Islam (SRI) dan Sekolah Menengah Agama Islam (SMAI), yang kemudian disatukan menjadi Perguruan Islam Raudhatul Ulum (PIRUS) Sakatiga di bawah naungan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) berdasarkan Akte Notaris Aminus Palembang No. 21.A Tahun 1966.
                        </p>

                        <h4>3. Era Modern &amp; Pesantren Terpadu Muadalah (1986 - Sekarang)</h4>
                        <p>
                            Mulai 8 Agustus 1986 di bawah kepemimpinan Mudir <strong>KH. Tol'at Wafa Ahmad, Lc.</strong>, diterapkan sistem pesantren modern terpadu (Kulliyatul Mu'allimin Al-Islamiyyah / KMI) dengan sistem asrama penuh (boarding school) 24 jam. Kurikulum pesantren memadukan keilmuan Pondok Modern Gontor, Kementerian Agama, dan Diknas, serta mendapatkan piagam pengakuan kesetaraan resmi (Muadalah) dari Universitas Al-Azhar Kairo Mesir dan Universitas Islam Madinah.
                        </p>

                        <p class="font-medium text-gray-900 bg-emerald-50/80 p-5 rounded-2xl border-l-4 border-[#00913e]">
                            Kini, PPRU Sakatiga berkembang pesat di atas lahan lebih dari 60 hektar dengan mengasuh ribuan santri dari penjuru nusantara pada 8 unit pendidikan formal, mencetak generasi <em>Khairu Ummah</em> yang beraqidah lurus, berakhlak mulia, dan berdaya saing global.
                        </p>
                    @endif
                </div>
            </article>
        </div>

        {{-- SIDEBAR KANAN (1/3) --}}
        <div class="lg:col-span-4 space-y-8">
            
            {{-- WIDGET ARTIKEL & BERITA TERBARU --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="font-extrabold text-gray-900 text-base">Kabar Sekolah</h3>
                    <a href="{{ route('artikel.index') }}" class="text-xs font-bold text-[#00913e] hover:text-orange-500">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($latestPosts ?? [] as $lp)
                        <a href="{{ route('artikel.show', $lp->slug) }}" class="flex items-center space-x-3 group">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ $lp->featured_image }}" alt="{{ $lp->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    {{ $lp->title }}
                                </h4>
                                <span class="text-[11px] text-gray-400 block mt-1">
                                    {{ $lp->published_at ? $lp->published_at->translatedFormat('d M Y') : ($lp->created_at ? $lp->created_at->translatedFormat('d M Y') : '') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada berita terbaru.</p>
                    @endforelse
                </div>
            </div>

            {{-- WIDGET AGENDA TERJADWAL --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 reveal-fade-up delay-1">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="font-extrabold text-gray-900 text-base">Agenda Akademik</h3>
                    <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-[#00913e] hover:text-orange-500">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($latestAgendas ?? [] as $la)
                        <a href="{{ route('agenda.show', $la->slug) }}" class="flex items-start space-x-3 group p-3 rounded-xl hover:bg-emerald-50/50 transition">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00913e] flex flex-col items-center justify-center flex-shrink-0 font-bold text-xs">
                                <span class="text-sm font-extrabold leading-none">{{ $la->event_date ? $la->event_date->format('d') : '01' }}</span>
                                <span class="text-[9px] uppercase">{{ $la->event_date ? $la->event_date->translatedFormat('M') : 'SMA' }}</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    {{ $la->title }}
                                </h4>
                                <span class="text-[11px] text-gray-400 block mt-1">
                                    <i class="fa-solid fa-location-dot mr-1 text-orange-400"></i> {{ $la->location ?: 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>
            </div>

            {{-- CTA BANNER --}}
            <div class="bg-gradient-to-br from-emerald-950 via-[#00913e] to-emerald-900 text-white p-6 sm:p-8 rounded-3xl shadow-xl space-y-4 text-center reveal-fade-up delay-2">
                <div class="w-14 h-14 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center text-2xl mx-auto border border-red-500/30">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
                <h3 class="text-xl font-extrabold">Bergabung Bersama Kami!</h3>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Daftarkan putra-putri tercinta sekarang dan jadilah bagian dari keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>
                <div class="pt-2">
                    <a href="{{ route('ppdb.index') }}" class="block w-full bg-[#da251c] hover:bg-[#b91c1c] text-white py-3 rounded-xl font-bold text-xs shadow-lg transition">
                        Daftar PPDB &amp; PSB Sekarang
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
