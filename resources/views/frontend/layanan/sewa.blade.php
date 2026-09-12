@extends('layouts.frontend')

@section('title', 'Permohonan Sewa Menyewa Barang Sekolah - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Formulir permohonan sewa sarana dan fasilitas SMA IT Ishlahul Ummah Prabumulih: Hall Ishum, laboratorium komputer, lapangan olahraga, sound system, dan tenda.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Publik</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Sewa Barang &amp; Fasilitas</span>
        </nav>
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl shadow-md">
                <i class="fa-solid fa-building-user"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Permohonan Sewa Fasilitas &amp; Barang</h1>
                <p class="text-sm text-emerald-100 mt-1 font-light">
                    Penyewaan fasilitas Hall Ishum, sarana olahraga, ruang multimedia, dan sarana penunjang kegiatan.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    {{-- JUDUL RESMI TAMPILAN --}}
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-2xl sm:text-3xl font-black text-[#00913e] tracking-tight uppercase">
            PERMOHONAN SEWA MENYEWA BARANG SEKOLAH
        </h2>
        <p class="text-sm sm:text-base font-bold text-[#da251c] mt-1">
            SMA Islam Terpadu Ishlahul Ummah Prabumulih
        </p>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-2 border-[#00913e] rounded-3xl p-6 sm:p-8 mb-8 text-center space-y-4 shadow-lg animate-fadeIn">
            <div class="w-16 h-16 rounded-full bg-[#00913e] text-white flex items-center justify-center text-2xl mx-auto shadow-md">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="font-extrabold text-xl text-emerald-950">Permohonan Sewa Berhasil Dikirim!</h3>
            <p class="text-xs sm:text-sm text-emerald-800 max-w-lg mx-auto">
                {{ session('success') }}
            </p>
            @if(session('wa_url'))
                <div class="pt-2">
                    <a href="{{ session('wa_url') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-emerald-700 text-white font-extrabold text-xs sm:text-sm px-6 py-3 rounded-full shadow-lg transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Konfirmasi WhatsApp Bagian Sarpras</span>
                    </a>
                </div>
            @endif
        </div>
    @endif

    {{-- FORM CONTAINER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-xl space-y-8">
        <div class="border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                <i class="fa-solid fa-pen-clip text-[#00913e]"></i>
                <span>Silahkan isi Form dibawah ini</span>
            </h3>
            <p class="text-xs text-gray-500 mt-1 font-light">Lengkapi informasi fasilitas atau barang yang ingin disewa beserta waktu pemakaian.</p>
        </div>

        <form action="{{ route('layanan.sewa.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 1. Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap Pemohon *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap pemohon atau perwakilan penyewa" class="w-full bg-gray-50 text-xs sm:text-sm text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:bg-white transition">
                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 2. Asal Instansi / Komunitas --}}
            <div>
                <label for="agency" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Asal Instansi / Komunitas / Pribadi *</label>
                <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" placeholder="Contoh: Komunitas Olahraga Prabumulih / Yayasan Bina Insan / Pribadi" class="w-full bg-gray-50 text-xs sm:text-sm text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:bg-white transition">
                @error('agency') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 3. Nomor WhatsApp --}}
            <div>
                <label for="whatsapp" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor WhatsApp Aktif *</label>
                <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp') }}" placeholder="Contoh: 081234567890 (untuk pengecekan jadwal dan biaya)" class="w-full bg-gray-50 text-xs sm:text-sm text-gray-800 rounded-xl px-4 py-3 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:bg-white transition">
                @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 4. Fasilitas / Barang yang Ingin Disewa --}}
            <div>
                <label for="purpose" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Fasilitas / Barang yang Ingin Disewa &amp; Tanggal Pemakaian *</label>
                <textarea name="purpose" id="purpose" rows="4" required placeholder="Sebutkan sarana yang dibutuhkan (misal: Hall Ishum untuk acara seminar, lapangan futsal, proyektor sound system, tenda), beserta tanggal dan estimasi durasi pemakaian..." class="w-full bg-gray-50 text-xs sm:text-sm text-gray-800 rounded-xl p-4 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e] focus:bg-white transition leading-relaxed">{{ old('purpose') }}</textarea>
                @error('purpose') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 5. Sertakan Surat Permohonan --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-gray-50 border border-gray-200 space-y-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Sertakan Surat Permohonan Sewa (PDF / DOC / JPG) *
                </label>
                <p class="text-[11px] text-gray-500">Surat pengajuan sewa fasilitas / sarana resmi (Maksimal 5MB).</p>
                <input type="file" name="letter_file" required accept=".pdf,.doc,.docx,image/*" class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-emerald-700 cursor-pointer">
                @error('letter_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 6. Sertakan KTP --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-gray-50 border border-gray-200 space-y-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Sertakan KTP Pemohon (Foto / PDF) *
                </label>
                <p class="text-[11px] text-gray-500">Foto KTP penanggung jawab sewa (Maksimal 5MB).</p>
                <input type="file" name="ktp_file" required accept="image/*,.pdf" class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#da251c] file:text-white hover:file:bg-[#b91c1c] cursor-pointer">
                @error('ktp_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 7. Sertakan NPWP (Opsional) --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-gray-50 border border-gray-200 space-y-2">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                    Sertakan NPWP (Opsional untuk Lembaga/Perusahaan)
                </label>
                <p class="text-[11px] text-gray-500">Lampirkan foto/file NPWP instansi jika diperlukan administrasi perpajakan resmi.</p>
                <input type="file" name="npwp_file" accept="image/*,.pdf" class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-600 file:text-white hover:file:bg-slate-700 cursor-pointer">
                @error('npwp_file') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Portal Layanan</span>
                </a>
                <button type="submit" class="w-full sm:w-auto bg-[#00913e] hover:bg-emerald-700 text-white font-extrabold text-sm px-8 py-3.5 rounded-full shadow-lg hover:shadow-xl transition flex items-center justify-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>KIRIM PERMOHONAN SEWA</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
