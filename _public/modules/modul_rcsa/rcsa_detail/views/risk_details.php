<header class="panel-heading tab-bg-dark-navy-blue ">
	<ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#home">Risk Detail</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#about">Rist Level</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#profile">Action Plans</a>
		</li>
	</ul>
</header>
<div class="panel-body margin-bottom-15">
	<div class="tab-content">
		<div id="home" class="tab-pane active">
			<?php  echo form_open_multipart(base_url('rcsa/save_detail/1'),array('id'=>'form_input'));?>
			<div id="content_detail">
				<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								Risk Event
							</td>
							<td class=" no-border">
								<div class="input-group w100">
								<?php 
									echo form_textarea("risk_event", ""," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
								?>
									<input type="hidden" name="risk_event_id">
									<input type='button' class='btn btn-warning btn-flat pull-right' value='From Library' style="width:85px !important;" id='browse_event' />
								</div>
							</td>
						</tr>
						<tr>
							<td class="row-title  no-border">
								<sup><span class="required"> *) </span></sup>
								Risk Owner
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_owner">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5" width="82%">
												<?php echo form_dropdown('owner_name[]',$cbo_owner, '','class="form-control p100"');?>
											</td>
											<td class="text-right no-border padding-5"><input type='button' class='btn btn-warning btn-flat' value='Add More' id='browse_owner' /></td>
										</tr>
									</tbody>
								</table>
								<?php
								$owner_name = form_dropdown('owner_name[]',$cbo_owner, '','class="form-control p100"');
								?>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								Risk Type
							</td>
							<td class="no-border">
								<table class="table borderless" id="instlmt_type">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5" width="82%">
												<?php echo form_dropdown('type_name[]',$cbo_type, '','class="form-control p100"');?>
											</td>
											<td class="text-right no-border padding-5">
												<input type='button' class='btn btn-warning	 btn-flat' value='Add More' id='browse_type' />
											</td>
										</tr>
									</tbody>
								</table>
								<?php
								$type_name = form_dropdown('type_name[]',$cbo_type, '','class="form-control p100"');
								?>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								Risk Couse
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_couse">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5" width="82%">
												<?php 
													echo form_textarea("risk_couse[]", ""," class='form-control text-left p100 risk_couse' rows='2' cols='5' style='overflow: hidden; height: 75px;' id='risk_couse1' ")."&nbsp;&nbsp;&nbsp;";
												?>
												<input type="hidden" name="risk_couse_id[]" id="risk_couse11">
											</td>
											<td class="text-right no-border padding-5">
												<input type='button' class='btn btn-warning btn-flat' value=' From Library' style="width:85px; margin-bottom:10px;" id='browse_couse' /><br/>
												<input type='button' class='btn btn-warning btn-flat' value='Add More' style="width:85px; margin-bottom:10px;" id='browse_couse_more' />
											</td>
										</tr>
									</tbody>
								</table>
								<?php
								$owner_name = form_dropdown('owner_name[]',$cbo_owner, '','class="form-control p100"');
								?>
							</td>
						</tr>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								Risk IMpact
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_impact">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5 " width="82%">
												<?php 
													echo form_textarea("risk_impact[]", ""," class='form-control text-left p100 risk_impact' rows='2' cols='5' style='overflow: hidden; height: 75px;' id='risk_impact1' ")."&nbsp;&nbsp;&nbsp;";
												?>
												<input type="hidden" name="risk_impact_id[]" id="risk_impact11">
											</td>
											<td class="text-right no-border padding-5">
												<input type='button' class='btn btn-warning btn-flat' value=' From Library' style="width:85px; margin-bottom:10px;" id='browse_impact' /><br/>
												<input type='button' class='btn btn-warning btn-flat' value='Add More' style="width:85px; margin-bottom:10px;" id='browse_impact_more' />
											</td>
										</tr>
									</tbody>
								</table>
								<?php
								$owner_name = form_dropdown('owner_name[]',$cbo_owner, '','class="form-control p100"');
								?>
							</td>
						</tr>
						
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								Attactment
							</td>
							<td class="no-border">
								<table class="table borderless no-margin-bottom" id="instlmt_att">
									<tbody>
										<tr>
											<td class="no-padding-left no-border padding-5 " width="82%">
												<?php echo form_upload("attac[]",'');?>
											</td>
											<td class="text-right no-border padding-5">
												<input type='button' class='btn btn-warning btn-flat' value='Add More' id='browse_att' />
												<span class='btn btn-warning btn-flat hide' id='clear_att'>
													<i class="fa fa-cut hide" title="menghapus data" id="i_att">
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
				<hr>
				<div class="box-body">
					<button class="delete btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
					<i class="fa fa-floppy-o"></i>
					Save
					</button>
					<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo $this->uri->uri_string.'/delete';?> >
						<i class="fa fa-plus"></i> Delete
					</a>
					<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('rcsa/risk-event/1');?>
						<i class="fa fa-plus"></i> Add
					</a>
					<span class="pull-right" style="padding-right:20px;"> 
						<a class="add btn btn-success btn-flat" data-content="Add New Data" data-toggle="popover" href="http://p.risk.com/operator/add">
						<i class="fa fa-plus"></i>
							Next
						</a>
					</span>
				</div>
			</div>
			<?php echo form_close();?>
		</div>
		<div id="about" class="tab-pane">
			<div id="content_level">Level yep</div>
		</div>
		<div id="profile" class="tab-pane">
			<div id="content_action">Action nih</div>
		</div>
	</div>
	<div id="loading" class="loading-img hide"></div>
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


