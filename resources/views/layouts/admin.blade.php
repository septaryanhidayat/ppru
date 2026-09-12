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

    {{-- SweetAlert2 Assets --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Word-like Ribbon Toolbar Styling */
        .ql-toolbar.ql-snow {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            border-color: #cbd5e1;
            background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
            padding: 10px 14px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
        }
        .ql-toolbar.ql-snow .ql-formats {
            margin-right: 12px;
            padding-right: 12px;
            border-right: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        .ql-toolbar.ql-snow .ql-formats:last-child {
            border-right: none;
        }
        .ql-toolbar.ql-snow button {
            border-radius: 6px;
            transition: all 0.15s ease;
            width: 28px;
            height: 28px;
        }
        .ql-toolbar.ql-snow button:hover {
            background-color: #e2e8f0;
        }
        .ql-toolbar.ql-snow button.ql-active {
            background-color: #00913e !important;
            color: white !important;
        }
        .ql-toolbar.ql-snow button.ql-active svg .ql-stroke {
            stroke: #ffffff !important;
        }
        .ql-toolbar.ql-snow button.ql-active svg .ql-fill {
            fill: #ffffff !important;
        }
        .ql-toolbar.ql-snow .ql-picker-label {
            border-radius: 6px;
        }
        .ql-toolbar.ql-snow .ql-picker-label:hover {
            background-color: #e2e8f0;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            border-color: #cbd5e1;
            font-family: 'Poppins', sans-serif;
            font-size: 0.875rem;
            background-color: #ffffff;
            min-height: 280px;
            max-height: 580px;
            overflow-y: auto;
        }
        .ql-editor {
            min-height: 280px;
            max-height: 580px;
            overflow-y: auto;
            line-height: 1.8 !important;
            padding: 20px 24px !important;
            color: #1e293b;
        }
        .ql-editor .ql-align-center { text-align: center; }
        .ql-editor .ql-align-right { text-align: right; }
        .ql-editor .ql-align-justify { text-align: justify; }
        .ql-editor p {
            margin-bottom: 1rem !important;
        }
        .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4 {
            margin-top: 1.5rem !important;
            margin-bottom: 0.75rem !important;
            font-weight: 700 !important;
            color: #0f172a !important;
        }
        .ql-editor ul, .ql-editor ol {
            padding-left: 1.5rem !important;
            margin-bottom: 1rem !important;
        }
        .ql-editor li {
            margin-bottom: 0.35rem !important;
        }
        /* Sidebar Styling & Smooth Collapsing */
        #sidebar {
            scrollbar-width: none;
            -ms-overflow-style: none;
            transition: width 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar::-webkit-scrollbar {
            display: none;
        }
        html.sidebar-init-collapsed #sidebar,
        #sidebar.collapsed {
            width: 4.5rem !important; /* 72px */
        }
        html.sidebar-init-collapsed #sidebar .sidebar-label,
        html.sidebar-init-collapsed #sidebar .sidebar-brand-text,
        html.sidebar-init-collapsed #sidebar .sidebar-badge,
        html.sidebar-init-collapsed #sidebar .sidebar-section-title,
        html.sidebar-init-collapsed #sidebar .sidebar-user-text,
        #sidebar.collapsed .sidebar-label,
        #sidebar.collapsed .sidebar-brand-text,
        #sidebar.collapsed .sidebar-badge,
        #sidebar.collapsed .sidebar-section-title,
        #sidebar.collapsed .sidebar-user-text {
            display: none !important;
        }
        #sidebar.collapsed .sidebar-header {
            justify-content: center !important;
            padding: 0.75rem 0.25rem !important;
            flex-direction: column !important;
            height: auto !important;
            gap: 0.35rem !important;
        }
        #sidebar.collapsed .sidebar-item {
            justify-content: center !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        #sidebar.collapsed .sidebar-item i {
            margin-right: 0 !important;
            font-size: 0.95rem !important;
        }
        #sidebar.collapsed .sidebar-user-card {
            padding: 0.5rem !important;
            background: transparent !important;
            border-color: rgba(51, 65, 85, 0.4) !important;
        }
        #sidebar.collapsed .sidebar-user-card .flex {
            flex-direction: column !important;
            gap: 0.5rem !important;
            align-items: center !important;
        }
        #sidebar.collapsed .sidebar-section-divider {
            border-top: 1px solid rgba(51, 65, 85, 0.5);
            margin: 0.5rem 0.25rem;
            display: block;
        }
    </style>
    <script>
        if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
            document.documentElement.classList.add('sidebar-init-collapsed');
        }
    </script>
