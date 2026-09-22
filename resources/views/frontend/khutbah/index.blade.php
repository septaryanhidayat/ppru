@extends('layouts.frontend')

@section('title', 'Mimbar Khutbah Jum\'at & Kajian Dakwah - PPRU Sakatiga')
@section('meta_description', 'Koleksi naskah khutbah Jum\'at, khutbah Idul Fitri, khutbah Idul Adha, dan materi dakwah resmi Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- 1. HERO HEADER MIMBAR KHUTBAH --}}
<div class="relative bg-gradient-to-r from-emerald-950 via-[#006e30] to-slate-950 text-white py-14 sm:py-18 overflow-hidden">
    {{-- Glow Background Accents --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="text-xs text-emerald-200/90 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Khutbah Jum'at</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-emerald-900/80 border border-emerald-500/40 text-xs text-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="font-bold tracking-wider uppercase text-[11px]">Mimbar Dakwah &amp; Khutbah • YAPIRUS PPRU</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    Naskah Khutbah <span class="text-[#f59e0b]">Jum'at</span> &amp; Kajian Dakwah
                </h1>

                <p class="text-sm sm:text-base text-emerald-100/90 leading-relaxed max-w-2xl font-light">
                    Koleksi naskah khutbah bermutu tinggi lengkap dengan mukaddimah bahasa Arab berharakat, wasiat taqwa, dalil ayat dan hadits pilihan karya para masyayikh serta dewan asatidz Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>

                {{-- Fitur Pendukung Khatib --}}
                <div class="pt-2 flex flex-wrap items-center gap-3 text-xs text-emerald-200">
                    <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg border border-white/15">
                        <i class="fa-solid fa-check-double text-amber-400"></i> Lengkap Rukun Syar'i
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg border border-white/15">
                        <i class="fa-solid fa-print text-amber-400"></i> Format Siap Cetak
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg border border-white/15">
                        <i class="fa-solid fa-mobile-screen-button text-amber-400"></i> Mode Baca Gawai / Tablet
                    </span>
                </div>
            </div>

            {{-- Kolom Kanan: Search Box Naskah --}}
            <div class="lg:col-span-4 bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/15 space-y-4 shadow-xl">
                <div class="flex items-center space-x-2 text-amber-300 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Cari Naskah Khutbah</span>
                </div>
                <form action="{{ route('khutbah.index') }}" method="GET" class="space-y-3">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik topik, judul, atau nama khatib..." class="w-full bg-white text-gray-800 text-xs rounded-xl pl-9 pr-4 py-3 shadow-inner focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
                    </div>

                    @if(request('tema'))
                        <input type="hidden" name="tema" value="{{ request('tema') }}">
                    @endif

                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 font-black text-xs py-2.5 rounded-xl transition shadow">
                            Cari Naskah
                        </button>
                        @if(request('q') || request('tema'))
                            <a href="{{ route('khutbah.index') }}" class="bg-white/20 hover:bg-white/30 text-white font-semibold text-xs px-3 py-2.5 rounded-xl transition" title="Reset filter">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- 2. TEMA / TOPIK FILTER BAR --}}
<div class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 sticky top-0 z-30 shadow-xs transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider mr-2 shrink-0 flex items-center gap-1.5">
                <i class="fa-solid fa-layer-group text-[#00843d] dark:text-emerald-400"></i> Tema:
            </span>
            @foreach($themes as $t)
                @php
                    $isActive = request('tema') === $t['slug'] || (!request('tema') && $t['slug'] === '');
                @endphp
                <a href="{{ route('khutbah.index', array_filter(['tema' => $t['slug'], 'q' => request('q')])) }}" 
                   class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition {{ $isActive ? 'bg-[#00843d] text-white shadow-sm' : 'bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white border border-transparent dark:border-slate-700' }}">
                    <i class="{{ $t['icon'] }} text-[11px] {{ $isActive ? 'text-amber-300' : 'text-gray-400 dark:text-slate-400' }}"></i>
                    <span>{{ $t['name'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- 3. NASKAH PILIHAN PEKAN INI (FEATURED KHUTBAH) --}}
    @if($featured && !request('q') && !request('tema'))
        <div class="mb-12 bg-gradient-to-br from-emerald-900 via-[#006e30] to-emerald-950 rounded-3xl p-6 sm:p-8 lg:p-10 text-white shadow-xl relative overflow-hidden border border-emerald-500/30">
            <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center relative z-10">
                <div class="lg:col-span-8 space-y-3">
                    <div class="inline-flex items-center gap-2 bg-amber-400 text-slate-950 px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider shadow">
                        <i class="fa-solid fa-star text-[10px]"></i>
                        <span>Naskah Pilihan Pekan Ini</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-snug">
                        <a href="{{ route('khutbah.show', $featured->slug) }}" class="hover:text-amber-300 transition">
                            {{ $featured->title }}
                        </a>
                    </h2>

                    <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-light">
                        {{ $featured->excerpt ?: Str::limit(strip_tags($featured->content), 200) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-emerald-200/90 pt-1">
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-user-tie text-amber-300"></i>
                            <span class="font-medium">{{ $featured->author_name ?: ($featured->author?->name ?? 'Dewan Asatidz PPRU') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-check text-amber-300"></i>
                            <span>{{ ($featured->published_at ?? $featured->created_at)->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-amber-300"></i>
                            <span>7-10 Menit Durasi Khutbah</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center items-stretch">
                    <a href="{{ route('khutbah.show', $featured->slug) }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 font-black text-xs px-6 py-3.5 rounded-xl shadow-lg transition text-center flex items-center justify-center gap-2 transform hover:scale-102">
                        <i class="fa-solid fa-book-open-reader"></i>
                        <span>BACA NASKAH LENGKAP</span>
                    </a>
                    <a href="{{ route('khutbah.show', $featured->slug) }}#print" class="bg-white/10 hover:bg-white/20 text-white border border-white/25 font-bold text-xs px-6 py-3.5 rounded-xl transition text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-print text-amber-300"></i>
                        <span>Cetak Naskah</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- 4. DAFTAR ARSIP NASKAH KHUTBAH --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-microphone-lines text-[#00843d] dark:text-emerald-400"></i>
                <span>Koleksi Naskah Khutbah</span>
            </h2>
            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                Menampilkan total <strong>{{ $totalKhutbah }}</strong> naskah khutbah dan kajian dakwah resmi
                @if(request('q'))
                    dengan kata kunci <em>"{{ request('q') }}"</em>
                @endif
            </p>
        </div>
    </div>

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($posts as $post)
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-md hover:shadow-xl border border-gray-100 dark:border-slate-800 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1">
                    <div class="space-y-3">
                        {{-- Top Badges: Rubrik & Waktu Baca --}}
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1 bg-emerald-50 dark:bg-emerald-950/80 text-[#00843d] dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80 text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                                <i class="fa-solid fa-microphone text-[10px]"></i> Khutbah Jum'at
                            </span>
                            <span class="text-[11px] text-gray-400 dark:text-slate-400 flex items-center gap-1">
                                <i class="fa-regular fa-clock text-[10px]"></i> 7-10 mnt
                            </span>
                        </div>

                        {{-- Judul Khutbah --}}
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white leading-snug group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition line-clamp-2">
                            <a href="{{ route('khutbah.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        {{-- Ringkasan / Excerpt --}}
                        <p class="text-xs text-gray-600 dark:text-slate-300 leading-relaxed line-clamp-3 font-light">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 140) }}
                        </p>
                    </div>

                    {{-- Footer Kartu Khutbah --}}
                    <div class="pt-4 mt-4 border-t border-gray-100 dark:border-slate-800 space-y-3">
                        <div class="flex items-center justify-between text-[11px] text-gray-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5 truncate max-w-[170px]" title="{{ $post->author_name ?: ($post->author?->name ?? 'Dewan Asatidz PPRU') }}">
                                <i class="fa-solid fa-user-tie text-emerald-700 dark:text-emerald-400"></i>
                                <span class="truncate text-gray-600 dark:text-slate-300">{{ $post->author_name ?: ($post->author?->name ?? 'Dewan Asatidz PPRU') }}</span>
                            </span>
                            <span class="flex items-center gap-1 shrink-0 text-gray-400 dark:text-slate-400">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ ($post->published_at ?? $post->created_at)->isoFormat('D MMM Y') }}</span>
                            </span>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <a href="{{ route('khutbah.show', $post->slug) }}" class="flex-1 bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs py-2.5 rounded-xl text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-book-open-reader text-[11px]"></i>
                                <span>Baca Naskah</span>
                            </a>
                            <a href="{{ route('khutbah.show', $post->slug) }}#print" class="bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 text-xs px-3.5 py-2.5 rounded-xl transition flex items-center justify-center shadow-xs" title="Cetak naskah untuk mimbar">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-12 text-center border border-gray-200 dark:border-slate-800 max-w-lg mx-auto shadow-sm space-y-4">
            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-950/80 text-[#00843d] dark:text-emerald-300 rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-file-circle-question"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada Naskah Khutbah yang Cocok</h3>
            <p class="text-xs text-gray-500 dark:text-slate-400 leading-relaxed">
                Tidak ditemukan naskah khutbah dengan kriteria pencarian yang Anda masukkan. Silakan coba kata kunci lain atau bersihkan filter.
            </p>
            <div class="pt-2">
                <a href="{{ route('khutbah.index') }}" class="inline-flex items-center gap-2 bg-[#00843d] hover:bg-[#006e30] text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    <span>Tampilkan Semua Naskah</span>
                </a>
            </div>
        </div>
    @endif

    {{-- 5. CALLOUT PANDUAN KHATIB --}}
    <div class="mt-14 bg-emerald-50/70 dark:bg-slate-900 border border-emerald-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 text-emerald-950 dark:text-slate-200">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-[#00843d] dark:text-emerald-400 uppercase tracking-wider">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Panduan Syar'i Khutbah Jum'at</span>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-gray-900 dark:text-white">Rukun dan Adab Khutbah Jum'at</h3>
                <p class="text-xs text-gray-700 dark:text-slate-300 leading-relaxed max-w-3xl font-light">
                    Setiap naskah khutbah yang diterbitkan di portal ini telah melalui penelaahan rukun-rukun khutbah: <strong>Hamdalah</strong>, <strong>Shalawat kepada Nabi SAW</strong>, <strong>Wasiat Taqwa</strong>, <strong>Membaca ayat Al-Qur'an</strong> pada salah satu khutbah, dan <strong>Doa ampunan bagi kaum muslimin</strong> pada khutbah kedua. Naskah dapat diunduh, dicetak, maupun langsung dibaca dari ponsel/tablet saat bertugas di atas mimbar.
                </p>
            </div>
            <a href="{{ route('hubungi') }}" class="bg-[#00843d] hover:bg-[#006e30] text-white text-xs font-bold px-5 py-3 rounded-xl transition shrink-0 flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Kirim Naskah Khutbah</span>
            </a>
        </div>
    </div>

</div>
@endsection
