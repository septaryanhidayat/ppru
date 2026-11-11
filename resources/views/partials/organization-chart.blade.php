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
             style="background-color: #ffffff; background-image: none; width: 1180px; min-width: 1180px;">
            
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
                <div style="width: 360px; background-color: #ffffff; border: 2px solid #d97706; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin: 0 auto;">
                    <div style="height: 32px; background: linear-gradient(135deg, #d97706, #b45309) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 0 12px; text-align: center;">
                        <i class="fa-solid fa-crown" style="font-size: 12px; color: #fde68a;"></i>
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                            DEWAN PEMBINA YAPIRUS
                        </span>
                    </div>
                    <div style="min-h: 58px; padding: 8px 12px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h3 style="font-size: 13px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                            {{ $tree['pembina_ketua']->name ?? ($tree['pembina']->name ?? "KH. Tol'at Wafa Ahmad, Lc.") }}
                        </h3>
                        <p style="font-size: 10px; font-weight: 700; color: #b45309; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                            {{ $tree['pembina_ketua']->position ?? ($tree['pembina']->position ?? 'Ketua Dewan Pembina YAPIRUS') }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 5 Anggota Dewan Pembina (Centers at 114, 342, 570, 798, 1026) -->
                <svg style="width: 1140px; height: 28px; display: block; margin: 0 auto;" viewBox="0 0 1140 28" fill="none">
                    <path d="M 570 0 V 14" stroke="#00843d" stroke-width="2"/>
                    <path d="M 114 14 H 1026" stroke="#00843d" stroke-width="2"/>
                    <path d="M 114 14 V 28 M 342 14 V 28 M 570 14 V 28 M 798 14 V 28 M 1026 14 V 28" stroke="#00843d" stroke-width="2"/>
                </svg>

                <!-- 5 Anggota Dewan Pembina (Explicit Inline Flex Row, 5 Horizontal Columns) -->
                <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: stretch; width: 1140px; margin: 0 auto; gap: 12px;">
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
                        <div style="flex: 1 1 0; min-width: 0; width: 216px; background-color: #ffffff; border: 1.5px solid #00843d; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                            <div style="height: 28px; background: linear-gradient(135deg, #047857, #00843d) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 6px; text-align: center;">
                                <i class="fa-solid fa-user-group" style="font-size: 10px; color: #a7f3d0;"></i>
                                <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; white-space: nowrap;">ANGGOTA DEWAN PEMBINA</span>
                            </div>
                            <div style="min-height: 48px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                    {{ $name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector line from Level 1 down to Level 2 -->
                <div style="width: 2px; height: 24px; background-color: #00843d; margin: 0 auto;"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 2: PENGURUS HARIAN YAPIRUS                     -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Ketua Dewan Harian YAPIRUS Card -->
                <div style="width: 360px; background-color: #ffffff; border: 2px solid #2563eb; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin: 0 auto;">
                    <div style="height: 32px; background: linear-gradient(135deg, #1d4ed8, #2563eb) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 0 12px; text-align: center;">
                        <i class="fa-solid fa-building-columns" style="font-size: 12px; color: #bfdbfe;"></i>
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                            PENGURUS HARIAN
                        </span>
                    </div>
                    <div style="min-height: 58px; padding: 8px 12px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h3 style="font-size: 13px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                            {{ $tree['harian_ketua']->name ?? ($tree['ketua_yayasan']->name ?? 'Dr. H. Husnul Amin, Lc., M.H.I., MM.') }}
                        </h3>
                        <p style="font-size: 10px; font-weight: 700; color: #1d4ed8; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                            {{ $tree['harian_ketua']->position ?? 'Ketua Dewan Harian YAPIRUS' }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 4 Pengurus Harian (Sekretaris & Bendahara) -->
                <svg style="width: 1040px; height: 28px; display: block; margin: 0 auto;" viewBox="0 0 1040 28" fill="none">
                    <path d="M 520 0 V 14" stroke="#0d9488" stroke-width="2"/>
                    <path d="M 125 14 H 915" stroke="#0d9488" stroke-width="2"/>
                    <path d="M 125 14 V 28 M 388 14 V 28 M 652 14 V 28 M 915 14 V 28" stroke="#0d9488" stroke-width="2"/>
                </svg>

                <!-- 4 Pengurus Harian (Explicit Inline Flex Row, 4 Columns) -->
                <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: stretch; width: 1040px; margin: 0 auto; gap: 14px;">
                    <!-- Sekretaris -->
                    <div style="flex: 1 1 0; min-width: 0; width: 245px; background-color: #ffffff; border: 1.5px solid #0d9488; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <div style="height: 26px; background: linear-gradient(135deg, #0f766e, #0d9488) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 8px; text-align: center;">
                            <i class="fa-solid fa-file-signature" style="font-size: 10px; color: #99f6e4;"></i>
                            <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">SEKRETARIS YAYASAN</span>
                        </div>
                        <div style="min-height: 52px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['sekretaris_1']->name ?? ($tree['sekretaris']->name ?? 'Salamuddin, S.Si.') }}
                            </h4>
                            <p style="font-size: 9px; font-weight: 700; color: #0f766e; margin-top: 2px; line-height: 1.2; text-align: center;">Sekretaris</p>
                        </div>
                    </div>

                    <!-- Wakil Sekretaris -->
                    <div style="flex: 1 1 0; min-width: 0; width: 245px; background-color: #ffffff; border: 1.5px solid #0d9488; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <div style="height: 26px; background: linear-gradient(135deg, #0f766e, #0d9488) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 8px; text-align: center;">
                            <i class="fa-solid fa-file-lines" style="font-size: 10px; color: #99f6e4;"></i>
                            <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">SEKRETARIS YAYASAN</span>
                        </div>
                        <div style="min-height: 52px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['sekretaris_2']->name ?? 'H. Muhammad Rido, S.Ag.' }}
                            </h4>
                            <p style="font-size: 9px; font-weight: 700; color: #0f766e; margin-top: 2px; line-height: 1.2; text-align: center;">Wakil Sekretaris</p>
                        </div>
                    </div>

                    <!-- Bendahara -->
                    <div style="flex: 1 1 0; min-width: 0; width: 245px; background-color: #ffffff; border: 1.5px solid #0d9488; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <div style="height: 26px; background: linear-gradient(135deg, #0f766e, #0d9488) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 8px; text-align: center;">
                            <i class="fa-solid fa-coins" style="font-size: 10px; color: #fde68a;"></i>
                            <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">BENDAHARA YAYASAN</span>
                        </div>
                        <div style="min-height: 52px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['bendahara_1']->name ?? ($tree['bendahara']->name ?? 'Hj. Risa Fauziah Aristina') }}
                            </h4>
                            <p style="font-size: 9px; font-weight: 700; color: #0f766e; margin-top: 2px; line-height: 1.2; text-align: center;">Bendahara</p>
                        </div>
                    </div>

                    <!-- Wakil Bendahara -->
                    <div style="flex: 1 1 0; min-width: 0; width: 245px; background-color: #ffffff; border: 1.5px solid #0d9488; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                        <div style="height: 26px; background: linear-gradient(135deg, #0f766e, #0d9488) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 8px; text-align: center;">
                            <i class="fa-solid fa-coins" style="font-size: 10px; color: #fde68a;"></i>
                            <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">BENDAHARA YAYASAN</span>
                        </div>
                        <div style="min-height: 52px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['bendahara_2']->name ?? 'Maila Rasyidah, Lc' }}
                            </h4>
                            <p style="font-size: 9px; font-weight: 700; color: #0f766e; margin-top: 2px; line-height: 1.2; text-align: center;">Wakil Bendahara</p>
                        </div>
                    </div>
                </div>

                <!-- Connector line from Level 2 down to Level 3 -->
                <div style="width: 2px; height: 24px; background-color: #00843d; margin: 0 auto;"></div>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 3: DEWAN PENGAWAS                              -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <!-- Ketua Dewan Pengawas Card -->
                <div style="width: 360px; background-color: #ffffff; border: 2px solid #047857; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin: 0 auto;">
                    <div style="height: 32px; background: linear-gradient(135deg, #065f46, #047857) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 0 12px; text-align: center;">
                        <i class="fa-solid fa-shield-halved" style="font-size: 12px; color: #fde68a;"></i>
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                            DEWAN PENGAWAS
                        </span>
                    </div>
                    <div style="min-height: 58px; padding: 8px 12px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h3 style="font-size: 13px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                            {{ $tree['pengawas_ketua']->name ?? 'Drs. KH. Ahmad Nahrowi, MM' }}
                        </h3>
                        <p style="font-size: 10px; font-weight: 700; color: #047857; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                            {{ $tree['pengawas_ketua']->position ?? 'Ketua Dewan Pengawas' }}
                        </p>
                    </div>
                </div>

                <!-- SVG Bracket Connector to 5 Anggota Dewan Pengawas (Centers at 114, 342, 570, 798, 1026) -->
                <svg style="width: 1140px; height: 28px; display: block; margin: 0 auto;" viewBox="0 0 1140 28" fill="none">
                    <path d="M 570 0 V 14" stroke="#00843d" stroke-width="2"/>
                    <path d="M 114 14 H 1026" stroke="#00843d" stroke-width="2"/>
                    <path d="M 114 14 V 28 M 342 14 V 28 M 570 14 V 28 M 798 14 V 28 M 1026 14 V 28" stroke="#00843d" stroke-width="2"/>
                </svg>

                <!-- 5 Anggota Dewan Pengawas (Explicit Inline Flex Row, 5 Horizontal Columns) -->
                <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: stretch; width: 1140px; margin: 0 auto; gap: 12px;">
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
                        <div style="flex: 1 1 0; min-width: 0; width: 216px; background-color: #ffffff; border: 1.5px solid #00843d; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                            <div style="height: 28px; background: linear-gradient(135deg, #047857, #00843d) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 5px; padding: 0 6px; text-align: center;">
                                <i class="fa-solid fa-user-shield" style="font-size: 10px; color: #a7f3d0;"></i>
                                <span style="font-size: 9px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; white-space: nowrap;">ANGGOTA DEWAN PENGAWAS</span>
                            </div>
                            <div style="min-height: 48px; padding: 6px 8px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <h4 style="font-size: 11px; font-weight: 800; color: #0f172a; line-height: 1.25; margin: 0; text-align: center; word-break: break-word;">
                                    {{ $name }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- SVG Connector from Level 3 down to Level 4 (Mudir center 530, Naibah 155, Naib 905) -->
                <svg style="width: 1060px; height: 28px; display: block; margin: 0 auto;" viewBox="0 0 1060 28" fill="none">
                    <path d="M 530 0 V 28" stroke="#00843d" stroke-width="2"/>
                    <path d="M 155 14 H 905" stroke="#00843d" stroke-width="2"/>
                    <path d="M 155 14 V 28 M 905 14 V 28" stroke="#00843d" stroke-width="2"/>
                </svg>
            </div>

            <!-- ==================================================== -->
            <!-- LEVEL 4: PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)    -->
            <!-- ==================================================== -->
            <div class="relative flex flex-col items-center">
                <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: stretch; width: 1060px; margin: 0 auto;">
                    
                    <!-- Wakil Pimpinan Putri (Naibah Mudir) -->
                    <div style="width: 310px; background-color: #ffffff; border: 2px solid #7e22ce; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <div style="height: 32px; background: linear-gradient(135deg, #6b21a8, #7e22ce) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 0 12px; text-align: center;">
                            <i class="fa-solid fa-user-tie" style="font-size: 11px; color: #f3e8ff;"></i>
                            <span style="font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                                WAKIL PIMPINAN PONDOK PESANTREN
                            </span>
                        </div>
                        <div style="min-height: 60px; padding: 8px 12px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 13px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['naibah_mudir']->name ?? 'Maila Rasyidah, Lc' }}
                            </h4>
                            <p style="font-size: 10px; font-weight: 700; color: #7e22ce; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                                {{ $tree['naibah_mudir']->position ?? 'Naibah Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                    <!-- Mudir Pondok Pesantren (Pimpinan Utama) -->
                    <div style="width: 380px; background-color: #ffffff; border: 2px solid #00843d; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                        <div style="height: 36px; background: linear-gradient(135deg, #064e3b, #00843d) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0 12px; text-align: center;">
                            <i class="fa-solid fa-mosque" style="font-size: 12px; color: #fde68a;"></i>
                            <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                                PIMPINAN PONDOK PESANTREN (MUDIR MA'HAD)
                            </span>
                        </div>
                        <div style="min-height: 64px; padding: 8px 16px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h3 style="font-size: 14px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['mudir']->name ?? "KH. Tol'at Wafa Ahmad, Lc." }}
                            </h3>
                            <p style="font-size: 11px; font-weight: 700; color: #00843d; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                                {{ $tree['mudir']->position ?? 'Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                    <!-- Wakil Pimpinan Putra (Naib Mudir) -->
                    <div style="width: 310px; background-color: #ffffff; border: 2px solid #2563eb; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <div style="height: 32px; background: linear-gradient(135deg, #1e40af, #2563eb) !important; color: #ffffff !important; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 0 12px; text-align: center;">
                            <i class="fa-solid fa-user-tie" style="font-size: 11px; color: #dbeafe;"></i>
                            <span style="font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff;">
                                WAKIL PIMPINAN PONDOK PESANTREN
                            </span>
                        </div>
                        <div style="min-height: 60px; padding: 8px 12px; text-align: center; background-color: #ffffff; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <h4 style="font-size: 13px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0; text-align: center; word-break: break-word;">
                                {{ $tree['naib_mudir']->name ?? 'H. M. Akram Afifi, Lc., M.Pd' }}
                            </h4>
                            <p style="font-size: 10px; font-weight: 700; color: #1d4ed8; margin-top: 4px; line-height: 1.2; text-align: center; word-break: break-word;">
                                {{ $tree['naib_mudir']->position ?? 'Naib Mudir Pondok Pesantren Raudhatul Ulum' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bagan Footer Legend Sesuai Bagan Resmi PPRU -->
            <div style="padding-top: 16px; margin-top: 16px; border-top: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; font-size: 10px; color: #64748b;">
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 16px;">
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background-color: #d97706; display: inline-block;"></span>
                        <span style="font-weight: 700; color: #334155;">Dewan Pembina YAPIRUS</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background-color: #2563eb; display: inline-block;"></span>
                        <span style="font-weight: 700; color: #334155;">Pengurus Harian YAPIRUS</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background-color: #047857; display: inline-block;"></span>
                        <span style="font-weight: 700; color: #334155;">Dewan Pengawas YAPIRUS</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background-color: #00843d; display: inline-block;"></span>
                        <span style="font-weight: 700; color: #334155;">Pimpinan Utama (Mudir Ma'had)</span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background-color: #7e22ce; display: inline-block;"></span>
                        <span style="font-weight: 700; color: #334155;">Wakil Pimpinan Pesantren</span>
                    </span>
                </div>
                <span style="font-weight: 700; color: #94a3b8;">Pondok Pesantren Raudhatul Ulum Sakatiga &copy; 2026</span>
            </div>

        </div>
    </div>
</div>
