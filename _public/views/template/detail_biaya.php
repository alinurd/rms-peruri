<table class="table table-striped table-hover" id="detail_biaya">
	<thead>
	<tr>
		<th width="5%">No</th>
		<th><?=lang('msg_field_komponen_biaya');?></th>
		<th width="15%" class="text-right"><?=lang('msg_field_biaya');?></th>
	</tr>
	</thead>
	<tbody>
		<?php
	$i=0;
	$total = 0;
	foreach($field as $key=>$row)
	{ 
		$komponen=form_input('komponen[]', $row['komponen'],' readonly="readonly" class="form-control" style="width:100% !important;"');
		$biaya=form_input('biaya[]', number_format($row['biaya']),' class="form-control rupiah text-right" style="width:100% !important;"');
		$edit=form_hidden('id_edit_biaya[]',$row['id']);
		$total +=floatval($row['biaya']);
		++$i;
		?>
		<tr>
			<td class="text-center"><?=$i.$edit;?></td>
			<td><?=$komponen;?></td>
			<td><?=$biaya;?></td>
		</tr>
		<?php 
	} ?>
	<tr>
		<td colspan="2" class="text-right">Total : (<em><?=terbilang($total);?></em>)</td>
		<td class="text-right"><strong><?=number_format($total);?></strong></td>
	</tr>
	</tbody>
</table>