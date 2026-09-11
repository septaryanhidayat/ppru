@extends('layouts.frontend')

@section('title', 'Galeri Video & Dokumentasi - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Kumpulan video profil sekolah, dokumentasi kegiatan santri, pentas prestasi, dan liputan pembelajaran SMA IT Ishlahul Ummah Prabumulih.')

@section('content')
{{-- HERO HEADER --}}
<div class="bg-gradient-to-r from-emerald-950 via-[#00913e] to-emerald-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Galeri Video</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Galeri Video SMA IT Ishlahul Ummah Prabumulih</h1>
        <p class="text-sm text-emerald-100 mt-2 font-light max-w-2xl">
            Dokumentasi video liputan kegiatan santri, tasmi' Al-Qur'an, praktikum sains, dan prestasi sekolah.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    
    <div class="text-center max-w-2xl mx-auto">
        <span class="text-xs font-bold text-orange-500 uppercase tracking-wider block">DOKUMENTASI MULTIMEDIA</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
            Video Kegiatan Santri Ishum
        </h2>
        <div class="w-16 h-1 bg-[#00913e] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($videos as $idx => $vid)
            <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-xl border border-gray-100 flex flex-col justify-between group reveal-fade-up delay-{{ $idx % 3 }}">
                <div>
                    <button type="button" class="w-full relative pb-[56.25%] h-0 bg-black overflow-hidden cursor-pointer group/vid block focus:outline-none" onclick="playPageVideo(this, '{{ $vid->youtube_id }}', '{{ addslashes($vid->title) }}')" aria-label="Putar video: {{ $vid->title }}">
                        <img src="{{ $vid->thumbnail_url }}" 
                             alt="Thumbnail video: {{ $vid->title }}" 
                             class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 group-hover/vid:scale-105"
                             loading="lazy"
                             onerror="this.src='https://img.youtube.com/vi/{{ $vid->youtube_id }}/hqdefault.jpg'">
                        <div class="absolute inset-0 bg-black/30 group-hover/vid:bg-black/10 transition flex items-center justify-center" aria-hidden="true">
                            <div class="w-14 h-14 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-xl group-hover/vid:scale-110 group-hover/vid:bg-red-600 transition-all">
                                <i class="fa-solid fa-play text-xl ml-1"></i>
                            </div>
                        </div>
                    </button>
                    <div class="p-6">
                        <h3 class="font-extrabold text-sm sm:text-base text-gray-900 group-hover:text-[#00913e] transition line-clamp-2 leading-snug">
                            {{ $vid->title }}
                        </h3>
                        @if($vid->description)
                            <p class="text-xs text-gray-600 line-clamp-3 mt-2 font-light leading-relaxed">
                                {!! strip_tags($vid->description) !!}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-gray-100 flex items-center justify-between text-xs text-gray-600 mt-2">
                    <span class="inline-flex items-center text-red-600 font-bold">
                        <i class="fa-brands fa-youtube mr-1.5 text-sm" aria-hidden="true"></i> YouTube
                    </span>
                    <span>SMA IT Ishlahul Ummah Prabumulih</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500 bg-white rounded-3xl border border-gray-100">
                <i class="fa-solid fa-video text-4xl text-gray-300 mb-3 block" aria-hidden="true"></i>
                <span>Belum ada video dokumentasi yang tersedia.</span>
            </div>
        @endforelse
    </div>

    <div class="pt-6">
        {{ $videos->links() }}
    </div>
</div>

<script>
function playPageVideo(el, id, title) {
    if (!id) return;
    el.onclick = null;
    el.innerHTML = '<iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/' + encodeURIComponent(id) + '?autoplay=1&rel=0" title="' + (title || 'YouTube video') + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}
</script>
@endsection
