@extends('layouts.frontend')

@section('title', 'Fasilitas & Sarana Prasarana - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Fasilitas belajar modern, laboratorium sains, ruang multimedia, perpustakaan digital, asrama santri, dan sarana olahraga SMA IT Ishlahul Ummah Prabumulih.')

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
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Fasilitas & Sarana Prasarana</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Infrastruktur modern dan lingkungan belajar terpadu yang nyaman untuk mendukung potensi akademik, riset, dan hafalan Al-Qur'an.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Standar Pendidikan Modern</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Sarana & Prasarana Kampus
        </h2>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($bidangs as $idx => $b)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-gray-100 hover:shadow-2xl transition transform hover:-translate-y-1.5 flex flex-col justify-between group p-6 sm:p-8 reveal-fade-up delay-{{ $idx % 4 }}">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-emerald-100 text-[#00913e] px-3 py-1 rounded-full">
                            Fasilitas Sekolah
                        </span>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50/80 p-2.5 flex items-center justify-center flex-shrink-0 shadow-inner group-hover:scale-110 transition duration-300 text-[#00913e]">
                            @if(!empty($b->icon) && (str_starts_with($b->icon, 'http') || str_starts_with($b->icon, '/')))
                                <img src="{{ $b->icon }}" alt="{{ $b->name }}" class="w-full h-full object-contain" onerror="this.src='/uploads/campus-ishum.jpg'">
                            @else
                                <i class="{{ $b->icon ?: 'fa-solid fa-school' }} text-2xl text-[#00913e]"></i>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg group-hover:text-[#00913e] transition leading-snug">
                            <a href="{{ route('bidang.show', $b->slug) }}">{{ $b->name }}</a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed font-light">
                            {!! strip_tags($b->description) !!}
                        </p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center justify-between text-xs">
                    <a href="{{ route('bidang.show', $b->slug) }}" class="inline-flex items-center font-bold text-[#00913e] group-hover:text-orange-500">
                        <span>Rincian Fasilitas</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                    <span class="text-[11px] text-gray-400 font-medium">SMA IT Ishlahul Ummah Prabumulih</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-400">
                Belum ada data fasilitas.
            </div>
        @endforelse
    </div>

</div>
@endsection
