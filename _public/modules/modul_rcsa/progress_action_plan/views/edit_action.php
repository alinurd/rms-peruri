<?php
	$data=$data_action;
	// Doi::dump($data);
	// Doi::dump($data[0]);
	// die();
?>
<input type="hidden" name="id_action_detail" value="<?php echo $data['id'];?>">
<table class="table table-striped table-hover dataTable data table-small-font" width="100%" cellspacing="0" cellpadding="0" border="0">
	<tbody>
		<tr>
			<td><?php echo lang('msg_field_date') . get_help('msg_help_date');?></td>
			<td> <?php  echo form_input('action_date',$data['progress_date'],"  class='form-control datepicker' style='width:110px !important;' id='action_date' ");?></td>
		</tr>
		<tr>
			<td><?php echo lang('msg_field_description') . get_help('msg_help_description');?></td>
			<td>
				<?php 
					echo form_textarea("description", $data['description']," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo lang('msg_field_progress') . get_help('msg_help_progress');?></td>
			<td> <?php echo form_input(array('type'=>'number','name'=>'progress'),$data['progress'],' style="width:10% !important;" class="text-center" id="progress"');?> %</td>
		</tr>
		<tr>
			<td><?php echo lang('msg_field_notes') . get_help('msg_help_notes');?></td>
			<td>
				<?php 
					echo form_textarea("notes", $data['notes']," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='notes' ")."&nbsp;&nbsp;&nbsp;";
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo lang('msg_field_status');?></td>
			<td>
				<?php echo form_dropdown('status_no',$cbo_status, $data['status_no'],'class="form-control" id="status_no"');?>
			</td>
		</tr>
		<tr>
			<td class="row-title  no-border vcenter text-left">
				<?=lang('msg_field_residual_risk');?>
			</td>
			<td class="no-border vcenter text-left">
				<span style="margin-right:10px; float: left;"> <?=lang('msg_field_likelihood')?> :</span>
				<?= form_dropdown('residual_likelihood',$cbo_level_like, (empty($data['residual_likelihood']))?'':$data['residual_likelihood'] ,'class="form-control" style="width:150px;float:left;margin-right:10px" id="residual_likelihood"')?>
				<span style="margin-right:10px; float: left;"> <?=lang('msg_field_impact')?> :</span>
				<?php echo form_dropdown('residual_impact',$cbo_level_impact_baru, (empty($data['residual_impact']))?'':$data['residual_impact'],'class="form-control" id="residual_impact" style="width:150px"');?>
			</td>
		</tr>
		<tr>
			<td class="row-title no-border">
				<?php echo lang('msg_field_att') . get_help('msg_help_att');?>
			</td>
			<td class="no-border">
				<table class="table borderless no-margin-bottom" id="instlmt_att">
					<tbody>
						<?php 
						$i=0;
						$path=upload_url().'action/';
						if(count($data['attach'])>0){
							foreach($data['attach'] as $row){
							?>
							<tr>
								<td class="no-padding-left no-border padding-5 " width="82%">
									<a href="<?php echo base_url('progress-action-plan/get_file/'.$row['name']);?>"><?php echo $row['real_name'];?></a>
									<input type="hidden" name="attach_no[]" id="attach_no" value="<?php echo $row['name']."###".$row['real_name'];?>">
								</td>
								<td class="text-center no-border padding-5">
									<?php if($i==0){
										++$i;
									?>
									<input type='button' class='btn btn-primary btn-flat' value='Add' id='browse_att' />
									<span class='btn btn-warning btn-flat' id='clear_att'  onclick="remove_install(this,0)">
										<i class="fa fa-cut" title="menghapus data" id="i_att"></i>
									</span>
									<?php }else{
									?>
										<span nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>
									<?php
									} ?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td class="no-padding-left no-border padding-5 " width="82%">
									<?php echo form_upload("attac[]",'');?>
								</td>
								<td class="text-center no-border padding-5">
									<span id='clear_att'  onclick="remove_install(this,0)">
										<i class="fa fa-cut" title="menghapus data" id="i_att"></i>
									</span>
									
								</td>
							</tr>
							<?php
						}else{ 		
						?>
						<tr>
							<td class="no-padding-left no-border padding-5 " width="82%">
								<?php echo form_upload("attac[]",'');?>
							</td>
							<td class="text-right no-border padding-5">
								<input type='button' class='btn btn-primary btn-flat' value='Add More' id='browse_att' />
								<span class='btn btn-warning btn-flat hide' id='clear_att'>
									<i class="fa fa-cut hide" title="menghapus data" id="i_att"></i>
								</span>
								
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php
				$attch = form_upload("attac[]",'');
				?>
			</td>
		</tr>
	</tbody>
</table>

<script>
	$(".datepicker").datetimepicker({
		lang:'id',
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true
	});
</script>