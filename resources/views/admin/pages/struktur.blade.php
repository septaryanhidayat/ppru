@extends('layouts.admin')

@section('title', 'Kelola Struktur Organisasi & Bagan')
@section('header_title', 'Kelola Struktur Organisasi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{
    chartPreview: '{{ $settings['struktur_chart_image_url'] ?? ($page->featured_image ?? '') }}',
    removeImage: false
}">
    
    {{-- TOP NAVIGATION & STATUS BAR --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Halaman</span>
        </a>
        <div class="flex items-center space-x-3 text-xs">
            <span class="text-slate-400">Slug URL: <code class="bg-slate-100 px-2 py-1 rounded font-mono">/struktur-organisasi</code></span>
            <a href="{{ url('/struktur-organisasi') }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-bold px-3.5 py-1.5 rounded-xl border border-emerald-200 transition shadow-xs" title="Buka Halaman Struktur Organisasi di Web Publik">
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

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-xs space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                <span>Terdapat kesalahan pada input formulir:</span>
            </div>
            <ul class="list-disc list-inside text-[11px] pl-2 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pages.struktur.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- CARD 1: UNGGAH BAGAN GAMBAR STRUKTUR ORGANISASI --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-[#00843d] flex items-center justify-center text-lg font-black shadow-xs">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Bagan Gambar Struktur Organisasi (Resmi)</h3>
                        <p class="text-xs text-slate-500">Unggah bagan struktur dalam format gambar (hasil desain dari Canva, Corel, Photoshop, atau PPT) agar bebas menyesuaikan bentuk bagan.</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-[#00843d] border border-emerald-200 self-start sm:self-auto">
                    Mendukung JPG, PNG, WebP, SVG
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih File Gambar Bagan Struktur <span class="text-emerald-600 font-normal">(Maks 15 MB)</span>
                        </label>
                        <input type="file" 
                               name="struktur_chart_image_file" 
                               accept="image/png,image/jpeg,image/webp,image/svg+xml"
                               class="w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00843d] file:text-white hover:file:bg-[#006e33] cursor-pointer border border-slate-200 rounded-xl p-1.5 bg-slate-50">
                        <p class="text-[11px] text-slate-500 mt-1.5 leading-relaxed">
                            Format resolusi tinggi disarankan (misal 1920x1080 atau lebih tinggi). Sistem otomatis mengoptimasi berkas agar tajam dan cepat dimuat.
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Atau Masukkan URL Path Gambar (Opsional)
                        </label>
                        <input type="text" 
                               name="struktur_chart_image_url" 
                               value="{{ old('struktur_chart_image_url', $settings['struktur_chart_image_url'] ?? ($page->featured_image ?? '')) }}" 
                               placeholder="Contoh: /uploads/struktur/bagan-resmi-ppru.webp atau https://..."
                               class="w-full bg-slate-50 text-xs font-mono text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Mode Tampilan Bagan di Website
                        </label>
                        <select name="struktur_chart_mode" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                            <option value="image" {{ ($settings['struktur_chart_mode'] ?? 'image') === 'image' ? 'selected' : '' }}>
                                Prioritaskan Bagan Gambar Resmi (Sangat Dianjurkan)
                            </option>
                            <option value="both" {{ ($settings['struktur_chart_mode'] ?? '') === 'both' ? 'selected' : '' }}>
                                Tampilkan Keduanya (Bagan Gambar &amp; Bagan Hirarki Interaktif)
                            </option>
                            <option value="chart" {{ ($settings['struktur_chart_mode'] ?? '') === 'chart' ? 'selected' : '' }}>
                                Bagan Hirarki Interaktif Saja
                            </option>
                        </select>
                        <p class="text-[11px] text-slate-500 mt-1">Mode ini menentukan elemen visual utama yang langsung dilihat pengunjung saat membuka halaman struktur.</p>
                    </div>
                </div>

                {{-- PREVIEW GAMBAR BAGAN STRUKTUR SAAT INI --}}
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Pratinjau Bagan Saat Ini</span>
                        @php
                            $currentChart = $settings['struktur_chart_image_url'] ?? ($page->featured_image ?? '');
                        @endphp
                        @if(!empty($currentChart))
                            <a href="{{ $currentChart }}" target="_blank" class="text-[11px] font-bold text-[#00843d] hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                <span>Buka Resolusi Penuh</span>
                            </a>
                        @endif
                    </div>

                    @if(!empty($currentChart))
                        <div class="relative rounded-xl overflow-hidden border border-slate-300 bg-white shadow-inner max-h-72 flex items-center justify-center p-2 group">
                            <img src="{{ $currentChart }}" 
                                 alt="Bagan Struktur Organisasi PPRU" 
                                 class="max-h-64 w-auto object-contain transition duration-300 group-hover:scale-105">
                        </div>

                        <div class="pt-2 flex items-center justify-between">
                            <label class="inline-flex items-center space-x-2 text-xs font-semibold text-red-600 cursor-pointer">
                                <input type="checkbox" name="remove_chart_image" value="1" class="rounded text-red-600 focus:ring-red-500">
                                <span>Hapus gambar bagan struktur ini</span>
                            </label>
                            <span class="text-[10px] text-slate-400 font-mono truncate max-w-[200px]" title="{{ $currentChart }}">{{ basename($currentChart) }}</span>
                        </div>
                    @else
                        <div class="py-12 px-4 rounded-xl border-2 border-dashed border-slate-300 text-center text-slate-400 space-y-2">
                            <i class="fa-regular fa-image text-4xl block text-slate-300"></i>
                            <p class="text-xs font-semibold text-slate-600">Belum ada gambar bagan struktur yang diunggah.</p>
                            <p class="text-[11px] text-slate-400 max-w-xs mx-auto">Gunakan form di samping untuk mengunggah bagan visual resmi pesantren.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- CARD 2: KONTEN TEKS & INFORMASI KEPEMIMPINAN --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-align-left"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Judul &amp; Informasi Narasi Struktur</h3>
                    <p class="text-xs text-slate-500">Sesuaikan judul, pengantar, dan uraian tata kelola kepemimpinan pondok pesantren.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Halaman <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required value="{{ old('title', $page->title ?: 'Struktur Organisasi & Kepengurusan') }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Pengantar / Intro Singkat</label>
                    <input type="text" name="struktur_intro" value="{{ old('struktur_intro', $settings['struktur_intro'] ?? ($page->excerpt ?: 'Susunan pengurus Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) dan pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga.')) }}" placeholder="Ringkasan singkat di bawah judul..." class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Ringkasan Pendek (Excerpt Meta)</label>
                    <textarea name="excerpt" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ old('excerpt', $page->excerpt) }}</textarea>
                </div>

                {{-- WYSIWYG EDITOR UNTUK ISI INFORMASI KEPEMIMPINAN --}}
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Uraian Informasi Kepemimpinan / Pedoman Tata Kelola (Opsional)
                    </label>
                    <input type="hidden" name="content" id="struktur_content_input" value="{{ old('content', $page->content) }}">
                    <div id="struktur_editor" data-quill="struktur_content_input" class="bg-white min-h-[160px] rounded-xl border border-slate-200"></div>
                    <p class="text-[11px] text-slate-500 mt-1.5">Teks ini akan tampil dalam kotak informasi elegan di atas bagan struktur pada website publik.</p>
                </div>
            </div>
        </div>

        {{-- CARD 3: PENGATURAN TAMPILAN SEKSI TAMBAHAN --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Pengaturan Seksi Tambahan di Bawah Struktur</h3>
                    <p class="text-xs text-slate-500">Tentukan apakah seksi fasilitas dan program unggulan ditampilkan di halaman struktur.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="flex items-start space-x-3 p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-emerald-50/50 transition cursor-pointer">
                    <input type="checkbox" name="struktur_show_facilities" value="1" {{ ($settings['struktur_show_facilities'] ?? '1') === '1' ? 'checked' : '' }} class="mt-0.5 rounded text-[#00843d] focus:ring-[#00843d]">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Tampilkan Seksi Fasilitas &amp; Sarana</span>
                        <span class="text-[11px] text-slate-500 font-light block mt-0.5">Menampilkan katalog sarana pondok di bawah bagan struktur.</span>
                    </div>
                </label>

                <label class="flex items-start space-x-3 p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-emerald-50/50 transition cursor-pointer">
                    <input type="checkbox" name="struktur_show_programs" value="1" {{ ($settings['struktur_show_programs'] ?? '1') === '1' ? 'checked' : '' }} class="mt-0.5 rounded text-[#00843d] focus:ring-[#00843d]">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Tampilkan Seksi Program Unggulan</span>
                        <span class="text-[11px] text-slate-500 font-light block mt-0.5">Menampilkan daftar program santri unggulan di bawah bagan struktur.</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- CARD 4: DATA PEJABAT & PENGURUS STRUKTUR (DARI DATABASE) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-lg font-black shadow-xs">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Daftar Pejabat &amp; Pengurus Yayasan/PPRU</h3>
                        <p class="text-xs text-slate-500">Data pengurus yang tampil di tab "Daftar Kartu Pengurus" dan "Tabel Nama". Tidak ada satupun yang di-hardcode.</p>
                    </div>
                </div>
                <a href="{{ route('admin.dewan.index') }}" class="inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    <span>Kelola Pejabat &amp; Asatidz &rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">Urutan</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4">Amanah / Jabatan</th>
                            <th class="py-3 px-4">Bidang / Lembaga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengurus as $p)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4 text-center font-mono font-bold text-slate-400">#{{ $p->order }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <img src="{{ $p->photo_url }}" alt="{{ $p->name }}" class="w-7 h-7 rounded-lg object-cover object-top border border-slate-200 shrink-0" onerror="this.onerror=null;this.src='/uploads/avatar-neutral-gray.svg'">
                                        <span class="font-bold text-slate-900">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-semibold text-[#00843d]">{{ $p->position }}</td>
                                <td class="py-3 px-4 text-slate-500">{{ $p->fraction ?: 'Yayasan YAPIRUS' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-xs text-slate-400">
                                    Belum ada data pengurus. Tambahkan data di menu <a href="{{ route('admin.dewan.index') }}" class="text-[#00843d] underline font-bold">Struktur Pengurus &amp; Dewan Guru</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CARD 5: OPTIMASI MESIN PENCARI (SEO GOOGLE) --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-black shadow-xs">
                    <i class="fa-brands fa-google"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Optimasi SEO Google</h3>
                    <p class="text-xs text-slate-500">Judul dan deskripsi yang tampil di mesin pencari Google saat mencari struktur organisasi PPRU.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title ?: 'Struktur Organisasi & Kepengurusan Pesantren Raudhatul Ulum Sakatiga') }}" class="w-full bg-slate-50 text-xs font-semibold text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="2" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">{{ old('meta_description', $page->meta_description ?: 'Bagan struktur organisasi pimpinan dan kepengurusan Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.') }}</textarea>
                </div>
            </div>
        </div>

        {{-- SUBMIT BUTTON (STICKY) --}}
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xl flex items-center justify-between">
            <div class="text-xs text-slate-500 hidden sm:block">
                <span>Pastikan gambar bagan dan data pengurus sudah benar sebelum menyimpan.</span>
            </div>
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-[#006e33] text-white px-8 py-3.5 rounded-xl text-xs font-black uppercase tracking-wider shadow-lg shadow-emerald-600/30 transition flex items-center justify-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-floppy-disk text-sm"></i>
                <span>Simpan Perubahan Struktur Organisasi</span>
            </button>
        </div>

    </form>
</div>
@endsection
