@extends('layouts.frontend')

@section('title', 'Infaq Pembangunan & Beasiswa Pendidikan - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Salurkan infaq pembangunan sarana laboratorium sains, asrama santri, dan beasiswa pendidikan dhuafa berprestasi melalui rekening resmi Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
@php
    $bank1Name = $siteSettings['donation_bank_1_name'] ?? 'Bank Sumsel Babel Syariah';
    $bank1Code = $siteSettings['donation_bank_1_code'] ?? '120';
    $bank1Rek = trim($siteSettings['donation_bank_1_rekening'] ?? '');
    $bank1Holder = $siteSettings['donation_bank_1_holder'] ?? 'YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)';
    $bank1Badge = $siteSettings['donation_bank_1_badge'] ?? 'Bank Utama Wilayah';
    $bank1Note = $siteSettings['donation_bank_1_note'] ?? 'Mitra Resmi Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS)';
    $bank1Btn = $siteSettings['donation_bank_1_btn_text'] ?? 'Salin Nomor Rekening';

    $bank2Name = $siteSettings['donation_bank_2_name'] ?? 'Bank Syariah Indonesia (BSI)';
    $bank2Code = $siteSettings['donation_bank_2_code'] ?? '451';
    $bank2Rek = trim($siteSettings['donation_bank_2_rekening'] ?? '801-0900-1950');
    $bank2Holder = $siteSettings['donation_bank_2_holder'] ?? 'PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA';
    $bank2Badge = $siteSettings['donation_bank_2_badge'] ?? 'Bank Syariah Nasional';
    $bank2Note = $siteSettings['donation_bank_2_note'] ?? 'Jaringan Perbankan Syariah Nasional';
    $bank2Btn = $siteSettings['donation_bank_2_btn_text'] ?? 'Salin Nomor Rekening';

    $bank3Name = $siteSettings['donation_bank_3_name'] ?? '';
    $bank3Code = $siteSettings['donation_bank_3_code'] ?? '';
    $bank3Rek = trim($siteSettings['donation_bank_3_rekening'] ?? '');
    $bank3Holder = $siteSettings['donation_bank_3_holder'] ?? '';
    $bank3Badge = $siteSettings['donation_bank_3_badge'] ?? 'Rekening Tambahan';
    $bank3Note = $siteSettings['donation_bank_3_note'] ?? '';
    $bank3Btn = $siteSettings['donation_bank_3_btn_text'] ?? 'Salin Nomor Rekening';

    $confirmPhone = !empty($siteSettings['donation_confirm_phone']) ? $siteSettings['donation_confirm_phone'] : ($siteSettings['contact_phone'] ?? '081278901950');
    $cleanWa = preg_replace('/[^0-9]/', '', $confirmPhone);
    if (str_starts_with($cleanWa, '0')) {
        $cleanWa = '62' . substr($cleanWa, 1);
    }
    $rawConfirmText = $siteSettings['donation_confirm_text'] ?? "Assalamu'alaikum Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga, saya telah menyalurkan infaq / donasi pendidikan untuk kemaslahatan sekolah.";
    $confirmText = urlencode($rawConfirmText);
@endphp

{{-- HERO HEADER ELEGAN --}}
<div class="relative bg-gradient-to-br from-emerald-950 via-[#00913e] to-emerald-900 text-white py-14 sm:py-20 overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#da251c_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-orange-500/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-amber-500/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="text-xs text-emerald-200 mb-4 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-medium">Infaq Pendidikan</span>
        </nav>
        <div class="max-w-3xl">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-orange-500/20 text-amber-300 border border-orange-500/30 mb-4">
                <i class="fa-solid fa-hand-holding-heart mr-2"></i> {{ $siteSettings['donation_hero_badge'] ?? 'Infaq & Shadaqah Jariyah' }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
                {{ $siteSettings['donation_hero_title'] ?? 'Infaq Pembangunan & Beasiswa PPRU' }}
            </h1>
            <p class="text-sm sm:text-base text-emerald-100 mt-4 leading-relaxed font-light">
                {{ $siteSettings['donation_hero_subtitle'] ?? 'Mari bergotong royong membangun sarana laboratorium riset modern, masjid pondok, fasilitas asrama tahfidz, dan program beasiswa bagi santri berprestasi di Pondok Pesantren Raudhatul Ulum Sakatiga.' }}
            </p>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-20 space-y-12">

    {{-- KUTIPAN AYAT INSPIRATIF --}}
    <div class="bg-white/95 backdrop-blur-md p-6 sm:p-8 rounded-3xl shadow-xl border border-gray-100 text-center reveal-fade-up">
        <p class="text-sm sm:text-base text-gray-800 italic font-medium leading-relaxed max-w-4xl mx-auto">
            "{{ $siteSettings['donation_quote_text'] ?? 'Perumpamaan orang-orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan sebutir benih yang menumbuhkan tujuh bulir, pada tiap-tiap bulir seratus biji. Allah melipatgandakan bagi siapa yang Dia kehendaki.' }}"
        </p>
        <span class="block text-xs font-bold text-[#00913e] tracking-wider uppercase mt-3">{{ $siteSettings['donation_quote_ref'] ?? '(QS. Al-Baqarah: 261)' }}</span>
    </div>

    {{-- KARTU REKENING BANK & KONFIRMASI --}}
    <div class="space-y-6">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-extrabold text-orange-500 uppercase tracking-wider block">{{ $siteSettings['donation_section_tag'] ?? 'Rekening Resmi Sekolah' }}</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight mt-1">
                {{ $siteSettings['donation_section_title'] ?? 'Penyaluran Infaq & Wakaf Pendidikan' }}
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
                {{ $siteSettings['donation_section_desc'] ?? 'Silakan salurkan infaq dan sedekah jariyah Anda melalui rekening perbankan resmi berikut:' }}
            </p>
            <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        </div>

        <div class="grid grid-cols-1 {{ !empty($bank3Rek) ? 'lg:grid-cols-3' : 'lg:grid-cols-2' }} gap-8">
            
            {{-- KARTU 1 --}}
            <div class="bg-gradient-to-br from-white via-emerald-50/40 to-emerald-50/70 rounded-3xl p-7 sm:p-9 shadow-xl border-2 border-emerald-300/80 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:shadow-2xl transition duration-300 reveal-fade-up">
                <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-emerald-400/10 blur-2xl pointer-events-none"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black tracking-wide uppercase bg-[#00913e] text-white shadow-sm">
                            <i class="fa-solid fa-crown mr-1.5 text-xs"></i> {{ $bank1Badge }}
                        </span>
                        <span class="text-xs font-mono font-bold text-emerald-800 bg-emerald-100/80 px-2.5 py-1 rounded-lg">
                            Kode: {{ $bank1Code }}
                        </span>
                    </div>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-700 text-white flex items-center justify-center text-2xl shadow-lg shadow-emerald-600/20 flex-shrink-0">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 leading-tight">{{ $bank1Name }}</h3>
                            <p class="text-xs text-emerald-800 font-semibold mt-0.5">{{ $bank1Note }}</p>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur-sm p-4 sm:p-5 rounded-2xl border border-emerald-200/80 shadow-inner mt-4 space-y-2">
                        <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider block">Nomor Rekening Infaq</span>
                        @if(!empty($bank1Rek))
                            <div class="flex items-center justify-between">
                                <span class="text-2xl sm:text-3xl font-black text-gray-900 font-mono tracking-wider select-all" id="rekBank1">{{ $bank1Rek }}</span>
                            </div>
                        @else
                            <div class="py-2">
                                <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-amber-100/80 text-amber-900 text-xs font-semibold border border-amber-200">
                                    <i class="fa-solid fa-clock-rotate-left mr-2 text-amber-700"></i>
                                    <span>Nomor rekening sedang dalam proses pembaruan resmi</span>
                                </div>
                            </div>
                        @endif
                        <p class="text-xs text-gray-700 pt-1 border-t border-gray-100">
                            a.n. <strong class="text-gray-900 font-black">{{ $bank1Holder }}</strong>
                        </p>
                    </div>
                </div>

                <div class="pt-2">
                    @if(!empty($bank1Rek))
                        <button onclick="copyToClipboard('{{ $bank1Rek }}', '{{ $bank1Name }}')" class="w-full bg-gradient-to-r from-emerald-600 to-[#00913e] hover:from-emerald-700 hover:to-emerald-800 text-white py-3.5 px-4 rounded-xl text-xs sm:text-sm font-bold shadow-lg shadow-emerald-600/20 transition flex items-center justify-center space-x-2 cursor-pointer">
                            <i class="fa-regular fa-copy text-sm"></i>
                            <span>{{ $bank1Btn }}</span>
                        </button>
                    @else
                        <a href="https://wa.me/{{ $cleanWa }}?text={{ $confirmText }}" target="_blank" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3.5 px-4 rounded-xl text-xs sm:text-sm font-bold shadow transition flex items-center justify-center space-x-2">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Konfirmasi Rekening via WhatsApp</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- KARTU 2 --}}
            <div class="bg-gradient-to-br from-white via-orange-50/30 to-orange-50/60 rounded-3xl p-7 sm:p-9 shadow-xl border border-orange-200/80 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:shadow-2xl transition duration-300 reveal-fade-up delay-1">
                <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-orange-400/10 blur-2xl pointer-events-none"></div>
                
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black tracking-wide uppercase bg-orange-600 text-white shadow-sm">
                            <i class="fa-solid fa-moon mr-1.5 text-xs"></i> {{ $bank2Badge }}
                        </span>
                        <span class="text-xs font-mono font-bold text-orange-700 bg-orange-100/80 px-2.5 py-1 rounded-lg">
                            Kode: {{ $bank2Code }}
                        </span>
                    </div>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-orange-500/20 flex-shrink-0">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 leading-tight">{{ $bank2Name }}</h3>
                            <p class="text-xs text-orange-800 font-semibold mt-0.5">{{ $bank2Note }}</p>
                        </div>
                    </div>

                    <div class="bg-white/90 backdrop-blur-sm p-4 sm:p-5 rounded-2xl border border-orange-200/80 shadow-inner mt-4 space-y-2">
                        <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider block">Nomor Rekening Infaq</span>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl sm:text-3xl font-black text-gray-900 font-mono tracking-wider select-all" id="rekBank2">{{ $bank2Rek }}</span>
                        </div>
                        <p class="text-xs text-gray-700 pt-1 border-t border-gray-100">
                            a.n. <strong class="text-gray-900 font-black">{{ $bank2Holder }}</strong>
                        </p>
                    </div>
                </div>

                <div class="pt-2">
                    <button onclick="copyToClipboard('{{ $bank2Rek }}', '{{ $bank2Name }}')" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3.5 px-4 rounded-xl text-xs sm:text-sm font-bold shadow-lg shadow-orange-500/20 transition flex items-center justify-center space-x-2 cursor-pointer">
                        <i class="fa-regular fa-copy text-sm"></i>
                        <span>{{ $bank2Btn }}</span>
                    </button>
                </div>
            </div>

            {{-- KARTU 3 (OPSIONAL JIKA DIISI) --}}
            @if(!empty($bank3Rek))
                <div class="bg-gradient-to-br from-white via-cyan-50/30 to-cyan-50/60 rounded-3xl p-7 sm:p-9 shadow-xl border border-cyan-200/80 flex flex-col justify-between space-y-6 relative overflow-hidden group hover:shadow-2xl transition duration-300 reveal-fade-up delay-2">
                    <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-cyan-400/10 blur-2xl pointer-events-none"></div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black tracking-wide uppercase bg-cyan-700 text-white shadow-sm">
                                <i class="fa-solid fa-building-columns mr-1.5 text-xs"></i> {{ $bank3Badge }}
                            </span>
                            @if(!empty($bank3Code))
                                <span class="text-xs font-mono font-bold text-cyan-800 bg-cyan-100/80 px-2.5 py-1 rounded-lg">
                                    Kode: {{ $bank3Code }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-600 to-cyan-700 text-white flex items-center justify-center text-2xl shadow-lg shadow-cyan-600/20 flex-shrink-0">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-gray-900 leading-tight">{{ $bank3Name }}</h3>
                                @if(!empty($bank3Note))
                                    <p class="text-xs text-cyan-800 font-semibold mt-0.5">{{ $bank3Note }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white/90 backdrop-blur-sm p-4 sm:p-5 rounded-2xl border border-cyan-200/80 shadow-inner mt-4 space-y-2">
                            <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider block">Nomor Rekening Infaq</span>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl sm:text-3xl font-black text-gray-900 font-mono tracking-wider select-all" id="rekBank3">{{ $bank3Rek }}</span>
                            </div>
                            @if(!empty($bank3Holder))
                                <p class="text-xs text-gray-700 pt-1 border-t border-gray-100">
                                    a.n. <strong class="text-gray-900 font-black">{{ $bank3Holder }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2">
                        <button onclick="copyToClipboard('{{ $bank3Rek }}', '{{ $bank3Name }}')" class="w-full bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white py-3.5 px-4 rounded-xl text-xs sm:text-sm font-bold shadow-lg shadow-cyan-600/20 transition flex items-center justify-center space-x-2 cursor-pointer">
                            <i class="fa-regular fa-copy text-sm"></i>
                            <span>{{ $bank3Btn }}</span>
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- KARTU KONFIRMASI WHATSAPP & PANDUAN --}}
    <div class="bg-gradient-to-br from-emerald-700 via-[#00913e] to-emerald-800 text-white rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden reveal-fade-up">
        <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center relative z-10">
            <div class="md:col-span-2 space-y-3">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white border border-white/30">
                    <i class="fa-brands fa-whatsapp mr-1.5 text-sm"></i> {{ $siteSettings['donation_confirm_badge'] ?? 'Konfirmasi Infaq Cepat' }}
                </div>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight">
                    {{ $siteSettings['donation_confirm_title'] ?? 'Sudah Menyalurkan Infaq? Konfirmasi Sekarang' }}
                </h3>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-light">
                    {{ $siteSettings['donation_confirm_desc'] ?? 'Kirimkan bukti transfer Anda ke nomor WhatsApp bendahara sekolah agar donasi Anda tercatat secara akuntabel dan mendapatkan laporan berkala.' }}
                </p>
            </div>
            <div class="flex flex-col space-y-3">
                <a href="https://wa.me/{{ $cleanWa }}?text={{ $confirmText }}" target="_blank" class="w-full bg-white hover:bg-gray-100 text-[#00913e] font-extrabold text-xs sm:text-sm py-4 px-6 rounded-2xl shadow-xl transition transform hover:scale-105 flex items-center justify-center space-x-2 text-center">
                    <i class="fa-brands fa-whatsapp text-lg text-emerald-600"></i>
                    <span>{{ $siteSettings['donation_confirm_btn_text'] ?? 'Kirim Bukti Transfer' }} ({{ $confirmPhone }})</span>
                </a>
                <span class="text-[11px] text-emerald-200 text-center font-medium">{{ $siteSettings['donation_confirm_note'] ?? 'Layanan Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga' }}</span>
            </div>
        </div>
    </div>

    {{-- 3 LANGKAH MUDAH BERINFAQ --}}
    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100 reveal-fade-up space-y-8">
        <div class="text-center max-w-xl mx-auto">
            <h3 class="text-xl sm:text-2xl font-black text-gray-900">{{ $siteSettings['donation_steps_title'] ?? '3 Langkah Mudah Berinfaq Jariyah' }}</h3>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ $siteSettings['donation_steps_subtitle'] ?? 'Panduan singkat proses pengiriman dan konfirmasi infaq pendidikan' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 text-center space-y-3 hover:bg-emerald-50/50 hover:border-emerald-200 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00913e] font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                    1
                </div>
                <h4 class="font-extrabold text-sm text-gray-900">{{ $siteSettings['donation_step_1_title'] ?? 'Transfer Dana Infaq' }}</h4>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $siteSettings['donation_step_1_desc'] ?? 'Kirimkan donasi melalui Bank Sumsel Babel Syariah atau BSI rekening resmi sekolah.' }}
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 text-center space-y-3 hover:bg-emerald-50/50 hover:border-emerald-200 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00913e] font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                    2
                </div>
                <h4 class="font-extrabold text-sm text-gray-900">{{ $siteSettings['donation_step_2_title'] ?? 'Simpan Bukti Mutasi' }}</h4>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $siteSettings['donation_step_2_desc'] ?? 'Ambil tangkapan layar (screenshot) struk mutasi perbankan mobile banking atau ATM Anda.' }}
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 border border-gray-100 text-center space-y-3 hover:bg-emerald-50/50 hover:border-emerald-200 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00913e] font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                    3
                </div>
                <h4 class="font-extrabold text-sm text-gray-900">{{ $siteSettings['donation_step_3_title'] ?? 'Konfirmasi via WA' }}</h4>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ $siteSettings['donation_step_3_desc'] ?? 'Kirimkan bukti ke nomor WhatsApp sekolah untuk pencatatan dan penerbitan tanda terima resmi.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- TRANSPARANSI PENGELOLAAN DANA PENDIDIKAN --}}
    <div class="bg-emerald-50/80 border-l-4 border-[#00913e] p-6 sm:p-8 rounded-3xl shadow-sm text-xs sm:text-sm text-gray-700 space-y-3 reveal-fade-up">
        <h4 class="font-extrabold text-gray-900 flex items-center text-sm sm:text-base">
            <i class="fa-solid fa-scale-balanced mr-2.5 text-[#00913e] text-lg"></i>
            <span>{{ $siteSettings['donation_transparency_title'] ?? 'Akuntabilitas & Tata Kelola Infaq Yayasan' }}</span>
        </h4>
        <p class="leading-relaxed text-gray-600">
            {{ $siteSettings['donation_transparency_desc'] ?? 'Pengelolaan infaq pembangunan dan beasiswa pendidikan santri diatur secara profesional oleh Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS) dengan prinsip amanah, transparan, dan dapat dipertanggungjawabkan secara berkala.' }}
        </p>
        <ul class="list-disc list-inside space-y-1 text-gray-600 text-xs">
            <li>{{ $siteSettings['donation_transparency_point_1'] ?? '100% dana infaq pembangunan dialokasikan langsung untuk sarana belajar, laboratorium, dan masjid pondok.' }}</li>
            <li>{{ $siteSettings['donation_transparency_point_2'] ?? 'Program beasiswa disalurkan langsung kepada santri berprestasi dari keluarga prasejahtera dan dhuafa.' }}</li>
            <li>{{ $siteSettings['donation_transparency_point_3'] ?? 'Laporan keuangan disajikan secara berkala dalam forum komite dan rapat tahunan yayasan.' }}</li>
        </ul>
    </div>

</div>

{{-- TOAST NOTIFIKASI SALIN REKENING --}}
<div id="copyToast" class="fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3.5 rounded-2xl shadow-2xl text-xs font-semibold flex items-center space-x-3 transform translate-y-24 opacity-0 transition duration-300 z-50">
    <div class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center">
        <i class="fa-solid fa-check text-xs"></i>
    </div>
    <span id="copyToastText">Nomor rekening berhasil disalin!</span>
</div>

<script>
    function copyToClipboard(text, bankName) {
        if (!navigator.clipboard) {
            const temp = document.createElement('textarea');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
        } else {
            navigator.clipboard.writeText(text);
        }
        
        const toast = document.getElementById('copyToast');
        const toastText = document.getElementById('copyToastText');
        if (toast && toastText) {
            toastText.textContent = `Nomor rekening ${bankName} berhasil disalin!`;
            toast.classList.remove('translate-y-24', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 3000);
        }
    }
</script>
@endsection
