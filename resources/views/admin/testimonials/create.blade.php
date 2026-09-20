@extends('layouts.admin')

@section('title', 'Tambah Testimonial Baru')
@section('header_title', 'Tambah Testimonial Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 flex items-center space-x-2">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar Testimonial</span>
        </a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Pemberi Testimoni *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Ahmad Fauzi, S.Pd" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="profession" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Profesi / Status</label>
                    <input type="text" name="profession" id="profession" value="{{ old('profession') }}" placeholder="Contoh: Wali Santri Ogan Ilir" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                </div>

                <div>
                    <label for="unit_pendidikan_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Unit Pendidikan</label>
                    @if(auth()->user()?->isUnitAdmin())
                        <input type="hidden" name="unit_pendidikan_id" value="{{ auth()->user()->unit_pendidikan_id }}">
                        <div class="w-full bg-emerald-50 text-xs text-[#00843d] font-bold rounded-xl px-4 py-3 border border-emerald-200">
                            {{ auth()->user()->unit?->name ?? 'Unit Saya' }}
                        </div>
                    @else
                        <select name="unit_pendidikan_id" id="unit_pendidikan_id" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d]">
                            <option value="">-- Umum / Seluruh Pesantren --</option>
                            @foreach($units as $u)
                                <option value="{{ $u->id }}" {{ old('unit_pendidikan_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div>
                <label for="content" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Testimoni / Pernyataan *</label>
                <textarea name="content" id="content" rows="4" required placeholder="Tuliskan testimoni atau kesan dari wali santri / alumni..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl p-4 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#00843d] leading-relaxed">{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Upload Foto (JPG / PNG / WebP)</label>
                    <input type="file" name="photo_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-[#da251c] hover:file:bg-red-100 bg-slate-50 rounded-xl border border-slate-200">
                </div>

                <div>
                    <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atau Path / URL Foto</label>
                    <input type="text" name="photo" id="photo" value="{{ old('photo') }}" placeholder="/uploads/... atau https://..." class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                </div>
            </div>

            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Publikasi</label>
                <select name="status" id="status" class="w-full bg-slate-50 text-xs text-slate-800 rounded-xl px-4 py-3 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#da251c]">
                    <option value="publish" {{ old('status') === 'publish' ? 'selected' : '' }}>Langsung Tayang (Publish)</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Simpan Sebagai Draft</option>
                </select>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.testimonials.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition">Batal</a>
                <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Testimonial</span>
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
