<div class="table-responsive">

	<table class="table table-bordered table-hover">
		<caption class="text-center" style="font-size:18px;">
			TOP RISK – RISIKO OPERASIONAL<br/>
			PERUM PERURI<br/>
			Level Akibat = <strong><span id="couse">-</span></strong>, Level Probabilitas = <strong><span id="impact">-</span></strong>

		<caption>
		<thead>
			<tr>
				<th class="text-center" rowspan="2" width="5%">No.</th>
				<th class="text-center" rowspan="2">Risk Owner</th>
				<th class="text-center" rowspan="2">Kategori</th>
				<th class="text-center" rowspan="2">Peristiwa Resiko</th>
				<th class="text-center" rowspan="2">Inherent</th>
				<th class="text-center" rowspan="2">Residual</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
			$no=0;
			foreach($data as $row):
			$couse = $row['ket_likelihood'];
			$impact = $row['ket_impact'];
			?>
			<tr class="pointer sub_detail" title="klik untuk melihat detail" data-id="<?=$row['id'];?>">
				<td><?=++$no;?></td>
				<td><?=$row['name'];?></td>
				<td><?=$row['kategori'];?></td>
				<td><?=$row['event_name'];?></td>
				<td style="background-color:<?=$row['warna'];?>;color:#000000;"><?=$row['inherent_analisis'];?></td>
				<td style="background-color:<?=$row['warna_residual'];?>;color:#000000;"><?=$row['residual_analisis'];?></td>
							
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
<div id="sub_detail">
	
</div>
<!-- <script>
	var couse='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$couse));?>';
	var impact='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$impact));?>';
	
	$("#couse").html(couse);
	$("#impact").html(impact);
</script> -->
