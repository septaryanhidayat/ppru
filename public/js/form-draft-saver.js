/**
 * PPRU Universal Form Draft Saver & Restorer (Local Storage)
 * Otomatis menyimpan isian form ke penyimpanan lokal browser sementara (localStorage)
 * agar saat tidak sengaja terefresh, tertutup, atau terputus koneksi, data tidak hilang.
 */
(function() {
    'use strict';

    if (typeof window === 'undefined' || !window.localStorage) {
        return;
    }

    const DRAFT_PREFIX = 'ppru_form_draft_';
    const EXPIRY_DAYS = 7;

    // Helper: generate unique storage key for a form on the current URL
    function getDraftKey(form) {
        const path = window.location.pathname;
        const formId = form.id || form.getAttribute('name') || form.getAttribute('action') || 'form_main';
        const sanitizedId = formId.replace(/[^a-zA-Z0-9_-]/g, '_');
        return DRAFT_PREFIX + path + '::' + sanitizedId;
    }

    // Helper: check if a form should be excluded
    function isExcludedForm(form) {
        if (!form) return true;
        if (form.getAttribute('data-no-draft') === 'true') return true;

        const method = (form.getAttribute('method') || 'GET').toUpperCase();
        if (method === 'GET') return true;

        const action = (form.getAttribute('action') || '').toLowerCase();
        if (action.includes('login') || action.includes('logout') || action.includes('password')) {
            return true;
        }

        // Exclude delete forms
        const deleteMethod = form.querySelector('input[name="_method"][value="DELETE"], input[name="_method"][value="delete"]');
        if (deleteMethod) return true;

        // Exclude forms with only 1 submit button and no real user inputs
        const userInputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]):not([type="button"]), textarea, select');
        if (userInputs.length === 0) return true;

        return false;
    }

    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Collect all savable field data from form
    function extractFormData(form) {
        const data = {};
        let hasNonEmptyField = false;

        const elements = form.elements;
        for (let i = 0; i < elements.length; i++) {
            const el = elements[i];
            const name = el.name;
            if (!name) continue;
            if (el.getAttribute('data-no-draft') === 'true') continue;

            const type = (el.type || '').toLowerCase();

            // Skip sensitive or non-savable fields
            if (['password', 'file', 'submit', 'button', 'reset'].includes(type)) continue;
            if (name === '_token' || name === '_method') continue;

            if (type === 'checkbox') {
                if (name.endsWith('[]')) {
                    if (!data[name]) data[name] = [];
                    if (el.checked) {
                        data[name].push(el.value);
                        hasNonEmptyField = true;
                    }
                } else {
                    data[name] = el.checked;
                    if (el.checked) hasNonEmptyField = true;
                }
            } else if (type === 'radio') {
                if (el.checked) {
                    data[name] = el.value;
                    hasNonEmptyField = true;
                }
            } else if (el.tagName.toLowerCase() === 'select') {
                if (el.multiple) {
                    const selected = Array.from(el.selectedOptions).map(opt => opt.value);
                    data[name] = selected;
                    if (selected.length > 0) hasNonEmptyField = true;
                } else {
                    data[name] = el.value;
                    if (el.value) hasNonEmptyField = true;
                }
            } else {
                // text, textarea, hidden (for Quill WYSIWYG etc.)
                data[name] = el.value;
                if (el.value && el.value.trim().length > 0) {
                    hasNonEmptyField = true;
                }
            }
        }

        return { fields: data, hasData: hasNonEmptyField };
    }

    // Save draft to localStorage
    function saveDraft(form) {
        if (isExcludedForm(form)) return;
        const key = getDraftKey(form);
        const { fields, hasData } = extractFormData(form);

        if (!hasData) {
            localStorage.removeItem(key);
            return;
        }

        const payload = {
            savedAt: Date.now(),
            url: window.location.pathname,
            fields: fields
        };

        try {
            localStorage.setItem(key, JSON.stringify(payload));
        } catch (e) {
            console.warn('[FormDraftSaver] Failed to save draft to localStorage:', e);
        }
    }

    // Create a sleek notification banner when draft is restored
    function showRestoredBanner(form, onDiscard) {
        const existingBanner = document.getElementById('ppru-draft-banner');
        if (existingBanner) existingBanner.remove();

        const banner = document.createElement('div');
        banner.id = 'ppru-draft-banner';
        banner.className = 'ppru-draft-banner fixed bottom-5 right-5 z-50 bg-slate-900/95 text-white p-4 rounded-2xl shadow-2xl border border-emerald-500/50 flex items-center gap-3.5 text-xs max-w-md backdrop-blur-md transition-all duration-300 transform translate-y-0';
        banner.innerHTML = `
            <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base flex-shrink-0 font-bold border border-emerald-500/30">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-extrabold text-slate-100 flex items-center gap-1.5">
                    <span>Draft Isian Terakhir Dipulihkan</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <p class="text-[11px] text-slate-300 mt-0.5 leading-snug">Data formulir Anda otomatis dipulihkan dari penyimpanan lokal sementara agar tidak hilang saat refresh.</p>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <button type="button" id="ppru-btn-discard-draft" class="px-3 py-1.5 rounded-xl bg-red-600/90 hover:bg-red-600 text-white font-bold text-[11px] transition cursor-pointer shadow-sm" title="Hapus draft dan kembalikan ke data asli">
                    Buang Draft
                </button>
                <button type="button" id="ppru-btn-close-draft" class="text-slate-400 hover:text-white p-1 text-sm cursor-pointer" title="Tutup pemberitahuan">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        `;

        document.body.appendChild(banner);

        const discardBtn = banner.querySelector('#ppru-btn-discard-draft');
        if (discardBtn) {
            discardBtn.addEventListener('click', function() {
                if (typeof onDiscard === 'function') {
                    onDiscard();
                }
                banner.remove();
            });
        }

        const closeBtn = banner.querySelector('#ppru-btn-close-draft');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                banner.remove();
            });
        }

        // Auto fade after 12 seconds
        setTimeout(() => {
            if (banner && banner.parentNode) {
                banner.style.opacity = '0';
                banner.style.transform = 'translateY(10px)';
                setTimeout(() => banner.remove(), 300);
            }
        }, 12000);
    }

    // Restore draft into form
    function restoreDraft(form) {
        if (isExcludedForm(form)) return false;
        const key = getDraftKey(form);

        let stored = null;
        try {
            const raw = localStorage.getItem(key);
            if (!raw) return false;
            stored = JSON.parse(raw);
        } catch (e) {
            localStorage.removeItem(key);
            return false;
        }

        if (!stored || !stored.fields) return false;

        // Check expiration (7 days)
        if (stored.savedAt && (Date.now() - stored.savedAt > EXPIRY_DAYS * 24 * 60 * 60 * 1000)) {
            localStorage.removeItem(key);
            return false;
        }

        // Capture initial server rendered values for reset
        const initialValues = {};
        const elements = form.elements;
        for (let i = 0; i < elements.length; i++) {
            const el = elements[i];
            if (!el.name) continue;
            if (el.type === 'checkbox') {
                initialValues[el.name + '::' + el.value] = el.checked;
            } else if (el.type === 'radio') {
                if (el.checked) initialValues[el.name] = el.value;
            } else {
                initialValues[el.name] = el.value;
            }
        }

        // Compare if draft is meaningfully different from current initial values
        let hasDifferences = false;
        const fields = stored.fields;

        for (const [name, val] of Object.entries(fields)) {
            const el = form.elements[name];
            if (!el) continue;

            if (Array.isArray(val)) {
                hasDifferences = true;
            } else if (typeof val === 'boolean') {
                if (el.checked !== val) hasDifferences = true;
            } else if (typeof val === 'string') {
                const currentVal = el.value || '';
                // Normalize and compare
                if (val.trim() !== currentVal.trim()) {
                    hasDifferences = true;
                }
            }
        }

        if (!hasDifferences) {
            return false;
        }

        // Apply draft values
        for (const [name, val] of Object.entries(fields)) {
            const el = form.elements[name];
            if (!el) continue;

            if (el instanceof RadioNodeList) {
                el.value = val;
            } else if (el.type === 'checkbox') {
                if (Array.isArray(val)) {
                    // Node list of checkboxes with name[]
                    const checkboxes = form.querySelectorAll(`input[type="checkbox"][name="${name}"]`);
                    checkboxes.forEach(cb => {
                        cb.checked = val.includes(cb.value);
                    });
                } else {
                    el.checked = Boolean(val);
                }
            } else if (el.tagName.toLowerCase() === 'select') {
                if (el.multiple && Array.isArray(val)) {
                    Array.from(el.options).forEach(opt => {
                        opt.selected = val.includes(opt.value);
                    });
                } else {
                    el.value = val;
                }
            } else {
                el.value = val;
            }

            // If this element is synced with a Quill WYSIWYG editor
            const quillContainer = form.querySelector(`[data-quill="${el.id}"]`);
            if (quillContainer && typeof Quill !== 'undefined') {
                try {
                    const qInstance = Quill.find(quillContainer);
                    if (qInstance) {
                        qInstance.root.innerHTML = val;
                    }
                } catch (err) {
                    console.warn('[FormDraftSaver] Error restoring Quill editor:', err);
                }
            }
        }

        // Show banner informing user draft was restored
        showRestoredBanner(form, function onDiscard() {
            localStorage.removeItem(key);
            window.location.reload();
        });

        return true;
    }

    // Attach listeners to a form
    function initFormDraftSaver(form) {
        if (isExcludedForm(form)) return;

        const debouncedSave = debounce(() => saveDraft(form), 500);

        // Listen for input, change, and keyup events
        form.addEventListener('input', debouncedSave);
        form.addEventListener('change', debouncedSave);

        // Listen for Quill editors inside this form
        const quillContainers = form.querySelectorAll('[data-quill]');
        quillContainers.forEach(container => {
            const targetInputId = container.getAttribute('data-quill');
            const targetInput = document.getElementById(targetInputId);
            
            // Watch for text changes using MutationObserver or Quill events
            const observer = new MutationObserver(() => {
                if (targetInput && container.querySelector('.ql-editor')) {
                    targetInput.value = container.querySelector('.ql-editor').innerHTML;
                    debouncedSave();
                }
            });

            observer.observe(container, { childList: true, subtree: true, characterData: true });
        });

        // Save immediately on beforeunload
        window.addEventListener('beforeunload', () => {
            // Sync any Quill editors before final unload
            quillContainers.forEach(container => {
                const targetInputId = container.getAttribute('data-quill');
                const targetInput = document.getElementById(targetInputId);
                const qlEditor = container.querySelector('.ql-editor');
                if (targetInput && qlEditor) {
                    targetInput.value = qlEditor.innerHTML;
                }
            });
            saveDraft(form);
        });

        // Clear draft when form is submitted
        form.addEventListener('submit', function() {
            const key = getDraftKey(form);
            localStorage.removeItem(key);
        });

        // Try restoring draft
        // Small delay to allow Quill or other JS plugins to finish initializing
        setTimeout(() => {
            restoreDraft(form);
        }, 150);
    }

    // Initialize all forms on DOMContentLoaded
    function init() {
        // If there is a flash success message on screen, clean up draft for this URL
        const hasSuccess = document.querySelector('.bg-emerald-50, [class*="alert-success"], .swal2-success');
        if (hasSuccess) {
            const path = window.location.pathname;
            for (let i = 0; i < localStorage.length; i++) {
                const k = localStorage.key(i);
                if (k && k.startsWith(DRAFT_PREFIX + path)) {
                    localStorage.removeItem(k);
                }
            }
        }

        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            initFormDraftSaver(form);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
