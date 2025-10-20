<?php
include "../config.php";

// Ambil pasien terakhir yang baru input
$pasienTerbaru = mysqli_query($conn, "SELECT * FROM 212341_pasien ORDER BY 212341_pasien_id DESC LIMIT 1");
$pasien = mysqli_fetch_assoc($pasienTerbaru);

// Jika belum ada pasien
if (!$pasien) {
    echo "<script>
        alert('⚠️ Belum ada data pasien. Silakan input data pasien terlebih dahulu.');
        window.location.href = '../pasien/inputDataPasien.php';
    </script>";
    exit;
}

// 🔹 Fungsi klasifikasi tekanan darah
function klasifikasiTekanan($sistol, $diastol) {
    if ($sistol < 120 && $diastol < 80) {
        return ['Normal', 'Tekanan darah normal'];
    } elseif (($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) {
        return ['Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat'];
    } else {
        return ['Hipertensi', 'Segera periksa ke dokter. Tekanan darah tinggi'];
    }
}

// Hanya untuk AJAX request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax'])) {
    $sistol  = $_POST["sistol"];
    $diastol = $_POST["diastol"];
    $tanggal = date("Y-m-d");
    $pasien_id = $pasien['212341_pasien_id'];

    $queryRekam = "INSERT INTO 212341_rekam_medis (
        212341_pasien_id, 212341_tekanan_sistol, 212341_tekanan_diastol, 212341_tanggal_input
    ) VALUES (
        '$pasien_id', '$sistol', '$diastol', '$tanggal'
    )";

    if (mysqli_query($conn, $queryRekam)) {
        $rekam_id = mysqli_insert_id($conn);
        list($klasifikasi, $hasil) = klasifikasiTekanan($sistol, $diastol);

        $queryDiagnosa = "INSERT INTO 212341_diagnosa (
            212341_rekam_id, 212341_klasifikasi, 212341_hasil, 212341_tanggal_hasil
        ) VALUES (
            '$rekam_id', '$klasifikasi', '$hasil', '$tanggal'
        )";

        mysqli_query($conn, $queryDiagnosa);

        echo json_encode([
            "success" => true,
            "message" => "✅ Data berhasil disimpan!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "❌ Gagal menyimpan data: " . mysqli_error($conn)
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Rekam Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        h1 {
            color: #fff;
            font-weight: 700;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.2);
        }
        .container-card {
            width: 480px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            overflow: hidden;
            background-color: #fff;
            animation: fadeIn 0.6s ease-in-out;
        }
        .card-header {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: #fff;
            font-weight: 700;
            text-align: center;
            padding: 18px;
            font-size: 1.25rem;
        }
        .card-body {
            padding: 25px;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.08);
        }
        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(106,17,203,0.4);
        }
        .alert {
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .alert-success {
            background: linear-gradient(90deg, #4caf50, #2ecc71);
            color: #fff;
        }
        .alert-danger {
            background: linear-gradient(90deg, #ff4b5c, #ff6f91);
            color: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>

    <div style="position: absolute; top: 20px; width: 100%;">
        <h1>🩺 Input Rekam Medis Pasien</h1>
    </div>

    <div class="container-card">
        <div class="card-header">Detail Pasien</div>
        <div class="card-body">
            <p><strong>Nama:</strong> <?= htmlspecialchars($pasien['212341_nama']); ?></p>
            <p><strong>Umur:</strong> <?= htmlspecialchars($pasien['212341_umur']); ?> tahun</p>
            <hr>

            <!-- alert akan muncul di sini -->
            <div id="alert-box"></div>

            <form id="rekamForm">
                <div class="mb-3">
                    <label class="form-label">Tekanan Sistol (mmHg)</label>
                    <input type="number" name="sistol" class="form-control" required placeholder="Contoh: 120">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tekanan Diastol (mmHg)</label>
                    <input type="number" name="diastol" class="form-control" required placeholder="Contoh: 80">
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-primary px-5">💾 Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

<script>
document.getElementById("rekamForm").addEventListener("submit", function(e){
    e.preventDefault(); // cegah reload halaman

    const formData = new FormData(this);
    formData.append("ajax", 1); // tanda request ajax

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const alertBox = document.getElementById("alert-box");
        alertBox.innerHTML = `<div class="alert ${data.success ? 'alert-success' : 'alert-danger'}">${data.message}</div>`;

        if(data.success) {
            // tunggu sebentar agar alert terlihat, kemudian redirect ke hasilHipertensi.php
            setTimeout(() => {
                window.location.href = "hasilHipertensi.php";
            }, 1500);
        }
    })
    .catch(err => console.error(err));
});
</script>

</body>
</html>
