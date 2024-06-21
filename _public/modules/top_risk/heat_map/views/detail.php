<div class="table-responsive">

	<table class="table table-bordered table-hover">
		<caption class="text-center" style="font-size:18px;">
			TOP RISK – RISIKO OPERASIONAL<br/>
			PERUM PERURI<br/>
			Level Akibat = <strong><span id="couse">-</span></strong>, Level Probabilitas = <strong><span id="impact">-</span></strong>

		<caption>
		<thead>
			<tr>
				<th width="5%">No.</th>
				<th >Area</th>
				<th >Nama Risiko</th>
				<th >Penyebab</th>
				<th >Akibat</th>
				<th >Likelihood</th>
				<th >Impact </th>
				<th >Inherent Risk</th>
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
				<td><?=$row['ket_likelihood'];?></td>				
				<td><?=$row['ket_impact'];?></td>				
				<td><?=$row['inherent_analisis'];?></td>				
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
