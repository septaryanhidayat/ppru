@extends('layouts.frontend')

@section('title', 'Sambutan Kepala Sekolah - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Sambutan resmi Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih, Agi Gustiawan, S. Pd.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-gray-900 to-[#00913e] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-gray-300 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-[#ef4444] font-semibold">Sambutan Kepala Sekolah</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Sambutan Kepala Sekolah</h1>
        <p class="text-sm text-gray-200 mt-2 font-light">
            Pesan dan komitmen pembinaan karakter, iman, dan ilmu di SMA IT Ishlahul Ummah Prabumulih.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        {{-- PROFIL PIMPINAN HEADER --}}
        <div class="flex flex-col md:flex-row items-center gap-8 mb-8 pb-8 border-b border-gray-100">
            <div class="w-48 h-56 sm:w-52 sm:h-60 rounded-2xl overflow-hidden shadow-lg border-4 border-white ring-4 ring-green-100 flex-shrink-0 bg-green-50">
                <img src="/uploads/kepsek-agi-gustiawan.jpg" alt="Agi Gustiawan, S. Pd - Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih" class="w-full h-full object-cover object-top" onerror="this.src='/uploads/logo-ishum-square.png'">
            </div>
            <div class="space-y-2 text-center md:text-left">
                <span class="inline-block bg-green-100 text-[#00913e] text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                    Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Agi Gustiawan, S. Pd
                </h2>
                <p class="text-xs sm:text-sm text-[#00913e] font-semibold">Pendidik Berpengalaman &amp; Praktisi Pendidikan Karakter Islami</p>
                <p class="text-xs sm:text-sm text-gray-600 italic pt-1">"Membina Generasi Qur'ani, Berakhlak Mulia, Cerdas, dan Siap Memimpin Peradaban Masa Depan."</p>
            </div>
        </div>

        {{-- KONTEN PIDATO RESMI --}}
        <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-5">
            @if(!empty($page->content) && strlen(trim(strip_tags($page->content))) > 30)
                {!! $page->content !!}
            @else
                <p class="font-semibold text-gray-900 text-base sm:text-lg">Assalamu'alaikum Warahmatullahi Wabarakatuh,</p>

                <p>Alhamdulillahirabbil'alamin, segala puji dan syukur senantiasa kita panjatkan ke hadirat Allah Subhanahu Wa Ta'ala atas limpahan rahmat, taufik, serta hidayah-Nya. Shalawat beriring salam semoga senantiasa tercurah kepada uswah hasanah kita, Nabi Muhammad Shallallahu 'Alaihi Wasallam, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.</p>

                <p>Selamat datang di laman resmi <strong>SMA IT Ishlahul Ummah Prabumulih</strong>. Website ini kami hadirkan sebagai media keterbukaan informasi, sarana komunikasi, dan etalase karya serta prestasi seluruh civitas akademika keluarga besar Ishum.</p>

                <p>Dunia pendidikan saat ini menghadapi tantangan globalisasi dan disrupsi teknologi yang sangat cepat. Oleh karena itu, SMA IT Ishlahul Ummah Prabumulih berkomitmen memadukan <strong>Kurikulum Nasional (Kurikulum Merdeka)</strong> dengan <strong>Kurikulum Khusus Keislaman Terpadu</strong>, penguatan <strong>Tahfidzul Qur'an bersanad</strong>, penguasaan sains dan teknologi modern, serta pembinaan akhlakul karimah melalui sistem <em>Bina Pribadi Islam (BPI)</em>.</p>

                <p>Kami meyakini bahwa setiap anak memiliki potensi istimewa yang dianugerahkan Allah SWT. Tugas kami bersama para ustadz dan ustadzah yang berdedikasi adalah mendampingi, memantik potensi tersebut, dan membimbing mereka agar tumbuh menjadi generasi yang kokoh akidahnya, rajin ibadahnya, berakhlak mulia, cerdas inteleknya, serta berjiwa kepemimpinan.</p>

                <p>Kami mengucapkan terima kasih yang sebesar-besarnya kepada seluruh orang tua/wali murid atas amanah dan kepercayaan yang diberikan kepada kami. Mari bersama-sama bersinergi melahirkan generasi khaira ummah yang membanggakan keluarga, bangsa, dan agama.</p>

                <p class="font-semibold text-gray-900 pt-2">Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>

                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">DRS. H. AHMAD HUSEN, M.Pd.I</h3>
                        <p class="text-xs text-gray-500">Kepala SMA Islam Terpadu Ishlahul Ummah Prabumulih</p>
                    </div>
                    <div class="inline-flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-xl text-xs text-[#00913e] border border-green-200">
                        <i class="fa-solid fa-certificate text-[#da251c]"></i>
                        <span>Akreditasi A Unggul</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- CTA DAFTAR PPDB --}}
        <div class="mt-10 pt-8 border-t border-gray-100 bg-gradient-to-r from-[#00913e] via-[#05a849] to-[#b91c1c] rounded-2xl p-6 sm:p-8 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg">
            <div>
                <h4 class="text-xl font-extrabold">Pendaftaran Peserta Didik Baru (PPDB)</h4>
                <p class="text-xs sm:text-sm text-green-100 mt-1">Mari bergabung bersama keluarga besar SMA IT Ishlahul Ummah Prabumulih. Gelombang pendaftaran siswa baru telah dibuka.</p>
            </div>
            <div class="flex flex-wrap gap-3 flex-shrink-0">
                <a href="{{ route('hubungi') }}?type=ppdb" class="bg-white text-[#00913e] hover:bg-orange-50 px-5 py-2.5 rounded-xl font-bold text-xs shadow transition flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-1.5 text-[#da251c]"></i> Daftar PPDB Online
                </a>
                <a href="{{ route('hubungi') }}" class="bg-black/30 hover:bg-black/40 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow transition flex items-center">
                    <i class="fa-solid fa-phone mr-1.5"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
