-- ==============================================================================
-- PONDOK PESANTREN RAUDHATUL ULUM (PPRU) SAKATIGA
-- SCRIPT UPDATE DATABASE CPANEL (MYSQL 5.7+ / MYSQL 8.0+ / MARIADB 10.3+)
-- Tanggal: 2026-09-20
-- Deskripsi:
-- 1. Pembuatan tabel `hero_slides` (CRUD Banner Slider Beranda)
-- 2. Pembuatan tabel `nav_menus` (CRUD Menu Navigasi Header & Footer)
-- 3. Pembersihan residu data lama (DPD, Robbani, Ishum, Ishlahul Ummah)
-- 4. Pengisian data awal konten dinamis beranda & menu navigasi PPRU
-- ==============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- 1. TABEL: hero_slides
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `hero_slides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `badge` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 2. TABEL: nav_menus
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `nav_menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'header',
  `order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nav_menus_parent_id_foreign` (`parent_id`),
  CONSTRAINT `nav_menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `nav_menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. PEMBERSIHAN RESIDU NAMA ORGANISASI/SEKOLAH LAMA (DPD, Robbani, Ishum, Ishlahul Ummah)
-- ------------------------------------------------------------------------------
DELETE FROM `settings` 
WHERE `key` LIKE '%robbani%' 
   OR `key` LIKE '%ishum%' 
   OR `value` LIKE '%robbani%' 
   OR `value` LIKE '%ishlahul ummah%';

UPDATE `settings` SET `value` = 'Pondok Pesantren Raudhatul Ulum Sakatiga' 
WHERE `key` = 'site_name' AND (`value` LIKE '%Robbani%' OR `value` LIKE '%Ishlahul%');

UPDATE `settings` SET `value` = 'Official Website Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir, Sumatera Selatan.' 
WHERE `key` = 'site_description' AND (`value` LIKE '%Robbani%' OR `value` LIKE '%Ishlahul%');

UPDATE `settings` SET `value` = 'sekretariat@ppru.ac.id' 
WHERE `key` = 'contact_email' AND (`value` LIKE '%robbani%' OR `value` LIKE '%ishlahul%');

UPDATE `unit_pendidikans` SET `thumbnail` = '/images/hero-1.webp' 
WHERE `thumbnail` LIKE '%robbani%' OR `thumbnail` LIKE '%ishum%';

UPDATE `posts` SET `featured_image` = '/images/hero-1.webp' 
WHERE `featured_image` LIKE '%robbani%' OR `featured_image` LIKE '%ishum%';

-- ------------------------------------------------------------------------------
-- 4. INSERT DATA AWAL HERO SLIDES (Jika Masih Kosong)
-- ------------------------------------------------------------------------------
INSERT INTO `hero_slides` (`id`, `badge`, `title`, `subtitle`, `image`, `button_text_1`, `button_url_1`, `button_text_2`, `button_url_2`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 1, 'Pondok Pesantren Raudhatul Ulum Sakatiga', 'Mencetak Generasi Ulama, Pemimpin, & Intelektual Muslim Berakhlakul Karimah', 'Pendidikan pesantren modern terpadu dengan kedalaman kitab kuning, hafalan Al-Qur\'an 30 Juz mutqin, dan kecakapan dwibahasa Arab & Inggris aktif.', '/images/hero-1.webp', 'Daftar Santri Baru (PSB)', 'https://santri.ppru.ac.id', 'Jelajahi Profil Pondok', '/tentang-kami', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `hero_slides` WHERE `id` = 1);

INSERT INTO `hero_slides` (`id`, `badge`, `title`, `subtitle`, `image`, `button_text_1`, `button_url_1`, `button_text_2`, `button_url_2`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 2, 'Pusat Keunggulan Islam Sumatera Selatan', 'Perpaduan Turots Kitab Kuning, Tahfidzul Qur\'an, & Sains Modern', 'Membina ribuan santri dari seluruh penjuru nusantara dalam suasana asri, disiplin 24 jam, dan penuh kekeluargaan.', '/images/hero-2.webp', 'Unit Pendidikan', '/pendidikan', 'Program Unggulan', '/program-unggulan', 2, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `hero_slides` WHERE `id` = 2);

