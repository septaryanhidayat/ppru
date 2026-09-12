@extends('layouts.admin')

@section('title', 'Detail Pendaftaran: ' . $ppdb->full_name)
@section('header_title', 'Detail Calon Santri: ' . $ppdb->full_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- TOP BAR --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.ppdb.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-xs transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar PPDB</span>
        </a>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.ppdb.print', $ppdb) }}" target="_blank" class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-xs transition">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Bukti Pendaftaran</span>
            </a>
        </div>
    </div>

    {{-- STATUS & NOTES CARD --}}
    <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block">Status Pendaftaran</span>
                <div class="flex items-center space-x-3 mt-1">
                    <span class="font-mono font-black text-lg text-[#da251c]">{{ $ppdb->registration_number }}</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $ppdb->status_badge }}">
                        {{ $ppdb->status_label }}
                    </span>
                </div>
            </div>
            <div class="text-xs text-slate-500 text-right">
                <span class="block font-medium">Waktu Pendaftaran:</span>
                <span class="font-bold text-slate-700">{{ $ppdb->created_at->translatedFormat('l, d F Y - H:i') }} WIB</span>
            </div>
        </div>

        {{-- Form Ubah Status --}}
        <form action="{{ route('admin.ppdb.status', $ppdb) }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-end gap-3">
            @csrf
            <div class="w-full sm:w-1/3">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Ubah Status</label>
                <select name="status" class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    <option value="pending" {{ $ppdb->status === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="verified" {{ $ppdb->status === 'verified' ? 'selected' : '' }}>Terverifikasi (Berkas Lengkap)</option>
                    <option value="accepted" {{ $ppdb->status === 'accepted' ? 'selected' : '' }}>Diterima Sebagai Santri</option>
                    <option value="rejected" {{ $ppdb->status === 'rejected' ? 'selected' : '' }}>Ditolak / Berkas Tidak Sesuai</option>
                </select>
            </div>
            <div class="w-full sm:w-1/2">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Catatan Panitia (Opsional)</label>
                <input type="text" name="notes" value="{{ old('notes', $ppdb->notes) }}" placeholder="Catatan hasil verifikasi..." class="w-full bg-white text-xs rounded-xl px-3 py-2 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
            </div>
            <button type="submit" class="bg-[#00913e] hover:bg-[#007532] text-white font-bold text-xs px-5 py-2 rounded-xl shadow transition cursor-pointer">
                Simpan Status
            </button>
        </form>
    </div>

    {{-- DATA CALON SISWA --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <div class="pb-3 border-b border-slate-100 flex items-center space-x-2">
            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">1</span>
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Biodata Calon Siswa</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block mb-0.5">Nama Lengkap</span>
                <span class="font-bold text-slate-900 text-sm">{{ $ppdb->full_name }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Tempat &amp; Tanggal Lahir</span>
                <span class="font-semibold text-slate-800">{{ $ppdb->birth_place }}, {{ $ppdb->birth_date->translatedFormat('d F Y') }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Jenis Kelamin</span>
                <span class="font-semibold text-slate-800">{{ $ppdb->gender }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Asal Sekolah (SMP/MTs)</span>
                <span class="font-semibold text-slate-800">{{ $ppdb->previous_school }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">NISN</span>
                <span class="font-mono font-semibold text-slate-800">{{ $ppdb->nisn ?: '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Tinggal Bersama</span>
                <span class="font-semibold text-slate-800">{{ $ppdb->living_with }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Anak ke / Dari Saudara</span>
                <span class="font-semibold text-slate-800">Anak ke-{{ $ppdb->child_order }} dari {{ $ppdb->siblings_count }} bersaudara</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Nomor HP / WhatsApp</span>
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $ppdb->phone)) }}" target="_blank" class="text-[#00913e] font-bold hover:underline">
                    <i class="fa-brands fa-whatsapp mr-1"></i>{{ $ppdb->phone }}
                </a>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-400 block mb-0.5">Alamat Tempat Tinggal</span>
                <span class="text-slate-800">{{ $ppdb->address }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Hobi</span>
                <span class="text-slate-800">{{ $ppdb->hobby }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Bidang Studi Paling Disukai</span>
                <span class="text-slate-800">{{ $ppdb->favorite_subject ?: '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Cita-cita</span>
                <span class="text-slate-800">{{ $ppdb->ambition }}</span>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Prestasi yang Pernah Diraih</span>
                <span class="text-slate-800">{{ $ppdb->achievements ?: 'Tidak ada' }}</span>
            </div>
        </div>
    </div>

    {{-- DATA ORANG TUA / WALI --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        
        {{-- Ayah / Wali --}}
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-3">
            <div class="pb-2 border-b border-slate-100 flex items-center space-x-2">
                <i class="fa-solid fa-user-tie text-blue-600 text-sm"></i>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Data Ayah / Wali</h3>
            </div>
            <div class="space-y-2 text-xs">
                <div>
                    <span class="text-slate-400 block">Nama Ayah</span>
                    <span class="font-bold text-slate-900">{{ $ppdb->father_name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Tempat & Tanggal Lahir</span>
                    <span class="text-slate-700">{{ $ppdb->father_birth_place }}, {{ $ppdb->father_birth_date ? $ppdb->father_birth_date->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pendidikan Terakhir</span>
                    <span class="text-slate-700">{{ $ppdb->father_education }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pekerjaan</span>
                    <span class="text-slate-700">{{ $ppdb->father_job }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Penghasilan</span>
                    <span class="text-slate-700">{{ $ppdb->father_income }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Nomor Telepon / WA</span>
                    <span class="text-slate-700">{{ $ppdb->father_phone ?: '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Alamat</span>
                    <span class="text-slate-700">{{ $ppdb->father_address }}</span>
                </div>
            </div>
        </div>

        {{-- Ibu / Wali --}}
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-3">
            <div class="pb-2 border-b border-slate-100 flex items-center space-x-2">
                <i class="fa-solid fa-person-dress text-pink-600 text-sm"></i>
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-wider">Data Ibu / Wali</h3>
            </div>
            <div class="space-y-2 text-xs">
                <div>
                    <span class="text-slate-400 block">Nama Ibu</span>
                    <span class="font-bold text-slate-900">{{ $ppdb->mother_name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Tempat & Tanggal Lahir</span>
                    <span class="text-slate-700">{{ $ppdb->mother_birth_place }}, {{ $ppdb->mother_birth_date ? $ppdb->mother_birth_date->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pendidikan Terakhir</span>
                    <span class="text-slate-700">{{ $ppdb->mother_education }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Pekerjaan</span>
                    <span class="text-slate-700">{{ $ppdb->mother_job }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Penghasilan</span>
                    <span class="text-slate-700">{{ $ppdb->mother_income }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Nomor Telepon / WA</span>
                    <span class="text-slate-700">{{ $ppdb->mother_phone ?: '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Alamat</span>
                    <span class="text-slate-700">{{ $ppdb->mother_address }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- BERKAS LAMPIRAN --}}
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <div class="pb-3 border-b border-slate-100 flex items-center space-x-2">
            <i class="fa-solid fa-folder-open text-amber-500 text-base"></i>
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Berkas Pendaftaran Terunggah</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- 1. Akta Kelahiran --}}
            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Scan Akta Kelahiran</span>
                    @if($ppdb->birth_certificate_path)
                        <a href="{{ $ppdb->birth_certificate_path }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka File
                        </a>
                    @endif
                </div>
                @if($ppdb->birth_certificate_path)
                    @if(str_ends_with(strtolower($ppdb->birth_certificate_path), '.pdf'))
                        <div class="p-6 bg-white rounded-xl text-center border border-slate-200">
                            <i class="fa-solid fa-file-pdf text-red-500 text-4xl mb-2"></i>
                            <span class="text-xs block font-bold text-slate-700">Dokumen PDF</span>
                            <a href="{{ $ppdb->birth_certificate_path }}" target="_blank" class="inline-block mt-2 text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg font-bold">
                                Unduh / Lihat PDF
                            </a>
                        </div>
                    @else
                        <div class="rounded-xl overflow-hidden border border-slate-200 bg-white max-h-64 flex items-center justify-center">
                            <img src="{{ $ppdb->birth_certificate_path }}" alt="Akta Kelahiran" class="max-h-64 object-contain">
                        </div>
                    @endif
                @else
                    <span class="text-xs text-red-500 italic">Berkas belum diunggah.</span>
                @endif
            </div>

            {{-- 2. Bukti Pembayaran --}}
            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Bukti Pembayaran Pendaftaran</span>
                    @if($ppdb->payment_proof_path)
                        <a href="{{ $ppdb->payment_proof_path }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka File
                        </a>
                    @endif
                </div>
                @if($ppdb->payment_proof_path)
                    @if(str_ends_with(strtolower($ppdb->payment_proof_path), '.pdf'))
                        <div class="p-6 bg-white rounded-xl text-center border border-slate-200">
                            <i class="fa-solid fa-file-pdf text-red-500 text-4xl mb-2"></i>
                            <span class="text-xs block font-bold text-slate-700">Dokumen PDF</span>
                            <a href="{{ $ppdb->payment_proof_path }}" target="_blank" class="inline-block mt-2 text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg font-bold">
                                Unduh / Lihat PDF
                            </a>
                        </div>
                    @else
                        <div class="rounded-xl overflow-hidden border border-slate-200 bg-white max-h-64 flex items-center justify-center">
                            <img src="{{ $ppdb->payment_proof_path }}" alt="Bukti Pembayaran" class="max-h-64 object-contain">
                        </div>
                    @endif
                @else
                    <span class="text-xs text-red-500 italic">Berkas belum diunggah.</span>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
