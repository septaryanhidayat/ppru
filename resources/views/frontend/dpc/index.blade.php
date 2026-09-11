@extends('layouts.frontend')

@section('title', 'Program Unggulan Sekolah - SMA IT Plus Robbani')
@section('meta_description', 'Program unggulan SMA IT Plus Robbani: Tahfidz Qur\'an Mutqin, Sains & Robotika, Islamic Boarding, Bilingual Camp, dan Sukses Masuk PTN.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Akademik</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Program Unggulan</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Program Unggulan SMA IT Plus Robbani</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Kurikulum terintegrasi yang dirancang khusus untuk mengoptimalkan potensi ruhiyah, intelektual, dan kepemimpinan santri.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Karakter & Keahlian Abad 21</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Program Khusus Siswa Robbani
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Mengasah kecakapan santri menjadi pribadi cerdas, mandiri, dan berjiwa pelopor.</p>
        <div class="w-16 h-1 bg-[#0d6b38] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($dpcs as $idx => $dpc)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-md hover:shadow-xl transition transform hover:-translate-y-1 reveal-fade-up delay-{{ $idx % 3 }}">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#0d6b38] flex items-center justify-center text-2xl mb-4 font-bold shadow-inner">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h3 class="text-lg font-extrabold text-gray-900 mb-2">
                    {{ $dpc->name }}
                </h3>
                @if($dpc->address)
                    <div class="text-xs text-gray-500 mb-3 flex items-start">
                        <i class="fa-solid fa-tag text-emerald-600 mr-2 mt-0.5 flex-shrink-0"></i>
                        <span>{{ $dpc->address }}</span>
                    </div>
                @endif
                @if($dpc->description)
                    <p class="text-xs text-gray-600 line-clamp-4 leading-relaxed border-t border-gray-100 pt-3 font-light">
                        {{ $dpc->description }}
                    </p>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-graduation-cap text-4xl text-gray-300 mb-3 block"></i>
                <span>Data program unggulan sedang diperbarui.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection
