<!-- <h4 class="modal-title">Daftar Risk Indicator Likelihood Analisis & Evaluasi</h4> -->
<?php
$hidesv = ''; 
if ($detail['sts_propose'] == 5) {
	$hide_edit = '';
	$note = 'Revisi risk conteks';

	$disabled= ' ';
	$readonly = '';
} else {
	if ($detail['sts_propose'] > 0) {
		$hide_edit = 'hide';
		$hidesv = 'hide';
		$note = 'risk conteks sudah berstatus Progres Treatment, Tidak bisa melakukan perubahan KRI';

		$disabled = 'disabled';
		$readonly = 'readonly="true"';
	}
}



?>
<tr>
	<td>
		<input id="popup" class="btn btn-info" width="100%" type="button" value="Tambah KRI" name="popup">
	</td>
</tr>

<table class="table table-borderless tbl_kri">
	<thead>
		<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th style="text-align:center;">KRI</th>
			<!-- <th style="text-align:center;">Pembobotan</th> -->
			<th style="text-align:center;">Satuan</th>
			<th style="text-align:center;">Level 1</th>
			<th style="text-align:center;">Level 2</th>
			<th style="text-align:center;">Level 3</th>
			<th style="text-align:center;">Perolehan Data</th>
			<!-- <th style="text-align:center;">Realisasi</th> -->
			<!-- <th style="text-align:center;">Nilai</th> -->
			<!-- <th width="10%"><?php echo lang('msg_tombol_select'); ?></th> -->
		</tr>
	</thead>
	<tbody>
		<?php
		if ($detail['kri']) {
			$combo = $this->db->where('id', $detail['kri'])->get('bangga_data_combo')->row_array();
			$combo_stuan = $this->db->where('id', $detail['satuan'])->get('bangga_data_combo')->row_array(); ?>
			<tr class="text-center">
				<td width="10%" style="text-align:center;">1</td>
				<td><?= $combo['data'] ?></td>
				<td><?php
					if ($combo_stuan['data'] == "%") {
						echo "persen [%]";
					} else {
						echo $combo_stuan['data'];
					}
					?></td>
				<td style="background-color: #7FFF00;color: #000;"><?= $detail['min_rendah'] ?> - <?= $detail['max_rendah'] ?></td>
				<td style="background-color: #FFFF00;color:#000;"><?= $detail['min_menengah'] ?> - <?= $detail['max_menengah'] ?></td>
				<td class="bg-danger" style=" color: #000;"><?= $detail['min_tinggi'] ?> - <?= $detail['max_tinggi'] ?></td>
				<td><?php
					if ($detail['per_data'] == 1) {
						echo "Bulan";
					} elseif ($detail['per_data'] == 2) {
						echo "Triwulan";
					} elseif ($detail['per_data'] == 3) {
						echo "Semester";
					} else {
						echo "Tidak Ada Data";
					}
					?></td>



				<!-- <td><?= $detail['realisasi'] ?></td> -->
			</tr>
		<?php } else { ?>
			<tr>
				<td class="text-center" colspan="8"> tidak ad data Key Risk Indikator <br>silahkan masukan data Key Risk Indikator terlebih dahulu </td>
			</tr>
		<?php } ?>

	</tbody>

</table>


