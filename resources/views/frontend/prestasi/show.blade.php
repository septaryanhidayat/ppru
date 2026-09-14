@extends('layouts.frontend')

@section('title', $item->title . ' - Prestasi Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', Str::limit(strip_tags($item->content), 155))

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('prestasi.index') }}" class="hover:text-white transition">Prestasi</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold truncate max-w-xs">{{ $item->title }}</span>
        </nav>
        <span class="inline-block bg-amber-400 text-emerald-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
            Raihan Prestasi
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight max-w-4xl">
            {{ $item->title }}
        </h1>
        <div class="flex items-center space-x-4 text-xs text-emerald-100 mt-3">
            <span class="flex items-center space-x-1.5">
                <i class="fa-regular fa-calendar"></i>
                <span>{{ $item->published_at ? $item->published_at->format('d F Y') : $item->created_at->format('d F Y') }}</span>
            </span>
            <span>•</span>
            <span class="flex items-center space-x-1.5">
                <i class="fa-solid fa-school"></i>
                <span>Pondok Pesantren Raudhatul Ulum</span>
            </span>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- MAIN CONTENT --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-sm space-y-6">
                @if($item->featured_image)
                    <div class="rounded-2xl overflow-hidden shadow-md bg-gray-100 max-h-[480px]">
                        <img src="{{ $item->featured_image }}" alt="{{ $item->title }}" class="w-full h-full object-cover" onerror="this.src='/uploads/campus-robbani.webp'">
                    </div>
                @endif

                <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">
                    {!! $item->content !!}
                </div>

                {{-- SHARE BUTTONS --}}
                <div class="pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Bagikan Kabar Baik Ini:</span>
                    <div class="flex items-center space-x-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($item->title . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-emerald-500 text-white flex items-center justify-center text-sm hover:bg-emerald-600 transition shadow-sm" title="Bagikan ke WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm hover:bg-blue-700 transition shadow-sm" title="Bagikan ke Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-6">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3 flex items-center space-x-2">
                    <i class="fa-solid fa-trophy text-amber-500"></i>
                    <span>Prestasi Lainnya</span>
                </h3>
                <div class="space-y-4">
                    @forelse($related as $rel)
                        <a href="{{ route('prestasi.show', $rel->slug) }}" class="flex items-center space-x-3 group">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 shadow-sm">
                                <img src="{{ $rel->featured_image ?: '/uploads/campus-robbani.webp' }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/campus-robbani.webp'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-semibold text-gray-800 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    {{ $rel->title }}
                                </h4>
                                <span class="text-[10px] text-gray-400 mt-1 block">
                                    {{ $rel->published_at ? $rel->published_at->format('d M Y') : $rel->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400">Belum ada prestasi lainnya.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-gradient-to-br from-emerald-900 to-[#00913e] text-white p-6 rounded-3xl shadow-lg space-y-3">
                <h3 class="font-black text-lg">Ingin Berprestasi Bersama Kami?</h3>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Daftarkan putra-putri Anda di Pondok Pesantren Raudhatul Ulum Sakatiga dan wujudkan potensi terbaiknya.
                </p>
                <a href="{{ route('ppdb.index') }}" class="inline-block w-full text-center bg-white text-[#00913e] font-bold py-2.5 px-4 rounded-xl text-xs hover:bg-emerald-50 transition shadow-md">
                    Daftar PPDB Online Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
