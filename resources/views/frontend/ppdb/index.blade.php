@extends('layouts.frontend')

@section('title', 'SPMB / PPDB Online 2026/2027 - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Penerimaan Peserta Didik Baru (PPDB/SPMB) SMA Islam Terpadu Ishlahul Ummah Prabumulih Tahun Pelajaran 2026/2027. Informasi alur, syarat, jadwal, dan formulir pendaftaran online.')

@section('content')
<div class="bg-gradient-to-b from-emerald-50/50 via-white to-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- HEADER BRAND & LOGO --}}
        <div class="text-center space-y-3">
            <div class="inline-block p-2 bg-white rounded-3xl shadow-md border border-emerald-100">
                <img src="/uploads/logo-ishum-square.png" alt="Logo SMA IT Ishlahul Ummah" class="h-24 sm:h-28 w-auto object-contain mx-auto">
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight uppercase">
                    SPMB SMA IT ISHLAHUL UMMAH <br class="hidden sm:inline">PRABUMULIH
                </h1>
                <p class="text-sm sm:text-base font-bold text-[#00913e] mt-1">
                    Tahun Akademik 2026/2027
                </p>
            </div>
            <div class="pt-1">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#007532] text-white px-5 py-2 rounded-xl text-xs font-bold transition shadow-sm hover:shadow">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Beranda</span>
                </a>
            </div>
        </div>

        {{-- VIDEO PROFILE EMBED --}}
        <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-lg border border-slate-200/80 overflow-hidden">
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-900 shadow-inner">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/jZ_yTq14i1M?rel=0" 
                    title="A Day My Life in School :) Waktu Sholat Dzuhur - SMA IT Ishlahul Ummah Prabumulih" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="text-center mt-3">
                <p class="text-xs font-semibold text-slate-600 flex items-center justify-center space-x-2">
                    <i class="fa-brands fa-youtube text-red-600 text-base"></i>
                    <span>Video Suasana & Keseharian Santri SMA IT Ishlahul Ummah Prabumulih</span>
                </p>
            </div>
        </div>

        {{-- JAM OPERASIONAL SPMB --}}
        <div class="text-center space-y-1 py-3 bg-red-50/60 border border-red-100 rounded-3xl p-6 shadow-xs">
            <h2 class="text-xl sm:text-2xl font-black text-[#da251c] tracking-tight uppercase">
                JAM OPERASIONAL SPMB
            </h2>
            <p class="text-xs sm:text-sm font-bold text-[#00913e]">
                Setiap hari Offline &amp; Online
            </p>
            <p class="text-xs text-slate-600 font-medium">
                Hari Senin – Jum'at : Pukul 08.00 – 15.00 WIB
            </p>
        </div>

        {{-- ACCORDION INFORMASI SPMB DUA KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ activeLeft: 1, activeRight: 1 }">

            {{-- KOLOM KIRI --}}
            <div class="space-y-3">
                
                {{-- 1. Alur Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 1 ? null : 1)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Alur Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 1" x-collapse class="p-5 text-xs text-slate-700 space-y-2.5 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-2">
                            <li>
                                Siapkan berkas foto atau scan bukti transfer pembayaran biaya pendaftaran melalui <strong>Bank Syariah Indonesia (BSI)</strong> nomor rekening <strong>7011304251</strong> a.n. <strong>YL. Fatmawati</strong>.
                            </li>
                            <li>
                                Siapkan berkas foto atau hasil scan dalam bentuk pdf/jpg/png akta kelahiran.
                            </li>
                            <li>
                                Mengisi formulir PPDB 2026/2027 secara online pada website resmi: 
                                <a href="{{ route('ppdb.form') }}" class="text-[#00913e] font-bold underline">{{ url('/form_ppdb') }}</a>.
                            </li>
                            <li>
                                Konfirmasi pendaftaran kepada admin melalui WhatsApp.
                            </li>
                            <li>
                                Pendaftaran selesai dan berkas diverifikasi tim panitia.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- 2. Syarat Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Syarat Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 2" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-1.5">
                            <li>Mengisi Formulir Pendaftaran online dengan data yang benar.</li>
                            <li>Melampirkan bukti transfer biaya pendaftaran.</li>
                            <li>Melampirkan scan/fotokopi Akta Kelahiran dan Kartu Keluarga (KK).</li>
                            <li>Melampirkan fotokopi rapor SMP/MTs semester 1-5.</li>
                            <li>Pas foto terbaru calon siswa ukuran 3x4 berwarna.</li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Jalur Prestasi --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Jalur Prestasi</span>
                        <i class="fa-solid" :class="activeLeft === 3 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 3" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Jalur khusus bagi santri berprestasi akademik maupun non-akademik (OSN, FLS2N, O2SN, Popda, MHQ, MTQ, Robotika):</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Bebas tes tulis akademik bagi Juara 1, 2, atau 3 tingkat Kota/Kabupaten, Provinsi, maupun Nasional.</li>
                            <li>Diskon khusus biaya pendaftaran dan prioritas penerimaan.</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Jalur Hafizh --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Jalur Hafizh</span>
                        <i class="fa-solid" :class="activeLeft === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 4" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Apresiasi istimewa bagi para penghafal Kitab Suci Al-Qur'an:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Tahfidz minimal 3 Juz: Beasiswa potongan biaya pendaftaran & SPP.</li>
                            <li>Tahfidz 5 Juz atau lebih: Beasiswa SPP berkala dan pembinaan khusus Sanad/Mutqin.</li>
                            <li>Mengikuti tes sima'an tahfidz bersama dewan musyrif Al-Qur'an Ishum.</li>
                        </ul>
                    </div>
                </div>

                {{-- 5. Jalur Alumni SMPIT Ishum --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 5 ? null : 5)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Jalur Alumni SMPIT Ishum</span>
                        <i class="fa-solid" :class="activeLeft === 5 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 5" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Keringanan istimewa bagi lulusan SMPIT Ishlahul Ummah Prabumulih yang melanjutkan ke SMA IT Ishlahul Ummah Prabumulih berupa potongan biaya uang pangkal &amp; pendaftaran langsung tanpa biaya seleksi.</p>
                    </div>
                </div>

                {{-- 6. Jalur Tes Mandiri --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 6 ? null : 6)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Jalur Tes Mandiri</span>
                        <i class="fa-solid" :class="activeLeft === 6 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 6" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Jalur seleksi reguler melalui tahapan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Tes Potensi Akademik (Matematika, Bahasa Indonesia, PAI).</li>
                            <li>Tes Kemampuan Membaca Al-Qur'an (Tahsin &amp; Tajwid).</li>
                            <li>Wawancara Komitmen Orang Tua &amp; Santri.</li>
                        </ul>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-3">
                
                {{-- 1. Jadwal PPDB --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 1 ? null : 1)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Jadwal PPDB</span>
                        <i class="fa-solid" :class="activeRight === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 1" x-collapse class="p-5 text-xs text-slate-700 space-y-2.5 bg-emerald-50/20 leading-relaxed">
                        <div class="p-3 bg-white rounded-xl border border-emerald-200 font-medium">
                            <span class="font-bold text-slate-900 block mb-1 text-sm">GELOMBANG 3</span>
                            <p class="text-slate-600">Pendaftaran: <strong>Maret – Juni 2026</strong></p>
                            <p class="text-emerald-700 font-bold mt-1">PENGUMUMAN GEL. 3 PADA TANGGAL 25 JUNI 2026</p>
                        </div>
                        <p class="text-[11px] text-slate-500 italic">* Kuota terbatas setiap gelombang, pendaftaran akan ditutup otomatis apabila kuota kelas telah terpenuhi.</p>
                    </div>
                </div>

                {{-- 2. Rincian Biaya --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Rincian Biaya</span>
                        <i class="fa-solid" :class="activeRight === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 2" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Biaya Formulir Pendaftaran: Sesuai ketentuan panitia SPMB.</li>
                            <li>Paket Seragam Sekolah (4 stel seragam lengkap + atribut).</li>
                            <li>Biaya Orientasi Siswa (MPLS) &amp; Baitul Maqdis Camp.</li>
                            <li>Untuk rincian lengkap tabel biaya, silakan hubungi kontak panitia SPMB Ishum.</li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Biaya Boarding / Asrama --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Biaya Boarding / Asrama</span>
                        <i class="fa-solid" :class="activeRight === 3 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 3" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Pilihan program Full Day School dan Boarding School (Asrama Santri):</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Fasilitas asrama bersih, nyaman, ber-AC/ventilasi sehat.</li>
                            <li>Makan dan gizi terjamin 3 kali sehari.</li>
                            <li>Bimbingan tahfidz Al-Qur'an 24 jam bersama musyrif/musyrifah berpengalaman.</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Pengumuman Kelulusan PPDB 2025 - 2026 --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>Pengumuman Kelulusan PPDB 2025 – 2026</span>
                        <i class="fa-solid" :class="activeRight === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 4" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Arsip data kelulusan santri dan informasi daftar ulang gelombang sebelumnya telah diumumkan. Bagi calon santri baru 2026/2027 silakan langsung mengisi formulir pendaftaran.</p>
                    </div>
                </div>

            </div>

        </div>

        {{-- ACTION CARDS: FORMULIR PENDAFTARAN & HUBUNGI ADMIN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
            
            {{-- Card 1: Formulir Pendaftaran --}}
            <a href="{{ route('ppdb.form') }}" class="group bg-white p-8 rounded-3xl border-2 border-emerald-100 hover:border-[#00913e] shadow-md hover:shadow-xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-clipboard-list text-amber-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-[#00913e] transition">
                            Formulir Pendaftaran
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Silakan Bapak/Ibu mengisi formulir pendaftaran online ini sebagai syarat pendaftaran di SMA IT Ishlahul Ummah dengan sebenar-benarnya.
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#00913e] group-hover:bg-[#007532] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md transition">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi Formulir Online Sekarang</span>
                </span>
            </a>

            {{-- Card 2: Hubungi Admin --}}
            <a href="https://wa.me/6282281896792?text={{ urlencode('Halo Admin SPMB SMA IT Ishlahul Ummah Prabumulih, saya ingin berkonsultasi mengenai pendaftaran santri baru TP 2026/2027.') }}" target="_blank" class="group bg-white p-8 rounded-3xl border-2 border-indigo-100 hover:border-indigo-500 shadow-md hover:shadow-xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-mobile-screen-button text-indigo-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-indigo-600 transition">
                            Hubungi Admin
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Silakan konfirmasi di sini jika sudah berhasil mengisi form pendaftaran online, atau jika ada kendala dalam pengisian.
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md transition">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Chat WhatsApp Panitia SPMB</span>
                </span>
            </a>

        </div>

        {{-- UCAPAN TERIMA KASIH & FLYER PROMOSI --}}
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-md border border-slate-200/80 text-center space-y-6">
            <div>
                <h3 class="text-xl sm:text-2xl font-black text-[#da251c] tracking-tight">
                    Terima Kasih Sudah Mendaftar di SMA Islam Terpadu Ishlahul Ummah Prabumulih
                </h3>
                <p class="text-xs sm:text-sm font-semibold text-[#00913e] mt-2 max-w-2xl mx-auto leading-relaxed">
                    Semoga Ananda kelak bisa menjadi anak yang cerdas, sholeh/ah, berbakti kepada orang tua dan menjadi kebanggaan bagi agama, bangsa dan negara. Aamiin
                </p>
            </div>

            {{-- Flyer Showcase --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/campus-robbani.webp" alt="Welcome to SMA IT Ishum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ishum/fasilitas_3427_IMG-20240528-WA0106-scaled.webp" alt="Gedung Kampus Ishum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ishum/fasilitas_1278_HALL-SIT-Ishlahul-Ummah_.webp" alt="Hall Ishlahul Ummah" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>

            {{-- Salam Mendidik Sepenuh Cinta --}}
            <div class="pt-4 border-t border-slate-100">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                    Salam Mendidik Sepenuh Cinta
                </p>
                <div class="mt-2 text-xs font-semibold text-sky-600 tracking-wider uppercase">
                    Coming Soon SPMB 2027–2028
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
