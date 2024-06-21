<?php
	$data_detail=$data_risk_detail[0];
	$rcsa_no=$this->uri->segment(3);
	$data=$data_risk_level[0];
	// Doi::dump($data);die();
	
echo form_open_multipart(base_url('project/save_level'),array('name'=>'form_level','id'=>'form_input_level','class'=>'form-inline'));?>
<input type="hidden" name="id_rcsa_level" value="<?php echo $id_rcsa;?>">
<input type="hidden" name="id_event_detail_level" value="<?php echo $id_event_detail;?>">
<div id="content_detail">
	<table class="table table-condensed no-margin-bottom" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td class="row-title no-border latar-risk">
					<?php echo lang('msg_field_risk_event');?>
				</td>
				<td class=" no-border">
					<div class="input-group w100">
					<?php 
						echo form_textarea("risk_event", $data_detail['event_no'][0]['name']," class='form-control text-left' rows='2' readonly='' cols='5' style='overflow: hidden; width: 90% !important; height: 100px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="row-title no-border  latar-risk">
					<?php echo lang('msg_field_risk_impact');?>
				</td>
				<td class=" no-border">
					<div class="input-group w100">
					<?php 
						$i=0;
						$impact=array();
						if(count($data_detail['risk_impact_no'])>0){
							foreach($data_detail['risk_impact_no'] as $row){
								$impact[]=$row['name'];
							}
						}
						$impact=implode("\n",$impact);
						echo form_textarea("risk_event", $impact," class='form-control text-left' readonly='' rows='2' cols='5' style='overflow: hidden; width: 90% !important; height: 100px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
					?>
					</div>
				</td>
			</tr>
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_inherent_risk');?></strong>
				</td>
				<td class="no-border vcenter text-left">
					<hr class="no-padding no-margin" style="margin-bottom:20px;">
						<span style="margin-left:0px;">
							<?php echo lang('msg_field_likelihood');?> : 
						</span>
							<?php echo form_dropdown('inherent_likelihood',$cbo_level_like, (empty($data['inherent_likelihood']))?'':$data['inherent_likelihood'] ,'class="form-control" style="width:150px" id="inherent_likelihood"');?>
						<span style="margin-left:10px;">
							<?php echo lang('msg_field_impact');?> : 
						</span>
							<?php echo form_dropdown('inherent_impact',$cbo_level_impact_baru, (empty($data['inherent_impact']))?'':$data['inherent_impact'],'class="form-control" id="inherent_impact" style="width:150px"');?>
					<hr class="no-padding no-margin" style="margin-top:20px;">
				</td>
			</tr>
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_inherent_level');?></strong>
				</td>
				<td class="no-border vcenter text-left">
					<span id="inherent_level_label">
						<span style="background-color:<?php echo (count($data['inherent_level_text'])>0)? $data['inherent_level_text'][0]['color']:'#fff';?>;color:<?php echo (count($data['inherent_level_text'])>0)? $data['inherent_level_text'][0]['color_text']:'#000';?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper((count($data['inherent_level_text'])>0)? $data['inherent_level_text'][0]['level_mapping']:'');?>&nbsp;&nbsp;&nbsp;&nbsp;</span> 
					</span><span id="spinner-inherent"></span><br/>
					<input type="hidden" class="form-control" readonly="" name="inherent_level" id="inherent_level" value="<?php echo (empty($data['inherent_level']))?'':$data['inherent_level'];?>"/>
				</td>
			</tr>
			<tr>
				<td class="row-title no-border text-left" colspan="2">
					<strong><?php echo lang('msg_field_existing_control');?></strong><br/>
					<div class="well p100">
						<div class="row">
					<?php 
						$jml=intval(count($data_risk_level_control)/2   );
						$check ='';
						$i=1;
						$control=array();
						if (is_array($data['control_no']))
							$control=$data['control_no'];
						foreach($data_risk_level_control as $row){
							if ($i==1)
								$check .='<div class="col-md-6">';
							
							$sts=false;
							foreach($control as $ctrl){
								if ($row['component']==$ctrl){
									$sts=true;
									break;
								}
							}
							$check .= form_checkbox('check_item[]', $row['component'], $sts);
							$check .= '&nbsp;'.$row['component'].'<br/>';
				
							// $check .='<input type="checkbox" value="'.$row['component'].'" name="check_item[]"> &nbsp;'.$row['component'].'<br/>';
							
							if ($i==$jml)
								$check .='</div><div class="col-md-6">';
							
							++$i;
						}
						$check .='</div>';
						echo $check ;
					?>
							
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_risk_control_assessment');?></strong>
				</td>
				<td class="no-border">
					<?php echo form_dropdown('risk_control_assessment',$cboAssesmen, (empty($data['risk_control_assessment']))?'':$data['risk_control_assessment'],'class="form-control" id="risk_control_assessment" style="width:160px"');?>
				</td>
			</tr>

			<tr>
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_treatment');?></strong>
				</td>
				<td class="no-border">
					<?php echo form_dropdown('treatment_no',$cbo_treatment, (empty($data['treatment_no']))?'':$data['treatment_no']	,'class="form-control" id="treatment_no" style="width:160px"');?>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title no-border vcenter text-left">
					<strong><?php echo lang('msg_field_residual_risk');?></strong>
				</td>
				<td class="no-border vcenter text-right">
					<hr class="no-padding no-margin" style="margin-bottom:20px;">
						<?php echo lang('msg_field_likelihood');?> : &nbsp;&nbsp;<?php echo form_dropdown('residual_likelihood',$cbo_level_like, $data['residual_likelihood'],'class="form-control" id="residual_likelihood"');?>
						<span style="margin-left:10px;"><?php echo lang('msg_field_impact');?> : &nbsp;&nbsp;</span><?php echo form_dropdown('residual_impact',$cbo_level_impact_baru, $data['residual_impact'],'class="form-control" id="residual_impact"');?>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_residual_level');?> :</strong>
				</td>
				<td class="no-border vcenter text-left">
					<span id="residual_level"><span style="background-color:<?php echo ($data['risk_level_text'])?$data['risk_level_text'][0]['color']:'';?>;color:<?php echo ($data['risk_level_text'])?$data['risk_level_text'][0]['color_text']:'';?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($data['risk_level_text'])?strtoupper($data['risk_level_text'][0]['level_mapping']):'';?>&nbsp;&nbsp;&nbsp;&nbsp;</span> </span> <span id="spinner-residual"></span> 
					<br/>
					<input type="hidden" class="form-control" readonly="" name="risk_level" id="risk_level" value="<?php echo $data['risk_level'];?>'"/>
				</td>
			</tr>
			<tr class="hide">
				<td class="row-title  no-border vcenter text-left">
					<strong><?php echo lang('msg_field_impact_value');?></strong>
				</td>
				<td class="no-border text-left">
					<div class="input-group">
					<span class="input-group-addon">
					<strong> Rp. </strong>
					</span>
					<?php echo form_input('nilai_dampak',$data['nilai_dampak'],'class="form-control numeric rupiah  text-right" size="21" id="nilai_dampak"');?>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
	<div class="box-body">
		<button class="save btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit">
		<i class="fa fa-floppy-o"></i>
		<?php echo lang('msg_tbl_simpan');?>
		</button>
		<span class="delete btn btn-warning btn-flat" data-content="Remove Data Event Detail" data-toggle="popover" url="<?php echo base_url('project/delete-event/'.$id_rcsa.'/'.$id_event_detail);?>">
			<i class="fa fa-cut"></i> <?php echo lang('msg_tbl_del');?>
		</span>
		<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('project/risk-event/'.$id_rcsa);?>" >
			<i class="fa fa-plus"></i> <?php echo lang('msg_tbl_add');?>
		</a>
		<span class="pull-right" style="padding-right:20px;"> 
			<span class="next btn btn-success btn-flat" value='Back'>
				<?php echo lang('msg_tbl_back');?>
			</span>
			<span class="next btn btn-success btn-flat" value='Next'>
				<?php echo lang('msg_tbl_next');?>
			</span>
		</span>
	</div>
	<div class="row" style="margin-top:15px;">
		<div class="col-md-12">
			<?php 
				$cb=(isset($data['create_user']))? $data['create_user']:'';
				$cd=(isset($data['create_date']))? $data['create_date']:'';
				$ub=(isset($data['update_user']))? $data['update_user']:'';
				$ud=(isset($data['update_date']))? $data['update_date']:'';
			?>
			<em><sup><?php echo lang('msg_create_by').'<span class="text-info">'.$cb.'</span> , '.lang('msg_create_stamp').'<span class="text-info">'.$cd.'</span> | '.lang('msg_update_by').'<span class="text-info">'.$ub.'</span> '.lang('msg_update_stamp').'<span class="text-info">'.$ud.'</span>';?></sup></em>
		</div>
	</div>
</div>
<?php echo form_close();?>

<script>
	var master_level = '<?php echo $master_level;?>';
	var data_master_level = $.parseJSON(master_level);

	function cari_level(likelihood, impact, asal){
		var label='-';
		var id=0;
		var color=0;
		var color_text=0;
		$.each(data_master_level, function(key, value){
			if (value.impact==impact && value.likelihood==likelihood){
				label = value.level_mapping;
				id = value.id_color;
				color = value.color;
				color_text = value.color_text;
			}
		});
		var text='<span style="background-color:'+color+';color:'+color_text+'">  &nbsp;&nbsp;'+label.toUpperCase()+' &nbsp;&nbsp;</span>';
		if (asal==2){
			$("#risk_level").val(id);
			$("#residual_level").html(text);
		}else if (asal==1){
			$("#inherent_level").val(id);
			$("#inherent_level_label").html(text);
		}
	}
	
	$("#residual_likelihood, #residual_impact").change(function(){
		var url='<?php echo base_url("project/get_risk_level");?>';
		var likelihood=$("#residual_likelihood").val();
		var impact=$("#residual_impact").val();
		cari_level(likelihood, impact, 2);
		return false;
	});
	
	$("#inherent_impact, #inherent_likelihood").change(function(){
		var url='<?php echo base_url("project/get_risk_level");?>';
		var likelihood=$("#inherent_likelihood").val();
		var residual_likelihood=$("#residual_likelihood").val();
		var impact=$("#inherent_impact").val();
		var residual_impact=$("#residual_impact").val();
		var sts=false;
		
		if (likelihood>0 && residual_likelihood<=0){
			$("#residual_likelihood").val(likelihood);
			sts=true;
		}
		
		if (impact>0 && residual_impact<=0){
			$("#residual_impact").val(impact);
			sts=true;
		}
			
		if(sts)
			$("#residual_likelihood").trigger('change');
		
		cari_level(likelihood, impact, 1);
		return false;
	});
	
	$("#nilai_dampak").change(function(){
		var url='<?php echo base_url("project/get_inherent_risk_level");?>';
		var rcsa_no='<?php echo $rcsa_no;?>';
		var nil_dampak=$(this).val();
		var likelihood=$("#inherent_likelihood").val();
		var impact=$("#inherent_impact").val();
		if (likelihood==0){
			return false;
		}
		var form = {'likelihood':likelihood,'impact':impact,'nil_dampak':nil_dampak,'type':'inherent','rcsa_no':rcsa_no};		
		show_spinner('spinner-inherent');
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			success: function(msg){
				hasil=msg.split('###');
				$("#inherent_impact").val(hasil[2]);
				
				$("#inherent_impact").trigger('change');
				close_spinner('spinner-inherent');
			},
			failed: function(msg){
				close_spinner('spinner-inherent');
				alert("gagal");
			},
			error: function(msg){
				close_spinner('spinner-inherent');
				alert("gagal");
			},
		});
	})
</script>