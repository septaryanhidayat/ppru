@extends('layouts.admin')

@section('title', 'Kelola Konten & Persyaratan Layanan Terpadu')
@section('header_title', 'Kelola Persyaratan, Prosedur & Konten Layanan Terpadu')

@push('styles')
<style>
    /* Styling Toolbar Word-like untuk Akordion Layanan */
    .accordion-item .ql-toolbar.ql-snow {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        border-color: #cbd5e1;
        background-color: #f8fafc;
        padding: 6px 10px;
    }
    .accordion-item .ql-container.ql-snow {
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-color: #cbd5e1;
        background-color: #ffffff;
        font-family: inherit;
        font-size: 0.85rem;
        min-height: 120px !important;
        max-height: 380px !important;
    }
    .accordion-item .ql-editor {
        min-height: 120px !important;
        max-height: 380px !important;
        padding: 12px 16px !important;
        line-height: 1.7 !important;
        color: #1e293b;
    }
    .accordion-item .ql-editor p {
        margin-bottom: 0.5rem !important;
    }
    .accordion-item .ql-editor ul, .accordion-item .ql-editor ol {
        padding-left: 1.25rem !important;
        margin-bottom: 0.5rem !important;
    }
    .accordion-item .ql-editor li {
        margin-bottom: 0.25rem !important;
    }
    .accordion-item .ql-editor .ql-align-justify {
        text-align: justify !important;
        text-justify: inter-word;
    }
    .accordion-item .ql-editor .ql-align-center {
        text-align: center !important;
    }
    .accordion-item .ql-editor .ql-align-right {
        text-align: right !important;
    }
</style>
@endpush

