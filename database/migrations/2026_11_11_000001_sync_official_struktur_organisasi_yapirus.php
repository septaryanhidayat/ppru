<?php

use App\Models\AnggotaDewan;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Set default bagan image URL to the official diagram
        $currentChart = Setting::get('struktur_chart_image_url');
        if (empty($currentChart)) {
            Setting::set('struktur_chart_image_url', '/uploads/official/bagan-struktur-organisasi-resmi.png', 'struktur');
        }

        // 2. Clean existing records in dewan_asatidz to strip any raw HTML tags from profile_summary
        $existing = AnggotaDewan::all();
        foreach ($existing as $d) {
            if (! empty($d->profile_summary)) {
                $cleaned = trim(strip_tags(html_entity_decode($d->profile_summary, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                if ($cleaned !== $d->profile_summary) {
                    $d->profile_summary = $cleaned;
                    $d->save();
                }
            }
        }

        // 3. Seed / Update the 17 official leaders from the official diagram
        $officials = [
            [
                'name' => "KH. Tol'at Wafa Ahmad, Lc.",
                'position' => 'Ketua Dewan Pembina YAPIRUS & Mudir Pondok Pesantren Raudhatul Ulum',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'order' => 1,
                'profile_summary' => 'Pimpinan & Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga sekaligus Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS). Alumni Universitas Al-Azhar Kairo Mesir, pembina ribuan santri dan hafizh Qur\'an di seluruh pelosok nusantara.',
                'photo' => '/uploads/official/kh-tolat-wafa-ahmad.webp',
            ],
            [
                'name' => 'KH. Abdul Karim Umar',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 2,
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Drs. KH. Nadjib Subkie',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 3,
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Drs. KH. Mohd. Iqbal Romzie',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 4,
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'H. M. Akram Afifi, Lc., M.Pd.',
                'position' => 'Naib Mudir PPRU & Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'order' => 5,
                'profile_summary' => 'Naib Mudir Pondok Pesantren Raudhatul Ulum Sakatiga dan Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS).',
            ],
            [
                'name' => 'Faiz Nabil, M.Pd.',
                'position' => 'Anggota Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 6,
                'profile_summary' => 'Anggota Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Dr. H. Husnul Amin, Lc., M.H.I., M.M.',
                'position' => 'Ketua Dewan Harian YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 7,
                'profile_summary' => 'Ketua Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Salamuddin, S.Si.',
                'position' => 'Sekretaris Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 8,
                'profile_summary' => 'Sekretaris Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'H. Muhammad Rido, S.Ag.',
                'position' => 'Wakil Sekretaris Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 9,
                'profile_summary' => 'Wakil Sekretaris Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Hj. Risa Fauziah Aristina',
                'position' => 'Bendahara Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 10,
                'profile_summary' => 'Bendahara Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Maila Rasyidah, Lc',
                'position' => 'Naibah Mudir PPRU & Wakil Bendahara Yayasan',
                'fraction' => 'Yayasan & Pimpinan Pesantren',
                'order' => 11,
                'profile_summary' => 'Naibah Mudir Pondok Pesantren Raudhatul Ulum Sakatiga dan Wakil Bendahara Pengurus Harian YAPIRUS.',
            ],
            [
                'name' => 'Drs. KH. Ahmad Nahrowi, MM',
                'position' => 'Ketua Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 12,
                'profile_summary' => 'Ketua Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'H. Husnul Anam, S.H.I',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 13,
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Lazuwardi, S.Kom',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 14,
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'H. Ahmad Almanfaluty, Lc., M.Pd',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 15,
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Azzam Mujahid Izzulhaq',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 16,
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
            [
                'name' => 'Mohd. Hafiy Nawwaf, S.H., M.H',
                'position' => 'Anggota Dewan Pengawas YAPIRUS',
                'fraction' => 'Yayasan',
                'order' => 17,
                'profile_summary' => 'Anggota Dewan Pengawas Yayasan Perguruan Islam Raudhatul Ulum (YAPIRUS) Sakatiga.',
            ],
        ];

        foreach ($officials as $item) {
            $existingItem = AnggotaDewan::where('name', $item['name'])->first();
            if ($existingItem) {
                $existingItem->update([
                    'position' => $item['position'],
                    'fraction' => $item['fraction'],
                    'order' => $item['order'],
                    'profile_summary' => $item['profile_summary'],
                    'photo' => $item['photo'] ?? $existingItem->photo,
                ]);
            } else {
                AnggotaDewan::create([
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'position' => $item['position'],
                    'fraction' => $item['fraction'],
                    'unit_pendidikan_id' => null,
                    'profile_summary' => $item['profile_summary'],
                    'order' => $item['order'],
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
