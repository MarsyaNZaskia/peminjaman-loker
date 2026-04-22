/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `kategoris`;
CREATE TABLE `kategoris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `log_aktivitas`;
CREATE TABLE `log_aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` bigint unsigned DEFAULT NULL,
  `keterangan` text,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_user_id_foreign` (`user_id`),
  CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `lokers`;
CREATE TABLE `lokers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor_loker` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `ukuran` enum('kecil','sedang','besar') NOT NULL DEFAULT 'sedang',
  `status` enum('tersedia','dipinjam','rusak') NOT NULL DEFAULT 'tersedia',
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lokers_nomor_loker_unique` (`nomor_loker`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `loker_id` bigint unsigned NOT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali_rencana` date NOT NULL,
  `status` enum('pending','disetujui','ditolak','selesai') NOT NULL DEFAULT 'pending',
  `keperluan` text,
  `catatan_petugas` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_user_id_foreign` (`user_id`),
  KEY `peminjaman_loker_id_foreign` (`loker_id`),
  KEY `peminjaman_approved_by_foreign` (`approved_by`),
  CONSTRAINT `peminjaman_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `peminjaman_loker_id_foreign` FOREIGN KEY (`loker_id`) REFERENCES `lokers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE `pengembalian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `peminjaman_id` bigint unsigned NOT NULL,
  `tgl_kembali_realisasi` date NOT NULL,
  `total_denda` int NOT NULL DEFAULT '0',
  `kondisi_barang` enum('baik','rusak','hilang') DEFAULT 'baik',
  `catatan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengembalian_user_id_foreign` (`user_id`),
  KEY `pengembalian_peminjaman_id_foreign` (`peminjaman_id`),
  CONSTRAINT `pengembalian_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengembalian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('admin','petugas','peminjam') NOT NULL DEFAULT 'peminjam',
  `kategori_id` bigint unsigned DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`),
  KEY `users_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `users_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;






