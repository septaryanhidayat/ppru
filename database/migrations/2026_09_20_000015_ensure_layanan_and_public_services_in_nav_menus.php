<?php

use App\Models\NavMenu;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('nav_menus')) {
            return;
        }

        // 1. Ensure root Layanan menu exists
        $layanan = NavMenu::where('location', 'header')
            ->whereNull('parent_id')
            ->where(function ($q) {
                $q->where('name', 'like', '%Layanan%')->orWhere('url', 'like', '%layanan%');
            })->first();

        if (! $layanan) {
            $layanan = NavMenu::create([
                'name' => 'Layanan',
                'url' => '/layanan-terpadu',
                'icon' => 'fa-solid fa-handshake-angle',
                'location' => 'header',
                'order' => 5,
                'is_active' => true,
            ]);
        } else {
            $layanan->update([
                'order' => 5,
                'name' => 'Layanan',
                'url' => '/layanan-terpadu',
                'is_active' => true,
            ]);
        }

        // 2. Remove obsolete or erroneous child links under Layanan
        NavMenu::where('parent_id', $layanan->id)
            ->whereIn('url', ['/layanan/izin', '/layanan/kerjasama', '/layanan/sewa'])
            ->delete();

        // 3. Ensure 3 Layanan Publik & other service links exist under Layanan
        $layananItems = [
            [
                'name' => 'Permohonan Izin Kunjungan Sekolah',
                'url' => '/izin-sekolah',
                'icon' => 'fa-solid fa-school',
                'order' => 1,
            ],
            [
                'name' => 'Permohonan Kerja Sama',
                'url' => '/permohonan-kerja-sama',
                'icon' => 'fa-solid fa-handshake',
                'order' => 2,
            ],
            [
                'name' => 'Permohonan Sewa Fasilitas & Sarana',
                'url' => '/sewa-barang',
                'icon' => 'fa-solid fa-building-user',
                'order' => 3,
            ],
            [
                'name' => 'Portal Layanan Terpadu',
                'url' => '/layanan-terpadu',
                'icon' => 'fa-solid fa-circle-nodes',
                'order' => 4,
            ],
            [
                'name' => 'Brosur & Rincian Biaya',
                'url' => '/download',
                'icon' => 'fa-solid fa-file-pdf',
                'order' => 5,
            ],
            [
                'name' => 'Download Logo Resmi',
                'url' => '/logo',
                'icon' => 'fa-solid fa-image',
                'order' => 6,
            ],
            [
                'name' => 'Kontak & Lokasi Humas',
                'url' => '/hubungi',
                'icon' => 'fa-solid fa-address-book',
                'order' => 7,
            ],
        ];

        foreach ($layananItems as $item) {
            $child = NavMenu::where('parent_id', $layanan->id)
                ->where(function ($q) use ($item) {
                    $q->where('url', $item['url'])
                        ->orWhere('name', $item['name'])
                        ->orWhere('url', 'like', '%'.trim($item['url'], '/').'%');
                })->first();

            if (! $child) {
                NavMenu::create([
                    'parent_id' => $layanan->id,
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'icon' => $item['icon'],
                    'location' => 'header',
                    'order' => $item['order'],
                    'is_active' => true,
                ]);
            } else {
                $child->update([
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'icon' => $item['icon'],
                    'order' => $item['order'],
                    'is_active' => true,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non-destructive rollback
    }
};
