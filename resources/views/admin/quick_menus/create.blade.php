@extends('layouts.admin')

@section('title', 'Tambah Menu Cepat Baru')
@section('header_title', 'Tambah Menu Cepat (Quick Action)')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.quick-menus.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Menu Cepat</span>
        </a>
    </div>

    <form action="{{ route('admin.quick-menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Menu *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Berita, Profil, Aspirasi" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan / Link URL *</label>
                    <input type="text" name="url" id="url" required value="{{ old('url') }}" placeholder="Contoh: /artikel atau https://..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-mono">
                    @error('url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Icon Gambar (WebP / PNG / SVG)</label>
                    <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#00843d] hover:file:bg-emerald-100 bg-slate-50 rounded-xl border border-slate-200">
                </div>

                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Path Gambar / Class FontAwesome</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', 'fa-solid fa-graduation-cap') }}" placeholder="fa-solid fa-graduation-cap atau /uploads/..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] font-mono">
                </div>
            </div>

            {{-- Preset Icon Cepat --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 block uppercase tracking-wider">Pilihan Icon Cepat Bawaan:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-user-tie'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Sambutan</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-school'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Profil</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-chalkboard-user'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Dewan Guru</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-flask'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Fasilitas</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-newspaper'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Berita</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-bullhorn'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Pengumuman</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-video'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Video</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-calendar-days'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00843d] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Agenda</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#00843d]"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700">Tampilkan di Beranda (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.quick-menus.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Menu Cepat</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
