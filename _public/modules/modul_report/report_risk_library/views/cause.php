	<table class="table" id="instlmt_cause"><thead><tr>
	<th width="10%" style="text-align:center;">No.</th>
	<th>Cause</th>
	<th width="10%" style="text-align:center;">Aksi</th>
	</tr></thead><tbody>
		
<?php
	$i=0;
	foreach($field as $key=>$row)
	{ 
		$edit=form_hidden('id_edit[]',$row['edit_no']);
		$cbo = form_dropdown('library_no[]', $cbogroup, $row['child_no'],'class="select2 form-control" style="width:100%;"');
		++$i;
		?>
		<tr>
			<td style="text-align:center;width:10%;"><?php echo $i.$edit;?></td>
			<td><?php echo $cbo;?></td>
			<td style="text-align:center;width:10%;"><a nilai="<?php echo $row['edit_no'];?>" style="cursor:pointer;" onclick="remove_install(this,<?php echo $row['edit_no'];?>)"><i class="fa fa-cut" title="menghapus data"></i></a></td>
		</tr>
	<?php }
	$cbo = form_dropdown('library_no[]', $cbogroup,'','class="form-control select4" style="width:100%;"');
	$edit=form_hidden('id_edit[]','0');
	?>
	</tbody></table><center>
	<button id="add_cause" class="btn btn-primary" type="button" value="Add More" name="add_cause"> Add More </button>
	</center>
	
<script type="text/javascript">
	var cboCouse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$cbo));?>';
	var editCouse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$edit));?>';
</script>