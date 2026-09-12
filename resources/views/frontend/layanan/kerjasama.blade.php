@extends('layouts.frontend')

@section('title', 'Permohonan Kerja Sama - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Formulir resmi dan persyaratan pengajuan kemitraan, MoU, program kolaborasi, sponsorship, dan kerjasama bersama SMA IT Ishlahul Ummah Prabumulih.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-10 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Publik</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Kerja Sama</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-handshake"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Permohonan Kerja Sama</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Kemitraan strategis dengan perguruan tinggi, lembaga dakwah, dunia usaha, dan instansi resmi.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-14 space-y-10">

    {{-- JUDUL RESMI HALAMAN (SESUAI ELEMENTOR ORIGINAL) --}}
    <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#00913e] tracking-tight uppercase">
            PERMOHONAN KERJA SAMA
        </h2>
        <p class="text-sm sm:text-base font-bold text-[#da251c] mt-1">
            SMA Islam Terpadu Ishlahul Ummah Prabumulih
        </p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-2 border-[#00913e] rounded-3xl p-6 sm:p-8 text-center space-y-4 shadow-lg animate-fadeIn">
            <div class="w-16 h-16 rounded-full bg-[#00913e] text-white flex items-center justify-center text-2xl mx-auto shadow-md">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="font-extrabold text-xl text-emerald-950">Permohonan Kerja Sama Terkirim!</h3>
            <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto leading-relaxed">
                {{ session('success') }}
            </p>
            @if(session('wa_url'))
                <div class="pt-2">
                    <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-emerald-700 text-white font-extrabold text-xs sm:text-sm px-6 py-3 rounded-full shadow-lg transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Konfirmasi WhatsApp Pimpinan / Humas</span>
                    </a>
                </div>
            @endif
        </div>
    @endif

    {{-- DETAIL PERSYARATAN & INFORMASI PELAYANAN (ACCORDION RESMI) --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm" x-data="{ activeTab: 0 }">
        @php
            $defaultKerjasamaTabs = [
                [
                    'title' => 'Persyaratan Pelayanan',
                    'content' => '<ul><li>Surat permohonan dari Pemerintah/Swasta/Industri/Yayasan/Organisasi/Instansi lainnya.</li><li>Surat permohonan dari Individu (perorangan)</li></ul>'
                ],
                [
                    'title' => 'Sistem Mekanisme dan Prosedur',
                    'content' => '<ul><li>Calon mitra mengajukan surat permohonan ditujukan kepada Kepala Sekolah</li><li>KS memberikan disposisi kepada TU, selanjutnya TU dan/atau unit kerja terkait melakukan penilaian kepada calon mitra. Jika disetujui, dilanjutkan dengan pembahasan draft dokumen kerja sama. Jika tidak disetujui, TU akan memberikan surat balasan kepada mitra.</li><li>Pembahasan dan negosiasi draft dokumen kerja sama.</li><li>Pengesahan naskah perjanjian kerja sama.</li></ul>'
                ],
                [
                    'title' => 'Jangka Waktu Penyelesaian',
                    'content' => '<p>Waktu respon atas permohonan paling lambat 10 (sepuluh) hari kerja</p>'
                ],
                [
                    'title' => 'Biaya dan Tarif',
                    'content' => '<p>Gratis</p>'
                ],
                [
                    'title' => 'Produk Layanan',
                    'content' => '<p>Naskah perjanjian kerja sama</p>'
                ],
                [
                    'title' => 'Pengaduan, Saran dan Masukan',
                    'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian humas dan media layanan terpadu SMA IT Ishlahul Ummah Prabumulih</p><p class="mt-2"><strong>Alamat :</strong> Jln. Sadewa RT 01 RW 03 Kel. Krg Raja Prabumulih Timur</p><p><strong>No. HP (WA) :</strong> <a href="https://wa.me/6282182680647" target="_blank" class="text-emerald-600 font-bold hover:underline">0821-8268-0647</a></p><p><strong>Website :</strong> smaitishumpbm.sch.id</p><p><strong>Email :</strong> <a href="mailto:smaitishlahulummah2019@gmail.com" class="text-emerald-600 font-bold hover:underline">smaitishlahulummah2019@gmail.com</a></p>'
                ]
            ];
            $tabs = !empty($accordions) ? $accordions : $defaultKerjasamaTabs;
        @endphp

        <div class="divide-y divide-gray-200">
            @foreach($tabs as $idx => $tab)
                <div class="transition">
                    <button type="button" @click="activeTab = (activeTab === {{ $idx }} ? -1 : {{ $idx }})" class="w-full py-4 px-6 text-left flex items-center justify-between hover:bg-gray-50 focus:outline-none transition select-none">
                        <span class="flex items-center space-x-3">
                            <span class="text-[#00913e] font-extrabold text-lg leading-none" x-text="activeTab === {{ $idx }} ? '−' : '+'"></span>
                            <span class="font-extrabold text-sm sm:text-base text-[#00913e] tracking-tight">{{ $tab['title'] }}</span>
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400 transform transition-transform duration-200" :class="activeTab === {{ $idx }} ? 'rotate-180 text-[#00913e]' : ''"></i>
                    </button>
                    <div x-show="activeTab === {{ $idx }}" x-collapse class="px-6 pb-5 pt-1 text-xs sm:text-sm text-gray-700 leading-relaxed border-t border-gray-100 bg-gray-50/50">
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
        <h3 class="text-xl sm:text-2xl font-bold text-[#00913e]">
            Silahkan isi Form dibawah ini
        </h3>
    </div>

    {{-- FORM CONTAINER --}}
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-md space-y-6">
        <form action="{{ route('layanan.kerjasama.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Honeypot anti-spam protection --}}
            <input type="hidden" name="_hp_security_check" value="">

            {{-- 1. Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-bold text-gray-700 mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Nama Lengkap" class="w-full bg-white text-xs sm:text-sm text-gray-800 rounded-lg px-4 py-2.5 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-transparent transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 2. Asal Instansi --}}
            <div>
                <label for="agency" class="block text-xs font-bold text-gray-700 mb-1">
                    Asal Instansi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" placeholder="Asal Instansi" class="w-full bg-white text-xs sm:text-sm text-gray-800 rounded-lg px-4 py-2.5 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-transparent transition">
                @error('agency') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 3. Nomor WhatsApp --}}
            <div>
                <label for="whatsapp" class="block text-xs font-bold text-gray-700 mb-1">
                    Nomor WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" placeholder="Contoh: 082182680647" class="w-full bg-white text-xs sm:text-sm text-gray-800 rounded-lg px-4 py-2.5 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-transparent transition">
                @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 4. Keperluan --}}
            <div>
                <label for="purpose" class="block text-xs font-bold text-gray-700 mb-1">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea name="purpose" id="purpose" rows="3" required placeholder="Keperluan" class="w-full bg-white text-xs sm:text-sm text-gray-800 rounded-lg p-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:border-transparent transition leading-relaxed">{{ old('purpose') }}</textarea>
                @error('purpose') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 5. Sertakan Surat --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">
                    Sertakan Surat <span class="text-red-500">*</span>
                </label>
                <input type="file" name="letter_file" required accept=".pdf,.doc,.docx,image/*" class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                @error('letter_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 6. Sertakan KTP --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">
                    Sertakan KTP <span class="text-red-500">*</span>
                </label>
                <input type="file" name="ktp_file" required accept="image/*,.pdf" class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                @error('ktp_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-2">
                <button type="submit" class="w-full bg-[#00913e] hover:bg-emerald-700 text-white font-extrabold text-sm py-3 rounded-md shadow-md hover:shadow-lg transition cursor-pointer tracking-wider">
                    Send
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
