@extends('layouts.frontend')

@section('title', 'PSB / PPDB Online ' . ($settings['year'] ?? '2026/2027') . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Penerimaan Santri Baru (PSB/PPDB) Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga Tahun Pelajaran ' . ($settings['year'] ?? '2026/2027') . '. Informasi alur, syarat, jadwal, biaya, dan formulir pendaftaran online.')

@section('content')
<div class="bg-gradient-to-b from-emerald-50/50 via-white to-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- HEADER BRAND & HERO TITLE --}}
        <div class="text-center space-y-4 reveal-fade-up">
            <div class="inline-block p-3 bg-white rounded-3xl shadow-md border border-emerald-100">
                <img src="/uploads/logo-ppru-banner.png" alt="Logo Pondok Pesantren Raudhatul Ulum" class="h-20 sm:h-24 w-auto object-contain mx-auto" onerror="this.src='/uploads/logo-ppru-square.png'">
            </div>
            <div>
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-school-green px-4 py-1.5 rounded-full text-xs font-black mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Pendaftaran Santri Baru Telah Dibuka</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-950 tracking-tight uppercase">
                    PSB PONDOK PESANTREN RAUDHATUL ULUM <br class="hidden sm:inline">SAKATIGA OGAN ILIR
                </h1>
                <p class="text-sm sm:text-base font-extrabold text-school-gold mt-1.5">
                    Tahun Pelajaran {{ $settings['year'] ?? '2026/2027' }} &bull; {{ $settings['wave'] ?? 'Gelombang Aktif' }}
                </p>
                @if(!empty($settings['promo']))
                    <div class="inline-block mt-2 bg-amber-500 text-slate-950 font-black text-xs sm:text-sm px-4 py-1.5 rounded-xl shadow-xs border border-amber-600">
                        <i class="fa-solid fa-tag mr-1.5 text-red-700"></i> {{ $settings['promo'] }}
                    </div>
                @endif
                <p class="text-xs sm:text-sm text-slate-800 max-w-2xl mx-auto mt-2.5 font-medium leading-relaxed">
                    {{ $settings['tagline'] ?? "Membina Generasi Khairu Ummah: Beraqidah Lurus, Berakhlak Mulia, Cerdas Sains, Mandiri, dan Berwawasan Global dengan Muadalah Al-Azhar Kairo Mesir." }}
                </p>
            </div>

            {{-- CTA Quick Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ route('ppdb.form') }}" class="inline-flex items-center space-x-2 bg-school-green hover:bg-emerald-800 text-white px-7 py-3 rounded-2xl text-xs sm:text-sm font-black transition shadow-lg shadow-emerald-700/25 transform hover:scale-105">
                    <i class="fa-solid fa-file-pen text-sm"></i>
                    <span>Isi Formulir Online</span>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 bg-slate-900 hover:bg-black text-white px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition shadow-sm">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Beranda Pesantren</span>
                </a>
                @php
                    $cleanHotline = preg_replace('/[^0-9]/', '', (string) ($settings['hotline_phone'] ?? '081278901950'));
                    if (str_starts_with($cleanHotline, '0')) {
                        $cleanHotline = '62' . substr($cleanHotline, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $cleanHotline }}?text={{ urlencode('Assalamu\'alaikum Panitia PSB Pondok Pesantren Raudhatul Ulum Sakatiga, saya ingin konsultasi pendaftaran santri baru.') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white px-6 py-3 rounded-2xl text-xs sm:text-sm font-bold transition shadow-md">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Hotline WhatsApp ({{ $settings['hotline_phone'] ?? '0812-7890-1950' }})</span>
                </a>
            </div>
        </div>

        {{-- VIDEO PROFILE RESMI PESANTREN EMBED --}}
        @if(!empty($settings['youtube_id']))
            <div class="bg-white p-4 sm:p-7 rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden space-y-4">
                <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-950 shadow-2xl border border-slate-800">
                    <iframe 
                        class="w-full h-full"
                        src="https://www.youtube.com/embed/{{ $settings['youtube_id'] }}?rel=0" 
                        title="{{ $settings['video_title'] ?? 'Video Profil Resmi Pondok Pesantren Raudhatul Ulum Sakatiga' }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-2">
                    <div class="flex items-center space-x-3 text-left">
                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-lg flex-shrink-0">
                            <i class="fa-brands fa-youtube"></i>
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $settings['video_title'] ?? 'Video Profil & Dokumentasi Pesantren' }}</h4>
                            <p class="text-xs text-slate-700 font-medium">Saksikan suasana pembelajaran, asrama santri, laboratorium, dan tahfidz Al-Qur'an.</p>
                        </div>
                    </div>
                    <a href="https://www.youtube.com/watch?v={{ $settings['youtube_id'] }}" target="_blank" class="inline-flex items-center space-x-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition flex-shrink-0">
                        <span>Tonton di YouTube</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endif

        {{-- JAM OPERASIONAL & KOTAK REKENING PEMBAYARAN BSI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Jam Operasional --}}
            <div class="bg-white border-2 border-emerald-300 rounded-3xl p-6 sm:p-7 shadow-sm flex flex-col justify-between">
                <div class="space-y-2">
                    <span class="inline-block bg-emerald-700 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                        Layanan Terpadu
                    </span>
                    <h3 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight uppercase">
                        JAM OPERASIONAL SPMB
                    </h3>
                    <p class="text-xs font-bold text-[#00913e]">
                        Tersedia Layanan Konsultasi Offline &amp; Online
                    </p>
                    <ul class="text-xs text-slate-900 font-medium space-y-2 pt-2">
                        <li class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-[#00913e] font-bold"></i>
                            <span>{{ $settings['operational_weekday'] ?? "Senin – Jum'at: Pukul 08.00 – 15.00 WIB" }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-[#00913e] font-bold"></i>
                            <span>{{ $settings['operational_weekend'] ?? 'Sabtu: Pukul 08.00 – 12.00 WIB' }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-[#da251c] font-bold"></i>
                            <span><strong>Sekretariat:</strong> {{ $settings['secretariat'] ?? 'Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga Indralaya Ogan Ilir' }}</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-200">
                    <p class="text-xs text-slate-700 font-bold">* Biaya Formulir Pendaftaran: <strong class="text-[#00913e]">{{ $settings['registration_fee'] ?? 'Rp 250.000,-' }}</strong></p>
                </div>
            </div>

            {{-- Rekening Resmi Pembayaran Formulir --}}
            <div class="bg-gradient-to-br from-[#064e3b] via-[#043d2e] to-[#022c22] text-white rounded-3xl p-6 sm:p-7 shadow-xl border-2 border-emerald-500/50 flex flex-col justify-between relative overflow-hidden" x-data="{ copied: false }">
                <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-emerald-400/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="space-y-3.5 relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-xs">
                            Rekening Resmi SPMB
                        </span>
                        <span class="text-xs font-black text-amber-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-building-columns"></i>
                            <span>{{ $settings['bank_name'] ?? 'Bank Syariah Indonesia (BSI)' }}</span>
                        </span>
                    </div>
                    <h3 class="text-xl font-black text-white tracking-tight">
                        Pembayaran Biaya Formulir ({{ $settings['registration_fee'] ?? 'Rp 250.000,-' }})
                    </h3>
                    <div class="bg-black/35 backdrop-blur-md rounded-2xl p-4 sm:p-5 border border-emerald-400/30 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-emerald-100 font-extrabold uppercase tracking-wider">Nomor Rekening:</span>
                            <span class="text-xs text-amber-300 font-black bg-emerald-900/80 px-2.5 py-0.5 rounded-lg border border-emerald-500/40">
                                Kode Bank: {{ $settings['bank_code'] ?? '451' }}
                            </span>
                        </div>
                        <div class="text-3xl sm:text-4xl font-black text-amber-300 font-mono tracking-wider drop-shadow-md">
                            {{ $settings['bank_account'] ?? '7011304251' }}
                        </div>
                        <div class="text-xs text-emerald-100 font-medium pt-1 flex items-center justify-between border-t border-white/10">
                            <span>Atas Nama:</span>
                            <strong class="text-white font-black text-sm uppercase">{{ $settings['bank_holder'] ?? 'YL. Fatmawati' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-3 relative z-10 flex items-center justify-between gap-3">
                    <button 
                        @click="navigator.clipboard.writeText('{{ $settings['bank_account'] ?? '7011304251' }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="inline-flex items-center space-x-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 text-xs font-black px-5 py-3 rounded-xl transition shadow-lg shadow-emerald-950/40 cursor-pointer flex-shrink-0">
                        <i class="fa-regular" :class="copied ? 'fa-check' : 'fa-copy'"></i>
                        <span x-text="copied ? 'Nomor Tersalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                    <span class="text-xs text-amber-300 font-extrabold flex items-center gap-1.5">
                        <i class="fa-solid fa-receipt"></i>
                        <span>Simpan bukti transfer</span>
                    </span>
                </div>
            </div>

        </div>

        {{-- ACCORDION LENGKAP 10 INFORMASI SPMB DUA KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ activeLeft: 1, activeRight: 1 }">

            {{-- KOLOM KIRI (6 MENU) --}}
            <div class="space-y-3">
                
                {{-- 1. Alur Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 1 ? null : 1)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>1. Alur Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 1" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2.5 bg-white border-t border-emerald-100 leading-relaxed">
                        @php
                            $linesAlur = array_values(array_filter(array_map('trim', explode("\n", (string) ($settings['alur'] ?? '')))));
                        @endphp
                        @if(count($linesAlur) > 0)
                            <ul class="list-disc list-inside space-y-2 text-slate-800">
                                @foreach($linesAlur as $line)
                                    <li>{!! nl2br(e($line)) !!}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-slate-500">Informasi alur pendaftaran akan segera diperbarui.</p>
                        @endif
                    </div>
                </div>

                {{-- 2. Syarat Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>2. Syarat Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 2" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed">
                        @php
                            $linesSyarat = array_values(array_filter(array_map('trim', explode("\n", (string) ($settings['syarat'] ?? '')))));
                        @endphp
                        @if(count($linesSyarat) > 0)
                            <ul class="list-disc list-inside space-y-1.5 text-slate-800">
                                @foreach($linesSyarat as $line)
                                    <li>{!! nl2br(e($line)) !!}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-slate-500">Informasi syarat pendaftaran akan segera diperbarui.</p>
                        @endif
                    </div>
                </div>

                {{-- 3. Jalur Prestasi --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>3. Jalur Prestasi &amp; Keringanan</span>
                        <i class="fa-solid" :class="activeLeft === 3 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 3" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['prestasi'] ?? '-' }}</div>
                </div>

                {{-- 4. Jalur Hafizh Al-Qur'an --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>4. Jalur Hafizh Al-Qur'an (Tahfidz)</span>
                        <i class="fa-solid" :class="activeLeft === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 4" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['tahfidz'] ?? '-' }}</div>
                </div>

                {{-- 5. Jalur Alumni SMPIT PPRU --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 5 ? null : 5)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>5. Jalur Alumni SMPIT PPRU</span>
                        <i class="fa-solid" :class="activeLeft === 5 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 5" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['alumni'] ?? '-' }}</div>
                </div>

                {{-- 6. Jalur Tes Mandiri --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 6 ? null : 6)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>6. Jalur Reguler / Tes Mandiri</span>
                        <i class="fa-solid" :class="activeLeft === 6 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 6" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['mandiri'] ?? '-' }}</div>
                </div>

            </div>

            {{-- KOLOM KANAN (4 MENU) --}}
            <div class="space-y-3">
                
                {{-- 7. Jadwal Gelombang PPDB --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 1 ? null : 1)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>1. Jadwal Gelombang PPDB</span>
                        <i class="fa-solid" :class="activeRight === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 1" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2.5 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['jadwal_gelombang'] ?? '-' }}</div>
                </div>

                {{-- 8. Rincian Biaya --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>2. Rincian Biaya &amp; Fasilitas Seragam</span>
                        <i class="fa-solid" :class="activeRight === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 2" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['biaya'] ?? '-' }}</div>
                </div>

                {{-- 9. Pilihan Program --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>3. Pilihan Program: Boarding (Asrama) &amp; Full Day</span>
                        <i class="fa-solid" :class="activeRight === 3 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 3" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['boarding'] ?? '-' }}</div>
                </div>

                {{-- 10. Pengumuman Kelulusan --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition cursor-pointer">
                        <span>4. Pengumuman Kelulusan &amp; Daftar Ulang</span>
                        <i class="fa-solid" :class="activeRight === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 4" x-collapse class="p-5 text-xs text-slate-900 font-medium space-y-2 bg-white border-t border-emerald-100 leading-relaxed whitespace-pre-line text-slate-800">{{ $settings['kelulusan'] ?? '-' }}</div>
                </div>

            </div>

        </div>

        {{-- ACTION CARDS: FORMULIR PENDAFTARAN & HUBUNGI ADMIN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
            
            {{-- Card 1: Formulir Pendaftaran --}}
            <a href="{{ route('ppdb.form') }}" class="group bg-white p-8 rounded-3xl border-2 border-emerald-200 hover:border-[#00913e] shadow-md hover:shadow-2xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-red-50 text-[#da251c] flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-950 group-hover:text-[#00913e] transition">
                            Formulir Pendaftaran Online
                        </h3>
                        <p class="text-xs text-slate-700 font-medium mt-2 leading-relaxed">
                            Silakan Bapak/Ibu mengisi formulir pendaftaran online ini sebagai syarat pendaftaran di Pondok Pesantren Raudhatul Ulum Sakatiga dengan data yang valid dan benar.
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white text-xs font-black px-7 py-3.5 rounded-2xl shadow-md transition">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi Formulir Online Sekarang</span>
                </span>
            </a>

            {{-- Card 2: Hubungi Admin via WhatsApp --}}
            @php
                $cleanHotline2 = preg_replace('/[^0-9]/', '', (string) ($settings['hotline_2_phone'] ?? '081278901950'));
                if (str_starts_with($cleanHotline2, '0')) {
                    $cleanHotline2 = '62' . substr($cleanHotline2, 1);
                }
            @endphp
            <a href="https://wa.me/{{ $cleanHotline }}?text={{ urlencode('Halo Panitia PSB Pondok Pesantren Raudhatul Ulum Sakatiga, saya ingin berkonsultasi mengenai pendaftaran santri baru.') }}" target="_blank" class="group bg-white p-8 rounded-3xl border-2 border-emerald-200 hover:border-[#00913e] shadow-md hover:shadow-2xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-green-50 text-[#00913e] flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-brands fa-whatsapp text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-950 group-hover:text-[#00913e] transition">
                            Konsultasi via WhatsApp
                        </h3>
                        <p class="text-xs text-slate-700 font-medium mt-2 leading-relaxed">
                            Konfirmasi pendaftaran, pengiriman bukti transfer formulir, atau konsultasi langsung dengan panitia PSB: <strong>{{ $settings['hotline_phone'] ?? '0812-7890-1950' }} ({{ $settings['hotline_name'] ?? 'Admin PSB' }})</strong>
                            @if(!empty($settings['hotline_2_phone']))
                                atau <strong>{{ $settings['hotline_2_phone'] }} ({{ $settings['hotline_2_name'] ?? 'Sekretariat' }})</strong>.
                            @endif
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#007532] text-white text-xs font-black px-7 py-3.5 rounded-2xl shadow-md transition">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Chat WhatsApp Panitia ({{ $settings['hotline_phone'] ?? '0812-7890-1950' }})</span>
                </span>
            </a>

        </div>

        {{-- UCAPAN TERIMA KASIH & DOKUMENTASI KAMPUS PPRU --}}
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-md border border-slate-200/80 text-center space-y-6">
            <div>
                <h3 class="text-xl sm:text-2xl font-black text-[#da251c] tracking-tight">
                    {{ $settings['closing_title'] ?? 'Terima Kasih Sudah Mendaftar di Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                </h3>
                <p class="text-xs sm:text-sm font-semibold text-[#00913e] mt-2 max-w-2xl mx-auto leading-relaxed">
                    {{ $settings['closing_desc'] ?? 'Semoga Ananda kelak bisa menjadi anak yang cerdas, sholeh/ah, berbakti kepada orang tua dan menjadi kebanggaan bagi agama, bangsa dan negara. Aamiin' }}
                </p>
            </div>

            {{-- Dokumentasi Fasilitas Pesantren --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/campus-robbani.webp" alt="Kampus Pondok Pesantren Raudhatul Ulum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/activities-robbani.webp" alt="Aktivitas Santri Raudhatul Ulum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ppru-haflah.webp" alt="Aula dan Gedung Pertemuan Pesantren" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200">
                <p class="text-xs font-black text-slate-800 uppercase tracking-widest">
                    Mendidik Sepenuh Cinta &bull; Menuju Khoiru Ummah
                </p>
                <div class="mt-2 text-xs font-extrabold text-[#00913e] tracking-wider uppercase">
                    Pondok Pesantren Raudhatul Ulum Sakatiga &bull; Ogan Ilir, Sumatera Selatan
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
