# 🚀 Panduan Update & Deployment: Push ke GitHub & Pull di Terminal cPanel

Panduan resmi untuk mempublikasikan seluruh pembaruan sistem dinamis (CMS Halaman Statis, CRUD Beranda Penuh, Menu Navigasi Dinamis, Hero Banner Slider, dan Pembersihan Residu) ke repositori GitHub dan memperbarui server cPanel hosting secara langsung melalui Terminal.

---

## 💻 BAGIAN 1: Perintah di Terminal Lokal (Komputer / Laptop)

Jalankan perintah berikut di terminal komputer Anda (PowerShell, Command Prompt, atau Git Bash di direktori project `ppru`):

### 1. Cek Status Perubahan
```bash
git status
```

### 2. Tambahkan Semua File Baru dan yang Telah Diubah
```bash
git add .
```

### 3. Buat Commit Git
```bash
git commit -m "feat: implement full dynamic homepage & static pages CMS, dynamic nav menus, hero slider CRUD, and purge legacy residue"
```

### 4. Push ke Repositori GitHub
```bash
git push origin main
```
*(Catatan: Jika branch utama Anda bernama `master`, gunakan `git push origin master`)*

---

## 🌐 BAGIAN 2: Perintah di Terminal cPanel Hosting

Setelah berhasil di-push ke GitHub, login ke cPanel hosting Anda, lalu buka menu **Terminal** di dashboard cPanel dan jalankan langkah-langkah berikut:

### 1. Masuk ke Folder Project Website di cPanel
Sesuaikan path folder dengan letak instalasi website Anda di cPanel (misalnya `ppru` atau nama domain/subfolder Anda):
```bash
cd ~/ppru
```
*(atau jika diletakkan di root: `cd ~/public_html` atau sesuai path folder instalasi)*

### 2. Set Versi PHP (Jika Belum Default PHP 8.4)
```bash
alias php='/usr/local/bin/ea-php84'
```

### 3. Tarik (Pull) Pembaruan dari GitHub
```bash
git pull origin main
```
*(Atau jika branch `master`: `git pull origin master`)*

### 4. Jalankan Migrasi Database Otomatis
Laravel akan secara otomatis membuat tabel `hero_slides`, `nav_menus`, mengisi data awal beranda dinamis, dan membersihkan residu data lama:
```bash
php artisan migrate --force
```

### 5. Bersihkan & Optimasi Cache Laravel
Jalankan satu baris perintah berikut untuk memastikan seluruh view Blade, route, dan konfigurasi baru langsung aktif:
```bash
php artisan optimize:clear
php artisan storage:link
php artisan optimize
```

---

## 🗄️ BAGIAN 3: Alternatif Update Database via phpMyAdmin cPanel (Opsional)

Jika Anda tidak menjalankan `php artisan migrate` di terminal cPanel, Anda dapat menerapkan perubahan struktur dan data database langsung melalui phpMyAdmin:

1. Buka cPanel dan masuk ke menu **phpMyAdmin**.
2. Pilih database website PPRU Anda di bilah sisi kiri.
3. Klik tab **Import** (Impor) di menu atas.
4. Klik tombol **Choose File** (Pilih Berkas) dan pilih file:
   `database/cpanel_update_2026_ppru.sql`
5. Gulir ke bawah dan klik tombol **Import** / **Go** (Kirim).
6. Selesai! Semua tabel baru (`hero_slides`, `nav_menus`), data menu navigasi, dan pengaturan beranda dinamis telah terpasang rapi.

---

## 🔐 Verifikasi & Akses Dashboard Admin

Setelah langkah di atas selesai:
1. Buka website: `https://domain-anda.com`
2. Login ke dashboard admin: `https://domain-anda.com/login`
3. Menu baru yang siap digunakan di sidebar admin:
   - **Banner Hero Slider**: Kelola foto, judul, subtitle, tombol & link slider utama beranda.
   - **Menu Navigasi Web**: Kelola urutan, nama menu, submenu dropdown, dan link menu header maupun footer.
   - **Program Unggulan**: Kelola program unggulan santri.
   - **Halaman Statis**: Kelola isi konten Tentang Kami, Visi Misi, Sejarah, Struktur Organisasi, Sambutan Mudir, Kebijakan Privasi, dan tambah halaman baru.
   - **Pengaturan Website**:
     * Bagian 6 (Konten Beranda): Atur 3 kartu Trisula Keunggulan, 4 Statistik Counter, Sambutan Mudir Beranda, Spotlight PSB, dan Kanal Infaq/Wakaf.
