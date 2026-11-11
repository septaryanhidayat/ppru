@php
    $logoPath = public_path('uploads/logo-ppru-transparent.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '/uploads/logo-ppru-transparent.png';
@endphp
{{-- Component Bagan Struktur Organisasi Visual Landscape Simetris Presisi dengan Logo PPRU --}}
<div x-data="{
    zoomLevel: 100,
    isFullscreen: false,
    isExporting: false,
    zoomIn() { if (this.zoomLevel < 140) this.zoomLevel += 10; },
    zoomOut() { if (this.zoomLevel > 50) this.zoomLevel -= 10; },
    resetZoom() { this.zoomLevel = 100; },
    toggleFullscreen() {
        const el = document.getElementById('org-chart-wrapper');
        if (!document.fullscreenElement) {
            el.requestFullscreen().catch(err => alert(`Error: ${err.message}`));
            this.isFullscreen = true;
        } else {
            document.exitFullscreen();
            this.isFullscreen = false;
        }
    },
    exportChartImage() {
        this.isExporting = true;
        const target = document.getElementById('org-chart-canvas');
        const prevTransform = target.style.transform;
        target.style.transform = 'none';

        const downloadDataUrl = (dataUrl) => {
            target.style.transform = prevTransform;
            this.isExporting = false;
            const link = document.createElement('a');
            link.download = 'bagan-struktur-organisasi-ppru-sakatiga.png';
            link.href = dataUrl;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Bagan Berhasil Diunduh!',
                    text: 'File gambar bagan landscape resolusi tinggi telah disimpan dalam format PNG dengan latar belakang putih bersih.',
                    timer: 2500,
                    showConfirmButton: false,
                });
            }
        };

        const tryHtmlToImage = () => {
            if (typeof window.htmlToImage !== 'undefined' && typeof window.htmlToImage.toPng === 'function') {
                window.htmlToImage.toPng(target, {
                    quality: 0.95,
                    backgroundColor: '#ffffff',
                    pixelRatio: 2,
                    skipFonts: true,
                }).then((dataUrl) => {
                    downloadDataUrl(dataUrl);
                }).catch((fallbackErr) => {
                    target.style.transform = prevTransform;
                    this.isExporting = false;
                    console.error('Fallback export error:', fallbackErr);
                    alert('Gagal mengekspor gambar bagan: ' + (fallbackErr.message || 'Terjadi kendala rendering'));
                });
            } else {
                target.style.transform = prevTransform;
                this.isExporting = false;
                alert('Gagal mengekspor gambar bagan.');
            }
        };

        const performExport = () => {
            const h2c = window.html2canvasPro || window.html2canvas;
            if (typeof h2c === 'undefined') {
                tryHtmlToImage();
                return;
            }

            h2c(target, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                logging: false,
                onclone: (clonedDoc) => {
                    const clonedCanvas = clonedDoc.getElementById('org-chart-canvas');
                    if (clonedCanvas) {
                        clonedCanvas.style.transform = 'none';
                        clonedCanvas.style.boxShadow = 'none';
                        clonedCanvas.style.margin = '0';
                    }
                }
            }).then((canvas) => {
                const dataUrl = canvas.toDataURL('image/png');
                downloadDataUrl(dataUrl);
            }).catch((err) => {
                console.warn('html2canvas failed, attempting htmlToImage fallback:', err);
                tryHtmlToImage();
            });
        };

        if (typeof window.html2canvas === 'undefined' && typeof window.html2canvasPro === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/html2canvas-pro@latest/dist/html2canvas.min.js';
            script.onload = () => {
                if (document.fonts && document.fonts.ready) {
                    document.fonts.ready.then(performExport);
                } else {
                    performExport();
                }
            };
            script.onerror = () => {
                tryHtmlToImage();
            };
            document.head.appendChild(script);
        } else {
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(performExport);
            } else {
                performExport();
            }
        }
    }
}" class="space-y-3" id="org-chart-root">

    <style>
        #org-chart-canvas {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            background-color: #ffffff !important;
        }
        #org-chart-canvas * {
            box-sizing: border-box;
        }
        #org-chart-canvas h1,
        #org-chart-canvas h2,
        #org-chart-canvas h3,
        #org-chart-canvas h4,
        #org-chart-canvas h5,
        #org-chart-canvas h6,
        #org-chart-canvas p {
            margin: 0;
            padding: 0;
            line-height: 1.25;
            text-align: center;
        }
        #org-chart-canvas svg {
            display: block;
            overflow: visible;
            flex-shrink: 0;
            shape-rendering: geometricPrecision;
        }
        @media print {
            @page {
                size: landscape;
                margin: 5mm;
            }
            body {
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .print\:hidden {
                display: none !important;
            }
            #org-chart-wrapper {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                overflow: visible !important;
                box-shadow: none !important;
            }
            #org-chart-canvas {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 4mm !important;
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                transform: none !important;
                background: #ffffff !important;
            }
        }
    </style>

    <!-- Top Action Bar & Controls (Clean White Theme) -->
    <div class="flex flex-wrap items-center justify-between gap-2.5 p-3 sm:p-3.5 rounded-2xl bg-white border border-slate-200 shadow-sm print:hidden">
        
        <!-- Legend / Info -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 text-[#00843d] flex items-center justify-center font-bold text-sm sm:text-base shadow-sm border border-emerald-200">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-black text-slate-900 flex items-center gap-1.5">
                    <span>Bagan Alur &amp; Hirarki Kepengurusan Yayasan &amp; Pesantren</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        Format Landscape Simetris
                    </span>
                </h4>
                <p class="text-[10px] text-slate-500 font-medium">Bagan resmi: Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) &amp; Pimpinan PPRU</p>
            </div>
        </div>

        <!-- Interactive Tools (Zoom, Download, Print, Fullscreen) -->
        <div class="flex flex-wrap items-center gap-1.5">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-slate-100 p-0.5 rounded-xl border border-slate-200">
                <button type="button" @click="zoomOut()" aria-label="Perkecil (-)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 hover:bg-white text-xs font-bold transition-all cursor-pointer" title="Perkecil (-)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="px-2 text-[10px] sm:text-xs font-bold text-slate-700 min-w-[2.8rem] text-center" x-text="zoomLevel + '%'">100%</span>
                <button type="button" @click="zoomIn()" aria-label="Perbesar (+)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 hover:bg-white text-xs font-bold transition-all cursor-pointer" title="Perbesar (+)">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button type="button" @click="resetZoom()" aria-label="Reset Zoom" class="px-2 py-1 rounded-lg text-[10px] font-bold text-slate-600 hover:bg-white transition-all cursor-pointer" title="Reset Ukuran">
                    Reset
                </button>
            </div>

            <!-- Fullscreen Button -->
            <button type="button" @click="toggleFullscreen()" aria-label="Layar Penuh" class="h-8 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer" title="Layar Penuh">
                <i class="fa-solid fa-expand"></i>
                <span class="hidden md:inline">Layar Penuh</span>
            </button>

            <!-- Export Image Button -->
            <button type="button" @click="exportChartImage()" :disabled="isExporting" aria-label="Unduh Gambar PNG Landscape" class="h-8 px-3 rounded-xl bg-[#00843d] hover:bg-[#006830] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all cursor-pointer disabled:opacity-50">
                <i class="fa-solid fa-download" :class="isExporting ? 'fa-bounce' : ''"></i>
                <span x-text="isExporting ? 'Memproses...' : 'Unduh PNG'">Unduh PNG</span>
            </button>

            <!-- Print Button -->
            <button type="button" onclick="window.print()" aria-label="Cetak Bagan" class="h-8 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span class="hidden md:inline">Cetak</span>
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container (Landscape Scroll Wrapper) -->
    <div id="org-chart-wrapper" class="relative w-full overflow-x-auto rounded-3xl bg-white border border-slate-200 shadow-sm p-3 sm:p-5 transition-all">
        
        <!-- The Printable & Exportable Canvas (Landscape Width ~1180px, Simetris & Anti-Clipping, Pure White Background) -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="w-[1180px] mx-auto p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-5"
             style="background-color: #ffffff; background-image: none;">
            
            <!-- Bagan Header Title dengan Logo PPRU Resmi (Base64 Inlined untuk Anti-CORS) -->
            <div class="text-center pb-4 border-b border-slate-200">
                <div class="flex items-center justify-center mb-2.5">
                    <img src="{{ $logoBase64 }}" 
                         alt="Logo Pondok Pesantren Raudhatul Ulum Sakatiga" 
                         class="h-16 w-auto object-contain drop-shadow-sm" 
                         loading="eager"
                         crossorigin="anonymous">
                </div>

                <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wider leading-snug text-center m-0">
                    STRUKTUR ORGANISASI YAYASAN &amp; PIMPINAN PESANTREN
                </h2>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-xs sm:text-sm font-extrabold text-[#00843d]">
                        YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)
                    </span>
                    <span class="text-slate-300">&bull;</span>
                    <span class="text-[11px] font-bold text-slate-600">
                        PONDOK PESANTREN RAUDHATUL ULUM SAKATIGA
                    </span>
                </div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 1: DEWAN PEMBINA YAPIRUS                       -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Ketua Dewan Pembina Card -->
                <div class="w-[360px] rounded-2xl bg-white border-2 border-amber-500 shadow-md">
                    <div class="h-8 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-t-xl px-3 flex items-center justify-center gap-1.5 text-center">
                        <i class="fa-solid fa-crown text-xs text-amber-200"></i>
                        <span class="text-[11px] font-black uppercase tracking-wider text-center">
                            DEWAN PEMBINA YAPIRUS
                        </span>
                    </div>
                    <div class="min-h-[58px] px-3 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-snug break-words text-center m-0">
                            {{ $tree['pembina_ketua']->name ?? ($tree['pembina']->name ?? "KH. Tol'at Wafa Ahmad, Lc.") }}
                        </h3>
                        <p class="text-[10px] text-amber-700 font-bold mt-1 leading-none break-words text-center m-0">
                            {{ $tree['pembina_ketua']->position ?? ($tree['pembina']->position ?? 'Ketua Dewan Pembina YAPIRUS') }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 5 Anggota Dewan Pembina -->
                <svg class="w-[1100px] h-7 text-emerald-600 mx-auto block" viewBox="0 0 1100 28" fill="none">
                    <path d="M 550 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 110 14 H 990" stroke="currentColor" stroke-width="2"/>
                    <path d="M 110 14 V 28 M 330 14 V 28 M 550 14 V 28 M 770 14 V 28 M 990 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- 5 Anggota Dewan Pembina Grid -->
                <div class="w-[1140px] mx-auto grid grid-cols-5 gap-3">
                    @php
                        $pembinaList = [
                            'KH. Abdul Karim Umar',
                            'Drs. KH. Nadjib Subkie',
                            'Drs. KH. Mohd. Iqbal Romzie',
                            'H. M. Akram Afifi, Lc., M.Pd.',
                            'Faiz Nabil, M.Pd.',
                        ];
                    @endphp
                    @foreach($pembinaList as $idx => $fallbackName)
                        @php
                            $member = $tree['pembina_anggota']->get($idx);
                            $name = $member?->name ?: $fallbackName;
                        @endphp
                        <div class="rounded-xl bg-white border border-emerald-600 shadow-xs">
                            <div class="h-6 bg-gradient-to-r from-emerald-700 to-[#00843d] text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                                <i class="fa-solid fa-user-group text-[9px] text-emerald-200"></i>
                                <span class="text-[9px] font-black uppercase tracking-wider text-center">ANGGOTA DEWAN PEMBINA</span>
                            </div>
                            <div class="min-h-[48px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                                <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                    {{ $name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector line from Level 1 down to Level 2 -->
                <div class="w-[2px] h-6 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 2: PENGURUS HARIAN YAPIRUS                     -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Ketua Dewan Harian YAPIRUS Card -->
                <div class="w-[360px] rounded-2xl bg-white border-2 border-blue-600 shadow-md">
                    <div class="h-8 bg-gradient-to-r from-blue-700 to-sky-600 text-white rounded-t-xl px-3 flex items-center justify-center gap-1.5 text-center">
                        <i class="fa-solid fa-building-columns text-xs text-blue-200"></i>
                        <span class="text-[11px] font-black uppercase tracking-wider text-center">
                            PENGURUS HARIAN
                        </span>
                    </div>
                    <div class="min-h-[58px] px-3 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-snug break-words text-center m-0">
                            {{ $tree['harian_ketua']->name ?? ($tree['ketua_yayasan']->name ?? 'Dr. H. Husnul Amin, Lc., M.H.I., M.M.') }}
                        </h3>
                        <p class="text-[10px] text-blue-700 font-bold mt-1 leading-none break-words text-center m-0">
                            {{ $tree['harian_ketua']->position ?? 'Ketua Dewan Harian YAPIRUS' }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 4 Pengurus Harian (Sekretaris & Bendahara) -->
                <svg class="w-[960px] h-7 text-teal-600 mx-auto block" viewBox="0 0 960 28" fill="none">
                    <path d="M 480 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 120 14 H 840" stroke="currentColor" stroke-width="2"/>
                    <path d="M 120 14 V 28 M 360 14 V 28 M 600 14 V 28 M 840 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- 4 Pengurus Harian Grid (Sekretaris, Wasekr, Bendahara, Wabend) -->
                <div class="w-[1000px] mx-auto grid grid-cols-4 gap-3.5">
                    <!-- Sekretaris -->
                    <div class="rounded-xl bg-white border border-teal-500 shadow-xs">
                        <div class="h-6 bg-gradient-to-r from-teal-700 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                            <i class="fa-solid fa-file-signature text-[9px] text-teal-200"></i>
                            <span class="text-[9px] font-black uppercase tracking-wider text-center">SEKRETARIS YAYASAN</span>
                        </div>
                        <div class="min-h-[52px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['sekretaris_1']->name ?? ($tree['sekretaris']->name ?? 'Salamuddin, S.Si.') }}
                            </h4>
                            <p class="text-[9px] text-teal-700 font-semibold mt-0.5 leading-none break-words text-center m-0">Sekretaris</p>
                        </div>
                    </div>

                    <!-- Wakil Sekretaris -->
                    <div class="rounded-xl bg-white border border-teal-500 shadow-xs">
                        <div class="h-6 bg-gradient-to-r from-teal-700 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                            <i class="fa-solid fa-file-lines text-[9px] text-teal-200"></i>
                            <span class="text-[9px] font-black uppercase tracking-wider text-center">SEKRETARIS YAYASAN</span>
                        </div>
                        <div class="min-h-[52px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['sekretaris_2']->name ?? 'H. Muhammad Rido, S.Ag.' }}
                            </h4>
                            <p class="text-[9px] text-teal-700 font-semibold mt-0.5 leading-none break-words text-center m-0">Wakil Sekretaris</p>
                        </div>
                    </div>

                    <!-- Bendahara -->
                    <div class="rounded-xl bg-white border border-teal-500 shadow-xs">
                        <div class="h-6 bg-gradient-to-r from-teal-700 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                            <i class="fa-solid fa-coins text-[9px] text-amber-300"></i>
                            <span class="text-[9px] font-black uppercase tracking-wider text-center">BENDAHARA YAYASAN</span>
                        </div>
                        <div class="min-h-[52px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['bendahara_1']->name ?? ($tree['bendahara']->name ?? 'Hj. Risa Fauziah Aristina') }}
                            </h4>
                            <p class="text-[9px] text-teal-700 font-semibold mt-0.5 leading-none break-words text-center m-0">Bendahara</p>
                        </div>
                    </div>

                    <!-- Wakil Bendahara -->
                    <div class="rounded-xl bg-white border border-teal-500 shadow-xs">
                        <div class="h-6 bg-gradient-to-r from-teal-700 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                            <i class="fa-solid fa-coins text-[9px] text-amber-300"></i>
                            <span class="text-[9px] font-black uppercase tracking-wider text-center">BENDAHARA YAYASAN</span>
                        </div>
                        <div class="min-h-[52px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['bendahara_2']->name ?? 'Maila Rasyidah, Lc' }}
                            </h4>
                            <p class="text-[9px] text-teal-700 font-semibold mt-0.5 leading-none break-words text-center m-0">Wakil Bendahara</p>
                        </div>
                    </div>
                </div>

                <!-- Connector line from Level 2 down to Level 3 -->
                <div class="w-[2px] h-6 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: DEWAN PENGAWAS                              -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Ketua Dewan Pengawas Card -->
                <div class="w-[360px] rounded-2xl bg-white border-2 border-emerald-700 shadow-md">
                    <div class="h-8 bg-gradient-to-r from-emerald-800 to-emerald-700 text-white rounded-t-xl px-3 flex items-center justify-center gap-1.5 text-center">
                        <i class="fa-solid fa-shield-halved text-xs text-amber-300"></i>
                        <span class="text-[11px] font-black uppercase tracking-wider text-center">
                            DEWAN PENGAWAS
                        </span>
                    </div>
                    <div class="min-h-[58px] px-3 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-snug break-words text-center m-0">
                            {{ $tree['pengawas_ketua']->name ?? 'Drs. KH. Ahmad Nahrowi, MM' }}
                        </h3>
                        <p class="text-[10px] text-emerald-700 font-bold mt-1 leading-none break-words text-center m-0">
                            {{ $tree['pengawas_ketua']->position ?? 'Ketua Dewan Pengawas' }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 5 Anggota Dewan Pengawas -->
                <svg class="w-[1100px] h-7 text-emerald-600 mx-auto block" viewBox="0 0 1100 28" fill="none">
                    <path d="M 550 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 110 14 H 990" stroke="currentColor" stroke-width="2"/>
                    <path d="M 110 14 V 28 M 330 14 V 28 M 550 14 V 28 M 770 14 V 28 M 990 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <!-- 5 Anggota Dewan Pengawas Grid -->
                <div class="w-[1140px] mx-auto grid grid-cols-5 gap-3">
                    @php
                        $pengawasList = [
                            'H. Husnul Anam, S.H.I',
                            'Lazuwardi, S.Kom',
                            'H. Ahmad Almanfaluty, Lc., M.Pd',
                            'Azzam Mujahid Izzulhaq',
                            'Mohd. Hafiy Nawwaf, S.H., M.H',
                        ];
                    @endphp
                    @foreach($pengawasList as $idx => $fallbackName)
                        @php
                            $member = $tree['pengawas_anggota']->get($idx);
                            $name = $member?->name ?: $fallbackName;
                        @endphp
                        <div class="rounded-xl bg-white border border-emerald-600 shadow-xs">
                            <div class="h-6 bg-gradient-to-r from-emerald-700 to-[#00843d] text-white rounded-t-lg px-2 flex items-center justify-center gap-1 text-center">
                                <i class="fa-solid fa-user-shield text-[9px] text-emerald-200"></i>
                                <span class="text-[9px] font-black uppercase tracking-wider text-center">ANGGOTA DEWAN PENGAWAS</span>
                            </div>
                            <div class="min-h-[48px] px-2 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                                <h4 class="text-xs font-black text-slate-900 leading-snug break-words text-center m-0">
                                    {{ $name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector line from Level 3 down to Level 4 -->
                <div class="w-[2px] h-6 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)    -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <div class="w-[1060px] mx-auto flex justify-between items-stretch">
                    
                    <!-- Wakil Pimpinan Putri (Naibah Mudir) -->
                    <div class="w-[310px] rounded-2xl bg-white border-2 border-purple-600 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-purple-700 to-fuchsia-600 text-white rounded-t-xl px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-user-tie text-xs text-purple-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-wider text-center">
                                WAKIL PIMPINAN PONDOK PESANTREN
                            </span>
                        </div>
                        <div class="min-h-[60px] px-3 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                            <h4 class="text-xs sm:text-sm font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['naibah_mudir']->name ?? 'Maila Rasyidah, Lc' }}
                            </h4>
                            <p class="text-[10px] text-purple-700 font-bold mt-1 leading-none break-words text-center m-0">
                                {{ $tree['naibah_mudir']->position ?? 'Naibah Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                    <!-- Mudir Pondok Pesantren (Pimpinan Utama) -->
                    <div class="w-[380px] rounded-2xl bg-white border-2 border-[#00843d] shadow-xl">
                        <div class="h-9 bg-gradient-to-r from-emerald-900 via-[#00843d] to-emerald-800 text-white rounded-t-xl px-3 flex items-center justify-center gap-2 text-center">
                            <i class="fa-solid fa-mosque text-xs text-amber-300"></i>
                            <span class="text-xs font-black uppercase tracking-wider text-center">
                                PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)
                            </span>
                        </div>
                        <div class="min-h-[64px] px-4 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                            <h3 class="text-sm sm:text-base font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['mudir']->name ?? "KH. Tol'at Wafa Ahmad, Lc." }}
                            </h3>
                            <p class="text-[11px] text-[#00843d] font-bold mt-1 leading-none break-words text-center m-0">
                                {{ $tree['mudir']->position ?? 'Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                    <!-- Wakil Pimpinan Putra (Naib Mudir) -->
                    <div class="w-[310px] rounded-2xl bg-white border-2 border-blue-600 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-blue-700 to-indigo-600 text-white rounded-t-xl px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-user-tie text-xs text-blue-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-wider text-center">
                                WAKIL PIMPINAN PONDOK PESANTREN
                            </span>
                        </div>
                        <div class="min-h-[60px] px-3 py-2 text-center bg-white rounded-b-xl flex flex-col justify-center items-center">
                            <h4 class="text-xs sm:text-sm font-black text-slate-900 leading-snug break-words text-center m-0">
                                {{ $tree['naib_mudir']->name ?? 'H. M. Akram Afifi, Lc., M.Pd' }}
                            </h4>
                            <p class="text-[10px] text-blue-700 font-bold mt-1 leading-none break-words text-center m-0">
                                {{ $tree['naib_mudir']->position ?? 'Naib Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bagan Footer Legend Sesuai Bagan Resmi PPRU -->
            <div class="pt-4 mt-4 border-t border-slate-200 flex flex-wrap items-center justify-between text-[10px] text-slate-500">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-amber-500 inline-block"></span>
                        <span class="font-bold text-slate-700">Dewan Pembina YAPIRUS</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-blue-600 inline-block"></span>
                        <span class="font-bold text-slate-700">Pengurus Harian YAPIRUS</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-emerald-700 inline-block"></span>
                        <span class="font-bold text-slate-700">Dewan Pengawas YAPIRUS</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-[#00843d] inline-block"></span>
                        <span class="font-bold text-slate-700">Pimpinan Utama (Mudir Ma'had)</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-purple-600 inline-block"></span>
                        <span class="font-bold text-slate-700">Wakil Pimpinan Pesantren</span>
                    </span>
                </div>
                <span class="font-bold text-slate-400">Pondok Pesantren Raudhatul Ulum Sakatiga &copy; 2026</span>
            </div>

        </div>
    </div>
</div>
