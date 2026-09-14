@extends('layouts.frontend')

@section('title', 'Pondok Pesantren Raudhatul Ulum Sakatiga - Basis Kaderisasi Generasi Khairu Ummah')
@section('meta_description', 'Website Resmi Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga, Ogan Ilir, Sumatera Selatan. Pesantren modern terpadu berasrama dengan muadalah Al-Azhar Kairo Mesir.')

@section('content')
{{-- ========================================================
     SECTION #0: HERO SLIDER
     ======================================================== --}}
<section class="relative bg-gray-950 overflow-hidden" x-data="{
    activeSlide: 0,
    slides: {{ Js::from($heroSlides) }},
    autoSlide() {
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        }, 6500);
    }
}" x-init="autoSlide()">
    {{-- Banner Images & Content --}}
    <div class="relative h-[480px] sm:h-[520px] lg:h-[560px] w-full overflow-hidden">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-700" 
                 x-transition:enter-start="opacity-0 scale-105" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-500" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="absolute inset-0">
                
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover object-center brightness-60">
                {{-- Islamic Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-black/30"></div>
                <div class="absolute inset-0 bg-[radial-gradient(#00843d_1px,transparent_1px)] [background-size:24px_24px] opacity-15"></div>

                {{-- Konten Rata Tengah --}}
                <div class="absolute inset-0 flex items-center justify-center pt-4 pb-20 sm:pb-16">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center text-white space-y-3 sm:space-y-4">
                        <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full text-[11px] sm:text-xs font-bold uppercase tracking-widest bg-school-green/90 text-white shadow-lg backdrop-blur-xs border border-white/20">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            <span>Pondok Pesantren Raudhatul Ulum Sakatiga</span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black tracking-tight drop-shadow-xl leading-tight" x-text="slide.title"></h1>
                        <p class="text-xs sm:text-base md:text-lg text-gray-200 font-medium max-w-2xl mx-auto drop-shadow line-clamp-3 sm:line-clamp-none leading-relaxed" x-text="slide.subtitle"></p>
                        <div class="pt-2 sm:pt-4 flex flex-wrap items-center justify-center gap-3">
                            <a :href="slide.btn_link" class="inline-flex items-center justify-center bg-gradient-to-r from-school-gold to-amber-500 hover:from-amber-500 hover:to-amber-600 text-gray-950 px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-black text-xs sm:text-sm shadow-xl transition transform hover:scale-105">
                                <span x-text="slide.btn_text"></span>
                                <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                            <a href="{{ route('ppdb.index') }}" class="inline-flex items-center justify-center bg-school-green hover:bg-emerald-800 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-full font-bold text-xs sm:text-sm shadow-xl transition border border-white/20 transform hover:scale-105">
                                <i class="fa-solid fa-user-graduate mr-2 text-xs"></i>
                                <span>Pendaftaran PSB</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Carousel Controls (Panah Samping) --}}
    <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length" class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-school-green text-white w-9 h-9 sm:w-11 sm:h-11 rounded-full flex items-center justify-center transition backdrop-blur z-20 shadow-lg cursor-pointer" aria-label="Slide sebelumnya">
        <i class="fa-solid fa-chevron-left text-xs sm:text-sm" aria-hidden="true"></i>
    </button>
    <button @click="activeSlide = (activeSlide + 1) % slides.length" class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-school-green text-white w-9 h-9 sm:w-11 sm:h-11 rounded-full flex items-center justify-center transition backdrop-blur z-20 shadow-lg cursor-pointer" aria-label="Slide berikutnya">
        <i class="fa-solid fa-chevron-right text-xs sm:text-sm" aria-hidden="true"></i>
    </button>

    {{-- Dots Pagination di Tengah --}}
    <div class="absolute bottom-9 sm:bottom-12 left-1/2 -translate-x-1/2 flex space-x-1.5 z-20">
        <template x-for="(slide, idx) in slides" :key="idx">
            <button @click="activeSlide = idx" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center cursor-pointer" :aria-label="'Pilih slide ' + (idx + 1)">
                <span class="h-2 sm:h-2.5 rounded-full transition-all duration-300" :class="activeSlide === idx ? 'w-6 sm:w-8 bg-amber-400' : 'w-2 sm:w-2.5 bg-white/70 hover:bg-white'"></span>
            </button>
        </template>
    </div>
</section>

{{-- ========================================================
     SECTION #1: FLOATING QUICK ICONS / MENU UTAMA (8 Kartu Pesantren)
     ======================================================== --}}
<div x-data="{ showDownloadModal: false }" class="max-w-6xl mx-auto px-4 sm:px-6 relative z-30 -mt-8 sm:-mt-10 reveal-fade-up">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-4 sm:p-6 md:p-7">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 sm:mb-5 border-b border-gray-100">
            <div class="text-center sm:text-left">
                <h2 class="text-base sm:text-lg font-black text-gray-900 tracking-tight flex items-center justify-center sm:justify-start gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-school-green inline-block animate-pulse"></span>
                    <span>Menu Utama &amp; Layanan Utama Pesantren</span>
                </h2>
                <p class="text-xs text-gray-500 font-light mt-0.5">Akses cepat informasi pendidikan, pendaftaran santri, dan kelembagaan PPRU</p>
            </div>
            <div class="flex items-center justify-center sm:justify-end">
                <button @click="showDownloadModal = true" type="button" aria-label="Buka Pilihan Download" class="bg-gradient-to-r from-school-green to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-xs font-black px-4 py-2.5 rounded-full transition shadow flex items-center space-x-1.5 cursor-pointer transform hover:scale-105 min-h-[40px]">
                    <i class="fa-solid fa-download text-[11px]" aria-hidden="true"></i>
                    <span>Download Brosur &amp; Dokumen</span>
                </button>
            </div>
        </div>

        @php
            $dbQuickMenus = \App\Models\QuickMenu::active()->orderBy('order', 'asc')->take(8)->get();
            if ($dbQuickMenus->isEmpty()) {
                $quickMenus = collect([
                    (object)['name' => 'PSB Online', 'icon' => 'fa-solid fa-graduation-cap', 'url' => route('ppdb.index'), 'is_image' => false],
                    (object)['name' => 'Profil', 'icon' => 'fa-solid fa-landmark-dome', 'url' => route('page.tentang-kami'), 'is_image' => false],
                    (object)['name' => 'Pendidikan', 'icon' => 'fa-solid fa-building-columns', 'url' => route('pendidikan.index'), 'is_image' => false],
                    (object)['name' => 'Asatidz', 'icon' => 'fa-solid fa-chalkboard-user', 'url' => route('dewan.index'), 'is_image' => false],
                    (object)['name' => 'Sarana', 'icon' => 'fa-solid fa-layer-group', 'url' => route('bidang.index'), 'is_image' => false],
                    (object)['name' => 'Unggulan', 'icon' => 'fa-solid fa-award', 'url' => route('dpc.index'), 'is_image' => false],
                    (object)['name' => 'Prestasi', 'icon' => 'fa-solid fa-trophy', 'url' => route('prestasi.index'), 'is_image' => false],
                    (object)['name' => 'Kabar', 'icon' => 'fa-solid fa-newspaper', 'url' => route('artikel.index'), 'is_image' => false],
                ]);
            } else {
                $quickMenus = $dbQuickMenus;
            }
        @endphp

        {{-- GRID QUICK MENUS: 4 Kolom di Mobile, 8 Kolom di Desktop --}}
        <div class="grid grid-cols-4 md:grid-cols-8 gap-2.5 sm:gap-3 md:gap-3.5 text-center justify-items-center">
            @foreach($quickMenus as $qm)
            <a href="{{ $qm->url }}" 
               class="group w-full flex flex-col items-center justify-between text-center p-2 sm:p-2.5 md:py-3.5 md:px-2 rounded-2xl border border-slate-200/90 hover:border-emerald-600 bg-white hover:bg-gradient-to-b hover:from-[#005a28] hover:to-emerald-950 shadow-xs hover:shadow-xl hover:shadow-emerald-950/20 transition-all duration-300 transform hover:-translate-y-1.5 min-h-[96px] sm:min-h-[104px] md:min-h-[112px] focus:outline-none focus:ring-2 focus:ring-[#00843d]" 
               aria-label="Menu {{ $qm->name }}">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-emerald-50 border border-emerald-200 group-hover:border-emerald-400 text-[#00843d] group-hover:bg-[#00843d] group-hover:text-white flex items-center justify-center mx-auto mb-1.5 sm:mb-2 shadow-xs group-hover:shadow-md group-hover:scale-110 transition-all duration-300">
                    @if(!empty($qm->is_image) && $qm->is_image)
                        <img src="{{ $qm->icon }}" alt="Ikon {{ $qm->name }}" class="w-6 h-6 sm:w-6 sm:h-6 md:w-7 md:h-7 object-contain group-hover:scale-105 transition" onerror="this.src='/uploads/logo-ppru-square.png'">
                    @else
                        <i class="{{ $qm->icon }} text-base sm:text-lg md:text-xl transition-transform duration-300 group-hover:scale-105" aria-hidden="true"></i>
                    @endif
                </div>
                <span class="text-[11px] sm:text-[11px] md:text-xs font-black text-slate-900 group-hover:text-white text-center leading-tight block w-full tracking-tight px-0.5 transition-colors">
                    {{ $qm->name }}
                </span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- POPUP MODAL DOWNLOAD --}}
    <div x-show="showDownloadModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="showDownloadModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs"
         style="display: none;">
         
        <div class="fixed inset-0" @click="showDownloadModal = false"></div>

        <div x-show="showDownloadModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-6 sm:p-8 border border-gray-100 z-10">

            <button @click="showDownloadModal = false" type="button" class="absolute top-4 right-4 sm:top-5 sm:right-5 w-9 h-9 rounded-lg bg-gray-900 text-white hover:bg-black transition flex items-center justify-center shadow-md cursor-pointer" aria-label="Tutup Pilihan Download">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-school-green flex items-center justify-center text-xl mx-auto mb-2.5">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-gray-900">
                    Pusat Unduhan Pesantren Raudhatul Ulum
                </h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Silakan pilih kategori dokumen, modul, atau panduan resmi yang ingin Anda unduh
                </p>
                <div class="w-12 h-1 bg-school-green mx-auto mt-3 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6">
                <a href="{{ route('download.index') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-school-green hover:bg-emerald-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-school-green flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-school-green transition">Brosur PSB &amp; Formulir</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Panduan pendaftaran santri baru, biaya &amp; syarat</p>
                    </div>
                </a>

                <a href="{{ route('download.ebook') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-school-green hover:bg-emerald-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-school-green transition">E-Library &amp; Modul Siswa</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Kutubut turats, modul tahfidz &amp; materi santri</p>
                    </div>
                </a>

                <a href="{{ route('download.hymne-mars') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-school-green hover:bg-emerald-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 text-school-green flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-school-green transition">Mars &amp; Hymne PPRU</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Lirik dan audio resmi santri Raudhatul Ulum</p>
                    </div>
                </a>

                <a href="{{ route('download.logo') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-school-green hover:bg-emerald-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-school-green transition">Logo Resmi Pesantren</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Aset logo resolusi tinggi PNG &amp; vektor</p>
                    </div>
                </a>
            </div>

            <div class="text-center pt-2 border-t border-gray-100">
                <button @click="showDownloadModal = false" type="button" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition cursor-pointer">
                    Kembali ke Beranda
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================
     SECTION #2: MENDIDIK DENGAN SEPENUH KASIH SAYANG (FULL WIDTH CINEMATIC)
     ======================================================== --}}
