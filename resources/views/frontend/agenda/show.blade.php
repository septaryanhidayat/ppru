@extends('layouts.frontend')

@section('title', $agenda->title . ' - Agenda Pondok Pesantren Raudhatul Ulum Sakatiga')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('agenda.index') }}" class="hover:text-white transition">Agenda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $agenda->title }}</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">{{ $agenda->title }}</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 sm:p-10 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-800 space-y-6">
            <div class="flex flex-wrap items-center gap-4 p-4 bg-emerald-50 dark:bg-emerald-950/40 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 text-xs text-gray-700 dark:text-slate-200">
                <div class="flex items-center">
                    <i class="fa-regular fa-calendar-days text-[#00913e] dark:text-emerald-400 mr-2 text-base"></i>
                    <span class="font-bold">{{ $agenda->event_date ? $agenda->event_date->translatedFormat('l, d F Y') : '-' }}</span>
                </div>
                <span>&bull;</span>
                <div class="flex items-center">
                    <i class="fa-solid fa-location-dot text-orange-500 mr-2 text-base"></i>
                    <span>{{ $agenda->location ?: 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}</span>
                </div>
            </div>

            @if($agenda->featured_image)
                <div class="rounded-2xl overflow-hidden shadow-md bg-gray-100 dark:bg-slate-800 border border-gray-100 dark:border-slate-800">
                    <img src="{{ $agenda->featured_image }}" alt="{{ $agenda->title }}" class="w-full h-auto">
                </div>
            @endif

            <div class="prose-content text-gray-700 dark:text-slate-200 text-sm sm:text-base leading-relaxed">
                {!! $agenda->content !!}
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-slate-800">
                    Agenda Lainnya
                </h3>
                <div class="space-y-3 text-xs">
                    @foreach($otherAgendas as $oA)
                        <a href="{{ route('agenda.show', $oA->slug) }}" class="block p-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-slate-800/80 transition border border-gray-50 dark:border-slate-800">
                            <span class="text-[10px] text-orange-600 dark:text-orange-400 font-bold block mb-1">
                                {{ $oA->event_date ? $oA->event_date->format('d M Y') : '' }}
                            </span>
                            <h4 class="font-bold text-gray-800 dark:text-slate-200 line-clamp-2 leading-snug">{{ $oA->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
