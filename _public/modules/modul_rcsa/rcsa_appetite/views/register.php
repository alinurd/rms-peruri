<style>
	 .double-scroll {
			width: 100%;
		}
		
	thead th, tfoot th {
	  font-size: 12px;
	  padding: 5px !important;
	  text-align: center;
	}
	.w250 { width: 250px;  } 
	.w150 { width: 150px;  } 
	.w100 { width: 100px;  } 
	.w80 { width: 80px;  } 
	.w50 { width: 50px;  } 
	td ol { padding-left: 10px; width: 300px;}
	td ol li { margin-left: 5px; }
</style>

<?php echo form_open(base_url('rcsa/simpan-propose'),array('id'=>'form_input_library','role'=>'form"'),['id_rcsa'=>$id_rcsa]);?>
<?php
if ($status):?>
<div class="well well-sm text-centre text-danger" style="font-size:18px;">
	<?=$field;?>
</div>
<?php else: ?>
<table class="table table-bordered hide">
	<tr style="background:#0B2161 !important; color: white">
		<td width="80%"><h4><b>Risk Top</b></h4></td>
		<td><button class="btn btn-sm btn-info simpan_propose pull-right" style="right:10px; top:13px;">PROPOSE</button>		
		</td>
	</tr>
</table>
<div class="col-12 hide" style="overflow-x: auto">
	<table class="table table-bordered table-sm table-top-ten hide" id="datatables_event">
		<thead>
			<tr>
				<th rowspan="2">Nox</th>
				<th rowspan="2">Unselect</th>
				<th rowspan="2"><label class="w150">Area</label></th>
				<th rowspan="2"><label>Kategori</label></th>
				<th rowspan="2"><label>Sub Kategori</label></th>
				<th rowspan="2"><label class="w250">Risiko</label></th>
				<th rowspan="2"><label class="w250">Penyebab</label></th>
				<th rowspan="2"><label class="w250">Dampak Kualitatif</label></th>
				<th rowspan="2"><label class="w250">Dampak Kuantitatif</label></th>
				<th rowspan="2"><label>Urgency</label></th>
				<th rowspan="1" colspan="6"><label>Analisis</label></th>
				<th rowspan="1" colspan="3"><label>Evaluasi</label></th>
				<th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
				<th rowspan="2"><label class="w100">Accountable Unit</label></th>
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
		<td>
		<button class="btn btn-sm btn-info simpan_propose pull-right" style="right:10px; top:13px;">PROPOSE</button>
		</td>
	</tr>
	<tr>
		<td colspan="23">
		Catatan<br/>
		<?=form_textarea('note', ''," id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' ");?>
		</td>
	</tr>
</table>

<div class="double-scroll" style='height:550px;'>
	<table class="table table-bordered table-sm table-risk-register table-scroll" id="datatables_event">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" class="hide">Select</th>
				<th rowspan="2"><label class="w150">Area</label></th>
				<th rowspan="2"><label>Kategori</label></th>
				<th rowspan="2"><label>Sub Kategori</label></th>
				<th rowspan="2"><label class="w250">Risiko</label></th>
				<th rowspan="2"><label class="w250">Penyebab</label></th>
				<th rowspan="2"><label class="w250">Dampak Kualitatif</label></th>
				<th rowspan="2"><label class="w250">Dampak Kuantitatif</label></th>
				<!-- <th rowspan="2"><label>Urgensi</label></th> -->
				<th rowspan="1" colspan="6"><label>Analisis</label></th>
				<th rowspan="1" colspan="3"><label>Evaluasi</label></th>
				<th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
				<th rowspan="2"><label class="w100">Accountable Unit</label></th>
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
			if (count($field) == 0 )
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$i=1;
			$ttl_nil_dampak=0;
			$ttl_exposure=0;
			$ttl_exposure_residual=0;
			$note = '';
			foreach($field as $keys=>$row)
			{ 
				if (empty($note))
					$note=$row['note_approve_kadep'];
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td class="hide"> <button data-urgency="<?=$row['id_rcsa_detail'];?>" value="<?=$row['urgensi_no'];?>" class="btn btn-xs btn-success move">select</button></td>
					<td style="width: 50%"><?=$row['area_name'];?></td>
					<td><?=$row['kategori'];?></td>
					<td><?=$row['sub_kategori'];?></td>
					<td><?=$row['event_name'];?></td>
					<td><?=format_list($row['couse'], "###");?></td>
					<td><?=format_list($row['impact'], "###");?></td>
					<td valign="top"><?= ($row['risk_impact_kuantitatif'])?></td>
					<!-- <td> - </td> -->
					<td><?=$row['level_like'];?></td>
					<td><?=$row['like_ket'];?></td>
					<td><?=$row['level_impact'];?></td>
					<td><?=$row['impact_ket'];?></td>
					<td><?=intval($row['level_like'])*intval($row['level_impact']);?></td>
					<td><?=$row['level_mapping'];?></td>
					<td><?=$row['penanggung_jawab'];?></td>
					<!-- <td><?=$row['urgensi_no'];?></td> -->
					<td><?=format_list($row['control_name'], "###");?></td>
					<td><?=$row['control_ass'];?></td>
					<td><?=$row['proaktif'];?></td>
					<td><?=$row['reaktif'];?></td>
					<td><?=format_list($row['accountable_unit_name'], "###");?></td>
					<td><?=$row['sumber_daya'];?></td>
               <?php $originalDate = $row['target_waktu']; ?>
                <td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td>
				</tr>
			<?php 
				++$i;
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan=23>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
</div>

<?php endif;
echo form_close();
?>
<script type="text/javascript">
	var note = '<?php echo $note;?>';
	$(document).ready(function() {
	   $('.double-scroll').doubleScroll({
			resetOnWindowResize: true,
			scrollCss: {                
				'overflow-x': 'auto',
				'overflow-y': 'auto'
			},
			contentCss: {
				'overflow-x': 'auto',
				'overflow-y': 'auto'
			},
		});
	   $(window).resize();
	   $('#note').text(note);
	});
	var arr_row = [];
	var total_row = <?php echo count($field); ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>