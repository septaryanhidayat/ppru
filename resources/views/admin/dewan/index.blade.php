@extends('layouts.admin')

@section('title', 'Dewan Guru & Tenaga Kependidikan')
@section('header_title', 'Dewan Guru & Tenaga Kependidikan (GTK)')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Dewan Guru & Tenaga Pendidik</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola profil guru, foto resmi, mata pelajaran / amanah, dan urutan tampil.</p>
            </div>
            <a href="{{ route('admin.dewan.create') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Tenaga Pendidik</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            @forelse($dewan as $d)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="text-center space-y-3">
                        <div class="w-24 h-24 mx-auto rounded-2xl bg-white p-1 shadow-xs border border-slate-200 overflow-hidden">
                            <img src="{{ $d->photo }}" alt="{{ $d->name }}" class="w-full h-full object-cover object-top rounded-xl" onerror="this.src='/uploads/logo-ishum-square.png'">
                        </div>
                        <div>
                            <h3 class="font-extrabold text-sm text-slate-900">{{ $d->name }}</h3>
                            <span class="inline-block bg-emerald-100 text-[#00913e] text-[10px] font-bold px-2 py-0.5 rounded-full mt-1">
                                {{ $d->position }}
                            </span>
                            <p class="text-[11px] text-slate-500 mt-2 line-clamp-2">{{ $d->fraction ?? 'Dewan Guru & GTK Ishum' }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[10px]">Urutan: #{{ $d->order }}</span>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.dewan.edit', $d) }}" class="p-2 text-slate-600 hover:text-[#ff5001] hover:bg-orange-100 rounded-lg transition" title="Edit Profil">
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
@endsection
