@extends('layouts.admin')

@section('title', 'Agenda, Info & Pengumuman')
@section('header_title', 'Manajemen Agenda Kegiatan, Info & Pengumuman')

@section('content')
<div class="space-y-6" x-data="{
    activeTab: '{{ $tab ?? 'agenda' }}',
    editAgendaModal: false,
    agendaToEdit: { id: '', title: '', event_date: '', location: '', content: '', status: 'upcoming' },
    editPengumumanModal: false,
    pengumumanToEdit: { id: '', title: '', content: '', status: 'publish' },
    openEditAgenda(item) {
        this.agendaToEdit = {
            id: item.id,
            title: item.title,
            event_date: item.event_date ? item.event_date.substring(0, 10) : '',
            location: item.location || '',
            content: item.content || '',
            status: item.status || 'upcoming'
        };
        this.editAgendaModal = true;
    },
    openEditPengumuman(item) {
        this.pengumumanToEdit = {
            id: item.id,
            title: item.title,
            content: item.content || '',
            status: item.status || 'publish'
        };
        this.editPengumumanModal = true;
    }
}">

    {{-- TOP BAR: TAB SELECTOR & SEARCH --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 sm:p-5 rounded-2xl shadow-xs border border-slate-200/80">
        <div class="flex items-center space-x-2 bg-slate-100 p-1.5 rounded-xl text-xs font-bold">
            <button type="button" @click="activeTab = 'agenda'" :class="activeTab === 'agenda' ? 'bg-[#00843d] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-lg transition flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Agenda Kegiatan ({{ $agendas->total() }})</span>
            </button>
            <button type="button" @click="activeTab = 'pengumuman'" :class="activeTab === 'pengumuman' ? 'bg-[#da251c] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-4 py-2 rounded-lg transition flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman &amp; Info ({{ $pengumumen->total() }})</span>
            </button>
        </div>

        {{-- SEARCH FORM --}}
        <form method="GET" action="{{ route('admin.agenda.index') }}" class="flex items-center space-x-2">
            <input type="hidden" name="tab" :value="activeTab">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul, lokasi, atau isi..." class="pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00913e] w-64">
            </div>
            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs px-3.5 py-2 rounded-xl font-bold transition">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.agenda.index', ['tab' => $tab ?? 'agenda']) }}" class="text-xs text-slate-500 hover:text-red-600 px-2 py-2" title="Reset Pencarian">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- TAB 1: AGENDA KEGIATAN --}}
    <div x-show="activeTab === 'agenda'" x-cloak class="space-y-6">
        
        {{-- FORM TAMBAH AGENDA (CARD ACCORDION / TOGGLE) --}}
        <div class="bg-white p-6 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-5" x-data="{ openAdd: false }">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-[#00843d]"></i>
                        <span>Agenda Kegiatan Sekolah &amp; Pondok</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola jadwal ujian, wisuda, perlombaan, seminar, dan kalender kegiatan santri.</p>
                </div>
                <button type="button" @click="openAdd = !openAdd" class="bg-[#00843d] hover:bg-emerald-800 text-white text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-2 shadow-xs cursor-pointer">
                    <i :class="openAdd ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    <span x-text="openAdd ? 'Tutup Form' : 'Tambah Agenda Baru'"></span>
                </button>
            </div>

            <div x-show="openAdd" x-collapse x-cloak>
                <form action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4 mt-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Agenda Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Wisuda Tahfidz Al-Qur'an 30 Juz Angkatan 2026" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                            <input type="date" name="event_date" required class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Lokasi Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="location" required placeholder="Gedung Serbaguna Kampus A" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Status Agenda</label>
                            <select name="status" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                                <option value="upcoming">Akan Datang (Upcoming)</option>
                                <option value="ongoing">Sedang Berlangsung (Ongoing)</option>
                                <option value="completed">Selesai (Completed)</option>
                                <option value="publish">Publikasi Umum</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Foto / Poster Agenda (Opsional)</label>
                            <input type="file" name="featured_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-[#00843d] bg-white rounded-xl border border-slate-200 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Catatan / Rincian Agenda (Opsional)</label>
                        <textarea name="content" rows="2" placeholder="Tuliskan susunan acara, pakaian/dresscode, atau instruksi khusus untuk peserta/santri..." class="w-full bg-white text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]"></textarea>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-calendar-plus"></i>
                            <span>Simpan &amp; Terbitkan Agenda</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL AGENDA --}}
        <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4">Nama Kegiatan</th>
                            <th class="py-3.5 px-4">Tanggal Pelaksanaan</th>
                            <th class="py-3.5 px-4">Lokasi</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($agendas as $agenda)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-extrabold text-slate-900 block text-xs">{{ $agenda->title }}</span>
                                    @if($agenda->content)
                                        <span class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ strip_tags($agenda->content) }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-700 font-semibold whitespace-nowrap">
                                    <i class="fa-regular fa-calendar text-emerald-600 mr-1.5"></i>
                                    {{ $agenda->event_date ? \Carbon\Carbon::parse($agenda->event_date)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">
                                    <i class="fa-solid fa-location-dot text-amber-500 mr-1"></i>
                                    {{ $agenda->location ?: 'PPRU Sakatiga' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @php
                                        $badgeStyles = match($agenda->status) {
                                            'ongoing' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'completed' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            default => 'bg-emerald-100 text-[#00843d] border-emerald-200'
                                        };
                                        $badgeLabel = match($agenda->status) {
                                            'ongoing' => 'Berlangsung',
                                            'completed' => 'Selesai',
                                            'upcoming' => 'Akan Datang',
                                            default => 'Publish'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $badgeStyles }}">
                                        {{ $badgeLabel }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <a href="{{ route('agenda.show', $agenda->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Lihat di Web">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <button type="button" @click="openEditAgenda({{ json_encode($agenda) }})" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition cursor-pointer" title="Edit Agenda">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" onsubmit="return confirm('Hapus agenda kegiatan {{ $agenda->title }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Agenda">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-slate-300 block"></i>
                                    Belum ada data agenda kegiatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>

    {{-- TAB 2: PENGUMUMAN & INFO RESMI --}}
    <div x-show="activeTab === 'pengumuman'" x-cloak class="space-y-6">
        
        {{-- FORM TAMBAH PENGUMUMAN (CARD ACCORDION / TOGGLE) --}}
        <div class="bg-white p-6 sm:p-7 rounded-3xl shadow-xs border border-slate-200/80 space-y-5" x-data="{ openAddP: false }">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-[#da251c]"></i>
                        <span>Papan Pengumuman &amp; Informasi Resmi</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Publikasikan informasi akademik, kelulusan PPDB, surat edaran mudir, dan pemberitahuan penting.</p>
                </div>
                <button type="button" @click="openAddP = !openAddP" class="bg-[#da251c] hover:bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-2 shadow-xs cursor-pointer">
                    <i :class="openAddP ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    <span x-text="openAddP ? 'Tutup Form' : 'Terbitkan Pengumuman / Info Baru'"></span>
                </button>
            </div>

            <div x-show="openAddP" x-collapse x-cloak>
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4 mt-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pengumuman / Informasi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Pengumuman Kelulusan Seleksi Penerimaan Santri Baru (PSB) Gelombang 1" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Status Publikasi</label>
                            <select name="status" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                                <option value="publish">Publikasikan Langsung</option>
                                <option value="draft">Simpan sebagai Draft</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Pesan Pengumuman <span class="text-red-500">*</span></label>
                        <textarea name="content" required rows="4" placeholder="Tuliskan detail surat edaran atau rincian pengumuman di sini..." class="w-full bg-white text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Lampiran Dokumen PDF / Edaran (Opsional)</label>
                        <input type="file" name="file_attachment_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-100 file:text-[#da251c] bg-white rounded-xl border border-slate-200 cursor-pointer">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-[#da251c] hover:bg-red-700 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span>Terbitkan Pengumuman</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL PENGUMUMAN --}}
        <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-4">Judul Pengumuman / Info</th>
                            <th class="py-3.5 px-4">Tanggal Terbit</th>
                            <th class="py-3.5 px-4">Lampiran</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengumumen as $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-extrabold text-slate-900 block text-xs">{{ $p->title }}</span>
                                    <span class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ strip_tags($p->content) }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
                                    {{ $p->created_at ? $p->created_at->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($p->file_attachment)
                                        <a href="{{ $p->file_attachment }}" target="_blank" class="inline-flex items-center text-[11px] font-semibold text-blue-600 hover:underline">
                                            <i class="fa-solid fa-file-pdf mr-1 text-red-500"></i> Unduh Berkas
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $p->status === 'publish' ? 'bg-emerald-100 text-[#00843d] border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center space-x-1.5">
                                        <a href="{{ route('pengumuman.show', $p->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Lihat di Web">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        <button type="button" @click="openEditPengumuman({{ json_encode($p) }})" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition cursor-pointer" title="Edit Pengumuman">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengumuman {{ $p->title }}?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Pengumuman">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <i class="fa-solid fa-bullhorn text-3xl mb-2 text-slate-300 block"></i>
                                    Belum ada pengumuman atau info resmi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $pengumumen->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL EDIT AGENDA --}}
    <div x-show="editAgendaModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div @click.away="editAgendaModal = false" class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-2xl w-full p-6 sm:p-7 space-y-5 animate-scale-in">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-[#00843d]"></i>
                    <span>Edit Agenda Kegiatan</span>
                </h3>
                <button type="button" @click="editAgendaModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/agenda') }}/' + agendaToEdit.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Agenda Kegiatan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" x-model="agendaToEdit.title" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                        <input type="date" name="event_date" x-model="agendaToEdit.event_date" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Lokasi Tempat <span class="text-red-500">*</span></label>
                        <input type="text" name="location" x-model="agendaToEdit.location" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Status Agenda</label>
                        <select name="status" x-model="agendaToEdit.status" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                            <option value="upcoming">Akan Datang (Upcoming)</option>
                            <option value="ongoing">Sedang Berlangsung (Ongoing)</option>
                            <option value="completed">Selesai (Completed)</option>
                            <option value="publish">Publikasi Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto Poster (Opsional)</label>
                        <input type="file" name="featured_image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-[#00843d] bg-slate-50 rounded-xl border border-slate-200 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Rincian Agenda Kegiatan</label>
                    <textarea name="content" x-model="agendaToEdit.content" rows="3" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]"></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="editAgendaModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#00843d] hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT PENGUMUMAN --}}
    <div x-show="editPengumumanModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div @click.away="editPengumumanModal = false" class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-2xl w-full p-6 sm:p-7 space-y-5 animate-scale-in">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-[#da251c]"></i>
                    <span>Edit Pengumuman / Info Resmi</span>
                </h3>
                <button type="button" @click="editPengumumanModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <form :action="'{{ url('admin/pengumuman') }}/' + pengumumanToEdit.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Pengumuman <span class="text-red-500">*</span></label>
                        <input type="text" name="title" x-model="pengumumanToEdit.title" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Status</label>
                        <select name="status" x-model="pengumumanToEdit.status" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                            <option value="publish">Publikasikan</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Rincian Pengumuman <span class="text-red-500">*</span></label>
                    <textarea name="content" x-model="pengumumanToEdit.content" rows="5" required class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c] leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Lampiran Berkas Dokumen (Opsional)</label>
                    <input type="file" name="file_attachment_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-100 file:text-[#da251c] bg-slate-50 rounded-xl border border-slate-200 cursor-pointer">
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="editPengumumanModal = false" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-semibold text-xs hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#da251c] hover:bg-red-700 text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
