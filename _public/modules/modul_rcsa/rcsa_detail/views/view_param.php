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
		<input id="param_initial" type="radio" <?php echo $pi[1];?> value="1" name="param_initial">
		Initial Period RSCA
	</label>
</div>
<div class="radio">
	<label class="no-padding">
		<input id="param_initial" type="radio" <?php echo $pi[2];?> value="2" name="param_initial">
		Continue from Previous Period :
	</label>
</div>
<div class="input-group width-100">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-5 control-label col-md-5" for="inputSuccess">Period : </label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_period_no',$cbo_period,$isi_period,' id="param_period_no" class=" form-control" style=" width:auto;" '.$readonly[1].' ');?>
		</div>
	</div>
</div>
<div class="radio">
	<label class="no-padding">
		<input id="param_initial" type="radio" <?php echo $pi[3];?> value="3" name="param_initial">
		Copy from other Unit :
	</label>
</div>
<div class="input-group width-100">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-7 control-label col-md-7" for="inputSuccess">Risk Owner : </label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_risk_owner_no',$cbo_owner,$isi_owner,' id="param_risk_owner_no" class=" form-control" style=" width:auto;" '.$readonly[2].' ');?>
		</div>
	</div>
</div>
<div class="input-group width-100">
	<div class="row">
		<div class="col-sm-3">
			<label class="col-sm-7 control-label col-md-7" for="inputSuccess">Period : </label>
		</div>
		<div class="col-sm-9">
			<?php echo form_dropdown('param_copy_period',$cbo_period,$isi_period_copy,' id="param_copy_period" class=" form-control" style=" width:auto;" '.$readonly[3].' ');?>
		</div>
	</div>
</div>

<div class="input-group width-100 <?php echo $sts_detail_copy;?>" id="detail_copy">
	<div class="row well" style="margin:20px;">
		<div class="col-sm-12">
			<div class="radio">
				<label class="no-padding">
					<input id="param_type_copy" type="radio" <?php echo $pic[1];?> checked="" value="1" name="param_type_copy">
					Copy All Data
				</label>
			</div>
			<div class="radio">
				<label class="no-padding">
					<input id="param_type_copy" type="radio" <?php echo $pic[2];?> value="2" name="param_type_copy">
					Copy Partial Data :
				</label>
			</div>
			<div class="col-md-10 <?php echo $sts_partial_copy;?>" id="partial_copy">
				<div class="checkbox">
					<div class="checkbox">
						<label> 
							<input type="hidden" value=0 name="param_copy_risk">
							<input type="checkbox" value="1" name="param_copy_risk" <?php echo $copy[1];?>> Copy Risk Information
						</label>
					</div>
					<div class="checkbox">
						<label> 
							<input type="hidden" value=0 name="param_copy_risk_level">
							<input type="checkbox" value="1" name="param_copy_risk_level" <?php echo $copy[2];?>> Copy Risk Levels
						</label>
					</div>
					<div class="checkbox">
						<label> 
							<input type="hidden" value=0 name="param_copy_action_info">
							<input type="checkbox" value="1" name="param_copy_action_info" <?php echo $copy[3];?>> Copy Action Plan Information
						</label>
					</div>
					<div class="checkbox">
						<label> 
							<input type="hidden" value=0 name="param_copy_action_sched">
							<input type="checkbox" value="1" name="param_copy_action_sched" <?php echo $copy[4];?>> Copy Action Plan Resource
						</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$("input[name='param_initial']").click(function(){
		var nil = $(this).val();
		$("#detail_copy").removeClass('hide').addClass('hide');
		if (nil==1){
			$('#param_period_no').attr('readonly',true);
			$('#param_risk_owner_no').attr('readonly',true);
			$('#param_copy_period').attr('readonly',true);
		}else if (nil==2){
			$('#param_period_no').removeAttr('readonly');
			$('#param_risk_owner_no').attr('readonly',true);
			$('#param_copy_period').attr('readonly',true);
		}else if (nil==3){
			$('#param_period_no').attr('readonly',true);
			$('#param_risk_owner_no').removeAttr('readonly');
			$('#param_copy_period').removeAttr('readonly');
			$("#detail_copy").removeClass('hide');
		}
	})
	
	$("input[name='param_type_copy']").click(function(){
		var nil = $(this).val();
		if (nil==1){
			$("#partial_copy").addClass('hide');
		}else{
			$("#partial_copy").removeClass('hide');
		}
	});
	
	function disable_period(nil){
		if (nil=="1")
			$("#l_period_no").removeAttr('readonly');
		else
			$("#l_period_no").attr('readonly',true);
	}
</script>
