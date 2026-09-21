@extends('layouts.admin')

@section('title', 'Kelola Testimonial Masyarakat')
@section('header_title', 'Testimonial & Suara Masyarakat')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-lg font-black text-slate-800">Daftar Testimonial & Kesan Masyarakat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola komentar, apresiasi, foto profil, dan status publikasi di website.</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" class="inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition self-start sm:self-auto">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Testimonial Baru</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($testimonials as $t)
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $t->status === 'publish' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $t->status === 'publish' ? 'Tayang' : 'Draft' }}
                                </span>
                                @if($t->unit)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        {{ $t->unit->short_name ?: $t->unit->name }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] text-slate-400">ID: #{{ $t->id }}</span>
                        </div>

                        <p class="text-xs text-slate-600 italic line-clamp-3 leading-relaxed">
                            "{{ $t->content }}"
                        </p>

                        <div class="flex items-center space-x-3 pt-3 border-t border-slate-200/60">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-[#da251c] font-bold flex items-center justify-center flex-shrink-0 overflow-hidden text-xs shadow-xs">
                                @if($t->photo)
                                    <img src="{{ $t->photo_url }}" alt="{{ $t->name }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='/uploads/2023/08/user-2.webp'">
                                @else
                                    {{ substr($t->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-extrabold text-xs text-slate-900 truncate">{{ $t->name }}</h3>
                                <span class="text-[10px] text-slate-400 block truncate">{{ $t->profession ?: 'Masyarakat' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end space-x-2 text-xs">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="p-2 text-slate-600 hover:text-[#da251c] hover:bg-red-100 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimonial dari {{ $t->name }}?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-xs text-slate-400">
                    <i class="fa-regular fa-comment-dots text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada data testimonial. Klik tombol di atas untuk menambahkan.
                </div>
            @endforelse
        </div>

        @if($testimonials->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
