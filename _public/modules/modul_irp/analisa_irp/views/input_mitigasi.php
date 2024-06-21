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
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_pengendalian');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('pengendalian',($field)?$field['pengendalian']:'', 'class="form-control"  id="pengendalian"');
	echo form_hidden(array('parent_mitigasi'=>$parent, 'id_detail_mitigasi'=>$id, 'id_edit_mitigasi'=>$id_edit))?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('mitigasi_no',($field)?$field['mitigasi']:'', 'class="form-control" id="mitigasi_no"')?></div>
</div>