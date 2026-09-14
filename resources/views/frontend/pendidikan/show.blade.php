@extends('layouts.frontend')

@section('title', $unit->name . ' - Pondok Pesantren Raudhatul Ulum Sakatiga')
@section('meta_description', Str::limit(strip_tags($unit->description), 160))

@section('content')
{{-- HERO BANNER --}}
<div class="relative bg-gradient-to-br from-[#006830] via-[#00843d] to-[#053d1c] text-white py-14 sm:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -left-16 -top-16 w-80 h-80 bg-[#f59e0b]/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto space-y-4 relative z-10">
        <div class="flex flex-wrap items-center gap-2">
            <span class="bg-[#00843d] border border-white/25 text-white text-xs font-black px-3.5 py-1 rounded-full shadow-xs uppercase tracking-wider">
                <i class="fa-solid fa-school mr-1.5 text-amber-300"></i> {{ $unit->category_type }}
            </span>
            @if($unit->badge)
                <span class="bg-[#f59e0b] text-slate-950 text-xs font-black px-3.5 py-1 rounded-full shadow-xs flex items-center">
                    <i class="fa-solid fa-award mr-1.5"></i> {{ $unit->badge }}
                </span>
            @endif
            @if($unit->short_name)
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-xs">
                    {{ $unit->short_name }}
                </span>
            @endif
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight">
            {{ $unit->name }}
        </h1>

        @if($unit->curriculum)
            <p class="text-xs sm:text-sm text-emerald-100 font-medium flex items-center max-w-3xl">
                <i class="fa-solid fa-book-quran mr-2 text-[#f59e0b] text-base shrink-0"></i>
                <span>{{ $unit->curriculum }}</span>
            </p>
        @endif
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100 py-3 shadow-xs sticky top-18 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2 text-xs text-gray-500 font-medium overflow-x-auto">
        <a href="{{ route('home') }}" class="hover:text-[#00843d] flex items-center shrink-0"><i class="fa-solid fa-house mr-1.5 text-[#00843d]"></i> Beranda</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('pendidikan.index') }}" class="hover:text-[#00843d] shrink-0">Unit Pendidikan</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-bold truncate">{{ $unit->name }}</span>
    </div>
</div>

{{-- CONTENT DETAIL --}}
<div class="py-12 sm:py-16 bg-slate-50/70 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- MAIN COLUMN (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- CARD PROFIL & GAMBARAN UNIT --}}
                <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-school-green flex items-center justify-center text-xl shadow-xs">
                                <i class="{{ $unit->icon ?: 'fa-solid fa-graduation-cap' }}"></i>
                            </div>
                            <div>
                                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                                    Profil &amp; Kurikulum {{ $unit->short_name ?: $unit->name }}
                                </h2>
                                <p class="text-xs text-gray-500 font-medium">Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Utama --}}
                    <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-4">
                        {!! nl2br(e($unit->description)) !!}
                    </div>

                    {{-- Highlight Keunggulan Unit --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        <div class="bg-emerald-50/60 p-4 rounded-2xl border border-emerald-100/80 text-center sm:text-left">
                            <i class="fa-solid fa-certificate text-emerald-600 text-xl mb-2"></i>
                            <h4 class="font-extrabold text-xs text-emerald-950">Akreditasi &amp; Ijazah</h4>
                            <p class="text-[11px] text-emerald-800/80 mt-0.5">Ijazah resmi pemerintah serta muadalah Al-Azhar Kairo &amp; Timur Tengah.</p>
                        </div>
                        <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-100/80 text-center sm:text-left">
                            <i class="fa-solid fa-language text-amber-600 text-xl mb-2"></i>
                            <h4 class="font-extrabold text-xs text-amber-950">Dwi-Bahasa Aktif</h4>
                            <p class="text-[11px] text-amber-800/80 mt-0.5">Bahasa Arab fusha dan Inggris aktif dalam percakapan dan pembelajaran harian.</p>
                        </div>
                        <div class="bg-sky-50/60 p-4 rounded-2xl border border-sky-100/80 text-center sm:text-left">
                            <i class="fa-solid fa-book-quran text-sky-600 text-xl mb-2"></i>
                            <h4 class="font-extrabold text-xs text-sky-950">Tahfidz &amp; Karakter</h4>
                            <p class="text-[11px] text-sky-800/80 mt-0.5">Target hafalan Al-Qur'an mutqin serta pembentukan 10 Jati Diri Santri.</p>
                        </div>
                    </div>
                </div>

                {{-- JADWAL RUTINITAS 24 JAM SANTRI (Daily Boarding Routine) --}}
                <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                    <div class="border-b border-gray-100 pb-4">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-school-green bg-emerald-50 px-3 py-1 rounded-full">
                            Sistem Asrama Penuh (Boarding)
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mt-2 tracking-tight">
                            Jadwal Rutinitas 24 Jam Santri
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">Pembinaan terpadu jasmani, ruhani, dan fikriyah santri sepanjang hari di lingkungan asrama pesantren</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">04.00 - 05.30</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Qiyamul Lail &amp; Shubuh Berjamaah</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Shalat tahajjud, shalat shubuh berjamaah, dzikir ma'tsurat, dan pemberian mufrodat / vocabulary harian.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">05.30 - 06.45</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Mandi, Sarapan &amp; Piket Asrama</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Penanaman kemandirian dan kebersihan kamar asrama serta persiapan KBM formal.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-school-green text-white rounded-lg font-mono font-bold text-[11px] shrink-0">07.00 - 12.15</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">KBM Pagi (Dirasah &amp; Sains)</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Pembelajaran kurikulum terpadu: ilmu-ilmu syar'i, kitab turats, sains teknologi, matematika, dan bahasa.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">12.15 - 13.30</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Shalat Dzuhur &amp; Makan Siang</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Shalat dzuhur berjamaah di masjid utama dilanjutkan makan siang bersama di ruang makan santri.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">13.30 - 15.00</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">KBM Siang / Praktikum Laboratorium</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Praktikum sains IPA, laboratorium komputer digital, dan bimbingan belajar tambahan.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">15.00 - 17.30</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Ashar, Muhadatsah, Olahraga &amp; Ekskul</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Latihan percakapan dwi-bahasa (Arab &amp; Inggris), kepanduan pramuka, silat tapak suci, futsal, dan seni kaligrafi.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-school-green text-white rounded-lg font-mono font-bold text-[11px] shrink-0">18.00 - 20.30</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Maghrib, Halaqah Tahfidz &amp; Isya</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Setoran hafalan Al-Qur'an (ziyadah) dan muraja'ah bersama musyrif tahfidz di masjid.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-3 rounded-2xl bg-slate-50 border border-gray-100">
                                <span class="px-2 py-1 bg-emerald-600 text-white rounded-lg font-mono font-bold text-[11px] shrink-0">20.30 - 22.00</span>
                                <div>
                                    <h5 class="font-bold text-gray-900">Belajar Terbimbing (Muwajjah) &amp; Istirahat</h5>
                                    <p class="text-gray-500 text-[11px] mt-0.5">Muhadharah pidato 3 bahasa, pengulangan pelajaran esok hari, dan istirahat malam tepat pukul 22.00 WIB.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DEWAN ASATIDZ & GURU PENGAJAR UNIT --}}
                <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-school-green bg-emerald-50 px-3 py-1 rounded-full">
                                Tenaga Pendidik
                            </span>
                            <h3 class="text-xl sm:text-2xl font-black text-gray-900 mt-2 tracking-tight">
                                Dewan Asatidz &amp; Guru Pengajar {{ $unit->short_name }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Asatidz berdedikasi tinggi, alumni perguruan tinggi terkemuka dalam dan luar negeri</p>
                        </div>
                    </div>

                    @if($teachers->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                            @foreach($teachers as $t)
                                <div class="bg-slate-50/80 rounded-2xl p-4 border border-gray-100 text-center hover:border-emerald-300 hover:bg-white hover:shadow-md transition duration-300 group">
                                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden mb-3 bg-white shadow-xs border-2 border-emerald-100">
                                        <img src="{{ $t->photo_url }}" alt="{{ $t->name }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition" onerror="this.src='/uploads/default-avatar.webp'">
                                    </div>
                                    <h4 class="font-bold text-xs sm:text-sm text-gray-900 line-clamp-2">{{ $t->name }}</h4>
                                    <p class="text-[11px] text-school-green font-semibold mt-0.5 line-clamp-1">{{ $t->position }}</p>
                                    @if($t->education)
                                        <p class="text-[10px] text-gray-400 mt-1 line-clamp-1"><i class="fa-solid fa-graduation-cap mr-1"></i> {{ $t->education }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-slate-50 rounded-2xl text-xs text-gray-500">
                            <i class="fa-solid fa-chalkboard-user text-3xl text-emerald-400 mb-2"></i>
                            <p>Data tenaga pendidik unit {{ $unit->name }} sedang dalam proses sinkronisasi.</p>
                        </div>
                    @endif
                </div>

                {{-- SARANA & FASILITAS KHUSUS UNIT --}}
                <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-sm border border-gray-100 space-y-6 reveal-fade-up">
                    <div class="border-b border-gray-100 pb-4">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-school-green bg-emerald-50 px-3 py-1 rounded-full">
                            Kenyamanan Belajar
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mt-2 tracking-tight">
                            Fasilitas Penunjang Unit
                        </h3>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-chalkboard text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Ruang Kelas Multimedia</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-bed text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Asrama Santri Asri</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-flask text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Lab Sains Terpadu</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-desktop text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Lab Komputer &amp; IT</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-mosque text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Masjid Jami' Kampus</span>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-gray-100 flex items-center space-x-3">
                            <i class="fa-solid fa-futbol text-emerald-600 text-lg"></i>
                            <span class="font-bold text-gray-800">Lapangan Olahraga</span>
                        </div>
                    </div>
                </div>

                {{-- ALUR PENDAFTARAN PSB / PPDB ONLINE --}}
                <div class="bg-gradient-to-br from-school-green to-[#005a28] text-white rounded-3xl p-6 sm:p-9 shadow-xl space-y-6 reveal-fade-up">
                    <div class="border-b border-white/20 pb-4">
                        <span class="text-[11px] font-black uppercase tracking-wider text-amber-300 bg-black/20 px-3 py-1 rounded-full">
                            Penerimaan Santri Baru (PSB)
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black text-white mt-2 tracking-tight">
                            Alur Pendaftaran Masuk Santri Baru
                        </h3>
                        <p class="text-xs text-green-100 mt-1">Langkah mudah menjadi bagian dari keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                        <div class="bg-white/10 backdrop-blur-xs p-4 rounded-2xl border border-white/15">
                            <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-2">1</span>
                            <h5 class="font-bold text-white text-sm">Daftar Online</h5>
                            <p class="text-green-100 text-[11px] mt-1">Mengisi formulir PSB melalui portal website resmi.</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-xs p-4 rounded-2xl border border-white/15">
                            <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-2">2</span>
                            <h5 class="font-bold text-white text-sm">Verifikasi Berkas</h5>
                            <p class="text-green-100 text-[11px] mt-1">Upload dokumen KK, Akte Kelahiran, dan pas foto santri.</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-xs p-4 rounded-2xl border border-white/15">
                            <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-2">3</span>
                            <h5 class="font-bold text-white text-sm">Tes &amp; Wawancara</h5>
                            <p class="text-green-100 text-[11px] mt-1">Ujian baca Al-Qur'an, potensi akademik, dan wawancara wali.</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-xs p-4 rounded-2xl border border-white/15">
                            <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-xs mb-2">4</span>
                            <h5 class="font-bold text-white text-sm">Daftar Ulang</h5>
                            <p class="text-green-100 text-[11px] mt-1">Pengumuman kelulusan dan penempatan kamar asrama santri.</p>
                        </div>
                    </div>

                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-amber-500 text-slate-950 text-xs font-black px-6 py-3 rounded-full shadow-lg transition flex items-center space-x-2">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Daftar PSB Online Sekarang</span>
                        </a>
                        @if($unit->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone) }}?text=Assalamu%27alaikum%20Panitia%20PSB%20{{ urlencode($unit->name) }}%2C%20saya%20ingin%20konsultasi%20pendaftaran" target="_blank" class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-5 py-3 rounded-full transition flex items-center space-x-2">
                                <i class="fa-brands fa-whatsapp text-green-300 text-sm"></i>
                                <span>Konsultasi WhatsApp</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            {{-- SIDEBAR COLUMN (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Quick Info Card --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4 reveal-fade-up">
                    <h3 class="text-sm font-black text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-school-green"></span>
                        <span>Informasi Singkat Unit</span>
                    </h3>
                    
                    <ul class="space-y-3 text-xs">
                        <li class="flex justify-between py-1.5 border-b border-gray-50">
                            <span class="text-gray-500">Nama Lembaga:</span>
                            <span class="font-bold text-gray-900 text-right">{{ $unit->short_name ?: $unit->name }}</span>
                        </li>
                        <li class="flex justify-between py-1.5 border-b border-gray-50">
                            <span class="text-gray-500">Tipe Pendidikan:</span>
                            <span class="font-bold text-emerald-700">{{ $unit->category_type }}</span>
                        </li>
                        @if($unit->badge)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Akreditasi:</span>
                                <span class="font-bold text-amber-600">{{ $unit->badge }}</span>
                            </li>
                        @endif
                        @if($unit->head_name)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Pimpinan / Kepala:</span>
                                <span class="font-bold text-gray-900 text-right">{{ $unit->head_name }}</span>
                            </li>
                        @endif
                        @if($unit->phone)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Kontak Telepon/WA:</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $unit->phone) }}" target="_blank" class="font-bold text-emerald-700 hover:underline">{{ $unit->phone }}</a>
                            </li>
                        @endif
                        @if($unit->email)
                            <li class="flex justify-between py-1.5 border-b border-gray-50">
                                <span class="text-gray-500">Email Resmi:</span>
                                <a href="mailto:{{ $unit->email }}" class="font-bold text-gray-900 hover:text-school-green">{{ $unit->email }}</a>
                            </li>
                        @endif
                        <li class="flex justify-between py-1.5">
                            <span class="text-gray-500">Naungan:</span>
                            <span class="font-bold text-gray-900 text-right">YAPIRUS Sakatiga</span>
                        </li>
                    </ul>

                    <div class="pt-2">
                        <a href="{{ route('ppdb.index') }}" class="w-full bg-school-green hover:bg-emerald-800 text-white font-black text-xs py-3 rounded-2xl flex items-center justify-center space-x-2 shadow-md transition">
                            <i class="fa-solid fa-file-pen"></i>
                            <span>Formulir PSB Online</span>
                        </a>
                    </div>
                </div>

                {{-- Other Units List --}}
                @if($otherUnits->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4 reveal-fade-up">
                        <h3 class="text-sm font-black text-gray-900 border-b border-gray-100 pb-3 flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-school-green"></i>
                            <span>Unit Pendidikan Lainnya</span>
                        </h3>
                        <div class="space-y-2.5">
                            @foreach($otherUnits as $ou)
                                <a href="{{ route('pendidikan.show', $ou->slug) }}" class="flex items-center space-x-3 p-3 rounded-2xl hover:bg-emerald-50/60 transition group border border-transparent hover:border-emerald-200">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-school-green flex items-center justify-center text-xs shrink-0 group-hover:bg-school-green group-hover:text-white transition">
                                        <i class="{{ $ou->icon ?: 'fa-solid fa-school' }}"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-800 truncate group-hover:text-school-green transition">{{ $ou->name }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $ou->category_type }} &bull; {{ $ou->badge ?: 'PPRU' }}</p>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-school-green group-hover:translate-x-0.5 transition"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Download Brosur Card --}}
                <div class="bg-emerald-50 rounded-3xl p-6 border border-emerald-100 text-center space-y-3 reveal-fade-up">
                    <div class="w-12 h-12 rounded-2xl bg-school-green text-white flex items-center justify-center text-xl mx-auto shadow-md">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-gray-900">Brosur &amp; Rincian Biaya</h4>
                    <p class="text-[11px] text-gray-600">Unduh dokumen resmi panduan santri baru, kurikulum lengkap, dan rincian biaya pondok.</p>
                    <a href="{{ route('download.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-school-green hover:underline">
                        <span>Pusat Unduhan Brosur</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
