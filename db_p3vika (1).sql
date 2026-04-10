-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2026 at 11:01 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_p3vika`
--

-- --------------------------------------------------------

--
-- Table structure for table `aspirasi`
--

CREATE TABLE `aspirasi` (
  `id_aspirasi` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Menunggu','Proses','Selesai') DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aspirasi`
--

INSERT INTO `aspirasi` (`id_aspirasi`, `user_id`, `id_kategori`, `lokasi`, `keterangan`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, 1, 'kelas 12 rpl', 'meja patah', 'aspirasi_foto/1775657829_555ef5680423bd083f8b4567.jpeg', 'Selesai', '2026-04-08 07:17:09', '2026-04-08 07:38:55'),
(3, 4, 2, 'kelas 12 rpl', 'kursinya udah rusak', 'aspirasi_foto/1775660968_Screenshot_20250115_131355_WhatsApp.jpg', 'Proses', '2026-04-08 08:09:28', '2026-04-08 08:12:08'),
(4, 4, 4, 'kelas 12 rpl', 'pintu rusak', 'aspirasi_foto/1775661066_download1.jpg', 'Menunggu', '2026-04-08 08:11:06', '2026-04-08 08:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `mata_pelajaran` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama`, `mata_pelajaran`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 3, '2317628317862', 'guru edit', 'animator', 'L', '2026-04-11', 'padasuka', '9987765447333', NULL, '2026-04-06 23:01:42', '2026-04-09 22:40:05'),
(2, NULL, '22110000', 'guru', 'indonesia', 'P', '2026-04-04', 'lllll', '0999999997', 'guru/evFRZ6ubox8YB8LggMLYBdvHl7OxyE5dFNJWqyHY.png', '2026-04-10 00:36:10', '2026-04-10 03:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `history_status`
--

CREATE TABLE `history_status` (
  `id_history` int NOT NULL,
  `id_aspirasi` int DEFAULT NULL,
  `status_lama` enum('Menunggu','Proses','Selesai') DEFAULT NULL,
  `status_baru` enum('Menunggu','Proses','Selesai') DEFAULT NULL,
  `diubah_oleh` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `history_status`
--

INSERT INTO `history_status` (`id_history`, `id_aspirasi`, `status_lama`, `status_baru`, `diubah_oleh`, `created_at`) VALUES
(1, 2, 'Menunggu', 'Proses', 3, '2026-04-08 14:19:59'),
(2, 2, 'Proses', 'Selesai', 3, '2026-04-08 14:38:55'),
(3, 3, 'Menunggu', 'Proses', 3, '2026-04-08 15:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Meja', 'meja siswa', '2026-04-07 10:20:55'),
(2, 'kursi', 'kursi siswa', '2026-04-07 10:49:37'),
(3, 'papan tulis', 'papan tulis', '2026-04-07 10:49:46'),
(4, 'pintu', 'pintu kelas', '2026-04-08 13:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progres`
--

CREATE TABLE `progres` (
  `id_progres` int NOT NULL,
  `id_aspirasi` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `keterangan_progres` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progres`
--

INSERT INTO `progres` (`id_progres`, `id_aspirasi`, `user_id`, `keterangan_progres`, `created_at`) VALUES
(2, 2, 3, 'Feedback: sekolah akan secepatnya mengganti meja', '2026-04-08 14:19:59'),
(3, 2, 3, 'segera', '2026-04-08 14:22:41'),
(4, 3, 3, 'Feedback: kami akan secepatnya mengganti yang baru', '2026-04-08 15:11:36'),
(5, 3, 3, 'kursi sekarang sedang di perbaiki', '2026-04-08 15:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `user_id`, `nis`, `nama`, `kelas`, `jurusan`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `no_hp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 4, '2324102576', 'siswa', '12', 'rpl', 'L', '2026-04-10', 'cimahi', '081726517251', 'foto_profil/1775631955_download.jpg', '2026-04-06 23:26:35', '2026-04-08 00:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('siswa','guru','admin') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'admin@ukk2026.com', '$2y$12$eWoqe0yVBGoLlXUXDv3uhe8iCfrj2x8.nlXqkl1P0Wo.zpnL2SXYW', 'admin', '2026-04-06 22:07:15', '2026-04-07 23:22:34'),
(3, 'guru@ukk2026.com', '$2y$12$ycQ/LUgULj12TboE77oQC.XteHRUnFhCPsMvEJenwTc02cW3sEn4W', 'guru', '2026-04-06 23:01:42', '2026-04-07 23:22:58'),
(4, 'siswa@ukk2026.com', '$2y$12$K1HSg0W7r5bIKqGeAy0jyudWDrbz.RZIxhZy.EeUwNwWTFDx5Bv1O', 'siswa', '2026-04-06 23:26:35', '2026-04-07 23:23:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `history_status`
--
ALTER TABLE `history_status`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_aspirasi` (`id_aspirasi`),
  ADD KEY `diubah_oleh` (`diubah_oleh`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progres`
--
ALTER TABLE `progres`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `id_aspirasi` (`id_aspirasi`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `aspirasi`
--
ALTER TABLE `aspirasi`
  MODIFY `id_aspirasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `history_status`
--
ALTER TABLE `history_status`
  MODIFY `id_history` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progres`
--
ALTER TABLE `progres`
  MODIFY `id_progres` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aspirasi`
--
ALTER TABLE `aspirasi`
  ADD CONSTRAINT `aspirasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aspirasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `history_status`
--
ALTER TABLE `history_status`
  ADD CONSTRAINT `history_status_ibfk_1` FOREIGN KEY (`id_aspirasi`) REFERENCES `aspirasi` (`id_aspirasi`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_status_ibfk_2` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progres`
--
ALTER TABLE `progres`
  ADD CONSTRAINT `progres_ibfk_1` FOREIGN KEY (`id_aspirasi`) REFERENCES `aspirasi` (`id_aspirasi`) ON DELETE CASCADE,
  ADD CONSTRAINT `progres_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
