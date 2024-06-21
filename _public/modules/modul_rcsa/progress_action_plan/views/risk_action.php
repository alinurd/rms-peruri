<?php
	$data=$data_even_detail[0];
	// Doi::dump($data);
?>

<div>
	<table class="table table-striped table-hover dataTable data table-small-font" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td><?php echo lang('msg_field_date') . get_help('msg_help_date');?></td>
				<td> <?php  echo form_input('action_date',date('d-m-Y'),"  class='form-control datepicker' style='width:110px !important;' id='action_date' ");?></td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_description') . get_help('msg_help_description');?></td>
				<td>
					<?php 
						echo form_textarea("description", ($data_action)?$data['description']:''," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='risk_event' ")."&nbsp;&nbsp;&nbsp;";
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_progress') . get_help('msg_help_progress');?></td>
				<td> <?php echo form_input(array('type'=>'number','name'=>'progress'), ($data_action)?$data['progress']:'',' style="width:10% !important;" class="text-center"');?> %</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_notes') . get_help('msg_help_notes');?></td>
				<td>
					<?php 
						echo form_textarea("notes", ($data_action)?$data['schedule_detail']:''," class='form-control text-left' rows='2' cols='5' style='overflow: hidden; width: 80% !important; height: 75px;' id='notes' ")."&nbsp;&nbsp;&nbsp;";
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_status') . get_help('msg_help_status');?></td>
				<td>
					<?php echo form_dropdown('status_no',$cbo_status, ($data_action)?$data['status_no']:'','class="form-control"');?>
				</td>
			</tr>
			<tr>
				<td class="row-title no-border">
					<?php echo lang('msg_field_att') . get_help('msg_help_att');?>
				</td>
				<td class="no-border">
					<table class="table borderless no-margin-bottom" id="instlmt_att">
						<tbody>
							<tr>
								<td class="no-padding-left no-border padding-5 " width="82%">
									<div id="attr_awal">
										<?php echo form_upload("attac[]",'');?>
									</div>
								</td>
								<td class="text-right no-border padding-5">
									<input type='button' class='btn btn-warning btn-flat' value='<?php echo lang('msg_tbl_add_more');?>' id='browse_att' />
									<span class='btn btn-warning btn-flat hide' id='clear_att'>
										<i class="fa fa-cut hide" title="<?php echo lang('msg_tips_delete');?>" id="i_att">
									</span>
									
								</td>
							</tr>
						</tbody>
					</table>
					<?php
					$attch = form_upload("attac[]",'');
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>