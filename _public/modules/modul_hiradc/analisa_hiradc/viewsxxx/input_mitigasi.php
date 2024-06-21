<div class="row">
	<div class="col-sm-6">
		Input Mitigasi: 
	</div>
	<div class="col-sm-6">
		<span class="btn btn-default pull-right" id="closeMitigasi"> Kembali </span>
		<span class="btn btn-primary pull-right" id="saveMitigasi"> Simpan </span>
	</div>
</div>
<br/>
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_operasi');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('operasional',($field)?$field['operasional']:'', 'class="form-control"  id="operasional"');
	echo form_hidden(array('parent_mitigasi'=>$parent, 'id_detail_mitigasi'=>$id, 'id_edit_mitigasi'=>$id_edit))?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_sekarang');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('sekarang',($field)?$field['sekarang']:'', 'class="form-control" id="sekarang"')?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_mendatang');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('mendatang',($field)?$field['mendatang']:'', 'class="form-control" id="mendatang"')?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_faktor');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=$faktor?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_program');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=$cboProgram?></div>
</div>
