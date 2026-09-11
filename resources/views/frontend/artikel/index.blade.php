@extends('layouts.frontend')

@section('title', 'Berita & Artikel - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Kumpulan berita sekolah, prestasi siswa, kegiatan akademik, tahfidz, dan artikel edukasi SMA Islam Terpadu Ishlahul Ummah Prabumulih.')

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
            Informasi kegiatan santri, prestasi akademik & tahfidz, serta kabar terkini SMA IT Ishlahul Ummah Prabumulih.
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
                    <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group reveal-fade-up delay-{{ $idx % 4 }}">
                        <a href="{{ route('artikel.show', $post->slug) }}" class="block relative h-48 overflow-hidden bg-gray-100">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ishum.jpg'">
                            @else
                                <img src="/uploads/campus-ishum.jpg" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @endif
                            @if($post->categories->isNotEmpty())
                                <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                    {{ $post->categories->first()->name }}
                                </span>
                            @endif
                        </a>

                        <div class="p-5 flex-grow flex flex-col justify-between space-y-3">
                            <div>
                                <div class="flex items-center text-[11px] text-gray-400 space-x-2 mb-2">
                                    <span><i class="fa-regular fa-calendar mr-1 text-[#00913e]"></i>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '-' }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-eye mr-1"></i>{{ number_format($post->views_count) }}</span>
                                </div>
                                <h2 class="font-bold text-gray-900 text-sm sm:text-base line-clamp-2 group-hover:text-[#00913e] transition">
                                    <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-xs text-gray-500 line-clamp-2 mt-2 font-light">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                            <div class="pt-2 border-t border-gray-50 flex items-center justify-between text-xs font-semibold text-[#00913e] group-hover:text-orange-600">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-2 text-center py-16 bg-white rounded-2xl border border-gray-100">
                        <i class="fa-solid fa-newspaper text-4xl text-gray-300 mb-3"></i>
                        <h3 class="text-base font-bold text-gray-700">Tidak ada artikel ditemukan</h3>
                        <p class="text-xs text-gray-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        <a href="{{ route('artikel.index') }}" class="inline-block mt-4 text-xs font-semibold text-[#00913e] hover:underline">
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

            {{-- Categories Widget --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Kategori Pilihan
                </h3>
                <ul class="space-y-2 text-xs">
                    @foreach($categories->take(12) as $cat)
                        <li>
                            <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="flex items-center justify-between py-1.5 px-2 rounded-lg hover:bg-emerald-50 hover:text-[#00913e] transition {{ request('kategori') == $cat->slug ? 'text-[#00913e] font-bold bg-emerald-50' : 'text-gray-600' }}">
                                <span class="flex items-center"><i class="fa-solid fa-folder-open mr-2 text-emerald-400"></i>{{ $cat->name }}</span>
                                <span class="text-gray-400 text-[11px] bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Recent Posts Widget --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Artikel Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach($recentPosts as $rPost)
                        <div class="flex items-start space-x-3 group">
                            <a href="{{ route('artikel.show', $rPost->slug) }}" class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($rPost->featured_image)
                                    <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/campus-ishum.jpg'">
                                @else
                                    <img src="/uploads/campus-ishum.jpg" alt="{{ $rPost->title }}" class="w-full h-full object-cover">
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
                <p class="text-xs text-emerald-100">Jadilah bagian dari generasi Qur'ani dan saintis berprestasi di SMA IT Ishlahul Ummah Prabumulih.</p>
                <a href="{{ route('hubungi') }}" class="inline-block w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-2.5 rounded-xl text-xs hover:from-orange-600 hover:to-amber-600 transition shadow">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
