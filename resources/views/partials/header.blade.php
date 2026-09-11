{{-- TOP MINI BAR (Elegan: Kontak Telepon & Email Resmi Sekolah) --}}
<div class="bg-[#0f172a] text-white text-xs py-2 border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center sm:justify-start items-center space-x-4 sm:space-x-6">
        <a href="tel:{{ $siteSettings['contact_phone'] ?? '082177889900' }}" class="flex items-center text-white hover:text-[#fb923c] transition py-1 text-xs font-semibold" aria-label="Hubungi Telepon {{ $siteSettings['contact_phone'] ?? '0821-7788-9900' }}">
            <i class="fa-solid fa-phone mr-2 text-[#f97316]" aria-hidden="true"></i>
            <span>{{ $siteSettings['contact_phone'] ?? '0821-7788-9900' }}</span>
        </a>
        <span class="text-neutral-600" aria-hidden="true">|</span>
        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@smaitplusrobbani.sch.id' }}" class="flex items-center text-white hover:text-[#fb923c] transition py-1 text-xs font-semibold" aria-label="Kirim Email ke {{ $siteSettings['contact_email'] ?? 'info@smaitplusrobbani.sch.id' }}">
            <i class="fa-solid fa-envelope mr-2 text-[#f97316]" aria-hidden="true"></i>
            <span>{{ $siteSettings['contact_email'] ?? 'info@smaitplusrobbani.sch.id' }}</span>
        </a>
        <span class="hidden md:inline text-neutral-600" aria-hidden="true">|</span>
        <span class="hidden md:flex items-center text-gray-300 text-xs">
            <i class="fa-solid fa-location-dot mr-1.5 text-[#f97316]"></i>
            <span>Indralaya, Ogan Ilir, Sumatera Selatan</span>
        </span>
    </div>
</div>

