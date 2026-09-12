@extends('layouts.admin')

@section('title', 'Edit Berkas: ' . $download->title)
@section('header_title', 'Edit Berkas Download')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.downloads.index') }}" class="text-xs font-bold text-slate-700 hover:text-slate-950 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Download Center</span>
        </a>
    </div>

    <form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-5">
            
            <div>
                <label for="title" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Nama Berkas / Judul File <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" required value="{{ old('title', $download->title) }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-900 rounded-xl px-4 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_type" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Kategori Berkas <span class="text-red-500">*</span></label>
                    <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs font-semibold text-slate-900 rounded-xl px-4 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition cursor-pointer">
                        <option value="E-Book" {{ old('category_type', $download->category_type) === 'E-Book' ? 'selected' : '' }}>E-Book &amp; Modul Digital</option>
                        <option value="Panduan & Kurikulum" {{ old('category_type', $download->category_type) === 'Panduan & Kurikulum' ? 'selected' : '' }}>Panduan Akademik &amp; Kurikulum</option>
                        <option value="Formulir & Brosur" {{ old('category_type', $download->category_type) === 'Formulir & Brosur' ? 'selected' : '' }}>Formulir PPDB &amp; Brosur</option>
                        <option value="Logo Resmi" {{ old('category_type', $download->category_type) === 'Logo Resmi' ? 'selected' : '' }}>Logo Resmi Sekolah</option>
                        <option value="Lainnya" {{ old('category_type', $download->category_type) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">File Berkas Saat Ini</label>
                    <div class="flex items-center space-x-2 p-2.5 bg-slate-50 rounded-xl border border-slate-200 text-xs truncate">
                        <i class="fa-solid fa-file-circle-check text-[#00913e] shrink-0"></i>
                        <a href="{{ $download->file_path }}" target="_blank" class="font-mono text-blue-600 hover:underline truncate">{{ basename($download->file_path) }}</a>
                        <span class="text-slate-400 text-[11px] shrink-0">({{ $download->file_size ?: 'File' }})</span>
                    </div>
                </div>
            </div>

            {{-- GANTI FILE BERKAS (CHOOSE FILE) --}}
            <div>
                <label for="file" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">
                    Ganti File Berkas (Pilih File Baru - Opsional)
                </label>
                <input type="file" name="file" id="file" class="w-full text-xs text-slate-800 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#da251c] file:text-white hover:file:bg-[#b91c1c] cursor-pointer">
                <p class="text-[11px] text-slate-500 mt-1">Kosongkan jika tidak ingin mengganti file yang sudah ada.</p>
                @error('file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- COVER IMAGE PREVIEW & UPLOAD --}}
            <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-4">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-image text-[#00913e]"></i>
                    <label for="cover_image" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Cover E-Book / Dokumen (Pilih File Gambar)
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row items-start gap-4">
                    @if(!empty($download->cover_image))
                        <div class="w-24 h-32 rounded-xl overflow-hidden border border-emerald-200 shadow-sm shrink-0 bg-white">
                            <img src="{{ asset($download->cover_image) }}" alt="Cover {{ $download->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="space-y-2 flex-1">
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="w-full text-xs text-slate-800 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-white hover:file:bg-black cursor-pointer">
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            Pilih file gambar cover baru (JPG, PNG, atau WebP). Sistem akan otomatis mengonversi gambar ke format <strong>WebP</strong> berkualitas tinggi untuk tampilan di E-Library &amp; Beranda.
                        </p>
                    </div>
                </div>
                @error('cover_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label for="description" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Deskripsi / Sinopsis Singkat</label>
                <textarea name="description" id="description" rows="3" placeholder="Keterangan singkat isi materi atau modul..." class="w-full bg-slate-50 text-xs font-medium text-slate-900 rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">{{ old('description', $download->description) }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.downloads.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-extrabold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
