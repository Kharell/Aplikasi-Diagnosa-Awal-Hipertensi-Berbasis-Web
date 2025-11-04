<?php
include "../config.php";

$hasil_diagnosa = "";
$klasifikasi = "";
$nama = $umur = $jk = "";
$show_modal = false;

// 🔹 Tangani hasil redirect (GET setelah submit)
if (isset($_GET['success'])) {
    $show_modal = true;
    $nama = $_GET['nama'] ?? '';
    $umur = $_GET['umur'] ?? '';
    $jk = $_GET['jk'] ?? '';
    $hasil_diagnosa = $_GET['hasil'] ?? '';
    $klasifikasi = $_GET['klasifikasi'] ?? '';
}

// 🔹 Tangani form POST (saat tombol Simpan diklik)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jk'];
    $berat_badan = $_POST['berat_badan'];

    // Gabungkan checkbox menjadi teks
    $riwayat_tekanan = isset($_POST['riwayat_tekanan']) ? implode(", ", $_POST['riwayat_tekanan']) : '';
    $pola_makan = isset($_POST['pola_makan']) ? implode(", ", $_POST['pola_makan']) : '';
    $riwayat_keluarga = $_POST['riwayat_keluarga'];
    $keluhan = isset($_POST['keluhan']) ? implode(", ", $_POST['keluhan']) : '';

    $sistol = $_POST['sistol'];
    $diastol = $_POST['diastol'];
    $tanggal_input = date('Y-m-d');

    // 🔹 Simpan ke tabel pasien
    $stmt = $conn->prepare("INSERT INTO 212341_pasien 
        (212341_nama, 212341_umur, 212341_alamat, 212341_jk, 212341_berat_badan, 
         212341_riwayat_tekanan, 212341_pola_makan, 212341_riwayat_keluarga, 212341_keluhan)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $nama, $umur, $alamat, $jk, $berat_badan, $riwayat_tekanan, $pola_makan, $riwayat_keluarga, $keluhan);
    $stmt->execute();
    $pasien_id = $conn->insert_id;

    // 🔹 Simpan ke tabel rekam medis 🔹
    $stmt2 = $conn->prepare("INSERT INTO 212341_rekam_medis 
        (212341_pasien_id, 212341_tekanan_sistol, 212341_tekanan_diastol, 212341_tanggal_input)
        VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("iiis", $pasien_id, $sistol, $diastol, $tanggal_input);
    $stmt2->execute();
    $rekam_id = $conn->insert_id;

    // ============================================
    // 🔹 ALGORITMA NAIVE BAYES 🔹
    // ============================================
    function naiveBayesDiagnosa($sistol, $diastol, $pola_makan, $riwayat_keluarga, $keluhan) {
        $kelas = ['Rendah', 'Normal', 'Pre-Hipertensi', 'Hipertensi'];
        $prob = [];
        foreach ($kelas as $k) {
            $prob[$k] = 1.0;
        }

        // ---- Tekanan darah ----
        if ($sistol < 90 || $diastol < 60) {
            $prob['Rendah'] *= 0.8;
        } elseif ($sistol < 120 && $diastol < 80) {
            $prob['Normal'] *= 0.8;
        } elseif (($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) {
            $prob['Pre-Hipertensi'] *= 0.8;
        } else {
            $prob['Hipertensi'] *= 0.8;
        }

        // ---- Pola makan ----
        if (strpos($pola_makan, 'Makanan tinggi garam') !== false) $prob['Hipertensi'] *= 1.3;
        if (strpos($pola_makan, 'Sering makan gorengan') !== false) $prob['Pre-Hipertensi'] *= 1.2;
        if (strpos($pola_makan, 'Jarang makan sayur') !== false) $prob['Rendah'] *= 1.1;

        // ---- Riwayat keluarga ----
        if ($riwayat_keluarga === 'Ya') $prob['Hipertensi'] *= 1.4;
        else $prob['Normal'] *= 1.2;

        // ---- Keluhan ----
        if (strpos($keluhan, 'Pusing') !== false || strpos($keluhan, 'Jantung Berdebar') !== false)
            $prob['Hipertensi'] *= 1.3;
        if (strpos($keluhan, 'Sesak Napas') !== false)
            $prob['Pre-Hipertensi'] *= 1.1;

        // ---- Pilih probabilitas tertinggi ----
        arsort($prob);
        $hasil = key($prob);

        switch ($hasil) {
            case 'Rendah':
                $pesan = "Tekanan darah rendah (hipotensi). Perbanyak istirahat dan konsumsi air putih.";
                break;
            case 'Normal':
                $pesan = "Tekanan darah normal. Pertahankan pola hidup sehat!";
                break;
            case 'Pre-Hipertensi':
                $pesan = "Waspada! Tekanan darah mulai meningkat, jaga pola makan dan olahraga.";
                break;
            case 'Hipertensi':
                $pesan = "Tekanan darah tinggi. Segera konsultasikan ke dokter.";
                break;
        }
        return [$hasil, $pesan];
    }

    // 🔹 Panggil fungsi Naive Bayes
    list($klasifikasi, $hasil_diagnosa) = naiveBayesDiagnosa($sistol, $diastol, $pola_makan, $riwayat_keluarga, $keluhan);

    // ============================================

    // 🔹 Simpan ke tabel diagnosa 🔹
    $stmt3 = $conn->prepare("INSERT INTO 212341_diagnosa 
        (212341_rekam_id, 212341_klasifikasi, 212341_hasil, 212341_tanggal_hasil)
        VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("isss", $rekam_id, $klasifikasi, $hasil_diagnosa, $tanggal_input);
    $stmt3->execute();

    // Tutup koneksi prepared statement
    $stmt->close();
    $stmt2->close();
    $stmt3->close();

    // 🔹 Redirect agar tidak duplikasi saat refresh 🔹
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1&nama=" . urlencode($nama) . "&umur=" . urlencode($umur) . "&jk=" . urlencode($jk) . "&hasil=" . urlencode($hasil_diagnosa) . "&klasifikasi=" . urlencode($klasifikasi));
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input & Diagnosa Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5 p-4 shadow-lg bg-white rounded-4">
    <h2 class="text-center text-primary fw-bold mb-4">Form Input & Diagnosa Pasien</h2>

    <form method="POST" class="row g-3">
        <!-- Data Pasien -->
        <h5 class="text-secondary mt-3">🧍 Data Pasien</h5>
        <div class="col-md-6">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label>Berat Badan (kg)</label>
            <input type="text" name="berat_badan" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Jenis Kelamin</label>
            <select name="jk" class="form-select" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <!-- Riwayat -->
        <h5 class="text-secondary mt-4">🩺 Riwayat Kesehatan</h5>
        <div class="col-md-6">
            <label>Riwayat Tekanan Darah</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="riwayat_tekanan[]" value="Pernah tekanan darah tinggi">
                <label class="form-check-label">Pernah tekanan darah tinggi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="riwayat_tekanan[]" value="Sering stres berat">
                <label class="form-check-label">Sering stres berat</label>
            </div>
        </div>
        <div class="col-md-6">
            <label>Riwayat Keluarga</label>
            <select name="riwayat_keluarga" class="form-select">
                <option value="Tidak">Tidak</option>
                <option value="Ya">Ya</option>
            </select>
        </div>

        <!-- Pola makan -->
        <div class="col-md-12">
            <label>Pola Makan</label><br>
            <div class="row">
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="pola_makan[]" value="Sering makan gorengan">
                    <label class="form-check-label">Sering makan gorengan</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="pola_makan[]" value="Makanan tinggi garam">
                    <label class="form-check-label">Makanan tinggi garam</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="pola_makan[]" value="Sering minum kopi">
                    <label class="form-check-label">Sering minum kopi</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="pola_makan[]" value="Jarang makan sayur">
                    <label class="form-check-label">Jarang makan sayur</label>
                </div>
            </div>
        </div>

        <!-- Keluhan -->
        <div class="col-md-12">
            <label>Keluhan</label><br>
            <div class="row">
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="keluhan[]" value="Pusing">
                    <label class="form-check-label">Pusing</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="keluhan[]" value="Sesak Napas">
                    <label class="form-check-label">Sesak Napas</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="keluhan[]" value="Nyeri Dada">
                    <label class="form-check-label">Nyeri Dada</label>
                </div>
                <div class="col-md-3 form-check">
                    <input class="form-check-input" type="checkbox" name="keluhan[]" value="Jantung Berdebar">
                    <label class="form-check-label">Jantung Berdebar</label>
                </div>
            </div>
        </div>

        <!-- Tekanan darah -->
        <h5 class="text-secondary mt-4">🧪 Pemeriksaan Tekanan Darah</h5>
        <div class="col-md-6">
            <label>Tekanan Sistol</label>
            <input type="number" name="sistol" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Tekanan Diastol</label>
            <input type="number" name="diastol" class="form-control" required>
        </div>

        <div class="col-12 text-center mt-4">
            <a href="../index.php" class="btn btn-secondary px-4 ms-2">🏠 Kembali ke Halaman Utama</a>
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Simpan & Diagnosa</button>
        </div>
    </form>
</div>

<!-- Modal hasil diagnosa -->
<div class="modal fade" id="hasilModal" tabindex="-1" aria-labelledby="hasilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="hasilModalLabel">Hasil Diagnosa Pasien</h5>
        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
        <p><strong>Umur:</strong> <?= htmlspecialchars($umur) ?> tahun</p>
        <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($jk) ?></p>
        <hr>
        <h6><strong>Klasifikasi:</strong> <?= htmlspecialchars($klasifikasi) ?></h6>
        <p><?= htmlspecialchars($hasil_diagnosa) ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tutup dan cek detail tekanan dengan ADMIN</button>
      </div>
    </div>
  </div>
</div>

<?php if ($show_modal): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var hasilModal = new bootstrap.Modal(document.getElementById('hasilModal'));
    hasilModal.show();
});
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
