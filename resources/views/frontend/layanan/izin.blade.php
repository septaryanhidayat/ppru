@extends('layouts.frontend')

@section('title', 'Permohonan Izin Kunjungan ke Sekolah - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Formulir resmi dan prosedur permohonan izin kunjungan edukasi, studi banding, riset ilmiah, atau kunjungan instansi di Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- 1. COMPACT HERO HEADER --}}
<section class="relative bg-gradient-to-r from-emerald-950 via-[#00843d] to-emerald-900 text-white py-8 sm:py-10 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-7xl mx-auto relative z-10 space-y-2">
        <nav class="text-xs text-emerald-200 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Beranda</span>
            </a>
            <span class="text-emerald-400">/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Terpadu</a>
            <span class="text-emerald-400">/</span>
            <span class="text-[#fcd116] font-bold">Izin Kunjungan</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
            <div class="flex items-center space-x-3.5">
                <div class="w-11 h-11 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-black text-xl shadow-md shrink-0">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black tracking-tight text-white">
                        PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH
                    </h1>
                    <p class="text-xs text-emerald-100 font-normal">
                        Pondok Pesantren Raudhatul Ulum Sakatiga
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-xs text-xs font-semibold text-emerald-200 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Pelayanan Terbuka
                </span>
            </div>
        </div>
    </div>
</section>

{{-- 2. MAIN SPLIT INTERFACE --}}
<div class="bg-slate-50/70 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="bg-emerald-50 border-2 border-[#00843d] rounded-3xl p-6 mb-8 text-center space-y-3 shadow-lg animate-fadeIn">
                <div class="w-12 h-12 rounded-full bg-[#00843d] text-white flex items-center justify-center text-2xl mx-auto shadow-md">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h3 class="font-black text-lg text-emerald-950">Permohonan Berhasil Dikirim!</h3>
                <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto leading-relaxed">
                    {{ session('success') }}
                </p>
                @if(session('wa_url'))
                    <div class="pt-1">
                        <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold text-xs px-6 py-3 rounded-full shadow transition">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Konfirmasi via WhatsApp Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- TWO-COLUMN BALANCED GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            {{-- KOLOM KIRI (5 Kolom): SATU KOTAK CARD TERPADU (PERSYARATAN, WAKTU, BIAYA, PRODUK) --}}
            <div class="lg:col-span-5 flex flex-col">
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-md flex flex-col justify-between flex-1 space-y-6">
                    
                    <div class="space-y-5">
                        {{-- Header Card --}}
                        <div class="pb-3.5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100">
                                    Panduan &amp; Spesifikasi
                                </span>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight mt-1">
                                    Ketentuan &amp; Informasi Pelayanan
                                </h3>
                            </div>
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-sm font-bold shadow-xs">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                        </div>

                        {{-- Unified Specification Sections (No Truncated Tabs) --}}
                        @php
                            $accordionList = !empty($accordions) ? $accordions : [];
                            // Pisahkan Pengaduan untuk diletakkan di card bawah full-width
                            $specList = array_filter($accordionList, function($item) {
                                return !str_contains(strtolower($item['title'] ?? ''), 'pengaduan');
                            });
                        @endphp

                        <div class="space-y-4">
                            @foreach($specList as $item)
                                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/70 space-y-2">
                                    <div class="flex items-center space-x-2 pb-2 border-b border-slate-200/80">
                                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00843d] flex items-center justify-center text-xs font-black shrink-0">
                                            @if(str_contains(strtolower($item['title']), 'waktu'))
                                                <i class="fa-solid fa-clock text-[10px]"></i>
                                            @elseif(str_contains(strtolower($item['title']), 'biaya'))
                                                <i class="fa-solid fa-tags text-[10px]"></i>
                                            @elseif(str_contains(strtolower($item['title']), 'produk'))
                                                <i class="fa-solid fa-certificate text-[10px]"></i>
                                            @elseif(str_contains(strtolower($item['title']), 'prosedur') || str_contains(strtolower($item['title']), 'mekanisme'))
                                                <i class="fa-solid fa-diagram-project text-[10px]"></i>
                                            @else
                                                <i class="fa-solid fa-list-check text-[10px]"></i>
                                            @endif
                                        </span>
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 tracking-tight">{{ $item['title'] }}</h4>
                                    </div>
                                    <div class="text-xs text-slate-600 leading-relaxed prose prose-sm max-w-none [&>ul]:list-disc [&>ul]:pl-5 [&>ul]:space-y-1.5 [&>ol]:list-decimal [&>ol]:pl-5 [&>ol]:space-y-1.5 [&>p]:m-0">
                                        {!! $item['content'] !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Helpdesk Footer inside the same card --}}
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-950 to-slate-950 text-white flex items-center justify-between gap-3 shadow-sm border border-emerald-900/40 mt-auto">
                        <div class="flex items-center space-x-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-xl shrink-0"></i>
                            <div class="text-[11px] leading-tight">
                                <span class="font-bold text-white block">Pusat Bantuan Cepat</span>
                                <span class="text-emerald-200 text-[10px]">WhatsApp: 0812-7890-1950</span>
                            </div>
                        </div>
                        <a href="https://wa.me/6281278901950?text={{ urlencode('Assalamu\'alaikum Humas PPRU Sakatiga, saya ingin konsultasi terkait permohonan izin kunjungan.') }}" target="_blank" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white text-[11px] font-bold px-3 py-1.5 rounded-xl transition shrink-0 shadow-sm flex items-center gap-1">
                            <span>Chat WA</span>
                            <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>

                </div>
            </div>

            {{-- KOLOM KANAN (7 Kolom): FORMULIR PERMOHONAN DARING --}}
            <div class="lg:col-span-7 flex flex-col">
                <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-9 border border-slate-200/90 shadow-md space-y-6 flex-1 flex flex-col justify-between">
                    
                    <div class="pb-4 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 block">Formulir Daring</span>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight mt-0.5">
                                Isi Formulir Permohonan Izin
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Lengkapi identitas pemohon dan lampirkan dokumen pendukung.</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-sm shrink-0 border border-emerald-100" title="Koneksi Aman">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>

                    <form action="{{ route('layanan.izin.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="_hp_security_check" value="">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- 1. Nama Lengkap --}}
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Penanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-user text-xs"></i>
                                    </span>
                                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Nama lengkap Anda" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                                </div>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- 2. Asal Instansi --}}
                            <div>
                                <label for="agency" class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Asal Instansi / Lembaga / Sekolah <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-building text-xs"></i>
                                    </span>
                                    <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" placeholder="Nama instansi pengaju" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                                </div>
                                @error('agency') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- 3. Nomor WhatsApp --}}
                        <div>
                            <label for="whatsapp" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                </span>
                                <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" placeholder="Contoh: 081278901950" class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl pl-9 pr-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition">
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1 block">Konfirmasi persetujuan izin dan surat balasan akan dikirimkan ke WhatsApp ini.</span>
                            @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- 4. Keperluan Kunjungan --}}
                        <div>
                            <label for="purpose" class="block text-xs font-bold text-slate-700 mb-1.5">
                                Maksud, Tujuan &amp; Perkiraan Jumlah Peserta <span class="text-red-500">*</span>
                            </label>
                            <textarea name="purpose" id="purpose" rows="3" required placeholder="Tuliskan maksud kunjungan (studi banding kurikulum, observasi asrama, riset santri), tanggal rencana kunjungan, dan perkiraan jumlah rombongan..." class="w-full bg-slate-50 text-xs sm:text-sm text-slate-800 rounded-xl p-3.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] focus:bg-white transition leading-relaxed">{{ old('purpose') }}</textarea>
                            @error('purpose') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- 5 & 6. Upload Berkas Lampiran --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                            <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-slate-300 hover:border-[#00843d] transition">
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    <span>Sertakan Surat Permohonan</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <p class="text-[10px] text-slate-400 mb-2">Format PDF / DOC / Gambar (Maks 5 MB)</p>
                                <input type="file" name="letter_file" required accept=".pdf,.doc,.docx,image/*" class="w-full text-xs text-slate-700 font-medium file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-emerald-800 file:cursor-pointer transition">
                                @error('letter_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-slate-50 p-4 rounded-2xl border border-dashed border-slate-300 hover:border-[#00843d] transition">
                                <label class="block text-xs font-bold text-slate-800 mb-1">
                                    <span>Sertakan KTP Penanggung Jawab</span>
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
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Kirim Permohonan Izin Kunjungan</span>
                            </button>
                            <p class="text-[11px] text-slate-400 text-center mt-2.5 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                <span>Data dan dokumen terenkripsi langsung ke Sekretariat Pondok Pesantren Raudhatul Ulum.</span>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        {{-- 3. SEKSI PENGADUAN, SARAN DAN MASUKAN (FULL-WIDTH BALANCED BOTTOM CARD) --}}
        <div class="mt-8">
            <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-9 border border-slate-200/90 shadow-md">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                                Pengaduan, Saran dan Masukan
                            </h3>
                            <p class="text-xs text-slate-500">Kanal aspirasi, kritik membangun, dan pusat tindak lanjut pelayanan publik PPRU Sakatiga.</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-[#00843d] text-xs font-bold border border-emerald-200 self-start sm:self-auto">
                        <i class="fa-solid fa-headset"></i>
                        <span>Respon Cepat Pelayanan</span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 text-xs sm:text-sm text-slate-600">
                    {{-- Col 1: Pengantar & Alamat --}}
                    <div class="space-y-2">
                        <span class="font-extrabold text-slate-900 uppercase tracking-wider text-[11px] block text-emerald-800">
                            <i class="fa-solid fa-location-dot mr-1"></i> Alamat Sekretariat &amp; Humas
                        </span>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pengaduan, saran dan masukan dapat disampaikan ke bagian Sekretariat &amp; Humas Layanan Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga.
                        </p>
                        <p class="text-xs font-semibold text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            Kompleks Pondok Pesantren Raudhatul Ulum, Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662
                        </p>
                    </div>

                    {{-- Col 2: Kontak WhatsApp & Email --}}
                    <div class="space-y-3">
                        <span class="font-extrabold text-slate-900 uppercase tracking-wider text-[11px] block text-emerald-800">
                            <i class="fa-solid fa-phone-volume mr-1"></i> Kontak &amp; Saluran Resmi
                        </span>
                        <div class="space-y-2">
                            <a href="https://wa.me/6281278901950" target="_blank" class="flex items-center space-x-3 p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100/70 border border-emerald-200 transition group">
                                <i class="fa-brands fa-whatsapp text-xl text-[#25D366]"></i>
                                <div>
                                    <span class="text-[10px] text-emerald-800 font-bold block uppercase">No. HP (WhatsApp)</span>
                                    <span class="text-xs sm:text-sm font-black text-slate-900 group-hover:text-[#00843d] transition">0812-7890-1950</span>
                                </div>
                            </a>
                            <a href="mailto:sekretariat@ppru.ac.id" class="flex items-center space-x-3 p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 transition group">
                                <i class="fa-solid fa-envelope text-lg text-emerald-700"></i>
                                <div>
                                    <span class="text-[10px] text-slate-500 font-bold block uppercase">Email Resmi</span>
                                    <span class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#00843d] transition">sekretariat@ppru.ac.id</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Col 3: Website & Komitmen Pelayanan --}}
                    <div class="space-y-3">
                        <span class="font-extrabold text-slate-900 uppercase tracking-wider text-[11px] block text-emerald-800">
                            <i class="fa-solid fa-globe mr-1"></i> Portal &amp; Waktu Pelayanan
                        </span>
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-500 font-medium">Website:</span>
                                <a href="https://ppru.ac.id" target="_blank" class="font-bold text-[#00843d] hover:underline">ppru.ac.id</a>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200">
                                <span class="text-slate-500 font-medium">Hari Kerja:</span>
                                <span class="font-bold text-slate-800">Senin - Sabtu</span>
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 border-t border-slate-200">
                                <span class="text-slate-500 font-medium">Jam Pelayanan:</span>
                                <span class="font-bold text-slate-800">08.00 - 15.30 WIB</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-normal flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600 shrink-0"></i>
                            <span>Setiap pengaduan akan diverifikasi dan ditindaklanjuti maksimal 1x24 jam kerja.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
