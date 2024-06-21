<?php
	$readonly = '';
	if ($tingkat_no==6 || $tingkat_no==7){
		$readonly = ' readonly="readonly" ';
	}
?>
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
<div class="form-group clearfix hide">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_operasi');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('operasional',($field)?$field['operasional']:'', 'class="form-control"  id="operasional"');
	echo form_hidden(array('parent_mitigasi'=>$parent, 'id_detail_mitigasi'=>$id, 'id_edit_mitigasi'=>$id_edit))?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_sekarang');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_textarea('sekarang', ($field)?$field['sekarang']:''," id='sekarang' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
								
	?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_mendatang');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_textarea('mendatang', ($field)?$field['sekarang']:''," id='mendatang' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'")?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_tgl_mulai');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('tgl_mulai', ($field)?$field['tgl_mulai']:''," id='tgl_mulai' size='20' class='form-control datepicker' style='width:130px;'");?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_tgl_selesai');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('tgl_selesai', ($field)?$field['tgl_selesai']:''," id='tgl_selesai' size='20' class='form-control datepicker' style='width:130px;'");?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_faktor');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=$faktor?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_mitigasi_program');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=$cboProgram?></div>
</div>
