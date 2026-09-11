@extends('layouts.frontend')

@section('title', 'Mars dan Hymne - SMA IT Plus Robbani')
@section('meta_description', 'Lagu resmi Mars dan Hymne SMA IT Plus Robbani, pembangkit semangat belajar, hafalan Qur\'an, dan keunggulan sains bagi seluruh santri.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#0d6b38] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('download.index') }}" class="hover:text-white transition">Download</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Hymne & Mars Robbani</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Mars dan Hymne SMA IT Plus Robbani</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Lagu resmi pembangkit semangat menuntut ilmu, integritas moral, kecintaan pada Al-Qur'an, dan dedikasi santri bagi peradaban bangsa.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    {{-- MARS SEKOLAH --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 space-y-6 reveal-fade-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">Lagu Semangat Santri</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">MARS SMA IT PLUS ROBBANI</h2>
                <p class="text-xs sm:text-sm text-gray-500 italic mt-1">
                    Gubahan: <strong>Keluarga Besar SMA IT Plus Robbani</strong>
                </p>
            </div>
            <a href="#" class="inline-flex items-center bg-[#0d6b38] hover:bg-emerald-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex-shrink-0">
                <i class="fa-solid fa-download mr-2"></i> Unduh Audio Mars
            </a>
        </div>

        {{-- Lirik Mars Lengkap --}}
        <div class="bg-emerald-50/50 p-8 rounded-2xl border border-emerald-100 text-center space-y-4 text-sm sm:text-base text-gray-800 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-extrabold text-emerald-800 uppercase tracking-widest mb-6">LIRIK MARS SMA IT PLUS ROBBANI</h3>

            <p>
                Di bumi persada Nusantara nan megah<br>
                Tegak berdiri bahtera peradaban mulia<br>
                SMA IT Plus Robbani harapan bangsa<br>
                Menempa insan beriman dan bertaqwa
            </p>

            <p>
                Al-Qur'an dan Sunnah lentera penerang jiwa<br>
                Sains dan teknologi kami kuasai bersama<br>
                Dengan tekad bulat melangkah ke depan<br>
                Menyongsong fajar kejayaan peradaban
            </p>

            <div class="py-2">
                <span class="inline-block text-xs font-bold text-white bg-orange-500 px-3 py-1 rounded-full uppercase tracking-wider mb-2 font-sans">Reff</span>
                <p class="font-bold text-gray-900">
                    Maju bersama SMA IT Plus Robbani<br>
                    Generasi tangguh, cerdas, dan mandiri<br>
                    Hafizh Qur'an, pemimpin berakhlak terpuji<br>
                    Membangun negeri demi ridho Ilahi
                </p>
            </div>

            <p>
                Kibarkan panji prestasi di kancah dunia<br>
                Bakti kami persembahkan untuk Indonesia tercinta
            </p>
        </div>
    </article>

    {{-- HYMNE SEKOLAH --}}
    <article class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 space-y-6 reveal-fade-up delay-1">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block">Lagu Keheningan & Doa</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">HYMNE SMA IT PLUS ROBBANI</h2>
                <p class="text-xs sm:text-sm text-gray-500 italic mt-1">
                    Dedikasi & Syukur Santri Robbani
                </p>
            </div>
            <a href="#" class="inline-flex items-center bg-gray-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition flex-shrink-0">
                <i class="fa-solid fa-download mr-2"></i> Unduh Audio Hymne
            </a>
        </div>

        {{-- Lirik Hymne Lengkap --}}
        <div class="bg-amber-50/50 p-8 rounded-2xl border border-amber-100 text-center space-y-4 text-sm sm:text-base text-gray-800 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-extrabold text-amber-800 uppercase tracking-widest mb-6">LIRIK HYMNE ROBBANI</h3>

            <p>
                Dalam sujud syukur kami tengadahkan doa<br>
                Atas rahmat dan karunia-Mu yang tiada terkira<br>
                Engkau bimbing kami dalam naungan cahaya<br>
                Di taman ilmu Robbani penuh berkah
            </p>

            <p>
                Wahai guru-guru kami tercinta<br>
                Ikhlasmu mengalir bagai telaga jernih<br>
                Membimbing langkah kami meniti jalan kebenaran<br>
                Menjadi hamba yang sholeh dan bermanfaat
            </p>

            <div class="py-2">
                <span class="inline-block text-xs font-bold text-white bg-emerald-700 px-3 py-1 rounded-full uppercase tracking-wider mb-2 font-sans">Reff</span>
                <p class="font-bold text-gray-900">
                    Robbani... Robbani... Almamater kebanggaan kami<br>
                    Kan kami jaga amanah luhur ini<br>
                    Mengharumkan asmamu di persada bumi<br>
                    Hingga akhir hayat kami nanti
                </p>
            </div>
        </div>
    </article>

</div>
@endsection
