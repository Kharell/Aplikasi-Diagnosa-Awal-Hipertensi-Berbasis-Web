<?php
include "config.php";
if (!isset($_SESSION["admin_id"])) header("Location: index.php");

// Ambil data rekam medis + pasien
$rekam = $conn->query("
    SELECT r.*, p.212341_nama 
    FROM 212341_rekam_medis r 
    JOIN 212341_pasien p ON r.212341_pasien_id = p.212341_pasien_id 
    ORDER BY r.212341_rekam_id DESC
");

// 🔹 Fungsi klasifikasi tekanan darah & saran
function klasifikasi($sistol, $diastol)
{
    if ($sistol < 120 && $diastol < 80) {
        return [
            "kategori" => "Normal",
            "deskripsi" => "Tekanan darah dalam batas ideal. Jaga pola makan seimbang dan olahraga rutin untuk mempertahankan kondisi ini."
        ];
    } elseif (($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) {
        return [
            "kategori" => "Pre-Hipertensi",
            "deskripsi" => "Mulai ada peningkatan tekanan darah. Disarankan untuk mengurangi garam, hindari stres, dan rutin periksa tekanan darah."
        ];
    } else {
        return [
            "kategori" => "Hipertensi",
            "deskripsi" => "Tekanan darah tinggi. Segera konsultasikan dengan dokter, konsumsi obat sesuai anjuran, dan hindari makanan tinggi lemak serta garam."
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosa Tekanan Darah</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fafc;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
            color: #000000ff;
            font-weight: 700;
        }
        h3 {
            text-align: center;
            margin-top: 10px;
            color: #495057;
        }
        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .badge {
            font-size: 1rem;
            padding: 8px 14px;
        }
    </style>
</head>
<body class="container mt-4">

    <h1>Hasil Diagnosa Tekanan Darah Pasien</h1> 
    <br>
    <h3 class="mb-4"><i>Analisis dan Penanganan Berdasarkan Hasil Rekam Medis</i></h3>

    <table class="table table-bordered shadow-sm">
        <thead class="table-primary text-center">
            <tr>
                <th>Nama Pasien</th>
                <th>Sistol (mmHg)</th>
                <th>Diastol (mmHg)</th>
                <th>Klasifikasi</th>
                <th>Keterangan & Saran Penanganan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $rekam->fetch_assoc()) {
                $hasil = klasifikasi($row["212341_tekanan_sistol"], $row["212341_tekanan_diastol"]);
                $kategori = $hasil["kategori"];
                $deskripsi = $hasil["deskripsi"];

                // Warna badge berdasarkan kategori
                $warna = $kategori == "Normal" ? "success" : ($kategori == "Pre-Hipertensi" ? "warning" : "danger");
            ?>
            <tr>
                <td><?= htmlspecialchars($row["212341_nama"]) ?></td>
                <td class="text-center"><?= htmlspecialchars($row["212341_tekanan_sistol"]) ?></td>
                <td class="text-center"><?= htmlspecialchars($row["212341_tekanan_diastol"]) ?></td>
                <td class="text-center">
                    <span class="badge bg-<?= $warna ?>"><?= $kategori ?></span>
                </td>
                <td><?= $deskripsi ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="alert alert-info mt-4">
        <strong>Catatan:</strong> Data di atas hanya bersifat informatif. Jika tekanan darah tidak stabil, disarankan untuk melakukan pemeriksaan medis lebih lanjut di fasilitas kesehatan terdekat.
    </div>

</body>
</html>
