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
            <!-- LEVEL 1: DEWAN PEMBINA & KETUA UMUM YAYASAN (YAPIRUS) -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <div class="w-[620px] mx-auto flex justify-between items-stretch">
                    
                    <!-- Dewan Pembina Yayasan Card -->
                    <div class="w-[290px] rounded-xl bg-white border-2 border-amber-500 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-t-lg px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-crown text-xs text-amber-200"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider text-center">
                                DEWAN PEMBINA YAPIRUS
                            </span>
                        </div>
                        <div class="h-16 px-3 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-tight text-center m-0">
                                {{ $tree['pembina']->name ?? 'Drs. KH. Karim Kasim' }}
                            </h3>
                            <p class="text-[10px] text-amber-700 font-bold mt-1 leading-none text-center m-0">
                                {{ $tree['pembina']->position ?? 'Ketua Dewan Pembina YAPIRUS' }}
                            </p>
                        </div>
                    </div>

                    <!-- Ketua Umum Pengurus Yayasan Card -->
                    <div class="w-[290px] rounded-xl bg-white border-2 border-emerald-600 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-emerald-700 to-[#00843d] text-white rounded-t-lg px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-building-columns text-xs text-emerald-200"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider text-center">
                                PENGURUS HARIAN YAYASAN
                            </span>
                        </div>
                        <div class="h-16 px-3 py-1.5 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-tight text-center m-0">
                                {{ $tree['ketua_yayasan']->name ?? 'H. Faisal Abdullah, S.T.' }}
                            </h3>
                            <p class="text-[10px] text-emerald-700 font-bold mt-1 leading-none text-center m-0">
                                {{ $tree['ketua_yayasan']->position ?? 'Ketua Umum Pengurus YAPIRUS' }}
                            </p>
                        </div>
                    </div>

                </div>

                <!-- SVG Bracket Connector from Level 1 down to Mudir Pesantren -->
                <svg class="w-[620px] h-7 text-[#00843d] mx-auto block" viewBox="0 0 620 28" fill="none">
                    <path d="M 145 0 V 14 M 465 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 145 14 H 465" stroke="currentColor" stroke-width="2"/>
                    <path d="M 310 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 2: MUDIR PONDOK PESANTREN (PIMPINAN UTAMA MA'HAD) -->
            <!-- ==================================================== -->
            <div class="flex flex-col items-center">
                <div class="w-[360px] rounded-xl bg-white border-2 border-[#00843d] shadow-lg">
                    <div class="h-9 bg-gradient-to-r from-emerald-800 via-[#00843d] to-emerald-700 text-white rounded-t-lg px-3 flex items-center justify-center gap-2 text-center">
                        <i class="fa-solid fa-user-check text-xs text-amber-300"></i>
                        <span class="text-xs font-black uppercase tracking-wider text-center">
                            PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)
                        </span>
                    </div>
                    <div class="h-16 px-4 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 leading-tight text-center m-0">
                            {{ $tree['mudir']->name ?? "KH. Tol'at Wafa Ahmad, Lc." }}
                        </h3>
                        <p class="text-[11px] text-[#00843d] font-bold mt-1 leading-none text-center m-0">
                            {{ $tree['mudir']->position ?? 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga' }}
                        </p>
                    </div>
                </div>

                <!-- Vertical Connector from Mudir down to Administration & Operasional -->
                <div class="w-[2px] h-5 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: SEKRETARIS & BENDAHARA YAYASAN (SAYAP PENGELOLA) -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- SVG Bracket Connector Sekretaris & Bendahara -->
                <svg class="w-[740px] h-7 text-[#00843d] mx-auto block" viewBox="0 0 740 28" fill="none">
                    <path d="M 370 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 130 14 H 610" stroke="currentColor" stroke-width="2"/>
                    <path d="M 130 14 V 28 M 610 14 V 28" stroke="currentColor" stroke-width="2"/>
                    <!-- Direct Line to ASDIR Below -->
                    <path d="M 370 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <div class="w-[740px] mx-auto flex justify-between items-center">
                    <!-- Sekretaris Yayasan Card (Warna Hijau Teal, Bukan Hitam) -->
                    <div class="w-[240px] rounded-xl bg-white border border-teal-300 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-teal-800 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-file-signature text-[10px] text-emerald-200"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">SEKRETARIS YAYASAN</span>
                        </div>
                        <div class="h-12 px-2 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-tight truncate w-full text-center m-0">
                                {{ $tree['sekretaris']->name ?? 'Ustadz H. Ahmad Dailami, S.Pd.I.' }}
                            </h4>
                            <p class="text-[9px] text-teal-700 font-semibold mt-0.5 leading-none text-center m-0 truncate w-full" title="{{ $tree['sekretaris']->position ?? 'Sekretaris Yayasan YAPIRUS' }}">
                                {{ $tree['sekretaris']->position ?? 'Sekretaris Yayasan YAPIRUS' }}
                            </p>
                        </div>
                    </div>


                    <!-- Bendahara Yayasan Card (Warna Hijau Zamrud, Bukan Hitam) -->
                    <div class="w-[240px] rounded-xl bg-white border border-emerald-300 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-emerald-800 to-emerald-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-coins text-[10px] text-amber-300"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">BENDAHARA YAYASAN</span>
                        </div>
                        <div class="h-12 px-2 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-tight truncate w-full text-center m-0">
                                {{ $tree['bendahara']->name ?? 'H. M. Husin, M.Si.' }}
                            </h4>
                            <p class="text-[9px] text-emerald-700 font-semibold mt-0.5 leading-none text-center m-0 truncate w-full" title="{{ $tree['bendahara']->position ?? 'Bendahara Yayasan YAPIRUS' }}">
                                {{ $tree['bendahara']->position ?? 'Bendahara Yayasan YAPIRUS' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Connector down from Center to ASDIR / Wakil Mudir -->
                <div class="w-[2px] h-5 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: WAKIL MUDIR / ASISTEN MUDIR OPERASIONAL     -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- SVG Bracket Connector Wakil Mudir 3 Bidang (Lebar 920px) -->
                <svg class="w-[920px] h-7 text-[#00843d] mx-auto block" viewBox="0 0 920 28" fill="none">
                    <path d="M 460 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 140 14 H 780" stroke="currentColor" stroke-width="2"/>
                    <path d="M 140 14 V 28 M 460 14 V 28 M 780 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <div class="w-[920px] mx-auto flex justify-between items-stretch">
                    
                    <!-- Wadir 1: Pendidikan -->
                    <div class="w-[260px] rounded-xl bg-white border border-emerald-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-graduation-cap text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR I &bull; PENDIDIKAN</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-tight truncate w-full text-center m-0">
                                {{ $tree['wadir_pendidikan']->name ?? ($tree['wakil_mudir'][0]->name ?? 'Ustadz H. Abdul Halim, Lc.') }}
                            </h4>
                            <p class="text-[9px] text-emerald-700 font-medium mt-0.5 leading-none text-center m-0 truncate w-full" title="{{ $tree['wadir_pendidikan']->position ?? ($tree['wakil_mudir'][0]->position ?? 'Wakil Mudir Bidang Pendidikan') }}">
                                {{ $tree['wadir_pendidikan']->position ?? ($tree['wakil_mudir'][0]->position ?? 'Wakil Mudir Bidang Pendidikan') }}
                            </p>
                        </div>
                    </div>

                    <!-- Wadir 2: Kepengasuhan -->
                    <div class="w-[260px] rounded-xl bg-white border border-amber-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-users text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR II &bull; PENGASUHAN</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-tight truncate w-full text-center m-0">
                                {{ $tree['wadir_pengasuhan']->name ?? ($tree['wakil_mudir'][1]->name ?? 'Ustadz H. Syamsuddin, S.Ag.') }}
                            </h4>
                            <p class="text-[9px] text-amber-700 font-medium mt-0.5 leading-none text-center m-0 truncate w-full" title="{{ $tree['wadir_pengasuhan']->position ?? ($tree['wakil_mudir'][1]->position ?? 'Wakil Mudir Bidang Kepengasuhan') }}">
                                {{ $tree['wadir_pengasuhan']->position ?? ($tree['wakil_mudir'][1]->position ?? 'Wakil Mudir Bidang Kepengasuhan') }}
                            </p>
                        </div>
                    </div>

                    <!-- Wadir 3: Sarana & Pembangunan -->
                    <div class="w-[260px] rounded-xl bg-white border border-sky-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-layer-group text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR III &bull; SARPRAS</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 leading-tight truncate w-full text-center m-0">
                                {{ $tree['wadir_sarpras']->name ?? ($tree['wakil_mudir'][2]->name ?? 'Ir. H. Ahmad Fauzi') }}
                            </h4>
                            <p class="text-[9px] text-sky-700 font-medium mt-0.5 leading-none text-center m-0 truncate w-full" title="{{ $tree['wadir_sarpras']->position ?? ($tree['wakil_mudir'][2]->position ?? 'Wakil Mudir Bidang Sarpras') }}">
                                {{ $tree['wadir_sarpras']->position ?? ($tree['wakil_mudir'][2]->position ?? 'Wakil Mudir Bidang Sarpras') }}
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Direct Connector down to Unit Pendidikan -->
                <div class="w-[2px] h-5 bg-[#00843d]"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 5: PIMPINAN UNIT PENDIDIKAN & LEMBAGA (8 UNIT) -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center pt-1">
                <!-- SVG Bracket Connector 8 Unit Pendidikan (Lebar 1120px) -->
                <svg class="w-[1120px] h-7 text-[#00843d] mx-auto block" viewBox="0 0 1120 28" fill="none">
                    <path d="M 560 0 V 14" stroke="currentColor" stroke-width="2"/>
                    <path d="M 65 14 H 1055" stroke="currentColor" stroke-width="2"/>
                    <path d="M 65 14 V 28 M 205 14 V 28 M 345 14 V 28 M 485 14 V 28 M 635 14 V 28 M 775 14 V 28 M 915 14 V 28 M 1055 14 V 28" stroke="currentColor" stroke-width="2"/>
                </svg>

                <div class="w-[1120px] mx-auto grid grid-cols-8 gap-2">
                    @php
                        $unitModels = \App\Models\UnitPendidikan::active()->orderBy('order', 'asc')->get();
                    @endphp

                    @foreach($unitModels as $u)
                        <div class="rounded-xl bg-white border border-emerald-500 shadow-xs p-2 text-center flex flex-col justify-between min-h-[76px]">
                            <span class="inline-block bg-emerald-50 text-emerald-800 text-[9px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider mx-auto">
                                {{ $u->short_name ?: 'UNIT' }}
                            </span>
                            <div>
                                <h5 class="text-[10px] font-black text-slate-900 leading-tight truncate w-full mt-1" title="{{ $u->head_name }}">
                                    {{ $u->head_name ?: 'Kepala Lembaga' }}
                                </h5>
                                <p class="text-[8.5px] text-slate-500 font-medium truncate w-full leading-none mt-0.5" title="{{ $u->name }}">
                                    {{ Str::limit($u->name, 22) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bagan Footer Legend -->
            <div class="pt-4 mt-2 border-t border-slate-200 flex flex-wrap items-center justify-between text-[10px] text-slate-500">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-amber-500 inline-block"></span>
                        <span>Badan Pembina Yayasan</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-[#00843d] inline-block"></span>
                        <span>Pimpinan Utama Pesantren (Mudir Ma'had)</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-teal-700 inline-block"></span>
                        <span>Sekretariat &amp; Kebendaharaan</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-md bg-teal-600 inline-block"></span>
                        <span>Pimpinan Unit Pendidikan</span>
                    </span>
                </div>
                <span class="font-bold text-slate-400">Pondok Pesantren Raudhatul Ulum Sakatiga &copy; {{ date('Y') }}</span>
            </div>

        </div>
    </div>
</div>
