@extends('layouts.admin')

@section('title', 'Edit Pengguna: ' . $user->name)
@section('header_title', 'Edit Pengguna: ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Pengguna</span>
        </a>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Email *</label>
                <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" minlength="8" placeholder="••••••••" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="role" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Peran & Hak Akses (Multi-Role) *</label>
                <select name="role" id="role" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#ff5001] transition">
                    <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>Super Administrator - Hak akses penuh ke seluruh menu dan sistem</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator - Pengelolaan seluruh konten dan pengaturan umum</option>
                    <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor Berita - Mengelola dan menerbitkan artikel berita serta media</option>
                    <option value="author" {{ old('role', $user->role) === 'author' ? 'selected' : '' }}>Penulis / Kontributor - Hanya menulis draf berita baru</option>
                </select>
                @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#ff5001] hover:bg-[#e04500] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Akun</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
