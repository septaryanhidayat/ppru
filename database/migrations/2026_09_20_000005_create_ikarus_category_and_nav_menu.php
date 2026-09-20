<?php

use App\Models\Category;
use App\Models\NavMenu;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ensure IKARUS Category exists
        if (Schema::hasTable('categories')) {
            $ikarusCat = Category::firstOrCreate(
                ['slug' => 'ikarus'],
                [
                    'name' => 'IKARUS',
                    'description' => 'Ikatan Keluarga Alumni Raudhatul Ulum (IKARUS) - Berita, opini, dan karya tulisan alumni PPRU Sakatiga.',
                ]
            );

            // 2. Ensure initial alumni articles exist under IKARUS category
            if (Schema::hasTable('posts') && Schema::hasTable('post_category')) {
                $author = User::where('role', 'superadmin')->orWhere('role', 'admin')->first() ?: User::first();
                $authorId = $author?->id;

                $existingCount = Post::whereHas('categories', function ($q) {
                    $q->where('slug', 'ikarus')->orWhere('name', 'like', '%ikarus%');
                })->count();

                if ($existingCount === 0) {
                    $post1 = Post::create([
                        'title' => 'Kiprah Alumni MARU Menempuh Studi di Universitas Al-Azhar Kairo Mesir',
                        'slug' => 'kiprah-alumni-maru-menempuh-studi-di-universitas-al-azhar-kairo-mesir',
                        'type' => 'post',
                        'author_id' => $authorId,
                        'author_name' => 'Ustadz Ahmad Farhan, Lc. (Alumni MARU 2018)',
                        'content' => '
                            <p class="lead">Melalui program muadalah (penyetaraan ijazah resmi) antara Pondok Pesantren Raudhatul Ulum Sakatiga dengan Universitas Al-Azhar Kairo, setiap tahunnya puluhan alumni santri diberangkatkan ke Mesir untuk menimba ilmu syariah dan dirasah islamiyah.</p>
                            
                            <h2>Perjalanan Menembus Kampus Tertua di Dunia</h2>
                            <p>Keberhasilan santri menembus seleksi nasional Kemenag dan beasiswa langsung Al-Azhar berakar dari pondasi kebahasaan yang kokoh sejak di pondok. Tradisi <em>Muhadatsah</em>, kajian <em>Kutubut Turats</em> (Kitab Kuning), dan bimbingan para masyaikh di MARU memberikan bekal mutqin bagi para santri.</p>
                            
                            <blockquote>"Belajar di Raudhatul Ulum tidak hanya membentuk kecerdasan kognitif, tetapi juga adab, kedisiplinan asrama, serta mental kemandirian yang sangat terasa manfaatnya saat hidup di perantauan Kairo." — Ustadz Ahmad Farhan, Lc.</blockquote>

                            <h2>Kontribusi untuk Almamater dan Bangsa</h2>
                            <p>Para alumni di Mesir yang terhimpun dalam IKARUS Komisariat Kairo secara berkala mengadakan bimbingan belajar (bimbel) persiapan kuliah bagi adik-adik kelas santri baru, serta berkontribusi menerjemahkan karya-karya ilmiah ulama Al-Azhar untuk khazanah keislaman nusantara.</p>
                        ',
                        'excerpt' => 'Catatan inspiratif alumni MARU PPRU Sakatiga yang menempuh pendidikan sarjana di Universitas Al-Azhar Kairo Mesir melalui program muadalah resmi.',
                        'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                        'status' => 'publish',
                        'is_featured' => true,
                        'published_at' => now()->subDays(2),
                        'views_count' => 142,
                    ]);
                    $post1->categories()->sync([$ikarusCat->id]);

                    $post2 = Post::create([
                        'title' => 'Membangun Sinergi Ummat: Catatan Reuni Akbar dan Musyawarah Kerja IKARUS PPRU',
                        'slug' => 'membangun-sinergi-ummat-catatan-reuni-akbar-dan-musyawarah-kerja-ikarus-ppru',
                        'type' => 'post',
                        'author_id' => $authorId,
                        'author_name' => 'Pengurus Pusat IKARUS Sakatiga',
                        'content' => '
                            <p class="lead">Musyawarah Kerja dan Reuni Akbar Ikatan Keluarga Alumni Raudhatul Ulum (IKARUS) mengukuhkan komitmen pengabdian alumni dalam memajukan dakwah, ekonomi keummatan, dan beasiswa santri berprestasi.</p>
                            
                            <h2>Tiga Pilar Program Unggulan IKARUS</h2>
                            <p>Dalam musyawarah kerja tahun ini, IKARUS menetapkan 3 fokus program pengabdian:</p>
                            <ul>
                                <li><strong>Dana Abadi Beasiswa Santri Yatim & Dhuafa</strong>: Bantuan pembiayaan pendidikan penuh bagi santri berprestasi di seluruh unit lembaga bawah YAPIRUS.</li>
                                <li><strong>Bimbingan Karir & Alumni Mentorship</strong>: Pendampingan bagi lulusan MA/SMAIT dalam memilih jurusan perguruan tinggi negeri (PTN) dan kampus luar negeri.</li>
                                <li><strong>Jejaring Bisnis & Kolaborasi Profesional</strong>: Membuka peluang sinergi wirausaha antar-alumni berbasis ekonomi syariah.</li>
                            </ul>

                            <p>Semoga ikhtiar kebersamaan ini terus membawa berkah bagi almamater Pondok Pesantren Raudhatul Ulum Sakatiga tercinta.</p>
                        ',
                        'excerpt' => 'Musyawarah Kerja dan Reuni Akbar IKARUS menyepakati 3 pilar aksi pengabdian: beasiswa santri, mentoring karir lulusan, dan sinergi ekonomi keummatan.',
                        'featured_image' => '/uploads/official/drone-danau-telok-putih.webp',
                        'status' => 'publish',
                        'is_featured' => false,
                        'published_at' => now()->subDays(5),
                        'views_count' => 98,
                    ]);
                    $post2->categories()->sync([$ikarusCat->id]);
                }
            }
        }

        // 3. Ensure NavMenu has IKARUS entry if nav_menus table exists
        if (Schema::hasTable('nav_menus')) {
            $existingNav = NavMenu::where('location', 'header')
                ->where(function ($q) {
                    $q->where('url', '/ikarus')
                        ->orWhere('name', 'like', '%IKARUS%');
                })->first();

            if (! $existingNav) {
                NavMenu::create([
                    'name' => 'IKARUS (Alumni)',
                    'url' => '/ikarus',
                    'location' => 'header',
                    'icon' => 'fa-solid fa-graduation-cap',
                    'order' => 4,
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
        if (Schema::hasTable('nav_menus')) {
            NavMenu::where('url', '/ikarus')->delete();
        }

        // Keep category data intact on rollback to avoid data loss for user articles
    }
};
