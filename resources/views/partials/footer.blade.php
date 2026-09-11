{{-- FOOTER RESMI SMA IT PLUS ROBBANI --}}
<footer class="bg-[#0b131f] text-white pt-8 sm:pt-10 pb-8 font-['Poppins',sans-serif]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. NEWSLETTER SUBSCRIBE BAR (Warna Hijau Dominan #0d6b38 & Tombol Secondary Orange #f97316) --}}
        <div class="bg-gradient-to-r from-[#0d6b38] to-[#15803d] rounded-[22px] sm:rounded-[26px] px-6 sm:px-10 py-5 sm:py-6 mb-10 sm:mb-12 shadow-xl flex flex-col md:flex-row items-center justify-between gap-5 text-center md:text-left border border-green-700/40">
            <div>
                <span class="text-xs uppercase tracking-wider text-orange-200 font-bold block mb-1">Buletin &amp; Kabar Sekolah</span>
                <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Dapatkan Info &amp; Pengumuman Terupdate</h2>
            </div>
            <form action="{{ route('hubungi') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 max-w-lg">
                <input type="email" name="subscribe_email" placeholder="Masukkan Email Anda" aria-label="Masukkan Email Anda untuk Berlangganan" class="bg-white text-xs sm:text-sm text-gray-800 placeholder-gray-500 px-5 py-2.5 sm:py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#f97316] w-full shadow-inner font-light" required>
                <button type="submit" aria-label="Kirim Langganan Info Terupdate" class="bg-[#f97316] hover:bg-[#ea580c] text-white font-extrabold text-xs sm:text-sm px-6 py-2.5 sm:py-3 rounded-full shadow-lg transition flex items-center justify-center space-x-2 flex-shrink-0 cursor-pointer min-h-[44px]">
                    <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                    <span>LANGGANAN</span>
                </button>
            </form>
        </div>

        {{-- 2. MAIN FOOTER CONTENT (4 Kolom Sesuai Persis Layout & Proporsi Web Asli) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 items-start text-center md:text-left">
            
            {{-- KOLOM 1: LOGO ASLI SEKOLAH --}}
            <div class="lg:col-span-2 flex justify-center md:justify-start">
                <div class="bg-white p-3 rounded-2xl shadow-md inline-block">
                    <img src="/uploads/logo-robbani-emblem.svg" alt="Logo Resmi SMA IT Plus Robbani" class="w-24 sm:w-28 h-auto object-contain block mx-auto md:mx-0" onerror="this.src='/uploads/logo-robbani.svg'">
                </div>
            </div>

            {{-- KOLOM 2: ALAMAT KAMPUS & KONTAK --}}
            <div class="lg:col-span-4 space-y-3 text-center md:text-left">
                <h3 class="font-bold text-[#f97316] text-base sm:text-lg tracking-wide uppercase">
                    Alamat Kampus
                </h3>
                <p class="text-sm sm:text-[15px] text-gray-200 font-normal leading-relaxed pr-0 md:pr-2">
                    {{ $siteSettings['contact_address'] ?? 'Jl. Lintas Timur KM 35, Kel. Indralaya Indah, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan 30662' }}
                </p>
                <div class="space-y-2 pt-1 text-sm sm:text-[15px] text-gray-200">
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-phone text-[#22c55e] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="tel:{{ $siteSettings['contact_phone'] ?? '082177889900' }}" class="text-gray-200 hover:text-[#f97316] transition py-1" aria-label="Telepon Sekolah">{{ $siteSettings['contact_phone'] ?? '0821-7788-9900' }}</a>
                    </div>
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-envelope text-[#22c55e] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'info@smaitplusrobbani.sch.id' }}" class="text-gray-200 hover:text-[#f97316] transition py-1" aria-label="Email Sekolah">{{ $siteSettings['contact_email'] ?? 'info@smaitplusrobbani.sch.id' }}</a>
                    </div>
                </div>
            </div>

            {{-- KOLOM 3: SOSIAL MEDIA & TAUTAN WEB RESMI --}}
            <div class="lg:col-span-3 space-y-2 text-center md:text-left">
                <h3 class="font-bold text-[#f97316] text-base sm:text-lg tracking-wide uppercase">
                    Media Sosial
                </h3>
                <p class="text-base sm:text-[17px] font-bold text-white mb-3">
                    SMA IT Plus Robbani
                </p>
                
                {{-- 5 Ikon Bulat Putih dengan Ikon Hijau/Orange di Dalamnya --}}
                <div class="flex items-center justify-center md:justify-start space-x-2 pt-1 pb-3">
                    <a href="{{ $siteSettings['social_facebook'] ?? 'https://www.facebook.com' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#0d6b38] hover:text-[#f97316] hover:scale-110 transition shadow" aria-label="Kunjungi Facebook SMA IT Plus Robbani">
                        <i class="fa-brands fa-facebook-f text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $siteSettings['social_instagram'] ?? 'https://www.instagram.com' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#0d6b38] hover:text-[#f97316] hover:scale-110 transition shadow" aria-label="Kunjungi Instagram SMA IT Plus Robbani">
                        <i class="fa-brands fa-instagram text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $siteSettings['social_youtube'] ?? 'https://www.youtube.com' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#0d6b38] hover:text-[#f97316] hover:scale-110 transition shadow" aria-label="Kunjungi YouTube SMA IT Plus Robbani">
                        <i class="fa-brands fa-youtube text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $siteSettings['social_tiktok'] ?? 'https://www.tiktok.com' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#0d6b38] hover:text-[#f97316] hover:scale-110 transition shadow" aria-label="Kunjungi TikTok SMA IT Plus Robbani">
                        <i class="fa-brands fa-tiktok text-base" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.me/6282177889900" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#0d6b38] hover:text-[#f97316] hover:scale-110 transition shadow" aria-label="Hubungi WhatsApp SMA IT Plus Robbani">
                        <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Tautan Web Resmi dengan Ikon Globe Hijau --}}
                <div class="space-y-1.5 text-sm sm:text-[15px] text-gray-200 pt-1">
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-globe text-[#22c55e] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="{{ url('/') }}" class="text-gray-200 hover:text-[#f97316] transition py-1">smaitplusrobbani.sch.id</a>
                    </div>
                </div>
            </div>

            {{-- KOLOM 4: PENGUNJUNG --}}
            <div class="lg:col-span-3 space-y-2 text-center md:text-left">
                <h3 class="font-bold text-[#f97316] text-base sm:text-lg tracking-wide uppercase flex items-center justify-center md:justify-start gap-2">
                    <span>Pengunjung</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#0d6b38] text-white border border-green-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#f97316] animate-ping mr-1"></span> Live
                    </span>
                </h3>
                <div class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-normal font-sans leading-tight pt-1 flex items-center justify-center md:justify-start" style="font-family: Arial, sans-serif;">
                    <span id="footer-visitor-counter" data-target="{{ $rawVisitorHits ?? (int) str_replace(['.', ','], '', $visitorHits ?? '53512') }}">
                        {{ $visitorHits ?? '53.512' }}
                    </span>
                </div>
                <p class="text-xs text-gray-400 font-light">Kunjungan ke website resmi sekolah</p>
            </div>

        </div>

        {{-- 3. DUA GARIS PEMISAH HORIZONTAL --}}
        <div class="mt-12 mb-6 space-y-1">
            <div class="border-t border-neutral-800"></div>
            <div class="border-t border-neutral-800"></div>
        </div>

        {{-- 4. BOTTOM COPYRIGHT & LINKS --}}
        <div class="flex flex-col sm:flex-row justify-between items-center text-xs sm:text-[13px] text-gray-400 gap-4 text-center sm:text-left">
            <div>
                Copyright &copy; {{ date('Y') }} SMA IT Plus Robbani. All Rights Reserved.
            </div>

            {{-- Privacy Policy, PPDB, & Kontak --}}
            <div class="flex items-center justify-center sm:justify-end space-x-6 text-xs sm:text-[13px] text-gray-300 font-normal flex-shrink-0">
                <a href="{{ route('hubungi') }}?type=ppdb" class="text-[#f97316] font-semibold hover:underline transition py-2 inline-block">Info PPDB</a>
                <a href="{{ route('page.privacy-policy') }}" class="text-gray-300 hover:text-[#f97316] transition py-2 inline-block">Kebijakan Privasi</a>
                <a href="{{ route('hubungi') }}" class="text-gray-300 hover:text-[#f97316] transition py-2 inline-block">Kontak</a>
            </div>
        </div>

    </div>

    {{-- Script Animasi Hitung Visitor Counter --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counterEl = document.getElementById('footer-visitor-counter');
            if (!counterEl) return;

            const targetVal = parseInt(counterEl.getAttribute('data-target') || '53512', 10);
            let hasRun = false;

            const runCounterAnimation = () => {
                if (hasRun) return;
                hasRun = true;

                const duration = 2000;
                const startTime = performance.now();
                const startVal = Math.max(0, targetVal - 2500);

                const formatNum = (num) => {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                };

                const frame = (now) => {
                    const elapsed = now - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const ease = 1 - Math.pow(1 - progress, 4);
                    const current = Math.floor(startVal + (targetVal - startVal) * ease);

                    counterEl.textContent = formatNum(current);

                    if (progress < 1) {
                        requestAnimationFrame(frame);
                    } else {
                        counterEl.textContent = formatNum(targetVal);
                    }
                };

                requestAnimationFrame(frame);
            };

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            runCounterAnimation();
                            observer.unobserve(counterEl);
                        }
                    });
                }, { threshold: 0.1 });
                observer.observe(counterEl);
            } else {
                runCounterAnimation();
            }
        });
    </script>
</footer>
