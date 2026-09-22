@extends('layouts.frontend')

@section('title', $post->title . ' - Khutbah Jum\'at PPRU Sakatiga')
@section('meta_description', $post->excerpt ?: Str::limit(strip_tags($post->content), 160))

@section('content')
{{-- BREADCRUMB HEADER --}}
<div class="bg-emerald-950 text-white py-6 border-b border-emerald-800/60 print:hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-300/80 flex flex-wrap items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('khutbah.index') }}" class="hover:text-white transition">Khutbah Jum'at</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold line-clamp-1 max-w-xs sm:max-w-md">{{ $post->title }}</span>
        </nav>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

    {{-- TOOLBAR PEMBACA MIMBAR (FLOATING / STICKY CONTROLS) --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-md border border-emerald-100 dark:border-slate-800 p-3 mb-8 sticky top-3 z-40 flex flex-wrap items-center justify-between gap-3 print:hidden transition-colors">
        <div class="flex items-center space-x-1 sm:space-x-2">
            <span class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden sm:inline mr-1">
                <i class="fa-solid fa-text-height text-[#00843d] dark:text-emerald-400"></i> Ukuran Huruf:
            </span>
            <button type="button" onclick="adjustFontSize(-2)" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 hover:text-[#00843d] dark:hover:text-emerald-400 font-bold text-xs transition flex items-center justify-center cursor-pointer border border-transparent dark:border-slate-700" title="Perkecil Huruf">
                A-
            </button>
            <button type="button" onclick="resetFontSize()" class="px-2.5 h-8 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 hover:text-[#00843d] dark:hover:text-emerald-400 font-bold text-xs transition flex items-center justify-center cursor-pointer border border-transparent dark:border-slate-700" title="Ukuran Standar">
                Normal
            </button>
            <button type="button" onclick="adjustFontSize(2)" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 hover:text-[#00843d] dark:hover:text-emerald-400 font-bold text-xs transition flex items-center justify-center cursor-pointer border border-transparent dark:border-slate-700" title="Perbesar Huruf">
                A+
            </button>
            <button type="button" onclick="adjustFontSize(4)" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 hover:text-[#00843d] dark:hover:text-emerald-400 font-black text-xs transition flex items-center justify-center cursor-pointer border border-transparent dark:border-slate-700" title="Ukuran Ekstra Besar untuk Mimbar">
                A++
            </button>
        </div>

        <div class="flex items-center space-x-2">
            {{-- Tombol Cetak / Print --}}
            <button type="button" onclick="window.print()" class="bg-[#00843d] hover:bg-emerald-800 text-white px-3.5 py-1.5 rounded-xl font-bold text-xs transition flex items-center space-x-1.5 shadow-sm cursor-pointer" title="Cetak naskah untuk dibaca di mimbar">
                <i class="fa-solid fa-print"></i>
                <span class="hidden sm:inline">Cetak Naskah</span>
            </button>

            {{-- Tombol Salin Naskah --}}
            <button type="button" id="btn-copy-khutbah" onclick="copyKhutbahText()" class="bg-amber-100 dark:bg-amber-500 hover:bg-amber-200 dark:hover:bg-amber-400 text-amber-950 dark:text-slate-950 border border-amber-300 dark:border-amber-400 px-3.5 py-1.5 rounded-xl font-bold text-xs transition flex items-center space-x-1.5 cursor-pointer shadow-xs" title="Salin seluruh teks khutbah">
                <i class="fa-solid fa-copy"></i>
                <span id="label-copy-khutbah" class="hidden sm:inline">Salin Teks</span>
            </button>

            {{-- Bagikan WhatsApp --}}
            <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - Naskah Khutbah PPRU: ' . url()->current()) }}" target="_blank" rel="noopener" class="bg-[#25d366] hover:bg-[#1eb956] text-white px-3 py-1.5 rounded-xl font-bold text-xs transition flex items-center space-x-1 shadow-xs" title="Bagikan ke WhatsApp">
                <i class="fa-brands fa-whatsapp text-sm"></i>
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA NASKAH KHUTBAH --}}
    <article class="bg-white dark:bg-slate-900 rounded-3xl shadow-xl border border-gray-100 dark:border-slate-800 p-6 sm:p-10 lg:p-12 print:p-0 print:shadow-none print:border-0 transition-colors" id="printable-khutbah">

        {{-- Header Naskah Khutbah --}}
        <header class="border-b border-gray-200 dark:border-slate-800 pb-6 mb-6">
            <div class="flex flex-wrap items-center gap-2 mb-3 print:hidden">
                <span class="bg-emerald-100 dark:bg-emerald-950/80 text-[#00843d] dark:text-emerald-400 text-xs font-black px-3 py-1 rounded-full border border-emerald-200 dark:border-emerald-800/80 flex items-center gap-1.5">
                    <i class="fa-solid fa-microphone-lines text-[10px]"></i> Naskah Khutbah Resmi
                </span>
                <span class="bg-amber-100 dark:bg-amber-950/80 text-amber-900 dark:text-amber-300 text-xs font-bold px-3 py-1 rounded-full border border-amber-200 dark:border-amber-800/80">
                    YAPIRUS • PPRU Sakatiga
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 dark:text-white tracking-tight leading-snug mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center text-xs text-gray-600 dark:text-slate-300 gap-4 sm:gap-6 pt-2">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-user-tie text-[#00843d] dark:text-emerald-400"></i>
                    <span>Khatib / Penyusun: <strong class="text-gray-900 dark:text-white">{{ $post->author_name ?: ($post->author?->name ?? 'Dewan Asatidz PPRU') }}</strong></span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-regular fa-calendar-check text-[#00843d] dark:text-emerald-400"></i>
                    <span>{{ ($post->published_at ?? $post->created_at)->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
                <div class="flex items-center space-x-2 print:hidden">
                    <i class="fa-solid fa-eye text-gray-400 dark:text-slate-500"></i>
                    <span>{{ number_format($post->views_count) }} kali dibaca</span>
                </div>
            </div>

            {{-- Checklist Rukun Khutbah --}}
            <div class="mt-4 p-3.5 bg-emerald-50/70 dark:bg-slate-800/80 rounded-xl border border-emerald-200 dark:border-slate-700 text-xs text-emerald-950 dark:text-emerald-300 flex flex-wrap items-center gap-x-4 gap-y-1 print:hidden">
                <span class="font-bold text-[#00843d] dark:text-emerald-400 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400"></i> Rukun Syar'i:
                </span>
                <span>✓ Hamdalah</span>
                <span>✓ Shalawat Nabi</span>
                <span>✓ Wasiat Taqwa</span>
                <span>✓ Ayat Al-Qur'an</span>
                <span>✓ Doa Mukminin</span>
            </div>
        </header>

        {{-- Isi Naskah Khutbah --}}
        <div id="khutbah-text-content" class="khutbah-content prose dark:prose-invert max-w-none text-slate-800 dark:text-slate-200 leading-relaxed space-y-6 text-base" style="font-size: 16px;">
            {!! $post->content !!}
        </div>

        {{-- Footer Naskah Khutbah --}}
        <footer class="mt-10 pt-6 border-t border-gray-200 dark:border-slate-800 text-xs text-gray-500 dark:text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-4 print:mt-4">
            <div>
                <p class="font-bold text-gray-700 dark:text-slate-300">Pondok Pesantren Raudhatul Ulum Sakatiga</p>
                <p>Desa Sakatiga, Indralaya, Ogan Ilir, Sumatera Selatan 30816</p>
            </div>
            <div class="print:hidden">
                <a href="{{ route('khutbah.index') }}" class="inline-flex items-center gap-2 text-[#00843d] dark:text-emerald-400 hover:underline font-bold">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Koleksi Khutbah</span>
                </a>
            </div>
        </footer>
    </article>

    {{-- NASKAH KHUTBAH TERKAIT --}}
    @if(isset($related) && $related->isNotEmpty())
        <div class="mt-12 print:hidden">
            <h2 class="text-xl font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-book-bookmark text-[#00843d] dark:text-emerald-400"></i>
                <span>Naskah Khutbah Terkait Lainnya</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($related as $rel)
                    <a href="{{ route('khutbah.show', $rel->slug) }}" class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-gray-200 dark:border-slate-800 hover:border-[#00843d] dark:hover:border-emerald-500 hover:shadow-md transition group block">
                        <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-slate-500 block mb-1">
                            {{ ($rel->published_at ?? $rel->created_at)->isoFormat('D MMMM Y') }}
                        </span>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-[#00843d] dark:group-hover:text-emerald-400 transition line-clamp-2">
                            {{ $rel->title }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-2 flex items-center gap-1.5 font-light">
                            <i class="fa-solid fa-user-tie text-emerald-600 dark:text-emerald-400 text-[10px]"></i>
                            <span>{{ $rel->author_name ?: 'Dewan Asatidz PPRU' }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>

{{-- SCRIPT PENGATUR HURUF, COPY & PRINT --}}
@push('scripts')
<script>
    let currentFontSize = 16;
    const contentEl = document.getElementById('khutbah-text-content');

    function adjustFontSize(delta) {
        currentFontSize = Math.min(26, Math.max(13, currentFontSize + delta));
        if (contentEl) {
            contentEl.style.fontSize = currentFontSize + 'px';
            contentEl.style.lineHeight = (currentFontSize * 1.8) + 'px';
        }
    }

    function resetFontSize() {
        currentFontSize = 16;
        if (contentEl) {
            contentEl.style.fontSize = '16px';
            contentEl.style.lineHeight = '28px';
        }
    }

    function copyKhutbahText() {
        if (!contentEl) return;
        const textToCopy = "{{ $post->title }}\nOleh: {{ $post->author_name ?: 'Dewan Asatidz PPRU' }}\n\n" + contentEl.innerText;
        navigator.clipboard.writeText(textToCopy).then(() => {
            const btn = document.getElementById('btn-copy-khutbah');
            const label = document.getElementById('label-copy-khutbah');
            if (label) label.textContent = 'Tersalin!';
            if (btn) {
                btn.classList.remove('bg-amber-100', 'text-amber-900');
                btn.classList.add('bg-emerald-600', 'text-white');
            }
            setTimeout(() => {
                if (label) label.textContent = 'Salin Teks';
                if (btn) {
                    btn.classList.remove('bg-emerald-600', 'text-white');
                    btn.classList.add('bg-amber-100', 'text-amber-900');
                }
            }, 2500);
        });
    }

    // Otomatis print jika url mengandung hashtag #print
    if (window.location.hash === '#print') {
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    }
</script>
@endpush

{{-- CSS KHUSUS CETAK UNTUK MIMBAR --}}
<style>
@media print {
    body {
        background: #ffffff !important;
        color: #000000 !important;
        font-size: 13pt !important;
        line-height: 1.6 !important;
    }
    header, footer, nav, aside, .print\\:hidden, #footer-visitor-counter {
        display: none !important;
    }
    #printable-khutbah {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .arabic-block {
        font-size: 16pt !important;
        line-height: 2 !important;
        color: #000000 !important;
        border: 1px solid #ccc !important;
        padding: 10px !important;
    }
}
</style>
@endsection
