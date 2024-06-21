<?php
	$arr_icon_file=array('pdf'=>'fa fa-file-pdf-o','word'=>'fa fa-word-pdf-o','wordx'=>'fa fa-file-word-o','xls'=>'fa fa-file-excel-o','xlsx'=>'fa fa-file-excel-o','ppt'=>'fa fa-file-powerpoint-o','pptx'=>'fa fa-file-powerpoint-o','jpg'=>'fa fa-file-image-o','png'=>'fa fa-file-image-o','other'=>'fa fa-file-code-o');
	$data=$data_risk_detail[0];
	$tab=$this->session->userdata('tab_rcsa');
	$active_tab[0]='';
	$active_tab[1]='';
	$active_tab[2]='';
	$active_tab[3]='';
	if (!empty($tab)){
		if ($tab=='#level')
			$active_tab[1]=' active ';
		elseif ($tab=='#action')
			$active_tab[2]=' active ';
		elseif ($tab=='#register')
			$active_tab[3]=' active ';
		else
			$active_tab[0]=' active ';
	}else{
		$active_tab[0]=' active ';
	}
?>

<header class="panel-heading tab-bg-dark-navy-blue ">
	<ul class="nav nav-tabs">
		<li class="<?php echo $active_tab[0];?>">
			<a data-toggle="tab" href="#home"><?php echo lang('msg_field_tab1');?></a>
		</li>
		<li class="<?php echo $active_tab[1];?>">
			<a data-toggle="tab" href="#level"><?php echo lang('msg_field_tab2');?></a>
		</li>
		<li class="<?php echo $active_tab[2];?>">
			<a data-toggle="tab" href="#action"><?php echo lang('msg_field_tab3');?></a>
		</li>
		<li class="<?php echo $active_tab[3];?>">
			<a data-toggle="tab" href="#register" id="tab_register"><?php echo lang('msg_field_tab4');?></a>
		</li>
	</ul>
