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
				<div class="col-12">
					<div class="x_content">
						<div class="row">
							<div class="col-12">
								<?php  echo form_open_multipart(base_url('propose'),array('id'=>'propose'));?>
								<section class="x_panel">
									<header class="x_title">
										Filter
										<span class="tools pull-right">
											<a class="fa fa-chevron-down" href="javascript:;"></a>
										</span>
									</header>
									
									<div class="x_content">

										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="height:34px; line-height:34px; font-weight:bold">Owner Name :</div>
										<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-bottom: 5px">
											<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select2" style=" width:100%;"');?>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="height:34px; line-height:34px; font-weight:bold">Period :</div>
										<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-bottom: 5px">
											<?php echo form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control" style=" width:auto;"');?>
										</div>

										<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2" style="height:34px; line-height:34px; font-weight:bold">Project Name :</div>
										<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10" style="margin-bottom: 5px">
											<?php echo form_dropdown('project_no',$cbo_project, $post['project_no'],'id="project_no" class="form-control" style="width:100%"');?>
										</div>

									</div>

								</section>
								<?php  echo form_close();?>
							</div>
						</div>
					<!--state overview start-->
					
						<div class="tbl-risk-register" style="overflow-x: auto;">
							<div class="well col-12" style="text-align:center">
								select data to load risk register
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>


<style>
	thead th, tfoot th {
	  font-size: 12px;
	  padding: 5px !important;
	  text-align: center;
	}
	.w150 { width: 150px;  } 
	.w100 { width: 100px;  } 
	.w80 { width: 80px;  } 
	.w50 { width: 50px;  } 
	td ol { padding-left: 10px; width: 300px;}
	td ol li { margin-left: 5px; }
</style>
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