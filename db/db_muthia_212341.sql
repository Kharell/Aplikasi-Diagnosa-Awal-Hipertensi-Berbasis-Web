-- Table Admin
CREATE TABLE IF NOT EXISTS `212341_admin` (
  `212341_admin_id` int NOT NULL,
  `212341_username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `212341_password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `212341_created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `212341_admin` (`212341_admin_id`, `212341_username`, `212341_password`, `212341_created_at`) VALUES
(1, 'admin', 'admin123', '2025-09-28 19:40:57'),
(2, 'mutia', 'mutia123', '2025-09-29 12:11:40');

ALTER TABLE `212341_admin`
  ADD PRIMARY KEY (`212341_admin_id`),
  ADD UNIQUE KEY `212341_username` (`212341_username`);

ALTER TABLE `212341_admin`
  MODIFY `212341_admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;



-- Table Pasien
CREATE TABLE IF NOT EXISTS `212341_pasien` (
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

-- DATA ASLI + TAMBAHAN 20 DATA BARU
INSERT INTO `212341_pasien` (`212341_pasien_id`, `212341_nama`, `212341_umur`, `212341_alamat`, `212341_jk`, `212341_berat_badan`, `212341_riwayat_tekanan`, `212341_pola_makan`, `212341_riwayat_keluarga`, `212341_keluhan`, `212341_created_at`) VALUES
(53, 'Patrik Tangdilintin', 67, 'Makassar Jl. Landak No.5', 'Laki-laki', 88.00, 'Pernah tekanan darah tinggi, Sering stres berat', 'Sering makan gorengan, Sering minum kopi, Jarang makan sayur', 'Ya', 'Pusing, Sesak Napas, Jantung Berdebar', '2025-10-30 06:40:17'),
(54, 'Karolus Jone Kalang', 77, 'Makassar Jl. Bung No.5', 'Laki-laki', 90.00, 'Sering stres berat', 'Sering minum kopi, Jarang makan sayur', 'Tidak', 'Sesak Napas, Jantung Berdebar', '2025-10-30 06:42:55'),
(55, 'Mayanti Selseplia', 66, 'Makassar BPT', 'Perempuan', 77.00, 'Pernah tekanan darah tinggi', 'Sering makan gorengan, Jarang makan sayur', 'Ya', 'Pusing', '2025-10-30 06:44:14'),
(57, 'Muhamad Jalil', 55, 'Perumahan Perdos No 10', 'Laki-laki', 67.00, 'Pernah tekanan darah tinggi', 'Sering minum kopi, Jarang makan sayur', 'Ya', 'Pusing, Jantung Berdebar', '2025-10-30 13:33:01'),
(58, 'Ahmad Qhairul Mufti', 44, 'Perumahan Aspol ', 'Laki-laki', 57.00, 'Pernah tekanan darah tinggi', 'Sering makan gorengan, Sering minum kopi', 'Tidak', 'Pusing', '2025-10-30 13:36:03'),
(61, 'Afdal Haq', 45, 'Petarani no 10', 'Laki-laki', 88.00, 'Sering stres berat', 'Sering minum kopi', 'Tidak', 'Jantung Berdebar', '2025-10-30 13:43:53'),

-- ***20 DATA BARU***
(62, 'Rama Pratama', 27, 'Makassar', 'Laki-laki', 70.00, 'Tidak ada', 'Jarang makan sayur', 'Tidak', 'Pusing ringan', NOW()),
(63, 'Dewi Anggraini', 29, 'Gowa', 'Perempuan', 55.00, 'Sering stres ringan', 'Sering makan pedas', 'Tidak', 'Lelah cepat', NOW()),
(64, 'Aldi Firnando', 30, 'Maros', 'Laki-laki', 82.00, 'Pernah tekanan darah tinggi', 'Sering makan gorengan', 'Ya', 'Sesak napas', NOW()),
(65, 'Putri Amelia', 26, 'Makassar', 'Perempuan', 60.00, 'Tidak ada', 'Seimbang', 'Tidak', 'Tidak ada', NOW()),
(66, 'Johan Kristian', 33, 'Makassar', 'Laki-laki', 85.00, 'Pernah tekanan darah tinggi', 'Sering makan cepat saji', 'Tidak', 'Pusing', NOW()),
(67, 'Salsa Nuraini', 23, 'Gowa', 'Perempuan', 50.00, 'Tidak ada', 'Sehat', 'Tidak', 'Tidak ada', NOW()),
(68, 'Kevin Saputra', 28, 'Makassar', 'Laki-laki', 75.00, 'Sering stres', 'Sering minum kopi', 'Tidak', 'Jantung berdebar', NOW()),
(69, 'Anisa Mareta', 24, 'Takalar', 'Perempuan', 53.00, 'Tidak ada', 'Cukup sehat', 'Tidak', 'Pusing', NOW()),
(70, 'Albert Riyanto', 32, 'Makassar', 'Laki-laki', 90.00, 'Hipertensi ringan', 'Sering makan asin', 'Ya', 'Sesak napas', NOW()),
(71, 'Intan Safira', 27, 'Maros', 'Perempuan', 58.00, 'Tidak ada', 'Sehat', 'Tidak', 'Tidak ada', NOW()),
(72, 'Dimas Wicaksono', 30, 'Makassar', 'Laki-laki', 72.00, 'Sering stres', 'Sering minum kopi', 'Tidak', 'Pusing', NOW()),
(73, 'Rizki Firmansyah', 31, 'Gowa', 'Laki-laki', 76.00, 'Tidak ada', 'Jarang makan sayur', 'Tidak', 'Capek cepat', NOW()),
(74, 'Citra Maharani', 25, 'Makassar', 'Perempuan', 54.00, 'Tidak ada', 'Cukup sehat', 'Tidak', 'Tidak ada', NOW()),
(75, 'Yoga Pranata', 29, 'Makassar', 'Laki-laki', 80.00, 'Hipertensi sedang', 'Sering makan asin', 'Ya', 'Pusing berat', NOW()),
(76, 'Lestari Widya', 22, 'Gowa', 'Perempuan', 48.00, 'Tidak ada', 'Sehat', 'Tidak', 'Tidak ada', NOW()),
(77, 'Gilang Mahendra', 34, 'Makassar', 'Laki-laki', 90.00, 'Hipertensi', 'Sering makan gorengan', 'Ya', 'Sesak napas', NOW()),
(78, 'Shinta Yuliana', 28, 'Maros', 'Perempuan', 56.00, 'Tidak ada', 'Seimbang', 'Tidak', 'Tidak ada', NOW()),
(79, 'Rendi Ardana', 30, 'Takalar', 'Laki-laki', 83.00, 'Stres berat', 'Sering minum kopi', 'Tidak', 'Pusing', NOW()),
(80, 'Maya Kurnia', 26, 'Makassar', 'Perempuan', 58.00, 'Tidak ada', 'Cukup sehat', 'Tidak', 'Tidak ada', NOW()),
(81, 'Daniel Frans', 27, 'Makassar', 'Laki-laki', 74.00, 'Tidak ada', 'Jarang makan sayur', 'Tidak', 'Pusing ringan', NOW());

ALTER TABLE `212341_pasien`
  ADD PRIMARY KEY (`212341_pasien_id`);

ALTER TABLE `212341_pasien`
  MODIFY `212341_pasien_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;


-- Table Rekam Medis
CREATE TABLE IF NOT EXISTS `212341_rekam_medis` (
  `212341_rekam_id` int NOT NULL,
  `212341_pasien_id` int NOT NULL,
  `212341_tekanan_sistol` int NOT NULL,
  `212341_tekanan_diastol` int NOT NULL,
  `212341_tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- DATA BARU UNTUK 20 PASIEN TAMBAHAN
INSERT INTO `212341_rekam_medis` (`212341_rekam_id`, `212341_pasien_id`, `212341_tekanan_sistol`, `212341_tekanan_diastol`, `212341_tanggal_input`) VALUES
(60, 62, 118, 78, '2025-11-01'),
(61, 63, 130, 85, '2025-11-01'),
(62, 64, 155, 97, '2025-11-01'),
(63, 65, 120, 80, '2025-11-02'),
(64, 66, 145, 95, '2025-11-02'),
(65, 67, 110, 70, '2025-11-02'),
(66, 68, 140, 90, '2025-11-03'),
(67, 69, 160, 100, '2025-11-03'),
(68, 70, 135, 88, '2025-11-03'),
(69, 71, 128, 82, '2025-11-04'),
(70, 72, 150, 95, '2025-11-04'),
(71, 73, 115, 75, '2025-11-04'),
(72, 74, 125, 80, '2025-11-05'),
(73, 75, 165, 102, '2025-11-05'),
(74, 76, 108, 68, '2025-11-05'),
(75, 77, 170, 105, '2025-11-06'),
(76, 78, 137, 89, '2025-11-06'),
(77, 79, 142, 91, '2025-11-06'),
(78, 80, 112, 71, '2025-11-07'),
(79, 81, 158, 98, '2025-11-07');

ALTER TABLE `212341_rekam_medis`
  ADD PRIMARY KEY (`212341_rekam_id`),
  ADD KEY `fk_pasien` (`212341_pasien_id`);

ALTER TABLE `212341_rekam_medis`
  MODIFY `212341_rekam_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;


  -- Table Diagnosa
  CREATE TABLE IF NOT EXISTS `212341_diagnosa` (
  `212341_diagnosa_id` int NOT NULL,
  `212341_rekam_id` int NOT NULL,
  `212341_klasifikasi` enum('Normal','Hipertensi','Pre-Hipertensi') COLLATE utf8mb4_general_ci NOT NULL,
  `212341_hasil` text COLLATE utf8mb4_general_ci,
  `212341_tanggal_hasil` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `212341_diagnosa` (`212341_diagnosa_id`, `212341_rekam_id`, `212341_klasifikasi`, `212341_hasil`, `212341_tanggal_hasil`) VALUES
(71, 60, 'Normal', 'Tekanan darah normal.', '2025-11-01'),
(72, 61, 'Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat.', '2025-11-01'),
(73, 62, 'Hipertensi', 'Segera periksa ke dokter. Tekanan darah tinggi.', '2025-11-01'),
(74, 63, 'Normal', 'Tekanan darah normal.', '2025-11-02'),
(75, 64, 'Hipertensi', 'Segera periksa ke dokter.', '2025-11-02'),
(76, 65, 'Normal', 'Tekanan darah normal.', '2025-11-02'),
(77, 66, 'Pre-Hipertensi', 'Waspada.', '2025-11-03'),
(78, 67, 'Hipertensi', 'Bahaya, tekanan darah tinggi.', '2025-11-03'),
(79, 68, 'Normal', 'Tekanan darah normal.', '2025-11-03'),
(80, 69, 'Pre-Hipertensi', 'Mulai meningkat.', '2025-11-04'),
(81, 70, 'Hipertensi', 'Sangat tinggi, segera periksa.', '2025-11-04'),
(82, 71, 'Normal', 'Tekanan darah normal.', '2025-11-04'),
(83, 72, 'Pre-Hipertensi', 'Waspada.', '2025-11-05'),
(84, 73, 'Hipertensi', 'Bahaya.', '2025-11-05'),
(85, 74, 'Normal', 'Aman.', '2025-11-05'),
(86, 75, 'Hipertensi', 'Sangat tinggi.', '2025-11-06'),
(87, 76, 'Pre-Hipertensi', 'Mulai meningkat.', '2025-11-06'),
(88, 77, 'Pre-Hipertensi', 'Waspada.', '2025-11-06'),
(89, 78, 'Normal', 'Aman.', '2025-11-07'),
(90, 79, 'Hipertensi', 'Bahaya.', '2025-11-07');

ALTER TABLE `212341_diagnosa`
  ADD PRIMARY KEY (`212341_diagnosa_id`),
  ADD KEY `fk_rekam` (`212341_rekam_id`);

ALTER TABLE `212341_diagnosa`
  MODIFY `212341_diagnosa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;


-- Foreign Key Constraints
ALTER TABLE `212341_diagnosa`
  ADD CONSTRAINT `212341_diagnosa_ibfk_1`
  FOREIGN KEY (`212341_rekam_id`) REFERENCES `212341_rekam_medis` (`212341_rekam_id`)
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `212341_rekam_medis`
  ADD CONSTRAINT `212341_rekam_medis_ibfk_1`
  FOREIGN KEY (`212341_pasien_id`) REFERENCES `212341_pasien` (`212341_pasien_id`)
  ON DELETE CASCADE ON UPDATE CASCADE;
