@extends('layouts.admin')

@section('title', 'Backup Database')
@section('header_title', 'Cadangan Basis Data (Database Backup)')

@section('content')
<div class="space-y-6">
    
    {{-- DOWNLOAD HERO BANNER --}}
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-[#0b1120] rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-slate-700">
        <div class="space-y-2 text-center md:text-left">
            <div class="inline-flex items-center space-x-2 bg-amber-400/20 text-amber-400 px-3 py-1 rounded-full text-xs font-bold">
                <i class="fa-solid fa-database"></i>
                <span>MySQL & MariaDB Ready</span>
            </div>
            <h2 class="text-2xl font-black text-white">Unduh Cadangan Basis Data (SQL)</h2>
            <p class="text-xs text-slate-300 max-w-xl font-light">
                Ekspor seluruh tabel, data berita, galeri, anggota dewan, dan pengaturan web ke dalam format <code>.sql</code> standar yang siap diimpor langsung ke phpMyAdmin atau server cPanel Anda.
            </p>
        </div>

        <div class="flex-shrink-0">
            <a href="{{ route('admin.backup.download') }}" class="bg-gradient-to-r from-[#ff5001] to-[#ff7300] hover:from-[#e04500] hover:to-[#e06500] text-white font-extrabold text-sm px-6 py-3.5 rounded-2xl shadow-xl transition flex items-center space-x-3 transform hover:scale-105 cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-down text-lg"></i>
                <span>Download File Backup (.sql)</span>
            </a>
        </div>
    </div>

    {{-- STATS & TABLE OVERVIEW --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Ukuran Basis Data</span>
            <span class="text-2xl font-black text-slate-800">{{ $dbSize }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold block mt-1"><i class="fa-solid fa-check mr-1"></i>Kondisi Optimal</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Tabel Data</span>
            <span class="text-2xl font-black text-slate-800">{{ count($tableDetails) }} Tabel</span>
            <span class="text-[11px] text-slate-500 block mt-1">Struktur relasi lengkap</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Entri / Baris</span>
            <span class="text-2xl font-black text-slate-800">{{ number_format($totalRecords) }} Baris</span>
            <span class="text-[11px] text-slate-500 block mt-1">Termasuk 73 artikel berita</span>
        </div>
    </div>

    {{-- TABLE DETAILS --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <h3 class="font-extrabold text-sm text-slate-800 uppercase tracking-wider flex items-center space-x-2">
            <i class="fa-solid fa-table-list text-[#ff5001]"></i>
            <span>Rincian Seluruh Tabel Database</span>
        </h3>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 pt-2">
            @foreach($tableDetails as $td)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/70 text-center">
                    <span class="font-mono text-xs font-bold text-slate-800 block truncate" title="{{ $td['name'] }}">{{ $td['name'] }}</span>
                    <span class="text-[11px] text-[#ff5001] font-semibold block mt-0.5">{{ number_format($td['records']) }} data</span>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
