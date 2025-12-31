-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2025 at 01:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_facility_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `gedung`
--

CREATE TABLE `gedung` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
  `id` int UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi_kerusakan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi_spesifik` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','diproses','selesai','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `user_id` int UNSIGNED DEFAULT NULL,
  `gedung_id` int UNSIGNED DEFAULT NULL,
  `prioritas` enum('low','medium','high') COLLATE utf8mb4_general_ci DEFAULT 'medium',
  `kategori` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `admin_verifikator` int UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `keterangan_verifikasi` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama_pelapor`, `lokasi_kerusakan`, `lokasi_spesifik`, `deskripsi`, `foto`, `status`, `user_id`, `gedung_id`, `prioritas`, `kategori`, `admin_verifikator`, `tanggal_verifikasi`, `keterangan_verifikasi`, `created_at`, `updated_at`) VALUES
(19, 'Zakkya Nurhadi', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Kerusakan Jalan', '1765685546_e6632cc6333bb7ebb57a.jpg', 'diproses', 9, 1, 'low', 'Keamanan', NULL, '2025-12-24 02:45:40', 'tessssssss', '2025-12-14 11:12:26', '2025-12-24 09:45:40'),
(20, 'Zakkya', 'Lab. Software 2', '', 'Masalah AC tidak dingin', NULL, 'pending', 9, 2, 'low', 'AC', NULL, NULL, NULL, '2025-12-31 18:43:05', '2025-12-31 18:43:05'),
(21, 'Zakkya', 'Lab. Kom, Lt 2', '', 'Air tidak ada habis dan air bocor', '1767181790_84ba8ec7518ebb85ea52.jpg', 'pending', 11, 3, 'low', 'Toilet', NULL, NULL, NULL, '2025-12-31 18:49:50', '2025-12-31 18:49:50'),
(34, 'Zakkya nurhadi', 'SFS. Lt 2 Toilet', '', 'Masalah air mampet pada toilet', '1767184864_df6f84a662a1010da09c.jpeg', 'diproses', 11, 2, 'low', 'AIR', NULL, '2025-12-31 12:59:36', 'oke laporan akan segera di proses', '2025-12-31 19:41:04', '2025-12-31 19:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int UNSIGNED NOT NULL,
  `admin_id` int UNSIGNED NOT NULL,
  `laporan_id` int UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
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
(32, 3, 34, 'Memverifikasi laporan #34 menjadi diproses', '2025-12-31 12:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
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
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `laporan_id` int UNSIGNED DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_general_ci NOT NULL,
  `terbaca` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `laporan_id`, `pesan`, `terbaca`, `created_at`) VALUES
(3, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa menunggu verifikasi. Keterangan: tessssssssss', 1, '2025-12-23 06:15:45'),
(6, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa menunggu verifikasi. Keterangan: laporan telah diterima\n', 0, '2025-12-24 01:57:41'),
(11, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa sedang diproses. Keterangan: tessssssss', 0, '2025-12-24 02:45:40'),
(12, 2, 21, 'Laporan baru dari Zakkya: Toilet di Lab. Kom, Lt 2', 1, '2025-12-31 11:49:50'),
(13, 3, 21, 'Laporan baru dari Zakkya: Toilet di Lab. Kom, Lt 2', 0, '2025-12-31 11:49:50'),
(38, 2, 34, 'Laporan baru dari Zakkya nurhadi: AIR di SFS. Lt 2 Toilet', 0, '2025-12-31 12:41:04'),
(39, 3, 34, 'Laporan baru dari Zakkya nurhadi: AIR di SFS. Lt 2 Toilet', 0, '2025-12-31 12:41:04'),
(42, 11, 34, 'Laporan Anda di SFS. Lt 2 Toilet sedang diproses. Keterangan: oke laporan akan segera di proses', 1, '2025-12-31 12:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `npm` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.png',
  `role` enum('user','admin','superadmin','rektor') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `status` enum('active','suspended') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
(11, '23753042', 'Zakkya Nurhadi', 'zakkya.nurhadi@gmail.com', '$2y$10$sJm5igddob3.CLOU3grfwuioF.NpyGhdDZ64ovxjWq20qZPB.nELK', '1767186298_2ad512959db4f61f1294.png', 'user', 'active', '2025-12-23 21:23:13', '2025-12-31 20:04:58', '28ce91c8b0fec279500c760131bf78de997c82c83cc995f18c4c3962290bae2c', '2025-12-23 14:33:52'),
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
  ADD KEY `laporan_gedung_fk` (`gedung_id`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
