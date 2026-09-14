@extends('layouts.admin')

@section('title', 'Tambah Berkas Download')
@section('header_title', 'Tambah Berkas Download Publik')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.downloads.index') }}" class="text-xs font-bold text-slate-700 hover:text-slate-950 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Download Center</span>
        </a>
    </div>

    <form action="{{ route('admin.downloads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-5">
            
            <div>
                <label for="title" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Nama Berkas / Judul File <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Modul Tahfidz Qur'an Santri SMA IT PPRU..." class="w-full bg-slate-50 text-xs font-semibold text-slate-900 rounded-xl px-4 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_type" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Kategori Berkas <span class="text-red-500">*</span></label>
                    <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs font-semibold text-slate-900 rounded-xl px-4 py-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition cursor-pointer">
                        <option value="E-Book" {{ old('category_type') == 'E-Book' ? 'selected' : '' }}>E-Book &amp; Modul Digital</option>
                        <option value="Panduan & Kurikulum" {{ old('category_type') == 'Panduan & Kurikulum' ? 'selected' : '' }}>Panduan Akademik &amp; Kurikulum</option>
                        <option value="Formulir & Brosur" {{ old('category_type') == 'Formulir & Brosur' ? 'selected' : '' }}>Formulir PPDB &amp; Brosur</option>
                        <option value="Logo Resmi" {{ old('category_type') == 'Logo Resmi' ? 'selected' : '' }}>Logo Resmi Sekolah</option>
                        <option value="Lainnya" {{ old('category_type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category_type') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="file" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Pilih File Berkas (PDF / DOCX / ZIP) <span class="text-red-500">*</span></label>
                    <input type="file" name="file" id="file" required class="w-full text-xs text-slate-800 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-[#094d28] cursor-pointer">
                    <p class="text-[11px] text-slate-500 mt-1">Ukuran maksimal file: 30 MB.</p>
                    @error('file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- UPLOAD GAMBAR COVER (UNTUK E-BOOK / MODUL) --}}
            <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-3">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-image text-[#00913e]"></i>
                    <label for="cover_image" class="block text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Unggah Gambar Cover (Khusus E-Book / Buku Digital)
                    </label>
                </div>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" class="w-full text-xs text-slate-800 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-white hover:file:bg-black cursor-pointer">
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Pilih file gambar cover sampul buku (JPG, PNG, atau WebP). Sistem akan otomatis mengonversi ke format <strong>WebP</strong> berkualitas tinggi untuk tampilan di E-Library &amp; slider Beranda.
                </p>
                @error('cover_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Deskripsi / Sinopsis Singkat (Opsional)</label>
                <textarea name="description" id="description" rows="3" placeholder="Tuliskan keterangan singkat isi modul/dokumen ini..." class="w-full bg-slate-50 text-xs font-medium text-slate-900 rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.downloads.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-extrabold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Simpan Berkas Download</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
