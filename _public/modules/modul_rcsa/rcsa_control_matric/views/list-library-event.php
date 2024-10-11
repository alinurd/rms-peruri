<h4 class="modal-title"> Peristiwa Risiko</h4>

<div id="konten_event">
	<div class="row form-horizontal">
		<div class="form-group pull-right" style="margin-right:15px;">
			<span class='btn btn-success' id="add_library">Tambah</span>
			<span class="btn btn-warning close-library pointer"> Cancel </span>
		</div>
	</div>
	<br />
	<div id="listEvent">

		<table class="table data" id="datatables_event">
			<thead>
				<tr>
					<th width="10%" style="text-align:center;">No.</th>
					<th width="60%">Peristiwa Risiko</th>
					<th width="60%">Jml Couse</th>
					<th width="60%">Jml Impact</th>
					<th width="10%"><?php echo lang('msg_tombol_select'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($field as $key => $row) {
					$value_chek = $row['id'] . "#" . $row['code'] . ' - ' . $row['description'];
					$c = $this->db->select('COUNT(library_no) AS count')
						->where('type', 2)
						->where('status', 1)
						->where('library_no', $row['id'])
						->get('bangga_view_library')
						->row_array();
					$im = $this->db->select('COUNT(library_no) AS count')
						->where('type', 3)
						->where('status', 1)
						->where('library_no', $row['id'])
						->get('bangga_view_library')
						->row_array();

				?>
					<tr style="cursor:pointer;" data-value="<?= $value_chek; ?>">
						<td style="text-align:center;width:10%;"><?= $i; ?></td>
						<td style="width:80%;text-align: justify;"><?= $row['description']; ?></td>
						<td style="width:80%;text-align:justify;"><?= $c['count']; ?></td>
						<td style="width:80%;text-align:justify;"><?= $im['count']; ?></td>
						<td style="text-align:center;width:10%;"><span class="btn btn-info pilih-event" data-value="<?= $value_chek; ?>" style="padding:2px 8px;"> <?= lang('msg_tombol_select'); ?></span></td>
					</tr>
				<?php
					++$i;
				}
				?>
			</tbody>
		</table>
	</div>
</div>





<div id="konten_add_library" class="hide">
	<h6> <i>Tambah Data Baru</i></h6>

	<div class="row form-horizontal">
		<div class="form-group pull-right" style="margin-right:15px;">
			<span class="btn btn-primary" id="simpan_library"> Simpan </span>
			<span class="btn btn-warning" id="cancel_library"> Cancel </span>
		</div>
	</div>
	<div class="row">
		<div clas="col-md-12 col-sm-12 col-xs-12">
			<Span>Nama Peristiwa</Span>
			<?= form_textarea('add_event_name', '', " id='add_event_name' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['add_kel' => $nilKel, 'add_event_no' => $event_no]); ?>
			<br>
			<div class="couseee">
				<table class="table" id="instlmt_cause">
					<thead>
						<tr>
							<th width="10%" style="text-align:center;">No.</th>
							<th>Risk Cause</th>
							<th width="10%" style="text-align:center;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;width:10%;">1</td>
							<td><?php echo $cbo; ?></td>
							<td style="text-align:center;width:10%;">
								<a nilai="<?php echo $row['edit_no']; ?>" style="cursor:pointer;" onclick="remove_install(this,<?php echo $row['edit_no']; ?>)">
									<i class="fa fa-cut" title="menghapus data"></i>
								</a>
							</td>
						</tr>
						<?php
						$cbbo = $cbbo;
						$edit = form_hidden('id_edit[]', '0');
						$cbn = form_input('', '', ' id="new_cause[]" name="new_cause[]" class="form-control"');
						?>
					</tbody>
				</table>
				<center>
					<span class="btn btn-info" id="add_cause_news"> Library Couse </span>
					<span class="btn btn-info" id="add_new_cause"> Couse New </span>
				</center>

			</div>

			<br>
			<div class="impact">
				<table class="table" id="instlmt_impact">
					<thead>
						<tr>
							<th width="10%" style="text-align:center;">No.</th>
							<th>Risk Impact</th>
							<th width="10%" style="text-align:center;">Aksi</th>
						</tr>
					</thead>
					<tbody>

						<tr>
							<td style="text-align:center;width:10%;"><?php echo $i . $edit; ?></td>
							<td><?php echo $cbo1; ?></td>
							<td style="text-align:center;width:10%;"><a nilai="<?php echo $row['edit_no']; ?>" style="cursor:pointer;" onclick="remove_install(this,<?php echo $row['edit_no']; ?>)"><i class="fa fa-cut" title="menghapus data"></i></a></td>
						</tr>
						<?php
						$cbbi = $cbbii;
						$edit = form_hidden('id_edit[]', '0');
						$cbi = form_input('', '', ' id="new_impact" name="new_impact[]" class="form-control"');
						?>
					</tbody>
				</table>

				<center>
					<input id="add_impact" class="btn btn-info" type="button" onclick="add_install_impact()" value="Library Impact " name="add_impact">
					<button id="add_new_impact" class="btn btn-info" type="button" onclick="add_new_install_impact()" value="Impact New" name="add_new_impact"> Impact New </button>
				</center>

			</div>
		</div>
	</div>


</div>

<script type="text/javascript">
	loadTable('', 0, 'datatables_event');
	var no_urut = 1;
	var cbiImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbi)); ?>';
	var cboImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbi)); ?>';
	var editImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';


	var cbnCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbn)); ?>';
	var cboCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbo)); ?>';
	var editCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';
</script>