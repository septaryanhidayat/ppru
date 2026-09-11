<?php

namespace Database\Seeders;

use App\Models\QuickMenu;
use Illuminate\Database\Seeder;

class QuickMenuSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'name' => 'Sambutan',
                'icon' => '/uploads/2025/09/ICON-Sambupatan.webp',
                'url' => '/sambutan-ketua-dpd',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Profil',
                'icon' => '/uploads/2025/09/ICON-About.webp',
                'url' => '/tentang-kami',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Fraksi',
                'icon' => '/uploads/2025/09/ICON-Dewan.webp',
                'url' => '/anggota-dewan',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Bidang',
                'icon' => '/uploads/2025/09/ICON-Bidang.webp',
                'url' => '/bidang',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Berita',
                'icon' => '/uploads/2025/09/ICON-Berita.webp',
                'url' => '/artikel',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Pengumuman',
                'icon' => '/uploads/2025/09/ICON-Pengumuman.webp',
                'url' => '/pengumuman',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Video',
                'icon' => '/uploads/2025/09/ICON-Video.webp',
                'url' => '/video',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Agenda',
                'icon' => '/uploads/2025/09/ICON-Agenda.webp',
                'url' => '/agenda',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($defaults as $menu) {
            QuickMenu::updateOrCreate(
                ['name' => $menu['name']],
                $menu
            );
        }
    }
}
