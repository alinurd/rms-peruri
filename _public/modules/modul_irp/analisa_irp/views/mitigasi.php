List Mitigasi: <span class="btn btn-primary pull-right" id="addMitigasi"> Tambah </span><br/>
<table class="display table table-bordered table-striped table-hover" id="tbl_event">
	<thead>
		<tr>
			<th>No.</th>
			<th>Pengendalian</th>
			<th>Mitigasi</th>
			<th>Progress</th>
			<th>Status</th>
			<th>Create Date</th>
			<th>Update Date</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=0;
		foreach($mitigasi as $key=>$row){?>
			<tr>
				<td><?=++$no;?></td>
				<td><?=$row['pengendalian'];?></td>
				<td><?=$row['mitigasi'];?></td>
				<td><?=$row['progress'];?></td>
				<td><?=$row['status'];?></td>
				<td><?=$row['create_date'];?></td>
				<td><?=$row['update_date'];?></td>
				<td class="text-center"><span class="btn btn-primary pointer editMitigasi" data-id="<?=$row['id'];?>"> <i class="fa fa-pencil"></i> </span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>