<!-- Konten Popup -->
<div id="popupContent" class="custom-popup-content">

	<!-- <span class="custom-close-btn" </span> -->


	<h3>Key Risk Indikator</h3>
	<p>Tambahkan Key Risk Indikator</p>
	<div class="row">
		<div clas="col-md-12 col-sm-12 col-xs-12">
			<table class="table table-borderless input_kri">
				<tbody>
					<tr>
						<td width="20%">Key Risk Indikator <span class="text-danger">*)</span></td>
						<!-- <td><?= form_dropdown('kri', $krii, ($detail) ? $detail['kri'] : '', 'class="select form-control" style="width:100%;" id="kri"'); ?></td> -->
						<td colspan="2"><?= form_input('kri', ($detail) ?  $combo['data'] : '', 'class="form-control" placeholder="Key Risk Indikato" style="width:100%;" id="kri"' . $readonly); ?></td>
					</tr>
					<tr>
						<td width="20%">Satuan <span class="text-danger">*)</span></td>
						<td colspan="2"><?= form_dropdown('satuan', $satuan, ($detail) ? $detail['satuan'] : '', 'class="select form-control" style="width:100%;" id="satuan"' . $disabled); ?></td>
					</tr>
					<tr>
						<td style="text-align: center; font-weight: bold; color: #000; background-color: navajowhite;" width="100%" colspan="4">Treshold </span></td>
					</tr>
					<tr>
						<td width="20%">Level 3 <span class="text-danger">*)</span> <span class="btn btn-danger"> </span></td>
						<td><?= form_input('min_tinggi', ($detail) ? $detail['min_tinggi'] : '', 'class="form-control" placeholder="Min Level 3" style="width:100%;" id="min_tinggi"' . $disabled); ?></td>

						<td><?= form_input('max_tinggi', ($detail) ? $detail['max_tinggi'] : '', 'class="form-control" placeholder="Max Level 3"  style="width:100%;" id="max_tinggi"' . $disabled); ?></td>
					</tr>
					<tr>
						<td width="20%">Level 2 <span class="text-danger">*)</span> <span class="btn  " style="background-color: #FFFF00;"> </span></td>
						<td><?= form_input('min_menengah', ($detail) ? $detail['min_menengah'] : '', 'class="form-control" placeholder="Min Level 2" style="width:100%;" id="min_menengah"' . $disabled); ?></td>

						<td><?= form_input('max_menengah', ($detail) ? $detail['max_menengah'] : '', 'class="form-control" placeholder="Max Level 2"  style="width:100%;" id="max_menengah"' . $disabled); ?></td>
					</tr>
					<tr>
						<td width="20%">Level 1 <span class="text-danger">*)</span> <span class="btn  " style="background-color: #7FFF00;"> </span></td>
						<td><?= form_input('min_rendah', ($detail) ? $detail['min_rendah'] : '', 'class="form-control" placeholder="Min Level 1" style="width:100%;" id="min_rendah"' . $disabled); ?></td>

						<td><?= form_input('max_rendah', ($detail) ? $detail['max_rendah'] : '', 'class="form-control" placeholder="Max Level 1"  style="width:100%;" id="max_rendah"' . $disabled); ?></td>
					</tr>
					<tr>
						<td width="20%">Perolehan Data <span class="text-danger">*)</span></td>
						<td colspan="2"><?= form_dropdown('per_data', $per_data, ($detail) ? $detail['per_data'] : '', 'class="select form-control" style="width:100%;" id="per_data"' . $disabled); ?></td>
					</tr>
					<input type="hidden" name="id_edit_baru" value="<?= ($id_edit) ? $id_edit : '0' ?>" class="form-control text-right" id="id_edit">
					<input type="hidden" name="rcsa_no" value="<?= ($rcsa_no) ? $rcsa_no : '0' ?>" class="form-control text-right" id="rcsa_no">
				</tbody>
			</table>
			<span>note: <br><i class="text-warning"> <?= $note ?></i></span>
		</div>

		<div class="form-group pull-right" style="margin-right:15px;">
			<span class="btn btn-primary <?= $hidesv ?>" id="simpan_kri"> Simpan </span>
			<span class="btn btn-warning custom-close-btn">&times; Cancel </span>
		</div>

	</div>
</div>

<!-- Lapisan Blur -->
<div id="custom-overlay" class="custom-overlay"></div>


<!-- Tambahkan script berikut di bagian bawah halaman -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="<?= base_url('themes/default/assets/frontend/css/custom-style.css'); ?>">

<script>
	$(document).ready(function() {
		$('.select2').select2(); // Inisialisasi plugin Select2 pada elemen dengan class "select2"
	})

	// Menampilkan Popup saat Tombol "Tampil Popup" diklik
	document.getElementById('popup').addEventListener('click', function() {
		document.getElementById('popupContent').style.display = 'block';
		document.getElementById('custom-overlay').style.display = 'block';
		document.body.style.overflow = 'hidden'; // Menghilangkan scroll pada body
	});

	// Menutup Popup saat Tombol Close di dalam Popup diklik
	document.getElementsByClassName('custom-close-btn')[0].addEventListener('click', function() {
		document.getElementById('popupContent').style.display = 'none';
		document.getElementById('custom-overlay').style.display = 'none';
		document.body.style.overflow = 'auto'; // Mengaktifkan scroll pada body kembali
	});
</script>