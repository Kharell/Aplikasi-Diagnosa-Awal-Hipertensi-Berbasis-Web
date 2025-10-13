<?php include "config.php"; 
if(!isset($_SESSION["admin_id"])) header("Location: index.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pasien_id = $_POST["pasien_id"];
    $sistol    = $_POST["sistol"];
    $diastol   = $_POST["diastol"];
    $admin_id  = $_SESSION["admin_id"];
    $tanggal   = date("Y-m-d");

    $sql = "INSERT INTO 212341_rekam_medis 
            (212341_pasien_id,212341_admin_id,212341_tekanan_sistol,212341_tekanan_diastol,212341_tanggal_input)
            VALUES ('$pasien_id','$admin_id','$sistol','$diastol','$tanggal')";
    $conn->query($sql);
}
$pasien = $conn->query("SELECT * FROM 212341_pasien");
?>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!DOCTYPE html>
<html>
<head>
    <title>Input Rekam Medis</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<h3>Input Rekam Medis</h3>
<form method="post">
    <select name="pasien_id" class="form-control mb-2" required>
        <option value="">Pilih Pasien</option>
        <?php while($p = $pasien->fetch_assoc()){ ?>
        <option value="<?= $p["212341_pasien_id"] ?>"><?= $p["212341_nama"] ?></option>
        <?php } ?>
    </select>
    <input type="number" name="sistol" class="form-control mb-2" placeholder="Tekanan Sistol" required>
    <input type="number" name="diastol" class="form-control mb-2" placeholder="Tekanan Diastol" required>
    <button class="btn btn-success">Simpan</button>
</form>
</body>
</html>
