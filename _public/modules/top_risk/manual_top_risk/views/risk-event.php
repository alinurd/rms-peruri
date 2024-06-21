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
		<section class="x_panel">
			<div class="x_title">
				<strong>Assesment : <?=strtoupper($parent['corporate']);?></strong>
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
  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/add/'.$parent['id']);?>" class="btn btn-primary <?=$hide_edit;?>"> <?=lang('msg_tombol_add');?> </a>&nbsp;&nbsp;
		<button class="btn btn-success" data-id="<?=$parent['id'];?>" id="cmdRisk_Register"> <?=lang('msg_field_risk_register');?> </button>
		
		<h3><?=lang('msg_sub_title');?></h3>
		<h5 class="text-warning"><strong><?=$parent['corporate'];?></strong></h5>	
	</div>
	<aside class="col-md-12 col-sm-12 col-xs-12">
		<section class="x_panel">
			<div class="x_content">
				<div class="table-responsive">
					<table class="display table table-bordered table-striped table-hover" id="tbl_event">
						<thead>
							<tr>
								<th width="5%">No.</th>
								<th><?=lang('msg_field_risk_area');?></th>
								<th><?=lang('msg_field_risk_event');?></th>
								<th width="15%"><?=lang('msg_field_inherent_risk');?></th>
								<th width="15%"><?=lang('msg_field_risk_control_assessment');?></th>
								<th width="10%"><?=lang('msg_field_jml_mitigasi');?></th>
								<th><?=lang('msg_tombol_aksi');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no=0;
							foreach($field as $key=>$row){
								$del='';
								if (intval($row['jml_mitigasi'])==0){
									$del = ' | <i class="fa fa-trash pointer text-danger del-event '.$hide_edit.'" data-id="'.$row['id'].'"></i>';
								}
								?>
								<tr>
									<td><?=++$no;?></td>
									<td><?=$row['area_name'];?></td>
									<td><?=$row['event_name'];?></td>
									<td class="text-center"><span style="background-color:<?=$row['warna'];?>;color:<?=$row['warna_text'];?>;padding:4px 8px;width:100%;"><?=$row['inherent_analisis'];?></span></td>
									<td><?=$row['risk_control'];?></td>
									<td class="text-center"><?=$row['jml_mitigasi'];?></td>
									<td class="text-center">
										<a href="<?=base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/edit/'.$parent['id'].'/'.$row['id']);?>"> <i class="fa fa-pencil"></i> </a><?=$del;?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</aside>
</div>

<script>
	$(function() {
		loadTable('', 0, 'tbl_event');
		$("#tbl_event").css('margin-right','5px');
	})
</script>