@extends('layouts.frontend')

@section('title', ($post->meta_title ?: $post->title) . ' - ' . ($siteSettings['site_name'] ?? 'SMA IT Ishlahul Ummah Prabumulih'))
@section('og_title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))
@section('og_description', $post->meta_description ?: Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->meta_keywords)
@section('og_type', 'article')
@section('og_image', $post->featured_image ? asset($post->featured_image) : asset('/uploads/gedung-smait-ishum.webp'))

@section('content')
{{-- BREADCRUMB HEADER --}}
<div class="bg-gray-100 py-6 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-gray-500 flex flex-wrap items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-[#00913e] transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('artikel.index') }}" class="hover:text-[#00913e] transition">Berita</a>
            @if($post->categories->isNotEmpty())
                <span>/</span>
                <a href="{{ route('artikel.index', ['kategori' => $post->categories->first()->slug]) }}" class="hover:text-[#00913e] transition">
                    {{ $post->categories->first()->name }}
                </a>
            @endif
            <span>/</span>
            <span class="text-gray-800 font-medium line-clamp-1 max-w-xs sm:max-w-md">{{ $post->title }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        {{-- MAIN ARTICLE (2/3) --}}
        <article class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
            
            {{-- Category Pills --}}
            @if($post->categories->isNotEmpty())
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($post->categories as $cat)
                        <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="bg-emerald-100 text-[#00913e] hover:bg-[#00913e] hover:text-white transition text-xs font-bold px-3 py-1 rounded-full">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight leading-snug mb-4">
                {{ $post->title }}
            </h1>

            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center text-xs text-gray-500 gap-4 py-3 border-y border-gray-100 mb-6">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-user text-[#00913e]"></i>
                    <span>{{ $post->author?->name ?: 'Humas SMA IT Ishlahul Ummah Prabumulih' }}</span>
                </div>
                <span>&bull;</span>
                <div class="flex items-center space-x-2">
                    <i class="fa-regular fa-calendar text-[#00913e]"></i>
                    <span>{{ $post->published_at ? $post->published_at->translatedFormat('l, d F Y - H:i') : '-' }} WIB</span>
                </div>
                <span>&bull;</span>
                <div class="flex items-center space-x-2">
                    <i class="fa-regular fa-eye text-gray-400"></i>
                    <span>{{ number_format($post->views_count) }} kali dibaca</span>
                </div>
            </div>

            {{-- Featured Image --}}
            @if($post->featured_image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-md bg-gray-100">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover" onerror="this.style.display='none'">
                </div>
            @endif

            {{-- Article Content --}}
            <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed">
                {!! $post->content !!}
            </div>

            {{-- Tags --}}
            @if($post->tags->isNotEmpty())
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Tag Terkait:</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $t)
                            <a href="{{ route('artikel.index', ['tag' => $t->slug]) }}" class="text-xs bg-gray-100 hover:bg-[#00913e] hover:text-white text-gray-600 px-3 py-1 rounded-md transition">
                                #{{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Social Share Buttons --}}
            <div class="mt-8 p-5 bg-emerald-50/60 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs font-bold text-gray-700 uppercase tracking-wider flex items-center">
                    <i class="fa-solid fa-share-nodes text-[#00913e] mr-2 text-base"></i>
                    Bagikan Berita Ini:
                </div>
                <div class="flex items-center space-x-2">
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center transition shadow-sm" aria-label="Share WhatsApp">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition shadow-sm" aria-label="Share Facebook">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-sm" aria-label="Share Twitter">
                        <i class="fa-brands fa-x-twitter text-sm"></i>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="w-9 h-9 rounded-full bg-blue-400 hover:bg-blue-500 text-white flex items-center justify-center transition shadow-sm" aria-label="Share Telegram">
                        <i class="fa-brands fa-telegram text-sm"></i>
                    </a>
                    <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Link berita berhasil disalin!');" class="w-9 h-9 rounded-full bg-gray-600 hover:bg-gray-700 text-white flex items-center justify-center transition shadow-sm" title="Salin Link">
                        <i class="fa-solid fa-link text-sm"></i>
                    </button>
                </div>
            </div>

            {{-- Related Posts --}}
            @if($relatedPosts->isNotEmpty())
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-6">Kabar Sekolah Terkait</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        @foreach($relatedPosts as $rPost)
                            <a href="{{ route('artikel.show', $rPost->slug) }}" class="group block">
                                <div class="h-36 rounded-xl overflow-hidden bg-gray-100 mb-3 shadow-sm">
                                    @if($rPost->featured_image)
                                        <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/gedung-smait-ishum.webp'">
                                    @else
                                        <img src="/uploads/gedung-smait-ishum.webp" alt="{{ $rPost->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <span class="text-[10px] text-gray-400 block mb-1">
                                    {{ $rPost->published_at ? $rPost->published_at->translatedFormat('d M Y') : '-' }}
                                </span>
                                <h4 class="font-bold text-xs text-gray-900 line-clamp-2 group-hover:text-[#00913e] transition leading-snug">
                                    {{ $rPost->title }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>

        {{-- SIDEBAR (1/3) --}}
        <div class="space-y-8">
            {{-- Search Box --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-3 uppercase tracking-wider">Cari Artikel</h3>
                <form action="{{ route('artikel.index') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="Ketik kata kunci..." class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl pl-4 pr-10 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-[#00913e]" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            {{-- Categories --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Kategori Pilihan
                </h3>
                <ul class="space-y-2 text-xs">
                    @foreach($categories->take(12) as $cat)
                        <li>
                            <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="flex items-center justify-between py-1.5 px-2 rounded-lg hover:bg-emerald-50 hover:text-[#00913e] transition text-gray-600">
                                <span>{{ $cat->name }}</span>
                                <span class="text-gray-400 text-[11px] bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Recent Posts --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-sm text-gray-900 mb-4 uppercase tracking-wider pb-2 border-b border-gray-100">
                    Artikel Terbaru
                </h3>
                <div class="space-y-4">
                    @foreach($recentPosts as $rPost)
                        <div class="flex items-start space-x-3 group">
                            <a href="{{ route('artikel.show', $rPost->slug) }}" class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($rPost->featured_image)
                                    <img src="{{ $rPost->featured_image }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/gedung-smait-ishum.webp'">
                                @else
                                    <img src="/uploads/gedung-smait-ishum.webp" alt="{{ $rPost->title }}" class="w-full h-full object-cover">
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
                <span class="inline-block bg-[#da251c] text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full text-white">PPDB Online</span>
                <h4 class="text-lg font-extrabold text-white">Penerimaan Santri Baru</h4>
                <p class="text-xs text-emerald-100">Jadilah bagian dari generasi Qur'ani dan saintis berprestasi di SMA IT Ishlahul Ummah Prabumulih.</p>
                <a href="{{ route('ppdb.index') }}" class="inline-block w-full bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold py-2.5 rounded-xl text-xs transition shadow">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
