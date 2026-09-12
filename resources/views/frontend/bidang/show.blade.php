@extends('layouts.frontend')

@section('title', $bidang->name . ' - SMA IT Ishlahul Ummah Prabumulih')

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
        <p class="text-sm text-emerald-100 mt-2 font-light">Sarana & Prasarana SMA IT Ishlahul Ummah Prabumulih</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- Detail Bidang / Fasilitas (2/3) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Foto Fasilitas --}}
            <div class="rounded-2xl overflow-hidden bg-slate-100 shadow-md">
                <img src="{{ $bidang->thumbnail_url }}" alt="{{ $bidang->name }}" class="w-full h-64 sm:h-80 object-cover" onerror="this.src='/uploads/campus-ishum.webp'">
            </div>

            <div class="flex items-center space-x-4 pb-6 border-b border-gray-100">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center text-2xl flex-shrink-0 overflow-hidden border border-emerald-200">
                    @if(!empty($bidang->icon) && !str_starts_with($bidang->icon, 'http') && !str_starts_with($bidang->icon, '/'))
                        <i class="{{ $bidang->icon }}"></i>
                    @else
                        <i class="fa-solid fa-school"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">{{ $bidang->name }}</h2>
                    <span class="text-xs text-gray-500">SMA Islam Terpadu Ishlahul Ummah Prabumulih</span>
                </div>
            </div>

            <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed">
                {!! $bidang->description !!}
            </div>

            <div class="mt-8 p-6 bg-emerald-50/60 rounded-2xl border border-emerald-100 space-y-3 text-xs sm:text-sm">
                <h3 class="font-bold text-gray-900 text-sm uppercase tracking-wider mb-2">Informasi Layanan Fasilitas</h3>
                <p class="flex items-start"><i class="fa-solid fa-location-dot text-[#00913e] mt-1 mr-3 w-4"></i><span>{{ $bidang->address ?: 'Kompleks Sekolah SMA IT Ishlahul Ummah Prabumulih, Prabumulih, Sumatera Selatan' }}</span></p>
                <p class="flex items-center"><i class="fa-solid fa-phone text-[#00913e] mr-3 w-4"></i><span>{{ $bidang->phone ?: '0821-8268-0647' }}</span></p>
                <p class="flex items-center"><i class="fa-solid fa-envelope text-[#00913e] mr-3 w-4"></i><span>{{ $bidang->email ?: 'smaitishlahulummah2019@gmail.com' }}</span></p>
            </div>
        </div>

        {{-- Sidebar Fasilitas Lainnya --}}
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Fasilitas Sekolah Lainnya
                </h3>
                <ul class="space-y-3 text-xs">
                    @foreach($otherBidangs as $oB)
                        <li>
                            <a href="{{ route('bidang.show', $oB->slug) }}" class="flex items-center py-2 px-3 rounded-xl hover:bg-emerald-50 hover:text-[#00913e] text-gray-700 transition">
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
