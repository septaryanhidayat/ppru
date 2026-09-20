@extends('layouts.admin')

@section('title', 'Tambah Tenaga Pendidik')
@section('header_title', 'Tambah Data Dewan Guru & GTK')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dewan.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Guru</span>
        </a>
    </div>

    <form action="{{ route('admin.dewan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap & Gelar *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: H. M. Ali Akbar, Lc" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="position" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jabatan / Amanah *</label>
                    <input type="text" name="position" id="position" required value="{{ old('position') }}" placeholder="Contoh: Guru Matematika / Pembina Tahfidz" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                    @error('position') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="fraction" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bidang / Fraksi</label>
                    <input type="text" name="fraction" id="fraction" value="{{ old('fraction', auth()->user()?->isUnitAdmin() ? auth()->user()->unit?->short_name : 'Dewan Guru & GTK') }}" placeholder="Contoh: Dewan Guru MARU" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] transition">
                </div>

                <div>
                    <label for="unit_pendidikan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unit Pendidikan</label>
                    @if(auth()->user()?->isUnitAdmin())
                        <input type="hidden" name="unit_pendidikan_id" value="{{ auth()->user()->unit_pendidikan_id }}">
                        <div class="w-full bg-emerald-50 text-xs text-[#00843d] font-bold rounded-xl px-4 py-3 border border-emerald-200">
                            {{ auth()->user()->unit?->name ?? 'Unit Saya' }}
                        </div>
                    @else
                        <select name="unit_pendidikan_id" id="unit_pendidikan_id" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="">-- Pimpinan Yayasan / Umum --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_pendidikan_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div>
                <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Resmi Guru / Tenaga Pendidik</label>
                <input type="file" name="photo" id="photo" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#00913e] file:text-white hover:file:bg-[#094d28]">
                <p class="text-[11px] text-slate-400 mt-1">Disarankan foto rasio potret (portrait) 3:4 atau 1:1 format JPG/PNG/WebP.</p>
                @error('photo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Profil Singkat & Biografi (Toolbox: Bold, Italic, Rata Penuh/Kiri/Kanan, List, Link)
                </label>
                <input type="hidden" name="profile_summary" id="dewan_profile" value="{{ old('profile_summary') }}">
                <div id="dewan_editor" data-quill="dewan_profile" class="bg-white"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="education" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Riwayat Pendidikan</label>
                    <input type="text" name="education" id="education" value="{{ old('education') }}" placeholder="Contoh: S1 Syariah LIPIA Jakarta" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>

                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil (Urutan Nomor)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.dewan.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Anggota Dewan</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
