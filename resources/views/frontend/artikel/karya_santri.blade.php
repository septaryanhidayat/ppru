@extends('layouts.frontend')

@section('title', 'Karya Santri & Asatidz - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Kumpulan karya tulis, artikel ilmiah, opini keislaman, sastra, dan riset para santri serta dewan asatidz Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00843d] to-emerald-900 text-white py-12 sm:py-16 relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('artikel.index') }}" class="hover:text-white transition">Informasi</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Karya Santri &amp; Asatidz</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl space-y-2">
                <span class="inline-flex items-center gap-1.5 bg-amber-400/20 text-amber-300 border border-amber-300/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-feather-pointed"></i>
                    <span>Mimbar Literasi &amp; Kreasi Santri</span>
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                    Karya Santri &amp; Asatidz
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 font-light leading-relaxed">
                    Wadah apresiasi literasi, riset sains, kajian turots, opini keummatan, dan kreasi tulisan para santri serta dewan asatidz Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <a href="#kirim-karya" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 px-5 py-3 rounded-2xl font-black text-xs shadow-lg shadow-amber-500/20 transition flex items-center space-x-2 transform hover:scale-105">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Kirim Naskah Tulisan</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
        
        {{-- MAIN CONTENT (2/3) --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Search Bar & Filter Form --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-center gap-3">
                <form action="{{ route('karya-santri') }}" method="GET" class="relative flex-1 w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul tulisan, nama santri, atau topik..." class="w-full bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm text-slate-800 dark:text-slate-100 rounded-xl pl-9 pr-4 py-2.5 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </form>
                @if(request('q'))
                    <a href="{{ route('karya-santri') }}" class="text-xs text-rose-600 dark:text-rose-400 hover:underline font-bold px-2 whitespace-nowrap">
                        <i class="fa-solid fa-xmark mr-1"></i> Reset
                    </a>
                @endif
            </div>

            {{-- Articles Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($posts as $idx => $post)
                    <article class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group reveal-fade-up delay-{{ $idx % 4 }}">
                        <div>
                            <a href="{{ route('artikel.show', $post->slug) }}" class="block relative h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                @if($post->featured_image)
                                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/uploads/official/drone-raudhatul-ulum.webp'">
                                @else
                                    <img src="/uploads/official/drone-raudhatul-ulum.webp" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @endif
                                <span class="absolute top-3 left-3 bg-[#00843d] text-white text-[10px] font-black px-2.5 py-1 rounded-full shadow-sm">
                                    <i class="fa-solid fa-pen-nib mr-1 text-[9px]"></i> Karya Santri
                                </span>
                            </a>

                            <div class="p-5 space-y-2.5">
                                <div class="flex items-center text-[11px] text-slate-400 dark:text-slate-400 gap-2 flex-wrap">
                                    <span><i class="fa-regular fa-calendar mr-1 text-[#00843d]"></i>{{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : $post->created_at->translatedFormat('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-user mr-1 text-amber-500"></i>{{ $post->author_name ?? ($post->author->name ?? 'Santri PPRU') }}</span>
                                </div>
                                <h2 class="font-extrabold text-slate-900 dark:text-white text-sm sm:text-base line-clamp-2 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition leading-snug">
                                    <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2 font-light leading-relaxed">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                        </div>

                        <div class="px-5 pb-5 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-[#00843d] dark:text-emerald-400 group-hover:text-emerald-700">
                            <span>Baca Mahakarya Santri</span>
                            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                        </div>
                    </article>
                @empty
                    <div class="col-span-2 text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 space-y-3">
                        <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-slate-800 text-[#00843d] flex items-center justify-center text-2xl mx-auto">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-base">Belum Ada Naskah yang Sesuai</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mx-auto">
                            Jadilah santri atau asatidz pertama yang menerbitkan karya tulis di portal resmi PPRU Sakatiga!
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
                <div class="pt-4">
                    {{ $posts->links() }}
                </div>
            @endif

            {{-- KOTAK AJAKAN KIRIM KARYA SANTRI --}}
            <div id="kirim-karya" class="bg-gradient-to-br from-emerald-950 via-[#004d24] to-slate-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-emerald-800/40 relative overflow-hidden">
                <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left">
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-300 bg-amber-400/20 px-3 py-1 rounded-full border border-amber-300/30">
                            Redaksi Mading &amp; Web PPRU
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                            Punya Tulisan, Puisi, Opini, atau Riset?
                        </h3>
                        <p class="text-xs sm:text-sm text-emerald-100/90 max-w-lg leading-relaxed">
                            Santri dan Asatidz Raudhatul Ulum dapat mengirimkan naskah tulisan untuk dipublikasikan di website resmi dan buletin pesantren. Kirimkan naskah Anda ke tim redaksi Humas.
                        </p>
                    </div>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_whatsapp'] ?? '6281278901950') }}?text={{ urlencode('Assalamu\'alaikum Redaksi Web PPRU, saya santri/asatidz ingin mengirimkan naskah karya tulis untuk website.') }}" target="_blank" rel="noopener noreferrer" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white px-6 py-3.5 rounded-2xl font-black text-xs shadow-lg transition flex items-center justify-center space-x-2 shrink-0">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>Kirim Naskah via WA</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- SIDEBAR (1/3) --}}
        <div class="space-y-6">
            
            {{-- Info Pojok Literasi --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-slate-800 text-[#00843d] flex items-center justify-center text-lg">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900 dark:text-white">Pojok Literasi PPRU</h3>
                        <p class="text-[11px] text-slate-400">10 Jati Diri Santri Sakatiga</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                    Salah satu tradisi keilmuan pesantren adalah menulis dan merangkum ilmu pengetahuan (kitabah). Melalui kanal ini, bakat kepenulisan santri dibina untuk syiar Islam yang mencerahkan.
                </p>
                <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-2 text-xs">
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                        <span><i class="fa-solid fa-check-circle text-[#00843d] mr-1.5"></i> Opini Keislaman</span>
                        <span class="font-bold text-emerald-600">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                        <span><i class="fa-solid fa-check-circle text-[#00843d] mr-1.5"></i> Riset Sains &amp; Robotika</span>
                        <span class="font-bold text-emerald-600">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600 dark:text-slate-300">
                        <span><i class="fa-solid fa-check-circle text-[#00843d] mr-1.5"></i> Khazanah Turots Salaf</span>
                        <span class="font-bold text-emerald-600">Aktif</span>
                    </div>
                </div>
            </div>

            {{-- Kategori Lainnya --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                <h3 class="font-black text-sm text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-folder-tree text-[#00843d]"></i>
                    <span>Kategori Tulisan</span>
                </h3>
                <div class="flex flex-col space-y-2 text-xs">
                    @foreach($categories->take(6) as $cat)
                        <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" class="flex items-center justify-between p-2 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-[#00843d] dark:hover:text-emerald-400 transition">
                            <span>{{ $cat->name }}</span>
                            <span class="text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-full font-bold">{{ $cat->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Berita Terkini Pesantren --}}
            @if(isset($recentPosts) && $recentPosts->isNotEmpty())
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                <h3 class="font-black text-sm text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-newspaper text-amber-500"></i>
                    <span>Kabar Pondok Terkini</span>
                </h3>
                <div class="space-y-3">
                    @foreach($recentPosts->take(4) as $rp)
                        <a href="{{ route('artikel.show', $rp->slug) }}" class="flex items-start gap-3 group">
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0">
                                <img src="{{ $rp->featured_image ?: '/uploads/official/drone-raudhatul-ulum.webp' }}" alt="{{ $rp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.onerror=null;this.src='/uploads/official/drone-raudhatul-ulum.webp'">
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition line-clamp-2 leading-snug">
                                    {{ $rp->title }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block">
                                    {{ $rp->published_at ? $rp->published_at->translatedFormat('d M Y') : '' }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection
