<h4>Risk Analysis</h4>
<?=form_open_multipart(base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/save'), array('id' => 'form_level'), ['id_edit'=>$id_edit, 'rcsa_no'=>$rcsa_no]);?>
<div class="col-md-12 col-sm-12 col-xs-12" id="input_level">
	<section class="x_panel">
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
			   <!-- <li><span class="btn btn-primary pointer" id="simpan_level"> Simpan </span></li>
				<li><span class="btn btn-info pointer" id="cancel_level" data-dismiss="modal"> Cancel </span></li> -->
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="table-responsive">
                <?php
                foreach($level_resiko as $row){ ?>
                <div class="col-md-3 col-sm-3 col-xs-3"><?=$row['label']?></div>
                <div class="col-md-9 col-sm-9 col-xs-9"><div class="form-group form-inline"><?=$row['isi']?></div></div>
                <?php } ?>
			</div>
		</div>
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
                <li><span class="btn btn-primary pointer" id="simpan_level"> Simpan </span></li>
				<li><span class="btn btn-default pointer" id="cancel_level" data-dismiss="modal"> Kembali </span></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</section>
</div>
<?=form_close();?>
<?php

$riskCouse = form_textarea('risk_couse[]', ''," id='risk_couse' readonly='readonly' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskCouse_no = form_hidden(['risk_couse_no[]'=>0]);

$riskImpact = form_textarea('risk_impact[]', ''," id='risk_impact' readonly='readonly' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskImpact_no = form_hidden(['risk_impact_no[]'=>0]);
?>

<script>
	var riskCouse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskCouse));?>';
	var riskCouse_no='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskCouse_no));?>';
	var riskImpact='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskImpact));?>';
	var riskImpact_no='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskImpact_no));?>';
	// $(function(){
	// 	$(".hoho").select2({
	// 		allowClear: false,
	// 		width:'style',
	// 		dropdownParent:	$('#modal_general')
	// 	})

	// });
</script>