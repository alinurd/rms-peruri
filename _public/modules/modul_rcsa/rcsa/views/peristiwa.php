<!-- <style type="text/css">
.select2-container {
    z-index: 99999;
}
</style> -->
<?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_peristiwa'), ['id_edit' => $id_edit, 'rcsa_no' => $rcsa_no]); ?>
<div class="col-md-12 col-sm-12 col-xs-12" id="input_peristiwa">
	<h4>Tambah Peristiwa Risiko</h4>
	<section class="x_panel">
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
				<!-- 			<li><span class="btn btn-primary pointer" id="simpan_peristiwa"> Simpan </span></li>
				<li><span class="btn btn-info pointer" id="cancel_peristiwa" data-dismiss="modal"> Cancel </span></li> -->
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="table-responsive">
				<table class="table table-borderless" id="tbl_peristiwa">
					<tbody>
						<tr>
							<td width="20%">Sasaran</td>
							<td><?= form_dropdown('sasaran', $sasaran, ($detail) ? $detail['sasaran_no'] : '', 'class="select2 form-control" style="width:100%;" id="sasaran"'); ?></td>
						</tr>
						<tr>
							<td width="20%">Tema Risiko (T1)</td>
							<td><?= form_dropdown('kategori', $kategori, ($detail) ? $detail['kategori_no'] : '', 'class="select2 form-control" style="width:100%;" id="kategori"'); ?></td>
						</tr>
						<tr>
							<td width="20%">Kategori Risiko (T2)</td>
							<td><?= form_dropdown('sub_kategori', $subkategori, ($detail) ? $detail['sub_kategori'] : '', 'class="select2 form-control" style="width:100%;" id="sub_kategori"'); ?></td>

						</tr>
						<tr>
							<td width="20%">Subkategori Risiko</td>
							<td><?= form_dropdown('subrisiko', $np, ($detail) ? $detail['subrisiko'] : '', 'class="select2 form-control" style="width:100%;" id="subrisiko"'); ?></td>
						</tr>

						<tr>
							<td width="20%">Peristiwa</td>
							<td>
								<?= $peristiwa; ?>
							</td>
						</tr>
						<tr>
							<td width="20%">Penyebab</td>
							<td>
								<?= $couse; ?>
							</td>
						</tr>
						<tr>
							<td width="20%">Dampak Kualitatif</td>
							<td><?= $impact; ?></td>
						</tr>
						<tr>
							<td width="20%">TES KRI</td>
							<td><?= $tblkri; ?></td>
						</tr>
						<tr>
							<td width="20%">Dampak Kuantitatif</td>
							<td>
								<div id="l_risk_impact_kuantitatif_parent" class="input-group">
									<!-- <span id="span_l_amoun" class="input-group-addon"> Rp </span> -->
									<?= form_input('risk_impact_kuantitatif', ($detail) ? ($detail['risk_impact_kuantitatif']) : '', 'class="form-control text-right" id="risk_impact_kuantitatif"'); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td width="20%">PIC</td>
							<td><?= form_dropdown('pic', $area, ($detail) ? $detail['pic'] : '', 'class="select2 form-control" style="width:100%;" id="pic"'); ?></td>
						</tr>
						<tr>
							<td width="20%"> Key Risk Indikator</td>
							<td id="kriok" class=" btn btn-info   " width="100%"> <span>KRI</span> </td>

						</tr>




						<table class="table table-borderless list_kri">
							<!-- <div class="text-center btn btn-warning" id="kriok"> Key Risk Indikator</div> -->

							<thead>
								<tr>
									<th width="10%" style="text-align:center;">No.</th>
									<th style="text-align:center;">KRI</th>
									<th style="text-align:center;">Pembobotan</th>
									<th style="text-align:center;">Pencapaian</th>
									<th style="text-align:center;">Realisasi</th>
									<th style="text-align:center;">Nilai</th>
									<!-- <th width="10%"><?php echo lang('msg_tombol_select'); ?></th> -->
								</tr>
							</thead>
							<tbody>
								<?php
								if ($detail['kri']) {
									$combo = $this->db->where('id', $detail['kri'])->get('bangga_data_combo')->row_array(); ?>
									<tr class="text-center">
										<td width="10%" style="text-align:center;">1</td>
										<td><?= $combo['data'] ?></td>
										<td><?= $detail['pembobotan'] ?>%</td>
										<td>Pencapaian</td>
 										<td><?= $detail['realisasi'] ?></td>
										<td>nilai</td>
									</tr>
								<?php } else { ?>
									<tr>
										<td class="text-center" colspan="6"> tidak ad data Key Risk Indikator <br>silahkn masukan data Key Risk Indikator terlebih dahulu </td>
									</tr>
								<?php } ?>

							</tbody>

						</table>
						<div class="clearfix"></div>

						<table class="table table-borderless input_kri hide">
							<tbody>
								<tr>
									<td width="20%">Key Risk Indikator <span class="text-danger">*)</span></td>
									<td><?= form_dropdown('kri', $krii, ($detail) ? $detail['kri'] : '', 'class="select2 form-control" style="width:100%;" id="kri"'); ?></td>
								</tr>
								<tr>
									<td width="20%">Satuan <span class="text-danger">*)</span></td>
									<td><?= form_dropdown('satuan', $satuan, ($detail) ? $detail['satuan'] : '', 'class="select2 form-control" style="width:100%;" id="satuan"'); ?></td>
								</tr>
								<tr>
									<td width="20%">Tinggi<span class="text-danger">*)</span> <span class="btn btn-danger"> </span></td>
									<td><?= form_input('min_tinggi', ($detail) ? $detail['min_tinggi'] : '', 'class="form-control" placeholder="Min Pencapaian" style="width:100%;" id="min_tinggi"'); ?></td>

									<td><?= form_input('max_tinggi', ($detail) ? $detail['max_tinggi'] : '', 'class="form-control" placeholder="Mix Pencapaian"  style="width:100%;" id="max_tinggi"'); ?></td>
								</tr>
								<tr>
									<td width="20%">menengah<span class="text-danger">*)</span> <span class="btn  " style="background-color: #FFFF00;"> </span></td>
									<td><?= form_input('min_menengah', ($detail) ? $detail['min_menengah'] : '', 'class="form-control" placeholder="Min Pencapaian" style="width:100%;" id="min_menengah"'); ?></td>

									<td><?= form_input('max_menengah', ($detail) ? $detail['max_menengah'] : '', 'class="form-control" placeholder="Mix Pencapaian"  style="width:100%;" id="max_menengah"'); ?></td>
								</tr>
								<tr>
									<td width="20%">rendah<span class="text-danger">*)</span> <span class="btn  " style="background-color: #7FFF00;"> </span></td>
									<td><?= form_input('min_rendah', ($detail) ? $detail['min_rendah'] : '', 'class="form-control" placeholder="Min Pencapaian" style="width:100%;" id="min_rendah"'); ?></td>

									<td><?= form_input('max_rendah', ($detail) ? $detail['max_rendah'] : '', 'class="form-control" placeholder="Mix Pencapaian"  style="width:100%;" id="max_rendah"'); ?></td>
								</tr>
								<!-- <tr>
									<td width="20%">Realisasi<span class="text-danger">*)</span> </td>
									<td><?= form_input('realisasi', ($detail) ? $detail['realisasi'] : '', 'class="form-control" placeholder="realisasi" style="width:100%;" id="realisasi"'); ?></td>


								</tr> -->
							</tbody>
						</table>

			</div>
			</tbody>
			</table>
		</div>
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
				<li><span class="btn btn-primary pointer" id="simpan_peristiwa"> Simpan </span></li>
				<li><span class="btn btn-default pointer" id="cancel_peristiwa" data-dismiss="modal"> Kembali </span></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</section>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 hide" id="input_library">
	<section class="x_panel">
		<div class="x_content">

		</div>
	</section>
