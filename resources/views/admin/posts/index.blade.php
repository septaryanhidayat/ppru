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
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl font-bold text-xs transition {{ ($type ?? 'post') === $tKey ? 'bg-[#00913e] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                <i class="fa-solid {{ $tInfo['icon'] }}"></i>
                <span>{{ $tInfo['title'] }}</span>
                <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] {{ ($type ?? 'post') === $tKey ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ number_format($counts[$tKey] ?? 0) }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Search & Add Button --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="relative w-full sm:w-80">
            <input type="hidden" name="type" value="{{ $type ?? 'post' }}">
            <input type="text" name="q" placeholder="Cari {{ strtolower($currentMeta['singular']) }}..." value="{{ request('q') }}" class="w-full bg-white text-xs text-gray-800 rounded-xl pl-9 pr-4 py-2.5 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-xs"></i>
        </form>
        <a href="{{ route('admin.posts.create', ['type' => $type ?? 'post']) }}" class="bg-[#00913e] hover:bg-[#007532] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow transition flex items-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah {{ $currentMeta['singular'] }} Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase font-bold border-b border-gray-100 text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Gambar</th>
                        <th class="py-3.5 px-4">Judul {{ $currentMeta['singular'] }}</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Views</th>
                        <th class="py-3.5 px-4">Tanggal</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($posts as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                    @if($p->featured_image)
                                        <img src="{{ $p->featured_image }}" alt="" class="w-full h-full object-cover" onerror="this.src='/uploads/logo-ppru-square.png'">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 font-bold text-gray-900 max-w-xs">
                                <a href="{{ route('artikel.show', $p->slug) }}" target="_blank" class="hover:text-[#00913e] transition line-clamp-2">
                                    {{ $p->title }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                @if($p->categories->isNotEmpty())
                                    <span class="bg-emerald-50 text-[#00913e] font-semibold px-2 py-0.5 rounded-full text-[10px]">
                                        {{ $p->categories->first()->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $p->status === 'publish' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-gray-500">
                                {{ number_format($p->views_count) }}
                            </td>
                            <td class="py-3 px-4 text-gray-400">
                                {{ $p->published_at ? $p->published_at->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-name="{{ $p->title }}" class="btn-delete w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400">Belum ada {{ strtolower($currentMeta['singular']) }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
