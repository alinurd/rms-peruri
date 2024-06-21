<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">
<table width="100%" border="1">
<thead>
  <tr>
    <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;">RISK CONTEXT</td>
    <td>No.</td>
    <td>: 001/RM-FORM/I/<?php echo date("Y");?></td>
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
    <td colspan="7" style="border: none;">A.Umum</td>
  </tr>
  <tr>
    <td  style="background-color: #BFBFBF;text-align: center;width: 1px">No</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Area</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Konteks</td>
  </tr>
  <tr>
    <td style="text-align: center;">1</td>
    <td colspan="3">Anggaran RKAP</td>
    <td colspan="3"><?= "Rp " . number_format($row['anggaran_rkap']); ?></td>
  </tr>
  <tr>
    <td style="text-align: center;">2</td>
    <td colspan="3">Pemimpin Unit Kerja</td>
    <td colspan="3"><?= $row['owner_pic']; ?></td>
  </tr>
  <tr>
    <td style="text-align: center;">3</td>
    <td colspan="3">Anggota Unit Kerja</td>
    <td colspan="3"><?= $row['anggota_pic']; ?></td>
  </tr>
  <tr>
    <td style="text-align: center;">4</td>
    <td colspan="3">Tugas Pokok Dan Fungsi</td>
    <td colspan="3"><?=$row['tugas_pic'];?></td> 
  </tr>
  <tr>
    <td style="text-align: center;">5</td>
    <td colspan="3">Pekerjaan Di Luar Tupoksi</td>

    <td colspan="3"><?=$row['tupoksi']; ?></td>
  </tr>
  <tr>
    <td style="text-align: center;">6</td>
   
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Sasaran</td>
    <td colspan="2" style="background-color: #BFBFBF;text-align: center;">Strategi</td>
    <td style="background-color: #BFBFBF;text-align: center;">Kebijakan</td>
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
    <td></td>
    <td  colspan="3"><?= $rows['sasaran']; ?></td>
    <td  colspan="2"><?= $rows['strategi']; ?></td>
    <td><?= $rows['kebijakan']; ?></td>
  </tr>
<?php 
}
?>
</tbody>
</table>
</td></tr></table>

<pagebreak>

<table width="100%" border="0"><tr><td width="100%" style="padding:0px;position: absolute;">
<table width="100%" border="1">

<thead>
  <tr>
    <td colspan="2" rowspan="3" style="text-align: center;border-right:none; " width="10%"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;" width="40%">RISK CONTEXT</td>
    <td>No.</td>
    <td>: 001/RM-FORM/I/<?php echo date("Y");?></td>
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
    <td colspan="7" style="border: none;">B.Isu Internal</td>
  </tr>
  <tr>
    <td  style="background-color: #BFBFBF;text-align: center;width: 1px">No</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Area</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Konteks</td>
  </tr>
<tr>
    <td style="text-align: center;">1</td>
    <td colspan="3">Man</td>
    <td colspan="3"><?= $row['man'];?></td>
  </tr>
<tr>
   <td style="text-align: center;">2</td>
    <td colspan="3">Method</td>
    <td colspan="3"><?= $row['method'];?></td>
  </tr>
  <tr>
    <td style="text-align: center;">3</td>
    <td colspan="3">Machine</td>
    <td colspan="3"><?= $row['machine'];?></td>
  </tr>
<tr>
    <td style="text-align: center;">4</td>
    <td colspan="3">Money</td>
    <td colspan="3"><?= $row['money'];?></td>
  </tr>
  <tr>
    <td style="text-align: center;">5</td>
    <td colspan="3">Material</td>
    <td colspan="3"><?= $row['material'];?></td>
  </tr>
   <tr>
    <td style="text-align: center;">6</td>
    <td colspan="3">Market</td>
    <td colspan="3"><?= $row['market'];?></td>
  </tr> 


  
</tbody>
</table>
</td></tr></table>
<pagebreak>

<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">
<table width="100%" border="1">

