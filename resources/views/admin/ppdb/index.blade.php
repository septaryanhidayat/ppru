@extends('layouts.admin')

@section('title', 'Data Pendaftaran PPDB')
@section('header_title', 'Penerimaan Peserta Didik Baru (PPDB Online)')

@section('content')
<div class="space-y-6">

    {{-- TOP NAVIGATION TABS & EXPORT BUTTONS --}}
    {{-- TOP NAVIGATION TABS & EXPORT BUTTONS --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-4">
        <a href="{{ route('admin.ppdb.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-[#00913e] text-white shadow-md transition">
            <i class="fa-solid fa-users mr-1.5"></i> Data Calon Santri (Pendaftar)
        </a>
        @if(!auth()->user()->isUnitAdmin())
        <a href="{{ route('admin.ppdb.content') }}" class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-slate-600 hover:bg-slate-100 border border-slate-200 transition">
            <i class="fa-solid fa-sliders mr-1.5"></i> Pengaturan &amp; Konten Halaman PPDB
        </a>
        @endif
        <div class="ml-auto flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.ppdb.export.excel', request()->query()) }}" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-emerald-700 hover:bg-emerald-800 text-white shadow-sm transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-excel"></i>
                <span>Export Excel</span>
            </a>
            <a href="{{ route('admin.ppdb.export.pdf', request()->query()) }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-red-700 hover:bg-red-800 text-white shadow-sm transition flex items-center space-x-1.5">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('ppdb.index') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs bg-slate-800 hover:bg-slate-900 text-white shadow-sm transition flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Halaman PPDB</span>
            </a>
        </div>
    </div>

    @if(auth()->user()->isUnitAdmin() && $currentUnit)
        {{-- UNIT ADMIN SCOPED NOTICE --}}
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-emerald-900">
            <div class="flex items-center space-x-3">
                <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                    <i class="fa-solid fa-school-flag"></i>
                </span>
                <div>
                    <h3 class="font-bold text-emerald-950 text-sm">PPDB Khusus Unit: {{ $currentUnit->name }} ({{ $currentUnit->short_name }})</h3>
                    <p class="text-emerald-700 text-[11px] mt-0.5">Data pendaftar di bawah ini secara otomatis terisolasi khusus untuk unit Anda. Data unit lain tidak akan tercampur.</p>
                </div>
            </div>
            <span class="bg-emerald-600 text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider shrink-0 self-start sm:self-auto">
                Admin {{ $currentUnit->short_name }}
            </span>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.ppdb.index', array_merge(request()->except('status'))) }}" class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-[#00913e] transition">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Pendaftar</span>
            <span class="text-2xl font-black text-slate-900 mt-1 block">{{ number_format($stats['total']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="p-4 rounded-2xl bg-amber-50 border border-amber-200 shadow-xs hover:border-amber-400 transition">
            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <span class="text-2xl font-black text-amber-900 mt-1 block">{{ number_format($stats['pending']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', array_merge(request()->except('status'), ['status' => 'verified'])) }}" class="p-4 rounded-2xl bg-blue-50 border border-blue-200 shadow-xs hover:border-blue-400 transition">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block">Terverifikasi</span>
            <span class="text-2xl font-black text-blue-900 mt-1 block">{{ number_format($stats['verified']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', array_merge(request()->except('status'), ['status' => 'accepted'])) }}" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-xs hover:border-emerald-400 transition">
            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Diterima</span>
            <span class="text-2xl font-black text-emerald-900 mt-1 block">{{ number_format($stats['accepted']) }}</span>
        </a>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        
        {{-- SEARCH & FILTER BAR --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">
                    Daftar Calon Santri Baru (2026/2027)
                    @if($currentUnit)
                        <span class="text-[#00913e] font-bold text-sm ml-1">&bull; {{ $currentUnit->short_name }}</span>
                    @endif
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola formulir masuk, verifikasi berkas akta & bukti transfer, dan status penerimaan santri.</p>
            </div>

            <form action="{{ route('admin.ppdb.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                @if(!auth()->user()->isUnitAdmin())
                    <select name="unit_id" onchange="this.form.submit()" class="bg-slate-50 text-xs text-slate-800 font-semibold rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        <option value="">Semua Unit Pendidikan</option>
                        @foreach($unitPendidikans as $u)
                            <option value="{{ $u->id }}" {{ (string)request('unit_id') === (string)$u->id ? 'selected' : '' }}>
                                {{ $u->short_name }} - {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                @endif

                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, No. Reg, asal sekolah..." class="bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] w-44 sm:w-56">
                <button type="submit" class="bg-[#00913e] hover:bg-[#007532] text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                @if(request('q') || request('unit_id') || request('status'))
                    <a href="{{ route('admin.ppdb.index') }}" class="text-xs text-slate-500 hover:text-red-500 font-semibold px-2 py-2" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">No. Registrasi</th>
                        <th class="py-3 px-4">Unit Tujuan</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Asal Sekolah</th>
                        <th class="py-3 px-4">No. HP / WA</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Tanggal Daftar</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-[#da251c] whitespace-nowrap">{{ $reg->registration_number }}</td>
                            <td class="py-3.5 px-4">
                                @if($reg->unitPendidikan)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10.5px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-2xs">
                                        {{ $reg->unitPendidikan->short_name }}
                                    </span>
                                    <span class="block text-[10px] text-slate-500 font-medium truncate max-w-[130px] mt-0.5">{{ $reg->unitPendidikan->name }}</span>
                                @else
                                    <span class="text-slate-400 text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block">{{ $reg->full_name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $reg->gender }} &bull; {{ $reg->birth_place }}</span>
                                <div class="mt-1 flex items-center gap-1.5 flex-wrap">
                                    <span class="text-[10px] bg-emerald-50 text-[#00913e] font-bold px-2 py-0.5 rounded-md border border-emerald-200">{{ $reg->track ?: 'Reguler' }}</span>
                                    <span class="text-[10px] bg-slate-100 text-slate-600 font-bold px-2 py-0.5 rounded-md border border-slate-200">{{ $reg->program_type ?: 'Boarding' }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">{{ $reg->previous_school }}</td>
                            <td class="py-3.5 px-4">
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $reg->phone)) }}" target="_blank" class="text-[#00913e] hover:underline font-bold flex items-center space-x-1">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span>{{ $reg->phone }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $reg->status_badge }}">
                                    {{ $reg->status_label }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.ppdb.show', $reg) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail & Berkas">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ppdb.print', $reg) }}" target="_blank" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Cetak Bukti Pendaftaran">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <form action="{{ route('admin.ppdb.destroy', $reg) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pendaftaran {{ $reg->full_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Data">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl block mb-2 text-slate-300"></i>
                                Belum ada formulir pendaftaran PPDB yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($registrations->hasPages())
            <div class="pt-4 border-t border-slate-100">
                {{ $registrations->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
