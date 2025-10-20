<?php
include "config.php";

// 🔹 Fungsi untuk klasifikasi tekanan darah
function klasifikasiTekanan($sistol, $diastol) {
    if ($sistol < 120 && $diastol < 80) {
        return ['Normal', 'Tekanan darah normal'];
    } elseif (($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) {
        return ['Pre-Hipertensi', 'Waspada! Tekanan darah mulai meningkat'];
    } else {
        return ['Hipertensi', 'Segera periksa ke dokter. Tekanan darah tinggi'];
    }
}

// Daftar field rekam medis
$rekam_fields = [
    '212341_pasien_id' => 'i',
    '212341_tekanan_sistol' => 'i',
    '212341_tekanan_diastol' => 'i',
    '212341_tanggal_input' => 's'
];

// 🟢 Tambah/Edit Rekam Medis
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [];
    $types = "";
    $values = [];

    foreach ($rekam_fields as $col => $t) {
        $val = $_POST[$col] ?? null;
        if ($t == 'i') $val = intval($val);
        $data[$col] = $val;
        $types .= $t;
        $values[] = &$data[$col];
    }

    // ✅ Cek duplikat pasien + tanggal
    $check = $conn->prepare("SELECT COUNT(*) FROM 212341_rekam_medis WHERE 212341_pasien_id=? AND 212341_tanggal_input=?");
    $check->bind_param("is", $_POST['212341_pasien_id'], $_POST['212341_tanggal_input']);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count > 0 && $_POST['action'] == "tambah") {
        echo "duplikat_data";
        exit;
    }

    // 🔹 TAMBAH
    if ($_POST['action'] == "tambah") {
        $cols = implode(",", array_keys($rekam_fields));
        $place = implode(",", array_fill(0, count($rekam_fields), "?"));
        $stmt = $conn->prepare("INSERT INTO 212341_rekam_medis($cols) VALUES($place)");
        call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $values));

        if ($stmt->execute()) {
            $rekam_id = $conn->insert_id;
            [$klasifikasi, $hasil] = klasifikasiTekanan($data['212341_tekanan_sistol'], $data['212341_tekanan_diastol']);

            // Simpan hasil diagnosa
            $stmt2 = $conn->prepare("INSERT INTO 212341_diagnosa (212341_rekam_id, 212341_klasifikasi, 212341_hasil, 212341_tanggal_hasil)
                                     VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("isss", $rekam_id, $klasifikasi, $hasil, $data['212341_tanggal_input']);
            $stmt2->execute();

            echo "tambah_success";
        } else {
            echo "error:" . $stmt->error;
        }
        exit;
    }

    // 🔹 EDIT
    elseif ($_POST['action'] == "edit") {
        $id = intval($_POST['id']);
        $set = implode(",", array_map(fn($c) => "$c=?", array_keys($rekam_fields)));
        $stmt = $conn->prepare("UPDATE 212341_rekam_medis SET $set WHERE 212341_rekam_id=?");
        $types .= "i";
        $values[] = &$id;
        call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $values));

        if ($stmt->execute()) {
            [$klasifikasi, $hasil] = klasifikasiTekanan($data['212341_tekanan_sistol'], $data['212341_tekanan_diastol']);
            $tanggal = $data['212341_tanggal_input'];

            // Update diagnosa otomatis
            $stmt2 = $conn->prepare("REPLACE INTO 212341_diagnosa (212341_rekam_id, 212341_klasifikasi, 212341_hasil, 212341_tanggal_hasil)
                                     VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("isss", $id, $klasifikasi, $hasil, $tanggal);
            $stmt2->execute();

            echo "edit_success";
        } else {
            echo "error:" . $stmt->error;
        }
        exit;
    }
}

// 🟢 Hapus Rekam
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $stmt = $conn->prepare("DELETE FROM 212341_rekam_medis WHERE 212341_rekam_id=?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? "hapus_success" : "error:" . $stmt->error;
    exit;
}

