<?php
$jumlah = 0;
if ($level_no != 4 && $level_no != -1) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		Anda tidak memiliki kewenangan untuk mengakses modul ini<br />Modul ini hanya bisa diakses oleh Level Kepala Bagian!
	</div>
<?php
elseif ($status) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		<?= $field; ?>
	</div>
	<?php else :
	$jumlah = count($field);
	if ($sts_parent) {
	?>
		<table class="table table-bordered <?= (!$sts_parent) ? 'hide' : ''; ?>">
			<tr style="background:#0B2161 !important; color: white">
				<td width="80%">
					<h4><b>Risk Register</b></h4>
				</td>
				<td width="10%"><button class="btn btn-sm btn-danger revisi-propose pull-right" style="right:10px; top:13px;" data-id="<?= $rcsa_no; ?>" data-owner="<?= $owner_no; ?>">REVISI</button>
				<td width="10%"><button class="btn btn-sm btn-info propose pull-right" style="right:10px; top:13px;" data-id="<?= $rcsa_no; ?>" data-owner="<?= $owner_no; ?>">PROPOSE</button>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					Catatan<br />
					<?= form_textarea('note', '', " id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?>
				</td>
			</tr>
		</table>
	<?php
	} else { ?>
		<div class="well well-sm text-centre text-danger" style="font-size:18px;">
			Jabatan Kepala Divisi masih kosong, silahkan hubungi Admin!
		</div>
	<?php } ?>
	<div class="col-12 hide" style="overflow-x: auto">
		<table class="table table-bordered table-sm table-top-ten hide" id="datatables_event">
			<thead>
				<tr>
					<th rowspan="2">No</th>
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
		<div class="well well-sm text-centre">
			<center>
				Pilih data event dibawah yang akan di Propose ke Kadiv!</center>
		</div>
	</div>

	<table class="table table-borderless">
		<tr>
			<td width="15%"><button class="btn btn-sm btn-primary" id="show_info" title="Lihat data risk content" data-id="<?= $rcsa_no; ?>"> Lihat Konteks Risiko </button>
			<td width="65%"><b>&nbsp;</b></td>
			<td width="15%"><button class="btn btn-sm btn-danger pull-right hide" id="edit_register" title="Edit Risk Register"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-sm btn-warning pull-right hide" title="batalkan perubahan" id="cancel_register"><i class="fa fa-refresh"></i></button>
				<button class="btn btn-sm btn-info pull-right hide" title="simpan perubahan" id="simpan_register"><i class="fa fa-save"></i></button>
			</td>
		</tr>
	</table>
	<div class="double-scroll col-12" style='height:550px;'>
		<table class="table table-bordered table-sm table-risk-register  table-scroll" id="datatables_event">
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
					<th rowspan="2" class="hide"><label>Urgensi</label></th>
					<th rowspan="1" colspan="6"><label>Analisis Risiko</label></th>
					<th rowspan="1" colspan="3"><label>Evaluasi Risiko</label></th>
					<th rowspan="1" colspan="2"><label>Treatment Risiko</label></th>
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
				if (count($field) == 0)
					echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
				$i = 1;
				$ttl_nil_dampak = 0;
				$ttl_exposure = 0;
				$ttl_exposure_residual = 0;
				$note = '';
				foreach ($field as $keys => $row) {
					if (empty($note))
						$note = $row['note_approve_kadiv'];
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td class="hide"> <button data-urgency="<?= $row['id_rcsa_detail']; ?>" data-rcsa="<?= $row['rcsa_no']; ?>" value="<?= $row['urgensi_no']; ?>" class="btn btn-xs btn-success move">select</button></td>
						<td style="width: 50%"><?= $row['area_name']; ?></td>
						<td><?= $row['kategori']; ?></td>
						<td><?= $row['sub_kategori']; ?></td>
						<td><?= $row['event_name']; ?></td>
						<?php
						$a = $row['couse'];
						if (!empty($a)) {
							$tmp[4] = format_list($a, "### ");
						} else {
							$tmp[4] = $a;
						}
						$b = $row['impact'];
						if (!empty($b)) {
							$tmp[5] = format_list($b, "### ");
						} else {
							$tmp[5] = $b;
						}
						?>
						<td><?= $tmp[4]; ?></td>
						<td><?= $tmp[5]; ?></td>
						<td valign="top"><?= ($row['risk_impact_kuantitatif'])?></td>
						<!-- 					<td><?= format_list($row['couse'], "###"); ?></td>
					<td><?= format_list($row['impact'], "###"); ?></td> -->
						<td class="hide"> <?= $row['urgensi_no']; ?> </td>
						<td><?= $row['level_like']; ?></td>
						<td><span class="statis"><?= $row['like_ket'] . '</span>' . form_dropdown('likelihood[]', $cboLike, $row['inherent_likelihood'], 'class="hide input_register likelihood" style="width:100% !important"') . form_hidden(['detail_no[]' => $row['id_rcsa_detail'], 'action_no[]' => $row['id_rcsa_action'], 'inherent_level[]' => $row['inherent_level']]); ?></td>
						<td><?= $row['level_impact']; ?></td>
						<td><span class="statis"><?= $row['impact_ket'] . '</span>' . form_dropdown('impact[]', $cboImpact, $row['inherent_impact'], 'class="hide input_register impact" style="width:100% !important"'); ?></td>
						<td><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
						<td><span class="mapping"><?= $row['level_mapping']; ?></span></td>
						<td><?= $row['penanggung_jawab']; ?></td>
						<!-- <td><?= $row['urgensi_no']; ?></td> -->
						<?php
						$cn = $row['control_name'];
						if (!empty($cn)) : ?>
							<td><?= format_list($cn, "###"); ?></td>

						<?php else : ?>
							<td><?= $cn; ?></td>
						<?php endif; ?>
						<!-- <td><?= format_list($row['control_name'], "###"); ?></td> -->
						<td><?= $row['control_ass']; ?></td>
						<td><span class="statis"><?= $row['proaktif'] . '</span>' . form_textarea('proaktif[]', $row['proaktif'], " id='proaktif' maxlength='1000' size=1000  class='form-control hide input_register' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?></td>
						<td><span class="statis"><?= $row['reaktif'] . '</span>' . form_textarea('reaktif[]', $row['reaktif'], " id='reaktif' maxlength='1000' size=1000  class='form-control hide input_register' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?></td>
						<td><?= format_list($row['accountable_unit_name'], "###"); ?></td>
						<td><?= $row['sumber_daya']; ?></td>
						<?php $originalDate = $row['target_waktu'];  ?>
						<td valign="top"><?= $newDate = date("d-m-Y", strtotime($originalDate)); ?></td>
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
		thead th,
		tfoot th {
			font-size: 12px;
			padding: 5px !important;
			text-align: center;
		}

		.w250 {
			width: 250px;
		}

		.w150 {
			width: 150px;
		}

		.w100 {
			width: 100px;
		}

		.w80 {
			width: 80px;
		}

		.w50 {
			width: 50px;
		}

		td ol {
			padding-left: 10px;
			width: 300px;
		}

		td ol li {
			margin-left: 5px;
		}

		tbody {
			transition: height .5s;
		}
	</style>
<?php endif; ?>
<script>
	var master_level = '<?php echo $master_level; ?>';
	var note = '<?php echo $note; ?>';
	var data_master_level = $.parseJSON(master_level);
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
	var total_row = <?php echo $jumlah; ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>