<script>
	$("#browse_owner").click(function(){
		var cbo='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$owner_name));?>';
		
		var theTable= document.getElementById("instlmt_owner");
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
		td1.innerHTML=cbo;
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	});
	
	$("#browse_type").click(function(){
		var cbo='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$type_name));?>';
		
		var theTable= document.getElementById("instlmt_type");
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
		td1.innerHTML=cbo;
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	});
	
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
	
	$("#browse_couse, #browse_couse_more").click(function(){
		var count=$(".risk_couse").size();
		var jml = $("#risk_couse11").val();
		
		if (jml>0){
			count=2;
		}
		$("#loading").removeClass('hide');
		var nil = 'couse'; 
		var tbl='instlmt_couse';
		get_data(nil, tbl, count);
	});
	
	$("#browse_impact, #browse_impact_more").click(function(){
		var count=$(".risk_impact").size();
		var jml = $("#risk_impact11").val();
		
		if (jml>0){
			count=2;
		}
		$("#loading").removeClass('hide');
		var nil = 'impact'; 
		var tbl='instlmt_impact';
		get_data(nil, tbl, count);
	});
	
	$("#browse_event").click(function(){
		$("#loading").removeClass('hide');
		var nil = 'event'; 
		var tbl='instlmt_event';
		var count=0;
		get_data(nil, tbl, count);
	});
	
	function get_data(nil, tblx, count){
		var url='<?php echo base_url("rcsa/get_data_source");?>';
		var form = {'idmodal':nil,'tbl':tblx,'jml':count};
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				$("#loading").addClass('hide');
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				$("#loading").addClass('hide');
				alert("gagal");
			},
		});
	}
	
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
	
	function add_install_event(id, nama) {
		$("#risk_event").val(nama);
		$("#risk_event_id").val(id);
	};
	
	function add_install_couse(id, nama) {
		$("textarea#risk_couse1").html(nama);
		$("#risk_couse11").val(id);
	};
	
	function add_install_couse_more(id, nama) {
		var couse_no = document.createElement("input");
		couse_no.setAttribute('type',"hidden");
		couse_no.setAttribute('name',"risk_couse_id[]");
		couse_no.setAttribute('value',id);
		
		var t = document.createTextNode(nama);
		var couse_name = document.createElement("textarea");
		couse_name.setAttribute('class',"form-control text-left p100 risk_couse");
		couse_name.setAttribute('name',"risk_couse[]");
		couse_name.setAttribute('id',"risk_couse");
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
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	};
	
	function add_install_impact(id, nama) {
		$("textarea#risk_impact1").html(nama);
		$("#risk_impact11").val(id);
	};
	
	function add_install_impact_more(id, nama) {
		var couse_no = document.createElement("input");
		couse_no.setAttribute('type',"hidden");
		couse_no.setAttribute('name',"risk_impact_id[]");
		couse_no.setAttribute('value',id);
		
		var t = document.createTextNode(nama);
		var couse_name = document.createElement("textarea");
		couse_name.setAttribute('class',"form-control text-left p100 risk_couse");
		couse_name.setAttribute('name',"risk_impact[]");
		couse_name.setAttribute('id',"risk_impact");
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
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
	};
	
	function remove_install(t,iddel){
		if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			var ri = t.parentNode.parentNode.rowIndex;
			t.parentNode.parentNode.parentNode.deleteRow(ri);
		}
		return false;
	}
</script>