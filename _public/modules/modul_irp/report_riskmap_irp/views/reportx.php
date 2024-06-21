<?php
	$title=array('','');
	$subtitle=array('','');
	$date=array('','','');
	$sign=array('','','');
	
	if (isset($field)){
		if (array_key_exists('title_sts',$field['param'])){
			if ($field['param']['title_sts']=="default"){
				$title[0]=' checked ';
			}elseif ($field['param']['title_sts']=="custom"){
				$title[1]=' checked ';
			}
		}
		
		if (array_key_exists('subtitle_sts',$field['param'])){
			if ($field['param']['subtitle_sts']=="default"){
				$subtitle[0]=' checked ';
			}elseif ($field['param']['subtitle_sts']=="custom"){
				$subtitle[1]=' checked ';
			}
		}
		
		if (array_key_exists('date_sts',$field['param'])){
			if ($field['param']['date_sts']=="default"){
				$date[0]=' checked ';
			}elseif ($field['param']['date_sts']=="custom"){
				$date[1]=' checked ';
			}elseif ($field['param']['date_sts']=="none"){
				$date[2]=' checked ';
			}
		}
		
		if (array_key_exists('sign_sts',$field['param'])){
			if ($field['param']['sign_sts']=="default"){
				$sign[0]=' checked ';
			}elseif ($field['param']['sign_sts']=="custom"){
				$sign[1]=' checked ';
			}elseif ($field['param']['sign_sts']=="none"){
				$sign[2]=' checked ';
			}
		}
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
						echo form_open_multipart(base_url('report-risk-map/save_data'),array('id'=>'form_input'));
						?>
						<input type="hidden" name="id" value="<?php echo (isset($field)) ? $field['id']:"";?>">
					<section class="panel">
						<div class="panel-body progress-panel">
							<div class="task-progress">
								<h1><strong><?php echo lang('msg_field_title_param');?></strong></h1>
							</div>
							<?php if($id_report>0){ ?>}
							<span class="pull-right">
								<a href="<?php echo base_url('report-risk-map');?>"><?php echo lang('msg_field_new_template');?></a>
							</span>
							<?php } ?>
						</div>
						<div class="panel-body">
							<div class="bio-row">
								<table class="table">
									<tbody>
										<tr>
											<td class="no-border" style="width:30%;vertical-align:middle;"><?php echo lang('msg_field_template_name');?></td>
											<td class="no-border">
													  <input name="template_name" id="template_name" type="text" placeholder="Template Name" class="form-control p100" style="height:34px;width:100% !important;border:1px solid #e2e2e4" value="<?php echo (isset($field)) ? $field['template_name']:"";?>">
											</td>
										</tr>
									</tbody>
								</table>
								<hr/>
								<table class="table">
									<tbody>
										<tr>
											<td class="no-border" style="vertical-align:middle;"><?php echo lang('msg_field_rcsa_type');?> :</td>
										</tr>
										<tr>
											<td class="no-border">
												 <div class="input-group">
													<?php echo form_dropdown('rcsa_type', array('1'=>'Operational','2'=>'Project'), '','class="form-control" id ="rcsa_type" ');?>
												  </div>
											</td>
										</tr>
										<tr>
											<td class="no-border" style="vertical-align:middle;"><?php echo lang('msg_field_view_data');?> :</td>
										</tr>
										<tr>
											<td class="no-border">
												 <div class="input-group">
													<?php echo form_dropdown('view_data', array('1'=>'Project/Assessmen Only','2'=>'Risk Owner Only', '0'=>'All Data'), '','class="form-control" id="view_data"');?>
												  </div>
											</td>
										</tr>
										<tr>
											<td class="no-border" style="vertical-align:middle;"><?php echo lang('msg_field_unit');?> :</td>
										</tr>
										<tr>
											<td class="no-border">
												 <div class="input-group">
													<?php echo form_dropdown('owner_no',$cbo_owner,(isset($field)) ? $field['param']['owner_no']:"",' class="form-control select-report" style="height: 34px; max-width: 150px;" id="owner_no"');?>
												  </div>
											</td>
										</tr>
										<tr>
											<td class="no-border" style="vertical-align:middle;"><?php echo lang('msg_field_period');?> :</td>
										</tr>
										<tr>
											<td class="no-border">
												 <div class="input-group">
													<?php echo form_dropdown('period_no', $cbo_period, (isset($field)) ? $field['param']['period_no']:"",'class="form-control" id="period_no"');?>
												  </div>
											</td>
										</tr>
										<tr>
											<td class="no-border" style="vertical-align:middle;"><?php echo lang('msg_field_project_name');?> :</td>
										</tr>
										<tr>
											<td class="no-border">
												 <div class="input-group project_name">
													<?php echo form_dropdown('project_no',$cbo_project,'','id="project_no" class="form-control" style="height: 34px; max-width: 350px;"');?>
													<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span>
												  </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<table class="table personal-task">
								<tbody>
									<tr>
										<td rowspan="2" style="width:15%;"><?php echo lang('msg_field_report_title');?></td>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="title_sts" value="default" <?php echo $title[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
										<td style="width:60%;"><input name="title_default" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['title_default']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="title_sts" value="custom" <?php echo $title[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
										<td style="width:60%;">
											<input name="title_custom" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['title_custom']:"";?>"></td>
									</tr>
									<tr>
										<td rowspan="2"><?php echo lang('msg_field_sub_title');?></td>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="subtitle_sts" value="default" <?php echo $subtitle[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
										<td style="width:60%;"><input name="subtitle_default" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['subtitle_default']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="subtitle_sts" value="custom" <?php echo $subtitle[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
										<td style="width:60%;"><input name="subtitle_custom" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['subtitle_custom']:"";?>"></td>
									</tr>
									<tr>
										<td rowspan="3"><?php echo lang('msg_field_date');?></td>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="default" <?php echo $date[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
										<td style="width:60%;"><input name="date_default" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['date_default']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="custom" <?php echo $date[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
										<td style="width:60%;"><input name="date_custom" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['date_custom']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="none" <?php echo $date[2];?>> None</label></div></td>
										<td style="width:60%;">&nbsp;</td>
									</tr>
									<tr>
										<td rowspan="3"><?php echo lang('msg_field_sign');?></td>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="default" <?php echo $sign[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
										<td style="width:60%;"><input name="sign_default" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['sign_default']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="custom" <?php echo $sign[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
										<td style="width:60%;">
											<input name="sign_custom" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['sign_custom']:"";?>"><br/>
											<input name="sign_position" type="text" class="form-control p100" value="<?php echo (isset($field)) ? $field['param']['sign_position']:"";?>"></td>
									</tr>
									<tr>
										<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="none" <?php echo $sign[2];?>> None</label></div></td>
										<td style="width:60%;">&nbsp;</td>
									</tr>
								</tbody>
							</table>
							<hr/>
							<div class="bio-row">
								<table class="table">
									<tbody>
										<tr>
											<td class="no-border" style="width:20%;vertical-align:middle;"><?php echo lang('msg_field_file_name');?></td>
											<td class="no-border">
												 <div class="input-group">
													  <input name="file_name" type="text" placeholder="File Name" class="form-control p100" style="height:34px;border:1px solid #e2e2e4" value="<?php echo (isset($field)) ? $field['param']['file_name']:"";?>">
													  <span class="input-group-btn">
														<button class="btn btn-primary" type="submit" id="btn_owner" title="browse"><?php echo lang('msg_tbl_simpan');?></button>
													  </span>
												  </div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
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
							<h1><?php echo lang('msg_field_title_tamplate');?></h1>
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
							$i=0;
							foreach($data_report as $row){ 
								?>
								<tr>
									<td style="text-align:center;width:10%;"><?php echo ++$i;?></td>
									<td class="text-left"> <?php echo $row['template_name'];?></td>
									<td> <?php echo $row['create_user'];?></td>
									<td style="text-align:center;width:15%;cursor:pointer;">
										<?php if ($row['id'] != $id_report){ ?>
										<a  href="<?php echo base_url("report-risk-map/edit-report/".$row['id']);?>"><i class="fa fa-edit" title="Print Template"></i></a> | <a  href="<?php echo base_url("report-risk-map/print-report/".$row['id']);?>" target="_blank"> <i class="fa fa-print" title="Cetak Template"></i></a> | <i class="fa fa-times" id="del_action" title="Delete data Action" onclick="remove_install(this,<?php echo $row['id'];?>)"></i>
										<?php }else { ?> 
											<a  href="<?php echo base_url("report-risk-map/print-report/".$row['id']);?>"  target="_blank"> <i class="fa fa-print" title="Cetak Template"></i></a>
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

<script>
	
	$("#owner_no, #period_no, #rcsa_type").change(function(){
		var type_dash = $("#rcsa_type").val();
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		$("button#btn-search").addClass('disabled');
		cari_ajax_combo(id, 'spinner_param', 'project_no', 'ajax/get_project_name');
	});
	
	$("#view_data").change(function(){
		nil=$(this).val();
		if (nil==0){
			$("#owner_no").removeAttr('disabled');
			$("#period_no").removeAttr('disabled');
			$("#project_no").attr('disabled', true);
		}else if (nil==1){
			$("#owner_no").removeAttr('disabled');
			$("#period_no").removeAttr('disabled');
			$("#project_no").removeAttr('disabled');
		}else if (nil==2){
			$("#owner_no").removeAttr('disabled');
			$("#period_no").removeAttr('disabled');
			$("#project_no").removeAttr('disabled').attr('disabled', true);
		}else{
			$("#owner_no").removeAttr('disabled');
			$("#period_no").removeAttr('disabled');
			$("#project_no").removeAttr('disabled');
		}
	})
	
	function remove_install(t,iddel){
			if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			
				var nil=iddel;
				var url='<?php echo base_url("report-risk-map/delete_report");?>';
				
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