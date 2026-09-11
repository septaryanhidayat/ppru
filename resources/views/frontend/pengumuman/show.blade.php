@extends('layouts.frontend')

@section('title', $announcement->title . ' - Pengumuman SMA IT Plus Robbani')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
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
        <div class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100 space-y-6">
            <div class="flex items-center space-x-3 text-xs text-[#0d6b38] font-bold">
                <i class="fa-solid fa-bullhorn text-base text-orange-500"></i>
                <span>Pengumuman Resmi SMA IT Plus Robbani</span>
            </div>

            @if($announcement->featured_image)
                <div class="rounded-2xl overflow-hidden shadow-md">
                    <img src="{{ $announcement->featured_image }}" alt="{{ $announcement->title }}" class="w-full h-auto">
                </div>
            @endif

            <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed">
                {!! $announcement->content !!}
            </div>

            @if($announcement->file_attachment)
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-file-arrow-down text-2xl text-[#0d6b38]"></i>
                        <div>
                            <span class="font-bold text-xs text-gray-800 block">Lampiran Dokumen</span>
                            <span class="text-[11px] text-gray-500">Unduh dokumen lampiran pengumuman ini</span>
                        </div>
                    </div>
                    <a href="{{ $announcement->file_attachment }}" target="_blank" class="bg-[#0d6b38] hover:bg-emerald-800 text-white px-4 py-2 rounded-xl text-xs font-semibold transition">
                        Unduh File
                    </a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Pengumuman Lainnya
                </h3>
                <div class="space-y-3 text-xs">
                    @foreach($otherAnnouncements as $oAnn)
                        <a href="{{ route('pengumuman.show', $oAnn->slug) }}" class="block p-3 rounded-xl hover:bg-emerald-50 transition border border-gray-50">
                            <span class="text-[10px] text-orange-600 font-bold block mb-1">Pengumuman</span>
                            <h4 class="font-bold text-gray-800 line-clamp-2 leading-snug">{{ $oAnn->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
