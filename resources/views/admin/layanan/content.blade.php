@extends('layouts.admin')

@section('title', 'Kelola Konten & Persyaratan Layanan Terpadu')
@section('header_title', 'Kelola Persyaratan, Prosedur & Konten Layanan Terpadu')

@section('content')
<div class="space-y-6" x-data="{ 
    activeTab: '{{ request('tab', 'izin') }}',
    izinItems: {{ json_encode($izinAccordions) }},
    kerjasamaItems: {{ json_encode($kerjasamaAccordions) }},
    sewaItems: {{ json_encode($sewaAccordions) }},
    addItem(listName) {
        this[listName].push({ title: 'Judul Persyaratan / Prosedur Baru', content: '<p>Tuliskan rincian persyaratan atau prosedur di sini...</p>' });
    },
    removeItem(listName, index) {
        if (confirm('Hapus butir persyaratan ini?')) {
            this[listName].splice(index, 1);
        }
    },
    moveUp(listName, index) {
        if (index > 0) {
            const temp = this[listName][index];
            this[listName].splice(index, 1);
            this[listName].splice(index - 1, 0, temp);
        }
    },
    moveDown(listName, index) {
        if (index < this[listName].length - 1) {
            const temp = this[listName][index];
            this[listName].splice(index, 1);
            this[listName].splice(index + 1, 0, temp);
        }
    }
}">

    {{-- TOP NAVIGATION TABS --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.layanan.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white text-slate-700 hover:bg-slate-50 border border-slate-200 transition">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Daftar Permohonan
            </a>

            <button type="button" @click="activeTab = 'izin'" :class="activeTab === 'izin' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-school"></i>
                <span>1. Izin Kunjungan Sekolah</span>
            </button>

            <button type="button" @click="activeTab = 'kerjasama'" :class="activeTab === 'kerjasama' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-handshake"></i>
                <span>2. Permohonan Kerja Sama</span>
            </button>

            <button type="button" @click="activeTab = 'sewa'" :class="activeTab === 'sewa' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-boxes-packing"></i>
                <span>3. Sewa Barang Milik Sekolah</span>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <a :href="activeTab === 'izin' ? '{{ route('layanan.izin') }}' : (activeTab === 'kerjasama' ? '{{ route('layanan.kerjasama') }}' : '{{ route('layanan.sewa') }}')" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-900 text-white transition flex items-center space-x-1.5 shadow-xs">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Tampilan Web</span>
            </a>
        </div>
    </div>

    {{-- ALERT INFO --}}
    <div class="bg-blue-50 border border-blue-200/80 rounded-2xl p-4 text-xs text-blue-800 flex items-start space-x-3">
        <i class="fa-solid fa-circle-info text-base mt-0.5 text-blue-600 flex-shrink-0"></i>
        <div class="leading-relaxed">
            <span class="font-bold">Panduan Pengaturan Akordion Persyaratan:</span>
            Anda dapat menyesuaikan judul butir, memindahkan urutan atas/bawah, menambahkan butir baru, atau mengedit kalimat rincian persyaratan. Format HTML seperti <code class="bg-blue-100 px-1 py-0.5 rounded font-mono">&lt;ul&gt;&lt;li&gt;...&lt;/li&gt;&lt;/ul&gt;</code> atau <code class="bg-blue-100 px-1 py-0.5 rounded font-mono">&lt;p&gt;...&lt;/p&gt;</code> didukung penuh agar tampilan di halaman publik rapi.
        </div>
    </div>

    {{-- TAB 1: IZIN KUNJUNGAN SEKOLAH --}}
    <div x-show="activeTab === 'izin'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="izin">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Izin Kunjungan ke Sekolah</h3>
                            <span class="text-xs text-slate-400">URL Publik: /izin-sekolah</span>
                        </div>
                    </div>

                    <button type="button" @click="addItem('izinItems')" class="px-3.5 py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in izinItems" :key="index">
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center flex-shrink-0" x-text="index + 1"></span>
                                    <input type="text" :name="'titles[' + index + ']'" x-model="item.title" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" @click="moveUp('izinItems', index)" :disabled="index === 0" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Naikkan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" @click="moveDown('izinItems', index)" :disabled="index === izinItems.length - 1" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Turunkan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" @click="removeItem('izinItems', index)" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Rincian Kalimat / Poin Persyaratan (Mendukung HTML &amp; Tag List):</label>
                                <textarea :name="'contents[' + index + ']'" x-model="item.content" rows="4" class="w-full bg-white border border-slate-200 text-xs rounded-xl p-3 text-slate-800 font-mono focus:ring-2 focus:ring-[#00913e] focus:outline-none leading-relaxed"></textarea>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-2.5 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Izin Kunjungan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TAB 2: PERMOHONAN KERJA SAMA --}}
    <div x-show="activeTab === 'kerjasama'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="kerjasama">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Permohonan Kerja Sama</h3>
                            <span class="text-xs text-slate-400">URL Publik: /permohonan-kerja-sama</span>
                        </div>
                    </div>

                    <button type="button" @click="addItem('kerjasamaItems')" class="px-3.5 py-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in kerjasamaItems" :key="index">
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center flex-shrink-0" x-text="index + 1"></span>
                                    <input type="text" :name="'titles[' + index + ']'" x-model="item.title" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" @click="moveUp('kerjasamaItems', index)" :disabled="index === 0" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Naikkan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" @click="moveDown('kerjasamaItems', index)" :disabled="index === kerjasamaItems.length - 1" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Turunkan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" @click="removeItem('kerjasamaItems', index)" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Rincian Kalimat / Poin Persyaratan (Mendukung HTML &amp; Tag List):</label>
                                <textarea :name="'contents[' + index + ']'" x-model="item.content" rows="4" class="w-full bg-white border border-slate-200 text-xs rounded-xl p-3 text-slate-800 font-mono focus:ring-2 focus:ring-[#00913e] focus:outline-none leading-relaxed"></textarea>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-2.5 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Kerja Sama</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TAB 3: SEWA BARANG MILIK SEKOLAH --}}
    <div x-show="activeTab === 'sewa'" class="space-y-6">
        <form action="{{ route('admin.layanan.content.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="service_type" value="sewa">

            <div class="bg-white rounded-3xl p-6 shadow-xs border border-slate-100 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Persyaratan &amp; Prosedur Sewa Barang Milik Sekolah</h3>
                            <span class="text-xs text-slate-400">URL Publik: /sewa-barang</span>
                        </div>
                    </div>

                    <button type="button" @click="addItem('sewaItems')" class="px-3.5 py-2 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Butir</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in sewaItems" :key="index">
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/50 space-y-3">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center space-x-2 flex-1">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center flex-shrink-0" x-text="index + 1"></span>
                                    <input type="text" :name="'titles[' + index + ']'" x-model="item.title" required placeholder="Judul Akordion (misal: Persyaratan Pelayanan)" class="w-full bg-white border border-slate-200 text-xs font-bold rounded-xl px-3 py-2 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                                </div>

                                <div class="flex items-center space-x-1">
                                    <button type="button" @click="moveUp('sewaItems', index)" :disabled="index === 0" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Naikkan">
                                        <i class="fa-solid fa-chevron-up text-xs"></i>
                                    </button>
                                    <button type="button" @click="moveDown('sewaItems', index)" :disabled="index === sewaItems.length - 1" class="p-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-30 cursor-pointer" title="Turunkan">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                    <button type="button" @click="removeItem('sewaItems', index)" class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition cursor-pointer" title="Hapus Butir">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Rincian Kalimat / Poin Persyaratan (Mendukung HTML &amp; Tag List):</label>
                                <textarea :name="'contents[' + index + ']'" x-model="item.content" rows="4" class="w-full bg-white border border-slate-200 text-xs rounded-xl p-3 text-slate-800 font-mono focus:ring-2 focus:ring-[#00913e] focus:outline-none leading-relaxed"></textarea>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="py-2.5 px-6 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center space-x-2 shadow-xs cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Sewa Barang</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
