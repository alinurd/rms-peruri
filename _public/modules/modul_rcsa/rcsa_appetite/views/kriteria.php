<?php
$tp1 = '_d';
if ($type1 == 1) {
	$tp1 = '_p';
}
?>
<table class="table" id="<?= ($type1 == 1) ? 'tbl_probabilitas' : 'tbl_dampak'; ?>">
	<thead>
		<tr>
			<th width="5%" style="text-align:center;">No.</th>
			<!-- <th><?= ($type == 1) ? 'Strategis' : 'Finansial'; ?></th>  -->
			<th width="15%">Deskripsi</th>
			<th>Sangat Kecil</th>
			<th>Kecil</th>
			<th>Sedang</th>
			<th>Besar</th>
			<th>Sangat Besar</th>
			<th width="5%" style="text-align:center;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		$kriteriak = $this->db->where('kelompok', 'kriteria-kemungkinan')->get(_TBL_DATA_COMBO)->result_array();
		$krti = [];
		foreach ($kriteriak as $k) {
			$krti[$k['id']] = $k['data'];
		}

		$kriteriab = $this->db->where('kelompok', 'kriteria-dampak')->get(_TBL_DATA_COMBO)->result_array();
		$subkriteriab = $this->db->where('kelompok', 'sub-kriteria-dampak')->get(_TBL_DATA_COMBO)->result_array();
		$krtib = [];
		$subkrtib = ['- Select Kriteria Dampak -'];
		$subkrtibab = [];
		$subkrtiba1 = [];
		foreach ($kriteriab as $kb) {
			$krtib[$kb['id']] = $kb['data'];
			$subkrtibab[$kb['id']] = [];
			$subkrtibab1[$kb['id']] = [];
			$subkriteriabc = $this->db->where('kelompok', 'sub-kriteria-dampak')->where('pid', $kb['id'])->get(_TBL_DATA_COMBO)->result_array();
			foreach ($subkriteriabc as $skbc) {
				$subkrtibab[$kb['id']][] = [
					'id' => $skbc['id'],
					'name' => $skbc['data'],
				];
				$subkrtibab1[$kb['id']][$skbc['id']] =  $skbc['data'];
			}
		}
		// foreach ($subkriteriab as $skb) {
		// 	$subkrtib[$skb['id']] = $skb['data'];
		// }
		// $krti = array(
		// 	'Strategis' => 'Strategis', 'Finansial' => 'Finansial', 'Operasional' => 'Operasional',
		// 	'Hukum & Kepatuhan' => 'Hukum & Kepatuhan', 'Bisnis' => 'Bisnis'
		// );
		foreach ($field as $key => $row) {
			if ($this->uri->segment(2) == "view") {
				$edit1 = form_hidden('id_edit' . $tp1 . '[]', $row['id']);
				if ($type1 == 1) {
					$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krti, $row['deskripsi'], " class='form-control' disabled='disabled' width='100%'");
				} else {
					$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krtib, $row['deskripsi'], " class='form-control' disabled='disabled' width='100%'") . '<br>' . form_dropdown('sub_kriteria_no' . $tp1 . '[]', $subkrtibab1[$row['deskripsi']], $row['sub_kriteria_no'], " class='form-control' disabled='disabled' width='100%'");
				}

				// $deskripsi = form_textarea('deskripsi'.$tp1.'[]', $row['deskripsi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sangat_besar = form_textarea('sangat_besar' . $tp1 . '[]', $row['sangat_besar'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$besar = form_textarea('besar' . $tp1 . '[]', $row['besar'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sedang = form_textarea('sedang' . $tp1 . '[]', $row['sedang'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$kecil = form_textarea('kecil' . $tp1 . '[]', $row['kecil'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sangat_kecil = form_textarea('sangat_kecil' . $tp1 . '[]', $row['sangat_kecil'], "  maxlength='10000' class='form-control' disabled='disabled' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
			} else {
				$edit1 = form_hidden('id_edit' . $tp1 . '[]', $row['id']);

				if ($type1 == 1) {
					$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krti, $row['deskripsi'], " class='form-control' width='100%'");
				} else {
					$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krtib, $row['deskripsi'], " class='form-control kriteria-dampak' width='100%'") . '<br>' . form_dropdown('sub_kriteria_no' . $tp1 . '[]', $subkrtibab1[$row['deskripsi']], $row['sub_kriteria_no'], " class='form-control sub-kriteria-dampak' width='100%'");
				}

				// $deskripsi = form_textarea('deskripsi'.$tp1.'[]', $row['deskripsi'],"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sangat_besar = form_textarea('sangat_besar' . $tp1 . '[]', $row['sangat_besar'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$besar = form_textarea('besar' . $tp1 . '[]', $row['besar'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sedang = form_textarea('sedang' . $tp1 . '[]', $row['sedang'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$kecil = form_textarea('kecil' . $tp1 . '[]', $row['kecil'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
				$sangat_kecil = form_textarea('sangat_kecil' . $tp1 . '[]', $row['sangat_kecil'], "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
			}
			++$i;
			$jml = 0;
		?>
			<tr>
				<td style="text-align:center;width:10%;"><?php echo $i . $edit1; ?></td>
				<td><?= $deskripsi; ?></td>
				<td><?= $sangat_kecil; ?></td>
				<td><?= $kecil; ?></td>
				<td><?= $sedang; ?></td>
				<td><?= $besar; ?></td>
				<td><?= $sangat_besar; ?></td>
				<?php if ($this->uri->segment(2) == "view") : ?>
					<td></td>
				<?php else : ?>
					<td style="text-align:center;width:10%;"><a href=" <?= base_url() ?>rcsa/delete_kriteria/<?php echo $row['id']; ?>/<?php echo $this->uri->segment(3); ?>"><i class="fa fa-cut" title="menghapus data"></i></a></td>
				<?php endif ?>
			</tr>
		<?php
		}
		if ($type1 == 1) {
			$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krti, '', " class='form-control' width='100%'");
		} else {
			$deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krtib, '', " class='form-control kriteria-dampak' width='100%'") . '<br>' . form_dropdown('sub_kriteria_no' . $tp1 . '[]', $subkrtib, '', " class='form-control sub-kriteria-dampak' width='100%'");
		}
		// $deskripsi = form_dropdown('deskripsi' . $tp1 . '[]', $krti, '', " class='form-control' width='100%'");
		//$deskripsi = form_textarea('deskripsi'.$tp1.'[]', '',"  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sangat_besar = form_textarea('sangat_besar' . $tp1 . '[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$besar = form_textarea('besar' . $tp1 . '[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sedang = form_textarea('sedang' . $tp1 . '[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$kecil = form_textarea('kecil' . $tp1 . '[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$sangat_kecil = form_textarea('sangat_kecil' . $tp1 . '[]', '', "  maxlength='10000' class='form-control' rows='2' cols='5' style='overflow: hidden; height: 104px;'");
		$edit1 = form_hidden('id_edit' . $tp1 . '[]', '0');
		?>
	</tbody>
