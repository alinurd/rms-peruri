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
						<td width="20%">Period : </td>
						<td><?=form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control select2" style=" width:100%;"');?></td>
						<td width="10%" class="text-center" rowspan="3"> 
							<button class="btn btn-flat btn-primary <?=$disabled;?>" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?=lang('msg_tbl_search');?></button>
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
					<aside class="profile-info col-md-12">
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