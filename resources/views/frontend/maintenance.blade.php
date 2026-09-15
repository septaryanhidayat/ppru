<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $maintenanceTitle ?? 'Pemeliharaan Sistem' }} - Pondok Pesantren Raudhatul Ulum Sakatiga</title>
    <link rel="icon" type="image/png" href="{{ asset('uploads/official/logo-ru-berwarna.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .mesh-bg {
            background-color: #061e16;
            background-image: 
                radial-gradient(at 10% 20%, rgba(13, 148, 136, 0.25) 0px, transparent 50%),
                radial-gradient(at 90% 10%, rgba(16, 185, 129, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 80%, rgba(5, 150, 105, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 90%, rgba(218, 37, 28, 0.12) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(15, 36, 28, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(52, 211, 153, 0.2);
        }
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); opacity: 0.9; }
            50% { transform: scale(1.05); opacity: 1; }
        }
        .pulse-icon {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="mesh-bg min-h-screen text-slate-100 flex flex-col justify-between selection:bg-emerald-500 selection:text-white antialiased relative overflow-x-hidden p-4 sm:p-6">

    {{-- Background Geometric Pattern --}}
    <div class="fixed inset-0 pointer-events-none opacity-5 bg-[radial-gradient(#34d399_1px,transparent_1px)] [background-size:24px_24px]"></div>

    {{-- Top Brand Bar --}}
    <header class="w-full max-w-5xl mx-auto flex items-center justify-between py-4 relative z-10">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
            <img src="{{ asset('uploads/official/logo-web-ppru.png') }}" alt="Logo PPRU" class="h-11 sm:h-12 w-auto object-contain transition group-hover:brightness-110 drop-shadow-md">
        </a>
        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-500/10 border border-amber-400/30 text-amber-300 text-xs font-semibold">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
            <span>Maintenance Mode</span>
        </span>
    </header>

    {{-- Center Content Card --}}
    <main class="w-full max-w-2xl mx-auto my-auto py-8 relative z-10">
        <div class="glass-card rounded-3xl p-6 sm:p-10 shadow-2xl shadow-emerald-950/50 text-center relative overflow-hidden">
            
            {{-- Decorative glow ring --}}
            <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-3xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-emerald-400 p-0.5 shadow-xl shadow-emerald-500/20 mb-6 pulse-icon">
                <div class="w-full h-full bg-slate-900/90 rounded-[22px] flex items-center justify-center text-emerald-400">
                    <i class="fa-solid fa-screwdriver-wrench text-3xl sm:text-4xl"></i>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/30 px-3.5 py-1 rounded-full text-xs font-bold text-emerald-300 mb-4">
                <i class="fa-solid fa-clock-rotate-left text-[11px]"></i>
                <span>Sedang Ditingkatkan Untuk Kenyamanan Anda</span>
            </div>

            {{-- Main Title --}}
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
                {{ $maintenanceTitle ?? 'Website Sedang Dalam Pemeliharaan' }}
            </h1>

            {{-- Body Message --}}
            <p class="text-sm sm:text-base text-slate-300 font-light leading-relaxed max-w-xl mx-auto mb-8">
                {{ $maintenanceMessage ?? 'Mohon maaf atas ketidaknyamanannya. Website resmi Pondok Pesantren Raudhatul Ulum Sakatiga sedang dalam pemeliharaan sistem rutin untuk meningkatkan kualitas layanan dan performa. Kami akan segera kembali online.' }}
            </p>

            {{-- Contact Hotline Boxes --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-w-lg mx-auto pt-2 mb-6">
                <a href="https://wa.me/6281278901950?text={{ urlencode('Assalamu\'alaikum Sekretariat PPRU, saya ingin menanyakan perihal...') }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm px-4 py-3 rounded-2xl shadow-lg shadow-emerald-700/20 transition group">
                    <i class="fa-brands fa-whatsapp text-lg group-hover:scale-110 transition"></i>
                    <span>WhatsApp Sekretariat</span>
                </a>
                <a href="mailto:sekretariat@ppru.ac.id" class="flex items-center justify-center gap-2.5 bg-slate-800/90 hover:bg-slate-700/90 text-slate-200 border border-slate-700 font-semibold text-xs sm:text-sm px-4 py-3 rounded-2xl transition group">
                    <i class="fa-solid fa-envelope text-base text-emerald-400 group-hover:scale-110 transition"></i>
                    <span>Email: sekretariat@ppru.ac.id</span>
                </a>
            </div>

            {{-- Pesantren Motto / Quote --}}
            <div class="text-xs text-slate-400 italic pt-4 border-t border-slate-800/80">
                &ldquo;Mendidik Generasi Shalih, Berilmu, dan Berakhlakul Karimah&rdquo;
            </div>
        </div>
    </main>

    {{-- Footer with Admin Login Link --}}
    <footer class="w-full max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 py-4 text-xs text-slate-400 relative z-10">
        <div>
            &copy; {{ date('Y') }} Pondok Pesantren Raudhatul Ulum Sakatiga. All rights reserved.
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-slate-400 hover:text-emerald-400 transition font-medium px-2.5 py-1 rounded-lg hover:bg-slate-800/50">
                <i class="fa-solid fa-lock text-[10px]"></i>
                <span>Akses Login Pengurus</span>
            </a>
        </div>
    </footer>

</body>
</html>
