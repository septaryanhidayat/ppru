<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', ($siteSettings['site_name'] ?? 'SMA Islam Terpadu Ishlahul Ummah Prabumulih') . ' - ' . ($siteSettings['site_tagline'] ?? 'Tanggap, Tangkas dan Tangguh Menuju Indonesia Emas'))</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['site_description'] ?? 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih (SMA IT Ishum). Sekolah Islam Terpadu pertama di Prabumulih yang tergabung dalam JSIT.')">
    <meta name="keywords" content="@yield('meta_keywords', $siteSettings['meta_keywords'] ?? 'sma it ishlahul ummah prabumulih, sma it ishum, sma islam terpadu prabumulih, jsit prabumulih, ppdb sma it ishum, tahfidz prabumulih')">
    <meta name="author" content="SMA Islam Terpadu Ishlahul Ummah Prabumulih">
    <meta name="robots" content="index, follow">
    @if(!empty($siteSettings['google_site_verification']))
    <meta name="google-site-verification" content="{{ $siteSettings['google_site_verification'] }}">
    @endif

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'SMA Islam Terpadu Ishlahul Ummah Prabumulih' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', $siteSettings['og_title'] ?? 'SMA Islam Terpadu Ishlahul Ummah Prabumulih'))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', $siteSettings['og_description'] ?? $siteSettings['site_description'] ?? 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih.'))">
    <meta property="og:image" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ishum-square.png'))">
    <meta property="og:image:secure_url" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ishum-square.png'))">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="{{ $siteSettings['twitter_card'] ?? 'summary_large_image' }}">
    <meta name="twitter:site" content="@smait_ishum">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('title', $siteSettings['og_title'] ?? 'SMA Islam Terpadu Ishlahul Ummah Prabumulih'))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', $siteSettings['og_description'] ?? $siteSettings['site_description'] ?? 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih'))">
    <meta name="twitter:image" content="@yield('og_image', asset($siteSettings['og_image'] ?? '/uploads/logo-ishum-square.png'))">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset($siteSettings['site_favicon'] ?? '/uploads/logo-ishum-square.png') }}">

    {{-- Google Fonts Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- FontAwesome 6 Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .ql-align-center, [style*="text-align: center"] { text-align: center !important; }
        .ql-align-right, [style*="text-align: right"] { text-align: right !important; }
        .ql-align-justify, [style*="text-align: justify"] { text-align: justify !important; text-justify: inter-word; }
        .prose-content { text-align: justify; text-justify: inter-word; }
        .prose-content p { margin-bottom: 1.25rem; line-height: 1.85; text-align: justify; text-justify: inter-word; }
        .prose-content img { margin-left: auto !important; margin-right: auto !important; display: block; border-radius: 1rem; max-width: 100%; height: auto; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- HEADER --}}
    @include('partials.header')

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-check text-green-600 text-lg mr-3"></i>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 text-sm min-w-[36px] min-h-[36px] flex items-center justify-center" aria-label="Tutup notifikasi">
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

    {{-- FLOATING BACK TO TOP BUTTON (Kanan Bawah - Warna Hijau Sekolah) --}}
    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-5 right-5 z-50 bg-[#00913e] hover:bg-[#007532] text-white w-12 h-12 rounded-full shadow-2xl flex items-center justify-center transition-all opacity-0 pointer-events-none duration-300 cursor-pointer" aria-label="Kembali ke atas halaman">
        <i class="fa-solid fa-chevron-up text-sm" aria-hidden="true"></i>
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
                    rootMargin: '0px 0px -25px 0px'
                });

                reveals.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom >= 0) {
                        el.classList.add('is-revealed');
                    } else {
                        observer.observe(el);
                    }
                });
            } else {
                reveals.forEach(el => el.classList.add('is-revealed'));
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
