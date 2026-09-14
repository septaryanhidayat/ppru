@extends('layouts.frontend')

@section('title', 'Portal Layanan Terpadu - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Pintu Pelayanan Publik Terpadu Pondok Pesantren Raudhatul Ulum Sakatiga: Izin Kunjungan & Studi Banding, Permohonan Kemitraan Kerja Sama, dan Sewa Peminjaman Fasilitas Kampus.')

@section('content')
{{-- HERO HEADER --}}
<section class="relative bg-gradient-to-br from-[#005a28] via-[#00843d] to-[#043317] text-white py-14 sm:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute -right-16 -bottom-16 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-16 -top-16 w-96 h-96 bg-[#f59e0b]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto space-y-4 relative z-10 text-center sm:text-left">
        <nav class="text-xs text-emerald-200 flex items-center justify-center sm:justify-start space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <i class="fa-solid fa-house text-[10px]"></i>
                <span>Beranda</span>
            </a>
            <span class="text-emerald-400">/</span>
            <span class="text-[#fcd116] font-bold">Layanan Terpadu</span>
        </nav>

        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-[#f59e0b] text-slate-950 flex items-center justify-center font-black text-2xl shadow-xl shrink-0">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white">
                    Portal Layanan Terpadu
                </h1>
                <p class="text-xs sm:text-sm text-emerald-100 mt-1 font-medium max-w-2xl leading-relaxed">
                    Satu pintu pelayanan administrasi resmi, perizinan kunjungan edukasi, kemitraan strategis, dan peminjaman fasilitas Pondok Pesantren Raudhatul Ulum Sakatiga.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- MAIN HUB CARDS --}}
<div class="bg-slate-50/70 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-[#00843d] bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-100">
                LAYANAN TERPADU PONDOK PESANTREN
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Pilih Layanan yang Anda Butuhkan
            </h2>
            <p class="text-xs sm:text-sm text-gray-500">
                Ajukan permohonan secara daring, tim Sekretariat dan Humas akan memproses permohonan Anda secara cepat, transparan, dan profesional.
            </p>
        </div>

        {{-- 3 KARTU UTAMA LAYANAN --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- 1. Izin Kunjungan --}}
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-[#00843d] flex items-center justify-center text-2xl group-hover:bg-[#00843d] group-hover:text-white transition duration-300 shadow-xs">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider bg-emerald-50 px-2.5 py-0.5 rounded-full">Layanan Izin</span>
                        <h3 class="text-lg font-black text-gray-900 mt-2 group-hover:text-[#00843d] transition">
                            Permohonan Izin Kunjungan ke Sekolah
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Layanan pengajuan studi banding, observasi kurikulum kepesantrenan, riset ilmiah, atau kunjungan silaturahmi instansi/sekolah ke kampus Raudhatul Ulum.
                    </p>
                    <ul class="text-[11px] text-gray-600 space-y-1.5 pt-2 border-t border-gray-100">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-[#00843d]"></i> <span>Bebas Biaya (Gratis)</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-[#00843d]"></i> <span>Tur keliling fasilitas kampus</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-[#00843d]"></i> <span>Respon konfirmasi maks 3 hari</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.izin') }}" class="w-full bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs py-3.5 px-4 rounded-2xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>Ajukan Izin Kunjungan</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

            {{-- 2. Permohonan Kerja Sama --}}
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:border-amber-300 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl group-hover:bg-[#f59e0b] group-hover:text-slate-950 transition duration-300 shadow-xs">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider bg-amber-50 px-2.5 py-0.5 rounded-full">Kemitraan &amp; MoU</span>
                        <h3 class="text-lg font-black text-gray-900 mt-2 group-hover:text-[#00843d] transition">
                            Permohonan Kerja Sama
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pengajuan kolaborasi program akademik, beasiswa, program CSR dunia usaha, riset bersama, dan kemitraan lembaga keuangan syariah atau universitas.
                    </p>
                    <ul class="text-[11px] text-gray-600 space-y-1.5 pt-2 border-t border-gray-100">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-600"></i> <span>MoU resmi berkekuatan hukum</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-600"></i> <span>Kemitraan beasiswa &amp; riset</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-600"></i> <span>Audiensi langsung pimpinan</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.kerjasama') }}" class="w-full bg-[#f59e0b] hover:bg-amber-500 text-slate-950 font-bold text-xs py-3.5 px-4 rounded-2xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>Ajukan Kemitraan / MoU</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

            {{-- 3. Sewa Fasilitas --}}
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:border-sky-300 transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1.5">
                <div class="space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl group-hover:bg-sky-600 group-hover:text-white transition duration-300 shadow-xs">
                        <i class="fa-solid fa-building-user"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-sky-700 uppercase tracking-wider bg-sky-50 px-2.5 py-0.5 rounded-full">Sarana &amp; Fasilitas</span>
                        <h3 class="text-lg font-black text-gray-900 mt-2 group-hover:text-[#00843d] transition">
                            Permohonan Sewa Menyewa Barang Sekolah
                        </h3>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pemanfaatan aula serbaguna, laboratorium komputer/CBT, lapangan olahraga terbuka, serta inventaris kegiatan untuk acara kemasyarakatan dan dakwah.
                    </p>
                    <ul class="text-[11px] text-gray-600 space-y-1.5 pt-2 border-t border-gray-100">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-sky-600"></i> <span>Aula berkapasitas 1.000 orang</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-sky-600"></i> <span>Sound system &amp; multimedia lengkap</span></li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-sky-600"></i> <span>Infaq pemeliharaan terjangkau</span></li>
                    </ul>
                </div>

                <div class="pt-6">
                    <a href="{{ route('layanan.sewa') }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs py-3.5 px-4 rounded-2xl flex items-center justify-center space-x-2 shadow-md transition">
                        <span>Ajukan Sewa Fasilitas</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- BANTUAN & KONTAK LANGSUNG --}}
        <div class="bg-gradient-to-br from-emerald-900 to-[#005a28] text-white rounded-3xl p-8 sm:p-10 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <span class="text-[11px] font-black uppercase tracking-wider text-amber-300">Helpdesk Terpadu</span>
                <h3 class="text-xl sm:text-2xl font-black">Butuh Konsultasi atau Informasi Lebih Lanjut?</h3>
                <p class="text-xs sm:text-sm text-emerald-100 max-w-xl">
                    Petugas humas dan sekretariat kami siap membantu menjawab pertanyaan Anda seputar perizinan, administrasi, dan kemitraan pondok.
                </p>
            </div>
            <div class="shrink-0">
                <a href="https://wa.me/6281278901950?text=Assalamu%27alaikum%20Humas%20PPRU%20Sakatiga%2C%20saya%20ingin%20konsultasi%20layanan%20terpadu" target="_blank" rel="noopener" class="bg-[#f59e0b] hover:bg-amber-400 text-slate-950 font-black text-xs sm:text-sm px-6 py-3.5 rounded-full shadow-lg transition flex items-center space-x-2 transform hover:scale-105">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span>Hubungi Humas via WhatsApp</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
