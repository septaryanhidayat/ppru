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
        if (Schema::hasTable('unit_pendidikans')) {
            $unitOrders = [
                'taman-kanak-kanak-islam-raudhatul-ulum' => 1,
                'madrasah-ibtidaiyah-raudhatul-ulum' => 2,
                'madrasah-tsanawiyah-raudhatul-ulum' => 3,
                'madrasah-tahfizhul-quran-raudhatul-ulum' => 4,
                'madrasah-aliyah-raudhatul-ulum' => 5,
                'smp-islam-terpadu-raudhatul-ulum' => 6,
                'sma-islam-terpadu-raudhatul-ulum' => 7,
                'institut-agama-islam-nur-raudhatul-ulum' => 8,
            ];

            foreach ($unitOrders as $slug => $order) {
                UnitPendidikan::where('slug', $slug)->update(['order' => $order]);
            }

            // Fallback by keyword or short_name
            UnitPendidikan::where(function ($q) {
                $q->where('slug', 'like', '%taman-kanak%')
                    ->orWhere('short_name', 'TAKIRU')
                    ->orWhere('name', 'like', '%Taman Kanak%');
            })->update(['order' => 1]);
        }

        if (Schema::hasTable('nav_menus')) {
            $pendidikanParent = NavMenu::where('url', '/pendidikan')
                ->orWhere('name', 'like', '%Pendidikan%')
                ->whereNull('parent_id')
                ->first();

            $parentId = $pendidikanParent ? $pendidikanParent->id : 11;

            $menuOrders = [
                'taman-kanak' => 1,
                'madrasah-ibtidaiyah' => 2,
                'madrasah-tsanawiyah' => 3,
                'tahfizhul-quran' => 4,
                'madrasah-aliyah' => 5,
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
        // No-op
    }
};
