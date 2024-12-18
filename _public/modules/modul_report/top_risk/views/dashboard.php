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
								<!-- 		<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span> -->
									</header>
									<div class="x_content">
										<table class="table borderless">
											<tr class="">
												<td width="15%">Risk Owner  :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select2" style=" width:100%;"');?></td>
												<td width="10%" class="text-center" rowspan="3"> 
													<!-- <button class="btn btn-round btn-flat btn-primary disabled" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button> -->
												</td>
											</tr>
											<tr>
												<td>Period : </td>
												<td><?php echo form_dropdown('period_no',$cbo_period, _TAHUN_NO_,' id="period_no" class=" form-control" style=" width:100%;"');?></td>
											</tr>
											</tr>
												<td>Bulan : </td>
												<td><?php echo form_dropdown('bulan',$cbo_bulan,  date('n'),' id="bulan" class=" form-control" style=" width:100%;"');?></td>
											</tr>
											<tr class="hide">
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
<span class="btn btn-warning btn-flat"><a href="#" style="color:#ffffff;" id="export_data"><i class="fa fa-file-pdf-o"></i> Export To PDF </a></span>
						<!--state overview start-->
						<div class="row" id="diagram">
<table class="table table-bordered table-sm"  id="golum" border="5" style="display: none;">

<thead>
<tr>
<td colspan="3" rowspan="3" style="text-align: left;border-right:none;" ><img src="<?=img_url('logo.png');?>" width="90"></td>
<td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle !important;"> TOP RISK</td>
<td colspan="4" style="text-align: left;">No.</td>
<td style="text-align: left;">: 009/RM-FORM/I/<span class="tahun2"></span></td>
</tr>
<tr>
<td colspan="4" style="text-align: left;">Revisi</td>
<td style="text-align: left;">: 1</td>
</tr>
<tr>
<td colspan="4" style="text-align: left;">Tanggal Revisi</td>
<td style="text-align: left;">: 31 Januari <span class="tahun2"></span></td>
</tr>
<tr>
<td colspan="2" style="text-align: left;border: none;">Risk Owner </td>
<td colspan="12" style="text-align: left;border: none;">: <span class="owner"></span></td>
</tr>
<tr>
<td colspan="2" style="text-align: left;border: none;">Bulan </td>
<td colspan="12" style="text-align: left;border: none;">: <span class="bulan2"></span></td>
</tr>
</thead>
</table>
						<div class="row">
							<aside class="profile-info col-md-12">
								<section class="x_panel">
									<div class="profile-info col-md-6">
										<!-- <strong>Inherent</strong> -->
										<div class="x_content text-center" id="mapping_inherent">
											<?=$mapping['inherent'];?>
										</div>
									</div>
									<div class="profile-info col-md-6">
										<!-- <strong>Residual</strong> -->
										<div class="x_content text-center" id="mapping_residual">
											<?=$mapping['residual'];?>
										</div>
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