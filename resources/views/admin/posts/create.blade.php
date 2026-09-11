@extends('layouts.admin')

@section('title', 'Tambah Artikel Baru')
@section('header_title', 'Tulis Artikel Baru')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Judul --}}
        <div>
            <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Judul Artikel *</label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Masukkan judul artikel yang menarik..." class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f37023]">
            @error('title') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Featured Image dengan Auto-WebP --}}
        <div>
            <label for="featured_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Gambar Utama (Featured Image)
            </label>
            <div class="bg-orange-50/70 border border-dashed border-orange-200 rounded-2xl p-5 text-center">
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#f37023] file:text-white hover:file:bg-[#d85c14]">
                <p class="text-[11px] text-[#f37023] font-medium mt-2 flex items-center justify-center">
                    <i class="fa-solid fa-wand-magic-sparkles mr-1.5"></i>
                    Semua gambar yang diunggah akan otomatis dikonversi ke format <strong>WebP</strong> berukuran ringan dengan kualitas tajam.
                </p>
            </div>
            @error('featured_image') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori & Status --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kategori Artikel</label>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 max-h-44 overflow-y-auto space-y-2 text-xs">
                    @foreach($categories as $cat)
                        <label class="flex items-center space-x-2 text-gray-700 cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}" class="rounded border-gray-300 text-[#f37023] focus:ring-[#f37023]">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Status Publikasi</label>
                    <select name="status" id="status" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f37023]">
                        <option value="publish">Publikasikan Langsung</option>
                        <option value="draft">Simpan Sebagai Draft</option>
                    </select>
                </div>

                <div>
                    <label for="tags" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tag (Pisahkan dengan koma)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="kegiatan, baksos, ogan ilir" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f37023]">
                </div>
            </div>
        </div>

        {{-- Konten Artikel dengan Toolbox WYSIWYG Editor --}}
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Isi Konten Artikel (Toolbox Lengkap: Bold, Italic, Rata Kiri/Tengah/Kanan/Penuh, Heading, List) *
            </label>
            <input type="hidden" name="content" id="post_content_input" value="{{ old('content') }}">
            <div id="post_editor" data-quill="post_content_input" class="bg-white"></div>
            @error('content') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Excerpt --}}
        <div>
            <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Ringkasan (Excerpt - Opsional)</label>
            <textarea name="excerpt" id="excerpt" rows="2" placeholder="Ringkasan singkat untuk tampilan kartu..." class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f37023]">{{ old('excerpt') }}</textarea>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-[#f37023] hover:bg-[#d85c14] text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg transition flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Artikel</span>
            </button>
            <a href="{{ route('admin.posts.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold text-xs transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
