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
							<td><?= form_input('sub_kategori', ($detail) ? $detail['sub_kategori'] : '', 'class="form-control" style="width:100%;" id="sub_kategori"'); ?></td>
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
							<td width="20%">Dampak Kuantitatif</td>
							<td>
								<div id="l_risk_impact_kuantitatif_parent" class="input-group">
									<!-- <span id="span_l_amoun" class="input-group-addon"> Rp </span> -->
									<?= form_input('risk_impact_kuantitatif', ($detail) ? ($detail['risk_impact_kuantitatif']) : '', 'class="form-control text-right" id="risk_impact_kuantitatif"'); ?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
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
		// $(".select2").select2({
		// 	allowClear: false,
		// 	width:'style'
		// })

		// $('.select4').select2({
		// 	dropdownParent: $('#modal_general'),
		// 	allowClear: false,
		// 	width:'style'
		// });

	});
	// $("#peristiwa").select2({
	// 			dropdownParent: $('#modal_general')
	// 		});
	// $(document).ready(function() {
	// 	$("#peristiwa").select2({
	// 		dropdownParent: $('#modal_general')
	// 	});
	// });
</script>