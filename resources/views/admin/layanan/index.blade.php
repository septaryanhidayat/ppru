@extends('layouts.admin')

@section('title', 'Permohonan Layanan Terpadu')
@section('header_title', 'Kelola Permohonan Layanan Terpadu Sekolah')

@section('content')
<div class="space-y-6">

    {{-- TOP STATISTICS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 sm:gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-xs">
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Masuk</span>
            <div class="text-xl sm:text-2xl font-black text-slate-800">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-amber-50/70 p-4 rounded-2xl border border-amber-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block mb-1">Menunggu</span>
            <div class="text-xl sm:text-2xl font-black text-amber-800">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-blue-50/70 p-4 rounded-2xl border border-blue-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider block mb-1">Disetujui</span>
            <div class="text-xl sm:text-2xl font-black text-blue-800">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-emerald-50/70 p-4 rounded-2xl border border-emerald-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block mb-1">Selesai</span>
            <div class="text-xl sm:text-2xl font-black text-emerald-800">{{ $stats['completed'] }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Izin Kunjungan</span>
            <div class="text-xl sm:text-2xl font-black text-slate-700">{{ $stats['izin'] }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kerja Sama</span>
            <div class="text-xl sm:text-2xl font-black text-slate-700">{{ $stats['kerjasama'] }}</div>
        </div>
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 shadow-xs">
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Sewa Barang</span>
            <div class="text-xl sm:text-2xl font-black text-slate-700">{{ $stats['sewa'] }}</div>
        </div>
    </div>

    {{-- ACTION BAR & FILTERS --}}
    <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-xs border border-slate-100 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.layanan.index') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ !request('type') || request('type') === 'all' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Layanan
            </a>
            <a href="{{ route('admin.layanan.index', ['type' => 'izin_kunjungan', 'status' => request('status')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request('type') === 'izin_kunjungan' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Izin Kunjungan
            </a>
            <a href="{{ route('admin.layanan.index', ['type' => 'kerja_sama', 'status' => request('status')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request('type') === 'kerja_sama' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Kerja Sama
            </a>
            <a href="{{ route('admin.layanan.index', ['type' => 'sewa_barang', 'status' => request('status')]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request('type') === 'sewa_barang' ? 'bg-[#00913e] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Sewa Barang
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.layanan.content') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white transition flex items-center space-x-1.5 shadow-xs">
                <i class="fa-solid fa-file-shield text-xs"></i>
                <span>Kelola Syarat &amp; Konten</span>
            </a>

            <form action="{{ route('admin.layanan.index') }}" method="GET" class="flex items-center gap-2">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs font-semibold rounded-xl px-3 py-2 text-slate-700 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / instansi..." class="bg-slate-50 border border-slate-200 text-xs rounded-xl pl-8 pr-3 py-2 text-slate-700 w-40 sm:w-48 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                    <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
                </div>
            </form>
        </div>
    </div>

    {{-- SUBMISSIONS TABLE --}}
    <div class="bg-white rounded-2xl shadow-xs border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold border-b border-slate-100 text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Tgl &amp; Status</th>
                        <th class="py-3.5 px-4">Layanan</th>
                        <th class="py-3.5 px-4">Pemohon &amp; Instansi</th>
                        <th class="py-3.5 px-4">Kontak &amp; Keperluan</th>
                        <th class="py-3.5 px-4">Dokumen</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($submissions as $sub)
                        <tr class="hover:bg-slate-50/80 transition {{ $sub->status === 'pending' ? 'bg-amber-50/20' : '' }}">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold block w-max mb-1 {{ $sub->status_badge }}">
                                    {{ $sub->status_label }}
                                </span>
                                <span class="text-[11px] text-slate-400 block">
                                    {{ $sub->created_at->translatedFormat('d M Y H:i') }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold inline-flex items-center space-x-1.5
                                    @if($sub->service_type === 'izin_kunjungan') bg-blue-50 text-blue-700 border border-blue-200/60
                                    @elseif($sub->service_type === 'kerja_sama') bg-purple-50 text-purple-700 border border-purple-200/60
                                    @else bg-teal-50 text-teal-700 border border-teal-200/60 @endif">
                                    <i class="fa-solid 
                                        @if($sub->service_type === 'izin_kunjungan') fa-school
                                        @elseif($sub->service_type === 'kerja_sama') fa-handshake
                                        @else fa-boxes-packing @endif text-[10px]"></i>
                                    <span>{{ $sub->service_label }}</span>
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="font-extrabold text-slate-900 text-sm mb-0.5">{{ $sub->name }}</div>
                                <div class="text-[11px] text-slate-500 font-medium flex items-center">
                                    <i class="fa-solid fa-building text-[10px] mr-1 text-slate-400"></i>
                                    <span>{{ $sub->agency ?: '-' }}</span>
                                </div>
                            </td>

                            <td class="py-3.5 px-4 max-w-xs">
                                @if($sub->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sub->whatsapp) }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-semibold text-xs inline-flex items-center mb-1 hover:underline">
                                        <i class="fa-brands fa-whatsapp mr-1 text-emerald-500"></i> {{ $sub->whatsapp }}
                                    </a>
                                @endif
                                <p class="text-slate-600 text-[11px] line-clamp-2 leading-relaxed" title="{{ $sub->purpose }}">
                                    {{ $sub->purpose }}
                                </p>
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @if($sub->letter_path)
                                        <a href="{{ $sub->letter_path }}" target="_blank" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Lihat Surat Permohonan">
                                            <i class="fa-solid fa-file-lines text-xs"></i>
                                        </a>
                                    @endif
                                    @if($sub->ktp_path)
                                        <a href="{{ $sub->ktp_path }}" target="_blank" class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition" title="Lihat KTP Pemohon">
                                            <i class="fa-solid fa-id-card text-xs"></i>
                                        </a>
                                    @endif
                                    @if($sub->npwp_path)
                                        <a href="{{ $sub->npwp_path }}" target="_blank" class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-600 hover:text-white flex items-center justify-center transition" title="Lihat NPWP">
                                            <i class="fa-solid fa-file-invoice text-xs"></i>
                                        </a>
                                    @endif
                                    @if(!$sub->letter_path && !$sub->ktp_path && !$sub->npwp_path)
                                        <span class="text-slate-300 text-[10px]">-</span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('admin.layanan.show', $sub->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-800 text-slate-700 hover:text-white text-[11px] font-bold transition flex items-center space-x-1">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        <span>Detail</span>
                                    </a>

                                    <form action="{{ route('admin.layanan.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan dari {{ addslashes($sub->name) }}? Berkas terlampir juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="Hapus Permohonan">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fa-solid fa-inbox"></i>
                                </div>
                                <span class="font-bold text-slate-600 block mb-1">Belum Ada Permohonan Layanan</span>
                                <span class="text-xs text-slate-400">Permohonan izin kunjungan, kerja sama, dan sewa barang akan muncul di sini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
