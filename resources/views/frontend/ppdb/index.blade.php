@extends('layouts.frontend')

@section('title', 'SPMB / PPDB Online 2026/2027 - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Penerimaan Peserta Didik Baru (PPDB/SPMB) SMA Islam Terpadu Ishlahul Ummah Prabumulih Tahun Pelajaran 2026/2027. Informasi alur, syarat, jadwal, biaya, dan formulir pendaftaran online.')

@section('content')
<div class="bg-gradient-to-b from-emerald-50/50 via-white to-gray-50 py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- HEADER BRAND & HERO TITLE --}}
        <div class="text-center space-y-4 reveal-fade-up">
            <div class="inline-block p-2.5 bg-white rounded-3xl shadow-md border border-emerald-100">
                <img src="/uploads/logo-ishum-square.png" alt="Logo SMA IT Ishlahul Ummah" class="h-24 sm:h-28 w-auto object-contain mx-auto">
            </div>
            <div>
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-[#00913e] px-4 py-1 rounded-full text-xs font-bold mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Pendaftaran Santri Baru Telah Dibuka</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight uppercase">
                    SPMB SMA IT ISHLAHUL UMMAH <br class="hidden sm:inline">PRABUMULIH
                </h1>
                <p class="text-sm sm:text-base font-bold text-[#da251c] mt-1.5">
                    Tahun Pelajaran 2026/2027 &bull; Gelombang Aktif
                </p>
                <p class="text-xs sm:text-sm text-slate-500 max-w-2xl mx-auto mt-2 font-light leading-relaxed">
                    Mewujudkan generasi Qur'ani berkarakter tangguh, cerdas sains, mandiri, dan berwawasan global di bawah naungan JSIT Indonesia.
                </p>
            </div>

            {{-- CTA Quick Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="{{ route('ppdb.form') }}" class="inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white px-7 py-3 rounded-2xl text-xs sm:text-sm font-black transition shadow-lg shadow-red-500/25 transform hover:scale-105">
                    <i class="fa-solid fa-file-pen text-sm"></i>
                    <span>Isi Formulir Online</span>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 bg-slate-900 hover:bg-black text-white px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition shadow-sm">
                    <i class="fa-solid fa-house text-xs"></i>
                    <span>Beranda Sekolah</span>
                </a>
                <a href="https://wa.me/6282182880628?text={{ urlencode('Assalamu\'alaikum Panitia PPDB SMA IT Ishlahul Ummah Prabumulih, saya ingin konsultasi pendaftaran santri baru.') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#007532] text-white px-6 py-3 rounded-2xl text-xs sm:text-sm font-bold transition shadow-md">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Hotline WhatsApp</span>
                </a>
            </div>
        </div>

        {{-- VIDEO PROFILE RESMI SMA IT ISHLAHUL UMMAH EMBED --}}
        <div class="bg-white p-4 sm:p-7 rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden space-y-4">
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-950 shadow-2xl border border-slate-800">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/IrPVG8CYjRc?rel=0" 
                    title="Video Profil Resmi SPMB SMA IT Ishlahul Ummah Prabumulih" 
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
                        <h4 class="text-xs sm:text-sm font-bold text-slate-800">Video Profil &amp; Dokumentasi Kampus SMA IT Ishum</h4>
                        <p class="text-[11px] text-slate-500">Saksikan suasana pembelajaran, asrama, laboratorium, dan tahfidz Al-Qur'an.</p>
                    </div>
                </div>
                <a href="https://www.youtube.com/watch?v=IrPVG8CYjRc" target="_blank" class="inline-flex items-center space-x-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-xl transition flex-shrink-0">
                    <span>Tonton di YouTube</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- JAM OPERASIONAL & KOTAK REKENING PEMBAYARAN BSI --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Jam Operasional --}}
            <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-3xl p-6 sm:p-7 shadow-xs flex flex-col justify-between">
                <div class="space-y-2">
                    <span class="inline-block bg-emerald-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Layanan Terpadu
                    </span>
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight uppercase">
                        JAM OPERASIONAL SPMB
                    </h3>
                    <p class="text-xs font-semibold text-[#00913e]">
                        Tersedia Layanan Konsultasi Offline &amp; Online
                    </p>
                    <ul class="text-xs text-slate-600 space-y-1.5 pt-2">
                        <li class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-[#00913e]"></i>
                            <span><strong>Senin – Jum'at:</strong> Pukul 08.00 – 15.00 WIB</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-regular fa-clock text-[#00913e]"></i>
                            <span><strong>Sabtu:</strong> Pukul 08.00 – 12.00 WIB</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-[#da251c]"></i>
                            <span>Sekretariat SPMB: Gedung Kampus SMA IT Ishlahul Ummah</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 mt-4 border-t border-emerald-200/60">
                    <p class="text-[11px] text-slate-500 italic">* Hari Ahad / Libur Nasional dapat berkonsultasi secara online via WhatsApp.</p>
                </div>
            </div>

            {{-- Rekening Resmi BSI --}}
            <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-800 flex flex-col justify-between relative overflow-hidden" x-data="{ copied: false }">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-[#00913e]/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="space-y-3 relative z-10">
                    <div class="flex items-center justify-between">
                        <span class="bg-[#00913e] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Rekening Resmi SPMB
                        </span>
                        <span class="text-xs font-bold text-amber-400">Bank Syariah Indonesia</span>
                    </div>
                    <h3 class="text-lg font-extrabold text-white">
                        Pembayaran Biaya Formulir
                    </h3>
                    <div class="bg-slate-800/90 rounded-2xl p-4 border border-slate-700 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Nomor Rekening BSI:</span>
                            <span class="text-[11px] text-emerald-400 font-semibold">Kode Bank: 451</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-black text-amber-300 font-mono tracking-wider">
                            7011304251
                        </div>
                        <div class="text-xs text-slate-300 font-medium">
                            Atas Nama: <strong class="text-white">YL. Fatmawati</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-3 relative z-10 flex items-center justify-between">
                    <button 
                        @click="navigator.clipboard.writeText('7011304251'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer">
                        <i class="fa-regular fa-copy" :class="copied ? 'fa-check' : 'fa-copy'"></i>
                        <span x-text="copied ? 'Nomor Tersalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                    <span class="text-[11px] text-slate-400">Simpan bukti transfer</span>
                </div>
            </div>

        </div>

        {{-- ACCORDION INFORMASI SPMB DUA KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ activeLeft: 1, activeRight: 1 }">

            {{-- KOLOM KIRI --}}
            <div class="space-y-3">
                
                {{-- 1. Alur Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 1 ? null : 1)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>1. Alur Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 1" x-collapse class="p-5 text-xs text-slate-700 space-y-2.5 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-2">
                            <li>
                                Siapkan berkas foto atau scan bukti transfer biaya pendaftaran melalui <strong>Bank Syariah Indonesia (BSI)</strong> nomor rekening <strong>7011304251</strong> a.n. <strong>YL. Fatmawati</strong>.
                            </li>
                            <li>
                                Siapkan berkas foto atau hasil scan dalam bentuk format gambar/PDF akta kelahiran dan kartu keluarga.
                            </li>
                            <li>
                                Mengisi formulir PPDB 2026/2027 secara online pada website resmi: 
                                <a href="{{ route('ppdb.form') }}" class="text-[#00913e] font-bold underline">{{ url('/form_ppdb') }}</a>.
                            </li>
                            <li>
                                Konfirmasi pengisian formulir kepada panitia melalui WhatsApp.
                            </li>
                            <li>
                                Pendaftaran selesai dan berkas diverifikasi tim panitia untuk tahapan tes wawancara dan tahfidz.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- 2. Syarat Pendaftaran --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>2. Syarat Pendaftaran</span>
                        <i class="fa-solid" :class="activeLeft === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 2" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-1.5">
                            <li>Mengisi Formulir Pendaftaran online dengan data yang benar dan lengkap.</li>
                            <li>Melampirkan bukti transfer biaya pendaftaran.</li>
                            <li>Melampirkan scan/fotokopi Akta Kelahiran dan Kartu Keluarga (KK).</li>
                            <li>Melampirkan fotokopi rapor SMP/MTs semester 1-5.</li>
                            <li>Pas foto terbaru calon santri ukuran 3x4 berwarna.</li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Jalur Prestasi --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>3. Jalur Prestasi</span>
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

                {{-- 4. Jalur Hafizh Al-Qur'an --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>4. Jalur Hafizh Al-Qur'an</span>
                        <i class="fa-solid" :class="activeLeft === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 4" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Apresiasi istimewa bagi para penghafal Kitab Suci Al-Qur'an:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Tahfidz minimal 3 Juz: Beasiswa potongan biaya pendaftaran &amp; SPP.</li>
                            <li>Tahfidz 5 Juz atau lebih: Beasiswa SPP berkala dan pembinaan khusus Sanad/Mutqin.</li>
                            <li>Mengikuti tes sima'an tahfidz bersama dewan musyrif Al-Qur'an Ishum.</li>
                        </ul>
                    </div>
                </div>

                {{-- 5. Jalur Alumni SMPIT Ishum --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 5 ? null : 5)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>5. Jalur Alumni SMPIT Ishum</span>
                        <i class="fa-solid" :class="activeLeft === 5 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeLeft === 5" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Keringanan istimewa bagi lulusan SMPIT Ishlahul Ummah Prabumulih yang melanjutkan ke SMA IT Ishlahul Ummah Prabumulih berupa potongan biaya uang pangkal &amp; pendaftaran langsung tanpa biaya seleksi.</p>
                    </div>
                </div>

                {{-- 6. Jalur Tes Mandiri --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeLeft = (activeLeft === 6 ? null : 6)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>6. Jalur Tes Mandiri</span>
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
                        <span>1. Jadwal Gelombang PPDB</span>
                        <i class="fa-solid" :class="activeRight === 1 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 1" x-collapse class="p-5 text-xs text-slate-700 space-y-2.5 bg-emerald-50/20 leading-relaxed">
                        <div class="p-3.5 bg-white rounded-xl border border-emerald-200 font-medium space-y-1">
                            <span class="font-bold text-slate-900 block text-sm">GELOMBANG 3 (SEKARANG BUKA)</span>
                            <p class="text-slate-600">Masa Pendaftaran: <strong>Maret – Juni 2026</strong></p>
                            <p class="text-emerald-700 font-bold">PENGUMUMAN GELOMBANG 3: 25 JUNI 2026</p>
                        </div>
                        <p class="text-[11px] text-slate-500 italic">* Kuota terbatas setiap gelombang, pendaftaran akan ditutup otomatis apabila kuota kelas telah terpenuhi.</p>
                    </div>
                </div>

                {{-- 2. Rincian Biaya --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 2 ? null : 2)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>2. Rincian Biaya &amp; Seragam</span>
                        <i class="fa-solid" :class="activeRight === 2 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 2" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Biaya Formulir Pendaftaran: Ditransfer ke rekening BSI sekolah.</li>
                            <li>Paket Seragam Sekolah (4 stel seragam lengkap + atribut dan jilbab/peci).</li>
                            <li>Biaya Orientasi Santri (MPLS) &amp; Baitul Maqdis Leadership Camp.</li>
                            <li>Untuk tabel rincian lengkap uang pangkal dan SPP bulanan, hubungi panitia PPDB.</li>
                        </ul>
                    </div>
                </div>

                {{-- 3. Biaya Boarding / Asrama --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 3 ? null : 3)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>3. Pilihan Program: Boarding &amp; Full Day</span>
                        <i class="fa-solid" :class="activeRight === 3 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 3" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Pilihan program fleksibel sesuai kebutuhan santri:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Program Boarding (Asrama):</strong> Fasilitas asrama bersih, ber-AC/ventilasi sehat, makan 3x sehari, pendampingan tahfidz 24 jam bersama musyrif.</li>
                            <li><strong>Program Full Day School:</strong> Pembelajaran terpadu hingga sore hari, shalat berjamaah, makan siang sehat, dan ekstrakurikuler.</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Pengumuman Kelulusan --}}
                <div class="rounded-2xl border border-emerald-200 overflow-hidden bg-white shadow-xs">
                    <button @click="activeRight = (activeRight === 4 ? null : 4)" class="w-full bg-[#00913e] text-white px-5 py-3.5 flex items-center justify-between font-bold text-xs sm:text-sm text-left transition">
                        <span>4. Pengumuman Kelulusan &amp; Daftar Ulang</span>
                        <i class="fa-solid" :class="activeRight === 4 ? 'fa-minus' : 'fa-plus'"></i>
                    </button>
                    <div x-show="activeRight === 4" x-collapse class="p-5 text-xs text-slate-700 space-y-2 bg-emerald-50/20 leading-relaxed">
                        <p>Hasil seleksi diumumkan melalui website resmi dan WhatsApp kepada nomor kontak orang tua calon santri. Bagi yang dinyatakan diterima wajib melakukan daftar ulang sesuai jadwal yang ditentukan panitia.</p>
                    </div>
                </div>

            </div>

        </div>

        {{-- ACTION CARDS: FORMULIR PENDAFTARAN & HUBUNGI ADMIN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
            
            {{-- Card 1: Formulir Pendaftaran --}}
            <a href="{{ route('ppdb.form') }}" class="group bg-white p-8 rounded-3xl border-2 border-emerald-100 hover:border-[#00913e] shadow-md hover:shadow-2xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-red-50 text-[#da251c] flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-[#00913e] transition">
                            Formulir Pendaftaran Online
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Silakan Bapak/Ibu mengisi formulir pendaftaran online ini sebagai syarat pendaftaran di SMA IT Ishlahul Ummah dengan data yang valid dan benar.
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white text-xs font-black px-7 py-3.5 rounded-2xl shadow-md transition">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Isi Formulir Online Sekarang</span>
                </span>
            </a>

            {{-- Card 2: Hubungi Admin via WhatsApp --}}
            <a href="https://wa.me/6282182880628?text={{ urlencode('Halo Panitia PPDB SMA IT Ishlahul Ummah Prabumulih, saya ingin berkonsultasi mengenai pendaftaran santri baru TP 2026/2027.') }}" target="_blank" class="group bg-white p-8 rounded-3xl border-2 border-emerald-100 hover:border-[#00913e] shadow-md hover:shadow-2xl transition duration-300 text-center flex flex-col items-center justify-between">
                <div class="space-y-4">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-green-50 text-[#00913e] flex items-center justify-center text-4xl shadow-xs group-hover:scale-110 transition duration-300">
                        <i class="fa-brands fa-whatsapp text-4xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-900 group-hover:text-[#00913e] transition">
                            Konsultasi via WhatsApp
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Silakan konfirmasi jika sudah berhasil mengisi formulir pendaftaran, mengirim bukti transfer, atau butuh panduan langsung dari panitia SPMB.
                        </p>
                    </div>
                </div>
                <span class="mt-6 inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#007532] text-white text-xs font-bold px-7 py-3.5 rounded-2xl shadow-md transition">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Chat WhatsApp Panitia PPDB</span>
                </span>
            </a>

        </div>

        {{-- UCAPAN TERIMA KASIH & DOKUMENTASI KAMPUS ISHUM --}}
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-md border border-slate-200/80 text-center space-y-6">
            <div>
                <h3 class="text-xl sm:text-2xl font-black text-[#da251c] tracking-tight">
                    Terima Kasih Sudah Mendaftar di SMA Islam Terpadu Ishlahul Ummah Prabumulih
                </h3>
                <p class="text-xs sm:text-sm font-semibold text-[#00913e] mt-2 max-w-2xl mx-auto leading-relaxed">
                    Semoga Ananda kelak bisa menjadi anak yang cerdas, sholeh/ah, berbakti kepada orang tua dan menjadi kebanggaan bagi agama, bangsa dan negara. Aamiin
                </p>
            </div>

            {{-- Dokumentasi Fasilitas Ishum --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ishum/fasilitas_1377_IMG-20240528-WA0094-scaled.webp" alt="Gerbang Utama Kampus Ishum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ishum/fasilitas_3427_IMG-20240528-WA0106-scaled.webp" alt="Gedung Kampus Ishum" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-xs group">
                    <img src="/uploads/ishum/fasilitas_1278_HALL-SIT-Ishlahul-Ummah_.webp" alt="Hall Ishlahul Ummah" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">
                    Mendidik Sepenuh Cinta
                </p>
                <div class="mt-2 text-xs font-semibold text-[#00913e] tracking-wider uppercase">
                    SMA IT Ishlahul Ummah Prabumulih &bull; Anggota JSIT Indonesia
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