<section class="w-full relative overflow-hidden bg-slate-950 py-20 sm:py-28 text-white" x-data="{ videoModalOpen: false }">
    {{-- Full Width Cinematic Poster & Gradient Backdrop --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="/uploads/campus-ppru-sakatiga.webp" alt="Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full h-full object-cover object-center filter brightness-[0.22] scale-105 transform hover:scale-100 transition duration-1000">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-emerald-950/85 to-slate-950/95"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#00843d_1px,transparent_1px)] [background-size:28px_28px] opacity-20 pointer-events-none"></div>
    </div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#f59e0b]/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-amber-300 text-xs font-black uppercase tracking-widest backdrop-blur-sm shadow-sm">
            <i class="fa-solid fa-heart text-rose-400 animate-pulse"></i>
            <span>Mendidik dengan Sepenuh Kasih Sayang</span>
        </div>

        <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight">
            Mendidik dengan Kasih Sayang, Membentuk Generasi Khairu Ummah
        </h2>

        <p class="text-sm sm:text-base md:text-lg text-emerald-100/90 font-light leading-relaxed max-w-3xl mx-auto">
            Di Pondok Pesantren Raudhatul Ulum Sakatiga, proses pendidikan berakar pada keikhlasan pengasuhan, keteladanan akhlaqul karimah, serta keseimbangan antara spiritualitas Qur'ani, ketajaman nalar ilmiah, dan kepemimpinan global.
        </p>

        {{-- Interactive Video Play Button & PSB Trigger --}}
        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <button @click="videoModalOpen = true" type="button" class="group inline-flex items-center gap-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs sm:text-sm px-7 py-3.5 rounded-full shadow-xl shadow-amber-500/25 transition transform hover:scale-105 cursor-pointer">
                <span class="w-8 h-8 rounded-full bg-slate-950 text-amber-400 flex items-center justify-center text-xs group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-play ml-0.5"></i>
                </span>
                <span>Tonton Video Profil Singkat Pesantren (1 Menit)</span>
            </button>

            <a href="{{ route('ppdb.index') }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-full border border-white/20 backdrop-blur-xs transition">
                <i class="fa-solid fa-graduation-cap text-amber-300"></i>
                <span>Pendaftaran PSB Online</span>
            </a>
        </div>
    </div>

    {{-- Interactive Video Modal Lightbox --}}
    <div x-show="videoModalOpen" 
         x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="videoModalOpen = false"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md">
        
        <div class="fixed inset-0" @click="videoModalOpen = false"></div>

        <div class="relative w-full max-w-4xl bg-slate-900 rounded-3xl overflow-hidden border border-white/20 shadow-2xl z-10"
             x-show="videoModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="flex items-center justify-between px-6 py-4 border-b border-white/10 bg-slate-950/80">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></span>
                    <h4 class="text-xs sm:text-sm font-bold text-white">Video Profil &amp; Dokumentasi Pondok Pesantren Raudhatul Ulum Sakatiga</h4>
                </div>
                <button @click="videoModalOpen = false" type="button" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="aspect-video bg-black relative">
                @php
                    $firstVideo = $videos->first();
                    $ytId = $firstVideo?->youtube_id ?? 'dQw4w9WgXcQ';
                @endphp
                <template x-if="videoModalOpen">
                    <iframe class="w-full h-full" 
                            src="https://www.youtube-nocookie.com/embed/{{ $ytId }}?autoplay=1" 
                            title="Video Profil Pondok Pesantren Raudhatul Ulum Sakatiga" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </template>
            </div>
            
            <div class="p-4 bg-slate-950 flex items-center justify-between text-xs text-slate-400">
                <span>Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir, Sumatera Selatan</span>
                <a href="{{ route('video.index') }}" class="text-amber-400 hover:text-amber-300 font-bold">
                    Lihat Koleksi Video Lainnya &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #3: TRISULA KEUNGGULAN SANTRI RAUDHATUL ULUM (BACKGROUND PUTIH KONTRAS)
     ======================================================== --}}
