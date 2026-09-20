<?php

use App\Models\NavMenu;
use App\Models\UnitPendidikan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Reset all unit pendidikan head_photo to neutral gray avatar if null or random activity photo
        if (Schema::hasTable('unit_pendidikans')) {
            UnitPendidikan::query()->each(function ($unit) {
                if (empty($unit->head_photo)
                    || str_contains($unit->head_photo, '/uploads/official/')
                    || str_contains($unit->head_photo, 'kbm-santri')
                    || str_contains($unit->head_photo, 'kegiatan-santri')
                    || str_contains($unit->head_photo, 'panahan-santri')
                    || str_contains($unit->head_photo, 'drone-')
                    || str_contains($unit->head_photo, 'ngaji-sore')) {
                    $unit->update(['head_photo' => '/uploads/avatar-neutral-gray.svg']);
                }
            });
        }

        // 2. Clean up nav_menus table if it exists: ensure only 5 core root menus exist
        if (Schema::hasTable('nav_menus')) {
            // Remove standalone Khutbah, IKARUS, Kontak, and PPDB from top-level header
            NavMenu::where('location', 'header')
                ->whereNull('parent_id')
                ->where(function ($q) {
                    $q->whereIn('url', ['/khutbah', '/ikarus', '/kontak', '/hubungi', '/ppdb'])
                        ->orWhere('name', 'like', '%Khutbah%')
                        ->orWhere('name', 'like', '%IKARUS%')
                        ->orWhere('name', 'like', '%Kontak%')
                        ->orWhere('name', 'like', '%PPDB%')
                        ->orWhere('name', 'like', '%PSB%');
                })
                ->delete();

            // Ensure parent items are numbered cleanly 1 to 5
            $beranda = NavMenu::where('location', 'header')->whereNull('parent_id')->where('url', '/')->first();
            if ($beranda) {
                $beranda->update(['order' => 1]);
            }

            $profil = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Profil')->first();
            if ($profil) {
                $profil->update(['order' => 2]);
                // Ensure IKARUS is child of Profil
                if (! NavMenu::where('parent_id', $profil->id)->where('url', '/ikarus')->exists()) {
                    NavMenu::create([
                        'parent_id' => $profil->id,
                        'name' => 'Ikatan Alumni (IKARUS)',
                        'url' => '/ikarus',
                        'icon' => 'fa-solid fa-user-graduate',
                        'location' => 'header',
                        'order' => 9,
                        'is_active' => true,
                    ]);
                }
            }

            $pendidikan = NavMenu::where('location', 'header')->whereNull('parent_id')->where(function ($q) {
                $q->where('url', '/pendidikan')->orWhere('name', 'like', '%Pendidikan%');
            })->first();
            if ($pendidikan) {
                $pendidikan->update(['order' => 3, 'name' => 'Pendidikan']);
            }

            $info = NavMenu::where('location', 'header')->whereNull('parent_id')->where(function ($q) {
                $q->where('name', 'like', '%Informasi%')->orWhere('name', 'like', '%Berita%');
            })->first();
            if ($info) {
                $info->update(['order' => 4, 'name' => 'Informasi']);
                // Ensure Khutbah is child of Informasi
                if (! NavMenu::where('parent_id', $info->id)->where('url', '/khutbah')->exists()) {
                    NavMenu::create([
                        'parent_id' => $info->id,
                        'name' => 'Khutbah Jum\'at & Tausiyah',
                        'url' => '/khutbah',
                        'icon' => 'fa-solid fa-microphone-lines',
                        'location' => 'header',
                        'order' => 7,
                        'is_active' => true,
                    ]);
                }
            }

            $layanan = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'like', '%Layanan%')->first();
            if ($layanan) {
                $layanan->update(['order' => 5, 'name' => 'Layanan']);
                // Ensure Kontak is child of Layanan
                if (! NavMenu::where('parent_id', $layanan->id)->whereIn('url', ['/hubungi', '/kontak'])->exists()) {
                    NavMenu::create([
                        'parent_id' => $layanan->id,
                        'name' => 'Kontak & Lokasi Humas',
                        'url' => '/hubungi',
                        'icon' => 'fa-solid fa-address-book',
                        'location' => 'header',
                        'order' => 7,
                        'is_active' => true,
                    ]);
                }
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
