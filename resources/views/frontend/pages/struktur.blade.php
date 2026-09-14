@extends('layouts.frontend')

@section('title', 'Struktur Organisasi - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Struktur Organisasi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Struktur Organisasi Pesantren</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Susunan pimpinan Pondok Pesantren Raudhatul Ulum dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    
    {{-- SEKSI 1: STRUKTUR ORGANISASI YAYASAN & PESANTREN --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up space-y-10">
        <div class="text-center max-w-3xl mx-auto">
            <span class="text-xs font-bold text-[#00843d] uppercase tracking-wider bg-emerald-50 px-3.5 py-1 rounded-full border border-emerald-100">
                Bagan Kepengurusan Resmi
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 tracking-tight mt-2">
                Struktur Kepengurusan Yayasan &amp; Pimpinan PPRU
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium">
                Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga, Ogan Ilir, Sumatera Selatan
            </p>
            <div class="w-16 h-1 bg-[#00843d] mx-auto rounded-full mt-3"></div>
        </div>

        {{-- 1. DEWAN PEMBINA YAYASAN --}}
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-2 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm"><i class="fa-solid fa-crown"></i></span>
                    <span>Dewan Pembina Yayasan (YAPIRUS)</span>
                </h3>
                <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-full">Musyawarah Tertinggi</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-amber-50/70 to-white p-5 rounded-2xl border border-amber-200/70 flex items-start space-x-4 shadow-xs">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl font-black shrink-0 shadow-md">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block">Ketua Dewan Pembina:</span>
                        <h4 class="font-black text-base text-gray-900 mt-0.5">KH. Tol'at Wafa Ahmad, Lc.</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                    </div>
                </div>
                <div class="bg-slate-50 p-5 rounded-2xl border border-gray-200/80 flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-xl font-black shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Anggota Dewan Pembina:</span>
                        <h4 class="font-black text-base text-gray-900 mt-0.5">Dewan Masyayikh &amp; Tokoh Pesantren</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">Para sesepuh dan ulama pengarah visi khidmah dakwah Raudhatul Ulum</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. PENGURUS HARIAN YAYASAN (YAPIRUS) --}}
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-2 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-sm"><i class="fa-solid fa-building-columns"></i></span>
                    <span>Pengurus Harian Yayasan (YAPIRUS)</span>
                </h3>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">Badan Penyelenggara</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-emerald-200/80 shadow-xs hover:border-[#00843d] transition">
                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Pimpinan / Ketua Umum:</span>
                    <h4 class="font-black text-base text-gray-900 mt-1">Dr. H. Husnul Amin, Lc., M.H.I., M.M.</h4>
                    <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Ketua Yayasan Perguruan Islam Raudhatul Ulum Sakatiga</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:border-[#00843d] transition">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Sekretaris Umum:</span>
                    <h4 class="font-black text-base text-gray-900 mt-1">Ust. H. M. Said, S.Ag., M.Pd.I.</h4>
                    <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Administrasi &amp; Legalitas Yayasan</p>
                </div>
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:border-[#00843d] transition">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Bendahara Umum:</span>
                    <h4 class="font-black text-base text-gray-900 mt-1">Ust. H. M. Syukri, S.Pd.I.</h4>
                    <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Tata Kelola Keuangan &amp; Akuntabilitas Wakaf</p>
                </div>
            </div>
        </div>

        {{-- 3. PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD) --}}
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-2 flex items-center justify-between">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-sm"><i class="fa-solid fa-graduation-cap"></i></span>
                    <span>Pimpinan Pondok Pesantren Raudhatul Ulum</span>
                </h3>
                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full">Pimpinan Ma'had</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-emerald-50/90 to-white p-6 rounded-2xl border border-emerald-300 shadow-sm flex items-start space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-[#00843d] text-white flex items-center justify-center text-2xl font-black shrink-0 shadow-md">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block">Mudir Pondok Pesantren:</span>
                        <h4 class="font-black text-lg text-gray-900 mt-0.5">KH. Tol'at Wafa Ahmad, Lc.</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">Pimpinan Tertinggi Penyelenggaraan Pendidikan &amp; Pengasuhan Santri</p>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-start space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-2xl font-black shrink-0">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Naib Mudir (Wakil Pimpinan):</span>
                        <h4 class="font-black text-lg text-gray-900 mt-0.5">Ust. K.H. Abdul Karim Subki, S.Pd.I.</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">Wakil Pengasuh &amp; Koordinasi Harian Kepesantrenan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. JAJARAN ASISTEN MUDIR (ASDIR I - VII) --}}
        <div class="space-y-4">
            <div class="border-b border-gray-100 pb-2">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-slate-100 text-gray-700 flex items-center justify-center text-sm"><i class="fa-solid fa-sitemap"></i></span>
                    <span>Asisten Mudir (ASDIR) Bidang Operasional</span>
                </h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 text-xs">
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR I &bull; Akademik &amp; Kurikulum</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. H. M. Said, S.Ag., M.Pd.I.</h5>
                    <p class="text-[11px] text-gray-500">Penyelarasan muadalah &amp; kurikulum nasional</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR II &bull; Pengasuhan &amp; Santri</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. Muhammad Ihsan, S.Ud., M.Ag.</h5>
                    <p class="text-[11px] text-gray-500">Kedisiplinan asrama putra &amp; putri</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR III &bull; Keuangan &amp; Administrasi</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. H. Ahmad Fauzi, S.E.</h5>
                    <p class="text-[11px] text-gray-500">Pengelolaan anggaran &amp; keuangan ma'had</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR IV &bull; Humas &amp; Sekretariat</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. Rahmat Hidayat, S.Sos.I.</h5>
                    <p class="text-[11px] text-gray-500">Pelayanan publik, media &amp; kemitraan</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR V &bull; Usaha Pesantren (BUMP)</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. Ir. H. Syamsuddin</h5>
                    <p class="text-[11px] text-gray-500">Koperasi, minimarket &amp; unit bisnis</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR VI &bull; Sarpras &amp; Pekerjaan Umum</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. Maryadi, S.T.</h5>
                    <p class="text-[11px] text-gray-500">Pembangunan gedung &amp; perawatan sarana</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-gray-100 space-y-1 col-span-1 sm:col-span-2">
                    <span class="text-[10px] font-bold text-[#00843d] uppercase tracking-wider">ASDIR VII &bull; SDM &amp; Pengembangan Asatidz</span>
                    <h5 class="font-bold text-sm text-gray-900">Ust. Dr. H. Faisal, M.Pd.</h5>
                    <p class="text-[11px] text-gray-500">Peningkatan mutu pedagogik dan kaderisasi guru pesantren</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 2: FASILITAS & SARANA PRASARANA SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Sarana &amp; Prasarana Kampus</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">Fasilitas Unggulan Pondok Pesantren Raudhatul Ulum</h2>
            </div>
            <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Selengkapnya</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bidangs as $b)
                <a href="{{ route('bidang.show', $b->slug) }}" class="rounded-2xl border border-gray-100 hover:border-[#00913e] hover:shadow-xl transition group bg-white overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-44 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $b->thumbnail_url }}" alt="{{ $b->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                            <span class="absolute top-3 left-3 bg-[#00913e] text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow">
                                Sarana Pesantren
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-sm sm:text-base text-gray-900 group-hover:text-[#00913e] transition">{{ $b->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($b->description), 80) }}</p>
                        </div>
                    </div>
                    <div class="px-5 pb-4 pt-2 border-t border-gray-50 flex items-center justify-between text-xs text-[#00913e] font-bold">
                        <span>Rincian Fasilitas</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data fasilitas.
                </div>
            @endforelse
        </div>
    </section>

    {{-- SEKSI 3: PROGRAM UNGGULAN SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Kurikulum &amp; Karakter</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                    Program Unggulan Santri Raudhatul Ulum
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 font-light">Mengasah kecakapan santri menjadi pribadi cerdas, mandiri, dan berjiwa pelopor.</p>
            </div>
            <a href="{{ route('dpc.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800 flex-shrink-0 transition">
                <span>Lihat Semua Program</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($dpcs->take(8) as $dpc)
                <div class="rounded-2xl border border-gray-100 bg-white hover:border-[#00913e] hover:shadow-lg transition overflow-hidden group flex flex-col justify-between">
                    <div>
                        <div class="h-32 w-full overflow-hidden bg-slate-100 relative">
                            <img src="{{ $dpc->thumbnail_url }}" alt="{{ $dpc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/logo-ppru-banner.png'">
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-[10px] font-bold text-[#00913e] block truncate uppercase tracking-wider">{{ $dpc->address ?: 'Program Unggulan' }}</span>
                            <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-[#00913e] transition line-clamp-1">{{ $dpc->name }}</h3>
                            <p class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed font-light">{{ Str::limit(strip_tags($dpc->description), 65) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data program.
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection
