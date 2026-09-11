{{-- FOOTER RESMI SMA ISLAM TERPADU ISHLAHUL UMMAH PRABUMULIH --}}
<footer class="bg-[#0b131f] text-white pt-8 sm:pt-10 pb-8 font-['Poppins',sans-serif]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. NEWSLETTER SUBSCRIBE BAR (Warna Hijau Ishum #00913e & Tombol Merah Ishum #da251c) --}}
        <div class="bg-gradient-to-r from-[#00913e] to-[#05a849] rounded-[22px] sm:rounded-[26px] px-6 sm:px-10 py-5 sm:py-6 mb-10 sm:mb-12 shadow-xl flex flex-col md:flex-row items-center justify-between gap-5 text-center md:text-left border border-green-600/40">
            <div>
                <span class="text-xs uppercase tracking-wider text-green-100 font-bold block mb-1">Buletin &amp; Kabar Sekolah</span>
                <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Dapatkan Info &amp; Pengumuman Terupdate</h2>
            </div>
            <form action="{{ route('hubungi') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 max-w-lg">
                <input type="email" name="subscribe_email" placeholder="Masukkan Email Anda" aria-label="Masukkan Email Anda untuk Berlangganan" class="bg-white text-xs sm:text-sm text-gray-800 placeholder-gray-500 px-5 py-2.5 sm:py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#da251c] w-full shadow-inner font-light" required>
                <button type="submit" aria-label="Kirim Langganan Info Terupdate" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-extrabold text-xs sm:text-sm px-6 py-2.5 sm:py-3 rounded-full shadow-lg transition flex items-center justify-center space-x-2 flex-shrink-0 cursor-pointer min-h-[44px]">
                    <i class="fa-solid fa-paper-plane text-xs" aria-hidden="true"></i>
                    <span>LANGGANAN</span>
                </button>
            </form>
        </div>

        {{-- 2. MAIN FOOTER CONTENT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 items-start text-center md:text-left">
            
            {{-- KOLOM 1: LOGO ASLI SEKOLAH --}}
            <div class="lg:col-span-3 flex justify-center md:justify-start">
                <div class="bg-white p-3 rounded-2xl shadow-md inline-block">
                    <img src="/uploads/logo-ishum-square.png" alt="Logo Resmi SMA Islam Terpadu Ishlahul Ummah Prabumulih" class="w-28 sm:w-32 h-auto object-contain block mx-auto md:mx-0" onerror="this.src='/uploads/logo-ishum.png'">
                </div>
            </div>

            {{-- KOLOM 2: ALAMAT KAMPUS & KONTAK --}}
            <div class="lg:col-span-4 space-y-3 text-center md:text-left">
                <h3 class="font-bold text-[#da251c] text-base sm:text-lg tracking-wide uppercase">
                    Alamat Kampus
                </h3>
                <p class="text-sm sm:text-[15px] text-gray-200 font-normal leading-relaxed pr-0 md:pr-2">
                    {{ $siteSettings['contact_address'] ?? 'Jalan Sadewa RT 01 RW 03 Kelurahan Karang Raja, Kecamatan Prabumulih Timur, Kota Prabumulih, Sumatera Selatan 31111' }}
                </p>
                <div class="space-y-2 pt-1 text-sm sm:text-[15px] text-gray-200">
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-phone text-[#10b981] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="tel:{{ $siteSettings['contact_phone'] ?? '082182680647' }}" class="text-gray-200 hover:text-[#da251c] transition py-1" aria-label="Telepon Sekolah">{{ $siteSettings['contact_phone'] ?? '0821-8268-0647' }}</a>
                    </div>
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-envelope text-[#10b981] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'smaitishlahulummah2019@gmail.com' }}" class="text-gray-200 hover:text-[#da251c] transition py-1" aria-label="Email Sekolah">{{ $siteSettings['contact_email'] ?? 'smaitishlahulummah2019@gmail.com' }}</a>
                    </div>
                </div>
            </div>

            {{-- KOLOM 3: SOSIAL MEDIA & TAUTAN WEB RESMI --}}
            <div class="lg:col-span-3 space-y-2 text-center md:text-left">
                <h3 class="font-bold text-[#da251c] text-base sm:text-lg tracking-wide uppercase">
                    Media Sosial
                </h3>
                <p class="text-base sm:text-[16px] font-bold text-white mb-3">
                    SMA IT Ishlahul Ummah
                </p>
                
                {{-- Ikon Bulat Putih --}}
                <div class="flex items-center justify-center md:justify-start space-x-2 pt-1 pb-3">
                    <a href="{{ $siteSettings['social_facebook'] ?? 'https://facebook.com/smait.ishlahulummah.3' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#00913e] hover:text-[#da251c] hover:scale-110 transition shadow" aria-label="Kunjungi Facebook SMA IT Ishlahul Ummah">
                        <i class="fa-brands fa-facebook-f text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $siteSettings['social_instagram'] ?? 'https://instagram.com/smait_ishum_prabumulih' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#00913e] hover:text-[#da251c] hover:scale-110 transition shadow" aria-label="Kunjungi Instagram SMA IT Ishlahul Ummah">
                        <i class="fa-brands fa-instagram text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $siteSettings['social_youtube'] ?? 'https://www.youtube.com/channel/UCUJgvV-nqy89f3m8Hw2QrGg/videos' }}" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#00913e] hover:text-[#da251c] hover:scale-110 transition shadow" aria-label="Kunjungi YouTube SMA IT Ishlahul Ummah">
                        <i class="fa-brands fa-youtube text-base" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.me/6282182680647" target="_blank" class="w-11 h-11 rounded-full bg-white flex items-center justify-center text-[#00913e] hover:text-[#da251c] hover:scale-110 transition shadow" aria-label="Hubungi WhatsApp SMA IT Ishlahul Ummah">
                        <i class="fa-brands fa-whatsapp text-base" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Tautan Web Resmi dengan Ikon Globe Hijau --}}
                <div class="space-y-1.5 text-sm sm:text-[15px] text-gray-200 pt-1">
                    <div class="flex items-center justify-center md:justify-start space-x-3">
                        <i class="fa-solid fa-globe text-[#10b981] w-4 text-center text-sm" aria-hidden="true"></i>
                        <a href="https://smaitishumpbm.sch.id" target="_blank" class="text-gray-200 hover:text-[#da251c] transition py-1">smaitishumpbm.sch.id</a>
                    </div>
                </div>
            </div>

            {{-- KOLOM 4: PENGUNJUNG --}}
            <div class="lg:col-span-2 space-y-2 text-center md:text-left">
                <h3 class="font-bold text-[#da251c] text-base sm:text-lg tracking-wide uppercase flex items-center justify-center md:justify-start gap-2">
                    <span>Pengunjung</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#00913e] text-white border border-green-500">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#da251c] animate-ping mr-1"></span> Live
                    </span>
                </h3>
                <div class="text-3xl sm:text-4xl lg:text-4xl font-bold text-white tracking-normal font-sans leading-tight pt-1 flex items-center justify-center md:justify-start" style="font-family: Arial, sans-serif;">
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
                Copyright &copy; {{ date('Y') }} SMA Islam Terpadu Ishlahul Ummah Prabumulih. All Rights Reserved.
            </div>

            {{-- Privacy Policy, PPDB, & Kontak --}}
            <div class="flex items-center justify-center sm:justify-end space-x-6 text-xs sm:text-[13px] text-gray-300 font-normal flex-shrink-0">
                <a href="{{ route('hubungi') }}?type=ppdb" class="text-[#da251c] font-semibold hover:underline transition py-2 inline-block">Info PPDB</a>
                <a href="{{ route('page.privacy-policy') }}" class="text-gray-300 hover:text-[#da251c] transition py-2 inline-block">Kebijakan Privasi</a>
                <a href="{{ route('hubungi') }}" class="text-gray-300 hover:text-[#da251c] transition py-2 inline-block">Kontak</a>
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
