@extends('layouts.frontend')

@section('title', $unit->name . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', Str::limit(strip_tags($unit->description), 160))

@section('content')
{{-- HERO BANNER --}}
<div class="relative bg-gradient-to-br from-[#006830] via-[#00843d] to-[#053d1c] text-white py-14 sm:py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-5xl mx-auto space-y-4 relative z-10">
        <div class="flex flex-wrap items-center gap-2">
            <span class="bg-[#00843d] border border-white/20 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-xs">
                {{ $unit->category_type }}
            </span>
            @if($unit->badge)
                <span class="bg-[#f59e0b] text-slate-900 text-xs font-black px-3 py-1 rounded-full shadow-xs">
                    {{ $unit->badge }}
                </span>
            @endif
            @if($unit->short_name)
                <span class="bg-white/20 text-white text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-xs">
                    {{ $unit->short_name }}
                </span>
            @endif
        </div>
        <h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight">
            {{ $unit->name }}
        </h1>
        @if($unit->curriculum)
            <p class="text-xs sm:text-sm text-emerald-100 font-medium flex items-center">
                <i class="fa-solid fa-book-quran mr-2 text-[#f59e0b]"></i>
                <span>{{ $unit->curriculum }}</span>
            </p>
        @endif
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100 py-3 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2 text-xs text-gray-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#00843d] flex items-center"><i class="fa-solid fa-house mr-1 text-[#00843d]"></i> Beranda</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('pendidikan.index') }}" class="hover:text-[#00843d]">Unit Pendidikan</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-800 font-bold truncate">{{ $unit->name }}</span>
    </div>
</div>

{{-- CONTENT DETAIL --}}
<div class="py-12 bg-gray-50/70 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">
                    @if($unit->thumbnail)
                        <div class="rounded-2xl overflow-hidden shadow-md">
                            <img src="{{ $unit->thumbnail_url }}" alt="{{ $unit->name }}" class="w-full h-auto max-h-[420px] object-cover">
                        </div>
                    @endif

                    <div class="prose-content text-gray-700 leading-relaxed space-y-4">
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 border-b border-gray-100 pb-3">
                            Tentang {{ $unit->name }}
                        </h2>
                        {!! nl2br(e($unit->description)) !!}
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-wrap gap-3">
                        <a href="{{ route('ppdb.form') }}" class="bg-[#00843d] hover:bg-[#006830] text-white text-xs font-black px-6 py-3 rounded-full shadow-md hover:shadow-lg transition flex items-center space-x-2">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Daftar Santri Baru (PSB Online)</span>
                        </a>
                        @if($unit->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone) }}?text=Assalamu%27alaikum%20Admin%20{{ urlencode($unit->name) }}%2C%20saya%20ingin%20konsultasi%20informasi%20pendaftaran" target="_blank" class="bg-emerald-50 hover:bg-emerald-100 text-[#00843d] text-xs font-bold px-5 py-3 rounded-full transition flex items-center space-x-2">
                                <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                                <span>Hubungi Pengelola Unit</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Quick Info Box --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                    <h3 class="text-sm font-black text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#00843d]"></span>
                        <span>Informasi Singkat</span>
                    </h3>
                    
                    <ul class="space-y-3 text-xs">
                        <li class="flex justify-between py-1.5 border-b border-gray-50">
                            <span class="text-gray-500">Tipe Sekolah:</span>
                            <span class="font-bold text-gray-900">{{ $unit->category_type }}</span>
                        </li>
                        @if($unit->badge)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Akreditasi:</span>
                                <span class="font-bold text-amber-600">{{ $unit->badge }}</span>
                            </li>
                        @endif
                        @if($unit->curriculum)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Kurikulum:</span>
                                <span class="font-bold text-gray-900 text-right">{{ $unit->curriculum }}</span>
                            </li>
                        @endif
                        @if($unit->head_name)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Pimpinan:</span>
                                <span class="font-bold text-gray-900 text-right">{{ $unit->head_name }}</span>
                            </li>
                        @endif
                        @if($unit->phone)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Kontak:</span>
                                <span class="font-bold text-gray-900">{{ $unit->phone }}</span>
                            </li>
                        @endif
                        @if($unit->email)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Email:</span>
                                <span class="font-bold text-gray-900">{{ $unit->email }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Other Units --}}
                @if($otherUnits->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                        <h3 class="text-sm font-black text-gray-900 border-b border-gray-100 pb-3">
                            Unit Pendidikan Lainnya
                        </h3>
                        <div class="space-y-2.5">
                            @foreach($otherUnits as $ou)
                                <a href="{{ route('pendidikan.show', $ou->slug) }}" class="flex items-center space-x-3 p-2.5 rounded-2xl hover:bg-emerald-50/50 transition group">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs shrink-0 group-hover:bg-[#00843d] group-hover:text-white transition">
                                        <i class="{{ $ou->icon ?: 'fa-solid fa-school' }}"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-800 truncate group-hover:text-[#00843d] transition">{{ $ou->name }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $ou->category_type }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
