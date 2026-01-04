-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2026 at 03:41 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_facility_report2`
--

-- --------------------------------------------------------

--
-- Table structure for table `gedung`
--

CREATE TABLE `gedung` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gedung`
--

INSERT INTO `gedung` (`id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'MH1JF5138CK284246', 'Gedung Serba Guna', 'Terdapat 4 Ruangan', '2025-12-11 10:41:48', '2025-12-11 10:41:48'),
(2, 'MH1JF5138CK284247', 'Smart Food Securty', 'Gedung dengan 18 kelas', '2025-12-11 16:01:12', '2025-12-11 16:01:12'),
(3, 'MH1JF5138CK284249', 'Gedung Sakura', '5 Ruangan', '2025-12-13 03:47:52', '2025-12-13 03:47:52'),
(4, 'MH1JF5138CK284250', 'CB', 'Gedung', '2025-12-22 12:02:46', '2025-12-22 12:02:46'),
(6, 'MH1JF5138CK284251', 'Lainnya', 'Lainnya', '2025-12-29 08:31:52', '2025-12-29 08:31:52');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) DEFAULT NULL,
  `lokasi_kerusakan` varchar(255) DEFAULT NULL,
  `lokasi_spesifik` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('pending','diproses','selesai','ditolak') DEFAULT 'pending',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `gedung_id` int(10) UNSIGNED DEFAULT NULL,
  `prioritas` enum('low','medium','high') DEFAULT 'medium',
  `kategori` varchar(100) DEFAULT NULL,
  `admin_verifikator` int(10) UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `keterangan_verifikasi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama_pelapor`, `lokasi_kerusakan`, `lokasi_spesifik`, `deskripsi`, `foto`, `status`, `user_id`, `gedung_id`, `prioritas`, `kategori`, `admin_verifikator`, `tanggal_verifikasi`, `keterangan_verifikasi`, `created_at`, `updated_at`) VALUES
(19, 'Zakkya Nurhadi', 'Depan GSG', 'Tes', 'Kerusakan Jalan', '1765685546_e6632cc6333bb7ebb57a.jpg', 'diproses', 9, 1, 'low', 'Keamanan', NULL, '2025-12-24 02:45:40', 'tessssssss', '2025-12-14 11:12:26', '2025-12-31 20:19:26'),
(20, 'Zakkya', 'Lab. Software 2', '', 'Masalah AC tidak dingin', NULL, 'diproses', 9, 2, 'low', 'AC', NULL, '2025-12-31 13:23:25', 'Oke segera di proses', '2025-12-31 18:43:05', '2025-12-31 20:23:25'),
(21, 'Zakkya2', 'Lab. Kom, Lt 2', '', 'Air tidak ada habis dan air bocor', '1767181790_84ba8ec7518ebb85ea52.jpg', 'pending', 11, 3, 'low', 'Toilet', NULL, NULL, NULL, '2025-12-31 18:49:50', '2026-01-04 11:47:42'),
(34, 'Zakkya nurhadi', 'SFS. Lt 2 Toilet', '', 'Masalah air mampet pada toilet', '1767184864_df6f84a662a1010da09c.jpeg', 'selesai', 11, 2, 'low', 'AIR', NULL, '2026-01-04 08:30:57', 'sudah di perbaiki', '2025-12-31 19:41:04', '2026-01-04 15:30:57'),
(36, 'Dimar', 'Sfs', '', ' dnnddnnkkkdkkdkdnndnndndndnn', '1767190844_a9d1084a673e8ebfc9d4.jpg', 'pending', 16, 4, 'medium', 'Ac', NULL, NULL, NULL, '2025-12-31 21:20:44', '2025-12-31 21:20:44'),
(37, 'Zakkya Nurhadi', 'CB 2', '', 'Kursi rusak di ruangan cb 2', NULL, 'pending', 11, 4, 'low', 'Kursi', NULL, NULL, NULL, '2026-01-04 12:28:57', '2026-01-04 12:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `laporan_id` int(10) UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `admin_id`, `laporan_id`, `aktivitas`, `waktu`) VALUES
(5, 3, NULL, 'Menambah gedung: CB', '2025-12-22 12:02:46'),
(6, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-22 12:08:12'),
(7, 2, 19, 'Memverifikasi laporan #19 menjadi selesai', '2025-12-22 16:18:54'),
(19, 2, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-22 17:20:37'),
(20, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-23 04:45:47'),
(21, 3, 19, 'Memverifikasi laporan #19 menjadi selesai', '2025-12-23 05:29:17'),
(22, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-23 06:15:45'),
(23, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-24 01:53:15'),
(24, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-24 01:57:13'),
(25, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-24 01:57:41'),
(26, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-24 02:11:43'),
(27, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-24 02:13:21'),
(28, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-24 02:13:59'),
(29, 3, 19, 'Memverifikasi laporan #19 menjadi pending', '2025-12-24 02:21:25'),
(30, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-24 02:45:40'),
(31, 3, NULL, 'Menambah gedung: Lainnya', '2025-12-29 08:31:52'),
(32, 3, 34, 'Memverifikasi laporan #34 menjadi diproses', '2025-12-31 12:59:36'),
(33, 3, 20, 'Memverifikasi laporan #20 menjadi diproses', '2025-12-31 13:23:25'),
(34, 2, 34, 'Memverifikasi laporan #34 menjadi selesai', '2026-01-04 08:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-12-24-021809', 'App\\Database\\Migrations\\AddIsReadToLaporan', 'default', 'App', 1766542783, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `laporan_id` int(10) UNSIGNED DEFAULT NULL,
  `pesan` text NOT NULL,
  `terbaca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `laporan_id`, `pesan`, `terbaca`, `created_at`) VALUES
