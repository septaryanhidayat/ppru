{{-- TOP MINI BAR (Elegan: Kontak Telepon, Email, Alamat & Medsos PPRU Sakatiga) --}}
<div class="bg-[#053d1c] text-white text-xs py-2 border-b border-green-900/70 hidden sm:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center space-x-4 sm:space-x-6">
            <a href="tel:{{ $siteSettings['contact_phone'] ?? '081278901950' }}" class="flex items-center text-emerald-100 hover:text-[#f59e0b] transition text-xs font-semibold" aria-label="Telepon Pesantren">
                <i class="fa-solid fa-phone mr-1.5 text-[#f59e0b]"></i>
                <span>{{ $siteSettings['contact_phone'] ?? '0812-7890-1950' }}</span>
            </a>
            <span class="text-emerald-800">|</span>
            <a href="mailto:{{ $siteSettings['contact_email'] ?? 'sekretariat@ppru.ac.id' }}" class="flex items-center text-emerald-100 hover:text-[#f59e0b] transition text-xs font-semibold" aria-label="Email Pesantren">
                <i class="fa-solid fa-envelope mr-1.5 text-[#f59e0b]"></i>
                <span>{{ $siteSettings['contact_email'] ?? 'sekretariat@ppru.ac.id' }}</span>
            </a>
            <span class="hidden md:inline text-emerald-800">|</span>
            <span class="hidden md:flex items-center text-emerald-200 text-xs">
                <i class="fa-solid fa-location-dot mr-1.5 text-[#f59e0b]"></i>
                <span>Sakatiga, Indralaya, Ogan Ilir, Sumsel 30816</span>
            </span>
        </div>

        <div class="flex items-center space-x-3 text-xs">
            <a href="{{ $siteSettings['social_facebook'] ?? 'https://www.facebook.com/pprusakatigasumsel/?locale=id_ID' }}" target="_blank" rel="noopener" class="text-emerald-200 hover:text-[#f59e0b] transition" aria-label="Facebook PPRU">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="{{ $siteSettings['social_instagram'] ?? 'https://www.instagram.com/ppru_sakatiga/' }}" target="_blank" rel="noopener" class="text-emerald-200 hover:text-[#f59e0b] transition" aria-label="Instagram PPRU">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="{{ $siteSettings['social_youtube'] ?? 'https://www.youtube.com/@pprusakatiga' }}" target="_blank" rel="noopener" class="text-emerald-200 hover:text-[#f59e0b] transition" aria-label="YouTube PPRU">
                <i class="fa-brands fa-youtube"></i>
            </a>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_whatsapp'] ?? '6281278901950') }}" target="_blank" rel="noopener" class="text-emerald-200 hover:text-[#f59e0b] transition flex items-center space-x-1" aria-label="WhatsApp PPRU">
                <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                <span class="text-[11px] font-semibold">Helpdesk</span>
            </a>
        </div>
    </div>
</div>

