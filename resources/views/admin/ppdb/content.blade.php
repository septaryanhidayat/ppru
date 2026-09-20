@extends('layouts.admin')

@section('title', 'Kelola Konten & Fleksibilitas Formulir PPDB')
@section('header_title', 'Kelola Konten & Fleksibilitas Formulir PPDB')

@section('content')
<div class="space-y-6" x-data="{ 
    currentTab: '{{ request('tab', 'konten') }}', 
    showAddFieldModal: false, 
    newFieldType: 'text',
    activeCategory: 'all',
    searchQuery: '',
    expandedField: null
}">

    {{-- TOP NAVIGATION TABS --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.ppdb.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs transition {{ request()->routeIs('admin.ppdb.index') ? 'bg-[#da251c] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <i class="fa-solid fa-users mr-1.5"></i> Data Calon Santri (Pendaftar)
            </a>
            <button type="button" @click="currentTab = 'konten'" :class="currentTab === 'konten' ? 'bg-[#00913e] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition cursor-pointer flex items-center space-x-1.5">
                <i class="fa-solid fa-sliders"></i>
                <span>Konten &amp; 10 Menu PPDB</span>
            </button>
            <button type="button" @click="currentTab = 'formulir'" :class="currentTab === 'formulir' ? 'bg-[#00913e] text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-5 py-2.5 rounded-xl font-bold text-xs transition cursor-pointer flex items-center space-x-1.5">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                <span>Kustomisasi Formulir Online</span>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.ppdb.export.excel') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-700 hover:bg-emerald-800 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
            <a href="{{ route('admin.ppdb.export.pdf') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-red-700 hover:bg-red-800 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('ppdb.index') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-slate-800 hover:bg-slate-900 text-white shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Pratinjau Web PPDB</span>
            </a>
        </div>
    </div>

    {{-- FORM PENGATURAN KONTEN & FORMULIR PPDB --}}
    <form action="{{ route('admin.ppdb.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- TAB 1: PENGATURAN KONTEN HALAMAN PPDB --}}
        <div x-show="currentTab === 'konten'" class="space-y-8">

            {{-- SECTION 1: STATUS & HERO BANNER PPDB --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">1. Status Gelombang &amp; Hero Banner PSB</h3>
                        <p class="text-xs text-slate-500">Atur periode penerimaan, tahun ajaran, nominal formulir, judul utama, dan 4 counter statistik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Pelajaran <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_year" required value="{{ old('ppdb_year', $settings['year']) }}" placeholder="Contoh: 2026/2027" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Gelombang Aktif</label>
                        <input type="text" name="ppdb_wave" value="{{ old('ppdb_wave', $settings['wave']) }}" placeholder="Contoh: Gelombang 1 (Aktif)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nominal Biaya Formulir <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_registration_fee" required value="{{ old('ppdb_registration_fee', $settings['registration_fee']) }}" placeholder="Contoh: Rp 250.000,-" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Promo / Potongan Biaya</label>
                        <input type="text" name="ppdb_promo" value="{{ old('ppdb_promo', $settings['promo']) }}" placeholder="Contoh: Potongan Biaya Masuk Up to 50% OFF (*S&K berlaku)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Hero (Headline)</label>
                        <input type="text" name="ppdb_hero_title" value="{{ old('ppdb_hero_title', $settings['hero_title'] ?? 'PSB PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA OGAN ILIR') }}" placeholder="Contoh: PSB PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA OGAN ILIR" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Singkat / Tagline Hero</label>
                        <textarea name="ppdb_tagline" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_tagline', $settings['tagline']) }}</textarea>
                    </div>

                    <div class="sm:col-span-3 pt-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Gambar Background Hero (Pilih File)
                        </label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            {{-- Preview Thumbnail --}}
                            <div class="w-28 h-20 rounded-xl overflow-hidden bg-slate-900 border border-slate-300 shrink-0 relative group shadow-xs">
                                <img src="{{ old('ppdb_hero_bg', $settings['hero_bg'] ?? '/uploads/campus-ppru-sakatiga.webp') }}" 
                                     alt="Preview Hero" 
                                     class="w-full h-full object-cover">
                            </div>
                            
                            {{-- Choose File Input --}}
                            <div class="flex-1 w-full space-y-1.5">
                                <input type="file" 
                                       name="ppdb_hero_bg_file" 
                                       accept="image/*" 
                                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-emerald-800 cursor-pointer bg-white rounded-xl border border-slate-200 shadow-xs">
                                <p class="text-[10px] text-slate-500">Pilih file gambar langsung dari komputer/HP (JPG, PNG, WebP maks 5MB). Otomatis dikonversi ke WebP tajam.</p>
                                <input type="hidden" name="ppdb_hero_bg" value="{{ old('ppdb_hero_bg', $settings['hero_bg'] ?? '/uploads/campus-ppru-sakatiga.webp') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4 Stat Counters CRUD --}}
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-3">
                        <i class="fa-solid fa-calculator text-emerald-600 mr-1"></i> 4 Counter Statistik di Bawah Hero
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 space-y-2">
                            <span class="text-[11px] font-black text-emerald-700 block uppercase">Statistik 1</span>
                            <input type="text" name="ppdb_stat_1_val" value="{{ old('ppdb_stat_1_val', $settings['stat_1_val'] ?? '8 Unit') }}" placeholder="8 Unit" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                            <input type="text" name="ppdb_stat_1_lbl" value="{{ old('ppdb_stat_1_lbl', $settings['stat_1_lbl'] ?? 'Jenjang Terpadu') }}" placeholder="Jenjang Terpadu" class="w-full bg-white text-[11px] rounded-lg px-3 py-1.5 border border-slate-200">
                        </div>

                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 space-y-2">
                            <span class="text-[11px] font-black text-emerald-700 block uppercase">Statistik 2</span>
                            <input type="text" name="ppdb_stat_2_val" value="{{ old('ppdb_stat_2_val', $settings['stat_2_val'] ?? 'Muadalah') }}" placeholder="Muadalah" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                            <input type="text" name="ppdb_stat_2_lbl" value="{{ old('ppdb_stat_2_lbl', $settings['stat_2_lbl'] ?? 'Al-Azhar Kairo') }}" placeholder="Al-Azhar Kairo" class="w-full bg-white text-[11px] rounded-lg px-3 py-1.5 border border-slate-200">
                        </div>

                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 space-y-2">
                            <span class="text-[11px] font-black text-emerald-700 block uppercase">Statistik 3</span>
                            <input type="text" name="ppdb_stat_3_val" value="{{ old('ppdb_stat_3_val', $settings['stat_3_val'] ?? '30 Juz') }}" placeholder="30 Juz" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                            <input type="text" name="ppdb_stat_3_lbl" value="{{ old('ppdb_stat_3_lbl', $settings['stat_3_lbl'] ?? 'Tahfidz Mutqin') }}" placeholder="Tahfidz Mutqin" class="w-full bg-white text-[11px] rounded-lg px-3 py-1.5 border border-slate-200">
                        </div>

                        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 space-y-2">
                            <span class="text-[11px] font-black text-emerald-700 block uppercase">Statistik 4</span>
                            <input type="text" name="ppdb_stat_4_val" value="{{ old('ppdb_stat_4_val', $settings['stat_4_val'] ?? '24 Jam') }}" placeholder="24 Jam" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                            <input type="text" name="ppdb_stat_4_lbl" value="{{ old('ppdb_stat_4_lbl', $settings['stat_4_lbl'] ?? 'Pembinaan Asrama') }}" placeholder="Pembinaan Asrama" class="w-full bg-white text-[11px] rounded-lg px-3 py-1.5 border border-slate-200">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: BROSUR / POSTER RESMI PSB (UPLOAD & PREVIEW) --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-image"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">2. Brosur &amp; Poster Resmi PSB (Gambar Digital)</h3>
                        <p class="text-xs text-slate-500">Upload dan atur poster/flyer digital resmi penerimaan santri baru yang tampil di halaman PSB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
                    <div class="sm:col-span-2 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Bagian Brosur / Poster</label>
                            <input type="text" name="ppdb_flyer_title" value="{{ old('ppdb_flyer_title', $settings['flyer_title'] ?? 'Brosur & Poster Resmi PSB Online') }}" placeholder="Brosur & Poster Resmi PSB Online" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi / Keterangan Brosur</label>
                            <textarea name="ppdb_flyer_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_flyer_desc', $settings['flyer_desc'] ?? 'Dapatkan panduan lengkap penerimaan santri baru, profil keunggulan, rincian biaya, serta tata cara pendaftaran santri baru.') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih File Poster / Flyer Baru</label>
                            <div class="flex items-center gap-3">
                                <input type="file" name="ppdb_flyer_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#00913e] hover:file:bg-emerald-100 cursor-pointer">
                            </div>
                            <input type="hidden" name="ppdb_flyer_image" value="{{ $settings['flyer_image'] ?? '' }}">
                            <p class="text-[10px] text-slate-400 mt-1.5">Format disarankan: WebP, JPG, atau PNG (Maks 5MB). Otomatis dioptimalkan.</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-center space-y-2">
                        <span class="text-[11px] font-bold text-slate-600 block">Preview Brosur Saat Ini</span>
                        @if(!empty($settings['flyer_image']))
                            <div class="relative rounded-xl overflow-hidden shadow-sm border border-slate-300 max-h-56 bg-slate-900">
                                <img src="{{ $settings['flyer_image'] }}" alt="Poster PSB" class="w-full h-auto max-h-56 object-contain mx-auto">
                            </div>
                            <a href="{{ $settings['flyer_image'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] text-[#00913e] font-bold hover:underline pt-1">
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                <span>Buka Ukuran Penuh</span>
                            </a>
                        @else
                            <div class="h-36 rounded-xl border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-400">
                                Belum ada brosur diunggah
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- SECTION 3: HEADER KATALOG UNIT PENDIDIKAN --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">3. Teks Header Katalog Unit Pendidikan</h3>
                        <p class="text-xs text-slate-500">Atur badge, judul, dan deskripsi pengantar pada bagian katalog unit pendidikan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Bagian</label>
                        <input type="text" name="ppdb_unit_badge" value="{{ old('ppdb_unit_badge', $settings['unit_badge'] ?? 'Multi-Unit Pendidikan Terpadu') }}" placeholder="Multi-Unit Pendidikan Terpadu" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama</label>
                        <input type="text" name="ppdb_unit_title" value="{{ old('ppdb_unit_title', $settings['unit_title'] ?? 'PILIH UNIT PENDIDIKAN TUJUAN') }}" placeholder="PILIH UNIT PENDIDIKAN TUJUAN" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Pengantar Unit</label>
                        <textarea name="ppdb_unit_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_unit_desc', $settings['unit_desc'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga menaungi 8 unit pendidikan resmi yang terstruktur mulai dari Madrasah, TK Islam, Sekolah Islam Terpadu (JSIT), hingga Perguruan Tinggi Islam.') }}</textarea>
                    </div>
                </div>

                {{-- CRUD Foto Unit Pendidikan di Halaman PSB --}}
                <div class="pt-6 border-t border-slate-200 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <h4 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="fa-solid fa-camera text-emerald-600"></i>
                                <span>Kelola Foto 8 Unit Pendidikan PSB (Choose File / Upload Langsung)</span>
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Ganti foto unit pendidikan yang tampil pada kartu pilihan unit di halaman PSB langsung melalui tombol <b>Choose File</b> berikut:
                            </p>
                        </div>
                        <a href="{{ route('admin.unit-pendidikan.index') }}" class="text-xs text-[#00913e] hover:underline font-bold inline-flex items-center gap-1 shrink-0">
                            <span>Manajemen Detail Unit</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    @if(isset($unitPendidikans) && $unitPendidikans->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($unitPendidikans as $unit)
                                <div class="bg-slate-50 rounded-2xl p-3.5 border border-slate-200 space-y-3 flex flex-col justify-between shadow-2xs hover:border-[#00913e]/60 transition">
                                    <div class="space-y-2">
                                        <div class="relative h-32 w-full rounded-xl overflow-hidden bg-slate-900 border border-slate-300">
                                            <img src="{{ $unit->thumbnail_url }}" alt="{{ $unit->name }}" class="w-full h-full object-cover">
                                            <span class="absolute top-2 left-2 bg-[#00913e] text-white text-[9px] font-black px-2 py-0.5 rounded shadow">
                                                {{ $unit->category_type }}
                                            </span>
                                            @if($unit->short_name)
                                                <span class="absolute bottom-2 right-2 bg-black/75 text-[#fcd116] text-[10px] font-black px-2 py-0.5 rounded backdrop-blur-xs">
                                                    {{ $unit->short_name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-xs text-slate-900 truncate" title="{{ $unit->name }}">{{ $unit->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-medium">{{ $unit->badge ?: 'Jenjang Resmi' }}</div>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5 pt-2 border-t border-slate-200/80">
                                        <label class="block text-[10px] font-bold text-slate-700 uppercase">
                                            Ganti Foto Unit (Choose File):
                                        </label>
                                        <input type="file" 
                                               name="unit_photos[{{ $unit->id }}]" 
                                               accept="image/*" 
                                               class="w-full text-[10px] text-slate-600 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-emerald-800 cursor-pointer bg-white rounded-lg border border-slate-200 shadow-2xs">
                                        <div class="flex items-center justify-between text-[10px] pt-0.5">
                                            <a href="{{ route('admin.unit-pendidikan.edit', $unit) }}" class="text-slate-500 hover:text-[#00913e] font-semibold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-pen-to-square text-[9px]"></i>
                                                <span>Edit Data Lengkap</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- SECTION 4: ALUR PENDAFTARAN & 5 TAHAPAN --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">4. Alur Pendaftaran &amp; 5 Tahapan Calon Santri</h3>
                        <p class="text-xs text-slate-500">Sesuaikan judul, deskripsi, dan teks pada 5 kotak tahapan alur penerimaan santri.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Bagian Alur</label>
                        <input type="text" name="ppdb_alur_title" value="{{ old('ppdb_alur_title', $settings['alur_title'] ?? 'ALUR PENDAFTARAN SANTRI BARU (PSB)') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Bagian Alur</label>
                        <input type="text" name="ppdb_alur_desc" value="{{ old('ppdb_alur_desc', $settings['alur_desc'] ?? '5 Tahapan mudah dan transparan pendaftaran santri baru Pondok Pesantren Raudhatul Ulum Sakatiga') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>

                {{-- 5 Step Cards CRUD --}}
                <div class="space-y-4 pt-2">
                    <div class="p-3 bg-emerald-50 text-[#00913e] rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-list-ol"></i>
                        <span>5 Kotak Tahapan Alur</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        {{-- Step 1 --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center">1</span>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Judul Tahap 1</label>
                            <input type="text" name="ppdb_step_1_title" value="{{ old('ppdb_step_1_title', $settings['step_1_title'] ?? 'Pendaftaran Online') }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Deskripsi</label>
                            <textarea name="ppdb_step_1_desc" rows="3" class="w-full bg-white text-[11px] rounded-lg p-2 border border-slate-200 leading-snug">{{ old('ppdb_step_1_desc', $settings['step_1_desc'] ?? 'Mengisi formulir PSB melalui portal website resmi ini dengan data calon santri dan orang tua secara lengkap.') }}</textarea>
                            <input type="text" name="ppdb_step_1_sub" value="{{ old('ppdb_step_1_sub', $settings['step_1_sub'] ?? 'Portal aktif 24 jam') }}" placeholder="Catatan kaki" class="w-full bg-white text-[10px] text-slate-500 rounded-lg px-2.5 py-1 border border-slate-200">
                        </div>

                        {{-- Step 2 --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center">2</span>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Judul Tahap 2</label>
                            <input type="text" name="ppdb_step_2_title" value="{{ old('ppdb_step_2_title', $settings['step_2_title'] ?? 'Transfer & Berkas') }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Deskripsi</label>
                            <textarea name="ppdb_step_2_desc" rows="3" class="w-full bg-white text-[11px] rounded-lg p-2 border border-slate-200 leading-snug">{{ old('ppdb_step_2_desc', $settings['step_2_desc'] ?? 'Membayar biaya pendaftaran ke rekening BSI resmi pesantren dan mengunggah bukti transfer serta berkas KK/Akta.') }}</textarea>
                            <input type="text" name="ppdb_step_2_sub" value="{{ old('ppdb_step_2_sub', $settings['step_2_sub'] ?? 'Biaya Rp 250.000,- via Bank BSI') }}" placeholder="Catatan kaki" class="w-full bg-white text-[10px] text-slate-500 rounded-lg px-2.5 py-1 border border-slate-200">
                        </div>

                        {{-- Step 3 --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center">3</span>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Judul Tahap 3</label>
                            <input type="text" name="ppdb_step_3_title" value="{{ old('ppdb_step_3_title', $settings['step_3_title'] ?? 'Ujian Seleksi & Wawancara') }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Deskripsi</label>
                            <textarea name="ppdb_step_3_desc" rows="3" class="w-full bg-white text-[11px] rounded-lg p-2 border border-slate-200 leading-snug">{{ old('ppdb_step_3_desc', $settings['step_3_desc'] ?? 'Mengikuti tes potensi akademik, tes membaca Al-Qur\'an/tahfidz, dan wawancara kesiapan orang tua serta santri.') }}</textarea>
                            <input type="text" name="ppdb_step_3_sub" value="{{ old('ppdb_step_3_sub', $settings['step_3_sub'] ?? 'Jadwal diinfokan via WhatsApp') }}" placeholder="Catatan kaki" class="w-full bg-white text-[10px] text-slate-500 rounded-lg px-2.5 py-1 border border-slate-200">
                        </div>

                        {{-- Step 4 --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center">4</span>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Judul Tahap 4</label>
                            <input type="text" name="ppdb_step_4_title" value="{{ old('ppdb_step_4_title', $settings['step_4_title'] ?? 'Pengumuman Kelulusan') }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Deskripsi</label>
                            <textarea name="ppdb_step_4_desc" rows="3" class="w-full bg-white text-[11px] rounded-lg p-2 border border-slate-200 leading-snug">{{ old('ppdb_step_4_desc', $settings['step_4_desc'] ?? 'Mengecek hasil seleksi kelulusan melalui website dan notifikasi resmi WhatsApp panitia PSB.') }}</textarea>
                            <input type="text" name="ppdb_step_4_sub" value="{{ old('ppdb_step_4_sub', $settings['step_4_sub'] ?? 'Daftar ulang & fitting seragam') }}" placeholder="Catatan kaki" class="w-full bg-white text-[10px] text-slate-500 rounded-lg px-2.5 py-1 border border-slate-200">
                        </div>

                        {{-- Step 5 --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center">5</span>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Judul Tahap 5</label>
                            <input type="text" name="ppdb_step_5_title" value="{{ old('ppdb_step_5_title', $settings['step_5_title'] ?? 'Masuk Asrama (P2SB)') }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            <label class="block text-[10px] font-bold text-slate-700 uppercase">Deskripsi</label>
                            <textarea name="ppdb_step_5_desc" rows="3" class="w-full bg-white text-[11px] rounded-lg p-2 border border-slate-200 leading-snug">{{ old('ppdb_step_5_desc', $settings['step_5_desc'] ?? 'Kedatangan santri ke asrama, serah terima dengan Mudir dan pengasuh, serta mengikuti Pekan Perkenalan Santri Baru (P2SB).') }}</textarea>
                            <input type="text" name="ppdb_step_5_sub" value="{{ old('ppdb_step_5_sub', $settings['step_5_sub'] ?? 'Khutbatul Arsy & pembagian kamar santri') }}" placeholder="Catatan kaki" class="w-full bg-white text-[10px] text-slate-500 rounded-lg px-2.5 py-1 border border-slate-200">
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Petunjuk &amp; Alur Tambahan (Teks Bebas)
                            </label>
                            <span class="text-[10px] text-slate-400">Toolbar format penulisan</span>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-1.5 bg-slate-100/90 border border-b-0 border-slate-200 rounded-t-xl px-3 py-2 text-xs text-slate-700">
                            <div class="flex flex-wrap items-center gap-1">
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'bold')" title="Tebal (Bold)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs font-bold transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><b>B</b></button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'italic')" title="Miring (Italic)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs italic font-serif transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><i>I</i></button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'underline')" title="Garis Bawah (Underline)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs underline transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><u>U</u></button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'strike')" title="Coret (Strikethrough)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs line-through transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><s>S</s></button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'left')" title="Rata Kiri (Left)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-left text-[10px]"></i>
                                    <span>Kiri</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'center')" title="Rata Tengah (Center)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-center text-[10px]"></i>
                                    <span>Tengah</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'right')" title="Rata Kanan (Right)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-right text-[10px]"></i>
                                    <span>Kanan</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'justify')" title="Rata Penuh (Justify)" class="h-7 px-2 rounded bg-white shadow-xs text-[#00843d] border border-emerald-300 text-[11px] font-bold transition flex items-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-align-justify text-[10px]"></i>
                                    <span>Rata Penuh</span>
                                </button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'heading')" title="Sub Judul (H3)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-bold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <span>H3</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'bullet')" title="Daftar Poin" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-list-ul text-[10px]"></i>
                                    <span>Poin</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'number')" title="Daftar Angka" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-list-ol text-[10px]"></i>
                                    <span>Angka</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'quote')" title="Kutipan / Catatan" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-quote-left text-[10px]"></i>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_alur_textarea', 'clear')" title="Hapus Tag Format" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] text-red-600 font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-eraser text-[10px]"></i>
                                </button>
                            </div>
                            <div class="flex items-center gap-1 text-[10px] text-slate-500">
                                <button type="button" onclick="expandTextarea('ppdb_alur_textarea', 80)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer inline-flex items-center gap-1">
                                    <i class="fa-solid fa-arrows-up-down text-[9px]"></i>
                                    <span>Perbesar Kotak</span>
                                </button>
                                <button type="button" onclick="expandTextarea('ppdb_alur_textarea', -80)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer">
                                    <span>Perkecil</span>
                                </button>
                            </div>
                        </div>
                        <textarea id="ppdb_alur_textarea" name="ppdb_alur" rows="8" class="w-full bg-slate-50 text-xs rounded-b-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed min-h-[180px]">{{ old('ppdb_alur', $settings['alur']) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION 5: PILIHAN JALUR PENERIMAAN --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-door-open"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">5. Pilihan Jalur Penerimaan Santri Baru</h3>
                        <p class="text-xs text-slate-500">Sesuaikan judul dan syarat setiap jalur seleksi (Reguler, Tahfidz, Prestasi, Alumni).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Bagian Jalur</label>
                        <input type="text" name="ppdb_jalur_title" value="{{ old('ppdb_jalur_title', $settings['jalur_title'] ?? 'JALUR PENERIMAAN SANTRI BARU') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Bagian Jalur</label>
                        <input type="text" name="ppdb_jalur_desc" value="{{ old('ppdb_jalur_desc', $settings['jalur_desc'] ?? 'Tersedia berbagai pilihan jalur penerimaan sesuai bakat, hafalan Al-Qur\'an, dan prestasi santri') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
                    {{-- Jalur 1: Reguler --}}
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <span class="text-xs font-black text-emerald-800 uppercase block"><i class="fa-solid fa-user-check mr-1.5"></i> Jalur 1</span>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Judul Jalur</label>
                            <input type="text" name="ppdb_jalur_reguler_title" value="{{ old('ppdb_jalur_reguler_title', $settings['jalur_reguler_title'] ?? 'Jalur Reguler (Mandiri)') }}" class="w-full bg-white text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Keterangan &amp; Syarat</label>
                            <textarea name="ppdb_mandiri" rows="3" class="w-full bg-white text-xs rounded-xl p-3 border border-slate-200 leading-relaxed">{{ old('ppdb_mandiri', $settings['mandiri']) }}</textarea>
                        </div>
                    </div>

                    {{-- Jalur 2: Tahfidz --}}
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <span class="text-xs font-black text-amber-700 uppercase block"><i class="fa-solid fa-book-quran mr-1.5"></i> Jalur 2 (Tahfidz)</span>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Judul Jalur</label>
                            <input type="text" name="ppdb_jalur_tahfidz_title" value="{{ old('ppdb_jalur_tahfidz_title', $settings['jalur_tahfidz_title'] ?? 'Jalur Hafizh Al-Qur\'an') }}" class="w-full bg-white text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Keterangan &amp; Syarat</label>
                            <textarea name="ppdb_tahfidz" rows="3" class="w-full bg-white text-xs rounded-xl p-3 border border-slate-200 leading-relaxed">{{ old('ppdb_tahfidz', $settings['tahfidz']) }}</textarea>
                        </div>
                    </div>

                    {{-- Jalur 3: Prestasi --}}
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <span class="text-xs font-black text-blue-700 uppercase block"><i class="fa-solid fa-trophy mr-1.5"></i> Jalur 3 (Prestasi)</span>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Judul Jalur</label>
                            <input type="text" name="ppdb_jalur_prestasi_title" value="{{ old('ppdb_jalur_prestasi_title', $settings['jalur_prestasi_title'] ?? 'Jalur Prestasi Sains') }}" class="w-full bg-white text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Keterangan &amp; Syarat</label>
                            <textarea name="ppdb_prestasi" rows="3" class="w-full bg-white text-xs rounded-xl p-3 border border-slate-200 leading-relaxed">{{ old('ppdb_prestasi', $settings['prestasi']) }}</textarea>
                        </div>
                    </div>

                    {{-- Jalur 4: Alumni --}}
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                        <span class="text-xs font-black text-purple-700 uppercase block"><i class="fa-solid fa-people-roof mr-1.5"></i> Jalur 4 (Alumni)</span>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Judul Jalur</label>
                            <input type="text" name="ppdb_jalur_alumni_title" value="{{ old('ppdb_jalur_alumni_title', $settings['jalur_alumni_title'] ?? 'Jalur Alumni Internal') }}" class="w-full bg-white text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Keterangan &amp; Syarat</label>
                            <textarea name="ppdb_alumni" rows="3" class="w-full bg-white text-xs rounded-xl p-3 border border-slate-200 leading-relaxed">{{ old('ppdb_alumni', $settings['alumni']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 6: REKENING RESMI & OPERASIONAL --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">6. Rekening Pembayaran &amp; Layanan Sekretariat</h3>
                        <p class="text-xs text-slate-500">Rekening tujuan transfer pendaftaran, jam layanan sekretariat, dan hotline panitia.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Bank <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_name" required value="{{ old('ppdb_bank_name', $settings['bank_name']) }}" placeholder="Bank Syariah Indonesia (BSI)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Bank <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_code" required value="{{ old('ppdb_bank_code', $settings['bank_code']) }}" placeholder="451" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_account" required value="{{ old('ppdb_bank_account', $settings['bank_account']) }}" placeholder="7011304251" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atas Nama Rekening <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_bank_holder" required value="{{ old('ppdb_bank_holder', $settings['bank_holder']) }}" placeholder="Pondok Pesantren Raudhatul Ulum" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hari Kerja (Senin - Jum'at) <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_operational_weekday" required value="{{ old('ppdb_operational_weekday', $settings['operational_weekday']) }}" placeholder="Senin - Jum'at: Pukul 08.00 - 15.00 WIB" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Hari Sabtu <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_operational_weekend" required value="{{ old('ppdb_operational_weekend', $settings['operational_weekend']) }}" placeholder="Sabtu: Pukul 08.00 - 12.00 WIB" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Sekretariat SPMB <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_secretariat" required value="{{ old('ppdb_secretariat', $settings['secretariat']) }}" placeholder="Kompleks Pondok Pesantren Raudhatul Ulum, Sakatiga" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp Admin 1 <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_hotline_phone" required value="{{ old('ppdb_hotline_phone', $settings['hotline_phone']) }}" placeholder="0812-7890-1950" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label Kontak 1</label>
                        <input type="text" name="ppdb_hotline_name" value="{{ old('ppdb_hotline_name', $settings['hotline_name']) }}" placeholder="Panitia SPMB PPRU" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp CS 2</label>
                        <input type="text" name="ppdb_hotline_2_phone" value="{{ old('ppdb_hotline_2_phone', $settings['hotline_2_phone']) }}" placeholder="0812-7890-1950" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label Kontak 2</label>
                        <input type="text" name="ppdb_hotline_2_name" value="{{ old('ppdb_hotline_2_name', $settings['hotline_2_name']) }}" placeholder="Sekretariat Pesantren" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 7: VIDEO PROFIL YOUTUBE --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-lg">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">7. Video Profil YouTube Halaman PPDB</h3>
                        <p class="text-xs text-slate-500">Video dokumentasi resmi pesantren yang disematkan (embed) pada halaman informasi PPDB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">YouTube Video ID atau URL Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="ppdb_youtube_id" required value="{{ old('ppdb_youtube_id', $settings['youtube_id']) }}" placeholder="Contoh: LXtIbizPVvE atau https://www.youtube.com/watch?v=LXtIbizPVvE" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Teks Video</label>
                        <input type="text" name="ppdb_video_title" value="{{ old('ppdb_video_title', $settings['video_title']) }}" placeholder="Profil & Suasana Kehidupan Santri Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Video</label>
                        <textarea name="ppdb_video_desc" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_video_desc', $settings['video_desc'] ?? 'Saksikan lingkungan belajar, masjid agung, asrama santri, laboratorium, dan aktivitas harian di Pondok Pesantren Raudhatul Ulum Sakatiga') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Label Channel YouTube</label>
                        <input type="text" name="ppdb_video_channel" value="{{ old('ppdb_video_channel', $settings['video_channel'] ?? 'Channel Resmi TVRU Sakatiga (@tvrusakatiga)') }}" placeholder="Channel Resmi TVRU Sakatiga (@tvrusakatiga)" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>

            {{-- SECTION 8: PERTANYAAN SERING DIAJUKAN (FAQ) --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">8. Pertanyaan Sering Diajukan (FAQ)</h3>
                        <p class="text-xs text-slate-500">Kelola daftar pertanyaan dan jawaban yang tampil pada accordion FAQ halaman PSB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Bagian FAQ</label>
                        <input type="text" name="ppdb_faq_title" value="{{ old('ppdb_faq_title', $settings['faq_title'] ?? 'PERTANYAAN SERING DIAJUKAN (FAQ)') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subjudul / Deskripsi FAQ</label>
                        <input type="text" name="ppdb_faq_desc" value="{{ old('ppdb_faq_desc', $settings['faq_desc'] ?? 'Jawaban seputar kehidupan berasrama dan pendaftaran santri baru di PPRU Sakatiga') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div class="sm:col-span-2">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Daftar Tanya Jawab FAQ <span class="text-emerald-700 font-normal">(Format: Pertanyaan | Jawaban, 1 baris per pertanyaan)</span>
                            </label>
                            <span class="text-[10px] text-slate-400">Gunakan toolbar di bawah untuk format cepat</span>
                        </div>
                        
                        {{-- Writing Toolbar FAQ --}}
                        <div class="flex flex-wrap items-center justify-between gap-1.5 bg-slate-100/90 border border-b-0 border-slate-200 rounded-t-xl px-3 py-2 text-xs text-slate-700">
                            <div class="flex flex-wrap items-center gap-1">
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'bold')" title="Tebal (Bold)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs font-bold transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><b>B</b></button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'italic')" title="Miring (Italic)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs italic font-serif transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><i>I</i></button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'underline')" title="Garis Bawah (Underline)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs underline transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><u>U</u></button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'strike')" title="Coret (Strikethrough)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs line-through transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><s>S</s></button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'left')" title="Rata Kiri (Left)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-left text-[10px]"></i>
                                    <span>Kiri</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'center')" title="Rata Tengah (Center)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-center text-[10px]"></i>
                                    <span>Tengah</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'right')" title="Rata Kanan (Right)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-right text-[10px]"></i>
                                    <span>Kanan</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'justify')" title="Rata Penuh (Justify)" class="h-7 px-2 rounded bg-white shadow-xs text-[#00843d] border border-emerald-300 text-[11px] font-bold transition flex items-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-align-justify text-[10px]"></i>
                                    <span>Rata Penuh</span>
                                </button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'pipe')" title="Sisipkan Format Pipa FAQ (Pertanyaan | Jawaban)" class="h-7 px-2.5 rounded bg-emerald-100/90 hover:bg-emerald-200 text-[#00843d] text-[11px] font-bold transition flex items-center gap-1 cursor-pointer border border-emerald-300">
                                    <i class="fa-solid fa-plus text-[9px]"></i>
                                    <span>+ Format Pipa FAQ (|)</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'bullet')" title="Daftar Poin" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-list-ul text-[10px]"></i>
                                    <span>Poin</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'number')" title="Daftar Angka" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-list-ol text-[10px]"></i>
                                    <span>Angka</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_faq_textarea', 'clear')" title="Hapus Tag Format" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] text-red-600 font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-eraser text-[10px]"></i>
                                </button>
                            </div>
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-500">
                                <button type="button" onclick="expandTextarea('ppdb_faq_textarea', 120)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer inline-flex items-center gap-1" title="Perbesar Tinggi Kotak Teks">
                                    <i class="fa-solid fa-arrows-up-down text-[9px]"></i>
                                    <span>Perbesar Kotak</span>
                                </button>
                                <button type="button" onclick="expandTextarea('ppdb_faq_textarea', -100)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer" title="Perkecil Tinggi Kotak Teks">
                                    <span>Perkecil</span>
                                </button>
                            </div>
                        </div>

                        <textarea id="ppdb_faq_textarea" name="ppdb_faq" rows="12" class="w-full bg-slate-50 font-mono text-xs rounded-b-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed min-h-[280px]">{{ old('ppdb_faq', $settings['faq'] ?? '') }}</textarea>
                        <p class="text-[10px] text-slate-400 mt-1.5">Pisahkan antara teks pertanyaan dan jawaban dengan simbol pipa <code>|</code>. Setiap baris baru akan menjadi 1 item accordion FAQ di web.</p>
                    </div>
                </div>
            </div>

            {{-- SECTION 9: PESAN PENUTUP & CTA FORMULIR --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-hands-praying"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">9. Pesan Penutup &amp; Tombol Pendaftaran</h3>
                        <p class="text-xs text-slate-500">Teks ajakan penutup dan doa yang tampil di banner akhir halaman PPDB.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Banner Penutup</label>
                            <input type="text" name="ppdb_closing_title" value="{{ old('ppdb_closing_title', $settings['closing_title']) }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol CTA</label>
                            <input type="text" name="ppdb_closing_btn_text" value="{{ old('ppdb_closing_btn_text', $settings['closing_btn_text'] ?? 'Isi Formulir Pendaftaran Sekarang') }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Isi Doa &amp; Ajakan Harapan</label>
                            <span class="text-[10px] text-slate-400">Toolbar format penulisan</span>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-1.5 bg-slate-100/90 border border-b-0 border-slate-200 rounded-t-xl px-3 py-2 text-xs text-slate-700">
                            <div class="flex flex-wrap items-center gap-1">
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'bold')" title="Tebal (Bold)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs font-bold transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><b>B</b></button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'italic')" title="Miring (Italic)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs italic font-serif transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><i>I</i></button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'underline')" title="Garis Bawah" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs underline transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><u>U</u></button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'strike')" title="Coret (Strikethrough)" class="w-7 h-7 rounded hover:bg-white hover:shadow-xs line-through transition flex items-center justify-center cursor-pointer border border-transparent hover:border-slate-300"><s>S</s></button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'left')" title="Rata Kiri (Left)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-left text-[10px]"></i>
                                    <span>Kiri</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'center')" title="Rata Tengah" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-center text-[10px]"></i>
                                    <span>Tengah</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'right')" title="Rata Kanan (Right)" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-align-right text-[10px]"></i>
                                    <span>Kanan</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'justify')" title="Rata Penuh (Justify)" class="h-7 px-2 rounded bg-white shadow-xs text-[#00843d] border border-emerald-300 text-[11px] font-bold transition flex items-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-align-justify text-[10px]"></i>
                                    <span>Rata Penuh</span>
                                </button>
                                <span class="w-[1px] h-4 bg-slate-300 mx-1"></span>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'bullet')" title="Daftar Poin" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-list-ul text-[10px]"></i>
                                    <span>Poin</span>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'quote')" title="Kutipan Doa" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-quote-left text-[10px]"></i>
                                </button>
                                <button type="button" onclick="formatTextarea('ppdb_closing_desc_textarea', 'clear')" title="Hapus Tag Format" class="h-7 px-2 rounded hover:bg-white hover:shadow-xs text-[11px] text-red-600 font-semibold transition flex items-center gap-1 cursor-pointer border border-transparent hover:border-slate-300">
                                    <i class="fa-solid fa-eraser text-[10px]"></i>
                                </button>
                            </div>
                            <div class="flex items-center gap-1 text-[10px] text-slate-500">
                                <button type="button" onclick="expandTextarea('ppdb_closing_desc_textarea', 80)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer inline-flex items-center gap-1">
                                    <i class="fa-solid fa-arrows-up-down text-[9px]"></i>
                                    <span>Perbesar</span>
                                </button>
                                <button type="button" onclick="expandTextarea('ppdb_closing_desc_textarea', -80)" class="px-2 py-1 rounded bg-white hover:bg-slate-50 border border-slate-200 font-semibold transition cursor-pointer">
                                    <span>Perkecil</span>
                                </button>
                            </div>
                        </div>
                        <textarea id="ppdb_closing_desc_textarea" name="ppdb_closing_desc" rows="6" class="w-full bg-slate-50 text-xs rounded-b-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed min-h-[140px]">{{ old('ppdb_closing_desc', $settings['closing_desc']) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        {{-- TAB 2: PENGATURAN & KUSTOMISASI FORMULIR ONLINE --}}
        <div x-show="currentTab === 'formulir'" class="space-y-6" style="display: none;">

            {{-- 1. STATUS & PENGUMUMAN FORMULIR (KOMPAK & BERSIH) --}}
            <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-sm">
                        <i class="fa-solid fa-power-off"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-base">1. Status Penerimaan &amp; Pengumuman Formulir</h3>
                        <p class="text-xs text-slate-500">Kontrol cepat buka/tutup pendaftaran online dan notifikasi untuk calon pendaftar.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Formulir PPDB Online</label>
                        <select name="ppdb_form_status" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="1" {{ ($settings['form_status'] ?? '1') === '1' ? 'selected' : '' }}>🟢 BUKA PENDAFTARAN (Formulir Aktif Dapat Diisi)</option>
                            <option value="0" {{ ($settings['form_status'] ?? '1') === '0' ? 'selected' : '' }}>🔴 TUTUP PENDAFTARAN (Tampilkan Pemberitahuan Tutup)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi WhatsApp Otomatis</label>
                        <select name="ppdb_form_wa_confirm" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="1" {{ ($settings['form_wa_confirm'] ?? '1') === '1' ? 'selected' : '' }}>🟢 Aktif (Arahkan otomatis ke WA Panitia setelah submit)</option>
                            <option value="0" {{ ($settings['form_wa_confirm'] ?? '1') === '0' ? 'selected' : '' }}>⚪ Simpan di Database Saja (Tanpa redirect WhatsApp)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pesan Saat Formulir Ditutup</label>
                        <textarea name="ppdb_form_closed_message" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_form_closed_message', $settings['form_closed_message']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kotak Pengumuman / Info di Atas Formulir</label>
                        <textarea name="ppdb_form_announcement" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('ppdb_form_announcement', $settings['form_announcement']) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 2. PENGATUR STRUKTUR KOLOM ISIAN FORMULIR (NOTION-STYLE LIST) --}}
            <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden space-y-0">
                
                {{-- Form Builder Header --}}
                <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-white to-slate-50/60">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-layer-group"></i>
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-base">2. Struktur &amp; Kolom Isian Formulir Online</h3>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-emerald-50 text-[#00913e] border border-emerald-200">
                                {{ count($schema) }} Kolom
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Atur nama judul isian, tampilkan/sembunyikan kolom, atau tentukan kolom yang wajib diisi calon pendaftar.</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="showAddFieldModal = true" class="bg-[#00913e] hover:bg-[#007a34] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-plus-circle"></i>
                            <span>Tambah Kolom Baru</span>
                        </button>
                        <button type="button" onclick="if(confirm('Apakah Anda yakin ingin mengembalikan seluruh kolom formulir ke susunan standar awal sekolah?')) { document.getElementById('resetFieldsForm').submit(); }" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3.5 py-2.5 rounded-xl transition flex items-center gap-1.5 cursor-pointer" title="Reset ke Standar">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span class="hidden sm:inline">Reset Standar</span>
                        </button>
                    </div>
                </div>

                {{-- Filter Kategori Tabs & Search Bar --}}
                <div class="p-4 bg-slate-50/70 border-b border-slate-100 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 sm:pb-0">
                            <button type="button" @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition shrink-0 cursor-pointer">
                                Semua ({{ count($schema) }})
                            </button>
                            @foreach($sections as $sKey => $sInfo)
                                @php
                                    $countInSec = collect($schema)->where('section', $sKey)->count();
                                @endphp
                                <button type="button" @click="activeCategory = '{{ $sKey }}'" :class="activeCategory === '{{ $sKey }}' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-3 py-1.5 rounded-xl text-xs font-bold transition shrink-0 cursor-pointer flex items-center gap-1.5">
                                    <i class="{{ $sInfo['icon'] }} text-[10px]"></i>
                                    <span>{{ $sInfo['name'] }}</span>
                                    <span class="text-[10px] opacity-80 font-normal">({{ $countInSec }})</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="relative w-full sm:w-64 shrink-0">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" x-model="searchQuery" placeholder="Cari nama kolom..." class="w-full bg-white text-xs rounded-xl pl-8 pr-3 py-1.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>
                    </div>
                </div>

                {{-- Field List Rows --}}
                <div class="divide-y divide-slate-100">
                    @foreach($schema as $f)
                        @php
                            $isCustom = empty($f['is_system']);
                            $secKey = $f['section'] ?? 'tambahan';
                            $secInfo = $sections[$secKey] ?? ['name' => 'Lainnya', 'icon' => 'fa-solid fa-folder', 'color' => 'bg-slate-100 text-slate-700'];
                            $typeMeta = match($f['type']) {
                                'select' => ['label' => 'Pilihan', 'icon' => 'fa-solid fa-list', 'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                'file' => ['label' => 'Upload File', 'icon' => 'fa-solid fa-paperclip', 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                'date' => ['label' => 'Tanggal', 'icon' => 'fa-solid fa-calendar', 'color' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                                'number' => ['label' => 'Angka', 'icon' => 'fa-solid fa-hashtag', 'color' => 'bg-cyan-50 text-cyan-700 border-cyan-200'],
                                'textarea' => ['label' => 'Paragraf', 'icon' => 'fa-solid fa-align-left', 'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                'tel' => ['label' => 'Telepon/WA', 'icon' => 'fa-solid fa-phone', 'color' => 'bg-teal-50 text-teal-700 border-teal-200'],
                                default => ['label' => 'Teks', 'icon' => 'fa-solid fa-font', 'color' => 'bg-slate-100 text-slate-700 border-slate-200'],
                            };
                            $labelSafe = strtolower(addcslashes($f['label'], "'\r\n\\"));
                            $keySafe = strtolower(addcslashes($f['key'], "'\r\n\\"));
                        @endphp
                        <div x-show="(activeCategory === 'all' || activeCategory === '{{ $secKey }}') && (!searchQuery || '{{ $labelSafe }}'.includes(searchQuery.toLowerCase()) || '{{ $keySafe }}'.includes(searchQuery.toLowerCase()))" 
                             class="p-4 sm:px-6 hover:bg-slate-50/80 transition space-y-3"
                             :class="{ 'bg-slate-50/90': expandedField === '{{ $f['key'] }}' }">
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                                
                                {{-- Left Column: Type Icon & Editable Label & Meta --}}
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <span class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-xs font-bold border {{ $typeMeta['color'] }}" title="Tipe: {{ $typeMeta['label'] }}">
                                        <i class="{{ $typeMeta['icon'] }}"></i>
                                    </span>

                                    <div class="flex-1 min-w-0 flex flex-wrap items-center gap-2">
                                        <input type="text" name="fields[{{ $f['key'] }}][label]" value="{{ $f['label'] }}" 
                                               class="bg-slate-50 hover:bg-white focus:bg-white text-xs sm:text-sm font-bold text-slate-800 rounded-lg px-2.5 py-1.5 border border-slate-200 focus:border-[#00913e] focus:outline-none focus:ring-1 focus:ring-[#00913e] transition w-full sm:w-72 max-w-full"
                                               title="Klik untuk mengubah label/judul isian">
                                        
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border uppercase {{ $typeMeta['color'] }}">
                                            {{ $typeMeta['label'] }}
                                        </span>

                                        @if($isCustom)
                                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-purple-100 text-purple-700 border border-purple-200">
                                                Kustom
                                            </span>
                                        @endif

                                        <span class="text-[10px] text-slate-400 font-mono hidden lg:inline">
                                            {{ $f['key'] }}
                                        </span>

                                        <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md hidden sm:inline-flex items-center gap-1">
                                            <i class="{{ $secInfo['icon'] }} text-[9px] text-slate-400"></i>
                                            <span>{{ $secInfo['name'] }}</span>
                                        </span>
                                    </div>
                                </div>

                                {{-- Right Column: Tampil, Wajib, Pengaturan Detail & Hapus --}}
                                <div class="flex items-center gap-2 sm:gap-3 shrink-0 pl-11 md:pl-0">
                                    {{-- Toggle Tampil --}}
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer select-none bg-white hover:bg-slate-50 px-2.5 py-1.5 rounded-xl border border-slate-200 shadow-2xs transition text-xs font-semibold text-slate-700">
                                        <input type="checkbox" name="fields[{{ $f['key'] }}][enabled]" value="1" {{ !empty($f['enabled']) ? 'checked' : '' }} class="w-3.5 h-3.5 rounded text-[#00913e] focus:ring-[#00913e] border-slate-300">
                                        <span>Tampil</span>
                                    </label>

                                    {{-- Toggle Wajib --}}
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer select-none bg-white hover:bg-slate-50 px-2.5 py-1.5 rounded-xl border border-slate-200 shadow-2xs transition text-xs font-semibold text-slate-700">
                                        <input type="checkbox" name="fields[{{ $f['key'] }}][required]" value="1" {{ !empty($f['required']) ? 'checked' : '' }} class="w-3.5 h-3.5 rounded text-red-600 focus:ring-red-500 border-slate-300">
                                        <span>Wajib <span class="text-red-500 font-bold">*</span></span>
                                    </label>

                                    {{-- Tombol Detail / Pengaturan Opsi --}}
                                    <button type="button" @click="expandedField = (expandedField === '{{ $f['key'] }}' ? null : '{{ $f['key'] }}')" 
                                            :class="expandedField === '{{ $f['key'] }}' ? 'bg-slate-800 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'" 
                                            class="p-1.5 px-2 rounded-xl text-xs font-bold transition cursor-pointer flex items-center gap-1"
                                            title="Pengaturan Placeholder / Opsi Dropdown">
                                        <i class="fa-solid fa-gear text-[11px]"></i>
                                        <i class="fa-solid fa-chevron-down text-[9px] transition" :class="expandedField === '{{ $f['key'] }}' ? 'rotate-180' : ''"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button type="button" onclick="if(confirm('Hapus kolom \'{{ addslashes($f['label']) }}\' dari formulir PPDB?')) { document.getElementById('deleteFieldForm').action = '{{ route('admin.ppdb.fields.delete', $f['key']) }}'; document.getElementById('deleteFieldForm').submit(); }" 
                                            class="text-slate-400 hover:text-red-600 p-1.5 rounded-xl hover:bg-red-50 transition cursor-pointer text-xs" 
                                            title="Hapus Kolom Ini">
                                        <i class="fa-solid fa-trash-can text-[11px]"></i>
                                    </button>
                                </div>

                            </div>

                            {{-- Inline Detail Drawer: Placeholder & Dropdown Options --}}
                            <div x-show="expandedField === '{{ $f['key'] }}'" class="pt-3 pb-2 px-4 bg-white rounded-2xl border border-slate-200 space-y-3 mt-2 shadow-inner">
                                <div class="grid grid-cols-1 {{ $f['type'] === 'select' ? 'md:grid-cols-2' : '' }} gap-3">
                                    @if($f['type'] !== 'file' && $f['type'] !== 'select')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Teks Bantuan / Placeholder
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Contoh teks bantuan saat kosong..." class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>
                                    @endif

                                    @if($f['type'] === 'file')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Petunjuk Upload Dokumen
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Format JPG, PNG, atau PDF (Maks 5 MB)" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>
                                    @endif

                                    @if($f['type'] === 'select')
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Placeholder Pilihan Awal
                                            </label>
                                            <input type="text" name="fields[{{ $f['key'] }}][placeholder]" value="{{ $f['placeholder'] ?? '' }}" placeholder="Pilih salah satu..." class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                                Daftar Pilihan Dropdown <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                                            </label>
                                            <textarea name="fields[{{ $f['key'] }}][options]" rows="4" class="w-full bg-slate-50 text-xs font-mono rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ implode("\n", $f['options'] ?? []) }}</textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>

            {{-- 3. ACCORDION PENGATURAN LANJUTAN (OPSI TEKS GELOMBANG, JALUR & PROGRAM) --}}
            <details class="group bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
                <summary class="p-5 sm:p-6 flex items-center justify-between font-extrabold text-slate-800 text-sm cursor-pointer hover:bg-slate-50 transition select-none">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-sliders"></i>
                        </span>
                        <div>
                            <span class="block">3. Pengaturan Lanjutan (Opsi Teks Gelombang, Jalur &amp; Program)</span>
                            <span class="text-xs font-normal text-slate-500">Klik untuk melihat atau mengubah daftar opsi teks gelombang, jalur masuk, dan program belajar.</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-slate-400 group-open:rotate-180 transition"></i>
                </summary>

                <div class="p-6 pt-2 border-t border-slate-100 space-y-6 bg-slate-50/50">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Gelombang <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_waves" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_waves', $settings['form_waves']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Jalur Masuk <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_tracks" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_tracks', $settings['form_tracks']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Pilihan Program Belajar <span class="text-emerald-700 font-bold">(1 baris = 1 opsi)</span>
                            </label>
                            <textarea name="ppdb_form_programs" rows="5" class="w-full bg-white text-xs font-semibold rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed">{{ old('ppdb_form_programs', $settings['form_programs']) }}</textarea>
                        </div>
                    </div>

                    {{-- Hidden inputs for legacy requirements to preserve backwards-compatibility --}}
                    <input type="hidden" name="ppdb_form_require_payment" value="{{ $settings['form_require_payment'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_require_birth_cert" value="{{ $settings['form_require_birth_cert'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_nisn_rule" value="{{ $settings['form_nisn_rule'] ?? 'optional' }}">
                    <input type="hidden" name="ppdb_form_show_achievements" value="{{ $settings['form_show_achievements'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_show_hobbies" value="{{ $settings['form_show_hobbies'] ?? '1' }}">
                    <input type="hidden" name="ppdb_form_require_parent_income" value="{{ $settings['form_require_parent_income'] ?? '1' }}">
                </div>
            </details>

        </div>

        {{-- SUBMIT BAR STICKY --}}
        <div class="sticky bottom-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-200 flex items-center justify-between z-20">
            <div class="text-xs text-slate-500 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check text-[#00913e]"></i>
                <span>Semua perubahan konten &amp; pengaturan formulir langsung diterapkan ke halaman website.</span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.ppdb.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#007a34] text-white font-black text-xs sm:text-sm px-8 py-3 rounded-xl shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Seluruh Pengaturan PPDB</span>
                </button>
            </div>
        </div>

    </form>

    {{-- HIDDEN FORM UNTUK DELETE FIELD --}}
    <form id="deleteFieldForm" method="POST" action="" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- HIDDEN FORM UNTUK RESET FIELDS --}}
    <form id="resetFieldsForm" method="POST" action="{{ route('admin.ppdb.fields.reset') }}" style="display: none;">
        @csrf
    </form>

    {{-- MODAL TAMBAH KOLOM ISIAN BARU --}}
    <div x-show="showAddFieldModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="showAddFieldModal = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6" @click.away="showAddFieldModal = false">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Tambah Kolom Isian Baru</h3>
                            <p class="text-xs text-slate-500">Buat kolom kustom baru untuk formulir PPDB online.</p>
                        </div>
                    </div>
                    <button type="button" @click="showAddFieldModal = false" class="text-slate-400 hover:text-slate-600 text-lg cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form action="{{ route('admin.ppdb.fields.add') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama / Label Kolom <span class="text-red-500">*</span></label>
                        <input type="text" name="label" required placeholder="Contoh: Nomor Kartu Keluarga, Ukuran Baju, dsb..." class="w-full bg-slate-50 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori / Bagian <span class="text-red-500">*</span></label>
                            <select name="section" required class="w-full bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                                @foreach($sections as $sKey => $sInfo)
                                    <option value="{{ $sKey }}">{{ $sInfo['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Input <span class="text-red-500">*</span></label>
                            <select name="type" x-model="newFieldType" required class="w-full bg-slate-50 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs font-semibold">
                                <option value="text">Teks Pendek</option>
                                <option value="number">Angka / Nomor</option>
                                <option value="date">Tanggal</option>
                                <option value="select">Pilihan Dropdown (Select)</option>
                                <option value="textarea">Teks Panjang (Paragraf)</option>
                                <option value="tel">Nomor Telepon / WA</option>
                                <option value="file">Upload Berkas / File</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Placeholder / Petunjuk Isian</label>
                        <input type="text" name="placeholder" placeholder="Contoh: Masukkan 16 digit no KK..." class="w-full bg-slate-50 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs">
                    </div>

                    <div x-show="newFieldType === 'select'" style="display: none;">
                        <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Opsi Pilihan Dropdown <span class="text-emerald-700 font-normal">(1 baris = 1 opsi)</span> <span class="text-red-500">*</span>
                        </label>
                        <textarea name="options" rows="3" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3" class="w-full bg-slate-50 font-mono rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] text-xs"></textarea>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-slate-800 block text-xs">Wajib Diisi oleh Pendaftar?</span>
                            <span class="text-[10px] text-slate-500">Jika aktif, formulir tidak dapat dikirim sebelum kolom ini diisi.</span>
                        </div>
                        <input type="checkbox" name="required" value="1" class="w-5 h-5 rounded text-[#00913e] focus:ring-[#00913e] border-slate-300">
                    </div>

                    <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                        <button type="button" @click="showAddFieldModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="bg-[#00913e] hover:bg-[#007a34] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md shadow-emerald-500/25 transition flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tambahkan Kolom</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function formatTextarea(id, type) {
    const el = document.getElementById(id);
    if (!el) return;
    const start = el.selectionStart;
    const end = el.selectionEnd;
    const val = el.value;
    const selected = val.substring(start, end);
    let replacement = '';

    switch(type) {
        case 'bold':
            replacement = selected ? `<b>${selected}</b>` : `<b>teks tebal</b>`;
            break;
        case 'italic':
            replacement = selected ? `<i>${selected}</i>` : `<i>teks miring</i>`;
            break;
        case 'underline':
            replacement = selected ? `<u>${selected}</u>` : `<u>teks garis bawah</u>`;
            break;
        case 'strike':
            replacement = selected ? `<s>${selected}</s>` : `<s>teks coret</s>`;
            break;
        case 'left':
            replacement = selected ? `<div align="left">${selected}</div>` : `<div align="left">Teks rata kiri</div>`;
            break;
        case 'center':
            replacement = selected ? `<center>${selected}</center>` : `<center>Teks rata tengah</center>`;
            break;
        case 'right':
            replacement = selected ? `<div align="right">${selected}</div>` : `<div align="right">Teks rata kanan</div>`;
            break;
        case 'justify':
            replacement = selected ? `<div align="justify" style="text-align: justify;">${selected}</div>` : `<div align="justify" style="text-align: justify;">Teks rata penuh (kiri dan kanan)</div>`;
            break;
        case 'heading':
            replacement = selected ? `<h3>${selected}</h3>` : `<h3>Sub Judul Penting</h3>\n`;
            break;
        case 'bullet':
            replacement = selected ? `• ${selected}` : `• Poin penjelasan baru\n`;
            break;
        case 'number':
            replacement = selected ? `1. ${selected}` : `1. Langkah pertama\n2. Langkah kedua\n`;
            break;
        case 'quote':
            replacement = selected ? `<blockquote>${selected}</blockquote>` : `<blockquote>Catatan atau petunjuk khusus di sini</blockquote>\n`;
            break;
        case 'pipe':
            replacement = selected ? ` | ${selected}` : `\nPertanyaan Baru? | Jawaban lengkap pertanyaan di sini.`;
            break;
        case 'clear':
            replacement = selected ? selected.replace(/<[^>]*>?/gm, '') : '';
            break;
    }

    el.value = val.substring(0, start) + replacement + val.substring(end);
    el.focus();
    el.selectionStart = start + replacement.length;
    el.selectionEnd = start + replacement.length;
    el.dispatchEvent(new Event('input', { bubbles: true }));
}

function expandTextarea(id, delta) {
    const el = document.getElementById(id);
    if (el) {
        const cur = el.offsetHeight;
        const newHeight = Math.max(120, cur + delta);
        el.style.height = newHeight + 'px';
    }
}
</script>
@endsection
