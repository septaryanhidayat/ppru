@extends('layouts.admin')

@section('title', 'Fasilitas & Sarana Kampus')
@section('header_title', 'Fasilitas & Sarana SMA IT Ishlahul Ummah Prabumulih')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Fasilitas & Sarana Sekolah</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola fasilitas kampus, deskripsi sarana prasarana, dan nomor urut tampil.</p>
            </div>
            <a href="{{ route('admin.bidang.create') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Fasilitas Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($bidangs as $b)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-orange-100 text-[#ff5001] flex items-center justify-center text-lg shrink-0 overflow-hidden border border-orange-200">
                                @if($b->is_image_icon)
                                    <img src="{{ $b->icon }}" alt="{{ $b->name }}" class="w-full h-full object-contain p-1.5" onerror="this.src='/uploads/2025/09/logo-thumbnail.webp'">
                                @else
                                    <i class="{{ $b->icon ?: 'fa-solid fa-users' }}"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-extrabold text-sm text-slate-900 truncate">{{ $b->name }}</h3>
                                <span class="text-[10px] text-slate-400 font-mono">/{{ $b->slug }}</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ strip_tags($b->description) ?: 'Belum ada deskripsi untuk bidang ini.' }}</p>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[10px]">Urutan: #{{ $b->order }}</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.bidang.edit', $b) }}" class="p-2 text-slate-600 hover:text-[#ff5001] hover:bg-orange-100 rounded-lg transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.bidang.destroy', $b) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang ini?');" class="inline">
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
                <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada bidang kepengurusan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
