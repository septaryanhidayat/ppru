@extends('layouts.admin')

@section('title', 'Agenda & Pengumuman')
@section('header_title', 'Agenda Kegiatan & Pengumuman Resmi')

@section('content')
<div class="space-y-8">
    
    {{-- BAGIAN 1: AGENDA KEGIATAN --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Agenda Kegiatan Sekolah</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola jadwal ujian, wisuda tahfidz, seminar, dan kalender akademik sekolah.</p>
            </div>
        </div>

        {{-- Form Tambah Agenda --}}
        <form action="{{ route('admin.agenda.store') }}" method="POST" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Nama Agenda Kegiatan *</label>
                    <input type="text" name="title" required placeholder="Contoh: Wisuda Tahfidz Angkatan X" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Tanggal Pelaksanaan *</label>
                    <input type="date" name="event_date" required class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Lokasi Tempat *</label>
                    <input type="text" name="location" required placeholder="Aula Utama Pondok PPRU" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Status Agenda</label>
                    <select name="status" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        <option value="upcoming">Akan Datang</option>
                        <option value="ongoing">Sedang Berlangsung</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between pt-2">
                <input type="text" name="content" placeholder="Keterangan tambahan atau catatan kegiatan (opsional)..." class="w-3/4 bg-white text-xs text-slate-800 rounded-xl px-4 py-2 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-calendar-plus"></i>
                    <span>Tambah Agenda</span>
                </button>
            </div>
        </form>

        {{-- Tabel Agenda --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Lokasi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $agenda->title }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $agenda->event_date }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $agenda->location }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $agenda->status === 'completed' ? 'bg-slate-100 text-slate-600' : ($agenda->status === 'ongoing' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-[#da251c]') }}">
                                    {{ ucfirst($agenda->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded transition" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Belum ada agenda kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- BAGIAN 2: PENGUMUMAN RESMI --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Pengumuman & Siaran Resmi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Terbitkan pengumuman resmi bagi santri, wali santri, guru, dan publik.</p>
            </div>
        </div>

        {{-- Form Tambah Pengumuman --}}
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Pengumuman *</label>
                    <input type="text" name="title" required placeholder="Contoh: Pengumuman Seleksi Penerimaan Santri Baru (PPDB)" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Status Publikasi</label>
                    <select name="status" class="w-full bg-white text-xs text-slate-800 rounded-xl px-4 py-2.5 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        <option value="publish">Publikasikan Langsung</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Isi Pesan Pengumuman *</label>
                <textarea name="content" required rows="3" placeholder="Tuliskan detail rincian pengumuman di sini..." class="w-full bg-white text-xs text-slate-800 rounded-xl p-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00913e]"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#00913e] hover:bg-[#094d28] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Terbitkan Pengumuman</span>
                </button>
            </div>
        </form>

        {{-- Tabel Pengumuman --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="py-3 px-4">Judul Pengumuman</th>
                        <th class="py-3 px-4">Tanggal Terbit</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengumumen as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $p->title }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $p->created_at ? $p->created_at->format('d M Y') : '-' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.pengumuman.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded transition" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-slate-400">Belum ada pengumuman resmi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
