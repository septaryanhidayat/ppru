<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        $downloads = [
            [
                'title' => 'Logo Resmi PKS (Dewan Pengurus Daerah Ogan Ilir)',
                'file_path' => '/uploads/2025/09/Logo-PKS.png',
                'file_type' => 'PNG',
                'category_type' => 'Aset Visual',
                'download_count' => 142,
            ],
            [
                'title' => 'Mars PKS (Orchestra)',
                'file_path' => '/uploads/2025/09/MARSPKSORCHESTRA.mp3',
                'file_type' => 'MP3',
                'category_type' => 'Audio',
                'download_count' => 389,
            ],
            [
                'title' => 'Hymne PKS (Orchestra)',
                'file_path' => '/uploads/2025/09/HYMNEPKSORCHESTRA.mp3',
                'file_type' => 'MP3',
                'category_type' => 'Audio',
                'download_count' => 275,
            ],
            [
                'title' => "E-Book Ma'rifatullah (17 Materi Tarbiyah)",
                'file_path' => '/uploads/2025/09/Ebook-Marifatullah.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 420,
            ],
            [
                'title' => "E-Book Ma'rifatul Qur'an (5 Materi Tarbiyah)",
                'file_path' => '/uploads/2025/09/Marifatul-Quran_MIK.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 365,
            ],
            [
                'title' => "E-Book Ghazwul Fikri (Perang Pemikiran)",
                'file_path' => '/uploads/2025/09/ghazwul-fikri_mik.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 298,
            ],
            [
                'title' => "E-Book Kurikulum Pembinaan Da'i Muda Tingkat 1",
                'file_path' => '/uploads/2025/09/Materi-Pembinaan-Dai-Muda-Tingkat-1.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 312,
            ],
            [
                'title' => "E-Book Al-Bidayah Wan Nihayah - Ibnu Katsir",
                'file_path' => '/uploads/2025/09/BidayahWanNihayah-IbnuKatsir.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 450,
            ],
            [
                'title' => "E-Book Adab Olahraga di Tempat Umum",
                'file_path' => '/uploads/2025/10/ADAB-OLAHRAGA-A6.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 195,
            ],
        ];

        DB::table('downloads')->truncate();

        foreach ($downloads as $dl) {
            DB::table('downloads')->insert([
                'title' => $dl['title'],
                'file_path' => $dl['file_path'],
                'file_type' => $dl['file_type'],
                'category_type' => $dl['category_type'],
                'download_count' => $dl['download_count'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