<section class="w-full bg-white py-16 sm:py-24 border-y border-slate-200/80 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-[#00843d] bg-emerald-50 border border-emerald-200 px-3.5 py-1 rounded-full inline-block">
                3 Prioritas Utama Pembelajaran
            </span>
            <h3 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight">
                Trisula Keunggulan Santri Raudhatul Ulum
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 font-normal">
                Kurikulum komprehensif yang dirancang untuk mengantarkan santri berprestasi di kancah nasional maupun dunia.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            
            {{-- Prioritas 1: Quranic Character --}}
            <div class="bg-slate-50/90 hover:bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 hover:border-amber-400/90 transition-all duration-300 transform hover:-translate-y-2 flex flex-col justify-between group shadow-xs hover:shadow-2xl">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center text-2xl font-black shadow-lg shadow-amber-500/20 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-700 block">Prioritas I &bull; Keagamaan &amp; Karakter</span>
                        <h4 class="text-xl font-black text-gray-900 mt-1 group-hover:text-amber-700 transition">
                            Karakter Qur'ani (Quranic Insight)
                        </h4>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                        Bimbingan intensif tahsin dan tahfidzul Qur'an mutqin hingga 30 juz bersanad lewat unit khusus MATQULARU, kajian kitab kuning (turats), serta pembiasaan ibadah sunnah 24 jam dan penempaan 10 Jati Diri Santri Raudhatul Ulum.
                    </p>
                </div>
                <div class="pt-5 mt-6 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-amber-700">
                    <span>Target Mutqin 30 Juz &amp; Sanad</span>
                    <i class="fa-solid fa-circle-check text-amber-500 text-sm"></i>
                </div>
            </div>

            {{-- Prioritas 2: Scientific Insight --}}
            <div class="bg-slate-50/90 hover:bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 hover:border-[#00843d] transition-all duration-300 transform hover:-translate-y-2 flex flex-col justify-between group shadow-xs hover:shadow-2xl">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00843d] to-emerald-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 block">Prioritas II &bull; Sains &amp; Teknologi</span>
                        <h4 class="text-xl font-black text-gray-900 mt-1 group-hover:text-[#00843d] transition">
                            Nalar Ilmiah (Scientific Insight)
                        </h4>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                        Penguatan logika berpikir kritis melalui integrasi kurikulum sains nasional, laboratorium terpadu, olimpiade riset (KSM/OSN), pengenalan literasi digital modern, coding, robotika pesantren, dan karya tulis ilmiah santri.
                    </p>
                </div>
                <div class="pt-5 mt-6 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-[#00843d]">
                    <span>Laboratorium Modern &amp; Robotika</span>
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                </div>
            </div>

            {{-- Prioritas 3: Global Leadership --}}
            <div class="bg-slate-50/90 hover:bg-white rounded-3xl p-7 sm:p-8 border border-slate-200/90 hover:border-sky-500 transition-all duration-300 transform hover:-translate-y-2 flex flex-col justify-between group shadow-xs hover:shadow-2xl">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-sky-500/20 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-globe"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-sky-700 block">Prioritas III &bull; Bahasa &amp; Kepemimpinan</span>
                        <h4 class="text-xl font-black text-gray-900 mt-1 group-hover:text-blue-700 transition">
                            Kepemimpinan Global (Global Leadership)
                        </h4>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                        Ekosistem dwi-bahasa aktif (Arab &amp; Inggris harian), kurikulum muadalah yang diakui resmi di Universitas Al-Azhar Kairo Mesir, organisasi kepemimpinan santri (OSPRU), kepanduan pramuka, serta kemandirian hidup berasrama 24 jam.
                    </p>
                </div>
                <div class="pt-5 mt-6 border-t border-slate-200/80 flex items-center justify-between text-xs font-bold text-sky-700">
                    <span>Dwi-Bahasa &amp; Muadalah Al-Azhar</span>
                    <i class="fa-solid fa-circle-check text-sky-500 text-sm"></i>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #4: PROGRAM UNGGULAN SANTRI RAUDHATUL ULUM (BACKGROUND GELAP)
     ======================================================== --}}
<section class="w-full bg-gradient-to-b from-slate-900 via-emerald-950 to-slate-900 py-16 sm:py-24 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#00843d_1px,transparent_1px)] [background-size:24px_24px] opacity-15 pointer-events-none"></div>
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#f59e0b]/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-white/15">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#f59e0b] block">
                    Kurikulum &amp; Ekstrakurikuler Khusus
                </span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">
                    Program Unggulan Santri Raudhatul Ulum
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 mt-1 font-light">
                    Pilihan program akselerasi minat dan bakat untuk melahirkan generasi santri yang berprestasi dan berwawasan luas.
                </p>
            </div>
            <a href="{{ route('dpc.index') }}" class="inline-flex items-center text-xs font-bold text-amber-400 hover:text-amber-300 transition flex-shrink-0">
                <span>Lihat Seluruh Program</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programUnggulan as $p)
                <div class="bg-white/10 rounded-3xl overflow-hidden border border-white/15 hover:border-amber-400/80 transition-all duration-300 group hover:-translate-y-1 shadow-lg flex flex-col justify-between">
                    <div>
                        <div class="h-48 w-full overflow-hidden bg-slate-800 relative">
                            <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-108 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full shadow">
                                {{ $p->address ?: 'Program Unggulan' }}
                            </span>
                        </div>
                        <div class="p-6 space-y-2">
                            {{-- Judul dibuat unclipped dengan line-clamp-2 min-h dan leading-snug break-words --}}
                            <h4 class="font-extrabold text-base sm:text-lg text-white group-hover:text-amber-300 transition line-clamp-2 leading-snug break-words min-h-[3rem]">
                                {{ $p->name }}
                            </h4>
                            <p class="text-xs text-slate-300 font-light leading-relaxed line-clamp-3">
                                {{ strip_tags($p->description) }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">
                    Data program unggulan segera diperbarui.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #3: SAMBUTAN MUDIR PESANTREN
     ======================================================== --}}
<section class="py-14 sm:py-20 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            {{-- Foto Mudir Pesantren --}}
            <div class="lg:col-span-5 reveal-fade-up delay-1">
                <div class="max-w-sm sm:max-w-md mx-auto relative">
                    {{-- Decorative Islamic Corner Accent --}}
                    <div class="absolute -top-4 -left-4 w-20 h-20 border-t-4 border-l-4 border-school-gold rounded-tl-3xl -z-0"></div>
                    <div class="absolute -bottom-4 -right-4 w-20 h-20 border-b-4 border-r-4 border-school-green rounded-br-3xl -z-0"></div>
                    
                    <div class="relative z-10 rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gradient-to-b from-emerald-50 to-emerald-100 aspect-[4/5]">
                        <img src="/uploads/kh-tolat-wafa-ahmad.webp" alt="KH. Tol'at Wafa Ahmad, Lc. - Mudir Pondok Pesantren Raudhatul Ulum" class="w-full h-full object-cover object-top transform hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-transparent to-transparent flex items-end p-5">
                            <div class="text-white">
                                <span class="inline-block px-2.5 py-0.5 bg-school-gold text-gray-950 rounded-full text-[10px] font-black uppercase tracking-wider mb-1">
                                    Pimpinan Pesantren
                                </span>
                                <p class="font-extrabold text-base sm:text-lg leading-tight">
                                    KH. Tol'at Wafa Ahmad, Lc.
                                </p>
                                <p class="text-xs text-emerald-200 mt-0.5">Mudir Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Isi Sambutan --}}
            <div class="lg:col-span-7 space-y-4 reveal-fade-up delay-2 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-school-green bg-emerald-50 px-3 py-1 rounded-full">
                    <i class="fa-solid fa-quote-left text-xs"></i>
                    <span>Kata Sambutan Mudir / Sambutan Kepala Sekolah</span>
                </div>
                
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight leading-tight">
                    Mendidik Generasi Khairu Ummah, Menegakkan Risalah Islam
                </h2>

                <p class="font-arabic text-lg sm:text-xl text-school-green leading-relaxed text-center lg:text-left" dir="rtl">
                    بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ • كُنتُمْ خَيْرَ أُمَّةٍ أُخْرِجَتْ لِلنَّاسِ تَأْمُرُونَ بِالْمَعْرُوفِ وَتَنْهَوْنَ عَنِ الْمُنكَرِ
                </p>

                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-normal">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga. Sejak dirintisnya madrasah cikal bakal pada tahun 1930 hingga resmi berdirinya pesantren pada 1 Agustus 1950, PPRU senantiasa istiqomah membina putra-putri umat dalam lingkungan asrama yang asri, disiplin, dan sarat nilai-nilai perjuangan Islam.
                </p>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-normal hidden sm:block">
                    Kami berkomitmen memadukan kurikulum kepesantrenan terpadu Gontor, Kementerian Agama, dan Diknas, sehingga alumni kami siap melanjutkan studi ke universitas ternama di Timur Tengah (Al-Azhar Kairo, Madinah) maupun perguruan tinggi umum terkemuka di dalam dan luar negeri.
                </p>

                <div class="w-20 h-1 bg-school-green mx-auto lg:mx-0 my-4 rounded-full"></div>

                {{-- Tombol Tindakan --}}
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-2">
                    <a href="{{ route('page.sambutan') }}" class="bg-school-green hover:bg-emerald-800 text-white px-6 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition flex items-center space-x-2">
                        <i class="fa-solid fa-book-open text-xs"></i>
                        <span>Sambutan Lengkap</span>
                    </a>
                    <a href="{{ route('page.visi-misi') }}" class="bg-gray-900 hover:bg-black text-white px-6 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition flex items-center space-x-2">
                        <span>Visi, Misi &amp; 10 Jati Diri</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('page.tentang-kami') }}" class="text-school-green hover:text-emerald-800 font-bold text-xs sm:text-sm px-4 py-2.5 flex items-center space-x-1.5">
                        <span>Profil Singkat</span>
                        <i class="fa-solid fa-circle-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #4: UNIT PENDIDIKAN PESANTREN (Fitur Baru & Unggulan - Inspired by Baitussalam)
     ======================================================== --}}
