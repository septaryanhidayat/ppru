@extends('layouts.frontend')

@section('title', 'Dewan Guru & Tenaga Kependidikan - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Profil pendidik, ustadz, dan tenaga kependidikan berdedikasi tinggi di Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Dewan Guru</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Dewan Guru & Tenaga Kependidikan</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Pendidik profesional, hafizh Qur'an, dan pakar sains yang siap mendampingi tumbuh kembang putra-putri Anda.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Pendidik & Pembimbing Santri</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Guru & Tenaga Kependidikan (GTK)
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Pondok Pesantren Raudhatul Ulum Sakatiga</p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($dewan as $idx => $d)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl border border-gray-100 transition transform hover:-translate-y-1.5 flex flex-col justify-between reveal-fade-up delay-{{ $idx % 4 }}">
                
                {{-- FOTO GURU --}}
                <div class="h-80 w-full overflow-hidden bg-gray-100 relative group">
                    <img src="{{ $d->photo_url }}" alt="{{ $d->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/kh-tolat-wafa-ahmad.webp'">
                    <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    @if($d->fraction)
                    <span class="absolute bottom-3 left-4 text-[11px] font-extrabold text-white bg-orange-500 px-3 py-1 rounded-full shadow">
                        {{ $d->fraction }}
                    </span>
                    @endif
                </div>

                {{-- DESKRIPSI GURU --}}
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-lg leading-snug hover:text-[#00913e] transition">
                            {{ $d->name }}
                        </h3>
                        <span class="text-xs font-semibold text-orange-600 block mt-1">{{ $d->position }}</span>
                        @if($d->profile_summary)
                        <div class="mt-3 text-xs text-gray-600 leading-relaxed font-light line-clamp-4">
                            {!! strip_tags($d->profile_summary) !!}
                        </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span class="font-medium text-emerald-700">Pondok Pesantren Raudhatul Ulum Sakatiga</span>
                        <span class="inline-flex items-center text-amber-500 font-semibold">
                            <i class="fa-solid fa-award mr-1"></i> Pendidik Berdedikasi
                        </span>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-chalkboard-user text-4xl text-gray-300 mb-3 block"></i>
                <span>Data dewan guru sedang diperbarui.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection
