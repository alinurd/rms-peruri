<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">ADD RISK LIBRARY</h4>
</div>
<div class="modal-body">
	 <?php echo form_open($this->uri->uri_string,array('id'=>'form_input_library','role'=>'form"'));?>
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li id="library_data" class="active"><a href="#tab_general" data-toggle="tab"> Data Event Library </a></li>
			<li id="library_mapping"><a href="#tab_mapping" data-toggle="tab"> Link Mapping </a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_general">
			<table class="table data" id="datatables_librari">
				<tr>
					<td style="text-align:center;width:10%;">Type</td>
					<td style="width:15%;"><strong>Event Library</strong>
					<input type="hidden" id="add_type_library" name="add_type_library" value="1">
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
						$content= form_textarea('add_description', ''," id='add_description' maxlength='500' size=200 class='form-control ' rows='2' cols='8' style='height: 103px; width: 833px ! important;'  onblur='_maxLength(this , \"$left\")' onkeyup='_maxLength(this , \"$left\")' data-role='tagsinput' ");
									
						$content .='<br/>'.lang('msg_chr_left').' <span style="display:inline-block;height:20px;"><input id="'.$left.'" type="text" align="right" class="form-control" style="text-align:right;width:60px;" disabled="" name="f1_11_char_left" value="500" size="3"></span>';
						echo $content;
						?>
					</td>
				</tr>
			</table>
		</div>
		<div class="tab-pane" id="tab_mapping">
			<?php echo $cause;?>
			<?php echo $impact;?>
		</div>
		<div class="text-center">
		<button value="save" type="button" class="btn btn-primary text-center" id="proses_quit"  style="margin-right:25px;" title="Save & Quit" ><i class="fa fa-save"></i> S a v e </button>
		<button value="cancel" type="button" class="add btn btn-warning btn-sm btn-grad  text-center" title="Cancel" id="proses_close"><i class="fa fa-save"></i> Cancel </button>
		</div>			
	</div>	
	<?php echo form_close();?>	
</div>

<div class="overlay hide" id="overlay_library">
	<i class="fa fa-refresh fa-spin"></i>
</div>

<script type="text/javascript">
	$("#proses_quit, #proses_close").click(function(){
		loading(true,'overlay_library');
		var url='<?php echo base_url("rcsa/save-add-library-event");?>';
		var mode=$(this).val();
		var form = $('form').serialize() + "&mode=" + mode ;
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			dataType:'json',
			success: function(msg){
				loading(false,'overlay_library');
				if (mode=='save')
					pesan_toastr(Globals.success_process,"info","Admin","toast-top-center");
				pilih(msg.id, msg.name);
			},
			failed: function(msg){
				loading(false,'overlay_library');
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
			error: function(msg){
				loading(false,'overlay_library');
				pesan_toastr(Globals.failed_process,"err","Admin","toast-top-center");
			},
		});
	});
	
	function pilih(id, name){
		add_install_event(id, name);
		$('#id_tambah_data_target').modal('hide');
	};
</script>