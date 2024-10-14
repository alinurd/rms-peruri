<table class="table" id="tbl_sasaran">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No.</th>
            <th>Sasaran</th>
            <!-- <th>Strategi</th> -->
            <!-- <th>Kebijakan</th> -->
            <th width="10%" style="text-align:center;">Aksi</th>
        </tr>
    </thead
    ><tbody>
<?php
	$i=0;
	foreach($field as $key=>$row)
	{
	if ($this->uri->segment(2) == "view"){
		$edit=form_hidden('id_edit[]',$row['id']);
		$sasaran = form_textarea('sasaran[]', $row['sasaran'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		// $strategi = form_textarea('strategi[]', $row['strategi'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		// $kebijakan = form_textarea('kebijakan[]', $row['kebijakan'],"  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	}else{
		$edit=form_hidden('id_edit[]',$row['id']);
		$sasaran = form_textarea('sasaran[]', $row['sasaran'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		// $strategi = form_textarea('strategi[]', $row['strategi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		// $kebijakan = form_textarea('kebijakan[]', $row['kebijakan'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	}
        ++$i;
        $jml=0;

		?>
		<tr>
			<td style="text-align:center;width:10%;"><?php echo $i.$edit;?></td>
			<td><?=$sasaran;?></td>
			<?php if ($this->uri->segment(2) == "view"): ?>
			<td></td>
			<?php else: ?>
				<td style="text-align:center;width:10%;"><a href=" <?= base_url()?>rcsa/delete_sasaran/<?php echo $row['id'];?>/<?php echo $this->uri->segment(3); ?>" ><i class="fa fa-cut" title="menghapus data"></i></a></td>
			<?php endif ?>
		</tr>
        <?php
    }
	$sasaran = form_textarea('sasaran[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$strategi = form_textarea('strategi[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$kebijakan = form_textarea('kebijakan[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
	$edit=form_hidden('id_edit[]','0');
	?>
	</tbody></table><center>
		<?php if ($this->uri->segment(2) == "view"): ?>
				<button id="add_sasaran" class="btn btn-primary hidden" type="button" value="Add More" name="add_sasaran"> Add More </button>
		<?php else : ?>
				<button id="add_sasaran" class="btn btn-primary" type="button" value="Add More" name="add_sasaran"> Add More </button>
		<?php endif ?>
	</center>

<script type="text/javascript">
	var sasaran='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$sasaran));?>';
	var strategi='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$strategi));?>';
	var kebijakan='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$kebijakan));?>';
	var edit='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit));?>';
</script>