<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title">ADD RISK LIBRARY</h4>
</div>
<div class="modal-body">
	<?php echo form_open($this->uri->uri_string,array('id'=>'form_input_library','role'=>'form"'));?>
	<table class="table data" id="datatables_librari">
		<tr>
			<td style="text-align:center;width:10%;">Type</td>
			<td style="width:15%;"><?php echo  form_dropdown('add_type_library', array(1=>'Event Library', 2=>'Cause Library', 3=>'Impact Library'), 1,"id='add_type_library' class='form-control' style='width:100%;'");?></td>
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
		<tr>
			<td class="text-center" colspan="2">
				 <button value="quit" type="button" class="btn btn-primary text-center" id="proses_quit"  style="margin-right:25px;" title="Save & Quit" ><i class="fa fa-save"></i> Save & Quit </button>
				<button value="add" type="button" class="add btn btn-warning btn-sm btn-grad  text-center" title="Save & New" id="proses_add"><i class="fa fa-save"></i> Save & New </button>
			</td>
		</tr>
	</table>
	<?php echo form_close();?>	
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<div class="overlay hide" id="overlay_library">
	<i class="fa fa-refresh fa-spin"></i>
</div>

<script type="text/javascript">
	$("#proses_quit, #proses_add").click(function(){
		loading(true,'overlay_library');
		var url='<?php echo base_url("rcsa/save-add-library");?>';
		nil=$(this).val();
		// type=$("#add_type_library").val();
		// category=$("#add_risk_type").val();
		// ket=$("#add_description").val();
		// var form = {'type':type,'category':category,'ket':ket};
		var form = $('form').serialize();
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			success: function(msg){
				loading(false,'overlay_library');
				if (nil=="quit"){
					$("#id_tambah_data_target").modal('hide');
				}else{
					$("#add_type_library").val(0);
					$("#add_risk_type").val(0);
					$("#add_description").val('');
				}
				pesan_toastr(Globals.success_process,"info","Admin","toast-top-center");
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
</script>