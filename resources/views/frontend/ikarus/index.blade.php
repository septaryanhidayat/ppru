@extends('layouts.frontend')

@section('title', 'IKARUS - Ikatan Keluarga Alumni Raudhatul Ulum Sakatiga')
@section('meta_description', 'Portal resmi IKARUS: Berita, kabar silaturahmi, gagasan, opini, dan karya tulis pemikiran alumni Pondok Pesantren Raudhatul Ulum Sakatiga di seluruh penjuru dunia.')

@section('content')
{{-- 1. HERO HEADER IKARUS --}}
<div class="relative bg-gradient-to-r from-emerald-950 via-[#006e30] to-slate-950 text-white py-14 sm:py-18 overflow-hidden">
    {{-- Glow Background Accents --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="text-xs text-emerald-200/90 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Alumni (IKARUS)</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-emerald-900/80 border border-emerald-500/40 text-xs text-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="font-bold tracking-wider uppercase text-[11px]">Portal Resmi Alumni • YAPIRUS PPRU</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                    <span class="text-white">IKARUS</span> — <span class="text-[#f59e0b]">Ikatan Keluarga Alumni</span> <br class="hidden sm:inline">Raudhatul Ulum
                </h1>

                <p class="text-sm sm:text-base text-emerald-100/90 leading-relaxed max-w-2xl font-light">
                    Wadah silaturahmi, pertukaran gagasan, kabar kiprah, dan karya tulis pemikiran ribuan alumni Pondok Pesantren Raudhatul Ulum Sakatiga di penjuru nusantara dan mancanegara.
                </p>

                {{-- Action Buttons & Search --}}
                <div class="pt-2 flex flex-wrap items-center gap-3">
                    <a href="#kirim-karya" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 px-5 py-2.5 rounded-xl font-black text-xs shadow-lg shadow-amber-500/20 transition flex items-center space-x-2 transform hover:scale-102">
                        <i class="fa-solid fa-pen-nib text-xs"></i>
                        <span>Kirim Tulisan Alumni</span>
                    </a>
                    <a href="{{ route('alumni.index') }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-5 py-2.5 rounded-xl font-bold text-xs transition flex items-center space-x-2">
                        <i class="fa-solid fa-id-card text-xs text-amber-300"></i>
                        <span>Direktori Data Alumni</span>
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan: Search Box --}}
            <div class="lg:col-span-4 bg-white/10 backdrop-blur-md p-6 rounded-3xl border border-white/15 space-y-4">
                <div class="flex items-center space-x-2 text-amber-300 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Cari Karya &amp; Berita Alumni</span>
                </div>
                <form action="{{ route('ikarus.index') }}" method="GET" class="space-y-3">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik judul, topik, atau nama penulis alumni..." class="w-full bg-white text-gray-800 text-xs rounded-xl pl-9 pr-4 py-3 shadow-inner focus:outline-none focus:ring-2 focus:ring-[#f59e0b]">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-gray-400 text-xs"></i>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-grow bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition shadow-md">
                            Filter Tulisan
                        </button>
                        @if(request('q'))
                            <a href="{{ route('ikarus.index') }}" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs py-2.5 px-3 rounded-xl transition" title="Reset Pencarian">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </form>
                <p class="text-[11px] text-emerald-200/80 leading-snug">
                    <i class="fa-solid fa-circle-info mr-1 text-amber-300"></i> Menampilkan seluruh artikel dan berita berkategori <strong>IKARUS</strong>.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- 2. STATS & KEY METRICS BAR --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-emerald-100 shadow-lg shadow-emerald-950/5 flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl shrink-0 font-bold">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block leading-tight">{{ $totalKarya }}</span>
                <span class="text-xs text-gray-500 font-medium">Karya &amp; Kabar Alumni</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-emerald-100 shadow-lg shadow-emerald-950/5 flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0 font-bold">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block leading-tight">{{ $alumniProfilesCount > 0 ? $alumniProfilesCount.'+' : '1000+' }}</span>
                <span class="text-xs text-gray-500 font-medium">Alumni Terdata</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-emerald-100 shadow-lg shadow-emerald-950/5 flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0 font-bold">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block leading-tight">8 Unit</span>
                <span class="text-xs text-gray-500 font-medium">Lembaga Lulusan</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-emerald-100 shadow-lg shadow-emerald-950/5 flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0 font-bold">
                <i class="fa-solid fa-globe"></i>
            </div>
            <div>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block leading-tight">Global</span>
                <span class="text-xs text-gray-500 font-medium">Kiprah Alumni</span>
            </div>
        </div>
    </div>
</div>

{{-- 3. MAIN CONTENT CONTAINER --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-12">

    {{-- HIGHLIGHT FEATURED ARTICLE (Jika tidak sedang mencari kata kunci) --}}
    @if(isset($featured) && !request('q'))
        <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-xl flex flex-col lg:flex-row group hover:shadow-2xl transition duration-300">
            <div class="lg:w-1/2 relative h-64 sm:h-80 lg:h-auto overflow-hidden bg-slate-900">
                <img src="{{ $featured->featured_image ?: '/uploads/campus-ppru-sakatiga.webp' }}" alt="{{ $featured->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ppru-sakatiga.webp'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <span class="absolute top-4 left-4 bg-gradient-to-r from-[#f59e0b] to-[#d97706] text-slate-950 font-black text-xs px-3.5 py-1 rounded-full shadow-md flex items-center space-x-1.5">
                    <i class="fa-solid fa-star"></i>
                    <span>Sorotan Karya Alumni</span>
                </span>
                @if($featured->unitPendidikan)
                    <span class="absolute bottom-4 left-4 bg-emerald-900/90 backdrop-blur-sm text-emerald-200 text-xs font-bold px-3 py-1 rounded-lg border border-emerald-700">
                        {{ $featured->unitPendidikan->short_name }}
                    </span>
                @endif
            </div>

            <div class="lg:w-1/2 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400">
                        <span class="text-emerald-700 font-bold flex items-center">
                            <i class="fa-solid fa-user-pen mr-1.5"></i>
                            {{ $featured->author_name ?: ($featured->author?->name ?: 'Alumni Raudhatul Ulum') }}
                        </span>
                        <span>&bull;</span>
                        <span><i class="fa-regular fa-calendar mr-1"></i>{{ $featured->published_at ? $featured->published_at->format('d M Y') : $featured->created_at->format('d M Y') }}</span>
                        <span>&bull;</span>
                        <span><i class="fa-regular fa-eye mr-1"></i>{{ $featured->views_count }} views</span>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 group-hover:text-[#00843d] transition leading-snug">
                        <a href="{{ route('artikel.show', $featured->slug) }}">
                            {{ $featured->title }}
                        </a>
                    </h2>

                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed line-clamp-4 font-light">
                        {{ $featured->excerpt ?: Str::limit(strip_tags($featured->content), 200) }}
                    </p>
                </div>

                <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('artikel.show', $featured->slug) }}" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition transform hover:translate-x-0.5">
                        <span>Baca Tulisan Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    <span class="text-xs text-gray-400 italic">Karya Resmi IKARUS</span>
                </div>
            </div>
        </div>
    @endif

    {{-- SECTION HEADER & FILTER STATUS --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight flex items-center space-x-2">
                <i class="fa-solid fa-feather-pointed text-[#f59e0b]"></i>
                <span>Arsip Tulisan &amp; Berita IKARUS</span>
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                @if(request('q'))
                    Hasil pencarian untuk kata kunci: <strong class="text-emerald-700 font-bold">"{{ request('q') }}"</strong> (Ditemukan {{ $posts->total() }} karya)
                @else
                    Koleksi tulisan, gagasan ilmiah, resensi, dan kabar reuni alumni Pondok Pesantren Raudhatul Ulum.
                @endif
            </p>
        </div>

        <div class="flex items-center space-x-2 text-xs">
            <span class="text-gray-500">Kategori:</span>
            <span class="bg-emerald-100 text-emerald-800 font-bold px-3 py-1 rounded-full border border-emerald-300 flex items-center space-x-1">
                <i class="fa-solid fa-tag text-[10px] text-emerald-600"></i>
                <span>IKARUS</span>
            </span>
        </div>
    </div>

    {{-- 4. GRID KARYA & BERITA ALUMNI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition duration-300 flex flex-col group reveal-fade-up">
                {{-- Gambar Cover --}}
                <a href="{{ route('artikel.show', $post->slug) }}" class="block relative h-52 overflow-hidden bg-slate-900">
                    <img src="{{ $post->featured_image ?: '/uploads/campus-ppru-sakatiga.webp' }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ppru-sakatiga.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    {{-- Badge Kategori IKARUS --}}
                    <span class="absolute top-3 left-3 bg-[#00843d] text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow-md flex items-center space-x-1">
                        <i class="fa-solid fa-graduation-cap text-[9px] text-amber-300"></i>
                        <span>IKARUS</span>
                    </span>

                    {{-- Badge Unit jika ada --}}
                    @if($post->unitPendidikan)
                        <span class="absolute top-3 right-3 bg-amber-400 text-slate-950 text-[10px] font-extrabold px-2 py-0.5 rounded-md shadow-sm">
                            {{ $post->unitPendidikan->short_name }}
                        </span>
                    @endif

                    {{-- Penulis --}}
                    <span class="absolute bottom-2.5 left-3 text-[11px] text-white/95 font-semibold drop-shadow-md truncate max-w-[90%]">
                        <i class="fa-solid fa-pen-nib mr-1 text-amber-300"></i>{{ $post->author_name ?: ($post->author?->name ?: 'Alumni PPRU') }}
                    </span>
                </a>

                {{-- Konten Ringkas --}}
                <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3 text-[11px] text-gray-400">
                            <span><i class="fa-regular fa-calendar mr-1"></i>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye mr-1"></i>{{ $post->views_count }} views</span>
                        </div>

                        <h3 class="font-black text-gray-900 text-base group-hover:text-[#00843d] transition line-clamp-2 leading-snug">
                            <a href="{{ route('artikel.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed font-light">
                            {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('artikel.show', $post->slug) }}" class="text-xs font-black text-[#00843d] hover:text-emerald-800 inline-flex items-center space-x-1 group-hover:translate-x-1 transition-transform">
                            <span>Baca Tulisan</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <span class="text-[10px] text-gray-400">Artikel Alumni</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-100 p-8 space-y-3">
                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-2xl">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Belum Ada Tulisan Karya Alumni</h3>
                <p class="text-xs text-gray-500 max-w-md mx-auto">
                    @if(request('q'))
                        Tidak ditemukan artikel alumni dengan kata kunci "{{ request('q') }}". Silakan coba kata kunci lain atau reset filter pencarian.
                    @else
                        Saat ini belum ada tulisan berkategori IKARUS yang diterbitkan. Jadilah alumni pertama yang mengirimkan karya dan opini Anda ke almamater!
                    @endif
                </p>
                @if(request('q'))
                    <a href="{{ route('ikarus.index') }}" class="inline-flex items-center space-x-2 bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-xl mt-2">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Lihat Seluruh Tulisan</span>
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
        <div class="pt-4 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif

    {{-- 5. KOTAK AJAKAN: KIRIM KARYA & KABAR ALUMNI --}}
    <div id="kirim-karya" class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden border border-emerald-800/40">
        <div class="absolute right-0 top-0 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <div class="lg:col-span-8 space-y-3">
                <div class="inline-flex items-center space-x-2 text-xs font-bold text-amber-400 bg-amber-400/10 px-3 py-1 rounded-full border border-amber-400/30">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Redaksi Media &amp; Jurnal IKARUS</span>
                </div>

                <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Punya Tulisan, Opini, atau Liputan Reuni Alumni?
                </h3>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light max-w-2xl">
                    Redaksi IKARUS menerima sumbangan naskah berupa artikel ilmiah populer, opini keummatan, kajian kitab kuning, resensi buku, hingga liputan kegiatan silaturahmi alumni per wilayah di seluruh dunia.
                </p>
            </div>

            <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_whatsapp'] ?? '6281278901950') }}?text={{ urlencode('Assalamu\'alaikum Redaksi IKARUS PPRU, saya alumni ingin mengirimkan naskah karya tulis untuk website.') }}" target="_blank" rel="noopener noreferrer" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white px-5 py-3 rounded-xl font-bold text-xs text-center shadow-lg transition flex items-center justify-center space-x-2">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Kirim Naskah via WhatsApp</span>
                </a>
                <a href="{{ route('hubungi') }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-5 py-3 rounded-xl font-semibold text-xs text-center transition flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Sekretariat &amp; Humas</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
