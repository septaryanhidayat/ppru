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
        // 1. Update UnitPendidikan order: Taman Kanak-Kanak (TAKIRU) is order 1
        if (Schema::hasTable('unit_pendidikans')) {
            $unitOrders = [
                'taman-kanak-kanak-islam-raudhatul-ulum' => 1,
                'madrasah-aliyah-raudhatul-ulum' => 2,
                'madrasah-tsanawiyah-raudhatul-ulum' => 3,
                'madrasah-ibtidaiyah-raudhatul-ulum' => 4,
                'madrasah-tahfizhul-quran-raudhatul-ulum' => 5,
                'smp-islam-terpadu-raudhatul-ulum' => 6,
                'sma-islam-terpadu-raudhatul-ulum' => 7,
                'institut-agama-islam-nur-raudhatul-ulum' => 8,
            ];

            foreach ($unitOrders as $slug => $order) {
                UnitPendidikan::where('slug', $slug)->update(['order' => $order]);
            }

            // Fallback by ID if slug did not match
            UnitPendidikan::where('id', 5)->update(['order' => 1]);
            UnitPendidikan::where('id', 1)->update(['order' => 2]);
            UnitPendidikan::where('id', 2)->update(['order' => 3]);
            UnitPendidikan::where('id', 3)->update(['order' => 4]);
            UnitPendidikan::where('id', 4)->update(['order' => 5]);
            UnitPendidikan::where('id', 6)->update(['order' => 6]);
            UnitPendidikan::where('id', 7)->update(['order' => 7]);
            UnitPendidikan::where('id', 8)->update(['order' => 8]);
        }

        // 2. Update NavMenu items under Pendidikan (parent_id = 11 or parent with url /pendidikan)
        if (Schema::hasTable('nav_menus')) {
            $pendidikanParent = NavMenu::where('url', '/pendidikan')
                ->orWhere('name', 'like', '%Pendidikan%')
                ->whereNull('parent_id')
                ->first();

            $parentId = $pendidikanParent ? $pendidikanParent->id : 11;

            $menuOrders = [
                'taman-kanak' => 1,
                'madrasah-aliyah' => 2,
                'madrasah-tsanawiyah' => 3,
                'madrasah-ibtidaiyah' => 4,
                'tahfizhul-quran' => 5,
                'smp-islam-terpadu' => 6,
                'sma-islam-terpadu' => 7,
                'institut-agama-islam' => 8,
            ];

            foreach ($menuOrders as $key => $order) {
                NavMenu::where('parent_id', $parentId)
                    ->where('url', 'like', "%{$key}%")
                    ->update(['order' => $order]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('unit_pendidikans')) {
            UnitPendidikan::where('id', 1)->update(['order' => 1]);
            UnitPendidikan::where('id', 2)->update(['order' => 2]);
            UnitPendidikan::where('id', 3)->update(['order' => 3]);
            UnitPendidikan::where('id', 4)->update(['order' => 4]);
            UnitPendidikan::where('id', 5)->update(['order' => 5]);
            UnitPendidikan::where('id', 6)->update(['order' => 6]);
            UnitPendidikan::where('id', 7)->update(['order' => 7]);
            UnitPendidikan::where('id', 8)->update(['order' => 8]);
        }
    }
};
