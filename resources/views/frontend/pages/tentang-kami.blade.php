@extends('layouts.frontend')

@section('title', ($page?->meta_title ?: ($page?->title ?: 'Tentang Kami')) . ' - ' . ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga'))
@section('meta_description', $page?->meta_description ?: 'Mengenal profil, sejarah, visi misi, fasilitas, pimpinan, serta keunggulan Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir, Sumatera Selatan.')

@section('content')
{{-- HERO HEADER & BREADCRUMB --}}
<div class="bg-gradient-to-r from-gray-900 to-[#00913e] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-gray-300 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-[#f59e0b] font-semibold">{{ $page?->title ?: 'Tentang Kami' }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $page?->title ?: 'Profil Pondok Pesantren Raudhatul Ulum' }}</h1>
        <p class="text-sm text-gray-200 mt-2 font-light max-w-2xl">
            {{ $page?->excerpt ?: 'Mengenal lebih dekat visi, sejarah, pimpinan, sistem muadalah Al-Azhar, dan nilai pendidikan kepesantrenan di Sakatiga, Ogan Ilir.' }}
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">

    {{-- KONTEN PROFIL RESMI DARI ADMIN --}}
    @if(!empty($page?->content) && strlen(trim(strip_tags($page->content))) > 0)
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="inline-flex items-center space-x-2 bg-emerald-100 text-[#00843d] px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4">
            <i class="fa-solid fa-circle-info"></i>
            <span>{{ $page->title }}</span>
        </div>
        <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed">
            {!! $page->content !!}
        </div>
    </section>
    @endif

    {{-- SEKSI 1: SAMBUTAN MUDIR PESANTREN --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
            <div class="lg:col-span-5 flex flex-col">
                <div class="w-full h-full min-h-[360px] sm:min-h-[420px] rounded-3xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-emerald-100 bg-emerald-50 relative group flex flex-col">
                    <img src="/uploads/official/foto-mudir.webp" alt="KH. Tol'at Wafa Ahmad, Lc. - Mudir Pesantren" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/official/logo-ru-berwarna.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="block text-base sm:text-lg font-extrabold drop-shadow">KH. Tol'at Wafa Ahmad, Lc.</span>
                        <span class="text-xs text-emerald-300 font-semibold drop-shadow">Mudir Pondok Pesantren Raudhatul Ulum</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-7 flex flex-col justify-between space-y-4 text-left">
                <div>
                    <div class="inline-flex items-center space-x-2 bg-emerald-100 text-[#00843d] px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Sambutan Pimpinan Pesantren</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-3">
                        Mendidik Generasi Khairu Ummah, Berdaya Saing Global
                    </h2>
                    <div class="w-16 h-1 bg-[#00913e] rounded-full my-3"></div>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                        Assalamu'alaikum Warahmatullahi Wabarakatuh. Pondok Pesantren Raudhatul Ulum Sakatiga sejak berdirinya pada 1 Agustus 1950, senantiasa teguh mengemban amanah kaderisasi generasi terbaik umat. Memadukan kurikulum kepesantrenan terpadu (Pondok Modern Gontor), Kementerian Agama, kurikulum nasional, serta ijazah kesetaraan Muadalah dari Universitas Al-Azhar Kairo Mesir.
                    </p>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed mt-3">
                        Dalam lingkungan asrama 24 jam yang asri di atas lahan lebih dari 60 hektar, para santri dibina dengan penguasaan bahasa Arab dan Inggris aktif, tahfidzul qur'an mutqin, pengkajian kitab turats, sains teknologi, dan penempaan 10 Jati Diri Santri Raudhatul Ulum.
                    </p>
                </div>
                <div class="pt-4 flex flex-wrap gap-3">
                    <a href="{{ route('page.sambutan') }}" class="inline-flex items-center bg-[#00913e] hover:bg-emerald-800 text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                        <span>Baca Sambutan Lengkap</span>
                        <i class="fa-solid fa-arrow-right ml-2 text-[11px]"></i>
                    </a>
                    <a href="{{ route('page.visi-misi') }}" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl text-xs font-bold transition">
                        <span>Visi &amp; Misi</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 2: SEJARAH SINGKAT PESANTREN --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
            <div class="lg:col-span-7 flex flex-col justify-between space-y-4 order-2 lg:order-1">
                <div>
                    <div class="inline-flex items-center space-x-2 bg-amber-100 text-amber-900 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-landmark"></i>
                        <span>Jejak Langkah</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-3">
                        Sejarah Pondok Pesantren Raudhatul Ulum Sakatiga
                    </h2>
                    <span class="block text-xs sm:text-sm font-semibold text-[#00913e] mt-1">Dari "Mekkah Kecil" Menuju Pesantren Muadalah Modern</span>
                    <div class="w-16 h-1 bg-[#00913e] rounded-full my-3"></div>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                        Pondok Pesantren Raudhatul Ulum berakar dari madrasah bersejarah di Desa Sakatiga sejak 1930 (Madrasah Al-Falah) dan 1936 (Madrasah Al-Shibyan). Desa Sakatiga telah lama dijuluki sebagai "Mekkah Kecil" di Sumatera Selatan berkat banyaknya alim ulama yang bermukim dan menimba ilmu di tanah suci Makkah.
                    </p>
                    <p class="text-gray-600 text-sm sm:text-base leading-relaxed mt-3">
                        Pada 1 Agustus 1950, madrasah resmi bertransformasi di bawah naungan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS). Sejak 1986 di bawah kepemimpinan Mudir KH. Tol'at Wafa Ahmad, Lc., diterapkan kurikulum boarding modern terpadu dan muadalah resmi Universitas Al-Azhar Kairo Mesir.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('page.sejarah') }}" class="inline-flex items-center bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                        <span>Baca Sejarah Lengkap</span>
                        <i class="fa-solid fa-arrow-right ml-2 text-[11px]"></i>
                    </a>
                </div>
            </div>
            <div class="lg:col-span-5 order-1 lg:order-2 flex flex-col">
                <div class="w-full h-full min-h-[360px] sm:min-h-[420px] rounded-3xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-emerald-100 bg-gray-50 relative group flex flex-col">
                    <img src="/uploads/official/drone-raudhatul-ulum.webp" alt="Pondok Pesantren Raudhatul Ulum Sakatiga" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <span class="block text-sm sm:text-base font-extrabold drop-shadow">Kampus Terpadu PPRU Sakatiga</span>
                        <span class="text-[11px] text-emerald-300 font-medium drop-shadow">Pemandangan Kawasan Pesantren Seluas 60+ Hektar</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 3: 3 QUICK CARDS (FASILITAS, AGENDA, DEWAN GURU) --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Card 1: Fasilitas --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-[#00913e] flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span class="text-xs font-bold text-[#00913e] uppercase tracking-wider block">Sarana Pesantren</span>
                <h3 class="text-xl font-extrabold text-gray-900">Fasilitas &amp; Pondok</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Masjid Jami', asrama putra/putri terpisah, laboratorium sains, lab multimedia digital, perpustakaan kutubut turats, dan sarana olahraga luas.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:text-emerald-800">
                    <span>Lihat Semua Fasilitas</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 2: Agenda --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up delay-1">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider block">Kalender Pendidikan</span>
                <h3 class="text-xl font-extrabold text-gray-900">Agenda Pesantren</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Jadwal ujian tahfidz, penerimaan santri baru (PSB), perkemahan santri, festival dwi-bahasa, dan haflah milad kesyukuran.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('agenda.index') }}" class="inline-flex items-center text-xs font-bold text-amber-700 hover:text-amber-800">
                    <span>Lihat Semua Agenda</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 3: Dewan Asatidz --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up delay-2">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-school-green flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <span class="text-xs font-bold text-school-green uppercase tracking-wider block">Masyayikh &amp; Pendidik</span>
                <h3 class="text-xl font-extrabold text-gray-900">Dewan Asatidz &amp; Guru</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Para masyayikh, asatidz, dan dosen alumni Universitas Al-Azhar Kairo, Timur Tengah, dan perguruan tinggi terkemuka dalam negeri.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('dewan.index') }}" class="inline-flex items-center text-xs font-bold text-school-green hover:text-emerald-800">
                    <span>Lihat Profil Pendidik</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- SEKSI 4: VISI DAN MISI --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up space-y-8">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold text-[#00913e] uppercase tracking-wider block">Pedoman Pendidikan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Visi dan Misi Raudhatul Ulum
            </h2>
            <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Card Visi --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-3xl border border-green-100 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-[#00913e] text-white flex items-center justify-center font-bold text-base shadow">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Visi Pesantren</h3>
                    </div>
                    <blockquote class="text-sm sm:text-base text-gray-800 italic leading-relaxed border-l-4 border-[#00913e] pl-4 font-serif">
                        "Menjadi basis kaderisasi generasi terbaik (Khoiru Ummah) yang bermanfaat luas dan berdaya saing global."
                    </blockquote>
                </div>
                <div class="pt-2">
                    <a href="{{ route('page.visi-misi') }}" class="inline-flex items-center text-xs font-bold text-[#00913e] hover:underline">
                        <span>Baca Rincian Visi</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Card Misi --}}
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8 rounded-3xl border border-gray-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-900 text-white flex items-center justify-center font-bold text-base shadow">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Trilogi Misi</h3>
                    </div>
                    <ol class="text-xs sm:text-sm text-gray-700 space-y-2 list-decimal list-inside leading-relaxed">
                        <li><strong>Ta'lim:</strong> Pengajaran utuh ilmu syar'i, kitab turats, dan sains modern.</li>
                        <li><strong>Tarbiyah:</strong> Pembinaan karakter islami beradab dalam asrama 24 jam.</li>
                        <li><strong>Dakwah:</strong> Melatih keterampilan dakwah dan kepedulian sosial santri.</li>
                    </ol>
                </div>
                <div class="pt-2">
                    <a href="{{ route('page.visi-misi') }}" class="inline-flex items-center text-xs font-bold text-gray-900 hover:text-[#00913e] transition">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 5: LOKASI PONDOK SAKATIGA --}}
    <section class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#00913e] uppercase tracking-wider block">Lokasi Pondok</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">Pondok Pesantren Raudhatul Ulum Sakatiga</h2>
                <p class="text-xs text-gray-500 mt-1">Desa Sakatiga, Kecamatan Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan 30816</p>
            </div>
            <a href="https://maps.google.com/?q=Pondok+Pesantren+Raudhatul+Ulum+Sakatiga" target="_blank" class="inline-flex items-center bg-[#00913e] hover:bg-emerald-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow transition flex-shrink-0">
                <i class="fa-solid fa-map-location-dot mr-2"></i> Buka Google Maps
            </a>
        </div>

        <div class="rounded-2xl overflow-hidden shadow-inner border border-gray-200 h-80 sm:h-96">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15935.918903337965!2d104.642145!3d-3.232491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b9991cb45aaab%3A0x28dfaa3303668f80!2sSakatiga%2C%20Indralaya%2C%20Ogan%20Ilir%20Regency%2C%20South%20Sumatra!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

</div>
@endsection
