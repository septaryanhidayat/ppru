@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', auth()->user()->isUnitAdmin() ? ('Dashboard Unit: ' . (auth()->user()->unit?->short_name ?: 'Unit')) : 'Dashboard Ringkasan Website')

@section('content')
<div class="space-y-6 sm:space-y-8">

@if(auth()->user()->isUnitAdmin())
    {{-- ============================================================ --}}
    {{-- TAMPILAN DASHBOARD KHUSUS ADMIN UNIT LEMBAGA PENDIDIKAN      --}}
    {{-- ============================================================ --}}

    {{-- 1. HERO UNIT CARD --}}
    <div class="rounded-3xl p-5 sm:p-7 text-white shadow-xl relative overflow-hidden border border-emerald-800/60" style="background: linear-gradient(135deg, #022c19 0%, #064e3b 50%, #0f172a 100%); color: #ffffff;">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
            <div class="space-y-2 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold" style="background: rgba(251, 191, 36, 0.2); border: 1px solid rgba(251, 191, 36, 0.5); color: #fde68a;">
                        <i class="fa-solid fa-graduation-cap text-[11px]"></i>
                        <span>Unit: {{ $unit?->short_name ?: 'Lembaga' }}</span>
                    </span>
                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background: rgba(6, 78, 59, 0.9); border: 1px solid rgba(16, 185, 129, 0.5); color: #6ee7b7;">
                        <i class="fa-solid fa-circle-check text-[9px]" style="color: #34d399;"></i>
                        <span>Panel Khusus Unit</span>
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    {{ $unit?->name ?: 'Unit Lembaga Pendidikan' }}
                </h2>
                <p class="text-xs sm:text-sm max-w-2xl font-normal leading-relaxed" style="color: #d1fae5;">
                    Kelola identitas profil, publikasi berita, galeri foto, video YouTube, dewan asatidz, testimoni, prestasi, dan ekstrakurikuler khusus unit {{ $unit?->short_name ?: 'Anda' }}.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 sm:gap-2.5 shrink-0">
                <a href="{{ route('admin.profil-unit') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold px-3.5 py-2.5 rounded-xl shadow-md transition" style="background-color: #f59e0b; color: #0f172a;">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span>Edit Profil Unit</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold px-3.5 py-2.5 rounded-xl shadow-md transition" style="background-color: #10b981; color: #ffffff;">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tulis Berita</span>
                </a>
                <a href="{{ route('admin.media.index') }}" class="inline-flex items-center space-x-1.5 text-xs font-semibold px-3 py-2.5 rounded-xl transition" style="background-color: #1e293b; color: #ffffff; border: 1px solid #334155;">
                    <i class="fa-solid fa-photo-film text-xs" style="color: #fde047;"></i>
                    <span>Galeri &amp; Video</span>
                </a>
                <form action="{{ route('admin.unit.seed-demo') }}" method="POST" class="inline" onsubmit="return confirm('Muat ulang seluruh konten demo unit ini (berita, foto galeri, dewan guru, testimoni, prestasi, dan ekskul)?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center space-x-1.5 text-xs font-bold px-3.5 py-2.5 rounded-xl shadow-md transition cursor-pointer" style="background-color: #3b82f6; color: #ffffff;" title="Klik untuk melengkapi atau memuat ulang data demo unit jika kosong">
                        <i class="fa-solid fa-arrows-rotate text-xs"></i>
                        <span>Muat Demo Unit</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 2. KPI METRICS (6 CARDS KHUSUS UNIT) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        {{-- Card 1: Berita Unit --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-emerald-400/30" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #d1fae5;">Berita Unit</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ number_format($stats['total_posts'] ?? 0) }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #d1fae5;">
                {{ number_format($stats['total_views'] ?? 0) }} kali dibaca
            </p>
        </div>

        {{-- Card 2: Dokumentasi Media --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-sky-400/30" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #e0f2fe;">Media Galeri</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-photo-film"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ ($stats['total_photos'] ?? 0) + ($stats['total_videos'] ?? 0) }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #e0f2fe;">
                {{ $stats['total_photos'] ?? 0 }} foto &bull; {{ $stats['total_videos'] ?? 0 }} video
            </p>
        </div>

        {{-- Card 3: Dewan Asatidz / Guru --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-purple-400/30" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #ede9fe;">Dewan Guru</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ $stats['total_teachers'] ?? 0 }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #ede9fe;">
                Asatidz &amp; GTK unit
            </p>
        </div>

        {{-- Card 4: Testimoni --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-teal-400/30" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #ccfbf1;">Testimoni</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-comments"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ $stats['total_testimonials'] ?? 0 }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #ccfbf1;">
                Ulasan wali &amp; alumni
            </p>
        </div>

        {{-- Card 5: Prestasi & Ekskul --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-amber-400/30" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #fef3c7;">Prestasi &amp; Ekskul</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-trophy"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ ($stats['total_prestasi'] ?? 0) + ($stats['total_ekskul'] ?? 0) }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #fef3c7;">
                {{ $stats['total_prestasi'] ?? 0 }} p &bull; {{ $stats['total_ekskul'] ?? 0 }} e
            </p>
        </div>

        {{-- Card 6: Calon Santri PSB --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 shadow-md border border-indigo-400/30" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #e0e7ff;">Calon Santri</span>
                <div class="w-8 h-8 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ $stats['total_ppdb'] ?? 0 }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #e0e7ff;">
                Pendaftar jenjang
            </p>
        </div>
    </div>

    {{-- 3. PROFIL LEMBAGA CARD & QUICK EDIT --}}
    <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/80 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <h3 class="font-extrabold text-slate-800 text-sm sm:text-base">Informasi Profil {{ $unit?->short_name ?: 'Unit' }}</h3>
                    <p class="text-xs text-slate-400">Data identitas, kurikulum, kontak, dan sambutan yang tampil pada halaman web unit</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.profil-unit') }}" class="inline-flex items-center space-x-1.5 bg-[#00843d] hover:bg-[#00632e] text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-sliders text-xs"></i>
                    <span>Perbarui Data Unit</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 text-xs">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Kepala Lembaga</span>
                <span class="font-bold text-slate-800 mt-1 block text-xs leading-snug break-words">{{ $unit?->head_name ?: 'Belum diisi' }}</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Kurikulum</span>
                <span class="font-bold text-slate-800 mt-1 block text-xs leading-snug break-words">{{ $unit?->curriculum ?: 'Kurikulum Pesantren' }}</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Kontak / Telepon</span>
                <span class="font-bold text-slate-800 mt-1 block text-xs leading-snug break-words">{{ $unit?->phone ?: '-' }}</span>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70">
                <span class="text-slate-400 text-[10px] uppercase font-bold block">Status Halaman</span>
                <span class="inline-flex items-center space-x-1.5 text-emerald-700 font-bold mt-1 text-xs">
                    <i class="fa-solid fa-circle text-[8px] text-emerald-500"></i>
                    <span>{{ ($unit?->is_active ?? true) ? 'Aktif & Tayang' : 'Nonaktif' }}</span>
                </span>
            </div>
        </div>

        @if($unit?->sambutan)
            <div class="mt-4 p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-200/60 text-xs text-slate-700">
                <span class="font-bold text-emerald-800 block text-[11px] mb-1">Kutipan Sambutan Kepala Unit:</span>
                <p class="line-clamp-2 italic text-slate-600">"{{ \Illuminate\Support\Str::limit(strip_tags($unit->sambutan), 220) }}"</p>
            </div>
        @endif
    </div>

    {{-- 4. KONTEN MODUL 1: BERITA & MEDIA DOKUMENTASI --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        {{-- KOLOM KIRI: Berita Terbaru Unit (7 Cols) --}}
        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-newspaper text-[#00843d]"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Berita &amp; Artikel Unit</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        {{ $recentPosts->count() }} Terbit
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.posts.create') }}" class="text-xs font-bold text-[#00843d] hover:underline">
                        + Tulis
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 hover:underline">
                        Semua &rarr;
                    </a>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentPosts as $post)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                <img src="{{ $post->featured_image ?? '/uploads/logo-ppru-square.png' }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="font-bold text-xs sm:text-sm text-slate-800 hover:text-[#00843d] truncate block">
                                    {{ $post->title }}
                                </a>
                                <div class="flex items-center space-x-2 text-[10px] sm:text-[11px] text-slate-400 mt-0.5">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->views_count }} views</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-[#00843d] hover:bg-emerald-50 rounded-lg transition shrink-0" title="Edit Artikel">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-400">
                        <p>Belum ada berita khusus unit ini.</p>
                        <a href="{{ route('admin.posts.create') }}" class="inline-block mt-2 font-bold text-[#00843d] hover:underline">
                            + Tulis Berita Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Dokumentasi Foto & Video Unit (5 Cols) --}}
        <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-camera text-sky-600"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Media Galeri &amp; Video</h3>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.media.index') }}" class="text-xs font-bold text-sky-600 hover:underline">
                        Kelola Media &rarr;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                @forelse($recentPhotos as $photo)
                    <div class="rounded-xl overflow-hidden aspect-video bg-slate-100 relative group border border-slate-200">
                        <img src="{{ $photo->featured_image }}" alt="{{ $photo->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-end p-2">
                            <p class="text-[10px] text-white font-medium truncate">{{ $photo->title }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-6 text-center text-xs text-slate-400">
                        <p>Belum ada foto galeri unit.</p>
                        <a href="{{ route('admin.media.index') }}" class="inline-block mt-1 font-bold text-sky-600 hover:underline">
                            + Upload Foto
                        </a>
                    </div>
                @endforelse
            </div>

            @if(isset($recentVideos) && $recentVideos->count() > 0)
                <div class="pt-2 border-t border-slate-100 space-y-2">
                    <span class="text-[11px] font-bold text-slate-600 block">Video YouTube Unit</span>
                    @foreach($recentVideos->take(3) as $v)
                        <div class="flex items-center space-x-2 text-xs text-slate-700 bg-slate-50 p-2 rounded-xl border border-slate-200/60">
                            <i class="fa-brands fa-youtube text-red-600 text-sm shrink-0"></i>
                            <span class="truncate font-medium flex-1">{{ $v->title }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- 5. KONTEN MODUL 2: DEWAN GURU & ASATIDZ UNIT + TESTIMONI UNIT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        {{-- KOLOM KIRI: Dewan Guru / Asatidz Unit (7 Cols) --}}
        <div class="lg:col-span-7 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-chalkboard-user text-purple-600"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Dewan Asatidz &amp; GTK Unit</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                        {{ $recentTeachers->count() }} Guru
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dewan.create') }}" class="text-xs font-bold text-purple-600 hover:underline">
                        + Tambah
                    </a>
                    <a href="{{ route('admin.dewan.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 hover:underline">
                        Semua Asatidz &rarr;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @forelse($recentTeachers as $teacher)
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/70 flex flex-col items-center text-center relative group hover:bg-purple-50/40 hover:border-purple-300 transition">
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-white border border-slate-200 shadow-xs mb-2">
                            <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-bold text-xs text-slate-800 line-clamp-1 group-hover:text-purple-700">
                            {{ $teacher->name }}
                        </h4>
                        <p class="text-[11px] font-medium text-emerald-700 line-clamp-1 mt-0.5">
                            {{ $teacher->position }}
                        </p>
                        @if($teacher->education)
                            <span class="text-[9px] text-slate-500 mt-1 line-clamp-1">
                                {{ $teacher->education }}
                            </span>
                        @endif
                        <a href="{{ route('admin.dewan.edit', $teacher) }}" class="mt-2 text-[10px] font-bold text-purple-600 hover:underline inline-flex items-center space-x-1">
                            <i class="fa-solid fa-pen-to-square text-[9px]"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 py-8 text-center text-xs text-slate-400">
                        <p>Belum ada data dewan guru untuk unit ini.</p>
                        <a href="{{ route('admin.dewan.create') }}" class="inline-block mt-2 font-bold text-purple-600 hover:underline">
                            + Tambah Asatidz Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Testimoni Santri & Wali Unit (5 Cols) --}}
        <div class="lg:col-span-5 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-comments text-teal-600"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Testimoni Unit</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-200">
                        {{ $recentTestimonials->count() }} Ulasan
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.testimonials.create') }}" class="text-xs font-bold text-teal-600 hover:underline">
                        + Tambah
                    </a>
                    <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 hover:underline">
                        Semua &rarr;
                    </a>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($recentTestimonials as $testi)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 hover:bg-teal-50/30 transition">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-8 h-8 rounded-full overflow-hidden bg-white border border-slate-200 shrink-0">
                                    <img src="{{ $testi->photo_url }}" alt="{{ $testi->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5 class="font-bold text-xs text-slate-800 leading-snug">{{ $testi->name }}</h5>
                                    <span class="text-[10px] text-teal-700 font-medium block">{{ $testi->profession ?: 'Wali Santri' }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.testimonials.edit', $testi) }}" class="text-slate-400 hover:text-teal-600 p-1" title="Edit Testimoni">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                        </div>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-2 italic leading-relaxed">
                            "{{ $testi->content }}"
                        </p>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-400">
                        <p>Belum ada ulasan testimoni untuk unit ini.</p>
                        <a href="{{ route('admin.testimonials.create') }}" class="inline-block mt-2 font-bold text-teal-600 hover:underline">
                            + Tambah Testimoni Pertama
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- 6. KONTEN MODUL 3: PRESTASI & EKSTRAKURIKULER UNIT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        {{-- Prestasi Santri (6 Cols) --}}
        <div class="lg:col-span-6 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-trophy text-amber-500"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Prestasi Santri {{ $unit?->short_name }}</h3>
                </div>
                <a href="{{ route('admin.posts.create') }}?type=prestasi" class="text-xs font-bold text-amber-600 hover:underline">
                    + Tambah Prestasi
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentPrestasi as $pres)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50/40 border border-amber-200/60 gap-3">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-white overflow-hidden shrink-0 border border-amber-200">
                                <img src="{{ $pres->featured_image }}" alt="{{ $pres->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <h5 class="font-bold text-xs text-slate-800 truncate block">{{ $pres->title }}</h5>
                                <span class="text-[10px] text-amber-800">{{ $pres->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $pres) }}" class="p-1.5 text-slate-400 hover:text-amber-600">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-400">
                        <p>Belum ada publikasi prestasi unit.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Ekstrakurikuler Unggulan (6 Cols) --}}
        <div class="lg:col-span-6 bg-white p-5 sm:p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-shapes text-indigo-600"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Ekstrakurikuler {{ $unit?->short_name }}</h3>
                </div>
                <a href="{{ route('admin.posts.create') }}?type=ekskul" class="text-xs font-bold text-indigo-600 hover:underline">
                    + Tambah Ekskul
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentEkskul as $ekskul)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-indigo-50/40 border border-indigo-200/60 gap-3">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-white overflow-hidden shrink-0 border border-indigo-200">
                                <img src="{{ $ekskul->featured_image }}" alt="{{ $ekskul->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <h5 class="font-bold text-xs text-slate-800 truncate block">{{ $ekskul->title }}</h5>
                                <span class="text-[10px] text-indigo-800">Kegiatan Rutin</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $ekskul) }}" class="p-1.5 text-slate-400 hover:text-indigo-600">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-400">
                        <p>Belum ada publikasi ekstrakurikuler unit.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@else
    {{-- ============================================================ --}}
    {{-- TAMPILAN DASHBOARD GLOBAL ADMINISTRATOR PONDOK PESANTREN     --}}
    {{-- ============================================================ --}}

    @if(isset($hasVisitorLogs) && !$hasVisitorLogs)
        <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-amber-900">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg shrink-0"></i>
                <span>Tabel Database <code>visitor_logs</code> belum terpasang di database. Jalankan migrasi atau pasang skrip SQL analitik.</span>
            </div>
            <form action="{{ route('admin.migrate') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-3 py-1.5 rounded-xl transition cursor-pointer">
                    Jalankan Migrasi
                </button>
            </form>
        </div>
    @endif

    {{-- 1. WELCOME HERO CARD --}}
    <div class="bg-gradient-to-r from-[#0b1120] via-slate-900 to-[#1e293b] rounded-3xl p-5 sm:p-7 text-white shadow-xl relative overflow-hidden border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5">
            <div class="space-y-1.5 min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex items-center space-x-1.5 bg-slate-800/80 border border-slate-700 px-2.5 py-0.5 rounded-full text-xs text-amber-400 font-semibold">
                        <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i>
                        <span>Sistem Aktif</span>
                    </div>
                    <a href="https://ppru.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center space-x-1 bg-emerald-950/80 border border-emerald-500/40 px-2.5 py-0.5 rounded-full text-xs text-emerald-300 font-bold hover:text-emerald-200 transition">
                        <i class="fa-solid fa-globe text-emerald-400 text-[10px]"></i>
                        <span>ppru.ac.id</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[8px] ml-0.5"></i>
                    </a>
                </div>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl font-light leading-relaxed">
                    Panel kendali Pondok Pesantren Raudhatul Ulum Sakatiga. Kelola berita, unit pendidikan, dan layanan terpusat.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center space-x-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3.5 py-2.5 rounded-xl shadow-md transition">
                    <i class="fa-solid fa-external-link text-xs"></i>
                    <span>Lihat Web</span>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center space-x-1.5 bg-gradient-to-r from-[#da251c] to-[#ef4444] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg transition">
                    <i class="fa-solid fa-pen-nib text-xs"></i>
                    <span>Tulis Berita</span>
                </a>
                <a href="{{ route('admin.backup.download') }}" class="inline-flex items-center space-x-1.5 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold px-3 py-2.5 rounded-xl border border-slate-700 transition">
                    <i class="fa-solid fa-cloud-arrow-down text-amber-400 text-xs"></i>
                    <span>Backup SQL</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 1.5 MAINTENANCE MODE CONTROL CARD --}}
    <div class="rounded-3xl p-4 sm:p-5 shadow-lg border-2 transition-all duration-300 text-white {{ $isMaintenance ? 'border-amber-500' : 'border-emerald-500/40' }}" style="background: {{ $isMaintenance ? 'linear-gradient(135deg, #451a03 0%, #1e1b4b 100%)' : 'linear-gradient(135deg, #091e2b 0%, #0f172a 100%)' }}; color: #ffffff;">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center text-lg shrink-0 {{ $isMaintenance ? 'bg-amber-500 text-slate-950 font-black' : 'bg-emerald-500/20 text-emerald-400' }}">
                    <i class="fa-solid {{ $isMaintenance ? 'fa-triangle-exclamation' : 'fa-shield-halved' }}"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-sm sm:text-base font-extrabold text-white">Mode Maintenance</h3>
                        @if($isMaintenance)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase">Aktif (Tertutup)</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300">Publik Normal</span>
                        @endif
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-300 mt-0.5">
                        {{ $isMaintenance ? 'Pengunjung dialihkan ke halaman pemeliharaan. Hanya admin yang dapat melihat web.' : 'Website aktif dan dapat diakses umum.' }}
                    </p>
                </div>
            </div>

            <form action="{{ route('admin.maintenance.toggle') }}" method="POST" onsubmit="return confirm('{{ $isMaintenance ? 'Buka kembali website untuk umum?' : 'Aktifkan mode maintenance? Pengunjung umum tidak dapat mengakses.' }}')">
                @csrf
                <button type="submit" class="inline-flex items-center space-x-1.5 text-xs font-bold px-4 py-2.5 rounded-xl transition cursor-pointer shadow-md" style="background-color: {{ $isMaintenance ? '#10b981' : '#f59e0b' }}; color: {{ $isMaintenance ? '#ffffff' : '#0f172a' }};">
                    <i class="fa-solid {{ $isMaintenance ? 'fa-power-off' : 'fa-screwdriver-wrench' }} text-xs"></i>
                    <span>{{ $isMaintenance ? 'Buka Website' : 'Aktifkan Maintenance' }}</span>
                </button>
            </form>
        </div>
    </div>

    {{-- 2. SECURITY ALERT BANNER --}}
    @if(($stats['security_threats'] ?? 0) > 0)
        <div class="bg-red-50 border-l-4 border-red-500 rounded-2xl p-3.5 sm:p-4 shadow-xs flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-shield-virus text-red-600 text-lg shrink-0"></i>
                <div class="min-w-0">
                    <h4 class="text-xs sm:text-sm font-bold text-red-900">Keamanan Sistem</h4>
                    <p class="text-[11px] text-red-700 truncate">Terdeteksi {{ $stats['security_threats'] }} upaya pemindaian diblokir otomatis.</p>
                </div>
            </div>
            <a href="{{ route('admin.security.index', ['status' => 'danger']) }}" class="text-xs font-bold text-red-700 hover:text-red-900 bg-red-100 px-3 py-1.5 rounded-lg shrink-0">
                Detail &rarr;
            </a>
        </div>
    @endif

    {{-- 3. KPI ANALYTICS GRID (4 Cards) --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
        {{-- Card 1: Berita & Views --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-md border border-red-400/30" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #fee2e2;">Artikel Berita</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ number_format($stats['total_posts'] ?? 0) }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #fee2e2;">
                {{ number_format($stats['total_views'] ?? 0) }} pembaca
            </p>
        </div>

        {{-- Card 2: Pengunjung Web --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-md border border-sky-400/30" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #e0f2fe;">Pengunjung</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ number_format($stats['visitor_hits'] ?? 0) }}
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #e0f2fe;">
                Hits pelacak aktif
            </p>
        </div>

        {{-- Card 3: Guru & Fasilitas --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-md border border-purple-400/30" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #f3e8ff;">Guru &amp; Asatidz</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ $stats['total_dewan'] ?? 0 }} <span class="text-xs font-medium" style="color: #e9d5ff;">Asatidz</span>
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #f3e8ff;">
                {{ $stats['total_bidang'] ?? 0 }} Sarana &bull; {{ $stats['total_programs'] ?? 0 }} Unggulan
            </p>
        </div>

        {{-- Card 4: Keamanan --}}
        <div class="text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-md border border-emerald-400/30" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff;">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate" style="color: #d1fae5;">Keamanan</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-white/20 text-white flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white">
                {{ $stats['security_threats'] ?? 0 }} <span class="text-xs font-medium" style="color: #a7f3d0;">ancaman</span>
            </div>
            <p class="text-[10px] sm:text-xs font-medium mt-1 truncate" style="color: #d1fae5;">
                Firewall &amp; WAF aktif
            </p>
        </div>
    </div>

    {{-- 3B. OPERASIONAL & LAYANAN PESANTREN (Row 2 - 4 Cards) --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
        {{-- Card 5: Unit Pendidikan --}}
        <a href="{{ route('admin.unit-pendidikan.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Lembaga</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <div class="mt-2 sm:mt-4">
                <div class="text-xl sm:text-2xl font-black text-slate-900">{{ $stats['total_units'] ?? 8 }} <span class="text-xs font-semibold text-slate-400">Unit</span></div>
                <p class="text-[10px] sm:text-[11px] text-slate-500 mt-0.5 truncate">TK s/d Perguruan Tinggi</p>
            </div>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-amber-600 font-bold">
                <span>Kelola Unit</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </div>
        </a>

        {{-- Card 6: PSB Online --}}
        <a href="{{ route('admin.ppdb.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Pendaftar PPDB</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <div class="mt-2 sm:mt-4">
                <div class="text-xl sm:text-2xl font-black text-slate-900">{{ $stats['total_ppdb'] ?? 0 }} <span class="text-xs font-bold text-emerald-600">Santri</span></div>
                <p class="text-[10px] sm:text-[11px] text-slate-500 mt-0.5 truncate">{{ $stats['total_ppdb_verified'] ?? 0 }} terverifikasi</p>
            </div>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-emerald-600 font-bold">
                <span>Data PPDB</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </div>
        </a>

        {{-- Card 7: Layanan Terpadu --}}
        <a href="{{ route('admin.layanan.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan Terpadu</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
            </div>
            <div class="mt-2 sm:mt-4">
                <div class="text-xl sm:text-2xl font-black text-slate-900">{{ $stats['total_services'] ?? 0 }} <span class="text-xs font-bold text-blue-600">Pengajuan</span></div>
                <p class="text-[10px] sm:text-[11px] text-slate-500 mt-0.5 truncate">{{ $stats['pending_services'] ?? 0 }} menunggu respon</p>
            </div>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-blue-600 font-bold">
                <span>Buka Layanan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </div>
        </a>

        {{-- Card 8: Pusat Download --}}
        <a href="{{ route('admin.downloads.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200/80 shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Unduhan Dokumen</span>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm sm:text-lg">
                    <i class="fa-solid fa-file-arrow-down"></i>
                </div>
            </div>
            <div class="mt-2 sm:mt-4">
                <div class="text-xl sm:text-2xl font-black text-slate-900">{{ $stats['total_downloads'] ?? 0 }} <span class="text-xs font-bold text-purple-600">Berkas</span></div>
                <p class="text-[10px] sm:text-[11px] text-slate-500 mt-0.5 truncate">Brosur, hymne &amp; mars</p>
            </div>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-purple-600 font-bold">
                <span>Kelola Berkas</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </div>
        </a>
    </div>

    {{-- 3C. AKUN KHUSUS & DASHBOARD TERISOLASI 8 UNIT LEMBAGA (YAPIRUS PPRU) --}}
    <div class="bg-white rounded-3xl p-5 sm:p-7 border border-slate-200/80 shadow-xs space-y-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div class="space-y-1">
                <div class="inline-flex items-center space-x-1.5 px-3 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-[11px] font-bold text-emerald-800">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Multi-Unit Scoped Isolation Active (Middleware: unit.access)</span>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight flex items-center space-x-2">
                    <i class="fa-solid fa-graduation-cap text-[#00843d]"></i>
                    <span>Akun Khusus &amp; Dashboard Terisolasi 8 Unit Lembaga</span>
                </h3>
                <p class="text-xs text-slate-500 max-w-3xl leading-relaxed">
                    Setiap unit pendidikan di bawah Yayasan Pesantren Raudhatul Ulum (YAPIRUS) memiliki akun admin mandiri dengan hak akses terisolasi ketat. Admin unit hanya dapat mengelola profil dan konten milik unitnya sendiri, serta diblokir otomatis jika mencoba mengakses pengaturan sistem global atau unit lain.
                </p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <form action="{{ route('admin.unit.seed-demo') }}" method="POST" class="inline" onsubmit="return confirm('Muat ulang seluruh konten demo (berita, galeri, dewan asatidz, testimoni, prestasi, dan ekskul) untuk seluruh 8 unit pendidikan?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center space-x-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs cursor-pointer" title="Inisialisasi atau lengkapi data demo seluruh 8 unit">
                        <i class="fa-solid fa-arrows-rotate text-xs"></i>
                        <span>Muat Demo 8 Unit</span>
                    </button>
                </form>
                <a href="{{ route('admin.users.index', ['role' => 'admin_unit']) }}" class="inline-flex items-center space-x-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-users-gear text-xs text-amber-400"></i>
                    <span>Kelola Semua Akun</span>
                </a>
                <a href="{{ route('admin.unit-pendidikan.index') }}" class="inline-flex items-center space-x-1.5 bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-xs">
                    <i class="fa-solid fa-landmark text-xs"></i>
                    <span>Kelola 8 Unit</span>
                </a>
            </div>
        </div>

        {{-- Highlight Ketentuan Hak Akses Terisolasi --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-200/70">
            <div class="flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">1</div>
                <div>
                    <strong class="text-slate-800 font-bold block">Profil Unit Terbatas</strong>
                    <span class="text-slate-500 text-[11px] leading-snug block">Hanya mengedit profil unit sendiri (nama pimpinan, kontak, kurikulum, akreditasi).</span>
                </div>
            </div>
            <div class="flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">2</div>
                <div>
                    <strong class="text-slate-800 font-bold block">Konten Terisolasi</strong>
                    <span class="text-slate-500 text-[11px] leading-snug block">Hanya membuat &amp; mengedit berita, foto galeri, dan video milik unitnya sendiri.</span>
                </div>
            </div>
            <div class="flex items-start space-x-2.5">
                <div class="w-6 h-6 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">3</div>
                <div>
                    <strong class="text-slate-800 font-bold block">Proteksi Otomatis (HTTP 403)</strong>
                    <span class="text-slate-500 text-[11px] leading-snug block">Otomatis diblokir jika mencoba akses pengaturan global, hero slider, atau unit lain.</span>
                </div>
            </div>
        </div>

        {{-- Tabel 8 Akun Admin Unit --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-3.5">Unit Lembaga</th>
                        <th class="py-3 px-3.5">Email Akun Unit</th>
                        <th class="py-3 px-3.5">Password Default</th>
                        <th class="py-3 px-3.5">Konten Terdaftar</th>
                        <th class="py-3 px-3.5">Status Akses</th>
                        <th class="py-3 px-3.5 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($unitAdmins ?? [] as $ua)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-300 font-black text-[11px] shrink-0 whitespace-nowrap min-w-[74px] text-center shadow-2xs">
                                        {{ $ua['short_name'] }}
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <span class="font-extrabold text-slate-900 text-xs sm:text-sm block leading-snug break-words">{{ $ua['name'] }}</span>
                                        <span class="text-[10px] text-slate-500 block leading-tight mt-0.5">{{ $ua['category_type'] }} &bull; Pimpinan: {{ $ua['head_name'] ?: '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3.5 font-mono text-xs font-semibold text-emerald-800">
                                <div class="flex items-center space-x-1.5">
                                    <span>{{ $ua['email'] }}</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $ua['email'] }}'); alert('Email berhasil disalin: {{ $ua['email'] }}');" class="text-slate-400 hover:text-emerald-700 p-1" title="Salin Email">
                                        <i class="fa-regular fa-copy text-[11px]"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="py-3.5 px-3.5 font-mono text-xs text-slate-600">
                                <div class="flex items-center space-x-1.5">
                                    <span class="bg-slate-100 border border-slate-200 px-2.5 py-0.5 rounded-lg text-[11px] font-semibold text-slate-700 select-all">AdminUnitPPRU2026!</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('AdminUnitPPRU2026!'); alert('Password default disalin: AdminUnitPPRU2026!');" class="text-slate-400 hover:text-amber-700 p-1" title="Salin Password">
                                        <i class="fa-regular fa-copy text-[11px]"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="py-3.5 px-3.5 text-xs text-slate-600 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center text-[11px] font-semibold text-slate-700">
                                        <i class="fa-regular fa-newspaper text-emerald-600 mr-1"></i>{{ $ua['posts_count'] }} Berita
                                    </span>
                                    <span>&bull;</span>
                                    <span class="inline-flex items-center text-[11px] font-semibold text-slate-700">
                                        <i class="fa-solid fa-photo-film text-sky-600 mr-1"></i>{{ $ua['photos_count'] + $ua['videos_count'] }} Media
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1"></span>
                                    Terisolasi Aktif
                                </span>
                            </td>
                            <td class="py-3.5 px-3.5 text-center">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    @if(isset($ua['unit']))
                                        <a href="{{ route('admin.unit-pendidikan.edit', $ua['unit']) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-emerald-600 hover:text-white rounded-lg transition shadow-2xs" title="Kelola Profil &amp; Data Unit">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            <span>Kelola</span>
                                        </a>
                                        <a href="{{ route('pendidikan.show', $ua['unit']->slug) }}" target="_blank" class="inline-flex items-center justify-center w-7 h-7 text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition border border-slate-200/70" title="Kunjungi Halaman Publik">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-xs text-slate-400">Data akun unit sedang diinisialisasi...</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. TWO COLUMN DATA GRID (Berita Terbaru & Log Aktivitas) --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
        {{-- KOLOM KIRI: Berita Terbaru (7 Cols) --}}
        <div class="lg:col-span-7 bg-white p-5 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-newspaper text-[#da251c]"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Berita Terbaru</h3>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-bold text-[#da251c] hover:underline">
                    Semua Berita &rarr;
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentPosts as $post)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center space-x-3 min-w-0">
                            <div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                <img src="{{ $post->featured_image ?? '/uploads/logo-ppru-square.png' }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="font-bold text-xs sm:text-sm text-slate-800 hover:text-[#00913e] truncate block">
                                    {{ $post->title }}
                                </a>
                                <div class="flex items-center space-x-2 text-[10px] sm:text-[11px] text-slate-400 mt-0.5">
                                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $post->views_count }} views</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-[#da251c] hover:bg-red-50 rounded-lg transition shrink-0" title="Edit Artikel">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>
                    </div>
                @empty
                    <p class="py-8 text-center text-xs text-slate-400">Belum ada artikel dipublikasikan.</p>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Log Aktivitas & Keamanan (5 Cols) --}}
        <div class="lg:col-span-5 bg-white p-5 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                    <h3 class="font-extrabold text-sm text-slate-800">Log Aktivitas</h3>
                </div>
                <a href="{{ route('admin.security.index') }}" class="text-xs font-bold text-[#da251c] hover:underline">
                    Semua Log &rarr;
                </a>
            </div>

            <div class="space-y-2.5">
                @forelse($recentLogs as $log)
                    <div class="p-3 rounded-2xl border text-xs {{ $log->status === 'danger' ? 'bg-red-50/70 border-red-200 text-red-900' : ($log->status === 'warning' ? 'bg-amber-50/70 border-amber-200 text-amber-900' : 'bg-slate-50 border-slate-200/70 text-slate-800') }}">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold inline-flex items-center space-x-1.5 truncate">
                                @if($log->status === 'danger')
                                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-xs"></i>
                                @elseif($log->status === 'warning')
                                    <i class="fa-solid fa-shield-exclamation text-amber-600 text-xs"></i>
                                @else
                                    <i class="fa-solid fa-circle-info text-blue-500 text-xs"></i>
                                @endif
                                <span class="capitalize truncate">{{ str_replace('_', ' ', $log->action) }}</span>
                            </span>
                            <span class="text-[10px] text-slate-400 shrink-0">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-[11px] leading-relaxed line-clamp-2">{{ $log->description }}</p>
                    </div>
                @empty
                    <p class="py-8 text-center text-xs text-slate-400">Belum ada catatan aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>

@endif

</div>
@endsection
