<?php
	$data=$field;
	// Doi::dump($data);
	
echo form_open_multipart(base_url('rcsa/save_action'),array('name'=>'form_action','id'=>'form_input_action','class'=>'form-inline'));?>
<input type="hidden" name="id_rcsa_action" value="<?php echo $id_rcsa;?>">
<input type="hidden" name="id_rcsa_detail_action" value="<?php echo $id_event_detail;?>">
<input type="hidden" name="id_event_detail_action" value="<?php echo $id_event_action;?>">
<div id="content_detail">
	<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0" id="tbl_action">
		<tbody>
			<!-- risk treatment option -->
			<tr>
				<td width="25%" class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_treatment_option');?></strong>
				</td>
				<td class="no-border vcenter">
					<!-- <input type="text" class="form-control p100" name="title" id="title" value="<?php echo $data['title'];?>"/> -->
					<input type="radio" name="reaktif" value="reaktif" checked> Reaktif &nbsp;&nbsp;
					<input type="radio" name="proaktif" value="proaktif" > Proaktif
				</td>
			</tr>
			<!-- mitigation -->
			<tr>
				<td width="25%" class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_action_plan_title');?></strong>
				</td>
				<td class="no-border vcenter">
					<input type="text" class="form-control p100" name="title" id="title" value="<?php echo $data['title'];?>"/>
				</td>
			</tr>

			<tr class="hide">
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_description');?></strong>
				</td>
				<td class="no-border vcenter">
					<textarea type="text" class="form-control p100" name="description" id="description"><?php echo $data['description'];?></textarea>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_details');?></strong>
				</td>
				<td class="no-border">
					<textarea type="text" class="form-control p100" name="schedule_detail" id="schedule_detail"><?php echo $data['schedule_detail'];?></textarea>
				</td>
			</tr>
			<!-- Cost -->
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_action_amount');?></strong>
				</td>
				<td class="no-border vcenter">
					<?php echo form_input('amount', number_format(floatval($data['amount'])),'class="form-control text-right rupiah"');?>
				</td>
			</tr>
			<!-- Accounttbl Unit -->
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_pic');?></strong>
				</td>
				<td class="no-border vcenter">
					<?php 
						$isi_owner='';
						if (is_array($data['owner_no']))
							$isi_owner = $data['owner_no'];
						echo form_dropdown('owner_no_action[]',$cbo_owner, $isi_owner,'multiple="multiple" class="select3  form-control p100"');?>
				</td>
			</tr>
			<!-- resource -->
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_schedule');?></strong>
				</td>
				<!-- <td class="no-border vcenter">
					<?php echo form_dropdown('schedule_no',$cbo_schedule, $data['schedule_no'],'class="form-control"');?>
				</td> -->
				<td class="no-border vcenter">
					<input type="text" class="form-control p100" name="schedule_no" id="schedule_no" value="<?php echo $data['schedule_no'];?>"/>
				</td>
			</tr>
			<!-- deadline -->
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_target_waktu');?></strong>
				</td>
				<td class="no-border vcenter">
					<?php echo form_input('target_waktu',$data['target_waktu']," id='target_waktu' size='20' class='form-control datepicker' style='width:130px;' ");;?>
				</td>
			</tr>
			<!-- Attachment -->
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_risk_attacment');?></strong>
				</td>
				<td class="no-border vcenter">
					<?php if (!empty($data['attc'])){
						echo '<input type="hidden" name="id_attachment" value="'.$data['attc'].'">';
						
						echo ' <div class="alert alert-info fade in" id="attachment1">
                                  <button data-dismiss="alert" class="close close-sm" type="button">
                                      <i class="fa fa-times"></i>
                                  </button>
                                  <strong><a target="_blank" href="'.base_url('rcsa/get-download-file/'.$data['attc']).'">'.$data['attc'].'</a></stong>
							   </div>';
						
						echo '<div class="hide" id="attachment2">'.form_upload("attac","").'<div>';
					}else{
						echo '<input type="hidden" name="id_attachment" value="">';
						echo form_upload("attac","");
					}
					?>
					
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<div class="box-body">
		<button class="save btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
		<i class="fa fa-floppy-o"></i>
		Save
		</button>
		<?php 
		if (!empty($id_event_action)){
		?>	
		<span class="delete btn btn-warning btn-flat" data-content="Remove Data Event Detail" data-toggle="popover" url="<?php echo base_url('rcsa/delete-action/'.$id_rcsa.'/'.$id_event_detail.'/'.$id_event_action);?>">
			<i class="fa fa-cut"></i> <?php echo lang('msg_tbl_del');?>
		</span>
		<?php } ?>
		<span class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" id="add_action" value="0">
			<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_add');?>
		</span>
		<a class="add btn btn-success btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('rcsa/risk-event/'.$id_rcsa.'/'.$id_event_detail);?>" >
			<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_back_to_list');?>
		</a>
	</div>
