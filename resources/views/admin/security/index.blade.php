@extends('layouts.admin')

@section('title', 'Log Aktivitas & Audit Keamanan')
@section('header_title', 'Log Aktivitas & Audit Keamanan Siber')

@section('content')
<div class="space-y-6">
    
    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Catatan Log</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-800">{{ number_format($stats['total']) }}</span>
            <span class="text-[11px] text-slate-400 block mt-1">Seluruh riwayat audit</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-red-200/80 bg-red-50/20">
            <span class="text-xs font-bold text-red-500 uppercase tracking-wider block mb-1">Ancaman Serangan Terblokir</span>
            <span class="text-2xl sm:text-3xl font-black text-red-600">{{ number_format($stats['threats']) }}</span>
            <span class="text-[11px] text-red-400 block mt-1">Injeksi SQL, XSS, Webshell probe</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-amber-200/80 bg-amber-50/20">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block mb-1">Peringatan / Gagal Login</span>
            <span class="text-2xl sm:text-3xl font-black text-amber-600">{{ number_format($stats['warnings']) }}</span>
            <span class="text-[11px] text-amber-500 block mt-1">Upaya login gagal & aksi kritis</span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Aktivitas Hari Ini</span>
            <span class="text-2xl sm:text-3xl font-black text-slate-800">{{ number_format($stats['today']) }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold block mt-1">Real-time monitoring</span>
        </div>
    </div>

    {{-- MAIN LOG TABLE CONTAINER --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        
        {{-- Header & Filters --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Riwayat Log & Audit Sistem</h2>
                <p class="text-xs text-slate-500 mt-0.5">Memantau setiap aktivitas login, perubahan data, dan upaya serangan ke website.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Filter Buttons --}}
                <div class="inline-flex rounded-xl bg-slate-100 p-1 text-xs font-bold">
                    <a href="{{ route('admin.security.index') }}" class="px-3 py-1.5 rounded-lg transition {{ !request('status') ? 'bg-white text-slate-800 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">Semua</a>
                    <a href="{{ route('admin.security.index', ['status' => 'danger']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'danger' ? 'bg-red-600 text-white shadow-xs' : 'text-red-600 hover:text-red-700' }}">Ancaman ({{ $stats['threats'] }})</a>
                    <a href="{{ route('admin.security.index', ['status' => 'warning']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'warning' ? 'bg-amber-500 text-white shadow-xs' : 'text-amber-600 hover:text-amber-700' }}">Peringatan</a>
                    <a href="{{ route('admin.security.index', ['status' => 'info']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') === 'info' ? 'bg-white text-slate-800 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">Info</a>
                </div>

                {{-- Clear Logs --}}
                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                    <form action="{{ route('admin.security.clear') }}" method="POST" onsubmit="return confirm('Bersihkan log umum berkala? (Log ancaman/keamanan akan tetap disimpan)');">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-slate-600 text-xs border border-slate-200 rounded-xl hover:bg-slate-50 transition cursor-pointer" title="Bersihkan Log Umum">
                            <i class="fa-solid fa-broom mr-1"></i> Bersihkan Log Info
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Search Bar --}}
        <form action="{{ route('admin.security.index') }}" method="GET" class="flex gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan aksi, deskripsi, user, atau alamat IP..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001]">
            <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-900 transition flex items-center space-x-1 flex-shrink-0">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Cari</span>
            </button>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Aksi</th>
                        <th class="py-3.5 px-4">Rincian Deskripsi</th>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Alamat IP</th>
                        <th class="py-3.5 px-4">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/80 transition {{ $log->status === 'danger' ? 'bg-red-50/30' : '' }}">
                            <td class="py-3.5 px-4">
                                @if($log->status === 'danger')
                                    <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center space-x-1">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        <span>Ancaman</span>
                                    </span>
                                @elseif($log->status === 'warning')
                                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center space-x-1">
                                        <i class="fa-solid fa-shield-exclamation"></i>
                                        <span>Peringatan</span>
                                    </span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center space-x-1">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span>Info</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-xs text-slate-800">
                                {{ $log->action }}
                            </td>
                            <td class="py-3.5 px-4 max-w-md">
                                <p class="text-xs text-slate-700 leading-relaxed">{{ $log->description }}</p>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $log->user_name ?: 'Tamu' }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $log->ip_address }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 whitespace-nowrap text-[11px]">
                                {{ $log->created_at->format('d M Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-xs text-slate-400">Tidak ada log yang sesuai dengan kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
