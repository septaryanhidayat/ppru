<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\NavMenu;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CmsAutoHealService
{
    /**
     * Ensure schema columns for multi-unit education content exist (fail-safe for cPanel).
     */
    public static function ensureUnitPendidikanSchemaExists(): void
    {
        try {
            if (Schema::hasTable('dewan_asatidz') && ! Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id')) {
                Schema::table('dewan_asatidz', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('testimonials') && ! Schema::hasColumn('testimonials', 'unit_pendidikan_id')) {
                Schema::table('testimonials', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'unit_pendidikan_id')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('author_id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('videos') && ! Schema::hasColumn('videos', 'unit_pendidikan_id')) {
                Schema::table('videos', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'unit_pendidikan_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('role');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('unit_pendidikans')) {
                Schema::table('unit_pendidikans', function (Blueprint $table) {
                    if (! Schema::hasColumn('unit_pendidikans', 'sambutan')) {
                        $table->text('sambutan')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'visi')) {
                        $table->text('visi')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'misi')) {
                        $table->text('misi')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'hero_image')) {
                        $table->string('hero_image')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'head_photo')) {
                        $table->string('head_photo')->nullable();
                    }
                });

                // Auto-heal: reset head_photo to neutral gray avatar if empty or pointing to activity photos
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
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureUnitPendidikanSchemaExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure nav_menus table exists and is populated with default pesantren navigation.
     */
    public static function ensureNavMenusTableExists(): void
    {
        try {
            if (! Schema::hasTable('nav_menus')) {
                Schema::create('nav_menus', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('parent_id')->nullable()->constrained('nav_menus')->nullOnDelete();
                    $table->string('name');
                    $table->string('url');
                    $table->string('icon')->nullable();
                    $table->string('location')->default('header'); // header, footer_quick, footer_info
                    $table->string('target')->default('_self'); // _self, _blank
                    $table->integer('order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }

            // If empty, seed default menu items
            if (NavMenu::count() === 0) {
                self::seedDefaultNavMenus();
            } else {
                // Ensure no orphaned standalone Khutbah, Ikarus, Kontak, or PPDB at top-level header
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

                // Ensure Profil dropdown contains IKARUS if missing
                $profil = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Profil')->first();
                if ($profil && ! NavMenu::where('parent_id', $profil->id)->where('url', '/ikarus')->exists()) {
                    NavMenu::create([
                        'parent_id' => $profil->id,
                        'name' => 'Ikatan Alumni (IKARUS)',
                        'url' => '/ikarus',
                        'icon' => 'fa-solid fa-user-graduate',
                        'location' => 'header',
                        'order' => 9,
                    ]);
                }

                // Ensure Informasi dropdown contains Khutbah if missing
                $info = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Informasi')->first();
                if ($info && ! NavMenu::where('parent_id', $info->id)->where('url', '/khutbah')->exists()) {
                    NavMenu::create([
                        'parent_id' => $info->id,
                        'name' => 'Khutbah Jum\'at & Tausiyah',
                        'url' => '/khutbah',
                        'icon' => 'fa-solid fa-microphone-lines',
                        'location' => 'header',
                        'order' => 6,
                    ]);
                }

                // Ensure Layanan exists at root level (order 5)
                $layanan = NavMenu::where('location', 'header')->whereNull('parent_id')->where(function ($q) {
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
                    $layanan->update(['order' => 5, 'name' => 'Layanan', 'url' => '/layanan-terpadu', 'is_active' => true]);
                }

                // Ensure 3 Layanan Publik & Layanan Terpadu exist as children of Layanan
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

                // Ensure Pendidikan dropdown contains all active unit pendidikans
                $pendidikan = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Pendidikan')->first();
                if ($pendidikan && Schema::hasTable('unit_pendidikans')) {
                    $hasChildren = NavMenu::where('parent_id', $pendidikan->id)->exists();
                    if (! $hasChildren) {
                        $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
                        foreach ($units as $u) {
                            $cleanName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $u->name));
                            NavMenu::create([
                                'parent_id' => $pendidikan->id,
                                'name' => $cleanName,
                                'url' => '/pendidikan/'.$u->slug,
                                'icon' => 'fa-solid fa-graduation-cap',
                                'location' => 'header',
                                'order' => $u->order ?: 1,
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureNavMenusTableExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure hero_slides table exists and has default slides.
     */
    public static function ensureHeroSlidesTableExists(): void
    {
        try {
            if (! Schema::hasTable('hero_slides')) {
                Schema::create('hero_slides', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('subtitle')->nullable();
                    $table->string('badge')->nullable()->default('Pondok Pesantren Raudhatul Ulum Sakatiga');
                    $table->string('image')->default('/uploads/official/drone-raudhatul-ulum.webp');
                    $table->string('btn_primary_text')->nullable()->default('Profil Singkat Pesantren');
                    $table->string('btn_primary_url')->nullable()->default('/tentang-kami');
                    $table->string('btn_secondary_text')->nullable()->default('Pendaftaran PSB');
                    $table->string('btn_secondary_url')->nullable()->default('/ppdb');
                    $table->integer('order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }

            if (HeroSlide::count() === 0) {
                self::seedDefaultHeroSlides();
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureHeroSlidesTableExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure the 8 official leaders of PPRU & YAPIRUS exist with real photos and bios.
     */
    public static function ensureDewanAsatidzSeeded(): void
    {
        try {
            if (! Schema::hasTable('dewan_asatidz')) {
                return;
            }

            // Clean up old placeholders and reset to exactly the 8 prominent figures
            AnggotaDewan::query()->delete();

            $dewanGuruList = [
                [
                    'name' => "KH. Tol'at Wafa Ahmad, Lc.",
                    'slug' => 'kh-tolat-wafa-ahmad-lc',
                    'position' => 'Mudir Pondok Pesantren Raudhatul Ulum',
                    'fraction' => 'Pimpinan Pesantren',
                    'photo' => '/uploads/kh-tolat-wafa-ahmad.webp',
                    'profile_summary' => "Pimpinan & Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga. Alumni Universitas Al-Azhar Kairo Mesir, pembina ribuan santri dan hafizh Qur'an di seluruh pelosok nusantara.",
                    'education' => "S1 Syari'ah Islamiyah - Universitas Al-Azhar Kairo, Mesir",
                    'order' => 1,
                ],
                [
                    'name' => 'Drs. KH. Karim Kasim',
                    'slug' => 'drs-kh-karim-kasim',
                    'position' => 'Ketua Dewan Pembina YAPIRUS',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/official/foto-mudir.webp',
                    'profile_summary' => 'Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS). Dedikasi lebih dari 40 tahun dalam pembinaan akhlak, tarbiyah santri, dan pengembangan institusi pendidikan Islam terpadu.',
                    'education' => 'Sarjana Pendidikan Islam & Tarbiyah',
                    'order' => 2,
                ],
                [
                    'name' => 'Ustadz H. Faisal Abdullah, S.T.',
                    'slug' => 'ustadz-h-faisal-abdullah-st',
                    'position' => 'Direktur Sarana, Prasarana & Keuangan',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/official/kegiatan-santri-waw1985.webp',
                    'profile_summary' => 'Mengawal modernisasi tata kelola sarana prasarana, laboratorium sains, kampus asrama terpadu, dan ekosistem digital Pondok Pesantren Raudhatul Ulum Sakatiga.',
                    'education' => 'S1 Teknik Sipil & Manajemen Infrastruktur',
                    'order' => 3,
                ],
                [
                    'name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                    'slug' => 'ustadz-h-ahmad-dailami-spdi',
                    'position' => 'Kepala Madrasah Aliyah Raudhatul Ulum (MARU)',
                    'fraction' => 'Pendidik',
                    'photo' => '/uploads/official/kbm-santri-0054.webp',
                    'profile_summary' => 'Memimpin jenjang Madrasah Aliyah dengan kurikulum muadalah Al-Azhar Kairo dan Kemenag. Sukses menghantarkan puluhan alumni meraih beasiswa ke Timur Tengah dan PTN ternama.',
                    'education' => "S1 Pendidikan Agama Islam & Ma'had Aly",
                    'order' => 4,
                ],
                [
                    'name' => 'Ustadz Agi Gustiawan, S.Pd.',
                    'slug' => 'ustadz-agi-gustiawan-spd',
                    'position' => 'Kepala SMA Islam Terpadu Raudhatul Ulum',
                    'fraction' => 'Pendidik',
                    'photo' => '/uploads/official/kbm-santri-0098.webp',
                    'profile_summary' => 'Kepala SMAIT Raudhatul Ulum. Berkomitmen memadukan kurikulum sains nasional, pembinaan karakter Islami, dan riset ilmiah remaja berprestasi hingga kancah olimpiade sains.',
                    'education' => 'S1 Pendidikan Sains & Matematika',
                    'order' => 5,
                ],
                [
                    'name' => 'Ustadz Muhammad Syakir, M.Pd.',
                    'slug' => 'ustadz-muhammad-syakir-mpd',
                    'position' => 'Kepala MTs Raudhatul Ulum (MATSARU)',
                    'fraction' => 'Pendidik',
                    'photo' => '/uploads/official/kbm-santri-0152.webp',
                    'profile_summary' => 'Kepala Madrasah Tsanawiyah Raudhatul Ulum. Berpengalaman dalam penguatan bahasa Arab-Inggris harian santri, tahsin bersanad, dan kedisiplinan asrama 24 jam.',
                    'education' => 'S2 Manajemen Pendidikan Islam',
                    'order' => 6,
                ],
                [
                    'name' => 'Ustadzah Hj. Fatimah Azzahra, Lc., M.Ag.',
                    'slug' => 'ustadzah-hj-fatimah-azzahra-lc-mag',
                    'position' => 'Kepala Bagian Tahfidz & Pengasuhan Putri',
                    'fraction' => 'Pendidik',
                    'photo' => '/uploads/official/ngaji-sore.webp',
                    'profile_summary' => "Alumni Universitas Al-Azhar Kairo dan Pengasuh Markaz Tahfidz Putri PPRU. Telah mencetak puluhan santriwati mutqin 30 juz berakhlak Qur'ani dan berjiwa da'iyah.",
                    'education' => 'S1 Ushuluddin Al-Azhar Mesir, S2 Studi Islam',
                    'order' => 7,
                ],
                [
                    'name' => 'Ustadz M. Rasyid Ridho, S.Th.I.',
                    'slug' => 'ustadz-m-rasyid-ridho-sthi',
                    'position' => 'Kepala Pengasuhan & Kedisiplinan Santri Putra',
                    'fraction' => 'Pendidik',
                    'photo' => '/uploads/official/panahan-santri.webp',
                    'profile_summary' => 'Kepala Biro Pengasuhan Santri Putra (BPSP). Mengawal penegakan sunnah pondok, kepanduan, olahraga bela diri, dan penempaan mental kepemimpinan santri.',
                    'education' => "S1 Tafsir Hadits & Ilmu Al-Qur'an",
                    'order' => 8,
                ],
            ];

            foreach ($dewanGuruList as $d) {
                AnggotaDewan::updateOrCreate(
                    ['slug' => $d['slug']],
                    $d
                );
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureDewanAsatidzSeeded error: '.$e->getMessage());
        }
    }

    /**
     * Ensure all official demo contents (Dewan Guru, TVRU Videos, Berita, Artikel, Prestasi, Ekskul, Testimoni, Agenda, Pengumuman) are seeded.
     * Guaranteed fail-safe execution without requiring cPanel terminal migration commands.
     */
    public static function ensureOfficialDemoContentsSeeded(): void
    {
        try {
            self::ensureUnitPendidikanSchemaExists();
            self::ensureDewanAsatidzSeeded();

            // 1. Purge Rickroll & ensure TVRU official videos
            if (Schema::hasTable('videos')) {
                Video::where('youtube_id', 'dQw4w9WgXcQ')->delete();

                $tvruVideos = [
                    [
                        'title' => 'Upacara Kemerdekaan RI di Kampus Pondok Pesantren Raudhatul Ulum Sakatiga',
                        'youtube_id' => 'BG311kT-yXc',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Khidmatnya upacara bendera dan apel santri PPRU Sakatiga.',
                    ],
                    [
                        'title' => 'Sarasehan & Orientasi Wali Santri Baru PPRU Sakatiga Tahun Ajaran 2026/2027',
                        'youtube_id' => 'cFXK5Of-IzQ',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Pengenalan tata tertib kepesantrenan dan pembinaan santri.',
                    ],
                    [
                        'title' => "Sarasehan & Silaturahim Wali Santri Bersama Mudir KH. Tol'at Wafa Ahmad, Lc.",
                        'youtube_id' => 'mRdb_kGhbiQ',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Arahan mendalam seputar sinergi pendidikan pesantren dan wali santri.',
                    ],
                    [
                        'title' => 'Peringatan Hari Besar Islam & Kiprah Santri di Kampus Pesantren Raudhatul Ulum',
                        'youtube_id' => 'p8B8wKu5o4c',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Semarak tabligh akbar, lomba bahasa, dan kreasi santri.',
                    ],
                ];

                foreach ($tvruVideos as $v) {
                    Video::updateOrCreate(
                        ['youtube_id' => $v['youtube_id']],
                        [
                            'title' => $v['title'],
                            'slug' => Str::slug($v['title']),
                            'youtube_url' => 'https://www.youtube.com/watch?v='.$v['youtube_id'],
                            'description' => $v['description'],
                        ]
                    );
                }
            }

            // 2. Auto-heal Unit Principals (eliminate Ustadz Fulan from unit pages)
            if (Schema::hasTable('unit_pendidikans')) {
                $principals = [
                    'madrasah-aliyah-raudhatul-ulum' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                    'madrasah-tsanawiyah-raudhatul-ulum' => 'Ustadz Muhammad Syakir, M.Pd.',
                    'madrasah-ibtidaiyah-raudhatul-ulum' => 'Ustadzah Siti Aminah, S.Pd.I.',
                    'madrasah-tahfizhul-quran-raudhatul-ulum' => 'Ustadzah Hj. Fatimah Azzahra, Lc., M.Ag.',
                    'taman-kanak-kanak-islam-raudhatul-ulum' => 'Ustadzah Maryam, S.Pd.',
                    'smp-islam-terpadu-raudhatul-ulum' => 'Ustadz Abdullah, S.Pd.I., M.Pd.',
                    'sma-islam-terpadu-raudhatul-ulum' => 'Ustadz Agi Gustiawan, S.Pd.',
                    'institut-agama-islam-nur-raudhatul-ulum' => 'Dr. H. Ahmad Fauzi, M.A.',
                ];
                foreach ($principals as $uSlug => $hName) {
                    $unit = UnitPendidikan::where('slug', $uSlug)->first();
                    if ($unit && (empty($unit->head_name) || str_contains($unit->head_name, 'Fulan'))) {
                        $unit->update(['head_name' => $hName]);
                    }
                }
            }

            // Safe author ID for posts
            $authorId = User::first()?->id;

            // 3. Demo Berita (4 Konten)
            if (Schema::hasTable('posts') && Schema::hasTable('categories')) {
                $catBerita = Category::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita Pondok', 'description' => 'Berita Kegiatan Pondok']);
                $beritaList = [
                    [
                        'title' => 'Pekan Perkenalan Santri Baru (P2SB) dan Matrikulasi T.A. 2026/2027 Resmi Dibuka',
                        'image' => '/uploads/official/drone-raudhatul-ulum.webp',
                        'excerpt' => 'Upacara pembukaan P2SB tahun ajaran 2026/2027 berlangsung khidmat di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum Sakatiga.',
                        'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Ribuan santri baru dari berbagai penjuru nusantara resmi mengikuti upacara pembukaan Pekan Perkenalan Santri Baru (P2SB) dan Program Matrikulasi Tahun Ajaran 2026/2027 di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga.</p><p>Upacara dipimpin langsung oleh Mudir PPRU, <strong>KH. Tol\'at Wafa Ahmad, Lc.</strong></p>',
                    ],
                    [
                        'title' => 'Haflah Milad ke-76 dan Wisuda Akbar Santri Kelas Akhir Raudhatul Ulum Berlangsung Khidmat',
                        'image' => '/uploads/official/upacara-santri-4680.webp',
                        'excerpt' => 'PPRU Sakatiga menggelar resepsi kesyukuran Haflah Milad ke-76 sekaligus wisuda akbar ratusan santri kelas akhir MARU, SMAIT, MATSARU, dan SMPIT.',
                        'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Suasana haru dan penuh rasa syukur menyelimuti wisuda akbar santri kelas akhir Pondok Pesantren Raudhatul Ulum Sakatiga yang dirangkaikan dengan peringatan Haflah Milad ke-76 berdirinya pesantren.</p>',
                    ],
                    [
                        'title' => 'Pelepasan Delegasi Alumni MARU Raudhatul Ulum Lolos Beasiswa Universitas Al-Azhar Kairo',
                        'image' => '/uploads/official/kegiatan-santri-waw1981.webp',
                        'excerpt' => 'Sebanyak 18 santri alumni MARU Raudhatul Ulum Sakatiga dilepas secara resmi untuk melanjutkan studi sarjana di Universitas Al-Azhar Kairo Mesir.',
                        'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Prestasi gemilang kembali ditorehkan santri Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga. Sebanyak 18 santri dinyatakan lolos seleksi beasiswa Kementerian Agama dan Muadalah Al-Azhar untuk melanjutkan kuliah di Kairo, Mesir.</p>',
                    ],
                    [
                        'title' => 'Penandatanganan MoU Sinergi Riset Sains dan Teknologi Bersama Perguruan Tinggi Negeri Terkemuka',
                        'image' => '/uploads/official/kbm-santri-0054.webp',
                        'excerpt' => 'PPRU Sakatiga memperluas kemitraan strategis dalam pengembangan laboratorium sains terpadu dan pembinaan olimpiade sains madrasah.',
                        'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Guna memperkuat keunggulan akademik di bidang sains dan teknologi, Pondok Pesantren Raudhatul Ulum Sakatiga menandatangani naskah nota kesepahaman (MoU) kemitraan riset dan pengabdian masyarakat.</p>',
                    ],
                ];

                foreach ($beritaList as $idx => $b) {
                    $slug = Str::slug($b['title']);
                    $post = Post::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'title' => $b['title'],
                            'content' => $b['content'],
                            'excerpt' => $b['excerpt'],
                            'status' => 'publish',
                            'type' => 'post',
                            'is_featured' => $idx === 0,
                            'featured_image' => $b['image'],
                            'author_id' => $authorId,
                            'author_name' => 'Humas & Informasi PPRU',
                            'published_at' => now()->subDays($idx * 2),
                        ]
                    );
                    $post->categories()->sync([$catBerita->id]);
                }

                // 4. Demo Artikel (4 Konten)
                $catArtikel = Category::firstOrCreate(['slug' => 'taujih'], ['name' => 'Tausiyah & Artikel Asatidz', 'description' => 'Artikel Ilmiah dan Tausiyah Keislaman']);
                $artikelList = [
                    [
                        'title' => 'Menumbuhkan Jiwa Kepemimpinan dan Akhlakul Karimah Melalui Tarbiyah Pesantren',
                        'image' => '/uploads/official/ngaji-sore.webp',
                        'excerpt' => 'Pendidikan pesantren bukan sekadar transfer of knowledge, melainkan proses internalisasi nilai-nilai keikhlasan, kesederhanaan, dan kemandirian.',
                        'content' => '<p>Pondok pesantren sejak berabad-abad telah membuktikan perannya sebagai benteng peradaban umat. Di era disrupsi digital yang sarat distraksi, tarbiyah asrama selama 24 jam menjadi sarana paling efektif untuk menanamkan kedisiplinan dan akhlakul karimah.</p>',
                    ],
                    [
                        'title' => 'Pentingnya Menjaga Hafalan Al-Qur\'an (Muraja\'ah) di Tengah Kesibukan Akademik',
                        'image' => '/uploads/official/drone-danau-telok-putih.webp',
                        'excerpt' => 'Menghafal Al-Qur\'an adalah anugerah besar, namun menjaga dan memutqinkan hafalan adalah amanah seumur hidup yang membutuhkan keteguhan istiqamah.',
                        'content' => '<p>Rasulullah ﷺ mengibaratkan hafalan Al-Qur\'an bagaikan unta yang terikat; jika terus dijaga maka ia akan tetap berada di genggaman. Kunci utama keberhasilan para santri penghafal Qur\'an di PPRU Sakatiga adalah jadwal muraja\'ah terstruktur sebelum subuh dan ba\'da maghrib.</p>',
                    ],
                    [
                        'title' => 'Sinergi Kurikulum Dirasah Islamiyah Al-Azhar dan Sains Modern Menuju Indonesia Emas',
                        'image' => '/uploads/official/kbm-santri-0098.webp',
                        'excerpt' => 'Mengintegrasikan sains dan Al-Qur\'an secara harmonis tanpa dikotomi demi melahirkan generasi saintis Muslim yang taat beribadah.',
                        'content' => '<p>Islam tidak pernah memisahkan ilmu agama dan ilmu pengetahuan umum. Di Raudhatul Ulum Sakatiga, para santri diajarkan bahwa mempelajari fisika, matematika, dan biologi adalah sarana bertadabbur atas kebesaran Allah ﷻ di alam semesta.</p>',
                    ],
                    [
                        'title' => 'Adab Penuntut Ilmu Menurut Imam An-Nawawi: Panduan Emas Generasi Pelajar Muslim',
                        'image' => '/uploads/official/kbm-santri-0152.webp',
                        'excerpt' => 'Ilmu tidak akan meresap ke dalam dada yang dipenuhi kesombongan. Kerendahan hati dan kepatuhan kepada guru adalah kunci barakahnya ilmu.',
                        'content' => '<p>Dalam kitab <em>At-Tibyan fi Adabi Hamalatil Qur\'an</em>, Imam An-Nawawi menekankan pentingnya membersihkan niat dalam menuntut ilmu.</p>',
                    ],
                ];

                foreach ($artikelList as $idx => $a) {
                    $slug = Str::slug($a['title']);
                    $post = Post::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'title' => $a['title'],
                            'content' => $a['content'],
                            'excerpt' => $a['excerpt'],
                            'status' => 'publish',
                            'type' => 'post',
                            'is_featured' => false,
                            'featured_image' => $a['image'],
                            'author_id' => $authorId,
                            'author_name' => 'Dewan Asatidz PPRU',
                            'published_at' => now()->subDays($idx * 3 + 1),
                        ]
                    );
                    $post->categories()->sync([$catArtikel->id]);
                }

                // 5. Demo Prestasi (4 Konten)
                $prestasiList = [
                    [
                        'title' => 'Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 30 Juz Tingkat Nasional 2026',
                        'image' => '/uploads/official/kegiatan-santri-waw1985.webp',
                        'excerpt' => 'Santri tahfidz PPRU Sakatiga berhasil meraih podium tertinggi dalam ajang MHQ 30 Juz Tingkat Nasional yang diselenggarakan Kemenag RI.',
                        'content' => '<p>Prestasi membanggakan kembali dipersembahkan santri Pondok Pesantren Raudhatul Ulum Sakatiga. Ananda Ahmad Faizul Wafa berhasil meraih <strong>Juara 1 Nasional</strong> pada cabang Musabaqah Hifdzil Qur\'an (MHQ) 30 Juz Mutqin.</p>',
                    ],
                    [
                        'title' => 'Medali Emas Olimpiade Sains Madrasah (KSM) Tingkat Provinsi Bidang Fisika Terpadu',
                        'image' => '/uploads/official/kbm-santri-0098.webp',
                        'excerpt' => 'Santri SMAIT Raudhatul Ulum menorehkan prestasi membanggakan dengan merebut medali emas dalam KSM Sains Madrasah.',
                        'content' => '<p>Melalui persaingan ketat bersama ratusan peserta madrasah se-Sumatera Selatan, delegasi sains PPRU Sakatiga sukses membawa pulang medali emas bidang Fisika Terpadu Terintegrasi Nilai-Nilai Islam.</p>',
                    ],
                    [
                        'title' => 'Juara Umum Kejuaraan Pencak Silat Tapak Suci Pesantren se-Sumatera 2026',
                        'image' => '/uploads/official/panahan-santri.webp',
                        'excerpt' => 'Kontingen Tapak Suci PPRU Sakatiga memborong 7 medali emas dan 4 medali perak, sekaligus dinobatkan sebagai Juara Umum.',
                        'content' => '<p>Pendekar santri Raudhatul Ulum menunjukkan ketangkasan dan sportivitas tinggi pada Kejuaraan Seni Bela Diri Tapak Suci Antar-Pesantren.</p>',
                    ],
                    [
                        'title' => 'Juara 1 Lomba Debat Bahasa Arab (Munazarah Ilmiyah) Antar Pondok Pesantren Modern',
                        'image' => '/uploads/official/kbm-santri-0054.webp',
                        'excerpt' => 'Tim debat bahasa Arab santri MARU tampil memukau dengan argumen ilmiah dan kefasihan berbahasa Arab fusha tingkat tinggi.',
                        'content' => '<p>Kefasihan berbahasa Arab santri PPRU Sakatiga kembali terbukti di ajang festival bahasa internasional.</p>',
                    ],
                ];

                foreach ($prestasiList as $idx => $pr) {
                    $slug = Str::slug($pr['title']);
                    Post::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'title' => $pr['title'],
                            'content' => $pr['content'],
                            'excerpt' => $pr['excerpt'],
                            'status' => 'publish',
                            'type' => 'prestasi',
                            'featured_image' => $pr['image'],
                            'author_id' => $authorId,
                            'author_name' => 'Biro Prestasi & Bakat Santri',
                            'published_at' => now()->subDays($idx * 4),
                        ]
                    );
                }
            }

            // 6. Demo Testimoni (4 Konten)
            if (Schema::hasTable('testimonials')) {
                $testimonialList = [
                    [
                        'name' => 'H. Ir. Ahmad Syamsuddin',
                        'profession' => 'Wali Santri Madrasah Aliyah Raudhatul Ulum (MARU)',
                        'photo' => '/uploads/official/foto-mudir.webp',
                        'content' => 'Alhamdulillah, dua anak kami menempuh pendidikan di PPRU Sakatiga. Perubahan karakternya sangat luar biasa: shalat berjamaah tidak pernah tertinggal, adab kepada orang tua sangat santun, dan fasih berbahasa Arab serta hafizh Al-Qur\'an.',
                        'status' => 'publish',
                    ],
                    [
                        'name' => 'Dr. Muhammad Fauzan, Lc., M.A.',
                        'profession' => 'Alumni MARU & Dosen Pascasarjana UIN',
                        'photo' => '/uploads/kh-tolat-wafa-ahmad.webp',
                        'content' => 'Fondasi keilmuan syar\'i berstandar muadalah Al-Azhar Kairo yang saya dapatkan di Sakatiga menjadi bekal utama menembus beasiswa sarjana hingga doktoral di Timur Tengah. PPRU adalah rumah tarbiyah sejati.',
                        'status' => 'publish',
                    ],
                    [
                        'name' => 'Hj. Siti Rahmah, S.Pd.',
                        'profession' => 'Wali Santri SMPIT & SMAIT Raudhatul Ulum',
                        'photo' => '/uploads/official/ngaji-sore.webp',
                        'content' => 'Sistem boarding school 24 jam dengan bimbingan asatidz yang amanah memberi ketenangan bagi kami sebagai orang tua. Anak-anak mandiri, cerdas akademik, dan memiliki kecintaan mendalam pada Al-Qur\'an.',
                        'status' => 'publish',
                    ],
                    [
                        'name' => 'Fadhilurrahman Al-Hafizh, S.Kom.',
                        'profession' => 'Alumni & Software Engineer',
                        'photo' => '/uploads/official/kegiatan-santri-waw1985.webp',
                        'content' => 'Fasilitas kampus terpadu, lingkungan asri dan aman, serta pengasuhan asatidz yang penuh kasih sayang membuat anak-anak betah dan berkembang pesat baik akhlak maupun prestasinya.',
                        'status' => 'publish',
                    ],
                ];

                foreach ($testimonialList as $t) {
                    Testimonial::updateOrCreate(
                        ['name' => $t['name']],
                        $t
                    );
                }
            }

            // 7. Demo Agenda (4 Konten)
            if (Schema::hasTable('agendas')) {
                $agendaList = [
                    [
                        'title' => 'Wisuda Akbar Tahfidz Al-Qur\'an 30 Juz & Khotmil Kutub Angkatan 2026',
                        'event_date' => now()->addDays(14)->setTime(8, 30),
                        'location' => 'Gedung Pertemuan Serbaguna Kampus A PPRU Sakatiga',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                        'content' => 'Prosesi wisuda akbar hafalan Al-Qur\'an 30 juz mutqin santri kelas akhir serta penganugerahan ijazah sanad tahfidz bersama pimpinan pesantren.',
                    ],
                    [
                        'title' => 'Ujian Penilaian Akhir Semester (PAS) Terpadu & Standar Muadalah Al-Azhar',
                        'event_date' => now()->addDays(28)->setTime(7, 30),
                        'location' => 'Ruang Kelas & Laboratorium Komputer Seluruh Unit',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/kbm-santri-0054.webp',
                        'content' => 'Pelaksanaan evaluasi pembelajaran semester genap berbasis Computer Based Test (CBT) dan ujian lisan bahasa Arab-Inggris.',
                    ],
                    [
                        'title' => 'Pekan Olahraga, Seni & Bahasa Santri (PORSENI) Antar-Asrama Se-Pesantren',
                        'event_date' => now()->addDays(42)->setTime(8, 0),
                        'location' => 'Kompleks Lapangan Olahraga Terpadu Kampus B',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/panahan-santri.webp',
                        'content' => 'Ajang unjuk ketangkasan olahraga memanah, futsal, tapak suci, orasi bahasa Arab-Inggris, dan festival kreasi seni santri.',
                    ],
                    [
                        'title' => 'Sarasehan & Temu Akbar Silaturahmi Wali Santri Nasional PPRU Sakatiga',
                        'event_date' => now()->addDays(56)->setTime(9, 0),
                        'location' => 'Masjid Jami\' Pondok Pesantren Raudhatul Ulum',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/ngaji-sore.webp',
                        'content' => 'Forum tahunan komunikasi antara Mudir, dewan asatidz, dan seluruh wali santri guna mengevaluasi tumbuh kembang anak didik.',
                    ],
                ];

                foreach ($agendaList as $ag) {
                    Agenda::updateOrCreate(
                        ['slug' => Str::slug($ag['title'])],
                        [
                            'title' => $ag['title'],
                            'slug' => Str::slug($ag['title']),
                            'event_date' => $ag['event_date'],
                            'location' => $ag['location'],
                            'status' => $ag['status'],
                            'featured_image' => $ag['featured_image'],
                            'content' => $ag['content'],
                        ]
                    );
                }
            }

            // 8. Demo Pengumuman (4 Konten)
            if (Schema::hasTable('pengumumen')) {
                $pengumumanList = [
                    [
                        'title' => 'Pengumuman Kelulusan Seleksi Penerimaan Santri Baru (PSB) Gelombang I T.A. 2026/2027',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Diberitahukan kepada seluruh calon wali santri bahwa hasil seleksi tes akademik, membaca Al-Qur\'an, dan wawancara PSB Gelombang I telah resmi diumumkan. Silakan login ke portal PPDB Online untuk mengunduh surat ketetapan kelulusan.',
                    ],
                    [
                        'title' => 'Jadwal Kedatangan Santri & Tata Tertib Masuk Asrama Tahun Ajaran 2026/2027',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Seluruh santri lama dan santri baru diwajibkan melakukan check-in asrama sesuai pembagian jadwal per unit guna menjaga ketertiban arus lalu lintas dan kelancaran serah terima santri bersama musyrif/musyrifah.',
                    ],
                    [
                        'title' => 'Surat Edaran Libur Hari Raya Idul Fitri 1447 H & Kalender Akademik Pesantren',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Berdasarkan keputusan pimpinan pesantren, perpulangan santri dalam rangka libur Idul Fitri dimulai secara bertahap. Wali santri dihimbau menjemput tepat waktu dan memperhatikan batas akhir kembali ke asrama.',
                    ],
                    [
                        'title' => 'Panduan Registrasi Ulang & Pembayaran Syahriyah Melalui Virtual Account Bank',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Untuk mempermudah layanan administrasi keuangan santri secara transparan dan real-time, seluruh transaksi pembayaran kini menggunakan nomor Virtual Account resmi Bank Syariah Indonesia (BSI) dan Bank Sumsel Babel Syariah.',
                    ],
                ];

                foreach ($pengumumanList as $p) {
                    Pengumuman::updateOrCreate(
                        ['slug' => Str::slug($p['title'])],
                        [
                            'title' => $p['title'],
                            'slug' => Str::slug($p['title']),
                            'status' => $p['status'],
                            'content' => $p['content'],
                            'file_attachment' => $p['file_attachment'],
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureOfficialDemoContentsSeeded error: '.$e->getMessage());
        }
    }

    /**
     * Ensure all core CMS tables exist (fail-safe for cPanel).
     */
    public static function ensureAllCoreTablesExist(): void
    {
        self::ensureUnitPendidikanSchemaExists();
        self::ensureHeroSlidesTableExists();
        self::ensureNavMenusTableExists();
        self::ensureOfficialDemoContentsSeeded();
    }

    /**
     * Seed comprehensive default navigation for PPRU.
     */
    public static function seedDefaultNavMenus(): void
    {
        // 1. Beranda
        NavMenu::create([
            'name' => 'Beranda',
            'url' => '/',
            'icon' => 'fa-solid fa-house',
            'location' => 'header',
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Profil (Dropdown)
        $profil = NavMenu::create([
            'name' => 'Profil',
            'url' => '#',
            'icon' => 'fa-solid fa-landmark-dome',
            'location' => 'header',
            'order' => 2,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sambutan Mudir PPRU', 'url' => '/sambutan', 'icon' => 'fa-solid fa-user-tie', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Profil Singkat Pesantren', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-landmark-dome', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Visi, Misi & 10 Jati Diri', 'url' => '/visi-dan-misi', 'icon' => 'fa-solid fa-compass', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sejarah Sejak 1930 & 1950', 'url' => '/sejarah', 'icon' => 'fa-solid fa-clock-rotate-left', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Dewan Asatidz & Guru', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Struktur Organisasi & Pengasuh', 'url' => '/struktur-organisasi', 'icon' => 'fa-solid fa-sitemap', 'location' => 'header', 'order' => 6]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sarana & Fasilitas Pondok', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'location' => 'header', 'order' => 7]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Program Unggulan Pesantren', 'url' => '/program-unggulan', 'icon' => 'fa-solid fa-star-and-crescent', 'location' => 'header', 'order' => 8]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Ikatan Alumni (IKARUS)', 'url' => '/ikarus', 'icon' => 'fa-solid fa-user-graduate', 'location' => 'header', 'order' => 9]);

        // 3. Pendidikan (Dropdown with all units)
        $pendidikan = NavMenu::create([
            'name' => 'Pendidikan',
            'url' => '/pendidikan',
            'icon' => 'fa-solid fa-building-columns',
            'location' => 'header',
            'order' => 3,
            'is_active' => true,
        ]);

        if (Schema::hasTable('unit_pendidikans')) {
            $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
            foreach ($units as $u) {
                $cleanName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $u->name));
                NavMenu::create([
                    'parent_id' => $pendidikan->id,
                    'name' => $cleanName,
                    'url' => '/pendidikan/'.$u->slug,
                    'icon' => 'fa-solid fa-graduation-cap',
                    'location' => 'header',
                    'order' => $u->order ?: 1,
                ]);
            }
        }

        // 4. Informasi (Dropdown)
        $info = NavMenu::create([
            'name' => 'Informasi',
            'url' => '#',
            'icon' => 'fa-solid fa-newspaper',
            'location' => 'header',
            'order' => 4,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Berita & Kabar Pondok', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Prestasi Santri & Guru', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Agenda & Kalender', 'url' => '/agenda', 'icon' => 'fa-solid fa-calendar-days', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Pengumuman Resmi', 'url' => '/pengumuman', 'icon' => 'fa-solid fa-bullhorn', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Karya Santri & Asatidz', 'url' => '/karya-santri', 'icon' => 'fa-solid fa-feather-pointed', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Khutbah Jum\'at & Tausiyah', 'url' => '/khutbah', 'icon' => 'fa-solid fa-microphone-lines', 'location' => 'header', 'order' => 6]);

        // 5. Layanan
        $layanan = NavMenu::create([
            'name' => 'Layanan',
            'url' => '/layanan-terpadu',
            'icon' => 'fa-solid fa-handshake-angle',
            'location' => 'header',
            'order' => 5,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Izin Kunjungan Sekolah', 'url' => '/izin-sekolah', 'icon' => 'fa-solid fa-school', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Kerja Sama', 'url' => '/permohonan-kerja-sama', 'icon' => 'fa-solid fa-handshake', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Sewa Fasilitas & Sarana', 'url' => '/sewa-barang', 'icon' => 'fa-solid fa-building-user', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Portal Layanan Terpadu', 'url' => '/layanan-terpadu', 'icon' => 'fa-solid fa-circle-nodes', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Brosur & Rincian Biaya', 'url' => '/download', 'icon' => 'fa-solid fa-file-pdf', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Download Logo Resmi', 'url' => '/logo', 'icon' => 'fa-solid fa-image', 'location' => 'header', 'order' => 6]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Kontak & Lokasi Humas', 'url' => '/hubungi', 'icon' => 'fa-solid fa-address-book', 'location' => 'header', 'order' => 7]);

        // Footer Menus
        NavMenu::create(['name' => 'Tentang PPRU', 'url' => '/tentang-kami', 'location' => 'footer_quick', 'order' => 1]);
        NavMenu::create(['name' => 'Unit Pendidikan', 'url' => '/pendidikan', 'location' => 'footer_quick', 'order' => 2]);
        NavMenu::create(['name' => 'Pendaftaran PPDB', 'url' => '/ppdb', 'location' => 'footer_quick', 'order' => 3]);
        NavMenu::create(['name' => 'Khutbah & Dakwah', 'url' => '/khutbah', 'location' => 'footer_quick', 'order' => 4]);
        NavMenu::create(['name' => 'Portal Alumni IKARUS', 'url' => '/ikarus', 'location' => 'footer_quick', 'order' => 5]);
        NavMenu::create(['name' => 'Pusat Unduhan', 'url' => '/unduhan', 'location' => 'footer_quick', 'order' => 6]);
        NavMenu::create(['name' => 'Layanan Pesantren', 'url' => '/layanan', 'location' => 'footer_quick', 'order' => 7]);
    }

    /**
     * Seed default hero slides.
     */
    public static function seedDefaultHeroSlides(): void
    {
        HeroSlide::create([
            'title' => 'Mencetak Generasi Ulama dan Pemimpin Umat',
            'subtitle' => 'Pondok Pesantren Raudhatul Ulum Sakatiga Ogan Ilir Sumatera Selatan memadukan kurikulum kepesantrenan, tahfizh Quran, dan sains modern sejak 1950.',
            'badge' => 'Selamat Datang di Portal Resmi PPRU',
            'image' => '/uploads/hero-slide-1.webp',
            'btn_primary_text' => 'Daftar Santri Baru (PSB)',
            'btn_primary_url' => '/ppdb',
            'btn_secondary_text' => 'Jelajahi Pesantren',
            'btn_secondary_url' => '/tentang-kami',
            'order' => 1,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'title' => 'Pendidikan Islam Berkelanjutan dari Usia Dini hingga Perguruan Tinggi',
            'subtitle' => 'Menaungi 8 unit lembaga pendidikan terpadu: TK Islam, MI, MTs, MA, MATQULA, SMPIT, SMAIT, hingga Institut Agama Islam Nur Raudhatul Ulum.',
            'badge' => '8 Unit Pendidikan Terpadu',
            'image' => '/uploads/hero-slide-2.webp',
            'btn_primary_text' => 'Lihat Semua Unit',
            'btn_primary_url' => '/pendidikan',
            'btn_secondary_text' => 'Program Unggulan',
            'btn_secondary_url' => '/program-unggulan',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