{{-- MAIN STICKY NAVBAR (Hijau Dominan #0d6b38 & Aksen Secondary Orange #f97316) --}}
<header class="sticky top-0 z-50 bg-[#0d6b38] shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- LOGO SMA IT PLUS ROBBANI --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0" aria-label="Beranda SMA IT Plus Robbani">
                <div class="h-14 flex items-center">
                    <img src="/uploads/logo-robbani.svg" alt="Logo SMA IT Plus Robbani" class="max-h-14 w-auto object-contain transform group-hover:scale-105 transition duration-300" onerror="this.src='/uploads/logo-robbani-emblem.svg'">
                </div>
            </a>

            {{-- DESKTOP NAVIGATION (Teks Putih Tebal dengan Safe-Hover Dropdown) --}}
            <nav class="hidden lg:flex items-center space-x-1 font-bold text-sm text-white" aria-label="Navigasi Utama">
                
                {{-- Beranda --}}
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg hover:bg-black/15 transition {{ request()->routeIs('home') ? 'bg-black/20 text-white' : '' }}">
                    Beranda
                </a>

                {{-- Profil Dropdown --}}
                <div class="relative group py-2" id="nav-dropdown-profil">
                    <button type="button" aria-haspopup="true" aria-expanded="false" aria-label="Buka Menu Profil" class="px-3.5 py-2 rounded-lg inline-flex items-center hover:bg-black/15 transition {{ request()->is('sambutan*', 'tentang*', 'visi*', 'sejarah*', 'anggota*', 'struktur*', 'bidang*', 'dpc*', 'dewan*') ? 'bg-black/20 text-white' : '' }}">
                        <span>Profil</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180" aria-hidden="true"></i>
                    </button>
                    {{-- Safe Hover Bridge Container --}}
                    <div class="absolute left-0 top-full pt-1 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('page.sambutan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-user-tie w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Sambutan Kepala Sekolah
                            </a>
                            <a href="{{ route('page.tentang-kami') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-school w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Profil Singkat Sekolah
                            </a>
                            <a href="{{ route('page.visi-misi') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-compass w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Visi dan Misi
                            </a>
                            <a href="{{ route('page.sejarah') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-landmark w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Sejarah Sekolah
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('dewan.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-chalkboard-user w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Dewan Guru &amp; Tenaga Kependidikan
                            </a>
                            <a href="{{ route('page.struktur') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-sitemap w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Struktur Organisasi Sekolah
                            </a>
                            <a href="{{ route('bidang.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-layer-group w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Fasilitas &amp; Sarana Prasarana
                            </a>
                            <a href="{{ route('dpc.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-star-and-crescent w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Program Unggulan &amp; Tahfidz
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Berita & Prestasi --}}
                <a href="{{ route('artikel.index') }}" class="px-3.5 py-2 rounded-lg hover:bg-black/15 transition {{ request()->routeIs('artikel*') ? 'bg-black/20 text-white' : '' }}">
                    Berita &amp; Prestasi
                </a>

                {{-- Informasi Dropdown --}}
                <div class="relative group py-2" id="nav-dropdown-informasi">
                    <button type="button" aria-haspopup="true" aria-expanded="false" aria-label="Buka Menu Informasi" class="px-3.5 py-2 rounded-lg inline-flex items-center hover:bg-black/15 transition {{ request()->is('agenda*', 'pengumuman*', 'testimonial*', 'video*') ? 'bg-black/20 text-white' : '' }}">
                        <span>Informasi</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180" aria-hidden="true"></i>
                    </button>
                    {{-- Safe Hover Bridge Container --}}
                    <div class="absolute left-0 top-full pt-1 w-56 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('agenda.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-calendar-days w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Agenda Akademik
                            </a>
                            <a href="{{ route('pengumuman.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-bell w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Pengumuman Sekolah
                            </a>
                            <a href="{{ route('testimonial.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-comment-dots w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Testimonial Alumni &amp; Wali
                            </a>
                            <a href="{{ route('video.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-brands fa-youtube w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Galeri Video Kegiatan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Download Dropdown --}}
                <div class="relative group py-2" id="nav-dropdown-download">
                    <button type="button" aria-haspopup="true" aria-expanded="false" aria-label="Buka Menu Download" class="px-3.5 py-2 rounded-lg inline-flex items-center hover:bg-black/15 transition {{ request()->is('download*', 'e-book*', 'hymne*', 'logo*') ? 'bg-black/20 text-white' : '' }}">
                        <span>Download</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180" aria-hidden="true"></i>
                    </button>
                    {{-- Safe Hover Bridge Container --}}
                    <div class="absolute left-0 top-full pt-1 w-56 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('download.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-file-arrow-down w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Formulir &amp; Brosur PPDB
                            </a>
                            <a href="{{ route('download.ebook') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-book-open w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> E-Library &amp; Modul Siswa
                            </a>
                            <a href="{{ route('download.hymne-mars') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-music w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Mars &amp; Hymne Sekolah
                            </a>
                            <a href="{{ route('download.logo') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-green-50 hover:text-[#0d6b38] transition flex items-center">
                                <i class="fa-solid fa-image w-5 text-[#0d6b38] mr-2 text-sm" aria-hidden="true"></i> Logo Resmi Sekolah
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Galeri --}}
                <a href="{{ route('galeri.index') }}" class="px-3.5 py-2 rounded-lg hover:bg-black/15 transition {{ request()->routeIs('galeri*') ? 'bg-black/20 text-white' : '' }}">
                    Galeri
                </a>
            </nav>

            {{-- TOMBOL AKSI: KONTAK, DAFTAR PPDB (ORANGE MENCOLOK), & LOGIN --}}
            <div class="hidden lg:flex items-center space-x-3">
                <a href="{{ route('hubungi') }}" class="bg-gray-950 hover:bg-black text-white px-5 py-2 rounded-full text-xs font-extrabold shadow-md hover:shadow-lg transition flex items-center space-x-2 transform hover:scale-105">
                    <span>Kontak</span>
                </a>
                <a href="{{ route('hubungi') }}?type=ppdb" class="bg-[#f97316] hover:bg-[#ea580c] text-white px-5 py-2 rounded-full text-xs font-extrabold shadow-md transition flex items-center space-x-1.5 transform hover:scale-105" aria-label="Pendaftaran PPDB Online SMA IT Plus Robbani">
                    <i class="fa-solid fa-graduation-cap text-xs" aria-hidden="true"></i>
                    <span>Daftar PPDB</span>
                </a>
                <a href="/login" class="text-white hover:text-white/80 px-2.5 py-2 text-xs font-bold transition flex items-center space-x-1 rounded-lg hover:bg-black/15" aria-label="Login SIAKAD & Admin">
                    <i class="fa-solid fa-lock text-[11px]" aria-hidden="true"></i>
                    <span>Login</span>
                </a>
            </div>

            {{-- MOBILE TOP RIGHT: Tombol PPDB & Hamburger --}}
            <div class="flex lg:hidden items-center space-x-2">
                <a href="{{ route('hubungi') }}?type=ppdb" class="bg-[#f97316] hover:bg-[#ea580c] text-white px-3.5 py-2 rounded-full text-xs font-extrabold shadow transition min-h-[44px] flex items-center">
                    PPDB
                </a>
                <button id="mobile-menu-toggle" type="button" class="text-white hover:text-green-100 p-2 rounded-lg focus:outline-none min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Buka Menu Navigasi">
                    <i class="fa-solid fa-bars text-2xl" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU DRAWER --}}
    <div id="mobile-menu" class="hidden lg:hidden bg-white text-gray-800 border-t-2 border-[#f97316] px-5 pt-4 pb-6 space-y-3 shadow-2xl max-h-[85vh] overflow-y-auto">
        <form action="{{ route('artikel.index') }}" method="GET" class="relative mb-3">
            <input type="text" name="q" placeholder="Cari info & artikel sekolah..." aria-label="Cari artikel sekolah" value="{{ request('q') }}" class="w-full bg-gray-100 text-xs text-gray-800 rounded-full pl-9 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#0d6b38]">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs" aria-hidden="true"></i>
        </form>

        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-green-50 hover:text-[#0d6b38] transition {{ request()->routeIs('home') ? 'bg-green-50 text-[#0d6b38]' : '' }}">Beranda</a>
        
        {{-- Mobile Profil Submenu --}}
        <div class="border-t border-gray-100 pt-2">
            <div class="font-extrabold text-xs text-[#0d6b38] uppercase tracking-wider px-3 mb-1 flex items-center">
                <i class="fa-solid fa-school mr-2 text-[#f97316]"></i> Profil Sekolah
            </div>
            <a href="{{ route('page.sambutan') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Sambutan Kepala Sekolah</a>
            <a href="{{ route('page.tentang-kami') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Profil Singkat Sekolah</a>
            <a href="{{ route('page.visi-misi') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Visi dan Misi</a>
            <a href="{{ route('page.sejarah') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Sejarah Sekolah</a>
            <a href="{{ route('dewan.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Dewan Guru &amp; Tenaga Kependidikan</a>
            <a href="{{ route('page.struktur') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Struktur Organisasi</a>
            <a href="{{ route('bidang.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Fasilitas &amp; Sarana Prasarana</a>
            <a href="{{ route('dpc.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Program Unggulan &amp; Tahfidz</a>
        </div>

        <a href="{{ route('artikel.index') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-green-50 hover:text-[#0d6b38] transition {{ request()->routeIs('artikel*') ? 'bg-green-50 text-[#0d6b38]' : '' }}">Berita &amp; Prestasi</a>

        {{-- Mobile Informasi Submenu --}}
        <div class="border-t border-gray-100 pt-2">
            <div class="font-extrabold text-xs text-[#0d6b38] uppercase tracking-wider px-3 mb-1 flex items-center">
                <i class="fa-solid fa-circle-info mr-2 text-[#f97316]"></i> Informasi
            </div>
            <a href="{{ route('agenda.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Agenda Akademik</a>
            <a href="{{ route('pengumuman.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Pengumuman</a>
            <a href="{{ route('testimonial.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Testimonial Alumni &amp; Wali</a>
            <a href="{{ route('video.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Galeri Video Kegiatan</a>
        </div>

        {{-- Mobile Download Submenu --}}
        <div class="border-t border-gray-100 pt-2">
            <div class="font-extrabold text-xs text-[#0d6b38] uppercase tracking-wider px-3 mb-1 flex items-center">
                <i class="fa-solid fa-download mr-2 text-[#f97316]"></i> Download
            </div>
            <a href="{{ route('download.index') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Formulir PPDB &amp; Brosur</a>
            <a href="{{ route('download.ebook') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">E-Library &amp; Modul Siswa</a>
            <a href="{{ route('download.hymne-mars') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Mars &amp; Hymne Sekolah</a>
            <a href="{{ route('download.logo') }}" class="block px-4 py-1.5 text-xs text-gray-700 hover:text-[#0d6b38]">Logo Resmi Sekolah</a>
        </div>

        <a href="{{ route('galeri.index') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-green-50 hover:text-[#0d6b38] transition {{ request()->routeIs('galeri*') ? 'bg-green-50 text-[#0d6b38]' : '' }}">Galeri Foto</a>
        <a href="{{ route('hubungi') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-green-50 hover:text-[#0d6b38] transition">Hubungi Kami</a>
        <a href="{{ route('donasi') }}" class="block px-3 py-2 rounded-lg font-extrabold text-[#0d6b38] hover:bg-green-50">Infaq &amp; Beasiswa Robbani</a>

        <div class="pt-3 space-y-2">
            <a href="{{ route('hubungi') }}?type=ppdb" class="block w-full text-center bg-[#f97316] hover:bg-[#ea580c] text-white py-3 rounded-xl text-xs font-extrabold shadow-md transition">
                <i class="fa-solid fa-graduation-cap mr-1.5" aria-hidden="true"></i> Pendaftaran PPDB Online
            </a>
            <a href="/login" class="block w-full text-center bg-gray-900 hover:bg-black text-white py-2.5 rounded-xl text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-lock mr-1.5 text-[#fb923c]" aria-hidden="true"></i> Login SIAKAD / Admin
            </a>
        </div>
    </div>
</header>
