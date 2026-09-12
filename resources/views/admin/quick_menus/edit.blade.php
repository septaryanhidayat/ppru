@extends('layouts.admin')

@section('title', 'Edit Menu Cepat: ' . $quickMenu->name)
@section('header_title', 'Edit Menu Cepat (Quick Action)')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.quick-menus.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Menu Cepat</span>
        </a>
    </div>

    <form action="{{ route('admin.quick-menus.update', $quickMenu) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Menu *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $quickMenu->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan / Link URL *</label>
                    <input type="text" name="url" id="url" required value="{{ old('url', $quickMenu->url) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] font-mono">
                    @error('url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Preview Icon Saat Ini --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center space-x-4">
                <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-2 shadow-xs">
                    @if($quickMenu->is_image)
                        <img src="{{ $quickMenu->icon }}" alt="{{ $quickMenu->name }}" class="max-h-full max-w-full object-contain">
                    @else
                        <i class="{{ $quickMenu->icon }} text-2xl text-[#da251c]"></i>
                    @endif
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-700 block">Icon Saat Ini</span>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $quickMenu->icon }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ganti File Icon (WebP / PNG / SVG)</label>
                    <input type="file" name="icon_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-[#da251c] hover:file:bg-red-100 bg-slate-50 rounded-xl border border-slate-200">
                </div>

                <div>
                    <label for="icon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Path Gambar / Class FontAwesome</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', $quickMenu->icon) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                </div>
            </div>

            {{-- Preset Icon Cepat --}}
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <span class="text-[11px] font-bold text-slate-600 block uppercase tracking-wider">Pilihan Icon Cepat Bawaan:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-user-tie'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Sambutan</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-school'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Profil</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-chalkboard-user'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Dewan Guru</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-flask'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Fasilitas</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-newspaper'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Berita</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-bullhorn'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Pengumuman</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-video'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Video</button>
                    <button type="button" onclick="document.getElementById('icon').value='fa-solid fa-calendar-days'" class="text-[11px] bg-white hover:bg-emerald-50 hover:text-[#00913e] border border-slate-200 px-3 py-1.5 rounded-lg transition font-medium">Agenda</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (1, 2, 3...)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $quickMenu->order) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>

                <div class="flex items-center space-x-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $quickMenu->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#da251c]"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700">Tampilkan di Beranda (Aktif)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.quick-menus.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
