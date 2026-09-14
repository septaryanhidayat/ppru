@extends('layouts.admin')

@section('title', 'Download Center')
@section('header_title', 'Download Center & Berkas Publik')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Berkas Publik untuk Diunduh</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola panduan akademik, Logo Resmi PPRU, modul siswa, dan formulir PPDB.</p>
            </div>
            <a href="{{ route('admin.downloads.create') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Tambah Berkas Download</span>
            </a>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4">Nama Berkas</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Format</th>
                        <th class="py-3.5 px-4">Ukuran</th>
                        <th class="py-3.5 px-4 text-center">Diunduh</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($downloads as $file)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-red-100 text-[#da251c] flex items-center justify-center text-sm shadow-xs flex-shrink-0">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="block truncate max-w-xs">{{ $file->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono block truncate max-w-xs">{{ $file->file_path }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    {{ $file->category_type }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-mono text-xs font-semibold text-slate-600">
                                {{ $file->file_type ?: 'FILE' }}
                            </td>
                            <td class="py-4 px-4 text-slate-500">
                                {{ $file->file_size ?: '1.0 MB' }}
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-slate-800">
                                {{ number_format($file->download_count) }}x
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ $file->file_path }}" target="_blank" class="p-2 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Unduh / Buka File">
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </a>
                                    <a href="{{ route('admin.downloads.edit', $file) }}" class="p-2 text-slate-500 hover:text-[#da251c] hover:bg-red-50 rounded-lg transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.downloads.destroy', $file) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-xs text-slate-400">Belum ada file download publik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $downloads->links() }}
        </div>
    </div>
</div>
@endsection
