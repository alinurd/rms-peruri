<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tes1">
		<caption class="text-center" style="font-size:18px;">
			CORPORATE RISK MAP PERUM PERURI<br />
			<caption>
			<thead>
		<tr>
			<th class="text-center" rowspan="2" width="2%">No.</th>
			<th class="text-center" rowspan="2">Risk Owner</th>
			<th class="text-center" rowspan="2">Kategori</th>
			<th class="text-center" rowspan="2">Peristiwa Risiko</th>
			<th class="text-center" rowspan="2">Inherent</th>
			<th class="text-center" rowspan="2">Residual</th>
		</tr>

	</thead>
	<tbody>
			<?php
			$no = 0;
			foreach ($data as $row) :
				$couse 			= $row['ket_likelihood'];
				$impact 		= $row['ket_impact'];
				$inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				$likeinherent 	= $this->db
					->where('id', $inherent_level['likelihood'])
					->get('bangga_level')->row_array();

				$impactinherent = $this->db
					->where('id', $inherent_level['impact'])
					->get('bangga_level')->row_array();

				$cek_score2 			= $this->data->cek_level_new($row['residual_likelihood_action'], $row['residual_impact_action']);
            	$realisasi_level_risiko = $this->data->get_master_level(true, $cek_score2['id']);
				$realisasi_code = $this->data->level_action($row['residual_likelihood_action'], $row['residual_impact_action']);
				if ($realisasi_code['impact']['code']) {
					$realisasi 	= $realisasi_level_risiko['level_mapping'] . '<br>[ ' . $realisasi_code['impact']['code'] . '-' . $realisasi_code['like']['code'] . ' ]';
				} else {
					$realisasi 	= "<p class='text-danger'>-</p>";
				}
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
	</tbody>
	</table>
</div>
<div id="sub_detail">

</div>