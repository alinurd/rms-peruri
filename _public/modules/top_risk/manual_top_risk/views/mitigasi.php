<?php
	$hide_edit='';
	$sts_risk=intval($parent['sts_propose']);
	if ($sts_risk>=3){
		$hide_edit=' hide ';
	}
?>

List Mitigasi: <span class="btn btn-primary pull-right" id="addMitigasi"> Tambah </span><br/>
<table class="display table table-bordered table-striped table-hover" id="tbl_event">
	<thead>
		<tr>
			<th>No.</th>
			<th>Proaktif</th>
			<th>Reaktif</th>
			<th>Biaya</th>
			<th>Target Waktu</th>
			<th>Progres</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=0;
		foreach($mitigasi as $key=>$row){?>
			<tr>
				<td><?=++$no;?></td>
				<td><?=$row['proaktif'];?></td>
				<td><?=$row['reaktif'];?></td>
				<td class="text-right"><?=number_format($row['amount']);?></td>
				<td><?=date('d-m-Y', strtotime($row['target_waktu']));?></td>
				<td><?=$row['progress'];?></td>
				<td><?=$row['status_no'];?></td>
				<td class="text-center">
					<span class="pointer editMitigasi <?=$hide_edit;?>" data-id="<?=$row['id'];?>"> 
						<i class="fa fa-pencil"></i>
					</span>
					<span class="pointer delMitigasi <?=$hide_edit;?>" data-id="<?=$row['id'];?>"> 
					 | <i class="fa fa-trash pointer text-danger del-mitigasi" data-id="<?=$row['id'];?>"></i>
					</span>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>