@extends('layouts.frontend')

@section('title', 'SMA IT Ishlahul Ummah Prabumulih - Membina Generasi Qur\'ani, Berakhlak Mulia & Berprestasi')

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
    <div class="relative h-[380px] sm:h-[440px] lg:h-[490px] w-full overflow-hidden">
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
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/45 to-black/30"></div>

                {{-- Konten Rata Tengah --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center text-white space-y-3">
                        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest bg-[#da251c] text-white shadow-md">
                            SMA Islam Terpadu Unggulan
                        </span>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight drop-shadow-lg leading-tight" x-text="slide.title"></h1>
                        <p class="text-sm sm:text-base md:text-lg text-gray-100 font-medium max-w-2xl mx-auto drop-shadow" x-text="slide.subtitle"></p>
                        <div class="pt-3 flex justify-center">
                            <a :href="slide.btn_link" class="inline-flex items-center justify-center bg-[#da251c] hover:bg-[#b91c1c] text-white px-8 py-3 rounded-full font-extrabold text-xs sm:text-sm shadow-xl transition transform hover:scale-105">
                                <span x-text="slide.btn_text"></span>
                                <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Carousel Controls (Panah Samping) --}}
    <button @click="activeSlide = (activeSlide - 1 + slides.length) % slides.length" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-[#00913e] text-white w-11 h-11 rounded-full flex items-center justify-center transition backdrop-blur z-20 shadow-lg" aria-label="Slide sebelumnya">
        <i class="fa-solid fa-chevron-left text-xs sm:text-sm" aria-hidden="true"></i>
    </button>
    <button @click="activeSlide = (activeSlide + 1) % slides.length" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-[#00913e] text-white w-11 h-11 rounded-full flex items-center justify-center transition backdrop-blur z-20 shadow-lg" aria-label="Slide berikutnya">
        <i class="fa-solid fa-chevron-right text-xs sm:text-sm" aria-hidden="true"></i>
    </button>

    {{-- Dots Pagination di Tengah --}}
    <div class="absolute bottom-12 sm:bottom-16 left-1/2 -translate-x-1/2 flex space-x-1 z-20">
        <template x-for="(slide, idx) in slides" :key="idx">
            <button @click="activeSlide = idx" class="w-8 h-8 flex items-center justify-center cursor-pointer" :aria-label="'Pilih slide ' + (idx + 1)">
                <span class="h-2.5 rounded-full transition-all duration-300" :class="activeSlide === idx ? 'w-6 bg-[#da251c]' : 'w-2.5 bg-white/70 hover:bg-white'"></span>
            </button>
        </template>
    </div>
</section>

{{-- ========================================================
     SECTION: FLOATING QUICK ICONS / MENU UTAMA (8 Kartu Sekolah)
     ======================================================== --}}
<div x-data="{ showDownloadModal: false }" class="max-w-6xl mx-auto px-4 sm:px-6 relative z-30 -mt-8 sm:-mt-10 reveal-fade-up">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-4 sm:p-6 md:p-7">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 sm:mb-5 border-b border-gray-100">
            <div class="text-center sm:text-left">
                <h2 class="text-base sm:text-lg font-black text-gray-900 tracking-tight flex items-center justify-center sm:justify-start gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#00913e] inline-block animate-pulse"></span>
                    <span>Menu Utama Sekolah</span>
                </h2>
                <p class="text-xs text-gray-500 font-light mt-0.5">Akses cepat informasi dan layanan unggulan SMA IT Ishlahul Ummah Prabumulih</p>
            </div>
            <div class="flex items-center justify-center sm:justify-end">
                <button @click="showDownloadModal = true" type="button" aria-label="Buka Pilihan Download" class="bg-[#00913e] hover:bg-[#007532] text-white text-xs font-black px-4 py-2 rounded-full transition shadow flex items-center space-x-1.5 cursor-pointer transform hover:scale-105 min-h-[40px]">
                    <i class="fa-solid fa-download text-[11px]" aria-hidden="true"></i>
                    <span>Download Brosur</span>
                </button>
            </div>
        </div>

        @php
            $dbQuickMenus = \App\Models\QuickMenu::active()->orderBy('order', 'asc')->take(8)->get();
            if ($dbQuickMenus->isEmpty()) {
                $quickMenus = collect([
                    (object)['name' => 'PPDB Online', 'icon' => 'fa-solid fa-graduation-cap', 'url' => route('ppdb.index'), 'is_image' => false],
                    (object)['name' => 'Profil', 'icon' => 'fa-solid fa-school', 'url' => url('/tentang-kami'), 'is_image' => false],
                    (object)['name' => 'Dewan Guru', 'icon' => 'fa-solid fa-chalkboard-user', 'url' => route('dewan.index'), 'is_image' => false],
                    (object)['name' => 'Fasilitas', 'icon' => 'fa-solid fa-layer-group', 'url' => route('bidang.index'), 'is_image' => false],
                    (object)['name' => 'Unggulan', 'icon' => 'fa-solid fa-award', 'url' => route('dpc.index'), 'is_image' => false],
                    (object)['name' => 'Prestasi', 'icon' => 'fa-solid fa-trophy', 'url' => url('/prestasi'), 'is_image' => false],
                    (object)['name' => 'Ekskul', 'icon' => 'fa-solid fa-people-group', 'url' => url('/ekstrakurikuler'), 'is_image' => false],
                    (object)['name' => 'Kabar Sekolah', 'icon' => 'fa-solid fa-newspaper', 'url' => route('artikel.index'), 'is_image' => false],
                ]);
            } else {
                $quickMenus = $dbQuickMenus;
            }
        @endphp

        {{-- GRID QUICK MENUS: 4 Kolom di Mobile (2 baris x 4 item), 8 Kolom di Desktop (1 baris x 8 item) --}}
        <div class="grid grid-cols-4 md:grid-cols-8 gap-2 sm:gap-3 md:gap-3.5 text-center justify-items-center">
            @foreach($quickMenus as $qm)
            <a href="{{ $qm->url }}" 
               class="group w-full flex flex-col items-center justify-between text-center p-2 sm:p-2.5 md:py-3.5 md:px-1 rounded-2xl border border-slate-100 hover:border-[#00913e] bg-white hover:bg-emerald-50/30 shadow-xs hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 min-h-[88px] sm:min-h-[98px] md:min-h-[105px]" 
               aria-label="Menu {{ $qm->name }}">
                <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 rounded-2xl bg-emerald-50 text-[#00913e] flex items-center justify-center mx-auto mb-1.5 sm:mb-2 shadow-xs border border-emerald-100/70 group-hover:bg-[#00913e] group-hover:text-white group-hover:scale-110 transition-all duration-300">
                    @if(!empty($qm->is_image) && $qm->is_image)
                        <img src="{{ $qm->icon }}" alt="Ikon {{ $qm->name }}" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 object-contain group-hover:scale-105 transition" onerror="this.src='/uploads/logo-ishum-square.webp'">
                    @else
                        <i class="{{ $qm->icon }} text-lg sm:text-xl md:text-2xl transition-colors duration-300" aria-hidden="true"></i>
                    @endif
                </div>
                <span class="text-[10px] sm:text-[11px] md:text-xs font-bold text-slate-800 group-hover:text-[#00913e] text-center leading-tight line-clamp-2 w-full break-words tracking-tight px-0.5">
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
         
        {{-- Backdrop click to close --}}
        <div class="fixed inset-0" @click="showDownloadModal = false"></div>

        {{-- Modal Box Container --}}
        <div x-show="showDownloadModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-6 sm:p-8 border border-gray-100 z-10">

            {{-- Tombol Close X di Pojok Kanan Atas --}}
            <button @click="showDownloadModal = false" type="button" class="absolute top-4 right-4 sm:top-5 sm:right-5 w-9 h-9 rounded-lg bg-gray-900 text-white hover:bg-black transition flex items-center justify-center shadow-md cursor-pointer" aria-label="Tutup Pilihan Download">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Judul Modal --}}
            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-green-50 text-[#00913e] flex items-center justify-center text-xl mx-auto mb-2.5">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-gray-900">
                    Pusat Unduhan SMA IT Ishlahul Ummah Prabumulih
                </h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Silakan pilih kategori dokumen atau materi yang ingin Anda unduh
                </p>
                <div class="w-12 h-1 bg-[#da251c] mx-auto mt-3 rounded-full"></div>
            </div>

            {{-- 4 Pilihan Menu Download --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-6">
                <a href="{{ route('download.index') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-[#00913e] hover:bg-green-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-green-100 text-[#00913e] flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#00913e] transition">Formulir PPDB &amp; Panduan</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Brosur, tata tertib, dan syarat registrasi</p>
                    </div>
                </a>

                <a href="{{ route('download.ebook') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-[#00913e] hover:bg-green-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-orange-100 text-[#da251c] flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#00913e] transition">E-Library &amp; Modul Ajar</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Modul pembelajaran dan literasi santri</p>
                    </div>
                </a>

                <a href="{{ route('download.hymne-mars') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-[#00913e] hover:bg-green-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-green-100 text-[#00913e] flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#00913e] transition">Mars &amp; Hymne Sekolah</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Lirik dan audio resmi pembangkit semangat</p>
                    </div>
                </a>

                <a href="{{ route('download.logo') }}" class="flex items-center p-4 rounded-2xl border border-gray-200 hover:border-[#00913e] hover:bg-green-50/50 transition group shadow-xs">
                    <div class="w-11 h-11 rounded-xl bg-orange-100 text-[#da251c] flex items-center justify-center text-lg mr-3.5 flex-shrink-0 group-hover:scale-105 transition">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#00913e] transition">Logo Resmi Sekolah</h4>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">Aset logo resolusi tinggi SVG &amp; PNG</p>
                    </div>
                </a>
            </div>

            {{-- Footer info --}}
            <div class="text-center pt-2 border-t border-gray-100">
                <button @click="showDownloadModal = false" type="button" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
                    Kembali ke Beranda
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ========================================================
     SECTION #1: SAMBUTAN KEPALA SEKOLAH
     ======================================================== --}}
<section class="py-14 sm:py-20 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            {{-- Foto Kepala Sekolah (Ukuran Pas & Proporsional Sesuai Web Referensi) --}}
            <div class="lg:col-span-6 reveal-fade-up delay-1">
                <div class="max-w-sm sm:max-w-md mx-auto">
                    <div class="rounded-2xl sm:rounded-3xl overflow-hidden shadow-xl border border-gray-100 bg-gradient-to-b from-green-50 to-emerald-100 aspect-[4/3] max-h-[340px]">
                        <img src="/uploads/kepsek-agi-gustiawan.jpg" alt="Agi Gustiawan, S. Pd - Kepala SMA IT Ishlahul Ummah Prabumulih" class="w-full h-full object-cover object-center transform hover:scale-105 transition duration-500">
                    </div>
                    <p class="font-extrabold text-gray-900 text-lg sm:text-xl text-center mt-3 tracking-tight">
                        Agi Gustiawan, S. Pd
                    </p>
                    <p class="text-xs text-[#00913e] font-bold text-center">Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih</p>
                </div>
            </div>

            {{-- Isi Sambutan Rata Tengah --}}
            <div class="lg:col-span-6 space-y-4 reveal-fade-up delay-2 text-center">
                {{-- Ikon Kutipan Ganda --}}
                <div class="text-4xl sm:text-5xl text-green-200 flex justify-center leading-none mb-1" aria-hidden="true">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight text-center">
                    Sambutan Kepala Sekolah
                </h2>

                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed max-w-lg mx-auto font-normal text-center">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh. Alhamdulillah, puji syukur ke hadirat Allah SWT. Selamat datang di website resmi SMA IT Ishlahul Ummah Prabumulih. Lembaga pendidikan yang berikhtiar mendidik generasi muda Islam menjadi insan berakhlakul karimah, hafidz Qur'an, mandiri, dan unggul dalam sains serta teknologi modern untuk menyongsong masa depan gemilang...
                </p>

                {{-- Garis Pemisah Tipis --}}
                <div class="w-24 h-[1.5px] bg-[#00913e] mx-auto my-5"></div>

                {{-- Tombol Berjejer di Tengah (Sambutan Hijau & Visi Misi Hitam) --}}
                <div class="flex items-center justify-center space-x-3.5 pt-2">
                    <a href="{{ route('page.sambutan') }}" class="bg-[#00913e] hover:bg-[#007532] text-white px-6 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition flex items-center space-x-2">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Sambutan Lengkap</span>
                    </a>
                    <a href="{{ route('page.visi-misi') }}" class="bg-black hover:bg-gray-900 text-white px-6 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition flex items-center space-x-2">
                        <span>Visi &amp; Misi</span>
                        <i class="fa-regular fa-circle-dot"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #2: ARTIKEL & BERITA SEKOLAH (Headline Utama + 3 Samping)
     ======================================================== --}}
<section class="py-12 bg-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="mb-6 flex flex-col sm:flex-row items-center justify-between text-center sm:text-left gap-3 reveal-fade-up">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 flex items-center justify-center sm:justify-start">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#00913e] mr-2" aria-hidden="true"></span>
                    Artikel &amp; Berita Sekolah
                </h2>
                <div class="w-12 h-0.5 bg-[#da251c] mt-1 mx-auto sm:mx-0"></div>
            </div>
            <a href="{{ route('artikel.index') }}" aria-label="Lihat Semua Artikel dan Berita" class="text-xs sm:text-sm font-semibold text-[#00913e] hover:text-[#da251c] transition flex items-center">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1.5 text-xs" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Big Headline Card (60% Desktop) --}}
            @if($featuredPost)
            <div class="lg:col-span-7 reveal-fade-up delay-1">
                <article class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 h-full flex flex-col group">
                    <div class="relative h-60 sm:h-80 overflow-hidden bg-gray-100">
                        <img src="{{ $featuredPost->featured_image_url }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ishum.jpg'">
                        @if($featuredPost->categories->isNotEmpty())
                        <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow">
                            {{ $featuredPost->categories->first()->name }}
                        </span>
                        @endif
                    </div>
                    <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="text-xs text-gray-600 flex items-center space-x-3">
                                <span><i class="fa-regular fa-calendar-check mr-1 text-[#00913e]" aria-hidden="true"></i> {{ $featuredPost->published_at ? $featuredPost->published_at->translatedFormat('d F Y') : '-' }}</span>
                                <span><i class="fa-regular fa-eye mr-1 text-[#da251c]" aria-hidden="true"></i> {{ $featuredPost->views_count }} views</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#00913e] transition line-clamp-2">
                                <a href="{{ route('artikel.show', $featuredPost->slug) }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-700 line-clamp-3 leading-relaxed">
                                {{ $featuredPost->excerpt }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-semibold text-[#00913e]">Kabar Ishum</span>
                            <a href="{{ route('artikel.show', $featuredPost->slug) }}" class="text-xs font-bold text-[#da251c] hover:underline flex items-center">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @endif

            {{-- 3 Side Posts --}}
            <div class="lg:col-span-5 space-y-4">
                @foreach($sidePosts as $index => $sp)
                <article class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center space-x-4 group reveal-fade-up delay-{{ $index + 2 }}">
                    <div class="w-24 h-24 sm:w-28 sm:h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        <img src="{{ $sp->featured_image_url }}" alt="{{ $sp->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/lab-ishum.jpg'">
                    </div>
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="text-[11px] text-gray-500 flex items-center space-x-2">
                            <span><i class="fa-regular fa-clock mr-1 text-[#00913e]"></i> {{ $sp->published_at ? $sp->published_at->translatedFormat('d M Y') : '' }}</span>
                        </div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
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
     SECTION #3: PRESTASI SISWA SMA IT ISHLAHUL UMMAH
     ======================================================== --}}
<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-8 reveal-fade-up">
            <span class="text-xs uppercase tracking-widest text-[#da251c] font-bold block mb-1">Kebanggaan Sekolah</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#00913e] tracking-tight">
                Prestasi Siswa
            </h2>
            <p class="text-xs sm:text-sm text-gray-700 mt-1 font-medium">
                Capaian membanggakan santri &amp; siswa SMA IT Ishlahul Ummah Prabumulih di tingkat daerah, nasional, dan internasional
            </p>
            <div class="w-16 h-0.5 bg-[#da251c] mx-auto mt-2.5 rounded-full"></div>
        </div>

        {{-- 2 Baris: Desktop 4 kolom, Mobile 1 kolom --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($fraksiPosts as $index => $post)
            <article class="flex flex-col group reveal-fade-up delay-{{ ($index % 4) + 1 }}">
                <div class="aspect-[16/10] overflow-hidden rounded-2xl bg-gray-100 shadow-sm relative">
                    <a href="{{ route('artikel.show', $post->slug) }}" class="block w-full h-full" aria-label="Baca berita: {{ $post->title }}">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/lab-ishum.jpg'">
                    </a>
                    <span class="absolute bottom-2.5 left-2.5 bg-black/70 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-0.5 rounded-md">
                        <i class="fa-solid fa-trophy text-amber-400 mr-1"></i> Prestasi
                    </span>
                </div>
                <div class="pt-3 flex-1 flex flex-col justify-between">
                    <h3 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                        <a href="{{ route('artikel.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="text-[11px] sm:text-xs text-[#00913e] mt-1.5 font-medium">
                        {{ $post->published_at ? $post->published_at->translatedFormat('j F Y') : '' }}
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-8 reveal-fade-up">
            <a href="{{ route('artikel.index') }}?kategori=prestasi" aria-label="Lihat Semua Prestasi Siswa" class="inline-flex items-center bg-[#00913e] hover:bg-[#007532] text-white font-bold text-xs sm:text-sm px-7 py-2.5 rounded-full shadow transition">
                Lihat Semua Prestasi <i class="fa-solid fa-arrow-right ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #4: AKADEMIK & KESISWAAN (2 Kolom Berdampingan)
     ======================================================== --}}
<section class="py-12 bg-gray-50 border-y border-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- KOLOM 1: AKADEMIK & KURIKULUM --}}
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between reveal-fade-up delay-1">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#00913e] mr-2" aria-hidden="true"></span>
                            Akademik &amp; Kurikulum
                        </h2>
                        <span class="text-xs text-[#00913e] font-bold">Kurikulum Terpadu</span>
                    </div>

                    <div class="space-y-3.5">
                        @foreach($nasionalPosts as $post)
                        <div class="flex items-start space-x-3 group">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 mt-0.5">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/lab-ishum.jpg'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                </h4>
                                <span class="text-[11px] text-gray-500 mt-1 block">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 text-right">
                    <a href="{{ route('artikel.index') }}?kategori=akademik" class="text-xs font-bold text-[#00913e] hover:text-[#da251c] transition inline-flex items-center">
                        Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            {{-- KOLOM 2: KESISWAAN & EKSTRAKURIKULER --}}
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between reveal-fade-up delay-2">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#da251c] mr-2" aria-hidden="true"></span>
                            Kesiswaan &amp; Karakter
                        </h2>
                        <span class="text-xs text-[#da251c] font-bold">Aktivitas Santri</span>
                    </div>

                    <div class="space-y-3.5">
                        @foreach($daerahPosts as $post)
                        <div class="flex items-start space-x-3 group">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 mt-0.5">
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/tahfidz-ishum.jpg'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-[#da251c] transition line-clamp-2 leading-snug">
                                    <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                </h4>
                                <span class="text-[11px] text-gray-500 mt-1 block">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : '' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-4 mt-4 border-t border-gray-100 text-right">
                    <a href="{{ route('artikel.index') }}?kategori=kesiswaan" class="text-xs font-bold text-[#da251c] hover:text-[#00913e] transition inline-flex items-center">
                        Selengkapnya <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #5: PROGRAM UNGGULAN & EKSTRAKURIKULER (8 Cards)
     ======================================================== --}}
<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-8 reveal-fade-up">
            <span class="text-xs uppercase tracking-widest text-[#00913e] font-bold block mb-1">Membentuk Karakter Qur'ani</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#00913e] tracking-tight">
                Program Unggulan &amp; Ekstrakurikuler
            </h2>
            <p class="text-xs sm:text-sm text-gray-700 mt-1 font-medium">
                Pilar pembinaan tahfidz Qur'an, kecakapan bahasa, kepemimpinan, dan teknologi
            </p>
            <div class="w-16 h-0.5 bg-[#da251c] mx-auto mt-2.5 rounded-full"></div>
        </div>

        {{-- 2 Baris: Desktop 4 col, Mobile 1 col --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($senayanPosts as $index => $post)
            <article class="flex flex-col group reveal-fade-up delay-{{ ($index % 4) + 1 }}">
                <div class="aspect-[16/10] overflow-hidden rounded-2xl bg-gray-100 shadow-sm relative">
                    <a href="{{ route('artikel.show', $post->slug) }}" class="block w-full h-full" aria-label="Baca program: {{ $post->title }}">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/tahfidz-ishum.jpg'">
                    </a>
                </div>
                <div class="pt-3 flex-1 flex flex-col justify-between">
                    <h3 class="font-extrabold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                        <a href="{{ route('artikel.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="text-[11px] sm:text-xs text-[#da251c] mt-1.5 font-medium">
                        {{ $post->published_at ? $post->published_at->translatedFormat('j F Y') : '' }}
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="text-center mt-8 reveal-fade-up">
            <a href="{{ route('dpc.index') }}" aria-label="Lihat Semua Program Unggulan" class="inline-flex items-center bg-[#00913e] hover:bg-[#007532] text-white font-bold text-xs sm:text-sm px-7 py-2.5 rounded-full shadow transition">
                Jelajahi Program Unggulan <i class="fa-solid fa-arrow-right ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #6 - 9: DEWAN GURU & TENAGA KEPENDIDIKAN (GTK)
     ======================================================== --}}
<section class="py-12 bg-gray-50 border-t border-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-8 reveal-fade-up">
            <span class="text-xs uppercase tracking-widest text-[#da251c] font-bold block mb-1">Pendidik Berdedikasi</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Dewan Guru &amp; Tenaga Kependidikan
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                Para ustadz, ustadzah, dan pengajar profesional yang membimbing putra-putri Anda
            </p>
            <div class="w-16 h-1 bg-[#00913e] mx-auto mt-2 rounded-full"></div>
        </div>

        {{-- DESKTOP VIEW (4 Kolom 1 Baris) --}}
        <div class="hidden md:grid md:grid-cols-4 gap-6">
            @foreach($dewan as $index => $d)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 text-center group hover:shadow-lg transition transform hover:-translate-y-1 reveal-fade-up delay-{{ $index + 1 }}">
                <div class="h-64 rounded-xl overflow-hidden mb-3 bg-gray-100">
                    <img src="{{ $d->photo_url }}" alt="Foto {{ $d->name }} - {{ $d->position }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/kepsek-agi-gustiawan.jpg'">
                </div>
                <h3 class="font-extrabold text-sm text-gray-900 group-hover:text-[#00913e] transition">
                    {{ $d->name }}
                </h3>
                <p class="text-xs text-[#00913e] mt-0.5 font-semibold">
                    {{ $d->position }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- MOBILE VIEW (2 Kolom x 2 Baris) --}}
        <div class="grid md:hidden grid-cols-2 gap-3.5">
            @foreach($dewan as $index => $d)
            <div class="bg-white rounded-xl p-2.5 shadow-sm border border-gray-100 text-center reveal-fade-up delay-{{ $index + 1 }}">
                <div class="h-44 rounded-lg overflow-hidden mb-2 bg-gray-100">
                    <img src="{{ $d->photo_url }}" alt="Foto {{ $d->name }} - {{ $d->position }}" class="w-full h-full object-cover object-top" onerror="this.src='/uploads/kepsek-agi-gustiawan.jpg'">
                </div>
                <h3 class="font-extrabold text-xs text-gray-900 leading-tight">
                    {{ $d->name }}
                </h3>
                <p class="text-[10px] text-[#00913e] mt-0.5 font-semibold">
                    {{ $d->position }}
                </p>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 reveal-fade-up">
            <a href="{{ route('dewan.index') }}" aria-label="Lihat Semua Dewan Guru" class="inline-flex items-center bg-[#00913e] hover:bg-[#007532] text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-full shadow transition">
                Lihat Semua Dewan Guru &amp; GTK <i class="fa-solid fa-arrow-right ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #10: VIDEO KEGIATAN & PROFIL SEKOLAH
     ======================================================== --}}
<section class="py-14 bg-gray-900 text-white overflow-hidden relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-10 reveal-fade-up">
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                Galeri Video Kegiatan
            </h2>
            <p class="text-xs sm:text-sm text-[#da251c] mt-1 font-semibold">
                Dokumentasi Audio Visual Kehidupan Kampus SMA IT Ishlahul Ummah Prabumulih
            </p>
            <div class="w-16 h-1 bg-[#da251c] mx-auto mt-3 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($videos as $index => $v)
            <div class="bg-gray-800/80 rounded-2xl overflow-hidden shadow-lg border border-gray-700/60 group hover:border-[#00913e] transition reveal-fade-up delay-{{ ($index % 3) + 1 }}">
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
                    <h3 class="font-bold text-xs sm:text-sm text-white group-hover:text-[#da251c] transition line-clamp-2">
                        {{ $v->title }}
                    </h3>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal-fade-up">
            <a href="{{ route('video.index') }}" class="inline-flex items-center bg-[#da251c] hover:bg-[#b91c1c] text-white text-xs sm:text-sm font-bold px-7 py-2.5 rounded-full shadow transition">
                Lihat Semua Video <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #12: PENGUMUMAN & AGENDA AKADEMIK (2 Kolom)
     ======================================================== --}}
