<?php
if ($kel=="lengkap"){ ?>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th width="5%" rowspan="2">No.</th>
				<th rowspan="2">Propinsi</th>
				<th width="45%" colspan="3" class="text-center">Statistik Pengiriman Laporan</th>
			</tr>
			<tr>
				<th width="15%">Total Puskesmas</th>
				<th width="15%">Sudah Mengirim Laporan</th>
				<th width="15%">Belum</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $row){
				?>
				<tr>
				<td><?=$i++;?></td>
				<td><?=$row['data'];?></td>
				<td class="text-right"><?=number_format($row['total']);?></td>
				<td class="text-right"><?=number_format($row['sudah']);?></td>
				<td class="text-right"><?=number_format($row['belum']);?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php }elseif($kel=="tepat"){ ?>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th width="5%" rowspan="2">No.</th>
				<th rowspan="2">Propinsi</th>
				<th width="45%" colspan="3" class="text-center">Statistik Pengiriman Laporan</th>
			</tr>
			<tr>
				<th width="15%">Total Laporan</th>
				<th width="15%">Tepat</th>
				<th width="15%">Tidak Tepat</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $row){
				?>
				<tr>
				<td><?=$i++;?></td>
				<td><?=$row['data'];?></td>
				<td class="text-right"><?=number_format($row['total']);?></td>
				<td class="text-right"><?=number_format($row['sudah']);?></td>
				<td class="text-right"><?=number_format($row['belum']);?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php }elseif($kel=="alert"){?>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th width="5%" rowspan="2">No.</th>
				<th rowspan="2">Propinsi</th>
				<th width="36%" colspan="3">Alert</th>
			</tr>
			<tr>
				<th width="12%" class="text-center">Jumlah</th>
				<th width="12%" class="text-center">Verif</th>
				<th width="12%" class="text-center">Belum</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $row){
				?>
				<tr>
				<td><?=$i++;?></td>
				<td><?=$row['data'];?></td>
				<td class="text-center"><?=number_format($row['alert']);?></td>
				<td class="text-center"><?=number_format($row['verif']);?></td>
				<td class="text-center"><?=number_format($row['belum']);?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>