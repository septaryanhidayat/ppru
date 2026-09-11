@extends('layouts.admin')

@section('title', 'Edit Berkas: ' . $download->title)
@section('header_title', 'Edit Berkas Download')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.downloads.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Download Center</span>
        </a>
    </div>

    <form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Berkas / Judul File *</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $download->title) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="category_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Berkas *</label>
                <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0d6b38] transition">
                    <option value="Logo Resmi" {{ old('category_type', $download->category_type) === 'Logo Resmi' ? 'selected' : '' }}>Logo Resmi Sekolah</option>
                    <option value="Panduan & Kurikulum" {{ old('category_type', $download->category_type) === 'Panduan & Kurikulum' ? 'selected' : '' }}>Panduan Akademik & Kurikulum</option>
                    <option value="E-Book & Publikasi" {{ old('category_type', $download->category_type) === 'E-Book & Publikasi' ? 'selected' : '' }}>Modul Siswa & E-Book</option>
                    <option value="Formulir & Pendaftaran" {{ old('category_type', $download->category_type) === 'Formulir & Pendaftaran' ? 'selected' : '' }}>Formulir PPDB & Administrasi</option>
                    <option value="Lainnya" {{ old('category_type', $download->category_type) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">File Saat Ini</label>
                <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-xl border border-slate-200 mb-3 text-xs">
                    <i class="fa-solid fa-file-check text-[#0d6b38]"></i>
                    <a href="{{ $download->file_path }}" target="_blank" class="font-mono text-blue-600 hover:underline truncate">{{ $download->file_path }}</a>
                    <span class="text-slate-400">({{ $download->file_size }})</span>
                </div>
                <label for="file" class="block text-[11px] font-semibold text-slate-600 mb-1">Ganti File Baru (Opsional)</label>
                <input type="file" name="file" id="file" class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#ff5001] file:text-white hover:file:bg-[#e04500]">
                @error('file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="file_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Ubah Tautan Langsung</label>
                <input type="text" name="file_path" id="file_path" value="{{ old('file_path', $download->file_path) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] font-mono">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.downloads.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#ff5001] hover:bg-[#e04500] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
