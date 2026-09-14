@extends('layouts.admin')

@section('title', 'Unit Pendidikan')
@section('header_title', 'Manajemen Unit Pendidikan Pondok Pesantren Raudhatul Ulum')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Unit Pendidikan PPRU</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data jenjang dan lembaga pendidikan di bawah Pondok Pesantren Raudhatul Ulum Sakatiga.</p>
            </div>
            <a href="{{ route('admin.unit-pendidikan.create') }}" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-[#006830] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Unit Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($units as $u)
                <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition group">
                    <div>
                        {{-- Thumbnail Unit --}}
                        <div class="h-44 w-full bg-slate-200 relative overflow-hidden">
                            <img src="{{ $u->thumbnail_url }}" alt="{{ $u->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            <span class="absolute top-2.5 left-2.5 bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">
                                #{{ $u->order }}
                            </span>
                            <span class="absolute top-2.5 right-2.5 bg-[#00843d] text-white text-[10px] font-extrabold px-2.5 py-1 rounded-lg shadow-xs">
                                {{ $u->category_type }}
                            </span>
                        </div>

                        <div class="p-5 space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-sm shrink-0 overflow-hidden border border-emerald-200">
                                    <i class="{{ $u->icon ?: 'fa-solid fa-graduation-cap' }}"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center space-x-1.5">
                                        <h3 class="font-extrabold text-sm text-slate-900 truncate">{{ $u->name }}</h3>
                                        @if($u->short_name)
                                            <span class="text-[10px] bg-emerald-50 text-[#00843d] font-bold px-1.5 py-0.5 rounded">{{ $u->short_name }}</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-mono">/pendidikan/{{ $u->slug }}</span>
                                </div>
                            </div>

                            @if($u->badge)
                                <div class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200/60">
                                    <i class="fa-solid fa-award mr-1 text-amber-500"></i> {{ $u->badge }}
                                </div>
                            @endif

                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-light">
                                {{ strip_tags($u->description) ?: 'Belum ada deskripsi untuk unit ini.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-2 border-t border-slate-200/70 flex items-center justify-between text-xs bg-white">
                        <span class="inline-flex items-center text-[11px] font-semibold {{ $u->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                            <span class="w-2 h-2 rounded-full mr-1.5 {{ $u->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                            {{ $u->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.unit-pendidikan.edit', $u) }}" class="p-2 text-slate-600 hover:text-[#00843d] hover:bg-emerald-50 rounded-lg transition" title="Edit Unit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.unit-pendidikan.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit pendidikan ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Unit">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-xs text-slate-400">
                    <i class="fa-solid fa-graduation-cap text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada data unit pendidikan. Klik tombol tambah di atas untuk membuat.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
