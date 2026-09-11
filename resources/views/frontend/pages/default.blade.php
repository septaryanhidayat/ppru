@extends('layouts.frontend')

@section('title', $page->title . ' - ' . ($siteSettings['site_name'] ?? 'SMA IT Ishlahul Ummah Prabumulih'))

@section('content')
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">{{ $page->title }}</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">{{ $page->title }}</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100">
        <div class="prose-content text-gray-700 text-sm sm:text-base leading-relaxed space-y-4">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
