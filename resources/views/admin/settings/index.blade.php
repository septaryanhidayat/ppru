@extends('layouts.admin')

@section('title', 'Pengaturan Website & SEO')
@section('header_title', 'Pengaturan Website, SEO & OpenGraph')

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- Info Card --}}
    <div class="bg-gradient-to-r from-[#00913e] to-[#05a849] rounded-2xl p-6 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center text-2xl shrink-0">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <div>
                <h3 class="text-base font-bold">Pusat Konfigurasi & Optimasi Website Sekolah</h3>
                <p class="text-xs text-emerald-100">Kelola identitas sekolah, informasi kontak, serta pengaturan SEO & OpenGraph untuk berbagi ke WhatsApp & medsos.</p>
            </div>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-white/15 hover:bg-white/25 text-white rounded-xl text-xs font-semibold transition flex items-center space-x-2 shrink-0">
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            <span>Lihat Website</span>
        </a>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 1. PENGATURAN SEO & SOCIAL SHARE OPENGRAPH --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">1</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">SEO & Social Share (OpenGraph)</h2>
                        <p class="text-[11px] text-gray-500">Tampilan saat link website dibagikan ke WhatsApp, Telegram, Facebook, dan X/Twitter</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200">
                    <i class="fa-solid fa-share-nodes mr-1.5"></i> Social Ready
                </span>
            </div>

            <div class="p-6 space-y-6">
                {{-- Live Social Share Simulator --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        <i class="fa-brands fa-whatsapp text-green-600 mr-1"></i> Preview Tampilan Share WhatsApp / Facebook
                    </label>
                    <div class="max-w-md bg-slate-50 rounded-2xl border border-gray-200 p-3.5 shadow-sm">
                        <div class="rounded-xl overflow-hidden border border-gray-200 bg-white">
                            <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden relative">
                                <img id="ogPreviewImg" src="{{ asset($settings['og_image'] ?? '/uploads/logo-ppru.png') }}" 
                                     alt="Preview OG" class="max-h-full max-w-full object-contain p-2">
                                <span class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] font-semibold px-2 py-0.5 rounded">OG Preview</span>
                            </div>
                            <div class="p-3 bg-white">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">ppru.ac.id</p>
                                <h4 id="ogPreviewTitle" class="text-xs font-bold text-gray-900 line-clamp-1 mt-0.5">
                                    {{ $settings['og_title'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga - Generasi Qur\'ani & Unggul Sains' }}
                                </h4>
                                <p id="ogPreviewDesc" class="text-[11px] text-gray-500 line-clamp-2 mt-1">
                                    {{ $settings['og_description'] ?? 'Website Resmi Pondok Pesantren Raudhatul Ulum Sakatiga. Menyajikan informasi akademik, kepesantrenan, kegiatan siswa, dan PPDB Online.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Judul OpenGraph (OG Title) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="og_title" id="ogTitleInput" 
                               value="{{ $settings['og_title'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga - Generasi Qur\'ani & Unggul Sains' }}" 
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-medium"
                               placeholder="Judul website saat dibagikan ke medsos" required>
                        <p class="text-[11px] text-gray-400 mt-1">Direkomendasikan antara 40 - 60 karakter agar tidak terpotong di WhatsApp.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Deskripsi OpenGraph (OG Description) <span class="text-red-500">*</span>
                        </label>
                        <textarea name="og_description" id="ogDescInput" rows="2" 
                                  class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] leading-relaxed"
                                  placeholder="Deskripsi ringkas yang tampil di bawah judul medsos" required>{{ $settings['og_description'] ?? 'Website Resmi Pondok Pesantren Raudhatul Ulum Sakatiga. Menyajikan informasi akademik, program tahfidz, sains & teknologi, dan penerimaan santri baru.' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Upload Logo / Gambar OpenGraph (PNG / JPG / SVG)
                        </label>
                        <input type="file" name="og_image_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" 
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#00913e] hover:file:bg-emerald-100 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-[11px] text-gray-400 mt-1">Format gambar resolusi min. 600x315 px untuk preview media sosial.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Path / URL Logo OG Saat Ini
                        </label>
                        <input type="text" name="og_image" value="{{ $settings['og_image'] ?? '/uploads/logo-ppru.png' }}" 
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Tipe Twitter Card
                        </label>
                        <select name="twitter_card" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="summary_large_image" {{ ($settings['twitter_card'] ?? '') == 'summary_large_image' ? 'selected' : '' }}>Large Image Card (Disarankan)</option>
                            <option value="summary" {{ ($settings['twitter_card'] ?? '') == 'summary' ? 'selected' : '' }}>Standard Summary</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Google Site Verification (Meta Tag)
                        </label>
                        <input type="text" name="google_site_verification" value="{{ $settings['google_site_verification'] ?? '' }}" 
                               placeholder="Contoh: abcd1234efgh5678"
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Meta Keywords (Kata Kunci SEO)
                        </label>
                        <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? 'pondok pesantren raudhatul ulum, ppru sakatiga, psb ppru, ponpes sakatiga' }}" 
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        <p class="text-[11px] text-gray-400 mt-1">Pisahkan tiap kata kunci dengan tanda koma.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. IDENTITAS UTAMA WEBSITE --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">2</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Identitas & Logo Website</h2>
                        <p class="text-[11px] text-gray-500">Nama situs, slogan, dan logo navigasi header</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Website / Sekolah</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tagline / Slogan</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Mewujudkan Generasi Qur\'ani & Unggul Berkarakter' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Default Website (SEO)</label>
                    <textarea name="site_description" rows="2" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ $settings['site_description'] ?? 'Official Website Pondok Pesantren Raudhatul Ulum Sakatiga. Pusat keunggulan pendidikan Islam terpadu, tahfidzul Qur\'an, sains modern, dan teknologi.' }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Upload Logo Header (PNG / SVG)</label>
                        <input type="file" name="site_logo_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" 
                               class="w-full text-xs text-gray-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#00913e] hover:file:bg-emerald-100 bg-gray-50 rounded-xl border border-gray-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Path Logo Saat Ini</label>
                        <input type="text" name="site_logo" value="{{ $settings['site_logo'] ?? '/uploads/logo-ppru.png' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 font-mono">
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. KONTAK & SEKRETARIAT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">3</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Informasi Kontak & Kampus</h2>
                        <p class="text-[11px] text-gray-500">Tampil di halaman kontak dan footer website</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email Resmi</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'sekretariat@ppru.ac.id' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nomor Telepon / WhatsApp PPDB</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '081278901234' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Kampus</label>
                        <textarea name="contact_address" rows="2" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ $settings['contact_address'] ?? 'Jl. Pendidikan Karakter No. 12, Kompleks Islamic Centre PPRU' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. MEDIA SOSIAL RESMI --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">4</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Tautan Media Sosial Resmi</h2>
                        <p class="text-[11px] text-gray-500">Ikon dan tautan otomatis aktif di seluruh header dan footer</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            <i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook Page
                        </label>
                        <input type="text" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://www.facebook.com/pprusakatigasumsel/?locale=id_ID' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            <i class="fa-brands fa-x-twitter text-black mr-1"></i> X / Twitter
                        </label>
                        <input type="text" name="social_twitter" value="{{ $settings['social_twitter'] ?? 'https://x.com/ppru_sakatiga' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            <i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram
                        </label>
                        <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://www.instagram.com/ppru_sakatiga/' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            <i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube Channel
                        </label>
                        <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://www.youtube.com/@pprusakatiga' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            <i class="fa-brands fa-tiktok text-black mr-1"></i> TikTok
                        </label>
                        <input type="text" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? 'https://www.tiktok.com/@pprusakatiga' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. PENGATURAN REKENING INFAQ & BEASISWA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">5</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Pengaturan Rekening Infaq & Beasiswa Santri</h2>
                        <p class="text-[11px] text-gray-500">Konfigurasi rekening Bank Syariah Indonesia (BSI), Muamalat, dan nomor konfirmasi transfer</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <i class="fa-solid fa-hand-holding-dollar mr-1.5"></i> Donasi
                </span>
            </div>

            <div class="p-6 space-y-6">
                {{-- Bank 1: Utama (BSI) --}}
                <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-black text-emerald-900 uppercase tracking-wider flex items-center">
                            <i class="fa-solid fa-star text-emerald-500 mr-2"></i>
                            Bank Utama (Bank Syariah Indonesia / BSI)
                        </h3>
                        <span class="text-[10px] font-bold bg-emerald-200/70 text-emerald-800 px-2.5 py-0.5 rounded-full">Prioritas Utama</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Bank</label>
                            <input type="text" name="donation_bank_1_name" value="{{ $settings['donation_bank_1_name'] ?? 'Bank Syariah Indonesia (BSI)' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Rekening</label>
                            <input type="text" name="donation_bank_1_rekening" value="{{ $settings['donation_bank_1_rekening'] ?? '7188992211' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Transfer</label>
                            <input type="text" name="donation_bank_1_code" value="{{ $settings['donation_bank_1_code'] ?? '451' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                        </div>
                        <div class="sm:col-span-2 md:col-span-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atas Nama Rekening (Holder)</label>
                            <input type="text" name="donation_bank_1_holder" value="{{ $settings['donation_bank_1_holder'] ?? 'YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-bold">
                        </div>
                    </div>
                </div>

                {{-- Bank 2: Bank Muamalat --}}
                <div class="p-5 rounded-2xl bg-teal-50/50 border border-teal-200/80 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-black text-teal-900 uppercase tracking-wider flex items-center">
                            <i class="fa-solid fa-building-columns text-teal-600 mr-2"></i>
                            Bank Pendukung (Bank Muamalat)
                        </h3>
                        <span class="text-[10px] font-bold bg-teal-200/70 text-teal-800 px-2.5 py-0.5 rounded-full">Bank Syariah</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Bank</label>
                            <input type="text" name="donation_bank_2_name" value="{{ $settings['donation_bank_2_name'] ?? 'Bank Muamalat' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Rekening</label>
                            <input type="text" name="donation_bank_2_rekening" value="{{ $settings['donation_bank_2_rekening'] ?? '3410088772' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Transfer</label>
                            <input type="text" name="donation_bank_2_code" value="{{ $settings['donation_bank_2_code'] ?? '147' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono">
                        </div>
                        <div class="sm:col-span-2 md:col-span-4">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atas Nama Rekening (Holder)</label>
                            <input type="text" name="donation_bank_2_holder" value="{{ $settings['donation_bank_2_holder'] ?? 'YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)' }}" class="w-full bg-white text-xs text-gray-800 rounded-xl px-4 py-2.5 border border-teal-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-bold">
                        </div>
                    </div>
                </div>

                {{-- Konfirmasi & Narasi Donasi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp Konfirmasi Infaq</label>
                        <input type="text" name="donation_confirm_phone" value="{{ $settings['donation_confirm_phone'] ?? '081278901234' }}" placeholder="Opsional (Otomatis pakai nomor kontak jika kosong)" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pesan Template WhatsApp Konfirmasi</label>
                        <input type="text" name="donation_confirm_text" value="{{ $settings['donation_confirm_text'] ?? 'Assalamu\'alaikum Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga, saya telah menyalurkan infaq beasiswa/pembangunan.' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Ajakan Singkat Infaq</label>
                        <textarea name="donation_intro_text" rows="2" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl p-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ $settings['donation_intro_text'] ?? 'Mari dukung generasi penghafal Al-Qur\'an dan calon cendekiawan muslim masa depan melalui program beasiswa dan pengembangan fasilitas Pondok Pesantren Raudhatul Ulum Sakatiga.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. PENGATURAN ANALITIK & PENGUNJUNG --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">6</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Pengaturan Analitik & Pelacak Pengunjung</h2>
                        <p class="text-[11px] text-gray-500">Kontrol pencatatan log kunjungan, lokasi, dan angka counter publik</p>
                    </div>
                </div>
                <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:underline">
                    <span>Buka Halaman Analitik</span>
                    <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Pencatatan Analitik (Visitor Tracking)</label>
                        <select name="analytics_enabled" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-semibold">
                            <option value="1" {{ ($settings['analytics_enabled'] ?? '1') === '1' ? 'selected' : '' }}>Aktif (Mencatat data pengunjung nyata)</option>
                            <option value="0" {{ ($settings['analytics_enabled'] ?? '1') === '0' ? 'selected' : '' }}>Non-Aktif (Jeda pencatatan)</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Saat aktif, sistem akan merekam IP, referer, halaman yang dibaca, dan perangkat.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Abaikan Kunjungan Pengurus/Admin</label>
                        <select name="analytics_ignore_admin" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-semibold">
                            <option value="1" {{ ($settings['analytics_ignore_admin'] ?? '1') === '1' ? 'selected' : '' }}>Ya, Abaikan Admin (Data statistik murni pengunjung publik)</option>
                            <option value="0" {{ ($settings['analytics_ignore_admin'] ?? '1') === '0' ? 'selected' : '' }}>Tidak (Catat semua termasuk aktivitas admin)</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Mencegah statistik membengkak saat admin sedang mengedit konten.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Angka Basis Counter Publik</label>
                        <input type="number" name="analytics_base_hits" value="{{ $settings['analytics_base_hits'] ?? '12850' }}" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-mono font-bold">
                        <p class="text-[10px] text-slate-400 mt-1">Angka awal counter publik di footer/beranda yang tersimpan di database.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deteksi Lokasi Geografis (Geo-IP Lookup)</label>
                        <select name="analytics_ip_lookup" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] font-semibold">
                            <option value="1" {{ ($settings['analytics_ip_lookup'] ?? '1') === '1' ? 'selected' : '' }}>Aktif (Deteksi Kota & Provinsi secara otomatis)</option>
                            <option value="0" {{ ($settings['analytics_ip_lookup'] ?? '1') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Menggunakan lookup IP publik dengan caching 7 hari agar web tetap super cepat.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- SUBMIT BAR --}}
        <div class="sticky bottom-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-gray-200 flex items-center justify-between">
            <span class="text-xs text-gray-500">
                <i class="fa-solid fa-shield-halved text-[#00913e] mr-1"></i> Perubahan tersimpan secara aman & tercatat di log aktivitas.
            </span>
            <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white px-7 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg transition flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Seluruh Pengaturan</span>
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('ogTitleInput');
        const descInput = document.getElementById('ogDescInput');
        const prevTitle = document.getElementById('ogPreviewTitle');
        const prevDesc = document.getElementById('ogPreviewDesc');

        if (titleInput && prevTitle) {
            titleInput.addEventListener('input', function() {
                prevTitle.textContent = this.value || 'Judul Website';
            });
        }
        if (descInput && prevDesc) {
            descInput.addEventListener('input', function() {
                prevDesc.textContent = this.value || 'Deskripsi Website';
            });
        }
    });
</script>
@endsection
