@extends('layouts.admin')

@section('title', 'Tambah Fasilitas & Sarana Sekolah')
@section('header_title', 'Tambah Fasilitas & Sarana Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bidang.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Fasilitas</span>
        </a>
    </div>

    <form action="{{ route('admin.bidang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Fasilitas Sekolah *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Laboratorium Komputer Multimedia" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- UPLOAD FOTO UTAMA FASILITAS --}}
            <div class="p-5 bg-emerald-50/40 rounded-2xl border border-emerald-100 space-y-3">
                <label class="block text-xs font-bold text-[#00913e] uppercase tracking-wider">
                    Foto Utama Fasilitas Sekolah (Thumbnail)
                </label>
                <p class="text-[11px] text-slate-500">Unggah foto dokumentasi sarana/ruangan (format JPG, PNG, atau WebP). Sistem akan otomatis mengoptimasi gambar ke format WebP.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-[#00913e] hover:file:bg-emerald-200 bg-white rounded-xl border border-slate-200 cursor-pointer">
                    </div>
                    <div>
                        <input type="text" name="thumbnail" id="thumbnail" value="{{ old('thumbnail') }}" placeholder="Atau URL / Path Foto (/uploads/...)" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Deskripsi &amp; Spesifikasi Sarana Prasarana
                </label>
                <input type="hidden" name="description" id="bidang_desc" value="{{ old('description') }}">
                <div id="bidang_editor" data-quill="bidang_desc" class="bg-white"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload File Icon (Opsional)</label>
                    <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#00913e] hover:file:bg-emerald-100 bg-slate-50 rounded-xl border border-slate-200">
                </div>

                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Class FontAwesome Icon</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', 'fa-solid fa-school') }}" placeholder="Contoh: fa-solid fa-laptop-code" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                </div>
            </div>

            {{-- Preset Icon Cepat Fasilitas Sekolah --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 block uppercase tracking-wider">Pilihan Icon Cepat:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-laptop-code'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Lab Komputer</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-book-open-reader'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Perpustakaan</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-mosque'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Masjid Sekolah</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-hotel'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Asrama Santri</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-flask-vial'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Lab Sains / IPA</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-futbol'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Sarana Olahraga</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-heart-pulse'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Klinik UKS</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-utensils'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Kantin Sehat</button>
                </div>
            </div>

            <div>
                <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.bidang.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Fasilitas Baru</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
