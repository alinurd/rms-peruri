<?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_realisasi'), ['id_edit' => $edit_no, 'rcsa_no' => $rcsa_no, 'detail_rcsa_no' => $rcsa_detail_no]); ?>
<div class="col-md-12 col-sm-12 col-xs-12" id="input_realisasi">
	<section class="x_panel">
		Input Treatment
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
				<!-- 				<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
				<li><span class="btn btn-info pointer" id="close_input_realisasi"  > Cancel </span></li> -->
			</ul>
			<div class="clearfix"></div>
		</div>
		<?php
		$a = date("m");
		$b = date("y");
		// $a="5";
		// $b="20";
		$hoho = array();
		$status = array();
		foreach ($cek as $key => $row) {
			$bb = $row['create_date'];
			$time = strtotime($bb);
			$month = date("m", $time);
			$year = date("y", $time);
			$hoho[] = array('bulan' => $month, 'tahun' => $year);
			// $hoho[]=array('bulan'=>$month);
			// var_dump($hoho);
			// die();
			if ($year != $b) {
				$status[] = TRUE;
			} else {
				if ($month != $a) {
					$status[] = TRUE;
				} else {
					$status[] = FALSE;
				}
			}
		}
		// var_dump($status);
		// var_dump($id);
		?>
		<hr>


		<div class="x_content">
			<div class="table-responsive">
				<div class="popup text-center" id="infoPopup">Penjelasan penerapan internal control dan mitigasi proaktif/reaktif <br> maupun tambahan mitigasi lain yang dilakukan</div>
				<?php
				foreach ($realisasi as $key => $row) { ?>
					<div class="col-md-3 col-sm-3 col-xs-3 mitigasi_<?= $key; ?> <?= ($row['show']) ? '' : 'hide'; ?>"><?= $row['label'] ?></div>
					<div class="col-md-9 col-sm-9 col-xs-9 mitigasi_<?= $key; ?> <?= ($row['show']) ? '' : 'hide'; ?>">
						<div class="form-group form-inline"><?= $row['isi'] ?></div>
					</div>
				<?php } ?>
			</div>

		</div>
		<hr>
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
				<?php if ($id != 0) : ?>
					<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
				<?php elseif (!in_array(FALSE, $status)) : ?>
					<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
				<?php else : ?>
					<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
				<?php endif; ?>
				<li><span class="btn btn-info pointer" id="close_input_realisasi"> Cancel </span></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</section>
</div>
<?= form_close(); ?>
<script>
	// Fungsi untuk menampilkan popup
	function showPopup() {
		var popup = document.getElementById('infoPopup');
		popup.style.display = 'block';
	}

	// Fungsi untuk menyembunyikan popup
	function hidePopup() {
		var popup = document.getElementById('infoPopup');
		popup.style.display = 'none';
	}
</script>

<style>
	/* Gaya untuk popup */
	.popup {
		display: none;
		position: absolute;
		/* Gunakan absolute agar popup tumpang tindih dengan elemen lain */
		padding: 10px;
		background-color: #f9f9f9;
		border: 1px solid #ccc;
		border-radius: 5px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		z-index: 9999;
	}

	#realisasi {
		position: relative;
		z-index: 1;
		/* Atur nilai z-index elemen realisasi agar lebih rendah daripada popup */
	}
</style>