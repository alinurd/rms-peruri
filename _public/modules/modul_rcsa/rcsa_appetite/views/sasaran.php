<table class="table" id="tbl_sasaran_new">
	<thead>
		<tr>
			<th rowspan="3" width="5%" style="text-align:center;">No.</th>
			<th rowspan="3" style="text-align:center;">Sasaran</th>
			<th rowspan="3" style="text-align:center;">Risk Appetite statement</th>
			<th colspan="7" style="text-align:center;">Threshold</th>
			<!-- <th colspan="9" style="text-align:center;">Threshold</th> -->
			<th rowspan="3" width="10%" style="text-align:center;">Aksi</th>
		</tr>
		<tr>
			<th colspan="3" style="text-align:center;">Risk Appetite</th>
			<th colspan="3" style="text-align:center;">Risk Tolerance</th>
			<th rowspan="3" style="text-align:center;">Risk Limit</th>
			<!-- <th colspan="3" style="text-align:center;">Risk Limit</th> -->
		</tr> 
		<tr>
			<th style="text-align:center;">Min</th>
			<th style="text-align:center;">-</th>
			<th style="text-align:center;">Max</th>
			<th style="text-align:center;">Min</th>
			<th style="text-align:center;">-</th>
			<th style="text-align:center;">Max</th>
			<!-- <th style="text-align:center;">Min</th>
			<th style="text-align:center;">-</th>
			<th style="text-align:center;">Max</th> -->
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		foreach ($field as $key => $row) {
			// doi::dump($row);	
			if ($this->uri->segment(2) == "view") {
				$edit = form_hidden('id_edit[]', $row['id']);
				$sasaran = form_textarea('sasaran[]', $row['sasaran'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$statement = form_textarea('statement[]', $row['statement'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$appetite = '<input name="appetite[]" value="' . $row['appetite'] . '" title="Risk Appetite Min"  title="appetite min" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
				$appetite_max = '<input name="appetite_max[]" value="' . $row['appetite_max'] . '" title="Ris Appetite max" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance = '<input name="tolerance[]" value="' . $row['tolerance'] . '" type="text"title="Risk Tolerance Min"  onkeyup="checkInput(this.value)" id="tolerance" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance_max = '<input name="tolerance_max[]" value="' . $row['tolerance_max'] . '" title="Risk Tolerance Max"  type="text" onkeyup="checkInput(this.value)" id="tolerance_max" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit = '<input name="limit[]" value="' . $row['limit'] . '" title="Risk appetite Min"  " type="text" onkeyup="checkInput(this.value)" id="limit" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit_max = '<input name="limit_max[]" value="' . $row['limit_max'] . '" title="Risk Limit Max"  type="text" onkeyup="checkInput(this.value)" id="limit_max" class="form-control" style="overflow: hidden; width: 100%;">';
			} else {
				$edit = form_hidden('id_edit[]', $row['id']);
				$sasaran = form_textarea('sasaran[]', $row['sasaran'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$statement = form_textarea('statement[]', $row['statement'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");

				$appetite = '<input name="appetite[]" value="' . $row['appetite'] . '" title="Risk appetite Min" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
				$appetite_max = '<input name="appetite_max[]" value="' . $row['appetite_max'] . '" title="Risk appetite Max"  type="text" onkeyup="checkInput(this.value)" id="appetite_max" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance = '<input name="tolerance[]" value="' . $row['tolerance'] . '" title="Risk Tolerance min" type="text" onkeyup="checkInput(this.value)" id="tolerance" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance_max = '<input name="tolerance_max[]" value="' . $row['tolerance_max'] . '" title="Risk Tolerance Max" type="text" onkeyup="checkInput(this.value)" id="tolerance_max" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit = '<input name="limit[]" value="' . $row['limit'] . '" title="Risk Limit  " type="text" onkeyup="checkInput(this.value)" id="limit" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit_max = '<input name="limit_max[]" value="' . $row['limit_max'] . '" title="Risk Limit Max" type="text" onkeyup="checkInput(this.value)" id="limit_max" class="form-control" style="overflow: hidden; width: 100%;">';
			}
			++$i;
			$jml = 0;

		?>
			<tr>
				<td style="text-align:center;width:10%;"><?php echo $i . $edit; ?></td>
				<td><?= $sasaran; ?></td>
				<td><?= $statement; ?></td>
				<td><?= $appetite; ?></td>
				<td>-</td>
				<td><?= $appetite_max; ?></td>
				<td><?= $tolerance; ?></td>
				<td>-</td>
				<td><?= $tolerance_max; ?></td>
				<td><?= $limit; ?></td>
				<!-- <td>-</td>
				<td><?= $limit_max; ?></td> -->
				<?php if ($this->uri->segment(2) == "view") : ?>
					<td></td>
				<?php else : ?>
					<td style="text-align:center;width:10%;"><a href=" <?= base_url() ?>rcsa-appetite/delete_sasaran/<?php echo $row['id']; ?>/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-cut" title="menghapus data"></i></a></td>
				<?php endif ?>
			</tr>
		<?php
		}
		$sasaran = form_textarea('sasaran[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$statement = form_textarea('statement[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$appetite = '<input name="appetite[]";  title="Risk Appetite Min" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
		$appetite_max = '<input name="appetite_max[]"; title="Risk Appetite Max" type="text" onkeyup="checkInput(this.value)" id="appetite_max" class="form-control" style="overflow: hidden; width: 100%;">';
		$tolerance = '<input name="tolerance[]"; title="Risk Tolerance Min" type="text" onkeyup="checkInput(this.value)" id="tolerance" class="form-control" style="overflow: hidden; width: 100%;">';
		$tolerance_max = '<input name="tolerance_max[]"; title="Risk Tolerance Max" type="text" onkeyup="checkInput(this.value)" id="tolerance_max" class="form-control" style="overflow: hidden; width: 100%;">';
		$limit = '<input name="limit[]";  title="Risk Limit " type="text" id="limit" onkeyup="checkInput(this.value)" class="form-control" style="overflow: hidden; width: 100%;">';
		$limit_max = '<input name="limit_max[]"; title="Risk Limit Max" type="text" id="limit_max" onkeyup="checkInput(this.value)" class="form-control" style="overflow: hidden; width: 100%;">';

		$edit = form_hidden('id_edit[]', '0');
		?>
		<!-- form_input(['name' => 'progress', 'id' => 'progress', , 'value' => ($data['detail']) ? $data['detail']['progress_detail'] : '', 'class' => 'form-control', 'style' => 'width:15%;']) -->
	</tbody>
</table>
<center>
	<?php if ($this->uri->segment(2) == "view") : ?>
		<button id="add_sasaran_new" class="btn btn-primary hidden" type="button" value="Add More" name="add_sasaran_new"> Add More </button>
	<?php else : ?>
		<button id="add_sasaran_new" class="btn btn-primary" type="button" value="Add More" name="add_sasaran_new"> Add More </button>
	<?php endif ?>
</center>

<script type="text/javascript">
	var sasaran = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sasaran)); ?>';
	var statement = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $statement)); ?>';
	var appetite = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $appetite)); ?>';
	var appetite_max = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $appetite_max)); ?>';
	var tolerance = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $tolerance)); ?>';
	var tolerance_max = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $tolerance_max)); ?>';
	var limit = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $limit)); ?>';
	var limit_max = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $limit_max)); ?>';
	var edit = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';




	function checkInput(value) {
		// Regular expression untuk memeriksa apakah value hanya mengandung angka dan koma
		var regex = /^[0-9,.]+$/;

		if (!regex.test(value)) {
			// Jika value tidak sesuai dengan regular expression, berikan alert
			alert('Hanya angka dan koma yang diperbolehkan!');
		}
	}
</script>