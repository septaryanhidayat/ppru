@extends('layouts.admin')

@section('title', 'Struktur Pengurus & Dewan Guru')
@section('header_title', 'Pengurus Yayasan & Dewan Guru (GTK)')

@section('content')
<div class="space-y-6" x-data="{ tab: 'table' }">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Struktur Pengurus Yayasan &amp; Pendidik PPRU</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola susunan pimpinan yayasan (YAPIRUS), dewan guru, foto resmi, dan urutan tampil hirarki.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <!-- Tab Switcher (Tabel vs Bagan) -->
                <div class="inline-flex items-center p-1 rounded-xl bg-slate-100 border border-slate-200">
                    <button type="button" 
                            @click="tab = 'table'" 
                            :class="tab === 'table' ? 'bg-[#00843d] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer">
                        <i class="fa-solid fa-table-cells-large"></i>
                        <span>Daftar Data</span>
                    </button>
                    <button type="button" 
                            @click="tab = 'chart'" 
                            :class="tab === 'chart' ? 'bg-[#00843d] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Visualisasi Bagan</span>
                    </button>
                </div>

                <a href="{{ route('admin.dewan.create') }}" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-[#094d28] text-white font-bold text-xs px-4 py-2 rounded-xl shadow-md transition self-start sm:self-auto cursor-pointer">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah Pengurus / Guru</span>
                </a>
            </div>
        </div>

        {{-- TAB 1: VISUALISASI BAGAN HIRARKI (ORG CHART) --}}
        <div x-show="tab === 'chart'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="pt-6">
            @include('partials.organization-chart', ['tree' => $tree])
        </div>

        {{-- TAB 2: GRID LIST DATA PENGURUS & GURU --}}
        <div x-show="tab === 'table'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            @forelse($dewan as $d)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="text-center space-y-3">
                        <div class="w-24 h-24 mx-auto rounded-2xl bg-white p-1 shadow-xs border border-slate-200 overflow-hidden">
                            <img src="{{ $d->photo }}" alt="{{ $d->name }}" class="w-full h-full object-cover object-top rounded-xl" onerror="this.src='/uploads/logo-ppru-square.png'">
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-slate-900">{{ $d->name }}</h3>
                            <span class="inline-block bg-emerald-100 text-[#00913e] text-[10px] font-bold px-2 py-0.5 rounded-full mt-1">
                                {{ $d->position }}
                            </span>
                            <p class="text-[11px] text-slate-500 mt-2 line-clamp-2">{{ $d->fraction ?? 'Dewan Guru & GTK PPRU' }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[10px]">Urutan: #{{ $d->order }}</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.dewan.edit', $d) }}" class="p-2 text-slate-600 hover:text-[#da251c] hover:bg-red-100 rounded-lg transition" title="Edit Profil">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.dewan.destroy', $d) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota dewan ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada data anggota dewan.</div>
            @endforelse
        </div>
        </div>
    </div>
</div>
@endsection
