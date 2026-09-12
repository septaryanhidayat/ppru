@extends('layouts.frontend')

@section('title', 'Layanan Terpadu - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Portal Layanan Terpadu SMA Islam Terpadu Ishlahul Ummah Prabumulih: Izin Kunjungan Sekolah, Permohonan Kerja Sama Lembaga, dan Sewa Menyewa Fasilitas Barang Sekolah.')

@section('content')
{{-- HERO BREADCRUMB HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Layanan Publik</span>
            <span>/</span>
            <span class="text-white font-semibold">Layanan Terpadu</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Portal Layanan Terpadu</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Satu pintu pelayanan administrasi, perizinan kunjungan resmi, dan kemitraan SMA IT Ishum.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    {{-- JUDUL RESMI SESUAI TAMPILAN WEB UTAMA --}}
    <div class="text-center max-w-3xl mx-auto mb-14">
        <h2 class="text-3xl sm:text-4xl font-black text-[#00913e] tracking-tight uppercase">
            LAYANAN TERPADU
        </h2>
        <p class="text-base sm:text-lg font-bold text-[#da251c] mt-1">
            SMA Islam Terpadu Ishlahul Ummah Prabumulih
        </p>
        <div class="w-20 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        <p class="text-xs sm:text-sm text-gray-500 mt-3 font-light">
            Pilih jenis layanan administrasi di bawah ini untuk mengajukan permohonan secara online dan terhubung langsung dengan bagian humas sekolah.
        </p>
    </div>

    {{-- 3 KARTU UTAMA DENGAN ILUSTRASI KHAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        
        {{-- LAYANAN 1: IZIN KUNJUNGAN KE SEKOLAH --}}
        <a href="{{ route('layanan.izin') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center group hover:-translate-y-2">
            {{-- ILUSTRASI: Operator & Laptop Kunjungan --}}
            <div class="w-36 h-36 mb-6 flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                <svg viewBox="0 0 160 140" class="w-full h-full drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="25" y="30" width="110" height="75" rx="8" fill="#3B82F6" opacity="0.15"/>
                    <rect x="30" y="35" width="100" height="65" rx="6" fill="#1E293B"/>
                    <rect x="35" y="40" width="90" height="55" rx="4" fill="#60A5FA"/>
                    {{-- Layar Laptop & Orang Berheadset --}}
                    <path d="M15 110C15 107.239 17.2386 105 20 105H140C142.761 105 145 107.239 145 110V113C145 114.105 144.105 115 143 115H17C15.8954 115 15 114.105 15 113V110Z" fill="#CBD5E1"/>
                    <rect x="68" y="107" width="24" height="4" rx="2" fill="#94A3B8"/>
                    {{-- Avatar Petugas --}}
                    <circle cx="80" cy="58" r="14" fill="#FBBF24"/>
                    <path d="M64 88C64 78 70 74 80 74C90 74 96 78 96 88H64Z" fill="#3B82F6"/>
                    <path d="M68 56C68 50 72 44 80 44C88 44 92 50 92 56" stroke="#EF4444" stroke-width="3" stroke-linecap="round"/>
                    <rect x="66" y="54" width="4" height="8" rx="2" fill="#EF4444"/>
                    <rect x="90" y="54" width="4" height="8" rx="2" fill="#EF4444"/>
                    <path d="M92 60C92 64 88 66 84 66" stroke="#EF4444" stroke-width="2" stroke-linecap="round"/>
                    {{-- Speech Bubble --}}
                    <rect x="96" y="20" width="34" height="22" rx="6" fill="#EF4444"/>
                    <path d="M104 42L108 47L112 42H104Z" fill="#EF4444"/>
                    <line x1="102" y1="26" x2="124" y2="26" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <line x1="102" y1="32" x2="118" y2="32" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            
            <h3 class="font-extrabold text-[#00913e] text-lg group-hover:text-[#da251c] transition leading-snug mb-3">
                Permohonan Izin Kunjungan ke Sekolah
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Layanan pengajuan izin resmi untuk kegiatan studi banding, observasi edukatif, riset, atau kunjungan instansi kedinasan.
            </p>
            <span class="mt-auto inline-flex items-center space-x-2 text-xs font-bold text-[#00913e] group-hover:text-[#da251c] transition">
                <span>Buka Formulir</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </span>
        </a>

        {{-- LAYANAN 2: PERMOHONAN KERJA SAMA --}}
        <a href="{{ route('layanan.kerjasama') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center group hover:-translate-y-2">
            {{-- ILUSTRASI: Dua Orang Berdialog & Berkas Kemitraan --}}
            <div class="w-36 h-36 mb-6 flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                <svg viewBox="0 0 160 140" class="w-full h-full drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {{-- Folders / Documents --}}
                    <rect x="75" y="25" width="40" height="30" rx="4" fill="#93C5FD" opacity="0.6"/>
                    <rect x="80" y="30" width="40" height="30" rx="4" fill="#60A5FA"/>
                    <rect x="35" y="70" width="38" height="28" rx="4" fill="#93C5FD" opacity="0.6"/>
                    <rect x="40" y="75" width="38" height="28" rx="4" fill="#60A5FA"/>
                    {{-- Orang Kiri (Hijau) --}}
                    <rect x="45" y="20" width="42" height="42" rx="10" fill="#E2E8F0" stroke="#CBD5E1" stroke-width="1.5"/>
                    <circle cx="66" cy="36" r="9" fill="#FBBF24"/>
                    <path d="M54 58C54 50 59 47 66 47C73 47 78 50 78 58H54Z" fill="#10B981"/>
                    {{-- Orang Kanan (Merah) --}}
                    <rect x="85" y="65" width="42" height="42" rx="10" fill="#E2E8F0" stroke="#CBD5E1" stroke-width="1.5"/>
                    <circle cx="106" cy="81" r="9" fill="#FBBF24"/>
                    <path d="M94 103C94 95 99 92 106 92C113 92 118 95 118 103H94Z" fill="#EF4444"/>
                    {{-- Speech Dialogue Links --}}
                    <circle cx="78" cy="65" r="2.5" fill="#64748B"/>
                    <circle cx="85" cy="61" r="3" fill="#64748B"/>
                    <circle cx="93" cy="58" r="3.5" fill="#64748B"/>
                </svg>
            </div>
            
            <h3 class="font-extrabold text-[#00913e] text-lg group-hover:text-[#da251c] transition leading-snug mb-3">
                Permohonan Kerja Sama
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Kemitraan strategis dunia industri, perguruan tinggi, lembaga dakwah, sponsorship, program beasiswa, dan instansi formal.
            </p>
            <span class="mt-auto inline-flex items-center space-x-2 text-xs font-bold text-[#00913e] group-hover:text-[#da251c] transition">
                <span>Buka Formulir</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </span>
        </a>

        {{-- LAYANAN 3: SEWA MENYEWA BARANG SEKOLAH --}}
        <a href="{{ route('layanan.sewa') }}" class="bg-white rounded-3xl p-8 border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center group hover:-translate-y-2">
            {{-- ILUSTRASI: Rocket, Buku, Keyboard & Fasilitas Sarana --}}
            <div class="w-36 h-36 mb-6 flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                <svg viewBox="0 0 160 140" class="w-full h-full drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                    {{-- Buku / Agenda --}}
                    <rect x="50" y="25" width="60" height="60" rx="8" fill="#FDE68A"/>
                    <path d="M50 35C65 33 95 33 110 35V85C95 83 65 83 50 85V35Z" fill="#FBBF24" opacity="0.4"/>
                    <line x1="80" y1="35" x2="80" y2="85" stroke="#D97706" stroke-width="1.5" stroke-dasharray="2 2"/>
                    {{-- Roket Peluncuran Sarana --}}
                    <g transform="translate(65, 20) rotate(25)">
                        <path d="M15 0C25 15 25 35 15 45C5 35 5 15 15 0Z" fill="#3B82F6"/>
                        <circle cx="15" cy="18" r="4.5" fill="#E0F2FE"/>
                        <path d="M5 32L-2 42L8 40L5 32Z" fill="#EF4444"/>
                        <path d="M25 32L32 42L22 40L25 32Z" fill="#EF4444"/>
                        <path d="M11 45C11 50 15 56 15 56C15 56 19 50 19 45H11Z" fill="#F59E0B"/>
                    </g>
                    {{-- Keyboard & Mouse --}}
                    <rect x="35" y="94" width="65" height="24" rx="4" fill="#60A5FA"/>
                    <rect x="40" y="98" width="10" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    <rect x="53" y="98" width="10" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    <rect x="66" y="98" width="10" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    <rect x="79" y="98" width="15" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    <rect x="40" y="107" width="22" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    <rect x="65" y="107" width="29" height="6" rx="1.5" fill="white" opacity="0.8"/>
                    {{-- Mouse --}}
                    <rect x="108" y="94" width="16" height="24" rx="8" fill="#CBD5E1"/>
                    <line x1="116" y1="94" x2="116" y2="102" stroke="#64748B" stroke-width="1.5"/>
                </svg>
            </div>
            
            <h3 class="font-extrabold text-[#00913e] text-lg group-hover:text-[#da251c] transition leading-snug mb-3">
                Permohonan Sewa Menyewa Barang Sekolah
            </h3>
            <p class="text-xs text-gray-500 leading-relaxed font-light mb-6">
                Fasilitas Hall Serbaguna Ishum, laboratorium komputer, lapangan olahraga, audio sound system, dan tenda kegiatan sekolah.
            </p>
            <span class="mt-auto inline-flex items-center space-x-2 text-xs font-bold text-[#00913e] group-hover:text-[#da251c] transition">
                <span>Buka Formulir</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </span>
        </a>

    </div>

    {{-- KONTEN PANDUAN DAN FAQ LAYANAN --}}
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                <i class="fa-solid fa-circle-info text-[#00913e]"></i>
                <span>Ketentuan &amp; Prosedur Layanan Terpadu</span>
            </h3>
            <p class="text-xs text-gray-500 mt-1">Panduan umum dalam mengajukan permohonan layanan di SMA IT Ishlahul Ummah Prabumulih.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs text-gray-600 leading-relaxed">
            <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-100 space-y-2">
                <div class="font-bold text-emerald-900 text-sm flex items-center space-x-2">
                    <span class="w-6 h-6 rounded-full bg-[#00913e] text-white flex items-center justify-center text-xs font-extrabold">1</span>
                    <span>Pengisian Formulir</span>
                </div>
                <p>Isi formulir online secara lengkap dengan data identitas pemohon, asal instansi, tujuan kegiatan, serta lampiran surat resmi atau proposal pendukung.</p>
            </div>

            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-100 space-y-2">
                <div class="font-bold text-amber-900 text-sm flex items-center space-x-2">
                    <span class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-extrabold">2</span>
                    <span>Verifikasi Administrasi</span>
                </div>
                <p>Tim Humas dan Manajemen SMA IT Ishum akan memeriksa permohonan Anda dalam 1-2 hari kerja untuk penyesuaian jadwal serta ketersediaan sarana.</p>
            </div>

            <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-100 space-y-2">
                <div class="font-bold text-blue-900 text-sm flex items-center space-x-2">
                    <span class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-extrabold">3</span>
                    <span>Konfirmasi &amp; Surat Balasan</span>
                </div>
                <p>Konfirmasi persetujuan resmi beserta surat balasan akan dikirimkan melalui WhatsApp dan email pemohon secara langsung.</p>
            </div>
        </div>

        {{-- Hotlink WhatsApp Humas --}}
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
            <div>
                <span class="font-bold text-sm text-slate-800 block">Butuh bantuan cepat atau konfirmasi darurat?</span>
                <span class="text-xs text-slate-500">Hubungi Hotline Humas &amp; Sekretariat SMA IT Ishlahul Ummah Prabumulih.</span>
            </div>
            <a href="https://wa.me/6282182680647?text=Assalamu'alaikum%20Humas%20SMA%20IT%20Ishum,%20saya%20ingin%20bertanya%20mengenai%20Layanan%20Terpadu%20Sekolah." target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-emerald-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow transition shrink-0">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Chat WhatsApp Humas</span>
            </a>
        </div>
    </div>

</div>
@endsection
