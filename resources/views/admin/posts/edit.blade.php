@extends('layouts.admin')

@php
    $typeTitles = [
        'post' => 'Artikel & Berita',
        'prestasi' => 'Prestasi Siswa',
        'ekskul' => 'Ekstrakurikuler',
        'alumni' => 'Data Alumni',
    ];
    $currentTypeTitle = $typeTitles[$type ?? $post->type ?? 'post'] ?? 'Artikel & Berita';
@endphp

@section('title', 'Edit ' . $currentTypeTitle)
@section('header_title', 'Edit ' . $currentTypeTitle . ': ' . Str::limit($post->title, 40))

@section('content')
<div class="max-w-4xl bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="type" value="{{ $type ?? $post->type ?? 'post' }}">

        {{-- Judul --}}
        <div>
            <label for="title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Judul {{ $currentTypeTitle }} *</label>
            <input type="text" name="title" id="title" required value="{{ old('title', $post->title) }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            @error('title') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Featured Image dengan Preview WebP --}}
        <div>
            <label for="featured_image" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                Ganti Gambar Utama (Featured Image)
            </label>
            @if($post->featured_image)
                <div class="mb-3 flex items-center space-x-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                    <img src="{{ $post->featured_image }}" alt="" class="w-20 h-14 object-cover rounded-lg">
                    <div class="text-xs">
                        <span class="text-gray-500 block">Gambar saat ini (WebP):</span>
                        <span class="font-mono text-[11px] text-gray-800">{{ $post->featured_image }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-red-50/70 border border-dashed border-red-200 rounded-2xl p-5 text-center">
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#da251c] file:text-white hover:file:bg-[#d85c14]">
                <p class="text-[11px] text-[#da251c] font-medium mt-2 flex items-center justify-center">
                    <i class="fa-solid fa-wand-magic-sparkles mr-1.5"></i>
                    Bila mengunggah gambar baru, sistem akan otomatis mengonversinya ke format <strong>WebP</strong>.
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
                            <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }} class="rounded border-gray-300 text-[#da251c] focus:ring-[#da251c]">
                            <span>{{ $cat->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Status Publikasi</label>
                    <select name="status" id="status" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                        <option value="publish" {{ $post->status === 'publish' ? 'selected' : '' }}>Publikasikan</option>
                        <option value="draft" {{ $post->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div>
                    <label for="tags" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tag (Pisahkan dengan koma)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags', $selectedTags) }}" placeholder="kegiatan, baksos" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
            </div>
        </div>

        {{-- Konten Artikel dengan Toolbox WYSIWYG Editor --}}
        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                Isi Konten Artikel (Toolbox Lengkap: Bold, Italic, Rata Kiri/Tengah/Kanan/Penuh, Heading, List) *
            </label>
            <input type="hidden" name="content" id="post_content_input" value="{{ old('content', $post->content) }}">
            <div id="post_editor" data-quill="post_content_input" class="bg-white"></div>
            @error('content') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Excerpt --}}
        <div>
            <label for="excerpt" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Ringkasan (Excerpt)</label>
            <textarea name="excerpt" id="excerpt" rows="2" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex items-center space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-[#da251c] hover:bg-[#d85c14] text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg transition flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Perbarui Artikel</span>
            </button>
            <a href="{{ route('admin.posts.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl font-semibold text-xs transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
