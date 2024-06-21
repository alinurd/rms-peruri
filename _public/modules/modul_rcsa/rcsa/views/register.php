<style>
	.double-scroll {
		width: 100%;
	}

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
</style>

<?php echo form_open(base_url('rcsa/simpan-propose'), array('id' => 'form_input_library', 'role' => 'form"'), ['id_rcsa' => $id_rcsa]); ?>
<?php
if ($status) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		<?= $field; ?>
	</div>
<?php else : ?>
	<table class="table table-bordered  ">
		<tr style="background:#0B2161 !important; color: white">
			<td colspan="3">
				<h4><b>Log Approval</b></h4>
			</td>
		</tr>
		<tr style="background:#0B2161 !important; color: white">
			<?php
			$user = $this->db->where('id', $field[0]['owner_no'])->get('bangga_owner')->row_array();

			//reviwer
			// $officer1 = $this->db->where('owner_no', 1435)->get('bangga_officer')->row_array();
			$own_rev = $this->db->where('id', 1435)->get('bangga_owner')->row_array();

			$off_rev = $this->db->where('owner_no', $own_rev['id'])->get('bangga_officer')->result_array();



			// $group = $this->db
			// ->select('bangga_groups.group_name, bangga_group_user.*')
			// ->from('bangga_group_user')
			// ->join('bangga_groups', 'bangga_group_user.group_no = bangga_groups.id')
			// ->where('bangga_group_user.user_no', $x['user_no'])
			// // ->where('bangga_group_user.group_no', 1)
			// ->get()
			// ->row_array()
			?>


			<!-- inisiator -->
			<td width="33%">
				<span><b>Inisiator:</b></span><br>
				<span> <?= $user['name'] ?><br><br>
				</span>
				<span><b>Petugas:</b></span><br>
				<span> by: </span> <br>
				<span>
					<?php
					$no = 1;
					$createdUsers = array();
					foreach ($field as $rowxx) {
						$created = $this->db
							->where('id', $rowxx['id_rcsa_detail'])
							->get('bangga_rcsa_detail')
							->row_array();
						$createUser = $created['create_user'];
						if (!in_array($createUser, $createdUsers)) {
							$createdUsers[] = $createUser; // Tambahkan create_user ke array
					?>
							-<span><?= $createUser ?></span><br>
					<?php
						}
					}
					?>
					<span> -<?= $submiter = $this->authentication->get_info_user('username'); ?> (Inisiator)</span>
				</span>
			</td>


			<td width="33%">
				<span><b>Reviewer:</b></span><br>
				<span> <?= $own_rev['name'] ?><br><br>
				</span>
				<span><b>Petugas:</b></span><br>
				<span> by: <br>
					<?php
					foreach ($off_rev as $dt) {
						// cari user yang grup nya 1 => admin aplikasi
						$group = $this->db
							->where('user_no', $dt['user_no'])
							->where('group_no', 1)
							->get('bangga_group_user')
							->row_array();

						if (!empty($group) && array_key_exists('group_no', $group)) {
							$resoff_rev = $this->db->where('user_no', $group['user_no'])->get('bangga_officer')->row_array();
							$resgrup_rev = $this->db->where('id', $group['group_no'])->get('bangga_groups')->row_array();
					?>

							-<?= $resoff_rev['officer_name'] ?> (<?= $resgrup_rev['group_name'] ?>) <br>

					<?php
						}
					}
					?>
				</span>

			</td>
			<td width="33%">
				<span><b>Approve:</b></span><br>

				<span> Risk Owner <br><?= form_dropdown('approve_owner', $cbo_owner, '',  'class="select2 form-control" style="width:100%;" id="approve_owner"' . $readonly); ?> </span><br><br>
				<span><b>Petugas:</b></span><br>
				<span class="usergas"><i>Pilih owner terlebih dahulu</i></span><br>
				<span class="approve_userrrr"> User <br><?= form_dropdown('approve_user', $cbo_user, '', 'class="select2 form-control " style="width:100%;" id="approve_user"' . $readonly); ?> </span><br>
				<br>
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
				<button class="btn btn-sm btn-info disabled simpangas pull-right" style="right:10px; top:13px;">PROPOSE</button>
				<button class="btn btn-sm btn-info simpan_propose pull-right" style="right:10px; top:13px;">PROPOSE</button>
			</td>
		</tr>
		<tr>
			<td colspan="23">
				Catatan<br />
				<?= form_textarea('note', '', " id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?>
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
				if (count($field) == 0)
					echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
				$i = 1;
				$ttl_nil_dampak = 0;
				$ttl_exposure = 0;
				$ttl_exposure_residual = 0;
				$note = '';
				foreach ($field as $keys => $row) {
					if (empty($note))
						$note = $row['note_approve_kadep'];
				?>
					<tr>
						<td><?php echo $i; ?></td>
						<td class="hide"> <button data-urgency="<?= $row['id_rcsa_detail']; ?>" value="<?= $row['urgensi_no']; ?>" class="btn btn-xs btn-success move">select</button></td>
						<td style="width: 50%"><?= $row['area_name']; ?></td>
						<td><?= $row['kategori']; ?></td>
						<td><?= $row['sub_kategori']; ?></td>
						<td><?= $row['event_name']; ?></td>
						<td><?= format_list($row['couse'], "###"); ?></td>
						<td><?= format_list($row['impact'], "###"); ?></td>
						<td valign="top"><?= ($row['risk_impact_kuantitatif']) ?></td>
						<!-- <td> - </td> -->
						<td><?= $row['level_like']; ?></td>
						<td><?= $row['like_ket']; ?></td>
						<td><?= $row['level_impact']; ?></td>
						<td><?= $row['impact_ket']; ?></td>
						<td><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
						<td><?= $row['level_mapping']; ?></td>
						<td><?= $row['penanggung_jawab']; ?></td>
						<!-- <td><?= $row['urgensi_no']; ?></td> -->
						<td><?= format_list($row['control_name'], "###"); ?></td>
						<td><?= $row['control_ass']; ?></td>
						<td><?= $row['proaktif']; ?></td>
						<td><?= $row['reaktif']; ?></td>
						<td><?= format_list($row['accountable_unit_name'], "###"); ?></td>
						<td><?= $row['sumber_daya']; ?></td>
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
	var note = '<?php echo $note; ?>';
	$(document).ready(function() {
		var parent = $(this).parent();
		var nilai = $("#approve_owner").val();
		if (!nilai) {
			nilai = 0;
		}
		var data = {
			'id': nilai,
			'kelompok': 'approve_owner'
		};
		var usergas = $(".usergas");
		var approve_user = $(".approve_userrrr");

		var btnSimpan = $(".simpan_propose"); // Select the button with class "simpan_propose"
		var simpangas = $(".simpangas"); // Select the button with class "simpan_propose"

		btnSimpan.hide(); // Hide the button
		approve_user.hide(); // Hide the button
		$("#approve_owner").change(function() {
			approve_user.show(); // Show the button
			usergas.hide(); // Show the button

			var parent = 0;
			var nilai = $(this).val();
			if (!nilai) {
				nilai = 0;
			}
			var data = {
				'id': nilai,
				'kelompok': 'approve_owner'
			};
			btnSimpan.hide(); // Hide the button

			var target_combo = $("#approve_user");
			var url = "ajax/get_approve_owner";
			cari_ajax_combo("post", parent, data, target_combo, url);
		})


		$("#approve_user").change(function() {
			var nilai = $(this).val();
			console.log(nilai);

			if (nilai > 0) {
				btnSimpan.show(); // Show the button
				simpangas.hide(); // Hide the button
			} else {
				simpangas.show(); // Show the button
				btnSimpan.hide(); // Hide the button
			}
		});



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