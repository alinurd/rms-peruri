<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tes1">
		<caption class="text-center" style="font-size:18px;">
			CORPORATE RISK MAP PERUM PERURI<br />
			<!-- 			Level Akibat = <strong><span id="couse">-</span></strong>, Level Probabilitas = <strong><span id="impact">-</span></strong> -->
			<caption>
			<thead>
				<?php if ($kel == "residual") : ?>
		<tr>
			<th class="text-center" rowspan="2" width="2%">No.</th>
			<th class="text-center" rowspan="2">Risk Owner</th>
			<th class="text-center" rowspan="2">Kategori</th>
			<th class="text-center" rowspan="2">Peristiwa Risiko</th>
			<th class="text-center" rowspan="2">Inherent</th>
			<th class="text-center" rowspan="2">Residual</th>
		</tr>
	<?php else : ?>
		<tr>
			<th class="text-center" rowspan="2" width="2%">No.</th>
			<th class="text-center" rowspan="2">Risk Owner</th>
			<th class="text-center" rowspan="2">Peristiwa Risiko</th>
			<th class="text-center" rowspan="2">Treatment</th>
			<th class="text-center" rowspan="2">Realisasi</th>
			<th class="text-center" rowspan="2">Inherent</th>
			<th class="text-center" rowspan="2">Residual</th>
			<th class="text-center" rowspan="2">Tanggal Monitoring</th>
			<th class="text-center" rowspan="2">Short Report</th>
		</tr>
	<?php endif; ?>
	</thead>
	<tbody>
		<?php if ($kel == "residual") : ?>
			<?php
			$no = 0;
			foreach ($data as $row) :
				// doi::dump($row);
				$couse = $row['ket_likelihood'];
				$impact = $row['ket_impact'];


				// $residual_level = $this->data->get_master_level(true, $row['residual_level']);
				$inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				// $like = $this->db
				// 	->where('id', $residual_level['likelihood'])
				// 	->get('bangga_level')->row_array();

				// $impactx = $this->db
				// 	->where('id', $residual_level['impact'])
				// 	->get('bangga_level')->row_array();
				$likeinherent = $this->db
					->where('id', $inherent_level['likelihood'])
					->get('bangga_level')->row_array();

				$impactinherent = $this->db
					->where('id', $inherent_level['impact'])
					->get('bangga_level')->row_array();

				$cek_score2 = $this->data->cek_level_new($row['residual_likelihood_action'], $row['residual_impact_action']);
            	$realisasi_level_risiko = $this->data->get_master_level(true, $cek_score2['id']);
				$realisasi_code = $this->data->level_action($row['residual_likelihood_action'], $row['residual_impact_action']);
				if ($realisasi_code['impact']['code']) {
					$realisasi = $realisasi_level_risiko['level_mapping'] . '<br>[ ' . $realisasi_code['impact']['code'] . '-' . $realisasi_code['like']['code'] . ' ]';
				} else {
					$realisasi = "<p class='text-danger'>-</p>";
				}

				// doi::dump($residual_level);
			?>
				<tr class="pointer sub_detail" title="klik untuk melihat detail" data-id="<?= $row['id']; ?>">
					<td class="text-center"><?= ++$no; ?></td>
					<td><?= $row['name']; ?></td>
					<td><?= $row['kategori']; ?></td>
					<td><?= $row['event_name']; ?></td>

					<td style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?> <br>[&nbsp;<?= $likeinherent['code']; ?> x <?= $impactinherent['code']; ?>&nbsp;]</td>

					<td style="text-align: center; background-color:<?= $realisasi_level_risiko['color']; ?>;color:<?= $realisasi_level_risiko['color_text']; ?>;"><?= $realisasi; ?></td>


				</tr>
			<?php endforeach; ?>

		<?php else : ?>

			<?php
			$no = 0;

			foreach ($data['bobo'] as $row1) : ?>
				<tr>
					<td class="text-center"><?= ++$no; ?></td>
					<td><?= $row1['owner_name']; ?></td>
					<td><?= $row1['event_name']; ?></td>
					<td><?= $row1['type_name']; ?></td>
					<td><?= $row1['realisasi']; ?></td>
					<?php
					$a = $data['baba'][$row1['rcsa_detail_no']]['residual_analisis'];
					$b = $data['baba'][$row1['rcsa_detail_no']]['warna'];
					$c = $data['baba'][$row1['rcsa_detail_no']]['warna_text'];
					?>
					<td style="background-color:<?= $b; ?>;color:<?= $c; ?>;"><?= $a; ?></td>
					<td style=" text-align: center;background-color:<?= $row1['warna_action']; ?>;color:<?= $row1['warna_text_action']; ?>;"><?= $row1['residual_analisis_action']; ?></td>

					<td style=" text-align: center;"><?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English'); ?><?= strftime("%d %B %Y %H:%M", strtotime($row1['create_date'])); ?></td>
					<td class="text-center">
						<?php if ($row1['status_no'] == 1) : ?>
							<span style="background-color:blue;color:white;">&nbsp;Close &nbsp;</span>
						<?php elseif ($row1['status_no'] == 2) : ?>
							<span style="background-color:blue;color:white;">&nbsp;On Progress &nbsp;</span>
						<?php elseif ($row1['status_no'] == 3) : ?>
							<span style="background-color:red;color:white;">&nbsp;Add &nbsp;</span>
						<?php else : ?>
							<span style="background-color:blue;color:white;">&nbsp;Open &nbsp;</span>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
	</table>
</div>
<div id="sub_detail">

</div>