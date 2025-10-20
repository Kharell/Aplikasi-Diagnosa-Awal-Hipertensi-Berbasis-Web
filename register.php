<?php
include "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Password tidak sama!";
    } else {
        // Cek apakah username sudah ada
        $sql = "SELECT * FROM 212341_admin WHERE 212341_username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Simpan password langsung (plain text, sesuai DB sekarang)
            $sql = "INSERT INTO 212341_admin (212341_username, 212341_password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                // Redirect langsung ke login.php
                header("Location: login.php?register=success");
                exit;
            } else {
                $error = "Gagal membuat akun: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .btn-success {
            border-radius: 10px;
        }
        h3 {
            font-weight: bold;
            color: #333;
        }
        .form-control {
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
    <div class="col-md-5 mx-auto">
        <div class="card p-4">
            <h3 class="text-center mb-4">Register Akun</h3>
            <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="input-group-text" onclick="togglePassword('password','toggleIcon1')">
                        <i class="bi bi-eye" id="toggleIcon1"></i>
                    </span>
                </div>

                <div class="input-group mb-3">
                    <input type="password" id="confirm" name="confirm" class="form-control" placeholder="Konfirmasi Password" required>
                    <span class="input-group-text" onclick="togglePassword('confirm','toggleIcon2')">
                        <i class="bi bi-eye" id="toggleIcon2"></i>
                    </span>
                </div>

                <button class="btn btn-success w-100">Register</button>
            </form>
        </div>
        <p class="mt-3 text-center text-white">Sudah punya akun? <a href="login.php" class="text-dark fw-bold">Login disini</a></p>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(iconId);
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.replace("bi-eye","bi-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.replace("bi-eye-slash","bi-eye");
    }
}
</script>
</body>
</html>