INSERT INTO `hero_slides` (`id`, `badge`, `title`, `subtitle`, `image`, `button_text_1`, `button_url_1`, `button_text_2`, `button_url_2`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 3, 'Penerimaan Santri Baru', 'Pendaftaran Santri Baru (PSB) Tahun Ajaran Resmi Dibuka', 'Mari bergabung bersama keluarga besar Pondok Pesantren Raudhatul Ulum Sakatiga. Kuota terbatas untuk setiap jenjang pendidikan.', '/images/hero-3.webp', 'Daftar Sekarang', 'https://santri.ppru.ac.id', 'Informasi PSB', '/informasi/brosur-psb', 3, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `hero_slides` WHERE `id` = 3);

-- ------------------------------------------------------------------------------
-- 5. INSERT DATA AWAL MENU NAVIGASI HEADER & FOOTER (Jika Masih Kosong)
-- ------------------------------------------------------------------------------
INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 1, 'Beranda', '/', '_self', 'fa-solid fa-house', NULL, 'header', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 1);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 2, 'Profil Pondok', '#', '_self', 'fa-solid fa-mosque', NULL, 'header', 2, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 2);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 3, 'Unit Pendidikan', '/pendidikan', '_self', 'fa-solid fa-graduation-cap', NULL, 'header', 3, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 3);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 4, 'Program Unggulan', '/program-unggulan', '_self', 'fa-solid fa-star', NULL, 'header', 4, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 4);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 5, 'Berita & Info', '#', '_self', 'fa-solid fa-newspaper', NULL, 'header', 5, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 5);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 6, 'PSB Online', 'https://santri.ppru.ac.id', '_blank', 'fa-solid fa-user-plus', NULL, 'header', 6, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 6);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 7, 'Hubungi Kami', '/hubungi', '_self', 'fa-solid fa-phone', NULL, 'header', 7, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 7);

-- Submenu Profil Pondok
INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 8, 'Tentang PPRU', '/tentang-kami', '_self', 'fa-solid fa-circle-info', 2, 'header', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 8);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 9, 'Visi & Misi', '/visi-dan-misi', '_self', 'fa-solid fa-bullseye', 2, 'header', 2, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 9);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 10, 'Sejarah Pendirian', '/sejarah', '_self', 'fa-solid fa-clock-rotate-left', 2, 'header', 3, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 10);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 11, 'Struktur Organisasi', '/struktur-organisasi', '_self', 'fa-solid fa-sitemap', 2, 'header', 4, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 11);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 12, 'Sambutan Mudir Pondok', '/sambutan', '_self', 'fa-solid fa-comment-dots', 2, 'header', 5, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 12);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 13, 'Dewan Asatidz / Guru', '/dewan-guru', '_self', 'fa-solid fa-chalkboard-user', 2, 'header', 6, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 13);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 14, 'Sarana & Fasilitas', '/fasilitas', '_self', 'fa-solid fa-building-columns', 2, 'header', 7, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 14);

-- Submenu Berita & Info
INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 15, 'Berita Pesantren', '/artikel', '_self', 'fa-solid fa-newspaper', 5, 'header', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 15);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 16, 'Prestasi Santri', '/prestasi', '_self', 'fa-solid fa-trophy', 5, 'header', 2, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 16);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 17, 'Agenda & Kegiatan', '/agenda', '_self', 'fa-solid fa-calendar-days', 5, 'header', 3, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 17);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 18, 'Pengumuman Resmi', '/pengumuman', '_self', 'fa-solid fa-bullhorn', 5, 'header', 4, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 18);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 19, 'Galeri Dokumentasi', '/galeri', '_self', 'fa-solid fa-images', 5, 'header', 5, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 19);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 20, 'Kanal Infaq & Wakaf', '/donasi', '_self', 'fa-solid fa-hand-holding-heart', 5, 'header', 6, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 20);

-- Footer Menus
INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 21, 'Tentang Pondok PPRU', '/tentang-kami', '_self', NULL, NULL, 'footer', 1, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 21);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 22, 'Visi & Misi Pondok', '/visi-dan-misi', '_self', NULL, NULL, 'footer', 2, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 22);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 23, 'Unit-Unit Pendidikan', '/pendidikan', '_self', NULL, NULL, 'footer', 3, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 23);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 24, 'Program Unggulan', '/program-unggulan', '_self', NULL, NULL, 'footer', 4, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 24);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 25, 'Pendaftaran PSB Online', 'https://santri.ppru.ac.id', '_blank', NULL, NULL, 'footer', 5, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 25);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 26, 'Infaq & Wakaf Pesantren', '/donasi', '_self', NULL, NULL, 'footer', 6, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 26);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 27, 'Kebijakan Privasi', '/kebijakan-privasi', '_self', NULL, NULL, 'footer', 7, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 27);

