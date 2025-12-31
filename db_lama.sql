-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2025 at 08:10 PM
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
-- Database: `db_facility_report`
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
(4, 'MH1JF5138CK284250', 'CB', 'Gedung', '2025-12-22 12:02:46', '2025-12-22 12:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `lokasi_kerusakan` varchar(255) NOT NULL,
  `lokasi_spesifik` varchar(255) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('pending','diproses','selesai','ditolak') DEFAULT 'pending',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `gedung_id` int(10) UNSIGNED DEFAULT NULL,
  `ruangan_id` int(10) UNSIGNED DEFAULT NULL,
  `prioritas` enum('low','medium','high') DEFAULT 'medium',
  `kategori` varchar(100) NOT NULL,
  `admin_verifikator` int(10) UNSIGNED DEFAULT NULL,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `keterangan_verifikasi` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama_pelapor`, `lokasi_kerusakan`, `lokasi_spesifik`, `deskripsi`, `foto`, `status`, `user_id`, `gedung_id`, `ruangan_id`, `prioritas`, `kategori`, `admin_verifikator`, `tanggal_verifikasi`, `keterangan_verifikasi`, `created_at`, `updated_at`) VALUES
(19, 'Zakkya Nurhadi', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Kerusakan Jalan', '1765685546_e6632cc6333bb7ebb57a.jpg', 'selesai', 9, 1, 2, 'low', 'Keamanan', NULL, '2025-12-24 02:40:05', 'dcccssccs', '2025-12-14 11:12:26', '2025-12-24 09:40:05'),
(20, 'Damar', 'Sfs', 'Loook', 'Mxmnx', '1766903239_b160b6216ef07903f9dd.jpeg', 'pending', 12, 3, 2, 'medium', 'Network', NULL, NULL, NULL, '2025-12-28 13:27:19', '2025-12-31 17:05:22'),
(21, 'susi', 'lantai 2', 'ruangan belakang', 'kursi rusak dibelakang ruangan', '1767080286_2ac870d262723e9bcc53.png', 'diproses', 13, 2, NULL, 'medium', 'fasilitas', NULL, '2025-12-30 07:40:12', 'Sedang Pengajuan Perbaikan', '2025-12-30 14:38:06', '2025-12-30 14:40:12');

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
(23, 2, 19, 'Memverifikasi laporan #19 menjadi selesai', '2025-12-24 02:39:00'),
(24, 2, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-24 02:39:20'),
(25, 2, 19, 'Memverifikasi laporan #19 menjadi selesai', '2025-12-24 02:40:05'),
(26, 2, 21, 'Memverifikasi laporan #21 menjadi diproses', '2025-12-30 07:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `laporan_id` int(10) UNSIGNED DEFAULT NULL,
  `pesan` text NOT NULL,
  `terbaca` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `laporan_id`, `pesan`, `terbaca`, `created_at`) VALUES
(1, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa sedang diproses. Keterangan: tesssssssss', 1, '2025-12-23 04:45:47'),
(2, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa telah selesai dikerjakan. Keterangan: tesssssss', 1, '2025-12-23 05:29:17'),
(3, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa menunggu verifikasi. Keterangan: tessssssssss', 1, '2025-12-23 06:15:45'),
(6, 9, 19, 'Laporan Anda di dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa telah selesai dikerjakan. Keterangan: dcccssccs', 1, '2025-12-24 02:40:05'),
(7, 13, 21, 'Laporan Anda di lantai 2 sedang diproses. Keterangan: Sedang Pengajuan Perbaikan', 0, '2025-12-30 07:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int(10) UNSIGNED NOT NULL,
  `gedung_id` int(10) UNSIGNED NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `lantai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `gedung_id`, `nama_ruangan`, `lantai`) VALUES
