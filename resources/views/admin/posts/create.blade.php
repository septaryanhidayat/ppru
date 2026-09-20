@extends('layouts.admin')
@php
    $typeTitles = [
        'post' => 'Artikel & Berita',
        'prestasi' => 'Prestasi Siswa',
        'ekskul' => 'Ekstrakurikuler',
        'alumni' => 'Data Alumni',
    ];
    $currentTypeTitle = $typeTitles[$type ?? 'post'] ?? 'Artikel & Berita';
@endphp

@section('title', 'Tambah ' . $currentTypeTitle)
@section('header_title', 'Tambah ' . $currentTypeTitle)

@section('content')
<div class="max-w-5xl bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 sm:p-8">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="type" value="{{ $type ?? 'post' }}">

        {{-- Judul --}}
        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Judul {{ $currentTypeTitle }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Masukkan judul yang informatif dan menarik..." class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition font-medium">
            @error('title') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tanggal Terbit, Status Publikasi, dan Pilihan Penulis --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70">
            {{-- Tanggal Terbit Fleksibel --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="published_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        <i class="fa-regular fa-calendar text-[#00843d] mr-1"></i> Tanggal Terbit
                    </label>
                    <button type="button" onclick="setPublishedAtNow()" class="text-[10px] text-[#00843d] hover:underline font-semibold cursor-pointer">
                        Set Sekarang
                    </button>
                </div>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                <p class="text-[10px] text-slate-400 mt-1">Dapat diatur ke tanggal lampau atau waktu tertentu (WIB).</p>
                @error('published_at') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Status Publikasi --}}
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-signal text-[#00843d] mr-1"></i> Status Publikasi
                </label>
                <select name="status" id="status" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <option value="publish" {{ old('status', 'publish') === 'publish' ? 'selected' : '' }}>Publikasikan Langsung</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                </select>
                <div class="mt-2 flex items-center gap-2">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300 text-[#00843d] focus:ring-[#00843d]">
                    <label for="is_featured" class="text-xs font-semibold text-slate-700 cursor-pointer flex items-center gap-1">
                        <i class="fa-solid fa-thumbtack text-amber-500 text-[11px]"></i>
                        <span>Sematkan Jadi Berita Utama</span>
                    </label>
                </div>
            </div>

            {{-- Penulis / Kontributor --}}
            <div>
                <label for="author_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    <i class="fa-solid fa-user-pen text-[#00843d] mr-1"></i> Penulis / Kontributor
                </label>
                <select name="author_id" id="author_id" class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] mb-2">
                    @foreach($users as $usr)
                        <option value="{{ $usr->id }}" {{ old('author_id', auth()->id()) == $usr->id ? 'selected' : '' }}>
                            {{ $usr->name }} ({{ $usr->role ?? 'Staf' }})
                        </option>
                    @endforeach
                </select>
                <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" placeholder="Atau ketik nama kustom (Opsional)..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-3 py-1.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>
        </div>

        {{-- Featured Image & Takarir Foto --}}
        <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70 space-y-4">
            <div>
                <label for="featured_image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    <i class="fa-regular fa-image text-[#00843d] mr-1"></i> Gambar Utama (Featured Image)
                </label>
                <div class="bg-white border-2 border-dashed border-emerald-200/80 rounded-2xl p-4 text-center hover:bg-emerald-50/30 transition">
                    <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#00843d] file:text-white hover:file:bg-[#006e33] transition cursor-pointer">
                    <p class="text-[11px] text-[#00843d] font-medium mt-2 flex items-center justify-center">
                        <i class="fa-solid fa-wand-magic-sparkles mr-1.5 text-amber-500"></i>
                        Semua gambar otomatis dikonversi ke format <strong>WebP</strong> teroptimasi yang ringan dan tajam.
                    </p>
                </div>
                @error('featured_image') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="featured_image_caption" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Takarir / Keterangan &amp; Sumber Foto (Opsional)
                </label>
                <input type="text" name="featured_image_caption" id="featured_image_caption" value="{{ old('featured_image_caption') }}" placeholder="Contoh: Foto: Dokumentasi Tim Humas PPRU Sakatiga" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>
        </div>

        {{-- Kategori & Tags --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kategori Artikel dengan Inline Quick-Add --}}
            <div class="bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <i class="fa-solid fa-folder-tree text-[#00843d] mr-1"></i> Kategori Artikel
                        </label>
                        <a href="{{ route('admin.categories.index') }}" target="_blank" class="text-[10px] text-[#00843d] hover:underline font-semibold" title="Buka kelola kategori di tab baru">
                            Kelola Kategori &rarr;
                        </a>
                    </div>
                    
                    {{-- Checkbox Kategori --}}
                    <div id="categories-checkbox-list" class="bg-white p-3 rounded-xl border border-slate-200 max-h-48 overflow-y-auto space-y-2 text-xs">
                        @foreach($categories as $cat)
                            @php
                                $isKhutbah = in_array($cat->slug, ['khutbah', 'khutbah-jumat', 'taujih']) || str_contains(strtolower($cat->name), 'khutbah');
                            @endphp
                            <label class="flex items-center justify-between text-slate-700 hover:text-[#00843d] cursor-pointer py-0.5 {{ $isKhutbah ? 'bg-emerald-50/60 p-1.5 rounded-lg border border-emerald-200/80' : '' }}">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}" {{ in_array($cat->id, old('categories', [])) ? 'checked' : '' }} class="rounded border-slate-300 text-[#00843d] focus:ring-[#00843d]">
                                    <span class="font-medium {{ $isKhutbah ? 'text-[#00843d] font-bold' : '' }}">{{ $cat->name }}</span>
                                </div>
                                @if($isKhutbah)
                                    <span class="text-[10px] font-bold text-amber-700 bg-amber-100 border border-amber-300 px-2 py-0.5 rounded-full flex items-center gap-1 shrink-0">
                                        <i class="fa-solid fa-microphone-lines text-[9px]"></i> Otomatis Tampil di Khutbah
                                    </span>
                                @endif
                            </label>
                        @endforeach
                    </div>
                    <p class="text-[11px] text-emerald-700 mt-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        <span>Cukup centang kategori <strong>Khutbah Jum'at</strong> agar tulisan otomatis tampil pada halaman khusus Khutbah.</span>
                    </p>
                </div>

                {{-- Inline Quick Add Kategori Baru --}}
                <div class="mt-3 pt-3 border-t border-slate-200">
                    <label class="block text-[11px] font-bold text-slate-700 mb-1.5 flex items-center gap-1">
                        <i class="fa-solid fa-plus-circle text-[#00843d]"></i>
                        <span>Tambah Kategori Baru Instan:</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="quick_category_name" placeholder="Ketik nama kategori baru..." class="flex-1 bg-white text-xs text-slate-800 rounded-xl px-3 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <button type="button" id="btn_quick_add_cat" onclick="quickAddCategory()" class="bg-[#00843d] hover:bg-[#006e33] text-white font-bold text-xs px-3.5 py-2 rounded-xl transition flex items-center gap-1 shrink-0">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                    <p id="quick_cat_feedback" class="text-[11px] font-semibold mt-1 hidden"></p>
                </div>
            </div>

            {{-- Tags & Excerpt --}}
            <div class="space-y-4 bg-slate-50/70 p-5 rounded-2xl border border-slate-200/70">
                <div>
                    <label for="tags" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-tags text-[#00843d] mr-1"></i> Tag (Pisahkan dengan koma)
                    </label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="Contoh: santri, tahfidz, prestasi, ogan ilir" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <p class="text-[10px] text-slate-400 mt-1">Tag membantu pembaca menemukan topik artikel serupa.</p>
                </div>

                <div>
                    <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-align-left text-[#00843d] mr-1"></i> Ringkasan (Excerpt - Opsional)
                    </label>
                    <textarea name="excerpt" id="excerpt" rows="3" placeholder="Ringkasan singkat untuk tampilan kartu berita. Jika dikosongkan, akan dibuatkan otomatis dari paragraf pertama." class="w-full bg-white text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ old('excerpt') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Konten Artikel dengan WYSIWYG Editor --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                    Isi Konten Artikel <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-3 text-[11px] text-slate-500 font-medium">
                    <span><i class="fa-solid fa-font text-slate-400 mr-1"></i><span id="word_count_display">0 kata</span></span>
                    <span>&bull;</span>
                    <span><i class="fa-regular fa-clock text-[#00843d] mr-1"></i><span id="reading_time_display">1 menit baca</span></span>
                </div>
            </div>
            
            <input type="hidden" name="content" id="post_content_input" value="{{ old('content') }}">
            <div id="post_editor" data-quill="post_content_input" class="bg-white"></div>
            @error('content') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- SEO Meta (Google Snippet Optimization) --}}
        <div class="border border-slate-200 rounded-2xl overflow-hidden bg-slate-50/50">
            <button type="button" onclick="toggleSeoSection()" class="w-full p-4 flex items-center justify-between text-left font-bold text-xs text-slate-800 uppercase tracking-wider hover:bg-slate-100 transition">
                <span class="flex items-center gap-2">
                    <i class="fa-brands fa-google text-blue-600"></i>
                    <span>Optimasi Mesin Pencari (SEO Google) - Opsional</span>
                </span>
                <i id="seo_chevron" class="fa-solid fa-chevron-down text-slate-400 transition transform"></i>
            </button>

            <div id="seo_section_body" class="p-5 border-t border-slate-200 space-y-4 bg-white hidden">
                {{-- Preview Snippet Google --}}
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Pratinjau di Hasil Pencarian Google:</span>
                    <div class="text-xs text-slate-500 font-mono line-clamp-1" id="seo_preview_url">{{ url('/artikel') }}/...</div>
                    <div class="text-sm font-bold text-[#1a0dab] hover:underline cursor-pointer line-clamp-1 mt-0.5" id="seo_preview_title">Judul Artikel Akan Muncul di Sini</div>
                    <div class="text-xs text-[#4d5156] line-clamp-2 mt-1" id="seo_preview_desc">Deskripsi ringkas artikel untuk mesin pencari akan tampil di bagian ini.</div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="meta_title" class="block text-xs font-bold text-slate-700">Meta Title</label>
                        <span id="meta_title_counter" class="text-[10px] text-slate-400">0 / 70 karakter</span>
                    </div>
                    <input type="text" name="meta_title" id="meta_title" maxlength="70" value="{{ old('meta_title') }}" placeholder="Judul khusus SEO Google (bila ingin beda dari judul berita)..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="meta_description" class="block text-xs font-bold text-slate-700">Meta Description</label>
                        <span id="meta_desc_counter" class="text-[10px] text-slate-400">0 / 160 karakter</span>
                    </div>
                    <textarea name="meta_description" id="meta_description" maxlength="160" rows="2" placeholder="Ringkasan informatif maksimal 160 karakter untuk ditampilkan di bawah judul Google..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ old('meta_description') }}</textarea>
                </div>

                <div>
                    <label for="meta_keywords" class="block text-xs font-bold text-slate-700 mb-1">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="pesantren, ppru sakatiga, berita sekolah, pendidikan islam" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex items-center space-x-3 pt-4 border-t border-slate-100">
            <button type="submit" class="bg-[#00843d] hover:bg-[#006e33] text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg transition flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan &amp; Publikasikan</span>
            </button>
            <a href="{{ route('admin.posts.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl font-semibold text-xs transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
// Helper Set Waktu Sekarang untuk Tanggal Terbit
function setPublishedAtNow() {
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('published_at').value = now.toISOString().slice(0, 16);
}

// Inline Quick Add Category via AJAX
function quickAddCategory() {
    const input = document.getElementById('quick_category_name');
    const name = input.value.trim();
    const feedback = document.getElementById('quick_cat_feedback');
    const btn = document.getElementById('btn_quick_add_cat');

    if (!name) {
        feedback.className = 'text-[11px] font-semibold mt-1 text-red-500 block';
        feedback.innerText = 'Ketik nama kategori terlebih dahulu.';
        input.focus();
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-[10px]"></i>';

    fetch('{{ route('admin.categories.quick') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ name: name })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-plus text-[10px]"></i><span>Tambah</span>';

        if (data.success) {
            const list = document.getElementById('categories-checkbox-list');
            
            // Cek apakah checkbox sudah ada di DOM
            let existingCb = list.querySelector(`input[value="${data.category.id}"]`);
            if (existingCb) {
                existingCb.checked = true;
                existingCb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                // Buat item checkbox baru
                const label = document.createElement('label');
                label.className = 'flex items-center space-x-2 text-[#00843d] font-bold cursor-pointer py-0.5 bg-emerald-50/80 px-2 rounded-lg';
                label.innerHTML = `
                    <input type="checkbox" name="categories[]" value="${data.category.id}" checked class="rounded border-slate-300 text-[#00843d] focus:ring-[#00843d]">
                    <span>${data.category.name} <span class="text-[9px] bg-emerald-200 text-emerald-800 px-1 py-0.2 rounded font-mono">Baru</span></span>
                `;
                list.prepend(label);
            }

            input.value = '';
            feedback.className = 'text-[11px] font-semibold mt-1 text-emerald-600 block';
            feedback.innerText = data.message;
            setTimeout(() => { feedback.className = 'hidden'; }, 4000);
        } else {
            feedback.className = 'text-[11px] font-semibold mt-1 text-red-500 block';
            feedback.innerText = data.message || 'Gagal menambahkan kategori.';
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-plus text-[10px]"></i><span>Tambah</span>';
        feedback.className = 'text-[11px] font-semibold mt-1 text-red-500 block';
        feedback.innerText = 'Terjadi kesalahan jaringan.';
    });
}

// Enter key trigger on quick category input
document.getElementById('quick_category_name')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        quickAddCategory();
    }
});

// Toggle SEO Section
function toggleSeoSection() {
    const body = document.getElementById('seo_section_body');
    const chevron = document.getElementById('seo_chevron');
    if (body.classList.contains('hidden')) {
        body.classList.remove('hidden');
        chevron.classList.add('rotate-180');
    } else {
        body.classList.add('hidden');
        chevron.classList.remove('rotate-180');
    }
}

// Update SEO preview on type
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const metaTitleInput = document.getElementById('meta_title');
    const excerptInput = document.getElementById('excerpt');
    const metaDescInput = document.getElementById('meta_description');

    const previewTitle = document.getElementById('seo_preview_title');
    const previewDesc = document.getElementById('seo_preview_desc');
    const titleCounter = document.getElementById('meta_title_counter');
    const descCounter = document.getElementById('meta_desc_counter');

    function syncSeoPreview() {
        const titleText = metaTitleInput.value.trim() || titleInput.value.trim() || 'Judul Artikel Akan Muncul di Sini';
        previewTitle.innerText = titleText;
        titleCounter.innerText = `${metaTitleInput.value.length} / 70 karakter`;

        const descText = metaDescInput.value.trim() || excerptInput.value.trim() || 'Deskripsi ringkas artikel untuk mesin pencari akan tampil di bagian ini.';
        previewDesc.innerText = descText;
        descCounter.innerText = `${metaDescInput.value.length} / 160 karakter`;
    }

    titleInput?.addEventListener('input', syncSeoPreview);
    metaTitleInput?.addEventListener('input', syncSeoPreview);
    excerptInput?.addEventListener('input', syncSeoPreview);
    metaDescInput?.addEventListener('input', syncSeoPreview);

    // Hitung kata & estimasi waktu baca
    setInterval(function() {
        const contentInput = document.getElementById('post_content_input');
        if (contentInput) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = contentInput.value;
            const text = tempDiv.textContent || tempDiv.innerText || '';
            const words = text.trim().split(/\s+/).filter(w => w.length > 0);
            const wordCount = words.length;
            const readingMinutes = Math.max(1, Math.ceil(wordCount / 200));

            const wordDisplay = document.getElementById('word_count_display');
            const timeDisplay = document.getElementById('reading_time_display');
            if (wordDisplay) wordDisplay.innerText = `${wordCount} kata`;
            if (timeDisplay) timeDisplay.innerText = `${readingMinutes} menit baca`;
        }
    }, 1500);
});
</script>
@endsection
