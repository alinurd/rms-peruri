<div class="modal modal-default" id="peristiwa_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">
					<?php if ($nilKel == 2) : ?>
						<h4 class="modal-title">Tambah Penyebab Risiko</h4>
					<?php else : ?>
						<h4 class="modal-title">Tambah Dampak Risiko</h4>
					<?php endif; ?>
				</h4>
			</div>
			<div class="modal-body">
				<div id="konten_event">
					<div class="row form-horizontal">
						<div class="form-group pull-right" style="margin-right:15px;">
							<!-- <span class="btn btn-warning close-library pointer"> Cancel </span> -->
							<span class='btn btn-success' id="add_library">Tambah</span>
						</div>
					</div>
					<br />
					<div id="listEvent">

						<table class="table data" id="datatables_event">
							<thead>
								<tr>
									<th width="10%" style="text-align:center;">No.</th>
									<!-- <th width="15%" ><?php echo lang('msg_field_pop_risk_event_type'); ?></th> -->
									<?php if ($nilKel == 2) : ?>
										<th width="60%"><?php echo lang('msg_field_pop_event_cause'); ?></th>
									<?php else : ?>
										<th width="60%"><?php echo lang('msg_field_pop_event_impact'); ?></th>

									<?php endif; ?>
									<!-- <th width="15%" ><?php echo lang('msg_field_pop_event_description_library'); ?></th> -->
									<th width="10%"><?php echo lang('msg_tombol_select'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								foreach ($field as $key => $row) {
									// $value_chek=$row['id']."#".$row['code'].' - '.$row['description'];
									$value_chek = $row['id'] . "#" . $row['code'] . ' - ' . $row['description'];
								?>
									<tr style="cursor:pointer;" data-value="<?= $value_chek; ?>">
										<td style="text-align:center;width:10%;"><?= $i; ?></td>
										<!-- <td style="width:15%;"><?php echo $row['type_kelompok']; ?></td> -->
										<td style="width:80%;text-align: justify;"><?= $row['description']; ?></td>
										<td style="text-align:center;width:10%;"><span class="btn btn-info pilih-<?= $kel; ?>" data-value="<?= $value_chek; ?>" style="padding:2px 8px;"> <?= lang('msg_tombol_select'); ?></span></td>
									</tr>
								<?php
									++$i;
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="row form-horizontal">
						<div class="form-group pull-right" style="margin-right:15px;">
							<span class="btn btn-warning close-library pointer"> Cancel </span>
						</div>
					</div>
				</div>
				<div id="konten_add_library" class="hide">
					<div class="row">
						<div clas="col-md-12 col-sm-12 col-xs-12">
							<table class="table" id="tblEvent">
								<tbody>
									<tr>
										<td style="padding-left:0px;">
											<?= $kel; ?><br />
											<?= form_textarea('add_event_name', '', " id='add_event_name' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'") . form_hidden(['add_kel' => $nilKel, 'add_event_no' => $event_no]); ?>
										</td>
									</tr>
									<tr>
										<td class="text-right">
											<span class="btn btn-primary" id="simpan_library"> Simpan </span>
											<span class="btn btn-warning" id="cancel_library"> Cancel </span>
										</td>
									</tr>
								</tbody>
							</table>';
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
		$(document).ready(function() {
		$('#peristiwa_modal').modal('show');
	});
	$(document).on("click", ".close", function() {
		$('#input_peristiwa').addClass('show');

	});
	loadTable('', 0, 'datatables_event');
</script>