@section('content')
<div class="space-y-6" x-data="{ activeTab: '{{ request('tab', 'portal') }}' }">

    {{-- TOP NAVIGATION TABS --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.layanan.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 transition shadow-xs">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Daftar Permohonan
            </a>

            <button type="button" @click="activeTab = 'portal'" :class="activeTab === 'portal' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-handshake-angle"></i>
                <span>Portal Utama &amp; 3 Kartu Layanan</span>
            </button>

            <button type="button" @click="activeTab = 'izin'" :class="activeTab === 'izin' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-school"></i>
                <span>1. Izin Kunjungan</span>
            </button>

            <button type="button" @click="activeTab = 'kerjasama'" :class="activeTab === 'kerjasama' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-handshake"></i>
                <span>2. Kerja Sama</span>
            </button>

            <button type="button" @click="activeTab = 'sewa'" :class="activeTab === 'sewa' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-boxes-packing"></i>
                <span>3. Sewa Barang</span>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <a :href="activeTab === 'portal' ? '{{ route('layanan.index') }}' : (activeTab === 'izin' ? '{{ route('layanan.izin') }}' : (activeTab === 'kerjasama' ? '{{ route('layanan.kerjasama') }}' : '{{ route('layanan.sewa') }}'))" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-900 text-white transition flex items-center space-x-1.5 shadow-xs">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Pratinjau Halaman Web</span>
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB 0: PORTAL UTAMA PTSP & 3 KARTU LAYANAN --}}
    {{-- ============================================================ --}}
    <div x-show="activeTab === 'portal'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="portal">

            {{-- Hero Portal --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-5">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-slate-900 flex items-center justify-center font-black text-lg">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Header &amp; Pengantar Portal Layanan Terpadu</h3>
                        <p class="text-xs text-slate-500">Teks pembuka dan narasi pintu pelayanan terpadu satu pintu (PTSP).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header</label>
                        <input type="text" name="layanan_portal_hero_badge" value="{{ $settings['layanan_portal_hero_badge'] ?? 'Pelayanan Terpadu Satu Pintu (PTSP)' }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Hero</label>
                        <input type="text" name="layanan_portal_hero_title" value="{{ $settings['layanan_portal_hero_title'] ?? 'PORTAL LAYANAN TERPADU' }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hero</label>
                        <textarea name="layanan_portal_hero_desc" rows="2" class="w-full bg-slate-50 text-xs rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['layanan_portal_hero_desc'] ?? 'Satu pintu pelayanan administrasi resmi, perizinan kunjungan edukasi, kemitraan strategis, dan peminjaman fasilitas Pondok Pesantren Raudhatul Ulum Sakatiga.' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-3 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Pilihan Layanan</label>
                        <input type="text" name="layanan_section_title" value="{{ $settings['layanan_section_title'] ?? 'Pilih Layanan yang Anda Butuhkan' }}" class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Seksi Pilihan Layanan</label>
                        <input type="text" name="layanan_section_desc" value="{{ $settings['layanan_section_desc'] ?? 'Ajukan permohonan secara daring, tim Sekretariat dan Humas akan memproses permohonan Anda secara cepat, transparan, dan profesional.' }}" class="w-full bg-slate-50 text-xs rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                </div>
            </div>

            {{-- 3 Kartu Layanan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Kartu 1: Izin --}}
                <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80 space-y-4">
                    <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-id-card-clip"></i>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">1. Layanan Izin Kunjungan</h4>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Badge Kartu</label>
                        <input type="text" name="layanan_card_1_badge" value="{{ $settings['layanan_card_1_badge'] ?? 'Layanan Izin' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul Layanan</label>
                        <input type="text" name="layanan_card_1_title" value="{{ $settings['layanan_card_1_title'] ?? 'Permohonan Izin Kunjungan ke Sekolah' }}" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="layanan_card_1_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-2.5 border border-slate-200">{{ $settings['layanan_card_1_desc'] ?? 'Layanan pengajuan studi banding, observasi kurikulum kepesantrenan, riset ilmiah, atau kunjungan silaturahmi instansi/sekolah ke Pondok Pesantren Raudhatul Ulum.' }}</textarea>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Poin Benefit (Pisahkan dengan tanda |)</label>
                        <input type="text" name="layanan_card_1_benefits" value="{{ $settings['layanan_card_1_benefits'] ?? 'Bebas Biaya (Gratis)|Tur keliling fasilitas pondok|Respon konfirmasi maks 3 hari' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Teks Tombol Aksi</label>
                        <input type="text" name="layanan_card_1_btn_text" value="{{ $settings['layanan_card_1_btn_text'] ?? 'Ajukan Izin Kunjungan' }}" class="w-full bg-slate-50 text-xs font-bold text-[#00843d] rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                </div>

                {{-- Kartu 2: Kerjasama --}}
                <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80 space-y-4">
                    <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">2. Permohonan Kerja Sama</h4>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Badge Kartu</label>
                        <input type="text" name="layanan_card_2_badge" value="{{ $settings['layanan_card_2_badge'] ?? 'Kemitraan & MoU' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul Layanan</label>
                        <input type="text" name="layanan_card_2_title" value="{{ $settings['layanan_card_2_title'] ?? 'Permohonan Kerja Sama' }}" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="layanan_card_2_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-2.5 border border-slate-200">{{ $settings['layanan_card_2_desc'] ?? 'Pengajuan kolaborasi program akademik, beasiswa, program CSR dunia usaha, riset bersama, dan kemitraan lembaga keuangan syariah atau universitas.' }}</textarea>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Poin Benefit (Pisahkan dengan tanda |)</label>
                        <input type="text" name="layanan_card_2_benefits" value="{{ $settings['layanan_card_2_benefits'] ?? 'MoU resmi berkekuatan hukum|Kolaborasi program berkelanjutan|Publikasi bersama media resmi' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Teks Tombol Aksi</label>
                        <input type="text" name="layanan_card_2_btn_text" value="{{ $settings['layanan_card_2_btn_text'] ?? 'Ajukan Permohonan MoU' }}" class="w-full bg-slate-50 text-xs font-bold text-amber-700 rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                </div>

                {{-- Kartu 3: Sewa --}}
                <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-200/80 space-y-4">
                    <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <h4 class="font-black text-slate-900 text-sm">3. Sewa Sarana &amp; Fasilitas</h4>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Badge Kartu</label>
                        <input type="text" name="layanan_card_3_badge" value="{{ $settings['layanan_card_3_badge'] ?? 'Peminjaman Aset' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul Layanan</label>
                        <input type="text" name="layanan_card_3_title" value="{{ $settings['layanan_card_3_title'] ?? 'Permohonan Sewa Menyewa Barang Sekolah' }}" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Deskripsi Ringkas</label>
                        <textarea name="layanan_card_3_desc" rows="3" class="w-full bg-slate-50 text-xs rounded-xl p-2.5 border border-slate-200">{{ $settings['layanan_card_3_desc'] ?? 'Fasilitas peminjaman atau penyewaan sarana aula serbaguna, panggung, sound system, lapangan olahraga, atau peralatan kegiatan bagi masyarakat dan instansi.' }}</textarea>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Poin Benefit (Pisahkan dengan tanda |)</label>
                        <input type="text" name="layanan_card_3_benefits" value="{{ $settings['layanan_card_3_benefits'] ?? 'Fasilitas bersih & terawat|Kapasitas representatif|Pendampingan teknisi lapangan' }}" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Teks Tombol Aksi</label>
                        <input type="text" name="layanan_card_3_btn_text" value="{{ $settings['layanan_card_3_btn_text'] ?? 'Ajukan Sewa Fasilitas' }}" class="w-full bg-slate-50 text-xs font-bold text-purple-700 rounded-xl px-3 py-2 border border-slate-200">
                    </div>
                </div>
            </div>

            {{-- Kontak Helpdesk PTSP --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xs border border-slate-200/80 space-y-5">
                <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center font-black text-lg">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Kontak Bantuan Meja Pelayanan (PTSP)</h3>
                        <p class="text-xs text-slate-500">Nomor WhatsApp, email resmi sekretariat, dan jam operasional pelayanan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">WhatsApp Layanan</label>
                        <input type="text" name="layanan_ptsp_wa" value="{{ $settings['layanan_ptsp_wa'] ?? '081278901950' }}" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-4 py-3 border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Sekretariat</label>
                        <input type="email" name="layanan_ptsp_email" value="{{ $settings['layanan_ptsp_email'] ?? 'sekretariat@ppru.ac.id' }}" class="w-full bg-slate-50 text-xs font-bold rounded-xl px-4 py-3 border border-slate-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jam Kerja Pelayanan</label>
                        <input type="text" name="layanan_ptsp_hours" value="{{ $settings['layanan_ptsp_hours'] ?? 'Senin - Sabtu: 08.00 - 15.00 WIB' }}" class="w-full bg-slate-50 text-xs rounded-xl px-4 py-3 border border-slate-200">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Bantuan</label>
                        <input type="text" name="layanan_ptsp_note" value="{{ $settings['layanan_ptsp_note'] ?? 'Butuh bantuan cepat atau konfirmasi mendesak? Hubungi meja resepsionis & sekretariat resmi.' }}" class="w-full bg-slate-50 text-xs rounded-xl px-4 py-3 border border-slate-200">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="submit" class="bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs px-7 py-3 rounded-xl shadow-lg transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Pengaturan Portal Layanan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ALERT INFO WORD TOOLBAR --}}
    <div x-show="activeTab !== 'portal'" class="bg-emerald-50 border border-emerald-200/80 rounded-2xl p-4 text-xs text-emerald-900 flex items-start space-x-3 shadow-xs">
        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
            <i class="fa-solid fa-spell-check"></i>
        </div>
        <div class="leading-relaxed">
            <span class="font-extrabold text-slate-900 block text-xs mb-0.5">Toolbar Visual ala Microsoft Word (Tanpa Perlu Tulis Kode HTML)</span>
            <span>
                Gunakan toolbar di atas kotak teks untuk memformat kalimat: 
                <strong>Tebal (Bold)</strong>, <em>Miring (Italic)</em>, <u>Garis Bawah</u>, 
                <span class="bg-emerald-100 px-1 py-0.5 rounded font-bold">Rata Penuh (Justify)</span>, Rata Tengah/Kanan, Daftar Poin (Bullet), Nomor, maupun warna teks. Teks yang tersimpan akan langsung rapi di tampilan publik website sekolah.
            </span>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB 1: IZIN KUNJUNGAN SEKOLAH --}}
    {{-- ============================================================ --}}
    <div x-show="activeTab === 'izin'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" id="form-layanan-izin" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="izin">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Izin Kunjungan Sekolah</h3>
                            <span class="text-xs text-slate-400">Halaman Publik: /izin-sekolah</span>
                        </div>
                    </div>

                    <button type="button" onclick="addAccordionItem('izin')" class="px-3.5 py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir Baru</span>
                    </button>
                </div>

                <div id="items-container-izin" class="space-y-5">
                    @foreach($izinAccordions as $idx => $item)
                        <div class="accordion-item p-5 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-3.5 transition" data-service="izin">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="item-number w-7 h-7 rounded-lg bg-[#00913e] text-white font-black text-xs flex items-center justify-center flex-shrink-0 shadow-xs">{{ $idx + 1 }}</span>
                                    <input type="text" name="titles[]" value="{{ $item['title'] }}" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3.5 py-2.5 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" onclick="moveItemUp(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Naikkan Urutan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" onclick="moveItemDown(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Turunkan Urutan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" onclick="removeAccordionItem(this)" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir Ini">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-pen-nib text-[#00913e] text-xs"></i>
                                    <span>Rincian Kalimat / Isi Persyaratan (Ketik &amp; Format Menggunakan Toolbar Word di Atas):</span>
                                </label>
                                <input type="hidden" name="contents[]" id="input_izin_{{ $idx }}" value="{{ $item['content'] }}">
                                <div id="editor_izin_{{ $idx }}" class="accordion-quill-editor bg-white"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-3 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-md cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Izin Kunjungan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB 2: PERMOHONAN KERJA SAMA --}}
    {{-- ============================================================ --}}
    <div x-show="activeTab === 'kerjasama'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" id="form-layanan-kerjasama" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="kerjasama">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Permohonan Kerja Sama</h3>
                            <span class="text-xs text-slate-400">Halaman Publik: /permohonan-kerja-sama</span>
                        </div>
                    </div>

                    <button type="button" onclick="addAccordionItem('kerjasama')" class="px-3.5 py-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir Baru</span>
                    </button>
                </div>

                <div id="items-container-kerjasama" class="space-y-5">
                    @foreach($kerjasamaAccordions as $idx => $item)
                        <div class="accordion-item p-5 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-3.5 transition" data-service="kerjasama">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="item-number w-7 h-7 rounded-lg bg-[#00913e] text-white font-black text-xs flex items-center justify-center flex-shrink-0 shadow-xs">{{ $idx + 1 }}</span>
                                    <input type="text" name="titles[]" value="{{ $item['title'] }}" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3.5 py-2.5 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" onclick="moveItemUp(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Naikkan Urutan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" onclick="moveItemDown(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Turunkan Urutan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" onclick="removeAccordionItem(this)" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir Ini">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-pen-nib text-[#00913e] text-xs"></i>
                                    <span>Rincian Kalimat / Isi Persyaratan (Ketik &amp; Format Menggunakan Toolbar Word di Atas):</span>
                                </label>
                                <input type="hidden" name="contents[]" id="input_kerjasama_{{ $idx }}" value="{{ $item['content'] }}">
                                <div id="editor_kerjasama_{{ $idx }}" class="accordion-quill-editor bg-white"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-3 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-md cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Kerja Sama</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB 3: SEWA BARANG MILIK SEKOLAH --}}
    {{-- ============================================================ --}}
    <div x-show="activeTab === 'sewa'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" id="form-layanan-sewa" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="sewa">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Sewa Barang Milik Sekolah</h3>
                            <span class="text-xs text-slate-400">Halaman Publik: /sewa-barang</span>
                        </div>
                    </div>

                    <button type="button" onclick="addAccordionItem('sewa')" class="px-3.5 py-2 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir Baru</span>
                    </button>
                </div>

                <div id="items-container-sewa" class="space-y-5">
                    @foreach($sewaAccordions as $idx => $item)
                        <div class="accordion-item p-5 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-3.5 transition" data-service="sewa">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="item-number w-7 h-7 rounded-lg bg-[#00913e] text-white font-black text-xs flex items-center justify-center flex-shrink-0 shadow-xs">{{ $idx + 1 }}</span>
                                    <input type="text" name="titles[]" value="{{ $item['title'] }}" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3.5 py-2.5 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" onclick="moveItemUp(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Naikkan Urutan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" onclick="moveItemDown(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Turunkan Urutan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" onclick="removeAccordionItem(this)" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir Ini">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 flex items-center space-x-1.5">
                                    <i class="fa-solid fa-pen-nib text-[#00913e] text-xs"></i>
                                    <span>Rincian Kalimat / Isi Persyaratan (Ketik &amp; Format Menggunakan Toolbar Word di Atas):</span>
                                </label>
                                <input type="hidden" name="contents[]" id="input_sewa_{{ $idx }}" value="{{ $item['content'] }}">
                                <div id="editor_sewa_{{ $idx }}" class="accordion-quill-editor bg-white"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-3 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-md cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Sewa Barang</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    // Word-like Toolbar Specification: Heading, Bold, Italic, Underline, Strike, Align (Left, Center, Right, Justify), List, Colors, Clean
    const wordToolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }, { 'align': 'justify' }],
        [{ 'list': 'bullet' }, { 'list': 'ordered' }],
        [{ 'color': [] }, { 'background': [] }],
        ['clean']
    ];

    let editorCounter = 1000;

    /**
     * Clean and normalize HTML content before inserting into Quill
     */
    function cleanHtmlForAccordion(html) {
        if (!html) return '';
        let cleaned = html.replace(/<!--\s*\/?wp:[^>]*-->/gi, '');
        cleaned = cleaned.replace(/>\s*\n+\s*</g, '><');
        return cleaned.trim();
    }

    /**
     * Set Indonesian tooltips on Quill toolbar buttons
     */
    function applyWordTooltips(toolbarEl) {
        if (!toolbarEl) return;
        const tooltips = {
            '.ql-bold': 'Tebal (Bold)',
            '.ql-italic': 'Miring (Italic)',
            '.ql-underline': 'Garis Bawah (Underline)',
            '.ql-strike': 'Coret Teks (Strikethrough)',
            '.ql-align': 'Perataan Teks (Rata Kiri, Tengah, Kanan, Rata Penuh)',
            '.ql-align[value=""]': 'Rata Kiri',
            '.ql-align[value="center"]': 'Rata Tengah',
            '.ql-align[value="right"]': 'Rata Kanan',
            '.ql-align[value="justify"]': 'Rata Penuh (Justify)',
            '.ql-list[value="bullet"]': 'Daftar Butir (Bullet List)',
            '.ql-list[value="ordered"]': 'Daftar Nomor (Numbered List)',
            '.ql-color': 'Warna Teks',
            '.ql-background': 'Warna Sorotan (Highlight)',
            '.ql-clean': 'Hapus Format (Clear Formatting)'
        };
        for (const [selector, text] of Object.entries(tooltips)) {
            const btn = toolbarEl.querySelector(selector);
            if (btn) btn.setAttribute('title', text);
        }
    }

    /**
     * Initialize Quill instance on an element
     */
    function initQuillOnElement(editorEl, inputEl) {
        if (editorEl.__quill) return editorEl.__quill;

        const quill = new Quill(editorEl, {
            theme: 'snow',
            modules: {
                toolbar: wordToolbarOptions
            }
        });

        // Load initial content from hidden input
        if (inputEl && inputEl.value) {
            quill.root.innerHTML = cleanHtmlForAccordion(inputEl.value);
        }

        // Keep input updated on change
        quill.on('text-change', function() {
            if (inputEl) {
                inputEl.value = quill.root.innerHTML;
            }
        });

        editorEl.__quill = quill;

        // Apply tooltips to toolbar
        const toolbarEl = editorEl.previousElementSibling;
        applyWordTooltips(toolbarEl);

        return quill;
    }

    /**
     * Add new accordion item to the specified service tab
     */
    function addAccordionItem(type) {
        const container = document.getElementById(`items-container-${type}`);
        if (!container) return;

        editorCounter++;
        const newId = `new_${type}_${editorCounter}`;

        const itemDiv = document.createElement('div');
        itemDiv.className = 'accordion-item p-5 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-3.5 transition';
        itemDiv.setAttribute('data-service', type);

        itemDiv.innerHTML = `
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center space-x-2 flex-1">
                    <span class="item-number w-7 h-7 rounded-lg bg-[#00913e] text-white font-black text-xs flex items-center justify-center flex-shrink-0 shadow-xs">?</span>
                    <input type="text" name="titles[]" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3.5 py-2.5 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                </div>

                <div class="flex items-center space-x-1">
                    <button type="button" onclick="moveItemUp(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Naikkan Urutan">
                        <i class="fa-solid fa-chevron-up text-xs"></i>
                    </button>
                    <button type="button" onclick="moveItemDown(this)" class="p-2 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 transition cursor-pointer" title="Turunkan Urutan">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <button type="button" onclick="removeAccordionItem(this)" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir Ini">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1.5 flex items-center space-x-1.5">
                    <i class="fa-solid fa-pen-nib text-[#00913e] text-xs"></i>
                    <span>Rincian Kalimat / Isi Persyaratan (Ketik &amp; Format Menggunakan Toolbar Word di Atas):</span>
                </label>
                <input type="hidden" name="contents[]" id="input_${newId}" value="<p>Tuliskan rincian persyaratan atau ketentuan di sini...</p>">
                <div id="editor_${newId}" class="accordion-quill-editor bg-white"></div>
            </div>
        `;

        container.appendChild(itemDiv);

        // Initialize Quill on the new element
        const editorEl = itemDiv.querySelector('.accordion-quill-editor');
        const inputEl = itemDiv.querySelector(`input[id="input_${newId}"]`);
        initQuillOnElement(editorEl, inputEl);

        renumberItems(type);

        // Smooth scroll to the newly created item
        itemDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    /**
     * Remove accordion item card
     */
    function removeAccordionItem(btn) {
        const itemDiv = btn.closest('.accordion-item');
        if (!itemDiv) return;

        if (confirm('Apakah Anda yakin ingin menghapus butir persyaratan ini?')) {
            const type = itemDiv.getAttribute('data-service');
            itemDiv.remove();
            if (type) renumberItems(type);
        }
    }

    /**
     * Move accordion item card up
     */
    function moveItemUp(btn) {
        const itemDiv = btn.closest('.accordion-item');
        if (!itemDiv) return;
        const prev = itemDiv.previousElementSibling;
        if (prev && prev.classList.contains('accordion-item')) {
            // Sync current editor content to hidden input
            syncItemContent(itemDiv);
            syncItemContent(prev);
            itemDiv.parentNode.insertBefore(itemDiv, prev);
            const type = itemDiv.getAttribute('data-service');
            if (type) renumberItems(type);
        }
    }

    /**
     * Move accordion item card down
     */
    function moveItemDown(btn) {
        const itemDiv = btn.closest('.accordion-item');
        if (!itemDiv) return;
        const next = itemDiv.nextElementSibling;
        if (next && next.classList.contains('accordion-item')) {
            // Sync current editor content to hidden input
            syncItemContent(itemDiv);
            syncItemContent(next);
            itemDiv.parentNode.insertBefore(next, itemDiv);
            const type = itemDiv.getAttribute('data-service');
            if (type) renumberItems(type);
        }
    }

    /**
     * Sync quill root innerHTML into input
     */
    function syncItemContent(itemDiv) {
        const editorEl = itemDiv.querySelector('.accordion-quill-editor');
        const inputEl = itemDiv.querySelector('input[type="hidden"][name="contents[]"]');
        if (editorEl && editorEl.__quill && inputEl) {
            inputEl.value = editorEl.__quill.root.innerHTML;
        }
    }

    /**
     * Renumber badge counters in a container
     */
    function renumberItems(type) {
        const container = document.getElementById(`items-container-${type}`);
        if (!container) return;
        const items = container.querySelectorAll('.accordion-item');
        items.forEach((item, idx) => {
            const numEl = item.querySelector('.item-number');
            if (numEl) numEl.textContent = idx + 1;
        });
    }

    // Initialize all existing accordion Quill editors on load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.accordion-item').forEach(function(itemDiv) {
            const editorEl = itemDiv.querySelector('.accordion-quill-editor');
            const inputEl = itemDiv.querySelector('input[type="hidden"][name="contents[]"]');
            if (editorEl && inputEl) {
                initQuillOnElement(editorEl, inputEl);
            }
        });

        // Ensure form syncs all quill editors on submit
        ['izin', 'kerjasama', 'sewa'].forEach(function(type) {
            const form = document.getElementById(`form-layanan-${type}`);
            if (form) {
                form.addEventListener('submit', function() {
                    const container = document.getElementById(`items-container-${type}`);
                    if (container) {
                        container.querySelectorAll('.accordion-item').forEach(syncItemContent);
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
