<?php
	$disabled = 'disabled';
	if ($post['project_no']>0)
		$disabled = '';
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li> <a href="<?=base_url();?>"> <i class="fa fa-home"></i> <?=lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?=lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
		<div class="x_panel">
			<div class="x_title">
				<strong>Filter</strong>
				<ul class="nav navbar-right panel_toolbox">
					<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content ">
				<table class="table borderless">
					<tr>
						<td width="15%">Owner Name :</td>
						<td colspan="2">
							<?=form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select2" style=" width:100%;"');?></td>
						<td width="10%" class="text-center" rowspan="3"> 
							<button class="btn btn-flat btn-primary <?=$disabled;?>" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?=lang('msg_tbl_search');?></button>
						</td>
					</tr>
					<tr>
						<td>Period : </td>
						<td><?=form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control select2" style=" width:100%;"');?></td>
					</tr>
					<tr>
						<td>Project Name :</td>
						<td colspan="2">
						<div class="input-group">
						<?=form_dropdown('project_no',$cbo_project,$post['project_no'],'id="project_no" class="form-control select2 " style="height:34px;width:100%;"');?> &nbsp;&nbsp;&nbsp;
						<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span>
						</div>
						</td>
					</tr>
				</table>
				<?php  echo form_close();?>
			</div>
		</div>
		<div class="x_panel">
			<div class="x_title">
				<strong>Dashboard Hiradc</strong>
				<ul class="nav navbar-right panel_toolbox">
					<li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
			<!--state overview start-->
				<div class="row">
					<aside class="profile-nav col-md-4" style="padding-right:0;">
						<section class="x_panel">
							<!--user info table start-->
							<section class="x_panel">
								<div class="x_content progress-panel">
									<div class="task-progress">
										<strong><?=lang('msg_field_owner') . get_help('msg_help_owner');?></strong>
									</div>
								</div>
								<div class="x_content">
									<div class="bio-row">
										<p><span><?=lang('msg_field_name');?> </span>: <strong ><?=(count($setting['rcsa'])>0)?$setting['rcsa'][0]['name']:' ';?></strong></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_email');?> </span>: <strong><?=(count($setting['rcsa'])>0)? $setting['rcsa'][0]['email']:' ';?></strong></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_mobile');?> </span>: <strong><?=(count($setting['rcsa'])>0)? $setting['rcsa'][0]['mobile']:' ';?></strong></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_phone');?> </span>: <strong><?=(count($setting['rcsa'])>0)? $setting['rcsa'][0]['phone']:' ';?></strong></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_fax');?> </span>: <strong><?=(count($setting['rcsa'])>0)? $setting['rcsa'][0]['fax']:' ';?></strong></p>
									</div>
								</div>
							</section>
							<section class="x_panel">
								<div class="x_content progress-panel">
									<div class="task-progress">
									<strong><?=lang('msg_field_officer') . get_help('msg_help_officer');?></strong>
									</div>
								</div>
								<div class="x_content">
									<div class="bio-row">
										<p><span><?=lang('msg_field_nama_project');?> </span>: <strong ><?=(count($setting['rcsa'])>0)?$setting['rcsa'][0]['corporate']:' ';?></strong></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_nilai_kontrak');?> </span>: <span class="pull-right"><strong><?=number_format((count($setting['rcsa'])>0)?$setting['rcsa'][0]['nilai_kontrak']:'0');?></strong></span></p>
									</div>

									<div class="bio-row">
										<p><span><?=lang('msg_field_target_laba');?> </span>: <span class="pull-right"><strong><?=number_format((count($setting['rcsa'])>0)?$setting['rcsa'][0]['target_laba']:'0');?></strong></span></p>
									</div>
									<div class="bio-row">
										<p><span><?=lang('msg_field_waktu');?> </span>: <strong><?=(count($setting['rcsa'])>0)?$setting['rcsa'][0]['start_date'] . ' s/d '.$setting['rcsa'][0]['end_date']:' ';?></strong></p>
									</div>
								</div>
							</section>
						</section>
					</aside>
					<aside class="profile-info col-md-8">
						<section class="x_panel">
							<div class="x_content progress-panel">
								<div class="task-progress">
									<h1><?=lang('msg_risk_map');?></h1>
								</div>
							</div>
							<div class="x_content bio-graph-info text-center">
								<?=$mapping;?>
							</div>
						</section>
						<section class="x_panel">
							<div class="x_content progress-panel">
								<div class="task-progress">
									<h1><?=lang('msg_risk_map');?></h1>
								</div>
							</div>
							<div class="x_content bio-graph-info text-center">
								<?=$mapping;?>
							</div>
						</section>
					</aside>
				</div>
				<div class="overlay hide" id="overlay_content">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
			</div>
		</div>
	</section>
</section><!-- /.right-side -->
<script>
	var type_dash = '<?=$type_dash;?>';
</script>