INSERT INTO `nav_menus` (`id`, `name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 28, 'Hubungi Sekretariat', '/hubungi', '_self', NULL, NULL, 'footer', 8, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `id` = 28);

-- ------------------------------------------------------------------------------
-- 6. UPSERT PENGATURAN KONTEN BERANDA (SETTINGS)
-- ------------------------------------------------------------------------------
INSERT INTO `settings` (`key`, `value`, `group`, `created_at`, `updated_at`) VALUES
('home_trisula_badge', 'Trisula Keunggulan Pesantren', 'homepage', NOW(), NOW()),
('home_trisula_title', 'Tiga Pondasi Utama Karakter Santri PPRU', 'homepage', NOW(), NOW()),
('home_trisula_subtitle', 'Pondok Pesantren Raudhatul Ulum Sakatiga memadukan tradisi keilmuan Islam klasik dengan kecakapan era modern melalui tiga pilar keunggulan:', 'homepage', NOW(), NOW()),
('home_trisula_1_title', 'Penguasaan Bahasa Internasional (Arab & Inggris)', 'homepage', NOW(), NOW()),
('home_trisula_1_desc', 'Santri dibina aktif berkomunikasi dalam bahasa Arab dan Inggris setiap hari dengan lingkungan bilingual 24 jam.', 'homepage', NOW(), NOW()),
('home_trisula_1_icon', 'fa-solid fa-language', 'homepage', NOW(), NOW()),
('home_trisula_2_title', 'Tahfidzul Qur\'an Mutqin 30 Juz', 'homepage', NOW(), NOW()),
('home_trisula_2_desc', 'Program tahfidz terarah dengan bimbingan para huffadz bersanad, mengutamakan tajwid, makhorijul huruf, dan pemahaman ayat.', 'homepage', NOW(), NOW()),
('home_trisula_2_icon', 'fa-solid fa-book-quran', 'homepage', NOW(), NOW()),
('home_trisula_3_title', 'Kajian Turots Kitab Kuning Klasik', 'homepage', NOW(), NOW()),
('home_trisula_3_desc', 'Mendalami kitab-kitab muktabar para ulama salaf dalam bidang fiqih, nahwu, shorof, ushul fiqih, tafsir, dan hadits.', 'homepage', NOW(), NOW()),
('home_trisula_3_icon', 'fa-solid fa-book-open-reader', 'homepage', NOW(), NOW()),
('home_counter_1_number', '3500+', 'homepage', NOW(), NOW()),
('home_counter_1_label', 'Santri Aktif Mukim', 'homepage', NOW(), NOW()),
('home_counter_2_number', '250+', 'homepage', NOW(), NOW()),
('home_counter_2_label', 'Asatidz & Pengasuh', 'homepage', NOW(), NOW()),
('home_counter_3_number', '15000+', 'homepage', NOW(), NOW()),
('home_counter_3_label', 'Alumni Tersebar Global', 'homepage', NOW(), NOW()),
('home_counter_4_number', '30 Juz', 'homepage', NOW(), NOW()),
('home_counter_4_label', 'Target Tahfidz Mutqin', 'homepage', NOW(), NOW()),
('home_mudir_badge', 'Sambutan Mudir Pondok', 'homepage', NOW(), NOW()),
('home_mudir_name', 'K.H. Tol\'at Wafa, Lc.', 'homepage', NOW(), NOW()),
('home_mudir_title', 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga', 'homepage', NOW(), NOW()),
('home_mudir_greeting', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh', 'homepage', NOW(), NOW()),
('home_mudir_excerpt', '<p>Segala puji bagi Allah SWT, Rabb semesta alam. Selamat datang di portal resmi Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir, Sumatera Selatan.</p><p>Sejak didirikan, kami terus berikhtiar mendidik para santri agar memiliki integritas aqidah yang lurus, ibadah yang shahihah, akhlaqul karimah, serta kecakapan intelektual yang mampu menjawab tantangan zaman.</p>', 'homepage', NOW(), NOW()),
('home_mudir_photo', '/images/mudir-ppru.webp', 'homepage', NOW(), NOW()),
('home_mudir_btn_text', 'Baca Sambutan Lengkap', 'homepage', NOW(), NOW()),
('home_mudir_btn_url', '/sambutan', 'homepage', NOW(), NOW()),
('home_psb_badge', 'Penerimaan Santri Baru', 'homepage', NOW(), NOW()),
('home_psb_title', 'Pendaftaran Santri Baru (PSB) Tahun Ajaran Baru Telah Dibuka', 'homepage', NOW(), NOW()),
('home_psb_subtitle', 'Mari persiapkan masa depan putra-putri Anda menjadi generasi sholih, cerdas, berkarakter Qur\'ani, dan berwawasan global di PPRU Sakatiga.', 'homepage', NOW(), NOW()),
('home_psb_btn_text', 'Daftar Online Sekarang', 'homepage', NOW(), NOW()),
('home_psb_btn_url', 'https://santri.ppru.ac.id', 'homepage', NOW(), NOW()),
('home_infaq_badge', 'Kanal Donasi & Wakaf', 'homepage', NOW(), NOW()),
('home_infaq_title', 'Investasikan Kebaikan Abadi untuk Pengembangan Dakwah & Pendidikan Pesantren', 'homepage', NOW(), NOW()),
('home_infaq_subtitle', 'Salurkan infaq dan wakaf terbaik Anda untuk pembangunan fasilitas santri penghafal Al-Qur\'an serta beasiswa santri berprestasi.', 'homepage', NOW(), NOW()),
('home_infaq_btn_text', 'Salurkan Donasi / Infaq', 'homepage', NOW(), NOW()),
('home_infaq_btn_url', '/donasi', 'homepage', NOW(), NOW())
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`);