{{-- MAIN STICKY NAVBAR (Hijau Islami PPRU #00843d & Aksen Emas #f59e0b) --}}
<header class="sticky top-0 z-50 bg-[#00843d] shadow-lg border-b border-emerald-600/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- LOGO RESMI PONDOK PESANTREN RAUDHATUL ULUM --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0" aria-label="Beranda Pondok Pesantren Raudhatul Ulum">
                <div class="h-16 flex items-center py-1">
                    {{-- Logo Banner Horizontal Resmi --}}
                    <img src="{{ $siteSettings['site_logo'] ?? '/uploads/logo-ppru-banner.png' }}" 
                         alt="Pondok Pesantren Raudhatul Ulum Sakatiga" 
                         class="max-h-16 w-auto object-contain transform group-hover:scale-102 transition duration-300 drop-shadow-md brightness-105" 
                         onerror="this.src='/uploads/logo-ppru.png'">
                </div>
            </a>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="hidden lg:flex items-center space-x-1 font-bold text-xs xl:text-sm text-white" aria-label="Navigasi Utama">
                
                {{-- 1. Beranda --}}
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl hover:bg-black/15 transition {{ request()->routeIs('home') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                    Beranda
                </a>

                {{-- 2. Profil Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('sambutan*', 'tentang*', 'visi*', 'sejarah*', 'anggota*', 'struktur*', 'bidang*', 'dpc*', 'dewan*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Profil</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('page.sambutan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-user-tie w-5 text-[#00843d] mr-2 text-sm"></i> Sambutan Mudir PPRU
                            </a>
                            <a href="{{ route('page.tentang-kami') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-landmark-dome w-5 text-[#00843d] mr-2 text-sm"></i> Profil Singkat Pesantren
                            </a>
                            <a href="{{ route('page.visi-misi') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-compass w-5 text-[#00843d] mr-2 text-sm"></i> Visi, Misi &amp; 10 Jati Diri
                            </a>
                            <a href="{{ route('page.sejarah') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-clock-rotate-left w-5 text-[#00843d] mr-2 text-sm"></i> Sejarah Sejak 1930 &amp; 1950
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('dewan.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-chalkboard-user w-5 text-[#00843d] mr-2 text-sm"></i> Dewan Asatidz &amp; Guru
                            </a>
                            <a href="{{ route('page.struktur') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-sitemap w-5 text-[#00843d] mr-2 text-sm"></i> Struktur Organisasi &amp; Pengasuh
                            </a>
                            <a href="{{ route('bidang.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-layer-group w-5 text-[#00843d] mr-2 text-sm"></i> Sarana &amp; Fasilitas Kampus
                            </a>
                            <a href="{{ route('dpc.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-star-and-crescent w-5 text-[#00843d] mr-2 text-sm"></i> Program Unggulan Pesantren
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Pendidikan Dropdown (Menyerupai Referensi baitussalam.sch.id) --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('pendidikan*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Pendidikan</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-80 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn max-h-[75vh] overflow-y-auto">
                            <div class="px-4 py-2 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-[11px] font-black text-[#00843d] uppercase tracking-wider">Unit Pendidikan PPRU</span>
                                <a href="{{ route('pendidikan.index') }}" class="text-[10px] font-bold text-[#00843d] hover:underline">Semua Unit &rarr;</a>
                            </div>

                            @if(isset($navUnitPendidikans) && $navUnitPendidikans->isNotEmpty())
                                @foreach($navUnitPendidikans as $nu)
                                    <a href="{{ route('pendidikan.show', $nu->slug) }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold truncate">{{ $nu->name }}</span>
                                            @if($nu->short_name)
                                                <span class="text-[9px] bg-emerald-100 text-[#00843d] px-1.5 py-0.2 rounded font-bold shrink-0 ml-1.5">{{ $nu->short_name }}</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-normal block">{{ $nu->category_type }}</span>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    Madrasah Aliyah Raudhatul Ulum (MARU)
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    SMA IT Raudhatul Ulum
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    Madrasah Tsanawiyah Raudhatul Ulum (MATSARU)
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    SMP IT Raudhatul Ulum
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    Madrasah Tahfizhul Qur'an (MATQULARU)
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    Madrasah Ibtidaiyah Raudhatul Ulum (MIRU)
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    TK Islam Raudhatul Ulum (TAKIRU)
                                </a>
                                <a href="{{ route('pendidikan.index') }}" class="block px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition">
                                    Sekolah Tinggi Ilmu Tarbiyah (STITRU)
                                </a>
                            @endif

                            <div class="border-t border-gray-100 mt-1 pt-1 px-4 py-1.5 bg-emerald-50/50">
                                <a href="{{ route('pendidikan.index') }}" class="text-xs font-black text-[#00843d] hover:underline flex items-center justify-between">
                                    <span>Lihat Semua Kurikulum &amp; Jenjang</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Galeri Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('galeri*', 'video*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Galeri</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-56 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('galeri.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-images w-5 text-[#00843d] mr-2 text-sm"></i> Galeri Foto Kegiatan
                            </a>
                            <a href="{{ route('video.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-brands fa-youtube w-5 text-red-600 mr-2 text-sm"></i> Video Dokumenter &amp; Podcast
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 5. Artikel & Kabar Dropdown (Taujih, Berita, Kegiatan, Prestasi) --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('artikel*', 'agenda*', 'pengumuman*', 'kategori*', 'prestasi*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Artikel</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('kategori.show', 'taujih') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-mosque w-5 text-[#00843d] mr-2 text-sm"></i> Taujih &amp; Tausiyah
                            </a>
                            <a href="{{ route('artikel.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-newspaper w-5 text-[#00843d] mr-2 text-sm"></i> Berita Pondok
                            </a>
                            <a href="{{ route('kategori.show', 'kegiatan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-person-chalkboard w-5 text-[#00843d] mr-2 text-sm"></i> Kegiatan Santri
                            </a>
                            <a href="{{ route('prestasi.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-trophy w-5 text-amber-500 mr-2 text-sm"></i> Prestasi Santri &amp; Guru
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('agenda.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-calendar-days w-5 text-[#00843d] mr-2 text-sm"></i> Agenda Pesantren
                            </a>
                            <a href="{{ route('pengumuman.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-bullhorn w-5 text-[#00843d] mr-2 text-sm"></i> Pengumuman Resmi
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 6. Download / Brosur --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('download*', 'e-book*', 'hymne*', 'logo*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Brosur</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-56 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('download.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-file-pdf w-5 text-[#00843d] mr-2 text-sm"></i> Brosur PSB 2026/2027
                            </a>
                            <a href="{{ route('download.ebook') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-book-open w-5 text-[#00843d] mr-2 text-sm"></i> E-Book &amp; Modul Santri
                            </a>
                            <a href="{{ route('download.hymne-mars') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-music w-5 text-[#00843d] mr-2 text-sm"></i> Hymne &amp; Mars PPRU
                            </a>
                            <a href="{{ route('download.logo') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-image w-5 text-[#00843d] mr-2 text-sm"></i> Logo Resmi Pesantren
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 7. Layanan & Kontak --}}
                <div class="relative group py-2">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-black/15 transition {{ request()->is('layanan*') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                        <span>Layanan</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 py-2.5 text-gray-800 animate-fadeIn">
                            <a href="{{ route('layanan.index') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-handshake-angle w-5 text-[#00843d] mr-2 text-sm"></i> Portal Layanan Terpadu
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('layanan.izin') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-id-card-clip w-5 text-[#00843d] mr-2 text-sm"></i> Permohonan Izin Santri
                            </a>
                            <a href="{{ route('layanan.kerjasama') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-handshake w-5 text-[#00843d] mr-2 text-sm"></i> Permohonan Kerja Sama
                            </a>
                            <a href="{{ route('layanan.sewa') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-emerald-50 hover:text-[#00843d] transition flex items-center">
                                <i class="fa-solid fa-building-user w-5 text-[#00843d] mr-2 text-sm"></i> Sewa Fasilitas Pesantren
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 8. Kontak --}}
                <a href="{{ route('hubungi') }}" class="px-3 py-2 rounded-xl hover:bg-black/15 transition {{ request()->routeIs('hubungi') ? 'bg-black/20 text-[#fcd116]' : '' }}">
                    Kontak
                </a>
            </nav>

            {{-- TOMBOL AKSI: DAFTAR PSB (EMAS/KUNING MENCOLOK KHAS LOGO) & LOGIN --}}
            <div class="hidden lg:flex items-center space-x-2.5">
                <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 px-5 py-2.5 rounded-full text-xs font-black shadow-md hover:shadow-lg transition flex items-center space-x-2 transform hover:scale-105" aria-label="Penerimaan Santri Baru Pondok Pesantren Raudhatul Ulum">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                    <span>Daftar PSB</span>
                </a>
                <a href="/login" class="text-white hover:text-white/80 px-3 py-2 text-xs font-bold transition flex items-center space-x-1 rounded-xl hover:bg-black/15" aria-label="Login Admin">
                    <i class="fa-solid fa-lock text-[11px]"></i>
                    <span>Login</span>
                </a>
            </div>

            {{-- MOBILE TOP RIGHT: Tombol PSB & Hamburger --}}
            <div class="flex lg:hidden items-center space-x-2">
                <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 px-3.5 py-2 rounded-full text-xs font-extrabold shadow transition min-h-[40px] flex items-center">
                    PSB
                </a>
                <button id="mobile-menu-toggle" type="button" class="text-white hover:text-emerald-100 p-2 rounded-lg focus:outline-none min-w-[44px] min-h-[44px] flex items-center justify-center cursor-pointer" aria-label="Buka Menu Navigasi">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU DRAWER --}}
    <div id="mobile-menu" class="hidden lg:hidden bg-white text-gray-800 border-t-2 border-[#f59e0b] px-5 pt-4 pb-6 space-y-3 shadow-2xl max-h-[85vh] overflow-y-auto">
        <form action="{{ route('artikel.index') }}" method="GET" class="relative mb-3">
            <input type="text" name="q" placeholder="Cari informasi pesantren & artikel..." aria-label="Cari artikel" value="{{ request('q') }}" class="w-full bg-gray-100 text-xs text-gray-800 rounded-full pl-9 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-xs"></i>
        </form>

        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-[#00843d]' : '' }}">
            <i class="fa-solid fa-house mr-2 text-[#00843d]"></i> Beranda
        </a>

        {{-- Mobile Profil --}}
        <details class="group">
            <summary class="flex justify-between items-center px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 cursor-pointer list-none">
                <span><i class="fa-solid fa-landmark-dome mr-2 text-[#00843d]"></i> Profil</span>
                <i class="fa-solid fa-chevron-down text-xs group-open:rotate-180 transition"></i>
            </summary>
            <div class="pl-6 pt-1 space-y-1 text-xs">
                <a href="{{ route('page.sambutan') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Sambutan Mudir PPRU</a>
                <a href="{{ route('page.tentang-kami') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Profil Singkat Pesantren</a>
                <a href="{{ route('page.visi-misi') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Visi, Misi &amp; 10 Jati Diri</a>
                <a href="{{ route('page.sejarah') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Sejarah Sejak 1930 &amp; 1950</a>
                <a href="{{ route('dewan.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Dewan Asatidz &amp; Guru</a>
                <a href="{{ route('page.struktur') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Struktur Organisasi</a>
                <a href="{{ route('bidang.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Sarana &amp; Fasilitas Kampus</a>
                <a href="{{ route('dpc.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Program Unggulan</a>
            </div>
        </details>

        {{-- Mobile Pendidikan --}}
        <details class="group">
            <summary class="flex justify-between items-center px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 cursor-pointer list-none">
                <span><i class="fa-solid fa-building-columns mr-2 text-[#00843d]"></i> Unit Pendidikan</span>
                <i class="fa-solid fa-chevron-down text-xs group-open:rotate-180 transition"></i>
            </summary>
            <div class="pl-6 pt-1 space-y-1 text-xs">
                <a href="{{ route('pendidikan.index') }}" class="block py-1.5 font-bold text-[#00843d]">Katalog Semua Unit</a>
                @if(isset($navUnitPendidikans))
                    @foreach($navUnitPendidikans as $nu)
                        <a href="{{ route('pendidikan.show', $nu->slug) }}" class="block py-1.5 text-gray-600 hover:text-[#00843d] truncate">{{ $nu->name }}</a>
                    @endforeach
                @endif
            </div>
        </details>

        {{-- Mobile Galeri --}}
        <div class="flex flex-col space-y-1">
            <a href="{{ route('galeri.index') }}" class="px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition">
                <i class="fa-solid fa-images mr-2 text-[#00843d]"></i> Galeri Foto
            </a>
            <a href="{{ route('video.index') }}" class="px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition">
                <i class="fa-brands fa-youtube mr-2 text-red-600"></i> Video Kegiatan
            </a>
        </div>

        {{-- Mobile Artikel --}}
        <details class="group">
            <summary class="flex justify-between items-center px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 cursor-pointer list-none">
                <span><i class="fa-solid fa-newspaper mr-2 text-[#00843d]"></i> Artikel &amp; Kabar</span>
                <i class="fa-solid fa-chevron-down text-xs group-open:rotate-180 transition"></i>
            </summary>
            <div class="pl-6 pt-1 space-y-1 text-xs">
                <a href="{{ route('kategori.show', 'taujih') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Taujih &amp; Tausiyah</a>
                <a href="{{ route('artikel.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Berita Pondok</a>
                <a href="{{ route('kategori.show', 'kegiatan') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Kegiatan Santri</a>
                <a href="{{ route('prestasi.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Prestasi Santri &amp; Guru</a>
                <a href="{{ route('agenda.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Agenda Pesantren</a>
                <a href="{{ route('pengumuman.index') }}" class="block py-1.5 text-gray-600 hover:text-[#00843d]">Pengumuman</a>
            </div>
        </details>

        <a href="{{ route('download.index') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition">
            <i class="fa-solid fa-download mr-2 text-[#00843d]"></i> Unduh Brosur &amp; Dokumen
        </a>

        <a href="{{ route('layanan.index') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition">
            <i class="fa-solid fa-handshake-angle mr-2 text-[#00843d]"></i> Layanan Terpadu
        </a>

        <a href="{{ route('hubungi') }}" class="block px-3 py-2 rounded-lg font-bold text-gray-900 hover:bg-emerald-50 hover:text-[#00843d] transition">
            <i class="fa-solid fa-address-book mr-2 text-[#00843d]"></i> Kontak &amp; Lokasi
        </a>

        <div class="pt-3 border-t border-gray-100 flex flex-col space-y-2">
            <a href="{{ route('ppdb.index') }}" class="block w-full text-center bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 font-black py-2.5 rounded-full text-xs shadow">
                <i class="fa-solid fa-graduation-cap mr-1"></i> Daftar PSB Online
            </a>
            <a href="/login" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 rounded-full text-xs">
                <i class="fa-solid fa-lock mr-1"></i> Login Portal
            </a>
        </div>
    </div>
</header>
