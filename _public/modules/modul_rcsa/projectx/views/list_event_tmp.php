
<table class="table data" id="datatables_event">
	<thead>
		<tr>
		<th width="10%" style="text-align:center;">No.</th>
		<th width="15%" ><?php echo lang('msg_field_pop_risk_event_type');?></th>
		<th width="60%" ><?php echo lang('msg_field_pop_event_description_library');?></th>
		<th width="10%" ><?php echo lang('msg_tbl_select');?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		foreach($field['field'] as $key=>$row)
		{ 
			$value_chek=$row->id."#".$row->code.' - '.$row->description;
			?>
			<tr class="pilih_event" style="cursor:pointer;" value="<?php echo $value_chek;?>" data-dismiss="modal">
				<td style="text-align:center;width:10%;"><?php echo $i;?></td>
				<td style="width:15%;"><?php echo $row->type;?></td>
				<td style="width:80%;text-align: justify;"><?php echo $row->description;?></td>
				<td style="text-align:center;width:10%;"><span class="btn btn-info pilih_event" value="<?php echo $value_chek;?>" data-dismiss="modal"> <?php echo lang('msg_tbl_select');?></span></td>
			</tr>
		<?php 
			++$i;
		}
		?>
	</tbody>
</table>

<script>
	loadTable('', 0, 'datatables_event');
</script>