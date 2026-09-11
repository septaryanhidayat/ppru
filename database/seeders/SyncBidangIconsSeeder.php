<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;

class SyncBidangIconsSeeder extends Seeder
{
    public function run(): void
    {
        $iconMap = [
            1 => '/uploads/2023/08/Icon-KD2.webp',
            2 => '/uploads/2023/08/Icon-Muda.webp',
            3 => '/uploads/2023/08/Icon-BPU.webp',
            4 => '/uploads/2023/08/Icon-BPD.webp',
            5 => '/uploads/2023/08/Icon-BPKK.webp',
            6 => '/uploads/2025/09/ICON-Dewan.webp',
            7 => '/uploads/2023/08/Icon-Pekerja.webp',
            8 => '/uploads/2023/08/Icon-Muda.webp',
            9 => '/uploads/2023/08/Icon-Pekerja.webp',
            10 => '/uploads/2023/08/Icon-Humas.webp',
        ];

        foreach ($iconMap as $id => $icon) {
            $b = Bidang::find($id);
            if ($b) {
                $b->update([
                    'icon' => $icon,
                    'order' => $id,
                ]);
            }
        }
    }
}