</div>
<?= form_close(); ?>
<?php

$riskCouse = form_textarea('risk_couse[]', '', " id='risk_couse' readonly='readonly' maxlength='500' size=500 class='form-control browse-couse' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskCouse_no = form_hidden(['risk_couse_no[]' => 0]);

$riskEvent = form_textarea('risk_event[]', '', " id='peristiwa' readonly='readonly' maxlength='500' size=500 class='form-control browse-event' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskEvent_no = form_hidden(['peristiwa[]' => 0]);

$riskImpact = form_textarea('risk_impact[]', '', " id='risk_impact' readonly='readonly' maxlength='500' size=500 class='form-control browse-impact' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskImpact_no = form_hidden(['risk_impact_no[]' => 0]);
?>

<script>
	var riskEvent = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskEvent)); ?>';
	var riskEvent_no = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskEvent_no)); ?>';
	var riskCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskCouse)); ?>';
	var riskCouse_no = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskCouse_no)); ?>';
	var riskImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskImpact)); ?>';
	var riskImpact_no = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $riskImpact_no)); ?>';
	$(function() {
		$("#kategori").change(function() {
			var parent = $(this).parent();
			var nilai = $(this).val();
			var kelompok = 'subkel-library';
			var kel_targt = 'subkel-library';
			var data = {
				'id': nilai,
				'kelompok': kel_targt
			};
			console.log(data)
			var target_combo = $("#sub_kategori");
			var url = "ajax/get_ajax_combo";
			cari_ajax_combo("post", parent, data, target_combo, url);
		})
	});
</script>