// 🟢 Ambil semua data rekam medis
$res = $conn->query("
    SELECT 
        r.212341_rekam_id,
        p.212341_nama,
        r.212341_tekanan_sistol,
        r.212341_tekanan_diastol,
        r.212341_tanggal_input
    FROM 212341_rekam_medis r
    JOIN 212341_pasien p ON r.212341_pasien_id = p.212341_pasien_id
    ORDER BY r.212341_rekam_id DESC
");

$rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<h2 class="mb-4">Data Rekam Medis</h2>

<!-- <button class="btn btn-success mb-3" id="btnTambah">
    <i class="bi bi-file-earmark-plus"></i> Tambah Rekam
</button> -->

<style>
#tableRekam th { text-align: center; vertical-align: middle; background-color: #343a40; color: #fff; }
#tableRekam td { vertical-align: middle; }
.td-actions .btn {
    width: 36px; height: 36px; padding: 0; margin-right: 5px;
    display: inline-flex; justify-content: center; align-items: center;
}
.td-actions .btnEdit:hover { background-color: #0d6efd; color:#fff; }
.td-actions .btnHapus:hover { background-color: #dc3545; color:#fff; }
</style>

<table class="table table-bordered table-striped" id="tableRekam">
<thead>
<tr>
<th>No</th>
<th>Nama Pasien</th>
<th>Sistol</th>
<th>Diastol</th>
<th>Tanggal Input</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($rows as $r): ?>
<tr>
<td class="text-center"><?= $no++ ?></td>
<td><?= htmlspecialchars($r['212341_nama']) ?></td>
<td class="text-center"><?= $r['212341_tekanan_sistol'] ?></td>
<td class="text-center"><?= $r['212341_tekanan_diastol'] ?></td>
<td class="text-center"><?= $r['212341_tanggal_input'] ?></td>
<td class="text-center td-actions">
    <button class="btn btn-primary btnEdit" data-id="<?= $r['212341_rekam_id'] ?>"><i class="bi bi-pencil-square"></i></button>
    <br><br>
    <button class="btn btn-danger btnHapus" data-id="<?= $r['212341_rekam_id'] ?>"><i class="bi bi-trash3"></i></button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<form id="formRekam">
<div class="modal-header"><h5>Form Rekam Medis</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body" id="bodyForm"></div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Simpan</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
</div>
</form>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function refreshTable(){
    $.get("rekam.php", function(r){
        let temp = $('<div>').html(r);
        $("#tableRekam tbody").html(temp.find("#tableRekam tbody").html());
    });
}

// $(document).on("click","#btnTambah",function(){
//     $.get("form_rekam.php", function(html){
//         $("#bodyForm").html(html);
//         new bootstrap.Modal(document.getElementById('modalForm')).show();
//     });
// });

$(document).on("click",".btnEdit",function(){
    let id=$(this).data("id");
    $.get("form_rekam.php",{id:id}, function(html){
        $("#bodyForm").html(html);
        new bootstrap.Modal(document.getElementById('modalForm')).show();
    });
});

$(document).on("click",".btnHapus",function(){
    let id=$(this).data("id");
    Swal.fire({
        title:"Yakin hapus?",
        text:"Data rekam medis akan dihapus permanen!",
        icon:"warning",
        showCancelButton:true,
        confirmButtonText:"Ya, hapus",
        cancelButtonText:"Batal"
    }).then((res)=>{
        if(res.isConfirmed){
            $.get("rekam.php",{hapus:id}, function(r){
                if(r=="hapus_success"){
                    refreshTable();
                    Swal.fire("Berhasil!","Data berhasil dihapus.","success");
                } else {
                    Swal.fire("Gagal!",r,"error");
                }
            });
        }
    });
});

$(document).on("submit","#formRekam",function(e){
    e.preventDefault();
    let action = $(this).find("input[name='id']").length ? "edit" : "tambah";
    $.post("rekam.php", $(this).serialize()+"&action="+action, function(res){
        if(res=="duplikat_data"){
            Swal.fire("Gagal!","Data pasien & tanggal ini sudah ada.","warning");
        } else if(res=="tambah_success"){
            bootstrap.Modal.getInstance(document.getElementById('modalForm')).hide();
            refreshTable();
            Swal.fire("Berhasil!","Data berhasil disimpan & diagnosa dibuat.","success");
        } else if(res=="edit_success"){
            bootstrap.Modal.getInstance(document.getElementById('modalForm')).hide();
            refreshTable();
            Swal.fire("Berhasil!","Data berhasil diperbarui & diagnosa diperbarui.","success");
        } else {
            Swal.fire("Error!",res,"error");
        }
    });
});
</script>
