<?php
include "config.php";
$pasien_fields = [
    '212341_nama'=>'s','212341_umur'=>'i','212341_alamat'=>'s','212341_jk'=>'s',
    '212341_berat_badan'=>'d','212341_riwayat_tekanan'=>'s','212341_pola_makan'=>'s',
    '212341_riwayat_keluarga'=>'s','212341_keluhan'=>'s'
];

$id=intval($_GET['id'] ?? 0);
$edit_data=[];
if($id){
    $stmt=$conn->prepare("SELECT * FROM 212341_pasien WHERE 212341_pasien_id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $edit_data=$stmt->get_result()->fetch_assoc();
}
?>

<?php if($id): ?>
<input type="hidden" name="id" value="<?= $id ?>">
<?php endif; ?>

<?php foreach($pasien_fields as $f=>$t): 
    $val = $edit_data[$f] ?? "";
?>
<div class="mb-2">
<label class="form-label"><?= ucwords(str_replace("_"," ", str_replace("212341_","",$f))) ?></label>
<?php if(in_array($f,['212341_riwayat_tekanan','212341_pola_makan','212341_keluhan'])): ?>
<textarea class="form-control" name="<?= $f ?>"><?= $val ?></textarea>
<?php elseif($f=='212341_jk'): ?>
<select class="form-control" name="<?= $f ?>">
<option <?= $val=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
<option <?= $val=='Perempuan'?'selected':'' ?>>Perempuan</option>
</select>
<?php elseif($f=='212341_riwayat_keluarga'): ?>
<select class="form-control" name="<?= $f ?>">
<option <?= $val=='Ya'?'selected':'' ?>>Ya</option>
<option <?= $val=='Tidak'?'selected':'' ?>>Tidak</option>
</select>
<?php else: ?>
<input type="<?= $t=='i'?'number':($t=='d'?'number':'text') ?>" step="<?= $t=='d'?'0.01':'' ?>" class="form-control" name="<?= $f ?>" value="<?= $val ?>">
<?php endif; ?>
</div>
<?php endforeach; ?>
