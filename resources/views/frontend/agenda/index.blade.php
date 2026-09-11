@extends('layouts.frontend')

@section('title', 'Agenda Akademik & Kegiatan - SMA IT Plus Robbani')
@section('meta_description', 'Jadwal dan kalender agenda kegiatan akademik, ujian, perlombaan, tasmi\' Qur\'an, dan ekstrakurikuler SMA IT Plus Robbani Indralaya Ogan Ilir.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Informasi</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Agenda Kegiatan</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Agenda Akademik & Santri</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Jadwal kegiatan belajar, agenda tasmi' Al-Qur'an, olimpiade sains, dan ekstrakurikuler SMA IT Plus Robbani.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">KALENDER AKADEMIK</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Agenda Kegiatan Terjadwal
        </h2>
        <div class="w-16 h-1 bg-[#0d6b38] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($agendas as $idx => $agenda)
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-md hover:shadow-xl border border-gray-100 flex flex-col sm:flex-row gap-6 transition transform hover:-translate-y-1 reveal-fade-up delay-{{ $idx % 4 }}">
                <div class="bg-emerald-50 border-2 border-emerald-200 rounded-2xl p-4 text-center flex flex-col items-center justify-center flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 shadow-inner">
                    <span class="text-3xl font-extrabold text-[#0d6b38]">
                        {{ $agenda->event_date ? $agenda->event_date->format('d') : '01' }}
                    </span>
                    <span class="text-xs uppercase font-extrabold text-gray-700 mt-0.5">
                        {{ $agenda->event_date ? $agenda->event_date->translatedFormat('M Y') : '2026' }}
                    </span>
                </div>
                <div class="flex-grow flex flex-col justify-between space-y-3">
                    <div>
                        <h2 class="font-extrabold text-base sm:text-lg text-gray-900 hover:text-[#0d6b38] transition leading-snug">
                            <a href="{{ route('agenda.show', $agenda->slug) }}">{{ $agenda->title }}</a>
                        </h2>
                        <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                            <i class="fa-solid fa-location-dot mr-2 text-orange-500"></i>
                            <span>{{ $agenda->location ?: 'Kampus SMA IT Plus Robbani' }}</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed font-light">
                            {!! strip_tags($agenda->content) !!}
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-100">
                        <a href="{{ route('agenda.show', $agenda->slug) }}" class="inline-flex items-center text-xs font-bold text-[#0d6b38] hover:text-orange-600">
                            <span>Detail Agenda</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-3xl border border-gray-100">
                <i class="fa-regular fa-calendar-xmark text-4xl text-gray-300 mb-3 block"></i>
                <span>Belum ada agenda kegiatan terbaru yang dijadwalkan.</span>
            </div>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $agendas->links() }}
    </div>
</div>
@endsection
