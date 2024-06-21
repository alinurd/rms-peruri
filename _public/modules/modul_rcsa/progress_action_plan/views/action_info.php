<?php
	$data = array();
	if ($data_action)
		$data = $data_action[0];
?>

<div>
	<table class="table table-striped table-hover dataTable data table-small-font" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>
				<td><?php echo lang('msg_field_date') . get_help('msg_help_date');?></td>
				<td> <?php  echo date('d-m-Y');?></td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_description') . get_help('msg_help_description');?></td>
				<td>
					<?php 
						echo ($data_action)?$data['description']:'';
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_progress') . get_help('msg_help_progress');?></td>
				<td> <?php echo ($data_action)?$data['progress']:'';?> %</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_notes') . get_help('msg_help_notes');?></td>
				<td>
					<?php 
						echo ($data_action)?$data['schedule_detail']:'';
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo lang('msg_field_status') . get_help('msg_help_status');?></td>
				<td>
					<?php 
					if (array_key_exists($data['status_no'], $cbo_status))
						echo $cbo_status[$data['status_no']];?>
				</td>
			</tr>
			<tr>
				<td class="row-title no-border">
					<?php echo lang('msg_field_att') . get_help('msg_help_att');?>
				</td>
				<td class="no-border">
					-
				</td>
			</tr>
		</tbody>
	</table>
</div>