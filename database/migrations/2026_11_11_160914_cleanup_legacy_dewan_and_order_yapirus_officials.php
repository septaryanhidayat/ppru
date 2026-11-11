<?php

use App\Models\AnggotaDewan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Delete legacy unassigned mock/demo dewan entries that conflict with the official structure
        $legacyNames = [
            'Drs. KH. Karim Kasim',
            'H. Faisal Abdullah, S.T.',
            'Ustadz H. Faisal Abdullah, S.T.',
            'Ustadz H. Ahmad Dailami, S.Pd.I.',
            'H. M. Husin, M.Si.',
            'Ir. H. Ahmad Fauzi',
            'Ustadz Agi Gustiawan, S.Pd.',
            'Ustadz Muhammad Syakir, M.Pd.',
            'Ustadzah Hj. Fatimah Azzahra, Lc., M.Ag.',
            'Ustadz M. Rasyid Ridho, S.Th.I.',
        ];

        AnggotaDewan::whereIn('name', $legacyNames)
            ->whereNull('unit_pendidikan_id')
            ->delete();

        // 2. Ensure all 17 official leaders and officers of YAPIRUS & Pesantren are ordered sequentially #1 to #17
        $officials = [
            [
                'order' => 1,
                'name' => "KH. Tol'at Wafa Ahmad, Lc.",
                'position' => 'Ketua Dewan Pembina YAPIRUS & Mudir Pondok Pesantren Raudhatul Ulum',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'photo' => '/uploads/official/kh-tolat-wafa-ahmad.webp',
                'profile_summary' => 'Pimpinan & Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga sekaligus Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS). Alumni Universitas Al-Azhar Kairo Mesir.',
            ],
            [
                'order' => 2,
                'name' => 'KH. Abdul Karim Umar',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 3,
                'name' => 'Drs. KH. Nadjib Subkie',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 4,
                'name' => 'Drs. KH. Mohd. Iqbal Romzie',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 5,
                'name' => 'H. M. Akram Afifi, Lc., M.Pd.',
                'position' => 'Naib Mudir PPRU & Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Naib Mudir Pondok Pesantren Raudhatul Ulum Sakatiga dan Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS).',
            ],
            [
                'order' => 6,
                'name' => 'Faiz Nabil, M.Pd.',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 7,
                'name' => 'Dr. H. Husnul Amin, Lc., M.H.I., M.M.',
                'position' => 'Ketua Dewan Harian YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Ketua Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 8,
                'name' => 'Salamuddin, S.Si.',
                'position' => 'Sekretaris Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Sekretaris Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 9,
                'name' => 'H. Muhammad Rido, S.Ag.',
                'position' => 'Wakil Sekretaris Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Wakil Sekretaris Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 10,
                'name' => 'Hj. Risa Fauziah Aristina',
                'position' => 'Bendahara Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Bendahara Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 11,
                'name' => 'Maila Rasyidah, Lc',
                'position' => 'Naibah Mudir PPRU & Wakil Bendahara Yayasan',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Naibah Mudir Pondok Pesantren Raudhatul Ulum Sakatiga dan Wakil Bendahara Pengurus Harian YAPIRUS.',
            ],
            [
                'order' => 12,
                'name' => 'Drs. KH. Ahmad Nahrowi, MM',
                'position' => 'Ketua Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Ketua Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 13,
                'name' => 'H. Husnul Anam, S.H.I',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 14,
                'name' => 'Lazuwardi, S.Kom',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 15,
                'name' => 'H. Ahmad Almanfaluty, Lc., M.Pd',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 16,
                'name' => 'Azzam Mujahid Izzulhaq',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'order' => 17,
                'name' => 'Mohd. Hafiy Nawwaf, S.H., M.H',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/avatar-neutral-gray.svg',
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
        ];

        foreach ($officials as $item) {
            $existing = AnggotaDewan::where('name', $item['name'])->first();
            if ($existing) {
                $hasCustomUpload = ! empty($existing->photo) && str_starts_with($existing->photo, '/uploads/dewan/');
                $existing->update([
                    'order' => $item['order'],
                    'position' => $item['position'],
                    'fraction' => $item['fraction'],
                    'unit_pendidikan_id' => null,
                    'profile_summary' => $item['profile_summary'],
                    'photo' => $hasCustomUpload ? $existing->photo : ($item['photo'] ?? '/uploads/avatar-neutral-gray.svg'),
                ]);
            } else {
                AnggotaDewan::create([
                    'order' => $item['order'],
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'position' => $item['position'],
                    'fraction' => $item['fraction'],
                    'unit_pendidikan_id' => null,
                    'profile_summary' => $item['profile_summary'],
                    'photo' => $item['photo'] ?? '/uploads/avatar-neutral-gray.svg',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No destruct needed
    }
};
