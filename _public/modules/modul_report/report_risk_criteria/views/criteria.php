<?php
    $tp1='_d';
    if ($type1==1){
        $tp1='_p';
    }
?>
<table class="table" id="<?=($type1==1)?'tbl_probabilitas':'tbl_dampak';?>">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No.</th>
            <!-- <th><?=($type==1)?'Strategis':'Finansial';?></th>  -->
            <th width="15%">Deskripsi</th> 
            <th>Sangat Besar</th>
            <th>Besar</th>
            <th>Sedang</th>
            <th>Kecil</th>
            <!-- <th width="5%" style="text-align:center;">Aksi</th> -->
        </tr>
    </thead
    ><tbody>
<?php
	$i=0;
	$haha = array('Strategis'=>'Strategis','Finansial'=>'Finansial','Operasional'=>'Operasional',
				'Hukum & Kepatuhan'=>'Hukum & Kepatuhan','Bisnis'=>'Bisnis');
	foreach($field as $key=>$row)
	{
		if ($this->uri->segment(2) == "view"){
		$edit1=form_hidden('id_edit'.$tp1.'[]',$row['id']);
		$deskripsi = form_dropdown('deskripsi'.$tp1.'[]',$haha, $row['deskripsi']," class='form-control' disabled='disabled' width='100%'");
		
		// $deskripsi = form_textarea('deskripsi'.$tp1.'[]', $row['deskripsi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sangat_besar = form_textarea('sangat_besar'.$tp1.'[]', $row['sangat_besar'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$besar = form_textarea('besar'.$tp1.'[]', $row['besar'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sedang = form_textarea('sedang'.$tp1.'[]', $row['sedang'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$kecil = form_textarea('kecil'.$tp1.'[]', $row['kecil'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		}else{
		$edit1=form_hidden('id_edit'.$tp1.'[]',$row['id']);
		$deskripsi = form_dropdown('deskripsi'.$tp1.'[]',$haha, $row['deskripsi']," class='form-control' width='100%'");
		
		// $deskripsi = form_textarea('deskripsi'.$tp1.'[]', $row['deskripsi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sangat_besar = form_textarea('sangat_besar'.$tp1.'[]', $row['sangat_besar'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$besar = form_textarea('besar'.$tp1.'[]', $row['besar'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sedang = form_textarea('sedang'.$tp1.'[]', $row['sedang'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$kecil = form_textarea('kecil'.$tp1.'[]', $row['kecil'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");

		}
        ++$i;
        $jml=0;
		?>
		<tr>
			<td style="text-align:center;width:10%;"><?php echo $i.$edit1;?></td>
			<td><?=$deskripsi;?></td>
			<td><?=$sangat_besar;?></td>
			<td><?=$besar;?></td>
			<td><?=$sedang;?></td>
			<td><?=$kecil;?></td>
			<?php if ($this->uri->segment(2) == "view"): ?>
			<td></td>
			<?php else: ?>
			<td style="text-align:center;width:10%;"><a nilai="<?php echo $row['id'];?>" style="cursor:pointer;" onclick="remove_install(this,<?php echo $row['id'];?>)"><i class="fa fa-cut" title="menghapus data"></i></a></td>
			<?php endif ?>
		</tr>
        <?php
    } 
    $deskripsi = form_dropdown('deskripsi'.$tp1.'[]',$haha," class='form-control' width='100%'");
    // $deskripsi = form_textarea('deskripsi'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$sangat_besar = form_textarea('sangat_besar'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$besar = form_textarea('besar'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$sedang = form_textarea('sedang'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$kecil = form_textarea('kecil'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$edit1=form_hidden('id_edit'.$tp1.'[]','0');
	?>
	</tbody></table><center>
	<?php if ($this->uri->segment(2) == "view"): ?>
	<button id="<?=($type1==1)?'add_probabilitas':'add_dampak';?>" class="btn btn-primary hidden" type="button" value="Add More" name="<?=($type1==1)?'add_probabilitas':'add_dampak';?>"> Add More </button>
	<?php else : ?>
	<button id="<?=($type1==1)?'add_probabilitas':'add_dampak';?>" class="btn btn-primary" type="button" value="Add More" name="<?=($type1==1)?'add_probabilitas':'add_dampak';?>"> Add More </button>
	<?php endif ?>
	</center>
<?php
if ($type1==1):?>
<script type1="text/javascript">
	var deskripsi_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$deskripsi));?>';
	var sangat_besar_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$sangat_besar));?>';
	var besar_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$besar));?>';
	var sedang_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$sedang));?>';
	var kecil_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$kecil));?>';
	var edit_p='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit1));?>';
</script>
<?php else:?>
    <script type1="text/javascript">
	var deskripsi_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$deskripsi));?>';
	var sangat_besar_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$sangat_besar));?>';
	var besar_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$besar));?>';
	var sedang_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$sedang));?>';
	var kecil_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$kecil));?>';
	var edit_d='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit1));?>';
</script>
<?php endif;