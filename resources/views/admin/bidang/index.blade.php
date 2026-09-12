@extends('layouts.admin')

@section('title', 'Fasilitas & Sarana Sekolah')
@section('header_title', 'Fasilitas & Sarana SMA IT Ishlahul Ummah Prabumulih')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Fasilitas & Sarana Sekolah</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola foto sarana prasarana, deskripsi fasilitas belajar, dan urutan tampil.</p>
            </div>
            <a href="{{ route('admin.bidang.create') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Fasilitas Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($bidangs as $b)
                <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition group">
                    <div>
                        {{-- Foto Thumbnail Fasilitas --}}
                        <div class="h-44 w-full bg-slate-200 relative overflow-hidden">
                            <img src="{{ $b->thumbnail_url }}" alt="{{ $b->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ishum.webp'">
                            <span class="absolute top-2.5 left-2.5 bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">
                                #{{ $b->order }}
                            </span>
                        </div>

                        <div class="p-5 space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#00913e] flex items-center justify-center text-sm shrink-0 overflow-hidden border border-emerald-200">
                                    @if($b->is_image_icon)
                                        <img src="{{ $b->icon }}" alt="{{ $b->name }}" class="w-full h-full object-contain p-1" onerror="this.src='/uploads/2025/09/logo-thumbnail.webp'">
                                    @else
                                        <i class="{{ $b->icon ?: 'fa-solid fa-school' }}"></i>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-extrabold text-sm text-slate-900 truncate">{{ $b->name }}</h3>
                                    <span class="text-[10px] text-slate-400 font-mono">/{{ $b->slug }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-light">
                                {{ strip_tags($b->description) ?: 'Belum ada deskripsi untuk fasilitas ini.' }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-2 border-t border-slate-200/70 flex items-center justify-between text-xs bg-white">
                        <span class="text-slate-400 text-[11px] font-medium">SMA IT Ishum</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.bidang.edit', $b) }}" class="p-2 text-slate-600 hover:text-[#00913e] hover:bg-emerald-50 rounded-lg transition" title="Edit Fasilitas">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.bidang.destroy', $b) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas sekolah ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Fasilitas">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-xs text-slate-400">
                    <i class="fa-solid fa-school text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada data fasilitas sekolah.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
