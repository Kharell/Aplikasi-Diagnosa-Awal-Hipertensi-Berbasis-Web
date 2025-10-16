<?php include "config.php"; 
if(!isset($_SESSION["admin_id"])) header("Location: index.php");

$rekam = $conn->query("SELECT r.*, p.212341_nama 
                       FROM 212341_rekam_medis r 
                       JOIN 212341_pasien p ON r.212341_pasien_id=p.212341_pasien_id 
                       ORDER BY r.212341_rekam_id DESC");

function klasifikasi($sistol,$diastol){
    if($sistol < 120 && $diastol < 80) return "Normal";
    elseif(($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) return "Pre-Hipertensi";
    else return "Hipertensi";
}
?>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<script src="assets/js/bootstrap.bundle.min.js"></script>


<!DOCTYPE html>
<html>
<head>
    <title>Diagnosa</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<h3>Hasil Diagnosa</h3>
<table class="table table-bordered">
<tr><th>Nama Pasien</th><th>Sistol</th><th>Diastol</th><th>Klasifikasi</th></tr>
<?php while($row = $rekam->fetch_assoc()){ ?>
<tr>
  <td><?= $row["212341_nama"] ?></td>
  <td><?= $row["212341_tekanan_sistol"] ?></td>
  <td><?= $row["212341_tekanan_diastol"] ?></td>
  <td><?= klasifikasi($row["212341_tekanan_sistol"],$row["212341_tekanan_diastol"]); ?></td>
</tr>
<?php } ?>
</table>
</body>
</html>


<h1>tambahkan halaman tampilan yang baik dan berikan sepifikasi dari hasil klasifikasi alasan yang jelas untuk menangani masalah nya</h1>