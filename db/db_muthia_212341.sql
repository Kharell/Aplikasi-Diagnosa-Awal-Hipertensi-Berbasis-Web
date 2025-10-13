-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2025 at 05:24 PM
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
  `212341_username` varchar(100) NOT NULL,
  `212341_password` varchar(255) NOT NULL,
  `212341_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `212341_admin`
--

INSERT INTO `212341_admin` (`212341_admin_id`, `212341_username`, `212341_password`, `212341_created_at`) VALUES
(1, 'admin', 'admin123', '2025-09-29 03:40:57'),
(2, 'mutia', 'mutia123', '2025-09-29 20:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `212341_diagnosa`
--

CREATE TABLE `212341_diagnosa` (
  `212341_diagnosa_id` int NOT NULL,
  `212341_rekam_id` int NOT NULL,
  `212341_klasifikasi` enum('Normal','Hipertensi','Pre-Hipertensi') NOT NULL,
  `212341_hasil` text,
  `212341_tanggal_hasil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `212341_pasien`
--

CREATE TABLE `212341_pasien` (
  `212341_pasien_id` int NOT NULL,
  `212341_nama` varchar(100) NOT NULL,
  `212341_umur` int NOT NULL,
  `212341_alamat` varchar(255) DEFAULT NULL,
  `212341_jk` enum('Laki-laki','Perempuan') NOT NULL,
  `212341_berat_badan` decimal(5,2) DEFAULT NULL,
  `212341_riwayat_tekanan` text,
  `212341_pola_makan` text,
  `212341_riwayat_keluarga` enum('Ya','Tidak') DEFAULT 'Tidak',
  `212341_keluhan` text,
  `212341_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `212341_pasien`
--

INSERT INTO `212341_pasien` (`212341_pasien_id`, `212341_nama`, `212341_umur`, `212341_alamat`, `212341_jk`, `212341_berat_badan`, `212341_riwayat_tekanan`, `212341_pola_makan`, `212341_riwayat_keluarga`, `212341_keluhan`, `212341_created_at`) VALUES
(2, 'Andi Wijaya', 50, 'Jl. Kenanga No. 8', 'Laki-laki', '90.20', 'Pernah naik tekanan darah saat stres', 'Sering makan gorengan dan kurang olahraga', 'Ya', 'Kadang jantung berdebar dan nyeri dada', '2025-10-01 01:40:58'),
(16, 'Karolus Jone Kalang', 33, 'Makassar Jl. Bung No.1', 'Laki-laki', '33.00', 'Dari ayah', 'Tidak sehat dan makan makanan siap saji', 'Ya', 'Sakit kepala dan pusing dan susah tidur', '2025-10-13 15:49:48');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  MODIFY `212341_admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  MODIFY `212341_diagnosa_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `212341_pasien`
--
ALTER TABLE `212341_pasien`
  MODIFY `212341_pasien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  MODIFY `212341_rekam_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  ADD CONSTRAINT `212341_diagnosa_ibfk_1` FOREIGN KEY (`212341_rekam_id`) REFERENCES `212341_rekam_medis` (`212341_rekam_id`) ON DELETE CASCADE;

--
-- Constraints for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  ADD CONSTRAINT `212341_rekam_medis_ibfk_1` FOREIGN KEY (`212341_pasien_id`) REFERENCES `212341_pasien` (`212341_pasien_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
