-- --------------------------------------------------------
-- Database: db_muthia_212341
-- --------------------------------------------------------

-- ==============================
-- Tabel: 212341_admin
-- ==============================
CREATE TABLE `212341_admin` (
  `212341_admin_id` INT NOT NULL AUTO_INCREMENT,
  `212341_username` VARCHAR(100) NOT NULL UNIQUE,
  `212341_password` VARCHAR(255) NOT NULL,
  `212341_created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`212341_admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data Awal
INSERT INTO `212341_admin` 
(`212341_admin_id`, `212341_username`, `212341_password`, `212341_created_at`) VALUES
(1, 'admin', 'admin123', '2025-09-29 11:40:57'),
(2, 'mutia', 'mutia123', '2025-09-30 04:11:40');

-- ==============================
-- Tabel: 212341_pasien
-- ==============================
CREATE TABLE `212341_pasien` (
  `212341_pasien_id` INT NOT NULL AUTO_INCREMENT,
  `212341_nama` VARCHAR(100) NOT NULL,
  `212341_umur` INT NOT NULL,
  `212341_alamat` VARCHAR(255),
  `212341_jk` ENUM('Laki-laki','Perempuan') NOT NULL,
  `212341_berat_badan` DECIMAL(5,2),
  `212341_riwayat_tekanan` TEXT,
  `212341_pola_makan` TEXT,
  `212341_riwayat_keluarga` ENUM('Ya','Tidak') DEFAULT 'Tidak',
  `212341_keluhan` TEXT,
  `212341_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`212341_pasien_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data Awal
INSERT INTO `212341_pasien` 
(`212341_nama`, `212341_umur`, `212341_alamat`, `212341_jk`, `212341_berat_badan`, `212341_riwayat_tekanan`, `212341_pola_makan`, `212341_riwayat_keluarga`, `212341_keluhan`) VALUES
('Siti Aminah', 35, 'Jl. Melati No. 5', 'Perempuan', 55.00, 'Tidak ada riwayat tekanan darah tinggi', 'Makan sayur dan buah rutin', 'Tidak', 'Tidak ada keluhan'),
('Andi Wijaya', 50, 'Jl. Kenanga No. 8', 'Laki-laki', 90.20, 'Pernah naik tekanan darah saat stres', 'Sering makan gorengan dan kurang olahraga', 'Ya', 'Kadang jantung berdebar dan nyeri dada'),
('Dewi Lestari', 40, 'Jl. Anggrek No. 3', 'Perempuan', 95.70, 'Ayah menderita hipertensi', 'Terlalu banyak konsumsi makanan cepat saji', 'Ya', 'Sering tengkuk pegal dan sakit kepala');

-- ==============================
-- Tabel: 212341_rekam_medis
-- ==============================
CREATE TABLE `212341_rekam_medis` (
  `212341_rekam_id` INT NOT NULL AUTO_INCREMENT,
  `212341_pasien_id` INT NOT NULL,
  `212341_admin_id` INT NOT NULL,
  `212341_tekanan_sistol` INT NOT NULL,
  `212341_tekanan_diastol` INT NOT NULL,
  `212341_tanggal_input` DATE NOT NULL,
  PRIMARY KEY (`212341_rekam_id`),
  KEY `fk_pasien` (`212341_pasien_id`),
  KEY `fk_admin` (`212341_admin_id`),
  CONSTRAINT `212341_rekam_medis_ibfk_1` FOREIGN KEY (`212341_pasien_id`) REFERENCES `212341_pasien` (`212341_pasien_id`) ON DELETE CASCADE,
  CONSTRAINT `212341_rekam_medis_ibfk_2` FOREIGN KEY (`212341_admin_id`) REFERENCES `212341_admin` (`212341_admin_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data Awal
INSERT INTO `212341_rekam_medis` 
(`212341_rekam_id`, `212341_pasien_id`, `212341_admin_id`, `212341_tekanan_sistol`, `212341_tekanan_diastol`, `212341_tanggal_input`) VALUES
(2, 2, 1, 118, 78, '2025-09-25');

-- ==============================
-- Tabel: 212341_diagnosa
-- ==============================
CREATE TABLE `212341_diagnosa` (
  `212341_diagnosa_id` INT NOT NULL AUTO_INCREMENT,
  `212341_rekam_id` INT NOT NULL,
  `212341_klasifikasi` ENUM('Normal','Hipertensi','Pre-Hipertensi') NOT NULL,
  `212341_hasil` TEXT,
  `212341_tanggal_hasil` DATE NOT NULL,
  PRIMARY KEY (`212341_diagnosa_id`),
  KEY `fk_rekam` (`212341_rekam_id`),
  CONSTRAINT `212341_diagnosa_ibfk_1` FOREIGN KEY (`212341_rekam_id`) REFERENCES `212341_rekam_medis` (`212341_rekam_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Data Awal
INSERT INTO `212341_diagnosa` 
(`212341_diagnosa_id`, `212341_rekam_id`, `212341_klasifikasi`, `212341_hasil`, `212341_tanggal_hasil`) VALUES
(2, 2, 'Normal', 'Tekanan darah dalam batas normal.', '2025-09-25');
