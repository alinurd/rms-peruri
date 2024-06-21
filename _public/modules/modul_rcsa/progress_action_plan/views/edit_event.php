<?php
	$data = array();
	$is_final = 0;
	$hide_edit='';
	if ($data_action){
		$data = $data_action[0];
		$is_final = $data['is_final'];
	}
	
	$data_edit = [];
	if ($data_edit_action){
		$data_edit = $data_edit_action;
	}
	
	// if ($is_final==1)
		// $hide_edit=' hide';
?>
<div class="x_content" style="background-color:#DCDDE2;">
	<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
	<tr>
		<td rowspan="2" class="row-title no-border" width="25%"><em>Action Plan</em></td>
		<td class="row-title no-border"><strong><?php echo ($data_action)?$data['title']:'';?></strong></td>
	</tr>
	<tr>
		<td class=" no-border">
			<div class="input-group w100">
			<strong><?php echo ($data_action)?$data['description']:'';?></strong>
			</div>
		</td>
	</tr>
	<tr>
		<td class="row-title no-border" width="25%"><em>Target Waktu</em></td>
		<td class=" no-border">
			<div class="input-group w100">
			<strong><?php echo ($data_action)?$data['target_waktu']:'';?></strong>
			</div>
		</td>
	</tr>
	<tr>
		<td class="row-title no-border" width="25%"><em><?php echo lang('msg_field_responsible_unit');?></em></td>
		<td class=" no-border">
			<div class="input-group w100">
			<strong><?php echo ($data_action)?$data['name']:'';?></strong>
			</div>
		</td>
	</tr>
	<tr>
		<td class="row-title no-border" width="25%"><em><?php echo lang('msg_field_status_no');?></em></td>
		<td class=" no-border">
			<div class="input-group w100">
			<img src="<?php echo img_url($data['icon']);?>" width="30">
			<span class="label label-<?php echo ($data_action)?$data['span']:'default';?>"><strong><?php echo ucwords(($data_action)?$data['status_action']:'');?></strong></span>
			</div>
		</td>
	</tr>
	</tbody>
	</table>
	<?php echo $risk_info;?>
</div>
<header class="x_title tab tab-bg-primary">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#action"><?php echo lang('msg_field_tab1');?></a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#info_action"><?php echo lang('msg_field_tab2');?></a>
		</li>
		<li class="hide">
			<a data-toggle="tab" href="#risk"><?php echo lang('msg_field_tab3');?></a>
		</li>
	</ul>
