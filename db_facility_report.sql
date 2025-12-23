-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2025 at 12:11 PM
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
(4, 'MH1JF5138CK284250', 'CB', 'Gedung', '2025-12-22 12:02:46', '2025-12-22 12:02:46');

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
  `ruangan_id` int UNSIGNED DEFAULT NULL,
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

INSERT INTO `laporan` (`id`, `nama_pelapor`, `lokasi_kerusakan`, `lokasi_spesifik`, `deskripsi`, `foto`, `status`, `user_id`, `gedung_id`, `ruangan_id`, `prioritas`, `kategori`, `admin_verifikator`, `tanggal_verifikasi`, `keterangan_verifikasi`, `created_at`, `updated_at`) VALUES
(19, 'Zakkya Nurhadi', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'Kerusakan Jalan', '1765685546_e6632cc6333bb7ebb57a.jpg', 'diproses', 9, 1, 1, 'low', 'dsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', NULL, '2025-12-22 12:08:12', 'Tes Log', '2025-12-14 11:12:26', '2025-12-22 19:08:12');

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
(6, 3, 19, 'Memverifikasi laporan #19 menjadi diproses', '2025-12-22 12:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `laporan_id` int UNSIGNED DEFAULT NULL,
  `pesan` text COLLATE utf8mb4_general_ci NOT NULL,
  `terbaca` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int UNSIGNED NOT NULL,
  `gedung_id` int UNSIGNED NOT NULL,
  `nama_ruangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lantai` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `gedung_id`, `nama_ruangan`, `lantai`) VALUES
(1, 1, '2.1', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `npm` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'default.png',
  `role` enum('user','admin','superadmin','rektor') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `status` enum('active','suspended') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npm`, `nama`, `email`, `password`, `img`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, '2023000001', 'Mahasiswa Satu', 'mahasiswa1@gmail.com', '$2y$10$m2DV03ok8jZJFOMRI43VBu5Uj7sZzQtaSWFkWTR/zw59tThF1kYz6', 'default.png', 'user', 'active', '2025-12-04 09:20:14', '2025-12-04 09:20:14'),
(2, 'admin', 'Admin Fasilitas', 'admin@gmail.com', '$2y$10$QuXj9wCzUTQuqDlzB7sId.IBm1oFnI/ZoWsdW6Ub4YqEULl3M5w.e', 'default.png', 'admin', 'active', '2025-12-04 09:20:14', '2025-12-13 13:54:04'),
(3, 'superadmin', 'Super Administrator', 'superadmin@gmail.com', '$2y$10$M4WTw/WyQRzelWpRgSEa6.q0KKpSk7arYNRlXZbVpdgiRjcqf.o1a', 'default.png', 'superadmin', 'active', '2025-12-04 09:20:14', '2025-12-22 17:21:59'),
(4, 'rektor', 'Rektor Kampus', 'rektor@gmail.com', '$2y$10$erkTwPZBwmkPOOl.vK9u.euLDcFg8kCEnumVjfGQ6s6TGMs3bnbO2', 'default.png', 'rektor', 'active', '2025-12-04 09:20:14', '2025-12-22 18:04:31'),
(5, '2023000001', 'Muhammad Arya Fadli', 'dadaww@gmail.com', '$2y$10$CvXdNN4q.Ay1vwLFuR2P1.atz5C4rHd.CDOtIDtCIWiZrsoZSwTvS', 'default.png', 'user', 'suspended', '2025-12-11 16:48:41', '2025-12-11 17:54:09'),
(7, '2023000001', 'Muhammad Arya Fadli', 'dadawwas@gmail.com', '$2y$10$uf1uDjqs7etGMeCYajeBIO.GaX.3kACc3v73Hixe57n.Lh9UDy5Uy', 'default.png', 'admin', 'active', '2025-12-11 16:49:03', '2025-12-11 16:49:03'),
(9, '23753041', 'Zakkya', 'arya56735272@gmail.com', '$2y$10$B5xKjffVhpZiS9CADGr71uNmeU5hXER5l2SnhyuQSKc6KZawgZhR.', '1765631403_e1db43738510ff09b85c.jpeg', 'user', 'active', '2025-12-11 17:53:58', '2025-12-13 20:27:55');

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
