
<div style="overflow-x: auto;">
	<span class="btn btn-primary btn-flat"> <a href="<?=base_url('rcsa/cetak-register/excel/'.$id);?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a></span> <span class="btn btn-warning btn-flat hide"> <a href="<?=base_url('rcsa/cetak-register/pdf/'.$id);?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a></span>
	<table class="table table-bordered table-sm" id="datatables_event" border="1">
		<thead>
			<tr>
				<td colspan="22">Date:</td>
			</tr>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2"><label class="w150">Area</label></th>
				<th rowspan="2"><label>Kategori</label></th>
				<th rowspan="2"><label>Sub Kategori</label></th>
				<th rowspan="2"><label>Risiko</label></th>
				<th rowspan="2"><label>Penyebab</label></th>
				<th rowspan="2"><label>Impact/Akibat</label></th>
				<th rowspan="1" colspan="6"><label>Analisis</label></th>
				<th rowspan="1" colspan="4"><label>Evaluasi</label></th>
				<th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
				<th rowspan="2"><label class="w100">Accountabel Unit</label></th>
				<th rowspan="2"><label class="w80">Sumber Daya</label></th>
				<th rowspan="2"><label class="w80">Deadline</label></th>
			</tr>
			<tr>
				<th colspan="2">Probabilitas</th>
				<th colspan="2">Impact</th>
				<th colspan="2">Risk Level</th>
				<th><label class="w150">PIC</label></th>
				<th>Urgency</th>
				<th>Existing Control</th>
				<th>Risk Control<br>Assessment</th>
				<th><label class="w150">Proaktif</label></th>
				<th><label class="w150">Reaktif</label></th>
			</tr>
		</thead>
		<tbody>

			<?php
			if (count($field) == 0 )
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$i=1;
			$ttl_nil_dampak=0;
			$ttl_exposure=0;
			$ttl_exposure_residual=0;

			foreach($field as $keys=>$row)
			{ 
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td style="width: 50%"><?=$row['area_name'];?></td>
					<td><?=$row['kategori'];?></td>
					<td><?=$row['sub_kategori'];?></td>
					<td><?=$row['event_name'];?></td>
					<td><?=format_list($row['couse']);?></td>
					<td><?=$row['impact'];?></td>
					<td><?=$row['level_like'];?></td>
					<td><?=$row['like_ket'];?></td>
					<td><?=$row['level_impact'];?></td>
					<td><?=$row['impact_ket'];?></td>
					<td><?=intval($row['level_like'])*intval($row['level_impact']);?></td>
					<td><?=$row['level_mapping'];?></td>
					<td><?=$row['penangung_jawab'];?></td>
					<td><?=$row['urgensi_no'];?></td>
					<td><?=format_list($row['control_name']);?></td>
					<td><?=$row['control_ass'];?></td>
					<td><?=$row['proaktif'];?></td>
					<td><?=$row['reaktif'];?></td>
					<td><?=$row['accountable_unit_name'];?></td>
					<td><?=$row['schedule_no'];?></td>
					<td><?=$row['target_waktu'];?></td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan=22>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</div>



<style>
	thead th, tfoot th {
	  font-size: 12px;
	  padding: 5px !important;
	  text-align: center;
	}
	.w150 { width: 150px;  } 
	.w100 { width: 100px;  } 
	.w80 { width: 80px;  } 
	.w50 { width: 50px;  } 
	td ol { padding-left: 10px; width: 300px;}
	td ol li { margin-left: 5px; }
</style>