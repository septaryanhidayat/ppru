@extends('layouts.frontend')

@section('title', 'Permohonan Kerja Sama - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Kemitraan dan permohonan kerjasama strategis bersama SMA IT Ishlahul Ummah Prabumulih.')

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('layanan.index') }}" class="hover:text-white transition">Layanan Terpadu</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Kerja Sama</span>
        </nav>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
            Permohonan Kerja Sama &amp; Kemitraan
        </h1>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-8">
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! $page?->content ?: '<p>SMA IT Ishlahul Ummah Prabumulih senantiasa membuka pintu kolaborasi dan sinergi bersama berbagai pihak, baik lembaga pendidikan, institusi pemerintah, perbankan syariah, maupun dunia usaha.</p>' !!}
        </div>

        <div class="bg-amber-50 rounded-2xl p-6 border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-amber-950 text-base">Diskusikan Kemitraan Strategis</h4>
                <p class="text-xs text-amber-800 mt-1">Proposal kemitraan dapat disampaikan secara digital atau audiensi langsung.</p>
            </div>
            <a href="https://wa.me/6282182680647?text=Assalamu'alaikum%20Pimpinan%20SMA%20IT%20Ishum,%20kami%20ingin%20mengajukan%20proposal%20kerja%20sama." target="_blank" class="inline-flex items-center space-x-2 bg-amber-600 text-white font-bold px-5 py-2.5 rounded-xl text-xs hover:bg-amber-700 transition shadow-md whitespace-nowrap">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Hubungi Tim Kemitraan</span>
            </a>
        </div>
    </div>
</div>
@endsection
