<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title"><?php echo strtoupper(lang('msg_field_risk_couse'));?></h4>
</div>
<div class="modal-body">
	<div class="well">
		<strong><?php echo lang('msg_field_risk_event');?> : <?php echo $field['title']->description;?></strong><br/>
		<em><?php echo lang('msg_field_ket_add_cause');?></em>
		<span class="pull-right"  style="margin-top:-6px !important;"><button class="btn btn-danger btn-flat" id="add_event"> <?php echo lang('msg_field_tbl_add_cause');?> </button>
	</div>
	<table class="table" id="datatables_course">
		<thead>
			<tr>
			<th width="10%" style="text-align:center;">No.</th>
			<th width="15%" ><?php echo lang('msg_field_pop_risk_couse_type');?></th>
			<th width="60%" ><?php echo lang('msg_field_pop_couse_description_library');?></th>
			<th width="35%" ><?php echo lang('msg_tbl_select');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field['field'] as $key=>$row)
			{ 
				$value_chek=$row->id."#".$row->code.' - '.$row->description;
				?>
				<tr class="pilih_couse" style="cursor:pointer;" value="<?php echo $value_chek;?>" data-dismiss="modal">
					<td style="text-align:center;width:10%;"><?php echo $i;?></td>
					<td style="width:15%;"><?php echo $row->type;?></td>
					<td style="width:65%;"><?php echo $row->description;?></td>
					<td style="text-align:center;width:10%;"><span class="btn btn-info pilih_couse" value="<?php echo $value_chek;?>" data-dismiss="modal"> <?php echo lang('msg_tbl_select');?></span></td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
	</table>
	<div class="overlay hide" id="overlay_content_event">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_tbl_close');?></button>
  </div>

<script type="text/javascript">
	var jml='<?php echo $jml;?>';
	var event_no='<?php echo $field['title']->id;?>';
	
	$(".pilih_couse").click(function(){
		var jml_pil=0;
		var nil='';
		nil=$(this).attr('value');
		var data=nil.split('#');
		
		add_install_couse(data[0], data[1], jml);
	});
	loadTable('', 0, 'datatables_course');
	
	$("#add_event").click(function(){
		var url='<?php echo base_url("project/add-library-cause");?>';
		var form = {'event_no':event_no,'jml':jml};
		$("#btn_close").addClass("hide");
		$.ajax({
			type: "POST",
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
	});
</script>