<section class="py-16 sm:py-20 bg-slate-50 border-y border-gray-200/80 overflow-hidden" id="unit-pendidikan">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Title --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 reveal-fade-up">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-school-green rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                    <span>Jenjang &amp; Lembaga Pendidikan</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">
                    Unit Pendidikan Raudhatul Ulum
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-2xl">
                    Penyelenggaraan pendidikan terpadu dari jenjang anak usia dini hingga perguruan tinggi dengan sistem asrama penuh (boarding) dan fullday.
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('pendidikan.index') }}" class="inline-flex items-center text-xs sm:text-sm font-bold text-school-green hover:text-emerald-800 transition">
                    <span>Lihat Semua Unit &amp; Brosur</span>
                    <i class="fa-solid fa-arrow-right ml-1.5 text-xs"></i>
                </a>
            </div>
        </div>

        {{-- 8 Unit Cards Grid (1 col mobile, 2 col sm, 4 col lg) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($unitPendidikans as $index => $u)
            <div class="bg-white rounded-3xl p-5 shadow-sm hover:shadow-xl border border-gray-200/70 hover:border-school-green/50 transition-all duration-300 flex flex-col justify-between group transform hover:-translate-y-1.5 reveal-fade-up delay-{{ ($index % 4) + 1 }}">
                <div>
                    {{-- Top Card Header --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-white p-1.5 shadow-sm border border-emerald-100/80 group-hover:border-school-green group-hover:scale-105 flex items-center justify-center transition duration-300 overflow-hidden">
                            @if(!empty($u->logo))
                                <img src="{{ $u->logo_url }}" alt="Logo {{ $u->name }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full rounded-xl bg-emerald-50 text-school-green group-hover:bg-school-green group-hover:text-white flex items-center justify-center text-lg transition">
                                    <i class="{{ $u->icon ?: 'fa-solid fa-graduation-cap' }}"></i>
                                </div>
                            @endif
                        </div>
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ str_contains(strtolower($u->category_type), 'boarding') ? 'bg-emerald-100 text-emerald-800' : (str_contains(strtolower($u->category_type), 'tahfidz') ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800') }}">
                            {{ $u->category_type }}
                        </span>
                    </div>

                    {{-- Nama Unit --}}
                    <div class="mb-2">
                        <span class="text-[11px] font-black text-school-gold uppercase tracking-wider">{{ $u->short_name }}</span>
                        <h3 class="text-base font-black text-gray-900 group-hover:text-school-green transition line-clamp-2 leading-snug">
                            <a href="{{ route('pendidikan.show', $u->slug) }}">
                                {{ $u->name }}
                            </a>
                        </h3>
                    </div>

                    {{-- Badge Akreditasi / Muadalah --}}
                    @if($u->badge)
                    <div class="inline-flex items-center space-x-1 px-2 py-0.5 bg-gray-100 rounded-md text-[10px] font-bold text-gray-700 mb-3">
                        <i class="fa-solid fa-certificate text-amber-500 text-[10px]"></i>
                        <span>{{ $u->badge }}</span>
                    </div>
                    @endif

                    {{-- Deskripsi Singkat --}}
                    <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-4">
                        {{ $u->description }}
                    </p>
                </div>

                {{-- Card Footer Action --}}
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('pendidikan.show', $u->slug) }}" class="text-xs font-bold text-school-green hover:underline flex items-center">
                        <span>Detail &amp; Kurikulum</span>
                        <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                    </a>
                    <a href="{{ route('ppdb.index') }}" class="w-8 h-8 rounded-full bg-emerald-50 hover:bg-school-green text-school-green hover:text-white flex items-center justify-center text-xs transition" title="Daftar ke unit ini">
                        <i class="fa-solid fa-user-plus"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Unit Consultation Banner --}}
        <div class="mt-10 bg-gradient-to-r from-school-green via-emerald-800 to-emerald-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 reveal-fade-up">
            <div class="space-y-1 text-center md:text-left">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-300">Konsultasi Peminatan Santri</span>
                <h3 class="text-lg sm:text-2xl font-black">Bingung Memilih Jenjang yang Tepat untuk Putra-Putri Anda?</h3>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-xl">
                    Tim bimbingan konseling dan pendaftaran santri baru siap membantu menjelaskan kurikulum, asrama, dan kesiapan ananda.
                </p>
            </div>
            <div class="flex-shrink-0 flex flex-wrap gap-3 justify-center">
                @php
                    $waHelpNumber = preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '081278901950');
                    if (str_starts_with($waHelpNumber, '0')) {
                        $waHelpNumber = '62' . substr($waHelpNumber, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $waHelpNumber }}?text={{ urlencode('Assalamu\'alaikum, saya ingin berkonsultasi mengenai pilihan unit pendidikan di Pondok Pesantren Raudhatul Ulum Sakatiga.') }}" target="_blank" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-full shadow-lg transition flex items-center space-x-2 transform hover:scale-105">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Konsultasi via WhatsApp</span>
                </a>
                <a href="{{ route('pendidikan.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-full border border-white/20 transition">
                    Semua Unit Pendidikan
                </a>
            </div>
        </div>

    </div>
</section>

{{-- ========================================================
     SECTION #5: PSB SPOTLIGHT (Penerimaan Santri Baru Online - Inspired by Baitussalam)
     ======================================================== --}}