</head>
<body class="bg-[#f8fafc] font-['Poppins',sans-serif] text-slate-800 flex min-h-screen antialiased">

    {{-- SIDEBAR DESKTOP --}}
    <aside id="sidebar" class="w-64 bg-[#0b1120] text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800 z-30 hidden md:flex sticky top-0 h-screen">
        
        {{-- Brand Logo Header with Minimize Toggle --}}
        <div class="sidebar-header h-16 flex items-center justify-between px-4 border-b border-slate-800/80 bg-[#070b14]/50 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5 group min-w-0" title="Admin Ishum Control Center">
                <div class="w-9 h-9 rounded-xl bg-white p-1 flex items-center justify-center shadow-md group-hover:scale-105 transition flex-shrink-0">
                    <img src="/uploads/logo-ishum-square.png" alt="Logo Ishum" class="h-7 w-auto object-contain">
                </div>
                <div class="sidebar-brand-text min-w-0">
                    <span class="font-black text-white text-sm tracking-tight block truncate">ADMIN ISHUM</span>
                    <span class="text-[9px] text-[#da251c] font-semibold tracking-wider uppercase block">Control Center</span>
                </div>
            </a>
            <button id="sidebar-collapse-btn" class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition cursor-pointer flex-shrink-0" title="Perkecil / Perbesar Sidebar">
                <i id="sidebar-collapse-icon" class="fa-solid fa-angles-left text-xs"></i>
            </button>
        </div>

        {{-- Scrollable Navigation Wrapper --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 flex flex-col">
            <nav class="space-y-3.5 text-xs font-medium">
                
                {{-- SECTION 1: UTAMA --}}
                <div class="space-y-0.5">
                    <span class="sidebar-section-title px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase block py-0.5">Utama</span>
                    <div class="sidebar-section-divider hidden"></div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Dashboard Utama">
                        <i class="fa-solid fa-gauge-high text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Dashboard Utama</span>
                    </a>

                    <a href="{{ route('admin.analytics.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.analytics*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Analitik Pengunjung">
                        <i class="fa-solid fa-chart-line text-xs w-4 text-center text-cyan-400"></i>
                        <span class="sidebar-label">Analitik Pengunjung</span>
                    </a>

                    <a href="{{ route('admin.posts.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.posts*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Berita & Artikel">
                        <i class="fa-solid fa-newspaper text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Berita &amp; Artikel</span>
                    </a>

                    <a href="{{ route('admin.pages.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.pages*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Halaman Profil Statis">
                        <i class="fa-solid fa-file-lines text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Halaman Profil Statis</span>
                    </a>

                    <a href="{{ route('admin.quick-menus.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.quick-menus*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Menu Cepat Beranda">
                        <i class="fa-solid fa-compass text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Menu Cepat Beranda</span>
                    </a>
                </div>

                {{-- SECTION 2: PENDIDIK & SARANA --}}
                <div class="space-y-0.5">
                    <span class="sidebar-section-title px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase block py-0.5">Pendidik &amp; Fasilitas</span>
                    <div class="sidebar-section-divider hidden"></div>
                    
                    <a href="{{ route('admin.dewan.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.dewan*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Dewan Guru & GTK">
                        <i class="fa-solid fa-chalkboard-user text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Dewan Guru &amp; GTK</span>
                    </a>

                    <a href="{{ route('admin.bidang.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.bidang*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Fasilitas & Sarana">
                        <i class="fa-solid fa-layer-group text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Fasilitas &amp; Sarana</span>
                    </a>

                    <a href="{{ route('admin.dpc.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.dpc*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Program Unggulan">
                        <i class="fa-solid fa-star-and-crescent text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Program Unggulan</span>
                    </a>
                </div>

                {{-- SECTION 3: PUBLIKASI & MEDIA --}}
                <div class="space-y-0.5">
                    <span class="sidebar-section-title px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase block py-0.5">Publikasi &amp; Media</span>
                    <div class="sidebar-section-divider hidden"></div>
                    
                    <a href="{{ route('admin.popup.index') }}" class="sidebar-item flex items-center justify-between px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.popup*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Popup Banner Beranda">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-bullhorn text-xs w-4 text-center text-amber-300"></i>
                            <span class="sidebar-label">Popup Banner Beranda</span>
                        </div>
                        @if(\App\Models\Setting::get('popup_active', '1') == '1')
                            <span class="sidebar-badge w-2 h-2 rounded-full bg-emerald-400 animate-pulse" title="Popup Aktif"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.media.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.media*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Galeri Foto & Video">
                        <i class="fa-solid fa-photo-film text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Galeri Foto &amp; Video</span>
                    </a>

                    <a href="{{ route('admin.agenda.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.agenda*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Agenda & Pengumuman">
                        <i class="fa-solid fa-calendar-days text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Agenda &amp; Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.posts.index', ['type' => 'prestasi']) }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request('type') === 'prestasi' ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Prestasi Siswa">
                        <i class="fa-solid fa-trophy text-xs w-4 text-center text-amber-400"></i>
                        <span class="sidebar-label">Prestasi Siswa</span>
                    </a>

                    <a href="{{ route('admin.posts.index', ['type' => 'ekskul']) }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request('type') === 'ekskul' ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Ekstrakurikuler">
                        <i class="fa-solid fa-people-group text-xs w-4 text-center text-emerald-400"></i>
                        <span class="sidebar-label">Ekstrakurikuler</span>
                    </a>

                    <a href="{{ route('admin.posts.index', ['type' => 'alumni']) }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request('type') === 'alumni' ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Data Alumni">
                        <i class="fa-solid fa-user-graduate text-xs w-4 text-center text-cyan-400"></i>
                        <span class="sidebar-label">Data Alumni</span>
                    </a>

                    <a href="{{ route('admin.downloads.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.downloads*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Download Center">
                        <i class="fa-solid fa-download text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Download Center</span>
                    </a>
                </div>

                {{-- SECTION 4: INTERAKSI & PPDB --}}
                <div class="space-y-0.5">
                    <span class="sidebar-section-title px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase block py-0.5">Interaksi &amp; PPDB</span>
                    <div class="sidebar-section-divider hidden"></div>

                    <a href="{{ route('admin.ppdb.index') }}" class="sidebar-item flex items-center justify-between px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.ppdb.index') || request()->routeIs('admin.ppdb.show') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Pendaftar PPDB">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-graduation-cap text-xs w-4 text-center text-amber-300"></i>
                            <span class="sidebar-label font-bold">Pendaftar PPDB</span>
                        </div>
                        @php $pendingPpdb = \App\Models\PpdbRegistration::where('status', 'pending')->count(); @endphp
                        @if($pendingPpdb > 0)
                            <span class="sidebar-badge bg-amber-400 text-slate-900 text-[10px] px-1.5 py-0.2 rounded-full font-bold">
                                {{ $pendingPpdb }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.ppdb.content') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.ppdb.content*') ? 'bg-gradient-to-r from-[#00913e] to-[#05a849] text-white font-bold shadow-md' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Kelola Halaman PPDB">
                        <i class="fa-solid fa-file-pen text-xs w-4 text-center text-emerald-400"></i>
                        <span class="sidebar-label">Kelola Halaman PPDB</span>
                    </a>

                    <a href="{{ route('admin.testimonials.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.testimonials*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Testimonial Masyarakat">
                        <i class="fa-solid fa-comments text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Testimonial Masyarakat</span>
                    </a>

                    <a href="{{ route('admin.feedbacks.index') }}" class="sidebar-item flex items-center justify-between px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.feedbacks*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Kotak Aspirasi">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-inbox text-xs w-4 text-center"></i>
                            <span class="sidebar-label">Kotak Aspirasi</span>
                        </div>
                        @php $unread = \App\Models\Feedback::where('status', 'unread')->count(); @endphp
                        @if($unread > 0)
                            <span class="sidebar-badge bg-red-500 text-white text-[10px] px-1.5 py-0.2 rounded-full font-bold">
                                {{ $unread }}
                            </span>
                        @endif
                    </a>
                </div>

                {{-- SECTION 5: SISTEM, KEAMANAN & SEO --}}
                <div class="space-y-0.5">
                    <span class="sidebar-section-title px-3 text-[10px] font-bold tracking-wider text-slate-400 uppercase block py-0.5">Sistem &amp; Keamanan</span>
                    <div class="sidebar-section-divider hidden"></div>
                    
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Pengaturan & SEO">
                        <i class="fa-solid fa-gear text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Pengaturan &amp; SEO</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Pengguna & Role">
                        <i class="fa-solid fa-users-gear text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Pengguna &amp; Role</span>
                    </a>

                    <a href="{{ route('admin.security.index') }}" class="sidebar-item flex items-center justify-between px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.security*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Log & Keamanan">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-shield-halved text-xs w-4 text-center"></i>
                            <span class="sidebar-label">Log &amp; Keamanan</span>
                        </div>
                        @php $dangerCount = \App\Models\ActivityLog::where('status', 'danger')->count(); @endphp
                        @if($dangerCount > 0)
                            <span class="sidebar-badge bg-red-600 text-white text-[10px] px-1.5 py-0.2 rounded-full font-bold">
                                {{ $dangerCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.backup.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-1.5 rounded-lg transition {{ request()->routeIs('admin.backup*') ? 'bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white font-bold shadow-md shadow-red-500/20' : 'hover:bg-slate-800/70 text-slate-300 hover:text-white' }}" title="Backup Database">
                        <i class="fa-solid fa-database text-xs w-4 text-center"></i>
                        <span class="sidebar-label">Backup Database</span>
                    </a>
                </div>

            </nav>

            {{-- USER INFO & LOGOUT: Tepat di bawah menu terakhir, tanpa jarak kosong berlebih --}}
            <div class="sidebar-user-card mt-3 pt-3 border-t border-slate-800/80 bg-[#070b14]/70 rounded-xl p-2.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-[#da251c] to-rose-600 text-white flex items-center justify-center font-bold text-xs shadow flex-shrink-0" title="{{ auth()->user()->name ?? 'Administrator' }}">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="sidebar-user-text min-w-0">
                            <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</span>
                            <span class="inline-block text-[9px] px-1.5 py-0.2 font-semibold rounded bg-slate-800 text-amber-400">
                                {{ auth()->user()->role_label ?? 'Administrator' }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 p-1.5 text-xs rounded-lg hover:bg-slate-800/80 transition cursor-pointer" title="Keluar dari Akun">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-grow flex flex-col min-w-0">
        
        {{-- Top Header Bar --}}
        <header class="bg-white border-b border-slate-200/80 h-18 flex items-center justify-between px-6 sm:px-8 z-10 shadow-xs sticky top-0">
            <div class="flex items-center space-x-3 sm:space-x-4">
                <button id="mobile-toggle" class="md:hidden text-slate-600 hover:text-slate-900 p-2 text-lg">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <button id="desktop-sidebar-toggle" class="hidden md:inline-flex items-center justify-center text-slate-500 hover:text-[#da251c] p-2 rounded-xl hover:bg-slate-100 transition cursor-pointer" title="Perkecil / Perbesar Sidebar">
                    <i class="fa-solid fa-bars-staggered text-base"></i>
                </button>
                <div>
                    <h1 class="font-extrabold text-lg sm:text-xl text-slate-800 tracking-tight">@yield('header_title', 'Panel Kontrol')</h1>
                    <p class="text-[11px] text-slate-400">SMA Islam Terpadu Ishlahul Ummah Prabumulih</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                <a href="{{ route('admin.posts.create') }}" class="hidden sm:inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md transition">
                    <i class="fa-solid fa-pen-nib text-xs"></i>
                    <span>Tulis Berita</span>
                </a>

                <a href="{{ route('admin.backup.download') }}" class="hidden md:inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-3.5 py-2 rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-download text-xs text-amber-400"></i>
                    <span>Backup SQL</span>
                </a>

                <a href="{{ route('home') }}" target="_blank" class="text-xs text-slate-600 hover:text-[#da251c] bg-slate-100 hover:bg-red-50 px-3.5 py-2 rounded-xl transition flex items-center space-x-1.5 font-medium border border-slate-200">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#da251c]"></i>
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

        {{-- Admin Footer & Watermark --}}
        <footer class="px-6 sm:px-8 py-4 border-t border-slate-200/80 bg-white/70 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
            <div>
                &copy; {{ date('Y') }} SMA IT Ishlahul Ummah Prabumulih &bull; Panel Administrasi
            </div>
            <div class="text-[11px] text-slate-400">
                Developed by <a href="https://berandadigital.net" target="_blank" rel="noopener" class="text-slate-500 hover:text-slate-800 hover:underline font-medium">Beranda Teknologi Digital</a>
            </div>
        </footer>
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

        // Register Quill Style Attributor for alignment so text-align: center style is generated
        if (typeof Quill !== 'undefined') {
            try {
                const AlignStyle = Quill.import('attributors/style/align');
                Quill.register(AlignStyle, true);
            } catch (e) {
                console.warn('Quill AlignStyle registration:', e);
            }
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
                            [{ 'font': [] }, { 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'sub'}, { 'script': 'super' }],
                            [{ 'align': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'indent': '-1'}, { 'indent': '+1' }],
                            ['blockquote', 'code-block'],
                            ['link', 'image', 'video'],
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

                // Ensure synced before form submit and on submit button click
                const form = targetInput.closest('form');
                if (form) {
                    form.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            targetInput.value = quill.root.innerHTML;
                        });
                    });

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

            // Desktop Sidebar Minimize / Expand Toggle
            const desktopToggleBtn = document.getElementById('desktop-sidebar-toggle');
            const sidebarCollapseBtn = document.getElementById('sidebar-collapse-btn');
            const collapseIcon = document.getElementById('sidebar-collapse-icon');

            function toggleSidebar() {
                if (!sidebar) return;
                const isCollapsed = sidebar.classList.toggle('collapsed');
                localStorage.setItem('admin_sidebar_collapsed', isCollapsed ? 'true' : 'false');
                if (collapseIcon) {
                    collapseIcon.classList.toggle('fa-angles-left', !isCollapsed);
                    collapseIcon.classList.toggle('fa-angles-right', isCollapsed);
                }
            }

            if (desktopToggleBtn) {
                desktopToggleBtn.addEventListener('click', toggleSidebar);
            }
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', toggleSidebar);
            }

            // Restore collapsed state on load
            if (localStorage.getItem('admin_sidebar_collapsed') === 'true' && sidebar) {
                sidebar.classList.add('collapsed');
                if (collapseIcon) {
                    collapseIcon.classList.remove('fa-angles-left');
                    collapseIcon.classList.add('fa-angles-right');
                }
            }
        });

        // === SWEETALERT2 NOTIFICATIONS & CONFIRMATIONS ===
        const IshumToast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            IshumToast.fire({
                icon: 'success',
                title: "{{ addslashes(session('success')) }}"
            });
        @endif

        @if(session('error'))
            IshumToast.fire({
                icon: 'error',
                title: "{{ addslashes(session('error')) }}"
            });
        @endif

        @if(session('info'))
            IshumToast.fire({
                icon: 'info',
                title: "{{ addslashes(session('info')) }}"
            });
        @endif

        @if(session('warning'))
            IshumToast.fire({
                icon: 'warning',
                title: "{{ addslashes(session('warning')) }}"
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Perhatian! Terdapat Kesalahan Input',
                html: '<div class="text-left text-xs sm:text-sm text-slate-700 bg-red-50 p-4 rounded-xl border border-red-200 mt-2 space-y-1"><ul class="list-disc pl-5">@foreach($errors->all() as $err)<li>{{ addslashes($err) }}</li>@endforeach</ul></div>',
                confirmButtonColor: '#00913e',
                confirmButtonText: '<i class="fa-solid fa-check mr-1"></i> Mengerti, Saya Perbaiki',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl p-6',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-md'
                }
            });
        @endif

        // Global Interceptor for Delete Actions
        document.addEventListener('click', function(e) {
            const deleteTrigger = e.target.closest('.btn-delete, button[data-confirm-delete], a[data-confirm-delete], button[title="Hapus"]');
            if (deleteTrigger) {
                e.preventDefault();
                const form = deleteTrigger.closest('form');
                const targetUrl = deleteTrigger.getAttribute('href');
                const itemName = deleteTrigger.getAttribute('data-name') || deleteTrigger.getAttribute('data-title') || 'data ini';

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus <strong class="text-red-600">${itemName}</strong>?<br><span class="text-xs text-slate-500">Tindakan ini permanen dan tidak dapat dibatalkan.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#da251c',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-trash-can mr-1.5"></i> Ya, Hapus Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-red-500/30',
                        cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (form) {
                            form.submit();
                        } else if (targetUrl && targetUrl !== '#') {
                            window.location.href = targetUrl;
                        }
                    }
                });
            }
        });

        // Intercept standard DELETE form submissions
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const methodInput = form.querySelector('input[name="_method"][value="DELETE"]');
            if (methodInput && !form.dataset.confirmed) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data yang dihapus tidak dapat dipulihkan kembali!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#da251c',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fa-solid fa-trash-can mr-1.5"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-red-500/30',
                        cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            }
        });
    </script>
</body>
</html>
