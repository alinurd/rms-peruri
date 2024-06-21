<?php
	$hide_edit='';
	$sts_risk=intval($parent['sts_propose']);
	if ($sts_risk>=3){
		$hide_edit=' hide ';
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-sm-6 panel-heading">
				<h3 style="padding-left:10px;"><?=lang('msg_title');?></h3>
			</div>
			<div class="col-sm-6" style="text-align:right">
				<ul class="breadcrumb">
					<li> <a href="<?=base_url();?>"> <i class="fa fa-home"></i> Home</a></li>
					<li><a href="<?=base_url(_MODULE_NAME_REAL_);?>"><?=_MODULE_NAME_;?></a></li>
					<li><a><?=lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel widget_tally_box">
			<div class="x_title">
				<strong><?=$parent['corporate'];?></strong>
				<ul class="nav navbar-right panel_toolbox">
					<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content" style="overflow-x: auto;">
				<?php
				foreach($judul as $key=>$row): ?>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<table class="table">
					<?php
					foreach($row as $jdl): ?>
							<tr><td width="30%"><em><?=$jdl['label'];?></em><br/><div class="ml10 text-danger"><?=$jdl['konten'];?></div></td></tr>
					<?php endforeach;?>
						</table>
					</div>
				<?php endforeach;?>
			</div>
		</section>
	</div>
</div>
<?=form_open_multipart(base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/save'), array('id' => 'form_risk_event'));
echo $hidden;
 ?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<span class="<?=$hide_edit;?>"><a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-primary <?=$hide_edit;?>" id="btnAdd"> Tambah </a></span>
		<span class="btn btn-success" id="cmdRisk_Register" data-id="<?=$parent['id'];?>"> Risk Register </span>
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/'.$parent['id']);?>" class="btn btn-default"  id="btnBack"> Kembali ke List </a>
		<span class="<?=$hide_edit;?>"><button type="submit" action="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-warning pull-right"  id="btnSave"> Simpan </a></span>&nbsp;
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs " role="tablist">
						<li role="presentation" class="active"><a href="#tab_identifikasi" id="identifikasi" role="tab" data-toggle="tab" aria-expanded="true">Identifikasi Resiko</a></li>
						<li role="presentation" class=""><a href="#tab_level" role="tab" id="level" data-toggle="tab" aria-expanded="false">Level Risiko</a></li>
						<?php if ($mode=='edit'){ ?>
						<li role="presentation" class=""><a href="#tab_mitigasi" role="tab" id="mitigasi" data-toggle="tab" aria-expanded="false">Mitigasi</a></li>
						<?php }?>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_identifikasi" aria-labelledby="home-tab">
							<?php
							foreach($identi as $row){ ?>
							<div class="col-md-3 col-sm-3 col-xs-3"><?=$row['label']?></div>
							<div class="col-md-9 col-sm-9 col-xs-9"><div class="form-group"><?=$row['isi']?></div></div>
							<?php } ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_level" aria-labelledby="profile-tab">
							<?php
							foreach($level_resiko as $row){ ?>
							<div class="col-md-3 col-sm-3 col-xs-3"><?=$row['label']?></div>
							<div class="col-md-9 col-sm-9 col-xs-9"><div class="form-group form-inline"><?=$row['isi']?></div></div>
							<?php } ?>
						</div>
						<?php if ($mode=='edit'){ ?>
						<div role="tabpanel" class="tab-pane fade" id="tab_mitigasi" aria-labelledby="profile-tab">
							<?=$list_mitigasi;?>
						</div>
						<?php };?>
					</div>
				</div>
			</div>
		</section>
	</aside>
	<div class="col-md-12 col-sm-12 col-xs-12 hide">
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-primary" id="btnAdd"> Tambah </a>
		<span class="btn btn-success" id="cmdRisk_Register" data-id="<?=$parent['id'];?>"> Risk Register </span>
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/'.$parent['id']);?>" class="btn btn-default"  id="btnBack"> Kembali ke List </a>
		<button type="submit" action="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-warning pull-right"  id="btnSave"> Simpan </a>&nbsp;
	</div>
</div>
<?=form_close();

$riskCouse = form_textarea('risk_couse[]', ''," id='risk_couse' readonly='readonly' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskCouse_no = form_hidden(['risk_couse_no[]'=>0]);

$riskImpact = form_textarea('risk_impact[]', ''," id='risk_impact' readonly='readonly' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
$riskImpact_no = form_hidden(['risk_impact_no[]'=>0]);

$attDetail = form_upload('attact[]');
?>

<script>
	var riskCouse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskCouse));?>';
	var riskCouse_no='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskCouse_no));?>';
	var riskImpact='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskImpact));?>';
	var riskImpact_no='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$riskImpact_no));?>';
	var attDetail='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$attDetail));?>';
	var master_level = '<?php echo $master_level;?>';
	var data_master_level = $.parseJSON(master_level);
</script>
