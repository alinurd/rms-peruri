<?php
	$info="";
	$sts_input="";
	$info_error="";
	if (validation_errors()){
		$info_error= validation_errors();
		$sts_input='danger';
	}elseif ($this->session->userdata('result_proses_error')){
		$info_error =  $this->session->userdata('result_proses_error');
		$this->session->set_userdata(array('result_proses_error'=>''));
		$sts_input='danger';
	}
	
	if ($this->session->userdata('result_proses')){
		$info = $this->session->userdata('result_proses');
		$this->session->set_userdata(array('result_proses'=>''));
		$sts_input='info';
	}
	
	$data=$setting['rcsa'][0];
	if (!array_key_exists('sts_propose',$data)){
		$data['sts_propose']=-1;
		$data['id']=0;
	}
	
	$owner_no='';
	$nilai_kontrak=0;
	$target_laba=0;
	if (count($setting['rcsa'])>0){
		$owner_no=$setting['rcsa'][0]['owner_no'];
		$period_no=$setting['rcsa'][0]['period_no'];
		$nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
		$target_laba=$setting['rcsa'][0]['target_laba'];
	}
?>
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>

<section id="main-content">
	<?php  echo form_open_multipart(base_url('approve/save_notes'),array('id'=>'form_input'));?>
	<section class="wrapper site-min-height">
	<div class="panel">
		<div class="row">
			<div class="col-sm-8 panel-heading">
				<h3 style="padding-left:10px;"><?php echo strtoupper(lang("msg_title"));?></h3>
			</div>
			<div class="col-sm-4" style="text-align:left; float: right;">
				<ol class="breadcrumb" style="text-align:right;">
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a href="#"><?php echo lang('msg_title');?></a></li>
				</ol>
			</div>
		</div>
	<!--state overview start-->
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary btn-flat center" type="submit"><strong>A P P R O V E</strong></button>
				<a class="danger btn btn-default btn-flat" data-content="Kembali Ke Daftar" data-toggle="popover" href="<?php echo base_url('approve');?>" data-original-title="" title="">
				<i class="fa fa-sign-out"></i>
				<?php echo lang("msg_tombol_back_to_list");?>
				</a>
			</div>
		</div>
		</div>
			
		<div class="row">
			<div class="col-md-12">
				 <section class="panel">
				 <div class="panel-body progress-panel">
					<div class="task-progress">
						<h1><?php echo $judul ;?></h1>
					</div>
				</div>
				</section>
			</div>
		</div>
		<div class="row">
			<aside class="profile-nav col-md-3" style="padding-right:0;">
					<!--user info table start-->
					<section class="panel well">
						<div class="panel-body progress-panel">
							<div class="task-progress">
								<strong><?php echo lang('msg_field_left_title');?></strong>
							</div>
						</div>
						<div class="panel-body">
							<table class="table no-margin no-padding borderess">
							<tr><th colspan="3"><?php echo lang('msg_field_current').get_help('msg_help_current');?></th></tr>
							<?php
								$total=0;
								if (array_key_exists('residual', $setting['rekap'])){
									?>
									<tr><td class="no-border" colspan="3">Residual</td></tr>
									<?php
									foreach($setting['rekap']['residual'] as $row){
										$total += intval($row['jml']);
									?>
										
										<tr><td class="no-border"><?php echo $row['title'];?></td><td class="no-border">:</td><td class="no-border text-right"><?php echo $row['jml'];?> <?php echo lang('msg_risk_item');?> </td></tr>
									<?php
									}
								?>
								<tr><td class="no-border"><strong><?php echo lang('msg_risk_total');?></strong></td><td class="no-border">:</td><td class="no-border text-right"><?php echo $total;?> <?php echo lang('msg_risk_item');?></td></tr>
								<?php
								}
								
								$total=0;
								if (array_key_exists('inherent', $setting['rekap'])){
									?>
									<tr><td class="no-border" colspan="3">Inherent</td></tr>
									<?php
									foreach($setting['rekap']['inherent'] as $row){
										$total += intval($row['jml']);
									?>
										
										<tr><td class="no-border"><?php echo $row['title'];?></td><td class="no-border">:</td><td class="no-border text-right"><?php echo $row['jml'];?> <?php echo lang('msg_risk_item');?> </td></tr>
									<?php
									}
								}
							?>
							<tr><td class="no-border"><strong><?php echo lang('msg_risk_total');?></strong></td><td class="no-border">:</td><td class="no-border text-right"><?php echo $total;?> <?php echo lang('msg_risk_item');?></td></tr>
							</table>
							<br/>
							<table class="table no-margin no-padding">
								<tr><th colspan="3"><?php echo lang('msg_field_change').get_help('msg_help_change');?></th></tr>
								<tr><td class="no-border"><?php echo lang('msg_field_new_risk');?></td><td class="no-border">:</td><td class="no-border"><?php echo $total;?> <?php echo lang('msg_risk_item');?></td></tr>
								<tr><td class="no-border"><?php echo lang('msg_field_changed_risk');?></td><td class="no-border">:</td><td class="no-border"><?php echo $total;?> <?php echo lang('msg_risk_item');?></td></tr>
							</table>
							<br/>
							<table class="table no-margin no-padding">
								<tr><th colspan="3"><?php echo lang('msg_field_information').get_help('msg_help_information');?></th></tr>
								<tr><td class="no-border"><?php echo lang('msg_field_nilai_kontrak');?></td><td class="no-border">:</td><td class="no-border"><?php echo number_format($nilai_kontrak);?></td></tr>
								<tr><td class="no-border"><?php echo lang('msg_field_target_laba');?></td><td class="no-border">:</td><td class="no-border"><?php echo number_format($target_laba);?></td></tr>
							</table>
							<table class="table no-margin no-padding">
								<tr><th colspan="3"><?php echo lang('msg_field_rating_likelihood');?></th></tr>
								<?php
								$no=0;
								foreach ($cbo_likelihood as $row){
									if ($no>0){
									?>
									<tr><td class="no-border"><?=$no;?></td><td class="no-border"><?=$row;?>%</td></tr>
									<?php
									}
									++$no;
								}
								?>
							</table>
							<table class="table no-margin no-padding">
								<tr><th colspan="3"><?php echo lang('msg_field_rating_impact');?></th></tr>
								<?php
								$no=0;
								foreach ($cbo_impact as $row){
									if ($no>0){
									?>
									<tr><td class="no-border"><?=$no;?></td><td class="no-border"><?=$row;?>%</td></tr>
									<?php
									}
									++$no;
								}
								?>
							</table>
						</div>
					</section>
			</aside>
			<aside class="profile-info col-md-9">
				<section class="panel">
					<div class="row">
						<div class="col-md-6">
							<div class="panel-body progress-panel">
								<div class="task-progress">
									<h1><?php echo lang('msg_field_current_period').get_help('msg_help_current_period');?><br/> <?php 
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
							<div class="panel-body bio-graph-info text-center">
								<?=draw_map($setting, 199, 'residual');?>
								<div id="loading" class="loading-img hide"></div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="panel-body progress-panel">
								<div class="task-progress">
									<h1><?php echo lang('msg_field_previous_period').get_help('msg_help_previous_period');?></h1>
								</div>
							</div>
							<div class="panel-body bio-graph-info text-center">
								<?=draw_map($setting, 199, 'inherent');?>
							</div>
						</div>
					</div>
					<hr>
					<?php 
					if (intval($data['sts_propose'])==1)
					{ ?>
					<div class="row">
						<div class="col-md-12">
							<div class="panel-body">
								<?php echo lang('msg_field_risk_note').get_help('msg_help_risk_note');?>
								<?php 
								echo form_hidden('rcsa_no',$data['id']);
								
								echo form_textarea('notes',''," maxlength='1000' size=1000 class='form-control w100' rows='2' cols='5' style='overflow: hidden; height: 104px;' ");
														
								?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button class="btn btn-default btn-flat center" type="submit" value="2" name="stsApp"><strong>Not APPROVE</strong></button> &nbsp;&nbsp;
							<button class="btn btn-primary btn-flat center" type="submit" value="1" name="stsApp"><strong>A P P R O V E</strong></button>
						</div>
					</div>
					<?php } ;?>
					<hr>
				</section>
			</aside>
		</div>
		</div>
	</section>
	<?php echo form_close();?>
</section><!-- /.right-side -->

<div class="modal fade bs-example-modal-sm" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	$("#owner_no, #period_no").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period);
		$("#btn-disabled").removeClass('disabled').addClass('disabled');
		cari_ajax_combo(id, 'spinner_param', 'project_no', 'ajax/get_project_name');
	});
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0)
			$("#btn-search").removeClass('disabled');
		else
			$("#btn-search").addClass('disabled');
	});

</script>