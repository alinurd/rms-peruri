<?php
	$sts_action_plan='';
	$sts_progress='';
	$sts_risk_detail='';
	$sts_risk_level='';
	$sts_attachment='';
	
	if (isset($field['param'])){
		if (array_key_exists('sts_action_plan',$field['param'])){
			if ($field['param']['sts_action_plan']==1){$sts_action_plan=' checked ';}
		}
		if (array_key_exists('sts_progress',$field['param'])){
			if ($field['param']['sts_progress']==1){$sts_progress=' checked ';}
		}
		if (array_key_exists('sts_risk_detail',$field['param'])){
			if ($field['param']['sts_risk_detail']==1){$sts_risk_detail=' checked ';}
		}
		if (array_key_exists('sts_risk_level',$field['param'])){
			if ($field['param']['sts_risk_level']==1){$sts_risk_level=' checked ';}
		}
		if (array_key_exists('sts_attachment',$field['param'])){
			if ($field['param']['sts_attachment']==1){$sts_attachment=' checked ';}
		}
	}
	$ketsave=lang('msg_tbl_simpan');
	
?>	

<table class="table">
	<tbody>
		<tr>
			<td><?php echo lang('msg_field_information');?></td>
			<td style="width:60%;">#</td>
		</tr>
		<tr>
			<td class="no-padding" >
				<div class="checkbox">
					<label>
						<input type="hidden" name="sts_action_plan" value="0">
						<input type="checkbox" name="sts_action_plan" value="1" <?php echo $sts_action_plan;?>>&nbsp; <?php echo lang('msg_field_plan_detail');?>
					</label>
				</div>
			</td>
			<td style="width:60%;">
				&nbsp;
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
			<td style="width:60%;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="no-padding" >
				<div class="checkbox">
					<label>
						<input type="hidden" name="sts_risk_detail" value="0">
						<input type="checkbox" name="sts_risk_detail" value="1" <?php echo $sts_risk_detail;?>>&nbsp; <?php echo lang('msg_field_risk_detail');?>
					</label>
				</div>
			</td>
			<td style="width:60%;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="no-padding" >
				<div class="checkbox">
					<label>
						<input type="hidden" name="sts_risk_level" value="0">
						<input type="checkbox" name="sts_risk_level" value="1" <?php echo $sts_risk_level;?>>&nbsp; <?php echo lang('msg_field_risk_level');?>
					</label>
				</div>
			</td>
			<td style="width:60%;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="no-padding" >
				<div class="checkbox">
					<label>
						<input type="hidden" name="sts_attachment" value="0">
						<input type="checkbox" name="sts_attachment" value="1" <?php echo $sts_attachment;?>>&nbsp; <?php echo lang('msg_field_attachment');?>
					</label>
				</div>
			</td>
			<td style="width:60%;">
				&nbsp;
			</td>
		</tr>
	</tbody>
</table>
<table class="table">
	<tbody>
		<tr>
			<td width="20%" style="vertical-align:middle;"><?php echo lang('msg_field_title');?></td>
			<td width="3%">:</td>
			<td width="77%">
				<input name="title" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['title']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_sub_title');?></td>
			<td width="3%">:</td>
			<td >
				<input name="subtitle" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['subtitle']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_person_name');?></td>
			<td width="3%">:</td>
			<td >
				<input name="person_name" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['person_name']:"";?>">
			</td>
		</tr>
		<tr>
			<td  style="vertical-align:middle;"><?php echo lang('msg_field_position');?></td>
			<td width="3%">:</td>
			<td >
				<input name="position" type="text" class="form-control p100" value="<?php echo (isset($field['param'])) ? $field['param']['position']:"";?>">
			</td>
		</tr>
	</tbody>
</table>