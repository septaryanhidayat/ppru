@extends('layouts.admin')

@section('title', 'Data Pendaftaran PPDB')
@section('header_title', 'Penerimaan Peserta Didik Baru (PPDB Online)')

@section('content')
<div class="space-y-6">

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="{{ route('admin.ppdb.index') }}" class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs hover:border-[#00913e] transition">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Pendaftar</span>
            <span class="text-2xl font-black text-slate-900 mt-1 block">{{ number_format($stats['total']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'pending']) }}" class="p-4 rounded-2xl bg-amber-50 border border-amber-200 shadow-xs hover:border-amber-400 transition">
            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <span class="text-2xl font-black text-amber-900 mt-1 block">{{ number_format($stats['pending']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'verified']) }}" class="p-4 rounded-2xl bg-blue-50 border border-blue-200 shadow-xs hover:border-blue-400 transition">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block">Terverifikasi</span>
            <span class="text-2xl font-black text-blue-900 mt-1 block">{{ number_format($stats['verified']) }}</span>
        </a>
        <a href="{{ route('admin.ppdb.index', ['status' => 'accepted']) }}" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-xs hover:border-emerald-400 transition">
            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Diterima</span>
            <span class="text-2xl font-black text-emerald-900 mt-1 block">{{ number_format($stats['accepted']) }}</span>
        </a>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        
        {{-- SEARCH & FILTER BAR --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Calon Santri Baru (2026/2027)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola formulir masuk, verifikasi berkas akta & bukti transfer, dan status penerimaan.</p>
            </div>

            <form action="{{ route('admin.ppdb.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, No. Reg, asal sekolah..." class="bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] w-48 sm:w-64">
                <button type="submit" class="bg-[#00913e] hover:bg-[#007532] text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">No. Registrasi</th>
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
                            <td class="py-3.5 px-4 font-mono font-bold text-[#da251c]">{{ $reg->registration_number }}</td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block">{{ $reg->full_name }}</span>
                                <span class="text-[11px] text-slate-400">{{ $reg->gender }} &bull; {{ $reg->birth_place }}</span>
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
                            <td class="py-3.5 px-4 text-slate-500">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.ppdb.show', $reg) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail & Berkas">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ppdb.print', $reg) }}" target="_blank" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Cetak Bukti Pendaftaran">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <form action="{{ route('admin.ppdb.destroy', $reg) }}" method="POST" class="inline">
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
                            <td colspan="7" class="py-8 text-center text-slate-400">
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
