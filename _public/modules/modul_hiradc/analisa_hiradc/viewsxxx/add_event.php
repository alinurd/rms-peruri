<header class="panel-heading tab-bg-dark-navy-blue ">
  <ul class="nav nav-tabs">
	  <li class="active">
		  <a data-toggle="tab" href="#home"><?php echo lang('msg_field_tab1');?></a>
	  </li>
	  <li>
		<a data-toggle="tab" href="#register" id="tab_register"><?php echo lang('msg_field_tab4');?></a>
	</li>
  </ul>
</header>
<div class="panel-body">
  <div class="tab-content">
	  <div id="home" class="tab-pane active">
		 <?php  
			echo form_open_multipart(base_url('rcsa/save_detail'),array('id'=>'form_input'));
		?>
			<input type="hidden" name="id_rcsa" value="<?php echo $id_rcsa;?>">
			<input type="hidden" name="id_event_detail" value="<?php echo $id_event_detail;?>">
			<div id="content_detail">
				<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0" id="table-add-event">
					<tbody>
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_event');?>
							</td>
							<td class=" no-border">
								<div class="input-group w100">
								<?php 
									echo form_textarea("risk_event", ""," class='form-control text-left' rows='2' cols='5' readonly='' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
								?>
									<input type="hidden" name="risk_event_id" id="risk_event_id">
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
									</tbody>
								</table>
							</td>
						</tr>
						
						<tr>
							<td class="row-title no-border">
								<sup><span class="required"> *) </span></sup>
								<?php echo lang('msg_field_risk_attacment');?>
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
												<button type='button' class='btn btn-primary btn-flat' id='browse_att'><i class="fa fa-plus"></i></button>
												<button type='button' class='btn btn-primary btn-flat' id='clear_att'><i class="fa fa-cut"></i></button>
											</td>
										</tr>
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
				<div class="box-body well">
					<button class="btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
					<i class="fa fa-floppy-o"></i>
					<?php echo lang('msg_tbl_simpan');?>
					</button>
					<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('rcsa/risk-event/'.$id_rcsa);?>" >
						<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_add');?>
					</a>
					<button class="btn btn-danger btn-flat pull-right" data-content="Add Library" data-toggle="popover" name="l_add_library" id="l_add_library" value="Add Library " type="button"><i class="fa fa-envelope"></i>
					<?php echo lang('msg_tbl_add_library');?>
					</button>
				</div>
			</div>
			<?php echo form_close();?>
	  </div>
  </div>
  <div id="loading" class="loading-img hide"></div>
</div>


<script>
	var nil_couse=1;
	var nil_impact=1;
	$('#browse_couse').attr('disabled', true);
	$('#browse_couse_more').attr('disabled', true);
	$('#browse_impact').attr('disabled', true);
	$('#browse_impact_more').attr('disabled', true);
		
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
	
	$("table#table-add-event").on('click','.browse_couse',function(){
		var jml=$(this).attr('nil');
		var nil = 'couse'; 
		var tbl='instlmt_couse';
		get_data(nil, tbl, jml);
	});
	
	$("#browse_couse_more").click(function(){
		add_install_couse_more();
	});
	
	$("table#table-add-event").on('click','.browse_impact',function(){
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
	
	function get_data(nil, tblx, count){
		var url='<?php echo base_url("rcsa/get_data_source");?>';
		var parent= $("#risk_event_id").val();
		if (nil!=='event' && parent.length==0){
			pesan_toastr("Event Belum dipilih","err","Admin","toast-top-center");
			return false;
		}
		loading(true,'overlay_content');
		var form = {'idmodal':nil,'tbl':tblx,'jml':count, 'parent':parent};
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				// $("#loading").addClass('hide');
				loading(false,'overlay_content');
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				loading(false,'overlay_content');
				// $("#loading").addClass('hide');
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				loading(false,'overlay_content');
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
		});
	}
	
	$("#l_add_library").click(function(){		
		loading(true,'overlay_content');
		var url='<?php echo base_url("rcsa/add-library");?>';
		form='';
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				loading(false,'overlay_content');
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				loading(false,'overlay_content');
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				loading(false,'overlay_content');
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
	
	function add_install_event(id, nama) {
		$("#risk_event").val(nama);
		$("#risk_event_id").val(id);
		
		$('#browse_couse').removeAttr('disabled');
		// $('#browse_couse_more').removeAttr('disabled');
		$('#browse_impact').removeAttr('disabled');
		// $('#browse_impact_more').removeAttr('disabled');
	};
	
	function add_install_couse(id, nama, jml) {
		$("textarea#risk_couse_"+jml).html(nama);
		$("#risk_couse_id_"+jml).val(id);
		$('#browse_couse_more').removeAttr('disabled');
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
		$('#browse_impact_more').removeAttr('disabled');
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
		if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			var ri = t.parentNode.parentNode.rowIndex;
			t.parentNode.parentNode.parentNode.deleteRow(ri);
		}
		return false;
	}
	
	$('.nav-tabs > li > a').bind('click', function (e) {
		var x = $(this).attr('href');
		if (x=="#register"){
			return false;
		}
	});
	$("#tab_register").click(function(){
		var url='<?php echo base_url("rcsa/get-data-risk-register");?>';
		var nil='<?php echo $id_rcsa;?>';
		var form = {'id-rcsa':nil};
		loading(true,'overlay_content');
		$.ajax({
			type: "GET",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				loading(false,'overlay_content');
				$('#id_tambah_data_target').modal('show');
				
			},
			failed: function(msg){
				loading(false,'overlay_content');
				alert("gagal");
			},
			error: function(msg){
				loading(false,'overlay_content');
				alert("gagal");
			},
		});
	})
	
</script>