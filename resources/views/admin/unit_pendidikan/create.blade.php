@extends('layouts.admin')

@section('title', 'Tambah Unit Pendidikan')
@section('header_title', 'Tambah Unit Pendidikan Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.unit-pendidikan.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Unit Pendidikan</span>
        </a>
    </div>

    <form action="{{ route('admin.unit-pendidikan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Unit Pendidikan *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Madrasah Aliyah Raudhatul Ulum" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="short_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Singkatan (Akronim)</label>
                    <input type="text" name="short_name" id="short_name" value="{{ old('short_name') }}" placeholder="Contoh: MARU" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="category_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Unit *</label>
                    <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <option value="Boarding School" {{ old('category_type') == 'Boarding School' ? 'selected' : '' }}>Boarding School</option>
                        <option value="Fullday School" {{ old('category_type') == 'Fullday School' ? 'selected' : '' }}>Fullday School</option>
                        <option value="Tahfidz Khusus" {{ old('category_type') == 'Tahfidz Khusus' ? 'selected' : '' }}>Tahfidz Khusus</option>
                        <option value="Perguruan Tinggi" {{ old('category_type') == 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                        <option value="Non-Formal" {{ old('category_type') == 'Non-Formal' ? 'selected' : '' }}>Non-Formal</option>
                    </select>
                </div>
                <div>
                    <label for="curriculum" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kurikulum / Muadalah</label>
                    <input type="text" name="curriculum" id="curriculum" value="{{ old('curriculum') }}" placeholder="Contoh: Gontor & Kemenag / Al-Azhar" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Akreditasi / Badge</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', 'Terakreditasi A') }}" placeholder="Contoh: Terakreditasi A" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            {{-- UPLOAD FOTO UTAMA UNIT --}}
            <div class="p-5 bg-emerald-50/40 rounded-2xl border border-emerald-100 space-y-3">
                <label class="block text-xs font-bold text-[#00843d] uppercase tracking-wider">
                    Foto Gedung / Dokumentasi Unit (Thumbnail)
                </label>
                <p class="text-[11px] text-slate-500">Unggah foto dokumentasi unit kegiatan atau gedung sekolah (JPG, PNG, WebP).</p>
                <div>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-emerald-800 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                    <input type="hidden" name="thumbnail" id="thumbnail" value="{{ old('thumbnail') }}">
                </div>
            </div>

            {{-- UPLOAD LOGO RESMI UNIT --}}
            <div class="p-5 bg-amber-50/50 rounded-2xl border border-amber-200/80 space-y-3">
                <label class="block text-xs font-bold text-amber-900 uppercase tracking-wider">
                    Logo Resmi Unit Pendidikan (Lambang / Emblem)
                </label>
                <p class="text-[11px] text-slate-500">Logo unit resmi yang akan tampil di beranda &amp; halaman profil unit (PNG transparan/SVG disarankan).</p>
                <div>
                    <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-600 file:text-white hover:file:bg-amber-700 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                    <input type="hidden" name="logo" id="logo" value="{{ old('logo') }}">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Deskripsi &amp; Profil Lengkap Unit Pendidikan
                </label>
                <input type="hidden" name="description" id="unit_description_input" value="{{ old('description') }}">
                <div id="unit_editor" data-quill="unit_description_input" class="bg-white min-h-[260px] rounded-b-xl border border-slate-200"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="head_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kepala Madrasah / Mudir</label>
                    <input type="text" name="head_name" id="head_name" value="{{ old('head_name') }}" placeholder="Nama Pimpinan Unit" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Telepon / WhatsApp Unit</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxx" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label for="website_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan Website Khusus (Opsional)</label>
                    <input type="text" name="website_url" id="website_url" value="{{ old('website_url') }}" placeholder="https://..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ikon FontAwesome</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', 'fa-solid fa-graduation-cap') }}" placeholder="fa-solid fa-graduation-cap" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-mono">
                </div>
                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="pt-5">
                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-4 h-4 text-[#00843d] rounded border-slate-300 focus:ring-[#00843d]">
                        <span class="text-xs font-bold text-slate-700">Tampilkan di Website (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.unit-pendidikan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00843d] hover:bg-[#006830] text-white text-xs font-bold shadow-md transition cursor-pointer">
                    Simpan Unit Pendidikan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
