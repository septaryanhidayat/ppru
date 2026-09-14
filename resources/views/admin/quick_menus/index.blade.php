@extends('layouts.admin')

@section('title', 'Kelola Menu Utama (Quick Action)')
@section('header_title', 'Menu Utama & Quick Action Beranda')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Menu Cepat (Quick Action)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola kartu icon, judul, tautan (link), dan status aktif. 8 menu aktif teratas otomatis tampil di bawah Hero Beranda.</p>
            </div>
            <a href="{{ route('admin.quick-menus.create') }}" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Menu Cepat</span>
            </a>
        </div>

        <div class="mt-4 p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center justify-between text-xs text-emerald-900">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-info text-emerald-600 text-sm"></i>
                <span><strong>Status Beranda:</strong> Menampilkan 8 menu pertama yang berstatus <strong>Aktif</strong> (Urutan #1 s/d #8). Menu lainnya dinonaktifkan agar beranda tetap rapi.</span>
            </div>
            <span class="text-[11px] font-bold bg-white text-emerald-700 px-3 py-1 rounded-xl border border-emerald-300 shadow-xs">
                {{ $quickMenus->where('is_active', true)->count() }} Menu Aktif &bull; {{ $quickMenus->where('is_active', false)->count() }} Nonaktif
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4 mt-6">
            @forelse($quickMenus as $qm)
                <div class="bg-slate-50 rounded-2xl p-4 border {{ $qm->is_active ? 'border-emerald-200 shadow-xs' : 'border-slate-200 opacity-80' }} flex flex-col justify-between items-center text-center space-y-3 hover:shadow-md transition group relative">
                    <div class="absolute top-2 right-2">
                        @if($qm->is_active)
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-extrabold bg-emerald-100 text-emerald-700 border border-emerald-300" title="Aktif di Beranda">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-slate-200 text-slate-600 border border-slate-300" title="Nonaktif (Tidak tampil di Beranda)">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center p-2 shadow-xs group-hover:scale-105 transition">
                        @if($qm->is_image)
                            <img src="{{ $qm->icon }}" alt="{{ $qm->name }}" class="max-h-full max-w-full object-contain" onerror="this.src='/uploads/logo-ppru-square.png'">
                        @else
                            <i class="{{ $qm->icon }} text-2xl text-[#00843d]"></i>
                        @endif
                    </div>

                    <div class="min-w-0 w-full">
                        <h3 class="font-extrabold text-xs text-slate-900 truncate">{{ $qm->name }}</h3>
                        <span class="text-[10px] text-slate-400 font-mono block truncate mt-0.5" title="{{ $qm->url }}">{{ $qm->url }}</span>
                        <span class="text-[10px] text-[#00843d] font-bold block mt-1">Urutan: #{{ $qm->order }}</span>
                    </div>

                    <div class="pt-2 border-t border-slate-200 w-full flex items-center justify-center space-x-2 text-xs">
                        <a href="{{ route('admin.quick-menus.edit', $qm) }}" class="p-1.5 text-slate-600 hover:text-[#00843d] hover:bg-emerald-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.quick-menus.destroy', $qm) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-name="{{ $qm->name }}" class="btn-delete p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-xs text-slate-400">
                    <i class="fa-solid fa-compass text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada menu cepat. Klik tombol di atas untuk menambahkan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
