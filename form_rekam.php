<?php
include "config.php";

$id = $_GET['id'] ?? null;
$data = [
    '212341_pasien_id' => '',
    '212341_tekanan_sistol' => '',
    '212341_tekanan_diastol' => '',
    '212341_tanggal_input' => date('Y-m-d')
];

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM 212341_rekam_medis WHERE 212341_rekam_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();
}

// daftar pasien
$pasien = $conn->query("SELECT 212341_pasien_id, 212341_nama FROM 212341_pasien ORDER BY 212341_nama ASC");
?>

<div class="row g-3">
    <?php if($id): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>

    <div class="col-md-6">
        <label class="form-label">Nama Pasien</label>
        <select name="212341_pasien_id" class="form-select" required>
            <option value="">-- Pilih Pasien --</option>
            <?php while($p = $pasien->fetch_assoc()): ?>
            <option value="<?= $p['212341_pasien_id'] ?>" <?= ($p['212341_pasien_id']==$data['212341_pasien_id'])?'selected':'' ?>>
                <?= htmlspecialchars($p['212341_nama']) ?>
            </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tekanan Sistol</label>
        <input type="number" name="212341_tekanan_sistol" class="form-control" value="<?= $data['212341_tekanan_sistol'] ?>" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tekanan Diastol</label>
        <input type="number" name="212341_tekanan_diastol" class="form-control" value="<?= $data['212341_tekanan_diastol'] ?>" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Input</label>
        <input type="date" name="212341_tanggal_input" class="form-control" value="<?= $data['212341_tanggal_input'] ?>" required>
    </div>
</div>
