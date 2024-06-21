<?php
	$data=array();
	if (!array_key_exists('sts_propose',$data)){
		$data['sts_propose']=-1;
		$data['id']=0;
	}
	
	$disabled = 'disabled';
	if ($post['project_no']>0)
		$disabled = '';
	
	$nilai_kontrak=0;
	$target_laba=0;
	if (!$post){
		if (count($setting['rcsa'])>0){
			$nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
			$target_laba=$setting['rcsa'][0]['target_laba'];
		}
	}else{
		if (count($setting['rcsa'])>0){
			$nilai_kontrak=$setting['rcsa'][0]['nilai_kontrak'];
			$target_laba=$setting['rcsa'][0]['target_laba'];
		}
	}
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
								<?=form_open_multipart(base_url(_MODULE_NAME_),array('id'=>'propose'));?>
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
												<td width="20%">Owner Name :</td>
												<td colspan="2">
													<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select2" style=" width:100%;"');?></td>
												<td width="10%" class="text-center" rowspan="3"> 
													<button class="btn btn-flat btn-primary" name="search" value="Simpan" type="button" id="btn-search" data-original-title=" Cari Data Register " title="" style="min-height:60px;width:100%;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button>
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
												<?php echo form_dropdown('project_no',$cbo_project, $post['project_no'],'id="project_no" class="form-control " style="height:34px;"');?> &nbsp;&nbsp;&nbsp;
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
							<aside class="profile-nav col-md-12" style="padding-right:0;">
								<section class="x_panel">
									<div class="x_content">
										<div class="task-progress">
											<strong><?php echo lang('msg_field_left_title');?></strong>
										</div>
									</div>
									<div class="x_content" id="hiradc_register">
									isi Register
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

<div class="modal fade" id="confirm_propose" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_btn_send_propose');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo form_input('email','','class="forn-control p100" placeholder="email address" id="email_address"');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_batal');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm_send" data-dismiss="modal"><?php echo lang('msg_btn_send');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" id="id_tambah_data_target" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<div class="modal fade bs-example-modal-sm" id="report_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:80%;margin:20px auto;">
		<div class="modal-content">
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_tbl_close');?></button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	var type_dash = '<?=$type_dash;?>';
	var rsca_tmp='<?php echo $data['id'];?>';
	var sts_tmp='<?php echo $data['sts_propose'];?>';
</script>