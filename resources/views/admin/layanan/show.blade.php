@extends('layouts.admin')

@section('title', 'Detail Permohonan Layanan #' . $submission->id)
@section('header_title', 'Detail Permohonan ' . $submission->service_label)

@section('content')
<div class="space-y-6 max-w-5xl">

    {{-- TOP BACK BAR --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.layanan.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition shadow-xs">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Permohonan</span>
        </a>

        <div class="flex items-center space-x-2">
            <span class="px-3 py-1.5 rounded-full text-xs font-extrabold shadow-xs {{ $submission->status_badge }}">
                Status: {{ $submission->status_label }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: DETAIL PEMOHON & BERKAS (2 COLS) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- APPLICANT INFO CARD --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#00913e] flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Informasi Pemohon</h3>
                            <span class="text-xs text-slate-400">ID Permohonan: #{{ $submission->id }}</span>
                        </div>
                    </div>

                    <span class="px-3 py-1 rounded-lg text-xs font-bold
                        @if($submission->service_type === 'izin_kunjungan') bg-blue-50 text-blue-700 border border-blue-200
                        @elseif($submission->service_type === 'kerja_sama') bg-purple-50 text-purple-700 border border-purple-200
                        @else bg-teal-50 text-teal-700 border border-teal-200 @endif">
                        {{ $submission->service_label }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Nama Lengkap</span>
                        <div class="text-sm font-extrabold text-slate-900">{{ $submission->name }}</div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Asal Instansi / Lembaga</span>
                        <div class="text-sm font-semibold text-slate-800">{{ $submission->agency ?: '-' }}</div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Nomor WhatsApp</span>
                        <div class="flex items-center space-x-2 mt-0.5">
                            <span class="font-bold text-slate-900 text-sm">{{ $submission->whatsapp }}</span>
                            @if($submission->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->whatsapp) }}?text={{ urlencode('Halo Bapak/Ibu ' . $submission->name . ', kami dari pihak Pondok Pesantren Raudhatul Ulum Sakatiga terkait pengajuan ' . $submission->service_label . ' Anda...') }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-[10px] inline-flex items-center space-x-1 shadow-xs transition">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>Chat WA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Waktu Masuk</span>
                        <div class="text-xs font-medium text-slate-600">{{ $submission->created_at->translatedFormat('l, d F Y H:i:s') }}</div>
                    </div>
                </div>

                <div>
                    <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1 text-xs">Keperluan / Tujuan Pengajuan</span>
                    <div class="bg-slate-50 p-4 rounded-xl text-slate-800 text-xs leading-relaxed border border-slate-200/60 whitespace-pre-line">
                        {{ $submission->purpose }}
                    </div>
                </div>
            </div>

            {{-- UPLOADED DOCUMENTS CARD --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 space-y-5">
                <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Berkas Lampiran Persyaratan</h3>
                        <span class="text-xs text-slate-400">Semua file tersimpan aman dan terenkripsi acak</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- SURAT PERMOHONAN --}}
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg font-bold">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 text-xs block">Surat Permohonan</span>
                                    <span class="text-[10px] text-slate-400 block">Wajib Resmi / Lembaga</span>
                                </div>
                            </div>
                            @if($submission->letter_path)
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Ada</span>
                            @else
                                <span class="bg-slate-200 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-md">Tidak Ada</span>
                            @endif
                        </div>

                        @if($submission->letter_path)
                            <div class="pt-2">
                                <a href="{{ $submission->letter_path }}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center space-x-1.5 transition shadow-xs">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    <span>Buka Berkas Surat</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- KTP PEMOHON --}}
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg font-bold">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 text-xs block">KTP Pemohon</span>
                                    <span class="text-[10px] text-slate-400 block">Identitas Penanggung Jawab</span>
                                </div>
                            </div>
                            @if($submission->ktp_path)
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Ada</span>
                            @else
                                <span class="bg-slate-200 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-md">Tidak Ada</span>
                            @endif
                        </div>

                        @if($submission->ktp_path)
                            <div class="pt-2">
                                <a href="{{ $submission->ktp_path }}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center space-x-1.5 transition shadow-xs">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    <span>Buka Berkas KTP</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- NPWP (OPSIONAL) --}}
                    @if($submission->service_type === 'sewa_barang' || $submission->npwp_path)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between space-y-3 sm:col-span-2">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg font-bold">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 text-xs block">NPWP (Opsional / Lembaga)</span>
                                        <span class="text-[10px] text-slate-400 block">Nomor Pokok Wajib Pajak</span>
                                    </div>
                                </div>
                                @if($submission->npwp_path)
                                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-md">Ada</span>
                                @else
                                    <span class="bg-slate-200 text-slate-500 text-[10px] font-bold px-2 py-0.5 rounded-md">Tidak Dilampirkan</span>
                                @endif
                            </div>

                            @if($submission->npwp_path)
                                <div class="pt-2">
                                    <a href="{{ $submission->npwp_path }}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs flex items-center justify-center space-x-1.5 transition shadow-xs">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        <span>Buka Berkas NPWP</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: STATUS UPDATE & META (1 COL) --}}
        <div class="space-y-6">

            {{-- UPDATE STATUS FORM --}}
            <div class="bg-white rounded-2xl shadow-xs border border-slate-100 p-6 space-y-4">
                <div class="flex items-center space-x-2.5 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-sliders text-[#00913e]"></i>
                    <h3 class="font-black text-slate-900 text-sm">Perbarui Status Permohonan</h3>
                </div>

                <form action="{{ route('admin.layanan.status', $submission->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Status Baru</label>
                        <select name="status" required class="w-full bg-slate-50 border border-slate-200 text-xs font-bold rounded-xl px-4 py-2.5 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none">
                            <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi (Pending)</option>
                            <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Disetujui / Dijadwalkan (Approved)</option>
                            <option value="completed" {{ $submission->status === 'completed' ? 'selected' : '' }}>Selesai Terlaksana (Completed)</option>
                            <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Internal / Alasan</label>
                        <textarea name="admin_notes" rows="4" placeholder="Tuliskan catatan internal admin, jadwal yang disetujui, atau alasan penolakan..." class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-3 text-slate-800 focus:ring-2 focus:ring-[#00913e] focus:outline-none leading-relaxed">{{ old('admin_notes', $submission->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-[#00913e] hover:bg-[#05a849] text-white font-bold text-xs transition flex items-center justify-center space-x-1.5 shadow-xs">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </form>
            </div>

            {{-- TECHNICAL METADATA CARD --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200/70 p-5 space-y-3 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider block text-[10px]">Log Jejak Keamanan</span>
                <div>
                    <span class="text-slate-400 block text-[10px]">Alamat IP Pemohon:</span>
                    <span class="font-mono font-bold text-slate-700">{{ $submission->ip_address ?: '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px]">User Agent Browser:</span>
                    <span class="font-mono text-[10px] text-slate-500 line-clamp-3 break-all">{{ $submission->user_agent ?: '-' }}</span>
                </div>
            </div>

            {{-- DANGER ZONE: DELETE --}}
            <div class="bg-red-50/50 rounded-2xl border border-red-200/60 p-5 space-y-3">
                <span class="font-bold text-red-700 uppercase tracking-wider block text-[10px]">Tindakan Berbahaya</span>
                <p class="text-xs text-red-600/80 leading-relaxed">
                    Menghapus permohonan ini akan menghapus semua data pemohon beserta berkas file yang terlampir secara permanen dari server.
                </p>
                <form action="{{ route('admin.layanan.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Peringatan: Berkas dan data permohonan ini akan dihapus secara permanen. Lanjutkan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs transition flex items-center justify-center space-x-1.5 shadow-xs">
                        <i class="fa-solid fa-trash"></i>
                        <span>Hapus Permanen</span>
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
