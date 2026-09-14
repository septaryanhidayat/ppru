@extends('layouts.frontend')

@section('title', 'Permohonan Kerja Sama - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Formulir resmi dan persyaratan pengajuan kemitraan, MoU, program kolaborasi, beasiswa, dan kerjasama bersama Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- 1. COMPACT HERO HEADER --}}
<section class="relative bg-gradient-to-r from-emerald-950 via-[#00843d] to-emerald-900 text-white py-8 sm:py-10 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-6xl mx-auto relative z-10 space-y-2">
        <nav class="text-xs text-emerald-200 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Beranda</span>
            </a>
            <span class="text-emerald-400">/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Terpadu</a>
            <span class="text-emerald-400">/</span>
            <span class="text-[#fcd116] font-bold">Kerja Sama</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
            <div class="flex items-center space-x-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-xl shadow-md shrink-0">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black tracking-tight text-white uppercase">
                        PERMOHONAN KERJA SAMA
                    </h1>
                    <p class="text-xs text-emerald-100 font-normal">
                        Kemitraan Lembaga, Perguruan Tinggi, CSR Dunia Usaha &bull; PPRU Sakatiga
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-xs text-xs font-semibold text-emerald-200 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Kemitraan Terbuka
                </span>
            </div>
        </div>
    </div>
</section>

{{-- 2. MAIN SPLIT INTERFACE --}}
<div class="bg-slate-50/70 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="bg-emerald-50 border-2 border-[#00843d] rounded-3xl p-6 mb-8 text-center space-y-3 shadow-lg animate-fadeIn">
                <div class="w-12 h-12 rounded-full bg-[#00843d] text-white flex items-center justify-center text-2xl mx-auto shadow-md">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h3 class="font-black text-lg text-emerald-950">Permohonan Kerja Sama Terkirim!</h3>
                <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto leading-relaxed">
                    {{ session('success') }}
                </p>
                @if(session('wa_url'))
                    <div class="pt-1">
                        <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold text-xs px-6 py-3 rounded-full shadow transition">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Konfirmasi WhatsApp Pimpinan / Humas</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- TWO-COLUMN BALANCED GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            {{-- KOLOM KIRI (5 Kolom): SATU KOTAK CARD TERPADU (PERSYARATAN, PROSEDUR, WAKTU, BIAYA, PENGADUAN) --}}
            <div class="lg:col-span-5 flex flex-col">
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-md flex flex-col justify-between flex-1 space-y-5" x-data="{ activeTab: 0 }">
                    
                    <div class="space-y-4">
                        {{-- Header Card --}}
                        <div class="pb-3 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-100">
                                    Sinergi &amp; Kemitraan
                                </span>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight mt-1">
                                    Informasi Kerja Sama
                                </h3>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold shadow-xs">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                        </div>

                        {{-- Tab Switcher Pills --}}
                        @php
                            $accordionList = !empty($accordions) ? $accordions : [];
                        @endphp

                        @if(!empty($accordionList))
                            <div class="flex flex-wrap gap-1 p-1 bg-slate-100/90 rounded-2xl border border-slate-200/60">
                                @foreach($accordionList as $idx => $tab)
                                    <button type="button" 
                                            @click="activeTab = {{ $idx }}" 
                                            :class="activeTab === {{ $idx }} ? 'bg-[#00843d] text-white shadow-xs font-bold' : 'text-slate-600 hover:text-slate-900 font-medium hover:bg-white/60'" 
                                            class="flex-1 min-w-[85px] text-[11px] py-1.5 px-2 rounded-xl transition text-center truncate cursor-pointer select-none">
                                        {{ $tab['title'] }}
                                    </button>
                                @endforeach
                            </div>

                            {{-- Tab Content Box --}}
                            <div class="bg-slate-50/70 rounded-2xl p-4 sm:p-5 border border-slate-200/70 min-h-[260px] max-h-[460px] overflow-y-auto">
                                @foreach($accordionList as $idx => $tab)
                                    <div x-show="activeTab === {{ $idx }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-2.5">
                                        <div class="flex items-center space-x-2 pb-2 border-b border-slate-200/80">
                                            <span class="w-5 h-5 rounded-md bg-emerald-100 text-[#00843d] flex items-center justify-center text-[10px] font-black">
                                                <i class="fa-solid fa-check"></i>
                                            </span>
                                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">{{ $tab['title'] }}</h4>
                                        </div>
                                        <div class="text-xs text-slate-600 leading-relaxed prose prose-sm max-w-none [&>ul]:list-disc [&>ul]:pl-5 [&>ul]:space-y-1 [&>ol]:list-decimal [&>ol]:pl-5 [&>p]:mb-1.5">
                                            {!! $tab['content'] !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Helpdesk Pimpinan / Humas Footer inside the same card --}}
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-950 to-slate-950 text-white flex items-center justify-between gap-3 shadow-sm border border-emerald-900/40 mt-auto">
                        <div class="flex items-center space-x-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-xl shrink-0"></i>
                            <div class="text-[11px] leading-tight">
                                <span class="font-bold text-white block">Audiensi Pimpinan</span>
                                <span class="text-emerald-200 text-[10px]">WhatsApp: 0812-7890-1950</span>
                            </div>
                        </div>
                        <a href="https://wa.me/6281278901950?text={{ urlencode('Assalamu\'alaikum Humas PPRU Sakatiga, kami dari instansi ingin mengajukan permohonan audiensi kerja sama.') }}" target="_blank" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white text-[11px] font-bold px-3 py-1.5 rounded-xl transition shrink-0 shadow-sm flex items-center gap-1">
                            <span>Chat WA</span>
                            <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>

                </div>
            </div>

            {{-- KOLOM KANAN (7 Kolom): FORMULIR PENGAJUAN PROPOSAL --}}
            <div class="lg:col-span-7 flex flex-col">
                <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-9 border border-slate-200/90 shadow-md space-y-6 flex-1 flex flex-col justify-between">
                    
                    <div class="pb-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-amber-700 block">Formulir Kemitraan</span>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mt-0.5">
                                Formulir Pengajuan Kerja Sama
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Kirimkan rincian profil lembaga dan lampiran proposal kerja sama Anda.</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm shrink-0 border border-amber-100" title="Koneksi Aman">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>

                    <form action="{{ route('layanan.kerjasama.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_hp_security_check" value="">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- 1. Nama Narahubung --}}
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Lengkap Penanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-user-tie text-xs"></i>
                                    </span>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Nama lengkap Anda &amp; gelar" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                                </div>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- 2. Nama Instansi / Perusahaan --}}
                            <div>
                                <label for="agency" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Instansi / Perusahaan / Lembaga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-building-flag text-xs"></i>
                                    </span>
                                    <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" placeholder="Nama instansi/perusahaan Anda" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                                </div>
                                @error('agency') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- 3. Nomor WhatsApp --}}
                        <div>
                            <label for="whatsapp" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nomor WhatsApp / Telepon Kantor <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                </span>
                                <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" placeholder="Contoh: 081278901950" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                            </div>
                            @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- 4. Rencana Kerja Sama --}}
                        <div>
                            <label for="purpose" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Ruang Lingkup &amp; Rencana Program Kerja Sama <span class="text-red-500">*</span>
                            </label>
                            <textarea name="purpose" id="purpose" rows="4" required placeholder="Jelaskan garis besar usulan kemitraan, manfaat timbal balik, target waktu pelaksanaan, dan pihak-pihak terkait..." class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition leading-relaxed">{{ old('purpose') }}</textarea>
                            @error('purpose') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- 5 & 6. Upload Proposal & Identitas --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-slate-300 hover:border-[#00843d] transition">
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    <span>Sertakan Surat Proposal Kerja Sama</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <p class="text-[10px] text-slate-400 mb-2">Format PDF / DOC (Maks 5 MB)</p>
                                <input type="file" name="letter_file" required accept=".pdf,.doc,.docx" class="w-full text-xs text-slate-700 font-medium file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 file:cursor-pointer transition">
                                @error('letter_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-slate-300 hover:border-[#00843d] transition">
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    <span>Sertakan KTP Penanggung Jawab / Legalitas</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <p class="text-[10px] text-slate-400 mb-2">Format JPG / PNG / PDF (Maks 5 MB)</p>
                                <input type="file" name="ktp_file" required accept="image/*,.pdf" class="w-full text-xs text-slate-700 font-medium file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 file:cursor-pointer transition">
                                @error('ktp_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[#00843d] hover:bg-emerald-800 text-white font-black text-sm py-4 rounded-2xl shadow-lg shadow-emerald-600/20 hover:shadow-xl transition cursor-pointer flex items-center justify-center space-x-2 transform hover:scale-[1.01]">
                                <i class="fa-solid fa-handshake text-sm"></i>
                                <span>Kirim Permohonan Kerja Sama</span>
                            </button>
                            <p class="text-[11px] text-slate-400 text-center mt-2.5 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                <span>Proposal Anda akan ditelaah oleh tim Sekretariat &amp; Pimpinan Yayasan PPRU.</span>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