(1, 1, '2.1', '2'),
(2, 1, 'lainnya', 'lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `npm` varchar(20) DEFAULT NULL,
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
(1, '2023000001', 'Mahasiswa Satu', 'mahasiswa1@gmail.com', '$2y$10$m2DV03ok8jZJFOMRI43VBu5Uj7sZzQtaSWFkWTR/zw59tThF1kYz6', 'default.png', 'user', 'active', '2025-12-04 09:20:14', '2025-12-04 09:20:14', NULL, NULL),
(2, 'admin', 'Admin Fasilitas', 'admin@gmail.com', '$2y$10$QuXj9wCzUTQuqDlzB7sId.IBm1oFnI/ZoWsdW6Ub4YqEULl3M5w.e', 'default.png', 'admin', 'active', '2025-12-04 09:20:14', '2025-12-13 13:54:04', NULL, NULL),
(3, 'superadmin', 'Super Administrator', 'superadmin@gmail.com', '$2y$10$M4WTw/WyQRzelWpRgSEa6.q0KKpSk7arYNRlXZbVpdgiRjcqf.o1a', 'default.png', 'superadmin', 'active', '2025-12-04 09:20:14', '2025-12-22 17:21:59', NULL, NULL),
(4, 'rektor', 'Rektor Kampus', 'rektor@gmail.com', '$2y$10$erkTwPZBwmkPOOl.vK9u.euLDcFg8kCEnumVjfGQ6s6TGMs3bnbO2', 'default.png', 'rektor', 'active', '2025-12-04 09:20:14', '2025-12-22 18:04:31', NULL, NULL),
(5, '2023000001', 'Muhammad Arya Fadli', 'dadaww@gmail.com', '$2y$10$CvXdNN4q.Ay1vwLFuR2P1.atz5C4rHd.CDOtIDtCIWiZrsoZSwTvS', 'default.png', 'user', 'suspended', '2025-12-11 16:48:41', '2025-12-11 17:54:09', NULL, NULL),
(9, '23753041', 'Zakkya Nurhadi', 'zakygamers280605@gmail.com', '$2y$10$B5xKjffVhpZiS9CADGr71uNmeU5hXER5l2SnhyuQSKc6KZawgZhR.', '1765631403_e1db43738510ff09b85c.jpeg', 'user', 'active', '2025-12-11 17:53:58', '2025-12-23 21:21:40', NULL, NULL),
(11, '23753042', 'Zakkya Nurhadi', 'zakkya.nurhadi@gmail.com', '$2y$10$/GfXoKRl8Ewg5oirEe/dcugfSxOpxuZZ/4kjz/eo8UgBl/hljmn.y', 'default.jpg', 'user', 'active', '2025-12-23 21:23:13', '2025-12-28 13:22:07', NULL, NULL),
(12, '23753011', 'Cindy', 'cindynsllismail27@gmail.com', '$2y$10$DJ0a/0HQZUIrrrgxA0ODNefaKBkGlpGj9OvBki.V30d6.pxh07ZQ2', 'default.jpg', 'user', 'active', '2025-12-24 14:42:59', '2025-12-24 14:44:37', '0619aaf9f8d02aa6b7ec7647a79b7ab178d6be87af7057e4374522ce3451229d', '2025-12-24 07:44:37'),
(13, '23753012', 'damar', 'damarghifari2@gmail.com', '$2y$10$LBLaYKcineyqIZCsyUSvvuV6iZuWpuUnCunhELWGSUAfu6P22hzZS', '1767077835_94c0226b4d2039677b57.png', 'user', 'active', '2025-12-28 13:49:06', '2025-12-30 13:57:15', NULL, NULL),
(14, '23753016', 'Damar', 'damarghifari7@gmail.com', '$2y$10$cyDi/pOGFnkUXScWQglPM.5PQkzxgZ2fwFAtCBv1a1JDfutqRQgle', 'default.jpg', 'user', 'active', '2025-12-30 21:46:52', '2025-12-30 21:46:52', NULL, NULL);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gedung_id` (`gedung_id`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

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

--
-- Constraints for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `ruangan_ibfk_1` FOREIGN KEY (`gedung_id`) REFERENCES `gedung` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
