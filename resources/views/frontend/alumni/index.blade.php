@extends('layouts.frontend')

@section('title', 'Data Alumni - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Database dan profil alumni Pondok Pesantren Raudhatul Ulum Sakatiga: jejak langkah lulusan di perguruan tinggi dan dunia profesional.')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Data Alumni</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Data Alumni Kebanggaan</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Kiprah dan rekam jejak lulusan Pondok Pesantren Raudhatul Ulum Sakatiga di berbagai penjuru nusantara.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @forelse($alumni as $idx => $item)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 text-center flex flex-col items-center group reveal-fade-up">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden mb-4 bg-emerald-50 ring-4 ring-emerald-100 shadow-md group-hover:scale-105 transition">
                    <img src="{{ $item->featured_image ?: '/uploads/logo-ppru-square.png' }}" alt="{{ $item->title }}" class="w-full h-full object-cover" onerror="this.src='/uploads/logo-ppru-square.png'">
                </div>
                <h3 class="font-bold text-gray-900 text-sm sm:text-base group-hover:text-[#00913e] transition line-clamp-1">
                    {{ $item->title }}
                </h3>
                <span class="text-xs text-[#00913e] font-semibold mt-1">
                    {{ $item->excerpt ?: 'Alumni SMA IT PPRU' }}
                </span>
                <span class="inline-block mt-3 bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                    Terverifikasi
                </span>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-user-graduate text-4xl text-gray-300 mb-3 block"></i>
                <p class="text-gray-500 font-medium">Data alumni sedang diperbarui.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $alumni->links() }}
    </div>
</div>
@endsection
