# SMA IT Plus Robbani - Website Resmi Sekolah

Website resmi profil dan portal informasi **SMA IT Plus Robbani**, dibangun menggunakan Laravel 12 dan Tailwind CSS v4 dengan arsitektur modern, responsif, dan elegan.

## 🌿 Identitas & Tema
- **Warna Dominan**: Hijau Robbani (`#0d6b38` / `#15803d`)
- **Warna Sekunder**: Oranye Robbani (`#f97316` / `#ea580c`)
- **Visi**: Mewujudkan Generasi Qur'ani, Berakhlak Mulia, Unggul dalam Sains, Teknologi, dan Berwawasan Global.

## 🚀 Fitur Utama
1. **Beranda Interaktif**:
   - Hero Slider & Sambutan Kepala Sekolah
   - Quick Access Menu & Counter Statistik Akademik
   - Program Unggulan (Tahfidz, Sains & Riset, Bilingual English & Arabic, IT & Robotika)
   - Dewan Guru & Tenaga Kependidikan (GTK)
   - Galeri Kegiatan & Fasilitas Kampus
   - Berita & Pengumuman Resmi
   - Testimonial Wali Santri & Alumni
   - Live Visitor Counter (Pengunjung Online & Total Kunjungan)
2. **Halaman Profil Lengkap**:
   - Sambutan Kepala Sekolah
   - Profil Sekolah, Akreditasi, & Sarana Prasarana
   - Visi, Misi, & Tujuan Pendidikan
   - Sejarah Pendirian & Nilai Luhur
   - Struktur Organisasi & Pengelola
3. **Portal Informasi & Download**:
   - Modul Ajar & E-Book Siswa
   - Hymne & Mars Robbani
   - Pedoman & Panduan Akademik
   - Unduhan Logo Resmi & Pedoman Identitas Visual
4. **PPDB & Donasi**:
   - Alur & Formulir Konsultasi PPDB Online
   - Portal Infaq Pembangunan & Beasiswa Pendidikan Robbani

## 🛠️ Tech Stack
- **Framework Backend**: Laravel 12 (PHP 8.4)
- **Frontend / Styling**: Blade Components, Tailwind CSS v4, FontAwesome 6, Alpine.js
- **Database**: SQLite (Development) / MySQL / PostgreSQL (Production)
- **Testing**: Pest PHP (58 tests passed, 282 assertions)

## 💻 Instalasi Lokal

```bash
# Clone repository
git clone https://github.com/septaryanhidayat/school.git
cd school

# Install dependensi PHP & JavaScript
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi & Seeder Data Sekolah
php artisan migrate:fresh --seed

# Build asset frontend
npm run build

# Jalankan server lokal
php artisan serve
```

---
Dikelola dengan bangga oleh **SMA IT Plus Robbani**.
