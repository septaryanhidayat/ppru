@extends('layouts.frontend')

@section('title', 'Data Alumni - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Database dan direktori resmi alumni Pondok Pesantren Raudhatul Ulum Sakatiga: rekam jejak lulusan di perguruan tinggi dan dunia profesional.')

@section('content')
{{-- HERO HEADER (High Contrast Deep Emerald) --}}
<div class="bg-gradient-to-r from-[#032e18] via-[#064e3b] to-[#043317] text-white py-12 sm:py-16 relative overflow-hidden shadow-inner border-b-2 border-emerald-800/60">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fcd116_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumbs: High Contrast --}}
        <nav class="text-xs text-emerald-200 mb-4 flex items-center space-x-2 font-medium">
            <a href="{{ route('home') }}" class="text-emerald-200 hover:text-amber-300 transition">Beranda</a>
            <span class="text-emerald-500">/</span>
            <a href="{{ route('ikarus.index') }}" class="text-emerald-200 hover:text-amber-300 transition">IKARUS</a>
            <span class="text-emerald-500">/</span>
            <span class="text-amber-300 font-bold">Data Alumni</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-black bg-amber-400 text-slate-950 shadow-md mb-3.5">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Direktori Resmi Alumni PPRU Sakatiga</span>
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white drop-shadow-md">
                    Data &amp; Rekam Jejak Alumni
                </h1>
                <p class="text-sm sm:text-base text-emerald-100 mt-3 font-normal leading-relaxed">
                    Kiprah dan dedikasi lulusan Pondok Pesantren Raudhatul Ulum Sakatiga di berbagai perguruan tinggi ternama dan ranah profesional di penjuru nusantara serta mancanegara.
                </p>
            </div>

            {{-- QUICK STATS BADGES (High Contrast Dark Slate Card) --}}
            <div class="grid grid-cols-3 gap-3 shrink-0">
                <div class="bg-black/40 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-center shadow-lg">
                    <span class="text-2xl sm:text-3xl font-black text-amber-400 block leading-tight">{{ number_format($countTotal) }}</span>
                    <span class="text-xs text-white font-bold mt-1 block">Total Alumni</span>
                </div>
                <div class="bg-black/40 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-center shadow-lg">
                    <span class="text-2xl sm:text-3xl font-black text-emerald-300 block leading-tight">{{ number_format($countPutra) }}</span>
                    <span class="text-xs text-white font-bold mt-1 block">Santriwan (PA)</span>
                </div>
                <div class="bg-black/40 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-center shadow-lg">
                    <span class="text-2xl sm:text-3xl font-black text-purple-300 block leading-tight">{{ number_format($countPutri) }}</span>
                    <span class="text-xs text-white font-bold mt-1 block">Santriwati (PI)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-8">

    {{-- KOTAK FILTER & PENCARIAN (SEDERHANA, JELAS, & MUDAH DIPAHAMI) --}}
    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-slate-200/80 space-y-5">
        
        {{-- Pilihan Kategori Santri: Putra, Putri, atau Semua --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Pilihan Kategori Santri:</span>
                <span class="text-xs text-slate-400">Segmen Santriwan (Putra) &amp; Santriwati (Putri)</span>
            </div>
            
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-2xl self-start sm:self-auto">
                {{-- Semua --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => null, 'page' => 1]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ empty($selectedGender) ? 'bg-[#00843d] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-users text-[11px]"></i>
                    <span>Semua Alumni ({{ $countTotal }})</span>
                </a>

                {{-- Putra --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putra', 'page' => 1]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedGender === 'putra' ? 'bg-[#00843d] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-mars text-[11px]"></i>
                    <span>Santriwan ({{ $countPutra }})</span>
                </a>

                {{-- Putri --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putri', 'page' => 1]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedGender === 'putri' ? 'bg-purple-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-venus text-[11px]"></i>
                    <span>Santriwati ({{ $countPutri }})</span>
                </a>
            </div>
        </div>

        {{-- FORM FILTER UTAMA: Asal Lembaga, Tahun Lulus, & Pencarian --}}
        <form action="{{ route('alumni.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            @if(!empty($selectedGender))
                <input type="hidden" name="gender" value="{{ $selectedGender }}">
            @endif

            {{-- 1. ASAL SEKOLAH / UNIT LEMBAGA --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-school text-[#00843d]"></i>
                    <span>Asal Sekolah / Unit Lembaga</span>
                </label>
                <select name="unit_id" onchange="this.form.submit()" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3.5 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-medium cursor-pointer">
                    <option value="">Semua Lembaga</option>
                    @foreach($units as $u)
                        <option value="{{ $u->id }}" {{ ($selectedUnit == $u->id) ? 'selected' : '' }}>
                            {{ $u->short_name ?: $u->name }} ({{ $u->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. PILIH TAHUN LULUS (ANGKATAN) --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-check text-[#00843d]"></i>
                    <span>Pilih Tahun Lulus (Angkatan)</span>
                </label>
                <select name="year" onchange="this.form.submit()" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3.5 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-medium cursor-pointer">
                    <option value="">Semua Angkatan</option>
                    @foreach($availableYears as $yItem)
                        <option value="{{ $yItem->graduation_year }}" {{ ($selectedYear == $yItem->graduation_year) ? 'selected' : '' }}>
                            Tahun {{ $yItem->graduation_year }} ({{ $yItem->count }} Alumni)
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. KATA KUNCI / PENCARIAN --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass text-[#00843d]"></i>
                    <span>Cari Nama / Profesi</span>
                </label>
                <div class="relative">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Nama, profesi, kampus..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl pl-9 pr-3 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <i class="fa-solid fa-user text-slate-400 text-xs absolute left-3 top-3.5"></i>
                </div>
            </div>

            {{-- 4. TOMBOL FILTER & RESET --}}
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-3 bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Cari Alumni</span>
                </button>
                @if(!empty($selectedUnit) || !empty($selectedYear) || !empty($selectedGender) || !empty($search))
                    <a href="{{ route('alumni.index') }}" class="px-3.5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1" title="Reset Semua Filter">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        {{-- STATUS FILTER AKTIF (TAGS) --}}
        @if(!empty($selectedUnit) || !empty($selectedYear) || !empty($selectedGender) || !empty($search))
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs">
                <span class="text-slate-400 font-bold text-[11px] uppercase tracking-wider">Filter Aktif:</span>

                @if(!empty($selectedUnit) && ($uObj = $units->firstWhere('id', $selectedUnit)))
                    <a href="{{ request()->fullUrlWithQuery(['unit_id' => null, 'page' => 1]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-[#00843d] border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition" title="Hapus filter lembaga">
                        <span>Lembaga: {{ $uObj->short_name ?: $uObj->name }}</span>
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </a>
                @endif

                @if(!empty($selectedYear))
                    <a href="{{ request()->fullUrlWithQuery(['year' => null, 'page' => 1]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold hover:bg-amber-100 transition" title="Hapus filter tahun">
                        <span>Tahun {{ $selectedYear }}</span>
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </a>
                @endif

                @if(!empty($selectedGender))
                    <a href="{{ request()->fullUrlWithQuery(['gender' => null, 'page' => 1]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $selectedGender === 'putri' ? 'bg-purple-50 text-purple-700 border-purple-200 hover:bg-purple-100' : 'bg-emerald-50 text-[#00843d] border-emerald-200 hover:bg-emerald-100' }} text-xs font-bold transition" title="Hapus filter gender">
                        <span>Santri: {{ ucfirst($selectedGender) }}</span>
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </a>
                @endif

                @if(!empty($search))
                    <a href="{{ request()->fullUrlWithQuery(['q' => null, 'page' => 1]) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold hover:bg-slate-200 transition" title="Hapus kata kunci">
                        <span>Cari: "{{ $search }}"</span>
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </a>
                @endif

                <a href="{{ route('alumni.index') }}" class="text-[11px] text-red-600 hover:underline font-bold ml-1">
                    Hapus Semua Filter
                </a>
            </div>
        @endif

    </div>

    {{-- DAFTAR KARTU ALUMNI (GRID PROFIL) --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black">
                    <i class="fa-solid fa-user-graduate"></i>
                </span>
                <h2 class="text-sm sm:text-base font-extrabold uppercase tracking-wider text-gray-900">
                    Data Rekam Jejak Alumni
                </h2>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                Menampilkan {{ $alumni->total() }} alumni terdata
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($alumni as $idx => $item)
                @php
                    $isItemPutri = ($item->gender === 'putri');
                    $ringColor = $isItemPutri ? 'ring-purple-200 group-hover:ring-purple-400' : 'ring-emerald-200 group-hover:ring-emerald-400';
                @endphp
                <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group reveal-fade-up">
                    <div>
                        {{-- Top Badges: Tahun Lulus & Gender --}}
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1">
                                <i class="fa-solid fa-graduation-cap text-[10px]"></i>
                                <span>Lulusan {{ $item->graduation_year }}</span>
                            </span>

                            @if($isItemPutri)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-purple-50 text-purple-700 flex items-center gap-1">
                                    <i class="fa-solid fa-venus text-[9px]"></i>
                                    <span>Putri</span>
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-[#00843d] flex items-center gap-1">
                                    <i class="fa-solid fa-mars text-[9px]"></i>
                                    <span>Putra</span>
                                </span>
                            @endif
                        </div>

                        {{-- Photo --}}
                        <div class="flex justify-center mb-4">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden bg-gray-50 ring-4 {{ $ringColor }} shadow-md group-hover:scale-105 transition duration-300 relative">
                                <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                            </div>
                        </div>

                        {{-- Name & Unit --}}
                        <div class="text-center">
                            <h3 class="font-black text-gray-900 text-sm sm:text-base leading-snug group-hover:text-[#00843d] transition line-clamp-2">
                                {{ $item->name }}
                            </h3>
                            <p class="text-[11px] text-[#00843d] font-bold mt-1">
                                {{ $item->unitPendidikan?->name ?? 'Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>

                        {{-- Aktivitas / Pekerjaan / Perkuliahan --}}
                        <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Aktivitas Saat Ini</span>
                            <p class="text-xs font-semibold text-slate-800 line-clamp-2 leading-relaxed" title="{{ $item->activity }}">
                                <i class="fa-solid fa-briefcase text-emerald-600 mr-1 text-[11px]"></i>
                                {{ $item->activity }}
                            </p>
                        </div>

                        @if(!empty($item->bio))
                            <p class="text-[11px] text-gray-500 line-clamp-2 mt-3 text-center italic font-light leading-relaxed">
                                "{{ $item->bio }}"
                            </p>
                        @endif
                    </div>

                    {{-- Card Footer --}}
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                        <span class="font-medium text-emerald-700 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            <span>Terverifikasi</span>
                        </span>
                        @if($item->social_media)
                            <span class="font-mono text-slate-500 truncate max-w-[120px]">{{ $item->social_media }}</span>
                        @else
                            <span class="text-slate-400">PPRU Sakatiga</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-200">
                    <i class="fa-solid fa-user-graduate text-4xl text-gray-300 mb-3 block"></i>
                    <h4 class="font-extrabold text-sm text-gray-700">Belum ada data alumni yang cocok.</h4>
                    <p class="text-xs text-gray-500 mt-1">Silakan sesuaikan pilihan lembaga, tahun kelulusan, atau kategori putra/putri di atas.</p>
                    <a href="{{ route('alumni.index') }}" class="mt-3 inline-block px-4 py-2 bg-emerald-50 text-[#00843d] font-bold text-xs rounded-xl hover:bg-emerald-100 transition">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($alumni->hasPages())
            <div class="mt-8 pt-4">
                {{ $alumni->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
