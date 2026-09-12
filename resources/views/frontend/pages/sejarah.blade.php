@extends('layouts.frontend')

@section('title', 'Sejarah Sekolah - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Sejarah perjalanan dan perkembangan SMA IT Ishlahul Ummah Prabumulih di Prabumulih Prabumulih dalam melahirkan generasi Qur\'ani dan saintis berprestasi.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Sejarah</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Sejarah SMA IT Ishlahul Ummah Prabumulih</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Jejak langkah pengabdian, dedikasi pendidik, dan perjalanan membangun peradaban pendidikan Islam terpadu di Kabupaten Prabumulih.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- KOLOM UTAMA (2/3) --}}
        <div class="lg:col-span-8 space-y-8">
            <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up space-y-6">
                
                {{-- GAMBAR ILUSTRASI SEJARAH --}}
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 max-h-96">
                    <img src="/uploads/gedung-smait-ishum.webp" alt="Kampus SMA IT Ishlahul Ummah Prabumulih" class="w-full h-full object-cover">
                </div>

                <div class="border-b border-gray-100 pb-4">
                    <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Jejak Langkah & Perkembangan</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                        Membangun Generasi Emas Ishum di Bumi Caram Seguguk
                    </h2>
                    <div class="w-16 h-1 bg-[#00913e] rounded-full mt-3"></div>
                </div>

                {{-- SEJARAH LENGKAP SEKOLAH --}}
                <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-5">
                    @if(!empty($page->content) && strlen(trim(strip_tags($page->content))) > 50)
                        {!! $page->content !!}
                    @else
                        <p>
                            SMA IT Ishlahul Ummah Prabumulih didirikan atas dasar cita-cita luhur para tokoh pendidikan dan ulama di Kabupaten Prabumulih yang menginginkan hadirnya institusi pendidikan menengah atas yang memadukan secara harmonis antara kecerdasan spiritual berbasis Al-Qur'an dan kemajuan sains-teknologi modern.
                        </p>

                        <p>
                            Pada awal pendiriannya, sekolah dirintis dengan sarana yang terukur namun sarat akan semangat juang tenaga pendidik yang berdedikasi tinggi. Minat masyarakat yang besar terhadap konsep Sekolah Islam Terpadu (SIT) plus tahfidz dan riset membuat SMA IT Ishlahul Ummah Prabumulih terus tumbuh pesat dan dipercaya oleh para orang tua dari berbagai penjuru Sumatera Selatan.
                        </p>

                        <p>
                            Seiring berjalannya waktu, sekolah terus memperluas sarana dan prasarana pendidikan. Pembangunan laboratorium sains mutakhir, laboratorium komputer multimedia terintegrasi, perpustakaan digital, serta asrama santri (Islamic Boarding School) yang representatif menjadi bukti komitmen nyata dalam menghadirkan lingkungan belajar yang holistik.
                        </p>

                        <p>
                            Berbagai prestasi membanggakan berhasil diraih oleh santri-santriwati SMA IT Ishlahul Ummah Prabumulih, mulai dari juara Olimpiade Sains Nasional tingkat daerah hingga nasional, kejuaraan Musabaqah Hifdzil Qur’an (MHQ), kompetisi robotika, hingga keberhasilan meluluskan alumni ke berbagai perguruan tinggi negeri ternama (PTN) dan universitas di Timur Tengah.
                        </p>

                        <p>
                            Kini, SMA IT Ishlahul Ummah Prabumulih telah berkembang menjadi salah satu sekolah rujukan di Prabumulih yang menerapkan Kurikulum Merdeka yang disempurnakan dengan kurikulum kekhasan Islam Terpadu Plus, didukung oleh tenaga pendidik berkualifikasi magister dan sertifikasi pendidik profesional.
                        </p>

                        <p class="font-medium text-gray-900 bg-emerald-50/80 p-5 rounded-2xl border-l-4 border-[#00913e]">
                            Dengan memegang teguh semboyan <em>Qur'ani, Berprestasi, dan Berakhlak Mulia</em>, SMA IT Ishlahul Ummah Prabumulih terus melangkah maju, berinovasi tanpa henti, dan bertekad mencetak calon pemimpin bangsa yang siap berkontribusi bagi kemaslahatan umat dan dunia.
                        </p>
                    @endif
                </div>
            </article>
        </div>

        {{-- SIDEBAR KANAN (1/3) --}}
        <div class="lg:col-span-4 space-y-8">
            
            {{-- WIDGET ARTIKEL & BERITA TERBARU --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="font-extrabold text-gray-900 text-base">Kabar Sekolah</h3>
                    <a href="{{ route('artikel.index') }}" class="text-xs font-bold text-[#00913e] hover:text-orange-500">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($latestPosts ?? [] as $lp)
                        <a href="{{ route('artikel.show', $lp->slug) }}" class="flex items-center space-x-3 group">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                <img src="{{ $lp->featured_image }}" alt="{{ $lp->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300" onerror="this.src='/uploads/gedung-smait-ishum.webp'">
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    {{ $lp->title }}
                                </h4>
                                <span class="text-[11px] text-gray-400 block mt-1">
                                    {{ $lp->published_at ? $lp->published_at->translatedFormat('d M Y') : ($lp->created_at ? $lp->created_at->translatedFormat('d M Y') : '') }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada berita terbaru.</p>
                    @endforelse
                </div>
            </div>

            {{-- WIDGET AGENDA TERJADWAL --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 reveal-fade-up delay-1">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="font-extrabold text-gray-900 text-base">Agenda Akademik</h3>
                    <a href="{{ route('agenda.index') }}" class="text-xs font-bold text-[#00913e] hover:text-orange-500">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($latestAgendas ?? [] as $la)
                        <a href="{{ route('agenda.show', $la->slug) }}" class="flex items-start space-x-3 group p-3 rounded-xl hover:bg-emerald-50/50 transition">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00913e] flex flex-col items-center justify-center flex-shrink-0 font-bold text-xs">
                                <span class="text-sm font-extrabold leading-none">{{ $la->event_date ? $la->event_date->format('d') : '01' }}</span>
                                <span class="text-[9px] uppercase">{{ $la->event_date ? $la->event_date->translatedFormat('M') : 'SMA' }}</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                                    {{ $la->title }}
                                </h4>
                                <span class="text-[11px] text-gray-400 block mt-1">
                                    <i class="fa-solid fa-location-dot mr-1 text-orange-400"></i> {{ $la->location ?: 'Kampus SMA IT Ishlahul Ummah Prabumulih' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>
            </div>

            {{-- CTA BANNER --}}
            <div class="bg-gradient-to-br from-emerald-950 via-[#00913e] to-emerald-900 text-white p-6 sm:p-8 rounded-3xl shadow-xl space-y-4 text-center reveal-fade-up delay-2">
                <div class="w-14 h-14 rounded-2xl bg-red-500/20 text-red-400 flex items-center justify-center text-2xl mx-auto border border-red-500/30">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
                <h3 class="text-xl font-extrabold">Bergabung Bersama Kami!</h3>
                <p class="text-xs text-emerald-100 leading-relaxed">
                    Daftarkan putra-putri tercinta sekarang dan jadilah bagian dari keluarga besar SMA IT Ishlahul Ummah Prabumulih.
                </p>
                <div class="pt-2">
                    <a href="{{ route('ppdb.index') }}" class="block w-full bg-[#da251c] hover:bg-[#b91c1c] text-white py-3 rounded-xl font-bold text-xs shadow-lg transition">
                        Daftar PPDB Sekarang
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
