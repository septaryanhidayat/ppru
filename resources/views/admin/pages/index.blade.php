@extends('layouts.admin')

@section('title', 'Kelola Halaman Statis Profil')
@section('header_title', 'Kelola Halaman Statis Profil')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Halaman Profil & Informasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Edit konten narasi, teks sambutan, visi misi, sejarah, struktur, dan kebijakan privasi langsung di sini.</p>
            </div>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4">Judul Halaman</th>
                        <th class="py-3.5 px-4">Slug URL</th>
                        <th class="py-3.5 px-4">Terakhir Diperbarui</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 text-[#ff5001] flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>
                                    <span>{{ $page->title }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-mono text-xs">
                                /{{ $page->slug }}
                            </td>
                            <td class="py-4 px-4 text-slate-400">
                                {{ $page->updated_at ? $page->updated_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center space-x-1.5 bg-[#ff5001] hover:bg-[#e04500] text-white font-bold px-3.5 py-1.5 rounded-xl shadow-xs transition">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    <span>Edit Konten</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-xs text-slate-400">Tidak ada halaman yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection
