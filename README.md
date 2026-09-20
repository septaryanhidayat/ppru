# Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga - Website Resmi

Website resmi profil dan portal informasi **Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga**, dibangun menggunakan Laravel 12 dan Tailwind CSS dengan arsitektur modern, responsif, dan dinamis berbasis CMS penuh.

## 🌿 Identitas & Tema
- **Warna Dominan**: Hijau PPRU (`#00913e` / `#00843d`)
- **Warna Aksen**: Emas / Kuning Keemasan (`#f59e0b` / `#d97706`)
- **Motto**: Berilmu Amaliah, Beramal Ilmiah, Berakhlakul Karimah.

## 🚀 Fitur Utama
1. **Beranda Interaktif (100% Dynamic CRUD)**:
   - Dynamic Hero Banner Slider (Judul, Subjudul, Gambar WebP, Tombol & Tautan)
   - Dynamic Navigation Menu (Header & Footer)
   - Video Profil Pesantren & Sambutan Mudir Pesantren
   - Trisula Keunggulan (Bahasa, Al-Qur'an, Kitab Kuning)
   - Statistik Santri, Asatidz, Alumni, & Penghafal Al-Qur'an
   - Program Unggulan Pesantren & Unit Pendidikan
   - Galeri Kegiatan 2-Row Slider & Prestasi Santri
   - Portal PSB Online & Infaq/Wakaf Pembangunan
   - Live Visitor Counter Real-Time
2. **Halaman Statis Dinamis (Full CMS)**:
   - Tentang Kami & Profil Pesantren
   - Visi, Misi, & Falsafah Hidup Pesantren
   - Sejarah Pendirian & Genealogi Ulama Pendiri
   - Struktur Organisasi & Majelis Pimpinan
   - Sambutan Mudir / Pimpinan Pondok
   - Kebijakan Privasi
3. **Portal Informasi & Download**:
   - Berita & Prestasi Santri
   - Kalender Agenda & Pengumuman
   - Unduhan Berkas & Brosur PSB Online
4. **PSB & Infaq/Wakaf**:
   - Formulir & Alur Pendaftaran Santri Baru (PSB)
   - Kanal Donasi & Infaq Pengembangan Sarana Pesantren

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
Dikelola dengan bangga oleh **Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga**.
