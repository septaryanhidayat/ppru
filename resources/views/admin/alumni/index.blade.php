@extends('layouts.admin')

@section('title', 'Kelola Data Alumni')
@section('header_title', 'Kelola Data Alumni PPRU')

@section('content')
<div class="space-y-6">

    {{-- STATS & QUICK INFO --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Alumni</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($counts['total']) }}</h4>
                <p class="text-[11px] text-slate-500 mt-0.5">Tercatat di sistem</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Santriwan (Putra)</p>
                <h4 class="text-2xl font-black text-emerald-700 mt-1">{{ number_format($counts['putra']) }}</h4>
                <p class="text-[11px] text-emerald-600 mt-0.5">Segmen Putra</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100/70 text-emerald-800 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-mars"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Santriwati (Putri)</p>
                <h4 class="text-2xl font-black text-purple-700 mt-1">{{ number_format($counts['putri']) }}</h4>
                <p class="text-[11px] text-purple-600 mt-0.5">Segmen Putri</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-venus"></i>
            </div>
        </div>
    </div>

    {{-- SEGMEN FILTER & ACTIONS --}}
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            {{-- SEGMEN PUTRA / PUTRI TABS --}}
            <div class="flex items-center gap-1.5 p-1 bg-slate-100 rounded-xl self-start sm:self-auto">
                <a href="{{ request()->fullUrlWithQuery(['gender' => null, 'page' => 1]) }}" 
                   class="px-4 py-2 rounded-lg text-xs font-bold transition {{ empty($selectedGender) ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    Semua ({{ $counts['total'] }})
                </a>
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putra', 'page' => 1]) }}" 
                   class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $selectedGender === 'putra' ? 'bg-[#00843d] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-mars text-[10px]"></i>
                    <span>Putra ({{ $counts['putra'] }})</span>
                </a>
                <a href="{{ request()->fullUrlWithQuery(['gender' => 'putri', 'page' => 1]) }}" 
                   class="px-4 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1.5 {{ $selectedGender === 'putri' ? 'bg-purple-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                    <i class="fa-solid fa-venus text-[10px]"></i>
                    <span>Putri ({{ $counts['putri'] }})</span>
                </a>
            </div>

            {{-- TOMBOL TAMBAH ALUMNI --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('alumni.index') }}" target="_blank" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition flex items-center gap-1.5" title="Lihat Tampilan Publik">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                    <span class="hidden sm:inline">Halaman Publik</span>
                </a>
                <a href="{{ route('admin.alumni.create') }}" class="px-5 py-2.5 rounded-xl bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Data Alumni</span>
                </a>
            </div>
        </div>

        {{-- FILTER FORM: TAHUN LULUS, UNIT, SEARCH --}}
        <form action="{{ route('admin.alumni.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 pt-3 border-t border-slate-100">
            @if(!empty($selectedGender))
                <input type="hidden" name="gender" value="{{ $selectedGender }}">
            @endif

            {{-- Filter Tahun Lulus --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tahun Lulus</label>
                <select name="year" onchange="this.form.submit()" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <option value="">-- Semua Tahun Lulus --</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Unit Pendidikan --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Unit Asal</label>
                <select name="unit_id" onchange="this.form.submit()" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <option value="">-- Semua Unit --</option>
                    @foreach($units as $u)
                        <option value="{{ $u->id }}" {{ request('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search Box --}}
            <div class="lg:col-span-2">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cari Alumni</label>
                <div class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, profesi, perkuliahan, atau instansi..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl pl-9 pr-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs absolute left-3 top-2.5"></i>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
                        Cari
                    </button>
                    @if(request()->hasAny(['q', 'year', 'unit_id', 'gender']))
                        <a href="{{ route('admin.alumni.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition" title="Reset Filter">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- ALUMNI TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-5 py-4 w-16">Foto</th>
                        <th class="px-5 py-4">Nama Alumni &amp; Gelar</th>
                        <th class="px-5 py-4">Segmen</th>
                        <th class="px-5 py-4">Tahun Lulus</th>
                        <th class="px-5 py-4">Unit Asal</th>
                        <th class="px-5 py-4">Aktivitas / Pekerjaan / Perkuliahan</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($alumnis as $alumni)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-3.5">
                                <img src="{{ $alumni->photo_url }}" alt="{{ $alumni->name }}" class="w-11 h-11 rounded-full object-cover ring-2 {{ $alumni->gender === 'putri' ? 'ring-purple-200' : 'ring-emerald-200' }} shadow-2xs" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-extrabold text-slate-900 block">{{ $alumni->name }}</span>
                                @if($alumni->phone)
                                    <span class="text-[10.5px] text-slate-400 block font-mono">{{ $alumni->phone }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if($alumni->gender === 'putri')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-purple-100 text-purple-700">
                                        <i class="fa-solid fa-venus text-[9px]"></i>
                                        <span>Putri</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-emerald-100 text-[#00843d]">
                                        <i class="fa-solid fa-mars text-[9px]"></i>
                                        <span>Putra</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-lg bg-amber-50 text-amber-800 font-extrabold text-xs border border-amber-200">
                                    {{ $alumni->graduation_year }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-slate-600 font-semibold block">
                                    {{ $alumni->unitPendidikan?->short_name ?: ($alumni->unitPendidikan?->name ?: 'PPRU') }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 max-w-xs">
                                <span class="font-medium text-slate-700 line-clamp-2" title="{{ $alumni->activity }}">
                                    {{ $alumni->activity }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($alumni->is_published)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Publish</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.alumni.edit', $alumni) }}" class="p-2 text-slate-600 hover:text-[#00843d] hover:bg-emerald-50 rounded-lg transition" title="Edit Data Alumni">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.alumni.destroy', $alumni) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni {{ $alumni->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Data Alumni">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-user-graduate text-3xl text-slate-300 mb-2 block"></i>
                                <p class="font-semibold text-xs text-slate-500">Belum ada data alumni yang cocok dengan filter.</p>
                                <a href="{{ route('admin.alumni.create') }}" class="text-xs text-[#00843d] font-bold hover:underline mt-1 inline-block">
                                    + Tambah Data Alumni Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($alumnis->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $alumnis->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
