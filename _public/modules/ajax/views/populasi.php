<table class="table table-hover">
<thead>
<tr>
	<th width="20%">Year</th>
	<th><?=lang("msg_field_populasi");?></th>
</tr>
</thead><tbody>
<?php
foreach ($field as $row){ ?>		
	<tr>
		<td class="text-center">
			<?=form_hidden(array('txtId'.$kel.'[]'=>$row['id']));?>
			<?=form_input('txtYear'.$kel.'[]', $row['year'], 'class="form-control text-center"');?>
		</td>
		<td><?=form_input('txtPopulasi'.$kel.'[]', number_format($row['populasi']), 'class="form-control rupiah angka"');?></td>
	</tr>
<?php } ?>
</tbody>
<tfoot>
<tr>
	<td><span class="btn btn-warning pointer btn_add" data-kel="<?=$kel;?>"> <?=lang("msg_tombol_add");?> </td>
	<td class="pull-right"><span class="btn btn-primary pointer btn_proses" data-kel="<?=$kel;?>" data-id="<?=$id;?>"> <?=lang("msg_tombol_save");?> </td>
</tr>
</tfoot>
</table>