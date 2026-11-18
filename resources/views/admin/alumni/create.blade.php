@extends('layouts.admin')

@section('title', 'Tambah Data Alumni')
@section('header_title', 'Tambah Data Alumni Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.alumni.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Alumni</span>
        </a>
    </div>

    <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            {{-- 1. NAMA LENGKAP & GELAR --}}
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap &amp; Gelar Alumni *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Ustadz H. Ahmad Al-Ghifari, Lc., M.Ag." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 2. SEGMEN (PUTRA / PUTRI) & TAHUN LULUS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Segmen Kelulusan *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:bg-emerald-50 has-checked:border-[#00843d] has-checked:text-[#00843d] transition">
                            <input type="radio" name="gender" value="putra" {{ old('gender', 'putra') === 'putra' ? 'checked' : '' }} class="accent-[#00843d]">
                            <span class="text-xs font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-mars text-sm"></i>
                                <span>Putra</span>
                            </span>
                        </label>
                        <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:bg-purple-50 has-checked:border-purple-600 has-checked:text-purple-700 transition">
                            <input type="radio" name="gender" value="putri" {{ old('gender') === 'putri' ? 'checked' : '' }} class="accent-purple-600">
                            <span class="text-xs font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-venus text-sm"></i>
                                <span>Putri</span>
                            </span>
                        </label>
                    </div>
                    @error('gender') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="graduation_year" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tahun Lulus (Angkatan) *</label>
                    <input type="number" name="graduation_year" id="graduation_year" required min="1950" max="{{ date('Y') + 1 }}" value="{{ old('graduation_year', date('Y')) }}" placeholder="Contoh: 2024" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition font-bold">
                    <p class="text-[11px] text-slate-400 mt-1">Masukkan 4 digit tahun kelulusan, misal: 2024</p>
                    @error('graduation_year') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- 3. UNIT PENDIDIKAN ASAL --}}
            <div>
                <label for="unit_pendidikan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unit Pendidikan Asal di PPRU</label>
                @if(auth()->user()?->isUnitAdmin())
                    <input type="hidden" name="unit_pendidikan_id" value="{{ auth()->user()->unit_pendidikan_id }}">
                    <div class="w-full bg-emerald-50 text-xs text-[#00843d] font-bold rounded-xl px-4 py-3 border border-emerald-200">
                        {{ auth()->user()->unit?->name ?? 'Unit Saya' }}
                    </div>
                @else
                    <select name="unit_pendidikan_id" id="unit_pendidikan_id" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <option value="">-- Pondok Pesantren Raudhatul Ulum (Umum) --</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}" {{ old('unit_pendidikan_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} {{ $u->short_name ? "({$u->short_name})" : '' }}
                            </option>
                        @endforeach
                    </select>
                @endif
                <p class="text-[11px] text-slate-400 mt-1">Pilih madrasah/sekolah kelulusan alumni di lingkungan Pondok Pesantren.</p>
                @error('unit_pendidikan_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 4. AKTIVITAS / PEKERJAAN / PERKULIAHAN --}}
            <div>
                <label for="activity" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Aktivitas / Pekerjaan / Perkuliahan Setelah Lulus *</label>
                <input type="text" name="activity" id="activity" required value="{{ old('activity') }}" placeholder="Contoh: Mahasiswa S1 Universitas Al-Azhar Kairo / Dokter RSUP Dr. Mohammad Hoesin / Senior Software Engineer" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                <p class="text-[11px] text-slate-400 mt-1">Keterangan profesi, kampus studi lanjutan, instansi kerja, atau usaha yang ditekuni alumni.</p>
                @error('activity') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 5. FOTO ALUMNI --}}
            <div>
                <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Foto Alumni</label>
                <input type="file" name="photo" id="photo" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#00843d] file:text-white hover:file:bg-[#006830]">
                <p class="text-[11px] text-slate-400 mt-1">Format JPG, PNG, atau WebP (maks. 3MB). Disarankan rasio persegi 1:1 atau potret 3:4.</p>
                @error('photo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 6. BIOGRAFI / PESAN ALUMNI --}}
            <div>
                <label for="bio" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profil Singkat / Pesan untuk Almamater &amp; Santri (Opsional)</label>
                <textarea name="bio" id="bio" rows="4" placeholder="Tuliskan biografi singkat, rekam jejak kiprah, atau pesan motivasi alumni untuk santri..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('bio') }}</textarea>
                @error('bio') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 7. KONTAK & URUTAN --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. WhatsApp / HP</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Contoh: 0812-3456-7890" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <label for="social_media" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Instagram / LinkedIn</label>
                    <input type="text" name="social_media" id="social_media" value="{{ old('social_media') }}" placeholder="Contoh: @username / linkedin.com/in/..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <label for="order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            {{-- 8. STATUS PUBLIKASI --}}
            <div class="pt-2">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded text-[#00843d] focus:ring-[#00843d] border-slate-300">
                    <span class="text-xs font-bold text-slate-700">Publikasikan Langsung ke Halaman Data Alumni</span>
                </label>
            </div>

            {{-- TOMBOL SIMPAN --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.alumni.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Simpan Data Alumni</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
