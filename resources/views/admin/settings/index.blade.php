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
                        <h2 class="font-bold text-sm text-gray-900">Informasi Kontak & Pondok</h2>
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
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Pondok</label>
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

        {{-- 5. VIDEO BACKGROUND BERANDA & PROFIL SINGKAT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs font-bold">5</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Video Background Beranda & Video Profil Pesantren</h2>
                        <p class="text-[11px] text-gray-500">Atur video background yang berputar bergerak di section 'Mendidik dengan Kasih Sayang' pada beranda</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                    <i class="fa-solid fa-film mr-1.5"></i> Video Showcase
                </span>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        URL Video Background (YouTube atau Link File MP4)
                    </label>
                    <input type="text" name="home_profile_video_bg" value="{{ $settings['home_profile_video_bg'] ?? 'https://www.youtube.com/watch?v=BG311kT-yXc' }}" 
                           placeholder="Contoh: https://www.youtube.com/watch?v=BG311kT-yXc atau https://domain.com/video-drone.mp4" 
                           class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    <p class="text-[11px] text-gray-400 mt-1">Bisa diisi URL YouTube (misal channel resmi TVRU Sakatiga) atau link file langsung (.mp4/.webm). Video diputar otomatis secara berulang (loop) tanpa suara di belakang teks.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul Badge Atas
                        </label>
                        <input type="text" name="home_profile_badge" value="{{ $settings['home_profile_badge'] ?? 'Profil Pesantren' }}" 
                               placeholder="Contoh: Profil Pesantren"
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            ID Video Popup (Tombol "Tonton Video")
                        </label>
                        <input type="text" name="home_profile_video_popup_id" value="{{ $settings['home_profile_video_popup_id'] ?? 'BG311kT-yXc' }}" 
                               placeholder="Contoh: BG311kT-yXc" 
                               class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        <p class="text-[10px] text-gray-400 mt-1">ID video YouTube yang akan diputar dengan suara di jendela modal saat pengunjung klik tombol play.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Judul Utama Section
                    </label>
                    <input type="text" name="home_profile_headline" value="{{ $settings['home_profile_headline'] ?? 'Mendidik dengan Kasih Sayang, Membentuk Generasi Khairu Ummah' }}" 
                           class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi / Penjelasan Singkat
                    </label>
                    <textarea name="home_profile_desc" rows="3" class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ $settings['home_profile_desc'] ?? 'Di Pondok Pesantren Raudhatul Ulum Sakatiga, proses pendidikan berakar pada keikhlasan pengasuhan, keteladanan akhlaqul karimah, serta keseimbangan antara spiritualitas Qur\'ani, ketajaman nalar ilmiah, dan kepemimpinan global.' }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Teks Tombol Play Video
                    </label>
                    <input type="text" name="home_profile_btn_text" value="{{ $settings['home_profile_btn_text'] ?? 'Tonton Video Profil' }}" 
                           class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>

                {{-- Foto Background Sementara (Poster Image sebelum video dimuat) --}}
                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Background Sementara (Poster Gambar Sebelum Video Berputar)
                    </label>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="w-32 h-20 rounded-xl overflow-hidden bg-slate-900 border border-gray-200 shrink-0 shadow-inner">
                            <img src="{{ $settings['home_profile_poster_image'] ?? '/uploads/campus-ppru-sakatiga.webp' }}" 
                                 alt="Preview Poster Video" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='/uploads/campus-ppru-sakatiga.webp'">
                        </div>
                        <div class="flex-1 w-full space-y-2">
                            <input type="file" name="home_profile_poster_file" accept="image/*"
                                   class="block w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-[#00913e] hover:file:bg-emerald-100 cursor-pointer">
                            <input type="text" name="home_profile_poster_image" value="{{ $settings['home_profile_poster_image'] ?? '/uploads/campus-ppru-sakatiga.webp' }}" 
                                   placeholder="Atau masukkan URL / path gambar langsung..." 
                                   class="w-full bg-gray-50 text-xs text-gray-800 rounded-xl px-4 py-2 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <p class="text-[11px] text-gray-400">Gambar yang tampil pertama kali saat halaman dibuka sebelum video YouTube/MP4 mulai berjalan.</p>
                        </div>
                    </div>
                </div>

                {{-- Persentase Transparansi Cover Hitam Video --}}
                <div class="border-t border-gray-100 pt-4" x-data="{ opacityVal: {{ (int)($settings['home_profile_overlay_opacity'] ?? 75) }} }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Persentase Kepekatan Cover Hitam di Atas Video
                        </label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-slate-900 text-amber-400 border border-slate-700">
                            <span x-text="opacityVal"></span>% Kepekatan Hitam
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <input type="range" name="home_profile_overlay_opacity" min="10" max="95" step="1" 
                               x-model="opacityVal"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#00913e]">
                        <input type="number" min="10" max="95" x-model="opacityVal"
                               class="w-20 text-center bg-gray-50 text-xs font-bold text-gray-800 rounded-xl px-2 py-2 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1.5">
                        Geser untuk mengatur transparansi warna hitam di atas video. Nilai standar <strong>75% - 80%</strong> memberikan efek sinematik yang meredupkan adegan video terang (seperti langit/pohon) agar seluruh teks putih terbaca dengan sangat jelas.
                    </p>
                </div>
            </div>
        </div>

        {{-- 6. KONTEN BERANDA & SECTION DINAMIS (TRISULA, STATISTIK, SAMBUTAN, PSB, INFAQ) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <span class="w-7 h-7 rounded-lg bg-emerald-100 text-[#00913e] flex items-center justify-center text-xs font-bold">6</span>
                    <div>
                        <h2 class="font-bold text-sm text-gray-900">Konten Beranda: Trisula, Statistik, PSB &amp; Infaq</h2>
                        <p class="text-[11px] text-gray-500">Sesuaikan seluruh teks judul, kutipan, kartu keunggulan, angka statistik dan tombol pada halaman depan</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                    <i class="fa-solid fa-pen-nib mr-1.5"></i> 100% Dinamis
                </span>
            </div>

            <div class="p-6 space-y-8 divide-y divide-gray-100">
                {{-- A. TRISULA KEUNGGULAN (3 KARTU) --}}
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-shield-halved text-[#00913e]"></i>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">A. Trisula Keunggulan Pesantren (3 Pilar)</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Section</label>
                            <input type="text" name="home_trisula_badge" value="{{ $settings['home_trisula_badge'] ?? 'Trisula Nilai Pesantren' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200 focus:ring-2 focus:ring-[#00913e]">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Section Trisula</label>
                            <input type="text" name="home_trisula_title" value="{{ $settings['home_trisula_title'] ?? 'Fondasi Kokoh Melahirkan Generasi Ulama & Pemimpin Masa Depan' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200 focus:ring-2 focus:ring-[#00913e]">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Sub-Judul / Keterangan Singkat</label>
                            <input type="text" name="home_trisula_subtitle" value="{{ $settings['home_trisula_subtitle'] ?? 'Tiga pilar pendidikan holistik yang menyatukan kedalaman ilmu syar\'i, kecakapan bahasa internasional, dan ketajaman riset sains.' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200 focus:ring-2 focus:ring-[#00913e]">
                        </div>
                    </div>

                    {{-- 3 Cards Trisula --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        {{-- Kartu 1 --}}
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2.5">
                            <span class="text-[11px] font-extrabold text-[#00913e] uppercase block">Kartu 1</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Badge Kartu</label>
                                <input type="text" name="home_trisula_1_badge" value="{{ $settings['home_trisula_1_badge'] ?? 'Pilar Pertama' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Judul Kartu</label>
                                <input type="text" name="home_trisula_1_title" value="{{ $settings['home_trisula_1_title'] ?? 'Tahfidzul Qur\'an Mutqin & Muadalah Al-Azhar' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Deskripsi Ringkas</label>
                                <textarea name="home_trisula_1_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['home_trisula_1_desc'] ?? 'Program bimbingan tahfidz 30 juz bersanad serta kurikulum dirasah Islamiyah berstandar Universitas Al-Azhar Mesir.' }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Icon FontAwesome</label>
                                    <input type="text" name="home_trisula_1_icon" value="{{ $settings['home_trisula_1_icon'] ?? 'fa-solid fa-quran' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200 font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Footer Tag</label>
                                    <input type="text" name="home_trisula_1_footer" value="{{ $settings['home_trisula_1_footer'] ?? 'Sanad Tahfidz & Muadalah' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                        </div>

                        {{-- Kartu 2 --}}
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2.5">
                            <span class="text-[11px] font-extrabold text-[#00913e] uppercase block">Kartu 2</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Badge Kartu</label>
                                <input type="text" name="home_trisula_2_badge" value="{{ $settings['home_trisula_2_badge'] ?? 'Pilar Kedua' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Judul Kartu</label>
                                <input type="text" name="home_trisula_2_title" value="{{ $settings['home_trisula_2_title'] ?? 'Bilingual Arabic-English & Karakter Mandiri' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Deskripsi Ringkas</label>
                                <textarea name="home_trisula_2_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['home_trisula_2_desc'] ?? 'Lingkungan asrama berbahasa Arab dan Inggris secara aktif untuk melatih santri berkomunikasi di kancah internasional.' }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Icon FontAwesome</label>
                                    <input type="text" name="home_trisula_2_icon" value="{{ $settings['home_trisula_2_icon'] ?? 'fa-solid fa-language' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200 font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Footer Tag</label>
                                    <input type="text" name="home_trisula_2_footer" value="{{ $settings['home_trisula_2_footer'] ?? 'Active Arabic & English' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                        </div>

                        {{-- Kartu 3 --}}
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2.5">
                            <span class="text-[11px] font-extrabold text-[#00913e] uppercase block">Kartu 3</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Badge Kartu</label>
                                <input type="text" name="home_trisula_3_badge" value="{{ $settings['home_trisula_3_badge'] ?? 'Pilar Ketiga' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Judul Kartu</label>
                                <input type="text" name="home_trisula_3_title" value="{{ $settings['home_trisula_3_title'] ?? 'Keunggulan Sains, Riset & Ekstrakurikuler Prestasi' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Deskripsi Ringkas</label>
                                <textarea name="home_trisula_3_desc" rows="2" class="w-full bg-white text-xs rounded-lg p-2 border border-slate-200">{{ $settings['home_trisula_3_desc'] ?? 'Laboratorium sains terpadu, bimbingan olimpiade, robotika, panahan, bela diri dan kegiatan ekstrakurikuler terlengkap.' }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Icon FontAwesome</label>
                                    <input type="text" name="home_trisula_3_icon" value="{{ $settings['home_trisula_3_icon'] ?? 'fa-solid fa-atom' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200 font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Footer Tag</label>
                                    <input type="text" name="home_trisula_3_footer" value="{{ $settings['home_trisula_3_footer'] ?? 'Riset, IT & Olahraga Sunnah' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- B. STATISTIK & PENCAPAIAN PESANTREN (4 COUNTER) --}}
                <div class="pt-6 space-y-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-chart-line text-[#00913e]"></i>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">B. Statistik &amp; Pencapaian Pesantren (4 Counter Angka)</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Section Statistik</label>
                            <input type="text" name="home_stat_title" value="{{ $settings['home_stat_title'] ?? 'Kiprah Dakwah & Jejak Prestasi Pondok Pesantren Raudhatul Ulum' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Sub-Judul Section Statistik</label>
                            <input type="text" name="home_stat_subtitle" value="{{ $settings['home_stat_subtitle'] ?? 'Perjalanan puluhan tahun menegakkan risalah dakwah dan mencetak generasi Qur\'ani di Sakatiga, Ogan Ilir, Sumatera Selatan.' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
                        {{-- Stat 1 --}}
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-extrabold text-[#00913e]">Statistik 1</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Angka Tampilan</label>
                                <input type="text" name="home_stat_1_number" value="{{ $settings['home_stat_1_number'] ?? '3.500+' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Label Utama</label>
                                <input type="text" name="home_stat_1_label" value="{{ $settings['home_stat_1_label'] ?? 'Santri Aktif Mukim' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Keterangan Tambahan</label>
                                <input type="text" name="home_stat_1_desc" value="{{ $settings['home_stat_1_desc'] ?? 'Dari berbagai provinsi nusantara' }}" class="w-full bg-white text-[11px] rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                        </div>

                        {{-- Stat 2 --}}
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-extrabold text-[#00913e]">Statistik 2</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Angka Tampilan</label>
                                <input type="text" name="home_stat_2_number" value="{{ $settings['home_stat_2_number'] ?? '15.000+' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Label Utama</label>
                                <input type="text" name="home_stat_2_label" value="{{ $settings['home_stat_2_label'] ?? 'Alumni Berkhidmat' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Keterangan Tambahan</label>
                                <input type="text" name="home_stat_2_desc" value="{{ $settings['home_stat_2_desc'] ?? 'Kiprah dakwah nasional & global' }}" class="w-full bg-white text-[11px] rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                        </div>

                        {{-- Stat 3 --}}
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-extrabold text-[#00913e]">Statistik 3</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Angka Tampilan</label>
                                <input type="text" name="home_stat_3_number" value="{{ $settings['home_stat_3_number'] ?? '100%' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Label Utama</label>
                                <input type="text" name="home_stat_3_label" value="{{ $settings['home_stat_3_label'] ?? 'Muadalah Al-Azhar' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Keterangan Tambahan</label>
                                <input type="text" name="home_stat_3_desc" value="{{ $settings['home_stat_3_desc'] ?? 'Akses studi langsung ke Mesir & Timur Tengah' }}" class="w-full bg-white text-[11px] rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                        </div>

                        {{-- Stat 4 --}}
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <span class="text-[11px] font-extrabold text-[#00913e]">Statistik 4</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Angka Tampilan</label>
                                <input type="text" name="home_stat_4_number" value="{{ $settings['home_stat_4_number'] ?? '75+' }}" class="w-full bg-white text-xs font-bold rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Label Utama</label>
                                <input type="text" name="home_stat_4_label" value="{{ $settings['home_stat_4_label'] ?? 'Tahun Pengabdian' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Keterangan Tambahan</label>
                                <input type="text" name="home_stat_4_desc" value="{{ $settings['home_stat_4_desc'] ?? 'Sejak 1950 di bumi Sakatiga Mekkah Kecil' }}" class="w-full bg-white text-[11px] rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- C. SAMBUTAN MUDIR BERANDA --}}
                <div class="pt-6 space-y-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-user-tie text-[#00913e]"></i>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">C. Seksi Sambutan Mudir / Pimpinan di Beranda</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Section</label>
                            <input type="text" name="home_sambutan_badge" value="{{ $settings['home_sambutan_badge'] ?? 'Pesan Dari Mudir Pesantren' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Sambutan</label>
                            <input type="text" name="home_sambutan_title" value="{{ $settings['home_sambutan_title'] ?? 'Mendidik Generasi Khairu Ummah, Berilmu Amaliah, Beramal Ilmiah' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Kutipan Utama (Quotes)</label>
                            <textarea name="home_sambutan_quote" rows="2" class="w-full bg-gray-50 text-xs rounded-xl p-2.5 border border-gray-200">{{ $settings['home_sambutan_quote'] ?? '“Pondok Pesantren Raudhatul Ulum Sakatiga berikhtiar teguh menyemai benih-benih kebaikan, adab, dan keilmuan Islam yang bersumber dari Al-Qur\'an dan Sunnah.”' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Paragraf 1</label>
                            <textarea name="home_sambutan_text_1" rows="3" class="w-full bg-gray-50 text-xs rounded-xl p-2.5 border border-gray-200">{{ $settings['home_sambutan_text_1'] ?? 'Selamat datang di gerbang informasi resmi Pondok Pesantren Raudhatul Ulum Sakatiga. Sejak dirintis di bumi Sakatiga yang berjuluk Mekkah Kecil, pesantren ini senantiasa berkomitmen menjaga kemurnian ajaran Islam.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Paragraf 2</label>
                            <textarea name="home_sambutan_text_2" rows="3" class="w-full bg-gray-50 text-xs rounded-xl p-2.5 border border-gray-200">{{ $settings['home_sambutan_text_2'] ?? 'Dengan integrasi kurikulum terpadu muadalah Al-Azhar Kairo dan pendidikan nasional, kami mengantarkan para santri menjadi ulama amilin dan cendekiawan muslim yang tangguh.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Mudir</label>
                            <input type="text" name="home_mudir_name" value="{{ $settings['home_mudir_name'] ?? ($settings['mudir_name'] ?? 'KH. Tol\'at Wafa Ahmad, Lc.') }}" class="w-full bg-gray-50 text-xs font-semibold rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Jabatan Mudir</label>
                            <input type="text" name="home_mudir_role" value="{{ $settings['home_mudir_role'] ?? ($settings['mudir_position'] ?? 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga') }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Unggah Foto Mudir (Opsional)</label>
                            <input type="file" name="home_mudir_photo_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-[#00913e] cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Tombol Aksi Sambutan</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="home_sambutan_btn_text" placeholder="Teks Tombol" value="{{ $settings['home_sambutan_btn_text'] ?? 'Baca Sambutan Lengkap' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                                <input type="text" name="home_sambutan_btn_url" placeholder="URL Target" value="{{ $settings['home_sambutan_btn_url'] ?? '/sambutan' }}" class="w-full bg-gray-50 text-xs rounded-xl px-3 py-2 border border-gray-200">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- D. SECTION PENERIMAAN SANTRI BARU (PSB) & INFAQ/WAKAF --}}
                <div class="pt-6 space-y-6">
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fa-solid fa-graduation-cap text-[#00913e]"></i>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">D. Banner Ajakan PSB / PPDB Online</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Badge Banner</label>
                                <input type="text" name="home_psb_badge" value="{{ $settings['home_psb_badge'] ?? 'Penerimaan Santri Baru (PSB)' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Judul Banner</label>
                                <input type="text" name="home_psb_title" value="{{ $settings['home_psb_title'] ?? 'Mari Bergabung Membentuk Generasi Qur\'ani Unggul Berdaya Saing Global' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Deskripsi Banner</label>
                                <input type="text" name="home_psb_desc" value="{{ $settings['home_psb_desc'] ?? 'Pendaftaran Santri Baru Tahun Ajaran 2026/2027 telah dibuka untuk seluruh jenjang: PAUD/TK, Madrasah Ibtidaiyah (MI), MTs, Madrasah Aliyah (MA), dan Sekolah Tinggi.' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Tombol 1 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" name="home_psb_btn1_text" placeholder="Teks" value="{{ $settings['home_psb_btn1_text'] ?? 'Daftar PPDB Online' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                    <input type="text" name="home_psb_btn1_url" placeholder="URL" value="{{ $settings['home_psb_btn1_url'] ?? '/ppdb' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Tombol 2 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" name="home_psb_btn2_text" placeholder="Teks" value="{{ $settings['home_psb_btn2_text'] ?? 'Brosur & Biaya' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                    <input type="text" name="home_psb_btn2_url" placeholder="URL" value="{{ $settings['home_psb_btn2_url'] ?? '/download' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <i class="fa-solid fa-hand-holding-heart text-[#00913e]"></i>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">E. Banner Infaq, Sedekah &amp; Wakaf Pesantren</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Badge Banner</label>
                                <input type="text" name="home_infaq_badge" value="{{ $settings['home_infaq_badge'] ?? 'Lumbung Amal Jariyah' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Judul Banner</label>
                                <input type="text" name="home_infaq_title" value="{{ $settings['home_infaq_title'] ?? 'Infaq & Wakaf Pembangunan Sarana Pendidikan Santri' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div class="sm:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Deskripsi Banner</label>
                                <input type="text" name="home_infaq_desc" value="{{ $settings['home_infaq_desc'] ?? 'Salurkan donasi terbaik Anda untuk beasiswa santri dhuafa penghafal Al-Qur\'an dan pengembangan sarana asrama Pondok Pesantren Raudhatul Ulum Sakatiga.' }}" class="w-full bg-white text-xs rounded-lg px-2.5 py-1.5 border border-slate-200">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Tombol 1 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" name="home_infaq_btn1_text" placeholder="Teks" value="{{ $settings['home_infaq_btn1_text'] ?? 'Salurkan Donasi' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                    <input type="text" name="home_infaq_btn1_url" placeholder="URL" value="{{ $settings['home_infaq_btn1_url'] ?? '/donasi' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Tombol 2 (Teks &amp; Link)</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <input type="text" name="home_infaq_btn2_text" placeholder="Teks" value="{{ $settings['home_infaq_btn2_text'] ?? 'Konfirmasi Donasi WA' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                    <input type="text" name="home_infaq_btn2_url" placeholder="URL" value="{{ $settings['home_infaq_btn2_url'] ?? 'https://wa.me/6281278901234' }}" class="w-full bg-white text-xs rounded-lg px-2 py-1.5 border border-slate-200">
                                </div>
                            </div>
                        </div>
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
