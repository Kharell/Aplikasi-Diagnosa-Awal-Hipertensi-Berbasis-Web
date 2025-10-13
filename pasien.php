<?php
include "config.php";

$pasien_fields = [
    '212341_nama'=>'s','212341_umur'=>'i','212341_alamat'=>'s','212341_jk'=>'s',
    '212341_berat_badan'=>'d','212341_riwayat_tekanan'=>'s','212341_pola_makan'=>'s',
    '212341_riwayat_keluarga'=>'s','212341_keluhan'=>'s'
];

// 🟢 Tambah/Edit
if($_SERVER['REQUEST_METHOD']=="POST"){
    $data=[];$types="";$values=[];
    foreach($pasien_fields as $col=>$t){
        $val=$_POST[$col]??null;
        if($t=='i') $val=intval($val);
        if($t=='d') $val=floatval($val);
        $data[$col]=$val;
        $types.=$t;$values[]=&$data[$col];
    }

    if($_POST['action']=="tambah"){
        $cols=implode(",",array_keys($pasien_fields));
        $place=implode(",",array_fill(0,count($pasien_fields),"?"));
        $stmt=$conn->prepare("INSERT INTO 212341_pasien($cols) VALUES($place)");
        call_user_func_array([$stmt,'bind_param'],array_merge([$types],$values));
        echo $stmt->execute()?"success":"error:".$stmt->error;
        exit;
    } elseif($_POST['action']=="edit"){
        $id=intval($_POST['id']);
        $set=implode(",",array_map(fn($c)=>"$c=?",array_keys($pasien_fields)));
        $stmt=$conn->prepare("UPDATE 212341_pasien SET $set WHERE 212341_pasien_id=?");
        $types.="i";$values[]=&$id;
        call_user_func_array([$stmt,'bind_param'],array_merge([$types],$values));
        echo $stmt->execute()?"success":"error:".$stmt->error;
        exit;
    }
}

// 🟢 Hapus
if(isset($_GET['hapus'])){
    $id=intval($_GET['hapus']);
    $stmt=$conn->prepare("DELETE FROM 212341_pasien WHERE 212341_pasien_id=?");
    $stmt->bind_param("i",$id);
    echo $stmt->execute()?"success":"error:".$stmt->error;
    exit;
}

// 🟢 Ambil semua data
$res=$conn->query("SELECT * FROM 212341_pasien ORDER BY 212341_pasien_id DESC");
$rows=$res?$res->fetch_all(MYSQLI_ASSOC):[];
?>

<h2 class="mb-4">Data Pasien</h2>

<button class="btn btn-success mb-3" id="btnTambah">
    <i class="bi bi-person-plus"></i> Tambah Pasien
</button>

<style>
/* Header tabel */
#tablePasien th {
    text-align: center;
    vertical-align: middle;
    background-color: #343a40;
    color: #fff;
}

/* Isi tabel */
#tablePasien td {
    vertical-align: middle;
}

/* Tombol aksi horizontal */
.td-actions .btn {
    width: 36px;
    height: 36px;
    padding: 0;
    margin-right: 5px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

/* Hover effect */
.td-actions .btnEdit:hover { background-color: #0d6efd; color:#fff; }
.td-actions .btnHapus:hover { background-color: #dc3545; color:#fff; }
</style>

<table class="table table-bordered table-striped" id="tablePasien">
<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Umur</th>
<th>Alamat</th>
<th>JK</th>
<th>Berat Badan</th>
<th>Riwayat Tekanan</th>
<th>Pola Makan</th>
<th>Riwayat Keluarga</th>
<th>Keluhan</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php $no=1; foreach($rows as $r): ?>
<tr>
<td class="text-center"><?= $no++ ?></td>
<td><?= $r['212341_nama'] ?></td>
<td class="text-center"><?= $r['212341_umur'] ?></td>
<td><?= $r['212341_alamat'] ?></td>
<td class="text-center"><?= $r['212341_jk'] ?></td>
<td class="text-center"><?= $r['212341_berat_badan'] ?></td>
<td><?= $r['212341_riwayat_tekanan'] ?></td>
<td><?= $r['212341_pola_makan'] ?></td>
<td><?= $r['212341_riwayat_keluarga'] ?></td>
<td><?= $r['212341_keluhan'] ?></td>
<td class="text-center td-actions">
    <button class="btn btn-primary btnEdit" data-id="<?= $r['212341_pasien_id'] ?>">
        <i class="bi bi-pencil-square"></i>
    </button>
    <br>
    <br>
    <button class="btn btn-danger btnHapus" data-id="<?= $r['212341_pasien_id'] ?>">
        <i class="bi bi-trash3"></i>
    </button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modalForm" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<form id="formPasien">
<div class="modal-header"><h5>Form Pasien</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body" id="bodyForm"></div>
<div class="modal-footer">
<button type="submit" class="btn btn-success">Simpan</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
</div>
</form>
</div>
</div>
</div>

<script>
function refreshTable(){
    $.get("pasien.php", function(r){
        let temp = $('<div>').html(r);
        $("#tablePasien tbody").html(temp.find("#tablePasien tbody").html());
    });
}

// Load form tambah
$(document).on("click","#btnTambah",function(){
    $.get("form_pasien.php", function(html){
        $("#bodyForm").html(html);
        new bootstrap.Modal(document.getElementById('modalForm')).show();
    });
});

// Load form edit
$(document).on("click",".btnEdit",function(){
    let id=$(this).data("id");
    $.get("form_pasien.php",{id:id}, function(html){
        $("#bodyForm").html(html);
        new bootstrap.Modal(document.getElementById('modalForm')).show();
    });
});

// Hapus
$(document).on("click",".btnHapus",function(){
    let id=$(this).data("id");
    Swal.fire({
        title:"Yakin hapus?",
        text:"Data akan dihapus permanen!",
        icon:"warning",
        showCancelButton:true,
        confirmButtonText:"Ya, hapus",
        cancelButtonText:"Batal"
    }).then((res)=>{
        if(res.isConfirmed){
            $.get("pasien.php",{hapus:id}, function(r){
                if(r=="success") refreshTable();
                else Swal.fire("Error",r,"error");
            });
        }
    });
});

// Submit tambah/edit
$(document).on("submit","#formPasien",function(e){
    e.preventDefault();
    let action = $(this).find("input[name='id']").length ? "edit" : "tambah";
    $.post("pasien.php", $(this).serialize()+"&action="+action, function(res){
        if(res=="success"){
            bootstrap.Modal.getInstance(document.getElementById('modalForm')).hide();
            refreshTable();
        } else Swal.fire("Error",res,"error");
    });
});
</script>
