<?php

use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add unit_pendidikan_id to users
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'unit_pendidikan_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('unit_pendidikan_id')
                    ->nullable()
                    ->after('role')
                    ->constrained('unit_pendidikans')
                    ->nullOnDelete();
            });
        }

        // 2. Add unit_pendidikan_id to posts
        if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'unit_pendidikan_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->foreignId('unit_pendidikan_id')
                    ->nullable()
                    ->after('author_id')
                    ->constrained('unit_pendidikans')
                    ->nullOnDelete();
            });
        }

        // 3. Add unit_pendidikan_id to videos
        if (Schema::hasTable('videos') && ! Schema::hasColumn('videos', 'unit_pendidikan_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->foreignId('unit_pendidikan_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('unit_pendidikans')
                    ->nullOnDelete();
            });
        }

        // 4. Seed isolated accounts for each of the 8 units under YAPIRUS PPRU
        $unitsConfig = [
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
                'name' => 'Madrasah Tahfizhul Qur\'an Lil Aulad',
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

        $defaultPassword = Hash::make('AdminUnitPPRU2026!');

        foreach ($unitsConfig as $cfg) {
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
            }

            User::updateOrCreate(
                ['email' => $cfg['email']],
                [
                    'name' => 'Admin '.$cfg['short_name'],
                    'password' => $defaultPassword,
                    'role' => 'admin_unit',
                    'unit_pendidikan_id' => $unit->id,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('videos') && Schema::hasColumn('videos', 'unit_pendidikan_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropForeign(['unit_pendidikan_id']);
                $table->dropColumn('unit_pendidikan_id');
            });
        }

        if (Schema::hasTable('posts') && Schema::hasColumn('posts', 'unit_pendidikan_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['unit_pendidikan_id']);
                $table->dropColumn('unit_pendidikan_id');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'unit_pendidikan_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['unit_pendidikan_id']);
                $table->dropColumn('unit_pendidikan_id');
            });
        }

        User::where('role', 'admin_unit')->delete();
    }
};
