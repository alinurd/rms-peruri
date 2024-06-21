<?php
$hide = '';
if (!isset($jml))
	$jml=0;
if ($jml_propose<$jml){
	$hide = ' disabled="disabled" ';
}
if ($status):?>
<div class="well well-sm text-centre text-danger" style="font-size:18px;">
	<?=$field;?>
</div>
<?php else: ?>
<div class="panel-group accordion-sortable content-group-lg ui-sortable" id="accordion-controls">
	<?php 
	$rcsa=0;
	$first=true;
	$no=0;
	
	foreach($field as $keys=>$row):
		if ($rcsa!==$row['rcsa_no']){
			if (!$first){?>
				</tbody>
					<tfoot>
						<tr>
							<th colspan=22>&nbsp;</th>
						</tr>
					</tfoot>
				</table>
				</div>
				</div>
			</div>
			</div>
			<?php }
			$i=0;
			$rcsa=$row['rcsa_no'];$first=false;
			?>
			<div class="panel panel-white">
				<div class="panel-heading">
					<h6 class="panel-title" style="color:#000000;font-weight:bold;">
						<a data-toggle="collapse" data-parent="#accordion-controls" href="#accordion-<?=$row['rcsa_no'];?>" aria-expanded="false" class="collapsed"><?=++$no.'. '.$row['name'];?></a>
					</h6><span class="text-warning">Tgl Propose : <?=date('d M Y', strtotime($row['date_propose_kadep']));?> | Petugas : <?=$row['create_user'];?></span>
				</div>
				<div id="accordion-<?=$row['rcsa_no'];?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
				<div class="panel-body">
					<table class="table table-bordered">
						<tr style="background:#0B2161 !important; color: white">
							<td width="80%"><h4><b>Risk Top</b></h4></td>
							<td width="10%"><button class="btn btn-sm btn-danger revisi-propose pull-right" style="right:10px; top:13px;" data-id="<?=$row['rcsa_no'];?>">REVISI</button>		
							<td width="10%"><button class="btn btn-sm btn-info propose pull-right" <?=$hide;?> style="right:10px; top:13px;" data-id="<?=$row['rcsa_no'];?>">APPROVE</button>		
							</td>
						</tr>
						<tr>
							<td colspan="3">Catatan<br/>
							<?=form_textarea('note', ''," id='note_".$row['rcsa_no']."' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' ");?>
							</td>
						</tr>
					</table>
					<div style="overflow:scroll;height:600px;">
					<table class="table table-bordered table-sm table-risk-register table-scroll" id="datatables_<?=$row['rcsa_no'];?>">
						<thead>
							<tr>
								<th rowspan="2">No</th>
								<th rowspan="2" class="hide">Select</th>
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
		<?php }?>
		<tr>
			<td><?=++$i;?></td>
			<td class="hide"> <button data-urgency="<?=$row['id_rcsa_detail'];?>" data-rcsa="<?=$row['rcsa_no'];?>"  value="<?=$row['urgensi_no'];?>" class="btn btn-xs btn-success move">select</button></td>
			<td style="width: 50%"><?=$row['area_name'];?></td>
			<td><?=$row['kategori'];?></td>
			<td><?=$row['sub_kategori'];?></td>
			<td><?=$row['event_name'];?></td>
			<td><?=format_list($row['couse'], '###');?></td>
			<td><?=format_list($row['impact'], '###');?></td>
			<td> <?=$row['urgensi_no'];?> </td>
			<td><?=$row['level_like'];?></td>
			<td><?=$row['like_ket'];?></td>
			<td><?=$row['level_impact'];?></td>
			<td><?=$row['impact_ket'];?></td>
			<td><?=intval($row['level_like'])*intval($row['level_impact']);?></td>
			<td><?=$row['level_mapping'];?></td>
			<td><?=$row['penanggung_jawab'];?></td>
			<td><?=format_list($row['control_name'], '###');?></td>
			<td><?=$row['control_ass'];?></td>
			<td><?=$row['proaktif'];?></td>
			<td><?=$row['reaktif'];?></td>
			<td><?=format_list($row['accountable_unit_name'], '###');?></td>
			<td><?=$row['schedule_no'];?></td>
			<td><?=$row['target_waktu'];?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
		<tfoot>
			<tr>
				<th colspan=22>&nbsp;</th>
			</tr>
		</tfoot>
	</table>
		</div>
		</div>
	</div>
	</div>
</div>
<?php endif;?>
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
<script>
	$(document).ready(function() {
	   $('.double-scroll').doubleScroll({
			resetOnWindowResize: true,
			scrollCss: {                
				'overflow-x': 'auto',
				'overflow-y': 'hide'
			},
			contentCss: {
				'overflow-x': 'auto',
				'overflow-y': 'hide'
			},
		});
	   $(window).resize();
	});
	var arr_row = [];
	var total_row = <?php echo count($field); ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>