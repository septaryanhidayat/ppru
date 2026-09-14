@extends('layouts.frontend')

@section('title', 'Unit Pendidikan - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', 'Layanan pendidikan terintegrasi Pondok Pesantren Raudhatul Ulum Sakatiga mulai dari usia dini (TK, MI) hingga jenjang menengah (MTs, MA, SMP IT, SMA IT), Tahfidz 30 Juz, dan Perguruan Tinggi.')

@section('content')
{{-- HERO HEADER --}}
<div class="relative bg-gradient-to-br from-[#006830] via-[#00843d] to-[#053d1c] text-white py-16 sm:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-5xl mx-auto text-center relative z-10 space-y-4">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-[#f59e0b] text-slate-900 shadow-md">
            Layanan Pendidikan Terpadu
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight drop-shadow-md">
            Unit Pendidikan PPRU
        </h1>
        <p class="text-sm sm:text-base text-emerald-100 max-w-2xl mx-auto font-light leading-relaxed">
            Pondok Pesantren Raudhatul Ulum menyediakan layanan pendidikan terintegrasi mulai dari usia dini hingga jenjang menengah atas, kepesantrenan berasrama (*Boarding School*), program khusus Tahfidzul Qur'an, dan perguruan tinggi.
        </p>
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100 py-3 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2 text-xs text-gray-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#00843d] flex items-center"><i class="fa-solid fa-house mr-1 text-[#00843d]"></i> Beranda</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-800 font-bold">Unit Pendidikan</span>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="py-14 bg-gray-50/70 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($units as $unit)
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between group">
                    <div>
                        {{-- Photo Thumbnail --}}
                        <div class="relative h-52 w-full overflow-hidden bg-emerald-950">
                            <img src="{{ $unit->thumbnail_url }}" alt="{{ $unit->name }}" class="w-full h-full object-cover group-hover:scale-108 transition duration-700 brightness-95" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            
                            {{-- Badges --}}
                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                <span class="bg-[#00843d] text-white text-[11px] font-extrabold px-3 py-1 rounded-full shadow-md backdrop-blur-xs flex items-center">
                                    <i class="fa-solid fa-building-columns mr-1.5 text-[10px]"></i>
                                    {{ $unit->category_type }}
                                </span>
                                @if($unit->badge)
                                    <span class="bg-[#f59e0b] text-slate-900 text-[11px] font-black px-3 py-1 rounded-full shadow-md flex items-center">
                                        <i class="fa-solid fa-award mr-1 text-[10px]"></i>
                                        {{ $unit->badge }}
                                    </span>
                                @endif
                            </div>

                            @if($unit->short_name)
                                <span class="absolute bottom-3 right-3 bg-white/90 text-[#00843d] text-xs font-black px-2.5 py-1 rounded-lg backdrop-blur shadow-sm">
                                    {{ $unit->short_name }}
                                </span>
                            @endif
                        </div>

                        {{-- Details --}}
                        <div class="p-6 space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-2xl bg-white p-1 flex items-center justify-center shrink-0 border border-emerald-100 group-hover:border-[#00843d] shadow-xs group-hover:scale-105 transition duration-300 overflow-hidden">
                                    @if(!empty($unit->logo))
                                        <img src="{{ $unit->logo_url }}" alt="Logo {{ $unit->name }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="w-full h-full rounded-xl bg-emerald-50 text-[#00843d] group-hover:bg-[#00843d] group-hover:text-white flex items-center justify-center text-base transition">
                                            <i class="{{ $unit->icon ?: 'fa-solid fa-graduation-cap' }}"></i>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-extrabold text-base sm:text-lg text-gray-900 group-hover:text-[#00843d] transition line-clamp-1">
                                    {{ $unit->name }}
                                </h3>
                            </div>

                            @if($unit->curriculum)
                                <div class="text-[11px] text-emerald-800 font-semibold bg-emerald-50/80 px-3 py-1.5 rounded-xl border border-emerald-100 flex items-center">
                                    <i class="fa-solid fa-book-quran mr-2 text-[#00843d]"></i>
                                    <span class="truncate">{{ $unit->curriculum }}</span>
                                </div>
                            @endif

                            <p class="text-xs text-gray-600 font-light leading-relaxed line-clamp-3">
                                {{ strip_tags($unit->description) ?: 'Menyelenggarakan pendidikan islami terpadu dan berkualitas berorientasi pada pembentukan generasi khoiru ummah.' }}
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-2 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('pendidikan.show', $unit->slug) }}" class="inline-flex items-center text-xs font-extrabold text-[#00843d] hover:text-[#006830] transition group/btn">
                            <span>Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover/btn:translate-x-1 transition"></i>
                        </a>
                        <a href="{{ route('ppdb.index') }}" class="bg-emerald-50 hover:bg-[#00843d] text-[#00843d] hover:text-white text-[11px] font-bold px-3 py-1.5 rounded-full transition">
                            Daftar Unit
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-gray-400">
                    <i class="fa-solid fa-school text-5xl text-gray-300 mb-3 block"></i>
                    Belum ada data unit pendidikan yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