<thead>
  <tr>
    <td colspan="2" rowspan="3" style="text-align: center;border-right:none; " width="10%"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;" width="40%">RISK CONTEXT</td>
    <td>No.</td>
    <td>: 001/RM-FORM/I/<?php echo date("Y");?></td>
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
    <td colspan="7" style="border: none;">C.Isu External</td>
  </tr>
  <tr>
    <td  style="background-color: #BFBFBF;text-align: center;width: 1px">No</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Area</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Konteks</td>
  </tr>
  <tr>
    <td style="text-align: center;">1</td>
    <td colspan="3">Politics</td>
    <td colspan="3"><?= $row['politics'];?></td>
  </tr>
 <tr>
   <td style="text-align: center;">2</td>
    <td colspan="3">Economics</td>
    <td colspan="3"><?= $row['economics'];?></td>
  </tr>
  <tr>
    <td style="text-align: center;">3</td>
    <td colspan="3">Social</td>
    <td colspan="3"><?= $row['social'];?></td>
  </tr>
<tr>
    <td style="text-align: center;">4</td>
    <td colspan="3">Tecnology</td>
    <td colspan="3"><?= $row['tecnology'];?></td>
  </tr>
  <tr>
    <td style="text-align: center;">5</td>
    <td colspan="3">Environment</td>
    <td colspan="3"><?= $row['environment'];?></td>
  </tr>
   <tr>
    <td style="text-align: center;">6</td>
    <td colspan="3">Legal</td>
    <td colspan="3"><?= $row['legal'];?></td>
  </tr> 
</tbody>
</table>
</td></tr></table>

<pagebreak>

<table width="100%" border="0"><tr><td width="100%" style="padding:0px;">
<table width="100%" border="1">

<thead>
  <tr>
    <td colspan="2" rowspan="3" style="text-align: center;border-right:none; " width="10%"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;" width="40%">RISK CONTEXT</td>
    <td>No.</td>
    <td>: 001/RM-FORM/I/<?php echo date("Y");?></td>
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
    <td colspan="7" style="border: none;">D.Stakeholder Internal</td>
  </tr>
  <tr>
    <td style="background-color: #BFBFBF;text-align: center;width: 1px">No</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Sasaran</td>
    <td colspan="2" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</td>
    <td style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</td>
  </tr>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 1;
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
    <td style="text-align: center;"><?=$no++?></td>
    <td colspan="3"><?= $rows1['stakeholder']; ?></td>
    <td colspan="2"><?= $rows1['peran']; ?></td>
    <td><?= $rows1['komunikasi']; ?></td>
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
    <td colspan="2" rowspan="3" style="text-align: center;border-right:none; " width="10%"><img src="<?=img_url('logo.png');?>" width="90"></td>
    <td colspan="3" rowspan="3" style="text-align: center;border-left:none;" width="40%">RISK CONTEXT</td>
    <td>No.</td>
    <td>: 001/RM-FORM/I/<?php echo date("Y");?></td>
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
    <td colspan="7" style="border: none;">E.Stakeholder External</td>
  </tr>
  <tr>
    <td style="background-color: #BFBFBF;text-align: center;width: 1px">No</td>
    <td colspan="3" style="background-color: #BFBFBF;text-align: center;">Sasaran</td>
    <td colspan="2" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</td>
    <td style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</td>
  </tr>
<?php
if (count($field) == 0)
echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
$no = 1;
$ttl_nil_dampak = 0;
$ttl_exposure = 0;
$ttl_exposure_residual = 0;
$last_id = 0;
foreach ($fields2 as $key => $rows2) {
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
    <td style="text-align: center;"><?=$no++?></td>
    <td colspan="3"><?= $rows2['stakeholder']; ?></td>
    <td colspan="2"><?= $rows2['peran']; ?></td>
    <td><?= $rows2['komunikasi']; ?></td>
  </tr>
<?php 
}
?>
  </tbody>
</table>
</td></tr></table>