@extends('layouts.frontend')

@section('title', 'Data Alumni - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Database dan direktori resmi alumni Pondok Pesantren Raudhatul Ulum Sakatiga: rekam jejak lulusan di perguruan tinggi dan dunia profesional.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-br from-[#053d1c] via-[#00843d] to-emerald-950 text-white py-12 sm:py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fcd116_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="text-xs text-emerald-200 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-amber-300 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('ikarus.index') }}" class="hover:text-amber-300 transition">IKARUS</a>
            <span>/</span>
            <span class="text-amber-300 font-bold">Data Alumni</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-400/20 text-amber-300 border border-amber-400/30 mb-3">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Direktori Resmi Alumni PPRU Sakatiga</span>
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white">
                    Data &amp; Rekam Jejak Alumni
                </h1>
                <p class="text-sm sm:text-base text-emerald-100 mt-2 font-light leading-relaxed">
                    Kiprah dan dedikasi lulusan Pondok Pesantren Raudhatul Ulum Sakatiga di berbagai perguruan tinggi ternama dan ranah profesional di penjuru nusantara serta mancanegara.
                </p>
            </div>

            {{-- QUICK STATS BADGES --}}
            <div class="grid grid-cols-3 gap-3 shrink-0">
                <div class="bg-white/10 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/15 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-amber-300 block leading-tight">{{ number_format($countTotal) }}</span>
                    <span class="text-[11px] text-emerald-100 font-medium mt-0.5 block">Total Alumni</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/15 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-emerald-200 block leading-tight">{{ number_format($countPutra) }}</span>
                    <span class="text-[11px] text-emerald-100 font-medium mt-0.5 block">Santriwan (PA)</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/15 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-purple-200 block leading-tight">{{ number_format($countPutri) }}</span>
                    <span class="text-[11px] text-emerald-100 font-medium mt-0.5 block">Santriwati (PI)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-8">

    {{-- SEGMEN WRAPPER CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-6">

        {{-- SEGMEN 1: ASAL SEKOLAH / UNIT LEMBAGA --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black">1</span>
                    <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-school text-[#00843d]"></i>
                        <span>Asal Sekolah / Unit Lembaga</span>
                    </h3>
                </div>
                @if(!empty($selectedUnit))
                    @php $currUnit = $units->firstWhere('id', $selectedUnit); @endphp
                    @if($currUnit)
                        <span class="text-xs font-bold text-[#00843d]">Unit: {{ $currUnit->short_name ?: $currUnit->name }}</span>
                    @endif
                @endif
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
                <a href="{{ request()->fullUrlWithQuery(['unit_id' => null, 'page' => 1]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ empty($selectedUnit) ? 'bg-[#00843d] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                    <span>Semua Lembaga</span>
                </a>

                @foreach($units as $u)
                    @php
                        $isActiveUnit = ($selectedUnit == $u->id);
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['unit_id' => $u->id, 'page' => 1]) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ $isActiveUnit ? 'bg-[#00843d] text-white shadow-sm ring-2 ring-emerald-500/30' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                       title="{{ $u->name }}">
                        <span class="font-extrabold">{{ $u->short_name ?: $u->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- SEGMEN 2: TAHUN LULUS (ANGKATAN) --}}
        <div class="pt-5 border-t border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black">2</span>
                    <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-calendar-check text-[#00843d]"></i>
                        <span>Pilih Tahun Lulus (Angkatan)</span>
                    </h3>
                </div>
                @if(!empty($selectedYear))
                    <span class="text-xs font-bold text-[#00843d]">Tahun Terpilih: {{ $selectedYear }}</span>
                @endif
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-thin">
                <a href="{{ request()->fullUrlWithQuery(['year' => null, 'page' => 1]) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ empty($selectedYear) ? 'bg-[#00843d] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    <span>Semua Angkatan</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ empty($selectedYear) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $countTotal }}
                    </span>
                </a>

                @foreach($availableYears as $yItem)
                    @php
                        $isActiveYear = ($selectedYear == $yItem->graduation_year);
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['year' => $yItem->graduation_year, 'page' => 1]) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ $isActiveYear ? 'bg-[#00843d] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <span>Tahun {{ $yItem->graduation_year }}</span>
                        <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $isActiveYear ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">
                            {{ $yItem->count }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- SEGMEN 3: PUTRA & PUTRI (GENDER SWITCHER) --}}
        <div class="pt-5 border-t border-gray-100">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black">3</span>
                <h3 class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-gray-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-users text-[#00843d]"></i>
                    <span>Segmen Santriwan (Putra) &amp; Santriwati (Putri)</span>
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                {{-- Tab Semua --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => null, 'page' => 1]) }}"
                   class="p-3 rounded-2xl border text-center transition flex items-center justify-center gap-2 {{ empty($selectedGender) ? 'bg-[#00843d] text-white border-[#00843d] shadow-sm' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                    <i class="fa-solid fa-layer-group text-sm"></i>
                    <span class="text-xs font-extrabold">Semua Alumni</span>
                </a>

                {{-- Tab Putra --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putra', 'page' => 1]) }}"
                   class="p-3 rounded-2xl border text-center transition flex items-center justify-center gap-2 {{ $selectedGender === 'putra' ? 'bg-[#00843d] text-white border-[#00843d] shadow-sm' : 'bg-white text-emerald-800 border-gray-200 hover:bg-emerald-50/50' }}">
                    <i class="fa-solid fa-mars text-sm"></i>
                    <span class="text-xs font-extrabold">Putra (Santriwan)</span>
                </a>

                {{-- Tab Putri --}}
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putri', 'page' => 1]) }}"
                   class="p-3 rounded-2xl border text-center transition flex items-center justify-center gap-2 {{ $selectedGender === 'putri' ? 'bg-purple-700 text-white border-purple-700 shadow-sm' : 'bg-white text-purple-700 border-gray-200 hover:bg-purple-50/50' }}">
                    <i class="fa-solid fa-venus text-sm"></i>
                    <span class="text-xs font-extrabold">Putri (Santriwati)</span>
                </a>
            </div>
        </div>

        {{-- FILTER PENCARIAN ALUMNI --}}
        <form action="{{ route('alumni.index') }}" method="GET" class="pt-5 border-t border-gray-100 flex flex-col sm:flex-row gap-3 items-center justify-between">
            @if(!empty($selectedUnit))
                <input type="hidden" name="unit_id" value="{{ $selectedUnit }}">
            @endif
            @if(!empty($selectedYear))
                <input type="hidden" name="year" value="{{ $selectedYear }}">
            @endif
            @if(!empty($selectedGender))
                <input type="hidden" name="gender" value="{{ $selectedGender }}">
            @endif

            <div class="relative w-full sm:max-w-md">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama alumni, profesi, kampus, instansi..." class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl pl-9 pr-3.5 py-2.5 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs absolute left-3 top-3"></i>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button type="submit" class="px-5 py-2.5 bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    <span>Cari</span>
                </button>
                @if(request()->hasAny(['year', 'gender', 'unit_id', 'q']))
                    <a href="{{ route('alumni.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5" title="Reset Semua Filter">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

    </div>

    {{-- SEGMEN 4: DATA ALUMNI (GRID KARTU PROFIL) --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black">4</span>
                <h2 class="text-sm sm:text-base font-extrabold uppercase tracking-wider text-gray-900">
                    Data Rekam Jejak Alumni
                </h2>
            </div>
            <span class="text-xs font-semibold text-gray-500">
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
                    <p class="text-xs text-gray-500 mt-1">Silakan sesuaikan filter tahun lulus atau segmen putra/putri di atas.</p>
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
