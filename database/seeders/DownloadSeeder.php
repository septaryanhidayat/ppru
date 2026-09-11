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
                'title' => 'Logo Resmi SMA IT Plus Robbani (Vector SVG & PNG)',
                'file_path' => '/uploads/logo-robbani.png',
                'file_type' => 'PNG',
                'category_type' => 'Aset Visual',
                'download_count' => 520,
            ],
            [
                'title' => 'Mars SMA IT Plus Robbani (Paduan Suara & Orkestra)',
                'file_path' => '/uploads/mars-robbani.mp3',
                'file_type' => 'MP3',
                'category_type' => 'Audio',
                'download_count' => 480,
            ],
            [
                'title' => 'Hymne Robbani - Membina Generasi Qur\'ani',
                'file_path' => '/uploads/hymne-robbani.mp3',
                'file_type' => 'MP3',
                'category_type' => 'Audio',
                'download_count' => 395,
            ],
            [
                'title' => 'Brosur & Panduan Pendaftaran PPDB TP 2026/2027',
                'file_path' => '/uploads/panduan-ppdb-robbani.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 840,
            ],
            [
                'title' => 'Buku Panduan Kurikulum Tahfidz Mutqin 30 Juz',
                'file_path' => '/uploads/panduan-tahfidz-robbani.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 650,
            ],
            [
                'title' => 'Modul Praktikum Laboratorium Sains Terpadu SMA',
                'file_path' => '/uploads/modul-sains-robbani.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 512,
            ],
            [
                'title' => 'Pedoman Karakter, Adab & Tata Tertib Santri Boarding',
                'file_path' => '/uploads/pedoman-adab-santri.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 430,
            ],
            [
                'title' => 'Silabus Program Riset & Olimpiade Sains (OSN) Robbani',
                'file_path' => '/uploads/silabus-olimpiade-robbani.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 380,
            ],
            [
                'title' => 'Panduan Ekstrakurikuler Robotika, Coding & IoT Santri',
                'file_path' => '/uploads/panduan-robotika-robbani.pdf',
                'file_type' => 'PDF',
                'category_type' => 'E-Book',
                'download_count' => 290,
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
