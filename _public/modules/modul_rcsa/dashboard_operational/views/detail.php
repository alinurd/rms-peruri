<div class="table-responsive">

	<table class="table table-bordered table-hover">
		<caption class="text-center" style="font-size:18px;">
			TOP RISK – RISIKO OPERASIONAL/HIRADC<br/>
			PERUM PERURI<br/>
			Level Akibat = <strong><span id="couse">-</span></strong>, Level Probabilitas = <strong><span id="impact">-</span></strong>

		<caption>
		<thead>
			<tr>
				<th rowspan="2" width="5%">No.</th>
				<th rowspan="2">Area</th>
				<th rowspan="2">Nama Risiko</th>
				<th rowspan="2">Penyebab</th>
				<th rowspan="2">Akibat</th>
				<th colspan="2">Treatment</th>
				<th rowspan="2">PIC</th>
				<th rowspan="2">Deadline</th>
			</tr>
			<tr>
				<th>Proaktif</th>
				<th>Aktif</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no=0;
			foreach($data as $row):
			$couse = $row['ket_likelihood'];
			$impact = $row['ket_impact'];
			?>
			<tr>
				<td><?=++$no;?></td>
				<td><?=$row['area_name'];?></td>
				<td><?=$row['event_name'];?></td>
				<td><?=$row['couse'];?></td>
				<td><?=$row['impact'];?></td>				
				<td>-</td>				
				<td>-</td>				
				<td>-</td>				
				<td>-</td>				
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>

<script>
	var couse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$couse));?>';
	var impact='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$impact));?>';
	
	$("#couse").html(couse);
	$("#impact").html(impact);
</script>