<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- PENGUMUMAN --}}
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col justify-between reveal-fade-up delay-1">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center">
                            <i class="fa-solid fa-bullhorn text-[#00913e] mr-2"></i> Pengumuman Sekolah
                        </h2>
                        <a href="{{ route('pengumuman.index') }}" class="text-xs text-[#00913e] hover:underline font-bold">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($announcements as $ann)
                        <div class="bg-white p-3.5 rounded-xl border border-gray-100 hover:border-[#00913e] transition">
                            <span class="text-[10px] font-bold text-[#da251c] uppercase">{{ $ann->created_at ? $ann->created_at->translatedFormat('d F Y') : '-' }}</span>
                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 hover:text-[#00913e] transition mt-1">
                                <a href="{{ route('pengumuman.show', $ann->slug) }}">{{ $ann->title }}</a>
                            </h4>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 py-4 text-center">Belum ada pengumuman baru.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- AGENDA AKADEMIK --}}
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col justify-between reveal-fade-up delay-2">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center">
                            <i class="fa-solid fa-calendar-days text-[#da251c] mr-2"></i> Agenda Akademik
                        </h2>
                        <a href="{{ route('agenda.index') }}" class="text-xs text-[#da251c] hover:underline font-bold">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($agendas as $ag)
                        <div class="bg-white p-3.5 rounded-xl border border-gray-100 hover:border-[#da251c] transition flex items-start space-x-3">
                            <div class="bg-orange-100 text-[#da251c] rounded-lg p-2 text-center flex-shrink-0 w-12">
                                <span class="block text-xs font-black">{{ $ag->event_date ? $ag->event_date->format('d') : '-' }}</span>
                                <span class="block text-[9px] uppercase font-bold">{{ $ag->event_date ? $ag->event_date->format('M') : '-' }}</span>
                            </div>
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 hover:text-[#da251c] transition">
                                    <a href="{{ route('agenda.show', $ag->slug) }}">{{ $ag->title }}</a>
                                </h4>
                                <p class="text-[11px] text-gray-500 mt-0.5">
                                    <i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> {{ $ag->location ?? 'Kampus Ishum' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-xs text-gray-500 py-4 text-center">Belum ada agenda terdekat.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #13: GALERI FOTO KEGIATAN SISWA (2 Baris Slider)
     ======================================================== --}}
<section class="py-14 bg-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 mb-8 text-center reveal-fade-up">
        <span class="text-xs uppercase tracking-widest text-[#00913e] font-bold block mb-1">Dokumentasi Sekolah</span>
        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
            Galeri Foto Kegiatan Siswa
        </h2>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">
            Merekam momen berharga dalam proses belajar, tahfidz, laboratorium, dan ekstrakurikuler
        </p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto mt-3 rounded-full"></div>
    </div>

    {{-- Slider Baris 1 --}}
    <div class="space-y-4">
        <div class="flex overflow-x-auto space-x-4 pb-2 scrollbar-none px-4 max-w-7xl mx-auto">
            @foreach($galleryRow1 as $item)
            <div class="flex-shrink-0 w-64 sm:w-72 h-44 sm:h-48 rounded-2xl overflow-hidden shadow-md relative group">
                <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='/uploads/campus-ishum.jpg'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition p-3 flex items-end">
                    <span class="text-xs font-bold text-white leading-tight">{{ $item['title'] }}</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Slider Baris 2 --}}
        <div class="flex overflow-x-auto space-x-4 pb-2 scrollbar-none px-4 max-w-7xl mx-auto">
            @foreach($galleryRow2 as $item)
            <div class="flex-shrink-0 w-64 sm:w-72 h-44 sm:h-48 rounded-2xl overflow-hidden shadow-md relative group">
                <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" onerror="this.src='/uploads/lab-ishum.jpg'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition p-3 flex items-end">
                    <span class="text-xs font-bold text-white leading-tight">{{ $item['title'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('galeri.index') }}" class="inline-flex items-center bg-gray-900 hover:bg-black text-white text-xs sm:text-sm font-bold px-7 py-2.5 rounded-full shadow transition">
            Lihat Semua Foto Galeri <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </a>
    </div>
</section>

{{-- ========================================================
     SECTION #14: CALL TO ACTION BANNER (PPDB ONLINE)
     ======================================================== --}}
<section class="relative bg-gradient-to-r from-[#00913e] via-[#05a849] to-[#b91c1c] text-white py-12 px-4 sm:px-6 overflow-hidden reveal-fade-up">
    <div class="max-w-6xl mx-auto relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div>
            <span class="inline-block bg-white/20 text-white text-xs font-bold px-3.5 py-1 rounded-full uppercase tracking-wider mb-2">
                Penerimaan Peserta Didik Baru (PPDB)
            </span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                Daftar Sekarang di SMA IT Ishlahul Ummah Prabumulih
            </h2>
            <p class="text-xs sm:text-sm text-green-50 mt-1 max-w-xl">
                Wujudkan cita-cita putra-putri Anda menjadi generasi berakhlak Qur'ani, berdaya saing global, dan berprestasi tinggi. Kuota terbatas setiap tahunnya!
            </p>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <a href="{{ route('hubungi') }}?type=ppdb" aria-label="Daftar Sekarang PPDB Online" class="bg-white text-[#00913e] hover:bg-orange-50 font-black text-xs sm:text-sm px-7 py-3 rounded-full shadow-lg hover:shadow-xl transition flex-shrink-0 min-h-[44px] flex items-center">
                Daftar PPDB Online <i class="fa-solid fa-graduation-cap ml-2 text-[#da251c]"></i>
            </a>
            <a href="{{ route('download.index') }}" aria-label="Unduh Brosur Informasi" class="bg-black/30 hover:bg-black/50 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-full border border-white/40 transition">
                Unduh Brosur
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #15: E-LIBRARY & MODUL SISWA
     ======================================================== --}}
