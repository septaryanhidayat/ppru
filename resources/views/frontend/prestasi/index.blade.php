@extends('layouts.frontend')

@section('title', 'Prestasi Siswa & Guru - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Raihan prestasi membanggakan santri dan guru SMA Islam Terpadu Ishlahul Ummah Prabumulih di tingkat Kota, Provinsi, Nasional, hingga Internasional.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Prestasi Sekolah</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-trophy"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Prestasi &amp; Penghargaan</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Bukti nyata kesungguhan pembinaan akademik, sains, tahfidz Qur'an, dan minat bakat di SMA IT Ishum.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- STATS HIGHLIGHT --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm text-center">
            <span class="text-2xl sm:text-3xl font-black text-[#00913e] block">20+</span>
            <span class="text-xs text-gray-600 font-medium">Prestasi Tercatat</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm text-center">
            <span class="text-2xl sm:text-3xl font-black text-amber-500 block">30 Juz</span>
            <span class="text-xs text-gray-600 font-medium">Hafalan Qur'an</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm text-center">
            <span class="text-2xl sm:text-3xl font-black text-blue-600 block">Nasional</span>
            <span class="text-xs text-gray-600 font-medium">&amp; Internasional</span>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm text-center">
            <span class="text-2xl sm:text-3xl font-black text-purple-600 block">PTN &amp; PTKIN</span>
            <span class="text-xs text-gray-600 font-medium">Lolos SNBP</span>
        </div>
    </div>

    {{-- PRESTASI GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($prestasi as $idx => $item)
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group reveal-fade-up">
                <a href="{{ route('prestasi.show', $item->slug) }}" class="block relative h-52 overflow-hidden bg-gray-100">
                    <img src="{{ $item->featured_image ?: '/uploads/campus-robbani.jpg' }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-robbani.jpg'">
                    <span class="absolute top-3 left-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md flex items-center space-x-1.5">
                        <i class="fa-solid fa-award text-xs"></i>
                        <span>Juara &amp; Prestasi</span>
                    </span>
                </a>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="text-[11px] text-gray-400 mb-2 flex items-center space-x-1.5">
                            <i class="fa-regular fa-calendar text-[#00913e]"></i>
                            <span>{{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                            <a href="{{ route('prestasi.show', $item->slug) }}">
                                {{ $item->title }}
                            </a>
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 mt-2 font-light leading-relaxed">
                            {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
                        </p>
                    </div>
                    <div class="pt-3 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-xs font-semibold text-[#00913e] flex items-center space-x-1 group-hover:translate-x-1 transition">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-trophy text-4xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 font-medium">Belum ada data prestasi yang ditampilkan.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-10">
        {{ $prestasi->links() }}
    </div>
</div>
@endsection
