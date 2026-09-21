@extends('layouts.frontend')

@section('title', $unit->name . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', Str::limit(strip_tags($unit->description), 160))

@section('content')
{{-- 1. HERO BANNER (Full Width, Islamic Aesthetic) --}}
<section class="relative bg-gradient-to-br from-[#005a28] via-[#00843d] to-[#043317] text-white py-14 sm:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    @if($unit->hero_image)
        <div class="absolute inset-0 z-0">
            <img src="{{ $unit->hero_image_url }}" alt="Banner {{ $unit->name }}" class="w-full h-full object-cover opacity-25 filter brightness-90">
            <div class="absolute inset-0 bg-gradient-to-r from-[#003d1b]/95 via-[#005a28]/90 to-[#00843d]/85"></div>
        </div>
    @endif
    <div class="absolute -right-16 -bottom-16 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-16 -top-16 w-96 h-96 bg-[#f59e0b]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto space-y-5 relative z-10">
        <div class="flex flex-wrap items-center gap-2.5">
            <span class="bg-black/20 border border-white/20 text-white text-xs font-extrabold px-3.5 py-1 rounded-full shadow-xs uppercase tracking-wider backdrop-blur-xs">
                <i class="fa-solid fa-school mr-1.5 text-amber-300"></i> {{ $unit->category_type }}
            </span>
            @if($unit->badge)
                <span class="bg-[#f59e0b] text-slate-950 text-xs font-black px-3.5 py-1 rounded-full shadow-xs flex items-center">
                    <i class="fa-solid fa-award mr-1.5"></i> {{ $unit->badge }}
                </span>
            @endif
            @if($unit->short_name)
                <span class="bg-white/20 text-white text-xs font-bold px-3.5 py-1 rounded-full backdrop-blur-xs">
                    {{ $unit->short_name }}
                </span>
            @endif
            <span class="bg-emerald-950/60 border border-emerald-400/30 text-emerald-200 text-xs font-bold px-3 py-1 rounded-full">
                YAPIRUS Sakatiga &bull; Terakreditasi
            </span>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-white/95 p-3 shadow-2xl border-2 border-emerald-400/40 flex items-center justify-center shrink-0">
                @if(!empty($unit->logo))
                    <img src="{{ $unit->logo_url }}" alt="Logo {{ $unit->name }}" class="max-w-full max-h-full object-contain">
                @elseif(!empty($unit->thumbnail) && (str_contains($unit->thumbnail, 'logo') || str_contains($unit->thumbnail, 'emblem')))
                    <img src="{{ $unit->thumbnail_url }}" alt="Logo {{ $unit->name }}" class="max-w-full max-h-full object-contain">
                @else
                    <img src="/uploads/logo-ppru-emblem.png" alt="Logo {{ $unit->name }}" class="max-w-full max-h-full object-contain">
                @endif
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight text-white drop-shadow-sm max-w-4xl">
                    {{ $unit->name }}
                </h1>
                @if($unit->curriculum)
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium flex items-center mt-2">
                        <i class="fa-solid fa-book-quran mr-2 text-[#f59e0b] text-base shrink-0"></i>
                        <span>{{ $unit->curriculum }}</span>
                    </p>
                @endif
            </div>
        </div>

        {{-- Top Action Buttons --}}
        <div class="pt-2 flex flex-wrap items-center gap-3">
            <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 font-black text-xs sm:text-sm px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition flex items-center space-x-2 transform hover:scale-105">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Daftar PSB Online {{ $unit->short_name ?: $unit->name }}</span>
            </a>
            @if($unit->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone) }}?text=Assalamu%27alaikum%20Panitia%20PSB%20{{ urlencode($unit->name) }}%2C%20saya%20ingin%20konsultasi%20pendaftaran" target="_blank" rel="noopener" class="bg-white/15 hover:bg-white/25 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-full border border-white/20 backdrop-blur-xs transition flex items-center space-x-2">
                    <i class="fa-brands fa-whatsapp text-emerald-300 text-base"></i>
                    <span>Konsultasi WhatsApp</span>
                </a>
            @endif
            <a href="{{ route('download.index') }}" class="bg-black/20 hover:bg-black/30 text-emerald-100 font-bold text-xs sm:text-sm px-5 py-3 rounded-full border border-emerald-500/30 transition flex items-center space-x-2">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>Unduh Brosur &amp; Rincian Biaya</span>
            </a>
        </div>
    </div>
