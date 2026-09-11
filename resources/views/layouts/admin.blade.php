<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - SMA IT Ishlahul Ummah Prabumulih</title>
    <link rel="icon" type="image/svg+xml" href="/uploads/logo-ishum-square.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    {{-- Quill.js WYSIWYG Editor Assets --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #e2e8f0;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            background-color: #ffffff;
            min-height: 200px;
            max-height: 480px;
            overflow-y: auto;
        }
        .ql-editor {
            min-height: 200px;
            max-height: 480px;
            overflow-y: auto;
            line-height: 1.65 !important;
            padding: 16px 20px !important;
        }
        .ql-editor p {
            margin-bottom: 0.75rem !important;
        }
        .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4 {
            margin-top: 1.25rem !important;
            margin-bottom: 0.5rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .ql-editor ul, .ql-editor ol {
            padding-left: 1.25rem !important;
            margin-bottom: 0.75rem !important;
        }
        .ql-editor li {
            margin-bottom: 0.25rem !important;
        }
    </style>
</head>
<body class="bg-[#f8fafc] font-['Poppins',sans-serif] text-slate-800 flex min-h-screen antialiased">

    {{-- SIDEBAR DESKTOP --}}
    <aside id="sidebar" class="w-72 bg-[#0b1120] text-slate-300 flex flex-col justify-between flex-shrink-0 border-r border-slate-800 transition-all duration-300 z-30 hidden md:flex">
        <div class="overflow-y-auto max-h-[calc(100vh-80px)] custom-scrollbar">
            
            {{-- Brand Logo Header --}}
            <div class="h-20 flex items-center px-6 border-b border-slate-800/80 bg-[#070b14]/50">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-md group-hover:scale-105 transition">
                        <img src="/uploads/logo-ishum-square.png" alt="Logo Ishum" class="h-8 w-auto object-contain">
                    </div>
                    <div>
                        <span class="font-black text-white text-base tracking-tight block">ADMIN ISHUM</span>
                        <span class="text-[10px] text-[#da251c] font-semibold tracking-wider uppercase block">Control Center</span>
                    </div>
                </a>
            </div>

            {{-- Navigation Sections --}}
            <nav class="p-4 space-y-6 text-xs font-medium">
                
                {{-- SECTION 1: UTAMA --}}
                <div class="space-y-1">
                    <span class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Utama</span>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high text-sm w-4 text-center"></i>
                        <span>Dashboard Utama</span>
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.analytics*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-chart-line text-sm w-4 text-center text-cyan-400"></i>
                        <span>Analitik Pengunjung</span>
                    </a>

                    <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.posts*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-newspaper text-sm w-4 text-center"></i>
                        <span>Berita & Artikel</span>
                    </a>

                    <a href="{{ route('admin.pages.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.pages*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-file-lines text-sm w-4 text-center"></i>
                        <span>Halaman Profil Statis</span>
                    </a>

                    <a href="{{ route('admin.quick-menus.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.quick-menus*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-compass text-sm w-4 text-center"></i>
                        <span>Menu Cepat Beranda</span>
                    </a>
                </div>

                {{-- SECTION 2: PENDIDIK & SARANA --}}
                <div class="space-y-1">
                    <span class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Pendidik &amp; Fasilitas</span>
                    
                    <a href="{{ route('admin.dewan.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dewan*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-chalkboard-user text-sm w-4 text-center"></i>
                        <span>Dewan Guru &amp; GTK</span>
                    </a>

                    <a href="{{ route('admin.bidang.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.bidang*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group text-sm w-4 text-center"></i>
                        <span>Fasilitas &amp; Sarana</span>
                    </a>

                    <a href="{{ route('admin.dpc.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dpc*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-star-and-crescent text-sm w-4 text-center"></i>
                        <span>Program Unggulan</span>
                    </a>
                </div>

                {{-- SECTION 3: PUBLIKASI & MEDIA --}}
                <div class="space-y-1">
                    <span class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Publikasi & Media</span>
                    
                    <a href="{{ route('admin.media.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.media*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-photo-film text-sm w-4 text-center"></i>
                        <span>Galeri Foto & Video</span>
                    </a>

                    <a href="{{ route('admin.agenda.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.agenda*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-calendar-days text-sm w-4 text-center"></i>
                        <span>Agenda & Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.downloads.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.downloads*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-download text-sm w-4 text-center"></i>
                        <span>Download Center</span>
                    </a>
                </div>

                {{-- SECTION 4: INTERAKSI --}}
                <div class="space-y-1">
                    <span class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Interaksi</span>
                    
                    <a href="{{ route('admin.testimonials.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.testimonials*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-comments text-sm w-4 text-center"></i>
                        <span>Testimonial Masyarakat</span>
                    </a>

                    <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.feedbacks*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-inbox text-sm w-4 text-center"></i>
                            <span>Kotak Aspirasi / Kritik</span>
                        </div>
                        @php $unread = \App\Models\Feedback::where('status', 'unread')->count(); @endphp
                        @if($unread > 0)
                            <span class="bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                </div>

                {{-- SECTION 5: SISTEM, KEAMANAN & SEO --}}
                <div class="space-y-1">
                    <span class="px-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Sistem & Keamanan</span>
                    
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-sliders text-sm w-4 text-center"></i>
                        <span>Pengaturan & SEO</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-users-gear text-sm w-4 text-center"></i>
                        <span>Pengguna & Role</span>
                    </a>

                    <a href="{{ route('admin.security.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.security*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-shield-halved text-sm w-4 text-center"></i>
                            <span>Log & Keamanan</span>
                        </div>
                        @php $dangerCount = \App\Models\ActivityLog::where('status', 'danger')->count(); @endphp
                        @if($dangerCount > 0)
                            <span class="bg-red-600 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">
                                {{ $dangerCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.backup.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl transition {{ request()->routeIs('admin.backup*') ? 'bg-gradient-to-r from-[#ff5001] to-[#ff6a00] text-white font-bold shadow-md shadow-orange-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-database text-sm w-4 text-center"></i>
                        <span>Backup Database</span>
                    </a>
                </div>

            </nav>
        </div>

        {{-- User info & Logout --}}
        <div class="p-4 border-t border-slate-800/80 bg-[#070b14]/50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#ff5001] to-amber-500 text-white flex items-center justify-center font-bold text-sm shadow flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span class="inline-block text-[10px] px-2 py-0.2 font-semibold rounded bg-slate-800 text-amber-400 mt-0.5">
                            {{ auth()->user()->role_label ?? 'Administrator' }}
                        </span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-400 p-2 text-sm rounded-lg hover:bg-slate-800/50 transition cursor-pointer" title="Keluar dari Akun">
                        <i class="fa-solid fa-power-off"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-grow flex flex-col min-w-0">
        
        {{-- Top Header Bar --}}
        <header class="bg-white border-b border-slate-200/80 h-18 flex items-center justify-between px-6 sm:px-8 z-10 shadow-xs sticky top-0">
            <div class="flex items-center space-x-4">
                <button id="mobile-toggle" class="md:hidden text-slate-600 hover:text-slate-900 p-2 text-lg">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h1 class="font-extrabold text-lg sm:text-xl text-slate-800 tracking-tight">@yield('header_title', 'Panel Kontrol')</h1>
                    <p class="text-[11px] text-slate-400">SMA Islam Terpadu Ishlahul Ummah Prabumulih</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                <a href="{{ route('admin.posts.create') }}" class="hidden sm:inline-flex items-center space-x-2 bg-[#ff5001] hover:bg-[#e04500] text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md transition">
                    <i class="fa-solid fa-pen-nib text-xs"></i>
                    <span>Tulis Berita</span>
                </a>

                <a href="{{ route('admin.backup.download') }}" class="hidden md:inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-download text-xs text-amber-400"></i>
                    <span>Backup SQL</span>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="text-xs text-slate-600 hover:text-[#ff5001] bg-slate-100 hover:bg-orange-50 px-3.5 py-2 rounded-xl transition flex items-center space-x-1.5 font-medium border border-slate-200">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#ff5001]"></i>
                    <span>Kunjungi Situs</span>
                </a>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mx-6 sm:mx-8 mt-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl shadow-xs flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                    <p class="text-xs sm:text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 sm:mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-xs flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 text-base"></i>
                    <p class="text-xs sm:text-sm font-semibold text-red-800">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Main Content Page --}}
        <main class="p-6 sm:p-8 flex-grow">
            @yield('content')
        </main>
    </div>

    {{-- Quill.js Automatic Initializer Script for Elements with [data-quill] --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function cleanHtmlForQuill(html) {
                if (!html) return '';
                // 1. Remove WordPress Gutenberg block comments
                let cleaned = html.replace(/<!--\s*\/?wp:[^>]*-->/gi, '');
                // 2. Collapse newlines between HTML tags to prevent white-space: pre-wrap expansion
                cleaned = cleaned.replace(/>\s*\n+\s*</g, '><');
                // 3. Normalize multiple empty paragraphs
                cleaned = cleaned.replace(/(<p>\s*(<br\s*\/?>|&nbsp;)?\s*<\/p>\s*){2,}/gi, '<p><br></p>');
                return cleaned.trim();
            }

            // Automatic Rich Text Editor Initializer
            document.querySelectorAll('[data-quill]').forEach(function(editorEl) {
                const targetInputId = editorEl.getAttribute('data-quill');
                const targetInput = document.getElementById(targetInputId);
                
                if (targetInput) {
                    const quill = new Quill(editorEl, {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, 3, 4, false] }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{ 'align': [] }, { 'align': 'center' }, { 'align': 'right' }, { 'align': 'justify' }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['blockquote', 'code-block'],
                                ['link', 'image', 'video'],
                                [{ 'color': [] }, { 'background': [] }],
                                ['clean']
                            ]
                        }
                    });

                    // Set initial content (cleaned)
                    if (targetInput.value) {
                        quill.root.innerHTML = cleanHtmlForQuill(targetInput.value);
                    }

                    // Sync on change
                    quill.on('text-change', function() {
                        targetInput.value = quill.root.innerHTML;
                    });

                    // Ensure synced before form submit
                    const form = targetInput.closest('form');
                    if (form) {
                        form.addEventListener('submit', function() {
                            targetInput.value = quill.root.innerHTML;
                        });
                    }
                }
            });

            // Mobile sidebar toggle
            const toggleBtn = document.getElementById('mobile-toggle');
            const sidebar = document.getElementById('sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('fixed');
                    sidebar.classList.toggle('inset-0');
                });
            }
        });
    </script>
</body>
</html>
