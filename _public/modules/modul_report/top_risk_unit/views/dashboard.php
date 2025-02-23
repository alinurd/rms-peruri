<?php
$disabled = 'disabled';
if ($post['project_no'] > 0)
	$disabled = '';
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url(); ?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home'); ?></a></li>
					<li><a href="#"><?php echo lang('msg_title'); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="x_panel">
			<div class="row">
				<div class="col-md-12">
					<div class="x_content">
						<div class="row">
							<div class="col-md-12">
								<?php echo form_open_multipart(base_url('dashboard-operational'), array('id' => 'dashboard-operational')); ?>
								<section class="x_panel">
									<header class="x_title">
										Filter
										<!-- 		<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span> -->
									</header>
									<div class="x_content">
										<table class="table borderless">
											<tr class="">
												<td width="15%">Risk Owner :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no', $cbo_owner, $post['owner_no'], ' id="owner_no" class=" form-control select2" style=" width:100%;"'); ?></td>
												<td width="10%" class="text-center" rowspan="3">
													<!-- <button class="btn btn-round btn-flat btn-primary disabled" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search'); ?></button> -->
												</td>
											</tr>
											<tr>
												<td>Period : </td>
												<td><?php echo form_dropdown('period_no', $cbo_period, _TAHUN_NO_, ' id="period_no" class=" form-control" style=" width:100%;"'); ?></td>
											</tr>
											</tr>
											<td>Bulan : </td>
											<td><?php echo form_dropdown('bulan', $cbo_bulan,  date('n'), ' id="bulan" class=" form-control" style=" width:100%;"'); ?></td>
											</tr>
											<tr class="hide">
												<td>Operational Name :</td>
												<td colspan="2">
													<div class="input-group">
														<?php echo form_dropdown('project_no', $cbo_project, $post['project_no'], 'id="project_no" class="form-control " style="height:34px;width:100%;"'); ?> &nbsp;&nbsp;&nbsp;
														<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span>
													</div>
												</td>
											</tr>
										</table>
									</div>
								</section>
								<?php echo form_close(); ?>
							</div>
						</div>
						<aside class="">
							<section class=" ">
								<div class="  text-center" id="mapping_inherent">
									<?= $mapping['inherent']; ?>
								</div>
								<div style="margin-left: 235px; margin-top: 20px; margin-bottom: 20px; text-align: center; display: flex; justify-content: center; gap: 20px;">
										<div class="current">
											<button id="currentText" class="badge rounded-pill" style="border: solid 0px #000; background-color:#3d004f; font-size:16px; padding: 8px 12px; color: #fff;">Current Risk</button>
										</div>
										<div class="inherent">
											<button id="inherentText" class="badge rounded-pill" style="border: solid 0px #000; background-color:#97beac; font-size:16px; padding: 8px 12px; color: #fff;">Inherent Risk</button>
										</div>
										<div class="residual">
											<button id="residualText" class="badge rounded-pill" style="border: solid 0px #000; background-color:#00d3ac; font-size:16px; padding: 8px 12px; color: #fff;">Residual Risk</button>
										</div>
									</div>
								
							</section>
						</aside>
					</div>
				</div>
			</div>
		</div>
	</section>
</section><!-- /.right-side -->


<script>
	var type_dash = '<?= $type_dash; ?>';
	
</script>