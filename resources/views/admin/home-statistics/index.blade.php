@extends('layouts.admin')

@section('title', 'Kelola Statistik Beranda Pesantren')

@section('content')
<div class="space-y-6" x-data="{
    openCreateModal: false,
    openEditModal: false,
    activeEdit: { id: null, number: '', label: '', description: '', icon: '', order: 1, is_active: true },
    editStat(item) {
        this.activeEdit = Object.assign({}, item);
        this.openEditModal = true;
    }
}">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center space-x-2 text-xs font-semibold text-emerald-700 mb-1">
                <i class="fa-solid fa-chart-simple text-sm"></i>
                <span class="uppercase tracking-wider">Konten Beranda Utama</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Statistik &amp; Pencapaian Pesantren</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola kotak-kotak statistik counter angka di beranda. Anda dapat menambah, mengubah, atau menghapus kotak statistik kapan saja.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button @click="openCreateModal = true" class="bg-gradient-to-r from-[#00843d] to-[#05a849] hover:from-[#00632e] hover:to-[#00843d] text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-md shadow-emerald-600/20 inline-flex items-center gap-2 cursor-pointer transform hover:scale-102">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Tambah Kotak Statistik</span>
            </button>
        </div>
    </div>

    {{-- LIVE PREVIEW DI ADMIN (PERSIS DENGAN TAMPILAN BERANDA) --}}
    <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-xs space-y-3">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-2 text-xs font-bold text-slate-700">
                <i class="fa-solid fa-eye text-emerald-600"></i>
                <span>Pratinjau Langsung (Live Preview di Beranda)</span>
            </div>
            <span class="text-[11px] bg-emerald-100 text-emerald-800 font-bold px-2.5 py-0.5 rounded-full">
                {{ $statistics->where('is_active', true)->count() }} Kotak Aktif Ditampilkan
            </span>
        </div>

        <div class="p-6 sm:p-8 rounded-2xl bg-gradient-to-r from-[#00843d] via-emerald-800 to-[#00843d] text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(white_1px,transparent_1px)] [background-size:24px_24px] opacity-10 pointer-events-none"></div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 text-center relative z-10">
                @forelse($statistics->where('is_active', true) as $stat)
                <div class="p-4 sm:p-5 bg-white/10 backdrop-blur-xs rounded-2xl border border-white/15 flex flex-col justify-between transition hover:bg-white/15">
                    <div>
                        <div class="text-2xl sm:text-4xl font-black text-amber-400 mb-1 tracking-tight">{{ $stat->number }}</div>
                        <div class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-emerald-100">{{ $stat->label }}</div>
                        @if($stat->description)
                            <p class="text-[10px] sm:text-[11px] text-emerald-200/80 mt-1 leading-snug">{{ $stat->description }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full py-8 text-center text-emerald-200 text-xs">
                    Belum ada kotak statistik yang berstatus aktif.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- TABEL PENGELOLAAN STATISTIK --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-table-list text-slate-400 text-sm"></i>
                <h2 class="text-sm font-bold text-slate-800">Daftar Seluruh Kotak Statistik</h2>
            </div>
            <span class="text-xs text-slate-400">Total: {{ $statistics->count() }} kotak</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3.5 px-4 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4 w-36">Angka / Nilai</th>
                        <th class="py-3.5 px-4">Label Judul</th>
                        <th class="py-3.5 px-4">Keterangan Subteks</th>
                        <th class="py-3.5 px-4 w-28 text-center">Status</th>
                        <th class="py-3.5 px-4 w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($statistics as $stat)
                    <tr class="hover:bg-slate-50/80 transition {{ ! $stat->is_active ? 'opacity-60 bg-slate-50/40' : '' }}">
                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-700 text-xs">
                                {{ $stat->order }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-black text-emerald-800 text-base">{{ $stat->number }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            {{ $stat->label }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 max-w-xs truncate">
                            {{ $stat->description ?: '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <form action="{{ route('admin.home-statistics.toggle', $stat->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $stat->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-200 text-slate-600 hover:bg-slate-300' }}" title="Klik untuk ubah status">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $stat->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $stat->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </form>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <div class="flex items-center justify-end space-x-1.5">
                                <button @click="editStat({{ Js::from($stat) }})" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 flex items-center justify-center transition cursor-pointer" title="Edit Kotak">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                <form action="{{ route('admin.home-statistics.destroy', $stat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kotak statistik ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition cursor-pointer" title="Hapus Kotak">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400">
                            <i class="fa-solid fa-chart-pie text-3xl mb-2 text-slate-300 block"></i>
                            Belum ada data kotak statistik. Klik "Tambah Kotak Statistik" untuk memulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH KOTAK STATISTIK --}}
    <div x-show="openCreateModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="openCreateModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 animate-fadeIn space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i class="fa-solid fa-plus text-xs"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base">Tambah Kotak Statistik Baru</h3>
                </div>
                <button @click="openCreateModal = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.home-statistics.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Angka / Nilai Pencapaian <span class="text-red-500">*</span></label>
                    <input type="text" name="number" required placeholder="Contoh: 3.500+ atau 100% atau 75+" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <p class="text-[10px] text-slate-400 mt-1">Dapat menggunakan simbol plus (+) atau persen (%).</p>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Label / Judul Kotak <span class="text-red-500">*</span></label>
                    <input type="text" name="label" required placeholder="Contoh: SANTRI AKTIF MUKIM" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-semibold uppercase focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi / Subteks Tambahan</label>
                    <textarea name="description" rows="2" placeholder="Contoh: Dari berbagai provinsi nusantara" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Urutan</label>
                        <input type="number" name="order" value="{{ ($statistics->max('order') ?? 0) + 1 }}" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="flex items-end pb-2">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <span class="font-bold text-slate-700">Tampilkan di Beranda</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold transition shadow-md cursor-pointer">
                        Simpan Kotak
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT KOTAK STATISTIK --}}
    <div x-show="openEditModal" 
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
        <div @click.away="openEditModal = false" class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 animate-fadeIn space-y-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                    </div>
                    <h3 class="font-black text-slate-900 text-base">Edit Kotak Statistik</h3>
                </div>
                <button @click="openEditModal = false" class="text-slate-400 hover:text-slate-600 cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/home-statistics') }}/' + activeEdit.id" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Angka / Nilai Pencapaian <span class="text-red-500">*</span></label>
                    <input type="text" name="number" x-model="activeEdit.number" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Label / Judul Kotak <span class="text-red-500">*</span></label>
                    <input type="text" name="label" x-model="activeEdit.label" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-semibold uppercase focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi / Subteks Tambahan</label>
                    <textarea name="description" x-model="activeEdit.description" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor Urutan</label>
                        <input type="number" name="order" x-model="activeEdit.order" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div class="flex items-end pb-2">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="activeEdit.is_active" class="rounded text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <span class="font-bold text-slate-700">Tampilkan di Beranda</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end space-x-2 border-t border-slate-100">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold transition shadow-md cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
