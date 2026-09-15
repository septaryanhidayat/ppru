@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Ringkasan Website')

@section('content')
<div class="space-y-8">
    
    {{-- 1. WELCOME HERO CARD --}}
    <div class="bg-gradient-to-r from-[#0b1120] via-slate-900 to-[#1e293b] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-[#da251c]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex items-center space-x-2 bg-slate-800/80 border border-slate-700/80 px-3 py-1 rounded-full text-xs text-amber-400 font-semibold">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                        <span>Sistem Aktif & Terlindungi</span>
                    </div>
                    <a href="https://ppru.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-1.5 bg-emerald-950/80 border border-emerald-500/40 hover:border-emerald-400 px-3 py-1 rounded-full text-xs text-emerald-300 font-bold hover:text-emerald-200 transition" title="Kunjungi Website Resmi Pondok Pesantren Raudhatul Ulum">
                        <i class="fa-solid fa-globe text-emerald-400 text-[11px]"></i>
                        <span>Website Resmi: https://ppru.ac.id</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[9px] ml-1"></i>
                    </a>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl font-light leading-relaxed">
                    Panel kendali resmi Pondok Pesantren Raudhatul Ulum Sakatiga. Anda dapat mengelola seluruh konten, memantau aktivitas sistem, mengedit informasi sekolah, serta mengamankan website secara terpusat.
                </p>
            </div>

            <div class="flex flex-nowrap items-center gap-2.5 sm:gap-3 shrink-0 overflow-x-auto max-w-full pb-1">
                <a href="https://ppru.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-3 rounded-xl shadow-md transition whitespace-nowrap shrink-0">
                    <i class="fa-solid fa-external-link text-xs"></i>
                    <span>Kunjungi ppru.ac.id</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-[#da251c] to-[#ef4444] hover:from-[#b91c1c] hover:to-[#e05500] text-white text-xs font-bold px-5 py-3 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 whitespace-nowrap shrink-0">
                    <i class="fa-solid fa-pen-nib"></i>
                    <span>Tulis Berita Baru</span>
                </a>
                <a href="{{ route('admin.backup.download') }}" class="inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold px-4 py-3 rounded-xl border border-slate-700 transition whitespace-nowrap shrink-0">
                    <i class="fa-solid fa-cloud-arrow-down text-amber-400"></i>
                    <span>Unduh Backup SQL</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 1.5 MAINTENANCE MODE CONTROL CARD --}}
    <div class="rounded-3xl p-5 sm:p-6 shadow-lg border transition-all duration-300 {{ $isMaintenance ? 'bg-gradient-to-r from-amber-950/50 via-slate-900 to-amber-900/40 border-amber-500/50 shadow-amber-950/30 ring-1 ring-amber-500/30' : 'bg-slate-900/90 border-slate-800 shadow-slate-950/20' }}">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shrink-0 shadow-inner {{ $isMaintenance ? 'bg-amber-500/20 text-amber-400 border border-amber-500/40 animate-pulse' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                    <i class="fa-solid {{ $isMaintenance ? 'fa-triangle-exclamation' : 'fa-shield-halved' }}"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <h3 class="text-base sm:text-lg font-bold text-white tracking-tight">
                            Mode Pemeliharaan (Maintenance Mode)
                        </h3>
                        @if($isMaintenance)
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-black bg-amber-500 text-slate-950 uppercase tracking-wide shadow-sm animate-pulse">
                                <i class="fa-solid fa-circle text-[8px]"></i>
                                <span>Sedang Aktif (Website Ditutup)</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase tracking-wide">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                <span>Nonaktif (Website Publik Normal)</span>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 leading-relaxed">
                        @if($isMaintenance)
                            <span class="text-amber-300 font-semibold">Perhatian:</span> Pengunjung umum dialihkan ke halaman pemeliharaan (HTTP 503). <strong>Hanya Anda (Admin yang sedang login)</strong> yang dapat menjelajahi dan melihat tampilan website secara normal.
                        @else
                            Website beroperasi normal dan dapat diakses oleh seluruh pengunjung umum serta mesin pencari (Google).
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0 self-start sm:self-end md:self-center">
                <form action="{{ route('admin.maintenance.toggle') }}" method="POST" onsubmit="return confirm('{{ $isMaintenance ? 'Apakah Anda yakin ingin MENONAKTIFKAN mode maintenance dan membuka kembali website untuk publik?' : 'Apakah Anda yakin ingin MENGAKTIFKAN mode maintenance? Pengunjung umum tidak akan bisa melihat website sampai dinonaktifkan kembali.' }}')">
                    @csrf
                    @if($isMaintenance)
                        <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-lg shadow-emerald-900/30 transition transform hover:-translate-y-0.5 cursor-pointer">
                            <i class="fa-solid fa-power-off text-sm"></i>
                            <span>Buka Website (Nonaktifkan Maintenance)</span>
                        </button>
                    @else
                        <button type="submit" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-500 hover:to-amber-600 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-2xl shadow-lg shadow-amber-950/30 transition transform hover:-translate-y-0.5 cursor-pointer">
                            <i class="fa-solid fa-screwdriver-wrench text-sm"></i>
                            <span>Aktifkan Mode Maintenance</span>
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- 2. SECURITY ALERT BANNER --}}
    @if(($stats['security_threats'] ?? 0) > 0)
        <div class="bg-red-50 border-l-4 border-red-500 rounded-2xl p-4 sm:p-5 shadow-xs flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-lg flex-shrink-0">
                    <i class="fa-solid fa-shield-virus"></i>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-900">Peringatan Keamanan Sistem</h4>
                    <p class="text-xs text-red-700 mt-0.5">
                        Terdeteksi <strong>{{ $stats['security_threats'] }}</strong> upaya pemindaian/injeksi berbahaya yang berhasil diblokir secara otomatis oleh firewall aplikasi.
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.security.index', ['status' => 'danger']) }}" class="text-xs font-bold text-red-700 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg transition">
                Lihat Rincian &rarr;
            </a>
        </div>
    @endif

    {{-- 3. KPI ANALYTICS GRID --}}
    {{-- 3. KPI ANALYTICS GRID (Warna-Warni Vibrant & Modern) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        {{-- Card 1: Berita & Views (Oranye PPRU Luminous) --}}
        <div class="bg-gradient-to-br from-[#da251c] via-[#da251c] to-[#b91c1c] text-white rounded-3xl p-6 shadow-lg shadow-red-500/20 border border-red-300/30 relative overflow-hidden group hover:scale-[1.02] transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold text-red-100 uppercase tracking-wider">Artikel Berita</span>
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-xl shadow-inner group-hover:rotate-6 transition duration-300">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight relative z-10">
                {{ number_format($stats['total_posts']) }}
            </div>
            <div class="flex items-center space-x-2 text-xs text-red-100 font-semibold mt-3 relative z-10">
                <i class="fa-solid fa-eye text-white"></i>
                <span>{{ number_format($stats['total_views']) }} total pembaca</span>
            </div>
        </div>

        {{-- Card 2: Pengunjung Web (Biru Safir / Cyan Luminous) --}}
        <div class="bg-gradient-to-br from-[#0284c7] via-[#0ea5e9] to-[#06b6d4] text-white rounded-3xl p-6 shadow-lg shadow-sky-500/20 border border-sky-300/30 relative overflow-hidden group hover:scale-[1.02] transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold text-sky-100 uppercase tracking-wider">Statistik Pengunjung</span>
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-xl shadow-inner group-hover:rotate-6 transition duration-300">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight relative z-10">
                {{ number_format($stats['visitor_hits'] ?? 53534) }}
            </div>
            <div class="flex items-center space-x-2 text-xs text-sky-100 font-semibold mt-3 relative z-10">
                <i class="fa-solid fa-arrow-trend-up text-white"></i>
                <span>Hit counter aktif real-time</span>
            </div>
        </div>

        {{-- Card 3: Struktur & Dewan (Ungu Royal / Indigo Luminous) --}}
        <div class="bg-gradient-to-br from-[#6366f1] via-[#7c3aed] to-[#8b5cf6] text-white rounded-3xl p-6 shadow-lg shadow-purple-500/20 border border-purple-300/30 relative overflow-hidden group hover:scale-[1.02] transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold text-purple-100 uppercase tracking-wider">Dewan Guru & GTK</span>
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-xl shadow-inner group-hover:rotate-6 transition duration-300">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight relative z-10">
                {{ $stats['total_dewan'] }} <span class="text-base font-medium text-purple-200">Pendidik</span>
            </div>
            <div class="flex items-center space-x-2 text-xs text-purple-100 font-semibold mt-3 relative z-10">
                <span>{{ $stats['total_bidang'] }} Fasilitas</span>
                <span>•</span>
                <span>{{ $stats['total_dpc'] }} Program Unggulan</span>
            </div>
        </div>

        {{-- Card 4: Keamanan & Log (Hijau Zamrud / Emerald Luminous) --}}
        <div class="bg-gradient-to-br from-[#059669] via-[#10b981] to-[#14b8a6] text-white rounded-3xl p-6 shadow-lg shadow-emerald-500/20 border border-emerald-300/30 relative overflow-hidden group hover:scale-[1.02] transition duration-300">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Keamanan Siber</span>
                <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-xl shadow-inner group-hover:rotate-6 transition duration-300">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight relative z-10">
                {{ $stats['security_threats'] ?? 0 }} <span class="text-base font-medium text-emerald-200">ancaman</span>
            </div>
            <div class="flex items-center space-x-2 text-xs text-emerald-100 font-semibold mt-3 relative z-10">
                <i class="fa-solid fa-lock text-white"></i>
                <span>Firewall & WAF aktif</span>
            </div>
        </div>
    </div>

    {{-- 3B. OPERASIONAL & LAYANAN PESANTREN (Row 2 - Complex Institutional Metrics) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        {{-- Card 5: Unit Pendidikan --}}
        <a href="{{ route('admin.unit-pendidikan.index') }}" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Pendidikan</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900">{{ $stats['total_units'] ?? 8 }} <span class="text-xs font-semibold text-slate-400">Jenjang</span></div>
                <p class="text-[11px] text-slate-500 mt-1">TK, MI, MTs, SMPIT, MA, SMAIT, STIT, Tahfidz</p>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-amber-600 font-bold">
                <span>Kelola Profil Unit</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </div>
        </a>

        {{-- Card 6: PSB Online --}}
        <a href="{{ route('admin.ppdb.index') }}" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pendaftaran PPDB</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900">{{ $stats['total_ppdb'] ?? 0 }} <span class="text-xs font-semibold text-emerald-600 font-bold">Santri</span></div>
                <p class="text-[11px] text-slate-500 mt-1">{{ $stats['total_ppdb_verified'] ?? 0 }} berkas terverifikasi panitia</p>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-emerald-600 font-bold">
                <span>Data Calon Santri</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </div>
        </a>

        {{-- Card 7: Layanan Terpadu --}}
        <a href="{{ route('admin.layanan.index') }}" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan Terpadu</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900">{{ $stats['total_services'] ?? 0 }} <span class="text-xs font-semibold text-blue-600 font-bold">Pengajuan</span></div>
                <p class="text-[11px] text-slate-500 mt-1">{{ $stats['pending_services'] ?? 0 }} pengajuan menunggu verifikasi</p>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-blue-600 font-bold">
                <span>Buka Permohonan</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </div>
        </a>

        {{-- Card 8: Pusat Download --}}
        <a href="{{ route('admin.downloads.index') }}" class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Download & Berkas</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-file-arrow-down"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-2xl font-black text-slate-900">{{ $stats['total_downloads'] ?? 0 }} <span class="text-xs font-semibold text-purple-600 font-bold">Dokumen</span></div>
                <p class="text-[11px] text-slate-500 mt-1">Brosur PSB, e-book santri, mars & hymne</p>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-purple-600 font-bold">
                <span>Kelola File Download</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
            </div>
        </a>
    </div>

    {{-- 3C. SYSTEM & SERVER ENVIRONMENT SPECS CARD --}}
    <div class="bg-slate-900 text-white rounded-3xl p-6 border border-slate-800 shadow-md">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg font-bold">
                    <i class="fa-solid fa-server"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-sm text-white">Status Infrastruktur & Spesifikasi Server</h4>
                    <p class="text-xs text-slate-400">Ringkasan lingkungan sistem website resmi Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                </div>
            </div>
            <a href="https://ppru.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-emerald-600/90 hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                <i class="fa-solid fa-globe"></i>
                <span>Domain: https://ppru.ac.id</span>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 pt-4 text-xs">
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">PHP Runtime</span>
                <span class="font-bold text-slate-200 mt-0.5 block">{{ $systemInfo['php_version'] ?? PHP_VERSION }}</span>
            </div>
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Framework</span>
                <span class="font-bold text-slate-200 mt-0.5 block">Laravel {{ $systemInfo['laravel_version'] ?? '12' }}</span>
            </div>
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Database Driver</span>
                <span class="font-bold text-emerald-400 mt-0.5 block">{{ strtoupper($systemInfo['db_driver'] ?? 'SQLITE') }}</span>
            </div>
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Environment</span>
                <span class="font-bold text-amber-400 mt-0.5 block">{{ strtoupper($systemInfo['app_env'] ?? 'LOCAL') }}</span>
            </div>
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Memory Usage</span>
                <span class="font-bold text-slate-200 mt-0.5 block">{{ $systemInfo['memory_usage'] ?? 'N/A' }}</span>
            </div>
            <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/60">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Waktu Server</span>
                <span class="font-bold text-slate-200 mt-0.5 block">{{ $systemInfo['server_time'] ?? date('d M Y H:i') }}</span>
            </div>
        </div>
    </div>

    {{-- RINGKASAN ANALITIK PENGUNJUNG NYATA (REAL DATA SUMMARY) --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <div class="inline-flex items-center space-x-2 bg-emerald-50 text-emerald-700 px-3 py-0.5 rounded-full text-xs font-bold mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Real-Time Visitor Insights</span>
                </div>
                <h3 class="font-black text-slate-900 text-lg">Ringkasan Analitik Pengunjung & Tren Hari Ini</h3>
                <p class="text-xs text-slate-400">Data riil pengunjung unik, sumber asal lalu lintas, dan artikel yang sedang ramai dibaca.</p>
            </div>
            <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center space-x-2 bg-slate-900 hover:bg-[#da251c] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                <span>Lihat Analitik Lengkap</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        @if(! ($hasVisitorLogs ?? false))
            <div class="bg-amber-50 border border-amber-200/90 rounded-2xl p-6 text-amber-900 space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 text-lg">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-sm text-amber-950">Tabel Database <code>visitor_logs</code> Belum Terpasang</h4>
                        <p class="text-xs text-amber-800 leading-relaxed">
                            Pembaruan kode pelacakan analitik telah aktif, namun tabel database <code>visitor_logs</code> di MySQL server belum dibuat. Anda dapat membuatnya secara instan dengan 1 klik tombol di bawah:
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-1">
                    <form action="{{ route('admin.migrate') }}" method="POST" onsubmit="return confirm('Jalankan migrasi database sekarang?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm cursor-pointer">
                            <i class="fa-solid fa-play text-[10px]"></i>
                            <span>Jalankan Migrasi Database Otomatis Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Box 1: Statistik Riil Hari Ini --}}
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/60 space-y-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Aktivitas Hari Ini</span>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-black text-slate-900">{{ number_format($stats['today_visitors']) }}</span>
                        <span class="text-xs text-slate-500 font-semibold">pengunjung unik</span>
                    </div>
                    <div class="text-xs text-slate-600 space-y-1 pt-1 border-t border-slate-200/60 font-medium">
                        <div class="flex justify-between">
                            <span>Total Tayangan (Pageviews):</span>
                            <strong class="text-slate-800">{{ number_format($stats['today_pageviews']) }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Pengunjung 7 Hari Terakhir:</span>
                            <strong class="text-slate-800">{{ number_format($stats['week_visitors']) }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Box 2: Top Sumber Asal Kunjungan --}}
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/60 space-y-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Asal Rujukan Teratas Hari Ini</span>
                    <div class="space-y-2">
                        @forelse($topTodayReferrers as $ref)
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-700 truncate max-w-[140px]">{{ $ref->referer_source }}</span>
                                <span class="font-bold text-slate-900 bg-white px-2 py-0.5 rounded-md border border-slate-200/80">{{ number_format($ref->total) }}</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada rujukan hari ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Box 3: Top Artikel / Halaman yang Dibaca --}}
                <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/60 space-y-3">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Halaman Paling Banyak Dibaca</span>
                    <div class="space-y-2">
                        @forelse($topTodayPages as $tp)
                            <div class="flex items-center justify-between text-xs">
                                <a href="{{ $tp->path }}" target="_blank" class="font-medium text-slate-700 hover:text-[#da251c] truncate max-w-[150px]" title="{{ $tp->title ?: $tp->path }}">
                                    {{ $tp->title ?: $tp->path }}
                                </a>
                                <span class="font-bold text-[#da251c] bg-red-50 px-2 py-0.5 rounded-md border border-red-100">{{ number_format($tp->views) }}x</span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada kunjungan halaman hari ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- 4. QUICK ACTION MENU --}}
    <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider flex items-center space-x-2">
            <i class="fa-solid fa-bolt text-[#da251c]"></i>
            <span>Pusat Aksi Cepat</span>
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-center">
            
            <a href="{{ route('admin.posts.create') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-file-pen text-xl mb-2 text-[#da251c] group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Tulis Berita</span>
            </a>

            <a href="{{ route('admin.pages.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-file-signature text-xl mb-2 text-indigo-500 group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Edit Profil</span>
            </a>

            <a href="{{ route('admin.dewan.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-chalkboard-user text-xl mb-2 text-purple-500 group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Dewan Guru</span>
            </a>

            <a href="{{ route('admin.media.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-photo-film text-xl mb-2 text-pink-500 group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Galeri Foto</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-sliders text-xl mb-2 text-emerald-500 group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Setting & SEO</span>
            </a>

            <a href="{{ route('admin.backup.download') }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-red-50 border border-slate-200/70 hover:border-red-200 text-slate-700 hover:text-[#da251c] transition group">
                <i class="fa-solid fa-download text-xl mb-2 text-amber-500 group-hover:scale-110 transition block"></i>
                <span class="text-xs font-bold block">Backup Database</span>
            </a>

        </div>
    </div>

    {{-- 5. TWO COLUMN DATA GRID (Berita Terbaru & Log Aktivitas / Keamanan) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        {{-- KOLOM KIRI: Berita Terbaru (7 Cols) --}}
        <div class="lg:col-span-7 bg-white p-6 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-newspaper text-[#da251c]"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Artikel & Berita Terbaru</h3>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-[#da251c] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentPosts as $post)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                <img src="{{ $post->featured_image ?? '/uploads/logo-ppru-square.png' }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="font-bold text-xs sm:text-sm text-slate-800 hover:text-[#00913e] truncate block">
                                    {{ $post->title }}
                                </a>
                                <div class="flex items-center space-x-3 text-[11px] text-slate-400 mt-1">
                                    <span><i class="fa-regular fa-calendar mr-1"></i>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-eye mr-1"></i>{{ $post->views_count }} views</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-[#da251c] hover:bg-red-50 rounded-lg transition" title="Edit Artikel">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                    </div>
                @empty
                    <p class="py-8 text-center text-xs text-slate-400">Belum ada artikel yang dipublikasikan.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Log Aktivitas & Keamanan (5 Cols) --}}
        <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Log Aktivitas & Audit Keamanan</h3>
                </div>
                <a href="{{ route('admin.security.index') }}" class="text-xs font-bold text-[#da251c] hover:underline">
                    Semua Log &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentLogs as $log)
                    <div class="p-3 rounded-2xl border text-xs {{ $log->status === 'danger' ? 'bg-red-50/70 border-red-200 text-red-900' : ($log->status === 'warning' ? 'bg-amber-50/70 border-amber-200 text-amber-900' : 'bg-slate-50 border-slate-200/70 text-slate-800') }}">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold inline-flex items-center space-x-1.5">
                                @if($log->status === 'danger')
                                    <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                @elseif($log->status === 'warning')
                                    <i class="fa-solid fa-shield-exclamation text-amber-600"></i>
                                @else
                                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                                @endif
                                <span class="capitalize">{{ str_replace('_', ' ', $log->action) }}</span>
                            </span>
                            <span class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] leading-relaxed line-clamp-2">{{ $log->description }}</p>
                        <div class="flex items-center space-x-2 text-[10px] text-slate-400 mt-1.5 pt-1 border-t border-slate-200/40">
                            <span>User: {{ $log->user_name }}</span>
                            <span>•</span>
                            <span>IP: {{ $log->ip_address }}</span>
                        </div>
                    </div>
                @empty
                    <p class="py-8 text-center text-xs text-slate-400">Belum ada catatan aktivitas.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