<section class="py-16 sm:py-20 bg-gray-900 text-white overflow-hidden relative">
    {{-- Islamic Background Glow --}}
    <div class="absolute inset-0 bg-[radial-gradient(#00843d_1.5px,transparent_1.5px)] [background-size:28px_28px] opacity-20 pointer-events-none"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-school-green/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-school-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12 reveal-fade-up">
            <span class="inline-block px-3.5 py-1 bg-school-gold/20 text-school-gold border border-school-gold/30 rounded-full text-xs font-black uppercase tracking-widest mb-3">
                PSB T.P. 2026 / 2027 Telah Dibuka
            </span>
            <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                Penerimaan Santri Baru (PSB) Online
            </h2>
            <p class="text-xs sm:text-base text-gray-300 mt-3 font-normal max-w-2xl mx-auto leading-relaxed">
                Bergabunglah bersama ribuan santri dari seluruh penjuru nusantara dalam lingkungan kaderisasi Islam yang unggul, disiplin, dan berwawasan global.
            </p>
            <div class="w-16 h-1 bg-school-gold mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- 3 Jalur Pendaftaran --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            {{-- Jalur 1: Prestasi --}}
            <div class="bg-gray-800/90 rounded-3xl p-6 sm:p-7 border border-gray-700/80 hover:border-school-gold transition-all duration-300 shadow-xl flex flex-col justify-between group reveal-fade-up delay-1">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            Jalur Prestasi
                        </span>
                        <i class="fa-solid fa-trophy text-amber-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-school-gold transition mb-2">
                        Akademik &amp; Tahfidz
                    </h3>
                    <p class="text-xs text-gray-300 leading-relaxed mb-4">
                        Diperuntukkan bagi calon santri dengan peringkat kelas/juara lomba sains, seni, pidato, atau hafalan Al-Qur'an minimal 3 juz.
                    </p>
                    <ul class="space-y-2 text-xs text-gray-300 border-t border-gray-700/60 pt-4">
                        <li class="flex items-center"><i class="fa-solid fa-check text-school-green mr-2 text-xs"></i> Bebas Ujian Tulis Standar</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-school-green mr-2 text-xs"></i> Peluang Beasiswa Santri Berprestasi</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-school-green mr-2 text-xs"></i> Kuota terbatas per gelombang</li>
                    </ul>
                </div>
                <div class="pt-5 mt-5">
                    <a href="{{ route('ppdb.index') }}" class="block w-full text-center bg-school-gold hover:bg-amber-400 text-gray-950 font-black text-xs py-2.5 rounded-xl transition">
                        Daftar Jalur Prestasi
                    </a>
                </div>
            </div>

            {{-- Jalur 2: Reguler --}}
            <div class="bg-gradient-to-b from-gray-800/90 to-emerald-950/40 rounded-3xl p-6 sm:p-7 border-2 border-school-green transition-all duration-300 shadow-2xl flex flex-col justify-between group reveal-fade-up delay-2 relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-school-green text-white text-[10px] font-black uppercase tracking-wider px-4 py-1 rounded-bl-xl shadow">
                    Paling Diminati
                </div>
                <div>
                    <div class="flex items-center justify-between mb-4 mt-2">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            Jalur Reguler
                        </span>
                        <i class="fa-solid fa-graduation-cap text-emerald-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-emerald-300 transition mb-2">
                        Ujian Masuk Terpadu
                    </h3>
                    <p class="text-xs text-gray-300 leading-relaxed mb-4">
                        Jalur umum terbuka untuk seluruh calon santri baru di jenjang MARU, SMAIT, MATSARU, SMPIT, MIRU, dan TAKIRU melalui seleksi terpadu.
                    </p>
                    <ul class="space-y-2 text-xs text-gray-300 border-t border-gray-700/60 pt-4">
                        <li class="flex items-center"><i class="fa-solid fa-check text-emerald-400 mr-2 text-xs"></i> Tes Membaca Al-Qur'an &amp; Tajwid</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-emerald-400 mr-2 text-xs"></i> Tes Akademik &amp; Psikotes Karakter</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-emerald-400 mr-2 text-xs"></i> Wawancara Calon Santri &amp; Orang Tua</li>
                    </ul>
                </div>
                <div class="pt-5 mt-5">
                    <a href="{{ route('ppdb.index') }}" class="block w-full text-center bg-school-green hover:bg-emerald-600 text-white font-black text-xs py-2.5 rounded-xl shadow-lg transition">
                        Daftar Jalur Reguler
                    </a>
                </div>
            </div>

            {{-- Jalur 3: Khusus Tahfidz MATQULARU --}}
            <div class="bg-gray-800/90 rounded-3xl p-6 sm:p-7 border border-gray-700/80 hover:border-sky-400 transition-all duration-300 shadow-xl flex flex-col justify-between group reveal-fade-up delay-3">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-sky-400/20 text-sky-300 border border-sky-400/30">
                            Jalur Khusus
                        </span>
                        <i class="fa-solid fa-book-quran text-sky-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-sky-300 transition mb-2">
                        Tahfidz 30 Juz Bersanad
                    </h3>
                    <p class="text-xs text-gray-300 leading-relaxed mb-4">
                        Program intensif percepatan hafalan Al-Qur'an 30 juz di bawah bimbingan masyaikh dan asatidz huffazh bersanad di MATQULARU.
                    </p>
                    <ul class="space-y-2 text-xs text-gray-300 border-t border-gray-700/60 pt-4">
                        <li class="flex items-center"><i class="fa-solid fa-check text-sky-400 mr-2 text-xs"></i> Target Mutqin 30 Juz Bersanad</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-sky-400 mr-2 text-xs"></i> Halaqah Asrama Khusus &amp; Pembimbing</li>
                        <li class="flex items-center"><i class="fa-solid fa-check text-sky-400 mr-2 text-xs"></i> Evaluasi Berkala &amp; Wisuda Akbar</li>
                    </ul>
                </div>
                <div class="pt-5 mt-5">
                    <a href="{{ route('ppdb.index') }}" class="block w-full text-center bg-sky-600 hover:bg-sky-500 text-white font-black text-xs py-2.5 rounded-xl transition">
                        Daftar Jalur Tahfidz
                    </a>
                </div>
            </div>
        </div>

        {{-- Alur Pendaftaran 3 Langkah --}}
        <div class="bg-gray-800/50 rounded-3xl p-6 sm:p-8 border border-gray-700/60 reveal-fade-up">
            <h3 class="text-center font-bold text-sm sm:text-base text-gray-200 mb-6">
                Alur Pendaftaran Santri Baru dalam 3 Langkah Praktis
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-school-green/20 text-school-green border border-school-green flex items-center justify-center font-black text-lg">
                        1
                    </div>
                    <h4 class="font-bold text-sm text-white">Isi Formulir Online</h4>
                    <p class="text-xs text-gray-400 max-w-xs">Lengkapi data santri &amp; orang tua melalui sistem PSB online serta unggah berkas persyaratan.</p>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-amber-400/20 text-amber-400 border border-amber-400 flex items-center justify-center font-black text-lg">
                        2
                    </div>
                    <h4 class="font-bold text-sm text-white">Seleksi &amp; Wawancara</h4>
                    <p class="text-xs text-gray-400 max-w-xs">Mengikuti tes kemampuan membaca Qur'an, akademik dasar, dan wawancara komitmen wali santri.</p>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <div class="w-12 h-12 rounded-full bg-sky-400/20 text-sky-400 border border-sky-400 flex items-center justify-center font-black text-lg">
                        3
                    </div>
                    <h4 class="font-bold text-sm text-white">Pengumuman &amp; Daftar Ulang</h4>
                    <p class="text-xs text-gray-400 max-w-xs">Cek hasil kelulusan secara online, pelunasan administrasi, dan persiapan masuk asrama pesantren.</p>
                </div>
            </div>
            <div class="pt-8 mt-6 border-t border-gray-700/60 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('ppdb.index') }}" class="bg-gradient-to-r from-school-gold to-amber-500 hover:from-amber-500 hover:to-amber-600 text-gray-950 font-black text-xs sm:text-sm px-8 py-3 rounded-full shadow-xl transition transform hover:scale-105">
                    <i class="fa-solid fa-graduation-cap mr-2"></i>
                    <span>Daftar PPDB &amp; PSB Online</span>
                </a>
                <a href="{{ route('download.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-full border border-white/20 transition">
                    <i class="fa-solid fa-file-arrow-down mr-2"></i>
                    <span>Unduh Brosur Biaya &amp; Syarat</span>
                </a>
            </div>
        </div>

    </div>
</section>

