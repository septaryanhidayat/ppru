@extends('layouts.frontend')

@section('title', 'Permohonan Izin Kunjungan - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Prosedur dan formulir pengajuan izin kunjungan, studi banding, atau observasi ke SMA IT Ishlahul Ummah Prabumulih.')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Terpadu</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Izin Kunjungan</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
            Permohonan Izin Kunjungan ke Sekolah
        </h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-8">
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! $page?->content ?: '<p>Silakan isi formulir permohonan kunjungan atau hubungi humas kami melalui WhatsApp resmi sekolah minimal 3 hari sebelum jadwal kunjungan.</p>' !!}
        </div>

        <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-emerald-950 text-base">Hubungi Layanan Terpadu &amp; Humas</h4>
                <p class="text-xs text-emerald-800 mt-1">Konfirmasi jadwal dan surat pengantar kunjungan resmi.</p>
            </div>
            <a href="https://wa.me/6282182680647?text=Assalamu'alaikum%20Humas%20SMA%20IT%20Ishum,%20kami%20ingin%20mengajukan%20permohonan%20kunjungan%20ke%20sekolah." target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] text-white font-bold px-5 py-2.5 rounded-xl text-xs hover:bg-emerald-700 transition shadow-md whitespace-nowrap">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Hubungi via WhatsApp</span>
            </a>
        </div>
    </div>
</div>
@endsection