-- ------------------------------------------------------------------------------
-- 7. PENAMBAHAN KOLOM unit_pendidikan_id (USERS, POSTS, VIDEOS)
-- ------------------------------------------------------------------------------
SET @col_users = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'unit_pendidikan_id');
SET @sql_users = IF(@col_users = 0, 'ALTER TABLE `users` ADD COLUMN `unit_pendidikan_id` bigint(20) unsigned NULL AFTER `role`, ADD CONSTRAINT `users_unit_fk` FOREIGN KEY (`unit_pendidikan_id`) REFERENCES `unit_pendidikans`(`id`) ON DELETE SET NULL', 'SELECT 1');
PREPARE stmt_users FROM @sql_users;
EXECUTE stmt_users;
DEALLOCATE PREPARE stmt_users;

SET @col_posts = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'posts' AND COLUMN_NAME = 'unit_pendidikan_id');
SET @sql_posts = IF(@col_posts = 0, 'ALTER TABLE `posts` ADD COLUMN `unit_pendidikan_id` bigint(20) unsigned NULL AFTER `author_id`, ADD CONSTRAINT `posts_unit_fk` FOREIGN KEY (`unit_pendidikan_id`) REFERENCES `unit_pendidikans`(`id`) ON DELETE SET NULL', 'SELECT 1');
PREPARE stmt_posts FROM @sql_posts;
EXECUTE stmt_posts;
DEALLOCATE PREPARE stmt_posts;

SET @col_videos = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'videos' AND COLUMN_NAME = 'unit_pendidikan_id');
SET @sql_videos = IF(@col_videos = 0, 'ALTER TABLE `videos` ADD COLUMN `unit_pendidikan_id` bigint(20) unsigned NULL AFTER `id`, ADD CONSTRAINT `videos_unit_fk` FOREIGN KEY (`unit_pendidikan_id`) REFERENCES `unit_pendidikans`(`id`) ON DELETE SET NULL', 'SELECT 1');
PREPARE stmt_videos FROM @sql_videos;
EXECUTE stmt_videos;
DEALLOCATE PREPARE stmt_videos;

