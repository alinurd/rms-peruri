<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">
<table width="100%" border="1">
<thead>
  <tr>
    <td colspan="2" rowspan="3" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;">RISK CRITERIA</td>
    <td>No.</td>
    <td>: 002/RM-FORM/I/<?php echo date("Y");?></td>
  </tr>
  <tr>
    <td>Revisi</td>
    <td>: 1</td>
  </tr>
  <tr>
    <td>Tanggal Revisi</td>
    <td>: 31 Januari <?php echo date("Y");?></td>
  </tr>
</thead>
<tbody>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 0;
$ttl_nil_dampak = 0;
$ttl_exposure = 0;
$ttl_exposure_residual = 0;
$last_id = 0;
foreach ($field as $key => $row) {
$not = '';
$tmp = ['', '', '', '', '', ''];
if ($last_id != $row['id']) {
++$no;
$last_id = $row['id'];
$not = $no;
$tmp[0] = $row['name'];

}
?>
<?php 
}
?>
  <tr>
    <td colspan="3" style="border: none;">Risk Owner</td>
    <td colspan="4" style="border: none;">: <?= $row['name']; ?></td>
  </tr>
  <tr>
    <td colspan="3" style="border: none;">Risk Agent</td>
    <td colspan="4" style="border: none;">: <?= $row['officer_name']; ?></td>
  </tr>
  <tr>
    <td colspan="7" style="border: none;"></td>
  </tr>
  <tr>
    <td colspan="7" style="border: none;">A. Kriteria Probabilitas</td>
  </tr>
  <tr>
    <td style="background-color: #BFBFBF;" colspan="3"><h3> <strong>Skor </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;"><h3> <strong>4 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>3 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>2 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>1 </strong></h3></td>
  </tr>
    <tr>
    <td style="background-color: #BFBFBF;" colspan="3"><h3> <strong>Deskripsi </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Sangat Besar </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Besar </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Sedang </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Kecil</strong></h3></td>
  </tr>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 0;
$ttl_nil_dampak = 0;
$ttl_exposure = 0;
$ttl_exposure_residual = 0;
$last_id = 0;
foreach ($fields as $key => $rows) {
$not = '';
$tmp = ['', '', '', '', '', ''];
if ($last_id == $row['id']) {
++$no;
$last_id = $row['id'];
$not = $no;
$tmp[0] = $row['name'];

}
?>
  <tr>
    <td colspan="3"><?= $rows['deskripsi']; ?></td>
    <td><?= $rows['sangat_besar']; ?></td>
    <td><?= $rows['besar']; ?></td>
    <td><?= $rows['sedang']; ?></td>
    <td><?= $rows['kecil']; ?></td>
  </tr>
<?php 
}
?>
</tbody>
</table>
</td></tr></table>

<pagebreak>

<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">
<table width="100%" border="1">
<thead>
    <tr>
    <td colspan="2" rowspan="3" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;">RISK CRITERIA</td>
    <td>No.</td>
    <td>: 002/RM-FORM/I/<?php echo date("Y");?></td>
  </tr>
  <tr>
    <td>Revisi</td>
    <td>: 1</td>
  </tr>
  <tr>
    <td>Tanggal Revisi</td>
    <td>: 31 Januari <?php echo date("Y");?></td>
  </tr>
</thead>
<tbody>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 0;
$ttl_nil_dampak = 0;
$ttl_exposure = 0;
$ttl_exposure_residual = 0;
$last_id = 0;
foreach ($field as $key => $row) {
$not = '';
$tmp = ['', '', '', '', '', ''];
if ($last_id != $row['id']) {
++$no;
$last_id = $row['id'];
$not = $no;
$tmp[0] = $row['name'];

}
?>
<?php 
}
?>
  <tr>
    <td colspan="3" style="border: none;">Risk Owner</td>
    <td colspan="4" style="border: none;">: <?= $row['name']; ?></td>
  </tr>
  <tr>
    <td colspan="3" style="border: none;">Risk Agent</td>
    <td colspan="4" style="border: none;">: <?= $row['officer_name']; ?></td>
  </tr>
  <tr>
    <td colspan="7" style="border: none;"></td>
  </tr>
  <tr>
    <td colspan="7" style="border: none;">B. Kriteria Dampak</td>
  </tr>
 <tr>
    <td style="background-color: #BFBFBF;" colspan="3"><h3> <strong>Skor </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;"><h3> <strong>4 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>3 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>2 </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center;" ><h3> <strong>1 </strong></h3></td>
  </tr>
    <tr>
    <td style="background-color: #BFBFBF;" colspan="3"><h3> <strong>Deskripsi </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Sangat Besar </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Besar </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Sedang </strong></h3></td>
    <td style="background-color: #BFBFBF;text-align: center; width: 250px" ><h3> <strong>Kecil</strong></h3></td>
  </tr>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 0;
$ttl_nil_dampak = 0;
$ttl_exposure = 0;
$ttl_exposure_residual = 0;
$last_id = 0;
foreach ($fields1 as $key => $rows1) {
$not = '';
$tmp = ['', '', '', '', '', ''];
if ($last_id == $row['id']) {
++$no;
$last_id = $row['id'];
$not = $no;
$tmp[0] = $row['name'];
}
?>
  <tr>
    <td colspan="3"><?= $rows1['deskripsi']; ?></td>
    <td><?= $rows1['sangat_besar']; ?></td>
    <td><?= $rows1['besar']; ?></td>
    <td><?= $rows1['sedang']; ?></td>
    <td><?= $rows1['kecil']; ?></td>
  </tr>
<?php 
}
?>
</tbody>
</table>
</td></tr></table>

