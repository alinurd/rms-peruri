<?php
	$title=array('','');
	$subtitle=array('','');
	$date=array('','','');
	$sign=array('','','');
	
	if (isset($field['param'])){
		if (array_key_exists('title_sts',$field['param'])){
			if ($field['param']['title_sts']=="default"){
				$title[0]=' checked ';
			}elseif ($field['param']['title_sts']=="custom"){
				$title[1]=' checked ';
			}
		}
		
		if (array_key_exists('subtitle_sts',$field['param'])){
			if ($field['param']['subtitle_sts']=="default"){
				$subtitle[0]=' checked ';
			}elseif ($field['param']['subtitle_sts']=="custom"){
				$subtitle[1]=' checked ';
			}
		}
		
		if (array_key_exists('date_sts',$field['param'])){
			if ($field['param']['date_sts']=="default"){
				$date[0]=' checked ';
			}elseif ($field['param']['date_sts']=="custom"){
				$date[1]=' checked ';
			}elseif ($field['param']['date_sts']=="none"){
				$date[2]=' checked ';
			}
		}
		
		if (array_key_exists('sign_sts',$field['param'])){
			if ($field['param']['sign_sts']=="default"){
				$sign[0]=' checked ';
			}elseif ($field['param']['sign_sts']=="custom"){
				$sign[1]=' checked ';
			}elseif ($field['param']['sign_sts']=="none"){
				$sign[2]=' checked ';
			}
		}
	}
?>	
<table class="table personal-task">
	<tbody>
		<tr>
			<td rowspan="2" width="10%"><?php echo lang('msg_field_report_title');?></td>
			<td class="no-padding"  style="width:10%;">
				<div class="checkbox"><label><input type="radio" name="title_sts" value="default" <?php echo $title[0];?>> <?php echo lang('msg_field_default');?></label></div>
			</td>
			<td style="width:3%;">:</td>
			<td>
				<input name="title_default" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['title_default']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="title_sts" value="custom" <?php echo $title[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
			<td>:</td>
			<td>
				<input name="title_custom" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['title_custom']:"";?>"></td>
		</tr>
		<tr>
			<td rowspan="2"><?php echo lang('msg_field_sub_title');?></td>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="subtitle_sts" value="default" <?php echo $subtitle[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
			<td>:</td>
			<td><input name="subtitle_default" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['subtitle_default']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="subtitle_sts" value="custom" <?php echo $subtitle[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
			<td>:</td>
			<td><input name="subtitle_custom" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['subtitle_custom']:"";?>"></td>
		</tr>
		<tr>
			<td rowspan="3"><?php echo lang('msg_field_date');?></td>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="default" <?php echo $date[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
			<td>:</td>
			<td><input name="date_default" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['date_default']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="custom" <?php echo $date[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
			<td>:</td>
			<td><input name="date_custom" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['date_custom']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="date_sts" value="none" <?php echo $date[2];?>> None</label></div></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td rowspan="3"><?php echo lang('msg_field_sign');?></td>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="default" <?php echo $sign[0];?>> <?php echo lang('msg_field_default');?></label></div></td>
			<td>:</td>
			<td><input name="sign_default" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['sign_default']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="custom" <?php echo $sign[1];?>> <?php echo lang('msg_field_custom');?></label></div></td>
			<td>:</td>
			<td>
				<input name="sign_custom" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['sign_custom']:"";?>"><br/>
				<input name="sign_position" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['sign_position']:"";?>"></td>
		</tr>
		<tr>
			<td class="no-padding" ><div class="checkbox"><label><input type="radio" name="sign_sts" value="none" <?php echo $sign[2];?>> None</label></div></td>
			<td>:</td>
			<td>&nbsp;</td>
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
	
</script>