
<?php
if($data){
  foreach ($data as $d) {
?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <!-- <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td> -->
        <td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle;"><h4>RISK APPETITE</h4></td>
        <td style="width: 24.5%;">No.</td>
        <td style="width: 24.5%;">: 001/RM-FORM/I/<?= $tahun; ?></td>
      </tr>
      <tr>
        <td>Revisi</td>
        <td>: 1</td>
      </tr>
      <tr>
        <td>Tanggal Revisi</td>
        <td>: 31 Januari <?= $tahun; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Owner</td>
        <td colspan="4" style="border: none;">: <?= $d['name']; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Agent</td>
        <td colspan="4" style="border: none;">: <?= $d['officer_name']; ?></td>
      </tr>
    </thead>
  </table>

  <table class="table" id="tbl_sasaran_new">
	<thead>
		<tr>
			<th rowspan="3" width="5%" style="text-align:center;">No.</th>
			<th rowspan="3" style="text-align:center;">Sasaran</th>
			<th rowspan="3" style="text-align:center;">Risk Appetite statement</th>
			<th colspan="7" style="text-align:center;">Threshold</th>
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
		</tr>
	</thead>
	<tbody>
		<?php
    $field=$this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_SASARAN)->result_array();
		$i = 0;
		foreach ($field as $key => $row) {
				$edit = form_hidden('id_edit[]', $row['id']);
				$sasaran = form_textarea('sasaran[]', $row['sasaran'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$statement = form_textarea('statement[]', $row['statement'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$appetite = '<input name="appetite[]" value="' . $row['appetite'] . '" title="Risk Appetite Min"  disabled="disabled" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
				$appetite_max = '<input name="appetite_max[]" value="' . $row['appetite_max'] . '" disabled="disabled" title="Ris Appetite max" type="text" onkeyup="checkInput(this.value)" id="appetite" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance = '<input name="tolerance[]" value="' . $row['tolerance'] . '" disabled="disabled" type="text"title="Risk Tolerance Min"  onkeyup="checkInput(this.value)" id="tolerance" class="form-control" style="overflow: hidden; width: 100%;">';
				$tolerance_max = '<input name="tolerance_max[]" value="' . $row['tolerance_max'] . '" disabled="disabled" title="Risk Tolerance Max"  type="text" onkeyup="checkInput(this.value)" id="tolerance_max" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit = '<input name="limit[]" value="' . $row['limit'] . '"  title="Risk appetite Min"   disabled="disabled"  type="text" onkeyup="checkInput(this.value)" id="limit" class="form-control" style="overflow: hidden; width: 100%;">';
				$limit_max = '<input name="limit_max[]" value="' . $row['limit_max'] . '" disabled="disabled" title="Risk Limit Max"  type="text" onkeyup="checkInput(this.value)" id="limit_max" class="form-control" style="overflow: hidden; width: 100%;">';
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
			</tr>
		<?php
		}
		?>
	</tbody>
</table>



<?php
  }
}