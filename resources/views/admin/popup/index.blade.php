@extends('layouts.admin')

@section('title', 'Pengaturan Popup Banner Beranda')
@section('header_title', 'Popup Banner Beranda')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Pengaturan Popup Banner Beranda</h2>
            <p class="text-xs text-slate-500 mt-0.5">Kelola banner promosi atau informasi penting yang muncul saat pengunjung pertama kali membuka halaman beranda.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold text-slate-600 hover:text-[#da251c] bg-white border border-slate-200 hover:bg-slate-50 px-4 py-2 rounded-xl transition flex items-center space-x-1.5 shadow-xs">
            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#da251c]"></i>
            <span>Pratinjau di Beranda</span>
        </a>
    </div>

    <form action="{{ route('admin.popup.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-8">
            
            {{-- SAKELAR AKTIF/NONAKTIF --}}
            <div class="p-5 rounded-2xl {{ $popup['active'] == '1' ? 'bg-emerald-50/80 border-2 border-emerald-300' : 'bg-slate-50 border-2 border-slate-200' }} flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl {{ $popup['active'] == '1' ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/30' : 'bg-slate-300 text-slate-600' }} flex items-center justify-center text-xl flex-shrink-0 transition">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Status Popup Banner di Halaman Beranda</h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            @if($popup['active'] == '1')
                                <span class="text-emerald-700 font-bold"><i class="fa-solid fa-circle-check mr-1"></i> Popup Sedang AKTIF</span> &mdash; Tampil saat pengunjung membuka beranda.
                            @else
                                <span class="text-slate-500 font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i> Popup Sedang NONAKTIF</span> &mdash; Tidak akan muncul di beranda.
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="popup_active" value="1" {{ $popup['active'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#00913e]"></div>
                        <span class="ml-3 text-xs font-bold text-slate-700 select-none">
                            {{ $popup['active'] == '1' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </label>
                </div>
            </div>

            {{-- PREVIEW & UPLOAD GAMBAR BANNER --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 pt-4 border-t border-slate-100">
                <div class="md:col-span-5 space-y-3">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Pratinjau Gambar Banner Saat Ini</label>
                    <div class="rounded-2xl overflow-hidden border-2 border-slate-200 bg-slate-900 shadow-md aspect-square flex items-center justify-center p-2 group relative">
                        <img id="popupPreviewImg" src="{{ asset($popup['image']) }}" alt="Preview Popup" class="max-h-full max-w-full object-contain rounded-xl" onerror="this.onerror=null;this.src='/uploads/logo-ppru-square.png'">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold pointer-events-none">
                            Pratinjau Banner
                        </div>
                    </div>
                    <span class="text-[11px] text-slate-400 block text-center">Rekomendasi rasio: 1:1 (persegi) atau 4:3, format JPG/PNG/WebP maks 5 MB</span>
                </div>

                <div class="md:col-span-7 space-y-5">
                    {{-- Upload File Gambar --}}
                    <div>
                        <label for="popup_image_file" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Ganti Gambar Banner Baru (Choose File)
                        </label>
                        <div class="p-4 bg-emerald-50/50 border-2 border-dashed border-emerald-300 rounded-2xl transition hover:border-[#00913e] hover:bg-emerald-50">
                            <input type="file" name="popup_image_file" id="popup_image_file" accept="image/*" class="w-full text-xs text-slate-700 font-medium file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-[#00913e] file:text-white hover:file:bg-[#007a34] file:cursor-pointer file:shadow-md transition">
                            <p class="text-[11px] text-slate-500 mt-2">Gambar otomatis dikompres dan dikonversi ke format modern WebP.</p>
                        </div>
                    </div>

                    {{-- Judul Popup --}}
                    <div>
                        <label for="popup_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Popup Banner <span class="text-red-500">*</span></label>
                        <input type="text" name="popup_title" id="popup_title" required value="{{ old('popup_title', $popup['title']) }}" placeholder="Contoh: Penerimaan Peserta Didik Baru (PPDB) TP 2026/2027" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    {{-- Subjudul Popup --}}
                    <div>
                        <label for="popup_subtitle" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subjudul / Deskripsi Promo</label>
                        <input type="text" name="popup_subtitle" id="popup_subtitle" value="{{ old('popup_subtitle', $popup['subtitle']) }}" placeholder="Contoh: Potongan Biaya Masuk s.d 50% - Kuota Terbatas!" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    {{-- Teks Tombol CTA & Tautan URL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="popup_button_text" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol Aksi <span class="text-red-500">*</span></label>
                            <input type="text" name="popup_button_text" id="popup_button_text" required value="{{ old('popup_button_text', $popup['button_text']) }}" placeholder="Contoh: Daftar PPDB Sekarang" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>
                        <div>
                            <label for="popup_link" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan URL Tujuan <span class="text-red-500">*</span></label>
                            <input type="text" name="popup_link" id="popup_link" required value="{{ old('popup_link', $popup['link']) }}" placeholder="Contoh: /ppdb atau https://..." class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="submit" class="bg-[#00913e] hover:bg-[#007a34] text-white font-black text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-lg shadow-emerald-500/25 transition cursor-pointer flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Pengaturan Popup Banner</span>
                </button>
            </div>

        </div>
    </form>

</div>

<script>
    document.getElementById('popup_image_file')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.getElementById('popupPreviewImg');
                if (img) img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
