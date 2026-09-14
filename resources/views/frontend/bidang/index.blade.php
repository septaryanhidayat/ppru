@extends('layouts.frontend')

@section('title', 'Fasilitas & Sarana Prasarana - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Fasilitas belajar modern, laboratorium sains, ruang multimedia, perpustakaan digital, asrama santri, dan sarana olahraga Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Fasilitas</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Fasilitas &amp; Sarana Prasarana</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Infrastruktur modern dan lingkungan belajar terpadu yang nyaman untuk mendukung potensi akademik, riset, dan hafalan Al-Qur'an.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-[#da251c] uppercase tracking-wider block">Standar Pendidikan Modern</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Sarana &amp; Prasarana Sekolah
        </h2>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($bidangs as $idx => $b)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-gray-100 hover:shadow-2xl transition transform hover:-translate-y-1.5 flex flex-col justify-between group reveal-fade-up delay-{{ $idx % 3 }}">
                <div>
                    {{-- FOTO DOKUMENTASI FASILITAS SEKOLAH --}}
                    <div class="h-48 sm:h-52 w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $b->thumbnail_url }}" alt="{{ $b->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-robbani.webp'">
                        <span class="absolute top-3.5 left-3.5 bg-[#00913e] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
                            Fasilitas Sekolah
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-3">
                        <div class="flex items-center space-x-2.5 text-xs text-[#00913e] font-semibold">
                            @if(!empty($b->icon) && !str_starts_with($b->icon, '/') && !str_starts_with($b->icon, 'http'))
                                <i class="{{ $b->icon }} text-sm text-[#00913e]"></i>
                            @else
                                <i class="fa-solid fa-school text-sm text-[#00913e]"></i>
                            @endif
                            <span>Pondok Pesantren Raudhatul Ulum</span>
                        </div>

                        <h3 class="font-extrabold text-gray-900 text-lg sm:text-xl group-hover:text-[#00913e] transition leading-snug">
                            <a href="{{ route('bidang.show', $b->slug) }}">{{ $b->name }}</a>
                        </h3>
                        
                        <p class="text-xs text-gray-500 line-clamp-3 leading-relaxed font-light">
                            {{ strip_tags($b->description) }}
                        </p>
                    </div>
                </div>

                <div class="px-6 sm:px-7 pb-6 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <a href="{{ route('bidang.show', $b->slug) }}" class="inline-flex items-center font-bold text-[#00913e] hover:text-[#da251c] transition">
                        <span>Rincian Fasilitas</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                    <span class="text-[11px] text-gray-400 font-medium">PPRU Sakatiga</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400 bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-school text-4xl text-gray-300 mb-3 block"></i>
                <span>Belum ada data fasilitas pesantren.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection
