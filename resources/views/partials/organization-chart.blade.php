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

        const doCapture = () => {
            const renderCanvas = () => {
                html2canvas(target, {
                    scale: 3,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    windowWidth: 1180,
                    windowHeight: target.scrollHeight,
                    onclone: (clonedDoc) => {
                        const canvasEl = clonedDoc.getElementById('org-chart-canvas');
                        if (canvasEl) {
                            canvasEl.style.transform = 'none';
                            canvasEl.style.width = '1180px';
                            canvasEl.style.maxWidth = '1180px';
                            canvasEl.style.overflow = 'visible';
                            canvasEl.querySelectorAll('*').forEach(el => {
                                el.style.overflow = 'visible';
                            });
                        }
                    }
                }).then(canvas => {
                    target.style.transform = prevTransform;
                    this.isExporting = false;
                    const link = document.createElement('a');
                    link.download = 'bagan-struktur-organisasi-ppru-sakatiga.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bagan Berhasil Diunduh!',
                            text: 'File gambar bagan landscape resolusi tinggi telah disimpan dalam format PNG dengan garis presisi tanpa terpotong.',
                            timer: 2500,
                            showConfirmButton: false,
                        });
                    }
                }).catch(err => {
                    target.style.transform = prevTransform;
                    this.isExporting = false;
                    console.error(err);
                    alert('Gagal mengekspor gambar bagan.');
                });
            };

            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(renderCanvas);
            } else {
                renderCanvas();
            }
        };

        if (typeof html2canvas === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js';
            script.onload = doCapture;
            document.head.appendChild(script);
        } else {
            doCapture();
        }
    }
}" class="space-y-3" id="org-chart-root">

    <style>
        #org-chart-canvas {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
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
            }
        }
    </style>

    <!-- Top Action Bar & Controls -->
    <div class="flex flex-wrap items-center justify-between gap-2.5 p-3 sm:p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm print:hidden">
        
        <!-- Legend / Info -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#00843d] flex items-center justify-center font-bold text-sm sm:text-base shadow-sm border border-emerald-200 dark:border-emerald-900/40">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <div>
                <h4 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white flex items-center gap-1.5">
                    <span>Bagan Alur &amp; Hirarki Kepengurusan Yayasan &amp; Pesantren</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        Format Landscape Simetris
                    </span>
                </h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Bagan resmi: Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) &amp; Pimpinan PPRU</p>
            </div>
        </div>

        <!-- Interactive Tools (Zoom, Download, Print, Fullscreen) -->
        <div class="flex flex-wrap items-center gap-1.5">
            <!-- Zoom Controls -->
            <div class="flex items-center bg-slate-100 dark:bg-slate-800 p-0.5 rounded-xl border border-slate-200 dark:border-slate-700">
                <button type="button" @click="zoomOut()" aria-label="Perkecil (-)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all cursor-pointer" title="Perkecil (-)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <span class="px-2 text-[10px] sm:text-xs font-bold text-slate-700 dark:text-slate-300 min-w-[2.8rem] text-center" x-text="zoomLevel + '%'">100%</span>
                <button type="button" @click="zoomIn()" aria-label="Perbesar (+)" class="w-7 h-7 rounded-lg flex items-center justify-center text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-xs font-bold transition-all cursor-pointer" title="Perbesar (+)">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <button type="button" @click="resetZoom()" aria-label="Reset Zoom" class="px-2 py-1 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-700 transition-all cursor-pointer" title="Reset Ukuran">
                    Reset
                </button>
            </div>

            <!-- Fullscreen Button -->
            <button type="button" @click="toggleFullscreen()" aria-label="Layar Penuh" class="h-8 px-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer" title="Layar Penuh">
                <i class="fa-solid fa-expand"></i>
                <span class="hidden md:inline">Layar Penuh</span>
            </button>

            <!-- Export Image Button -->
            <button type="button" @click="exportChartImage()" :disabled="isExporting" aria-label="Unduh Gambar PNG Landscape" class="h-8 px-3 rounded-xl bg-[#00843d] hover:bg-[#006830] text-white text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all cursor-pointer disabled:opacity-50">
                <i class="fa-solid fa-download" :class="isExporting ? 'fa-bounce' : ''"></i>
                <span x-text="isExporting ? 'Memproses...' : 'Unduh PNG'">Unduh PNG</span>
            </button>

            <!-- Print Button -->
            <button type="button" onclick="window.print()" aria-label="Cetak Bagan" class="h-8 px-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span class="hidden md:inline">Cetak</span>
            </button>
        </div>
    </div>

    <!-- Chart Canvas Container (Landscape Scroll Wrapper) -->
    <div id="org-chart-wrapper" class="relative w-full overflow-x-auto rounded-3xl bg-slate-100/70 dark:bg-slate-950/70 border border-slate-200 dark:border-slate-800 shadow-inner p-3 sm:p-5 transition-all">
        
        <!-- The Printable & Exportable Canvas (Landscape Width ~1180px, Simetris & Anti-Clipping) -->
        <div id="org-chart-canvas" 
             :style="'transform: scale(' + (zoomLevel / 100) + '); transform-origin: top center; transition: transform 0.2s ease-out;'"
             class="w-[1180px] mx-auto p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md space-y-5"
             style="background-image: radial-gradient(rgba(0, 132, 61, 0.06) 1px, transparent 1px); background-size: 16px 16px;">
            
            <!-- Bagan Header Title dengan Logo PPRU Resmi -->
            <div class="text-center pb-4 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-center mb-2.5">
                    <img src="/uploads/logo-ppru-transparent.png" 
                         alt="Logo Pondok Pesantren Raudhatul Ulum Sakatiga" 
                         class="h-16 w-auto object-contain drop-shadow-sm" 
                         loading="eager" 
                         onerror="this.src='/uploads/logo-ppru-square.png'">
                </div>

                <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white uppercase tracking-wider leading-snug text-center m-0">
                    STRUKTUR ORGANISASI YAYASAN &amp; PIMPINAN PESANTREN
                </h2>
                <div class="flex items-center justify-center gap-2 mt-1">
                    <span class="text-xs sm:text-sm font-extrabold text-[#00843d] dark:text-emerald-400">
                        YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)
                    </span>
                    <span class="text-slate-300 dark:text-slate-700">&bull;</span>
                    <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300">
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
                    <div class="w-[290px] rounded-xl bg-white dark:bg-slate-800 border-2 border-amber-500 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-t-lg px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-crown text-xs text-amber-200"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider text-center">
                                DEWAN PEMBINA YAPIRUS
                            </span>
                        </div>
                        <div class="h-16 px-3 py-1.5 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight text-center m-0">
                                {{ $tree['pembina']->name ?? 'Drs. KH. Karim Kasim' }}
                            </h3>
                            <p class="text-[10px] text-amber-700 dark:text-amber-400 font-bold mt-1 leading-none text-center m-0">
                                {{ $tree['pembina']->position ?? 'Ketua Dewan Pembina Yayasan' }}
                            </p>
                        </div>
                    </div>

                    <!-- Ketua Umum Pengurus Yayasan Card -->
                    <div class="w-[290px] rounded-xl bg-white dark:bg-slate-800 border-2 border-emerald-600 shadow-md">
                        <div class="h-8 bg-gradient-to-r from-emerald-700 to-[#00843d] text-white rounded-t-lg px-3 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-building-columns text-xs text-emerald-200"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider text-center">
                                PENGURUS HARIAN YAYASAN
                            </span>
                        </div>
                        <div class="h-16 px-3 py-1.5 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white leading-tight text-center m-0">
                                {{ $tree['ketua_yayasan']->name ?? 'H. Faisal Abdullah, S.T.' }}
                            </h3>
                            <p class="text-[10px] text-emerald-700 dark:text-emerald-400 font-bold mt-1 leading-none text-center m-0">
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
                <div class="w-[360px] rounded-xl bg-white dark:bg-slate-800 border-2 border-[#00843d] shadow-lg">
                    <div class="h-9 bg-gradient-to-r from-emerald-800 via-[#00843d] to-emerald-700 text-white rounded-t-lg px-3 flex items-center justify-center gap-2 text-center">
                        <i class="fa-solid fa-user-check text-xs text-amber-300"></i>
                        <span class="text-xs font-black uppercase tracking-wider text-center">
                            PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)
                        </span>
                    </div>
                    <div class="h-16 px-4 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                        <h3 class="text-sm sm:text-base font-black text-slate-900 dark:text-white leading-tight text-center m-0">
                            {{ $tree['mudir']->name ?? "KH. Tol'at Wafa Ahmad, Lc." }}
                        </h3>
                        <p class="text-[11px] text-[#00843d] dark:text-emerald-400 font-bold mt-1 leading-none text-center m-0">
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
                    <!-- Sekretaris Yayasan Card -->
                    <div class="w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 shadow-xs">
                        <div class="h-7 bg-slate-800 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-file-signature text-[10px] text-emerald-300"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">SEKRETARIS YAYASAN</span>
                        </div>
                        <div class="h-12 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white leading-tight truncate w-full text-center m-0">
                                {{ $tree['sekretaris']->name ?? 'Ustadz H. Ahmad Dailami, S.Pd.I.' }}
                            </h4>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400 font-semibold mt-0.5 leading-none text-center m-0">
                                Administrasi &amp; Legalitas
                            </p>
                        </div>
                    </div>

                    <!-- Center Badge (Operasional Ma'had) -->
                    <div class="px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-[#00843d] text-[10px] font-extrabold shadow-xs">
                        <i class="fa-solid fa-diagram-project mr-1"></i> KOORDINASI BIDANG
                    </div>

                    <!-- Bendahara Yayasan Card -->
                    <div class="w-[240px] rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 shadow-xs">
                        <div class="h-7 bg-slate-800 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-coins text-[10px] text-amber-300"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">BENDAHARA YAYASAN</span>
                        </div>
                        <div class="h-12 px-2 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white leading-tight truncate w-full text-center m-0">
                                {{ $tree['bendahara']->name ?? 'H. M. Husin, M.Si.' }}
                            </h4>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400 font-semibold mt-0.5 leading-none text-center m-0">
                                Keuangan &amp; Akuntabilitas Wakaf
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
                    <div class="w-[260px] rounded-xl bg-white dark:bg-slate-800 border border-emerald-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-graduation-cap text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR I &bull; PENDIDIKAN</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white leading-tight truncate w-full text-center m-0">
                                {{ $tree['wakil_mudir'][0]->name ?? 'Ustadz H. Abdul Halim, Lc.' }}
                            </h4>
                            <p class="text-[9px] text-emerald-700 dark:text-emerald-400 font-medium mt-0.5 leading-none text-center m-0">
                                Kurikulum Nasional &amp; Muadalah Al-Azhar
                            </p>
                        </div>
                    </div>

                    <!-- Wadir 2: Kepengasuhan -->
                    <div class="w-[260px] rounded-xl bg-white dark:bg-slate-800 border border-amber-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-users text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR II &bull; PENGASUHAN</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white leading-tight truncate w-full text-center m-0">
                                {{ $tree['wakil_mudir'][1]->name ?? 'Ustadz H. Syamsuddin, S.Ag.' }}
                            </h4>
                            <p class="text-[9px] text-amber-700 dark:text-amber-400 font-medium mt-0.5 leading-none text-center m-0">
                                Disiplin Asrama, Bahasa &amp; Karakter Santri
                            </p>
                        </div>
                    </div>

                    <!-- Wadir 3: Sarana & Pembangunan -->
                    <div class="w-[260px] rounded-xl bg-white dark:bg-slate-800 border border-sky-500 shadow-xs">
                        <div class="h-7 bg-gradient-to-r from-sky-600 to-blue-600 text-white rounded-t-lg px-2 flex items-center justify-center gap-1.5 text-center">
                            <i class="fa-solid fa-layer-group text-[10px]"></i>
                            <span class="text-[10px] font-black uppercase tracking-wide text-center">WAKIL MUDIR III &bull; SARPRAS</span>
                        </div>
                        <div class="h-14 px-2.5 py-1 text-center bg-white dark:bg-slate-800 rounded-b-lg flex flex-col justify-center items-center">
                            <h4 class="text-xs font-black text-slate-900 dark:text-white leading-tight truncate w-full text-center m-0">
                                {{ $tree['wakil_mudir'][2]->name ?? 'Ir. H. Ahmad Fauzi' }}
                            </h4>
                            <p class="text-[9px] text-sky-700 dark:text-sky-400 font-medium mt-0.5 leading-none text-center m-0">
                                Infrastruktur, Aset Wakaf &amp; Fasilitas
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
                        $unitLeaders = [
                            ['code' => 'MARU', 'unit' => 'Madrasah Aliyah', 'leader' => 'Ust. H. M. Said, S.Ag.', 'color' => 'border-emerald-500 text-emerald-800', 'bg' => 'bg-emerald-50'],
                            ['code' => 'SMAIT', 'unit' => 'SMA Islam Terpadu', 'leader' => 'Ust. Ahmad Fauzi, M.Pd.', 'color' => 'border-teal-500 text-teal-800', 'bg' => 'bg-teal-50'],
                            ['code' => 'MATSARU', 'unit' => 'Madrasah Tsanawiyah', 'leader' => 'Ust. Drs. H. Syamsuddin', 'color' => 'border-green-500 text-green-800', 'bg' => 'bg-green-50'],
                            ['code' => 'SMPIT', 'unit' => 'SMP Islam Terpadu', 'leader' => 'Ust. Ridwan, S.Pd.I.', 'color' => 'border-sky-500 text-sky-800', 'bg' => 'bg-sky-50'],
                            ['code' => 'MATQULARU', 'unit' => 'Tahfizhul Qur\'an', 'leader' => 'Ust. H. Abdul Halim', 'color' => 'border-amber-500 text-amber-800', 'bg' => 'bg-amber-50'],
                            ['code' => 'MIRU', 'unit' => 'Madrasah Ibtidaiyah', 'leader' => 'Usth. Hj. Maryam, S.Pd.I.', 'color' => 'border-lime-500 text-lime-800', 'bg' => 'bg-lime-50'],
                            ['code' => 'TAKIRU', 'unit' => 'TK Islam RU', 'leader' => 'Usth. Fatimah, S.Pd.', 'color' => 'border-orange-500 text-orange-800', 'bg' => 'bg-orange-50'],
                            ['code' => 'IAI NRU', 'unit' => 'Institut Agama Islam', 'leader' => 'Dr. H. M. Husin, M.A.', 'color' => 'border-indigo-500 text-indigo-800', 'bg' => 'bg-indigo-50'],
                        ];
                    @endphp

                    @foreach($unitLeaders as $ul)
                        <div class="rounded-xl bg-white dark:bg-slate-800 border {{ $ul['color'] }} shadow-xs p-2 text-center flex flex-col justify-between min-h-[76px]">
                            <span class="inline-block {{ $ul['bg'] }} {{ $ul['color'] }} text-[9px] font-black px-1.5 py-0.5 rounded uppercase tracking-wider mx-auto">
                                {{ $ul['code'] }}
                            </span>
                            <div>
                                <h5 class="text-[10px] font-black text-slate-900 dark:text-white leading-tight truncate w-full mt-1">
                                    {{ $ul['leader'] }}
                                </h5>
                                <p class="text-[8.5px] text-slate-500 dark:text-slate-400 font-medium truncate w-full leading-none mt-0.5">
                                    {{ $ul['unit'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bagan Footer Legend -->
            <div class="pt-4 mt-2 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between text-[10px] text-slate-500 dark:text-slate-400">
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
                        <span class="w-3 h-3 rounded-md bg-slate-800 inline-block"></span>
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
