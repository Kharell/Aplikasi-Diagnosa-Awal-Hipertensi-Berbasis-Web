-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2025 at 03:59 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_muthia_212341`
--

-- --------------------------------------------------------

--
-- Table structure for table `212341_admin`
--

CREATE TABLE `212341_admin` (
  `212341_admin_id` int NOT NULL,
  `212341_username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `212341_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `212341_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `212341_admin`
--

INSERT INTO `212341_admin` (`212341_admin_id`, `212341_username`, `212341_password`, `212341_created_at`) VALUES
(1, 'admin', 'admin123', '2025-09-28 19:40:57'),
(2, 'mutia', 'mutia123', '2025-09-29 12:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `212341_diagnosa`
--

CREATE TABLE `212341_diagnosa` (
  `212341_diagnosa_id` int NOT NULL,
  `212341_rekam_id` int NOT NULL,
  `212341_klasifikasi` enum('Normal','Hipertensi','Pre-Hipertensi') COLLATE utf8mb4_general_ci NOT NULL,
  `212341_hasil` text COLLATE utf8mb4_general_ci,
  `212341_tanggal_hasil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `212341_diagnosa`
--

INSERT INTO `212341_diagnosa` (`212341_diagnosa_id`, `212341_rekam_id`, `212341_klasifikasi`, `212341_hasil`, `212341_tanggal_hasil`) VALUES
(8, 12, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-16'),
(12, 15, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-17'),
(19, 40, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-20'),
(24, 45, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-20'),
(25, 46, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-20'),
(26, 12, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-16'),
(27, 12, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat', '2025-10-16'),
(28, 46, 'Hipertensi', 'Segera periksa ke dokter. Tekanan darah tinggi', '2025-10-20'),
(29, 47, 'Normal', 'Tekanan darah normal', '2025-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `212341_pasien`
--

CREATE TABLE `212341_pasien` (
  `212341_pasien_id` int NOT NULL,
  `212341_nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `212341_umur` int NOT NULL,
  `212341_alamat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `212341_jk` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `212341_berat_badan` decimal(5,2) DEFAULT NULL,
  `212341_riwayat_tekanan` text COLLATE utf8mb4_general_ci,
  `212341_pola_makan` text COLLATE utf8mb4_general_ci,
  `212341_riwayat_keluarga` enum('Ya','Tidak') COLLATE utf8mb4_general_ci DEFAULT 'Tidak',
  `212341_keluhan` text COLLATE utf8mb4_general_ci,
  `212341_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `212341_pasien`
--

INSERT INTO `212341_pasien` (`212341_pasien_id`, `212341_nama`, `212341_umur`, `212341_alamat`, `212341_jk`, `212341_berat_badan`, `212341_riwayat_tekanan`, `212341_pola_makan`, `212341_riwayat_keluarga`, `212341_keluhan`, `212341_created_at`) VALUES
(2, 'Andi Wijaya', 50, 'Jl. Kenanga No. 8', 'Laki-laki', '90.20', 'Pernah naik tekanan darah saat stres', 'Sering makan gorengan dan kurang olahraga', 'Ya', 'Kadang jantung berdebar dan nyeri dada', '2025-09-30 17:40:58'),
(22, 'Mayanti Sepselia', 55, 'Makassar Jl. Bung', 'Perempuan', '40.00', 'Dari orang tua ', 'Makan makanan siap saji dan micin berlebihan', 'Ya', 'Sering pusing dan sakit kepala serta sakit di dada', '2025-10-17 11:32:46'),
(42, 'Patrik Tangdilintin ', 34, 'Makassar', 'Laki-laki', '78.00', '56', 'Makan makanan siap saji', 'Ya', 'Sakit Pinggang dan pusing', '2025-10-20 08:26:55'),
(47, 'Karolus Jone Kalang', 26, 'Makassar Jl. Bung No.5', 'Laki-laki', '56.00', 'Dari Keluarga Terutama IBU', 'Makan makanan siap saji dan micin', 'Ya', 'Pusing dan sakir kepala dan mual muntah', '2025-10-20 08:55:03'),
(48, 'Muhamad Jalil', 33, 'Makassar BPT', 'Laki-laki', '77.00', 'Dari Keturunan nenek', 'Makan makanan dengan micin dan minum minuman botol terlalu sering', 'Ya', 'Pusing dan sakit kepala kalau terlalu lama duduk', '2025-10-20 08:58:45'),
(49, 'Afdal Haq', 55, 'Makassar Jl. Landak No.5', 'Laki-laki', '78.00', 'Dari keluarga', 'Makan makanan siap saji ', 'Ya', 'Pusing dan sering stres dan cepat emosi', '2025-10-20 09:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `212341_rekam_medis`
--

CREATE TABLE `212341_rekam_medis` (
  `212341_rekam_id` int NOT NULL,
  `212341_pasien_id` int NOT NULL,
  `212341_tekanan_sistol` int NOT NULL,
  `212341_tekanan_diastol` int NOT NULL,
  `212341_tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `212341_rekam_medis`
--

INSERT INTO `212341_rekam_medis` (`212341_rekam_id`, `212341_pasien_id`, `212341_tekanan_sistol`, `212341_tekanan_diastol`, `212341_tanggal_input`) VALUES
(12, 2, 80, 81, '2025-10-16'),
(15, 22, 130, 90, '2025-10-17'),
(40, 42, 123, 99, '2025-10-20'),
(45, 47, 110, 80, '2025-10-20'),
(46, 48, 170, 150, '2025-10-20'),
(47, 49, 22, 22, '2025-10-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `212341_admin`
--
ALTER TABLE `212341_admin`
  ADD PRIMARY KEY (`212341_admin_id`),
  ADD UNIQUE KEY `212341_username` (`212341_username`);

--
-- Indexes for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  ADD PRIMARY KEY (`212341_diagnosa_id`),
  ADD KEY `fk_rekam` (`212341_rekam_id`);

--
-- Indexes for table `212341_pasien`
--
ALTER TABLE `212341_pasien`
  ADD PRIMARY KEY (`212341_pasien_id`);

--
-- Indexes for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  ADD PRIMARY KEY (`212341_rekam_id`),
  ADD KEY `fk_pasien` (`212341_pasien_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `212341_admin`
--
ALTER TABLE `212341_admin`
  MODIFY `212341_admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  MODIFY `212341_diagnosa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `212341_pasien`
--
ALTER TABLE `212341_pasien`
  MODIFY `212341_pasien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  MODIFY `212341_rekam_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  ADD CONSTRAINT `212341_diagnosa_ibfk_1` FOREIGN KEY (`212341_rekam_id`) REFERENCES `212341_rekam_medis` (`212341_rekam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  ADD CONSTRAINT `212341_rekam_medis_ibfk_1` FOREIGN KEY (`212341_pasien_id`) REFERENCES `212341_pasien` (`212341_pasien_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