<section class="py-14 bg-gray-100 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        
        <div class="bg-[#0b131f] text-white rounded-3xl p-6 sm:p-10 border border-neutral-800 shadow-2xl reveal-fade-up">
            
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs uppercase tracking-widest text-[#da251c] font-bold block mb-1">Sumber Belajar Terpadu</span>
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                    E-Library &amp; Modul Pembelajaran
                </h2>
                <p class="text-xs sm:text-sm text-emerald-400 font-semibold mt-1">
                    Unduh Modul Kurikulum, Tahfidzul Qur'an &amp; Panduan Belajar Siswa
                </p>
                <div class="w-16 h-0.5 bg-gray-500 mx-auto mt-2 rounded-full"></div>
            </div>

            <div x-data="{
                current: 0,
                items: {{ Js::from($ebooks) }},
                perView: 4,
                timer: null,
                updatePerView() {
                    if (window.innerWidth < 640) {
                        this.perView = 1;
                    } else if (window.innerWidth < 1024) {
                        this.perView = 2;
                    } else {
                        this.perView = 4;
                    }
                },
                maxIndex() {
                    return Math.max(0, this.items.length - this.perView);
                },
                next() {
                    if (this.current >= this.maxIndex()) {
                        this.current = 0;
                    } else {
                        this.current++;
                    }
                },
                prev() {
                    if (this.current <= 0) {
                        this.current = this.maxIndex();
                    } else {
                        this.current--;
                    }
                },
                start() {
                    this.timer = setInterval(() => this.next(), 3500);
                },
                stop() {
                    clearInterval(this.timer);
                }
            }" x-init="updatePerView(); window.addEventListener('resize', () => updatePerView()); start()" @mouseenter="stop()" @mouseleave="start()" class="relative px-2 sm:px-4">
                
                {{-- Carousel Track --}}
                <div class="overflow-hidden py-3">
                    <div class="flex transition-transform duration-500 ease-out" :style="'transform: translateX(-' + (current * (100 / perView)) + '%)'">
                        <template x-for="(eb, idx) in items" :key="idx">
                            <div class="flex-shrink-0 px-2.5 sm:px-3" :style="'width: ' + (100 / perView) + '%'">
                                <a href="{{ route('download.ebook') }}" class="group block relative rounded-2xl overflow-hidden shadow-2xl bg-neutral-900 border border-neutral-800 transform hover:scale-104 transition duration-300 cursor-pointer h-72 sm:h-80 lg:h-96 w-full" :aria-label="'Unduh modul: ' + eb.title">
                                    <img :src="eb.cover" :alt="eb.title" class="w-full h-full object-cover object-center group-hover:scale-106 transition duration-500" onerror="this.src='/uploads/campus-ishum.jpg'">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end justify-center p-3 text-center" aria-hidden="true">
                                        <span class="text-xs font-bold text-white truncate max-w-full" x-text="eb.title"></span>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Navigasi Panah --}}
                <button @click="prev()" class="absolute left-0 sm:left-1 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/70 hover:bg-[#00913e] text-white flex items-center justify-center transition border border-neutral-700 shadow-2xl z-20" aria-label="Modul sebelumnya">
                    <i class="fa-solid fa-chevron-left text-xs sm:text-sm" aria-hidden="true"></i>
                </button>
                <button @click="next()" class="absolute right-0 sm:right-1 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/70 hover:bg-[#00913e] text-white flex items-center justify-center transition border border-neutral-700 shadow-2xl z-20" aria-label="Modul berikutnya">
                    <i class="fa-solid fa-chevron-right text-xs sm:text-sm" aria-hidden="true"></i>
                </button>

                {{-- Tombol Unduh Modul --}}
                <div class="pt-6 flex justify-center">
                    <a href="{{ route('download.ebook') }}" aria-label="Akses Perpustakaan Digital SMA IT Ishlahul Ummah Prabumulih" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-black text-xs sm:text-sm px-8 py-3 rounded-2xl shadow-xl transition flex items-center space-x-2 transform hover:scale-105 min-h-[44px]">
                        <i class="fa-solid fa-download" aria-hidden="true"></i>
                        <span>Akses Semua Modul &amp; E-Book</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

