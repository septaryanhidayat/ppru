@extends('layouts.frontend')

@section('title', 'Permohonan Kerja Sama - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Formulir resmi dan persyaratan pengajuan kemitraan, MoU, program kolaborasi, sponsorship, dan kerjasama bersama Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<section class="relative bg-gradient-to-br from-[#005a28] via-[#00843d] to-[#043317] text-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute -right-12 -bottom-12 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-12 -top-12 w-80 h-80 bg-[#f59e0b]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto space-y-4 relative z-10">
        <nav class="text-xs text-emerald-200 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Beranda</span>
            </a>
            <span class="text-emerald-400">/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Publik</a>
            <span class="text-emerald-400">/</span>
            <span class="text-[#fcd116] font-bold">Kerja Sama</span>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-[#f59e0b] text-slate-950 flex items-center justify-center font-black text-2xl shadow-lg shrink-0">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-white">
                    Permohonan Kerja Sama
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 font-medium max-w-2xl leading-relaxed">
                    Kemitraan strategis dengan perguruan tinggi, lembaga dakwah, dunia usaha, dan instansi resmi bersama Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- MAIN CONTAINER --}}
<div class="bg-slate-50/60 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- JUDUL RESMI HALAMAN --}}
        <div class="text-center max-w-2xl mx-auto space-y-1.5">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#00843d] bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-100">
                Kemitraan &amp; Sinergi
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#00843d] tracking-tight uppercase">
                PERMOHONAN KERJA SAMA
            </h2>
            <p class="text-xs sm:text-sm font-bold text-gray-700">
                Pondok Pesantren Raudhatul Ulum Sakatiga
            </p>
            <div class="w-16 h-1 bg-[#f59e0b] mx-auto rounded-full mt-2"></div>
        </div>

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="bg-emerald-50 border-2 border-[#00843d] rounded-3xl p-6 sm:p-8 text-center space-y-4 shadow-xl animate-fadeIn">
                <div class="w-16 h-16 rounded-full bg-[#00843d] text-white flex items-center justify-center text-3xl mx-auto shadow-md">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h3 class="font-black text-xl text-emerald-950">Permohonan Kerja Sama Terkirim!</h3>
                <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto leading-relaxed">
                    {{ session('success') }}
                </p>
                @if(session('wa_url'))
                    <div class="pt-2">
                        <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-emerald-800 text-white font-black text-xs sm:text-sm px-7 py-3.5 rounded-full shadow-lg transition transform hover:scale-105">
                            <i class="fa-brands fa-whatsapp text-lg text-emerald-300"></i>
                            <span>Konfirmasi WhatsApp Pimpinan / Humas</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- DETAIL PERSYARATAN & INFORMASI PELAYANAN (ACCORDION RESMI & MODERN) --}}
        <div class="bg-white rounded-3xl border border-gray-200/80 overflow-hidden shadow-sm" x-data="{ activeTab: 0 }">
            <div class="p-5 sm:p-6 bg-gradient-to-r from-emerald-50/80 to-white border-b border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#00843d]">Informasi Lengkap</span>
                    <h3 class="text-base sm:text-lg font-black text-gray-900 mt-0.5">Ketentuan Permohonan Kerja Sama</h3>
                </div>
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-sm shadow-xs">
                    <i class="fa-solid fa-handshake"></i>
                </div>
            </div>

            @php
                $defaultKerjasamaTabs = [
                    [
                        'icon' => 'fa-solid fa-list-check',
                        'title' => 'Persyaratan Pelayanan',
                        'content' => '<ul><li>Surat permohonan dari Pemerintah/Swasta/Industri/Yayasan/Organisasi/Instansi lainnya</li><li>Surat permohonan dari Individu (perorangan)</li><li>Proposal kerja sama resmi yang memuat profil lembaga, latar belakang, dan bentuk kemitraan yang diharapkan</li><li>Identitas resmi penanggung jawab (KTP / Paspor)</li></ul>'
                    ],
                    [
                        'icon' => 'fa-solid fa-gears',
                        'title' => 'Sistem Mekanisme dan Prosedur',
                        'content' => '<ul><li>Pemohon mengajukan proposal dan mengisi form online di website resmi</li><li>Sekretariat dan tim kerja sama menelaah kesesuaian program</li><li>Koordinasi teknis / audiensi bersama Mudir atau pimpinan bidang</li><li>Penandatanganan Nota Kesepahaman (MoU) dan realisasi program</li></ul>'
                    ],
                    [
                        'icon' => 'fa-solid fa-clock',
                        'title' => 'Jangka Waktu Penyelesaian',
                        'content' => '<p>Waktu respon atas permohonan paling lambat 10 (sepuluh) hari kerja</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-hand-holding-dollar',
                        'title' => 'Biaya dan Tarif',
                        'content' => '<p class="font-bold text-emerald-800">Proses permohonan dan pengajuan kerja sama tidak dipungut biaya (Gratis)</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-file-circle-check',
                        'title' => 'Produk Layanan',
                        'content' => '<p>Nota Kesepahaman (MoU), Surat Perjanjian Kerja Sama (PKS), dan kemitraan resmi</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-headset',
                        'title' => 'Pengaduan, Saran dan Masukan',
                        'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian humas dan media layanan terpadu Pondok Pesantren Raudhatul Ulum Sakatiga</p><p class="mt-2"><strong>Alamat :</strong> Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan</p><p><strong>No. HP (WA) :</strong> <a href="https://wa.me/6281278901950" target="_blank" class="text-emerald-700 font-bold hover:underline">0812-7890-1950</a></p><p><strong>Website :</strong> ppru.ac.id</p><p><strong>Email :</strong> <a href="mailto:sekretariat@ppru.ac.id" class="text-emerald-700 font-bold hover:underline">sekretariat@ppru.ac.id</a></p>'
                    ]
                ];
                $tabs = !empty($accordions) ? $accordions : $defaultKerjasamaTabs;
            @endphp

            <div class="divide-y divide-gray-100">
                @foreach($tabs as $idx => $tab)
                    <div class="transition">
                        <button type="button" @click="activeTab = (activeTab === {{ $idx }} ? -1 : {{ $idx }})" class="w-full py-4 px-6 text-left flex items-center justify-between hover:bg-emerald-50/40 focus:outline-none transition select-none">
                            <span class="flex items-center space-x-3">
                                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-[#00843d] flex items-center justify-center text-xs font-black shrink-0">
                                    <i class="{{ $tab['icon'] ?? 'fa-solid fa-circle-info' }}"></i>
                                </span>
                                <span class="font-bold text-xs sm:text-sm text-gray-900 tracking-tight">{{ $tab['title'] }}</span>
                            </span>
                            <span class="flex items-center space-x-2">
                                <span class="text-xs font-bold text-[#00843d]" x-text="activeTab === {{ $idx }} ? 'Tutup' : 'Buka'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 transform transition-transform duration-200" :class="activeTab === {{ $idx }} ? 'rotate-180 text-[#00843d]' : ''"></i>
                            </span>
                        </button>
                        <div x-show="activeTab === {{ $idx }}" x-collapse class="px-6 pb-5 pt-1 text-xs sm:text-sm text-gray-700 leading-relaxed border-t border-gray-100 bg-slate-50/50">
                            <div class="prose prose-sm max-w-none text-gray-700 [&>ul]:list-disc [&>ul]:pl-5 [&>ul]:space-y-1 [&>p]:mb-2">
                                {!! $tab['content'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- JUDUL FORMULIR --}}
        <div class="text-center pt-2">
            <h3 class="text-xl sm:text-2xl font-black text-[#00843d] tracking-tight">
                Silahkan isi Form dibawah ini
            </h3>
            <p class="text-xs text-gray-500 mt-1">Lengkapi rincian usulan kemitraan dan dokumen pendukung</p>
        </div>

        {{-- FORM CONTAINER MODERN --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-md space-y-6">
            <form action="{{ route('layanan.kerjasama.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="_hp_security_check" value="">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- 1. Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-user text-xs"></i>
                            </span>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Nama Lengkap" class="w-full bg-slate-50 text-xs sm:text-sm text-gray-800 rounded-xl pl-9 pr-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                        </div>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- 2. Asal Instansi --}}
                    <div>
                        <label for="agency" class="block text-xs font-bold text-gray-700 mb-1.5">
                            Asal Instansi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-building text-xs"></i>
                            </span>
                            <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" placeholder="Asal Instansi" class="w-full bg-slate-50 text-xs sm:text-sm text-gray-800 rounded-xl pl-9 pr-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                        </div>
                        @error('agency') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- 3. Nomor WhatsApp --}}
                <div>
                    <label for="whatsapp" class="block text-xs font-bold text-gray-700 mb-1.5">
                        Nomor WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </span>
                        <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" placeholder="Contoh: 081278901950" class="w-full bg-slate-50 text-xs sm:text-sm text-gray-800 rounded-xl pl-9 pr-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                    </div>
                    @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- 4. Keperluan --}}
                <div>
                    <label for="purpose" class="block text-xs font-bold text-gray-700 mb-1.5">
                        Keperluan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="purpose" id="purpose" rows="3" required placeholder="Keperluan" class="w-full bg-slate-50 text-xs sm:text-sm text-gray-800 rounded-xl p-3.5 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition leading-relaxed">{{ old('purpose') }}</textarea>
                    @error('purpose') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- 5 & 6. Upload Dokumen --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-gray-300">
                        <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                            <span>Sertakan Surat <span class="text-red-500">*</span></span>
                            <span class="text-[10px] text-gray-400">PDF / DOC / Image</span>
                        </label>
                        <input type="file" name="letter_file" required accept=".pdf,.doc,.docx,image/*" class="w-full text-xs text-slate-700 font-medium file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 file:cursor-pointer transition">
                        @error('letter_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-gray-300">
                        <label class="block text-xs font-bold text-gray-800 mb-1 flex items-center justify-between">
                            <span>Sertakan KTP <span class="text-red-500">*</span></span>
                            <span class="text-[10px] text-gray-400">JPG / PNG / PDF</span>
                        </label>
                        <input type="file" name="ktp_file" required accept="image/*,.pdf" class="w-full text-xs text-slate-700 font-medium file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 file:cursor-pointer transition">
                        @error('ktp_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-3">
                    <button type="submit" class="w-full bg-[#00843d] hover:bg-emerald-800 text-white font-black text-sm py-3.5 rounded-2xl shadow-lg hover:shadow-xl transition cursor-pointer uppercase tracking-wider flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>KIRIM</span>
                    </button>
                    <p class="text-[11px] text-gray-400 text-center mt-2 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                        <span>Pengajuan akan langsung ditindaklanjuti oleh Bagian Humas &amp; Kerjasama PPRU Sakatiga.</span>
                    </p>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