{{-- ========================================================
     SECTION #6: KABAR PESANTREN (Headline Berita, Taujih & Pengumuman)
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-gray-50 border-b border-gray-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col sm:flex-row items-center justify-between text-center sm:text-left gap-3 reveal-fade-up">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-emerald-100 text-school-green rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-newspaper text-xs"></i>
                    <span>Warta &amp; Informasi</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center justify-center sm:justify-start">
                    Kabar Pondok Pesantren &amp; Kabar Sekolah
                </h2>
                <div class="w-12 h-1 bg-school-gold mt-1.5 mx-auto sm:mx-0 rounded-full"></div>
            </div>
            <a href="{{ route('artikel.index') }}" aria-label="Lihat Semua Artikel dan Berita" class="text-xs sm:text-sm font-bold text-school-green hover:text-emerald-800 transition flex items-center">
                <span>Lihat Seluruh Berita</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Big Headline Card (7 Cols Desktop) --}}
            @if($featuredPost)
            <div class="lg:col-span-7 reveal-fade-up delay-1">
                <article class="bg-white rounded-3xl shadow-sm hover:shadow-xl overflow-hidden border border-gray-100 h-full flex flex-col group transition duration-300">
                    <div class="relative h-64 sm:h-84 overflow-hidden bg-gray-100">
                        <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-robbani.webp'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        @if($featuredPost->categories->isNotEmpty())
                        <span class="absolute top-4 left-4 bg-school-green text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $featuredPost->categories->first()->name }}
                        </span>
                        @endif
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <div class="text-xs text-gray-200 flex items-center space-x-3 mb-1">
                                <span><i class="fa-regular fa-calendar-check mr-1 text-amber-400" aria-hidden="true"></i> {{ $featuredPost->published_at ? $featuredPost->published_at->translatedFormat('d F Y') : '-' }}</span>
                                <span><i class="fa-regular fa-eye mr-1 text-emerald-400" aria-hidden="true"></i> {{ $featuredPost->views_count }} views</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 sm:p-7 flex-1 flex flex-col justify-between">
                        <div class="space-y-2.5">
                            <h3 class="text-lg sm:text-2xl font-black text-gray-900 group-hover:text-school-green transition line-clamp-2 leading-snug">
                                <a href="{{ route('artikel.show', $featuredPost->slug) }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 leading-relaxed">
                                {{ $featuredPost->excerpt }}
                            </p>
                        </div>
                        <div class="pt-5 mt-5 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-bold text-school-green">Warta Raudhatul Ulum</span>
                            <a href="{{ route('artikel.show', $featuredPost->slug) }}" class="text-xs font-bold text-gray-900 hover:text-school-green flex items-center">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right ml-1.5 text-xs text-school-green"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endif

            {{-- 4 Side Posts (5 Cols Desktop) --}}
            <div class="lg:col-span-5 space-y-4">
                @foreach($sidePosts as $index => $sp)
                <article class="bg-white rounded-2xl p-3.5 sm:p-4 shadow-xs hover:shadow-md border border-gray-100 hover:border-school-green/40 transition-all duration-300 flex items-center space-x-3.5 group reveal-fade-up delay-{{ $index + 2 }}">
                    <div class="w-24 h-24 sm:w-28 sm:h-24 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0 relative">
                        <img src="{{ $sp->featured_image_url }}" alt="{{ $sp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/activities-robbani.webp'">
                    </div>
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="text-[11px] text-gray-400 flex items-center space-x-2">
                            <span><i class="fa-regular fa-clock mr-1 text-school-green"></i> {{ $sp->published_at ? $sp->published_at->translatedFormat('d M Y') : '' }}</span>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-school-green transition line-clamp-2 leading-snug">
                            <a href="{{ route('artikel.show', $sp->slug) }}">
                                {{ $sp->title }}
                            </a>
                        </h4>
                        <p class="text-[11px] text-gray-500 line-clamp-1">
                            {{ $sp->excerpt }}
                        </p>
                    </div>
                </article>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #7: PRESTASI SANTRI & ASATIDZ
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 reveal-fade-up">
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-trophy mr-1 text-amber-500"></i> Capaian Membanggakan
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Prestasi Santri &amp; Prestasi Siswa
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1 font-medium">
                Capaian membanggakan santri Pondok Pesantren Raudhatul Ulum Sakatiga di tingkat daerah, nasional, dan internasional
            </p>
            <div class="w-16 h-1 bg-school-gold mx-auto mt-2.5 rounded-full"></div>
        </div>

        {{-- 4 Kolom di Desktop, 2 Kolom di Tablet, 1 Kolom di Mobile --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($fraksiPosts as $index => $post)
            <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col group reveal-fade-up delay-{{ ($index % 4) + 1 }}">
                <div class="aspect-[16/10] overflow-hidden rounded-t-2xl bg-gray-100 relative">
                    <a href="{{ route('artikel.show', $post->slug) }}" class="block w-full h-full" aria-label="Baca berita: {{ $post->title }}">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/activities-robbani.webp'">
                    </a>
                    <span class="absolute bottom-2.5 left-2.5 bg-black/75 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-0.5 rounded-md flex items-center">
                        <i class="fa-solid fa-medal text-amber-400 mr-1.5"></i> Prestasi
                    </span>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <h3 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-school-green transition line-clamp-2 leading-snug">
                        <a href="{{ route('artikel.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="text-[11px] sm:text-xs text-school-green mt-3 font-semibold flex items-center justify-between">
                        <span>{{ $post->published_at ? $post->published_at->translatedFormat('j F Y') : '' }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal-fade-up">
            <a href="{{ route('prestasi.index') }}" aria-label="Lihat Semua Prestasi Santri" class="inline-flex items-center bg-school-green hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-7 py-3 rounded-full shadow-md hover:shadow-lg transition">
                <span>Lihat Semua Prestasi Santri</span>
                <i class="fa-solid fa-arrow-right ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #8: PENGURUS YAYASAN (YAPIRUS) & DEWAN GURU
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-gray-50 border-t border-gray-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 reveal-fade-up">
            <span class="inline-block px-3 py-1 bg-emerald-100 text-school-green rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                Pimpinan &amp; Pengurus Yayasan
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Pengurus Yayasan &amp; Dewan Guru
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                Jajaran pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga dan pengurus Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS)
            </p>
            <div class="w-16 h-1 bg-school-green mx-auto mt-2.5 rounded-full"></div>
        </div>

        {{-- DESKTOP VIEW (4 Kolom) --}}
        <div class="hidden md:grid md:grid-cols-4 gap-6">
            @foreach($dewan as $index => $d)
            <div class="bg-white rounded-3xl p-4 shadow-xs hover:shadow-xl border border-gray-100 text-center group transition transform hover:-translate-y-1.5 reveal-fade-up delay-{{ $index + 1 }}">
                <div class="h-68 rounded-2xl overflow-hidden mb-3.5 bg-gray-100 relative">
                    <img src="{{ $d->photo_url }}" alt="Foto {{ $d->name }} - {{ $d->position }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/default-avatar.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center p-3">
                        <span class="text-white text-xs font-bold">{{ $d->position }}</span>
                    </div>
                </div>
                <h3 class="font-extrabold text-sm text-gray-900 group-hover:text-school-green transition leading-snug">
                    {{ $d->name }}
                </h3>
                <p class="text-xs text-school-green mt-1 font-semibold">
                    {{ $d->position }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- MOBILE VIEW (2 Kolom) --}}
        <div class="grid md:hidden grid-cols-2 gap-3.5">
            @foreach($dewan as $index => $d)
            <div class="bg-white rounded-2xl p-2.5 shadow-xs border border-gray-100 text-center reveal-fade-up delay-{{ $index + 1 }}">
                <div class="h-44 rounded-xl overflow-hidden mb-2 bg-gray-100">
                    <img src="{{ $d->photo_url }}" alt="Foto {{ $d->name }} - {{ $d->position }}" class="w-full h-full object-cover object-top" onerror="this.src='/uploads/default-avatar.webp'">
                </div>
                <h3 class="font-extrabold text-xs text-gray-900 leading-tight">
                    {{ $d->name }}
                </h3>
                <p class="text-[10px] text-school-green mt-0.5 font-semibold">
                    {{ $d->position }}
                </p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal-fade-up">
            <a href="{{ route('dewan.index') }}" aria-label="Lihat Seluruh Dewan Asatidz & Pengurus" class="inline-flex items-center bg-school-green hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-7 py-3 rounded-full shadow-md hover:shadow-lg transition">
                <span>Lihat Seluruh Pengurus &amp; Dewan Asatidz</span>
                <i class="fa-solid fa-arrow-right ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #9: STATISTIK & PENCAPAIAN PESANTREN (Counter)
     ======================================================== --}}
<section class="py-14 bg-gradient-to-r from-school-green via-emerald-800 to-school-green text-white overflow-hidden relative">
    <div class="absolute inset-0 bg-[radial-gradient(white_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">
            <div class="p-4 sm:p-6 bg-white/10 backdrop-blur-xs rounded-3xl border border-white/10 reveal-fade-up delay-1">
                <div class="text-3xl sm:text-5xl font-black text-amber-400 mb-1">75+</div>
                <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-100">Tahun Mengabdi</div>
                <p class="text-[11px] text-emerald-200/80 mt-1">Berdiri sejak 1 Agustus 1950</p>
            </div>
            <div class="p-4 sm:p-6 bg-white/10 backdrop-blur-xs rounded-3xl border border-white/10 reveal-fade-up delay-2">
                <div class="text-3xl sm:text-5xl font-black text-amber-400 mb-1">8</div>
                <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-100">Unit Pendidikan</div>
                <p class="text-[11px] text-emerald-200/80 mt-1">TK hingga Perguruan Tinggi</p>
            </div>
            <div class="p-4 sm:p-6 bg-white/10 backdrop-blur-xs rounded-3xl border border-white/10 reveal-fade-up delay-3">
                <div class="text-3xl sm:text-5xl font-black text-amber-400 mb-1">3.500+</div>
                <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-100">Santri &amp; Mahasiswa</div>
                <p class="text-[11px] text-emerald-200/80 mt-1">Dari berbagai penjuru Indonesia</p>
            </div>
            <div class="p-4 sm:p-6 bg-white/10 backdrop-blur-xs rounded-3xl border border-white/10 reveal-fade-up delay-4">
                <div class="text-3xl sm:text-5xl font-black text-amber-400 mb-1">15.000+</div>
                <div class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-100">Alumni Berkhidmat</div>
                <p class="text-[11px] text-emerald-200/80 mt-1">Kiprah dakwah di dalam &amp; luar negeri</p>
            </div>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #10: GALERI FOTO KEGIATAN SANTRI & PONDOK
     ======================================================== --}}
