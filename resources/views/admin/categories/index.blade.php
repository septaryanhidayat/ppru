@extends('layouts.admin')

@section('title', 'Kelola Kategori Artikel & Berita')
@section('header_title', 'Kategori Artikel & Berita')

@section('content')
<div class="space-y-6">
    {{-- Header Info --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-tags text-[#00843d]"></i>
                <span>Kelola Kategori Artikel &amp; Berita</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Kategori digunakan untuk mengelompokkan berita, artikel, prestasi, dan pengumuman di portal publik PPRU Sakatiga.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-xl transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Berita</span>
            </a>
        </div>
    </div>

    {{-- Grid: Form Tambah Kategori (1/3) & Tabel Kategori (2/3) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Form Tambah Kategori Baru --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs sticky top-20">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-plus-circle text-[#00843d]"></i>
                    <span>Tambah Kategori Baru</span>
                </h3>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Kajian Kitab Kuning" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                        @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Slug (Opsional / Otomatis)
                        </label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="kajian-kitab-kuning" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">
                        <p class="text-[10px] text-slate-400 mt-1">Jika dikosongkan, slug akan digenerate otomatis dari nama kategori.</p>
                        @error('slug') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Deskripsi Singkat (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="3" placeholder="Penjelasan singkat mengenai kategori ini..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] transition">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-[#00843d] hover:bg-[#006e33] text-white font-bold text-xs uppercase tracking-wider py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i>
                        <span>Simpan Kategori</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Tabel Daftar Kategori --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">
                            Daftar Kategori Terdaftar
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Total {{ $categories->total() }} kategori aktif dalam database.</p>
                    </div>

                    <form action="{{ route('admin.categories.index') }}" method="GET" class="relative w-full sm:w-64">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl pl-9 pr-4 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-100 text-[11px]">
                            <tr>
                                <th class="py-3.5 px-5">Nama Kategori</th>
                                <th class="py-3.5 px-4">Slug URL</th>
                                <th class="py-3.5 px-4 text-center">Jumlah Artikel</th>
                                <th class="py-3.5 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $cat)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-5">
                                        <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                            <i class="fa-regular fa-folder text-[#00843d]"></i>
                                            <span>{{ $cat->name }}</span>
                                        </div>
                                        @if($cat->description)
                                            <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-1">{{ $cat->description }}</p>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-[11px] text-slate-500">
                                        <span class="bg-slate-100 px-2 py-0.5 rounded text-slate-600">/kategori/{{ $cat->slug }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <a href="{{ route('admin.posts.index', ['category_id' => $cat->id]) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $cat->posts_count > 0 ? 'bg-emerald-50 text-[#00843d] hover:bg-emerald-100' : 'bg-slate-100 text-slate-400' }} transition" title="Lihat artikel dalam kategori ini">
                                            <i class="fa-solid fa-newspaper text-[10px]"></i>
                                            <span>{{ number_format($cat->posts_count) }}</span>
                                        </a>
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            {{-- Tombol Lihat di Web Publik --}}
                                            <a href="{{ route('artikel.index', ['kategori' => $cat->slug]) }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-[#00843d] flex items-center justify-center transition" title="Lihat di Web Publik">
                                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                            </a>

                                            {{-- Tombol Edit Modal --}}
                                            <button type="button" 
                                                onclick="openEditCategoryModal({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->slug) }}', '{{ addslashes($cat->description ?? '') }}')" 
                                                class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" 
                                                title="Edit Kategori">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" data-name="{{ $cat->name }}" class="btn-delete w-8 h-8 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition cursor-pointer" title="Hapus Kategori">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-slate-400">
                                        <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                        <span>Belum ada kategori artikel yang cocok.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT KATEGORI --}}
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl border border-slate-100 p-6 space-y-4 animate-scale-in">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-pen text-[#00843d]"></i>
                <span>Edit Kategori</span>
            </h3>
            <button type="button" onclick="closeEditCategoryModal()" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form id="editCategoryForm" action="" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori *</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div>
                <label for="edit_slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Slug URL</label>
                <input type="text" name="slug" id="edit_slug" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
            </div>

            <div>
                <label for="edit_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi</label>
                <textarea name="description" id="edit_description" rows="3" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#00843d] hover:bg-[#006e33] text-white font-bold text-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditCategoryModal(id, name, slug, description) {
    const form = document.getElementById('editCategoryForm');
    form.action = '/admin/categories/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_description').value = description;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}

function closeEditCategoryModal() {
    document.getElementById('editCategoryModal').classList.add('hidden');
}
</script>
@endsection
