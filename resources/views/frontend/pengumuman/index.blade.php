@extends('layouts.frontend')

@section('title', 'Papan Pengumuman Resmi - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Kumpulan pengumuman resmi akademik, jadwal ujian, informasi PPDB, dan surat edaran Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Informasi</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Pengumuman</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Papan Pengumuman Sekolah</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Informasi penting, edaran akademik, kalender kegiatan, dan pengumuman resmi Pondok Pesantren Raudhatul Ulum Sakatiga.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">INFORMASI AKADEMIK</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mt-1">
            Pengumuman & Surat Edaran Resmi
        </h2>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($pengumuman as $idx => $item)
            <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl shadow-md hover:shadow-xl border border-gray-100 dark:border-slate-800 flex flex-col justify-between space-y-4 transition transform hover:-translate-y-1 reveal-fade-up delay-{{ $idx % 4 }}">
                <div>
                    <div class="flex items-center space-x-2 text-xs text-[#00913e] dark:text-emerald-400 font-bold mb-2">
                        <i class="fa-solid fa-bullhorn text-orange-500"></i>
                        <span>PENGUMUMAN RESMI</span>
                    </div>
                    <h2 class="font-extrabold text-base sm:text-lg text-gray-900 dark:text-white hover:text-[#00913e] dark:hover:text-emerald-400 transition leading-snug">
                        <a href="{{ route('pengumuman.show', $item->slug) }}">{{ $item->title }}</a>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-slate-300 mt-2 line-clamp-3 leading-relaxed font-light">
                        {{ Str::limit(strip_tags($item->content), 140) }}
                    </p>
                </div>
                <div class="pt-4 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-[#00913e] dark:text-emerald-400">
                    <a href="{{ route('pengumuman.show', $item->slug) }}" class="inline-flex items-center hover:text-orange-600 dark:hover:text-amber-400">
                        <span>Baca Rincian Pengumuman</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                    <span class="text-[11px] text-gray-400 dark:text-slate-400 font-normal">
                        {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800">
                <i class="fa-solid fa-bullhorn text-4xl text-gray-300 dark:text-slate-600 mb-3 block"></i>
                <span>Belum ada pengumuman resmi yang dipublikasikan.</span>
            </div>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $pengumuman->links() }}
    </div>
</div>
@endsection
