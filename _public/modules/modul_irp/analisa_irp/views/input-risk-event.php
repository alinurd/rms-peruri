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
				<div class="col-md-6 col-sm-6 col-xs-6">
					<table class="table">
						<tr><td width="30%"><em><?=lang('msg_field_corporate');?></em><br/><div class="ml10 text-danger"><?=$parent['corporate'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_owner_no');?></em><br/><div class="ml10 text-danger"><?=$parent['name'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_type');?></em><br/><div class="ml10 text-danger"><?=$parent['start_date'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_periode');?></em><br/><div class="ml10 text-danger"><?=$parent['periode_name'];?></div></td></tr>
					</table>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<table class="table">
						<tr><td width="30%"><em><?=lang('msg_field_total_aktifitas');?></em><br/><div class="ml10 text-danger"><?=$parent['corporate'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_total_mitigasi');?></em><br/><div class="ml10 text-danger"><?=$parent['name'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_progress_mitigasi');?></em><br/><div class="ml10 text-danger"><?=$parent['start_date'];?></div></td></tr>
						<tr><td><em><?=lang('msg_field_tingkat_resiko');?></em><br/><div class="ml10 text-danger"><?=$parent['periode_name'];?></div></td></tr>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<?=form_open(base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/save'), array('id' => 'form_risk_event'));
echo $hidden;
 ?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-primary" id="btnAdd"> Tambah </a>
		<span class="btn btn-success" id="cmdRisk_Register" data-id="<?=$parent['id'];?>"> Risk Register </span>
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/'.$parent['id']);?>" class="btn btn-default"  id="btnBack"> Kembali ke List </a>
		<button type="submit" action="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-warning pull-right"  id="btnSave"> Simpan </a>&nbsp;
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<div class="x_content">
				<div class="" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs " role="tablist">
						<li role="presentation" class="active"><a href="#tab_identifikasi" id="identifikasi" role="tab" data-toggle="tab" aria-expanded="true">Identifikasi Resiko</a></li>
						<li role="presentation" class=""><a href="#tab_level" role="tab" id="level" data-toggle="tab" aria-expanded="false">Level Resiko</a></li>
						<?php if ($mode=='edit'){ ?>
						<li role="presentation" class=""><a href="#tab_mitigasi" role="tab" id="mitigasi" data-toggle="tab" aria-expanded="false">Mitigasi</a></li>
						<?php }?>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active in" id="tab_identifikasi" aria-labelledby="home-tab">
							<?php
							foreach($identifikasi as $row){ ?>
							<div class="col-md-3 col-sm-3 col-xs-3"><?=$row['label']?></div>
							<div class="col-md-9 col-sm-9 col-xs-9"><div class="form-group"><?=$row['isi']?></div></div>
							<?php } ?>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tab_level" aria-labelledby="profile-tab">
							<?php
							foreach($level_resiko as $row){ ?>
							<div class="col-md-3 col-sm-3 col-xs-3"><?=$row['label']?></div>
							<div class="col-md-9 col-sm-9 col-xs-9"><div class="form-group"><?=$row['isi']?></div></div>
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
</div>
<?=form_close();?>