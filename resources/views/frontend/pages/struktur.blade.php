@extends('layouts.frontend')

@section('title', 'Struktur Organisasi - SMA IT Plus Robbani')
@section('meta_description', 'Bagan struktur organisasi, pimpinan pengelola, dewan guru, dan unit kerja SMA IT Plus Robbani Indralaya Ogan Ilir.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Struktur Organisasi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Struktur Organisasi Sekolah</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Susunan pimpinan pengelola, wakil kepala sekolah, unit koordinasi tahfidz, dan tata usaha SMA IT Plus Robbani.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">
    
    {{-- SEKSI 1: PIMPINAN & PENGELOLA SEKOLAH GRID --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Pimpinan Sekolah</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Dewan Pimpinan & Pengelola Sekolah
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Sinergi kepemimpinan amanah, profesional, dan berdedikasi tinggi membimbing generasi masa depan.</p>
            <div class="w-16 h-1 bg-[#0d6b38] mx-auto rounded-full mt-3"></div>
        </div>

        @php
            $schoolLeaders = [
                [
                    'name' => 'Drs. H. Ahmad Husen, M.Pd.I',
                    'role' => 'Kepala Sekolah',
                    'title' => 'Penanggung Jawab Utama',
                    'desc' => 'Memimpin seluruh tata kelola pendidikan terpadu, penjaminan mutu kurikulum, dan sinergi kemitraan yayasan serta masyarakat.',
                    'photo' => '/uploads/kepala-sekolah-robbani.jpg',
                    'badge_bg' => 'bg-emerald-100 text-[#0d6b38]'
                ],
                [
                    'name' => 'Ustadz H. Salman Al-Farisi, Lc., M.Ag',
                    'role' => 'Waka Bidang Keislaman & Tahfidz',
                    'desc' => 'Program Diniyah',
                    'photo' => '/uploads/tahfidz-robbani.jpg',
                    'badge_bg' => 'bg-amber-100 text-amber-800'
                ],
                [
                    'name' => 'Dra. Hj. Nurul Hidayah, M.Pd',
                    'role' => 'Waka Bidang Kurikulum & Akademik',
                    'desc' => 'Kurikulum Merdeka',
                    'photo' => '/uploads/lab-robbani.jpg',
                    'badge_bg' => 'bg-orange-100 text-orange-700'
                ],
                [
                    'name' => 'Muhammad Ridwan, S.Pd., Gr',
                    'role' => 'Waka Bidang Kesiswaan & Kedisiplinan',
                    'desc' => 'Bina Karakter Siswa',
                    'photo' => '/uploads/campus-robbani.jpg',
                    'badge_bg' => 'bg-blue-100 text-blue-800'
                ],
                [
                    'name' => 'Ir. Hendra Kusuma, S.T',
                    'role' => 'Waka Bidang Sarana, Prasarana & Lab',
                    'desc' => 'Fasilitas & IT',
                    'photo' => '/uploads/lab-robbani.jpg',
                    'badge_bg' => 'bg-purple-100 text-purple-800'
                ],
                [
                    'name' => 'Siti Khadijah, S.E',
                    'role' => 'Kepala Tata Usaha & Keuangan',
                    'desc' => 'Administrasi & Layanan',
                    'photo' => '/uploads/campus-robbani.jpg',
                    'badge_bg' => 'bg-rose-100 text-rose-800'
                ],
                [
                    'name' => 'Ustadz Abdullah Faqih, S.Sos.I',
                    'role' => 'Direktur Asrama / Mudir Boarding',
                    'desc' => 'Islamic Boarding',
                    'photo' => '/uploads/tahfidz-robbani.jpg',
                    'badge_bg' => 'bg-teal-100 text-teal-800'
                ],
                [
                    'name' => 'Fathur Rahman, S.Kom',
                    'role' => 'Koordinator IT & Laboratorium Multimedia',
                    'desc' => 'Riset & Sistem Informasi',
                    'photo' => '/uploads/lab-robbani.jpg',
                    'badge_bg' => 'bg-cyan-100 text-cyan-800'
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($schoolLeaders as $leader)
                <div class="bg-gray-50/80 rounded-2xl p-6 border border-gray-200/80 hover:border-emerald-300 hover:shadow-lg transition transform hover:-translate-y-1 text-center flex flex-col justify-between space-y-4 group">
                    <div class="space-y-3">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-full overflow-hidden border-4 border-white shadow-md bg-white">
                            <img src="{{ $leader['photo'] }}" alt="{{ $leader['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition" onerror="this.src='/uploads/kepala-sekolah-robbani.jpg'">
                        </div>
                        <div>
                            <span class="inline-block {{ $leader['badge_bg'] }} text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider mb-1.5">
                                {{ $leader['desc'] }}
                            </span>
                            <h3 class="font-extrabold text-sm sm:text-base text-gray-900 group-hover:text-[#0d6b38] transition leading-snug">
                                {{ $leader['name'] }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium mt-1">{{ $leader['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SEKSI 2: FASILITAS & UNIT LAYANAN SEKOLAH --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Sarana & Prasarana Modern</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">Fasilitas Unggulan SMA IT Plus Robbani</h2>
            </div>
            <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#0d6b38] hover:text-orange-500 flex-shrink-0">
                <span>Lihat Selengkapnya</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($bidangs as $b)
                <a href="{{ route('bidang.show', $b->slug) }}" class="p-5 rounded-2xl border border-gray-100 hover:border-[#0d6b38] hover:shadow-md transition group bg-gray-50/80 flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#0d6b38] group-hover:bg-[#0d6b38] group-hover:text-white flex items-center justify-center text-lg flex-shrink-0 transition shadow-inner">
                        <i class="fa-solid fa-school"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 group-hover:text-[#0d6b38] transition">{{ $b->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ Str::limit(strip_tags($b->description), 80) }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-8 text-gray-400">
                    Belum ada data fasilitas.
                </div>
            @endforelse
        </div>
    </section>

    {{-- SEKSI 3: PROGRAM UNGGULAN & EKSTRAKURIKULER --}}
    <section class="bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-gray-100 reveal-fade-up">
        <div class="mb-8">
            <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Program Khusus</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Program Unggulan Siswa Robbani
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Mengasah bakat sains, kepemimpinan Islam, bahasa internasional, dan teknologi masa depan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse($dpcs as $dpc)
                <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/80 flex items-center space-x-3 hover:border-emerald-300 transition">
                    <div class="w-9 h-9 rounded-lg bg-[#0d6b38] text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="font-bold text-xs sm:text-sm text-gray-900 truncate">{{ $dpc->name }}</h3>
                        <span class="text-[11px] text-gray-500 block truncate">{{ $dpc->address ?: 'Program Unggulan Robbani' }}</span>
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
