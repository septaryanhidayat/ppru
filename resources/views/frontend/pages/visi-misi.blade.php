@extends('layouts.frontend')

@section('title', 'Visi dan Misi - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Visi dan Misi resmi SMA Islam Terpadu Ishlahul Ummah Prabumulih: Membentuk generasi Qur\'ani, berakhlak mulia, dan unggul dalam sains teknologi.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Visi dan Misi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Visi & Misi Sekolah</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Arah dan komitmen luhur SMA IT Ishlahul Ummah Prabumulih dalam membimbing generasi unggul berkarakter Qur'ani dan berwawasan masa depan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- KOLOM UTAMA (2/3) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- KARTU VISI --}}
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Falsafah Arah</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Visi Sekolah</h2>
                    </div>
                </div>
                <div class="w-16 h-1 bg-[#00913e] rounded-full mb-6"></div>

                <div class="bg-gradient-to-r from-emerald-50/90 to-amber-50/70 p-6 sm:p-8 rounded-2xl border-l-4 border-[#00913e] shadow-sm">
                    <p class="text-lg sm:text-xl font-bold text-gray-900 leading-relaxed font-serif italic text-center sm:text-left">
                        “Terwujudnya Generasi Ishum yang Beraqidah Kokoh, Berakhlak Qur'ani, Unggul dalam Sains & Teknologi, serta Berwawasan Lingkungan dan Global.”
                    </p>
                </div>
            </div>

            {{-- KARTU MISI --}}
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up delay-1">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-orange-600 uppercase tracking-wider block">Langkah Konkret</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Misi Sekolah</h2>
                    </div>
                </div>
                <div class="w-16 h-1 bg-orange-500 rounded-full mb-8"></div>

                <div class="space-y-6">
                    {{-- Misi 1 --}}
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-emerald-300 transition">
                        <div class="w-9 h-9 rounded-xl bg-[#00913e] text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow">
                            1
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900">Pendidikan Berbasis Al-Qur'an & Sunnah</h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                Menanamkan nilai-nilai Al-Qur'an dan Sunnah secara terpadu melalui kurikulum tahfidz mutqin, kajian adab islami, serta pembiasaan ibadah harian berdisiplin tinggi.
                            </p>
                        </div>
                    </div>

                    {{-- Misi 2 --}}
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-orange-300 transition">
                        <div class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow">
                            2
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900">Keunggulan Akademik, Sains & Riset Digital</h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                Mengembangkan potensi akademik siswa dalam penguasaan sains, matematika, teknologi informasi modern, dan robotika berbasis kecerdasan bernalar ilmiah.
                            </p>
                        </div>
                    </div>

                    {{-- Misi 3 --}}
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-emerald-300 transition">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow">
                            3
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900">Pembentukan Karakter Mandiri & Kepemimpinan Ishum</h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                Membentuk karakter santri yang amanah, santun, berjiwa kewirausahaan, disiplin, berintegritas moral, dan memiliki kecakapan memimpin peradaban masa depan.
                            </p>
                        </div>
                    </div>

                    {{-- Misi 4 --}}
                    <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-amber-300 transition">
                        <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow">
                            4
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900">Lingkungan Belajar Asri, Modern & Berwawasan Global</h3>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                Mewujudkan iklim sekolah ramah anak, sarana laboratorium representatif, penguasaan bilingual (Arab-Inggris), dan kesadaran pelestarian lingkungan hidup.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
                                <img src="{{ $lp->featured_image }}" alt="{{ $lp->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" onerror="this.src='/uploads/campus-ishum.webp'">
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

            {{-- WIDGET AGENDA --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 reveal-fade-up delay-1">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="font-extrabold text-gray-900 text-base">Agenda Terdekat</h3>
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
                                    <i class="fa-solid fa-location-dot mr-1 text-orange-400"></i> {{ $la->location ?: 'Kampus SMA IT Ishlahul Ummah Prabumulih' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>
            </div>

            {{-- CTA BANNER JOIN PPDB --}}
            <div class="bg-gradient-to-br from-emerald-950 via-[#00913e] to-emerald-900 text-white p-6 sm:p-8 rounded-3xl shadow-xl space-y-4 text-center reveal-fade-up delay-2">
                <div class="w-14 h-14 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center text-2xl mx-auto border border-red-500/30">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="text-xl font-extrabold">PPDB Telah Dibuka!</h3>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Wujudkan impian putra-putri Anda menjadi hafizh Qur'an yang cerdas sains bersama SMA IT Ishlahul Ummah Prabumulih.
                </p>
                <div class="pt-2">
                    <a href="{{ route('ppdb.index') }}" class="block w-full bg-[#da251c] hover:bg-[#b91c1c] text-white py-3 rounded-xl font-bold text-xs shadow-lg transition">
                        Daftar PPDB Online
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