</header>
<div class="panel-body margin-bottom-15">
	<div class="tab-content">
		<div id="home" class="tab-pane <?php echo $active_tab[0];?>">
			<?php  echo form_open_multipart(base_url('project/save_detail'),array('id'=>'form_input'));?>
			<input type="hidden" name="id_rcsa" value="<?php echo $id_rcsa;?>">
			<input type="hidden" name="id_event_detail" value="<?php echo $id_event_detail;?>">
			<div id="content_detail">
				<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0" id="table-edit-event">
					<tbody>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_area');?>
							</td>
							<td class=" no-border">
								<div class="input-group w100" style="width: 100%">

									<?php 
											$own = $data_owners[0]['id']." - ".$data_owners[0]['name'];

											echo form_textarea("risk_area", $own," class='form-control text-left' readonly='' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_area' ")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
											?>
											<input type="hidden" name="risk_area_id" id="risk_event_id" value="<?php echo $data['risk_area_id'];?>">

									<button type='button' class='btn btn-primary btn-flat btn-95' id='browse_area'><i class="fa fa-search"></i></button> 
								</div>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_event');?>
							</td>
							<td class=" no-border">
								<div class="input-group w100" style="width: 100%">
								<?php 
									if (count($data['event_no'])>0){
										foreach($data['event_no'] as $row){
											echo form_textarea("risk_event", $row['code'].' - '.$row['name']," class='form-control text-left' readonly='' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
											?>
											<input type="hidden" name="risk_event_id" id="risk_event_id" value="<?php echo $row['id'];?>">
										<?php } 
									} ?>
									<button type='button' class='btn btn-primary btn-flat btn-95' id='browse_event'><i class="fa fa-search"></i></button> 
								</div>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_couse');?>
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_couse">
									<tbody>
										<?php 
										$i=0;
										$nil_couse=count($data['risk_couse_no']);
										if (count($data['risk_couse_no'])>0){
											foreach($data['risk_couse_no'] as $row){
											?>
											<tr>
												<td class="no-padding-left no-border padding-5" width="82%">
													<?php 
														echo form_textarea("risk_couse[]", $row['code'].' - '.$row['name']," class='form-control text-left p100 risk_couse' readonly='' rows='2' cols='5' style='overflow: hidden; height: 75px;' id='risk_couse_".$i."' ")."&nbsp;&nbsp;&nbsp;";
													?>
													<input type="hidden" name="risk_couse_id[]" id="risk_couse_id_<?php echo $i;?>" value="<?php echo $row['id'];?>">
												</td>
												<td class="text-center no-border padding-5">
													<?php 
													if ($i==0){
														++$i;
													?>
														<button type='button' class='btn btn-primary btn-flat btn-95 browse_couse couse-0' id='browse_couse_0' nil="0"><i class="fa fa-search"></i></button> 
														<button type='button' class='btn btn-warning btn-flat btn-95' id='browse_couse_more'><i class="fa fa-plus"></i></button>
													<?php }else{
													?>
														<button type="button" class="btn btn-primary btn-flat btn-95 browse_couse couse-<?php echo $i;?>" id="browse_couse_<?php echo $i;?>"  nil="<?php echo $i;?>"><i class="fa fa-search"></i></button><br/><button type="button" class="btn btn-danger btn-flat btn-95" onclick="remove_install(this,0)" id="del_couse_<?php echo $i;?>" nil="<?php echo $i;?>"><i class="fa fa-cut"></i></button>
													<?php
													} ?>
												</td>
											</tr>
											<?php }
										}else{
										?>
										<tr>
											<td class="no-padding-left no-border padding-5" width="82%">
												<?php 
													echo form_textarea("risk_couse[]", ""," class='form-control text-left p100 risk_couse-0' rows='2' readonly='' cols='5' style='overflow: hidden; height: 75px;' id='risk_couse_0' ")."&nbsp;&nbsp;&nbsp;";
												?>
												<input type="hidden" name="risk_couse_id[]" id="risk_couse_id_0" value="0">
											</td>
											<td class="text-right no-border padding-5">
												<button type='button' class='btn btn-primary btn-flat btn-95 browse_couse couse-0' id='browse_couse_0' nil="0"><i class="fa fa-search"></i></button> 
												<button type='button' class='btn btn-warning btn-flat btn-95' id='browse_couse_more'><i class="fa fa-plus"></i></button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_impact');?>
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_impact">
									<tbody>
										<?php 
										$i=0;
										$nil_impact = count($data['risk_impact_no']);
										if(count($data['risk_impact_no'])>0){
											foreach($data['risk_impact_no'] as $row){
											?>
											<tr>
												<td class="no-padding-left no-border padding-5 " width="82%">
													<?php 
														echo form_textarea("risk_impact[]", $row['code'].' - '.$row['name']," class='form-control text-left p100 risk_impact' readonly='' rows='2' cols='5' style='overflow: hidden; height: 75px;' id='risk_impact_".$i."' ")."&nbsp;&nbsp;&nbsp;";
													?>
													<input type="hidden" name="risk_impact_id[]" id="risk_impact_id_<?php echo $i;?>" value="<?php echo $row['id'];?>">
												</td>
												<td class="text-center no-border padding-5">
													<?php 
													if($i==0){
														++$i;
														?>
														<button type='button' class='btn btn-primary btn-flat btn-95 browse_impact impact-0' id='browse_impact_0' nil="0"><i class="fa fa-search"></i></button> 
														<button type='button' class='btn btn-warning btn-flat btn-95' id='browse_impact_more'><i class="fa fa-plus"></i></button>
													<?php }else{
													?>
														<button type="button" class="btn btn-primary btn-flat btn-95 browse_impact impact-<?php echo $i;?>" id="browse_impact_<?php echo $i;?>"  nil="<?php echo $i;?>"><i class="fa fa-search"></i></button><br/><button type="button" class="btn btn-danger btn-flat btn-95" onclick="remove_install(this,0)" id="del_impact_<?php echo $i;?>" nil="<?php echo $i;?>"><i class="fa fa-cut"></i></button>
													<?php
													} ?>
												</td>
											</tr>
										<?php }
										}else{
										?>
											<tr>
												<td class="no-padding-left no-border padding-5 " width="82%">
													<?php 
														echo form_textarea("risk_impact[]", ""," class='form-control text-left p100 risk_impact' readonly='' rows='2' cols='5' style='overflow: hidden; height: 75px;' id='risk_impact_0' ")."&nbsp;&nbsp;&nbsp;";
													?>
													<input type="hidden" name="risk_impact_id[]" id="risk_impact_id_0" value="0">
												</td>
												<td class="text-right no-border padding-5">
													<button type='button' class='btn btn-primary btn-flat btn-95 browse_impact impact-0' id='browse_impact_0' nil="0"><i class="fa fa-search"></i></button> 
													<button type='button' class='btn btn-warning btn-flat btn-95' id='browse_impact_more'><i class="fa fa-plus"></i></button>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</td>
						</tr>
						
						<tr>
							<td class="row-title no-border">
								<!-- <sup><span class="required"> *) </span></sup> -->
								<?php echo lang('msg_field_risk_attacment');?>
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_att">
									<tbody>
										<?php 
										$i=0;
										$path=upload_url().'project/';
										if(count($data['attach'])>0){
											foreach($data['attach'] as $row){
												if (!empty($row['name']) && !empty($row['real_name'])){
													$ext=explode('.',$row['real_name']);
													
													if ($ext){
														$ext=strtolower($ext[count($ext)-1]);
													}else{
														$ext='other';
													}
													$ext = '<i class="'.$arr_icon_file[$ext].'"></i> ';
											?>
												<tr>
													<td class="no-padding-left no-border padding-5 " width="82%">
														<?php 
														if($i==0){
														?>
															<div id="attr_awal">
																<a href="<?php echo base_url('project/get_file/'.$row['name']);?>"><?php echo $ext.' '.$row['real_name'];?></a>
																<input type="hidden" name="attach_no[]" id="attach_no" value="<?php echo $row['name']."###".$row['real_name'];?>">
															</div>
														<?php }else{
															?>
															<a href="<?php echo base_url('project/get_file/'.$row['name']);?>"><?php echo $ext.' '.$row['real_name'];?></a>
																<input type="hidden" name="attach_no[]" id="attach_no" value="<?php echo $row['name']."###".$row['real_name'];?>">
														<?php
														}
														?>
													</td>
													<td class="text-center no-border padding-5">
														<?php 
														if($i==0){
															++$i;
															?>
															<button type='button' class='btn btn-primary btn-flat' id='browse_att'><i class="fa fa-plus"></i></button>
															<button type='button' class='btn btn-primary btn-flat' id='clear_att'><i class="fa fa-cut"></i></button>
														<?php }else{
														?>
															<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>
														<?php
														} ?>
													</td>
												</tr>
											<?php }} ?>
											<tr>
												<td class="no-padding-left no-border padding-5 " width="82%">
													<?php echo form_upload("attac[]",'');?>
												</td>
												<td class="text-center no-border padding-5">
													<span id='clear_att'  onclick="remove_install(this,0)">
														<i class="fa fa-cut" title="menghapus data" id="i_att"></i>
													</span>
													
												</td>
											</tr>
											<?php
										}else{ 		
										?>
										<tr>
											<td class="no-padding-left no-border padding-5 " width="82%">
												<?php echo form_upload("attac[]",'');?>
											</td>
											<td class="text-right no-border padding-5">
												<button type='button' class='btn btn-primary btn-flat' id='browse_att'><i class="fa fa-plus"></i></button>
												<button type='button' class='btn btn-primary btn-flat' id='clear_att'><i class="fa fa-cut"></i></button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
										<td colspan="2" class="well">
											<em>Type File</em> : <?php echo $this->authentication->get_Preference('upload_type');?><br/>
											<em>Max Size</em> : <?php echo $this->authentication->get_Preference('upload_size');?>kb
										</td>
										</tr>
									</tfoot>
								</table>
								<?php
								$attch = form_upload("attac[]",'');
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<hr>
				<div class="row well">
					<div class="col-md-8 text-left">
						<button class="save btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
						<i class="fa fa-floppy-o"></i>
						<?php echo lang('msg_tbl_simpan');?>
						</button>
						<span class="delete btn btn-warning btn-flat" data-content="Remove Data Event Detail" data-toggle="popover" url="<?php echo base_url('project/delete-event/'.$id_rcsa.'/'.$id_event_detail);?>">
							<i class="fa fa-cut"></i> <?php echo lang('msg_tbl_del');?>
						</span>
						<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('project/risk-event/'.$id_rcsa);?>" >
							<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_add');?>
						</a>
					</div>
					<div class="col-md-4 pull-right">
						<button class="btn btn-danger btn-flat pull-right" data-content="Add Library" data-toggle="popover" name="l_add_library" id="l_add_library" value="Add Library " type="button"><i class="fa fa-envelope"></i>
						<?php echo lang('msg_tbl_add_library');?>
						</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php 
							$cb=(isset($data['create_user']))? $data['create_user']:'';
							$cd=(isset($data['create_date']))? $data['create_date']:'';
							$ub=(isset($data['update_user']))? $data['update_user']:'';
							$ud=(isset($data['update_date']))? $data['update_date']:'';
						?>
						<em><sup><?php echo lang('msg_create_by').'<span class="text-info">'.$cb.'</span> , '.lang('msg_create_stamp').'<span class="text-info">'.$cd.'</span> | '.lang('msg_update_by').'<span class="text-info">'.$ub.'</span> '.lang('msg_update_stamp').'<span class="text-info">'.$ud.'</span>';?></sup></em>
					</div>
				</div>
			</div>
			<?php echo form_close();?>
		</div>
		<div id="level" class="tab-pane <?php echo $active_tab[1];?>">
			<div id="content_level">
				<?php echo $risk_level;?>
			</div>
		</div>
		<div id="action" class="tab-pane <?php echo $active_tab[2];?>">
			<div id="content_level">
				<?php echo $risk_action;?>
			</div>
		</div>
	</div>
</div>

<script>
	var nil_couse='<?php echo $nil_couse;?>';
	var nil_impact='<?php echo $nil_impact;?>';
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
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	});
	
	$("table#table-edit-event").on('click','.browse_couse',function(){
		var jml=$(this).attr('nil');
		var nil = 'couse'; 
		var tbl='instlmt_couse';
		get_data(nil, tbl, jml);
	});
	
	$("#browse_couse_more").click(function(){
		add_install_couse_more();
	});
	
	$("table#table-edit-event").on('click','.browse_impact',function(){
		var jml=$(this).attr('nil');
		var nil = 'impact'; 
		var tbl='instlmt_impact';
		get_data(nil, tbl, jml);
	});
	
	$("#browse_impact_more").click(function(){
		add_install_impact_more();
	});
	
	$("#browse_event").click(function(){
		var nil = 'event'; 
		var tbl='instlmt_event';
		var count=0;
		get_data(nil, tbl, count);
	});
	$("#browse_area").click(function(){
		var nil = 'owner'; 
		var tbl='instlmt_owner';
		var count=0;
		get_data(nil, tbl, count);
	});

	function get_data(nil, tblx, count){
		var parent= $("#risk_event_id").val();
		var nilai = nil;
		var tabel = tblx;
		var counter = count;
		if (nil=='owner') {
			get_data_source(nilai, tabel, counter, parent);
			return false;
		}
		if (nil!=='event' && parent.length==0) {
			pesan_toastr("Event Belum dipilih","err","Admin","toast-top-center");
			return false;
		} else {
			get_data_source(nilai, tabel, counter, parent);
		}
		
	}
	function get_data_source(nil, tblx, count, parents) {
		var url='<?php echo base_url("project/get_data_source");?>';
		var form = {'idmodal':nil,'tbl':tblx,'jml':count, 'parent':parents};
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
		});
	}
	// function get_data(nil, tblx, count){
	// 	var url='<?php echo base_url("project/get-data-source");?>';
	// 	var parent=$("#risk_event_id").val();
	// 	if (nil!=='event' && parent.length==0){
	// 		pesan_toastr("Event Belum dipilih","err","Admin","toast-top-center");
	// 		return false;
	// 	}
	// 	alert(url);
	// 	var form = {'idmodal':nil,'tbl':tblx,'jml':count, 'parent':parent};
	// 	// looding('light',$(this).parent());
	// 	$.ajax({
	// 		type: "GET",
	// 		url: url,
	// 		data: form,
	// 		success: function(msg){
	// 			$('#id_tambah_data_target').find('.modal-content').html(msg);
	// 			// stopLooding($(this).parent());
	// 			$('#id_tambah_data_target').modal('show');
				
	// 		},
	// 		failed: function(msg){
	// 			// stopLooding($(this).parent());
	// 			alert("gagal");
	// 		},
	// 		error: function(msg){
	// 			stopLooding($(this).parent());
	// 			alert("gagal");
	// 		},
	// 	});
	// }
	
	$("#l_add_library").click(function(){		
		looding('light',$(this));
		var url='<?php echo base_url("project/add-library");?>';
		form='';
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				stopLooding($(this).parent());
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				stopLooding($(this).parent());
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				stopLooding($(this).parent());
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
		});
	})
	
	function add_install(id, nama, tbl, kel) {
		var owner_no = document.createElement("input");
		owner_no.setAttribute('type',"hidden");
		owner_no.setAttribute('name',"id[]");
		owner_no.setAttribute('value',id);
		
		var owner_name = document.createElement("input");
		owner_name.setAttribute('type',"text");
		owner_name.setAttribute('name',kel + "_name[]");
		owner_name.setAttribute('readonly',"");
		owner_name.setAttribute('class',"form-control p100");
		owner_name.setAttribute('value',nama);
		
		var theTable= document.getElementById(tbl);
		var rl = theTable.tBodies[0].rows.length;
		
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		if((rl-1)%2==0)
			tr.className="dn_block";
		else
			tr.className="dn_block_alt";
		
		var td1 =document.createElement("TD")
		td1.setAttribute("style","text-align:left;width:82%;");
		td1.setAttribute("class","no-padding-left");
		td1.appendChild(owner_no);
		td1.appendChild(owner_name);
		
		var td2 =document.createElement("TD");
		td2.setAttribute("style","text-align:center;width:10%;");
		
		++rl;
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	};
	
	function add_install_area(id, nama) {
		$("#risk_area").val(id+" - "+nama);
		$("#risk_area_id").val(id);
	};

	function add_install_event(id, nama) {
		$("#risk_event").val(nama);
		$("#risk_event_id").val(id);
	};
	
	function add_install_couse(id, nama, jml) {
		$("textarea#risk_couse_"+jml).html(nama);
		$("#risk_couse_id_"+jml).val(id);
		// $('#browse_couse_more').removeAttr('disabled');
	};
	
	function add_install_couse_more() {
		var couse_no = document.createElement("input");
		couse_no.setAttribute('type',"hidden");
		couse_no.setAttribute('name',"risk_couse_id[]");
		couse_no.setAttribute('id',"risk_couse_id_"+nil_couse);
		couse_no.setAttribute('value',0);
		
		var t = document.createTextNode('');
		var couse_name = document.createElement("textarea");
		couse_name.setAttribute('class',"form-control text-left p100 risk_couse");
		couse_name.setAttribute('name',"risk_couse[]");
		couse_name.setAttribute('id',"risk_couse_"+nil_couse);
		couse_name.setAttribute('cols',"40");
		couse_name.setAttribute('rows',"10");
		couse_name.setAttribute('style',"overflow: hidden; height: 104px;");
		couse_name.appendChild(t);
		
		var theTable= document.getElementById('instlmt_couse');
		var rl = theTable.tBodies[0].rows.length;
		
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		if((rl-1)%2==0)
			tr.className="dn_block";
		else
			tr.className="dn_block_alt";
		
		var td1 =document.createElement("TD")
		td1.setAttribute("style","text-align:left;width:82%;");
		td1.setAttribute("class","no-padding-left no-border padding-5");
		td1.appendChild(couse_no);
		td1.appendChild(couse_name);
		
		var td2 =document.createElement("TD");
		td2.setAttribute("style","text-align:center;width:10%;");
		
		++rl;
		td2.innerHTML='<button type="button" class="btn btn-primary btn-flat btn-95 browse_couse couse-'+nil_couse+'" id="browse_couse_'+nil_couse+'"  nil="'+nil_couse+'"><i class="fa fa-search"></i></button><br/><button type="button" class="btn btn-danger btn-flat btn-95" onclick="remove_install(this,0)" id="del_couse_'+nil_couse+'" nil="'+nil_couse+'"><i class="fa fa-cut"></i></button>';
		
		++nil_couse;
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	};
	
	function add_install_impact(id, nama, jml) {
		$("textarea#risk_impact_"+jml).html(nama);
		$("#risk_impact_id_"+jml).val(id);
	};
	
	function add_install_impact_more() {
		var couse_no = document.createElement("input");
		couse_no.setAttribute('type',"hidden");
		couse_no.setAttribute('name',"risk_impact_id[]");
		couse_no.setAttribute('id',"risk_impact_id_"+nil_impact);
		couse_no.setAttribute('value',0);
		
		var t = document.createTextNode('');
		var couse_name = document.createElement("textarea");
		couse_name.setAttribute('class',"form-control text-left p100 risk_impact");
		couse_name.setAttribute('name',"risk_impact[]");
		couse_name.setAttribute('id',"risk_impact_"+nil_impact);
		couse_name.setAttribute('cols',"40");
		couse_name.setAttribute('rows',"10");
		couse_name.setAttribute('style',"overflow: hidden; height: 104px;");
		couse_name.appendChild(t);
		
		var theTable= document.getElementById('instlmt_impact');
		var rl = theTable.tBodies[0].rows.length;
		
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		if((rl-1)%2==0)
			tr.className="dn_block";
		else
			tr.className="dn_block_alt";
		
		var td1 =document.createElement("TD")
		td1.setAttribute("style","text-align:left;width:82%;");
		td1.setAttribute("class","no-padding-left no-border padding-5");
		td1.appendChild(couse_no);
		td1.appendChild(couse_name);
		
		var td2 =document.createElement("TD");
		td2.setAttribute("style","text-align:center;width:10%;");
		
		++rl;
		td2.innerHTML='<button type="button" class="btn btn-primary btn-flat btn-95 browse_impact impact-'+nil_impact+'" id="browse_impact_'+nil_impact+'"  nil="'+nil_impact+'"><i class="fa fa-search"></i></button><br/><button type="button" class="btn btn-danger btn-flat btn-95" onclick="remove_install(this,0)" id="del_impact_'+nil_impact+'" nil="'+nil_impact+'"><i class="fa fa-cut"></i></button>';
		++nil_impact;
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	};
	
	function remove_install(t,iddel){
		if(confirm(Globals.tips_delete_confirm)){
			var ri = t.parentNode.parentNode.rowIndex;
			t.parentNode.parentNode.parentNode.deleteRow(ri);
		}
		return false;
	}
	
	
	$('.nav-tabs > li > a').bind('click', function (e) {
		var url='<?php echo base_url("project/change_tab");?>';
		var x = $(this).attr('href');
		if (x=="#register"){
			return false;
		}
		var form={'tipe':x};
		$.ajax({
			type: "GET",
			url: url,
			data: form
		});
	});
		
	$("#tab_register").click(function(){
		var url='<?php echo base_url("project/get-data-risk-register");?>';
		var nil='<?php echo $id_rcsa;?>';
		var event='<?php echo $id_event_detail;?>';
		var form = {'id-rcsa':nil, 'event':event};
		// looding('light',$(this).parent());
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				// stopLooding("#tab_register");
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				// stopLooding($(this).parent());
				alert("gagal");
			},
			error: function(msg){
				// stopLooding($(this).parent());
				alert("gagal");
			},
		});
	});


</script>