<section class="py-16 sm:py-20 bg-gray-950 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10 reveal-fade-up">
            <span class="inline-block px-3 py-1 bg-white/10 text-emerald-300 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                Dokumentasi Visual
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                Galeri Kehidupan Pesantren
            </h2>
            <p class="text-xs sm:text-sm text-gray-400 mt-2">
                Potret aktivitas ibadah, pembelajaran kelas, tahfidz Qur'an, dan dinamika santri di pondok PPRU Sakatiga
            </p>
            <div class="w-16 h-1 bg-school-gold mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="space-y-6 sm:space-y-8">
            {{-- ROW 1: SLIDER BARIS ATAS (3 items per view di desktop) --}}
            <div x-data="{
                current: 0,
                items: {{ Js::from($galleryRow1) }},
                perView: 3,
                timer: null,
                updatePerView() {
                    if (window.innerWidth < 640) {
                        this.perView = 1;
                    } else if (window.innerWidth < 1024) {
                        this.perView = 2;
                    } else {
                        this.perView = 3;
                    }
                },
                maxIndex() {
                    return Math.max(0, this.items.length - this.perView);
                },
                next() {
                    this.current = (this.current >= this.maxIndex()) ? 0 : this.current + 1;
                },
                prev() {
                    this.current = (this.current <= 0) ? this.maxIndex() : this.current - 1;
                },
                start() {
                    this.timer = setInterval(() => this.next(), 4000);
                },
                stop() {
                    clearInterval(this.timer);
                }
            }" x-init="updatePerView(); window.addEventListener('resize', () => updatePerView()); start()" @mouseenter="stop()" @mouseleave="start()" class="relative group/row1">
                
                {{-- Track --}}
                <div class="overflow-hidden py-2 px-1">
                    <div class="flex transition-transform duration-700 ease-out" :style="'transform: translateX(-' + (current * (100 / perView)) + '%)'">
                        <template x-for="(item, idx) in items" :key="idx">
                            <div class="flex-shrink-0 px-2 sm:px-3" :style="'width: ' + (100 / perView) + '%'">
                                <div class="relative h-64 sm:h-80 md:h-96 lg:h-[360px] rounded-3xl overflow-hidden shadow-2xl bg-neutral-900 border border-neutral-800/80 group">
                                    <img :src="item.url" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out" onerror="this.src='/uploads/campus-robbani.webp'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-5">
                                        <span class="text-xs sm:text-sm font-bold text-white leading-snug drop-shadow-md" x-text="item.title"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Left Arrow --}}
                <button @click="prev()" class="absolute left-1 sm:left-2 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/70 hover:bg-school-green text-white flex items-center justify-center border border-white/20 shadow-2xl z-20 backdrop-blur-sm transition duration-200 cursor-pointer" aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                {{-- Right Arrow --}}
                <button @click="next()" class="absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/70 hover:bg-school-green text-white flex items-center justify-center border border-white/20 shadow-2xl z-20 backdrop-blur-sm transition duration-200 cursor-pointer" aria-label="Foto berikutnya">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>

            {{-- ROW 2: SLIDER BARIS BAWAH (4 items per view di desktop) --}}
            <div x-data="{
                current: 0,
                items: {{ Js::from($galleryRow2) }},
                perView: 4,
                timer: null,
                updatePerView() {
                    if (window.innerWidth < 640) {
                        this.perView = 1;
                    } else if (window.innerWidth < 768) {
                        this.perView = 2;
                    } else if (window.innerWidth < 1024) {
                        this.perView = 3;
                    } else {
                        this.perView = 4;
                    }
                },
                maxIndex() {
                    return Math.max(0, this.items.length - this.perView);
                },
                next() {
                    this.current = (this.current >= this.maxIndex()) ? 0 : this.current + 1;
                },
                prev() {
                    this.current = (this.current <= 0) ? this.maxIndex() : this.current - 1;
                },
                start() {
                    this.timer = setInterval(() => this.next(), 4800);
                },
                stop() {
                    clearInterval(this.timer);
                }
            }" x-init="updatePerView(); window.addEventListener('resize', () => updatePerView()); start()" @mouseenter="stop()" @mouseleave="start()" class="relative group/row2">
                
                {{-- Track --}}
                <div class="overflow-hidden py-2 px-1">
                    <div class="flex transition-transform duration-700 ease-out" :style="'transform: translateX(-' + (current * (100 / perView)) + '%)'">
                        <template x-for="(item, idx) in items" :key="idx">
                            <div class="flex-shrink-0 px-2 sm:px-2.5" :style="'width: ' + (100 / perView) + '%'">
                                <div class="relative h-52 sm:h-64 md:h-72 lg:h-76 rounded-2xl overflow-hidden shadow-xl bg-neutral-900 border border-neutral-800/80 group">
                                    <img :src="item.url" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out" onerror="this.src='/uploads/activities-robbani.webp'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                        <span class="text-xs font-bold text-white leading-snug drop-shadow-md" x-text="item.title"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Left Arrow --}}
                <button @click="prev()" class="absolute left-1 sm:left-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/70 hover:bg-school-green text-white flex items-center justify-center border border-white/20 shadow-2xl z-20 backdrop-blur-sm transition duration-200 cursor-pointer" aria-label="Foto sebelumnya">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                {{-- Right Arrow --}}
                <button @click="next()" class="absolute right-1 sm:right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/70 hover:bg-school-green text-white flex items-center justify-center border border-white/20 shadow-2xl z-20 backdrop-blur-sm transition duration-200 cursor-pointer" aria-label="Foto berikutnya">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('galeri.index') }}" class="inline-flex items-center space-x-2.5 bg-school-green hover:bg-emerald-700 text-white text-xs sm:text-sm font-black px-8 py-3.5 rounded-2xl shadow-xl transition transform hover:scale-105">
                <i class="fa-regular fa-images text-base"></i>
                <span>Lihat Seluruh Galeri Foto</span>
            </a>
        </div>

    </div>
</section>

{{-- ========================================================
     SECTION #11: VIDEO KEGIATAN & PROFIL PESANTREN
     ======================================================== --}}
