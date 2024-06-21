<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title"><?php echo strtoupper(lang('msg_field_risk_event'));?></h4>
</div>
<div class="modal-body">
	<div id="konten_event">
	<div class="well">
		<strong><?php echo lang('msg_field_ket_add_event');?></strong>
		<span class="pull-right"  style="margin-top:-6px !important;"><button class="btn btn-danger btn-flat" id="add_event"> <?php echo lang('msg_field_tbl_add_event');?> </button>
	</div>
		<div class="row form-horizontal bg-success">
			<div class="form-group pull-right" style="margin-right:15px;">
				<label class="col-xs-12 control-label">Category : 
				<?=form_dropdown('cbo_risk_type', $risk_type, '',"class='form-control' style='width:40px;display:inline;' id='cbo_risk_type' ");?></label>
			</div>
		</div>
		<div id="list_event">
		<table class="table data" id="datatables_event">
			<thead>
				<tr>
				<th width="10%" style="text-align:center;">No.</th>
				<th width="15%" ><?php echo lang('msg_field_pop_risk_event_type');?></th>
				<th width="60%" ><?php echo lang('msg_field_pop_event_description_library');?></th>
				<th width="10%" ><?php echo lang('msg_tbl_select');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				foreach($field['field'] as $key=>$row)
				{ 
					$value_chek=$row->id."#".$row->code.' - '.$row->description;
					?>
					<tr class="pilih_event" style="cursor:pointer;" value="<?php echo $value_chek;?>" data-dismiss="modal">
						<td style="text-align:center;width:10%;"><?php echo $i;?></td>
						<td style="width:15%;"><?php echo $row->type;?></td>
						<td style="width:80%;text-align: justify;"><?php echo $row->description;?></td>
						<td style="text-align:center;width:10%;"><span class="btn btn-info pilih_event" value="<?php echo $value_chek;?>" data-dismiss="modal"> <?php echo lang('msg_tbl_select');?></span></td>
					</tr>
				<?php 
					++$i;
				}
				?>
			</tbody>
		</table>
		</div>
		</div>
	<div class="overlay hide" id="overlay_content_event">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal" id="btn_close"><?php echo lang('msg_tbl_close');?></button>
  </div>

<script type="text/javascript">
	$(document).on("click",".pilih_event",function(){
		var jml_pil=0;
		var nil='';
		nil=$(this).attr('value');
		var data=nil.split('#');
		add_install_event(data[0], data[1]);
	});
	loadTable('', 0, 'datatables_event');
	
	$("#add_event").click(function(){
		var url='<?php echo base_url("project/add-library-event");?>';
		form='';
		$("#btn_close").addClass("hide");
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
	});
	
	$("#cbo_risk_type").change(function(){
		var url='<?php echo base_url("ajax/list-libray-ajax/1");?>';
		form={'id':$(this).val()};
		$("#btn_close").addClass("hide");
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			success: function(msg){
				$('#list_event').html(msg);
			},
			failed: function(msg){
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
		});
	})
	
	
</script>