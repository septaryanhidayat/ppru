@extends('layouts.admin')

@section('title', 'Edit DPC: ' . $dpc->name)
@section('header_title', 'Edit DPC: ' . $dpc->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dpc.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar DPC</span>
        </a>
    </div>

    <form action="{{ route('admin.dpc.update', $dpc) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama DPC Kecamatan *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $dpc->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="head_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Ketua DPC</label>
                <input type="text" name="head_name" id="head_name" value="{{ old('head_name', $dpc->head_name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Alamat Sekretariat & Keterangan DPC (Toolbox: Bold, Italic, Rata Penuh/Kiri/Kanan, List, Link)
                </label>
                <input type="hidden" name="address" id="dpc_address" value="{{ old('address', $dpc->address) }}">
                <div id="dpc_editor" data-quill="dpc_address" class="bg-white"></div>
            </div>

            <div>
                <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" name="order" id="order" value="{{ old('order', $dpc->order) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001]">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.dpc.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#ff5001] hover:bg-[#e04500] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
