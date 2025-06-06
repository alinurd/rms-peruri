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
								<?php  echo form_open_multipart(base_url('dashboard-operational'),array('id'=>'dashboard-operational'));?>
								<section class="x_panel">
									<header class="x_title">
										Filter
										<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span>
									</header>
									<div class="x_content">
										<table class="table borderless">
											<tr>
												<td width="15%">Owner Name :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select2" style=" width:100%;"');?></td>
												<td width="10%" class="text-center" rowspan="3"> 
													<button class="btn btn-round btn-flat btn-primary disabled" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button>
												</td>
											</tr>
											<tr>
												<td>Period : </td>
												<td><?php echo form_dropdown('period_no',$cbo_period,$post['period_no'],' id="period_no" class=" form-control" style=" width:100%;"');?></td>
											</tr>
											<tr>
												<td>Operational Name :</td>
												<td colspan="2">
												<div class="input-group">
												<?php echo form_dropdown('project_no',$cbo_project,$post['project_no'],'id="project_no" class="form-control " style="height:34px;width:100%;"');?> &nbsp;&nbsp;&nbsp;
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
							<aside class="profile-info col-md-12">
								<section class="x_panel">
									<div class="x_content">
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
									<div class="x_content text-center">
										<?=draw_map($setting,70, 'inherent');?>
									</div>
									<br/>
									<hr>
									<div class="x_content text-center" id="detail_map"></div>
									
								</section>
								
								<section class="x_panel hide">
									<div class="x_content">
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
									<div class="x_content">
										<?=draw_map($setting, 70, 'residual');?>
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


<script>
	var type_dash = '<?=$type_dash;?>';
</script>