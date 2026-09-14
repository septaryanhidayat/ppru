@extends('layouts.admin')

@section('title', 'Edit Program: ' . $dpc->name)
@section('header_title', 'Edit Program: ' . $dpc->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dpc.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Program</span>
        </a>
    </div>

    <form action="{{ route('admin.dpc.update', $dpc) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Program Unggulan *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $dpc->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Program</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $dpc->address) }}" placeholder="Contoh: Tahfidz & Qur'an / Akademik & Riset" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                </div>

                <div>
                    <label for="head_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Koordinator / Penanggung Jawab</label>
                    <input type="text" name="head_name" id="head_name" value="{{ old('head_name', $dpc->head_name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                </div>
            </div>

            {{-- FOTO COVER PROGRAM (THUMBNAIL) --}}
            <div class="p-5 bg-emerald-50/40 rounded-2xl border border-emerald-100 space-y-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="w-28 h-20 rounded-xl overflow-hidden bg-slate-200 border border-slate-300 shrink-0 shadow-sm">
                        <img src="{{ $dpc->thumbnail_url }}" alt="{{ $dpc->name }}" class="w-full h-full object-cover" onerror="this.src='/uploads/activities-robbani.webp'">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-[#00913e] uppercase tracking-wider mb-1">
                            Foto Dokumentasi Program
                        </label>
                        <span class="text-[11px] text-slate-500 block mb-2">Ganti foto cover program unggulan dengan mengunggah gambar baru di bawah ini.</span>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-[#00913e] hover:file:bg-emerald-200 bg-white rounded-xl border border-slate-200 cursor-pointer">
                    </div>
                </div>
                <div>
                    <label for="thumbnail" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Atau Path URL Foto:</label>
                    <input type="text" name="thumbnail" id="thumbnail" value="{{ old('thumbnail', $dpc->thumbnail) }}" placeholder="/uploads/..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Deskripsi &amp; Rincian Kegiatan Program
                </label>
                <input type="hidden" name="description" id="dpc_desc" value="{{ old('description', $dpc->description) }}">
                <div id="dpc_editor" data-quill="dpc_desc" class="bg-white"></div>
            </div>

            <div>
                <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                <input type="number" name="order" id="order" value="{{ old('order', $dpc->order) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.dpc.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
