<?php
if ($status) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		<?= $field; ?>
	</div>
<?php else : ?>
	<table class="table table-bordered">
		<tr style="background:#0B2161 !important; color: white">
			<td width="80%">
				<h4><b>Risk Top</b></h4>
			</td>
			<td><button class="btn btn-sm btn-danger revisi " id="popup" style="right:10px; top:13px;" data-id="<?= $rcsa_no; ?>">REJECT</button></td>
			<td><button class="btn btn-sm btn-info propose pull-right" style="right:10px; top:13px;" data-id="<?= $rcsa_no; ?>">APPROVE</button> </td>
		</tr>
	</table>
	<button class="btn btn-sm btn-primary" id="show_info" title="Lihat data risk content" data-id="<?= $rcsa_no; ?>"> Lihat Konteks Risiko </button>

	<!-- <div class="col-12" style="overflow-x: auto"> -->
	<div class="double-scroll col-12" style="overflow-x: auto">

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
					<th rowspan="2"><label class="w250">Akibat</label></th>
					<th rowspan="2"><label>Urgency</label></th>
					<th rowspan="1" colspan="6"><label>Analisis Risiko</label></th>
					<th rowspan="1" colspan="3"><label>Evaluasi Risiko</label></th>
					<th rowspan="1" colspan="2"><label>Treatment Risiko</label></th>
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
			<tbody id="risk-top-ten">

			</tbody>
			<tfoot>
				<tr>
					<th colspan=23>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	</div>

	<table class="table table-bordered">
		<tr style="background:#0B2161 !important; color: white">
			<td colspan="23">
				<h4><b>Risk Register</b></h4>
			</td>
		</tr>
	</table>
	<!-- <div class="col-12" style="overflow-x: auto"> -->
	<div class="double-scroll col-12" style="overflow-x: auto">
		<table class="table table-bordered table-sm table-risk-register" id="datatables_event">

			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">Select</th>
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

				<?php
				if (count($field) == 0)
					echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
				$i = 1;
				$ttl_nil_dampak = 0;
				$ttl_exposure = 0;
				$ttl_exposure_residual = 0;

				foreach ($field as $keys => $row) {
					// doi::dump($row);
					$tema               = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();
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
 				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td> <button data-urgency="<?= $row['id_rcsa_detail']; ?>" data-rcsa="<?= $row['rcsa_no']; ?>" value="<?= $row['urgensi_no_kadiv']; ?>" class="btn btn-xs btn-success move">select</button></td>
						<td style="width: 50%"><?= $row['area_name']; ?></td>
						<td><?= $tema['description']; ?></td>
						<td><?= $row['kategori']; ?></td>
						<td><?= $row['event_name']; ?></td>
						<td><?= format_list($row['couse'], "###"); ?></td>
						<td><?= format_list($row['impact'], "###"); ?></td>
						<td> <?= $row['urgensi_no_kadiv']; ?> </td>
						<!-- <td><?= $row['level_like']; ?></td>
						<td><?= $row['like_ket']; ?></td>
						<td><?= $row['level_impact']; ?></td>
						<td><?= $row['impact_ket']; ?></td>
						<td><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
						<td><?= $row['level_mapping']; ?></td> -->
						<td valign="top" style="text-align: center;"><?= $likeinherent['code']; ?></td>
						<td valign="top" style="text-align: center;"><?= $likeinherent['level']; ?></td>
						<td valign="top" style="text-align: center;"><?= $impactinherent['code']; ?></td>
						<td valign="top" style="text-align: center;"><?= $impactinherent['level']; ?></td>
						<td valign="top" style="text-align: center;"><?= intval($likeinherent['code']) * intval($impactinherent['code']); ?></td>
						<td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?></td>
						<?php
					$arrCouse = json_decode($row['penangung_no'], true);
					$rows_couse=array();
					if ($arrCouse)
					$rows_couse = $this->db->where_in('id', $arrCouse)->get(_TBL_OWNER)->result_array();
					$arrCouse=array();
					foreach($rows_couse as $rc){
						$arrCouse[]=$rc['name'];
					}
					$row['penanggung_jawab']=implode('### ',$arrCouse);
					?>
					<td valign="top"><?= $pic['name']; ?></td>
					
						<!-- <td><?= $row['urgensi_no_kadiv']; ?></td> -->
						<!-- <td><?= format_list($row['control_name'], "###"); ?></td> -->
						<?php
						$cn = $row['control_name'];
						if (!empty($cn)) : ?>
							<td><?= format_list($cn, "###"); ?></td>

						<?php else : ?>
							<td><?= $cn; ?></td>
						<?php endif; ?>
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
						<!-- <td><?= format_list($row['accountable_unit_name'], "###"); ?></td>
						<td><?= $row['sumber_daya']; ?></td>
						<?php $originalDate = $row['target_waktu']; ?>
						<td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td> -->
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


	<!-- Konten Popup -->
	<div id="popupContent" class="custom-popup-content">

		<!-- <span class="custom-close-btn" </span> -->
		<!-- d<?php doi::dump($rcsa_no); ?> -->

		<h3>Reject Risk Assessment</h3>
		<p>tambahkan catatan</p>
		<div class="row">
			<div clas="col-md-12 col-sm-12 col-xs-12">
				<table class="table table-borderless input_kri">
					<tbody>
						<tr>
							
							<?= form_textarea('note', ($detail) ? $combo['data'] : '', 'class="form-control" placeholder="Tambahkan Catatan" style="width:100%;" id="note" onkeyup="checkNote(this.value)"' . $readonly); ?> </tr>
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
	var arr_row = [];
	var total_row = <?php echo count($field); ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>
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