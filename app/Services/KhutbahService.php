<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KhutbahService
{
    /**
     * Pastikan kategori Khutbah dan sample demo naskah khutbah tersedia di sistem.
     */
    public static function ensureCategoryAndDemos(): Category
    {
        // 1. Dapatkan atau buat Kategori Khutbah Jum'at
        $category = Category::where('slug', 'khutbah')
            ->orWhere('slug', 'khutbah-jumat')
            ->first();

        if (! $category) {
            $category = Category::create([
                'name' => 'Khutbah Jum\'at',
                'slug' => 'khutbah',
                'description' => 'Koleksi naskah khutbah Jum\'at, khutbah hari raya, dan materi dakwah Islamiyah resmi Pondok Pesantren Raudhatul Ulum Sakatiga.',
            ]);
        }

        // 2. Cek apakah ada naskah khutbah di database
        $existingCount = Post::whereHas('categories', function ($q) {
            $q->whereIn('slug', ['khutbah', 'khutbah-jumat', 'taujih'])
                ->orWhere('name', 'like', '%khutbah%');
        })->orWhere('type', 'khutbah')->count();

        if ($existingCount < 3) {
            self::seedDemoKhutbahs($category);
        }

        return $category;
    }

    /**
     * Query dasar untuk mengambil semua postingan yang termasuk dalam rubrik Khutbah.
     * Cukup dengan memilih kategori 'Khutbah Jum'at' atau slug 'khutbah'/'taujih',
     * artikel otomatis masuk ke query ini.
     */
    public static function getKhutbahQuery(Request $request): Builder
    {
        $baseQuery = Post::whereIn('status', ['publish', 'published'])
            ->where(function ($q) {
                $q->whereHas('categories', function ($catQ) {
                    $catQ->whereIn('slug', ['khutbah', 'khutbah-jumat', 'taujih'])
                        ->orWhere('name', 'like', '%khutbah%');
                })->orWhere('type', 'khutbah');
            });

        // Filter Pencarian (Kata Kunci, Judul, Materi, Nama Khatib)
        if ($search = $request->input('q')) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter Tema Khutbah (Tag atau Tema Spesifik)
        if ($tema = $request->input('tema')) {
            $baseQuery->where(function ($q) use ($tema) {
                $q->whereHas('tags', function ($tq) use ($tema) {
                    $tq->where('slug', $tema)
                        ->orWhere('name', 'like', "%{$tema}%");
                })->orWhere('title', 'like', "%{$tema}%");
            });
        }

        return $baseQuery->with(['categories', 'tags', 'author', 'unitPendidikan']);
    }

    /**
     * Dapatkan daftar tema/topik khutbah populer beserta jumlah naskah.
     */
    public static function getKhutbahThemes(): array
    {
        return [
            ['slug' => '', 'name' => 'Semua Khutbah', 'icon' => 'fa-solid fa-list-check'],
            ['slug' => 'aqidah', 'name' => 'Aqidah & Keimanan', 'icon' => 'fa-solid fa-shield-halved'],
            ['slug' => 'akhlak', 'name' => 'Akhlak & Muamalah', 'icon' => 'fa-solid fa-hand-holding-heart'],
            ['slug' => 'ibadah', 'name' => 'Ibadah & Fiqih', 'icon' => 'fa-solid fa-mosque'],
            ['slug' => 'keluarga', 'name' => 'Keluarga & Birrul Walidain', 'icon' => 'fa-solid fa-people-roof'],
            ['slug' => 'hari-raya', 'name' => 'Khutbah Hari Raya', 'icon' => 'fa-solid fa-star-and-crescent'],
        ];
    }

    /**
     * Seed naskah khutbah bermutu tinggi dengan teks Arab berharakat,
     * wasiat taqwa, dan panduan khatib.
     */
    public static function seedDemoKhutbahs(Category $category): void
    {
        $admin = User::where('role', 'superadmin')->orWhere('role', 'admin')->first();

        $demoItems = [
            [
                'title' => 'Meneguhkan Istiqamah dan Keikhlasan di Tengah Gelombang Fitnah Akhir Zaman',
                'slug' => 'meneguhkan-istiqamah-dan-keikhlasan-akhir-zaman',
                'author_name' => 'KH. Tol\'at Wafa Ahmad, Lc.',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'tags' => ['aqidah', 'istiqamah', 'keikhlasan'],
                'excerpt' => 'Naskah khutbah Jum\'at tentang urgensi memegang teguh tali agama, memurnikan niat lillahi ta\'ala, dan melatih kesabaran di tengah dinamika godaan dunia modern.',
                'published_at' => Carbon::now()->subDays(2),
                'content' => <<<'HTML'
<div class="khutbah-container space-y-6">
    <div class="khutbah-section khutbah-pertama bg-emerald-50/40 p-6 rounded-2xl border border-emerald-100">
        <h3 class="text-lg font-bold text-[#006e30] border-b border-emerald-200 pb-2 mb-4 flex items-center">
            <span class="w-2.5 h-2.5 rounded-full bg-[#006e30] mr-2"></span>
            KHUTBAH PERTAMA
        </h3>

        <div class="arabic-block text-right font-serif text-xl sm:text-2xl leading-loose text-slate-900 bg-white p-5 rounded-xl border border-emerald-100 mb-4 shadow-sm" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ، اَلْحَمْدُ لِلّٰهِ الَّذِيْ هَدَانَا لِهٰذَا وَمَا كُنَّا لِنَهْتَدِيَ لَوْلَا أَنْ هَدَانَا اللّٰهُ. أَشْهَدُ أَنْ لَا إِلٰهَ إِلَّا اللّٰهُ وَحْدَهُ لَا شَرِيْكَ لَهُ، وَأَشْهَدُ أَنَّ سَيِّدَنَا وَنَبِيَّنَا مُحَمَّدًا عَبْدُهُ وَرَسُوْلُهُ، لَا نَبِيَّ وَلَا رَسُوْلَ بَعْدَهُ.<br><br>
            اَللّٰهُمَّ صَلِّ وَسَلِّمْ وَبَارِكْ عَلَى سَيِّدِنَا مُحَمَّدٍ، وَعَلَى آلِهِ وَصَحْبِهِ أَجْمَعِيْنَ.<br><br>
            أَمَّا بَعْدُ، فَيَا عِبَادَ اللّٰهِ، أُوْصِيْكُمْ وَنَفْسِيْ بِتَقْوَى اللّٰهِ، فَقَدْ فَازَ الْمُتَّقُوْنَ. قَالَ اللّٰهُ تَعَالَى فِيْ كِتَابِهِ الْكَرِيْمِ: <strong>يَا أَيُّهَا الَّذِينَ آمَنُوا اتَّقُوا اللَّهَ حَقَّ تُقَاتِهِ وَلَا تَمُوتُنَّ إِلَّا وَأَنتُم مُّسْلِمُونَ</strong>
        </div>

        <div class="khutbah-body text-slate-800 space-y-4 text-justify leading-relaxed">
            <p><strong>Ma'asyiral Muslimin Rahimakumullah,</strong></p>
            <p>Segala puji dan puja marilah senantiasa kita persembahkan ke hadirat Allah Subhanahu wa Ta'ala, Rabb semesta alam yang tiada henti melimpahkan taufiq, hidayah, dan nikmat-Nya yang tak terhingga kepada kita sekalian. Shalawat serta salam semoga tercurah kepada uswah hasanah kita, Baginda Nabi Muhammad Shallallahu 'Alaihi Wasallam, beserta keluarga dan para sahabatnya yang mulia.</p>
            <p>Dari atas mimbar yang mulia ini, khatib berwasiat kepada diri pribadi dan segenap jamaah shalat Jum'at sekalian, marilah kita senantiasa meningkatkan keimanan dan ketakwaan kepada Allah Ta'ala. Takwa dalam makna yang sebenar-benarnya: menjalankan seluruh titah perintah-Nya dan sekuat tenaga menjauhi larangan-larangan-Nya.</p>
            
            <p><strong>Sidang Jum'at yang Diberkahi Allah,</strong></p>
            <p>Kita hidup di suatu masa yang penuh dengan dinamika, keterbukaan informasi, dan derasnya fitnah syubhat maupun syahwat. Nilai-nilai kebenaran terkadang dikaburkan oleh opini dan persepsi yang menyesatkan. Di tengah situasi seperti ini, bekal paling berharga seorang mukmin adalah <em>keistiqamahan</em> dan <em>keikhlasan</em>.</p>
            <p>Rasulullah Shallallahu 'Alaihi Wasallam pernah didatangi seorang sahabat bernama Sufyan bin Abdillah radhiyallahu 'anhu yang memohon nasihat ringkas namun mencakup keseluruhan pokok agama:</p>
            
            <blockquote class="bg-white p-4 rounded-xl border-l-4 border-[#006e30] my-3 text-slate-700 italic">
                "Wahai Rasulullah, katakanlah kepadaku suatu perkataan dalam Islam yang aku tidak akan menanyakannya lagi kepada seorang pun selain engkau!" Beliau bersabda: <em>"Katakanlah: Aku beriman kepada Allah, kemudian istiqamahlah!"</em> (HR. Muslim).
            </blockquote>

            <p>Istiqamah bukanlah berarti kita tidak pernah berbuat salah, melainkan kesadaran penuh untuk segera kembali bangkit saat tergelincir, bertaubat saat khilaf, dan terus menjaga komitmen ibadah walau badai godaan menghadang. Allah Ta'ala berfirman dalam Surah Fushshilat ayat 30:</p>

            <div class="arabic-block text-right font-serif text-lg leading-loose text-emerald-950 bg-white/80 p-4 rounded-lg my-2" dir="rtl">
                إِنَّ الَّذِينَ قَالُوا رَبُّنَا اللَّهُ ثُمَّ اسْتَقَامُوا تَتَنَزَّلُ عَلَيْهِمُ الْمَلَائِكَةُ أَلَّا تَخَافُوا وَلَا تَحْزَنُوا وَأَبْشِرُوا بِالْجَنَّةِ الَّتِي كُنتُمْ تُوعَدُونَ
            </div>
            
            <p><em>"Sesungguhnya orang-orang yang berkata: 'Tuhan kami ialah Allah' kemudian mereka meneguhkan pendirian mereka (istiqamah), maka malaikat-malaikat akan turun kepada mereka (dengan berkata): 'Janganlah kamu merasa takut dan janganlah kamu bersedih hati; dan bergembiralah kamu dengan memperoleh surga yang telah dijanjikan kepadamu'."</em></p>

            <p>Semoga Allah mengaruniakan kepada kita hati yang teguh di atas agama-Nya, amal yang ikhlas hanya mengharap ridha-Nya, serta akhir hidup yang husnul khatimah.</p>

            <div class="arabic-block text-right font-serif text-lg leading-loose text-slate-800 bg-white p-3 rounded-lg border border-emerald-100 my-2" dir="rtl">
                بَارَكَ اللّٰهُ لِيْ وَلَكُمْ فِي الْقُرْآنِ الْعَظِيْمِ، وَنَفَعَنِيْ وَإِيَّاكُمْ بِمَا فِيْهِ مِنَ الْآيَاتِ وَالذِّكْرِ الْحَكِيْمِ. أَقُوْلُ قَوْلِيْ هٰذَا وَأَسْتَغْفِرُ اللّٰهَ الْعَظِيْمَ لِيْ وَلَكُمْ وَلِسَائِرِ الْمُسْلِمِيْنَ، فَاسْتَغْفِرُوْهُ إِنَّهُ هُوَ الْغَفُوْرُ الرَّحِيْمُ.
            </div>
        </div>
    </div>

    <div class="khutbah-section khutbah-kedua bg-slate-50/70 p-6 rounded-2xl border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4 flex items-center">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mr-2"></span>
            KHUTBAH KEDUA
        </h3>

        <div class="arabic-block text-right font-serif text-xl leading-loose text-slate-900 bg-white p-4 rounded-xl border border-slate-200 mb-4 shadow-sm" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ حَمْدًا كَثِيْرًا كَمَا أَمَرَ. وَأَشْهَدُ أَنْ لَا إِلٰهَ إِلَّا اللّٰهُ وَحْدَهُ لَا شَرِيْكَ لَهُ إِرْغَامًا لِمَنْ جَحَدَ بِهِ وَكَفَرَ، وَأَشْهَدُ أَنَّ سَيِّدَنَا مُحَمَّدًا عَبْدُهُ وَرَسُوْلُهُ سَيِّدُ الْبَشَرِ.<br><br>
            اَللّٰهُمَّ صَلِّ وَسَلِّمْ عَلَى سَيِّدِنَا مُحَمَّدٍ وَعَلَى آلِهِ وَأَصْحَابِهِ مَا اتَّصَلَتْ عَيْنٌ بِنَظَرٍ وَأُذُنٌ بِخَبَرٍ.<br><br>
            أَمَّا بَعْدُ، فَيَا عِبَادَ اللّٰهِ، اِتَّقُوا اللّٰهَ تَعَالَى وَاعْلَمُوْا أَنَّ اللّٰهَ أَمَرَكُمْ بِأَمْرٍ بَدَأَ فِيْهِ بِنَفْسِهِ وَثَنَّى بِمَلَائِكَتِهِ الْمُسَبِّحَةِ بِقُدْسِهِ، فَقَالَ تَعَالَى: <strong>إِنَّ اللَّهَ وَمَلَائِكَتَهُ يُصَلُّونَ عَلَى النَّبِيِّ يَا أَيُّهَا الَّذِينَ آمَنُوا صَلُّوا عَلَيْهِ وَسَلِّمُوا تَسْلِيمًا</strong>
        </div>

        <div class="arabic-block text-right font-serif text-lg leading-loose text-emerald-950 bg-emerald-50/80 p-5 rounded-xl border border-emerald-200 my-4" dir="rtl">
            اَللّٰهُمَّ صَلِّ عَلَى سَيِّدِنَا مُحَمَّدٍ وَعَلَى آلِ سَيِّدِنَا مُحَمَّدٍ.<br><br>
            اَللّٰهُمَّ اغْفِرْ لِلْمُسْلِمِيْنَ وَالْمُسْلِمَاتِ، وَالْمُؤْمِنِيْنَ وَالْمُؤْمِنَاتِ، اَلْأَحْيَاءِ مِنْهُمْ وَالْأَمْوَاتِ، إِنَّكَ سَمِيْعٌ قَرِيْبٌ مُجِيْبُ الدَّعَوَاتِ يَا قَاضِيَ الْحَاجَاتِ.<br><br>
            رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ.<br><br>
            عِبَادَ اللّٰهِ، إِنَّ اللّٰهَ يَأْمُرُ بِالْعَدْلِ وَالْإِحْسَانِ وَإِيْتَاءِ ذِي الْقُرْبَى وَيَنْهَى عَنِ الْفَحْشَاءِ وَالْمُنْكَرِ وَالْبَغْيِ، يَعِظُكُمْ لَعَلَّكُمْ تَذَكَّرُوْنَ. فَاذْكُرُوا اللّٰهَ الْعَظِيْمَ يَذْكُرْكُمْ، وَاشْكُرُوْهُ عَلَى نِعَمِهِ يَزِدْكُمْ، وَلَذِكْرُ اللّٰهِ أَكْبَرُ!
        </div>
    </div>
</div>
HTML,
            ],
            [
                'title' => 'Berbakti Kepada Orang Tua (Birrul Walidain): Pintu Surga Paling Tengah dan Rahasia Keberkahan',
                'slug' => 'berbakti-kepada-orang-tua-birrul-walidain',
                'author_name' => 'Ustadz H. Abdul Muta\'ali, M.Pd.',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'tags' => ['keluarga', 'akhlak', 'birrul-walidain'],
                'excerpt' => 'Naskah khutbah yang mengupas tuntas keagungan hak ibu dan bapak, serta ancaman durhaka (uququl walidain) bagi kelangsungan hidup seorang hamba di dunia dan akhirat.',
                'published_at' => Carbon::now()->subDays(7),
                'content' => <<<'HTML'
<div class="khutbah-container space-y-6">
    <div class="khutbah-section khutbah-pertama bg-emerald-50/40 p-6 rounded-2xl border border-emerald-100">
        <h3 class="text-lg font-bold text-[#006e30] border-b border-emerald-200 pb-2 mb-4">KHUTBAH PERTAMA</h3>
        <div class="arabic-block text-right font-serif text-xl sm:text-2xl leading-loose text-slate-900 bg-white p-5 rounded-xl border border-emerald-100 mb-4" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ الَّذِيْ قَضَى أَلَّا نَعْبُدَ إِلَّا إِيَّاهُ وَبِالْوَالِدَيْنِ إِحْسَانًا. أَشْهَدُ أَنْ لَا إِلٰهَ إِلَّا اللّٰهُ الْكَرِيْمُ الْمَنَّانُ، وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُوْلُهُ سَيِّدُ وَلَدِ عَدْنَانَ.<br><br>
            اَللّٰهُمَّ صَلِّ وَسَلِّمْ عَلَى نَبِيِّنَا مُحَمَّدٍ، وَعَلَى آلِهِ وَصَحْبِهِ أَهْلِ الْفَضْلِ وَالْإِحْسَانِ.<br><br>
            أَمَّا بَعْدُ، فَيَا عِبَادَ اللّٰهِ، اِتَّقُوا اللّٰهَ حَقَّ تُقَاتِهِ، وَرَاقِبُوْهُ فِي السِّرِّ وَالْعَلَنِ.
        </div>
        <div class="khutbah-body text-slate-800 space-y-4 text-justify leading-relaxed">
            <p><strong>Kaum Muslimin Sidang Shalat Jum'at yang Dimuliakan Allah,</strong></p>
            <p>Dalam syariat Islam yang agung, kedudukan kedua orang tua diletakkan pada posisi yang amat luhur. Bahkan Allah Subhanahu wa Ta'ala menggandengkan perintah beribadah kepada-Nya dengan perintah berbakti kepada kedua orang tua:</p>
            <blockquote class="bg-white p-4 rounded-xl border-l-4 border-amber-500 my-3 text-slate-700">
                <em>"Dan Tuhanmu telah memerintahkan supaya kamu jangan menyembah selain Dia dan hendaklah kamu berbuat baik pada ibu bapakmu dengan sebaik-baiknya..."</em> (QS. Al-Isra: 23).
            </blockquote>
            <p>Ibu telah mengandung kita dalam kepayahan yang bertambah-tambah, melahirkan dengan taruhan nyawa, dan menyusui siang malam tanpa lelah. Ayah membanting tulang memeras keringat di bawah terik matahari demi memastikan seteguk air dan sesuap nasi halal masuk ke tenggorokan kita.</p>
            <p>Rasulullah SAW bersabda: <em>"Keridhaan Allah ada pada keridhaan kedua orang tua, dan kemurkaan Allah ada pada kemurkaan kedua orang tua."</em> (HR. Tirmidzi).</p>
        </div>
    </div>

    <div class="khutbah-section khutbah-kedua bg-slate-50/70 p-6 rounded-2xl border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">KHUTBAH KEDUA</h3>
        <div class="arabic-block text-right font-serif text-xl leading-loose text-slate-900 bg-white p-4 rounded-xl border border-slate-200 mb-4" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ رَبِّ الْعَالَمِيْنَ، وَالصَّلَاةُ وَالسَّلَامُ عَلَى رَسُوْلِ اللّٰهِ الصَّادِقِ الْأَمِيْنِ.<br><br>
            اَللّٰهُمَّ اغْفِرْ لِآبَائِنَا وَأُمَّهَاتِنَا، وَارْحَمْهُمْ كَمَا رَبَّوْنَا صِغَارًا.<br><br>
            رَبَّنَا هَبْ لَنَا مِنْ أَزْوَاجِنَا وَذُرِّيَّاتِنَا قُرَّةَ أَعْيُنٍ وَاجْعَلْنَا لِلْمُتَّقِينَ إِمَامًا.
        </div>
    </div>
</div>
HTML,
            ],
            [
                'title' => 'Urgensi Menuntut Ilmu Syar\'i dan Penguatan Adab Generasi Santri Masa Kini',
                'slug' => 'urgensi-menuntut-ilmu-syari-dan-adab-santri',
                'author_name' => 'Dewan Asatidz PPRU Sakatiga',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'tags' => ['ibadah', 'akhlak', 'santri'],
                'excerpt' => 'Menjadikan adab mendahului ilmu sebagai fondasi utama pendidikan karakter pesantren dalam membentengi moralitas anak bangsa di era digital.',
                'published_at' => Carbon::now()->subDays(14),
                'content' => <<<'HTML'
<div class="khutbah-container space-y-6">
    <div class="khutbah-section khutbah-pertama bg-emerald-50/40 p-6 rounded-2xl border border-emerald-100">
        <h3 class="text-lg font-bold text-[#006e30] border-b border-emerald-200 pb-2 mb-4">KHUTBAH PERTAMA</h3>
        <div class="arabic-block text-right font-serif text-xl leading-loose text-slate-900 bg-white p-5 rounded-xl border border-emerald-100 mb-4" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ الَّذِيْ رَفَعَ الَّذِيْنَ آمَنُوا وَالَّذِيْنَ أُوْتُوا الْعِلْمَ دَرَجَاتٍ. أَشْهَدُ أَنْ لَا إِلٰهَ إِلَّا اللّٰهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُوْلُهُ مُعَلِّمُ الْبَشَرِيَّةِ. أَمَّا بَعْدُ، فَيَا عِبَادَ اللّٰهِ، اِتَّقُوا اللّٰهَ حَقَّ تُقَاتِهِ.
        </div>
        <div class="khutbah-body text-slate-800 space-y-4 text-justify leading-relaxed">
            <p><strong>Jamaah Shalat Jum'at yang Berbahagia,</strong></p>
            <p>Di era kelimpahan informasi saat ini, ilmu sangat mudah diakses lewat layar sentuh telepon pintar. Namun pertanyaannya, mengapa keberkahan ilmu seakan memudar? Para ulama salaf terdahulu telah berpesan: <em>"Pelajarilah adab sebelum engkau mempelajari ilmu."</em></p>
            <p>Imam Malik rahimahullah berpesan kepada seorang pemuda Quraisy: <em>"Pelajarilah adab sebelum engkau mempelajari suatu ilmu pengetahuan."</em> Tanpa adab dan rasa hormat kepada guru serta kitab-kitab suci, ilmu hanya akan melahirkan kesombongan intelektual yang membinasakan.</p>
        </div>
    </div>
    <div class="khutbah-section khutbah-kedua bg-slate-50/70 p-6 rounded-2xl border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">KHUTBAH KEDUA</h3>
        <div class="arabic-block text-right font-serif text-lg leading-loose text-slate-900 bg-white p-4 rounded-xl" dir="rtl">
            اَللّٰهُمَّ انْفَعْنَا بِمَا عَلَّمْتَنَا وَعَلِّمْنَا مَا يَنْفَعُنَا وَزِدْنَا عِلْمًا، وَأَصْلِحْ لَنَا شَأْنَنَا كُلَّهُ.
        </div>
    </div>
</div>
HTML,
            ],
            [
                'title' => 'Hakikat Syukur Nikmat dan Menjaga Amanah Usia di Dunia',
                'slug' => 'hakikat-syukur-nikmat-dan-menjaga-amanah-usia',
                'author_name' => 'Ustadz Ridwan Al-Hafidz',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'tags' => ['aqidah', 'ibadah'],
                'excerpt' => 'Memahami tiga rukun syukur: pengakuan dalam hati, pujian melalui lisan, dan pembuktian ketaatan melalui anggota badan sebelum datangnya ajal.',
                'published_at' => Carbon::now()->subDays(21),
                'content' => <<<'HTML'
<div class="khutbah-container space-y-6">
    <div class="khutbah-section khutbah-pertama bg-emerald-50/40 p-6 rounded-2xl border border-emerald-100">
        <h3 class="text-lg font-bold text-[#006e30] border-b border-emerald-200 pb-2 mb-4">KHUTBAH PERTAMA</h3>
        <div class="arabic-block text-right font-serif text-xl leading-loose text-slate-900 bg-white p-5 rounded-xl border border-emerald-100 mb-4" dir="rtl">
            اَلْحَمْدُ لِلّٰهِ الشَّكُوْرِ، اَلَّذِيْ وَعَدَ الشَّاكِرِيْنَ بِالْمَزِيْدِ. أَشْهَدُ أَنْ لَا إِلٰهَ إِلَّا اللّٰهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا عَبْدُهُ وَرَسُوْلُهُ. أَمَّا بَعْدُ، فَيَا عِبَادَ اللّٰهِ، اِتَّقُوا اللّٰهَ حَقَّ تُقَاتِهِ.
        </div>
        <div class="khutbah-body text-slate-800 space-y-4 text-justify leading-relaxed">
            <p><strong>Kaum Muslimin yang Dirahmati Allah,</strong></p>
            <p>Allah Ta'ala telah menegaskan dalam firman-Nya:</p>
            <blockquote class="bg-white p-4 rounded-xl border-l-4 border-emerald-600 my-3 text-slate-700 italic">
                <em>"Dan (ingatlah juga), tatkala Tuhanmu memaklumkan: 'Sesungguhnya jika kamu bersyukur, pasti Kami akan menambah (nikmat) kepadamu, dan jika kamu mengingkari (nikmat-Ku), maka sesungguhnya azab-Ku sangat pedih'."</em> (QS. Ibrahim: 7).
            </blockquote>
            <p>Syukur hakiki bukan sebatas ucapan Alhamdulillah di bibir, melainkan mempergunakan setiap tetes nikmat umur, harta, kesehatan, dan keluarga untuk mendekatkan diri kepada Sang Pemberi Nikmat.</p>
        </div>
    </div>
    <div class="khutbah-section khutbah-kedua bg-slate-50/70 p-6 rounded-2xl border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">KHUTBAH KEDUA</h3>
        <div class="arabic-block text-right font-serif text-lg leading-loose text-slate-900 bg-white p-4 rounded-xl" dir="rtl">
            اَللّٰهُمَّ أَعِنَّا عَلَى ذِكْرِكَ وَشُكْرِكَ وَحُسْنِ عِبَادَتِكَ. رَبَّنَا تَقَبَّلْ مِنَّا إِنَّكَ أَنْتَ السَّمِيْعُ الْعَلِيْمُ.
        </div>
    </div>
</div>
HTML,
            ],
            [
                'title' => 'Khutbah Idul Fitri: Merajut Tali Ukhuwah Islamiyah dan Menjaga Kesucian Jiwa Pasca Ramadhan',
                'slug' => 'khutbah-idul-fitri-merajut-ukhuwah-islamiyah',
                'author_name' => 'KH. Tol\'at Wafa Ahmad, Lc.',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'tags' => ['hari-raya', 'akhlak', 'keluarga'],
                'excerpt' => 'Naskah khutbah Idul Fitri yang mengetuk pintu sanubari: saling memaafkan sesama kerabat, mengikis dendam, dan mempertahankan grafik ibadah usai bulan suci Ramadhan.',
                'published_at' => Carbon::now()->subDays(30),
                'content' => <<<'HTML'
<div class="khutbah-container space-y-6">
    <div class="khutbah-section khutbah-pertama bg-emerald-50/40 p-6 rounded-2xl border border-emerald-100">
        <h3 class="text-lg font-bold text-[#006e30] border-b border-emerald-200 pb-2 mb-4">KHUTBAH PERTAMA IDUL FITRI</h3>
        <div class="arabic-block text-right font-serif text-xl leading-loose text-slate-900 bg-white p-5 rounded-xl border border-emerald-100 mb-4" dir="rtl">
            اَللّٰهُ أَكْبَرُ، اَللّٰهُ أَكْبَرُ، اَللّٰهُ أَكْبَرُ (٩×)<br><br>
            اَللّٰهُ أَكْبَرُ كَبِيْرًا، وَالْحَمْدُ لِلّٰهِ كَثِيْرًا، وَسُبْحَانَ اللّٰهِ بُكْرَةً وَأَصِيْلًا. لَا إِلٰهَ إِلَّا اللّٰهُ وَلَا نَعْبُدُ إِلَّا إِيَّاهُ مُخْلِصِيْنَ لَهُ الدِّيْنَ وَلَوْ كَرِهَ الْكَافِرُوْنَ.<br><br>
            أَمَّا بَعْدُ، فَيَا أَيُّهَا الْمُسْلِمُوْنَ وَالْمُسْلِمَاتُ، اِتَّقُوا اللّٰهَ حَقَّ تُقَاتِهِ وَاشْكُرُوْهُ عَلَى مَا هَدَاكُمْ لَعَلَّكُمْ تَشْكُرُوْنَ.
        </div>
        <div class="khutbah-body text-slate-800 space-y-4 text-justify leading-relaxed">
            <p><strong>Allahu Akbar, Allahu Akbar, Allahu Akbar wa Lillahil Hamd,</strong></p>
            <p>Pagi hari ini gema takbir, tahmid, dan tahlil berkumandang di seluruh pelosok bumi, menggetarkan arasy dan mengagungkan asma Allah Subhanahu wa Ta'ala. Kita merayakan kemenangan bukan dengan pesta pora kesombongan, melainkan dengan sujud syukur dan kerendahan hati.</p>
            <p>Mari kita rengkuh kedua tangan orang tua kita, tatap wajah mereka dengan cinta dan permohonan maaf setulus jiwa. Sambunglah silaturahmi yang sempat renggang, rekatkan ukhuwah Islamiyah di antara sanak saudara dan tetangga.</p>
        </div>
    </div>
    <div class="khutbah-section khutbah-kedua bg-slate-50/70 p-6 rounded-2xl border border-slate-200">
        <h3 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2 mb-4">KHUTBAH KEDUA IDUL FITRI</h3>
        <div class="arabic-block text-right font-serif text-lg leading-loose text-slate-900 bg-white p-4 rounded-xl" dir="rtl">
            اَللّٰهُ أَكْبَرُ (٧×) وَلِلّٰهِ الْحَمْدُ.<br><br>
            اَللّٰهُمَّ اجْعَلْنَا مِنَ الْعَائِدِيْنَ وَالْفَائِزِيْنَ وَالْمَقْبُوْلِيْنَ، كُلُّ عَامٍ وَأَنْتُمْ بِخَيْرٍ.
        </div>
    </div>
</div>
HTML,
            ],
        ];

        foreach ($demoItems as $item) {
            $post = Post::firstOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'content' => $item['content'],
                    'excerpt' => $item['excerpt'],
                    'status' => 'publish',
                    'type' => 'post',
                    'featured_image' => $item['featured_image'],
                    'author_id' => $admin?->id,
                    'author_name' => $item['author_name'],
                    'published_at' => $item['published_at'],
                    'views_count' => rand(150, 950),
                    'is_featured' => Str::contains($item['title'], 'Istiqamah'),
                ]
            );

            // Hubungkan dengan kategori Khutbah
            $post->categories()->syncWithoutDetaching([$category->id]);

            // Hubungkan tags
            foreach ($item['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagName)],
                    ['name' => ucwords(str_replace('-', ' ', $tagName))]
                );
                $post->tags()->syncWithoutDetaching([$tag->id]);
            }
        }

        Log::info('KhutbahService: Berhasil men-seed demo naskah khutbah PPRU.');
    }
}