<section class="py-14 bg-gray-900 text-white overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-10 reveal-fade-up">
            <span class="inline-block px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-brands fa-youtube mr-1"></i> Dokumentasi Audio Visual
            </span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                Galeri Video &amp; Profil Kegiatan Santri
            </h2>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">
                Saksikan dinamika dakwah, tausiyah masyayikh, dan kreasi santri Raudhatul Ulum Sakatiga
            </p>
            <div class="w-16 h-1 bg-school-gold mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $index => $v)
            <div class="bg-gray-800/80 rounded-2xl overflow-hidden shadow-lg border border-gray-700/60 group hover:border-school-green transition reveal-fade-up delay-{{ ($index % 3) + 1 }}">
                <div class="aspect-video relative overflow-hidden bg-black">
                    @if(!empty($v->youtube_id))
                    <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/{{ $v->youtube_id }}" title="{{ $v->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-500">
                        <i class="fa-brands fa-youtube text-4xl text-red-500"></i>
                    </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-xs sm:text-sm text-white group-hover:text-amber-400 transition line-clamp-2">
                        {{ $v->title }}
                    </h3>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal-fade-up">
            <a href="{{ route('video.index') }}" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-bold px-7 py-3 rounded-full shadow transition">
                <i class="fa-brands fa-youtube mr-2 text-base"></i>
                <span>Lihat Seluruh Video YouTube</span>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #12: PENGUMUMAN & AGENDA AKADEMIK
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- PENGUMUMAN --}}
            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-200/80 flex flex-col justify-between reveal-fade-up delay-1">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                        <h2 class="text-base sm:text-lg font-black text-gray-900 flex items-center">
                            <i class="fa-solid fa-bullhorn text-school-green mr-2"></i> Pengumuman Pesantren
                        </h2>
                        <a href="{{ route('pengumuman.index') }}" class="text-xs text-school-green hover:underline font-bold">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($announcements as $ann)
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 hover:border-school-green transition shadow-xs">
                            <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">{{ $ann->created_at ? $ann->created_at->translatedFormat('d F Y') : '-' }}</span>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 hover:text-school-green transition mt-1 line-clamp-2">
                                <a href="{{ route('pengumuman.show', $ann->slug) }}">{{ $ann->title }}</a>
                            </h4>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 py-6 text-center">Belum ada pengumuman baru.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- AGENDA AKADEMIK & KEGIATAN --}}
            <div class="bg-gray-50 p-6 rounded-3xl border border-gray-200/80 flex flex-col justify-between reveal-fade-up delay-2">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                        <h2 class="text-base sm:text-lg font-black text-gray-900 flex items-center">
                            <i class="fa-solid fa-calendar-days text-amber-600 mr-2"></i> Agenda Kegiatan
                        </h2>
                        <a href="{{ route('agenda.index') }}" class="text-xs text-amber-600 hover:underline font-bold">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($agendas as $ag)
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 hover:border-amber-400 transition shadow-xs flex items-start space-x-3.5">
                            <div class="bg-amber-100 text-amber-800 rounded-xl p-2.5 text-center flex-shrink-0 w-14">
                                <span class="block text-base font-black leading-tight">{{ $ag->event_date ? $ag->event_date->format('d') : '-' }}</span>
                                <span class="block text-[10px] uppercase font-bold">{{ $ag->event_date ? $ag->event_date->format('M') : '-' }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 hover:text-amber-700 transition line-clamp-2">
                                    <a href="{{ route('agenda.show', $ag->slug) }}">{{ $ag->title }}</a>
                                </h4>
                                <p class="text-[11px] text-gray-500 mt-1">
                                    <i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> {{ $ag->location ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 py-6 text-center">Belum ada agenda terdekat.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #13: TESTIMONIAL ALUMNI & WALI SANTRI
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-gray-50 border-t border-gray-200/80 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10 reveal-fade-up">
            <span class="inline-block px-3 py-1 bg-emerald-100 text-school-green rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                Kesan &amp; Pengalaman
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Testimonial Alumni &amp; Wali Santri
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                Kesan mendalam tentang pembinaan aqidah, adab santri, dan keilmuan di Pondok Pesantren Raudhatul Ulum Sakatiga
            </p>
            <div class="w-16 h-1 bg-school-green mx-auto mt-2.5 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials as $index => $t)
            <div class="bg-white p-5 sm:p-6 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between reveal-fade-up delay-{{ $index + 1 }}">
                <div class="space-y-3">
                    <div class="text-school-gold text-2xl" aria-hidden="true">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-700 leading-relaxed italic line-clamp-4">
                        "{{ $t->content }}"
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-gray-100 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center flex-shrink-0 shadow-inner">
                        <img src="{{ $t->photo_url }}" alt="Foto {{ $t->name }}" class="w-full h-full object-cover" onerror="this.src='/uploads/avatar-neutral-gray.svg'">
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-xs text-gray-900 truncate">{{ $t->name }}</h3>
                        <p class="text-[11px] text-school-green font-semibold truncate">{{ $t->profession ?? 'Alumni / Wali Santri' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal-fade-up">
            <a href="{{ route('testimonial.index') }}" aria-label="Lihat Semua Testimonial" class="inline-flex items-center bg-gray-900 hover:bg-black text-white font-bold text-xs sm:text-sm px-7 py-3 rounded-full shadow transition">
                <span>Lihat Seluruh Testimoni</span>
                <i class="fa-solid fa-comments ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #14: INFAQ & WAKAF PEMBANGUNAN PESANTREN
     ======================================================== --}}
<section class="py-14 sm:py-18 bg-white border-t border-gray-100 overflow-hidden" aria-label="Donasi & Wakaf">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="bg-gradient-to-br from-emerald-900 via-school-green to-emerald-950 rounded-3xl p-6 sm:p-10 text-white shadow-2xl relative overflow-hidden reveal-fade-up">
            {{-- Islamic pattern bg --}}
            <div class="absolute inset-0 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:24px_24px] opacity-15 pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-3 text-center lg:text-left">
                    <span class="inline-block px-3 py-1 bg-amber-400 text-gray-950 rounded-full text-xs font-black uppercase tracking-wider">
                        Investasi Akhirat
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                        Wakaf Pembangunan &amp; Beasiswa Penghafal Al-Qur'an
                    </h2>
                    <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed max-w-2xl">
                        Mari alirkan pahala jariyah tanpa putus dengan berdonasi untuk perluasan sarana ibadah santri, asrama, ruang kelas, dan beasiswa santri dhuafa penghafal Al-Qur'an di Pondok Pesantren Raudhatul Ulum Sakatiga.
                    </p>
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs font-semibold text-amber-200">
                        <span class="flex items-center"><i class="fa-solid fa-shield-halved mr-1.5"></i> Amanah &amp; Transparan</span>
                        <span class="flex items-center"><i class="fa-solid fa-receipt mr-1.5"></i> Laporan Rutin</span>
                        <span class="flex items-center"><i class="fa-solid fa-building-columns mr-1.5"></i> Rekening Resmi Yayasan (YAPIRUS)</span>
                    </div>
                </div>
                <div class="lg:col-span-4 flex flex-col items-center justify-center space-y-3">
                    <a href="{{ route('donasi') }}" class="w-full sm:w-auto text-center bg-school-gold hover:bg-amber-400 text-gray-950 font-black text-xs sm:text-sm px-8 py-3.5 rounded-2xl shadow-xl transition transform hover:scale-105">
                        <i class="fa-solid fa-hand-holding-heart mr-2"></i>
                        <span>Salurkan Infaq &amp; Wakaf</span>
                    </a>
                    <a href="https://wa.me/{{ $waHelpNumber }}?text={{ urlencode('Assalamu\'alaikum, saya ingin konfirmasi infaq/wakaf untuk Pondok Pesantren Raudhatul Ulum Sakatiga.') }}" target="_blank" class="w-full sm:w-auto text-center bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-6 py-2.5 rounded-xl border border-white/20 transition">
                        <i class="fa-brands fa-whatsapp mr-1.5"></i>
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@if(($popupSettings['active'] ?? '0') === '1' && !empty($popupSettings['image']))
{{-- ========================================================
     HOMEPAGE PROMO POPUP BANNER MODAL
     ======================================================== --}}
<div id="ppruHomePopupModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="ppruHomePopupCard" class="relative bg-white rounded-3xl shadow-2xl overflow-hidden max-w-sm sm:max-w-md w-full transform scale-95 transition-transform duration-300 border border-white/20">
        {{-- Close Button --}}
        <button id="closePpruHomePopupBtn" type="button" aria-label="Tutup Banner Promosi" class="absolute top-3 right-3 z-10 w-9 h-9 bg-black/60 hover:bg-black text-white rounded-full flex items-center justify-center backdrop-blur-md transition shadow-lg cursor-pointer">
            <i class="fa-solid fa-xmark text-base"></i>
        </button>

        {{-- Banner Image Clickable --}}
        <a href="{{ $popupSettings['link'] ?? '/ppdb' }}" target="{{ $popupSettings['target'] ?? '_self' }}" class="block overflow-hidden group">
            <img src="{{ asset($popupSettings['image']) }}" alt="{{ $popupSettings['title'] ?? 'PSB Pondok Pesantren Raudhatul Ulum' }}" class="w-full h-auto max-h-[70vh] object-contain sm:object-cover group-hover:scale-102 transition duration-500">
        </a>

        {{-- Action Bar --}}
        <div class="p-3.5 sm:p-4 bg-gradient-to-r from-emerald-900 to-school-green text-white flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[11px] text-amber-300 font-bold uppercase tracking-wider truncate">
                    {{ $popupSettings['title'] ?? 'Pendaftaran Santri Baru (PSB)' }}
                </p>
                <p class="text-xs text-white/90 font-medium truncate">
                    {{ $popupSettings['subtitle'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                </p>
            </div>
            <a href="{{ $popupSettings['link'] ?? '/ppdb' }}" target="{{ $popupSettings['target'] ?? '_self' }}" class="shrink-0 bg-school-gold hover:bg-amber-400 text-gray-950 font-black text-xs px-4 py-2.5 rounded-xl shadow-md transition flex items-center space-x-1.5">
                <span>{{ $popupSettings['button_text'] ?? 'Daftar' }}</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('ppruHomePopupModal');
        const card = document.getElementById('ppruHomePopupCard');
        const closeBtn = document.getElementById('closePpruHomePopupBtn');

        if (!modal) return;

        // Check if user already dismissed it in this browser session
        if (!sessionStorage.getItem('ppru_home_popup_closed')) {
            setTimeout(function () {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 600);
        }

        function closePopup() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100');
            card.classList.add('scale-95');
            card.classList.remove('scale-100');
            sessionStorage.setItem('ppru_home_popup_closed', '1');
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closePopup);
        }

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closePopup();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) {
                closePopup();
            }
        });
    });
</script>
@endif

@endsection
