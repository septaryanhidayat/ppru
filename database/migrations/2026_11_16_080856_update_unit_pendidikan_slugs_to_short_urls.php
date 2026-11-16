<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $mapping = [
            'taman-kanak-kanak-islam-raudhatul-ulum' => 'takiru',
            'madrasah-ibtidaiyah-raudhatul-ulum' => 'miru',
            'madrasah-tsanawiyah-raudhatul-ulum' => 'matsaru',
            'madrasah-aliyah-raudhatul-ulum' => 'maru',
            'smp-islam-terpadu-raudhatul-ulum' => 'smpitru',
            'sma-islam-terpadu-raudhatul-ulum' => 'smaitru',
            'institut-agama-islam-nur-raudhatul-ulum' => 'iainru',
            'madrasah-tahfizhul-quran-raudhatul-ulum' => 'matqularu',
        ];

        $shortNameMapping = [
            'TAKIRU' => 'takiru',
            'MIRU' => 'miru',
            'MATSARU' => 'matsaru',
            'MARU' => 'maru',
            'SMPIT RU' => 'smpitru',
            'SMPIT' => 'smpitru',
            'SMAIT RU' => 'smaitru',
            'SMAIT' => 'smaitru',
            'IAI NRU' => 'iainru',
            'IAINRU' => 'iainru',
            'MATQULARU' => 'matqularu',
        ];

        if (Schema::hasTable('unit_pendidikans')) {
            foreach ($mapping as $oldSlug => $newSlug) {
                DB::table('unit_pendidikans')->where('slug', $oldSlug)->update(['slug' => $newSlug]);
            }
            foreach ($shortNameMapping as $shortName => $newSlug) {
                DB::table('unit_pendidikans')->where('short_name', $shortName)->update(['slug' => $newSlug]);
            }
        }

        if (Schema::hasTable('nav_menus')) {
            foreach ($mapping as $oldSlug => $newSlug) {
                DB::table('nav_menus')
                    ->where('url', '/pendidikan/'.$oldSlug)
                    ->orWhere('url', 'like', '%/pendidikan/'.$oldSlug.'%')
                    ->update(['url' => '/'.$newSlug]);
            }
            foreach ($shortNameMapping as $shortName => $newSlug) {
                DB::table('nav_menus')
                    ->where('url', '/pendidikan/'.$newSlug)
                    ->update(['url' => '/'.$newSlug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $mapping = [
            'takiru' => 'taman-kanak-kanak-islam-raudhatul-ulum',
            'miru' => 'madrasah-ibtidaiyah-raudhatul-ulum',
            'matsaru' => 'madrasah-tsanawiyah-raudhatul-ulum',
            'maru' => 'madrasah-aliyah-raudhatul-ulum',
            'smpitru' => 'smp-islam-terpadu-raudhatul-ulum',
            'smaitru' => 'sma-islam-terpadu-raudhatul-ulum',
            'iainru' => 'institut-agama-islam-nur-raudhatul-ulum',
            'matqularu' => 'madrasah-tahfizhul-quran-raudhatul-ulum',
        ];

        if (Schema::hasTable('unit_pendidikans')) {
            foreach ($mapping as $newSlug => $oldSlug) {
                DB::table('unit_pendidikans')->where('slug', $newSlug)->update(['slug' => $oldSlug]);
            }
        }

        if (Schema::hasTable('nav_menus')) {
            foreach ($mapping as $newSlug => $oldSlug) {
                DB::table('nav_menus')->where('url', '/'.$newSlug)->update(['url' => '/pendidikan/'.$oldSlug]);
            }
        }
    }
};
