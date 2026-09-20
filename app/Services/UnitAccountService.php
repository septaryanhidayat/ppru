<?php

namespace App\Services;

use App\Models\Post;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class UnitAccountService
{
    /**
     * Configuration for all 8 educational units under YAPIRUS PPRU.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getUnitsConfig(): array
    {
        return [
            [
                'short_name' => 'MARU',
                'slug' => 'madrasah-aliyah-raudhatul-ulum',
                'name' => 'Madrasah Aliyah Raudhatul Ulum',
                'category_type' => 'Madrasah',
                'head_name' => 'Ustadz H. M. Said, S.Ag.',
                'email' => 'admin.maru@ppru.ac.id',
                'order' => 1,
            ],
            [
                'short_name' => 'MATSARU',
                'slug' => 'madrasah-tsanawiyah-raudhatul-ulum',
                'name' => 'Madrasah Tsanawiyah Raudhatul Ulum',
                'category_type' => 'Madrasah',
                'head_name' => 'Ustadz Drs. H. Syamsuddin',
                'email' => 'admin.matsaru@ppru.ac.id',
                'order' => 2,
            ],
            [
                'short_name' => 'MIRU',
                'slug' => 'madrasah-ibtidaiyah-raudhatul-ulum',
                'name' => 'Madrasah Ibtidaiyah Raudhatul Ulum',
                'category_type' => 'Madrasah',
                'head_name' => 'Ustadzah Hj. Maryam, S.Pd.I.',
                'email' => 'admin.miru@ppru.ac.id',
                'order' => 3,
            ],
            [
                'short_name' => 'MATQULARU',
                'slug' => 'madrasah-tahfizhul-quran-raudhatul-ulum',
                'name' => 'Madrasah Tahfizhul Quran Lil Aulad',
                'category_type' => 'Madrasah',
                'head_name' => 'Ustadz H. Abdul Halim, Al-Hafizh',
                'email' => 'admin.matqularu@ppru.ac.id',
                'order' => 4,
            ],
            [
                'short_name' => 'TAKIRU',
                'slug' => 'taman-kanak-kanak-islam-raudhatul-ulum',
                'name' => 'Taman Kanak-Kanak Islam Raudhatul Ulum',
                'category_type' => 'TK Islam',
                'head_name' => 'Ustadzah Fatimah, S.Pd.',
                'email' => 'admin.takiru@ppru.ac.id',
                'order' => 5,
            ],
            [
                'short_name' => 'SMPIT RU',
                'slug' => 'smp-islam-terpadu-raudhatul-ulum',
                'name' => 'SMP Islam Terpadu Raudhatul Ulum',
                'category_type' => 'Sekolah IT',
                'head_name' => 'Ustadz Ridwan, S.Pd.I.',
                'email' => 'admin.smpit@ppru.ac.id',
                'order' => 6,
            ],
            [
                'short_name' => 'SMAIT RU',
                'slug' => 'sma-islam-terpadu-raudhatul-ulum',
                'name' => 'SMA Islam Terpadu Raudhatul Ulum',
                'category_type' => 'Sekolah IT',
                'head_name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'email' => 'admin.smait@ppru.ac.id',
                'order' => 7,
            ],
            [
                'short_name' => 'IAI NRU',
                'slug' => 'institut-agama-islam-nur-raudhatul-ulum',
                'name' => 'Institut Agama Islam Nur Raudhatul Ulum',
                'category_type' => 'Perguruan Tinggi',
                'head_name' => 'Dr. H. M. Husin, M.A.',
                'email' => 'admin.iainru@ppru.ac.id',
                'order' => 8,
            ],
        ];
    }

    /**
     * Ensure all 8 units and their corresponding scoped admin accounts exist in database.
     */
    public static function ensureUnitAccountsExist(): void
    {
        try {
            if (! Schema::hasTable('unit_pendidikans') || ! Schema::hasTable('users')) {
                return;
            }

            // Auto-heal missing columns if migrations were interrupted or skipped on server
            if (! Schema::hasColumn('users', 'unit_pendidikan_id')) {
                try {
                    Schema::table('users', function (Blueprint $table) {
                        $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('role');
                        $table->index('unit_pendidikan_id');
                    });
                } catch (\Throwable $e) {
                    Log::warning('Auto-add unit_pendidikan_id to users: '.$e->getMessage());
                }
            }

            if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'unit_pendidikan_id')) {
                try {
                    Schema::table('posts', function (Blueprint $table) {
                        $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('author_id');
                        $table->index('unit_pendidikan_id');
                    });
                } catch (\Throwable $e) {
                    Log::warning('Auto-add unit_pendidikan_id to posts: '.$e->getMessage());
                }
            }

            if (Schema::hasTable('videos') && ! Schema::hasColumn('videos', 'unit_pendidikan_id')) {
                try {
                    Schema::table('videos', function (Blueprint $table) {
                        $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                        $table->index('unit_pendidikan_id');
                    });
                } catch (\Throwable $e) {
                    Log::warning('Auto-add unit_pendidikan_id to videos: '.$e->getMessage());
                }
            }

            $hasUnitCol = Schema::hasColumn('users', 'unit_pendidikan_id');
            $defaultPassword = Hash::make('AdminUnitPPRU2026!');

            foreach (self::getUnitsConfig() as $cfg) {
                $unit = UnitPendidikan::where('short_name', $cfg['short_name'])
                    ->orWhere('slug', $cfg['slug'])
                    ->first();

                if (! $unit) {
                    $unit = UnitPendidikan::create([
                        'name' => $cfg['name'],
                        'short_name' => $cfg['short_name'],
                        'slug' => $cfg['slug'],
                        'category_type' => $cfg['category_type'],
                        'head_name' => $cfg['head_name'],
                        'order' => $cfg['order'],
                        'is_active' => true,
                    ]);
                } else {
                    $unit->update([
                        'order' => $cfg['order'],
                        'category_type' => $cfg['category_type'],
                        'head_name' => $unit->head_name ?: $cfg['head_name'],
                    ]);
                }

                $userData = [
                    'name' => 'Admin '.$cfg['short_name'],
                    'password' => $defaultPassword,
                    'role' => 'admin_unit',
                ];

                if ($hasUnitCol) {
                    $userData['unit_pendidikan_id'] = $unit->id;
                }

                User::updateOrCreate(
                    ['email' => $cfg['email']],
                    $userData
                );
            }

            // Ensure all units have complete demo content populated
            UnitDemoContentService::seedAllUnitsDemo(false);
        } catch (\Throwable $e) {
            Log::error('UnitAccountService::ensureUnitAccountsExist error: '.$e->getMessage());
        }
    }

    /**
     * Get summary data of all 8 units and their admin accounts for dashboard display.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getUnitAdminsSummary(): array
    {
        try {
            self::ensureUnitAccountsExist();

            if (! Schema::hasTable('unit_pendidikans')) {
                return [];
            }

            $units = UnitPendidikan::orderBy('order', 'asc')->get();
            $summary = [];

            $hasUnitCol = Schema::hasTable('users') && Schema::hasColumn('users', 'unit_pendidikan_id');
            $hasPostUnitCol = Schema::hasTable('posts') && Schema::hasColumn('posts', 'unit_pendidikan_id');
            $hasVideoUnitCol = Schema::hasTable('videos') && Schema::hasColumn('videos', 'unit_pendidikan_id');

            foreach ($units as $unit) {
                $user = null;
                if ($hasUnitCol) {
                    $user = User::where('unit_pendidikan_id', $unit->id)
                        ->where('role', 'admin_unit')
                        ->first();
                }

                if (! $user && Schema::hasTable('users')) {
                    $user = User::where('email', 'admin.'.strtolower(str_replace(' ', '', (string) $unit->short_name)).'@ppru.ac.id')->first();
                }

                $postsCount = 0;
                $photosCount = 0;
                $videosCount = 0;

                if ($hasPostUnitCol) {
                    $postsCount = Post::where('unit_pendidikan_id', $unit->id)->where('type', 'post')->count();
                    $photosCount = Post::where('unit_pendidikan_id', $unit->id)->where('type', 'gallery')->count();
                }

                if ($hasVideoUnitCol) {
                    $videosCount = Video::where('unit_pendidikan_id', $unit->id)->count();
                }

                $summary[] = [
                    'unit' => $unit,
                    'user' => $user,
                    'short_name' => $unit->short_name ?: $unit->name,
                    'name' => $unit->name,
                    'slug' => $unit->slug,
                    'category_type' => $unit->category_type,
                    'head_name' => $unit->head_name,
                    'email' => $user?->email ?: ('admin.'.strtolower(str_replace(' ', '', (string) $unit->short_name)).'@ppru.ac.id'),
                    'password_default' => 'AdminUnitPPRU2026!',
                    'posts_count' => $postsCount,
                    'photos_count' => $photosCount,
                    'videos_count' => $videosCount,
                    'is_active' => $unit->is_active,
                ];
            }

            return $summary;
        } catch (\Throwable $e) {
            Log::error('UnitAccountService::getUnitAdminsSummary error: '.$e->getMessage());

            return [];
        }
    }
}
