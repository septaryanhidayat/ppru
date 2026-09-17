@extends('layouts.admin')

@section('title', 'Edit Halaman: ' . $page->title)
@section('header_title', 'Edit Halaman: ' . $page->title)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <div class="flex items-center space-x-3 text-xs">
            <span class="text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/{{ $page->slug }}</code></span>
            <a href="{{ $page->public_url }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold px-3 py-1.5 rounded-xl border border-emerald-200 transition" title="Buka Halaman Publik">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>Lihat di Web Publik</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            
            {{-- Judul Halaman --}}
            <div>
                <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman</label>
                <input type="text" name="title" id="title" required value="{{ old('title', $page->title) }}" class="w-full bg-slate-50 text-sm font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">
                @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Ringkasan Pendek / Excerpt --}}
            <div>
                <label for="excerpt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Pendek (Opsional)</label>
                <textarea name="excerpt" id="excerpt" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] transition">{{ old('excerpt', $page->excerpt) }}</textarea>
            </div>

            @if(in_array($page->slug, ['sambutan', 'sambutan-kepala-sekolah', 'sambutan-mudir']))
                {{-- KHUSUS HALAMAN SAMBUTAN MUDIR: DATA PIMPINAN & FOTO --}}
                <div class="p-6 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-5">
                    <div class="flex items-center space-x-3 pb-3 border-b border-emerald-200/80">
                        <div class="w-9 h-9 rounded-xl bg-[#00843d] text-white flex items-center justify-center text-sm shadow-xs">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Profil Mudir &amp; Identitas Pimpinan Pesantren</h3>
                            <p class="text-[11px] text-emerald-800">Ubah foto, nama, jabatan, kutipan, dan tombol ajakan pada halaman sambutan ini secara dinamis.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Mudir / Pimpinan</label>
                            <input type="text" name="mudir_name" value="{{ old('mudir_name', $settings['mudir_name'] ?? 'KH. Tol\'at Wafa Ahmad, Lc.') }}" class="w-full bg-white text-xs font-semibold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:ring-2 focus:ring-[#00843d]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Resmi</label>
                            <input type="text" name="mudir_position" value="{{ old('mudir_position', $settings['mudir_position'] ?? 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga') }}" class="w-full bg-white text-xs font-semibold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:ring-2 focus:ring-[#00843d]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Badge Sertifikasi / Akreditasi Pimpinan</label>
                            <input type="text" name="mudir_badge" value="{{ old('mudir_badge', $settings['mudir_badge'] ?? 'Muadalah Al-Azhar Kairo & Akreditasi A') }}" class="w-full bg-white text-xs font-semibold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:ring-2 focus:ring-[#00843d]">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Foto Resmi Mudir (JPG/PNG/WEBP)</label>
                            <input type="file" name="mudir_photo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            @if(!empty($settings['mudir_photo']))
                                <p class="text-[10px] text-slate-500 mt-1">Foto aktif saat ini: <a href="{{ $settings['mudir_photo'] }}" target="_blank" class="text-emerald-700 font-bold underline">Lihat Foto</a></p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kutipan / Motto Mudir</label>
                        <textarea name="mudir_quote" rows="2" class="w-full bg-white text-xs rounded-xl p-3 border border-slate-200 focus:ring-2 focus:ring-[#00843d]">{{ old('mudir_quote', $settings['mudir_quote'] ?? '"Mendidik Generasi Khairu Ummah, Berilmu Amaliah, Beramal Ilmiah, dan Berakhlak Qur\'ani."') }}</textarea>
                    </div>

                    {{-- Banner CTA Bawah Sambutan --}}
                    <div class="pt-3 border-t border-emerald-200/80 space-y-3">
                        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider block">Banner Ajakan (CTA) Bawah Halaman Sambutan</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Banner CTA</label>
                                <input type="text" name="sambutan_cta_title" value="{{ old('sambutan_cta_title', $settings['sambutan_cta_title'] ?? 'Penerimaan Santri Baru (PSB Online)') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Singkat CTA</label>
                                <input type="text" name="sambutan_cta_subtitle" value="{{ old('sambutan_cta_subtitle', $settings['sambutan_cta_subtitle'] ?? 'Mari bergabung bersama ribuan santri dari seluruh penjuru nusantara di Pondok Pesantren Raudhatul Ulum Sakatiga.') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tombol 1 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="sambutan_cta_btn1_text" placeholder="Teks Tombol" value="{{ old('sambutan_cta_btn1_text', $settings['sambutan_cta_btn1_text'] ?? 'Daftar PPDB & PSB Online') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                                    <input type="text" name="sambutan_cta_btn1_url" placeholder="URL Target" value="{{ old('sambutan_cta_btn1_url', $settings['sambutan_cta_btn1_url'] ?? '/ppdb') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Tombol 2 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="sambutan_cta_btn2_text" placeholder="Teks Tombol" value="{{ old('sambutan_cta_btn2_text', $settings['sambutan_cta_btn2_text'] ?? 'Hubungi Kami') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                                    <input type="text" name="sambutan_cta_btn2_url" placeholder="URL Target" value="{{ old('sambutan_cta_btn2_url', $settings['sambutan_cta_btn2_url'] ?? '/hubungi') }}" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-200">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- RICH TEXT WYSIWYG EDITOR (WordPress Style Toolbox) --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Isi Konten Halaman (Toolbox Lengkap: Bold, Italic, Rata Kiri/Tengah/Kanan/Penuh, Heading, List)
                </label>
                
                {{-- Hidden input that holds HTML value --}}
                <input type="hidden" name="content" id="page_content_input" value="{{ old('content', $page->content) }}">

                {{-- Quill Container --}}
                <div id="page_editor" data-quill="page_content_input" class="bg-white"></div>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SEO Settings for this page --}}
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <h3 class="font-bold text-sm text-slate-800">Optimasi SEO Halaman</h3>
                
                <div>
                    <label for="meta_title" class="block text-xs font-semibold text-slate-600 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" placeholder="Judul pada mesin pencari Google..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>

                <div>
                    <label for="meta_description" class="block text-xs font-semibold text-slate-600 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi singkat yang muncul di pencarian Google dan share medsos..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan Halaman</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
