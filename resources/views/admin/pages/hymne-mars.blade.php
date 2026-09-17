@extends('layouts.admin')

@section('title', 'Kelola Konten Dinamis Mars & Hymne')
@section('header_title', 'Kelola Mars & Hymne')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    
    {{-- TOP NAVIGATION & STATUS BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <div class="flex items-center space-x-3 text-xs">
            <span class="text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/hymne-mars</code></span>
            <a href="{{ route('download.hymne-mars') }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold px-3.5 py-1.5 rounded-xl border border-emerald-200 transition shadow-xs" title="Buka Halaman Mars & Hymne di Web Publik">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                <span>Lihat di Web Publik</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.pages.hymne-mars.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- CARD 1: HEADER & HERO --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-red-100 text-[#da251c] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-music"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Header &amp; Informasi Utama Mars</h3>
                    <p class="text-xs text-slate-500">Sesuaikan judul, badge, dan pengantar di bagian atas halaman.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Header</label>
                    <input type="text" name="hymne_mars_hero_badge" value="{{ $settings['hymne_mars_hero_badge'] ?? 'Mars JSIT Indonesia' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Utama Halaman</label>
                    <input type="text" name="hymne_mars_hero_title" value="{{ $settings['hymne_mars_hero_title'] ?? 'Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Lengkap Hero</label>
                    <textarea name="hymne_mars_hero_desc" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">{{ $settings['hymne_mars_hero_desc'] ?? 'Lagu kebanggaan civitas akademika Pondok Pesantren Raudhatul Ulum Sakatiga sebagai bagian dari Jaringan Sekolah Islam Terpadu (JSIT) Indonesia dalam membina generasi Rabbani yang unggul dan berdaya saing global.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 2: VIDEO YOUTUBE & TOMBOL --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-brands fa-youtube"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Video Player Mars YouTube</h3>
                    <p class="text-xs text-slate-500">Tautan video YouTube resmi untuk pemutar video dan tombol tonton langsung.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan Video YouTube / Video ID</label>
                    <input type="text" name="hymne_mars_youtube_url" value="{{ $settings['hymne_mars_youtube_url'] ?? 'https://www.youtube.com/watch?v=ijDo1wLvZ6w' }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol Tonton di YouTube</label>
                    <input type="text" name="hymne_mars_youtube_btn_text" value="{{ $settings['hymne_mars_youtube_btn_text'] ?? 'Tonton di YouTube' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Badge Video</label>
                    <input type="text" name="hymne_mars_badge" value="{{ $settings['hymne_mars_badge'] ?? 'Lagu Resmi Sekolah Islam Terpadu' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Seksi Video Mars</label>
                    <input type="text" name="hymne_mars_title" value="{{ $settings['hymne_mars_title'] ?? 'MARS JSIT INDONESIA' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Subtitle / Keterangan Mars</label>
                    <input type="text" name="hymne_mars_subtitle" value="{{ $settings['hymne_mars_subtitle'] ?? 'Pedoman semangat santri & pendidik Jaringan Sekolah Islam Terpadu (JSIT) se-Indonesia' }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
            </div>
        </div>

        {{-- CARD 3: LIRIK LENGKAP MARS --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-align-center"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Lirik Lengkap Mars &amp; Hymne</h3>
                    <p class="text-xs text-slate-500">Edit bait demi bait dan bagian refrain lirik lagu secara rapi.</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Lirik</label>
                <input type="text" name="hymne_mars_lyrics_title" value="{{ $settings['hymne_mars_lyrics_title'] ?? 'LIRIK MARS RESMI JSIT INDONESIA' }}" class="w-full bg-slate-50 text-xs font-bold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bait 1</label>
                    <textarea name="hymne_mars_lyrics_stanza_1" rows="5" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['hymne_mars_lyrics_stanza_1'] ?? "Dengan berbekal semangat kami melangkah\nMenjalin ukhuwah dengan tekad membaja\nMenuju mutu pendidikan Indonesia\nMelahirkan generasi cerdas mulia (2x)" }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Reff 1</label>
                    <textarea name="hymne_mars_lyrics_reff_1" rows="5" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['hymne_mars_lyrics_reff_1'] ?? "Kami Jaringan Sekolah Islam Terpadu\nSambut masa depan wajah Indonesia baru\nBersama tinggikan martabat dan citra guru\nIndonesia pasti maju! (pasti maju)" }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bait 2</label>
                    <textarea name="hymne_mars_lyrics_stanza_2" rows="5" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['hymne_mars_lyrics_stanza_2'] ?? "Di sinilah tempat kami berkarya\nMenggapai harapan meraih cita-cita\nSebagai penggerak dan pemberdaya bangsa\nWujudkan masyarakat cerdas dan sejahtera (2x)" }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Reff 2</label>
                    <textarea name="hymne_mars_lyrics_reff_2" rows="5" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['hymne_mars_lyrics_reff_2'] ?? "Kami Jaringan Sekolah Islam Terpadu\nBangkit serentak menyongsong peradaban baru\nBulatkan tekad dan cita membangun bangsa\nIndonesia maju dan berjaya! (dan berjaya)" }}</textarea>
                </div>
            </div>
        </div>

        {{-- CARD 4: MAKNA, PENCIPTA & UNDUHAN AUDIO --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-file-audio"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Filosofi Lagu, Pencipta &amp; File Audio</h3>
                    <p class="text-xs text-slate-500">Makna sejarah lagu dan berkas MP3/Audio untuk diunduh santri/wali murid.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Filosofi Lagu</label>
                    <input type="text" name="hymne_mars_philo_title" value="{{ $settings['hymne_mars_philo_title'] ?? 'Makna & Semangat Mars JSIT' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Pencipta / Arranger Lagu</label>
                    <input type="text" name="hymne_mars_creator_name" value="{{ $settings['hymne_mars_creator_name'] ?? 'Tim Pengembang JSIT Indonesia' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Filosofi & Makna Lagu</label>
                    <textarea name="hymne_mars_philo_desc" rows="3" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ $settings['hymne_mars_philo_desc'] ?? 'Mars JSIT Indonesia mencerminkan tekad luhur seluruh lembaga pendidikan Islam terpadu di Indonesia untuk mencetak generasi berkarakter salimul aqidah, shahihul ibadah, dan berprestasi sains teknologi tingkat dunia.' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tautan URL Berkas Audio (MP3)</label>
                    <input type="text" name="hymne_mars_audio_url" value="{{ $settings['hymne_mars_audio_url'] ?? '/uploads/downloads/mars-jsit-indonesia.mp3' }}" class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Tombol Unduh Audio</label>
                    <input type="text" name="hymne_mars_audio_btn_text" value="{{ $settings['hymne_mars_audio_btn_text'] ?? 'Unduh Audio Mars MP3' }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unggah File Audio Baru (Opsional, MP3/WAV maks 20MB)</label>
                    <input type="file" name="hymne_mars_audio_file" accept=".mp3,.wav,.ogg,.m4a" class="w-full bg-slate-50 text-xs text-slate-700 rounded-xl p-2.5 border border-slate-200">
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-[#da251c] to-[#ef4444] hover:from-red-700 hover:to-red-800 text-white font-bold text-xs px-7 py-3 rounded-xl shadow-lg transition flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Seluruh Konten Mars &amp; Hymne</span>
            </button>
        </div>

    </form>
</div>
@endsection
