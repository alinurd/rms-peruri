<div class="table-responsive">

	<table class="table table-bordered table-hover">
		<caption class="text-center" style="font-size:18px;">
			TOP RISK – RISIKO OPERASIONAL/HIRADC<br/>
			PERUM PERURI TAHUN <?=$tahun['periode_name'];?>
		<caption>
		<thead>
			<tr>
				<th>No.</th>
				<th>Area</th>
				<th>Nama Risiko</th>
				<th>Penyebab</th>
				<th>Bahaya</th>
				<th>Mitigasi</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=0;
			foreach($data as $row):?>
			<tr>
				<td><?=++$no;?></td>
				<td><?=$row['lokasi'];?></td>
				<td><?=$row['resiko'];?></td>
				<td><?=$row['kondisi'];?></td>
				<td><?=$row['bahaya'];?></td>
				<td>
				<?php
				if (array_key_exists('mitigasi', $row)):?>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Treadment</th>
								<th>Pic</th>
								<th>Progress</th>
								<th>Deadline</th>
							</tr>
						</thead>
						<tbody>
					<?php
					foreach($row['mitigasi'] as $rok):?>
					<tr>
						<td><?=$rok['operasional'];?></td>
						<td><?=$rok['mendatang'];?></td>
						<td><?=$rok['progress'];?></td>
						<td><?=$rok['tgl_selesai'];?></td>
					</tr>
					<?php endforeach;?>
					</tbody>
					</table>
				<?php endif;?>	
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>