<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', ($siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum') . ' - ' . ($siteSettings['site_tagline'] ?? 'Basis Kaderisasi Generasi Terbaik (Khoiru Ummah)'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['site_description'] ?? 'Official Website Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga, Ogan Ilir, Sumatera Selatan. Pesantren modern terpadu berasrama dengan muadalah Al-Azhar Kairo Mesir.')">
    <meta name="keywords" content="@yield('meta_keywords', $siteSettings['meta_keywords'] ?? 'pondok pesantren raudhatul ulum, ppru sakatiga, pesantren ogan ilir, santri sakatiga, psb ppru, muadalah al azhar, pondok pesantren sumsel')">
    <meta name="author" content="Pondok Pesantren Raudhatul Ulum Sakatiga">
    <meta name="robots" content="index, follow">
    @if(!empty($siteSettings['google_site_verification']))
    <meta name="google-site-verification" content="{{ $siteSettings['google_site_verification'] }}">
    @endif

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'Pondok Pesantren Raudhatul Ulum' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', $siteSettings['og_title'] ?? 'Pondok Pesantren Raudhatul Ulum'))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', $siteSettings['og_description'] ?? $siteSettings['site_description'] ?? 'Pondok Pesantren Raudhatul Ulum Sakatiga Ogan Ilir Sumatera Selatan.'))">
    <meta property="og:image" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ppru-banner.png'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ppru-banner.png'))">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="{{ $siteSettings['twitter_card'] ?? 'summary_large_image' }}">
    <meta name="twitter:site" content="@ppru_sakatiga">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', $siteSettings['og_title'] ?? 'Pondok Pesantren Raudhatul Ulum'))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', $siteSettings['og_description'] ?? $siteSettings['site_description'] ?? 'Official Website Pondok Pesantren Raudhatul Ulum'))">
    <meta name="twitter:image" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ppru-banner.png'))">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset($siteSettings['site_favicon'] ?? '/uploads/logo-ppru-square.png') }}">

    {{-- Google Fonts Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    {{-- FontAwesome 6 Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-arabic { font-family: 'Amiri', serif; }
        .ql-align-center, [style*="text-align: center"] { text-align: center !important; }
        .ql-align-right, [style*="text-align: right"] { text-align: right !important; }
        .ql-align-left, [style*="text-align: left"] { text-align: left !important; }
        .ql-align-justify, [style*="text-align: justify"] { text-align: justify !important; text-justify: inter-word; }
        .prose-content { text-align: justify; text-justify: inter-word; }
        .prose-content p { margin-bottom: 1.25rem; line-height: 1.85; text-align: justify; text-justify: inter-word; }
        .prose-content img { margin-left: auto !important; margin-right: auto !important; display: block; border-radius: 1rem; max-width: 100%; height: auto; }
        @media (min-width: 768px) {
            .footer-address-col, .footer-address-col * { text-align: left !important; }
            .footer-address-col { align-items: flex-start !important; }
            .footer-address-col div { justify-content: flex-start !important; align-items: flex-start !important; }
            .footer-address-col .flex { justify-content: flex-start !important; }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen font-sans selection:bg-school-green selection:text-white">

    {{-- MAINTENANCE MODE BANNER FOR LOGGED IN ADMIN --}}
    @auth
        @if(\App\Models\Setting::get('maintenance_mode', '0') === '1')
            <div class="bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 text-white text-xs font-semibold py-2.5 px-4 shadow-md sticky top-0 z-[100] border-b border-amber-500">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                    <div class="flex items-center gap-2 text-center sm:text-left">
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/20 text-white shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-[11px]"></i>
                        </span>
                        <span>
                            <strong class="font-bold">MODE MAINTENANCE AKTIF:</strong> Website saat ini ditutup untuk pengunjung umum dan hanya dapat dilihat oleh Anda sebagai Administrator.
                        </span>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="bg-white text-amber-900 hover:bg-amber-100 px-3 py-1 rounded-lg text-[11px] font-bold shadow-xs transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-gauge text-[10px]"></i>
                            <span>Kelola di Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- HEADER --}}
    @include('partials.header')

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-emerald-50 border-l-4 border-school-green p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check text-school-green text-lg mr-3"></i>
                    <p class="text-sm font-medium text-emerald-900">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-sm min-w-[36px] min-h-[36px] flex items-center justify-center" aria-label="Tutup notifikasi">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-lg mr-3" aria-hidden="true"></i>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 text-sm min-w-[36px] min-h-[36px] flex items-center justify-center" aria-label="Tutup notifikasi error">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- FLOATING MULTI-BAHASA (Kiri Bawah) --}}
    <div class="gtranslate_wrapper"></div>
    <script>
        window.gtranslateSettings = {
            "default_language": "id",
            "languages": ["id", "ar", "en"],
            "wrapper_selector": ".gtranslate_wrapper",
            "switcher_horizontal_position": "left",
            "switcher_vertical_position": "bottom",
            "float_switcher_open_direction": "top",
            "flag_style": "3d"
        };
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>

    {{-- FLOATING WHATSAPP HELPDESK WIDGET (Kanan Bawah) --}}
    <div x-data="{ openHelpdesk: false }" class="fixed bottom-5 right-5 z-40 flex flex-col items-end">
        {{-- Chat Bubble Popover --}}
        <div x-show="openHelpdesk"
             x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
             x-transition:enter-start="opacity-0 scale-90 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-2"
             @click.away="openHelpdesk = false"
             class="mb-3 w-80 sm:w-88 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden text-left"
             style="display: none;">
            {{-- Header Chat Box --}}
            <div class="bg-gradient-to-r from-school-green to-emerald-700 text-white p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <img src="{{ asset('/uploads/logo-ppru-square.png') }}" alt="Logo PPRU" class="w-10 h-10 rounded-full bg-white p-0.5 shadow">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm leading-tight">Helpdesk PPRU Sakatiga</h4>
                        <p class="text-[11px] text-green-100 flex items-center gap-1 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-300 inline-block animate-pulse"></span>
                            Online | Siap Membantu
                        </p>
                    </div>
                </div>
                <button @click="openHelpdesk = false" class="text-white/80 hover:text-white text-lg cursor-pointer w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/10" aria-label="Tutup Chat">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            {{-- Body Chat --}}
            <div class="p-4 bg-slate-50 space-y-3 text-xs text-gray-700">
                <div class="bg-white p-3 rounded-xl rounded-tl-none shadow-xs border border-gray-100 leading-relaxed">
                    <p class="font-semibold text-school-green mb-1">Assalamu'alaikum Warahmatullahi Wabarakatuh 👋</p>
                    <p>Selamat datang di layanan informasi resmi Pondok Pesantren Raudhatul Ulum Sakatiga. Ada yang bisa kami bantu seputar pendaftaran santri baru (PSB), biaya, kurikulum, atau kunjungan pesantren?</p>
                </div>
                <div class="text-center">
                    <span class="text-[10px] text-gray-400">Biasanya merespon dalam beberapa menit</span>
                </div>
            </div>
            {{-- Footer Action --}}
            <div class="p-3 bg-white border-t border-gray-100">
                @php
                    $waHelpNumber = preg_replace('/[^0-9]/', '', $siteSettings['site_phone'] ?? '081278901950');
                    if (str_starts_with($waHelpNumber, '0')) {
                        $waHelpNumber = '62' . substr($waHelpNumber, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $waHelpNumber }}?text={{ urlencode('Assalamu\'alaikum, saya ingin bertanya seputar informasi Pondok Pesantren Raudhatul Ulum Sakatiga.') }}"
                   target="_blank"
                   class="w-full bg-[#25D366] hover:bg-[#1EBE5D] text-white py-2.5 px-4 rounded-xl font-bold text-xs flex items-center justify-center space-x-2 shadow-md transition transform hover:scale-102">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Mulai Chat WhatsApp</span>
                </a>
            </div>
        </div>

        {{-- Floating Button Launcher (Bulat, Tidak Terlalu Besar) --}}
        <div class="flex items-center">
            <button @click="openHelpdesk = !openHelpdesk"
                    class="group flex items-center justify-center bg-[#25D366] hover:bg-[#1EBE5D] text-white w-12 h-12 rounded-full shadow-2xl transition duration-300 transform hover:scale-110 cursor-pointer relative"
                    aria-label="Buka Bantuan WhatsApp"
                    title="Konsultasi WhatsApp">
                <span class="absolute top-0.5 right-0.5 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                <i class="fa-brands fa-whatsapp text-2xl"></i>
            </button>
        </div>
    </div>

    {{-- FLOATING BACK TO TOP BUTTON (Stacked di atas WhatsApp jika di scroll) --}}
    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-20 right-5 z-30 bg-school-green hover:bg-emerald-800 text-white w-10 h-10 rounded-full shadow-xl flex items-center justify-center transition-all opacity-0 pointer-events-none duration-300 cursor-pointer border-2 border-white" aria-label="Kembali ke atas halaman">
        <i class="fa-solid fa-chevron-up text-xs" aria-hidden="true"></i>
    </button>

    {{-- GLOBAL SCRIPTS --}}
    <script>
        // Mobile Menu Toggle
        const mobileBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Smooth Grace-Period Hover & Click for Desktop Dropdowns
        document.querySelectorAll('.group[id^="nav-dropdown-"]').forEach(drop => {
            const btn = drop.querySelector('button');
            const menu = drop.querySelector('.absolute');
            let hideTimer = null;

            if (btn && menu) {
                const showMenu = () => {
                    clearTimeout(hideTimer);
                    menu.classList.remove('hidden');
                };

                const hideMenu = () => {
                    hideTimer = setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 220);
                };

                drop.addEventListener('mouseenter', showMenu);
                drop.addEventListener('mouseleave', hideMenu);

                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    menu.classList.toggle('hidden');
                });
            }
        });

        // Back to Top button visibility
        const backToTopBtn = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                backToTopBtn.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
                backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // Fast Snappy Scroll-Triggered Fade-Up Observer
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal-fade-up');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '0px 0px -20px 0px'
                });

                // Observe all elements
                reveals.forEach(el => observer.observe(el));

                // Trigger fast fade-up on initial viewport elements after initial paint
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        reveals.forEach(el => {
                            const rect = el.getBoundingClientRect();
                            if (rect.top < window.innerHeight && rect.bottom >= 0) {
                                el.classList.add('is-revealed');
                                observer.unobserve(el);
                            }
                        });
                    }, 60);
                });
            } else {
                reveals.forEach(el => el.classList.add('is-revealed'));
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
