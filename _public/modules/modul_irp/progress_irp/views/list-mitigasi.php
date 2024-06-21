<?php
$no=0;
foreach($detail as $key=>$row){?>
	<tr>
		<td><?=++$no;?></td>
		<td><?=$row['progress_date'];?></td>
		<td><?=$row['description'];?></td>
		<td><?=$row['notes'];?></td>
		<td class="text-center"><?=number_format($row['progress_detail']);?>%</td>
		<td class="text-center">
			<i class="fa fa-pencil pointer text-primary editMitigasi" data-id="<?=$row['id_edit'];?>"></i>
		</td>
	</tr>
<?php } ?>