{{-- ========================================================
     SECTION #16: TESTIMONIAL ALUMNI & WALI MURID
     ======================================================== --}}
<section class="py-12 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-8 reveal-fade-up">
            <span class="text-xs uppercase tracking-widest text-[#00913e] font-bold block mb-1">Kisah Inspiratif</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Testimonial Alumni &amp; Wali Murid
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">
                Kesan mendalam tentang pembinaan akhlak, hafalan Qur'an, dan prestasi akademik di SMA IT Ishlahul Ummah Prabumulih
            </p>
            <div class="w-16 h-1 bg-[#00913e] mx-auto mt-2 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials as $index => $t)
            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between reveal-fade-up delay-{{ $index + 1 }}">
                <div class="space-y-3">
                    <div class="text-[#00913e] text-xl" aria-hidden="true">
                        <i class="fa-solid fa-quote-left"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-700 leading-relaxed italic line-clamp-4">
                        "{{ $t->content }}"
                    </p>
                </div>
                <div class="pt-4 mt-4 border-t border-gray-200/60 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left space-y-2 sm:space-y-0 sm:space-x-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-green-100 flex items-center justify-center text-[#00913e] font-bold text-xs flex-shrink-0 mx-auto sm:mx-0">
                        <img src="{{ $t->photo_url }}" alt="Foto {{ $t->name }}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=0d6b38&color=fff'">
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-xs text-gray-900 truncate text-center sm:text-left">{{ $t->name }}</h3>
                        <p class="text-[11px] text-[#00913e] font-semibold truncate text-center sm:text-left">{{ $t->profession ?? 'Alumni / Wali Murid' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8 reveal-fade-up">
            <a href="{{ route('testimonial.index') }}" aria-label="Lihat Semua Testimonial" class="inline-flex items-center bg-gray-900 hover:bg-black text-white font-bold text-xs sm:text-sm px-6 py-2.5 rounded-full shadow transition">
                Lihat Semua Testimoni <i class="fa-solid fa-comments ml-2 text-xs" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SECTION #17: BOTTOM QUICK ACTION CARDS
     ======================================================== --}}