-- ------------------------------------------------------------------------------
-- 8. PEMBUATAN AKUN ADMIN 8 UNIT LEMBAGA PENDIDIKAN YAPIRUS PPRU
-- Default Password: AdminUnitPPRU2026!
-- ------------------------------------------------------------------------------
INSERT INTO `users` (`name`, `email`, `password`, `role`, `unit_pendidikan_id`, `created_at`, `updated_at`)
VALUES
('Admin MA Raudhatul Ulum', 'admin.maru@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 1, NOW(), NOW()),
('Admin MTs Raudhatul Ulum', 'admin.matsaru@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 2, NOW(), NOW()),
('Admin MI Raudhatul Ulum', 'admin.miru@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 3, NOW(), NOW()),
('Admin Tahfizhul Quran Lil Aulad', 'admin.matqularu@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 4, NOW(), NOW()),
('Admin TK Islam Raudhatul Ulum', 'admin.takiru@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 5, NOW(), NOW()),
('Admin SMPIT Raudhatul Ulum', 'admin.smpit@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 6, NOW(), NOW()),
('Admin SMAIT Raudhatul Ulum', 'admin.smait@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 7, NOW(), NOW()),
('Admin IAI Nur Raudhatul Ulum', 'admin.iainru@ppru.ac.id', '$2y$12$IllU7y9CcNnV20NdKyVtu.SkTMPip4pRYTCpUyn/ajIZ04EPAtSK2', 'admin_unit', 8, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `role` = 'admin_unit',
  `unit_pendidikan_id` = VALUES(`unit_pendidikan_id`),
  `updated_at` = NOW();

-- ------------------------------------------------------------------------------
-- 9. KATEGORI IKARUS (IKATAN KELUARGA ALUMNI RAUDHATUL ULUM) & MENU NAVIGASI
-- ------------------------------------------------------------------------------
INSERT INTO `categories` (`name`, `slug`, `created_at`, `updated_at`)
SELECT 'IKARUS', 'ikarus', NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `categories` WHERE `slug` = 'ikarus');

INSERT INTO `nav_menus` (`name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 'IKARUS (Alumni)', '/ikarus', '_self', 'fa-solid fa-graduation-cap', NULL, 'header', 6, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `url` = '/ikarus' AND `location` = 'header');

INSERT INTO `nav_menus` (`name`, `url`, `target`, `icon`, `parent_id`, `location`, `order`, `is_active`, `created_at`, `updated_at`)
SELECT 'Alumni RU (IKARUS)', '/ikarus', '_self', 'fa-solid fa-graduation-cap', NULL, 'footer', 5, 1, NOW(), NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `nav_menus` WHERE `url` = '/ikarus' AND `location` = 'footer');

-- ------------------------------------------------------------------------------
-- 10. PEMBERSIHAN SIMBOL AI (EM-DASH & EN-DASH) & SAMPLE DATA DEMO IKARUS
-- ------------------------------------------------------------------------------
UPDATE `posts` SET 
  `content` = REPLACE(REPLACE(`content`, '—', ' - '), '–', '-'), 
  `excerpt` = REPLACE(REPLACE(`excerpt`, '—', ' - '), '–', '-'), 
  `title` = REPLACE(REPLACE(`title`, '—', ' - '), '–', '-');

UPDATE `settings` SET 
  `value` = REPLACE(REPLACE(`value`, '—', ' - '), '–', '-');

-- Insert Demo Alumni Articles
INSERT INTO `posts` (`title`, `slug`, `author_name`, `excerpt`, `content`, `featured_image`, `is_featured`, `published_at`, `status`, `type`, `author_id`, `views_count`, `created_at`, `updated_at`)
SELECT 
  'Kiprah Alumni MARU Menempuh Studi di Universitas Al-Azhar Kairo Mesir',
  'kiprah-alumni-maru-menempuh-studi-di-universitas-al-azhar-kairo-mesir',
  'Ustadz Ahmad Farhan, Lc.',
  'Catatan inspiratif alumni Madrasah Aliyah Raudhatul Ulum Sakatiga yang kini menempuh studi sarjana Fakultas Ushuluddin di Universitas Al-Azhar Kairo, Mesir.',
  '<p><strong>Kairo, Mesir</strong> - Perjalanan menuntut ilmu ke negeri para anbiya adalah impian banyak santri di tanah air. Bagi kami para alumni Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga, bekal bahasa Arab fusha dan pemahaman dasar kitab turots yang dipelajari selama bertahun-tahun di asrama menjadi modal berharga saat pertama kali menginjakkan kaki di Universitas Al-Azhar Kairo.</p><p>Alhamdulillah, berkat piagam muadalah resmi yang telah lama terjalin antara Al-Azhar Asy-Syarif dengan Pondok Pesantren Raudhatul Ulum Sakatiga, adaptasi akademik santri alumni berjalan sangat lancar.</p>',
  '/uploads/official/kbm-santri-0098.webp',
  1,
  NOW(),
  'publish',
  'ikarus',
  1,
  350,
  NOW(),
  NOW()
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM `posts` WHERE `slug` = 'kiprah-alumni-maru-menempuh-studi-di-universitas-al-azhar-kairo-mesir');

-- Hubungkan post ke kategori IKARUS
INSERT IGNORE INTO `post_category` (`post_id`, `category_id`)
SELECT p.id, c.id
FROM `posts` p
JOIN `categories` c ON c.slug = 'ikarus'
WHERE p.type = 'ikarus';

SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================================================
-- UPDATE BERHASIL DILAKUKAN.
-- Database cPanel kini kompatibel penuh dengan Multi-Unit Admin & Portal IKARUS PPRU.
-- ==============================================================================


