@extends('layouts.admin')

@section('title', 'Galeri Foto & Video YouTube')
@section('header_title', 'Galeri Foto & Video YouTube')

@section('content')
<div class="space-y-8" x-data="{ editModalOpen: false, editId: null, editTitle: '', editAction: '' }">
    
    {{-- BAGIAN 1: GALERI FOTO --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-3">
                    <h2 class="text-xl font-black text-slate-900">Galeri Foto Dokumentasi Santri &amp; Sekolah</h2>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-[#00913e] border border-emerald-200">
                        {{ $photos->total() }} Foto
                    </span>
                </div>
                <p class="text-xs text-slate-600 mt-1">Kelola dan unggah foto dokumentasi kegiatan. Foto otomatis dioptimasi ke format WebP dan tampil di slider Home &amp; halaman Galeri.</p>
            </div>
        </div>

        {{-- Form Upload Foto Baru --}}
        <form action="{{ route('admin.media.photo.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-5 rounded-2xl border border-slate-300 flex flex-col md:flex-row items-center gap-4">
            @csrf
            <div class="w-full md:w-5/12">
                <label class="block text-xs font-bold text-slate-800 mb-1">Judul / Keterangan Foto <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Praktikum Biologi Laboratorium IPA..." class="w-full bg-white text-xs font-medium text-slate-900 rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <div class="w-full md:w-5/12">
                <label class="block text-xs font-bold text-slate-800 mb-1">File Foto (JPG/PNG/WebP, Maks 5MB) <span class="text-red-500">*</span></label>
                <input type="file" name="image" required accept="image/*" class="w-full text-xs text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#00913e] file:text-white hover:file:bg-[#094d28] cursor-pointer">
            </div>
            <div class="w-full md:w-2/12 flex items-end pt-5 md:pt-0">
                <button type="submit" class="w-full bg-[#00913e] hover:bg-[#094d28] text-white font-extrabold text-xs py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-upload"></i>
                    <span>Unggah Foto</span>
                </button>
            </div>
        </form>

        {{-- Grid Foto --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($photos as $photo)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                    <div class="relative aspect-square w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $photo->featured_image }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='/uploads/campus-ishum.webp'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition p-2.5 flex items-start justify-end gap-1.5">
                            {{-- Tombol Edit --}}
                            <button type="button" 
                                    @click="editId = {{ $photo->id }}; editTitle = '{{ addslashes($photo->title) }}'; editAction = '{{ route('admin.media.photo.update', $photo->id) }}'; editModalOpen = true"
                                    class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs hover:bg-amber-600 shadow transition cursor-pointer" 
                                    title="Edit Keterangan">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.media.photo.destroy', $photo) }}" method="POST" class="delete-photo-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDeletePhoto(this)" class="w-8 h-8 rounded-lg bg-[#da251c] text-white flex items-center justify-center text-xs hover:bg-red-700 shadow transition cursor-pointer" title="Hapus Foto">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="p-3 bg-white">
                        <p class="text-xs font-bold text-slate-900 line-clamp-2 leading-snug" title="{{ $photo->title }}">{{ $photo->title }}</p>
                        <p class="text-[10px] text-slate-500 mt-1">{{ $photo->created_at ? $photo->created_at->translatedFormat('d M Y') : '-' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-600 font-bold bg-slate-50 rounded-2xl border border-slate-200">
                    <i class="fa-regular fa-images text-4xl text-slate-400 mb-2 block"></i>
                    <span>Belum ada foto di galeri. Gunakan form di atas untuk mengunggah foto kegiatan.</span>
                </div>
            @endforelse
        </div>

        <div class="pt-2">
            {{ $photos->links() }}
        </div>
    </div>

    {{-- BAGIAN 2: VIDEO YOUTUBE --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
            <div>
                <div class="flex items-center space-x-3">
                    <h2 class="text-xl font-black text-slate-900">Video YouTube Resmi</h2>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-red-100 text-[#da251c] border border-red-200">
                        {{ $videos->total() }} Video
                    </span>
                </div>
                <p class="text-xs text-slate-600 mt-1">Tambah tayangan video resmi dari channel YouTube SMA IT Ishlahul Ummah Prabumulih.</p>
            </div>
        </div>

        {{-- Form Tambah Video YouTube --}}
        <form action="{{ route('admin.media.video.store') }}" method="POST" class="bg-slate-50 p-5 rounded-2xl border border-slate-300 flex flex-col md:flex-row items-center gap-4">
            @csrf
            <div class="w-full md:w-5/12">
                <label class="block text-xs font-bold text-slate-800 mb-1">Judul Video <span class="text-red-500">*</span></label>
                <input type="text" name="title" required placeholder="Judul video YouTube..." class="w-full bg-white text-xs font-medium text-slate-900 rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <div class="w-full md:w-5/12">
                <label class="block text-xs font-bold text-slate-800 mb-1">Link URL YouTube <span class="text-red-500">*</span></label>
                <input type="url" name="youtube_url" required placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-white text-xs font-medium text-slate-900 rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <div class="w-full md:w-2/12 flex items-end pt-5 md:pt-0">
                <button type="submit" class="w-full bg-[#da251c] hover:bg-[#b91c1c] text-white font-extrabold text-xs py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center space-x-2 cursor-pointer">
                    <i class="fa-brands fa-youtube text-sm"></i>
                    <span>Tambah Video</span>
                </button>
            </div>
        </form>

        {{-- Daftar Video --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($videos as $video)
                <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-xs flex flex-col justify-between">
                    <div>
                        <div class="aspect-video w-full bg-black">
                            @if($video->youtube_id)
                                <iframe src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_id }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Video Embed</div>
                            @endif
                        </div>
                        <div class="p-4 bg-white">
                            <h4 class="font-bold text-xs text-slate-900 line-clamp-2">{{ $video->title }}</h4>
                        </div>
                    </div>
                    <div class="p-4 pt-0 flex justify-end bg-white">
                        <form action="{{ route('admin.media.video.destroy', $video) }}" method="POST" class="delete-video-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteVideo(this)" class="p-2 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition text-xs font-bold flex items-center space-x-1 cursor-pointer" title="Hapus Video">
                                <i class="fa-solid fa-trash text-red-500"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-600 font-bold bg-slate-50 rounded-2xl border border-slate-200">Belum ada video yang ditambahkan.</div>
            @endforelse
        </div>

        <div>
            {{ $videos->links() }}
        </div>
    </div>

    {{-- MODAL EDIT FOTO --}}
    <div x-show="editModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
         style="display: none;">
        
        <div class="fixed inset-0" @click="editModalOpen = false"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-8 border border-slate-200 z-10 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                <h3 class="text-base font-black text-slate-900">Edit Keterangan Foto</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="editAction" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">Judul / Keterangan Foto <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="editTitle" required class="w-full bg-white text-xs font-semibold text-slate-900 rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">Ganti File Gambar (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-white hover:file:bg-black cursor-pointer">
                    <p class="text-[11px] text-slate-500 mt-1">Kosongkan jika hanya ingin mengubah judul/keterangan.</p>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                    <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00913e] hover:bg-[#094d28] text-white text-xs font-extrabold shadow-md transition cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function confirmDeletePhoto(btn) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Foto Ini?',
            text: 'Foto yang dihapus tidak dapat dipulihkan kembali.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#da251c',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Foto',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    } else {
        if (confirm('Hapus foto ini?')) {
            btn.closest('form').submit();
        }
    }
}

function confirmDeleteVideo(btn) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Video Ini?',
            text: 'Video akan dihapus dari daftar tayangan galeri.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#da251c',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Video',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    } else {
        if (confirm('Hapus video ini?')) {
            btn.closest('form').submit();
        }
    }
}
</script>
@endsection