<section class="py-8 bg-gray-50 border-t border-gray-200 overflow-hidden" aria-label="Aksi dan Layanan Cepat">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <h2 class="sr-only">Aksi dan Layanan Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <a href="{{ route('hubungi') }}?type=ppdb" class="bg-white p-4 rounded-xl border-t-4 border-[#00913e] shadow-sm hover:shadow-md transition flex items-center space-x-3.5 group reveal-fade-up delay-1" aria-label="Pendaftaran PPDB Online SMA IT Ishlahul Ummah Prabumulih">
                <div class="w-12 h-12 rounded-full bg-green-50 text-[#00913e] flex items-center justify-center text-xl flex-shrink-0 group-hover:bg-[#00913e] group-hover:text-white transition" aria-hidden="true">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-[#00913e] transition">PPDB Online Ishum</h3>
                    <p class="text-xs text-gray-600">Pendaftaran santri baru gelombang aktif</p>
                </div>
            </a>

            <a href="https://wa.me/6282177889900" target="_blank" class="bg-white p-4 rounded-xl border-t-4 border-[#da251c] shadow-sm hover:shadow-md transition flex items-center space-x-3.5 group reveal-fade-up delay-2" aria-label="Hubungi Hotline Sekolah via WhatsApp">
                <div class="w-12 h-12 rounded-full bg-orange-50 text-[#da251c] flex items-center justify-center text-xl flex-shrink-0 group-hover:bg-[#da251c] group-hover:text-white transition" aria-hidden="true">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-[#da251c] transition">Konsultasi via WhatsApp</h3>
                    <p class="text-xs text-gray-600">Layanan informasi PPDB &amp; akademik</p>
                </div>
            </a>

            <a href="{{ route('donasi') }}" class="bg-white p-4 rounded-xl border-t-4 border-emerald-500 shadow-sm hover:shadow-md transition flex items-center space-x-3.5 group reveal-fade-up delay-3" aria-label="Infaq & Beasiswa Ishum">
                <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition" aria-hidden="true">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-emerald-600 transition">Infaq &amp; Beasiswa Santri</h3>
                    <p class="text-xs text-gray-600">Dukung sarana &amp; beasiswa penghafal Qur'an</p>
                </div>
            </a>

        </div>
    </div>
</section>

@endsection
