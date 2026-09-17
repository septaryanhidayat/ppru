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

        {{-- QUICK ACCESS CARDS UNTUK HALAMAN STATIS KHUSUS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            <a href="{{ route('admin.pages.donasi') }}" class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 hover:border-emerald-400 hover:bg-emerald-100/60 transition group flex flex-col justify-between space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-[#00843d] text-white flex items-center justify-center text-base shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-xs group-hover:text-[#00843d] transition">Halaman Donasi</h3>
                        <span class="text-[10px] text-emerald-800 font-semibold">Rekening &amp; Konfirmasi WA</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-[11px] font-bold text-emerald-700 pt-2 border-t border-emerald-200/60">
                    <span>Edit Rekening &amp; Teks</span>
                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="{{ route('admin.pages.hymne-mars') }}" class="p-4 rounded-2xl bg-rose-50/80 border border-rose-200 hover:border-rose-400 hover:bg-rose-100/60 transition group flex flex-col justify-between space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center text-base shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-xs group-hover:text-rose-700 transition">Mars &amp; Hymne</h3>
                        <span class="text-[10px] text-rose-800 font-semibold">Lirik, Video &amp; Filosofi</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-[11px] font-bold text-rose-700 pt-2 border-t border-rose-200/60">
                    <span>Edit Konten Mars</span>
                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="{{ route('admin.pages.logo') }}" class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200 hover:border-amber-400 hover:bg-amber-100/60 transition group flex flex-col justify-between space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-[#f59e0b] text-slate-950 flex items-center justify-center text-base shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-xs group-hover:text-amber-800 transition">Logo &amp; Identitas</h3>
                        <span class="text-[10px] text-amber-800 font-semibold">Master HD &amp; Palet Warna</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-[11px] font-bold text-amber-700 pt-2 border-t border-amber-200/60">
                    <span>Edit Identitas Visual</span>
                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <a href="{{ route('admin.layanan.content') }}" class="p-4 rounded-2xl bg-teal-50/80 border border-teal-200 hover:border-teal-400 hover:bg-teal-100/60 transition group flex flex-col justify-between space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-700 text-white flex items-center justify-center text-base shadow-sm group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-xs group-hover:text-teal-800 transition">Portal Layanan</h3>
                        <span class="text-[10px] text-teal-800 font-semibold">3 Layanan &amp; Syarat Dokumen</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-[11px] font-bold text-teal-700 pt-2 border-t border-teal-200/60">
                    <span>Kelola Konten Layanan</span>
                    <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>
        </div>

        <div class="overflow-x-auto mt-8">
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
                        @php
                            $editUrl = route('admin.pages.edit', $page);
                            $specialBadge = null;
                            if (in_array($page->slug, ['donasi', 'infaq', 'rekening'])) {
                                $editUrl = route('admin.pages.donasi');
                                $specialBadge = 'Editor Khusus Donasi';
                            } elseif (in_array($page->slug, ['hymne-mars', 'mars-hymne', 'mars-jsit', 'mars'])) {
                                $editUrl = route('admin.pages.hymne-mars');
                                $specialBadge = 'Editor Khusus Mars & Hymne';
                            } elseif (in_array($page->slug, ['logo', 'logo-resmi', 'identitas'])) {
                                $editUrl = route('admin.pages.logo');
                                $specialBadge = 'Editor Khusus Logo & Identitas';
                            } elseif (in_array($page->slug, ['layanan-terpadu', 'layanan-terpadu-2', 'layanan'])) {
                                $editUrl = route('admin.layanan.content');
                                $specialBadge = 'Editor Khusus Layanan';
                            }
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-red-100 text-[#da251c] flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>
                                    <div>
                                        <span>{{ $page->title }}</span>
                                        @if($specialBadge)
                                            <span class="block text-[10px] text-emerald-700 font-semibold mt-0.5"><i class="fa-solid fa-wand-magic-sparkles mr-1"></i>{{ $specialBadge }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-500 font-mono text-xs">
                                <div class="flex items-center space-x-2">
                                    <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-mono text-xs">/{{ $page->slug }}</span>
                                    <a href="{{ $page->public_url }}" target="_blank" class="text-xs text-[#00843d] hover:underline font-bold inline-flex items-center space-x-1" title="Buka Halaman di Web Publik">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-slate-400">
                                {{ $page->updated_at ? $page->updated_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ $page->public_url }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-50 hover:text-[#00843d] text-slate-600 flex items-center justify-center border border-slate-200 transition text-xs shadow-xs" title="Lihat Tampilan Publik">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ $editUrl }}" class="w-8 h-8 rounded-xl bg-[#da251c] hover:bg-[#b91c1c] text-white flex items-center justify-center shadow-xs transition text-xs" title="Edit Konten">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                </div>
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
