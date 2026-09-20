@extends('layouts.admin')

@section('title', 'Kelola Menu Navigasi Website')
@section('header_title', 'Kelola Menu Navigasi')

@section('content')
<div class="space-y-6" x-data="{
    showAddModal: false,
    editMode: false,
    editFormAction: '',
    menuData: { id: '', name: '', url: '', icon: '', location: 'header', parent_id: '', target: '_self', order: 0, is_active: true },
    openAddModal(location = 'header', parentId = '') {
        this.editMode = false;
        this.editFormAction = '{{ route('admin.nav-menus.store') }}';
        this.menuData = { id: '', name: '', url: '', icon: '', location: location, parent_id: parentId, target: '_self', order: 0, is_active: true };
        this.showAddModal = true;
    },
    openEditModal(menu) {
        this.editMode = true;
        this.editFormAction = '/admin/nav-menus/' + menu.id;
        this.menuData = {
            id: menu.id,
            name: menu.name,
            url: menu.url,
            icon: menu.icon || '',
            location: menu.location,
            parent_id: menu.parent_id || '',
            target: menu.target || '_self',
            order: menu.order || 0,
            is_active: menu.is_active ? true : false
        };
        this.showAddModal = true;
    }
}">

    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Menu Navigasi Header &amp; Footer</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola susunan tombol link navigasi di header utama (termasuk submenu dropdown) dan footer website secara dinamis.</p>
            </div>
            <button @click="openAddModal('header')" type="button" class="inline-flex items-center space-x-2 bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-[#006e33] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-emerald-500/20 transition cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Menu Baru</span>
            </button>
        </div>

        {{-- TABEL MENU HEADER --}}
        <div class="mt-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span>1. Navigasi Header Utama (Navbar Atas)</span>
                </h3>
                <span class="text-[11px] text-slate-400">Item dengan sub-menu akan tampil sebagai dropdown</span>
            </div>

            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">Urutan</th>
                            <th class="py-3 px-4">Nama Menu</th>
                            <th class="py-3 px-4">URL Tujuan</th>
                            <th class="py-3 px-4 w-28">Ikon (FA)</th>
                            <th class="py-3 px-4 w-24 text-center">Status</th>
                            <th class="py-3 px-4 w-36 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($headerMenus as $m)
                        <tr class="bg-slate-50/50 font-semibold hover:bg-emerald-50/40 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-mono">#{{ $m->order }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    @if($m->icon)
                                        <i class="{{ $m->icon }} text-emerald-600 text-xs w-4 text-center"></i>
                                    @endif
                                    <span class="font-bold text-slate-900 text-xs">{{ $m->name }}</span>
                                    @if($m->children->isNotEmpty())
                                        <span class="text-[10px] px-2 py-0.2 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                                            {{ $m->children->count() }} Submenu
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 font-mono text-[11px]">{{ $m->url }}</td>
                            <td class="py-3 px-4 text-slate-400 font-mono text-[11px]">{{ $m->icon ?: '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($m->is_active)
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Aktif</span>
                                @else
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="openAddModal('header', {{ $m->id }})" type="button" class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-[#00843d] flex items-center justify-center transition cursor-pointer" title="Tambah Submenu">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                    <button @click="openEditModal({{ Js::from($m) }})" type="button" class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 flex items-center justify-center transition cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                    </button>
                                    <form action="{{ route('admin.nav-menus.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus menu {{ $m->name }} beserta submenunya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- SUBMENU DROPDOWN CHILDREN --}}
                        @foreach($m->children as $child)
                        <tr class="hover:bg-slate-50/80 transition text-slate-600">
                            <td class="py-2.5 px-4 text-center text-slate-300 font-mono text-[11px]">&rdquor; {{ $child->order }}</td>
                            <td class="py-2.5 px-4 pl-10">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-300">&boxur;</span>
                                    @if($child->icon)
                                        <i class="{{ $child->icon }} text-slate-500 text-xs w-4 text-center"></i>
                                    @endif
                                    <span class="text-xs font-semibold text-slate-700">{{ $child->name }}</span>
                                </div>
                            </td>
                            <td class="py-2.5 px-4 text-slate-400 font-mono text-[11px]">{{ $child->url }}</td>
                            <td class="py-2.5 px-4 text-slate-400 font-mono text-[11px]">{{ $child->icon ?: '-' }}</td>
                            <td class="py-2.5 px-4 text-center">
                                @if($child->is_active)
                                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Aktif</span>
                                @else
                                    <span class="text-[10px] font-semibold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="openEditModal({{ Js::from($child) }})" type="button" class="w-6 h-6 rounded bg-amber-50 hover:bg-amber-100 text-amber-600 flex items-center justify-center transition cursor-pointer" title="Edit Submenu">
                                        <i class="fa-solid fa-pen text-[9px]"></i>
                                    </button>
                                    <form action="{{ route('admin.nav-menus.destroy', $child) }}" method="POST" onsubmit="return confirm('Hapus submenu {{ $child->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-6 h-6 rounded bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition cursor-pointer" title="Hapus Submenu">
                                            <i class="fa-solid fa-trash text-[9px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada menu navigasi header.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TABEL MENU FOOTER --}}
        <div class="mt-8 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <span>2. Tautan Footer Cepat (Footer Quick Links)</span>
                </h3>
                <button @click="openAddModal('footer_quick')" type="button" class="text-xs font-bold text-amber-700 hover:text-amber-800 flex items-center gap-1 cursor-pointer">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Tambah Link Footer</span>
                </button>
            </div>

            <div class="overflow-x-auto border border-slate-200/80 rounded-2xl">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">Urutan</th>
                            <th class="py-3 px-4">Nama Tautan</th>
                            <th class="py-3 px-4">URL Tujuan</th>
                            <th class="py-3 px-4 w-24 text-center">Status</th>
                            <th class="py-3 px-4 w-28 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($footerMenus as $fm)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 text-center text-slate-400 font-mono">#{{ $fm->order }}</td>
                            <td class="py-3 px-4 font-bold text-slate-800">{{ $fm->name }}</td>
                            <td class="py-3 px-4 text-slate-500 font-mono text-[11px]">{{ $fm->url }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($fm->is_active)
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">Aktif</span>
                                @else
                                    <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="openEditModal({{ Js::from($fm) }})" type="button" class="w-7 h-7 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 flex items-center justify-center transition cursor-pointer" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                    </button>
                                    <form action="{{ route('admin.nav-menus.destroy', $fm) }}" method="POST" onsubmit="return confirm('Hapus tautan {{ $fm->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center transition cursor-pointer" title="Hapus">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada menu footer.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT MENU --}}
    <div x-show="showAddModal" 
         x-cloak 
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        
        <div class="fixed inset-0" @click="showAddModal = false"></div>

        <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden z-10"
             @click.stop>
            <form :action="editFormAction" method="POST">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/80">
                    <h3 class="font-black text-slate-800 text-sm" x-text="editMode ? 'Edit Item Menu Navigasi' : 'Tambah Item Menu Navigasi'"></h3>
                    <button @click="showAddModal = false" type="button" class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center hover:bg-slate-300 transition cursor-pointer">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Teks Menu <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="menuData.name" required placeholder="Contoh: Profil Singkat, Kurikulum, dll." class="w-full bg-slate-50 text-xs font-semibold rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">URL / Link Target <span class="text-red-500">*</span></label>
                        <input type="text" name="url" x-model="menuData.url" required placeholder="Contoh: /tentang-kami atau https://..." class="w-full bg-slate-50 text-xs font-mono rounded-xl px-3.5 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Menu</label>
                            <select name="location" x-model="menuData.location" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2.5 border border-slate-200">
                                <option value="header">Header Utama</option>
                                <option value="footer_quick">Footer Quick Links</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Menu Induk (Dropdown)</label>
                            <select name="parent_id" x-model="menuData.parent_id" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2.5 border border-slate-200">
                                <option value="">-- Menu Tingkat Atas --</option>
                                @foreach($allParentCandidates as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ikon FontAwesome (Opsional)</label>
                            <input type="text" name="icon" x-model="menuData.icon" placeholder="fa-solid fa-graduation-cap" class="w-full bg-slate-50 text-xs font-mono rounded-xl px-3 py-2.5 border border-slate-200">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Urutan</label>
                            <input type="number" name="order" x-model="menuData.order" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2.5 border border-slate-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Target Buka</label>
                            <select name="target" x-model="menuData.target" class="w-full bg-slate-50 text-xs rounded-xl px-3 py-2 border border-slate-200">
                                <option value="_self">Tab Saat Ini (_self)</option>
                                <option value="_blank">Tab Baru (_blank)</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-2 pt-6">
                            <input type="checkbox" name="is_active" id="modal_is_active" value="1" :checked="menuData.is_active" class="w-4 h-4 text-emerald-600 rounded border-slate-300">
                            <label for="modal_is_active" class="text-xs font-bold text-slate-700">Aktifkan Menu</label>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t border-slate-100 flex items-center justify-end space-x-2 bg-slate-50">
                    <button @click="showAddModal = false" type="button" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#00843d] hover:bg-[#006e33] text-white text-xs font-bold shadow transition cursor-pointer" x-text="editMode ? 'Perbarui Menu' : 'Simpan Menu'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
