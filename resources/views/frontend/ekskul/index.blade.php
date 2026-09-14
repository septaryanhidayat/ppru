@extends('layouts.frontend')

@section('title', 'Ekstrakurikuler & Club - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Kegiatan ekstrakurikuler dan klub minat bakat di Pondok Pesantren Raudhatul Ulum Sakatiga: Pramuka, Seni, Olahraga, dan Bahasa.')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Ekstrakurikuler &amp; Club</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-people-group"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Ekstrakurikuler &amp; Club</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Mengasah bakat, kepemimpinan, kemandirian, dan persaudaraan santri SMA IT PPRU.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($ekskul as $idx => $item)
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group reveal-fade-up">
                <div class="relative h-56 overflow-hidden bg-gray-100">
                    <img src="{{ $item->featured_image ?: '/uploads/campus-robbani.webp' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-robbani.webp'">
                    <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md flex items-center space-x-1.5">
                        <i class="fa-solid fa-star text-amber-300 text-xs"></i>
                        <span>Club Unggulan</span>
                    </span>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <h3 class="font-bold text-gray-900 text-xl group-hover:text-[#00913e] transition">
                            {{ $item->title }}
                        </h3>
                        <div class="prose text-xs sm:text-sm text-gray-600 mt-2 line-clamp-4 leading-relaxed font-light">
                            {!! $item->content !!}
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between text-xs text-emerald-700 font-semibold">
                        <span>Aktif Setiap Pekan</span>
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-campground text-4xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 font-medium">Data ekstrakurikuler sedang diperbarui.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