INSERT INTO `kategoris` (`id`, `nama_kategori`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Kelas 10', 'Siswa Kelas 10', '2026-02-08 00:06:55', '2026-02-08 00:06:55'),
(2, 'Kelas 11', 'Siswa Kelas 11', '2026-02-08 00:06:55', '2026-02-08 00:06:55'),
(3, 'Kelas 12', 'Siswa Kelas 12', '2026-02-08 00:06:55', '2026-02-08 00:06:55');
INSERT INTO `log_aktivitas` (`id`, `user_id`, `aksi`, `model`, `model_id`, `keterangan`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'clear', 'LogAktivitas', NULL, 'Menghapus semua log aktivitas', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 07:49:57', '2026-02-09 07:49:57'),
(2, 1, 'create', 'Loker', 15, 'Menambahkan loker L2-2008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 07:50:44', '2026-02-09 07:50:44'),
(3, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:06:55', '2026-02-09 12:06:55'),
(4, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:09:26', '2026-02-09 12:09:26'),
(5, NULL, 'login', 'User', 4, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:09:40', '2026-02-09 12:09:40'),
(6, NULL, 'logout', 'User', 4, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:11:11', '2026-02-09 12:11:11'),
(7, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:11:23', '2026-02-09 12:11:23'),
(8, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:11:56', '2026-02-09 12:11:56'),
(9, NULL, 'login', 'User', 5, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:12:12', '2026-02-09 12:12:12'),
(10, NULL, 'logout', 'User', 5, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:13:11', '2026-02-09 12:13:11'),
(11, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:13:26', '2026-02-09 12:13:26'),
(12, NULL, 'approve', 'Peminjaman', 2, 'Menyetujui peminjaman loker L2-005 oleh Seo Changbin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:13:41', '2026-02-09 12:13:41'),
(13, NULL, 'approve', 'Peminjaman', 3, 'Menyetujui peminjaman loker L2-005 oleh Christopher Bangh', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 12:13:50', '2026-02-09 12:13:50'),
(14, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 14:22:12', '2026-02-09 14:22:12'),
(15, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 14:22:30', '2026-02-09 14:22:30'),
(16, NULL, 'return', 'Pengembalian', 2, 'Mencatat pengembalian loker L2-005 dengan denda Rp 0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 14:22:58', '2026-02-09 14:22:58'),
(17, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-09 14:23:26', '2026-02-09 14:23:26'),
(18, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 00:29:16', '2026-02-10 00:29:16'),
(19, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 00:32:48', '2026-02-10 00:32:48'),
(20, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 04:16:29', '2026-02-10 04:16:29'),
(21, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 04:21:54', '2026-02-10 04:21:54'),
(22, NULL, 'login', 'User', 7, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 04:22:07', '2026-02-10 04:22:07'),
(23, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 12:02:59', '2026-02-10 12:02:59'),
(24, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-10 12:08:48', '2026-02-10 12:08:48'),
(25, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 00:48:35', '2026-02-11 00:48:35'),
(26, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 00:54:10', '2026-02-11 00:54:10'),
(27, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 00:55:54', '2026-02-11 00:55:54'),
(28, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 00:59:15', '2026-02-11 00:59:15'),
(29, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:04:03', '2026-02-11 01:04:03'),
(30, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:04:16', '2026-02-11 01:04:16'),
(31, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:33:27', '2026-02-11 01:33:27'),
(32, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:34:38', '2026-02-11 01:34:38'),
(33, 1, 'export', 'Loker', NULL, 'Export laporan loker ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:35:38', '2026-02-11 01:35:38'),
(34, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:48:03', '2026-02-11 01:48:03'),
(35, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:48:17', '2026-02-11 01:48:17'),
(36, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:51:36', '2026-02-11 01:51:36'),
(37, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:51:51', '2026-02-11 01:51:51'),
(38, NULL, 'approve', 'Peminjaman', 4, 'Menyetujui peminjaman loker L2-2008 oleh Hwang Hyunjin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:53:56', '2026-02-11 01:53:56'),
(39, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:56:16', '2026-02-11 01:56:16'),
(40, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:56:30', '2026-02-11 01:56:30'),
(41, 1, 'update', 'Loker', 15, 'Mengupdate loker L2-2008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 01:57:37', '2026-02-11 01:57:37'),
(42, 1, 'export', 'Peminjaman', NULL, 'Export laporan peminjaman ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:00:07', '2026-02-11 02:00:07'),
(43, 1, 'export', 'Peminjaman', NULL, 'Export laporan peminjaman ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:00:52', '2026-02-11 02:00:52'),
(44, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:11:54', '2026-02-11 02:11:54'),
(45, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:12:06', '2026-02-11 02:12:06'),
(46, NULL, 'return', 'Pengembalian', 3, 'Mencatat pengembalian loker L2-005 dengan denda Rp 0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:13:14', '2026-02-11 02:13:14'),
(47, NULL, 'export', 'Peminjaman', NULL, 'Export laporan peminjaman ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:15:28', '2026-02-11 02:15:28'),
(48, NULL, 'return', 'Pengembalian', 4, 'Mencatat pengembalian loker L2-2008 dengan denda Rp 0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:16:26', '2026-02-11 02:16:26'),
(49, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:16:34', '2026-02-11 02:16:34'),
(50, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 02:26:07', '2026-02-11 02:26:07'),
(51, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:27:32', '2026-02-11 05:27:32'),
(52, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:27:39', '2026-02-11 05:27:39'),
(53, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:27:51', '2026-02-11 05:27:51'),
(54, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:27:59', '2026-02-11 05:27:59'),
(55, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:28:14', '2026-02-11 05:28:14'),
(56, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:28:56', '2026-02-11 05:28:56'),
(57, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:29:32', '2026-02-11 05:29:32'),
(58, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:55:17', '2026-02-11 05:55:17'),
(59, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:57:19', '2026-02-11 05:57:19'),
(60, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 05:57:42', '2026-02-11 05:57:42'),
(61, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 06:10:37', '2026-02-11 06:10:37'),
(62, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 06:10:52', '2026-02-11 06:10:52'),
(63, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 07:01:32', '2026-02-11 07:01:32'),
(64, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 07:01:44', '2026-02-11 07:01:44'),
(65, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 07:03:18', '2026-02-11 07:03:18'),
(66, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 07:06:03', '2026-02-11 07:06:03'),
(67, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 07:28:05', '2026-02-11 07:28:05'),
(68, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 13:18:35', '2026-02-11 13:18:35'),
(69, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 13:58:23', '2026-02-11 13:58:23'),
(70, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 13:58:38', '2026-02-11 13:58:38'),
(71, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:00:28', '2026-02-11 14:00:28'),
(72, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:01:02', '2026-02-11 14:01:02'),
(73, NULL, 'login', 'User', 4, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:01:17', '2026-02-11 14:01:17'),
(74, NULL, 'logout', 'User', 4, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:04:24', '2026-02-11 14:04:24'),
(75, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:04:37', '2026-02-11 14:04:37'),
(76, NULL, 'approve', 'Peminjaman', 5, 'Menyetujui peminjaman loker L1-008 oleh Seo Changbin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:08:48', '2026-02-11 14:08:48'),
(77, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 14:09:07', '2026-02-11 14:09:07'),
(78, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 15:09:29', '2026-02-11 15:09:29'),
(79, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 23:48:04', '2026-02-11 23:48:04'),
(80, 1, 'delete', 'Loker', NULL, 'Menghapus loker L2-2008', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-11 23:48:21', '2026-02-11 23:48:21'),
(81, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 00:30:26', '2026-02-12 00:30:26'),
(82, NULL, 'login', 'User', 8, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 00:30:42', '2026-02-12 00:30:42'),
(83, NULL, 'logout', 'User', 8, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 00:31:51', '2026-02-12 00:31:51'),
(84, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 00:32:10', '2026-02-12 00:32:10'),
(85, NULL, 'reject', 'Peminjaman', 7, 'Menolak peminjaman loker L2-005 oleh Nadira Cantik', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 00:32:40', '2026-02-12 00:32:40'),
(86, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:28:36', '2026-02-12 01:28:36'),
(87, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:41:49', '2026-02-12 01:41:49'),
(88, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:49:09', '2026-02-12 01:49:09'),
(89, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:49:22', '2026-02-12 01:49:22'),
(90, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:52:14', '2026-02-12 01:52:14'),
(91, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:52:24', '2026-02-12 01:52:24'),
(92, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:56:19', '2026-02-12 01:56:19'),
(93, NULL, 'login', 'User', 6, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:57:34', '2026-02-12 01:57:34'),
(94, NULL, 'logout', 'User', 6, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-12 01:57:42', '2026-02-12 01:57:42'),
(95, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:28:42', '2026-03-25 14:28:42'),
(96, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:33:19', '2026-03-25 14:33:19'),
(97, NULL, 'approve', 'Peminjaman', 8, 'Menyetujui peminjaman loker L1-005 oleh Hwang Hyunjin', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:33:57', '2026-03-25 14:33:57'),
(98, NULL, 'logout', 'User', 2, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:34:31', '2026-03-25 14:34:31'),
(99, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 14:34:42', '2026-03-25 14:34:42'),
(100, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 15:04:46', '2026-03-25 15:04:46'),
(101, NULL, 'login', 'User', 2, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-03-25 15:04:58', '2026-03-25 15:04:58'),
(102, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 01:06:13', '2026-04-06 01:06:13'),
(103, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:13:53', '2026-04-07 01:13:53'),
(104, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:31:46', '2026-04-07 01:31:46'),
(105, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:32:03', '2026-04-07 01:32:03'),
(106, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:32:13', '2026-04-07 01:32:13'),
(107, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:34:24', '2026-04-07 01:34:24'),
(108, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 01:35:40', '2026-04-07 01:35:40'),
(109, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:41:17', '2026-04-07 03:41:17'),
(110, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:41:30', '2026-04-07 03:41:30'),
(111, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:42:07', '2026-04-07 03:42:07'),
(112, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:42:17', '2026-04-07 03:42:17'),
(113, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:42:51', '2026-04-07 03:42:51'),
(114, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:43:02', '2026-04-07 03:43:02'),
(115, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:43:26', '2026-04-07 03:43:26'),
(116, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:43:59', '2026-04-07 03:43:59'),
(117, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:47:36', '2026-04-07 03:47:36'),
(118, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:47:48', '2026-04-07 03:47:48'),
(119, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:48:40', '2026-04-07 03:48:40'),
(120, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:48:56', '2026-04-07 03:48:56'),
(121, 1, 'export', 'Peminjaman', NULL, 'Export laporan peminjaman ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:49:43', '2026-04-07 03:49:43'),
(122, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:50:11', '2026-04-07 03:50:11'),
(123, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:50:43', '2026-04-07 03:50:43'),
(124, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:54:12', '2026-04-07 03:54:12'),
(125, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 03:54:25', '2026-04-07 03:54:25'),
(126, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-07 03:54:58', '2026-04-07 03:54:58'),
(127, NULL, 'logout', 'User', 3, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-07 03:55:08', '2026-04-07 03:55:08'),
(128, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 04:09:37', '2026-04-07 04:09:37'),
(129, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 04:09:50', '2026-04-07 04:09:50'),
(130, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 04:12:13', '2026-04-07 04:12:13'),
(131, NULL, 'login', 'User', 3, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 04:12:33', '2026-04-07 04:12:33'),
(132, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 14:05:28', '2026-04-07 14:05:28'),
(133, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-07 14:10:03', '2026-04-07 14:10:03'),
(134, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 00:18:29', '2026-04-08 00:18:29'),
(135, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-08 03:37:28', '2026-04-08 03:37:28'),
(136, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-09 00:04:01', '2026-04-09 00:04:01'),
(137, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 00:05:02', '2026-04-09 00:05:02'),
(138, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-09 00:08:32', '2026-04-09 00:08:32'),
(139, 10, 'approve', 'Peminjaman', 10, 'Menyetujui peminjaman loker L2-001 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 00:58:39', '2026-04-09 00:58:39'),
(140, 10, 'return', 'Pengembalian', 5, 'Mencatat pengembalian loker L2-001 dengan denda Rp 50.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 01:19:23', '2026-04-09 01:19:23'),
(141, 10, 'approve', 'Peminjaman', 11, 'Menyetujui peminjaman loker L1-001 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 01:30:10', '2026-04-09 01:30:10'),
(142, 10, 'return', 'Pengembalian', 6, 'Mencatat pengembalian loker L1-001 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 01:53:26', '2026-04-09 01:53:26'),
(143, 10, 'approve', 'Peminjaman', 12, 'Menyetujui peminjaman loker L1-002 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 02:01:04', '2026-04-09 02:01:04'),
(144, 10, 'return', 'Pengembalian', 7, 'Mencatat pengembalian loker L1-002 dengan denda Rp 15.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-09 02:01:31', '2026-04-09 02:01:31'),
(145, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-09 06:15:28', '2026-04-09 06:15:28'),
(146, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-10 05:42:35', '2026-04-10 05:42:35'),
(147, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-10 05:43:23', '2026-04-10 05:43:23'),
(148, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-10 05:45:43', '2026-04-10 05:45:43'),
(149, 10, 'logout', 'User', 10, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-10 06:11:07', '2026-04-10 06:11:07'),
(150, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-10 06:11:14', '2026-04-10 06:11:14'),
(151, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-10 06:11:21', '2026-04-10 06:11:21'),
(152, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 06:43:32', '2026-04-13 06:43:32'),
(153, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-13 06:55:18', '2026-04-13 06:55:18'),
(154, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-13 06:56:00', '2026-04-13 06:56:00'),
(155, 10, 'approve', 'Peminjaman', 13, 'Menyetujui peminjaman loker L1-001 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-13 07:03:17', '2026-04-13 07:03:17'),
(156, 10, 'return', 'Pengembalian', 8, 'Mencatat pengembalian loker L1-001 dengan denda Rp 500.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-13 07:16:05', '2026-04-13 07:16:05'),
(157, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 00:12:20', '2026-04-14 00:12:20'),
(158, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 00:20:51', '2026-04-14 00:20:51'),
(159, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 00:22:08', '2026-04-14 00:22:08'),
(160, 10, 'approve', 'Peminjaman', 14, 'Menyetujui peminjaman loker L2-005 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 00:24:30', '2026-04-14 00:24:30'),
(161, 10, 'return', 'Pengembalian', 9, 'Mencatat pengembalian loker L2-005 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 00:25:32', '2026-04-14 00:25:32'),
(162, 10, 'approve', 'Peminjaman', 15, 'Menyetujui peminjaman loker L1-004 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 00:39:54', '2026-04-14 00:39:54'),
(163, 10, 'return', 'Pengembalian', 10, 'Mencatat pengembalian loker L1-004 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 00:40:24', '2026-04-14 00:40:24'),
(164, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 03:02:31', '2026-04-14 03:02:31'),
(165, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 03:03:22', '2026-04-14 03:03:22'),
(166, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-14 03:03:38', '2026-04-14 03:03:38'),
(167, 10, 'approve', 'Peminjaman', 16, 'Menyetujui peminjaman loker L1-001 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 03:04:21', '2026-04-14 03:04:21'),
(168, 10, 'return', 'Pengembalian', 11, 'Mencatat pengembalian loker L1-001 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 03:04:56', '2026-04-14 03:04:56'),
(169, 10, 'approve', 'Peminjaman', 17, 'Menyetujui peminjaman loker L2-002 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 03:22:01', '2026-04-14 03:22:01'),
(170, 10, 'return', 'Pengembalian', 12, 'Mencatat pengembalian loker L2-002 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 03:22:26', '2026-04-14 03:22:26'),
(171, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-14 23:58:53', '2026-04-14 23:58:53'),
(172, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-14 23:59:44', '2026-04-14 23:59:44'),
(173, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:22:53', '2026-04-15 00:22:53'),
(174, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:23:09', '2026-04-15 00:23:09'),
(175, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:24:27', '2026-04-15 00:24:27'),
(176, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:24:45', '2026-04-15 00:24:45'),
(177, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:25:15', '2026-04-15 00:25:15'),
(178, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:25:35', '2026-04-15 00:25:35'),
(179, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:26:18', '2026-04-15 00:26:18'),
(180, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', '2026-04-15 00:26:30', '2026-04-15 00:26:30'),
(181, 10, 'logout', 'User', 10, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:27:34', '2026-04-15 00:27:34'),
(182, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:27:49', '2026-04-15 00:27:49'),
(183, 10, 'logout', 'User', 10, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:32:15', '2026-04-15 00:32:15'),
(184, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 00:32:35', '2026-04-15 00:32:35'),
(185, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 06:27:29', '2026-04-15 06:27:29'),
(186, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 13:23:57', '2026-04-15 13:23:57'),
(187, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 13:52:50', '2026-04-15 13:52:50'),
(188, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 13:53:09', '2026-04-15 13:53:09'),
(189, 10, 'logout', 'User', 10, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 13:53:26', '2026-04-15 13:53:26'),
(190, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 13:54:00', '2026-04-15 13:54:00'),
(191, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:12:06', '2026-04-15 14:12:06'),
(192, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:13:34', '2026-04-15 14:13:34'),
(193, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:17:43', '2026-04-15 14:17:43'),
(194, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:18:02', '2026-04-15 14:18:02'),
(195, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-15 14:39:17', '2026-04-15 14:39:17'),
(196, 10, 'approve', 'Peminjaman', 18, 'Menyetujui peminjaman loker L1-006 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-15 14:39:44', '2026-04-15 14:39:44'),
(197, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:40:23', '2026-04-15 14:40:23'),
(198, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:46:47', '2026-04-15 14:46:47'),
(199, 11, 'login', 'User', 11, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:47:03', '2026-04-15 14:47:03'),
(200, 11, 'logout', 'User', 11, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:47:21', '2026-04-15 14:47:21'),
(201, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:47:36', '2026-04-15 14:47:36'),
(202, 10, 'return', 'Pengembalian', 13, 'Mencatat pengembalian loker L1-006 dengan denda Rp 5.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-15 14:48:34', '2026-04-15 14:48:34'),
(203, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:53:08', '2026-04-15 14:53:08'),
(204, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:53:38', '2026-04-15 14:53:38'),
(205, 10, 'logout', 'User', 10, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-15 14:53:49', '2026-04-15 14:53:49'),
(206, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:57:39', '2026-04-15 14:57:39'),
(207, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:59:15', '2026-04-15 14:59:15'),
(208, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 14:59:28', '2026-04-15 14:59:28'),
(209, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 15:00:42', '2026-04-15 15:00:42'),
(210, 10, 'approve', 'Peminjaman', 19, 'Menyetujui peminjaman loker L2-002 oleh Siti Kusmini', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 15:01:09', '2026-04-15 15:01:09'),
(211, 10, 'return', 'Pengembalian', 14, 'Mencatat pengembalian loker L2-002 dengan denda Rp 45.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 15:02:18', '2026-04-15 15:02:18'),
(212, 10, 'export', 'Peminjaman', NULL, 'Export laporan peminjaman ke Excel', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 15:03:04', '2026-04-15 15:03:04'),
(213, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 01:02:05', '2026-04-16 01:02:05'),
(214, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 06:07:44', '2026-04-16 06:07:44'),
(215, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-16 06:13:05', '2026-04-16 06:13:05'),
(216, 10, 'login', 'User', 10, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-16 06:15:27', '2026-04-16 06:15:27'),
(217, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 06:33:12', '2026-04-16 06:33:12'),
(218, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-16 17:17:55', '2026-04-16 17:17:55'),
(219, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 00:28:48', '2026-04-17 00:28:48'),
(220, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 03:08:41', '2026-04-17 03:08:41'),
(221, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 03:10:20', '2026-04-17 03:10:20'),
(222, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 03:17:35', '2026-04-17 03:17:35'),
(223, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', '2026-04-17 03:31:05', '2026-04-17 03:31:05'),
(224, 9, 'logout', 'User', 9, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 05:12:00', '2026-04-17 05:12:00'),
(225, 11, 'login', 'User', 11, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 05:12:31', '2026-04-17 05:12:31'),
(226, 11, 'logout', 'User', 11, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 05:45:03', '2026-04-17 05:45:03'),
(227, 11, 'login', 'User', 11, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-17 05:46:02', '2026-04-17 05:46:02'),
(228, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 05:55:24', '2026-04-20 05:55:24'),
(229, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 05:55:30', '2026-04-20 05:55:30'),
(230, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 06:07:51', '2026-04-20 06:07:51'),
(231, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:21:18', '2026-04-20 12:21:18'),
(232, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:34:06', '2026-04-20 12:34:06'),
(233, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 12:34:20', '2026-04-20 12:34:20'),
(234, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 15:34:41', '2026-04-20 15:34:41'),
(235, 1, 'login', 'User', 1, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 15:35:29', '2026-04-20 15:35:29'),
(236, 1, 'logout', 'User', 1, 'User logout dari sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 15:37:07', '2026-04-20 15:37:07'),
(237, 9, 'login', 'User', 9, 'User login ke sistem', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-20 15:37:24', '2026-04-20 15:37:24');
INSERT INTO `lokers` (`id`, `nomor_loker`, `lokasi`, `ukuran`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'L1-001', 'Lantai 1', 'kecil', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-14 03:04:56'),
(2, 'L1-002', 'Lantai 1', 'kecil', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-09 02:01:31'),
(3, 'L1-003', 'Lantai 1', 'kecil', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-02-08 00:06:56'),
(4, 'L1-004', 'Lantai 1', 'kecil', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-14 00:40:24'),
(5, 'L1-005', 'Lantai 1', 'kecil', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-07 03:42:47'),
(6, 'L1-006', 'Lantai 1', 'sedang', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-15 14:48:34'),
(7, 'L1-007', 'Lantai 1', 'sedang', 'dipinjam', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-02-11 15:13:50'),
(8, 'L1-008', 'Lantai 1', 'sedang', 'dipinjam', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-02-11 14:08:48'),
(9, 'L2-001', 'Lantai 2', 'sedang', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-09 01:19:23'),
(10, 'L2-002', 'Lantai 2', 'sedang', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-15 15:02:18'),
(11, 'L2-003', 'Lantai 2', 'sedang', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-02-08 00:06:56'),
(12, 'L2-004', 'Lantai 2', 'besar', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-02-08 00:06:56'),
(13, 'L2-005', 'Lantai 2', 'besar', 'tersedia', 'Loker dalam kondisi baik', '2026-02-08 00:06:56', '2026-04-14 00:25:32'),
(14, 'L2-203', 'Lantai 2', 'kecil', 'tersedia', NULL, '2026-02-09 07:32:24', '2026-02-09 07:32:24');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_05_133916_create_lokers_table', 1),
(5, '2026_02_05_134238_create_peminjaman_table', 1),
(6, '2026_02_07_123121_create_kategori_table', 1),
(7, '2026_02_07_123201_add_kategori_id_to_users_table', 1),
(8, '2026_02_07_235858_update_peminjaman_table_sesuai_erd', 1),
(9, '2026_02_07_235939_create_pengembalian_table', 1),
(10, '2026_02_08_102439_create_log_aktivitas_table', 2),
(11, '2026_04_07_135245_add_profile_fields_to_users_table', 3),
(12, '2026_04_09_011540_update_kondisi_barang_enum_in_pengembalian_table', 4),
(13, '2026_04_14_000828_drop_jenis_denda_from_pengembalian_table', 5),
(15, '2026_04_15_062149_add_email_and_class_to_users_table', 6),
(16, '2026_04_16_152432_add_google_id_and_email_verified_to_users_table', 7);

INSERT INTO `peminjaman` (`id`, `user_id`, `loker_id`, `approved_by`, `tanggal_pinjam`, `tanggal_kembali_rencana`, `status`, `keperluan`, `catatan_petugas`, `created_at`, `updated_at`) VALUES
(10, 9, 9, 10, '2026-04-09', '2026-04-10', 'selesai', 'menyimpan buku', NULL, '2026-04-09 00:57:48', '2026-04-09 01:19:23'),
(11, 9, 1, 10, '2026-04-09', '2026-04-09', 'selesai', 'menyimpan nyimpan', NULL, '2026-04-09 01:28:59', '2026-04-09 01:53:26'),
(12, 9, 2, 10, '2026-04-09', '2026-04-10', 'selesai', 'hhhh', NULL, '2026-04-09 02:00:46', '2026-04-09 02:01:31'),
(13, 9, 1, 10, '2026-04-13', '2026-04-14', 'selesai', 'ada', NULL, '2026-04-13 07:02:02', '2026-04-13 07:16:05'),
(14, 9, 13, 10, '2026-04-14', '2026-04-14', 'selesai', 'simpen tas', NULL, '2026-04-14 00:24:09', '2026-04-14 00:25:32'),
(15, 9, 4, 10, '2026-04-14', '2026-04-14', 'selesai', 'simpan', NULL, '2026-04-14 00:39:29', '2026-04-14 00:40:24'),
(16, 9, 1, 10, '2026-04-14', '2026-04-15', 'selesai', 'hh', NULL, '2026-04-14 03:04:00', '2026-04-14 03:04:56'),
(17, 9, 10, 10, '2026-04-14', '2026-04-14', 'selesai', 'simpen tas', NULL, '2026-04-14 03:20:05', '2026-04-14 03:22:26'),
(18, 9, 6, 10, '2026-04-15', '2026-04-15', 'selesai', 'simpan barang', NULL, '2026-04-15 00:00:39', '2026-04-15 14:48:34'),
(19, 9, 10, 10, '2026-04-15', '2026-04-15', 'selesai', 'simpan buku', NULL, '2026-04-15 15:00:13', '2026-04-15 15:02:18');
INSERT INTO `pengembalian` (`id`, `user_id`, `peminjaman_id`, `tgl_kembali_realisasi`, `total_denda`, `kondisi_barang`, `catatan`, `created_at`, `updated_at`) VALUES
(5, 10, 10, '2026-04-09', 50000, 'rusak', NULL, '2026-04-09 01:19:23', '2026-04-09 01:19:23'),
(6, 10, 11, '2026-04-10', 5000, 'baik', NULL, '2026-04-09 01:53:26', '2026-04-09 01:53:26'),
(7, 10, 12, '2026-04-13', 15000, 'baik', NULL, '2026-04-09 02:01:31', '2026-04-09 02:01:31'),
(8, 10, 13, '2026-04-15', 500000, 'hilang', NULL, '2026-04-13 07:16:04', '2026-04-13 07:16:04'),
(9, 10, 14, '2026-04-15', 5000, 'baik', NULL, '2026-04-14 00:25:32', '2026-04-14 00:25:32'),
(10, 10, 15, '2026-04-15', 5000, 'baik', NULL, '2026-04-14 00:40:24', '2026-04-14 00:40:24'),
(11, 10, 16, '2026-04-16', 5000, 'baik', NULL, '2026-04-14 03:04:56', '2026-04-14 03:04:56'),
(12, 10, 17, '2026-04-15', 5000, 'baik', 'telat', '2026-04-14 03:22:26', '2026-04-14 03:22:26'),
(13, 10, 18, '2026-04-16', 5000, 'baik', NULL, '2026-04-15 14:48:34', '2026-04-15 14:48:34'),
(14, 10, 19, '2026-04-24', 45000, 'baik', NULL, '2026-04-15 15:02:18', '2026-04-15 15:02:18');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('THshho8MddorQ70NZ6uB44UyJ1hddHRmOXcOlx5C', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZW9jb0lNeDBLWEMydldXZFRUSzRHOHNaWVQzZkJvd3oya1VhZGNDQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbS9yaXdheWF0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9', 1776699638);
INSERT INTO `users` (`id`, `google_id`, `username`, `name`, `role`, `kategori_id`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `address`, `photo`, `email`, `email_verified_at`, `class`) VALUES
(1, NULL, 'admin', 'Administrator', 'admin', NULL, '$2y$12$U4OWTkQhXb7zEUwoR3dstuczaYg1mhB/72Go.FLoKq0mmHge.ImHa', NULL, '2026-02-08 00:06:56', '2026-04-08 04:37:45', NULL, NULL, 'profile-photos/ZWFQX1eKZum7SKrrBMYL1tLGMH4Ap6IQ0Qer89vr.jpg', NULL, NULL, NULL),
(9, '110238408112093224148', 'Peminjam001', 'Siti Kusmini', 'peminjam', 1, '$2y$12$05OASlcdVdg7iL0y69aVOu37dwryKrVwlUTUpk7JxdGqfUbRF9Jby', NULL, '2026-04-07 14:07:41', '2026-04-17 03:23:24', '08121212121', 'Villa Bogor Indah No.8', 'profile-photos/RNKo2AXJVWrHWYdVB5i42rvrJKBVeL5Z0aVaWX91.jpg', 'mzaskia0808@gmail.com', NULL, '10 MIPA 1'),
(10, NULL, 'Petugas001', 'Sutini', 'petugas', NULL, '$2y$12$b.QzzDLsoE6K0GpiHv5oKeFlJJ0XhONtWGVMRa5J7aveQVnHpGIpW', NULL, '2026-04-07 14:08:21', '2026-04-16 06:14:59', NULL, NULL, 'profile-photos/aBX9tvww26knKf1FCbxI7Qfnlc0HlyJOmM6iQ2Uc.jpg', NULL, NULL, NULL),
(11, NULL, 'Peminjam002', 'Dudung dut', 'peminjam', 2, '$2y$12$z49s.jC8Ol6nd.kJY6beFuRxCf9pYDp932aDacdYbxGEhoc5K.DMG', NULL, '2026-04-15 14:46:23', '2026-04-15 14:46:23', NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'Ulil003', 'Ulil', 'peminjam', NULL, '$2y$12$uNqjSnXvVTgtCBUL/yH9teuJ3W4tTAgyrINEbRL/8hz/JrJMl33DS', NULL, '2026-04-17 04:56:28', '2026-04-17 04:56:28', NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 'Nunung002', 'Nunung', 'petugas', NULL, '$2y$12$LyHxAUCaFjngmZ4uXXNZ5erM61dBf1a7SdGi3WaRfdBfYOhrze0S6', NULL, '2026-04-17 04:56:28', '2026-04-17 04:56:28', NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 'Silpi001', 'Silpi', 'peminjam', NULL, '$2y$12$k.o7IJjv8AL51VwdFNQ0jO2./X.4Qwu1.6AcelZFREU5haivohMHq', NULL, '2026-04-17 05:48:38', '2026-04-17 05:48:38', NULL, NULL, NULL, NULL, NULL, NULL),
(17, NULL, 'Nadira001', 'Nadira', 'petugas', NULL, '$2y$12$JOAn3gUefXfwj6F7n/eT5uP/i4LJiUhQ9d/ajOSCNDjyB0FjpQjWq', NULL, '2026-04-17 05:48:39', '2026-04-17 05:48:39', NULL, NULL, NULL, NULL, NULL, NULL),
(18, NULL, 'Gita001', 'gita', 'peminjam', NULL, '$2y$12$FZEhZw0LdEESsVJfBKYofetWwBCmJxXIfIHnlvU4CLxN0Ulg53xpa', NULL, '2026-04-17 05:49:55', '2026-04-17 05:49:55', NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, 'Rini001', 'rini', 'petugas', NULL, '$2y$12$QE3YvBSWqeaLvm0oCKwyv.TCMvDgiORc.SjLwANfPd8IqgjiPPud.', NULL, '2026-04-17 05:49:56', '2026-04-17 05:49:56', NULL, NULL, NULL, NULL, NULL, NULL);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;