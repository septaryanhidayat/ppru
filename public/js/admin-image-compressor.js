/**
 * PPRU CMS - Client-Side Auto Image Compressor
 * Otomatis mengompres unggahan gambar (JPG/PNG/WEBP) di browser
 * menjadi ukuran kecil sekitar ~100 KB dengan kualitas visual HD yang tetap tajam & jernih.
 */
(function () {
    'use strict';

    function formatBytes(bytes) {
        if (!bytes || bytes <= 0) return '0 B';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(0) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    }

    /**
     * Kompres file gambar ke target ukuran ~100 KB dengan kualitas visual tinggi
     */
    function compressImageFile(file, maxWidth, maxHeight, targetKb) {
        maxWidth = maxWidth || 1600;
        maxHeight = maxHeight || 1600;
        targetKb = targetKb || 110; // Target sekitar 100-110 KB

        return new Promise(function (resolve) {
            // Abaikan file non-gambar atau SVG
            if (!file || !file.type || !file.type.startsWith('image/') || file.type === 'image/svg+xml') {
                return resolve(file);
            }

            // Jika ukuran berkas sudah <= targetKb, tidak perlu kompres
            if (file.size <= targetKb * 1024) {
                return resolve(file);
            }

            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = function () {
                URL.revokeObjectURL(objectUrl);

                let origW = img.naturalWidth || img.width;
                let origH = img.naturalHeight || img.height;

                function renderToCanvas(maxW, maxH) {
                    let w = origW;
                    let h = origH;
                    if (w > maxW || h > maxH) {
                        if (w > h) {
                            h = Math.round((h * maxW) / w);
                            w = maxW;
                        } else {
                            w = Math.round((w * maxH) / h);
                            h = maxH;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    ctx.imageSmoothingEnabled = true;
                    ctx.imageSmoothingQuality = 'high';
                    ctx.drawImage(img, 0, 0, w, h);
                    return canvas;
                }

                function exportBlob(canvas, quality, format) {
                    format = format || 'image/webp';
                    return new Promise(function (resBlob) {
                        canvas.toBlob(function (blob) {
                            if (blob) {
                                resBlob(blob);
                            } else {
                                // Fallback ke JPEG jika browser tidak mendukung export WebP
                                canvas.toBlob(resBlob, 'image/jpeg', quality);
                            }
                        }, format, quality);
                    });
                }

                // Render canvas dengan resolusi hingga 1600px (sangat tajam & jernih)
                const canvas1 = renderToCanvas(maxWidth, maxHeight);

                // Langkah 1: Kualitas 0.80 (HD jernih)
                exportBlob(canvas1, 0.80).then(function (blob1) {
                    if (!blob1) return resolve(file);

                    function createNewFile(finalBlob) {
                        const baseName = file.name.replace(/\.[^/.]+$/, '');
                        const ext = finalBlob.type === 'image/webp' ? '.webp' : (finalBlob.type === 'image/png' ? '.png' : '.jpg');
                        const newFile = new File([finalBlob], baseName + ext, {
                            type: finalBlob.type,
                            lastModified: Date.now()
                        });
                        resolve(newFile);
                    }

                    // Jika ukuran sudah mendekati target ~100-140 KB, langsung pakai
                    if (blob1.size <= 140 * 1024) {
                        return createNewFile(blob1);
                    }

                    // Langkah 2: Jika masih > 140 KB, coba kualitas 0.72
                    exportBlob(canvas1, 0.72).then(function (blob2) {
                        if (blob2 && blob2.size <= 140 * 1024) {
                            return createNewFile(blob2);
                        }

                        // Langkah 3: Jika masih > 140 KB, scale ke max 1280px kualitas 0.70 (pasti sekitar 80-110 KB)
                        const canvas2 = renderToCanvas(1280, 1280);
                        exportBlob(canvas2, 0.70).then(function (blob3) {
                            const chosenBlob = blob3 || blob2 || blob1;
                            createNewFile(chosenBlob.size < file.size ? chosenBlob : file);
                        });
                    });
                });
            };

            img.onerror = function () {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };

            img.src = objectUrl;
        });
    }

    let activeCompressionsCount = 0;

    function initAutoCompressor() {
        document.querySelectorAll('input[type="file"]:not([data-auto-compress="false"])').forEach(function (input) {
            if (input.dataset.compressBound) return;
            input.dataset.compressBound = 'true';

            input.addEventListener('change', async function () {
                if (!this.files || !this.files[0]) return;
                const file = this.files[0];

                // Hanya kompres berkas gambar (abaikan audio, video, dokumen, SVG)
                if (!file.type || !file.type.startsWith('image/') || file.type === 'image/svg+xml') {
                    return;
                }

                // Jika file sudah kecil (< 110 KB), tidak perlu kompres ulang
                if (file.size <= 110 * 1024) {
                    const existingBadge = input.parentNode.querySelector('.compression-status-badge');
                    if (existingBadge) existingBadge.remove();
                    return;
                }

                const form = input.closest('form');
                activeCompressionsCount++;
                if (form) {
                    form.dataset.compressing = 'true';
                }

                // Buat atau perbarui container badge informasi
                let badge = input.parentNode.querySelector('.compression-status-badge');
                if (!badge) {
                    badge = document.createElement('div');
                    badge.className = 'compression-status-badge mt-2 text-[11px]';
                    input.parentNode.appendChild(badge);
                }

                const origSizeText = formatBytes(file.size);
                badge.innerHTML = `
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 animate-pulse font-medium shadow-xs">
                        <svg class="animate-spin h-3.5 w-3.5 text-amber-600 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Sistem sedang mengompres foto (${origSizeText}) ke sekitar 100 KB...</span>
                    </span>
                `;

                try {
                    const compressed = await compressImageFile(file);
                    if (compressed && compressed !== file && window.DataTransfer) {
                        const dt = new DataTransfer();
                        dt.items.add(compressed);
                        this.files = dt.files;

                        const newSizeText = formatBytes(compressed.size);
                        badge.innerHTML = `
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-900 border border-emerald-200 font-medium shadow-xs">
                                <svg class="w-4 h-4 text-[#00913e] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Otomatis dikompres sistem: <strong>${origSizeText}</strong> ➔ <strong class="text-[#00913e]">${newSizeText}</strong> (Kualitas Bagus & Siap Unggah)</span>
                            </span>
                        `;
                    } else {
                        badge.remove();
                    }
                } catch (err) {
                    console.warn('Kompresi gambar otomatis dilewati:', err);
                    badge.remove();
                } finally {
                    activeCompressionsCount = Math.max(0, activeCompressionsCount - 1);
                    if (form && activeCompressionsCount === 0) {
                        delete form.dataset.compressing;
                    }
                }
            });
        });

        // Intercept form submit: tunggu jika masih ada kompresi yang aktif
        document.querySelectorAll('form').forEach(function (form) {
            if (form.dataset.compressSubmitBound) return;
            form.dataset.compressSubmitBound = 'true';

            form.addEventListener('submit', function (e) {
                if (form.dataset.compressing === 'true' || activeCompressionsCount > 0) {
                    e.preventDefault();
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const origBtnHtml = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menunggu kompresi gambar selesai...
                        `;
                    }

                    const checkInterval = setInterval(function () {
                        if (activeCompressionsCount === 0 && !form.dataset.compressing) {
                            clearInterval(checkInterval);
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = origBtnHtml;
                            }
                            form.submit();
                        }
                    }, 200);
                }
            });
        });
    }

    window.initAutoCompressor = initAutoCompressor;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoCompressor);
    } else {
        initAutoCompressor();
    }
})();
