<!-- <?php
include "../config.php";

// 🔹 Ambil hanya 1 data diagnosa terbaru (pasien terakhir yang input)
$query = "
    SELECT 
        p.212341_nama AS nama,
        p.212341_umur AS umur,
        r.212341_tekanan_sistol AS sistol,
        r.212341_tekanan_diastol AS diastol,
        d.212341_klasifikasi AS klasifikasi,
        d.212341_hasil AS hasil,
        d.212341_tanggal_hasil AS tanggal
    FROM 212341_diagnosa d
    JOIN 212341_rekam_medis r ON d.212341_rekam_id = r.212341_rekam_id
    JOIN 212341_pasien p ON r.212341_pasien_id = p.212341_pasien_id
    ORDER BY d.212341_diagnosa_id DESC
    LIMIT 1
";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa Terbaru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }
        h1 {
            color: #fff;
            font-weight: 800;
            text-align: center;
            margin-top: 30px;
            text-shadow: 2px 2px 12px rgba(0,0,0,0.3);
        }
        .container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            padding: 35px;
            margin-top: 30px;
            max-width: 1000px;
        }
        table th, table td {
            vertical-align: middle;
            text-align: center;
        }
        table th {
            background: linear-gradient(90deg, #c0c0c0ff, #fafafaff);
            color: #fff;
            border: none;
        }
        table td {
            border-top: 1px solid #dee2e6;
        }
        .badge-normal {
            background: linear-gradient(90deg, #28a745, #45c754);
            font-size: 0.9rem;
            padding: 0.5em 0.8em;
            border-radius: 12px;
        }
        .badge-pre {
            background: linear-gradient(90deg, #ffc107, #ffdf5a);
            color: #000;
            font-size: 0.9rem;
            padding: 0.5em 0.8em;
            border-radius: 12px;
        }
        .badge-hipertensi {
            background: linear-gradient(90deg, #dc3545, #ff5c6c);
            font-size: 0.9rem;
            padding: 0.5em 0.8em;
            border-radius: 12px;
        }
        .alert-success {
            background: linear-gradient(90deg, #4caf50, #2ecc71);
            color: #fff;
            border-radius: 15px;
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .alert-warning {
            background: linear-gradient(90deg, #ff9800, #ffc107);
            color: #fff;
            border-radius: 15px;
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .btn-back {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 10px 25px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-back:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(106,17,203,0.4);
            color: #fff;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<h1>🩺 Hasil Diagnosa Terbaru</h1>

<div class="container">
    <?php if (mysqli_num_rows($data) > 0): 
        $row = mysqli_fetch_assoc($data);
    ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle shadow-sm">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Umur</th>
                        <th>Tekanan Darah (mmHg)</th>
                        <th>Klasifikasi</th>
                        <th>Hasil Diagnosa</th>
                        <th>Tanggal Pemeriksaan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= $row['umur']; ?> tahun</td>
                        <td><?= $row['sistol']; ?> / <?= $row['diastol']; ?></td>
                        <td>
                            <?php if ($row['klasifikasi'] == 'Normal'): ?>
                                <span class="badge badge-normal"><?= $row['klasifikasi']; ?></span>
                            <?php elseif ($row['klasifikasi'] == 'Pre-Hipertensi'): ?>
                                <span class="badge badge-pre"><?= $row['klasifikasi']; ?></span>
                            <?php else: ?>
                                <span class="badge badge-hipertensi"><?= $row['klasifikasi']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['hasil']); ?></td>
                        <td><?= date("d M Y", strtotime($row['tanggal'])); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="alert alert-success text-center mt-4">
            ✅ Data di atas adalah hasil diagnosa hipertensi terbaru dari pasien yang baru saja melakukan input.
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            ⚠️ Belum ada data hasil diagnosa yang tersimpan.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="../index.php" class="btn-back">← Kembali ke Halaman Utama</a>
    </div>
</div>

</body>
</html> -->