</table>
<center>
	<?php if ($this->uri->segment(2) == "view") : ?>
		<button id="<?= ($type1 == 1) ? 'add_probabilitas' : 'add_dampak'; ?>" class="btn btn-primary hidden" type="button" value="Add More" name="<?= ($type1 == 1) ? 'add_probabilitas' : 'add_dampak'; ?>"> Add More </button>
	<?php else : ?>
		<button id="<?= ($type1 == 1) ? 'add_probabilitas' : 'add_dampak'; ?>" class="btn btn-primary" type="button" value="Add More" name="<?= ($type1 == 1) ? 'add_probabilitas' : 'add_dampak'; ?>"> Add More </button>
	<?php endif ?>
</center>
<script>
	var subkrtibab = <?= json_encode($subkrtibab) ?>;
	$(document).on("change",".kriteria-dampak", function() {
		let ini = $(this)
		let child = $(this).parent().find('.sub-kriteria-dampak')
		child.empty();
		subkrtibab[ini.val()].forEach(function(item) {
			child.append(new Option(item.name, item.id))
		})
	})
</script>
<?php
if ($type1 == 1) : ?>
	<script type="text/javascript">
		var deskripsi_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $deskripsi)); ?>';
		var sangat_besar_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sangat_besar)); ?>';
		var besar_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $besar)); ?>';
		var sedang_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sedang)); ?>';
		var kecil_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $kecil)); ?>';
		var sangat_kecil_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sangat_kecil)); ?>';
		var edit_p = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit1)); ?>';
	</script>
<?php else : ?>
	<script type="text/javascript">
		var deskripsi_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $deskripsi)); ?>';
		var sangat_besar_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sangat_besar)); ?>';
		var besar_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $besar)); ?>';
		var sedang_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sedang)); ?>';
		var kecil_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $kecil)); ?>';
		var sangat_kecil_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $sangat_kecil)); ?>';
		var edit_d = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit1)); ?>';
	</script>
<?php endif;
