<?php
    $tp='_ex';
    if ($type==1){
        $tp='_in';
    }
?>
<table class="table" id="<?=($type==1)?'tbl_internal':'tbl_external';?>">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No.</th>
            <th><?=($type==1)?'Stakeholder Internal':'Stakeholder External';?></th>
            <th>Peran/Fungsi</th>
            <th>Komunikasi Yang dipilih</th>
            <th>Potensi/Gangguan Hambatan</th>
            <th width="10%" style="text-align:center;">Aksi</th>
        </tr>
    </thead
    ><tbody>
<?php
	$i=0;
	foreach($field as $key=>$row)
	{
		if ($this->uri->segment(2) == "view"){
		$edit=form_hidden('id_edit'.$tp.'[]',$row['id']);
		$stakeholder = form_textarea('stakeholder'.$tp.'[]', $row['stakeholder'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$peran = form_textarea('peran'.$tp.'[]', $row['peran'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$komunikasi = form_textarea('komunikasi'.$tp.'[]', $row['komunikasi'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$potensi = form_textarea('potensi'.$tp.'[]', $row['potensi'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		}else{
		$edit=form_hidden('id_edit'.$tp.'[]',$row['id']);
		$stakeholder = form_textarea('stakeholder'.$tp.'[]', $row['stakeholder'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$peran = form_textarea('peran'.$tp.'[]', $row['peran'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$komunikasi = form_textarea('komunikasi'.$tp.'[]', $row['komunikasi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$potensi = form_textarea('potensi'.$tp.'[]', $row['potensi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		}
        ++$i;
        $jml=0;
		?>
		<tr>
			<td style="text-align:center;width:10%;"><?php echo $i.$edit;?></td>
			<td><?=$stakeholder;?></td>
			<td><?=$peran;?></td>
			<td><?=$komunikasi;?></td>
			<td><?=$potensi;?></td>
			<?php if ($this->uri->segment(2) == "view"): ?>
			<td></td>
			<?php else: ?>
				<td style="text-align:center;width:10%;"><a href=" <?= base_url()?>rcsa/delete_stakeholder/<?php echo $row['id'];?>/<?php echo $this->uri->segment(3); ?>" ><i class="fa fa-cut" title="menghapus data"></i></a></td>
			<?php endif ?>
		</tr>
        <?php
    }
	$stakeholder = form_textarea('stakeholder'.$tp.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$peran = form_textarea('peran'.$tp.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$komunikasi = form_textarea('komunikasi'.$tp.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$potensi = form_textarea('potensi'.$tp.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$edit=form_hidden('id_edit'.$tp.'[]','0');
	?>
	</tbody></table><center>
	<?php if ($this->uri->segment(2) == "view"): ?>
		<button id="<?=($type==1)?'add_internal':'add_external';?>" class="btn btn-primary hidden" type="button" value="Add More" name="<?=($type==1)?'add_internal':'add_external';?>"> Add More </button>
	<?php else : ?>
		<button id="<?=($type==1)?'add_internal':'add_external';?>" class="btn btn-primary" type="button" value="Add More" name="<?=($type==1)?'add_internal':'add_external';?>"> Add More </button>
	<?php endif ?>		
	</center>
<?php
if ($type==1):?>
<script type="text/javascript">
	var stakeholder_in='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$stakeholder));?>';
	var peran_in='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$peran));?>';
	var komunikasi_in='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$komunikasi));?>';
	var potensi_in='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$potensi));?>';
	var edit_in='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit));?>';
</script>
<?php else:?>
    <script type="text/javascript">
	var stakeholder_ex='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$stakeholder));?>';
	var peran_ex='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$peran));?>';
	var komunikasi_ex='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$komunikasi));?>';
	var potensi_ex='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$potensi));?>';
	var edit_ex='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit));?>';
</script>
<?php endif;