(12, 2, 21, 'Laporan baru dari Zakkya: Toilet di Lab. Kom, Lt 2', 1, '2025-12-31 11:49:50'),
(13, 3, 21, 'Laporan baru dari Zakkya: Toilet di Lab. Kom, Lt 2', 0, '2025-12-31 11:49:50'),
(38, 2, 34, 'Laporan baru dari Zakkya nurhadi: AIR di SFS. Lt 2 Toilet', 0, '2025-12-31 12:41:04'),
(39, 3, 34, 'Laporan baru dari Zakkya nurhadi: AIR di SFS. Lt 2 Toilet', 0, '2025-12-31 12:41:04'),
(42, 11, 34, 'Laporan Anda di SFS. Lt 2 Toilet sedang diproses. Keterangan: oke laporan akan segera di proses', 1, '2025-12-31 12:59:36'),
(43, 9, 20, 'Laporan Anda di Lab. Software 2 sedang diproses. Keterangan: Oke segera di proses', 1, '2025-12-31 13:23:25'),
(44, 2, 36, 'Laporan baru dari Dimar: Ac di Sfs', 0, '2025-12-31 14:20:44'),
(45, 3, 36, 'Laporan baru dari Dimar: Ac di Sfs', 0, '2025-12-31 14:20:44'),
(46, 2, 37, 'Laporan baru dari Zakkya Nurhadi: Kursi di CB 2', 0, '2026-01-04 05:28:57'),
(47, 3, 37, 'Laporan baru dari Zakkya Nurhadi: Kursi di CB 2', 0, '2026-01-04 05:28:57'),
(48, 11, 34, 'Laporan Anda di SFS. Lt 2 Toilet telah selesai dikerjakan. Keterangan: sudah di perbaiki', 0, '2026-01-04 08:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `npm` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT 'default.png',
  `role` enum('user','admin','superadmin','rektor') NOT NULL DEFAULT 'user',
  `status` enum('active','suspended') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `token_created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npm`, `nama`, `email`, `password`, `img`, `role`, `status`, `created_at`, `updated_at`, `reset_token`, `token_created_at`) VALUES
(2, 'admin', 'Admin Fasilitas', 'admin@gmail.com', '$2y$10$QuXj9wCzUTQuqDlzB7sId.IBm1oFnI/ZoWsdW6Ub4YqEULl3M5w.e', 'default.png', 'admin', 'active', '2025-12-04 09:20:14', '2025-12-13 13:54:04', NULL, NULL),
(3, 'superadmin', 'Super Administrator', 'superadmin@gmail.com', '$2y$10$M4WTw/WyQRzelWpRgSEa6.q0KKpSk7arYNRlXZbVpdgiRjcqf.o1a', 'default.png', 'superadmin', 'active', '2025-12-04 09:20:14', '2025-12-22 17:21:59', NULL, NULL),
(4, 'rektor', 'Rektor Kampus', 'rektor@gmail.com', '$2y$10$erkTwPZBwmkPOOl.vK9u.euLDcFg8kCEnumVjfGQ6s6TGMs3bnbO2', 'default.png', 'rektor', 'active', '2025-12-04 09:20:14', '2025-12-22 18:04:31', NULL, NULL),
(9, '23753041', 'Zakkya Nurhadi', 'zakygamers280605@gmail.com', '$2y$10$B5xKjffVhpZiS9CADGr71uNmeU5hXER5l2SnhyuQSKc6KZawgZhR.', 'default.jpg', 'user', 'active', '2025-12-11 17:53:58', '2025-12-31 18:17:28', NULL, NULL),
(11, '23753042', 'Zakkya Nurhadi', 'zakkya.nurhadi@gmail.com', '$2y$10$ZQ5izLt08Ld5e/g9zNJz..nlm2DEkQweKOBTw.ZdlIXyX5RIHS5Am', '1767501988_baf863c31779d8386d93.webp', 'user', 'active', '2025-12-23 21:23:13', '2026-01-04 11:46:28', NULL, NULL),
(15, '23753011', 'Cindy', 'cindynsllismail27@gmail.com', '$2y$10$porM82zrbXCHjJH0UGT9suURpu1Bi/gdbwceUu04HmvJrg5DCAZj2', 'default.png', 'user', 'active', '2025-12-31 20:07:42', '2025-12-31 20:07:42', NULL, NULL),
(16, '23753012', 'damar', 'damarghifari2@gmail.com', '$2y$10$GoC/e1qT/3L7gaj5YBZNv.RJ3aMJKC7s57sLZqcGfzy1pubO7qUsm', 'default.png', 'user', 'active', '2025-12-31 20:09:09', '2025-12-31 20:09:09', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gedung`
--
ALTER TABLE `gedung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_gedung_fk` (`gedung_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_prioritas` (`prioritas`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gedung`
--
ALTER TABLE `gedung`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_gedung_fk` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `log_aktivitas_ibfk_2` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
