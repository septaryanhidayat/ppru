<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DpcSeeder extends Seeder
{
    public function run(): void
    {
        $dpcsData = [
            [
                'name' => 'DPC PKS Indralaya',
                'slug' => 'dpc-pks-indralaya',
                'head_name' => 'Ustadz H. Ahmad Ridwan, S.Pd.I',
                'address' => 'Jl. Lintas Timur KM 35, Indralaya Mulya, Kec. Indralaya, Kab. Ogan Ilir',
                'description' => 'DPC PKS Indralaya merupakan sentra koordinasi kepengurusan tingkat kecamatan di pusat ibukota Kabupaten Ogan Ilir. Berfokus pada pelayanan advokasi warga, pengawalan kebijakan publik, program Jumat Berkah rutin, serta pembinaan generasi muda dan keluarga tangguh.',
                'order' => 1,
            ],
            [
                'name' => 'DPC PKS Indralaya Utara',
                'slug' => 'dpc-pks-indralaya-utara',
                'head_name' => 'Ust. Syarif Hidayatullah',
                'address' => 'Kel. Timbangan / Lorok, Kec. Indralaya Utara, Kab. Ogan Ilir',
                'description' => 'DPC PKS Indralaya Utara aktif menggerakkan pemberdayaan ekonomi masyarakat pedesaan, sektor pertanian pangan, serta penyelenggaraan layanan pemeriksaan kesehatan gratis dan tanggap darurat warga.',
                'order' => 2,
            ],
            [
                'name' => 'DPC PKS Indralaya Selatan',
                'slug' => 'dpc-pks-indralaya-selatan',
                'head_name' => 'Ust. M. Zulkifli, S.E',
                'address' => 'Desa Meranjat, Kec. Indralaya Selatan, Kab. Ogan Ilir',
                'description' => 'DPC PKS Indralaya Selatan giat menyelenggarakan pembinaan keagamaan, olahraga pemuda, pendampingan petani lokal, dan program santunan yatim dhuafa di wilayah Indralaya Selatan.',
                'order' => 3,
            ],
            [
                'name' => 'DPC PKS Tanjung Raja',
                'slug' => 'dpc-pks-tanjung-raja',
                'head_name' => 'Ust. Drs. Rusli Nawawi',
                'address' => 'Jl. Pasar Baru Tanjung Raja, Kec. Tanjung Raja, Kab. Ogan Ilir',
                'description' => 'DPC PKS Tanjung Raja menjadi salah satu simpul khidmat masyarakat terbesar dengan fokus pada advokasi pedagang pasar tradisional, pembinaan UMKM kuliner dan kerajinan, serta layanan mobil siaga warga.',
                'order' => 4,
            ],
            [
                'name' => 'DPC PKS Tanjung Batu',
                'slug' => 'dpc-pks-tanjung-batu',
                'head_name' => 'Ust. Baihaqi, S.Kom',
                'address' => 'Kel. Tanjung Batu, Kec. Tanjung Batu, Kab. Ogan Ilir',
                'description' => 'DPC PKS Tanjung Batu aktif mendampingi para pengrajin pandai besi dan perak tradisional khas Tanjung Batu, mengokohkan konsolidasi ranting (DPRa), serta menyelenggarakan pendidikan baca Al-Qur\'an untuk anak-anak.',
                'order' => 5,
            ],
            [
                'name' => 'DPC PKS Payaraman',
                'slug' => 'dpc-pks-payaraman',
                'head_name' => 'Ust. Hasan Basri',
                'address' => 'Jl. Raya Payaraman, Kec. Payaraman, Kab. Ogan Ilir',
                'description' => 'DPC PKS Payaraman berkomitmen melayani masyarakat pekebun karet dan sawit rakyat, memperjuangkan stabilisasi harga hasil bumi, dan mendampingi kelompok majelis taklim ibu-ibu.',
                'order' => 6,
            ],
            [
                'name' => 'DPC PKS Pemulutan',
                'slug' => 'dpc-pks-pemulutan',
                'head_name' => 'Ust. Fauzi Usman, S.Pd',
                'address' => 'Desa Ibul Besar / Pemulutan Ilir, Kec. Pemulutan, Kab. Ogan Ilir',
                'description' => 'DPC PKS Pemulutan berfokus melayani kawasan perairan dan rawa lebak dengan program advokasi nelayan tangkap, pemenuhan air bersih pedesaan, serta penanganan berkala luapan pasang surut.',
                'order' => 7,
            ],
            [
                'name' => 'DPC PKS Pemulutan Barat',
                'slug' => 'dpc-pks-pemulutan-barat',
                'head_name' => 'Ust. Muhammad Sholeh',
                'address' => 'Desa Talang Pangeran, Kec. Pemulutan Barat, Kab. Ogan Ilir',
                'description' => 'DPC PKS Pemulutan Barat menggiatkan program pembinaan ketahanan pangan keluarga, pelatihan wirausaha rumahan perempuan PKS, serta penyaluran bantuan sosial kemanusiaan.',
                'order' => 8,
            ],
            [
                'name' => 'DPC PKS Pemulutan Selatan',
                'slug' => 'dpc-pks-pemulutan-selatan',
                'head_name' => 'Ust. M. Ridho Ansori',
                'address' => 'Desa Sungai Keli, Kec. Pemulutan Selatan, Kab. Ogan Ilir',
                'description' => 'DPC PKS Pemulutan Selatan hadir sebagai mitra warga desa dalam mengawal bantuan bibit pertanian, kegiatan kepemudaan karang taruna, dan santunan pendidikan siswa kurang mampu.',
                'order' => 9,
            ],
            [
                'name' => 'DPC PKS Rantau Alai',
                'slug' => 'dpc-pks-rantau-alai',
                'head_name' => 'Ust. Syafei Harun',
                'address' => 'Desa Rantau Alai, Kec. Rantau Alai, Kab. Ogan Ilir',
                'description' => 'DPC PKS Rantau Alai konsisten melayani wilayah pedalaman dengan mengawal ketersediaan sarana jalan tani, lumbung pangan dhuafa, dan fasilitasi rujukan kesehatan darurat.',
                'order' => 10,
            ],
            [
                'name' => 'DPC PKS Rantau Panjang',
                'slug' => 'dpc-pks-rantau-panjang',
                'head_name' => 'Ust. K.H. Mansyur Syah',
                'address' => 'Desa Rantau Panjang Ilir, Kec. Rantau Panjang, Kab. Ogan Ilir',
                'description' => 'DPC PKS Rantau Panjang memperkuat silaturahim lintas tokoh agama dan adat, mengawal penanggulangan bencana banjir musiman, serta melayani pelatihan keahlian pemuda desa.',
                'order' => 11,
            ],
            [
                'name' => 'DPC PKS Sungai Pinang',
                'slug' => 'dpc-pks-sungai-pinang',
                'head_name' => 'Ust. Abdullah Faqih',
                'address' => 'Desa Sungai Pinang Jaya, Kec. Sungai Pinang, Kab. Ogan Ilir',
                'description' => 'DPC PKS Sungai Pinang membina para pengrajin anyaman purun dan rotan khas Ogan Ilir, serta rutin mengadakan cek kesehatan dan pengajian akbar warga di pelosok desa.',
                'order' => 12,
            ],
            [
                'name' => 'DPC PKS Muara Kuang',
                'slug' => 'dpc-pks-muara-kuang',
                'head_name' => 'Ust. Hendra Gunawan, S.H',
                'address' => 'Kel. Muara Kuang, Kec. Muara Kuang, Kab. Ogan Ilir',
                'description' => 'DPC PKS Muara Kuang menjadi garda perkhidmatan di wilayah selatan Ogan Ilir yang mengawal aspirasi petani karet, perbaikan infrastruktur pedesaan, dan advokasi beasiswa santri.',
                'order' => 13,
            ],
            [
                'name' => 'DPC PKS Rambang Kuang',
                'slug' => 'dpc-pks-rambang-kuang',
                'head_name' => 'Ust. H. Subki Mansyur',
                'address' => 'Desa Tambang Rambang, Kec. Rambang Kuang, Kab. Ogan Ilir',
                'description' => 'DPC PKS Rambang Kuang berfokus pada pembinaan masyarakat berbasis perkebunan, advokasi hak pekerja perkebunan, serta penyediaan layanan sosial khidmat bencana alam.',
                'order' => 14,
            ],
            [
                'name' => 'DPC PKS Lubuk Keliat',
                'slug' => 'dpc-pks-lubuk-keliat',
                'head_name' => 'Ust. M. Darwin, S.Ag',
                'address' => 'Desa Betung, Kec. Lubuk Keliat, Kab. Ogan Ilir',
                'description' => 'DPC PKS Lubuk Keliat giat membangun sinergi bersama kelompok tani tebu dan karet, mendorong regenerasi kepemimpinan pemuda desa, dan memperkuat basis ketahanan keluarga.',
                'order' => 15,
            ],
            [
                'name' => 'DPC PKS Kandis',
                'slug' => 'dpc-pks-kandis',
                'head_name' => 'Ust. Zulkarnain, S.Pd',
                'address' => 'Desa Kandis I, Kec. Kandis, Kab. Ogan Ilir',
                'description' => 'DPC PKS Kandis mengabdi untuk masyarakat di ujung selatan Ogan Ilir dengan menyediakan bimbingan belajar anak, pendampingan petani kebun, dan kegiatan silaturahim akbar tahunan.',
                'order' => 16,
            ],
        ];

        DB::table('dpcs')->truncate();

        foreach ($dpcsData as $dpc) {
            DB::table('dpcs')->insert([
                'name' => $dpc['name'],
                'slug' => $dpc['slug'],
                'head_name' => $dpc['head_name'],
                'address' => $dpc['address'],
                'description' => $dpc['description'],
                'order' => $dpc['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
