@extends('layouts.frontend')

@section('title', 'Formulir Pendaftaran PPDB 2026/2027 - SMA IT Ishlahul Ummah Prabumulih')
@section('meta_description', 'Formulir Pendaftaran Peserta Didik Baru (PPDB Online) SMA Islam Terpadu Ishlahul Ummah Prabumulih Tahun Pelajaran 2026/2027.')

@section('content')
<div class="bg-gray-50 py-10 sm:py-14 font-['Poppins',sans-serif]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">

        {{-- FORM CONTAINER CARD --}}
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/80 p-6 sm:p-10 space-y-8">
            
            {{-- HEADER LOGO & JUDUL --}}
            <div class="text-center space-y-4">
                <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto p-1 rounded-2xl flex items-center justify-center">
                    <img src="/uploads/logo-ishum-square.png" alt="Logo SMA IT Ishlahul Ummah" class="h-full w-auto object-contain">
                </div>

                <div class="space-y-1">
                    <h1 class="text-lg sm:text-xl md:text-2xl font-black text-[#00913e] tracking-tight leading-snug">
                        Formulir Pendaftaran Peserta Didik Baru<br>
                        SMA Islam Terpadu Ishlahul Ummah Prabumulih<br>
                        <span class="text-slate-800 text-sm sm:text-base font-bold">Tahun Pelajaran 2026/2027</span>
                    </h1>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Isi formulir dengan data yang sah dan lengkap. Tanda bintang (<span class="text-red-500 font-bold">*</span>) wajib diisi.
                    </p>
                </div>
            </div>

            {{-- ERROR SUMMARY IF ANY --}}
            @if($errors->any())
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                    <p class="font-bold flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-1.5 text-red-500"></i>
                        Mohon periksa kembali isian formulir:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- REGISTRATION FORM --}}
            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs text-slate-700">
                @csrf

                {{-- SECTION A: DATA CALON SISWA --}}
                <div class="space-y-4 pt-2">
                    <div class="pb-2 border-b border-emerald-100 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">1</span>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Data Calon Siswa</h2>
                    </div>

                    {{-- 1. Nama Lengkap --}}
                    <div>
                        <label for="full_name" class="block font-bold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" id="full_name" required value="{{ old('full_name') }}" placeholder="Masukkan nama lengkap sesuai akta kelahiran..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('full_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 2. Tempat Lahir, Tanggal Lahir, Jenis Kelamin --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label for="birth_place" class="block font-bold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="birth_place" id="birth_place" required value="{{ old('birth_place') }}" placeholder="Kota kelahiran..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('birth_place') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="birth_date" class="block font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="birth_date" id="birth_date" required value="{{ old('birth_date') }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('birth_date') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="gender" class="block font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- 3. Alamat Rumah --}}
                    <div>
                        <label for="address" class="block font-bold text-slate-700 mb-1">Alamat Rumah <span class="text-red-500">*</span></label>
                        <textarea name="address" id="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..." class="w-full bg-white text-xs rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('address') }}</textarea>
                        @error('address') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 4. Tinggal Bersama --}}
                    <div>
                        <label for="living_with" class="block font-bold text-slate-700 mb-1">Tinggal Bersama <span class="text-red-500">*</span></label>
                        <select name="living_with" id="living_with" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            <option value="Orang Tua" {{ old('living_with') === 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="Wali" {{ old('living_with') === 'Wali' ? 'selected' : '' }}>Wali</option>
                            <option value="Asrama / Boarding" {{ old('living_with') === 'Asrama / Boarding' ? 'selected' : '' }}>Asrama / Boarding</option>
                            <option value="Kost" {{ old('living_with') === 'Kost' ? 'selected' : '' }}>Kost</option>
                            <option value="Lainnya" {{ old('living_with') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('living_with') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 5. Anak ke & Dari Jumlah Saudara --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="child_order" class="block font-bold text-slate-700 mb-1">Anak ke - <span class="text-red-500">*</span></label>
                            <input type="number" name="child_order" id="child_order" min="1" max="30" required value="{{ old('child_order', 1) }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('child_order') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="siblings_count" class="block font-bold text-slate-700 mb-1">Dari Jumlah Saudara <span class="text-red-500">*</span></label>
                            <input type="number" name="siblings_count" id="siblings_count" min="0" max="30" required value="{{ old('siblings_count', 1) }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('siblings_count') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- 6. Asal Sekolah --}}
                    <div>
                        <label for="previous_school" class="block font-bold text-slate-700 mb-1">Asal Sekolah <span class="text-red-500">*</span></label>
                        <input type="text" name="previous_school" id="previous_school" required value="{{ old('previous_school') }}" placeholder="SMP / MTs asal..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('previous_school') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 7. NISN --}}
                    <div>
                        <label for="nisn" class="block font-bold text-slate-700 mb-1">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" placeholder="Nomor Induk Siswa Nasional (10 digit jika ada)..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('nisn') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 8. Hobi & Bidang Studi Paling Disukai --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="hobby" class="block font-bold text-slate-700 mb-1">Hobi <span class="text-red-500">*</span></label>
                            <input type="text" name="hobby" id="hobby" required value="{{ old('hobby') }}" placeholder="Membaca, Futsal, Memanah, dsb..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('hobby') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="favorite_subject" class="block font-bold text-slate-700 mb-1">Bidang Studi Paling Disukai</label>
                            <input type="text" name="favorite_subject" id="favorite_subject" value="{{ old('favorite_subject') }}" placeholder="Matematika, Biologi, PAI, B. Arab, dsb..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('favorite_subject') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- 9. Cita-cita --}}
                    <div>
                        <label for="ambition" class="block font-bold text-slate-700 mb-1">Cita-cita <span class="text-red-500">*</span></label>
                        <input type="text" name="ambition" id="ambition" required value="{{ old('ambition') }}" placeholder="Dokter, Ulama, Dosen, Pengusaha, Insinyur, dsb..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('ambition') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 10. Prestasi yang Pernah Diraih --}}
                    <div>
                        <label for="achievements" class="block font-bold text-slate-700 mb-1">Prestasi yang Pernah Diraih</label>
                        <textarea name="achievements" id="achievements" rows="2" placeholder="Sebutkan prestasi akademik, tahfidz, atau kejuaraan yang pernah diraih (jika ada)..." class="w-full bg-white text-xs rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('achievements') }}</textarea>
                    </div>

                    {{-- 11. Nomor HP / WA Siswa --}}
                    <div>
                        <label for="phone" class="block font-bold text-slate-700 mb-1">Nomor HP / WA Calon Siswa <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" id="phone" required value="{{ old('phone') }}" placeholder="Contoh: 081234567890" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('phone') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- SECTION B: DATA AYAH / WALI --}}
                <div class="space-y-4 pt-6">
                    <div class="pb-2 border-b border-emerald-100 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">2</span>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Data Ayah / Wali</h2>
                    </div>

                    <div>
                        <label for="father_name" class="block font-bold text-slate-700 mb-1">Nama Ayah / Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="father_name" id="father_name" required value="{{ old('father_name') }}" placeholder="Nama lengkap ayah/wali..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('father_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="father_birth_place" class="block font-bold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="father_birth_place" id="father_birth_place" required value="{{ old('father_birth_place') }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('father_birth_place') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="father_birth_date" class="block font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="father_birth_date" id="father_birth_date" required value="{{ old('father_birth_date') }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('father_birth_date') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="father_address" class="block font-bold text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="father_address" id="father_address" rows="2" required placeholder="Alamat domisili ayah/wali..." class="w-full bg-white text-xs rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('father_address') }}</textarea>
                        @error('father_address') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label for="father_education" class="block font-bold text-slate-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                            <select name="father_education" id="father_education" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Tidak Sekolah" {{ old('father_education') === 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD / Sederajat" {{ old('father_education') === 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP / Sederajat" {{ old('father_education') === 'SMP / Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA / SMK / MA" {{ old('father_education') === 'SMA / SMK / MA' ? 'selected' : '' }}>SMA / SMK / MA</option>
                                <option value="Diploma (D1/D2/D3)" {{ old('father_education') === 'Diploma (D1/D2/D3)' ? 'selected' : '' }}>Diploma (D1/D2/D3)</option>
                                <option value="Sarjana (S1)" {{ old('father_education', 'Sarjana (S1)') === 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                                <option value="Magister (S2)" {{ old('father_education') === 'Magister (S2)' ? 'selected' : '' }}>Magister (S2)</option>
                                <option value="Doktor (S3)" {{ old('father_education') === 'Doktor (S3)' ? 'selected' : '' }}>Doktor (S3)</option>
                            </select>
                        </div>
                        <div>
                            <label for="father_job" class="block font-bold text-slate-700 mb-1">Pekerjaan Ayah / Wali <span class="text-red-500">*</span></label>
                            <select name="father_job" id="father_job" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="PNS / Polisi / TNI" {{ old('father_job') === 'PNS / Polisi / TNI' ? 'selected' : '' }}>PNS / Polisi / TNI</option>
                                <option value="Wiraswasta / Pengusaha" {{ old('father_job') === 'Wiraswasta / Pengusaha' ? 'selected' : '' }}>Wiraswasta / Pengusaha</option>
                                <option value="Karyawan Swasta / BUMN" {{ old('father_job') === 'Karyawan Swasta / BUMN' ? 'selected' : '' }}>Karyawan Swasta / BUMN</option>
                                <option value="Guru / Dosen" {{ old('father_job') === 'Guru / Dosen' ? 'selected' : '' }}>Guru / Dosen</option>
                                <option value="Petani / Pekebun" {{ old('father_job') === 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                <option value="Buruh / Tenaga Harian" {{ old('father_job') === 'Buruh / Tenaga Harian' ? 'selected' : '' }}>Buruh / Tenaga Harian</option>
                                <option value="Pensiunan" {{ old('father_job') === 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                <option value="Lainnya" {{ old('father_job') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="father_income" class="block font-bold text-slate-700 mb-1">Penghasilan <span class="text-red-500">*</span></label>
                            <select name="father_income" id="father_income" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Tidak Berpenghasilan" {{ old('father_income') === 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                                <option value="< Rp 1.000.000" {{ old('father_income') === '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ old('father_income') === 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 – Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('father_income', 'Rp 3.000.000 - Rp 5.000.000') === 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 – Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ old('father_income') === 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 – Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ old('father_income') === '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="father_phone" class="block font-bold text-slate-700 mb-1">Nomor HP / WA Ayah</label>
                        <input type="tel" name="father_phone" id="father_phone" value="{{ old('father_phone') }}" placeholder="Contoh: 081234567890" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>

                {{-- SECTION C: DATA IBU / WALI --}}
                <div class="space-y-4 pt-6">
                    <div class="pb-2 border-b border-emerald-100 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">3</span>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Data Ibu / Wali</h2>
                    </div>

                    <div>
                        <label for="mother_name" class="block font-bold text-slate-700 mb-1">Nama Ibu / Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="mother_name" id="mother_name" required value="{{ old('mother_name') }}" placeholder="Nama lengkap ibu/wali..." class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                        @error('mother_name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="mother_birth_place" class="block font-bold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="mother_birth_place" id="mother_birth_place" required value="{{ old('mother_birth_place') }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('mother_birth_place') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="mother_birth_date" class="block font-bold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="mother_birth_date" id="mother_birth_date" required value="{{ old('mother_birth_date') }}" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                            @error('mother_birth_date') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mother_address" class="block font-bold text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="mother_address" id="mother_address" rows="2" required placeholder="Alamat domisili ibu/wali..." class="w-full bg-white text-xs rounded-xl p-3 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">{{ old('mother_address') }}</textarea>
                        @error('mother_address') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label for="mother_education" class="block font-bold text-slate-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                            <select name="mother_education" id="mother_education" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Tidak Sekolah" {{ old('mother_education') === 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                <option value="SD / Sederajat" {{ old('mother_education') === 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                <option value="SMP / Sederajat" {{ old('mother_education') === 'SMP / Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                <option value="SMA / SMK / MA" {{ old('mother_education') === 'SMA / SMK / MA' ? 'selected' : '' }}>SMA / SMK / MA</option>
                                <option value="Diploma (D1/D2/D3)" {{ old('mother_education') === 'Diploma (D1/D2/D3)' ? 'selected' : '' }}>Diploma (D1/D2/D3)</option>
                                <option value="Sarjana (S1)" {{ old('mother_education', 'Sarjana (S1)') === 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                                <option value="Magister (S2)" {{ old('mother_education') === 'Magister (S2)' ? 'selected' : '' }}>Magister (S2)</option>
                                <option value="Doktor (S3)" {{ old('mother_education') === 'Doktor (S3)' ? 'selected' : '' }}>Doktor (S3)</option>
                            </select>
                        </div>
                        <div>
                            <label for="mother_job" class="block font-bold text-slate-700 mb-1">Pekerjaan Ibu / Wali <span class="text-red-500">*</span></label>
                            <select name="mother_job" id="mother_job" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Ibu Rumah Tangga" {{ old('mother_job', 'Ibu Rumah Tangga') === 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                <option value="PNS / Polisi / TNI" {{ old('mother_job') === 'PNS / Polisi / TNI' ? 'selected' : '' }}>PNS / Polisi / TNI</option>
                                <option value="Wiraswasta / Pengusaha" {{ old('mother_job') === 'Wiraswasta / Pengusaha' ? 'selected' : '' }}>Wiraswasta / Pengusaha</option>
                                <option value="Karyawan Swasta / BUMN" {{ old('mother_job') === 'Karyawan Swasta / BUMN' ? 'selected' : '' }}>Karyawan Swasta / BUMN</option>
                                <option value="Guru / Dosen" {{ old('mother_job') === 'Guru / Dosen' ? 'selected' : '' }}>Guru / Dosen</option>
                                <option value="Petani / Pekebun" {{ old('mother_job') === 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                <option value="Lainnya" {{ old('mother_job') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="mother_income" class="block font-bold text-slate-700 mb-1">Penghasilan <span class="text-red-500">*</span></label>
                            <select name="mother_income" id="mother_income" required class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                                <option value="Tidak Berpenghasilan" {{ old('mother_income', 'Tidak Berpenghasilan') === 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                                <option value="< Rp 1.000.000" {{ old('mother_income') === '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ old('mother_income') === 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 – Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('mother_income') === 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 – Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ old('mother_income') === 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 – Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ old('mother_income') === '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="mother_phone" class="block font-bold text-slate-700 mb-1">Nomor HP / WA Ibu</label>
                        <input type="tel" name="mother_phone" id="mother_phone" value="{{ old('mother_phone') }}" placeholder="Contoh: 081234567890" class="w-full bg-white text-xs rounded-xl px-4 py-2.5 border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#00913e]">
                    </div>
                </div>

                {{-- SECTION D: UPLOAD BERKAS --}}
                <div class="space-y-4 pt-6">
                    <div class="pb-2 border-b border-emerald-100 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-[#00913e] font-bold text-xs flex items-center justify-center">4</span>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Upload Berkas Pendaftaran</h2>
                    </div>

                    {{-- 1. Scan Akta Kelahiran --}}
                    <div>
                        <label for="birth_certificate" class="block font-bold text-slate-700 mb-1">
                            Scan Akta Kelahiran <span class="text-red-500">*</span>
                        </label>
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <input type="file" name="birth_certificate" id="birth_certificate" required accept=".pdf,image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">
                            <p class="text-[10px] text-slate-400 mt-1">Format: PDF, JPG, PNG, WebP (Maksimal 5 MB)</p>
                        </div>
                        @error('birth_certificate') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 2. Scan / Foto Bukti Pembayaran Pendaftaran --}}
                    <div>
                        <label for="payment_proof" class="block font-bold text-slate-700 mb-1">
                            Scan / Foto Bukti Pembayaran Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <input type="file" name="payment_proof" id="payment_proof" required accept=".pdf,image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">
                            <p class="text-[10px] text-slate-400 mt-1">Transfer ke Bank BSI: <strong>7011304251</strong> a.n. <strong>YL. Fatmawati</strong> (Format: PDF, JPG, PNG, WebP)</p>
                        </div>
                        @error('payment_proof') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- SUBMIT BUTTON: RED BUTTON "KIRIM" --}}
                <div class="pt-6 text-center">
                    <button type="submit" class="bg-[#da251c] hover:bg-[#b91c1c] text-white font-black text-sm px-10 py-3.5 rounded-xl shadow-lg shadow-red-500/30 transition transform hover:-translate-y-0.5 cursor-pointer uppercase tracking-wider">
                        Kirim
                    </button>
                    <p class="text-[11px] text-slate-400 mt-2">
                        Pastikan seluruh data yang diisi telah benar sebelum menekan tombol kirim.
                    </p>
                </div>
            </form>

            {{-- DOODLE ART FOOTER --}}
            <div class="pt-8 text-center border-t border-slate-100">
                <div class="flex items-center justify-between text-[11px] text-slate-400">
                    <span>PPDB SMA IT Ishlahul Ummah Prabumulih</span>
                    <span>All rights reserved</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
