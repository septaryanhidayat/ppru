@extends('layouts.frontend')

@section('title', $announcement->title . ' - Pengumuman Pondok Pesantren Raudhatul Ulum Sakatiga')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('pengumuman.index') }}" class="hover:text-white transition">Pengumuman</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $announcement->title }}</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">{{ $announcement->title }}</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-800 space-y-6">
            <div class="flex items-center space-x-3 text-xs text-[#00913e] dark:text-emerald-400 font-bold">
                <i class="fa-solid fa-bullhorn text-base text-orange-500"></i>
                <span>Pengumuman Resmi Pondok Pesantren Raudhatul Ulum Sakatiga</span>
            </div>

            @if($announcement->featured_image)
                <div class="rounded-2xl overflow-hidden shadow-md bg-gray-100 dark:bg-slate-800 border border-gray-100 dark:border-slate-800">
                    <img src="{{ $announcement->featured_image }}" alt="{{ $announcement->title }}" class="w-full h-auto">
                </div>
            @endif

            <div class="prose-content text-gray-700 dark:text-slate-200 text-sm sm:text-base leading-relaxed">
                {!! $announcement->content !!}
            </div>

            @if($announcement->file_attachment)
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl border border-emerald-200 dark:border-emerald-900/40 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-file-arrow-down text-2xl text-[#00913e] dark:text-emerald-400"></i>
                        <div>
                            <span class="font-bold text-xs text-gray-800 dark:text-slate-200 block">Lampiran Dokumen</span>
                            <span class="text-[11px] text-gray-500 dark:text-slate-400">Unduh dokumen lampiran pengumuman ini</span>
                        </div>
                    </div>
                    <a href="{{ $announcement->file_attachment }}" target="_blank" class="bg-[#00913e] hover:bg-emerald-800 text-white px-4 py-2 rounded-xl text-xs font-semibold transition">
                        Unduh File
                    </a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-slate-800">
                    Pengumuman Lainnya
                </h3>
                <div class="space-y-3 text-xs">
                    @foreach($otherAnnouncements as $oAnn)
                        <a href="{{ route('pengumuman.show', $oAnn->slug) }}" class="block p-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-slate-800/80 transition border border-gray-50 dark:border-slate-800">
                            <span class="text-[10px] text-orange-600 dark:text-orange-400 font-bold block mb-1">Pengumuman</span>
                            <h4 class="font-bold text-gray-800 dark:text-slate-200 line-clamp-2 leading-snug">{{ $oAnn->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
