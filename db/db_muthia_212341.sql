-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 30, 2025 at 06:46 AM
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
(33, 51, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat.', '2025-10-30'),
(34, 52, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat.', '2025-10-30'),
(35, 53, 'Normal', 'Tekanan darah normal.', '2025-10-30');

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
(53, 'Patrik Tangdilintin ', 67, 'Makassar Jl. Landak No.5', 'Laki-laki', '88.00', 'Pernah tekanan darah tinggi, Sering stres berat', 'Sering makan gorengan, Sering minum kopi, Jarang makan sayur', 'Ya', 'Pusing, Sesak Napas, Jantung Berdebar', '2025-10-30 06:40:17'),
(54, 'Karolus Jone Kalang', 77, 'Makassar Jl. Bung No.5', 'Laki-laki', '90.00', 'Sering stres berat', 'Sering minum kopi, Jarang makan sayur', 'Tidak', 'Sesak Napas, Jantung Berdebar', '2025-10-30 06:42:55'),
(55, 'Mayanti Selseplia ', 66, 'Makassar BPT', 'Perempuan', '77.00', 'Pernah tekanan darah tinggi', 'Sering makan gorengan, Jarang makan sayur', 'Ya', 'Pusing', '2025-10-30 06:44:14');

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
(51, 53, 135, 88, '2025-10-30'),
(52, 54, 124, 99, '2025-10-30'),
(53, 55, 100, 77, '2025-10-30');

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
  MODIFY `212341_admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `212341_diagnosa`
--
ALTER TABLE `212341_diagnosa`
  MODIFY `212341_diagnosa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `212341_pasien`
--
ALTER TABLE `212341_pasien`
  MODIFY `212341_pasien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `212341_rekam_medis`
--
ALTER TABLE `212341_rekam_medis`
  MODIFY `212341_rekam_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
