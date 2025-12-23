-- =========================================
-- SQL untuk membuat tabel notifikasi
-- =========================================

CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `laporan_id` INT(11) NULL DEFAULT NULL,
  `pesan` TEXT NOT NULL,
  `terbaca` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_laporan_id` (`laporan_id`),
  INDEX `idx_terbaca` (`terbaca`),
  INDEX `idx_created_at` (`created_at`),
  CONSTRAINT `fk_notifikasi_user` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_notifikasi_laporan` FOREIGN KEY (`laporan_id`) 
    REFERENCES `laporan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================
-- Contoh data dummy untuk testing
-- =========================================
-- INSERT INTO `notifikasi` (`user_id`, `laporan_id`, `pesan`, `terbaca`, `created_at`) VALUES
-- (1, 1, 'Laporan Anda di Gedung A sedang diproses.', 0, NOW()),
-- (1, 2, 'Laporan Anda di Lab Komputer telah selesai dikerjakan.', 1, NOW()),
-- (1, 3, 'Laporan Anda di Ruang Kelas 101 ditolak. Keterangan: Data tidak lengkap.', 0, NOW());
