<!-- <?php
include "../config.php";

$message = "";
$message_type = ""; // ✅ untuk menentukan warna alert (success/danger)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $umur = $_POST["umur"];
    $alamat = $_POST["alamat"];
    $jk = $_POST["jk"];
    $berat = $_POST["berat"];
    $riwayat_tekanan = $_POST["riwayat_tekanan"];
    $pola_makan = $_POST["pola_makan"];
    $riwayat_keluarga = $_POST["riwayat_keluarga"];
    $keluhan = $_POST["keluhan"];

    $query = "INSERT INTO 212341_pasien (
        212341_nama, 212341_umur, 212341_alamat, 212341_jk, 212341_berat_badan,
        212341_riwayat_tekanan, 212341_pola_makan, 212341_riwayat_keluarga, 212341_keluhan
    ) VALUES (
        '$nama', '$umur', '$alamat', '$jk', '$berat', '$riwayat_tekanan', '$pola_makan', '$riwayat_keluarga', '$keluhan'
    )";

    if (mysqli_query($conn, $query)) {
        $message = "✅ Data pasien <strong>$nama</strong> berhasil disimpan!";
        $message_type = "success";
        echo "<meta http-equiv='refresh' content='2;url=inputDataRekamMedis.php'>";
    } else {
        $message = "❌ Gagal menyimpan data: " . mysqli_error($conn);
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        h1 {
            color: #fff;
            font-weight: 700;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.2);
        }
        .container {
            max-width: 800px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            margin-bottom: 60px;
        }
        label {
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background-color: #6a11cb;
            border: none;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #2575fc;
        }
        .btn-back {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: inline-block;
            margin-top: 15px;
        }
        .btn-back:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(37,117,252,0.4);
        }

        /* 🎨 Alert style modern */
        .alert {
            font-weight: 600;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            animation: fadeInDown 0.6s ease;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(90deg, #4caf50, #2ecc71);
            color: #fff;
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3);
        }
        .alert-danger {
            background: linear-gradient(90deg, #f44336, #e53935);
            color: #fff;
            box-shadow: 0 4px 10px rgba(244, 67, 54, 0.3);
        }
        .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body>

    <h1>🩺 Input Data Pasien</h1>
    <br>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-<?= $message_type ?> alert-dismissible fade show text-center shadow-sm" role="alert">
                <?= $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nama Pasien</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Umur</label>
                    <input type="number" name="umur" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jenis Kelamin</label>
                <select name="jk" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Riwayat Tekanan Darah</label>
                <textarea name="riwayat_tekanan" class="form-control" rows="2" required></textarea>
            </div>

            <div class="mb-3">
                <label>Pola Makan</label>
                <textarea name="pola_makan" class="form-control" rows="2" required></textarea>
            </div>

            <div class="mb-3">
                <label>Riwayat Keluarga</label>
                <select name="riwayat_keluarga" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="Ya">Ya</option>
                    <option value="Tidak">Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Keluhan</label>
                <textarea name="keluhan" class="form-control" rows="3" required></textarea>
            </div>
            <br>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">💾 Simpan Data Pasien</button>
            </div>
        </form>
    </div>

    <div class="text-center mb-4">
        <a href="../index.php" class="btn-back">← Kembali ke Halaman Utama</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> -->
