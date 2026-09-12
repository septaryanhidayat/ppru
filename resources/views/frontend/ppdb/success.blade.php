@extends('layouts.frontend')

@section('title', 'Pendaftaran Berhasil - PPDB SMA IT Ishlahul Ummah Prabumulih')

@section('content')
<div class="bg-gray-50 py-12 sm:py-16">
    <div class="max-w-xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-8 sm:p-10 text-center space-y-6">
            
            {{-- SUCCESS ICON --}}
            <div class="w-20 h-20 mx-auto rounded-full bg-emerald-100 text-[#00913e] flex items-center justify-center text-4xl shadow-md animate-bounce">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            {{-- TITLE & REG NUMBER --}}
            <div class="space-y-2">
                <span class="text-[11px] font-bold uppercase tracking-widest text-[#00913e] bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Pendaftaran Berhasil Terkirim
                </span>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Alhamdulillah, Formulir Telah Diterima!
                </h1>
                <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                    Terima kasih telah mendaftar di SMA IT Ishlahul Ummah Prabumulih Tahun Pelajaran 2026/2027.
                </p>
            </div>

            {{-- REGISTRATION CARD --}}
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 text-left space-y-2 text-xs">
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500 font-medium">Nomor Pendaftaran</span>
                    <span class="font-black text-[#da251c] font-mono text-sm">{{ $registration->registration_number }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500 font-medium">Nama Calon Siswa</span>
                    <span class="font-bold text-slate-800">{{ $registration->full_name }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500 font-medium">Asal Sekolah</span>
                    <span class="font-bold text-slate-800">{{ $registration->previous_school }}</span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500 font-medium">Tanggal Daftar</span>
                    <span class="text-slate-700">{{ $registration->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
                <div class="flex justify-between pt-1">
                    <span class="text-slate-500 font-medium">Status Berkas</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $registration->status_badge }}">
                        {{ $registration->status_label }}
                    </span>
                </div>
            </div>

            {{-- ACTION BUTTONS: AUTO FORWARD TO WHATSAPP --}}
            <div class="space-y-4 pt-2">
                <div class="p-3 bg-emerald-50 border border-emerald-300 rounded-2xl text-emerald-900 text-xs font-semibold flex items-center justify-center space-x-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Mengalihkan otomatis ke WhatsApp Admin dalam <strong id="countdown-sec" class="text-emerald-700 font-black text-sm">2</strong> detik...</span>
                </div>

                <a href="{{ $waUrl }}" id="wa-btn" class="w-full inline-flex items-center justify-center space-x-3 bg-[#25D366] hover:bg-[#1EBE5D] text-white font-black text-sm sm:text-base py-4 px-6 rounded-2xl shadow-xl shadow-green-500/25 transition transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                    <span>FORWARD SEMUA DATA KE WHATSAPP ADMIN</span>
                </a>

                <div class="flex items-center justify-center space-x-3 pt-1">
                    <a href="{{ route('home') }}" class="text-xs text-slate-600 hover:text-slate-900 font-semibold px-4 py-2 rounded-lg hover:bg-slate-100 transition">
                        <i class="fa-solid fa-house mr-1"></i> Kembali ke Beranda
                    </a>
                    <button onclick="window.print()" class="text-xs text-[#00913e] hover:text-[#007532] font-semibold px-4 py-2 rounded-lg hover:bg-emerald-50 transition cursor-pointer">
                        <i class="fa-solid fa-print mr-1"></i> Cetak Bukti
                    </button>
                </div>
            </div>

            {{-- NOTE --}}
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-[11px] leading-relaxed text-left">
                <p><strong>Penting:</strong> Pastikan Anda telah menekan tombol kirim pesan di WhatsApp agar seluruh formulir diterima oleh panitia. Data Anda juga telah tersimpan aman di database sekolah.</p>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let count = 2;
        const countEl = document.getElementById('countdown-sec');
        const interval = setInterval(() => {
            count--;
            if (countEl) countEl.textContent = count;
            if (count <= 0) {
                clearInterval(interval);
                window.location.href = @json($waUrl);
            }
        }, 1000);
    });
</script>
@endsection
