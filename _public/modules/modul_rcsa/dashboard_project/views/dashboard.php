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
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?php echo lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
		<div class="x_panel">
			<div class="row">
				<div class="col-md-12">
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
								<?php  echo form_open_multipart(base_url('dashboard-project'),array('id'=>'dashboard-project'));?>
								<section class="x_panel">
									<header class="x_title">
										Filter
										<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span>
									</header>
									<div class="x_content progress-panel">
										<table class="table borderless">
											<tr>
												<td width="15%">Owner Name :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select3" style=" width:auto;"');?></td>
												<td width="10%" class="text-center" rowspan="3"> 
													<button class="btn btn-round btn-flat btn-primary <?=$disabled;?>" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button>
												</td>
											</tr>
											<tr>
												<td>Period : </td>
												<td><?php echo form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control" style=" width:auto;"');?></td>
											</tr>
											<tr>
												<td>Project Name :</td>
												<td colspan="2">
												<div class="input-group">
												<?php echo form_dropdown('project_no',$cbo_project,$post['project_no'],'id="project_no" class="form-control " style="height:34px;"');?> &nbsp;&nbsp;&nbsp;
												<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span>
												</div>
												</td>
											</tr>
										</table>
									</div>
								</section>
								<?php  echo form_close();?>
							</div>
						</div>
						
					<!--state overview start-->
						<div class="row">
							<aside class="profile-nav col-md-4" style="padding-right:0;">
								<section class="x_panel" style="background-color:#F2F2F2;" !important>
									<!--user info table start-->
									<section class="x_panel" style="background-color:#F2F2F2;" !important>
										<div class="x_content progress-panel">
											<div class="task-progress">
												<strong><?php echo lang('msg_field_owner') . get_help('msg_help_owner');?></strong>
											</div>
										</div>
										<div class="x_content">
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_name');?> </span>: <strong ><?php echo (count($setting['rcsa'])>0)?$setting['rcsa'][0]['name']:' ';?></strong></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_email');?> </span>: <strong><?php echo (count($setting['rcsa'])>0)? $setting['rcsa'][0]['email']:' ';?></strong></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_mobile');?> </span>: <strong><?php echo (count($setting['rcsa'])>0)? $setting['rcsa'][0]['mobile']:' ';?></strong></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_phone');?> </span>: <strong><?php echo (count($setting['rcsa'])>0)? $setting['rcsa'][0]['phone']:' ';?></strong></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_fax');?> </span>: <strong><?php echo (count($setting['rcsa'])>0)? $setting['rcsa'][0]['fax']:' ';?></strong></p>
											</div>
										</div>
									</section>
									<section class="x_panel" style="background-color:#F2F2F2;" !important>
										<div class="x_content progress-panel">
											<div class="task-progress">
											<strong><?php echo lang('msg_field_officer') . get_help('msg_help_officer');?></strong>
											</div>
										</div>
										<div class="x_content">
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_nama_project');?> </span>: <strong ><?php echo (count($setting['rcsa'])>0)?$setting['rcsa'][0]['corporate']:' ';?></strong></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_nilai_kontrak');?> </span>: <span class="pull-right"><strong><?php echo number_format((count($setting['rcsa'])>0)?$setting['rcsa'][0]['nilai_kontrak']:'0');?></strong></span></p>
											</div>

											<div class="bio-row">
												<p><span><?php echo lang('msg_field_target_laba');?> </span>: <span class="pull-right"><strong><?php echo number_format((count($setting['rcsa'])>0)?$setting['rcsa'][0]['target_laba']:'0');?></strong></span></p>
											</div>
											<div class="bio-row">
												<p><span><?php echo lang('msg_field_waktu');?> </span>: <strong><?php echo (count($setting['rcsa'])>0)?$setting['rcsa'][0]['start_date'] . ' s/d '.$setting['rcsa'][0]['end_date']:' ';?></strong></p>
											</div>
										</div>
									</section>
								</section>
							</aside>
							<aside class="profile-info col-md-8">
								<section class="x_panel">
									<div class="x_content progress-panel">
										<div class="task-progress">
											<h1><?php echo lang('msg_risk_map');?> <?php 
												if (count($setting['rcsa'])>0){
													$awal=date('F Y',strtotime($setting['rcsa'][0]['start_date']));
													$akhir=date('F Y',strtotime($setting['rcsa'][0]['end_date']));
													
													echo $setting['rcsa'][0]['periode_name'] . ' : ' . $awal . ' s.d ' . $akhir;
												}else{
													echo "no data";
												}
											?> </h1>
										</div>
									</div>
									<div class="x_content bio-graph-info text-center">
										<?=draw_map($setting,50, 'inherent');?>
									</div>
								</section>
								<section class="x_panel">
									<div class="x_content progress-panel">
										<div class="task-progress">
											<h1><?php echo lang('msg_risk_map');?> <?php 
												if (count($setting['rcsa'])>0){
													$awal=date('F Y',strtotime($setting['rcsa'][0]['start_date']));
													$akhir=date('F Y',strtotime($setting['rcsa'][0]['end_date']));
													
													echo $setting['rcsa'][0]['periode_name'] . ' : ' . $awal . ' s.d ' . $akhir;
												}else{
													echo "no data";
												}
											?> </h1>
										</div>
									</div>
									<div class="x_content bio-graph-info text-center">
										<?=draw_map($setting,50, 'residual');?>
									</div>
								</section>
							</aside>
						</div>
						<div class="overlay hide" id="overlay_content">
							<i class="fa fa-refresh fa-spin"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section><!-- /.right-side -->


<div class="modal fade bs-example-modal-sm" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> Select</button>
			  </div>
		  </div>
	  </div>
</div>


<script>
	var type_dash = '<?=$type_dash;?>';
</script>