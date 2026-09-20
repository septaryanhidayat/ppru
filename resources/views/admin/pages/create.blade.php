@extends('layouts.admin')

@section('title', 'Tambah Halaman Baru')
@section('header_title', 'Buat Halaman Informasi / Profil Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
    </div>

    <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            
            {{-- Judul Halaman --}}
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman *</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Tata Tertib Santri / Fasilitas Asrama" class="w-full bg-slate-50 text-sm font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Slug URL --}}
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Slug URL (Opsional / Otomatis dibuat)</label>
                <div class="flex items-center">
                    <span class="bg-slate-100 text-slate-500 px-3.5 py-3 rounded-l-xl border border-r-0 border-slate-200 text-xs font-mono">/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="tata-tertib-santri" class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-r-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika ingin dibuat otomatis dari judul halaman.</p>
                @error('slug') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Ringkasan Pendek / Excerpt --}}
            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Pendek (Opsional)</label>
                <textarea name="excerpt" id="excerpt" rows="2" placeholder="Ringkasan singkat isi halaman..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">{{ old('excerpt') }}</textarea>
            </div>

            {{-- Status Publish --}}
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Publikasi</label>
                <select name="status" id="status" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    <option value="publish" {{ old('status') === 'publish' ? 'selected' : '' }}>Publikasikan Langsung (Publish)</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                </select>
            </div>

            {{-- WYSIWYG Editor --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Isi Konten Halaman (Editor Lengkap)
                </label>
                
                <input type="hidden" name="content" id="page_content_input" value="{{ old('content') }}">
                <div id="page_editor" data-quill="page_content_input" class="bg-white min-h-[300px]"></div>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SEO Settings --}}
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="font-bold text-sm text-slate-800">Pengaturan SEO (Mesin Pencari Google)</h3>
                
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-600 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" placeholder="Judul pencarian Google..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>

                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-600 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi ringkas untuk snippet hasil pencarian Google..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Halaman Baru</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
