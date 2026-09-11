@extends('layouts.admin')

@section('title', 'Tambah Berkas Download')
@section('header_title', 'Tambah Berkas Download Publik')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.downloads.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Download Center</span>
        </a>
    </div>

    <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Berkas / Judul File *</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Logo Resmi SMA IT Plus Robbani PNG" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0d6b38] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="category_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Berkas *</label>
                <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0d6b38] transition">
                    <option value="Logo Resmi">Logo Resmi Sekolah</option>
                    <option value="Panduan & Kurikulum">Panduan Akademik & Kurikulum</option>
                    <option value="E-Book & Publikasi">Modul Siswa & E-Book</option>
                    <option value="Formulir & Pendaftaran">Formulir PPDB & Administrasi</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                @error('category_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="file" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unggah File (PNG / PDF / ZIP / DOCX)</label>
                <input type="file" name="file" id="file" class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0d6b38] file:text-white hover:file:bg-[#094d28]">
                <p class="text-[11px] text-slate-400 mt-1">Ukuran maksimal file: 20 MB.</p>
                @error('file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="file_path" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Gunakan Tautan / Path File Langsung</label>
                <input type="text" name="file_path" id="file_path" value="{{ old('file_path') }}" placeholder="Contoh: /uploads/logo-robbani.svg" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0d6b38] font-mono">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.downloads.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#0d6b38] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Simpan Berkas Download</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
