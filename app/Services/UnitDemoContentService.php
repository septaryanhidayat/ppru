<?php

namespace App\Services;

use App\Models\AnggotaDewan;
use App\Models\Category;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UnitDemoContentService
{
    /**
     * Seed comprehensive demo content for all 8 educational units under YAPIRUS.
     */
    public static function seedAllUnitsDemo(bool $force = false): void
    {
        try {
            CmsAutoHealService::ensureUnitPendidikanSchemaExists();

            $units = UnitPendidikan::all();
            if ($units->isEmpty()) {
                return;
            }

            foreach ($units as $unit) {
                self::seedSingleUnit($unit, $force);
            }
        } catch (\Throwable $e) {
            Log::error('UnitDemoContentService::seedAllUnitsDemo error: '.$e->getMessage());
        }
    }

    /**
     * Check if a specific unit has empty demo content, and seed if needed.
     */
    public static function seedUnitIfEmpty(UnitPendidikan $unit): void
    {
        try {
            CmsAutoHealService::ensureUnitPendidikanSchemaExists();

            $hasPosts = Post::where('unit_pendidikan_id', $unit->id)->where('type', 'post')->exists();
            $hasPhotos = Post::where('unit_pendidikan_id', $unit->id)->where('type', 'gallery')->exists();
            $hasTeachers = AnggotaDewan::where('unit_pendidikan_id', $unit->id)->exists();
            $hasTestimonials = Testimonial::where('unit_pendidikan_id', $unit->id)->exists();

            if (! $hasPosts || ! $hasPhotos || ! $hasTeachers || ! $hasTestimonials) {
                self::seedSingleUnit($unit, false);
            }
        } catch (\Throwable $e) {
            Log::error("UnitDemoContentService::seedUnitIfEmpty for {$unit->name} error: ".$e->getMessage());
        }
    }

    /**
     * Seed comprehensive demo content for a single unit.
     */
    public static function seedSingleUnit(UnitPendidikan $unit, bool $force = false): void
    {
        try {
            CmsAutoHealService::ensureUnitPendidikanSchemaExists();

            // Ensure categories exist
            $catBerita = Category::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita']);
            $catPrestasi = Category::firstOrCreate(['slug' => 'prestasi'], ['name' => 'Prestasi']);
            $catEkskul = Category::firstOrCreate(['slug' => 'ekskul'], ['name' => 'Ekstrakurikuler']);
            $catPendidikan = Category::firstOrCreate(['slug' => 'pendidikan'], ['name' => 'Pendidikan']);

            $defaultAuthor = User::where('unit_pendidikan_id', $unit->id)->first()
                ?? User::whereIn('role', ['super_admin', 'admin'])->first()
                ?? User::first();
            $authorId = $defaultAuthor?->id ?? 1;

            self::seedUnitProfile($unit, $force);
            self::seedUnitPosts($unit, $authorId, $catBerita, $catPendidikan);
            self::seedUnitPhotos($unit, $authorId);
            self::seedUnitPrestasi($unit, $authorId, $catPrestasi);
            self::seedUnitEkskul($unit, $authorId, $catEkskul);
            self::seedUnitTeachers($unit);
            self::seedUnitVideos($unit);
            self::seedUnitTestimonials($unit);
        } catch (\Throwable $e) {
            Log::error("UnitDemoContentService::seedSingleUnit for {$unit->name} error: ".$e->getMessage());
        }
    }

    /**
     * Seed detailed profile data (sambutan, visi, misi, hero, head photo) for a unit.
     */
    protected static function seedUnitProfile(UnitPendidikan $unit, bool $force = false): void
    {
        $short = $unit->short_name ?: $unit->name;

        $profiles = [
            'MARU' => [
                'head_name' => 'Ustadz H. Abdul Halim, Lc.',
                'curriculum' => 'Kurikulum Kemenag & Muadalah Universitas Al-Azhar Kairo Mesir',
                'badge' => 'Terakreditasi A (Unggul)',
                'phone' => '081278901951',
                'email' => 'maru@ppru.ac.id',
                'hero_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'head_photo' => '/uploads/official/kbm-santri-0054.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Ahlan wa sahlan di Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga. Sebagai jenjang pendidikan menengah atas berasrama penuh, MARU berkomitmen mencetak kader ulama amilin dan ilmuwan muslim yang berwawasan global. Dengan muadalah resmi Al-Azhar Kairo Mesir, santri kami dibimbing mendalami kitab kuning turots sekaligus menguasai kurikulum sains nasional secara seimbang.',
                'visi' => 'Terwujudnya kader ulama intelek dan cendekiawan muslim yang beraqidah lurus, berakhlak mulia, menguasai ilmu syar\'i serta sains teknologi.',
                'misi' => "1. Menyelenggarakan pendidikan Islam terpadu dengan standar muadalah Al-Azhar Kairo Mesir.\n2. Membina kemampuan bahasa Arab fusha dan bahasa Inggris aktif secara intensif.\n3. Mengembangkan penalaran sains, teknologi, dan riset ilmiah populer santri.\n4. Membimbing santri menyelesaikan hafalan Al-Qur'an dan mutqin.",
            ],
            'MATSARU' => [
                'head_name' => 'Ustadz H. Syamsuddin, S.Ag.',
                'curriculum' => 'Kurikulum Kemenag Terpadu & Dirasah Kepesantrenan',
                'badge' => 'Terakreditasi A (Unggul)',
                'phone' => '081278901952',
                'email' => 'matsaru@ppru.ac.id',
                'hero_image' => '/uploads/official/drone-lingkungan-9941.webp',
                'head_photo' => '/uploads/official/kbm-santri-0098.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di MTs Raudhatul Ulum (MATSARU). Masa transisi usia remaja adalah fase keemasan dalam pembentukan karakter mandiri dan adab. Di MATSARU, santri dibiasakan sholat berjamaah tepat waktu di masjid, halaqah tahfidz harian, serta disiplin bahasa resmi asrama 24 jam.',
                'visi' => 'Membentuk generasi muslim tingkat dasar yang taat beribadah, berbudi pekerti luhur, dan cerdas dalam akademik.',
                'misi' => "1. Menanamkan aqidah salimah dan akhlak karimah melalui keteladanan asatidz 24 jam.\n2. Menguatkan fondasi dasar kaidah bahasa Arab (Nahwu dan Sharaf) dan tilawah Al-Qur'an.\n3. Mengasah potensi akademik, olahraga, dan kepanduan santri secara optimal.\n4. Mempersiapkan lulusan yang siap bersaing ke jenjang madrasah aliyah unggulan.",
            ],
            'MIRU' => [
                'head_name' => 'Ustadzah Siti Fatimah, S.Pd.I.',
                'curriculum' => 'Kurikulum Kemenag & Pembiasaan Adab Qur\'ani',
                'badge' => 'Terakreditasi A',
                'phone' => '081278901953',
                'email' => 'miru@ppru.ac.id',
                'hero_image' => '/uploads/official/kbm-santri-0152.webp',
                'head_photo' => '/uploads/official/kegiatan-santri-waw1981.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Madrasah Ibtidaiyah Raudhatul Ulum (MIRU) hadir mendampingi putra-putri Anda dalam suasana belajar yang ceria, ramah anak, dan kental dengan nilai-nilai adab islami. Target kami adalah setiap santri lulus dengan tuntas juz 30, terbiasa doa harian, dan mencintai ilmu pengetahuan.',
                'visi' => 'Menjadi madrasah ibtidaiyah teladan yang melahirkan generasi sholeh, cerdas, ceria, dan cinta Al-Qur\'an.',
                'misi' => "1. Menumbuhkan kecintaan membaca, menghafal, dan mengamalkan Al-Qur'an sejak usia dini.\n2. Mengembangkan kemampuan literasi, numerasi, dan kecakapan sosial emosional santri.\n3. Membiasakan adab sopan santun kepada orang tua, guru, dan sesama teman.\n4. Menyelenggarakan kegiatan belajar yang kreatif, aktif, dan menyenangkan.",
            ],
            'MATQULARU' => [
                'head_name' => 'Ustadz M. Shiddiq, Al-Hafizh, Lc.',
                'curriculum' => 'Kulliyatul Qur\'an, Sanad Tahfidz & Pengajian Kitab',
                'badge' => 'Program Unggulan Khusus',
                'phone' => '081278901954',
                'email' => 'matqularu@ppru.ac.id',
                'hero_image' => '/uploads/official/ngaji-sore.webp',
                'head_photo' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. MATQULARU adalah kawah candradimuka bagi santri yang bertekad kuat mendedikasikan waktu menghafal kalamullah 30 juz secara mutqin. Dengan metode talaqqi dan sanad bersambung, para santri ditempa agar hafalan melekat kuat di dada dan tercermin dalam akhlak mulia.',
                'visi' => 'Mencetak para huffazh Al-Qur\'an yang mutqin hafalan, shahih bacaan, dan berakhlak mulia pembawa syafaat.',
                'misi' => "1. Menyelenggarakan karantina dan halaqah tahfidz intensif berstandar sanad qira'ah.\n2. Membekali santri dengan pemahaman tajwid matan Jazariyyah dan Tuhfatul Athfal.\n3. Membimbing tasmi' terbuka sekali duduk berkala dari 5 hingga 30 juz.\n4. Mengajarkan adab hamilul Qur'an dalam kehidupan sehari-hari.",
            ],
            'TAKIRU' => [
                'head_name' => 'Ustadzah Hj. Halimah, S.Pd.',
                'curriculum' => 'Kurikulum PAUD Berbasis Fitrah & Sentra Karakter',
                'badge' => 'Terakreditasi B',
                'phone' => '081278901955',
                'email' => 'takiru@ppru.ac.id',
                'hero_image' => '/uploads/official/drone-danau-telok-putih.webp',
                'head_photo' => '/uploads/official/kegiatan-santri-waw1981.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di TK Islam Raudhatul Ulum (TAKIRU). Kami percaya bahwa setiap anak terlahir dengan fitrah kebaikan. Melalui metode sentra bermain dan belajar, anak-anak diajak mengenal keagungan Allah, melafalkan doa harian, dan mengasah motorik dengan penuh kegembiraan.',
                'visi' => 'Membentuk generasi emas usia dini yang beraqidah bersih, santun berperilaku, dan ceria berkreasi.',
                'misi' => "1. Menanamkan nilai-nilai tauhid dan pengenalan huruf hijaiyah sedari dini.\n2. Melatih kemandirian, keberanian, dan motorik halus serta kasar anak.\n3. Membiasakan adab islami makan, minum, dan salam dalam keseharian.\n4. Membangun sinergi harmonis antara pendidik madrasah dan orang tua santri.",
            ],
            'SMPIT RU' => [
                'head_name' => 'Ustadz Firdaus, S.Pd.I., M.Pd.',
                'curriculum' => 'Kurikulum Nasional & Standar Mutu JSIT Indonesia',
                'badge' => 'Terakreditasi A (Unggul)',
                'phone' => '081278901956',
                'email' => 'smpit@ppru.ac.id',
                'hero_image' => '/uploads/official/kbm-santri-0054.webp',
                'head_photo' => '/uploads/official/kbm-santri-0054.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. SMPIT Raudhatul Ulum memadukan kurikulum Kementerian Pendidikan dengan standar mutu Jaringan Sekolah Islam Terpadu (JSIT). Kami mempersiapkan santri yang unggul dalam sains, berprestasi dalam kepanduan, dan memiliki adab islami yang kokoh.',
                'visi' => 'Terwujudnya sekolah Islam terpadu yang melahirkan generasi cerdas berprestasi dan berjiwa pelopor.',
                'misi' => "1. Melaksanakan pembelajaran aktif berbasis proyek (P5) dan integrasi nilai Qur'ani.\n2. Mengembangkan kompetensi sains, teknologi, matematika, dan literasi digital santri.\n3. Menanamkan kepemimpinan melalui kepanduan SIT dan organisasi santri.\n4. Membina hafalan Al-Qur'an minimal 3 juz mutqin selama jenjang SMP.",
            ],
            'SMAIT RU' => [
                'head_name' => 'Ustadz H. Rahmat, M.Pd.',
                'curriculum' => 'Kurikulum Nasional Terpadu & Bimbingan Khusus UTBK/SNBT',
                'badge' => 'Terakreditasi A (Unggul)',
                'phone' => '081278901957',
                'email' => 'smait@ppru.ac.id',
                'hero_image' => '/uploads/official/drone-lingkungan-9936.webp',
                'head_photo' => '/uploads/official/panahan-santri.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. SMA Islam Terpadu Raudhatul Ulum dirancang sebagai batu loncatan strategis bagi santri untuk menembus Perguruan Tinggi Negeri (PTN) favorit dan kampus bergengsi luar negeri, tanpa meninggalkan identitas santri yang hafal Qur\'an dan berakhlak mulia.',
                'visi' => 'Mencetak cendekiawan muda berwawasan global yang siap memimpin peradaban dengan nilai Islam.',
                'misi' => "1. Menyelenggarakan program intensif sukses UTBK-SNBT dan seleksi kedinasan.\n2. Mengasah kemampuan riset ilmiah remaja dan publikasi sains santri.\n3. Meningkatkan skor kemahiran bahasa Inggris (TOEFL) dan bahasa Arab santri.\n4. Membina kepemimpinan organisasi dan dakwah keummatan.",
            ],
            'IAI NRU' => [
                'head_name' => 'Dr. H. Faisal, M.Ag.',
                'curriculum' => 'Kurikulum PTKI Berbasis KKNI & Nilai Ma\'had Aly',
                'badge' => 'Terakreditasi BAN-PT Baik Sekali',
                'phone' => '081278901958',
                'email' => 'iainru@ppru.ac.id',
                'hero_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'head_photo' => '/uploads/official/kbm-santri-0054.webp',
                'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Institut Agama Islam Nur Raudhatul Ulum (IAI NRU) adalah wujud kesinambungan pendidikan tinggi di dalam kawasan pondok pesantren. Kami berkomitmen menyelenggarakan tridharma perguruan tinggi yang kontekstual, melahirkan sarjana muslim yang profesional dan berintegritas moral tinggi.',
                'visi' => 'Menjadi pusat keunggulan pendidikan tinggi Islam berbasis riset dan kearifan pesantren di tingkat regional.',
                'misi' => "1. Menyelenggarakan pendidikan sarjana berkualitas dalam bidang tarbiyah, syari'ah, dan dakwah.\n2. Mengembangkan penelitian dan pengabdian masyarakat yang berdampak nyata.\n3. Menjalin kemitraan akademik nasional dan internasional.\n4. Memelihara tradisi keilmuan turots Islam di tengah arus modernitas.",
            ],
        ];

        $data = $profiles[$short] ?? [
            'head_name' => $unit->head_name ?: 'Pimpinan Unit',
            'curriculum' => $unit->curriculum ?: 'Kurikulum Terpadu Pesantren',
            'badge' => $unit->badge ?: 'Terakreditasi A',
            'phone' => $unit->phone ?: '081278901950',
            'email' => $unit->email ?: 'info@ppru.ac.id',
            'hero_image' => '/uploads/official/drone-raudhatul-ulum.webp',
            'head_photo' => '/uploads/avatar-neutral-gray.svg',
            'sambutan' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di '.$unit->name.' Pondok Pesantren Raudhatul Ulum Sakatiga.',
            'visi' => 'Mencetak generasi muslim berilmu amaliah dan berakhlak mulia.',
            'misi' => "1. Menyelenggarakan pendidikan Islam terpadu.\n2. Membina kedisiplinan dan adab islami santri.",
        ];

        if ($force) {
            $unit->update([
                'head_name' => $data['head_name'],
                'curriculum' => $data['curriculum'],
                'badge' => $data['badge'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'hero_image' => $data['hero_image'],
                'head_photo' => $data['head_photo'],
                'sambutan' => $data['sambutan'],
                'visi' => $data['visi'],
                'misi' => $data['misi'],
            ]);
        } else {
            $unit->update([
                'head_name' => $unit->head_name ?: $data['head_name'],
                'curriculum' => $unit->curriculum ?: $data['curriculum'],
                'badge' => $unit->badge ?: $data['badge'],
                'phone' => $unit->phone ?: $data['phone'],
                'email' => $unit->email ?: $data['email'],
                'hero_image' => $unit->hero_image ?: $data['hero_image'],
                'head_photo' => $unit->head_photo ?: $data['head_photo'],
                'sambutan' => $unit->sambutan ?: $data['sambutan'],
                'visi' => $unit->visi ?: $data['visi'],
                'misi' => $unit->misi ?: $data['misi'],
            ]);
        }
    }

    /**
     * Seed realistic news posts for the unit.
     */
    protected static function seedUnitPosts(UnitPendidikan $unit, int $authorId, Category $catBerita, Category $catPendidikan): void
    {
        $short = $unit->short_name ?: $unit->name;

        $postsData = [
            [
                'title' => "Dinamika Pembelajaran dan Halaqah Qur'ani Santri {$short} Berjalan Khidmat",
                'content' => "<p>Kegiatan belajar mengajar dan pembinaan keagamaan di unit <strong>{$unit->name}</strong> berjalan penuh antusiasme. Seluruh asatidz dan musyrif mendampingi santri secara intensif dalam rangka mewujudkan pribadi yang cerdas berakhlak mulia.</p><p>Program ini mencakup penguatan literasi kitab kuning, muhadatsah bahasa harian, dan setoran hafalan mutqin.</p>",
                'image' => '/uploads/official/kbm-santri-0054.webp',
            ],
            [
                'title' => "Pekan Kreativitas dan Asah Bakat Kepemimpinan Santri {$short} Tahun 2026",
                'content' => "<p>Unit <strong>{$unit->name}</strong> sukses menyelenggarakan Pekan Kreativitas Santri. Ajang tahunan ini menghadirkan beragam lomba kepemimpinan, debat ilmiah, seni kaligrafi, dan olahraga ketangkasan.</p><p>Kepala unit mengapresiasi tingginya partisipasi santri yang menunjukkan kemandirian dan sportifitas tinggi.</p>",
                'image' => '/uploads/official/kegiatan-santri-waw1985.webp',
            ],
            [
                'title' => "Program Penguatan Karakter, Disiplin, dan Bahasa Asing Santri {$short}",
                'content' => "<p>Untuk menunjang wawasan global, unit <strong>{$unit->name}</strong> mengintensifkan program bi'ah lughawiyyah (lingkungan berbahasa Arab dan Inggris). Santri dibimbing berbicara secara natural dalam percakapan formal maupun pergaulan asrama.</p><p>Penerapan disiplin positif ini menjadi ciri khas pesantren dalam melahirkan lulusan berdaya saing tinggi.</p>",
                'image' => '/uploads/official/kbm-santri-0098.webp',
            ],
            [
                'title' => "Studi Kolaboratif dan Pengayaan Wawasan Akademik Terpadu di {$short}",
                'content' => "<p>Guna memperkaya literasi keilmuan, asatidz di unit <strong>{$unit->name}</strong> menerapkan model pembelajaran aktif berbasis studi kasus dan kolaborasi kelompok. Santri diajak berpikir kritis terhadap materi kurikulum dan menghubungkannya dengan pengamalan ibadah sehari-hari.</p>",
                'image' => '/uploads/official/kbm-santri-0152.webp',
            ],
        ];

        foreach ($postsData as $p) {
            $slug = Str::slug($p['title']);
            $post = Post::where('unit_pendidikan_id', $unit->id)->where('slug', $slug)->first();
            if (! $post) {
                $created = Post::create([
                    'unit_pendidikan_id' => $unit->id,
                    'title' => $p['title'],
                    'slug' => $slug,
                    'content' => $p['content'],
                    'excerpt' => Str::limit(strip_tags($p['content']), 160),
                    'type' => 'post',
                    'status' => 'publish',
                    'featured_image' => $p['image'],
                    'author_id' => $authorId,
                    'author_name' => "Redaksi {$short}",
                    'published_at' => now()->subDays(rand(1, 14)),
                ]);
                $created->categories()->syncWithoutDetaching([$catBerita->id, $catPendidikan->id]);
            }
        }
    }

    /**
     * Seed 4 realistic gallery photos for the unit.
     */
    protected static function seedUnitPhotos(UnitPendidikan $unit, int $authorId): void
    {
        $short = $unit->short_name ?: $unit->name;

        $photosData = [
            [
                'title' => "Dokumentasi Pembelajaran Terpadu Santri {$short}",
                'image' => '/uploads/official/kbm-santri-0054.webp',
            ],
            [
                'title' => "Suasana Santri Menyimak Pelajaran di Kelas {$short}",
                'image' => '/uploads/official/kbm-santri-0098.webp',
            ],
            [
                'title' => "Kegiatan Pembiasaan Adab dan Halaqah Sore {$short}",
                'image' => '/uploads/official/ngaji-sore.webp',
            ],
            [
                'title' => "Latihan Ketangkasan Jasmani dan Olahraga Santri {$short}",
                'image' => '/uploads/official/panahan-santri.webp',
            ],
        ];

        foreach ($photosData as $p) {
            $slug = Str::slug($p['title']);
            $post = Post::where('unit_pendidikan_id', $unit->id)->where('slug', $slug)->first();
            if (! $post) {
                Post::create([
                    'unit_pendidikan_id' => $unit->id,
                    'title' => $p['title'],
                    'slug' => $slug,
                    'content' => "<p>Dokumentasi foto kegiatan belajar dan pembinaan santri di lingkungan {$unit->name} Pondok Pesantren Raudhatul Ulum Sakatiga.</p>",
                    'excerpt' => "Dokumentasi foto kegiatan di lingkungan {$unit->name}.",
                    'type' => 'gallery',
                    'status' => 'publish',
                    'featured_image' => $p['image'],
                    'author_id' => $authorId,
                    'author_name' => "Dokumentasi {$short}",
                    'published_at' => now()->subDays(rand(1, 10)),
                ]);
            }
        }
    }

    /**
     * Seed 2 realistic achievements for the unit.
     */
    protected static function seedUnitPrestasi(UnitPendidikan $unit, int $authorId, Category $catPrestasi): void
    {
        $short = $unit->short_name ?: $unit->name;

        $prestasiData = [
            [
                'title' => "Santri {$short} Raih Juara 1 Kompetisi Sains & Keagamaan Tingkat Provinsi",
                'content' => "<p>Kabar membanggakan datang dari santri <strong>{$unit->name}</strong> yang berhasil membawa pulang trofi Juara 1 pada ajang kompetisi sains dan keagamaan tingkat provinsi.</p><p>Prestasi ini membuktikan keunggulan kurikulum terpadu pondok pesantren yang mengawinkan kedalaman ilmu agama dan kecakapan akademik umum.</p>",
                'image' => '/uploads/official/kbm-santri-0098.webp',
            ],
            [
                'title' => "Delegasi Santri {$short} Harumkan Almamater pada Musabaqah Hifzhil Qur'an",
                'content' => "<p>Melalui perjuangan dan latihan intensif bersama musyrif, santri <strong>{$unit->name}</strong> berhasil menyabet predikat terbaik pada ajang Musabaqah Hifzhil Qur'an bergengsi.</p><p>Pimpinan unit menyampaikan rasa syukur dan berharap pencapaian ini memotivasi seluruh santri untuk istiqomah menghafal Al-Qur'an.</p>",
                'image' => '/uploads/official/ngaji-sore.webp',
            ],
        ];

        foreach ($prestasiData as $p) {
            $slug = Str::slug($p['title']);
            $post = Post::where('unit_pendidikan_id', $unit->id)->where('slug', $slug)->first();
            if (! $post) {
                $created = Post::create([
                    'unit_pendidikan_id' => $unit->id,
                    'title' => $p['title'],
                    'slug' => $slug,
                    'content' => $p['content'],
                    'excerpt' => Str::limit(strip_tags($p['content']), 160),
                    'type' => 'prestasi',
                    'status' => 'publish',
                    'featured_image' => $p['image'],
                    'author_id' => $authorId,
                    'author_name' => "Tim Prestasi {$short}",
                    'published_at' => now()->subDays(rand(2, 20)),
                ]);
                $created->categories()->syncWithoutDetaching([$catPrestasi->id]);
            }
        }
    }

    /**
     * Seed 2 featured extracurriculars for the unit.
     */
    protected static function seedUnitEkskul(UnitPendidikan $unit, int $authorId, Category $catEkskul): void
    {
        $short = $unit->short_name ?: $unit->name;

        $ekskulData = [
            [
                'title' => "Ekstrakurikuler Olahraga Sunnah Panahan (Archery) {$short}",
                'content' => "<p>Ekskul panahan merupakan salah satu wadah pembinaan jasmani dan fokus mental santri <strong>{$unit->name}</strong>. Melalui bimbingan instruktur bersertifikasi, santri dilatih konsentrasi, ketenangan emosi, dan kedisiplinan diri sesuai anjuran sunnah Rasulullah SAW.</p>",
                'image' => '/uploads/official/panahan-santri.webp',
            ],
            [
                'title' => "Klub Muhadharah Khitobah Pidato Tiga Bahasa {$short}",
                'content' => "<p>Kegiatan khitobah melatih rasa percaya diri dan keterampilan retorika dakwah santri dalam bahasa Arab, Inggris, dan Indonesia. Program mingguan ini membentuk santri agar siap menjadi da'i dan orator berbobot di tengah masyarakat.</p>",
                'image' => '/uploads/official/kbm-santri-0152.webp',
            ],
        ];

        foreach ($ekskulData as $e) {
            $slug = Str::slug($e['title']);
            $post = Post::where('unit_pendidikan_id', $unit->id)->where('slug', $slug)->first();
            if (! $post) {
                $created = Post::create([
                    'unit_pendidikan_id' => $unit->id,
                    'title' => $e['title'],
                    'slug' => $slug,
                    'content' => $e['content'],
                    'excerpt' => Str::limit(strip_tags($e['content']), 160),
                    'type' => 'ekskul',
                    'status' => 'publish',
                    'featured_image' => $e['image'],
                    'author_id' => $authorId,
                    'author_name' => "Pembina Ekskul {$short}",
                    'published_at' => now()->subDays(rand(5, 30)),
                ]);
                $created->categories()->syncWithoutDetaching([$catEkskul->id]);
            }
        }
    }

    /**
     * Seed 2-3 dedicated teachers in dewan_asatidz for the unit.
     */
    protected static function seedUnitTeachers(UnitPendidikan $unit): void
    {
        $short = $unit->short_name ?: $unit->name;

        $teachers = [
            [
                'name' => "Ustadz {$short} Al-Hafizh, S.Pd.I.",
                'position' => "Koordinator Tahfidz & Keasramaan {$short}",
                'education' => 'S1 Pendidikan Agama Islam',
                'order' => 1,
            ],
            [
                'name' => "Ustadz {$short} M.Pd.",
                'position' => "Waka Kurikulum & Pembelajaran {$short}",
                'education' => 'S2 Manajemen Pendidikan',
                'order' => 2,
            ],
            [
                'name' => "Ustadzah {$short} S.Si.",
                'position' => "Pembina Sains & Bimbingan Minat Bakat {$short}",
                'education' => 'S1 Sains & Matematika',
                'order' => 3,
            ],
        ];

        foreach ($teachers as $t) {
            $existing = AnggotaDewan::where('name', $t['name'])->first();
            if (! $existing) {
                AnggotaDewan::create([
                    'unit_pendidikan_id' => $unit->id,
                    'name' => $t['name'],
                    'slug' => Str::slug($t['name']),
                    'position' => $t['position'],
                    'fraction' => $short,
                    'education' => $t['education'],
                    'profile_summary' => "Tenaga pendidik profesional berdedikasi tinggi di unit {$unit->name}.",
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'order' => $t['order'],
                ]);
            } else {
                $existing->update([
                    'unit_pendidikan_id' => $unit->id,
                    'fraction' => $short,
                    'position' => $t['position'],
                ]);
            }
        }
    }

    /**
     * Seed official YouTube video for the unit.
     */
    protected static function seedUnitVideos(UnitPendidikan $unit): void
    {
        $short = $unit->short_name ?: $unit->name;
        $title = "Profil Kegiatan dan Kiprah Santri {$short} Raudhatul Ulum";

        $video = Video::where('unit_pendidikan_id', $unit->id)->first();
        if (! $video) {
            Video::create([
                'unit_pendidikan_id' => $unit->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_id' => 'dQw4w9WgXcQ',
                'description' => "Video dokumentasi ragam kegiatan pembelajaran dan kedisiplinan santri di unit {$unit->name} Pondok Pesantren Raudhatul Ulum Sakatiga.",
            ]);
        }
    }

    /**
     * Seed 2 authentic testimonials for the unit.
     */
    protected static function seedUnitTestimonials(UnitPendidikan $unit): void
    {
        $short = $unit->short_name ?: $unit->name;

        $testimonials = [
            [
                'name' => "H. Ahmad Fauzi (Wali Santri {$short})",
                'profession' => "Wali Santri {$short}",
                'content' => "Alhamdulillah, ananda mengalami perubahan karakter yang luar biasa sejak menempuh pendidikan di {$unit->name}. Ibadahnya tertib, adabnya santun, dan hafalannya terus bertambah.",
            ],
            [
                'name' => "Muhammad Syakir, S.T. (Alumni {$short})",
                'profession' => "Alumni {$short} & Profesional",
                'content' => "Fondasi kedisiplinan, bahasa asing, dan pemahaman agama yang saya dapatkan di {$unit->name} menjadi modal berharga dalam meniti karier profesional.",
            ],
        ];

        foreach ($testimonials as $t) {
            $existing = Testimonial::where('unit_pendidikan_id', $unit->id)->where('name', $t['name'])->first();
            if (! $existing) {
                Testimonial::create([
                    'unit_pendidikan_id' => $unit->id,
                    'name' => $t['name'],
                    'profession' => $t['profession'],
                    'content' => $t['content'],
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'status' => 'publish',
                ]);
            }
        }
    }
}
