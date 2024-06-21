<?php
if ($kel=="lengkap-detail"){ ?>
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
			$ttl=array(0,0,0);
			foreach($field as $row){
				$ttl[0]+=$row['total'];
				$ttl[1]+=$row['sudah'];
				$ttl[2]+=$row['belum'];
				?>
				<tr>
				<td><?=$i++;?></td>
				<td><?=$row['data'];?></td>
				<td class="text-center"><?=number_format($row['total']);?></td>
				<td class="text-center"><?=number_format($row['sudah']);?></td>
				<td class="text-center"><?=number_format($row['belum']);?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th class="text-center"><?=number_format($ttl[0]);?></th>
				<th class="text-center"><?=number_format($ttl[1]);?></th>
				<th class="text-center"><?=number_format($ttl[2]);?></th>
			</tr>
		</tfoot>
	</table>
<?php }elseif($kel=="tepat-detail"){ ?>
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
			$ttl=array(0,0,0);
			foreach($field as $row){
				$ttl[0]+=$row['total'];
				$ttl[1]+=$row['sudah'];
				$ttl[2]+=$row['belum'];
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
		<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th class="text-center"><?=number_format($ttl[0]);?></th>
				<th class="text-center"><?=number_format($ttl[1]);?></th>
				<th class="text-center"><?=number_format($ttl[2]);?></th>
			</tr>
		</tfoot>
	</table>
<?php }elseif($kel=="alert"){?>
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th width="5%" rowspan="2">No.</th>
				<th rowspan="2">Propinsi</th>
				<th width="36%" colspan="3" class="text-center">Alert</th>
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
			$ttl=array(0,0,0);
			foreach($field as $row){
				$ttl[0] +=$row['alert'];
				$ttl[1] +=$row['verif'];
				$ttl[2] +=$row['belum'];
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
		<tfoot>
			<tr>
				<th colspan="2">Total</th>
				<th class="text-center"><?=number_format($ttl[0]);?></th>
				<th class="text-center"><?=number_format($ttl[1]);?></th>
				<th class="text-center"><?=number_format($ttl[2]);?></th>
			</tr>
		</tfoot>
	</table>
<?php }elseif($kel=="alert-detail"){?>
	<div class="nav-tabs-custom">
		<!-- Tabs within a box -->
		<ul class="nav nav-tabs">
			<li class="active ln-blue"><a href="#tab_rekap" data-toggle="tab">Data Rekap</a></li>
			<li class="ln-yellow"><a href="#tab_detail" data-toggle="tab">Data Detail</a></li>
		</ul>
	</div>
	
	<div class="tab-content no-padding">
		<div class="tab-pane active" id="tab_rekap">
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th width="5%" rowspan="2">No.</th>
						<th rowspan="2"><?=$ket_title;?></th>
						<th width="36%" colspan="3" class="text-center">Alert</th>
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
					$ttl=array(0,0,0);
					foreach($field as $row){
						$ttl[0] +=$row['alert'];
						$ttl[1] +=$row['verif'];
						$ttl[2] +=$row['belum'];
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
				<tfoot>
					<tr>
						<th colspan="2">Total</th>
						<th class="text-center"><?=number_format($ttl[0]);?></th>
						<th class="text-center"><?=number_format($ttl[1]);?></th>
						<th class="text-center"><?=number_format($ttl[2]);?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="tab-pane" id="tab_detail">
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="5%" rowspan="2">No.</th>
						<th>Lokasi</th>
						<th>Puskesmas</th>
						<th>Penyakit</th>
						<th>Kasus</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					foreach($detail as $row){
						$sts = '<span class="label label-danger"> Belum Terverifikasi </span>';
						$cls="bg-danger";
						if ($row['sts_verifikasi']==1){
							$sts = '<span class="label label-primary"> Terverifikasi </span>';
							$cls="";
						}
						?>
						<tr class="<?=$cls;?>">
						<td><?=$i++;?></td>
						<td><?=$row['lokasi'];?></td>
						<td><?=$row['puskesmas'];?></td>
						<td><?=$row['nama_penyakit'];?></td>
						<td class="text-center"><?=number_format($row['nilai']);?></td>
						<td class="text-center"><?=$sts;?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php } ?>