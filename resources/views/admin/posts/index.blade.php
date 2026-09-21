@extends('layouts.admin')

@php
    $typeLabels = [
        'post' => ['title' => 'Artikel & Berita', 'singular' => 'Artikel', 'icon' => 'fa-newspaper'],
        'prestasi' => ['title' => 'Prestasi Siswa', 'singular' => 'Prestasi', 'icon' => 'fa-trophy'],
        'ekskul' => ['title' => 'Ekstrakurikuler', 'singular' => 'Ekstrakurikuler', 'icon' => 'fa-people-group'],
        'alumni' => ['title' => 'Data Alumni', 'singular' => 'Alumni', 'icon' => 'fa-user-graduate'],
    ];
    $currentMeta = $typeLabels[$type ?? 'post'] ?? $typeLabels['post'];
@endphp

@section('title', 'Kelola ' . $currentMeta['title'])
@section('header_title', 'Kelola ' . $currentMeta['title'])

@section('content')
<div class="space-y-6">
    {{-- Type Tabs Navigation --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        @foreach($typeLabels as $tKey => $tInfo)
            <a href="{{ route('admin.posts.index', ['type' => $tKey]) }}" 
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-bold text-xs transition {{ ($type ?? 'post') === $tKey ? 'bg-[#00843d] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <i class="fa-solid {{ $tInfo['icon'] }}"></i>
                <span>{{ $tInfo['title'] }}</span>
                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] {{ ($type ?? 'post') === $tKey ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ number_format($counts[$tKey] ?? 0) }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Search, Filter, & Action Buttons --}}
    <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
            <input type="hidden" name="type" value="{{ $type ?? 'post' }}">
            
            {{-- Search Box --}}
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" placeholder="Cari judul {{ strtolower($currentMeta['singular']) }}..." value="{{ request('q') }}" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl pl-9 pr-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-slate-400 text-xs"></i>
            </div>

            {{-- Category Filter --}}
            <div class="min-w-[170px]">
                <select name="category_id" onchange="this.form.submit()" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-3 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-2.5 rounded-xl transition">
                Filter
            </button>
            @if(request('q') || request('category_id'))
                <a href="{{ route('admin.posts.index', ['type' => $type ?? 'post']) }}" class="text-xs text-slate-500 hover:text-red-500 px-2 py-2">
                    Reset
                </a>
            @endif
        </form>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.categories.index') }}" class="bg-slate-100 hover:bg-emerald-50 hover:text-[#00843d] text-slate-700 px-4 py-2.5 rounded-xl font-bold text-xs transition flex items-center space-x-1.5 border border-slate-200">
                <i class="fa-solid fa-tags text-xs"></i>
                <span>Kelola Kategori</span>
            </a>
            <a href="{{ route('admin.posts.create', ['type' => $type ?? 'post']) }}" class="bg-[#00843d] hover:bg-[#006e33] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow transition flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah {{ $currentMeta['singular'] }}</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-100 text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Gambar</th>
                        <th class="py-3.5 px-4">Judul &amp; Penulis</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Views</th>
                        <th class="py-3.5 px-4">Tanggal Terbit</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($posts as $p)
                        @php
                            $publicUrl = match($p->type) {
                                'prestasi' => route('prestasi.show', $p->slug),
                                'page' => route('page.show', $p->slug),
                                default => route('artikel.show', $p->slug),
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4">
                                <div class="w-14 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                    @if($p->featured_image)
                                        <img src="{{ $p->featured_image }}" alt="" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='/uploads/logo-ppru-square.png'">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i class="fa-solid fa-image text-base"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-900 max-w-sm">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @if($p->is_featured)
                                        <span class="bg-amber-100 text-amber-800 text-[9px] font-extrabold px-1.5 py-0.5 rounded flex items-center gap-1">
                                            <i class="fa-solid fa-thumbtack text-[8px]"></i>
                                            <span>Headline</span>
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="font-bold hover:text-[#00843d] transition line-clamp-2">
                                        {{ $p->title }}
                                    </a>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-2">
                                    <span><i class="fa-solid fa-user-pen mr-1 text-slate-400"></i>{{ $p->display_author }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-clock mr-1"></i>{{ $p->reading_time }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($p->categories->isNotEmpty())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($p->categories as $c)
                                            <a href="{{ route('admin.posts.index', ['category_id' => $c->id, 'type' => $type ?? 'post']) }}" class="bg-emerald-50 hover:bg-emerald-100 text-[#00843d] font-semibold px-2 py-0.5 rounded-full text-[10px] transition">
                                                {{ $c->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $p->status === 'publish' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500">
                                {{ number_format($p->views_count) }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 font-medium">
                                @if($p->published_at)
                                    <div>{{ $p->published_at->format('d M Y') }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $p->published_at->format('H:i') }} WIB</div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="flex items-center justify-end space-x-1.5">
                                    {{-- Lihat di Web Publik --}}
                                    <a href="{{ $publicUrl }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-[#00843d] flex items-center justify-center transition" title="Lihat di Web Publik">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Edit Konten">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-name="{{ $p->title }}" class="btn-delete w-8 h-8 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400">
                                <i class="fa-regular fa-newspaper text-3xl mb-2 text-slate-300 block"></i>
                                <span>Belum ada {{ strtolower($currentMeta['singular']) }} yang cocok dengan filter pencarian.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
