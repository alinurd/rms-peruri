<?php 
	if (count($data_edit)>0){
		$pi[1]="";
		$pi[2]="";
		$pi[3]="";
		$pi[intval($data_edit['param_initial'])]=' checked="" ';
		
		$readonly[1]="";
		$readonly[2]="";
		$readonly[3]="";
		
		if (!empty($pi[1])){
			$readonly[1]=' readonly="" ';
			$readonly[2]=' readonly="" ';
			$readonly[3]=' readonly="" ';
		}elseif (!empty($pi[2])){
			$readonly[2]=' readonly="" ';
			$readonly[3]=' readonly="" ';
		}elseif (!empty($pi[3])){
			$readonly[1]=' readonly="" ';
		}
		
		$sts_detail_copy="hide";
		if(!empty($pi[3])){
			$sts_detail_copy="";
		}
		
		$isi_period=$data_edit['param_period_no'];
		$isi_owner=$data_edit['param_risk_owner_no'];
		$isi_period_copy=$data_edit['param_copy_period'];
		
		$pic[1]="";
		$pic[2]="";
		$pic[intval($data_edit['param_type_copy'])]=' checked="" ';
		
		$sts_partial_copy="hide";
		if(!empty($pic[2])){
			$sts_partial_copy="";
		}
		
		$copy[1]=(intval($data_edit['param_copy_risk'])==1)?' checked ':''	;
		$copy[2]=(intval($data_edit['param_copy_risk_level'])==1)?' checked ':'';
		$copy[3]=(intval($data_edit['param_copy_action_info'])==1)?' checked ':'';
		$copy[4]=(intval($data_edit['param_copy_action_sched'])==1)?' checked ':'';
	}else{
		$pi[1]=" checked='' ";
		$pi[2]="";
		$pi[3]="";
		$readonly[1]=' readonly="" ';
		$readonly[2]=' readonly="" ';
		$readonly[3]=' readonly="" ';
		$pic[1]=" checked='' ";
		$pic[2]="";
		$copy[1]=" checked ";
		$copy[2]=" checked ";
		$copy[3]=" checked ";
		$copy[4]=" checked ";
		$isi_period=0;
		$isi_owner=0;
		$isi_period_copy=0;
		$sts_partial_copy="hide";
		$sts_detail_copy="hide";
	}
?>
<div class="radio">
	<label class="no-padding">
		<input id="param_initial" type="radio" <?php echo $pi[3];?> value="3" name="param_initial">
		<?php echo lang('msg_field_copy_from');?>
	</label>
</div>
<div class="input-group width-100">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-7 control-label col-md-7" for="inputSuccess"><?php echo lang('msg_field_risk_owner');?></label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_risk_owner_no',$cbo_owner,$isi_owner,' id="param_risk_owner_no" class=" form-control select3" style=" width:auto;"');?>
		</div>
	</div>
</div>
<div class="input-group width-100" style="margin-top:15px;">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-7 control-label col-md-7" for="inputSuccess"><?php echo lang('msg_field_period');?></label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_copy_period',$cbo_period,$isi_period_copy,' id="param_copy_period" class=" form-control" style=" width:auto;"');?>
		</div>
	</div>
</div>

<div class="input-group width-100" style="margin-top:15px;">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-7 control-label col-md-7" for="inputSuccess"><?php echo lang('msg_field_corporate');?></label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_copy_rcsa', $cbo_rcsa, '',' id="param_copy_rcsa" class=" form-control" style=" width:auto;"');?>
			&nbsp;&nbsp;<span id="spinner_param" style="padding-top:1px;vertical-align:middle;"></span></div>
	</div>
</div>

<!-- 
	Risk informaytion 
	risk level
	action plant information
	action plan schedule
-->

<script>
	$("#param_risk_owner_no, #param_copy_period").change(function(){
		var owner = $('#param_risk_owner_no').val();
		var periode = $('#param_copy_period').val();
		var param = owner + '-' + periode;
		cari_ajax_combo(param, 'spinner_param', 'param_copy_rcsa', 'rcsa/cari_rcsa');
	})
</script>