</div>

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_del_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo lang('msg_del_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_batal');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm_del"><?php echo lang('msg_del_hapus');?></button>
      </div>
    </div>
  </div>
</div>
<?php echo form_close();?>
<?php
$owner_name = form_dropdown('owner_no_action[]',$cbo_owner, '','class="select3 form-control p100"');
?>

<script type="text/javascript">
	$("#add_action").click(function(){
		var nil=$(this).attr("value");
		var url='<?php echo base_url("rcsa/get_input_action");?>';
		var rcsa='<?php echo $id_rcsa;?>';
		var event_detail='<?php echo $id_event_detail;?>';
		
		var form={'id':nil,'rcsa':rcsa,'event_detail':event_detail};
		loading(true,'overlay_content');
		$.ajax({
			type: "GET",
			url: url,
			data:form,
			success: function(msg){
				loading(false,'overlay_content');
				$('td#content_action').html(msg);
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
	});
	
	$("#attachment1").click(function(){
		$("#attachment2").removeClass("hide");
		// $(this).addClass("hide");
		$("#id_attachment").val("");
	});
	
	$("span.delete").on("click", null, function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm_del').on('click', function(){
			window.location.href=url;
		});
    });
	
		$('.rupiah').change(function(event){
			var jml=$(this).val().replace(/,/g,"")
			var nilai=parseInt(jml);
			var value=accounting.formatMoney(nilai);
			$(this).val(value);
		});
		$("#target_waktu").datetimepicker({
			lang:'id',
			timepicker:false,
			format:'d-m-Y',
			closeOnDateSelect:true,
			validateOnBlur:true
		});
	
	$("#browse_owner_action").click(function(){
		var cbox='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$owner_name));?>';
		
		var theTable= document.getElementById("instlmt_action_owner");
		var rl = theTable.tBodies[0].rows.length;
		
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		var td1 =document.createElement("TD");
		td1.setAttribute("style","width:10%;");
		td1.setAttribute("class","no-padding-left no-border padding-5");
		var td2 =document.createElement("TD");
		td2.setAttribute("width","82%");
		td2.setAttribute("class","no-padding-left no-border padding-5");
		td2.setAttribute("style","text-align:center;");
		
		++rl;
		td1.innerHTML=cbox;
		td2.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		theTable.tBodies[0].insertBefore(tr , lastRow);
		$(".select3").select2({
		allowClear: false,
		placeholder: " - Select - ",
		width:'100%'
	});
	});
	
	function remove_install_action(t,iddel){
		if(confirm(Globals.tips_delete_confirm)){
			var ri = t.parentNode.parentNode.rowIndex;
			t.parentNode.parentNode.parentNode.deleteRow(ri);
		}
		return false;
	}
	
	$(".select3").select2({
		allowClear: false,
		placeholder: " - Select - ",
		width:'100%'
	});
</script>