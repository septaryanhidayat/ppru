@extends('layouts.frontend')

@section('title', $bidang->name . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('bidang.index') }}" class="hover:text-white transition">Fasilitas</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $bidang->name }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $bidang->name }}</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light">Sarana & Prasarana Pondok Pesantren Raudhatul Ulum Sakatiga</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- Detail Bidang / Fasilitas (2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Foto Fasilitas --}}
            <div class="rounded-2xl overflow-hidden bg-slate-100 shadow-md">
                <img src="{{ $bidang->thumbnail_url }}" alt="{{ $bidang->name }}" class="w-full h-64 sm:h-80 object-cover" onerror="this.onerror=null;this.src='/images/hero-1.webp'">
            </div>

            <div class="flex items-center space-x-4 pb-6 border-b border-gray-100 dark:border-slate-800">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-[#00913e] dark:text-emerald-400 flex items-center justify-center text-2xl flex-shrink-0 overflow-hidden border border-emerald-200 dark:border-emerald-800/40">
                    @if(!empty($bidang->icon) && !str_starts_with($bidang->icon, 'http') && !str_starts_with($bidang->icon, '/'))
                        <i class="{{ $bidang->icon }}"></i>
                    @else
                        <i class="fa-solid fa-school"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ $bidang->name }}</h2>
                    <span class="text-xs text-gray-500 dark:text-slate-400">Pondok Pesantren Raudhatul Ulum Sakatiga</span>
                </div>
            </div>

            <div class="prose-content text-gray-700 dark:text-slate-200 text-sm sm:text-base leading-relaxed">
                {!! $bidang->description !!}
            </div>

            <div class="mt-8 p-6 bg-emerald-50/60 dark:bg-emerald-950/30 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 space-y-3 text-xs sm:text-sm text-gray-700 dark:text-slate-200">
                <h3 class="font-bold text-gray-900 dark:text-white text-sm uppercase tracking-wider mb-2">Informasi Layanan Fasilitas</h3>
                <p class="flex items-start"><i class="fa-solid fa-location-dot text-[#00913e] dark:text-emerald-400 mt-1 mr-3 w-4"></i><span>{{ $bidang->address ?: 'Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Indralaya, Ogan Ilir, Sumatera Selatan' }}</span></p>
                <p class="flex items-center"><i class="fa-solid fa-phone text-[#00913e] dark:text-emerald-400 mr-3 w-4"></i><span>{{ $bidang->phone ?: '0812-7890-1950' }}</span></p>
                <p class="flex items-center"><i class="fa-solid fa-envelope text-[#00913e] dark:text-emerald-400 mr-3 w-4"></i><span>{{ $bidang->email ?: 'sekretariat@ppru.ac.id' }}</span></p>
            </div>
        </div>

        {{-- Sidebar Fasilitas Lainnya --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-slate-800">
                    Fasilitas Pesantren Lainnya
                </h3>
                <ul class="space-y-3 text-xs">
                    @foreach($otherBidangs as $oB)
                        <li>
                            <a href="{{ route('bidang.show', $oB->slug) }}" class="flex items-center py-2 px-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-slate-800/80 hover:text-[#00913e] dark:hover:text-emerald-400 text-gray-700 dark:text-slate-300 transition">
                                <i class="fa-solid fa-chevron-right text-[10px] mr-2 text-gray-400"></i>
                                <span class="font-medium">{{ $oB->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
