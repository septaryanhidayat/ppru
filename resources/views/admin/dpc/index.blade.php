@extends('layouts.admin')

@section('title', 'Program Unggulan Sekolah')
@section('header_title', 'Program Unggulan SMA IT Plus Robbani')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Program Unggulan Sekolah</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola program unggulan, koordinator program, dan deskripsi kegiatan.</p>
            </div>
            <a href="{{ route('admin.dpc.create') }}" class="inline-flex items-center space-x-2 bg-[#0d6b38] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Program Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($dpcs as $d)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-base flex-shrink-0">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-extrabold text-sm text-slate-900 truncate">{{ $d->name }}</h3>
                                <p class="text-xs text-[#ff5001] font-semibold mt-0.5"><i class="fa-solid fa-user-check text-[10px] mr-1"></i>{{ $d->head_name ?: 'Belum ditentukan' }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-2"><i class="fa-solid fa-location-dot text-slate-400 mr-1.5"></i>{{ $d->address ?: 'Alamat belum diatur' }}</p>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[10px]">Urutan: #{{ $d->order }}</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.dpc.edit', $d) }}" class="p-2 text-slate-600 hover:text-[#ff5001] hover:bg-orange-100 rounded-lg transition" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.dpc.destroy', $d) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data DPC ini?');" class="inline">
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
                <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada data DPC kecamatan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
