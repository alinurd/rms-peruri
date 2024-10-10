<style>
	.table-container {
		width: 100%;
		height: 300px;
		overflow: auto;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	th,
	td {
		padding: 8px;
		text-align: left;
		border-bottom: 1px solid #ddd;
	}

	.sticky-thead th {
		position: sticky;
		top: 0;
		background-color: #f5f5f5;
		z-index: 1;
	}

	.sticky-thead tr:nth-child(2) th {
		position: sticky;
		top: 35px;
		/* Sesuaikan dengan tinggi row pertama */
		background-color: #f5f5f5;
		z-index: 1;
	}

	/* Style checkbox */
	.custom-checkbox input[type="checkbox"] {
		display: none;
	}

	.custom-checkbox label {
		position: relative;
		padding-left: 25px;
		cursor: pointer;
	}

	.custom-checkbox label:before {
		content: '';
		position: absolute;
		left: 0;
		top: 0;
		width: 18px;
		height: 18px;
		border: 2px solid #ccc;
		background-color: #fff;
	}

	.custom-checkbox input[type="checkbox"]:checked+label:before {
		background-color: blue;
	}

	.custom-checkbox label:after {
		content: '';
		position: absolute;
		left: 6px;
		top: 3px;
		width: 5px;
		height: 10px;
		border: solid white;
		border-width: 0 2px 2px 0;
		transform: rotate(45deg);
		display: none;
	}

	.custom-checkbox input[type="checkbox"]:checked+label:after {
		display: block;
	}
</style>
<?php
if ($mode == "view") {
	$disabled = 'disabled';
	$readonly = 'readonly';
	// $checked = 'checked';
	// $checked = 'checked';
	$hide_edit = 'hide';
} elseif ($mode == "edit" && $mode == "add") {
	$hide_edit = '';
	$checked = '';
} elseif (!$id) {
	$hide_edit = 'hide';
}

// doi::dump($field);

?>
<i>Note: &nbsp;</i> <b>Perhatikan ketika melakukan pengisian data, data yang sudah di checklist tidak bisa di uncheklist!</b><br>
<div class="table-container border">
	<table>
		<thead class="sticky-thead">
			<tr>
				<th rowspan="2">No</th>
				<th class="text-center" rowspan="2">Proses Management Risiko</th>
				<th colspan="12" class="text-center">Waktu Implementasi</th>
				<th class="text-center" rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>Jan</th>
				<th>Feb</th>
				<th>Mar</th>
				<th>Apr</th>
				<th>Mei</th>
				<th>Jun</th>
				<th>Jul</th>
				<th>Ags</th>
				<th>Sep</th>
				<th>Okt</th>
				<th>Nov</th>
				<th>Des</th>
			</tr>
		</thead>

		<?php
		// if ($id) {
		?>
		<tbody>
			<?php
			$no = 1;

			// doi::dump($field);
			foreach ($combo as $data) {


				// doi::dump($imp);
			?>
				<tr>
					<td width="10px"><?= $no++ ?></td>
					<td width="50%"><?= $data['data'] ?></td>
					<?php
					$implementasi = [];

					for ($i = 0; $i < 12; $i++) {
						$month = date('m', strtotime("January +$i months")); //old
						$month = str_pad($i, 2, '0', STR_PAD_LEFT); // Two-digit month format (01, 02, ..., 12)

						$datbln = date('M', strtotime("January +$i months"));
						$blntl = date('F', strtotime("January +$i months"));
						$checkboxId = 'checkbox-' . ($no + $i) . '-code-' . $data['kode'];

						$idlop = $month . strval($data['id']);						if ($id) {
							$imp = $this->db
								->select('jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec,ket')
								->where('rcsa_no', $id)
								->where('combo_no', $data['id'])
								->get(_TBL_RCSA_IMPLEMENTASI)
								->row_array();
							$checked = '';
							$disabled = '';

							//ambil data berdasrkan name field nya dan langsung cocokan dengan idlop nya
							if ($imp && isset($imp[strtolower($datbln)]) && $imp[strtolower($datbln)] === $idlop) {
								$checked = 'checked';
								$disabled = 'disabled';
							}
						}



						// cek data dulu
						// doi::dump($imp[strtolower($datbln)]);
						// doi::dump($datbln);
						// doi::dump($checked);
					?>
						<td class="custom-checkbox">
							<input type="checkbox" id="<?= $idlop ?>" name="implementasi[<?= $data['id'] ?>][bulan][]" value="<?= $datbln ?>##<?= $month ?>" <?= $checked ?> <?= $disabled ?>>
							<label for="<?= $idlop ?>" title="<?= $blntl ?>"></label>
						</td>
					<?php
					}
					?>

					<td>
						<textarea placeholder="keterangan" title="keterangan proses management risiko" class="<?= $disabled ?>" name="implementasi[<?= $data['id'] ?>][ket]" id="" cols="3" rows="2"><?= isset($imp) ? $imp['ket'] : '' ?></textarea>
					</td>


				<?php
			}
				?>
		</tbody>


		<!-- <tr>
				<th colspan="15" class="text-center"> Risk Context Tidak di Temukan <br> silahkan selesaikan pengisian risk context terlebih dahulu</th>-->
	</table>
</div>