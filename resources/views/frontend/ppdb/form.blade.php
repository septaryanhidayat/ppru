@extends('layouts.frontend')

@section('title', 'Formulir Pendaftaran PSB ' . ($formSettings['year'] ?? '2026/2027') . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Formulir Pendaftaran Santri Baru (PSB Online) Pondok Pesantren Raudhatul Ulum Sakatiga Tahun Pelajaran ' . ($formSettings['year'] ?? '2026/2027') . '.')

@section('content')
<div class="bg-gray-50 py-10 sm:py-14 font-['Poppins',sans-serif]">
    <div class="max-w-4xl lg:max-w-5xl mx-auto px-4 sm:px-6">

        {{-- JIKA FORMULIR SEDANG DITUTUP SEMENTARA --}}
        @if(($formSettings['status'] ?? '1') === '0')
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-12 text-center space-y-6">
                <div class="w-24 h-24 mx-auto rounded-3xl bg-amber-50 text-amber-600 flex items-center justify-center text-4xl shadow-inner">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="space-y-2">
                    <span class="inline-block bg-amber-100 text-amber-800 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider">
                        Pemberitahuan SPMB
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Pendaftaran Online Ditutup Sementara
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed pt-2">
                        {{ $formSettings['closed_message'] ?? 'Pendaftaran PPDB online saat ini sedang ditutup sementara atau kuota telah terpenuhi. Silakan hubungi panitia melalui WhatsApp untuk informasi gelombang berikutnya.' }}
                    </p>
                </div>

                @php
                    $cleanHotline = preg_replace('/[^0-9]/', '', (string) ($formSettings['hotline_phone'] ?? '081278901950'));
                    if (str_starts_with($cleanHotline, '0')) {
                        $cleanHotline = '62' . substr($cleanHotline, 1);
                    }
                @endphp
                <div class="pt-4 flex flex-wrap items-center justify-center gap-3">
                    <a href="https://wa.me/{{ $cleanHotline }}?text={{ urlencode('Assalamu\'alaikum Panitia PSB PPRU Sakatiga, saya ingin menanyakan jadwal pendaftaran/kuota santri baru.') }}" target="_blank" class="inline-flex items-center space-x-2 bg-[#00913e] hover:bg-[#007532] text-white px-7 py-3.5 rounded-2xl text-xs sm:text-sm font-black transition shadow-lg shadow-emerald-500/25">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Hubungi Panitia via WhatsApp</span>
                    </a>
                    <a href="{{ route('ppdb.index') }}" class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3.5 rounded-2xl text-xs sm:text-sm font-bold transition">
                        <i class="fa-solid fa-circle-info text-sm"></i>
                        <span>Lihat Informasi PPDB</span>
                    </a>
                </div>
            </div>

        @else

        {{-- FORM CONTAINER CARD --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-10 space-y-8">
            
            {{-- HEADER LOGO & JUDUL --}}
            <div class="text-center space-y-4">
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto p-1 rounded-2xl flex items-center justify-center">
                    <img src="/uploads/logo-ppru-square.png" alt="Logo PPRU Sakatiga" class="h-full w-auto object-contain">
                </div>

                <div class="space-y-1">
                    <h1 class="text-lg sm:text-xl md:text-2xl font-black text-[#00913e] tracking-tight leading-snug">
                        Formulir Pendaftaran Peserta Didik Baru<br>
                        Pondok Pesantren Raudhatul Ulum Sakatiga
                    </h1>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Isi formulir dengan data yang sah dan lengkap. Tanda bintang (<span class="text-red-500 font-bold">*</span>) wajib diisi.
                    </p>
                </div>
            </div>

            {{-- KOTAK PENGUMUMAN / INFO ATAS FORM --}}
            @if(!empty($formSettings['announcement']))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-start space-x-3 shadow-xs">
                    <div class="w-7 h-7 rounded-xl bg-emerald-200 text-[#00913e] flex items-center justify-center font-bold flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-bullhorn text-xs"></i>
                    </div>
                    <div class="leading-relaxed">
                        <strong class="block text-emerald-950 font-bold mb-0.5">Petunjuk &amp; Pengumuman Pendaftaran:</strong>
                        <span>{{ $formSettings['announcement'] }}</span>
                    </div>
                </div>
            @endif

            {{-- ERROR SUMMARY IF ANY --}}
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                    <p class="font-bold flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1.5 text-red-500"></i>
                        Mohon periksa kembali isian formulir:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- REGISTRATION FORM --}}
            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs text-slate-700">
                @csrf

                @php
                    $sectionIndex = 1;
                @endphp

                @foreach($sections as $secKey => $secInfo)
                    @if(!empty($groupedFields[$secKey]) && count($groupedFields[$secKey]) > 0)
                        <div class="space-y-4 pt-4 border-t border-slate-100 first:border-t-0 first:pt-2">
                            <div class="pb-2 border-b border-emerald-100 flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">
                                    {{ $sectionIndex++ }}
                                </span>
                                <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                    <i class="{{ $secInfo['icon'] ?? 'fa-solid fa-folder' }} text-emerald-600"></i>
                                    <span>{{ $secInfo['name'] }}</span>
                                </h2>
                            </div>

                            @if($secKey === 'pilihan')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                                    @foreach($groupedFields[$secKey] as $f)
                                        @include('frontend.ppdb.partials.form_field', ['field' => $f])
                                    @endforeach
                                </div>
                            @elseif($secKey === 'berkas')
                                <div class="space-y-4">
                                    @foreach($groupedFields[$secKey] as $f)
                                        @include('frontend.ppdb.partials.form_field', ['field' => $f])
                                    @endforeach
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                    @foreach($groupedFields[$secKey] as $f)
                                        @php
                                            $isFullWidth = in_array($f['type'], ['textarea']) || in_array($f['key'], ['full_name', 'address', 'father_address', 'mother_address', 'achievements']);
                                        @endphp
                                        <div class="{{ $isFullWidth ? 'sm:col-span-2' : '' }}">
                                            @include('frontend.ppdb.partials.form_field', ['field' => $f])
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach

                {{-- SUBMIT BUTTON --}}
                <div class="pt-8 pb-4 text-center">
                    <button type="submit" class="w-full sm:w-auto min-w-[320px] bg-gradient-to-r from-[#da251c] to-[#b91c1c] hover:from-[#b91c1c] hover:to-[#991c1c] text-white font-black text-base sm:text-lg px-10 py-4 rounded-2xl shadow-xl shadow-red-500/30 hover:shadow-2xl transition-all transform hover:-translate-y-1 cursor-pointer uppercase tracking-wider inline-flex items-center justify-center gap-3">
                        <i class="fa-solid fa-paper-plane text-xl"></i>
                        <span>Kirim Formulir Pendaftaran</span>
                    </button>
                    @if($formSettings['wa_confirm'])
                        <p class="text-xs text-slate-600 font-semibold mt-3">
                            <i class="fa-brands fa-whatsapp text-emerald-600 mr-1 text-sm"></i>
                            Setelah formulir dikirim, seluruh data pendaftaran akan otomatis diteruskan ke WhatsApp Panitia PPDB.
                        </p>
                    @endif
                </div>
            </form>

            {{-- FOOTER --}}
            <div class="pt-8 text-center border-t border-slate-100">
                <div class="flex items-center justify-between text-[11px] text-slate-400">
                    <span>PSB Pondok Pesantren Raudhatul Ulum Sakatiga</span>
                    <span>Hak Cipta Dilindungi Undang-Undang</span>
                </div>
            </div>

        </div>

        @endif

    </div>
</div>
@endsection
