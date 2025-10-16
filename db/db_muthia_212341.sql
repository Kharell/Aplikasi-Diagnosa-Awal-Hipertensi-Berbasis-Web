-- Database: db_muthia_212341
CREATE DATABASE IF NOT EXISTS db_muthia_212341 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_muthia_212341;

SET FOREIGN_KEY_CHECKS=0;

-- --------------------------------------------------------
-- Table: 212341_admin
-- --------------------------------------------------------
CREATE TABLE `212341_admin` (
  `212341_admin_id` INT NOT NULL AUTO_INCREMENT,
  `212341_username` VARCHAR(100) NOT NULL,
  `212341_password` VARCHAR(255) NOT NULL,
  `212341_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`212341_admin_id`),
  UNIQUE KEY `212341_username` (`212341_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `212341_admin` (`212341_admin_id`, `212341_username`, `212341_password`, `212341_created_at`) VALUES
(1, 'admin', 'admin123', '2025-09-29 03:40:57'),
(2, 'mutia', 'mutia123', '2025-09-29 20:11:40');

-- --------------------------------------------------------
-- Table: 212341_pasien
-- --------------------------------------------------------
CREATE TABLE `212341_pasien` (
  `212341_pasien_id` INT NOT NULL AUTO_INCREMENT,
  `212341_nama` VARCHAR(100) NOT NULL,
  `212341_umur` INT NOT NULL,
  `212341_alamat` VARCHAR(255) DEFAULT NULL,
  `212341_jk` ENUM('Laki-laki','Perempuan') NOT NULL,
  `212341_berat_badan` DECIMAL(5,2) DEFAULT NULL,
  `212341_riwayat_tekanan` TEXT,
  `212341_pola_makan` TEXT,
  `212341_riwayat_keluarga` ENUM('Ya','Tidak') DEFAULT 'Tidak',
  `212341_keluhan` TEXT,
  `212341_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`212341_pasien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `212341_pasien` (`212341_pasien_id`, `212341_nama`, `212341_umur`, `212341_alamat`, `212341_jk`, `212341_berat_badan`, `212341_riwayat_tekanan`, `212341_pola_makan`, `212341_riwayat_keluarga`, `212341_keluhan`, `212341_created_at`) VALUES
(2, 'Andi Wijaya', 50, 'Jl. Kenanga No. 8', 'Laki-laki', '90.20', 'Pernah naik tekanan darah saat stres', 'Sering makan gorengan dan kurang olahraga', 'Ya', 'Kadang jantung berdebar dan nyeri dada', '2025-10-01 01:40:58'),
(16, 'Karolus Jone Kalang', 33, 'Makassar Jl. Bung No.1', 'Laki-laki', '33.00', 'Dari ayah', 'Tidak sehat dan makan makanan siap saji', 'Ya', 'Sakit kepala dan pusing dan susah tidur', '2025-10-13 15:49:48');

-- --------------------------------------------------------
-- Table: 212341_rekam_medis
-- --------------------------------------------------------
CREATE TABLE `212341_rekam_medis` (
  `212341_rekam_id` INT NOT NULL AUTO_INCREMENT,
  `212341_pasien_id` INT NOT NULL,
  `212341_tekanan_sistol` INT NOT NULL,
  `212341_tekanan_diastol` INT NOT NULL,
  `212341_tanggal_input` DATE NOT NULL,
  PRIMARY KEY (`212341_rekam_id`),
  KEY `fk_pasien` (`212341_pasien_id`),
  CONSTRAINT `212341_rekam_medis_ibfk_1` FOREIGN KEY (`212341_pasien_id`)
    REFERENCES `212341_pasien` (`212341_pasien_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table: 212341_diagnosa
-- --------------------------------------------------------
CREATE TABLE `212341_diagnosa` (
  `212341_diagnosa_id` INT NOT NULL AUTO_INCREMENT,
  `212341_rekam_id` INT NOT NULL,
  `212341_klasifikasi` ENUM('Normal','Hipertensi','Pre-Hipertensi') NOT NULL,
  `212341_hasil` TEXT,
  `212341_tanggal_hasil` DATE NOT NULL,
  PRIMARY KEY (`212341_diagnosa_id`),
  KEY `fk_rekam` (`212341_rekam_id`),
  CONSTRAINT `212341_diagnosa_ibfk_1` FOREIGN KEY (`212341_rekam_id`)
    REFERENCES `212341_rekam_medis` (`212341_rekam_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
