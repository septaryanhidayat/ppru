@php
    $headerUnits = (isset($navUnitPendidikans) && $navUnitPendidikans->isNotEmpty())
        ? $navUnitPendidikans
        : \App\Models\UnitPendidikan::active()->orderBy('order', 'asc')->get();

    $headerMenus = (isset($headerNavMenus) && $headerNavMenus->isNotEmpty())
        ? $headerNavMenus
        : (\Illuminate\Support\Facades\Schema::hasTable('nav_menus')
            ? \App\Models\NavMenu::header()->active()->root()->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('order', 'asc')])->orderBy('order', 'asc')->get()
            : collect());

    $isSewaActive = \App\Models\Setting::get('layanan_sewa_active', '0') === '1';

    $formatNavUrl = function (?string $url): string {
        if (empty($url) || $url === '#') {
            return '#';
        }
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'javascript:') || str_starts_with($url, 'tel:') || str_starts_with($url, 'mailto:')) {
            return $url;
        }

        return url($url);
    };
@endphp
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
            <a href="{{ route('home') }}" class="flex items-center group flex-shrink-0 py-1" aria-label="Beranda Pondok Pesantren Raudhatul Ulum">
                <img src="/uploads/official/logo-web-ppru.webp" 
                     alt="Pondok Pesantren Raudhatul Ulum Sakatiga" 
                     class="h-11 sm:h-12 md:h-14 w-auto object-contain transform group-hover:scale-105 transition duration-300 drop-shadow-md" 
                     onerror="this.onerror=null;this.src='/uploads/official/logo-web-ppru.png'">
            </a>

            {{-- DESKTOP NAVIGATION (Dinamis dari Kelola Menu Navigasi Admin) --}}
            <nav class="hidden lg:flex items-center space-x-1 xl:space-x-2 font-semibold text-[13px] xl:text-[14px] text-white" aria-label="Navigasi Utama">
                @if($headerMenus->isNotEmpty())
                    @foreach($headerMenus as $m)
                        @php
                            $slug = Str::slug($m->name);
                            $activeChildren = $m->children ? $m->children->where('is_active', true) : collect();
                            $hasChildren = $activeChildren->isNotEmpty();

                            // Active route check
                            $mUrl = $formatNavUrl($m->url);
                            $isMenuRouteActive = ($m->url === '/' && request()->routeIs('home'));
                            if (! $isMenuRouteActive && ! empty($m->url) && $m->url !== '#') {
                                $cleanPath = trim(parse_url($m->url, PHP_URL_PATH) ?? '', '/');
                                if (! empty($cleanPath) && request()->is($cleanPath.'*')) {
                                    $isMenuRouteActive = true;
                                }
                            }
                            if (! $isMenuRouteActive && $hasChildren) {
                                foreach ($activeChildren as $ac) {
                                    $childPath = trim(parse_url($ac->url, PHP_URL_PATH) ?? '', '/');
                                    if (! empty($childPath) && request()->is($childPath.'*')) {
                                        $isMenuRouteActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if(! $hasChildren)
                            <a href="{{ $mUrl }}" 
                               target="{{ $m->target ?? '_self' }}"
                               class="px-3.5 py-2 rounded-xl font-bold hover:bg-black/25 hover:text-[#fcd116] transition whitespace-nowrap {{ $isMenuRouteActive ? 'bg-black/25 text-[#fcd116] ring-1 ring-amber-400/40' : 'text-white' }}">
                                {{ $m->name }}
                            </a>
                        @else
                            <div id="nav-dropdown-{{ $slug }}" class="relative group py-2">
                                <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3.5 py-2 rounded-xl font-bold inline-flex items-center hover:bg-black/25 hover:text-[#fcd116] transition whitespace-nowrap {{ $isMenuRouteActive ? 'bg-black/25 text-[#fcd116] ring-1 ring-amber-400/40' : 'text-white' }}">
                                    <span>{{ $m->name }}</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                                </button>
                                
                                <div class="absolute {{ $slug === 'layanan' ? 'right-0 xl:right-auto xl:left-0 w-72 sm:w-80' : ($slug === 'pendidikan' ? 'left-0 w-80' : 'left-0 w-64') }} top-full pt-1 hidden group-hover:block transition-all duration-150 z-50">
                                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-800 py-2.5 text-slate-800 dark:text-slate-100 animate-fadeIn {{ $slug === 'pendidikan' ? 'max-h-[75vh] overflow-y-auto' : '' }}">
                                        
                                        @if($slug === 'pendidikan')
                                            <div class="px-4 py-2 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                                                <span class="text-[11px] font-black text-[#00843d] dark:text-emerald-400 uppercase tracking-wider">Unit Pendidikan PPRU</span>
                                                <a href="{{ route('pendidikan.index') }}" class="text-[10px] font-bold text-[#00843d] dark:text-emerald-400 hover:underline">Semua Unit &rarr;</a>
                                            </div>

                                            @foreach($activeChildren as $child)
                                                @php
                                                    $childUrl = $formatNavUrl($child->url);
                                                    $childSlug = last(explode('/', trim($child->url, '/')));
                                                    $matchedUnit = $headerUnits->first(fn ($u) => $u->slug === $childSlug || $u->name === $child->name);
                                                    $cleanName = $matchedUnit ? trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $matchedUnit->name)) : $child->name;
                                                @endphp
                                                <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white transition group/item rounded-lg mx-1.5">
                                                    <div class="flex items-center justify-between">
                                                        <span class="font-bold truncate text-slate-800 dark:text-slate-100 group-hover/item:text-white">{{ $cleanName }}</span>
                                                        @if($matchedUnit && $matchedUnit->short_name)
                                                            <span class="text-[9px] bg-emerald-100 dark:bg-emerald-950 text-[#00843d] dark:text-emerald-300 group-hover/item:bg-white/20 group-hover/item:text-white px-1.5 py-0.5 rounded font-bold shrink-0 ml-1.5">{{ $matchedUnit->short_name }}</span>
                                                        @endif
                                                    </div>
                                                    @if($matchedUnit && $matchedUnit->category_type)
                                                        <span class="text-[10px] text-slate-400 dark:text-slate-400 group-hover/item:text-emerald-100 font-normal block">{{ $matchedUnit->category_type }}</span>
                                                    @endif
                                                </a>
                                            @endforeach

                                            <div class="border-t border-gray-100 dark:border-slate-800 mt-1 pt-1 px-4 py-1.5 bg-emerald-50/50 dark:bg-slate-850">
                                                <a href="{{ route('pendidikan.index') }}" class="text-xs font-black text-[#00843d] dark:text-emerald-400 hover:underline flex items-center justify-between">
                                                    <span>Lihat Semua Kurikulum &amp; Jenjang</span>
                                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                                </a>
                                            </div>

                                        @elseif($slug === 'layanan')
                                            @php
                                                $publicServices = $activeChildren->filter(function($c) use ($isSewaActive) {
                                                    $isS = str_contains($c->url, 'sewa-barang') || str_contains($c->name, 'Sewa');
                                                    if ($isS && ! $isSewaActive) {
                                                        return false;
                                                    }
                                                    return in_array(trim($c->url, '/'), ['izin-sekolah', 'permohonan-kerja-sama', 'sewa-barang'])
                                                        || str_contains($c->url, 'izin-sekolah')
                                                        || str_contains($c->url, 'permohonan-kerja-sama')
                                                        || str_contains($c->url, 'sewa-barang');
                                                });
                                                $totalPublicCount = $publicServices->count() ?: ($isSewaActive ? 3 : 2);
                                            @endphp
                                            <div class="px-4 py-2 bg-emerald-50/90 dark:bg-slate-800/90 border-b border-gray-100 dark:border-slate-800 flex items-center justify-between">
                                                <span class="text-[11px] font-black text-[#00843d] dark:text-emerald-400 uppercase tracking-wider flex items-center">
                                                    <i class="fa-solid fa-handshake-angle mr-1.5 text-amber-500"></i>
                                                    {{ $totalPublicCount }} Layanan Publik
                                                </span>
                                                <span class="text-[9px] bg-[#00843d] text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Online</span>
                                            </div>

                                            @php $isPublicDividerDone = false; @endphp
                                            @foreach($activeChildren as $child)
                                                @php
                                                    $isChildSewa = str_contains($child->url, 'sewa-barang') || str_contains($child->name, 'Sewa');
                                                    if ($isChildSewa && ! $isSewaActive) {
                                                        continue;
                                                    }
                                                    $childUrl = $formatNavUrl($child->url);
                                                    $isPublicService = in_array(trim($child->url, '/'), ['izin-sekolah', 'permohonan-kerja-sama', 'sewa-barang'])
                                                        || str_contains($child->url, 'izin-sekolah')
                                                        || str_contains($child->url, 'permohonan-kerja-sama')
                                                        || str_contains($child->url, 'sewa-barang');
                                                @endphp

                                                @if(! $isPublicService && ! $isPublicDividerDone && $loop->index >= 3)
                                                    @php $isPublicDividerDone = true; @endphp
                                                    <div class="border-t border-gray-100 dark:border-slate-800 my-1"></div>
                                                @endif

                                                @if($isPublicService)
                                                    <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block px-4 py-2.5 text-xs text-slate-700 dark:text-slate-200 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white transition group/item rounded-lg mx-1.5">
                                                        <div class="flex items-start">
                                                            <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950 text-[#00843d] dark:text-emerald-300 flex items-center justify-center shrink-0 mr-2.5 mt-0.5 group-hover/item:bg-white group-hover/item:text-[#00843d] transition">
                                                                <i class="{{ $child->icon ?: 'fa-solid fa-handshake-angle' }} text-xs"></i>
                                                            </div>
                                                            <div>
                                                                <span class="font-bold block text-slate-800 dark:text-slate-100 group-hover/item:text-white">{{ $child->name }}</span>
                                                                @if(str_contains($child->url, 'izin-sekolah'))
                                                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 group-hover/item:text-emerald-100 font-normal block">Studi banding, rombongan &amp; kunjungan dinas</span>
                                                                @elseif(str_contains($child->url, 'permohonan-kerja-sama'))
                                                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 group-hover/item:text-emerald-100 font-normal block">Kemitraan, magang &amp; MoU lembaga</span>
                                                                @elseif(str_contains($child->url, 'sewa-barang'))
                                                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 group-hover/item:text-emerald-100 font-normal block">Aula, gedung, perlengkapan &amp; sarana</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white transition flex items-center group/sub rounded-lg mx-1.5">
                                                        <i class="{{ $child->icon ?: 'fa-solid fa-circle-nodes' }} w-5 text-[#00843d] dark:text-emerald-400 group-hover/sub:text-white mr-2.5 text-sm"></i>
                                                        <span class="font-semibold text-slate-800 dark:text-slate-100 group-hover/sub:text-white">{{ $child->name }}</span>
                                                    </a>
                                                @endif
                                            @endforeach

                                        @else
                                            @foreach($activeChildren as $child)
                                                @php
                                                    $childUrl = $formatNavUrl($child->url);
                                                    $isAlumni = str_contains($child->url, 'ikarus') || str_contains(strtolower($child->name), 'ikarus');
                                                    $isYoutube = str_contains($child->icon ?? '', 'youtube');
                                                    $isTrophy = str_contains($child->icon ?? '', 'trophy');
                                                    $iconColor = $isAlumni ? 'text-amber-500' : ($isYoutube ? 'text-red-500' : ($isTrophy ? 'text-amber-500' : 'text-[#00843d] dark:text-emerald-400'));
                                                @endphp
                                                @if($loop->index > 0 && in_array(trim($child->url, '/'), ['dewan-guru', 'ikarus', 'galeri', 'karya-santri']))
                                                    <div class="border-t border-gray-100 dark:border-slate-800 my-1"></div>
                                                @endif
                                                <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white transition flex items-center group/sub rounded-lg mx-1.5">
                                                    @if($child->icon)
                                                        <i class="{{ $child->icon }} w-5 {{ $iconColor }} group-hover/sub:text-white mr-2 text-sm"></i>
                                                    @endif
                                                    <span class="font-semibold text-slate-800 dark:text-slate-100 group-hover/sub:text-white">{!! str_contains($child->name, '&') ? str_replace('&', '&amp;', str_replace('&amp;', '&', $child->name)) : e($child->name) !!}</span>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    {{-- Fallback Hardcoded Navigasi PPRU --}}
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl font-bold hover:bg-black/25 hover:text-[#fcd116] transition whitespace-nowrap {{ request()->routeIs('home') ? 'bg-black/25 text-[#fcd116] ring-1 ring-amber-400/40' : 'text-white' }}">
                        Beranda
                    </a>
                    <div id="nav-dropdown-profil" class="relative group py-2">
                        <button type="button" aria-haspopup="true" aria-expanded="false" class="px-3.5 py-2 rounded-xl font-bold inline-flex items-center hover:bg-black/25 hover:text-[#fcd116] transition whitespace-nowrap">
                            <span>Profil</span>
                            <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                        </button>
                    </div>
                @endif
            </nav>

            {{-- TOMBOL AKSI: DAFTAR PSB, LOGIN & THEME TOGGLE (ICON ONLY) --}}
            <div class="hidden lg:flex items-center space-x-2 xl:space-x-3 ml-2 flex-shrink-0">
                {{-- Theme Toggle Desktop (Icon Only, Clean Round Button) --}}
                <button id="theme-toggle" type="button" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer text-sm shadow-xs border border-white/10" aria-label="Ganti mode gelap atau terang" title="Ganti Mode Gelap / Terang">
                    <i id="theme-toggle-dark-icon" class="fa-solid fa-moon text-emerald-100"></i>
                    <i id="theme-toggle-light-icon" class="fa-solid fa-sun text-amber-300 hidden" style="display: none;"></i>
                </button>

                <a href="{{ route('ppdb.index') }}" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 px-4 xl:px-5 py-2 rounded-full text-xs font-black shadow-md hover:shadow-lg transition flex items-center space-x-1.5 transform hover:scale-105" aria-label="Penerimaan Santri Baru Pondok Pesantren Raudhatul Ulum">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                    <span>Daftar PSB</span>
                </a>
                <a href="/login" class="text-white/90 hover:text-white px-3 py-1.5 text-xs font-bold transition flex items-center space-x-1 rounded-xl hover:bg-black/20" aria-label="Login Admin">
                    <i class="fa-solid fa-lock text-[11px]"></i>
                    <span>Login</span>
                </a>
            </div>

            {{-- MOBILE TOP RIGHT: Theme Toggle (Icon Only) & Hamburger Menu --}}
            <div class="flex lg:hidden items-center space-x-1.5">
                {{-- Theme Toggle Mobile --}}
                <button id="mobile-theme-toggle" type="button" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center cursor-pointer transition" aria-label="Ganti mode gelap atau terang" title="Ganti Mode Gelap / Terang">
                    <i id="mobile-theme-toggle-dark-icon" class="fa-solid fa-moon text-emerald-100 text-sm"></i>
                    <i id="mobile-theme-toggle-light-icon" class="fa-solid fa-sun text-amber-300 text-sm hidden" style="display: none;"></i>
                </button>

                <button id="mobile-menu-toggle" type="button" class="text-white hover:text-emerald-100 p-2 rounded-lg focus:outline-none min-w-[44px] min-h-[44px] flex items-center justify-center cursor-pointer" aria-label="Buka Menu Navigasi">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU DRAWER --}}
    <div id="mobile-menu" class="hidden lg:hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 border-t-2 border-[#f59e0b] px-5 pt-4 pb-6 space-y-3 shadow-2xl max-h-[85vh] overflow-y-auto">
        <form action="{{ route('artikel.index') }}" method="GET" class="relative mb-3">
            <input type="text" name="q" placeholder="Cari informasi pesantren & artikel..." aria-label="Cari artikel" value="{{ request('q') }}" class="w-full bg-slate-100 dark:bg-slate-800 text-xs text-slate-800 dark:text-slate-100 rounded-full pl-9 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#00843d] border border-slate-200 dark:border-slate-700">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
        </form>

        @if($headerMenus->isNotEmpty())
            @foreach($headerMenus as $m)
                @php
                    $slug = Str::slug($m->name);
                    $mChildren = $m->children ? $m->children->where('is_active', true) : collect();
                    $mUrl = $formatNavUrl($m->url);
                    $isRootActive = ($m->url === '/' && request()->routeIs('home')) || (trim($m->url, '/') !== '' && request()->is(trim($m->url, '/') . '*'));
                @endphp
                @if($mChildren->isEmpty())
                    <a href="{{ $mUrl }}" target="{{ $m->target ?? '_self' }}" class="block px-3.5 py-2.5 rounded-xl font-bold text-slate-900 dark:text-slate-100 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white transition {{ $isRootActive ? 'bg-emerald-50 dark:bg-slate-800 text-[#00843d] dark:text-emerald-400' : '' }}">
                        @if($m->icon)
                            <i class="{{ $m->icon }} mr-2 text-[#00843d] dark:text-emerald-400"></i>
                        @else
                            <i class="fa-solid fa-house mr-2 text-[#00843d] dark:text-emerald-400"></i>
                        @endif
                        <span>{{ $m->name }}</span>
                    </a>
                @else
                    <details class="group">
                        <summary class="flex justify-between items-center px-3.5 py-2.5 rounded-xl font-bold text-slate-900 dark:text-slate-100 hover:bg-[#00843d] hover:text-white dark:hover:bg-[#00843d] dark:hover:text-white cursor-pointer list-none transition">
                            <span>
                                @if($m->icon)
                                    <i class="{{ $m->icon }} mr-2 text-[#00843d] dark:text-emerald-400"></i>
                                @else
                                    <i class="fa-solid fa-folder mr-2 text-[#00843d] dark:text-emerald-400"></i>
                                @endif
                                {{ $m->name }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-xs group-open:rotate-180 transition"></i>
                        </summary>
                        <div class="pl-6 pt-1 space-y-1 text-xs">
                            @if($slug === 'pendidikan')
                                <a href="{{ route('pendidikan.index') }}" class="block py-1.5 font-bold text-[#00843d] dark:text-emerald-400 hover:underline">Katalog Semua Unit</a>
                                @foreach($mChildren as $child)
                                    @php
                                        $childUrl = $formatNavUrl($child->url);
                                        $childSlug = last(explode('/', trim($child->url, '/')));
                                        $matchedUnit = $headerUnits->first(fn ($u) => $u->slug === $childSlug || $u->name === $child->name);
                                        $cleanName = $matchedUnit ? trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $matchedUnit->name)) : $child->name;
                                    @endphp
                                    <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block py-2 text-slate-600 dark:text-slate-300 hover:text-[#00843d] dark:hover:text-emerald-400 truncate flex items-center justify-between">
                                        <span>{{ $cleanName }}</span>
                                        @if($matchedUnit && $matchedUnit->short_name)
                                            <span class="text-[9px] bg-emerald-100 dark:bg-emerald-950 text-[#00843d] dark:text-emerald-300 px-1.5 py-0.5 rounded font-bold shrink-0 ml-1">{{ $matchedUnit->short_name }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            @elseif($slug === 'layanan')
                                @php
                                    $mPublicServices = $mChildren->filter(function($c) use ($isSewaActive) {
                                        $isS = str_contains($c->url, 'sewa-barang') || str_contains($c->name, 'Sewa');
                                        if ($isS && ! $isSewaActive) {
                                            return false;
                                        }
                                        return in_array(trim($c->url, '/'), ['izin-sekolah', 'permohonan-kerja-sama', 'sewa-barang'])
                                            || str_contains($c->url, 'izin-sekolah')
                                            || str_contains($c->url, 'permohonan-kerja-sama')
                                            || str_contains($c->url, 'sewa-barang');
                                    });
                                    $totalMPublicCount = $mPublicServices->count() ?: ($isSewaActive ? 3 : 2);
                                @endphp
                                <div class="pt-1 pb-1 text-[10px] font-black uppercase text-[#00843d] dark:text-emerald-400 tracking-wider flex items-center">
                                    <i class="fa-solid fa-star text-amber-500 mr-1 text-[9px]"></i> {{ $totalMPublicCount }} Layanan Publik
                                </div>
                                @php $isMobileDividerDone = false; @endphp
                                @foreach($mChildren as $child)
                                    @php
                                        $isChildSewa = str_contains($child->url, 'sewa-barang') || str_contains($child->name, 'Sewa');
                                        if ($isChildSewa && ! $isSewaActive) {
                                            continue;
                                        }
                                        $childUrl = $formatNavUrl($child->url);
                                        $isPublic = in_array(trim($child->url, '/'), ['izin-sekolah', 'permohonan-kerja-sama', 'sewa-barang'])
                                            || str_contains($child->url, 'izin-sekolah')
                                            || str_contains($child->url, 'permohonan-kerja-sama')
                                            || str_contains($child->url, 'sewa-barang');
                                    @endphp
                                    @if(! $isPublic && ! $isMobileDividerDone && $loop->index >= 3)
                                        @php $isMobileDividerDone = true; @endphp
                                        <div class="border-t border-slate-100 dark:border-slate-800 my-1 pt-1 text-[10px] font-black uppercase text-slate-400 tracking-wider">Layanan Lainnya</div>
                                    @endif
                                    <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block py-2 {{ $isPublic ? 'text-slate-800 dark:text-white font-bold' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#00843d] dark:hover:text-emerald-400 flex items-center">
                                        @if($child->icon)
                                            <i class="{{ $child->icon }} w-4 text-[#00843d] dark:text-emerald-400 mr-1.5 text-xs"></i>
                                        @endif
                                        <span>{{ $child->name }}</span>
                                    </a>
                                @endforeach
                            @else
                                @foreach($mChildren as $child)
                                    @php
                                        $childUrl = $formatNavUrl($child->url);
                                        $isAlumni = str_contains($child->url, 'ikarus') || str_contains(strtolower($child->name), 'ikarus');
                                    @endphp
                                    <a href="{{ $childUrl }}" target="{{ $child->target ?? '_self' }}" class="block py-2 {{ $isAlumni ? 'text-[#00843d] dark:text-emerald-400 font-semibold hover:underline' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#00843d] dark:hover:text-emerald-400 flex items-center">
                                        @if($child->icon)
                                            <i class="{{ $child->icon }} w-4 mr-1.5 text-xs {{ $isAlumni ? 'text-[#f59e0b]' : 'text-[#00843d] dark:text-emerald-400' }}"></i>
                                        @endif
                                        <span>{!! str_contains($child->name, '&') ? str_replace('&', '&amp;', str_replace('&amp;', '&', $child->name)) : e($child->name) !!}</span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </details>
                @endif
            @endforeach
        @endif

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col space-y-2">
            <a href="{{ route('ppdb.index') }}" class="block w-full text-center bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 font-black py-2.5 rounded-full text-xs shadow">
                <i class="fa-solid fa-graduation-cap mr-1"></i> Daftar PSB Online
            </a>
            <a href="/login" class="block w-full text-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold py-2 rounded-full text-xs">
                <i class="fa-solid fa-lock mr-1"></i> Login Portal
            </a>
        </div>
    </div>
</header>
