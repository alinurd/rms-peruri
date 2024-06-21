<?php
if ($status):?>
<div class="well well-sm text-centre text-danger" style="font-size:18px;">
	<?=$field;?>
</div>
<?php else: ?>
<table class="table table-bordered">
	<tr style="background:#0B2161 !important; color: white">
		<td width="80%"><h4><b>Risk Top</b></h4></td>
		<td width="10%"><button class="btn btn-sm btn-danger revisi-propose pull-right" style="right:10px; top:13px;">REVISI</button>		
		<td width="10%"><button class="btn btn-sm btn-info propose pull-right" style="right:10px; top:13px;">PROSES</button>		
		</td>
	</tr>
	<tr>
		<td colspan="3">Catatan<br/>
		<?=form_textarea('note', ''," id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' ");?>
		</td>
	</tr>
</table>
<div class="col-12" style="overflow-x: auto">
	<table class="table table-bordered table-sm tbl-top-ten" id="datatables_event">
		<thead>
			
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Unselect</th>
				<th rowspan="2"><label class="w150">Owner Name</label></th>
				<th rowspan="2"><label class="w150">Area</label></th>
				<th rowspan="2"><label>Kategori</label></th>
				<th rowspan="2"><label>Sub Kategori</label></th>
				<th rowspan="2"><label>Risiko</label></th>
				<th rowspan="2"><label>Penyebab</label></th>
				<th rowspan="2"><label>Impact/Akibat</label></th>
				<th rowspan="2"><label>Urgency</label></th>
				<th rowspan="1" colspan="6"><label>Analisis</label></th>
				<th rowspan="1" colspan="3"><label>Evaluasi</label></th>
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
				<th>Existing Control</th>
				<th>Risk Control<br>Assessment</th>
				<th><label class="w150">Proaktif</label></th>
				<th><label class="w150">Reaktif</label></th>
			</tr>
		</thead>
		<tbody id="risk-top-ten">
			
		</tbody>
		<tfoot>
			<tr>
				<th colspan=22>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</div>

<table class="table table-bordered">
	<tr style="background:#0B2161 !important; color: white">
		<td colspan="22">
			<h4><b>Risk Register</b></h4>
		</td>
	</tr>
</table>
<div class="col-12" style="overflow-x: auto">
	<table class="table table-bordered table-sm tbl-risk-register" id="datatables_event">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" class="">Select</th>
				<th rowspan="2"><label class="w150">Owner Name</label></th>
				<th rowspan="2"><label class="w150">Area</label></th>
				<th rowspan="2"><label>Kategori</label></th>
				<th rowspan="2"><label>Sub Kategori</label></th>
				<th rowspan="2"><label>Risiko</label></th>
				<th rowspan="2"><label>Penyebab</label></th>
				<th rowspan="2"><label>Impact/Akibat</label></th>
				<th rowspan="2"><label>Urgensi</label></th>
				<th rowspan="1" colspan="6"><label>Analisis</label></th>
				<th rowspan="1" colspan="3"><label>Evaluasi</label></th>
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
				<th>Existing Control</th>
				<th>Risk Control<br>Assessment</th>
				<th><label class="w150">Proaktif</label></th>
				<th><label class="w150">Reaktif</label></th>
			</tr>
		</thead>
		<tbody id="risk-register">
			
			<?php
			if (!is_array($field))
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$i=1;
			$ttl_nil_dampak=0;
			$ttl_exposure=0;
			$ttl_exposure_residual=0;
			
			if (is_array($field)){
			foreach($field as $keys=>$row)
			{ 
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td class=""> <button data-urgency="<?=$row['id_rcsa_detail'];?>" data-rcsa="<?=$row['rcsa_no'];?>"  value="<?=$row['urgensi_no'];?>" class="btn btn-xs btn-success move">select</button></td>
					<td style="width: 50%"><?=$row['name'];?></td>
					<td style="width: 50%"><?=$row['area_name'];?></td>
					<td><?=$row['kategori'];?></td>
					<td><?=$row['sub_kategori'];?></td>
					<td><?=$row['event_name'];?></td>
					<td><?=format_list($row['couse'], "###");?></td>
					<td><?=format_list($row['impact'], "###");?></td>
					<td> <?=$row['urgensi_no'];?> </td>
					<td><?=$row['inherent_likelihood'];?></td>
					<td><?=$row['like_ket'];?></td>
					<td><?=$row['inherent_impact'];?></td>
					<td><?=$row['impact_ket'];?></td>
					<td><?=$row['inherent_level'];?></td>
					<td><?=$row['level_mapping'];?></td>
					<td><?=format_list($row['penanggung_jawab'], "###");?></td>
					<!-- <td><?=$row['urgensi_no'];?></td> -->
					<td><?=format_list($row['control_name'], "###");?></td>
					<td><?=$row['control_ass'];?></td>
					<td><?=$row['proaktif'];?></td>
					<td><?=$row['reaktif'];?></td>
					<td><?=format_list($row['accountable_unit_name'], "###");?></td>
					<td><?=$row['schedule_no'];?></td>
					<td><?=$row['target_waktu'];?></td>
				</tr>
			<?php 
				++$i;
			}
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
	tbody { transition: height .5s; }
</style>
<?php endif;?>
<script>
	var arr_row = [];
	var total_row = <?php echo count($field); ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>