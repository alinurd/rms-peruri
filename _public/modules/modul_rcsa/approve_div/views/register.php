<?php
$hide = '';
if (!isset($jml))
	$jml = 0;
if ($jml_propose < $jml) {
	$hide = ' disabled="disabled" ';
}
if ($status) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		<?= $field; ?>
	</div>
<?php else : ?>
	<div class="panel-group accordion-sortable content-group-lg ui-sortable" id="accordion-controls">
		<?php
		$rcsa = 0;
		$first = true;
		$no = 0;

		foreach ($field as $keys => $row) :
			if ($rcsa !== $row['rcsa_no']) {
				$residual_level = $this->data->get_master_level(true, $row['residual_level']);
						$inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
						$control_as = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
						$pic = $this->db->where('id', $row['pic'])->get('bangga_owner')->row_array();
		
						$like = $this->db
							->where('id', $residual_level['likelihood'])
							->get('bangga_level')->row_array();
		
						$impact = $this->db
							->where('id', $residual_level['impact'])
							->get('bangga_level')->row_array();
						// doi::dump($impact['level']);
						$likeinherent = $this->db
							->where('id', $inherent_level['likelihood'])
							->get('bangga_level')->row_array();
		
						$impactinherent = $this->db
							->where('id', $inherent_level['impact'])
							->get('bangga_level')->row_array();

							$act = $this->db
							->where('rcsa_detail_no', $row['id'])
							->get('bangga_rcsa_action')->result_array();
						
						$treatments = [];
						$kategori = [];
						$d_id_action = []; 
						
						// Pastikan $act tidak kosong
						if (!empty($act)) {
							foreach ($act as $item) {
								// Cek kondisi untuk proaktif dan reaktif
								if (!empty($item['proaktif']) && empty($item['reaktif'])) {
									$treatments[] = $item['proaktif']; // Tambahkan proaktif ke array
									$kategori[] = 'Proaktif'; // Tambahkan proaktif ke array
									$d_id_action[] = $item['id']; // Tambahkan ID ke array (gunakan [] untuk menambahkan)
								} elseif (!empty($item['reaktif']) && empty($item['proaktif'])) {
									$treatments[] = $item['reaktif']; // Tambahkan reaktif ke array
									$kategori[] = 'Reaktif'; // Tambahkan reaktif ke array
									$d_id_action[] = $item['id']; // Tambahkan ID ke array
								} else {
									$treatments[] = $item['proaktif']; // Atau bisa juga $item['reaktif'] jika ingin
									$kategori[] = 'Keduanya'; // Atau bisa juga $item['reaktif'] jika ingin
									$d_id_action[] = $item['id']; // Tambahkan ID ke array
								}
							}
						} else {
							$treatments = ''; // Atau nilai default lainnya jika tidak ada hasil
							$kategori = ''; // Set kategori ke string kosong atau nilai default
							$d_id_action = ''; // Set ID action ke string kosong atau nilai default
						}
				if (!$first) { ?>
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
				$i = 0;
				$rcsa = $row['rcsa_no'];
				$first = false;
?>
<div class="panel panel-white">
	<div class="panel-heading">
		<h6 class="panel-title" style="color:#000000;font-weight:bold;">
			<a data-toggle="collapse" data-parent="#accordion-controls" href="#accordion-<?= $row['rcsa_no']; ?>" aria-expanded="true" class="in collapsed"><?= ++$no . '. ' . $row['name']; ?></a>
		</h6>
		<span class="text-warning">Tgl Propose : <?= date('d M Y', strtotime($log['create_date'])); ?> | Petugas : <?= $log['create_user']; ?></span>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<tr style="background:#0B2161 !important; color: white">
				<td width="80%">
					<h4><b>Top Risk</b></h4>
				</td>
				<td width="10%"><button class="btn btn-sm btn-danger   pull-right" style="right:10px; top:13px;" id="popup" data-id="<?= $rcsa_no; ?>">REJECT</button>
				<td width="10%"><button class="btn btn-sm btn-info propose pull-right" style="right:10px; top:13px;" data-id="<?= $rcsa_no; ?>">APPROVE</button>
				</td>
			</tr>
			<tr>
				<td colspan="3">Catatan<br />
					<!-- <?= form_textarea('note', '', " id='note_" . $row['rcsa_no'] . "' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?> -->
					<?= form_textarea('note', '', " id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?>
				</td>
			</tr>
		</table>
		<button class="btn btn-sm btn-primary" id="show_info" title="Lihat data risk content" data-id="<?= $rcsa_no; ?>"> Lihat Konteks Risiko </button>
		<!-- <div style="overflow-x:scroll;"> -->
		<div class="double-scroll col-12" style='height:550px;'>
			<table class="table table-bordered table-sm table-risk-register table-scroll" id="datatables_<?= $row['rcsa_no']; ?>">
				<thead>
					<tr>
						<th rowspan="2">No</th>
						<th rowspan="2">&nbsp;</th>
						<th rowspan="2" class="hide">Select</th>
						<th rowspan="2"><label class="w150">Area</label></th>
						<th rowspan="2"><label>Kategori</label></th>
						<th rowspan="2"><label>Sub Kategori</label></th>
						<th rowspan="2"><label class="w250">Risiko</label></th>
						<th rowspan="2"><label class="w250">Penyebab</label></th>
						<th rowspan="2"><label class="w250">Akibat</label></th>
						<th rowspan="2"><label>Urgensi</label></th>
						<th rowspan="1" colspan="6"><label>Analisis Risiko</label></th>
						<th rowspan="1" colspan="3"><label>Evaluasi Risiko</label></th>
						<th rowspan="1" colspan="2"><label>Treatment Risiko</label></th>
						<!-- <th rowspan="2"><label class="w100">Accountable Unit</label></th>
						<th rowspan="2"><label class="w80">Sumber Daya</label></th>
						<th rowspan="2"><label class="w80">Deadline</label></th> -->
					</tr>
					<tr>
						<th colspan="2">Probabilitas</th>
						<th colspan="2">Impact</th>
						<th colspan="2">Risk Level</th>
						<th><label class="w150">PIC</label></th>
						<th>Existing Control</th>
						<th>Risk Control<br>Assessment</th>
						<th><label class="w250">Program Perlakuan Risiko (Risk Treatment)</label></th>
						<th><label>Kategori Treatment (Treatment Category)</label></th>
					</tr>
				</thead>
				<tbody id="risk-register">
				<?php } ?>
				<tr>
					<td><?= ++$i; ?></td>
					<td><i class="pointer text-danger icon-square-up" title=" Pindah posisi Keatas "></i><i class="pointer text-primary icon-square-down" title=" Pindah posisi Kebawah "></i> </td>
					<td class="hide"> <button data-urgency="<?= $row['id_rcsa_detail']; ?>" data-rcsa="<?= $row['rcsa_no']; ?>" value="<?= $row['urgensi_no']; ?>" class="btn btn-xs btn-success move">select</button></td>
					<td style="width: 50%"><?= $row['area_name']; ?></td>
					<td><?= $row['kategori']; ?></td>
					<td ><?= ($row['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td>

					<!-- <td><?= $row['sub_kategori']; ?></td> -->
					<td><?= $row['event_name']; ?></td>
					<!-- 								<td><?= format_list($row['couse'], '###'); ?></td>
								<td><?= format_list($row['impact'], '###'); ?></td> -->
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
					<td class="urgensi text-center"> <?= $row['urgensi_no_kadiv']; ?> </td>
					<td valign="top" style="text-align: center;"><?= $likeinherent['code']; ?></td>
						<td valign="top" style="text-align: center;"><?= $likeinherent['level']; ?></td>
						<td valign="top" style="text-align: center;"><?= $impactinherent['code']; ?></td>
						<td valign="top" style="text-align: center;"><?= $impactinherent['level']; ?></td>
						<td valign="top" style="text-align: center;"><?= intval($likeinherent['code']) * intval($impactinherent['code']); ?></td>
						<td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?></td>
						<td valign="top"><?= $pic['name']; ?></td>

					

					<!-- <td><?= $row['penanggung_jawab']; ?></td> -->
					<?php
					$cn = $row['control_name'];
					if (!empty($cn)) : ?>
						<td><?= format_list($cn,  "###"); ?></td>

					<?php else : ?>
						<td><?= $cn; ?></td>
					<?php endif; ?>
					<!-- <td><?= format_list($row['control_name'], '###'); ?></td> -->
					<td valign="top"><?= $control_as['data']; ?></td>
					<td valign="top" width="100">
                        <?php if (!empty($treatments)): ?>
                            <table style="width: 100%;">
                                    <?php foreach ($treatments as $index => $treatment): ?>
                                        <tr>
                                            <td width="2%" style="border: none;"><?= $index + 1 .'.'; ?></td>
                                            <td style="border: none;"><?= $treatment; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </table>
                                <?php else: ?>
                            <?= '-';?>
                        <?php endif; ?>
                    </td>
                    <td valign="top">
                        <?php if (!empty($kategori)): ?>
                            <table style="width: 100%;">
                                <?php foreach ($kategori as $index => $kat): ?>
                                    <tr>
                                        <td style="border: none;"><?= $index + 1 .'.'; ?></td>
                                        <td style="border: none;"><?= $kat; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php else: ?>
                                <?= '-';?>
                        <?php endif; ?>
                    </td>
					<?php
					//  doi::dump($row);
					$act = $this->db
						->where('rcsa_detail_no', $row['id_rcsa_detail'])
						->get('bangga_rcsa_action')->row_array();


					$arrayData = json_decode($act['owner_no'], true);

					if ($arrayData !== null) {
						$owners = array();
						foreach ($arrayData as $element) {
							$element = strval($element);
							$Accountable = $this->db->where('id', $element)->get('bangga_owner')->row_array();
							if ($Accountable) {
								$owners[] = $Accountable['name'];
							}
						}

						$ownersString = implode(", ", $owners);
					} else {
						$ownersString = '-';
					}
					?>

					<!-- <td valign="top"><?= format_list($ownersString); ?></td>
					<td><?= $row['sumber_daya']; ?></td>
					<?php $originalDate = $row['target_waktu']; ?>
					<td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td> -->
				</tr>
			<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan=23>&nbsp;</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
</div>
<?php endif; ?>

<!-- Konten Popup -->
<div id="popupContent" class="custom-popup-content">

	<h3>Reject Risk Context</h3>
	<p>tambahkan catatan</p>
	<div class="row">
		<div clas="col-md-12 col-sm-12 col-xs-12">
			<table class="table table-borderless input_kri">
				<tbody>
					<tr>

						<?= form_textarea('notereject', ($detail) ? $combo['data'] : '', 'class="form-control" placeholder="Tambahkan Catatan" style="width:100%;" id="notereject"  ' . $readonly); ?> </tr>
					<input type="hidden" name="id_edit_baru" value="<?= ($rcsa_no) ? $rcsa_no : '0' ?>" class="form-control text-right" id="rcsa_no">

				</tbody>
			</table>
			<!-- <span>tanggal reject: <br><i class="text-warning"> <?= $note ?></i></span> -->
		</div>

		<div class="form-group pull-right" style="margin-right:15px;">
			<span class="btn btn-primary <?= $hidesv ?>" id="simpanreject"> Simpan </span>
			<span class="btn btn-warning custom-close-btn">&times; Cancel </span>
		</div>

	</div>
</div>

<!-- Lapisan Blur -->
<div id="custom-overlay" class="custom-overlay"></div>

<link rel="stylesheet" type="text/css" href="<?= base_url('themes/default/assets/frontend/css/custom-style.css'); ?>">

<script>
	$(document).ready(function() {
		function checkNote(value) {
			if (value.length < 5) {
				$("#simpanreject").hide();
			} else {
				$("#simpanreject").show();
			}
		}
	});


	$(document).ready(function() {
		$('.select2').select2(); // Inisialisasi plugin Select2 pada elemen dengan class "select2"
	})

	// Menampilkan Popup saat Tombol "Tampil Popup" diklik
	document.getElementById('popup').addEventListener('click', function() {
		document.getElementById('popupContent').style.display = 'block';
		document.getElementById('custom-overlay').style.display = 'block';
		document.body.style.overflow = 'hidden'; // Menghilangkan scroll pada body
	});

	// Menutup Popup saat Tombol Close di dalam Popup diklik
	document.getElementsByClassName('custom-close-btn')[0].addEventListener('click', function() {
		document.getElementById('popupContent').style.display = 'none';
		document.getElementById('custom-overlay').style.display = 'none';
		document.body.style.overflow = 'auto'; // Mengaktifkan scroll pada body kembali
	});
</script>
<style>
	thead th,
	tfoot th {
		font - size: 12 px;
		padding: 5 px !important;
		text - align: center;
	}

	.w150 {
		width: 150 px;
	}

	.w250 {
		width: 250 px;
	}

	.w100 {
		width: 100 px;
	}

	.w80 {
		width: 80 px;
	}

	.w50 {
		width: 50 px;
	}

	td ol {
		padding - left: 10 px;
		width: 300 px;
	}

	td ol li {
		margin - left: 5 px;
	}

	tbody {
		transition: height .5 s;
	}
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