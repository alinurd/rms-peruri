	<table class="table" id="instlmt_impact">
		<thead>
			<tr>
				<th width="10%" style="text-align:center;">No.</th>
				<th>Risk Impact</th>
				<th width="10%" style="text-align:center;">Aksi</th>
			</tr>
		</thead>
		<tbody>

			<?php
			$i = 0;
			foreach ($field as $key => $row) {
				$edit = form_hidden('id_edit[]', $row['edit_no']);
				$cbo = form_dropdown('library_no[]', $cbogroup, $row['child_no'], 'class="select2 form-control" style="width:100%;"');
				$cbi = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
				++$i;
			?>
				<tr>
					<td style="text-align:center;width:10%;"><?php echo $i . $edit; ?></td>
					<td><?php echo $cbo; ?></td>
					<td style="text-align:center;width:10%;"><a nilai="<?php echo $row['edit_no']; ?>" style="cursor:pointer;" onclick="remove_install(this,<?php echo $row['edit_no']; ?>)"><i class="fa fa-cut" title="menghapus data"></i></a></td>
				</tr>
			<?php }
			$cbo = form_dropdown('library_no[]', $cbogroup, '', 'class="form-control select5" style="width:100%;"');
			$edit = form_hidden('id_edit[]', '0');
			$cbi = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
			?>
		</tbody>
	</table>
	<center>
		<input id="add_impact" class="btn btn-primary" type="button" onclick="add_install_impact()" value="Add More" name="add_impact">
		<button id="add_new_impact" class="btn btn-primary" type="button" onclick="add_new_install_impact()" value="Add New" name="add_new_impact"> Add New </button>
	</center>

	<script type="text/javascript">
		var no_urut = 1;
		var cbiImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbi)); ?>';
		var cboImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbo)); ?>';
		var editImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';
	</script>