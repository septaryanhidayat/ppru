@extends('layouts.frontend')

@section('title', 'Tentang Kami - SMA IT Plus Robbani')
@section('meta_description', 'Mengenal profil, sejarah, visi misi, fasilitas, dewan guru, serta keunggulan SMA IT Plus Robbani Ogan Ilir.')

@section('content')
{{-- HERO HEADER & BREADCRUMB --}}
<div class="bg-gradient-to-r from-gray-900 to-[#0d6b38] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-gray-300 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-[#fb923c] font-semibold">Tentang Kami</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Profil SMA IT Plus Robbani</h1>
        <p class="text-sm text-gray-200 mt-2 font-light">
            Mengenal lebih dekat visi, nilai pendidikan Qur'ani, fasilitas, dan keunggulan civitas akademika Robbani.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">

    {{-- SEKSI 1: SAMBUTAN KEPALA SEKOLAH --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-4 flex justify-center">
                <div class="w-56 h-72 sm:w-64 sm:h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-green-100 bg-green-50 relative group">
                    <img src="/uploads/kepala-sekolah-robbani.jpg" alt="Drs. H. Ahmad Husen, M.Pd.I - Kepala Sekolah" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 text-white">
                        <span class="block text-sm font-extrabold">Drs. H. Ahmad Husen, M.Pd.I</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-8 space-y-4 text-left">
                <div class="inline-flex items-center space-x-2 bg-green-100 text-[#0d6b38] px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Sambutan Pimpinan</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Mendidik Generasi Qur'ani Berprestasi
                </h2>
                <div class="w-16 h-1 bg-[#0d6b38] rounded-full"></div>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Assalamu'alaikum Warahmatullahi Wabarakatuh. SMA IT Plus Robbani berdiri dengan tekad kuat menyajikan pendidikan menengah atas yang seimbang antara kematangan spiritual, kemuliaan akhlak, dan keunggulan sains-teknologi. Kami meyakini bahwa generasi terbaik adalah generasi yang menjadikan Al-Qur'an sebagai pedoman hidup sekaligus terampil menguasai ilmu pengetahuan modern.
                </p>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Dengan tenaga pendidik berkompeten, kurikulum terintegrasi, sarana laboratorium modern, serta lingkungan Islamic Boarding yang kondusif, kami berkomitmen mengantarkan setiap santri menggapai masa depan mulia dan berprestasi di perguruan tinggi terkemuka.
                </p>
                <div class="pt-4">
                    <a href="{{ route('page.sambutan') }}" class="inline-flex items-center bg-[#0d6b38] hover:bg-[#094725] text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                        <span>Baca Sambutan Lengkap</span>
                        <i class="fa-solid fa-arrow-right ml-2 text-[11px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 2: SEJARAH SINGKAT SEKOLAH --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-4 order-2 lg:order-1">
                <div class="inline-flex items-center space-x-2 bg-orange-100 text-orange-800 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-landmark"></i>
                    <span>Jejak Langkah</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Sejarah Berdirinya SMA IT Plus Robbani
                </h2>
                <span class="block text-xs sm:text-sm font-semibold text-[#f97316]">Komitmen Membangun Pendidikan Berkualitas</span>
                <div class="w-16 h-1 bg-[#f97316] rounded-full"></div>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    SMA IT Plus Robbani didirikan di Kabupaten Ogan Ilir atas inisiatif para tokoh pendidikan dan alim ulama yang mendambakan hadirnya institusi pendidikan menengah atas Islam terpadu yang bermutu tinggi, berwawasan global, namun tetap berakar kuat pada nilai-nilai tradisi keislaman.
                </p>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Seiring berjalannya waktu, sekolah ini terus berkembang dengan fasilitas modern, akreditasi unggul, serta jejaring prestasi siswa yang menjuarai berbagai kompetisi sains nasional dan hafidz Qur'an hingga 30 juz.
                </p>
                <div class="pt-4">
                    <a href="{{ route('page.sejarah') }}" class="inline-flex items-center bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition">
                        <span>Baca Sejarah Lengkap</span>
                        <i class="fa-solid fa-arrow-right ml-2 text-[11px]"></i>
                    </a>
                </div>
            </div>
            <div class="lg:col-span-5 order-1 lg:order-2 flex justify-center">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 max-h-80 bg-gray-50">
                    <img src="/uploads/campus-robbani.jpg" alt="Kampus SMA IT Plus Robbani" class="w-full h-full object-cover object-center">
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 3: 3 QUICK CARDS (FASILITAS, AGENDA, DEWAN GURU) --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Card 1: Fasilitas --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-green-100 text-[#0d6b38] flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span class="text-xs font-bold text-[#0d6b38] uppercase tracking-wider block">Sarana Kampus</span>
                <h3 class="text-xl font-extrabold text-gray-900">Fasilitas &amp; Laboratorium</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Laboratorium sains, lab komputer multimedia, perpustakaan digital, masjid kampus, sarana olahraga, dan asrama representatif.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('bidang.index') }}" class="inline-flex items-center text-xs font-bold text-[#0d6b38] hover:text-[#f97316]">
                    <span>Lihat Semua Fasilitas</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 2: Agenda --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up delay-1">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-orange-100 text-[#f97316] flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="text-xs font-bold text-[#f97316] uppercase tracking-wider block">Kalender Pendidikan</span>
                <h3 class="text-xl font-extrabold text-gray-900">Agenda Akademik</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Jadwal ujian, masa pendaftaran PPDB, wisuda tahfidz, kemah pramuka SIT, workshop sains, dan kegiatan kesiswaan.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('agenda.index') }}" class="inline-flex items-center text-xs font-bold text-[#f97316] hover:text-[#ea580c]">
                    <span>Lihat Semua Agenda</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 3: Dewan Guru --}}
        <div class="bg-white rounded-3xl p-8 shadow-md border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col justify-between space-y-6 reveal-fade-up delay-2">
            <div class="space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider block">Tenaga Pendidik</span>
                <h3 class="text-xl font-extrabold text-gray-900">Dewan Guru &amp; GTK</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Para asatidz dan guru lulusan perguruan tinggi terkemuka dalam dan luar negeri yang berjiwa pendidik dan berakhlak mulia.
                </p>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ route('dewan.index') }}" class="inline-flex items-center text-xs font-bold text-emerald-700 hover:text-emerald-800">
                    <span>Lihat Profil Pendidik</span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- SEKSI 4: VISI DAN MISI --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up space-y-8">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold text-[#0d6b38] uppercase tracking-wider block">Pedoman Pendidikan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Visi dan Misi SMA IT Plus Robbani
            </h2>
            <div class="w-16 h-1 bg-[#f97316] mx-auto rounded-full mt-3"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Card Visi --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-3xl border border-green-100 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0d6b38] text-white flex items-center justify-center font-bold text-base shadow">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-gray-900">Visi Sekolah</h3>
                    </div>
                    <blockquote class="text-sm sm:text-base text-gray-800 italic leading-relaxed border-l-4 border-[#0d6b38] pl-4 font-serif">
                        "Terwujudnya Generasi Qur'ani yang Berakhlak Mulia, Cerdas, Mandiri, Unggul dalam Sains dan Teknologi, serta Berwawasan Global."
                    </blockquote>
                </div>
                <div class="pt-2">
                    <a href="{{ route('page.visi-misi') }}" class="inline-flex items-center text-xs font-bold text-[#0d6b38] hover:underline">
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
                        <h3 class="text-xl font-extrabold text-gray-900">Misi Utama</h3>
                    </div>
                    <ol class="text-xs sm:text-sm text-gray-700 space-y-2 list-decimal list-inside leading-relaxed">
                        <li>Menyelenggarakan pembelajaran terpadu antara kurikulum nasional dan nilai-nilai Al-Qur'an.</li>
                        <li>Menumbuhkan kecintaan membaca, menghafal, dan mengamalkan Al-Qur'an dalam kehidupan sehari-hari.</li>
                        <li>Mengembangkan potensi akademik, riset sains, dan teknologi berbasis kecakapan abad ke-21.</li>
                        <li>Membina kepemimpinan, kemandirian santri, dan kepedulian sosial melalui sistem boarding school.</li>
                    </ol>
                </div>
                <div class="pt-2">
                    <a href="{{ route('page.visi-misi') }}" class="inline-flex items-center text-xs font-bold text-gray-900 hover:text-[#0d6b38] transition">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 5: TESTIMONIAL ALUMNI & WALI MURID --}}
    @if(isset($testimonials) && $testimonials->isNotEmpty())
    <section class="space-y-8 reveal-fade-up">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold text-[#0d6b38] uppercase tracking-wider block">Aspirasi &amp; Testimoni</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                Komentar Alumni &amp; Orang Tua
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 font-semibold mt-1">Pengalaman berharga belajar dan bertumbuh di SMA IT Plus Robbani</p>
            <div class="w-16 h-1 bg-[#f97316] mx-auto rounded-full mt-3"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($testimonials->take(4) as $testi)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between space-y-4 hover:shadow-lg transition">
                    <div class="space-y-2">
                        <i class="fa-solid fa-quote-left text-2xl text-green-200"></i>
                        <p class="text-xs text-gray-600 italic leading-relaxed line-clamp-4">
                            "{{ $testi->content }}"
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left space-y-2 sm:space-y-0 sm:space-x-3 pt-3 border-t border-gray-50">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-[#0d6b38] font-bold flex items-center justify-center flex-shrink-0 overflow-hidden text-sm mx-auto sm:mx-0">
                            <img src="{{ $testi->photo_url }}" alt="{{ $testi->name }}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($testi->name) }}&background=0d6b38&color=fff'">
                        </div>
                        <div class="min-w-0">
                            <span class="block font-bold text-xs text-gray-900 text-center sm:text-left">{{ $testi->name }}</span>
                            <span class="block text-[11px] text-gray-400 text-center sm:text-left">{{ $testi->profession ?? 'Alumni / Wali Murid' }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center pt-2">
            <a href="{{ route('testimonial.index') }}" class="inline-flex items-center text-xs font-bold text-[#0d6b38] hover:underline">
                <span>Lihat Seluruh Testimonial</span>
                <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
            </a>
        </div>
    </section>
    @endif

    {{-- SEKSI 6: GOOGLE MAPS KAMPUS --}}
    <section class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-[#0d6b38] uppercase tracking-wider block">Lokasi Kampus</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">Alamat SMA IT Plus Robbani</h2>
                <p class="text-xs text-gray-500 mt-1">Jl. Lintas Timur KM 35, Kel. Indralaya Indah, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662</p>
            </div>
            <a href="https://maps.google.com" target="_blank" class="inline-flex items-center bg-[#0d6b38] hover:bg-[#094725] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow transition flex-shrink-0">
                <i class="fa-solid fa-map-location-dot mr-2"></i> Buka Google Maps
            </a>
        </div>

        <div class="rounded-2xl overflow-hidden shadow-inner border border-gray-200 h-80 sm:h-96">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15935.918903337965!2d104.642145!3d-3.232491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b9991cb45aaab%3A0x28dfaa3303668f80!2sIndralaya%20Mulya%2C%20Indralaya%2C%20Ogan%20Ilir%20Regency%2C%20South%20Sumatra!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

</div>
@endsection
