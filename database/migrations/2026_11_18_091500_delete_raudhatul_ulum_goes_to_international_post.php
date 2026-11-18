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
        $targetSlugs = [
            'raudhatul-ulum-goes-to-international-1789785862',
        ];

        $postIds = DB::table('posts')
            ->whereIn('slug', $targetSlugs)
            ->orWhere('title', 'like', '%Raudhatul Ulum Goes To International%')
            ->pluck('id');

        if ($postIds->isNotEmpty()) {
            if (Schema::hasTable('post_category')) {
                DB::table('post_category')->whereIn('post_id', $postIds)->delete();
            }

            if (Schema::hasTable('post_tag')) {
                DB::table('post_tag')->whereIn('post_id', $postIds)->delete();
            }

            if (Schema::hasTable('visitor_logs')) {
                DB::table('visitor_logs')
                    ->where(function ($q) {
                        $q->where('url', 'like', '%raudhatul-ulum-goes-to-international%')
                            ->orWhere('path', 'like', '%raudhatul-ulum-goes-to-international%');
                    })
                    ->delete();
            }

            DB::table('posts')->whereIn('id', $postIds)->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Deletion migration, no rollback needed.
    }
};
