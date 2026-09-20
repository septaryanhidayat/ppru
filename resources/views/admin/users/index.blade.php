@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Multi-Role')
@section('header_title', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Pengguna Administrator</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola akun staf, 8 admin unit terisolasi, dan hak akses multi-role sistem.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-user-plus"></i>
                <span>Tambah Pengguna Baru</span>
            </a>
        </div>

        {{-- Filter Pills: Semua / Global Admin / 8 Admin Unit --}}
        <div class="flex flex-wrap items-center gap-2 pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 {{ empty($roleFilter) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-solid fa-users text-[10px]"></i>
                <span>Semua Pengguna</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ empty($roleFilter) ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $counts['all'] ?? $users->total() }}</span>
            </a>

            <a href="{{ route('admin.users.index', ['role' => 'admin_unit']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 {{ $roleFilter === 'admin_unit' ? 'bg-[#00843d] text-white shadow-xs' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200/80' }}">
                <i class="fa-solid fa-graduation-cap text-[10px] {{ $roleFilter === 'admin_unit' ? 'text-amber-300' : 'text-emerald-600' }}"></i>
                <span>8 Admin Unit Terisolasi</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $roleFilter === 'admin_unit' ? 'bg-white/20 text-white' : 'bg-emerald-200 text-emerald-900' }}">{{ $counts['unit'] ?? 8 }}</span>
            </a>

            <a href="{{ route('admin.users.index', ['role' => 'global']) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 {{ $roleFilter === 'global' ? 'bg-purple-700 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <i class="fa-solid fa-shield-halved text-[10px] text-purple-400"></i>
                <span>Admin Utama &amp; Staf</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $roleFilter === 'global' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $counts['global'] ?? 0 }}</span>
            </a>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4">Nama Pengguna</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Peran (Role)</th>
                        <th class="py-3.5 px-4">Cakupan / Unit Lembaga</th>
                        <th class="py-3.5 px-4">Terdaftar</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl {{ $user->role === 'admin_unit' ? 'bg-gradient-to-tr from-[#00843d] to-emerald-600' : 'bg-gradient-to-tr from-[#da251c] to-rose-600' }} text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="ml-1 text-[10px] bg-emerald-100 text-emerald-800 px-1.5 py-0.5 rounded font-bold">Akun Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-600 font-mono text-xs">
                                {{ $user->email }}
                            </td>
                            <td class="py-4 px-4">
                                @if($user->role === 'super_admin')
                                    <span class="bg-purple-100 text-purple-800 text-[11px] px-2.5 py-1 rounded-full font-bold">Super Admin</span>
                                @elseif($user->role === 'admin')
                                    <span class="bg-red-100 text-[#da251c] text-[11px] px-2.5 py-1 rounded-full font-bold">Administrator</span>
                                @elseif($user->role === 'admin_unit')
                                    <span class="bg-emerald-100 text-emerald-800 text-[11px] px-2.5 py-1 rounded-full font-bold flex items-center w-fit space-x-1">
                                        <i class="fa-solid fa-lock text-[9px] text-emerald-600"></i>
                                        <span>Admin Unit: {{ $user->unit?->short_name ?: 'Unit' }}</span>
                                    </span>
                                @elseif($user->role === 'editor')
                                    <span class="bg-blue-100 text-blue-800 text-[11px] px-2.5 py-1 rounded-full font-bold">Editor Berita</span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 text-[11px] px-2.5 py-1 rounded-full font-bold">Penulis / Kontributor</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($user->unit)
                                    <div class="flex items-center space-x-1.5">
                                        <i class="fa-solid fa-graduation-cap text-[#00843d] text-xs"></i>
                                        <span class="font-bold text-slate-800">{{ $user->unit->name }}</span>
                                    </div>
                                @elseif($user->role === 'admin_unit')
                                    <span class="text-amber-600 font-semibold text-xs">Belum dihubungkan</span>
                                @else
                                    <span class="text-slate-400 text-xs">Semua Unit (Global Admin)</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-slate-400 text-xs">
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-500 hover:text-[#00843d] hover:bg-emerald-50 rounded-lg transition" title="Edit Akun">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Akun">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-xs text-slate-400">Belum ada pengguna terdaftar untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
