{{-- FOOTER RESMI PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA OGAN ILIR --}}
<footer class="bg-[#0b131f] text-white pt-10 sm:pt-14 pb-8 font-['Poppins',sans-serif] border-t-4 border-[#f59e0b]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- 1. NEWSLETTER / BULETIN BAR --}}
        <div class="bg-gradient-to-r from-[#006830] via-[#00843d] to-[#044c23] rounded-3xl px-6 sm:px-10 py-6 sm:py-7 mb-12 sm:mb-14 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-5 text-center md:text-left border border-emerald-500/40">
            <div>
                <span class="text-xs uppercase tracking-wider text-[#fcd116] font-extrabold block mb-1">Kabar &amp; Informasi Terkini</span>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">Dapatkan Informasi Resmi &amp; Pengumuman PSB PPRU</h2>
                <p class="text-xs text-emerald-100 font-light mt-1">Daftarkan email Anda untuk menerima buletin pesantren dan jadwal seleksi santri baru.</p>
            </div>
            <form action="{{ route('hubungi') }}" method="GET" class="w-full md:w-auto flex flex-col sm:flex-row items-center gap-2.5 sm:gap-3 max-w-lg">
                <input type="email" name="subscribe_email" placeholder="Masukkan Email Anda..." aria-label="Masukkan Email Anda" class="bg-white text-xs sm:text-sm text-gray-800 placeholder-gray-500 px-5 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#f59e0b] w-full shadow-inner font-light" required>
                <button type="submit" class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 font-black text-xs sm:text-sm px-7 py-3 rounded-full shadow-lg transition flex items-center justify-center space-x-2 shrink-0 cursor-pointer min-h-[44px]">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>BERLANGGANAN</span>
                </button>
            </form>
        </div>

        {{-- 2. MAIN FOOTER CONTENT (4 KOLOM TERSTRUKTUR SEPERTI BAITUSSALAM) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 items-start text-center md:text-left">
            
            {{-- KOLOM 1: IDENTITAS & LOGO PESANTREN (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-4 flex flex-col items-center md:items-start text-center md:text-left">
                <div class="flex items-center space-x-3 group justify-center md:justify-start">
                    <img src="/uploads/official/logo-ru-berwarna.png" 
                         alt="Logo Pondok Pesantren Raudhatul Ulum" 
                         class="h-14 w-auto object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.4)]" 
                         onerror="this.src='/uploads/logo-ppru-square.png'">
                    <div class="text-left">
                        <span class="text-[10px] uppercase font-bold tracking-widest text-emerald-400 block leading-tight">Pondok Pesantren</span>
                        <span class="text-lg font-black tracking-tight text-white block leading-tight">Raudhatul Ulum</span>
                        <span class="text-[10px] uppercase font-bold tracking-wider text-[#fcd116] block leading-tight mt-0.5">Sakatiga • Ogan Ilir</span>
                    </div>
                </div>
                <p class="text-xs text-gray-300 font-light leading-relaxed max-w-sm md:max-w-none">
                    Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga adalah lembaga pendidikan Islam terpadu yang memadukan kurikulum Pondok Modern Gontor, Kementerian Agama, dan Dinas Pendidikan Nasional untuk mencetak generasi khoiru ummah yang berakhlak mulia, cerdas, dan mandiri.
                </p>

                {{-- Sosial Media Resmi PPRU --}}
                <div class="pt-2 flex flex-col items-center md:items-start">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-400 block mb-2">Media Sosial Resmi:</span>
                    <div class="flex items-center justify-center md:justify-start space-x-2.5">
                        <a href="{{ $siteSettings['social_facebook'] ?? 'https://www.facebook.com/pprusakatigasumsel/?locale=id_ID' }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/10 hover:bg-[#00843d] text-white flex items-center justify-center transition hover:scale-110 shadow-sm" aria-label="Facebook PPRU">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="{{ $siteSettings['social_instagram'] ?? 'https://www.instagram.com/ppru_sakatiga/' }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/10 hover:bg-[#e1306c] text-white flex items-center justify-center transition hover:scale-110 shadow-sm" aria-label="Instagram PPRU">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="{{ $siteSettings['social_youtube'] ?? 'https://www.youtube.com/@pprusakatiga' }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/10 hover:bg-[#ff0000] text-white flex items-center justify-center transition hover:scale-110 shadow-sm" aria-label="YouTube PPRU">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['contact_whatsapp'] ?? '6281278901950') }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-full bg-white/10 hover:bg-[#25d366] text-white flex items-center justify-center transition hover:scale-110 shadow-sm" aria-label="WhatsApp PPRU">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- KOLOM 2: UNIT PENDIDIKAN (4 Kolom - Lapang & Tidak Terpotong) --}}
            <div class="lg:col-span-4 space-y-3 flex flex-col items-center md:items-start w-full">
                <h3 class="font-extrabold text-[#f59e0b] text-sm uppercase tracking-wider flex items-center justify-center md:justify-start gap-2 border-b border-gray-800 pb-2 w-full">
                    <i class="fa-solid fa-building-columns text-xs"></i>
                    <span>Unit Pendidikan</span>
                </h3>
                <ul class="space-y-2.5 text-xs text-gray-300 w-full text-center md:text-left">
                    @if(isset($navUnitPendidikans) && $navUnitPendidikans->isNotEmpty())
                        @foreach($navUnitPendidikans->take(8) as $nu)
                            @php
                                $cleanUnitName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $nu->name));
                            @endphp
                            <li>
                                <a href="{{ route('pendidikan.show', $nu->slug) }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start text-left group">
                                    <i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0 group-hover:translate-x-0.5 transition-transform"></i>
                                    <span class="leading-relaxed">{{ $cleanUnitName }}</span>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> Madrasah Aliyah Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> Madrasah Tsanawiyah Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> Madrasah Ibtidaiyah Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> Madrasah Tahfizhul Qur'an Lil Aulad</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> TK Islam Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> SMP Islam Terpadu Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> SMA Islam Terpadu Raudhatul Ulum</a></li>
                        <li><a href="{{ route('pendidikan.index') }}" class="hover:text-[#fcd116] transition flex items-center justify-center md:justify-start"><i class="fa-solid fa-angle-right text-[10px] text-emerald-500 mr-2 shrink-0"></i> Institut Agama Islam Nur Raudhatul Ulum</a></li>
                    @endif
                    <li class="pt-1 text-center md:text-left">
                        <a href="{{ route('pendidikan.index') }}" class="font-bold text-[#f59e0b] hover:underline inline-flex items-center">
                            <span>Katalog Seluruh Jenjang &rarr;</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 3: TAUTAN CEPAT & INFORMASI (2 Kolom) --}}
            <div class="lg:col-span-2 space-y-3 flex flex-col items-center md:items-start w-full">
                <h3 class="font-extrabold text-[#f59e0b] text-sm uppercase tracking-wider flex items-center justify-center md:justify-start gap-2 border-b border-gray-800 pb-2 w-full">
                    <i class="fa-solid fa-link text-xs"></i>
                    <span>Tautan Cepat</span>
                </h3>
                <ul class="space-y-2 text-xs text-gray-300 w-full text-center md:text-left">
                    <li><a href="{{ route('page.sambutan') }}" class="hover:text-[#fcd116] transition block">Sambutan Mudir</a></li>
                    <li><a href="{{ route('page.tentang-kami') }}" class="hover:text-[#fcd116] transition block">Profil Pesantren</a></li>
                    <li><a href="{{ route('page.visi-misi') }}" class="hover:text-[#fcd116] transition block">Visi, Misi &amp; Jati Diri</a></li>
                    <li><a href="{{ route('page.sejarah') }}" class="hover:text-[#fcd116] transition block">Sejarah Sejak 1950</a></li>
                    <li><a href="{{ route('dewan.index') }}" class="hover:text-[#fcd116] transition block">Dewan Asatidz &amp; Guru</a></li>
                    <li><a href="{{ route('ppdb.index') }}" class="hover:text-[#fcd116] transition font-bold text-emerald-400 block">Pendaftaran PSB Online</a></li>
                    <li><a href="{{ route('download.index') }}" class="hover:text-[#fcd116] transition block">Unduh Brosur PSB</a></li>
                    <li><a href="{{ route('donasi') }}" class="hover:text-[#fcd116] transition text-amber-300 block">Wakaf &amp; Infaq Sarana</a></li>
                    <li><a href="{{ route('page.privacy-policy') }}" class="hover:text-[#fcd116] transition block">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('hubungi') }}" class="hover:text-[#fcd116] transition block">Hubungi Kami</a></li>
                </ul>
            </div>

            {{-- KOLOM 4: ALAMAT, KONTAK & PENGUNJUNG (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-3 flex flex-col items-center md:items-start w-full text-center md:text-left">
                <h3 class="font-extrabold text-[#f59e0b] text-sm uppercase tracking-wider flex items-center justify-center md:justify-start gap-2 border-b border-gray-800 pb-2 w-full">
                    <i class="fa-solid fa-location-dot text-xs"></i>
                    <span>Alamat &amp; Kontak</span>
                </h3>
                <div class="space-y-2.5 text-xs text-gray-300 leading-relaxed flex flex-col items-center md:items-start">
                    <p class="flex items-start justify-center md:justify-start space-x-2 text-center md:text-left">
                        <i class="fa-solid fa-map-pin text-[#f59e0b] mt-1 shrink-0"></i>
                        <span>{{ $siteSettings['contact_address'] ?? 'Desa Sakatiga, Kecamatan Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan 30816' }}</span>
                    </p>
                    <p class="flex items-center justify-center md:justify-start space-x-2">
                        <i class="fa-solid fa-phone text-[#f59e0b] shrink-0"></i>
                        <a href="tel:{{ $siteSettings['contact_phone'] ?? '081278901950' }}" class="hover:text-[#fcd116]">{{ $siteSettings['contact_phone'] ?? '0812-7890-1950' }}</a>
                    </p>
                    <p class="flex items-center justify-center md:justify-start space-x-2">
                        <i class="fa-solid fa-envelope text-[#f59e0b] shrink-0"></i>
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'sekretariat@ppru.ac.id' }}" class="hover:text-[#fcd116]">{{ $siteSettings['contact_email'] ?? 'sekretariat@ppru.ac.id' }}</a>
                    </p>
                </div>

                {{-- Counter Pengunjung --}}
                <div class="pt-3 border-t border-gray-800/80 w-full flex flex-col items-center md:items-start">
                    <div class="flex items-center justify-center md:justify-between w-full gap-2">
                        <span class="text-[11px] text-gray-400 font-medium">Statistik Pengunjung:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-900/60 text-emerald-300 border border-emerald-500/40">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse mr-1.5"></span> Live
                        </span>
                    </div>
                    <div class="text-2xl font-extrabold text-white tracking-tight pt-1 font-mono">
                        <span id="footer-visitor-counter" data-target="{{ $rawVisitorHits ?? (int) str_replace(['.', ','], '', $visitorHits ?? '53512') }}">
                            {{ $visitorHits ?? '53.512' }}
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400">Kunjungan website resmi pesantren</p>
                </div>
            </div>

        </div>

        {{-- 3. BARIS PALING BAWAH (Copyright Kiri, Watermark Statis Paling Bawah Kanan) --}}
        <div class="mt-12 pt-6 border-t border-gray-800/80 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-400 gap-3 text-center sm:text-left pb-4">
            <div class="text-slate-400">
                &copy; {{ date('Y') }} <strong>Pondok Pesantren Raudhatul Ulum Sakatiga</strong>. All Rights Reserved.
            </div>
            <div class="text-[10.5px] font-normal sm:ml-auto text-center sm:text-right">
                <a href="https://berandadigital.net" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-slate-200 transition inline-flex items-center sm:justify-end gap-1.5 font-normal tracking-wide opacity-80 hover:opacity-100" title="Beranda Teknologi Digital">
                    <span class="font-normal text-slate-400/90 hover:text-slate-200">Beranda Teknologi Digital</span>
                </a>
            </div>
        </div>

    </div>

    {{-- Script Animasi Counter --}}
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

                const formatNum = (num) => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

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
