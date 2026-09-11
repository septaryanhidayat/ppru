@extends('layouts.frontend')

@section('title', 'Testimonial Wali Santri & Alumni - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Suara, apresiasi, dan kesan para orang tua murid dan alumni terhadap mutu pendidikan di SMA Islam Terpadu Ishlahul Ummah Prabumulih.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Informasi</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Testimonial</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Testimonial Orang Tua & Alumni</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Kesan, apresiasi, dan pengalaman nyata para orang tua santri dan alumni mengenai kualitas pendidikan karakter dan akademik di SMA IT Ishlahul Ummah Prabumulih.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Kesan & Pengalaman Nyata</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Apresiasi Terhadap SMA IT Ishlahul Ummah Prabumulih
        </h2>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($testimonials as $idx => $testi)
            <div class="bg-white p-8 rounded-3xl shadow-md border border-gray-100 flex flex-col justify-between space-y-6 hover:shadow-xl transition transform hover:-translate-y-1 reveal-fade-up delay-{{ $idx % 4 }}">
                <div class="space-y-3">
                    <i class="fa-solid fa-quote-left text-3xl text-emerald-200"></i>
                    <p class="text-xs sm:text-sm text-gray-600 italic leading-relaxed">
                        "{{ $testi->content }}"
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left space-y-3 sm:space-y-0 sm:space-x-3 pt-4 border-t border-gray-50">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-[#00913e] font-bold flex items-center justify-center flex-shrink-0 overflow-hidden text-base shadow-sm mx-auto sm:mx-0">
                        @if($testi->photo)
                            <img src="{{ $testi->photo }}" alt="{{ $testi->name }}" class="w-full h-full object-cover" onerror="this.src='/uploads/campus-ishum.jpg'">
                        @else
                            {{ substr($testi->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="block font-bold text-sm text-gray-900 text-center sm:text-left">{{ $testi->name }}</span>
                        <span class="block text-xs text-orange-600 font-medium text-center sm:text-left">{{ $testi->profession }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-400 bg-white rounded-3xl border border-gray-100">
                <i class="fa-regular fa-comment-dots text-4xl text-gray-300 mb-3 block"></i>
                <span>Belum ada testimonial yang dipublikasikan.</span>
            </div>
        @endforelse
    </div>

</div>
@endsection
