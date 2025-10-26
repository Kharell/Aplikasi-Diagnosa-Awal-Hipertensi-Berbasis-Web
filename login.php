<!DOCTYPE html>
<html>
<head>


<?php
include "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM 212341_admin WHERE 212341_username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();

        if ($password === $row['212341_password']) {
            $_SESSION['admin_id'] = $row['212341_admin_id'];
            $_SESSION['username'] = $row['212341_username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

    <title>Login Diagnosa Hipertensi</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        h1, h2, h3 {
            font-weight: bold;
        }
        .app-title {
            text-align: center;
            color: #fff;
            margin-bottom: 40px;
        }
        .app-title h1 {
            font-size: 28px;
            font-weight: 700;
        }
        .app-title h2 {
            font-size: 20px;
            font-weight: 500;
            margin-top: -5px;
        }
        .title-icon {
            font-size: 40px;
            color: #fff;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            border-radius: 10px;
        }
        .input-group-text {
            cursor: pointer;
            border-radius: 0 10px 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Judul aplikasi -->
    <div class="app-title">
        <i class="bi bi-heart-pulse-fill title-icon"></i>
        <h1>Aplikasi Diagnosa Awal</h1>
        <h2>Hipertensi Berbasis Web</h2>
    </div>

    <div class="col-md-5 mx-auto">
        <div class="card p-4">
            <h3 class="text-center mb-3">Login Admin</h3>
            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <?php if (isset($_GET['register']) && $_GET['register'] == "success") echo "<div class='alert alert-success'>Registrasi berhasil, silakan login.</div>"; ?>

            <form method="post">
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="input-group-text" onclick="togglePassword('password','toggleIcon')">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>

                <button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
        <p class="mt-3 text-center text-white">Belum punya akun? <a href="register.php" class="text-dark fw-bold">Daftar disini</a></p>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    }
</script>
</body>
</html>
