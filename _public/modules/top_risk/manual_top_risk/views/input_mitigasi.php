<?php 
$isi_owner_no_action=json_decode($field['owner_no'], true);
$isi_owner_no_action_accountable=json_decode($field['accountable_unit'], true);

if (!$isi_owner_no_action_accountable){
	$isi_owner_no_action_accountable[] = $owner['owner_no'];
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
<div class="row" style="background-color:#f7f7f7;">
	<div class="col-sm-12">
		Detail Peristiwa Resiko <br/>
		<table class="table table-borderless">
			<tr>
				<td width="20%">Peristiwa Resiko</td>
				<td><?=$rcsa['event_name'];?></td>
			</tr>
			<tr>
				<td>Penyebab Resiko</td>
				<td><?=nl2br($rcsa['couse']);?></td>
			</tr>
			<tr>
				<td>Dapak Resiko</td>
				<td><?=nl2br($rcsa['impact']);?></td>
			</tr>
			<tr>
				<td>Inherent Risk</td>
				<td>
					Probabilitas : <strong><?=$rcsa['ket_likelihood'];?></strong><br/><br/>
					Impact : <strong><?=$rcsa['ket_impact'];?></strong>
				</td>
			</tr>
			<tr>
				<td>Inherent Analisis</td>
				<td><strong><span style="background-color:<?=$rcsa['warna'];?>;color:<?=$rcsa['warna_text'];?>;"> &nbsp;&nbsp;<?=$rcsa['inherent_analisis'];?> &nbsp;&nbsp;</span></strong></td>
			</tr>
		</table>		
	</div>
</div>
<hr>
<div class="row">
<div class="form-group clearfix">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_proaktif');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_textarea('proaktif', ($field)?$field['proaktif']:''," id='proaktif' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'").
	form_hidden(array('parent_mitigasi'=>$parent, 'id_detail_mitigasi'=>$id, 'id_edit_mitigasi'=>$id_edit))?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_reaktif');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_textarea('reaktif', ($field)?$field['reaktif']:''," id='reaktif' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'");
								
	?></div>
</div>
	
<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_pic');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_dropdown('owner_no_action[]',$cbo_owner, $isi_owner_no_action,'multiple="multiple" class="select2 form-control" style="width:100%;" id="owner_no_action"');?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_responsible_unit');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_dropdown('owner_no_action_accountable[]',$cbo_owner, $isi_owner_no_action_accountable,'multiple="multiple" class="select2 form-control" style="width:100%;" id="owner_no_action_accountable"');?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_schedule');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('schedule_no', ($field)?$field['schedule_no']:'', 'class="form-control" style="width:100%;" id="schedule_no"');?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_action_amount');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9">
		<div id="l_amount_parent" class="input-group">
			<span id="span_l_amoun" class="input-group-addon"> Rp </span>
			<?=form_input('amount', ($field)?number_format($field['amount']):'', 'class="form-control text-right rupiah" id="amount"');?>
		</div>
	</div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_target_waktu');?><sup><span class="required">*)</span></sup></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_input('target_waktu', ($field)?$field['target_waktu']:date('d-m-Y')," id='target_waktu' size='20' class='form-control datepicker' style='width:130px;'");?></div>
</div>

<div class="form-group clearfix ">
	<label class="col-sm-3 control-label text-left"><?=lang('msg_field_risk_attacment');?></label>
	<div class="col-md-9 col-sm-9 col-xs-9"><?=form_upload("attac_mitigasi","");?></div>
</div>
