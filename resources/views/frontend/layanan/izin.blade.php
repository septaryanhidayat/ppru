@extends('layouts.frontend')

@section('title', 'Permohonan Izin Kunjungan ke Sekolah - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Formulir resmi dan prosedur permohonan izin kunjungan edukasi, studi banding, riset ilmiah, atau kunjungan instansi di Pondok Pesantren Raudhatul Ulum Sakatiga.')

@section('content')
{{-- 1. HERO HEADER (Modern Emerald Gradient) --}}
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
            <span class="text-[#fcd116] font-bold">Izin Kunjungan</span>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-2xl bg-[#f59e0b] text-slate-950 flex items-center justify-center font-black text-2xl shadow-lg shrink-0">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-white">
                    Izin Kunjungan ke Sekolah
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 font-medium max-w-2xl leading-relaxed">
                    Pengajuan izin kunjungan instansi, studi banding, atau riset edukatif di Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 2. MAIN CONTAINER --}}
<div class="bg-slate-50/60 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- JUDUL RESMI HALAMAN --}}
        <div class="text-center max-w-2xl mx-auto space-y-1.5">
            <span class="text-[11px] font-extrabold uppercase tracking-widest text-[#00843d] bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-100">
                Pelayanan Terpadu Satu Pintu
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-[#00843d] tracking-tight uppercase">
                PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH
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
                <h3 class="font-black text-xl text-emerald-950">Permohonan Berhasil Dikirim!</h3>
                <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto leading-relaxed">
                    {{ session('success') }}
                </p>
                @if(session('wa_url'))
                    <div class="pt-2">
                        <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00843d] hover:bg-emerald-800 text-white font-black text-xs sm:text-sm px-7 py-3.5 rounded-full shadow-lg transition transform hover:scale-105">
                            <i class="fa-brands fa-whatsapp text-lg text-emerald-300"></i>
                            <span>Konfirmasi WhatsApp Sekarang</span>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        {{-- DETAIL PERSYARATAN & INFORMASI PELAYANAN (OPEN CARDS MODERN - TANPA ACCORDION MEMBINGUNGKAN) --}}
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-200 pb-3">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-gray-900">Ketentuan Pelayanan Izin Kunjungan</h3>
                    <p class="text-xs text-gray-500">Seluruh rincian syarat, jadwal, serta prosedur izin kunjungan terbuka secara transparan tanpa perlu klik buka-tutup.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-[#00843d] px-3.5 py-1 rounded-full text-xs font-bold border border-emerald-100 self-start sm:self-auto">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Informasi Terbuka</span>
                </span>
            </div>

            @php
                $defaultIzinTabs = [
                    [
                        'icon' => 'fa-solid fa-list-check',
                        'title' => 'Persyaratan Pelayanan',
                        'content' => '<ul><li>Pemohon memiliki akun pada system untuk melakukan permohonan kunjungan</li><li>Pemohon melakukan pengajuan melalui system</li><li>Bukti permohonan kunjungan sudah di tandatangani oleh yang berwenang dan cap serta dibawa ketika hari kunjungan</li><li>Maksimal pengunjung 100 orang</li><li>Hari kunjungan adalah hari senin dan kamis</li><li>Waktu kunjungan adalah pukul 09.00-11.00 wib</li><li>Pengunjung menggunakan pakaian yang sopan dan rapi</li><li>Wajib menerapkan protkes ketat</li></ul>'
                    ],
                    [
                        'icon' => 'fa-solid fa-clock',
                        'title' => 'Jangka Waktu Penyelesaian',
                        'content' => '<p>Waktu respon atas permohonan paling lambat 10 (sepuluh) hari kerja</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-hand-holding-dollar',
                        'title' => 'Biaya dan Tarif',
                        'content' => '<p class="font-bold text-emerald-800">Proses permohonan dan pelaksanaan kunjungan tidak dipungut biaya (Gratis)</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-file-circle-check',
                        'title' => 'Produk Layanan',
                        'content' => '<p>Layanan kunjungan sekolah</p>'
                    ],
                    [
                        'icon' => 'fa-solid fa-headset',
                        'title' => 'Pengaduan, Saran dan Masukan',
                        'content' => '<p>Pengaduan, saran dan masukan dapat disampaikan ke bagian humas dan media layanan terpadu Pondok Pesantren Raudhatul Ulum Sakatiga</p><p class="mt-2"><strong>Alamat :</strong> Desa Sakatiga, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan</p><p><strong>No. HP (WA) :</strong> <a href="https://wa.me/6281278901950" target="_blank" class="text-emerald-700 font-bold hover:underline">0812-7890-1950</a></p><p><strong>Website :</strong> ppru.ac.id</p><p><strong>Email :</strong> <a href="mailto:sekretariat@ppru.ac.id" class="text-emerald-700 font-bold hover:underline">sekretariat@ppru.ac.id</a></p>'
                    ]
                ];
                $tabs = !empty($accordions) ? $accordions : $defaultIzinTabs;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($tabs as $tab)
                    <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm hover:border-[#00843d] transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-base font-bold shadow-xs">
                                    <i class="{{ $tab['icon'] ?? 'fa-solid fa-circle-info' }}"></i>
                                </div>
                                <h4 class="font-black text-sm sm:text-base text-gray-900">{{ $tab['title'] }}</h4>
                            </div>
                            <div class="text-xs text-gray-700 leading-relaxed prose prose-sm max-w-none [&>ul]:list-disc [&>ul]:pl-5 [&>ul]:space-y-1.5 [&>p]:mb-2">
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
            <p class="text-xs text-gray-500 mt-1">Lengkapi data kunjungan dan upload surat permohonan resmi</p>
        </div>

        {{-- FORM CONTAINER MODERN --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-md space-y-6">
            <form action="{{ route('layanan.izin.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
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
                        <i class="fa-solid fa-lock text-emerald-600"></i>
                        <span>Data dan dokumen terkirim aman ke Sekretariat Pondok Pesantren Raudhatul Ulum Sakatiga.</span>
                    </p>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
