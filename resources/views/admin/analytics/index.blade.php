@extends('layouts.admin')

@section('title', 'Statistik & Analitik Pengunjung Real')
@section('header_title', 'Analitik Pengunjung & Tren Pembaca')

@section('content')
<div class="space-y-8">

    {{-- HEADER & FILTER PERIODE --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80">
        <div>
            <div class="inline-flex items-center space-x-2 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold mb-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Data Nyata (Real Data Tracking)</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Statistik Pengunjung & Pembaca</h2>
            <p class="text-xs text-slate-500 mt-0.5">Analisis riil asal pembaca, sumber lalu lintas rujukan, dan performa halaman artikel.</p>
        </div>

        {{-- Period Pills --}}
        <div class="inline-flex bg-slate-100 p-1.5 rounded-2xl text-xs font-bold">
            <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition {{ $period === 'today' ? 'bg-[#ff5001] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Hari Ini
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '7days']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition {{ $period === '7days' ? 'bg-[#ff5001] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                7 Hari
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => '30days']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition {{ $period === '30days' ? 'bg-[#ff5001] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                30 Hari
            </a>
            <a href="{{ route('admin.analytics.index', ['period' => 'all']) }}" 
               class="px-3.5 py-1.5 rounded-xl transition {{ $period === 'all' ? 'bg-[#ff5001] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                Semua
            </a>
        </div>
    </div>

    @if(! ($hasVisitorLogs ?? false))
        <div class="bg-amber-50 border border-amber-200/90 rounded-3xl p-6 sm:p-8 text-amber-950 space-y-5 shadow-xs">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 text-2xl">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-black text-amber-950">Tabel Database <code>visitor_logs</code> Belum Terpasang di Server MySQL</h3>
                    <p class="text-xs sm:text-sm text-amber-800 leading-relaxed">
                        Anda telah menarik (deploy) file kode terbaru, namun tabel database untuk mencatat analitik belum dibuat di database MySQL hosting server Anda. Pilih salah satu cara berikut untuk membuatnya:
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                {{-- Opsi 1: Otomatis --}}
                <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-xs space-y-3">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase">Cara 1 (Rekomendasi / Paling Praktis)</span>
                    <h4 class="font-bold text-xs text-slate-800">Satu Klik Migrasi Otomatis</h4>
                    <p class="text-xs text-slate-500">Sistem akan menjalankan perintah migrasi database langsung dari panel ini.</p>
                    <form action="{{ route('admin.migrate') }}" method="POST" onsubmit="return confirm('Jalankan migrasi database sekarang?');">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm cursor-pointer">
                            <i class="fa-solid fa-play text-xs"></i>
                            <span>Jalankan Migrasi Database Otomatis</span>
                        </button>
                    </form>
                </div>

                {{-- Opsi 2: phpMyAdmin / Terminal --}}
                <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-xs space-y-3">
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">Cara 2 (Manual via phpMyAdmin / SSH)</span>
                    <h4 class="font-bold text-xs text-slate-800">Via Terminal atau phpMyAdmin</h4>
                    <p class="text-xs text-slate-500">Di Terminal cPanel / SSH jalankan: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-[11px] font-mono font-bold text-slate-900">php artisan migrate</code></p>
                    <details class="text-xs group">
                        <summary class="font-bold text-[#ff5001] cursor-pointer hover:underline list-none flex items-center space-x-1">
                            <i class="fa-solid fa-code text-[11px]"></i>
                            <span>Klik untuk melihat Query SQL (phpMyAdmin)</span>
                        </summary>
                        <div class="mt-2 bg-slate-900 text-slate-100 p-3 rounded-xl font-mono text-[10px] overflow-x-auto select-all">
CREATE TABLE IF NOT EXISTS `visitor_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) DEFAULT NULL,
  `session_id` varchar(80) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `device_type` varchar(30) NOT NULL DEFAULT 'Desktop',
  `browser` varchar(50) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `referer` text DEFAULT NULL,
  `referer_source` varchar(50) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `is_bot` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitor_logs_ip_address_index` (`ip_address`),
  KEY `visitor_logs_session_id_index` (`session_id`),
  KEY `visitor_logs_device_type_index` (`device_type`),
  KEY `visitor_logs_referer_source_index` (`referer_source`),
  KEY `visitor_logs_path_index` (`path`),
  KEY `visitor_logs_country_index` (`country`),
  KEY `visitor_logs_city_index` (`city`),
  KEY `visitor_logs_is_bot_index` (`is_bot`),
  KEY `visitor_logs_created_at_is_bot_index` (`created_at`,`is_bot`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                        </div>
                    </details>
                </div>
            </div>
        </div>
    @endif

    {{-- KPI METRICS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        {{-- Card 1: Total Kunjungan (Pageviews) --}}
        <div class="bg-gradient-to-br from-[#ff5001] via-[#f97316] to-[#ea580c] text-white rounded-3xl p-6 shadow-lg shadow-orange-500/20 border border-orange-300/30 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-orange-100 uppercase tracking-wider">Total Tayangan Halaman</span>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg">
                    <i class="fa-solid fa-eye"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ number_format($totalPageviews) }}
            </div>
            <div class="text-xs text-orange-100 mt-2 font-medium">
                Periode: {{ $period === 'today' ? 'Hari ini' : ($period === '7days' ? '7 hari terakhir' : ($period === '30days' ? '30 hari terakhir' : 'Semua riwayat')) }}
            </div>
        </div>

        {{-- Card 2: Pengunjung Unik (Unique IP Visitors) --}}
        <div class="bg-gradient-to-br from-[#0284c7] via-[#0ea5e9] to-[#06b6d4] text-white rounded-3xl p-6 shadow-lg shadow-sky-500/20 border border-sky-300/30 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-sky-100 uppercase tracking-wider">Pengunjung Unik</span>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ number_format($uniqueVisitors) }}
            </div>
            <div class="text-xs text-sky-100 mt-2 font-medium">
                Individu pengunjung unik (IP terpisah)
            </div>
        </div>

        {{-- Card 3: Pengunjung Hari Ini vs Kemarin --}}
        <div class="bg-gradient-to-br from-[#6366f1] via-[#7c3aed] to-[#8b5cf6] text-white rounded-3xl p-6 shadow-lg shadow-purple-500/20 border border-purple-300/30 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-purple-100 uppercase tracking-wider">Hari Ini vs Kemarin</span>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-day"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ number_format($todayUniques) }} <span class="text-sm font-normal text-purple-200">hari ini</span>
            </div>
            <div class="text-xs text-purple-100 mt-2 font-medium flex items-center space-x-1.5">
                <span>Kemarin: {{ number_format($yesterdayUniques) }} unik ({{ number_format($yesterdayPageviews) }} tayangan)</span>
            </div>
        </div>

        {{-- Card 4: Pengguna Mobile (HP) --}}
        <div class="bg-gradient-to-br from-[#059669] via-[#10b981] to-[#14b8a6] text-white rounded-3xl p-6 shadow-lg shadow-emerald-500/20 border border-emerald-300/30 relative overflow-hidden group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-emerald-100 uppercase tracking-wider">Pembaca Mobile (HP)</span>
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
            </div>
            <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ $mobilePercentage }}%
            </div>
            <div class="text-xs text-emerald-100 mt-2 font-medium">
                Mayoritas pembaca mengakses via smartphone
            </div>
        </div>

    </div>

    {{-- GRAFIK TREN KUNJUNGAN (CHART.JS) --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-slate-800 text-base">Grafik Tren Kunjungan & Pembaca</h3>
                <p class="text-xs text-slate-400">
                    {{ $period === 'today' ? 'Aktivitas kunjungan per jam hari ini' : 'Fluktuasi jumlah pembaca per hari' }}
                </p>
            </div>
            <div class="flex items-center space-x-4 text-xs font-semibold">
                <span class="flex items-center space-x-1.5 text-[#ff5001]">
                    <span class="w-3 h-3 rounded-full bg-[#ff5001] inline-block"></span>
                    <span>Tayangan (Pageviews)</span>
                </span>
                <span class="flex items-center space-x-1.5 text-sky-500">
                    <span class="w-3 h-3 rounded-full bg-sky-500 inline-block"></span>
                    <span>Pengunjung Unik</span>
                </span>
            </div>
        </div>

        <div class="relative h-72 sm:h-80 w-full">
            <canvas id="visitorTrendChart"></canvas>
        </div>
    </div>

    {{-- GRID 2 KOLOM: TOP PAGES & SUMBER RUJUKAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Halaman & Artikel --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Top 10 Halaman & Artikel Terpopuler</h3>
                    <p class="text-xs text-slate-400">Halaman yang paling banyak dibaca pada periode ini</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-orange-50 text-[#ff5001] flex items-center justify-center text-sm">
                    <i class="fa-solid fa-fire"></i>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topPages as $idx => $p)
                    <div class="py-3 flex items-center justify-between space-x-3">
                        <div class="flex items-center space-x-3 min-w-0">
                            <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0">
                                <a href="{{ $p->path }}" target="_blank" class="font-bold text-xs text-slate-800 hover:text-[#ff5001] transition truncate block">
                                    {{ $p->title ?: $p->path }}
                                </a>
                                <span class="text-[10px] text-slate-400 font-mono block truncate">{{ $p->path }}</span>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="font-extrabold text-xs text-slate-900 block">{{ number_format($p->views) }} <span class="text-[10px] text-slate-400 font-normal">views</span></span>
                            <span class="text-[10px] text-slate-400 block">{{ number_format($p->unique_views) }} unik</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-8">Belum ada data kunjungan halaman yang tercatat.</p>
                @endforelse
            </div>
        </div>

        {{-- Sumber Asal Rujukan (Referrers) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Sumber Asal Kunjungan (Traffic Sources)</h3>
                    <p class="text-xs text-slate-400">Dari mana pengunjung datang ke situs ini</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
            </div>

            <div class="space-y-3 pt-2">
                @forelse($trafficSources as $src)
                    @php
                        $pct = $totalPageviews > 0 ? round(($src->total / $totalPageviews) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center space-x-2">
                                @if(str_contains(strtolower($src->referer_source), 'google'))
                                    <i class="fa-brands fa-google text-red-500"></i>
                                @elseif(str_contains(strtolower($src->referer_source), 'facebook'))
                                    <i class="fa-brands fa-facebook text-blue-600"></i>
                                @elseif(str_contains(strtolower($src->referer_source), 'instagram'))
                                    <i class="fa-brands fa-instagram text-pink-600"></i>
                                @elseif(str_contains(strtolower($src->referer_source), 'whatsapp'))
                                    <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                                @elseif(str_contains(strtolower($src->referer_source), 'twitter') || str_contains(strtolower($src->referer_source), 'x'))
                                    <i class="fa-brands fa-x-twitter text-slate-900"></i>
                                @elseif(str_contains(strtolower($src->referer_source), 'direct'))
                                    <i class="fa-solid fa-compass text-amber-500"></i>
                                @else
                                    <i class="fa-solid fa-link text-slate-400"></i>
                                @endif
                                <span>{{ $src->referer_source }}</span>
                            </span>
                            <span class="text-slate-500">{{ number_format($src->total) }} ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-[#ff5001] to-amber-400 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-8">Belum ada data sumber rujukan yang tercatat.</p>
                @endforelse
            </div>
        </div>

    </div>

    {{-- GRID 2 KOLOM: LOKASI & PERANGKAT --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Asal Wilayah Pengunjung (Kota/Provinsi) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Asal Wilayah Geografis Pengunjung</h3>
                    <p class="text-xs text-slate-400">Kota dan provinsi tempat pengunjung mengakses web</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($topLocations as $loc)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-city"></i>
                            </span>
                            <div>
                                <h4 class="font-bold text-xs text-slate-800">
                                    {{ $loc->city ?: 'Indonesia' }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block">
                                    {{ $loc->region ? $loc->region . ', ' : '' }}{{ $loc->country ?: 'Indonesia' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-xs text-slate-900 block">{{ number_format($loc->total) }} <span class="text-[10px] text-slate-400 font-normal">hits</span></span>
                            <span class="text-[10px] text-slate-400 block">{{ number_format($loc->uniques) }} pengunjung unik</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-8">Belum ada data wilayah pengunjung yang tercatat.</p>
                @endforelse
            </div>
        </div>

        {{-- Komposisi Perangkat & Browser --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-base">Perangkat & Browser Pengunjung</h3>
                    <p class="text-xs text-slate-400">Spesifikasi teknologi yang digunakan pembaca</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
            </div>

            {{-- Device Types --}}
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Perangkat</h4>
                <div class="grid grid-cols-3 gap-3">
                    @php
                        $devMap = $devices->pluck('total', 'device_type')->toArray();
                    @endphp
                    <div class="bg-slate-50 p-3 rounded-2xl text-center border border-slate-200/60">
                        <i class="fa-solid fa-mobile-screen text-xl text-[#ff5001] mb-1"></i>
                        <span class="text-[11px] text-slate-500 block">Mobile (HP)</span>
                        <span class="font-extrabold text-sm text-slate-800">{{ number_format($devMap['Mobile'] ?? 0) }}</span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-2xl text-center border border-slate-200/60">
                        <i class="fa-solid fa-laptop text-xl text-sky-500 mb-1"></i>
                        <span class="text-[11px] text-slate-500 block">Desktop (PC)</span>
                        <span class="font-extrabold text-sm text-slate-800">{{ number_format($devMap['Desktop'] ?? 0) }}</span>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-2xl text-center border border-slate-200/60">
                        <i class="fa-solid fa-tablet-screen-button text-xl text-purple-500 mb-1"></i>
                        <span class="text-[11px] text-slate-500 block">Tablet</span>
                        <span class="font-extrabold text-sm text-slate-800">{{ number_format($devMap['Tablet'] ?? 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- Top Browsers --}}
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Top Browser</h4>
                <div class="space-y-2">
                    @foreach($browsers as $b)
                        @php
                            $bPct = $totalPageviews > 0 ? round(($b->total / $totalPageviews) * 100, 1) : 0;
                        @endphp
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-700 font-semibold">{{ $b->browser ?: 'Lainnya' }}</span>
                            <span class="text-slate-500 font-mono">{{ number_format($b->total) }} ({{ $bPct }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- LIVE FEED RIWAYAT KUNJUNGAN TERBARU --}}
    <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-0.5 rounded-full mb-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Real-Time Visitor Activity</span>
                </div>
                <h3 class="font-extrabold text-slate-900 text-lg">Log Kunjungan Pengunjung Terbaru</h3>
                <p class="text-xs text-slate-400">25 aktivitas kunjungan terakhir dari pengunjung website secara langsung.</p>
            </div>
            
            <div class="text-xs text-slate-500">
                Total Bot/Crawler disaring: <strong class="text-slate-800">{{ number_format($totalBotsBlocked) }}</strong>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Waktu</th>
                        <th class="py-3.5 px-6">Halaman Dikunjungi</th>
                        <th class="py-3.5 px-6">Lokasi & IP</th>
                        <th class="py-3.5 px-6">Sumber Asal</th>
                        <th class="py-3.5 px-6">Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentVisits as $visit)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-6 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $visit->created_at->diffForHumans() }}
                                <span class="text-[9px] text-slate-400 block">{{ $visit->created_at->format('d/m/Y H:i:s') }}</span>
                            </td>
                            <td class="py-3.5 px-6 max-w-xs">
                                <a href="{{ $visit->path }}" target="_blank" class="font-bold text-slate-800 hover:text-[#ff5001] transition truncate block">
                                    {{ $visit->page_title ?: $visit->path }}
                                </a>
                                <span class="text-[10px] text-slate-400 font-mono truncate block">{{ $visit->path }}</span>
                            </td>
                            <td class="py-3.5 px-6 whitespace-nowrap">
                                <div class="flex items-center space-x-1.5">
                                    <i class="fa-solid fa-location-dot text-purple-500 text-[10px]"></i>
                                    <span class="font-semibold text-slate-800">{{ $visit->city ?: 'Indonesia' }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-mono block">{{ $visit->ip_address }}</span>
                            </td>
                            <td class="py-3.5 px-6 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $visit->referer_source }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 whitespace-nowrap">
                                <div class="text-[11px] font-medium text-slate-700">
                                    {{ $visit->device_type }} &bull; {{ $visit->browser }}
                                </div>
                                <span class="text-[10px] text-slate-400 block">{{ $visit->platform }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Belum ada riwayat kunjungan yang tercatat. Kunjungan baru akan otomatis tampil di sini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PEMELIHARAAN LOG DATABASE --}}
    <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Pemeliharaan & Optimasi Database</h4>
            <p class="text-xs text-slate-500 mt-0.5">Bersihkan log kunjungan lama (>90 hari) agar ukuran database MySQL tetap ramping dan cepat.</p>
        </div>
        <form action="{{ route('admin.analytics.prune') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membersihkan data log kunjungan lebih dari 90 hari?');">
            @csrf
            <input type="hidden" name="days" value="90">
            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition flex items-center space-x-1.5">
                <i class="fa-solid fa-broom"></i>
                <span>Bersihkan Log > 90 Hari</span>
            </button>
        </form>
    </div>

</div>

{{-- CHART.JS SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorTrendChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const pageviews = @json($chartPageviews);
        const uniques = @json($chartUniques);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tayangan (Pageviews)',
                        data: pageviews,
                        borderColor: '#ff5001',
                        backgroundColor: 'rgba(255, 80, 1, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ff5001',
                        pointRadius: 3,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Pengunjung Unik',
                        data: uniques,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.05)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointBackgroundColor: '#0ea5e9',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#94a3b8' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 11 },
                            color: '#94a3b8'
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    });
</script>
@endsection
