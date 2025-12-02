-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2025 at 05:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_kerusakan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi_spesifik` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_kerusakan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tingkat_prioritas` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi_kerusakan` text COLLATE utf8mb4_general_ci NOT NULL,
  `foto_kerusakan` text COLLATE utf8mb4_general_ci,
  `status` enum('Pending','Diproses','Selesai') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `keterangan_verifikasi` text COLLATE utf8mb4_general_ci,
  `tanggal_verifikasi` datetime DEFAULT NULL,
  `verifikator` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `nama`, `npm`, `lokasi_kerusakan`, `lokasi_spesifik`, `kategori_kerusakan`, `tingkat_prioritas`, `deskripsi_kerusakan`, `foto_kerusakan`, `status`, `created_at`, `updated_at`, `keterangan_verifikasi`, `tanggal_verifikasi`, `verifikator`) VALUES
(1, 'MuhammadAryaFadli', '23753024', 'gedung-a', 'Ruangan 10 lanti 1 ', 'lainnya', 'sedang', 'KERUSAKAN KURSI YANG MENGAKIBATKAN JATUHNYA MAHASISWA', '[\"1750063089_7bd80f638b39f1b276f0.png\"]', 'Selesai', '2025-06-16 08:38:09', '2025-06-23 03:28:32', 'dadad', '2025-06-23 03:28:32', 'admingaul'),
(2, 'MuhammadAryaFadli', '23753024', 'lainnya', 'gedung h', 'air', 'tinggi', 'air wc mati tidak bisa digunakan', '[]', 'Selesai', '2025-06-23 01:34:23', '2025-06-23 03:30:43', 'Selesai yaa', '2025-06-23 03:30:43', 'admingaul'),
(3, 'Zakkya Nurhadi', '23753041', 'lainnya', 'Gedung SFS 3', 'air', 'sedang', 'Air tidak ada', '[\"1763892672_41d9c53953c50ae9ef0b.jpeg\"]', 'Pending', '2025-11-23 10:11:12', '2025-11-23 10:11:12', NULL, NULL, NULL);

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
(1, '2025-06-15-141758', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1750060331, 1),
(2, '2025-06-15-141846', 'App\\Database\\Migrations\\CreateLaporanTable', 'default', 'App', 1750060331, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `npm` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default.jpg',
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npm`, `nama`, `email`, `password`, `img`, `role`) VALUES
(1, '23753041', 'Zakkya Nurhadi', 'zaky@gmail.com', '$2y$10$sgT7a6Mquw70vUbXI2ywy.OKnasQHgZnegVf.Hl0YDTHIl0IeWvau', 'default.jpg', 'user'),
(2, '55667788', 'Citra Lestari', 'citra.lestari@email.com', '$2y$10$L0gGjPDubAeHs21KgR8IoeGHdvBAD3.X2sTZjrkxDES1Z6VvRUabK', 'default.jpg', 'user'),
(3, '87654321', 'Agus Setiawan', NULL, '$2y$10$kTaIGnpx9nSOr2k9pHyI.eQPvA71y0Mq1OUtHHXBSgWH8YYUGm.kS', 'default.jpg', 'user'),
(5, '23753024', 'MuhammadAryaFadli', 'aryafadli@email.com', '$2y$10$Ryykfvwkk2nojTB7j2TVp.YPzCzbBFvtnjxke.sFuVfEEOL7zjvNC', 'default.jpg', 'user'),
(6, 'admin', 'admingaul', 'admin@gmail.com', '$2y$10$AutQMUIq3W4j/r.IAnzzxeCnERd4/7YvzcmJoNEkZ9dGiESVqxNsi', 'default.jpg', 'admin'),
(7, '23753021', 'saadadada', 'gw@gmail.com', '$2y$10$3mW/CA4CgzE6EnNkNqAlnOiNwgytPPDRaarey9uUBXFdL0oM1eucC', 'default.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `npm` (`npm`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
