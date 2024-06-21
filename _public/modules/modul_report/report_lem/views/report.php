<?php
	$sts_risk_owner='';
	$sts_lost_event='';
	$sts_amount='';
	$sts_cause='';
	$sts_date='';
	$sts_action_plan='';
	
	if (isset($field)){
		if (array_key_exists('sts_risk_owner',$field['param'])){
			if ($field['param']['sts_risk_owner']==1){$sts_risk_owner=' checked ';}
		}
		if (array_key_exists('sts_lost_event',$field['param'])){
			if ($field['param']['sts_lost_event']==1){$sts_lost_event=' checked ';}
		}
		if (array_key_exists('sts_amount',$field['param'])){
			if ($field['param']['sts_amount']==1){$sts_amount=' checked ';}
		}
		if (array_key_exists('sts_cause',$field['param'])){
			if ($field['param']['sts_cause']==1){$sts_cause=' checked ';}
		}
		if (array_key_exists('sts_date',$field['param'])){
			if ($field['param']['sts_date']==1){$sts_date=' checked ';}
		}
		if (array_key_exists('sts_action_plan',$field['param'])){
			if ($field['param']['sts_action_plan']==1){$sts_action_plan=' checked ';}
		}
	}
	$ketsave="Save";
	if($id_report>0){
		$ketsave="Update";
	}
	
	$info="";
	$sts_input="";
	$info_error="";
	if (validation_errors()){
		$info_error= validation_errors();
		$sts_input='danger';
	}elseif ($this->session->userdata('result_proses')){
		$info = $this->session->userdata('result_proses');
		$this->session->set_userdata(array('result_proses'=>''));
		$sts_input="success";
	}elseif ($this->session->userdata('result_proses_error')){
		$info =  $this->session->userdata('result_proses_error');
		$this->session->set_userdata(array('result_proses_error'=>''));
		$sts_input="err";
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
	<section class="wrapper site-min-height">
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url();?>"> <i class="fa fa-home"></i> <?php echo lang('msg_breadcrumb_home');?></a></li>
					<li><a><?php echo lang('msg_title');?></a></li>
				</ul>
			</div>
		</div>
	<!--state overview start-->
		<div class="row">
			<aside class="profile-nav col-md-5" style="padding-right:0;">
				<section class="panel">
					<!--user info table start-->
					 <?php  
						echo form_open_multipart(base_url('report-lem/save_data'),array('id'=>'form_input'));
						?>
						<input type="hidden" name="id" value="<?php echo (isset($field)) ? $field['id']:"";?>">
					<section class="panel">
						<div class="panel-body progress-panel">
							<div class="task-progress">
								<h1><strong><?php echo lang('msg_field_title_param');?></strong></h1>
							</div>
							<?php if($id_report>0){ ?>}
							<span class="pull-right">
								<a href="<?php echo base_url('report-risk-monitoring');?>"><?php echo lang('msg_field_new_template');?></a>
							</span>
							<?php } ?>
						</div>
						<div class="panel-body" style="padding-left:8px !important;">
							<div class="bio-row">
								<table class="table">
									<tbody>
										<tr>
											<td class="no-border" style="width:35%;vertical-align:middle;"><sup>
												<span class="required"> *) </span>
												</sup> <?php echo lang('msg_field_template_name');?>
											</td>
											<td class="no-border">
												<input name="template_name" id="template_name" type="text" placeholder="Template Name" class="form-control p100" style="height:34px;width:100% !important;border:1px solid #e2e2e4" value="<?php echo (isset($field)) ? $field['template_name']:"";?>">
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<table class="table personal-task">
								<tbody>
									<tr>
										<th><?php echo lang('msg_field_information');?></th>
										<th style="width:60%;">#</th>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_risk_owner" value="0">
													<input type="checkbox" name="sts_risk_owner" value="1" <?php echo $sts_risk_owner;?>>&nbsp; <?php echo lang('msg_field_risk_owner');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_lost_event" value="0">
													<input type="checkbox" name="sts_lost_event" value="1" <?php echo $sts_lost_event;?>>&nbsp; <?php echo lang('msg_field_description');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_amount" value="0">
													<input type="checkbox" name="sts_amount" value="1" <?php echo $sts_amount;?>>&nbsp; <?php echo lang('msg_field_amount');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_cause" value="0">
													<input type="checkbox" name="sts_cause" value="1" <?php echo $sts_cause;?>>&nbsp; <?php echo lang('msg_field_couse');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_date" value="0">
													<input type="checkbox" name="sts_date" value="1" <?php echo $sts_date;?>>&nbsp; <?php echo lang('msg_field_date');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="no-padding" >
											<div class="checkbox">
												<label>
													<input type="hidden" name="sts_action_plan" value="0">
													<input type="checkbox" name="sts_action_plan" value="1" <?php echo $sts_action_plan;?>>&nbsp; <?php echo lang('msg_field_action_plan');?>
												</label>
											</div>
										</td>
										<td style="width:60%;">
											&nbsp;
										</td>
									</tr>
								</tbody>
							</table>
							<hr/>
							<table class="table">
								<tbody>
									<tr>
										<td class="no-border" style="width:30%;vertical-align:middle;"><sup>
										<span class="required"> *) </span> </sup><?php echo lang('msg_field_report_title');?></td>
										<td class="no-border">
											<input name="title" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['title']:"";?>">
										</td>
									</tr>
									<tr>
										<td class="no-border" style="vertical-align:middle;"><sup> <span class="required"> *) </span> </sup><?php echo lang('msg_field_sub_title');?></td>
										<td class="no-border">
											<input name="subtitle" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['subtitle']:"";?>">
										</td>
									</tr>
									<tr>
										<td class="no-border" style="vertical-align:middle;"><sup> <span class="required"> *) </span> </sup><?php echo lang('msg_field_person_name');?></td>
										<td class="no-border">
											<input name="person_name" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['person_name']:"";?>">
										</td>
									</tr>
									<tr>
										<td class="no-border" style="vertical-align:middle;"><sup><span class="required"> *) </span> </sup><?php echo lang('msg_field_position');?></td>
										<td class="no-border">
											<input name="position" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['position']:"";?>">
										</td>
									</tr>
									<tr>
										<td class="no-border" style="vertical-align:middle;"><span class="required"> *) </span> <?php echo lang('msg_field_file_name');?></td>
										<td class="no-border">
											 <div class="input-group">
												  <input name="file_name" type="text" placeholder="File Name" class="form-control p100" style="height:34px;border:1px solid #e2e2e4" value="<?php echo (isset($field)) ? $field['param']['file_name']:"";?>">
												  <span class="input-group-btn">
													<button class="btn btn-primary" type="submit" id="btn_owner" title="browse"><?php echo $ketsave;?></button>
												  </span>
											  </div>
										</td>
									</tr>
								</tbody>
							</table>
							 <div id="loading" class="loading-img hide"></div>
						</div>
					</section>
					<?php echo form_close();?>
				</section>
			</aside>
			<aside class="profile-info col-md-7">
				<section class="panel">
					<div class="panel-body progress-panel">
						<div class="task-progress">
							<h1><?php echo lang('msg_field_title_template');?></h1>
						</div>
					</div>
					<div class="panel-body text-center">
						<table class="table" id="datatable">
						<thead>
							<tr>
							<th width="8%" style="text-align:center;">No.</th>
							<th><?php echo lang('msg_field_template_name');?></th>
							<th width="20%" ><?php echo lang('msg_field_create_by');?></th>
							<th width="14%"><?php echo lang('msg_aksi');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($data_report as $row){ 
								?>
								<tr>
									<td style="text-align:center;width:10%;"><?php echo $i;?></td>
									<td class="text-left"> <?php echo $row['template_name'];?></td>
									<td> <?php echo $row['create_user'];?></td>
									<td style="text-align:center;width:15%;cursor:pointer;">
										<?php if ($row['id'] != $id_report){ ?>
										<a  href="<?php echo base_url("report-lem/edit-report/".$row['id']);?>"><i class="fa fa-edit" title="Print Template"></i></a> | <a  href="<?php echo base_url("report-lem/print-report/".$row['id']);?>" target="_blank"> <i class="fa fa-print" title="Cetak Template"></i></a> | <i class="fa fa-times" id="del_action" title="Delete data Action" onclick="remove_install(this,<?php echo $row['id'];?>)"></i>
										<?php }else { ?> 
											<a  href="<?php echo base_url("report-lem/print-report/".$row['id']);?>"  target="_blank"> <i class="fa fa-print" title="Cetak Template"></i></a>
										<?php } ?>
									</td>
								</tr>
								<?php 
							}
							?>
						</tbody>
					</table>
					</div>
				</section>
			</aside>
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
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	$("#btn_owner").click(function(){
		$("#loading").removeClass('hide');
		var nil = 'owner'; 
		get_data(nil);
	});
	
	$("#btn_period").click(function(){
		$("#loading").removeClass('hide');
		var nil = 'period'; 
		get_data(nil);
	});
	
	$("#btn_level").click(function(){
		$("#loading").removeClass('hide');
		var nil = 'level'; 
		get_data(nil);
	});
	
	$("#btn_type").click(function(){
		$("#loading").removeClass('hide');
		var nil = 'type'; 
		get_data(nil);
	});
	
	function get_data(nil, tblx, count){
		var url='<?php echo base_url("report_lem/get_param");?>';
		var form = {'idmodal':nil};
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#report_modal').find('.modal-content').html(msg);
				$("#loading").addClass('hide');
				$('#report_modal').modal('show');
				
			},
			failed: function(msg){
				$("#loading").addClass('hide');
				alert("gagal");
			},
		});
	}
	
	function add_install_owner(id, nama) {
		$("#owner_name").val(nama);
		$("#owner_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	function add_install_period(id, nama) {
		$("#period_name").val(nama);
		$("#period_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	function add_install_level(id, nama) {
		$("#level_name").val(nama);
		$("#level_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	function add_install_type(id, nama) {
		$("#type_name").val(nama);
		$("#type_no").val(id);
		$('#datatables >tbody').html("");
		$('#report_modal').modal('hide');
	};
	
	$("#level_name").change(function(){
		if ($(this).val().length==0)
			$("#level_no").val("");
	});
	
	$("#type_name").change(function(){
		if ($(this).val().length==0)
			$("#type_no").val("");
	});
	
	function remove_install(t,iddel){
			if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			
				var nil=iddel;
				var url='<?php echo base_url("report-lem/delete_report");?>';
				
				var form={'id':nil};
				$("#loading").removeClass('hide');
				$.ajax({
					type: "GET",
					url: url,
					data:form,
					success: function(msg){
						$("#loading").addClass('hide');						
						var ri = t.parentNode.parentNode.rowIndex-1;
						t.parentNode.parentNode.parentNode.deleteRow(ri);
						var err=msg;
						var sts="success";
						pesan_toastr(err,sts);
					},
					failed: function(msg){
						$("#loading").addClass('hide');
						alert("gagal");
					},
				});
			}
			return false;
		}
		
</script>