</section>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100 py-3 shadow-xs sticky top-20 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2 text-xs text-gray-500 font-medium overflow-x-auto">
        <a href="{{ route('home') }}" class="hover:text-[#00843d] flex items-center shrink-0"><i class="fa-solid fa-house mr-1.5 text-[#00843d]"></i> Beranda</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('pendidikan.index') }}" class="hover:text-[#00843d] shrink-0">Unit Pendidikan</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-bold truncate">{{ $unit->name }}</span>
    </div>
</div>

{{-- 2. INTEGRATED UNIT HIGHLIGHTS BAR (Modern, Premium, Anti-Clipping) --}}
<section class="py-6 sm:py-8 bg-slate-50 border-b border-gray-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 items-stretch">
            
            {{-- Card 1: Jenjang & Akreditasi --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between h-full group">
                <div class="flex items-start space-x-3.5">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-lg shrink-0 border border-emerald-100 group-hover:scale-105 transition">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 block">Jenjang Pendidikan</span>
                        <h3 class="text-sm font-black text-gray-900 mt-0.5 leading-snug line-clamp-2">{{ $unit->name }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-medium text-slate-500">Status Akreditasi</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-[10px] font-bold">
                        <i class="fa-solid fa-certificate text-[9px] text-amber-500"></i>
                        <span>{{ $unit->badge ?: 'Terakreditasi A' }}</span>
                    </span>
                </div>
            </div>

            {{-- Card 2: Pimpinan Unit --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between h-full group">
                <div class="flex items-start space-x-3.5">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg shrink-0 border border-amber-100 group-hover:scale-105 transition">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 block">Kepala / Mudir Unit</span>
                        <h3 class="text-sm font-black text-gray-900 mt-0.5 leading-snug line-clamp-2">{{ $unit->head_name ?: 'Pimpinan Lembaga' }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-medium text-slate-500">Lembaga</span>
                    <span class="text-[10px] font-bold text-slate-700">YAPIRUS Sakatiga</span>
                </div>
            </div>

            {{-- Card 3: Kurikulum & Muadalah --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between h-full group">
                <div class="flex items-start space-x-3.5">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center text-lg shrink-0 border border-sky-100 group-hover:scale-105 transition">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-sky-800 block">Kurikulum &amp; Sistem</span>
                        <h3 class="text-sm font-black text-gray-900 mt-0.5 leading-snug line-clamp-2">{{ $unit->curriculum ?: 'Kemenag & Muadalah Al-Azhar' }}</h3>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-medium text-slate-500">Sistem</span>
                    <span class="text-[10px] font-bold text-sky-700">Boarding School 24 Jam</span>
                </div>
            </div>

            {{-- Card 4: Hotline & Konsultasi PSB --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between h-full group">
                <div class="flex items-start space-x-3.5">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg shrink-0 border border-emerald-100 group-hover:scale-105 transition">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 block">Layanan Konsultasi</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone ?? '081278901950') }}?text={{ urlencode('Assalamu\'alaikum, saya ingin konsultasi PSB unit ' . $unit->name) }}" target="_blank" rel="noopener" class="text-sm font-black text-emerald-700 hover:text-emerald-800 hover:underline block mt-0.5 leading-snug">
                            {{ $unit->phone ?: '0812-7890-1950' }}
                        </a>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[10px] font-medium text-slate-500">Penerimaan Santri</span>
                    <a href="{{ route('ppdb.index') }}" class="text-[10px] font-bold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1">
                        <span>Daftar Santri Baru</span>
                        <i class="fa-solid fa-arrow-right text-[8px]"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- MAIN CONTENT SECTIONS (Tampilan Penuh / Full Width) --}}
<div class="py-12 sm:py-16 bg-slate-50/50 space-y-12 sm:space-y-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">

        {{-- 3. SAMBUTAN KEPALA SEKOLAH / MUDIR UNIT --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 reveal-fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                {{-- Foto Kepala Sekolah (Memanjang Vertikal Sejajar Informasi Sambutan) --}}
                <div class="lg:col-span-4 flex flex-col justify-between items-center text-center bg-gradient-to-b from-slate-50 via-white to-emerald-50/30 p-5 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs h-full">
                    <div class="relative w-full flex-1 min-h-[260px] sm:min-h-[300px] rounded-2xl overflow-hidden shadow-sm border border-slate-200/80 bg-white p-4 flex items-center justify-center group">
                        <img src="{{ $unit->head_photo_url }}" 
                             alt="Kepala {{ $unit->name }}" 
                             onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'"
                             class="w-full h-full max-h-56 sm:max-h-64 object-contain transform group-hover:scale-105 transition duration-500">
                        <span class="absolute bottom-3 left-3 right-3 bg-slate-900/85 backdrop-blur-xs text-white text-[11px] font-bold py-1.5 px-3 rounded-full shadow text-center">
                            Kepala {{ $unit->short_name ?: 'Unit' }}
                        </span>
                    </div>
                    <div class="w-full pt-4 mt-2 border-t border-slate-200/70">
                        <h3 class="font-black text-base sm:text-lg text-gray-900 leading-snug">{{ $unit->head_name ?: 'Pimpinan Lembaga' }}</h3>
                        <p class="text-xs text-[#00843d] font-bold mt-1">Kepala {{ $unit->name }}</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                    </div>
                </div>

                {{-- Sambutan Singkat --}}
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center space-x-2 bg-emerald-50 text-[#00843d] text-xs font-black px-3.5 py-1.5 rounded-full">
                        <i class="fa-solid fa-quote-left text-amber-500"></i>
                        <span>Sambutan Pimpinan Unit</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-tight">
                        Mendidik Generasi Qur'ani yang Unggul Ilmu, Kokoh Iman, dan Berakhlak Mulia
                    </h2>
                    <div class="prose-content text-gray-600 text-sm sm:text-base leading-relaxed space-y-3">
                        @if($unit->sambutan)
                            @if(strip_tags($unit->sambutan) !== $unit->sambutan)
                                {!! strip_tags($unit->sambutan, '<p><br><b><strong><i><em><u><ul><ol><li>') !!}
                            @else
                                {!! nl2br(e($unit->sambutan)) !!}
                            @endif
                        @else
                            <p>
                                <em>Assalamu’alaikum Warahmatullahi Wabarakatuh.</em>
                            </p>
                            <p>
                                Ahlan wa sahlan di laman resmi <strong>{{ $unit->name }}</strong> Pondok Pesantren Raudhatul Ulum Sakatiga. Kami berkomitmen menyelenggarakan ekosistem pendidikan Islam terpadu yang memadukan kedalaman ilmu syar'i (kitab kuning), tahfidzul Qur'an mutqin, kecakapan dwi-bahasa (Arab &amp; Inggris), serta keunggulan sains dan teknologi modern.
                            </p>
                            <p>
                                Melalui bimbingan penuh asatidz dan musyrif asrama selama 24 jam, para santri kami tempa agar memiliki karakter kepemimpinan, kemandirian hidup, dan wawasan global, siap mengemban estafet dakwah Islamiyyah dan berprestasi di kancah nasional maupun internasional.
                            </p>
                            <p class="font-semibold text-gray-800">
                                <em>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</em>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. PROFIL MENDALAM & KARAKTERISTIK UNGGULAN UNIT --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                        Tentang Lembaga
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                        Profil &amp; Identitas {{ $unit->name }}
                    </h2>
                </div>
                <div class="hidden sm:flex w-12 h-12 rounded-2xl bg-emerald-50 text-[#00843d] items-center justify-center text-xl shadow-xs">
                    <i class="{{ $unit->icon ?: 'fa-solid fa-graduation-cap' }}"></i>
                </div>
            </div>

            <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-4">
                @if(strip_tags($unit->description) !== $unit->description)
                    {!! strip_tags($unit->description, '<p><br><b><strong><i><em><u><center><ul><ol><li><a><h1><h2><h3><h4><h5><h6><div><span>') !!}
                @else
                    {!! nl2br(e($unit->description)) !!}
                @endif
            </div>

            {{-- 3 Pilar Utama --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-4">
                <div class="bg-gradient-to-br from-emerald-50 to-white p-5 rounded-2xl border border-emerald-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg mb-3 shadow-sm">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-gray-900">Akreditasi &amp; Ijazah Ganda</h4>
                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">
                        Ijazah resmi Kementerian Agama/Kemendikbud serta ijazah kepesantrenan dengan pengakuan muadalah Al-Azhar Kairo Mesir.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-amber-50 to-white p-5 rounded-2xl border border-amber-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-lg mb-3 shadow-sm">
                        <i class="fa-solid fa-language"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-gray-900">Bahasa Arab &amp; Inggris Aktif</h4>
                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">
                        Lingkungan bimbingan dwi-bahasa intensif harian (muhadatsah, mufrodat, dan muhadharah pidato 3 bahasa).
                    </p>
                </div>
                <div class="bg-gradient-to-br from-sky-50 to-white p-5 rounded-2xl border border-sky-100 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center text-lg mb-3 shadow-sm">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-gray-900">Tahfidz &amp; 10 Jati Diri</h4>
                    <p class="text-xs text-gray-600 mt-1.5 leading-relaxed">
                        Program tahfidzul Qur'an berkala dengan sanad bersambung serta pembiasaan adab luhur 10 Jati Diri Santri Raudhatul Ulum.
                    </p>
                </div>
            </div>
        </section>

        {{-- 5. VISI, MISI & TARGET KOMPETENSI LULUSAN --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-5 bg-[#00843d] text-white rounded-3xl p-6 sm:p-9 shadow-lg space-y-5">
                <span class="text-[11px] font-black uppercase tracking-wider text-amber-300 bg-black/20 px-3 py-1 rounded-full">
                    Arah Perjuangan
                </span>
                <h3 class="text-2xl font-black tracking-tight text-white">Visi &amp; Misi Unit</h3>
                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="bg-white/10 p-4 rounded-2xl border border-white/15 backdrop-blur-xs">
                        <h5 class="font-black text-amber-300 uppercase tracking-wide text-xs">Visi:</h5>
                        <p class="text-white mt-1 leading-relaxed">
                            {{ $unit->visi ?: 'Terwujudnya lembaga pendidikan Islam terpadu yang melahirkan kader ulama, intelektual muslim yang berakhlak mulia, cerdas, berwawasan global, dan berpegang teguh pada Al-Qur\'an dan As-Sunnah.' }}
                        </p>
                    </div>
                    <div class="bg-white/10 p-4 rounded-2xl border border-white/15 backdrop-blur-xs">
                        <h5 class="font-black text-amber-300 uppercase tracking-wide text-xs">Misi Utama:</h5>
                        @if($unit->misi)
                            <div class="text-emerald-100 mt-1 space-y-1.5 leading-relaxed text-xs">
                                {!! nl2br(e($unit->misi)) !!}
                            </div>
                        @else
                            <ul class="text-emerald-100 mt-1 space-y-2 list-disc pl-4 leading-relaxed text-xs">
                                <li>Menyelenggarakan pendidikan tahfidzul Qur'an dan penguasaan kitab-kitab mu'tabarah.</li>
                                <li>Mengembangkan penguasaan sains, teknologi, dan bahasa asing secara komprehensif.</li>
                                <li>Menanamkan kedisiplinan dan adab islami melalui pembinaan kepengasuhan 24 jam.</li>
                                <li>Mempersiapkan santri melanjutkan studi ke universitas ternama di Timur Tengah dan PTN favorit.</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-9 shadow-sm border border-gray-100 space-y-5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                    Standar Output
                </span>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">10 Target Kompetensi Lulusan</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Salimul 'Aqidah (Aqidah yang lurus dan bersih dari syirik)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Shahihul 'Ibadah (Ibadah yang benar sesuai tuntunan Rasulullah)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Matinul Khuluq (Akhlak yang mulia dan terpuji)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Qadirun 'Alal Kasbi (Memiliki kemandirian hidup &amp; etos kerja)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Mutsaqqaful Fikr (Wawasan keilmuan dan sains yang luas)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Qawiyyul Jism (Fisik prima melalui olahraga sunnah memanah &amp; silat)</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Hafidz Al-Qur'an mutqin sesuai jenjang pendidikan</span>
                    </div>
                    <div class="flex items-start space-x-2.5 p-3 rounded-xl bg-slate-50 border border-gray-100">
                        <i class="fa-solid fa-check-circle text-[#00843d] mt-0.5 text-sm"></i>
                        <span class="text-gray-700 font-semibold">Cakap berbahasa Arab fusha dan Inggris aktif</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. STRUKTUR KURIKULUM GANDA (Kepesantrenan & Nasional) --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
            <div class="border-b border-gray-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                    Struktur Akademik
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                    Kurikulum Terpadu Pesantren &amp; Nasional
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Sinergi antara kurikulum kepesantrenan modern, kurikulum salafiyah, dan kurikulum kementerian</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kurikulum Pesantren --}}
                <div class="bg-gradient-to-br from-emerald-50/70 to-white rounded-2xl p-6 border border-emerald-100 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-[#00843d] text-white flex items-center justify-center text-lg">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-gray-900">Kurikulum Kepesantrenan</h3>
                            <p class="text-[11px] text-gray-500">Dirasah Islamiyyah &amp; Kitab Kuning Mu'tabarah</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs text-gray-700">
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-[#00843d] text-xs"></i> <span>Tahfidzul Qur'an, Tahsin Qira'ati &amp; Ilmu Tajwid</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-[#00843d] text-xs"></i> <span>Nahwu, Shorof, &amp; Balaghah (Kaidah Bahasa Arab)</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-[#00843d] text-xs"></i> <span>Fiqh &amp; Ushul Fiqh Mazhab Syafi'i &amp; Muqaranah</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-[#00843d] text-xs"></i> <span>Tafsir Jalalain, Hadits Arbain &amp; Riyadhis Shalihin</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-[#00843d] text-xs"></i> <span>Tauhid / Aqidah Ahlussunnah Wal Jama'ah</span></li>
                    </ul>
                </div>

                {{-- Kurikulum Nasional & Sains --}}
                <div class="bg-gradient-to-br from-amber-50/70 to-white rounded-2xl p-6 border border-amber-100 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-[#f59e0b] text-slate-950 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-gray-900">Kurikulum Nasional &amp; Sains</h3>
                            <p class="text-[11px] text-gray-500">Kementerian Pendidikan / Kementerian Agama</p>
                        </div>
                    </div>
                    <ul class="space-y-2 text-xs text-gray-700">
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-amber-600 text-xs"></i> <span>Matematika, Fisika, Kimia, Biologi &amp; Sains Terapan</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-amber-600 text-xs"></i> <span>Bahasa Indonesia, Sejarah, &amp; Pendidikan Kewarganegaraan</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-amber-600 text-xs"></i> <span>Literasi Komputer, Pemrograman Dasar &amp; Robotika</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-amber-600 text-xs"></i> <span>English Language &amp; TOEFL Preparation</span></li>
                        <li class="flex items-center space-x-2"><i class="fa-solid fa-check text-amber-600 text-xs"></i> <span>Bimbingan Intensif UTBK &amp; Seleksi Beasiswa Timur Tengah</span></li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 7. DEWAN ASATIDZ & GURU PENGAJAR UNIT --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                        Tenaga Pendidik
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                        Dewan Asatidz &amp; Guru Pengajar {{ $unit->short_name }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Asatidz berdedikasi tinggi, alumni perguruan tinggi terkemuka dalam dan luar negeri</p>
                </div>
                <a href="{{ route('dewan.index') }}" class="text-xs font-bold text-[#00843d] hover:underline flex items-center gap-1 shrink-0">
                    <span>Semua Dewan Asatidz</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if($teachers->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                    @foreach($teachers as $t)
                        <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/80 text-center hover:border-emerald-300 hover:bg-white hover:shadow-md transition duration-300 group flex flex-col justify-between h-full">
                            <div>
                                <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-3.5 bg-slate-100 shadow-xs border-2 border-slate-200 p-1 flex items-center justify-center">
                                    <img src="{{ $t->photo_url }}" alt="{{ $t->name }}" class="w-full h-full object-contain rounded-full group-hover:scale-105 transition" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                                </div>
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold mb-1.5 border border-emerald-100">
                                    Jabatan #{{ $t->order }}
                                </span>
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 line-clamp-2">{{ $t->name }}</h4>
                                <p class="text-[11px] text-[#00843d] font-semibold mt-1 leading-snug">{{ $t->position }}</p>
                            </div>
                            @if($t->education)
                                <div class="mt-3.5 pt-2.5 border-t border-slate-200/60">
                                    <p class="text-[10px] text-gray-500 line-clamp-1"><i class="fa-solid fa-graduation-cap mr-1 text-emerald-600"></i> {{ $t->education }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- 8. KABAR & BERITA TERBARU UNIT --}}
        @if(isset($unitPosts) && $unitPosts->isNotEmpty())
            <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                            Kabar Terkini
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                            Berita &amp; Artikel {{ $unit->short_name ?: $unit->name }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Informasi kegiatan akademik, santri, dan dinamika pembelajaran di unit ini</p>
                    </div>
                    <a href="{{ route('artikel.index') }}" class="text-xs font-bold text-[#00843d] hover:underline flex items-center gap-1 shrink-0">
                        <span>Semua Berita</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($unitPosts as $post)
                        <article class="bg-slate-50/70 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md hover:border-emerald-200 transition group flex flex-col justify-between">
                            <div>
                                <div class="aspect-video w-full bg-gray-200 overflow-hidden relative">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/uploads/campus-ppru-sakatiga.webp'">
                                    <span class="absolute top-2.5 left-2.5 bg-[#00843d] text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow">
                                        {{ $unit->short_name ?: 'Unit' }}
                                    </span>
                                </div>
                                <div class="p-4 space-y-2">
                                    <h4 class="font-bold text-xs sm:text-sm text-gray-900 line-clamp-2 group-hover:text-[#00843d] transition">
                                        <a href="{{ route('artikel.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h4>
                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                        {{ Str::limit(strip_tags($post->content), 80) }}
                                    </p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 pt-1 border-t border-gray-100 flex items-center justify-between text-[10px] text-gray-400">
                                <span><i class="fa-solid fa-calendar mr-1"></i> {{ $post->created_at ? $post->created_at->translatedFormat('d M Y') : 'Terbaru' }}</span>
                                <a href="{{ route('artikel.show', $post->slug) }}" class="text-[#00843d] font-bold hover:underline">Baca &rarr;</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- 9. PRESTASI SANTRI & GURU UNIT --}}
        @if(isset($prestasi) && $prestasi->isNotEmpty())
            <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                            Rekam Prestasi
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                            Prestasi Santri &amp; Guru
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Bukti dedikasi santri Raudhatul Ulum dalam kompetisi akademik, sains, dan keagamaan</p>
                    </div>
                    <a href="{{ route('prestasi.index') }}" class="text-xs font-bold text-[#00843d] hover:underline flex items-center gap-1 shrink-0">
                        <span>Semua Prestasi</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($prestasi as $p)
                        <article class="bg-slate-50/70 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-md hover:border-emerald-200 transition group flex flex-col">
                            <div class="aspect-video w-full bg-gray-200 overflow-hidden relative">
                                <img src="{{ $p->featured_image_url }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/uploads/campus-ppru-sakatiga.webp'">
                                <span class="absolute top-2.5 left-2.5 bg-amber-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full shadow">
                                    Prestasi
                                </span>
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between space-y-2">
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 line-clamp-2 group-hover:text-[#00843d] transition">
                                    <a href="{{ route('artikel.show', $p->slug) }}">{{ $p->title }}</a>
                                </h4>
                                <span class="text-[10px] text-gray-400 block pt-1 border-t border-gray-100">
                                    <i class="fa-solid fa-calendar mr-1"></i> {{ $p->created_at ? $p->created_at->translatedFormat('d M Y') : 'Terbaru' }}
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- EKSTRAKURIKULER & PENGEMBANGAN MINAT BAKAT --}}
        @if(isset($ekskuls) && $ekskuls->isNotEmpty())
            <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">
                            Minat &amp; Bakat Santri
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                            Ekstrakurikuler Unggulan
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Wadah pembinaan karakter, ketangkasan fisik, dan kepemimpinan santri</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($ekskuls as $ek)
                        <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/80 hover:border-emerald-300 hover:bg-white hover:shadow-md transition duration-300 group flex items-start space-x-4">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl shrink-0 group-hover:scale-105 transition shadow-2xs">
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-[#00843d] transition">{{ $ek->title }}</h4>
                                <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($ek->content), 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- 10. ALUMNI SUKSES & TESTIMONI UNIT --}}
        <section class="bg-gradient-to-br from-emerald-900 via-[#005a28] to-[#043317] text-white rounded-3xl p-6 sm:p-10 shadow-xl space-y-6 reveal-fade-up">
            <div class="border-b border-white/20 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-amber-300 bg-black/20 px-3 py-1 rounded-full">
                        Testimoni &amp; Alumni
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-white mt-2 tracking-tight">
                        Testimoni &amp; Kiprah Santri {{ $unit->short_name ?: $unit->name }}
                    </h2>
                    <p class="text-xs text-emerald-100 mt-1">Pengalaman berharga santri, wali santri, dan alumni Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 text-xs">
                @if(isset($unitTestimonials) && $unitTestimonials->isNotEmpty())
                    @foreach($unitTestimonials as $testi)
                        <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15 space-y-3 flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-amber-400 bg-white/20 shrink-0">
                                        <img src="{{ $testi->photo_url }}" alt="{{ $testi->name }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white text-sm">{{ $testi->name }}</h4>
                                        <p class="text-amber-300 text-[11px] font-semibold">{{ $testi->profession ?: 'Alumni / Wali Santri' }}</p>
                                    </div>
                                </div>
                                <p class="text-emerald-100 text-[11px] leading-relaxed italic">
                                    "{{ $testi->content }}"
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15 space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-amber-400 bg-white/20 shrink-0">
                                <img src="/uploads/avatar-neutral-gray.svg" alt="Alumni Al-Azhar" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-black text-white text-sm">Ust. Ahmad Fauzan, Lc.</h4>
                                <p class="text-amber-300 text-[11px] font-semibold">Alumni Al-Azhar Cairo Mesir</p>
                            </div>
                        </div>
                        <p class="text-emerald-100 text-[11px] leading-relaxed italic">
                            "Pondok Pesantren Raudhatul Ulum Sakatiga membekali saya kemampuan bahasa Arab fusha dan pemahaman kitab kuning yang sangat kuat, sehingga sangat memudahkan studi saya di Fakultas Ushuluddin Universitas Al-Azhar Kairo."
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15 space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-amber-400 bg-white/20 shrink-0">
                                <img src="/uploads/avatar-neutral-gray.svg" alt="Alumni Madinah" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-black text-white text-sm">Ust. Muhammad Ihsan, Lc.</h4>
                                <p class="text-amber-300 text-[11px] font-semibold">Alumni Universitas Islam Madinah</p>
                            </div>
                        </div>
                        <p class="text-emerald-100 text-[11px] leading-relaxed italic">
                            "Kedisiplinan ibadah, hafalan mutqin Al-Qur'an, dan penanaman adab di PPRU menjadi modal utama saya meraih beasiswa penuh di Kota Madinah Nabawiyyah."
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15 space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-amber-400 bg-white/20 shrink-0">
                                <img src="/uploads/avatar-neutral-gray.svg" alt="Alumni PTN" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-black text-white text-sm">dr. Fatimah Zahra</h4>
                                <p class="text-amber-300 text-[11px] font-semibold">Alumni Kedokteran PTN &amp; Hafidzah 30 Juz</p>
                            </div>
                        </div>
                        <p class="text-emerald-100 text-[11px] leading-relaxed italic">
                            "Di Raudhatul Ulum, saya belajar bahwa sains dan Al-Qur'an saling menguatkan. Menghafal Al-Qur'an 30 juz membuka pintu kecerdasan untuk menyelesaikan studi kedokteran."
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- VIDEO PROFIL & KEGIATAN UNIT --}}
        @if(isset($unitVideos) && $unitVideos->isNotEmpty())
            <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#da251c] bg-red-50 px-3 py-1 rounded-full">
                            Video Profil
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                            Video Dokumentasi &amp; Profil {{ $unit->short_name ?: $unit->name }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Saksikan gambaran langsung kehidupan santri dan suasana pembelajaran dari TVRU Sakatiga</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($unitVideos as $vid)
                        <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200 shadow-xs space-y-2.5 p-3 flex flex-col justify-between">
                            <div class="aspect-video w-full rounded-xl overflow-hidden bg-black shadow-inner">
                                <iframe src="{{ $vid->youtube_embed_url ?? ('https://www.youtube-nocookie.com/embed/'.$vid->youtube_id) }}" title="{{ $vid->title }}" class="w-full h-full" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <h4 class="font-extrabold text-xs text-gray-900 line-clamp-2 leading-snug">{{ $vid->title }}</h4>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- 11. GALERI FOTO KEGIATAN KHUSUS UNIT --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                        Dokumentasi Santri
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                        Galeri Aktivitas Santri
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Potret ragam kegiatan belajar, keagamaan, dan pembinaan karakter di pondok pesantren</p>
                </div>
                <a href="{{ route('galeri.index') }}" class="text-xs font-bold text-[#00843d] hover:underline flex items-center gap-1 shrink-0">
                    <span>Lihat Semua Galeri</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if(isset($unitGallery) && (is_iterable($unitGallery) ? count($unitGallery) > 0 : !empty($unitGallery)))
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($unitGallery as $g)
                        @php
                            $gImage = $g instanceof \App\Models\Post ? $g->featured_image_url : ($g['image'] ?? '/uploads/official/kbm-santri-0054.webp');
                            $gTitle = $g instanceof \App\Models\Post ? $g->title : ($g['title'] ?? 'Dokumentasi Santri');
                            $gBadge = $g instanceof \App\Models\Post ? ($unit->short_name ?: 'Aktivitas') : ($g['badge'] ?? 'Aktivitas');
                        @endphp
                        <div class="aspect-4/3 rounded-2xl overflow-hidden group relative shadow-xs bg-slate-100 border border-slate-200/60">
                            <img src="{{ $gImage }}" 
                                 alt="{{ $gTitle }}" 
                                 onerror="this.onerror=null;this.src='/uploads/official/kbm-santri-0054.webp'"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-3.5">
                                <span class="text-amber-300 text-[10px] font-black uppercase tracking-wider mb-0.5">{{ $gBadge }}</span>
                                <span class="text-white text-xs font-bold line-clamp-2 leading-snug">{{ $gTitle }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="aspect-4/3 rounded-2xl overflow-hidden group relative shadow-xs bg-slate-100 border border-slate-200/60">
                        <img src="/uploads/official/drone-raudhatul-ulum.webp" alt="Pondok PPRU" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                            <span class="text-white text-[11px] font-bold">Kompleks Utama Pondok</span>
                        </div>
                    </div>
                    <div class="aspect-4/3 rounded-2xl overflow-hidden group relative shadow-xs bg-slate-100 border border-slate-200/60">
                        <img src="/uploads/official/panahan-santri.webp" alt="Latihan Memanah Santri" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                            <span class="text-white text-[11px] font-bold">Latihan Memanah Sunnah</span>
                        </div>
                    </div>
                    <div class="aspect-4/3 rounded-2xl overflow-hidden group relative shadow-xs bg-slate-100 border border-slate-200/60">
                        <img src="/uploads/official/ngaji-sore.webp" alt="Halaqah Tahfidz" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                            <span class="text-white text-[11px] font-bold">Halaqah Tahfidzul Qur'an</span>
                        </div>
                    </div>
                    <div class="aspect-4/3 rounded-2xl overflow-hidden group relative shadow-xs bg-slate-100 border border-slate-200/60">
                        <img src="/uploads/official/kbm-santri-0054.webp" alt="Kegiatan Santri" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                            <span class="text-white text-[11px] font-bold">Pembelajaran &amp; Karakter</span>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        {{-- 12. AGENDA & PENGUMUMAN UNIT TERKINI --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Agenda --}}
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-lg text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-[#00843d]"></i>
                        <span>Agenda &amp; Kalender</span>
                    </h3>
                    <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-[#00843d] hover:underline">Semua &rarr;</a>
                </div>
                <div class="space-y-3">
                    @forelse($agendas as $ag)
                        <div class="flex items-start space-x-3.5 p-3.5 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-200 transition">
                            <div class="bg-emerald-100 text-[#00843d] p-2.5 rounded-xl text-center shrink-0 min-w-[50px]">
                                <span class="block text-[10px] font-bold uppercase">{{ $ag->event_date ? $ag->event_date->format('M') : 'AGENDA' }}</span>
                                <span class="block text-base font-black">{{ $ag->event_date ? $ag->event_date->format('d') : '•' }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-xs sm:text-sm text-gray-900 line-clamp-1 hover:text-[#00843d]">
                                    <a href="{{ route('agenda.show', $ag->slug) }}">{{ $ag->title }}</a>
                                </h4>
                                <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-1">
                                    <i class="fa-solid fa-location-dot mr-1 text-amber-500"></i> {{ $ag->location ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 py-4 text-center">Belum ada agenda terdaftar.</p>
                    @endforelse
                </div>
            </div>

            {{-- Pengumuman --}}
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-5">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-lg text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-amber-500"></i>
                        <span>Pengumuman Resmi</span>
                    </h3>
                    <a href="{{ route('pengumuman.index') }}" class="text-xs font-bold text-[#00843d] hover:underline">Semua &rarr;</a>
                </div>
                <div class="space-y-3">
                    @forelse($pengumumen as $pe)
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-200 transition space-y-1">
                            <span class="text-[10px] font-bold text-[#00843d] bg-emerald-50 px-2 py-0.5 rounded-md">Resmi Pesantren</span>
                            <h4 class="font-bold text-xs sm:text-sm text-gray-900 hover:text-[#00843d] line-clamp-1">
                                <a href="{{ route('pengumuman.show', $pe->slug) }}">{{ $pe->title }}</a>
                            </h4>
                            <p class="text-[10px] text-gray-400">
                                <i class="fa-solid fa-clock mr-1"></i> {{ $pe->created_at ? $pe->created_at->translatedFormat('d F Y') : 'Terbaru' }}
                            </p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 py-4 text-center">Belum ada pengumuman terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- 13. SARANA & FASILITAS PENUNJANG KHUSUS UNIT --}}
        <section class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
            <div class="border-b border-gray-100 pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3 py-1 rounded-full">
                    Kenyamanan Belajar
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-2 tracking-tight">
                    Fasilitas Penunjang Pendidikan
                </h2>
                <p class="text-xs text-gray-500 mt-1">Infrastruktur modern dan representatif untuk mendukung kenyamanan belajar santri</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 text-center text-xs">
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-chalkboard"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Ruang Kelas Multimedia</h4>
                    <p class="text-[10px] text-gray-400 mt-1">AC, Proyektor &amp; Smart Audio</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-bed"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Asrama Santri Asri</h4>
                    <p class="text-[10px] text-gray-400 mt-1">Musyrif Pembimbing 24 Jam</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Lab Sains Terpadu</h4>
                    <p class="text-[10px] text-gray-400 mt-1">Fisika, Kimia, &amp; Biologi</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-desktop"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Lab Komputer &amp; IT</h4>
                    <p class="text-[10px] text-gray-400 mt-1">Koneksi Internet Edukasi</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-mosque"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Masjid Jami' Pondok</h4>
                    <p class="text-[10px] text-gray-400 mt-1">Pusat Ibadah &amp; Halaqah</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-300 transition">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl mb-2.5">
                        <i class="fa-solid fa-futbol"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Sarana Olahraga</h4>
                    <p class="text-[10px] text-gray-400 mt-1">Panahan, Futsal &amp; Silat</p>
                </div>
            </div>
        </section>

        {{-- 14. ALUR PENDAFTARAN SANTRI BARU (PSB) & CTA PENDAFTARAN --}}
        <section class="bg-gradient-to-br from-[#005a28] to-[#00843d] text-white rounded-3xl p-6 sm:p-10 shadow-xl space-y-6 reveal-fade-up">
            <div class="border-b border-white/20 pb-4">
                <span class="text-xs font-black uppercase tracking-wider text-amber-300 bg-black/20 px-3 py-1 rounded-full">
                    Penerimaan Santri Baru (PSB)
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white mt-2 tracking-tight">
                    Alur Pendaftaran Masuk {{ $unit->name }}
                </h2>
                <p class="text-xs text-emerald-100 mt-1">Langkah mudah menjadi bagian dari keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15">
                    <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-3">1</span>
                    <h4 class="font-bold text-white text-sm">Daftar Online</h4>
                    <p class="text-emerald-100 text-[11px] mt-1">Mengisi formulir PSB resmi melalui portal website pesantren.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15">
                    <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-3">2</span>
                    <h4 class="font-bold text-white text-sm">Verifikasi Berkas</h4>
                    <p class="text-emerald-100 text-[11px] mt-1">Upload dokumen KK, Akta Kelahiran, raport, dan pas foto santri.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15">
                    <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-3">3</span>
                    <h4 class="font-bold text-white text-sm">Tes &amp; Wawancara</h4>
                    <p class="text-emerald-100 text-[11px] mt-1">Ujian baca Al-Qur'an, potensi akademik, dan wawancara komitmen wali.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-xs p-5 rounded-2xl border border-white/15">
                    <span class="w-7 h-7 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-3">4</span>
                    <h4 class="font-bold text-white text-sm">Daftar Ulang</h4>
                    <p class="text-emerald-100 text-[11px] mt-1">Pengumuman kelulusan, penyelesaian administrasi, dan penempatan asrama.</p>
                </div>
            </div>

            <div class="pt-4 flex flex-wrap gap-4 items-center">
                <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-amber-400 text-slate-950 text-xs sm:text-sm font-black px-8 py-3.5 rounded-full shadow-lg hover:shadow-xl transition flex items-center space-x-2 transform hover:scale-105">
                    <i class="fa-solid fa-graduation-cap text-base"></i>
                    <span>Daftar PSB {{ $unit->short_name ?: 'Online' }} Sekarang</span>
                </a>
                @if($unit->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone) }}?text=Assalamu%27alaikum%20Panitia%20PSB%20{{ urlencode($unit->name) }}" target="_blank" rel="noopener" class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold px-6 py-3.5 rounded-full transition flex items-center space-x-2">
                        <i class="fa-brands fa-whatsapp text-emerald-300 text-base"></i>
                        <span>Hubungi Panitia PSB</span>
                    </a>
                @endif
            </div>
        </section>

        {{-- 15. UNIT PENDIDIKAN LAINNYA DI PONDOK PESANTREN RAUDHATUL ULUM --}}
        @if(isset($otherUnits) && $otherUnits->isNotEmpty())
            <section class="space-y-6 reveal-fade-up">
                <div class="border-b border-gray-200 pb-3 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#00843d]">Eksplorasi Jenjang</span>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 mt-1">Unit Pendidikan Lainnya di PPRU</h2>
                    </div>
                    <a href="{{ route('pendidikan.index') }}" class="text-xs font-bold text-[#00843d] hover:underline flex items-center gap-1">
                        <span>Lihat Semua Unit</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($otherUnits as $ou)
                        @php
                            $cleanOuName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $ou->name));
                        @endphp
                        <a href="{{ route('pendidikan.show', $ou->slug) }}" class="bg-white rounded-2xl p-4 border border-gray-100 hover:border-emerald-300 hover:shadow-md transition duration-300 group flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-sm shrink-0 group-hover:bg-[#00843d] group-hover:text-white transition">
                                <i class="{{ $ou->icon ?: 'fa-solid fa-school' }}"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-xs text-gray-900 group-hover:text-[#00843d] transition line-clamp-1">{{ $cleanOuName }}</h4>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $ou->category_type }} &bull; {{ $ou->badge ?: 'PPRU' }}</p>
                                <span class="text-[10px] font-bold text-[#00843d] inline-flex items-center gap-1 mt-1 group-hover:underline">
                                    <span>Lihat Profil</span>
                                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>
@endsection
