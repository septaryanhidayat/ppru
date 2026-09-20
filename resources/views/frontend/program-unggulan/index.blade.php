@extends('layouts.frontend')

@section('title', 'Program Unggulan Pesantren - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Program unggulan Pondok Pesantren Raudhatul Ulum Sakatiga: Tahfidz Qur\'an Mutqin, Dirasah Islamiyah, Sains & Riset, Bahasa Arab & Inggris, dan Kepemimpinan Santri.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Pendidikan</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Program Unggulan</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Program Unggulan Pondok Pesantren Raudhatul Ulum Sakatiga</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Kurikulum terpadu yang dirancang khusus untuk mengoptimalkan potensi ruhiyah, intelektual, dan kepemimpinan santri.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-[#da251c] uppercase tracking-wider block">Karakter &amp; Keahlian Abad 21</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Program Khusus Santri PPRU
        </h2>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 font-light">Mengasah kecakapan santri menjadi generasi mutafaqqih fiddin, cerdas, mandiri, dan berjiwa pemimpin.</p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($programs as $idx => $p)
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-md hover:shadow-2xl transition transform hover:-translate-y-1.5 flex flex-col justify-between group reveal-fade-up delay-{{ $idx % 3 }}">
                <div>
                    {{-- FOTO DOKUMENTASI PROGRAM --}}
                    <div class="h-48 sm:h-52 w-full overflow-hidden bg-slate-100 relative">
                        <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/images/hero-1.webp'">
                        <span class="absolute top-3.5 left-3.5 bg-[#00913e] text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
                            {{ $p->address ?: 'Program Unggulan' }}
                        </span>
                    </div>

                    <div class="p-6 sm:p-7 space-y-3">
                        <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 group-hover:text-[#00913e] transition leading-snug">
                            {{ $p->name }}
                        </h3>

                        @if($p->head_name)
                            <div class="text-xs text-[#da251c] font-semibold flex items-center">
                                <i class="fa-solid fa-user-check text-[10px] mr-1.5"></i>
                                <span>{{ $p->head_name }}</span>
                            </div>
                        @endif

                        @if($p->description)
                            <div class="text-xs text-gray-500 line-clamp-3 leading-relaxed font-light prose prose-sm">
                                {!! strip_tags($p->description) !!}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 sm:px-7 pb-6 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                    <span class="inline-flex items-center space-x-1.5 text-xs font-bold text-[#00913e]">
                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                        <span>Unggulan Terpadu</span>
                    </span>
                    <span class="text-[11px] text-gray-400 font-medium">PPRU Sakatiga</span>
                </div>
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
