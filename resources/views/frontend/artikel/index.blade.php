@extends('layouts.frontend')

@section('title', 'Berita & Artikel - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Kumpulan berita sekolah, prestasi siswa, kegiatan akademik, tahfidz, dan artikel edukasi Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Berita & Artikel</span>
            @if($activeCategory)
                <span>/</span>
                <span class="text-white font-medium">{{ $activeCategory->name }}</span>
            @endif
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
            @if($activeCategory)
                Kategori: <span class="text-amber-300">{{ $activeCategory->name }}</span>
            @elseif($activeTag)
                Tag: <span class="text-amber-300">#{{ $activeTag->name }}</span>
            @elseif(request('q'))
                Pencarian: <span class="text-amber-300">"{{ request('q') }}"</span>
            @else
                Kabar & Prestasi Sekolah
            @endif
        </h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Informasi kegiatan santri, prestasi akademik & tahfidz, serta kabar terkini Pondok Pesantren Raudhatul Ulum Sakatiga.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- MAIN CONTENT (2/3) --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Category Filter Pills --}}
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none text-xs">
                <a href="{{ route('artikel.index') }}" class="px-3.5 py-1.5 rounded-full font-medium whitespace-nowrap transition {{ !request('kategori') && !request('tag') ? 'bg-[#00913e] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-[#00913e]' }}">
                    Semua
                </a>
                @foreach($categories->take(8) as $cat)
                    <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="px-3.5 py-1.5 rounded-full font-medium whitespace-nowrap transition {{ request('kategori') == $cat->slug ? 'bg-[#00913e] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-[#00913e]' }}">
                        {{ $cat->name }} ({{ $cat->posts_count }})
                    </a>
                @endforeach
            </div>

            {{-- Articles Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($posts as $idx => $post)
                    <article class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group reveal-fade-up delay-{{ $idx % 4 }} hover:-translate-y-1">
                        <a href="{{ route('artikel.show', $post->slug) }}" class="block relative h-48 overflow-hidden bg-gray-100 dark:bg-slate-800">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/images/hero-1.webp'">
                            @else
                                <img src="/images/hero-1.webp" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @endif
                            @if($post->categories->isNotEmpty())
                                <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm">
                                    {{ $post->categories->first()->name }}
                                </span>
                            @endif
                            @if($post->is_featured)
                                <span class="absolute top-3 right-3 bg-amber-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm flex items-center gap-1">
                                    <i class="fa-solid fa-thumbtack text-[9px]"></i> Headline
                                </span>
                            @endif
                        </a>

                        <div class="p-5 flex-grow flex flex-col justify-between space-y-3">
                            <div>
                                <div class="flex items-center text-[11px] text-gray-400 dark:text-slate-400 gap-2 mb-2 flex-wrap">
                                    <span><i class="fa-regular fa-calendar mr-1 text-[#00913e] dark:text-emerald-400"></i>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-clock mr-1 text-[#00913e] dark:text-emerald-400"></i>{{ $post->reading_time }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($post->views_count) }}</span>
                                </div>
                                <h2 class="font-bold text-gray-900 dark:text-white text-sm sm:text-base line-clamp-2 group-hover:text-[#00913e] dark:group-hover:text-emerald-400 transition">
                                    <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-slate-300 line-clamp-2 mt-2 font-light">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                            <div class="pt-2 border-t border-gray-50 dark:border-slate-800 flex items-center justify-between text-xs font-semibold text-[#00913e] dark:text-emerald-400 group-hover:text-orange-600 dark:group-hover:text-amber-400">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-2 text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <i class="fa-solid fa-newspaper text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
                        <h3 class="text-base font-bold text-gray-700 dark:text-slate-200">Tidak ada artikel ditemukan</h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        <a href="{{ route('artikel.index') }}" class="inline-block mt-4 text-xs font-semibold text-[#00913e] dark:text-emerald-400 hover:underline">
                            Kembali ke Semua Artikel
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pt-6">
                {{ $posts->links() }}
            </div>
        </div>

        {{-- SIDEBAR (1/3) --}}
        <div class="space-y-8">
            
            {{-- Search Box --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-3 uppercase tracking-wider">Cari Artikel</h3>
                <form action="{{ route('artikel.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Ketik kata kunci..." value="{{ request('q') }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl pl-4 pr-10 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-[#00913e]" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            {{-- Modern Categories Widget --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100/90 dark:border-slate-800 overflow-hidden relative group/card transition-colors">
                <div class="h-1 bg-gradient-to-r from-[#00843d] via-emerald-400 to-[#f59e0b]"></div>
                <div class="p-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100 dark:border-slate-800">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-slate-800 text-[#00843d] dark:text-emerald-400 flex items-center justify-center text-xs shadow-inner">
                                <i class="fa-solid fa-shapes"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-xs tracking-wider uppercase text-gray-900 dark:text-white">Kategori Pilihan</h3>
                                <p class="text-[10px] text-gray-400 dark:text-slate-400 font-medium">Jelajahi rubrik &amp; topik</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50/80 dark:bg-slate-800 px-2.5 py-0.5 rounded-full border border-emerald-100 dark:border-slate-700">
                            {{ $categories->count() }} Topik
                        </span>
                    </div>

                    @php
                        $catIcons = [
                            'ikarus' => ['icon' => 'fa-solid fa-graduation-cap', 'color' => 'text-sky-600', 'bg' => 'bg-sky-50'],
                            'berita' => ['icon' => 'fa-solid fa-newspaper', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50'],
                            'khutbah' => ['icon' => 'fa-solid fa-microphone-lines', 'color' => 'text-teal-600', 'bg' => 'bg-teal-50'],
                            'taujih' => ['icon' => 'fa-solid fa-scroll', 'color' => 'text-teal-600', 'bg' => 'bg-teal-50'],
                            'prestasi' => ['icon' => 'fa-solid fa-trophy', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
                            'pendidikan' => ['icon' => 'fa-solid fa-school', 'color' => 'text-indigo-600', 'bg' => 'bg-indigo-50'],
                            'tahfidz' => ['icon' => 'fa-solid fa-book-quran', 'color' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
                            'kegiatan' => ['icon' => 'fa-solid fa-users', 'color' => 'text-cyan-600', 'bg' => 'bg-cyan-50'],
                            'ekstrakurikuler' => ['icon' => 'fa-solid fa-futbol', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'],
                            'ekskul' => ['icon' => 'fa-solid fa-futbol', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'],
                            'kesiswaan' => ['icon' => 'fa-solid fa-person-chalkboard', 'color' => 'text-rose-600', 'bg' => 'bg-rose-50'],
                            'kampus' => ['icon' => 'fa-solid fa-landmark', 'color' => 'text-violet-600', 'bg' => 'bg-violet-50'],
                        ];
                    @endphp

                    <div class="space-y-1.5 text-xs">
                        @foreach($categories->take(12) as $cat)
                            @php
                                $cSlug = strtolower($cat->slug . ' ' . $cat->name);
                                $iconData = ['icon' => 'fa-solid fa-tag', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50'];
                                foreach($catIcons as $key => $val) {
                                    if (str_contains($cSlug, $key)) {
                                        $iconData = $val;
                                        break;
                                    }
                                }
                                $isActive = request('kategori') == $cat->slug;
                            @endphp

                            @if($isActive)
                                <a href="{{ route('artikel.index') }}" class="group flex items-center justify-between p-2 rounded-xl bg-gradient-to-r from-emerald-600 to-[#00843d] text-white shadow-sm shadow-emerald-700/20 border border-emerald-600 transition-all duration-200" title="Klik untuk hapus filter kategori">
                                    <div class="flex items-center space-x-2.5 min-w-0">
                                        <span class="w-7 h-7 rounded-lg bg-white/20 text-white flex items-center justify-center shrink-0 text-xs shadow-sm">
                                            <i class="{{ $iconData['icon'] }}"></i>
                                        </span>
                                        <span class="font-bold text-xs truncate">{{ $cat->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1.5 shrink-0 ml-2">
                                        <span class="text-[10px] font-extrabold bg-white/25 text-white px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                                        <i class="fa-solid fa-circle-xmark text-white/80 text-xs group-hover:text-white transition"></i>
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="group flex items-center justify-between p-2 rounded-xl bg-white dark:bg-slate-800/80 hover:bg-emerald-50/60 dark:hover:bg-slate-750 border border-gray-100 dark:border-slate-700 hover:border-emerald-200 dark:hover:border-slate-600 text-gray-700 dark:text-slate-200 hover:text-[#00843d] dark:hover:text-emerald-400 transition-all duration-200">
                                    <div class="flex items-center space-x-2.5 min-w-0">
                                        <span class="w-7 h-7 rounded-lg {{ $iconData['bg'] }} {{ $iconData['color'] }} group-hover:bg-white dark:group-hover:bg-slate-900 flex items-center justify-center shrink-0 text-xs transition-colors shadow-none group-hover:shadow-sm">
                                            <i class="{{ $iconData['icon'] }}"></i>
                                        </span>
                                        <span class="font-semibold text-xs text-gray-700 dark:text-slate-200 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 truncate group-hover:translate-x-0.5 transition-transform">{{ $cat->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1 shrink-0 ml-2">
                                        <span class="text-[11px] font-bold text-gray-400 dark:text-slate-400 bg-gray-100 dark:bg-slate-700 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-950/80 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 px-2 py-0.5 rounded-full transition-colors">{{ $cat->posts_count }}</span>
                                        <i class="fa-solid fa-chevron-right text-[9px] text-gray-300 dark:text-slate-500 group-hover:text-emerald-500 group-hover:translate-x-0.5 transition-all"></i>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Recent Posts Widget --}}
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 transition-colors">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 uppercase tracking-wider pb-2 border-b border-gray-100 dark:border-slate-800">
                    Artikel Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach($recentPosts as $rPost)
                        <div class="flex items-start space-x-3 group">
                            <a href="{{ route('artikel.show', $rPost->slug) }}" class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-800 flex-shrink-0">
                                @if($rPost->featured_image)
                                    <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.onerror=null;this.src='/images/hero-1.webp'">
                                @else
                                    <img src="/images/hero-1.webp" alt="{{ $rPost->title }}" class="w-full h-full object-cover">
                                @endif
                            </a>
                            <div class="flex-grow">
                                <span class="text-[10px] text-gray-400 block mb-1">
                                    {{ $rPost->published_at ? $rPost->published_at->translatedFormat('d M Y') : '-' }}
                                </span>
                                <h4 class="text-xs font-bold text-gray-800 line-clamp-2 group-hover:text-[#00913e] transition leading-snug">
                                    <a href="{{ route('artikel.show', $rPost->slug) }}">{{ $rPost->title }}</a>
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Banner PPDB --}}
            <div class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-emerald-900 to-[#00913e] p-6 text-white text-center space-y-3">
                <span class="inline-block bg-orange-500 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full text-white">PPDB Online</span>
                <h4 class="text-lg font-extrabold text-white">Penerimaan Santri Baru</h4>
                <p class="text-xs text-emerald-100">Jadilah bagian dari generasi Qur'ani dan saintis berprestasi di Pondok Pesantren Raudhatul Ulum Sakatiga.</p>
                <a href="{{ route('hubungi') }}" class="inline-block w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-2.5 rounded-xl text-xs hover:from-orange-600 hover:to-amber-600 transition shadow">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
