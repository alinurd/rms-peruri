<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">ADD RISK CAUSE LIBRARY</h4>
</div>
<div class="modal-body box">
	<br/>
	<div class="well">
		<em><?php echo lang('msg_field_risk_event');?> </em>: <strong><?php echo ($title)?$title->description:'';?></strong>
	</div>
	<ul class="nav nav-tabs">
		<li>
			<a data-toggle="tab" href="#new_couse">Add New Couse</a>
		</li>
		<li class="active">
			<a data-toggle="tab" href="#get_exist_couse">Get From Database</a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="new_couse" class="tab-pane">
			<br/>
			<?php echo form_open($this->uri->uri_string,array('id'=>'form_input_library','role'=>'form"'));?>
			<table class="table data" id="datatables_librari">
				<tr>
					<td style="text-align:center;width:10%;">Type</td>
					<td style="width:15%;"><strong>CAUSE Library</strong>
					<input type="hidden" id="add_type_library" name="add_type_library" value="2">
					<input type="hidden" id="add_event_no" name="add_event_no" value="<?php echo $event_no;?>">
					<input type="hidden" id="jml" name="jml" value="<?php echo $jml;?>">
					</td>
				</tr>
				<tr>
					<td style="text-align:center;width:10%;">Category</td>
					<td style="width:15%;"><?php echo  form_dropdown('add_risk_type', $cbo, 0,"id='add_risk_type' class='form-control' style='width:100%;'");?></td>
				</tr>
				<tr>
					<td style="text-align:center;width:10%;">Description</td>
					<td style="width:15%;"><?php   
						$left='id_sisa_nya';
						$content= form_textarea('add_description', ''," id='add_description' maxlength='500' size=200 class='form-control ' rows='2' cols='8' style='height: 103px; width: 100% ! important;'  onblur='_maxLength(this , \"$left\")' onkeyup='_maxLength(this , \"$left\")' data-role='tagsinput' ");
									
						$content .='<br/>'.lang('msg_chr_left').' <span style="display:inline-block;height:20px;"><input id="'.$left.'" type="text" align="right" class="form-control" style="text-align:right;width:60px;" disabled="" name="f1_11_char_left" value="500" size="3"></span>';
						echo $content;
						?>
					</td>
				</tr>
			</table>
			<div class="text-center">
				<button value="save" type="button" class="btn btn-primary text-center" id="proses_quit" idtbl="form_input_library"  style="margin-right:25px;" title="Save & Quit" ><i class="fa fa-save"></i> S a v e </button>
				<button value="cancel" type="button" class="add btn btn-warning btn-sm btn-grad  text-center" idtbl="form_input_library" title="Cancel" id="proses_close"><i class="fa fa-save"></i> Cancel </button>
			</div>	
			<?php echo form_close();?>			
		</div>	
		<div id="get_exist_couse" class="tab-pane active">		
			<?php echo form_open($this->uri->uri_string,array('id'=>'form_input_library_db','role'=>'form"'));?>
			<?php echo $cause;?>
			<input type="hidden" id="add_type_library" name="add_type_library" value="2">
			<input type="hidden" id="add_event_no" name="add_event_no" value="<?php echo $event_no;?>">
			<input type="hidden" id="jml" name="jml" value="<?php echo $jml;?>">
			<div class="text-center">
				<button value="save_db" type="button" class="btn btn-primary text-center" id="proses_quit_db" idtbl="form_input_library_db"  style="margin-right:25px;" title="Save & Quit" ><i class="fa fa-save"></i> S a v e </button>
				<button value="cancel"  idtbl="form_input_library_db" type="button" class="add btn btn-warning btn-sm btn-grad  text-center" title="Cancel" id="proses_close_db"><i class="fa fa-save"></i> Cancel </button>
			</div>		
			<?php echo form_close();?>	
		</div>			
	</div>
	<div class="overlay hide" id="overlay_library">
		<i class="fa fa-refresh fa-spin"></i>
	</div>	
</div>	

<script type="text/javascript">
	$("#proses_quit, #proses_close,#proses_quit_db, #proses_close_db").click(function(){
		var url='<?php echo base_url("project/save-add-library-cause");?>';
		var mode=$(this).val();
		var id_tbl=$(this).attr('idtbl');
		var form = $('form#'+id_tbl).serialize() + "&mode=" + mode ;
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			success: function(msg){
				$('#id_tambah_data_target').find('.modal-content').html(msg);
				$('#id_tambah_data_target').modal('show');
				if (mode=='save')
					pesan_toastr(Globals.success_process,"info","Admin","toast-top-center");
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