@extends('layouts.admin')

@section('title', 'Edit Halaman: ' . $page->title)
@section('header_title', 'Edit Halaman: ' . $page->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <span class="text-xs text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/{{ $page->slug }}</code></span>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            
            {{-- Judul Halaman --}}
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $page->title) }}" class="w-full bg-slate-50 text-sm font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Ringkasan Pendek / Excerpt --}}
            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Pendek (Opsional)</label>
                <textarea name="excerpt" id="excerpt" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">{{ old('excerpt', $page->excerpt) }}</textarea>
            </div>

            {{-- RICH TEXT WYSIWYG EDITOR (WordPress Style Toolbox) --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Isi Konten Halaman (Toolbox Lengkap: Bold, Italic, Rata Kiri/Tengah/Kanan/Penuh, Heading, List)
                </label>
                
                {{-- Hidden input that holds HTML value --}}
                <input type="hidden" name="content" id="page_content_input" value="{{ old('content', $page->content) }}">

                {{-- Quill Container --}}
                <div id="page_editor" data-quill="page_content_input" class="bg-white"></div>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SEO Settings for this page --}}
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="font-bold text-sm text-slate-800">Optimasi SEO Halaman</h3>
                
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-600 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Judul pada mesin pencari Google..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001]">
                </div>

                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-600 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi singkat yang muncul di pencarian Google dan share medsos..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001]">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#ff5001] hover:bg-[#e04500] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Halaman</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
