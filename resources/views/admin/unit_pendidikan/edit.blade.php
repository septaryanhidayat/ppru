@extends('layouts.admin')

@section('title', 'Edit Unit Pendidikan')
@section('header_title', 'Edit Unit Pendidikan: ' . $unit->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.unit-pendidikan.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Unit Pendidikan</span>
        </a>
    </div>

    <form action="{{ route('admin.unit-pendidikan.update', $unit) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Unit Pendidikan *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $unit->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="short_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Singkatan (Akronim)</label>
                    <input type="text" name="short_name" id="short_name" value="{{ old('short_name', $unit->short_name) }}" placeholder="Contoh: MARU" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="category_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kategori Unit *</label>
                    <select name="category_type" id="category_type" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <option value="Boarding School" {{ old('category_type', $unit->category_type) == 'Boarding School' ? 'selected' : '' }}>Boarding School</option>
                        <option value="Fullday School" {{ old('category_type', $unit->category_type) == 'Fullday School' ? 'selected' : '' }}>Fullday School</option>
                        <option value="Tahfidz Khusus" {{ old('category_type', $unit->category_type) == 'Tahfidz Khusus' ? 'selected' : '' }}>Tahfidz Khusus</option>
                        <option value="Perguruan Tinggi" {{ old('category_type', $unit->category_type) == 'Perguruan Tinggi' ? 'selected' : '' }}>Perguruan Tinggi</option>
                        <option value="Non-Formal" {{ old('category_type', $unit->category_type) == 'Non-Formal' ? 'selected' : '' }}>Non-Formal</option>
                    </select>
                </div>
                <div>
                    <label for="curriculum" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kurikulum / Muadalah</label>
                    <input type="text" name="curriculum" id="curriculum" value="{{ old('curriculum', $unit->curriculum) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Akreditasi / Badge</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $unit->badge) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            {{-- UPLOAD FOTO UTAMA UNIT --}}
            <div class="p-5 bg-emerald-50/40 rounded-2xl border border-emerald-100 space-y-3">
                <label class="block text-xs font-bold text-[#00843d] uppercase tracking-wider">
                    Foto Gedung / Dokumentasi Unit (Thumbnail)
                </label>
                <p class="text-[11px] text-slate-500">Unggah foto dokumentasi unit kegiatan atau gedung sekolah (JPG, PNG, WebP).</p>
                @if($unit->thumbnail)
                    <div class="flex items-center space-x-3 mb-2">
                        <img src="{{ $unit->thumbnail_url }}" alt="Preview" class="h-20 w-32 object-cover rounded-xl border border-emerald-200 shadow-2xs">
                        <span class="text-xs text-slate-500 font-mono break-all">{{ $unit->thumbnail }}</span>
                    </div>
                @endif
                <div>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                    <input type="hidden" name="thumbnail" id="thumbnail" value="{{ old('thumbnail', $unit->thumbnail) }}">
                </div>
            </div>

            {{-- UPLOAD LOGO RESMI UNIT --}}
            <div class="p-5 bg-amber-50/50 rounded-2xl border border-amber-200/80 space-y-3">
                <label class="block text-xs font-bold text-amber-900 uppercase tracking-wider">
                    Logo Resmi Unit Pendidikan (Lambang / Emblem)
                </label>
                <p class="text-[11px] text-slate-500">Logo unit resmi yang akan tampil di beranda &amp; halaman profil unit (PNG transparan/SVG disarankan).</p>
                @if($unit->logo)
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-16 h-16 bg-white rounded-xl p-2 border border-amber-300 shadow-xs flex items-center justify-center">
                            <img src="{{ $unit->logo_url }}" alt="Logo {{ $unit->name }}" class="max-w-full max-h-full object-contain">
                        </div>
                        <span class="text-xs text-slate-500 font-mono break-all">{{ $unit->logo }}</span>
                    </div>
                @endif
                <div>
                    <input type="file" name="logo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-600 file:text-white hover:file:bg-amber-700 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                    <input type="hidden" name="logo" id="logo" value="{{ old('logo', $unit->logo) }}">
                </div>
            </div>

            {{-- UPLOAD HERO BANNER UNIT --}}
            <div class="p-5 bg-sky-50/50 rounded-2xl border border-sky-200/80 space-y-3">
                <label class="block text-xs font-bold text-sky-900 uppercase tracking-wider">
                    Banner Hero Latar Belakang Unit (Header)
                </label>
                <p class="text-[11px] text-slate-500">Banner lanskap lebar resolusi tinggi untuk bagian atas halaman profil unit (JPG, PNG, WebP).</p>
                @if($unit->hero_image)
                    <div class="flex items-center space-x-3 mb-2">
                        <img src="{{ $unit->hero_image_url }}" alt="Hero {{ $unit->name }}" class="h-20 w-40 object-cover rounded-xl border border-sky-300 shadow-2xs">
                        <span class="text-xs text-slate-500 font-mono break-all">{{ $unit->hero_image }}</span>
                    </div>
                @endif
                <div>
                    <input type="file" name="hero_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-700 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                    <input type="hidden" name="hero_image" id="hero_image" value="{{ old('hero_image', $unit->hero_image) }}">
                </div>
            </div>

            {{-- FOTO & DATA KEPALA UNIT --}}
            <div class="p-5 bg-purple-50/40 rounded-2xl border border-purple-200/80 space-y-4">
                <label class="block text-xs font-bold text-purple-900 uppercase tracking-wider">
                    Pimpinan / Kepala Unit Pendidikan
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="head_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kepala / Mudir</label>
                        <input type="text" name="head_name" id="head_name" value="{{ old('head_name', $unit->head_name) }}" placeholder="Contoh: Ustadz Ahmad, M.Pd." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Resmi Kepala Unit</label>
                        @if($unit->head_photo)
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="{{ $unit->head_photo_url }}" alt="Kepala {{ $unit->name }}" class="h-14 w-14 object-cover rounded-xl border border-purple-300 shadow-2xs">
                                <span class="text-[11px] text-slate-500 font-mono truncate max-w-[150px]">{{ $unit->head_photo }}</span>
                            </div>
                        @endif
                        <input type="file" name="head_photo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-700 bg-white rounded-xl border border-slate-200 cursor-pointer shadow-2xs">
                        <input type="hidden" name="head_photo" id="head_photo" value="{{ old('head_photo', $unit->head_photo) }}">
                    </div>
                </div>
                <div>
                    <label for="sambutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Teks Sambutan Kepala / Mudir Unit
                    </label>
                    <textarea name="sambutan" id="sambutan" rows="4" placeholder="Tuliskan kata sambutan resmi kepala unit untuk menyambut santri dan wali..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('sambutan', $unit->sambutan) }}</textarea>
                </div>
            </div>

            {{-- VISI & MISI UNIT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="visi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Visi Unit Pendidikan
                    </label>
                    <textarea name="visi" id="visi" rows="4" placeholder="Visi utama unit..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('visi', $unit->visi) }}</textarea>
                </div>
                <div>
                    <label for="misi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Misi Unit Pendidikan
                    </label>
                    <textarea name="misi" id="misi" rows="4" placeholder="Misi unit (bisa berupa poin-poin)..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('misi', $unit->misi) }}</textarea>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Deskripsi &amp; Profil Lengkap Unit Pendidikan
                </label>
                <input type="hidden" name="description" id="unit_description_input" value="{{ old('description', $unit->description) }}">
                <div id="unit_editor" data-quill="unit_description_input" class="bg-white min-h-[260px] rounded-b-xl border border-slate-200"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Telepon / WhatsApp Unit</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $unit->phone) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label for="website_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan Website Khusus (Opsional)</label>
                    <input type="text" name="website_url" id="website_url" value="{{ old('website_url', $unit->website_url) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ikon FontAwesome</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', $unit->icon) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-mono">
                </div>
                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $unit->order) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="pt-5">
                    <label class="inline-flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $unit->is_active) ? 'checked' : '' }} class="w-4 h-4 text-[#00843d] rounded border-slate-300 focus:ring-[#00843d]">
                        <span class="text-xs font-bold text-slate-700">Tampilkan di Website (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.unit-pendidikan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00843d] hover:bg-[#006830] text-white text-xs font-bold shadow-md transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
