<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama | Diagnosa Hipertensi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #000000ff;
            font-weight: 700;
            margin-bottom: 10px;
        }
        p {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        .main-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 480px;
            width: 100%;
        }
        a.btn {
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }
        a.btn:hover {
            transform: scale(1.05);
        }
        footer {
            margin-top: 25px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>

    <!-- Judul di luar card -->
    <h2>Aplikasi <i>Diagnosa Hipertensi</i></h2>
    <br>
    <!-- Card utama -->
    <div class="main-card">
        <div class="d-grid gap-3">
            <a href="pasien/inputDataPasien.php" class="btn btn-success">
                <i class="bi bi-person-fill"></i> Jika Pasien - Silahkan Input Data Kamu
            </a>
            <a href="login.php" class="btn btn-primary">
                <i class="bi bi-shield-lock-fill"></i> Jika Admin - Silahkan Login
            </a>
        </div>

        <footer>
            <hr>
            <em>"Menjaga kesehatan lebih baik daripada mengobati."</em><br>
            &copy; <?= date("Y") ?> Aplikasi Diagnosa Hipertensi
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
