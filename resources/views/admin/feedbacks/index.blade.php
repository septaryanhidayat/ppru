@extends('layouts.admin')

@section('title', 'Kotak Aspirasi & Masukan')
@section('header_title', 'Kotak Aspirasi / Kritik & Saran Masyarakat')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase font-bold border-b border-gray-100 text-[11px]">
                    <tr>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Nama Pengirim</th>
                        <th class="py-3.5 px-4">Kontak</th>
                        <th class="py-3.5 px-4">Isi Pesan / Saran / Kritik</th>
                        <th class="py-3.5 px-4">Waktu</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($feedbacks as $fb)
                        <tr class="hover:bg-gray-50 transition {{ $fb->status === 'unread' ? 'bg-orange-50/40 font-semibold' : '' }}">
                            <td class="py-3 px-4">
                                @if($fb->status === 'unread')
                                    <span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full">BARU</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">DIBACA</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-bold text-gray-900">
                                {{ $fb->name }}
                            </td>
                            <td class="py-3 px-4 text-[11px] space-y-0.5">
                                @if($fb->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $fb->whatsapp) }}" target="_blank" class="text-green-600 hover:underline block flex items-center">
                                        <i class="fa-brands fa-whatsapp mr-1"></i> {{ $fb->whatsapp }}
                                    </a>
                                @endif
                                @if($fb->email)
                                    <span class="text-gray-500 block truncate max-w-[150px]">{{ $fb->email }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-700 max-w-md">
                                <p class="line-clamp-2">{{ $fb->message }}</p>
                            </td>
                            <td class="py-3 px-4 text-gray-400 whitespace-nowrap">
                                {{ $fb->created_at->translatedFormat('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    @if($fb->status === 'unread')
                                        <form action="{{ route('admin.feedbacks.read', $fb->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white text-[11px] font-semibold transition" title="Tandai Sudah Dibaca">
                                                <i class="fa-solid fa-check mr-1"></i> Dibaca
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.feedbacks.destroy', $fb->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">Tidak ada pesan di kotak masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $feedbacks->links() }}
        </div>
    </div>
</div>
@endsection
