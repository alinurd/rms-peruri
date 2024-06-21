<?php
	$sts_risk_event='';
	$sts_risk_couse='';
	$sts_risk_impact='';
	$sts_risk_type='';
	$sts_risk_owner='';
	$sts_risk_level='';
	$sts_nilai_dampak='';
	$sts_risk_controls='';
	$sts_residual_risk_level='';
	$sts_action='';
	$sts_progress='';
	
	if (isset($field['param'])){
		if (array_key_exists('sts_risk_event',$field['param'])){
			if ($field['param']['sts_risk_event']==1){$sts_risk_event=' checked ';}
		}
		if (array_key_exists('sts_risk_couse',$field['param'])){
			if ($field['param']['sts_risk_couse']==1){$sts_risk_couse=' checked ';}
		}
		if (array_key_exists('sts_risk_impact',$field['param'])){
			if ($field['param']['sts_risk_impact']==1){$sts_risk_impact=' checked ';}
		}
		if (array_key_exists('sts_risk_type',$field['param'])){
			if ($field['param']['sts_risk_type']==1){$sts_risk_type=' checked ';}
		}
		if (array_key_exists('sts_risk_owner',$field['param'])){
			if ($field['param']['sts_risk_owner']==1){$sts_risk_owner=' checked ';}
		}
		if (array_key_exists('sts_risk_level',$field['param'])){
			if ($field['param']['sts_risk_level']==1){$sts_risk_level=' checked ';}
		}
		if (array_key_exists('sts_nilai_dampak',$field['param'])){
			if ($field['param']['sts_nilai_dampak']==1){$sts_nilai_dampak=' checked ';}
		}
		if (array_key_exists('sts_risk_controls',$field['param'])){
			if ($field['param']['sts_risk_controls']==1){$sts_risk_controls=' checked ';}
		}
		if (array_key_exists('sts_residual_risk_level',$field['param'])){
			if ($field['param']['sts_residual_risk_level']==1){$sts_residual_risk_level=' checked ';}
		}
		if (array_key_exists('sts_action',$field['param'])){
			if ($field['param']['sts_action']==1){$sts_action=' checked ';}
		}
		if (array_key_exists('sts_progress',$field['param'])){
			if ($field['param']['sts_progress']==1){$sts_progress=' checked ';}
		}
	}
	
	$ketsave=lang('msg_tbl_simpan');
?>	

<table class="table personal-task">
<tbody>
	<tr>
		<td colspan="3"><?php echo lang('msg_field_information');?></td>
	</tr>
	<tr>
		<td width="20%" class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_event" value="0">
					<input type="checkbox" name="sts_risk_event" value="1" <?php echo $sts_risk_event;?>>&nbsp; <?php echo lang('msg_field_risk_event');?>
				</label>
			</div>
		</td>
		<td width="3%">:</td>
		<td width="77%">
			<input name="risk_event" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_event']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_couse" value="0">
					<input type="checkbox" name="sts_risk_couse" value="1" <?php echo $sts_risk_couse;?>>&nbsp; <?php echo lang('msg_field_risk_couse');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_couse" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_couse']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_impact" value="0">
					<input type="checkbox" name="sts_risk_impact" value="1" <?php echo $sts_risk_impact;?>>&nbsp; <?php echo lang('msg_field_risk_impact');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_impact" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_impact']:"";?>">
		</td>
	</tr>
	<tr class="hide">
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_type" value="0">
					<input type="checkbox" name="sts_risk_type" value="1" <?php echo $sts_risk_type;?>>&nbsp; <?php echo lang('msg_field_risk_type');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_type" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_type']:"";?>">
		</td>
	</tr>
	<tr class="hide">
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_owner" value="0">
					<input type="checkbox" name="sts_risk_owner" value="1" <?php echo $sts_risk_owner;?>>&nbsp; <?php echo lang('msg_field_risk_owner');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_owner" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_owner']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_level" value="0">
					<input type="checkbox" name="sts_risk_level" value="1" <?php echo $sts_risk_level;?>>&nbsp; <?php echo lang('msg_field_inherent_level');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_level" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_level']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_nilai_dampak" value="0">
					<input type="checkbox" name="sts_nilai_dampak" value="1" <?php echo $sts_nilai_dampak;?>>&nbsp; <?php echo lang('msg_field_nilai_dampak');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="nilai_dampak" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['nilai_dampak']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_risk_controls" value="0">
					<input type="checkbox" name="sts_risk_controls" value="1" <?php echo $sts_risk_controls;?>>&nbsp; <?php echo lang('msg_field_internal_control');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="risk_controls" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['risk_controls']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_residual_risk_level" value="0">
					<input type="checkbox" name="sts_residual_risk_level" value="1" <?php echo $sts_residual_risk_level;?>>&nbsp; <?php echo lang('msg_field_residual_level');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="residual_risk_level" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['residual_risk_level']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_action" value="0">
					<input type="checkbox" name="sts_action" value="1" <?php echo $sts_action;?>>&nbsp; <?php echo lang('msg_field_detail');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="action" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['action']:"";?>">
		</td>
	</tr>
	<tr>
		<td class="no-padding" >
			<div class="checkbox">
				<label>
					<input type="hidden" name="sts_progress" value="0">
					<input type="checkbox" name="sts_progress" value="1" <?php echo $sts_progress;?>>&nbsp; <?php echo lang('msg_field_progress');?>
				</label>
			</div>
		</td>
		<td>:</td>
		<td>
			<input name="progress" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['progress']:"";?>">
		</td>
	</tr>
</tbody>
</table>
<table class="table">
	<tbody>
		<tr>
			<td width="20%" style="vertical-align:middle;"><?php echo lang('msg_field_title');?></td>
			<td width="3%" >:</td>
			<td width="77%">
				<input name="title" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['title']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_sub_title');?></td>
			<td>:</td>
			<td >
				<input name="subtitle" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['subtitle']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_person_name');?></td>
			<td>:</td>
			<td >
				<input name="person_name" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['person_name']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_position');?></td>
			<td>:</td>
			<td >
				<input name="position" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['position']:"";?>">
			</td>
		</tr>
	</tbody>
</table>
<script>
	$("#l_type_project_no, #l_owner_no, #l_periode_no").change(function(){
		var type_dash = $("#l_type_project_no").val();
		var id_owner = $("#l_owner_no").val();
		var id_period = $("#l_periode_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		$("button#btn-search").addClass('disabled');
		cari_ajax_combo(id, 'spinner_param', 'l_rcsa_no', 'ajax/get_project_name');
	});
	
	$("#l_type_view_no").change(function(){
		nil=$(this).val();
		if (nil==0){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").attr('disabled', true);
		}else if (nil==1){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled');
		}else if (nil==2){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled').attr('disabled', true);
		}else{
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled');
		}
	})
</script>