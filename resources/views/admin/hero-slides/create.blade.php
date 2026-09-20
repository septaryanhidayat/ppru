@extends('layouts.admin')

@section('title', 'Tambah Banner Hero Baru')
@section('header_title', 'Tambah Banner Hero Slider')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.hero-slides.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Slide</span>
        </a>
    </div>

    <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        @csrf

        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-black text-slate-800">Form Slide Banner Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Teks, gambar, dan tombol aksi yang akan tampil pada rotasi carousel di beranda website.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Badge Kecil Atas --}}
            <div class="md:col-span-2">
                <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Badge Kecil (Atas Judul)</label>
                <input type="text" name="badge" id="badge" value="{{ old('badge', 'Pondok Pesantren Raudhatul Ulum Sakatiga') }}" placeholder="Contoh: Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            {{-- Judul Utama --}}
            <div class="md:col-span-2">
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Utama Slide <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Contoh: Basis Kaderisasi Generasi Terbaik (Khoiru Ummah)" class="w-full bg-slate-50 text-sm font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Subjudul / Narasi --}}
            <div class="md:col-span-2">
                <label for="subtitle" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Subjudul / Deskripsi Pendek</label>
                <textarea name="subtitle" id="subtitle" rows="3" placeholder="Deskripsi ringkas yang memperjelas pesan slide..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ old('subtitle') }}</textarea>
            </div>

            {{-- Upload Foto --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Upload Foto Banner (JPG/PNG/WEBP)</label>
                <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-[#00843d] hover:file:bg-emerald-100 bg-slate-50 rounded-xl border border-slate-200 cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-1">Disarankan resolusi minimal 1920x800 px (otomatis dikonversi ke WebP).</p>
            </div>

            {{-- Path Gambar / Fallback --}}
            <div>
                <label for="image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atau Path Gambar Tersedia</label>
                <input type="text" name="image" id="image" value="{{ old('image', '/uploads/official/drone-raudhatul-ulum.webp') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-mono">
            </div>

            {{-- Tombol Utama (Primary) --}}
            <div>
                <label for="btn_primary_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Tombol Utama (Kuning Emas)</label>
                <input type="text" name="btn_primary_text" id="btn_primary_text" value="{{ old('btn_primary_text', 'Profil Singkat Pesantren') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div>
                <label for="btn_primary_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tautan URL Tombol Utama</label>
                <input type="text" name="btn_primary_url" id="btn_primary_url" value="{{ old('btn_primary_url', '/tentang-kami') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            {{-- Tombol Kedua (Secondary) --}}
            <div>
                <label for="btn_secondary_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Teks Tombol Kedua (Hijau)</label>
                <input type="text" name="btn_secondary_text" id="btn_secondary_text" value="{{ old('btn_secondary_text', 'Pendaftaran PSB') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div>
                <label for="btn_secondary_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tautan URL Tombol Kedua</label>
                <input type="text" name="btn_secondary_url" id="btn_secondary_url" value="{{ old('btn_secondary_url', '/ppdb') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            {{-- Urutan & Status --}}
            <div>
                <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Urutan Tampil</label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div class="flex items-center space-x-3 pt-6">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 rounded-md border-slate-300 focus:ring-[#00843d]">
                <label for="is_active" class="text-xs font-bold text-slate-700">Aktifkan Slide di Beranda</label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.hero-slides.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00843d] hover:bg-[#006e33] text-white text-xs font-bold shadow-md shadow-emerald-500/20 transition">Simpan Slide</button>
        </div>
    </form>
</div>
@endsection
