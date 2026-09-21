@extends('layouts.admin')

@section('title', 'Program Unggulan Pesantren')
@section('header_title', 'Program Unggulan Pondok Pesantren Raudhatul Ulum Sakatiga')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Program Unggulan Pesantren</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola foto kegiatan, kategori program, koordinator/pembina, dan deskripsi capaian santri.</p>
            </div>
            <a href="{{ route('admin.program-unggulan.create') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Program Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($programs as $p)
                <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition group">
                    <div>
                        {{-- Foto Cover Program --}}
                        <div class="h-44 w-full bg-slate-200 relative overflow-hidden">
                            <img src="{{ $p->thumbnail_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.onerror=null;this.src='/images/hero-1.webp'">
                            <span class="absolute top-2.5 left-2.5 bg-[#00913e] text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm">
                                {{ $p->address ?: 'Program Unggulan' }}
                            </span>
                            <span class="absolute top-2.5 right-2.5 bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold px-2 py-0.5 rounded-md">
                                #{{ $p->order }}
                            </span>
                        </div>

                        <div class="p-5 space-y-2.5">
                            <h3 class="font-extrabold text-sm text-slate-900 leading-snug">{{ $p->name }}</h3>
                            
                            @if($p->head_name)
                                <div class="text-xs text-[#da251c] font-semibold flex items-center">
                                    <i class="fa-solid fa-user-check text-[10px] mr-1.5"></i>
                                    <span>{{ $p->head_name }}</span>
                                </div>
                            @endif

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-light">
                                {{ strip_tags($p->description) ?: 'Belum ada deskripsi untuk program ini.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-2 border-t border-slate-200/70 flex items-center justify-between text-xs bg-white">
                        <span class="text-slate-400 text-[11px] font-medium">PPRU Sakatiga</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.program-unggulan.edit', $p) }}" class="p-2 text-slate-600 hover:text-[#00913e] hover:bg-emerald-50 rounded-lg transition" title="Edit Program">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.program-unggulan.destroy', $p) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program unggulan ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Program">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-xs text-slate-400">
                    <i class="fa-solid fa-graduation-cap text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada data program unggulan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
