@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')
@section('header_title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Pengguna</span>
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Ahmad Fauzi, S.Pd" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email *</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="nama@domain.com" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password Akun *</label>
                <input type="password" name="password" id="password" required minlength="8" placeholder="Minimal 8 karakter..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran &amp; Hak Akses (Multi-Role) *</label>
                <select name="role" id="role" required onchange="toggleUnitSelect(this.value)" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Administrator - Hak akses penuh ke seluruh menu dan sistem</option>
                    <option value="admin" {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}>Administrator - Pengelolaan seluruh konten dan pengaturan umum</option>
                    <option value="admin_unit" {{ old('role') === 'admin_unit' ? 'selected' : '' }}>Admin Unit Pendidikan - Akses terbatas terisolasi khusus 1 Unit Lembaga</option>
                    <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor Berita - Mengelola dan menerbitkan artikel berita serta media</option>
                    <option value="author" {{ old('role') === 'author' ? 'selected' : '' }}>Penulis / Kontributor - Hanya menulis draf berita baru</option>
                </select>
                @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div id="unit-select-box" class="{{ old('role') === 'admin_unit' ? '' : 'hidden' }}">
                <label for="unit_pendidikan_id" class="block text-xs font-bold text-emerald-800 uppercase tracking-wider mb-2">Pilih Unit Lembaga Pendidikan *</label>
                <select name="unit_pendidikan_id" id="unit_pendidikan_id" class="w-full bg-emerald-50/50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-emerald-300 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                    <option value="">-- Pilih Unit Lembaga Pendidikan --</option>
                    @foreach($units as $u)
                        <option value="{{ $u->id }}" {{ (string) old('unit_pendidikan_id') === (string) $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->short_name }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-emerald-700 mt-1">Akun ini hanya dapat mengelola data profil, berita, foto, dan video khusus untuk unit ini.</p>
                @error('unit_pendidikan_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <script>
                function toggleUnitSelect(val) {
                    const box = document.getElementById('unit-select-box');
                    if (box) {
                        if (val === 'admin_unit') {
                            box.classList.remove('hidden');
                        } else {
                            box.classList.add('hidden');
                        }
                    }
                }
            </script>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Buat Akun Pengguna</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
