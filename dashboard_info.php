<?php
include "config.php";

// Hitung total pasien
$totalPasien = 0;
$sqlPasien = mysqli_query($conn, "SELECT COUNT(*) AS total FROM 212341_pasien");
if ($sqlPasien && mysqli_num_rows($sqlPasien) > 0) {
    $totalPasien = mysqli_fetch_assoc($sqlPasien)['total'];
}

// 🔹 Tambahan baru: Hitung total rekam medis
$totalRekamMedis = 0;
$sqlTotalRekam = mysqli_query($conn, "SELECT COUNT(*) AS total FROM 212341_rekam_medis");
if ($sqlTotalRekam && mysqli_num_rows($sqlTotalRekam) > 0) {
    $totalRekamMedis = mysqli_fetch_assoc($sqlTotalRekam)['total'];
}

// Ambil rekam medis terbaru (kode lama tetap dipertahankan)
$rekamTerbaru = "Belum ada data";
$sqlRekam = mysqli_query($conn, "
    SELECT p.212341_nama AS nama, r.212341_tekanan_sistol AS sistol, r.212341_tekanan_diastol AS diastol, r.212341_tanggal_input
    FROM 212341_rekam_medis r
    JOIN 212341_pasien p ON r.212341_pasien_id = p.212341_pasien_id
    ORDER BY r.212341_tanggal_input DESC
    LIMIT 1
");
if ($sqlRekam && mysqli_num_rows($sqlRekam) > 0) {
    $rekam = mysqli_fetch_assoc($sqlRekam);
    $tanggal = date("d M Y", strtotime($rekam['212341_tanggal_input']));
    $rekamTerbaru = "{$rekam['nama']} ({$rekam['sistol']}/{$rekam['diastol']}) pada {$tanggal}";
}

// Hitung diagnosa hari ini
$tanggalHariIni = date('Y-m-d');
$diagnosaHariIni = 0;
$sqlDiagnosa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM 212341_diagnosa WHERE 212341_tanggal_hasil = '$tanggalHariIni'");
if ($sqlDiagnosa && mysqli_num_rows($sqlDiagnosa) > 0) {
    $diagnosaHariIni = mysqli_fetch_assoc($sqlDiagnosa)['total'];
}

// Kirim hasil dalam format JSON
echo json_encode([
    "totalPasien" => $totalPasien,
    "rekamTerbaru" => $totalRekamMedis, // 🔹 Ganti tampil angka total rekam medis
    "diagnosaHariIni" => $diagnosaHariIni,

    // 🔸 Simpan info lama sebagai tambahan opsional
    "rekamTerbaruDetail" => $rekamTerbaru
]);
?>