</header>
<div class="x_content margin-bottom-15">
	<div class="tab-content">
		<div id="action" class="tab-pane active">
			 <?php  
			echo form_open_multipart(base_url('progress_action_plan/save_action_detail'),array('id'=>'form_input_action'));
			?>
			<input type="hidden" name="id_rcsa_detail" value="<?php echo $id_rcsa_detail;?>">
			<input type="hidden" name="id_action" value="<?php echo $id_action;?>">
			<input type="hidden" name="id_rcsa" value="<?php echo $id_rcsa;?>">
			<div id="content_detail">
				<input type="hidden" name="id_action_detail" value="<?=$id_action_detail;?>">
				<table class="table table-striped table-hover dataTable data table-small-font" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td><?php echo lang('msg_field_date') . get_help('msg_help_date');?></td>
							<td> <?php  echo form_input('action_date',date('d-m-Y'),"  class='form-control datepicker' style='width:110px !important;' id='action_date' ");?></td>
						</tr>
						<tr>
							<td><?php echo lang('msg_field_description') . get_help('msg_help_description');?></td>
							<td>
								<?php 
									echo form_textarea("description", ($data_edit)?$data_edit['description']:''," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('msg_field_progress') . get_help('msg_help_progress');?></td>
							<td> <?php echo form_input(array('type'=>'number','name'=>'progress'),($data_edit)?$data_edit['progress']:'',' style="width:10% !important;" class="text-center" id="progress"');?> %</td>
						</tr>
						<tr>
							<td><?php echo lang('msg_field_notes') . get_help('msg_help_notes');?></td>
							<td>
								<?php 
									echo form_textarea("notes", ($data_edit)?$data_edit['notes']:''," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='notes' ")."&nbsp;&nbsp;&nbsp;";
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('msg_field_status') . get_help('msg_help_status');?></td>
							<td>
								<?php echo form_dropdown('status_no',$cbo_status, ($data_edit)?$data_edit['status_no']:'','class="form-control" id="status_no" ');?>
							</td>
						</tr>
						<tr>
							<td class="row-title  no-border vcenter text-left">
								<?=lang('msg_field_residual_risk');?>
							</td>
							<td class="no-border vcenter text-left">
								<span style="margin-right:10px; float: left;"> <?=lang('msg_field_likelihood')?> :</span>
								<?= form_dropdown('residual_likelihood',$cbo_level_like, (empty($data['residual_likelihood']))?'':$data['residual_likelihood'] ,'class="form-control" style="width:150px;float:left;margin-right:10px" id="residual_likelihood"')?>
								<span style="margin-right:10px; float: left;"> <?=lang('msg_field_impact')?> :</span>
								<?php echo form_dropdown('residual_impact',$cbo_level_impact_baru, (empty($data['residual_impact']))?'':$data['residual_impact'],'class="form-control" id="residual_impact" style="width:150px"');?>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<?php echo lang('msg_field_att') . get_help('msg_help_att');?>
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_att">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5 " width="82%">
												<div id="attr_awal">
													<?php echo form_upload("attac[]",'');?>
												</div>
											</td>
											<td class="text-right no-border padding-5">
												<input type='button' class='btn btn-warning btn-flat' value='<?php echo lang('msg_tbl_add_more');?>' id='browse_att' />
												<span class='btn btn-warning btn-flat hide' id='clear_att'>
													<i class="fa fa-cut hide" title="<?php echo lang('msg_tips_delete');?>" id="i_att">
												</span>
												
											</td>
										</tr>
									</tbody>
								</table>
								<?php
								$attch = form_upload("attac[]",'');
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			
			<div class="box-body <?php echo $hide_edit;?>">
				<button class="btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
				<i class="fa fa-floppy-o"></i>
				<?php echo lang('msg_tbl_simpan');?>
				</button>
				<span value="0" id="add_action" class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover">
					<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_add');?>
				</span>
			</div>
			<?php echo form_close();?>
			<hr>
			<table class="table" id="datatables">
				<thead>
					<tr>
					<th width="10%" style="text-align:center;">No.</th>
					<th width="15%" ><?php echo lang('msg_field_date');?></th>
					<th width="10%" ><?php echo lang('msg_field_progress_persent');?></th>
					<th width="27%" ><?php echo lang('msg_field_desciption');?></th>
					<th width="27%"><?php echo lang('msg_field_notes');?></th>
					<th width="6%"><?php echo lang('msg_aksi');?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					foreach($data_progress_action as $row){ 
						?>
						<tr>
							<td style="text-align:center;width:10%;"><?php echo $i;?></td>
							<td> <?php echo $row['progress_date'];?></td>
							<td> <?php echo $row['progress'];?></td>
							<td> <?php echo $row['description'];?></td>
							<td> <?php echo $row['notes'];?></td>
							<td style="text-align:center;width:10%;cursor:pointer;">
								<i class="fa fa-pencil edit_action" title="Edit data Action" value="<?php echo $row['id'];?>"></i> | 
								<i class="fa fa-times" id="del_action" title="Delete data Action" onclick="removes_install(this,<?php echo $row['id'];?>)"></i>
							</td>
						</tr>
						<?php 
					}
					?>
				</tbody>
			</table>
		</div>
		
		
		<div id="info_action" class="tab-pane ">
			<div id="content_level">
				<?php echo $action_info;?>
			</div>
		</div>
		
		<div id="risk" class="tab-pane ">
			<div id="content_level">
				<?php echo $risk_info;?>
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
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_tbl_close');?></button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script>
	$("#form_input_action").submit(function(){
		var nil=$("#progress").val();
		var sts=$("#status_no").val();
		if ((nil>=100 && sts!=="4") || (nil<100 && sts=="4")){
			pesan_toastr('Jika Status Finish maka progress harus 100%, begitu pula sebaliknya');
			return false;
		}else{
			$(this).submit();
		}
	})
	
	function validasi_progress(){
		var nil=$("#progress").val();
		var sts=$("#status_no").val();
		if (nil>100 || nil<0){
			pesan_toastr('Nilai yang diijinkan 0 sampai dengan 100','err','Prosess','toast-top-center');
			$("#progress").val('100');
		}
	}
	
	$("body").on('keyup','#progress',function(){
		validasi_progress();
	})
	
	$("body").on('change','#progress',function(){
		validasi_progress();
	})
	
	$("#clear_att").click(function(){
		$("#attr_awal").html('<input type="file" name="attac[]"/>');
	})
	
	$("#browse_att").click(function(){
		var att='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$attch));?>';
		
		$("#clear_att").removeClass('hide');
		$("#i_att").removeClass('hide');
		$(this).val('Add');
		
		var theTable= document.getElementById("instlmt_att");
		var rl = theTable.tBodies[0].rows.length;
		
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		var td1 =document.createElement("TD");
		td1.setAttribute("style","text-align:center;width:10%;");
		td1.setAttribute("class","no-padding-left no-border padding-5");
		var td2 =document.createElement("TD");
		td2.setAttribute("width","82%");
		td2.setAttribute("class","no-padding-left no-border padding-5");
		td2.setAttribute("style","text-align:center;");
		
		++rl;
		td1.innerHTML=att;
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="removes_install(this,0)"><i class="fa fa-cut" title="' + Globals.tips_delete + '" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	});
	
	$(".edit_action, #add_action").click(function(){
		var nil=$(this).attr("value");
		// alert(nil);
		var url='<?php echo base_url("progress-action-plan/get-form-action");?>';
		var rcsa_detail='<?php echo $id_rcsa_detail;?>';
		var action_detail='<?php echo $id_action;?>';
		var form={'id':nil,'rcsa_detail':rcsa_detail,'action_detail':action_detail};

		// loading(true,'overlay_content');
		$.ajax({
			type: "GET",
			url: url,
			data:form,
			success: function(msg){
				$('#content_detail').html(msg);
			},
			failed: function(msg){
				pesan_toastr('Gagal','err','Prosess','toast-top-center');
			},
			error: function(msg){
				pesan_toastr('Gagal','err','Prosess','toast-top-center');
			},
		});
	});

	function removes_install(t,iddel){
		 if(confirm(Globals.tips_delete_confirm)){
			var nil=iddel;
			var url='<?php echo base_url("progress-action-plan/del-action");?>';
			
			var form={'id':nil};
			$.ajax({
				type: "GET",
				url: url,
				data:form,
				success: function(msg){
					t.parentNode.parentNode.remove();
				},
				failed: function(msg){
					pesan_toastr('Gagal','err','Prosess','toast-top-center');
				},
				error: function(msg){
					pesan_toastr('Gagal','err','Prosess','toast-top-center');
				},
			});
		}
		return false;
	}

</script>