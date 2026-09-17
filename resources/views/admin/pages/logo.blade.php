@extends('layouts.admin')

@section('title', 'Kelola Konten Dinamis Logo Resmi & Identitas Visual')
@section('header_title', 'Kelola Logo & Identitas Visual')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    {{-- TOP NAVIGATION & STATUS BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <div class="flex items-center space-x-3 text-xs">
            <span class="text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/logo</code></span>
            <a href="{{ route('download.logo') }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold px-3.5 py-1.5 rounded-xl border border-emerald-200 transition shadow-xs" title="Buka Halaman Logo di Web Publik">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>Lihat di Web Publik</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.pages.logo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- CARD 1: HEADER & HERO --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-shapes"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Header &amp; Identitas Logo</h3>
                    <p class="text-xs text-slate-500">Judul, pengantar, dan teks identitas visual pada bagian atas halaman.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header</label>
                    <input type="text" name="logo_hero_badge" value="{{ $settings['logo_hero_badge'] ?? 'Identitas Visual Resmi' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Halaman</label>
                    <input type="text" name="logo_hero_title" value="{{ $settings['logo_hero_title'] ?? 'Logo Resmi Pondok Pesantren Raudhatul Ulum Sakatiga' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hero</label>
                    <textarea name="logo_hero_desc" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['logo_hero_desc'] ?? 'Identitas visual, filosofi lambang sekolah, panduan palet warna, dan aset unduhan resmi Pondok Pesantren Raudhatul Ulum Sakatiga.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 2: PREVIEW LOGO UTAMA & UNDUHAN MASTER HD --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Preview Logo Utama &amp; Unduhan Master HD</h3>
                    <p class="text-xs text-slate-500">Aset gambar logo utama, tautan file asli beresolusi tinggi, dan teks tombol unduh.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Preview</label>
                    <input type="text" name="logo_preview_badge" value="{{ $settings['logo_preview_badge'] ?? 'Identitas Visual Resmi' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Card Logo</label>
                    <input type="text" name="logo_preview_title" value="{{ $settings['logo_preview_title'] ?? 'Logo & Lambang Pondok Pesantren Raudhatul Ulum Sakatiga' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Path Gambar Preview (WebP/PNG)</label>
                    <input type="text" name="logo_preview_image" value="{{ $settings['logo_preview_image'] ?? '/uploads/official/logo-ru-berwarna.png' }}" class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Path File Unduh Master Asli (PNG HD)</label>
                    <input type="text" name="logo_download_url" value="{{ $settings['logo_download_url'] ?? '/uploads/official/master/logo-ru-berwarna.png' }}" class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama File Download Default</label>
                    <input type="text" name="logo_download_filename" value="{{ $settings['logo_download_filename'] ?? 'logo-resmi-ppru-berwarna.png' }}" class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol Unduh Utama</label>
                    <input type="text" name="logo_download_btn_text" value="{{ $settings['logo_download_btn_text'] ?? 'Download Logo Resmi Resolusi Tinggi (Format HD Master PNG)' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Keterangan Spesifikasi File Unduhan</label>
                    <input type="text" name="logo_download_note" value="{{ $settings['logo_download_note'] ?? 'Format Asli Resolusi Ultra HD (2272x2329 px) • Latar Belakang Transparan • Siap Cetak, Spanduk & Desain Grafis' }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unggah File Master Baru (Opsional, PNG/JPG/SVG HD)</label>
                    <input type="file" name="logo_main_file" accept=".png,.jpg,.jpeg,.svg,.webp" class="w-full bg-slate-50 text-xs text-slate-700 rounded-xl p-2.5 border border-slate-200">
                </div>
            </div>
        </div>

        {{-- CARD 3: FILOSOFI LAMBANG SEKOLAH (4 ELEMEN) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Filosofi Lambang Sekolah (4 Komponen)</h3>
                    <p class="text-xs text-slate-500">Ikon FontAwesome, judul komponen lambang, dan makna filosofisnya.</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Filosofi</label>
                <input type="text" name="logo_philo_title" value="{{ $settings['logo_philo_title'] ?? 'Filosofi Lambang Sekolah' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Elemen 1 --}}
                <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200 space-y-2">
                    <span class="text-xs font-black text-[#00843d] uppercase block">Elemen 1: Perisai</span>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 block">Ikon FA</label>
                            <input type="text" name="logo_philo_1_icon" value="{{ $settings['logo_philo_1_icon'] ?? 'fa-shield-halved' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-slate-600 block">Judul Elemen</label>
                            <input type="text" name="logo_philo_1_title" value="{{ $settings['logo_philo_1_title'] ?? 'Perisai Segi Lima' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                    </div>
                    <textarea name="logo_philo_1_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2.5 border border-slate-200">{{ $settings['logo_philo_1_desc'] ?? 'Melambangkan benteng keimanan yang kokoh, rukun Islam, serta kesetiaan pada dasar negara Pancasila.' }}</textarea>
                </div>

                {{-- Elemen 2 --}}
                <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200 space-y-2">
                    <span class="text-xs font-black text-amber-800 uppercase block">Elemen 2: Al-Qur'an</span>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 block">Ikon FA</label>
                            <input type="text" name="logo_philo_2_icon" value="{{ $settings['logo_philo_2_icon'] ?? 'fa-book-quran' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-slate-600 block">Judul Elemen</label>
                            <input type="text" name="logo_philo_2_title" value="{{ $settings['logo_philo_2_title'] ?? 'Mushaf Al-Qur\'an Terbuka' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                    </div>
                    <textarea name="logo_philo_2_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2.5 border border-slate-200">{{ $settings['logo_philo_2_desc'] ?? 'Sumber mata air ilmu pengetahuan, pedoman adab, dan lentera pembimbing setiap langkah santri.' }}</textarea>
                </div>

                {{-- Elemen 3 --}}
                <div class="p-4 rounded-2xl bg-orange-50/50 border border-orange-200 space-y-2">
                    <span class="text-xs font-black text-orange-800 uppercase block">Elemen 3: Obor Sains</span>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 block">Ikon FA</label>
                            <input type="text" name="logo_philo_3_icon" value="{{ $settings['logo_philo_3_icon'] ?? 'fa-fire-flame-curved' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-slate-600 block">Judul Elemen</label>
                            <input type="text" name="logo_philo_3_title" value="{{ $settings['logo_philo_3_title'] ?? 'Obor Sains & Inovasi' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                    </div>
                    <textarea name="logo_philo_3_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2.5 border border-slate-200">{{ $settings['logo_philo_3_desc'] ?? 'Semangat pantang padam dalam mempelajari sains, matematika, teknologi modern, dan riset ilmiah.' }}</textarea>
                </div>

                {{-- Elemen 4 --}}
                <div class="p-4 rounded-2xl bg-yellow-50/50 border border-yellow-200 space-y-2">
                    <span class="text-xs font-black text-yellow-800 uppercase block">Elemen 4: Bintang Emas</span>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 block">Ikon FA</label>
                            <input type="text" name="logo_philo_4_icon" value="{{ $settings['logo_philo_4_icon'] ?? 'fa-star' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-slate-600 block">Judul Elemen</label>
                            <input type="text" name="logo_philo_4_title" value="{{ $settings['logo_philo_4_title'] ?? 'Bintang Emas' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                        </div>
                    </div>
                    <textarea name="logo_philo_4_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2.5 border border-slate-200">{{ $settings['logo_philo_4_desc'] ?? 'Cita-cita prestasi puncak, kemuliaan budi pekerti, dan kepemimpinan PPRU masa depan.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 4: PALET WARNA RESMI (3 WARNA) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Palet Warna Resmi &amp; Filosofi HEX</h3>
                    <p class="text-xs text-slate-500">Nama warna, kode HEX perbankan/desain grafis, dan makna warna.</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Palet Warna</label>
                <input type="text" name="logo_color_title" value="{{ $settings['logo_color_title'] ?? 'Palet Warna Resmi' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Warna 1 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-[#00843d] uppercase block">Warna Utama (Hijau)</span>
                    <input type="text" name="logo_color_1_name" value="{{ $settings['logo_color_1_name'] ?? 'Hijau PPRU (Dominan)' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <input type="text" name="logo_color_1_hex" value="{{ $settings['logo_color_1_hex'] ?? '#0D6B38' }}" class="w-full bg-white text-xs font-mono font-bold text-[#00843d] rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <textarea name="logo_color_1_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['logo_color_1_desc'] ?? 'Kedamaian spiritual, keberkahan ilmu, dan naungan Qur\'ani.' }}</textarea>
                </div>

                {{-- Warna 2 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-orange-600 uppercase block">Warna Sekunder (Oranye)</span>
                    <input type="text" name="logo_color_2_name" value="{{ $settings['logo_color_2_name'] ?? 'Oranye Dinamis (Sekunder)' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <input type="text" name="logo_color_2_hex" value="{{ $settings['logo_color_2_hex'] ?? '#F97316' }}" class="w-full bg-white text-xs font-mono font-bold text-orange-600 rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <textarea name="logo_color_2_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['logo_color_2_desc'] ?? 'Semangat muda, kreativitas, energi riset, dan optimisme prestasi.' }}</textarea>
                </div>

                {{-- Warna 3 --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="text-xs font-bold text-amber-600 uppercase block">Warna Tersier (Emas)</span>
                    <input type="text" name="logo_color_3_name" value="{{ $settings['logo_color_3_name'] ?? 'Emas Prestasi' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <input type="text" name="logo_color_3_hex" value="{{ $settings['logo_color_3_hex'] ?? '#EAB308' }}" class="w-full bg-white text-xs font-mono font-bold text-amber-600 rounded-lg px-2.5 py-1.5 border border-slate-200">
                    <textarea name="logo_color_3_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['logo_color_3_desc'] ?? 'Kemuliaan akhlakul karimah dan prestasi akademik membanggakan.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 5: PAKET 4 VARIAN UNDUHAN RESMI LENGKAP --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Paket 4 Varian Logo Resmi &amp; Unduhan File Asli</h3>
                    <p class="text-xs text-slate-500">Judul varian, preview image, file download master asli PNG, dan teks tombol unduh.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Varian</label>
                    <input type="text" name="logo_variant_title" value="{{ $settings['logo_variant_title'] ?? 'Varian Logo Sekolah Lainnya & Paket Aset Resmi' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subjudul Seksi Varian</label>
                    <input type="text" name="logo_variant_subtitle" value="{{ $settings['logo_variant_subtitle'] ?? 'Seluruh file asli beresolusi tinggi, siap untuk publikasi digital, dokumen resmi, seragam, dan percetakan.' }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Varian 1 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-xs font-black text-blue-700 uppercase block">1. Logo & Branding Lengkap</span>
                    <input type="text" name="logo_var_1_title" value="{{ $settings['logo_var_1_title'] ?? 'Logo & Branding Raudhatul Ulum' }}" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                    <input type="text" name="logo_var_1_format" value="{{ $settings['logo_var_1_format'] ?? 'Format PNG Master Resolusi Tinggi (3375x6000 px)' }}" class="w-full bg-white text-xs text-slate-600 rounded-lg px-3 py-2 border border-slate-200">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="logo_var_1_tag" value="{{ $settings['logo_var_1_tag'] ?? 'Branding Lengkap' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                        <input type="text" name="logo_var_1_btn" value="{{ $settings['logo_var_1_btn'] ?? 'Unduh Master Logo & Branding' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path Gambar Preview</label>
                        <input type="text" name="logo_var_1_image" value="{{ $settings['logo_var_1_image'] ?? '/uploads/official/logo-branding-ru.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path File Asli Download (PNG Master)</label>
                        <input type="text" name="logo_var_1_file" value="{{ $settings['logo_var_1_file'] ?? '/uploads/official/master/logo-branding-ru.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Nama File Unduh</label>
                        <input type="text" name="logo_var_1_filename" value="{{ $settings['logo_var_1_filename'] ?? 'logo-branding-raudhatul-ulum.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                </div>

                {{-- Varian 2 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-xs font-black text-slate-800 uppercase block">2. Branding Monokrom (Hitam-Putih)</span>
                    <input type="text" name="logo_var_2_title" value="{{ $settings['logo_var_2_title'] ?? 'Branding PPRU Monokrom (Hitam-Putih)' }}" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                    <input type="text" name="logo_var_2_format" value="{{ $settings['logo_var_2_format'] ?? 'Format PNG Master Monokrom (3375x4219 px)' }}" class="w-full bg-white text-xs text-slate-600 rounded-lg px-3 py-2 border border-slate-200">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="logo_var_2_tag" value="{{ $settings['logo_var_2_tag'] ?? 'Stempel, Kop & Fotokopi' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                        <input type="text" name="logo_var_2_btn" value="{{ $settings['logo_var_2_btn'] ?? 'Unduh Master Monokrom' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path Gambar Preview</label>
                        <input type="text" name="logo_var_2_image" value="{{ $settings['logo_var_2_image'] ?? '/uploads/official/branding-ru-monokrom.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path File Asli Download (PNG Master)</label>
                        <input type="text" name="logo_var_2_file" value="{{ $settings['logo_var_2_file'] ?? '/uploads/official/master/branding-ru-monokrom.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Nama File Unduh</label>
                        <input type="text" name="logo_var_2_filename" value="{{ $settings['logo_var_2_filename'] ?? 'branding-ppru-monokrom.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                </div>

                {{-- Varian 3 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-xs font-black text-amber-700 uppercase block">3. Logo SPMB / PPDB 2027</span>
                    <input type="text" name="logo_var_3_title" value="{{ $settings['logo_var_3_title'] ?? 'Logo Resmi SPMB / PPDB 2027' }}" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                    <input type="text" name="logo_var_3_format" value="{{ $settings['logo_var_3_format'] ?? 'Format PNG Master Berwarna (3375x4219 px)' }}" class="w-full bg-white text-xs text-slate-600 rounded-lg px-3 py-2 border border-slate-200">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="logo_var_3_tag" value="{{ $settings['logo_var_3_tag'] ?? 'Penerimaan Santri Baru' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                        <input type="text" name="logo_var_3_btn" value="{{ $settings['logo_var_3_btn'] ?? 'Unduh Master Logo SPMB' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path Gambar Preview</label>
                        <input type="text" name="logo_var_3_image" value="{{ $settings['logo_var_3_image'] ?? '/uploads/official/logo-spmb-2027.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path File Asli Download (PNG Master)</label>
                        <input type="text" name="logo_var_3_file" value="{{ $settings['logo_var_3_file'] ?? '/uploads/official/master/logo-spmb-2027.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Nama File Unduh</label>
                        <input type="text" name="logo_var_3_filename" value="{{ $settings['logo_var_3_filename'] ?? 'logo-spmb-ppru-2027.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                </div>

                {{-- Varian 4 --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="text-xs font-black text-emerald-800 uppercase block">4. Logo Emblem Utama Berwarna</span>
                    <input type="text" name="logo_var_4_title" value="{{ $settings['logo_var_4_title'] ?? 'Logo Emblem Utama Berwarna' }}" class="w-full bg-white text-xs font-bold rounded-lg px-3 py-2 border border-slate-200">
                    <input type="text" name="logo_var_4_format" value="{{ $settings['logo_var_4_format'] ?? 'Format PNG Transparan Ultra HD (2272x2329 px)' }}" class="w-full bg-white text-xs text-slate-600 rounded-lg px-3 py-2 border border-slate-200">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="logo_var_4_tag" value="{{ $settings['logo_var_4_tag'] ?? 'Logo Resmi Pesantren' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                        <input type="text" name="logo_var_4_btn" value="{{ $settings['logo_var_4_btn'] ?? 'Unduh Master Logo Emblem' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path Gambar Preview</label>
                        <input type="text" name="logo_var_4_image" value="{{ $settings['logo_var_4_image'] ?? '/uploads/official/logo-ru-berwarna.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Path File Asli Download (PNG Master)</label>
                        <input type="text" name="logo_var_4_file" value="{{ $settings['logo_var_4_file'] ?? '/uploads/official/master/logo-ru-berwarna.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 block">Nama File Unduh</label>
                        <input type="text" name="logo_var_4_filename" value="{{ $settings['logo_var_4_filename'] ?? 'logo-resmi-ppru-berwarna.png' }}" class="w-full bg-white text-xs font-mono rounded-lg px-2.5 py-1.5 border border-slate-200">
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-emerald-700 hover:to-emerald-800 text-white font-bold text-xs px-7 py-3 rounded-xl shadow-lg transition flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Seluruh Konten Logo &amp; Identitas</span>
            </button>
        </div>

    </form>
</div>
@endsection
