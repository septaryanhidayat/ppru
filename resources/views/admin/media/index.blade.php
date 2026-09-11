@extends('layouts.admin')

@section('title', 'Galeri Foto & Video YouTube')
@section('header_title', 'Galeri Foto & Video YouTube')

@section('content')
<div class="space-y-8">
    
    {{-- BAGIAN 1: GALERI FOTO --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Galeri Foto Kegiatan & Album</h2>
                <p class="text-xs text-slate-500 mt-0.5">Unggah foto dokumentasi kegiatan santri & sekolah (Otomatis WebP Engine).</p>
            </div>
        </div>

        {{-- Form Upload Foto Baru --}}
        <form action="{{ route('admin.media.photo.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 flex flex-col md:flex-row items-center gap-4">
            @csrf
            <div class="w-full md:w-1/3">
                <input type="text" name="title" required placeholder="Judul / Keterangan Foto..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <div class="w-full md:w-1/2">
                <input type="file" name="image" required accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#00913e] file:text-white hover:file:bg-[#094d28]">
            </div>
            <button type="submit" class="w-full md:w-auto bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center justify-center space-x-2 flex-shrink-0 cursor-pointer">
                <i class="fa-solid fa-upload"></i>
                <span>Unggah Foto</span>
            </button>
        </form>

        {{-- Grid Foto --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($photos as $photo)
                <div class="group relative rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 aspect-square shadow-xs">
                    <img src="{{ $photo->featured_image }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition p-2.5 flex flex-col justify-between">
                        <form action="{{ route('admin.media.photo.destroy', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');" class="self-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-7 h-7 rounded-lg bg-red-600/90 text-white flex items-center justify-center text-xs hover:bg-red-700 transition" title="Hapus Foto">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        <p class="text-[11px] font-semibold text-white truncate">{{ $photo->title }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada foto di galeri.</div>
            @endforelse
        </div>

        <div>
            {{ $photos->links() }}
        </div>
    </div>

    {{-- BAGIAN 2: VIDEO YOUTUBE --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Video YouTube Resmi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah tayangan video resmi dari channel YouTube SMA IT Ishlahul Ummah Prabumulih.</p>
            </div>
        </div>

        {{-- Form Tambah Video YouTube --}}
        <form action="{{ route('admin.media.video.store') }}" method="POST" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 flex flex-col md:flex-row items-center gap-4">
            @csrf
            <div class="w-full md:w-1/3">
                <input type="text" name="title" required placeholder="Judul Video..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <div class="w-full md:w-1/2">
                <input type="url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <button type="submit" class="w-full md:w-auto bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center justify-center space-x-2 flex-shrink-0 cursor-pointer">
                <i class="fa-brands fa-youtube"></i>
                <span>Tambah Video</span>
            </button>
        </form>

        {{-- Daftar Video --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($videos as $video)
                <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="aspect-video w-full bg-black">
                            @if($video->youtube_id)
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Video Embed</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-xs text-slate-900 line-clamp-2">{{ $video->title }}</h4>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex justify-end">
                        <form action="{{ route('admin.media.video.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition text-xs" title="Hapus Video">
                                <i class="fa-solid fa-trash"></i> Hapus Video
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400">Belum ada video yang ditambahkan.</div>
            @endforelse
        </div>

        <div>
            {{ $videos->links() }}
        </div>
    </div>

</div>
@endsection
