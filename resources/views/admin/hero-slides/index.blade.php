@extends('layouts.admin')

@section('title', 'Kelola Banner Hero Slider Beranda')
@section('header_title', 'Kelola Banner Hero Slider')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Banner Hero Slider Beranda</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola banner slider utama di bagian paling atas beranda: gambar, teks judul, tombol, dan tautan.</p>
            </div>
            <a href="{{ route('admin.hero-slides.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-[#006e33] hover:to-[#04883b] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-500/20 transition transform hover:scale-102">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Slide Baru</span>
            </a>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">Urutan</th>
                        <th class="py-3.5 px-4 w-32">Preview Foto</th>
                        <th class="py-3.5 px-4">Judul &amp; Subtitle</th>
                        <th class="py-3.5 px-4">Tombol 1 &amp; 2</th>
                        <th class="py-3.5 px-4 w-24 text-center">Status</th>
                        <th class="py-3.5 px-4 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($slides as $slide)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="py-4 px-4 text-center font-bold text-slate-500">
                            #{{ $slide->order }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="w-28 h-16 rounded-xl overflow-hidden shadow-xs border border-slate-200 bg-slate-100 relative group">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="py-4 px-4 max-w-xs sm:max-w-md">
                            @if($slide->badge)
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-1">
                                    {{ $slide->badge }}
                                </span>
                            @endif
                            <h3 class="font-black text-slate-900 text-sm leading-snug line-clamp-1">{{ $slide->title }}</h3>
                            <p class="text-slate-500 text-[11px] line-clamp-2 mt-0.5 leading-relaxed">{{ $slide->subtitle }}</p>
                        </td>
                        <td class="py-4 px-4">
                            <div class="space-y-1 text-[11px]">
                                <div class="flex items-center space-x-1 font-semibold text-amber-700">
                                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    <span>{{ $slide->btn_primary_text }}</span>
                                    <span class="text-slate-400 font-normal">({{ $slide->btn_primary_url }})</span>
                                </div>
                                @if($slide->btn_secondary_text)
                                <div class="flex items-center space-x-1 text-emerald-700">
                                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    <span>{{ $slide->btn_secondary_text }}</span>
                                    <span class="text-slate-400 font-normal">({{ $slide->btn_secondary_url }})</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            @if($slide->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 flex items-center justify-center transition" title="Edit Slide">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </a>
                                <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slide ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition cursor-pointer" title="Hapus Slide">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-images text-3xl mb-2 text-slate-300 block"></i>
                            <span>Belum ada slide hero. Klik tombol "Tambah Slide Baru" di atas.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
