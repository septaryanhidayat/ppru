@extends('layouts.frontend')

@section('title', ($page?->meta_title ?: ($page?->title ?: 'Struktur Organisasi')) . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $page?->meta_description ?: 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $page?->title ?: 'Struktur Organisasi' }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $page?->title ?: 'Struktur Organisasi Pesantren' }}</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            {{ $page?->excerpt ?: 'Susunan pimpinan Pondok Pesantren Raudhatul Ulum dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16" x-data="{ 
    viewMode: 'chart',
    imageModalOpen: false,
    imageZoom: 100,
    zoomIn() { if (this.imageZoom < 180) this.imageZoom += 15; },
    zoomOut() { if (this.imageZoom > 50) this.imageZoom -= 15; },
    resetZoom() { this.imageZoom = 100; }
}">
    
    {{-- SEKSI 1: STRUKTUR ORGANISASI DUAL-MODE (Bagan Hirarki vs Daftar Kartu) --}}
    <section class="space-y-6">

        @if(!empty($strukturIntro))
            <div class="bg-gradient-to-r from-emerald-50 via-white to-emerald-50/60 rounded-3xl p-6 sm:p-8 shadow-xs border border-emerald-200/80 text-gray-700 text-xs sm:text-sm leading-relaxed reveal-fade-up">
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-[#00843d] px-3.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Informasi Kepengurusan</span>
                </div>
                <div class="prose-content text-slate-800 dark:text-slate-100">
                    {!! nl2br(e($strukturIntro)) !!}
                </div>
            </div>
        @elseif(!empty($page?->content) && strlen(trim(strip_tags($page->content))) > 0)
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-100 text-gray-700 text-xs sm:text-sm leading-relaxed reveal-fade-up">
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-[#00843d] px-3.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider mb-3">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Informasi Kepemimpinan</span>
                </div>
                <div class="prose-content">
                    {!! $page->content !!}
                </div>
            </div>
        @endif
        
        <!-- View Mode Switcher Header -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-100 inline-block">
                    Struktur Kepengurusan Resmi
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mt-2">
                    Susunan Pengurus Yayasan &amp; Pimpinan Pesantren
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Pilih model tampilan bagan visual hirarki interaktif atau daftar lengkap profil pengurus yayasan PPRU.
                </p>
            </div>

            <!-- Switcher Tabs -->
            <div class="inline-flex items-center p-1.5 rounded-2xl bg-white border border-gray-200 shadow-sm shrink-0 flex-wrap gap-1">
                <button type="button" 
                        @click="viewMode = 'chart'"
                        :class="viewMode === 'chart' ? 'bg-[#00843d] text-white shadow-md' : 'text-gray-600 hover:text-gray-900'"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-sitemap"></i>
                    <span>Bagan Struktur &amp; Hirarki</span>
                </button>
                <button type="button" 
                        @click="viewMode = 'grid'"
                        :class="viewMode === 'grid' ? 'bg-[#00843d] text-white shadow-md' : 'text-gray-600 hover:text-gray-900'"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-table-cells-large"></i>
                    <span>Daftar Kartu Pengurus</span>
                </button>
                <button type="button" 
                        @click="viewMode = 'table'"
                        :class="viewMode === 'table' ? 'bg-[#00843d] text-white shadow-md' : 'text-gray-600 hover:text-gray-900'"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer">
                    <i class="fa-solid fa-list-ol"></i>
                    <span>Daftar Nama Pengurus Yayasan</span>
                </button>
            </div>
        </div>

        <!-- TAMPILAN 1: BAGAN STRUKTUR (GAMBAR RESMI DAN/ATAU HIRARKI INTERAKTIF) -->
        <div x-show="viewMode === 'chart'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
            
            @if(!empty($chartImageUrl) && in_array($chartMode ?? 'both', ['image', 'both']))
                {{-- DISPLAY GAMBAR BAGAN STRUKTUR ORGANISASI RESMI --}}
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden p-4 sm:p-6 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-lg font-bold border border-emerald-200 shadow-xs">
                                <i class="fa-solid fa-image"></i>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-black text-slate-900 flex items-center gap-2">
                                    <span>Gambar Bagan Struktur Organisasi Resmi</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                                        Resolusi Tinggi
                                    </span>
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Bagan visual lengkap Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            {{-- ZOOM CONTROLS --}}
                            <div class="flex items-center bg-slate-100 p-0.5 rounded-xl border border-slate-200">
                                <button type="button" @click="zoomOut()" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 hover:bg-white text-xs font-bold transition cursor-pointer" title="Perkecil (-)">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span class="px-2 text-[10px] font-bold text-slate-700 min-w-[2.8rem] text-center" x-text="imageZoom + '%'">100%</span>
                                <button type="button" @click="zoomIn()" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 hover:bg-white text-xs font-bold transition cursor-pointer" title="Perbesar (+)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <button type="button" @click="resetZoom()" class="px-2 py-1 rounded-lg text-[10px] font-bold text-slate-600 hover:bg-white transition cursor-pointer" title="Reset Ukuran">
                                    Reset
                                </button>
                            </div>

                            {{-- LIGHTBOX MODAL TRIGGER --}}
                            <button type="button" @click="imageModalOpen = true" class="h-8 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold inline-flex items-center gap-1.5 transition cursor-pointer">
                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                                <span>Layar Penuh</span>
                            </button>

                            {{-- UNDUH FILE GAMBAR --}}
                            <a href="{{ $chartImageUrl }}" download="bagan-struktur-organisasi-ppru.webp" target="_blank" class="h-8 px-3.5 rounded-xl bg-[#00843d] hover:bg-[#006e33] text-white text-xs font-bold inline-flex items-center gap-1.5 shadow-sm transition">
                                <i class="fa-solid fa-download"></i>
                                <span>Unduh Gambar</span>
                            </a>
                        </div>
                    </div>

                    {{-- GAMBAR VIEWPORT DENGAN ZOOM & SCROLL --}}
                    <div class="w-full overflow-x-auto overflow-y-hidden bg-slate-50/80 rounded-2xl border border-slate-200/60 p-3 sm:p-6 flex justify-center items-center min-h-[380px]">
                        <div class="transition-transform duration-200 cursor-zoom-in" 
                             :style="'transform: scale(' + (imageZoom / 100) + '); transform-origin: top center;'"
                             @click="imageModalOpen = true">
                            <img src="{{ $chartImageUrl }}" 
                                 alt="Bagan Struktur Organisasi Yayasan & Pimpinan PPRU Sakatiga" 
                                 class="max-w-full h-auto mx-auto rounded-xl shadow-md border border-slate-200 object-contain hover:shadow-xl transition-shadow" 
                                 loading="lazy" 
                                 decoding="async">
                        </div>
                    </div>
                    <p class="text-center text-[11px] text-slate-400 italic">Klik gambar atau tombol Layar Penuh untuk melihat dalam ukuran maksimal.</p>
                </div>

                {{-- MODAL LIGHTBOX FULLSCREEN PREVIEW --}}
                <div x-show="imageModalOpen" 
                     x-cloak 
                     style="display: none;"
                     @keydown.escape.window="imageModalOpen = false"
                     class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 bg-black/85 backdrop-blur-sm">
                    <div class="fixed inset-0" @click="imageModalOpen = false"></div>
                    <div class="relative max-w-6xl max-h-[92vh] w-full bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col z-10" @click.stop>
                        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-850">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-sitemap text-emerald-600"></i>
                                <span class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white">Pratinjau Layar Penuh: Bagan Struktur Organisasi</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ $chartImageUrl }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-bold transition">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka Asli
                                </a>
                                <button type="button" @click="imageModalOpen = false" class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-rose-100 hover:text-rose-600 flex items-center justify-center transition cursor-pointer">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex-1 overflow-auto p-4 flex justify-center items-center bg-slate-100 dark:bg-slate-950">
                            <img src="{{ $chartImageUrl }}" alt="Bagan Struktur Organisasi" class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-lg">
                        </div>
                    </div>
                </div>
            @endif

            {{-- TAMPILKAN BAGAN HIRARKI SVG/NODE JIKA MODE 'DYNAMIC', 'BOTH', ATAU BELUM ADA GAMBAR --}}
            @if(empty($chartImageUrl) || in_array($chartMode ?? 'both', ['dynamic', 'both']))
                @if(!empty($chartImageUrl) && ($chartMode ?? 'both') === 'both')
                    <div class="pt-4 border-t border-slate-200">
                        <div class="mb-4">
                            <h3 class="text-base font-black text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-diagram-project text-[#00843d]"></i>
                                <span>Bagan Interaktif &amp; Skema Alur Kepemimpinan</span>
                            </h3>
                            <p class="text-xs text-slate-500">Bagan skema hirarki struktural pimpinan yayasan, mudir pesantren, asisten mudir, dan unit-unit pendidikan.</p>
                        </div>
                        @include('partials.organization-chart', ['tree' => $tree])
                    </div>
                @else
                    @include('partials.organization-chart', ['tree' => $tree])
                @endif
            @endif
        </div>

        <!-- TAMPILAN 2: DAFTAR KARTU GRID PENGURUS YAYASAN & PIMPINAN PPRU -->
        <div x-show="viewMode === 'grid'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($dewan as $d)
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/90 shadow-sm hover:shadow-xl transition-all duration-300 group hover:-translate-y-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-slate-700 flex items-center justify-center font-bold text-lg shadow-sm ring-2 ring-emerald-200 overflow-hidden shrink-0 aspect-square">
                                    <img src="{{ $d->photo_url }}" alt="{{ $d->name }}" width="64" height="64" loading="lazy" decoding="async" class="w-full h-full object-cover object-top" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-sm font-black text-gray-900 break-words group-hover:text-[#00843d] transition-colors leading-snug">{{ $d->name }}</h4>
                                    <span class="block text-[10px] font-bold text-emerald-700 uppercase break-words mt-0.5">
                                        {{ $d->fraction ?: 'Pengurus Yayasan & PPRU' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 mb-4">
                                <div class="text-[9px] uppercase font-black text-slate-400">Amanah / Jabatan</div>
                                <div class="text-xs font-black text-[#00843d] leading-snug mt-0.5 break-words">{{ $d->position }}</div>
                            </div>

                            @php
                                $rawSummary = $d->profile_summary ?? '';
                                $cleanSummary = trim(strip_tags(html_entity_decode($rawSummary, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                                if (empty($cleanSummary)) {
                                    $cleanSummary = trim(strip_tags($rawSummary));
                                }
                            @endphp
                            @if(!empty($cleanSummary))
                                <div class="text-[11px] text-gray-600 leading-relaxed font-light mb-4 break-words">
                                    {{ $cleanSummary }}
                                </div>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                            <span class="font-bold">Urutan: #{{ $d->order }}</span>
                            <span class="text-emerald-700 font-extrabold text-[10px] uppercase tracking-wider">YAPIRUS</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-400">
                        Data pengurus yayasan dan pimpinan sedang diproses.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TAMPILAN 3: TABEL DAFTAR LENGKAP NAMA PENGURUS YAYASAN PPRU -->
        <div x-show="viewMode === 'table'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-3xl border border-emerald-100 overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 inline-block mb-1">Daftar Lengkap</span>
                        <h3 class="text-xl font-black text-gray-900">Pengurus Yayasan &amp; Pimpinan Pesantren Raudhatul Ulum</h3>
                    </div>
                    <span class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-[#00843d] border border-emerald-200 text-xs font-bold self-start sm:self-auto">
                        Total {{ $dewan->count() }} Pejabat &amp; Asatidz
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs bg-white">
                        <thead class="bg-white border-b-2 border-emerald-500 text-slate-700 uppercase font-black tracking-wider text-[10px]">
                            <tr>
                                <th class="py-3.5 px-4 text-center w-12">No</th>
                                <th class="py-3.5 px-4">Foto &amp; Nama Lengkap</th>
                                <th class="py-3.5 px-4">Amanah / Jabatan</th>
                                <th class="py-3.5 px-4">Bidang / Lembaga</th>
                                <th class="py-3.5 px-4">Tugas &amp; Profil Singkat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($dewan as $d)
                                <tr class="hover:bg-emerald-50/40 transition">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                        {{ $d->order ?? $loop->iteration }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $d->photo_url }}" alt="{{ $d->name }}" class="w-10 h-10 rounded-xl object-cover object-top border border-emerald-200 shadow-xs shrink-0" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                                            <div>
                                                <div class="font-extrabold text-gray-900 text-sm break-words">{{ $d->name }}</div>
                                                <span class="text-[10px] text-emerald-700 font-semibold">{{ $d->fraction ?: 'Yayasan YAPIRUS' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-100/70 text-[#00843d] font-bold text-xs break-words">
                                            {{ $d->position }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700 break-words">
                                        {{ $d->fraction ?? 'Pengurus Yayasan' }}
                                    </td>
                                    @php
                                        $rawTableSummary = $d->profile_summary ?? '';
                                        $cleanTableSummary = trim(strip_tags(html_entity_decode($rawTableSummary, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                                        if (empty($cleanTableSummary)) {
                                            $cleanTableSummary = trim(strip_tags($rawTableSummary));
                                        }
                                    @endphp
                                    <td class="py-3.5 px-4 text-slate-500 max-w-sm break-words leading-relaxed text-[11px]">
                                        {{ $cleanTableSummary ?: 'Pejabat resmi Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>

    @if($showFacilities && $bidangs->isNotEmpty())
    {{-- SEKSI 2: FASILITAS & SARANA PRASARANA SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Sarana &amp; Prasarana pondok</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">Fasilitas Unggulan Pondok Pesantren Raudhatul Ulum</h2>
            </div>
            <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Selengkapnya</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bidangs as $b)
                <a href="{{ route('bidang.show', $b->slug) }}" class="rounded-2xl border border-gray-100 hover:border-[#00913e] hover:shadow-xl transition group bg-white overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $b->thumbnail_url }}" alt="{{ $b->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/uploads/logo-ppru-banner.png'">
                            <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow">
                                Sarana Pesantren
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900 group-hover:text-[#00913e] transition">{{ $b->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($b->description), 80) }}</p>
                        </div>
                    </div>
                    <div class="px-5 pb-4 pt-2 border-t border-gray-50 flex items-center justify-between text-xs text-[#00913e] font-bold">
                        <span>Rincian Fasilitas</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data fasilitas.
                </div>
            @endforelse
        </div>
    </section>
    @endif

    @if($showPrograms && $dpcs->isNotEmpty())
    {{-- SEKSI 3: PROGRAM UNGGULAN SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Kurikulum &amp; Karakter</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                    Program Unggulan Santri Raudhatul Ulum
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 font-light">Mengasah kecakapan santri menjadi pribadi cerdas, mandiri, dan berjiwa pelopor.</p>
            </div>
            <a href="{{ route('program-unggulan.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Semua Program</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($dpcs->take(8) as $dpc)
                <div class="rounded-2xl border border-gray-100 bg-white hover:border-[#00913e] hover:shadow-lg transition overflow-hidden group flex flex-col justify-between">
                    <div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $dpc->thumbnail_url }}" alt="{{ $dpc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/uploads/logo-ppru-banner.png'">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-[10px] font-bold text-[#00913e] block truncate uppercase tracking-wider">{{ $dpc->address ?: 'Program Unggulan' }}</span>
                            <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-1">{{ $dpc->name }}</h3>
                            <p class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($dpc->description), 65) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data program.
                </div>
            @endforelse
        </div>
    </section>
    @endif

</div>
@endsection
