@extends('layouts.admin')

@section('title', 'Edit Bidang: ' . $bidang->name)
@section('header_title', 'Edit Bidang: ' . $bidang->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bidang.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Bidang</span>
        </a>
    </div>

    <form action="{{ route('admin.bidang.update', $bidang) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Bidang *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $bidang->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Deskripsi & Program Kerja (Toolbox: Bold, Italic, Rata Penuh/Kiri/Kanan, List, Link)
                </label>
                <input type="hidden" name="description" id="bidang_desc" value="{{ old('description', $bidang->description) }}">
                <div id="bidang_editor" data-quill="bidang_desc" class="bg-white"></div>
            </div>

            {{-- Preview Icon Saat Ini --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-red-100 text-[#da251c] flex items-center justify-center text-xl shrink-0 overflow-hidden border border-red-200">
                    @if($bidang->is_image_icon)
                        <img src="{{ $bidang->icon }}" alt="{{ $bidang->name }}" class="w-full h-full object-contain p-1.5" onerror="this.src='/uploads/2025/09/logo-thumbnail.webp'">
                    @else
                        <i class="{{ $bidang->icon ?: 'fa-solid fa-users' }}"></i>
                    @endif
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-700 block">Icon Saat Ini</span>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $bidang->icon ?: '(Belum diatur)' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti File Icon (WebP / PNG / SVG)</label>
                    <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-[#da251c] hover:file:bg-red-100 bg-slate-50 rounded-xl border border-slate-200">
                </div>

                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Path Gambar / Class FontAwesome</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', $bidang->icon) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                </div>
            </div>

            {{-- Preset Icon Cepat Fasilitas --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 block uppercase tracking-wider">Pilihan Icon Fasilitas / Bidang:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-laptop-code'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Lab Komputer</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-book-open-reader'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Perpustakaan</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-mosque'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Masjid Kampus</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-hotel'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Asrama Santri</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-flask-vial'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Lab Sains</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-futbol'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Sarana Olahraga</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-heart-pulse'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Klinik UKS</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-utensils'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Kantin Sehat</button>
                </div>
            </div>

            <div>
                <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                <input type="number" name="order" id="order" value="{{ old('order', $bidang->order) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.bidang.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
