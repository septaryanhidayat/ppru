@extends('layouts.frontend')

@section('title', 'Struktur Organisasi - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Struktur Organisasi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Struktur Organisasi Pesantren</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Susunan pimpinan Pondok Pesantren Raudhatul Ulum dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    
    {{-- SEKSI 1: STRUKTUR ORGANISASI SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="text-center max-w-2xl mx-auto mb-8">
            <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Bagan Organisasi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Struktur Kepemimpinan YAPIRUS &amp; PPRU
            </h2>
            <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        </div>

        @if(!empty($page?->content) && trim(strip_tags($page->content)) !== '' && !str_contains($page->content, 'Raudhatul Ulum'))
            <div class="prose-content max-w-4xl mx-auto text-gray-700 text-justify text-sm sm:text-base leading-relaxed bg-slate-50/70 p-6 sm:p-10 rounded-2xl border border-slate-100">
                {!! $page->content !!}
            </div>
        @else
            <div class="max-w-md mx-auto text-center py-12 px-4 space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#00913e] flex items-center justify-center text-3xl mx-auto shadow-inner">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Bagan Struktur Organisasi</h3>
                <p class="text-xs sm:text-sm text-gray-500 leading-relaxed font-light">
                    Susunan bagan dan formatur struktur organisasi Pondok Pesantren Raudhatul Ulum Sakatiga saat ini sedang dalam proses pembaruan data resmi.
                </p>
            </div>
        @endif
    </section>

    {{-- SEKSI 2: FASILITAS & SARANA PRASARANA SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Sarana &amp; Prasarana Kampus</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">Fasilitas Unggulan Pondok Pesantren Raudhatul Ulum</h2>
            </div>
            <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Selengkapnya</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bidangs as $b)
                <a href="{{ route('bidang.show', $b->slug) }}" class="rounded-2xl border border-gray-100 hover:border-[#00913e] hover:shadow-xl transition group bg-white overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $b->thumbnail_url }}" alt="{{ $b->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow">
                                Sarana Pesantren
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900 group-hover:text-[#00913e] transition">{{ $b->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($b->description), 80) }}</p>
                        </div>
                    </div>
                    <div class="px-5 pb-4 pt-2 border-t border-gray-50 flex items-center justify-between text-xs text-[#00913e] font-bold">
                        <span>Rincian Fasilitas</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data fasilitas.
                </div>
            @endforelse
        </div>
    </section>

    {{-- SEKSI 3: PROGRAM UNGGULAN SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Kurikulum &amp; Karakter</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                    Program Unggulan Santri Raudhatul Ulum
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 font-light">Mengasah kecakapan santri menjadi pribadi cerdas, mandiri, dan berjiwa pelopor.</p>
            </div>
            <a href="{{ route('dpc.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Semua Program</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($dpcs->take(8) as $dpc)
                <div class="rounded-2xl border border-gray-100 bg-white hover:border-[#00913e] hover:shadow-lg transition overflow-hidden group flex flex-col justify-between">
                    <div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $dpc->thumbnail_url }}" alt="{{ $dpc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-[10px] font-bold text-[#00913e] block truncate uppercase tracking-wider">{{ $dpc->address ?: 'Program Unggulan' }}</span>
                            <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-1">{{ $dpc->name }}</h3>
                            <p class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($dpc->description), 65) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data program.
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection
