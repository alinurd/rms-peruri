<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tes1">
		<caption class="text-center" style="font-size:18px;">
			CORPORATE RISK MAP PERUM PERURI<br />
			<caption>
			<thead>
		<tr>
			<th class="text-center" rowspan="2" width="2%">No.</th>
			<th class="text-center" rowspan="2">Risk Owner</th>
			<th class="text-center" rowspan="2">Urut</th>
			<th class="text-center" rowspan="2">Kategori</th>
			<th class="text-center" rowspan="2">Peristiwa Risiko</th>
			<th class="text-center" rowspan="2">Bulan</th>
			<th class="text-center" rowspan="2">Inherent</th>
			<th class="text-center" rowspan="2">Residual</th>
		</tr>

	</thead>
	<tbody>
			<?php
			$nama_bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
			$no = 0;
			foreach ($data as $row) :
				$couse 			= $row['ket_likelihood'];
				$impact 		= $row['ket_impact'];
				// $inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				$inherent_level = $this->data->get_master_level(true, $row['residual_level']);
				if (!$inherent_level) {
					$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}
				$likeinherent 	= $this->db
					->where('id', $inherent_level['likelihood'])
					->get('bangga_level')->row_array();

				$impactinherent = $this->db
					->where('id', $inherent_level['impact'])
					->get('bangga_level')->row_array();

				$score_inh				= $this->db->select('score')->where('impact', $row['residual_impact'])->where('likelihood', $row['residual_likelihood'])->get(_TBL_LEVEL_COLOR)->row_array();
				$cek_score2 			= $this->data->cek_level_new($row['residual_likelihood_action'], $row['residual_impact_action']);
            	$realisasi_level_risiko = $this->data->get_master_level(true, $cek_score2['id']);
				$realisasi_code 		= $this->data->level_action($row['residual_likelihood_action'], $row['residual_impact_action']);
				$score_res				= $this->db->select('score')->where('impact', $row['residual_impact_action'])->where('likelihood', $row['residual_likelihood_action'])->get(_TBL_LEVEL_COLOR)->row_array();
				if ($realisasi_code['impact']['code']) {
					$realisasi 	= $realisasi_level_risiko['level_mapping'] . '<br>[ ' . $score_res['score'] . ' ]';
				} else {
					$realisasi 	= "<p class='text-danger'>-</p>";
				}
				$bulan = $row['bulan'];
                $nama_bulan_display = isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : 'Bulan Tidak Valid';
 			?>
				<tr class="pointer sub_detail" title="klik untuk melihat detail" data-id="<?= $row['id']; ?>">
					<td class="text-center"><?= ++$no; ?></td>
 					<td><?= $row['name']; ?></td>
					 <td class="text-center"><?= $row['norut']; ?></td>
					 <td><?= $row['kategori']; ?></td>
					 <td><?= $row['event_name']; ?></td>
					 <td><?= $nama_bulan_display; ?></td>

					<td style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?> <br>[&nbsp;<?=$score_inh['score'];?>&nbsp;]</td>

					<td style="text-align: center; background-color:<?= $realisasi_level_risiko['color']; ?>;color:<?= $realisasi_level_risiko['color_text']; ?>;"><?= $realisasi; ?></td>


				</tr>
			<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div id="sub_detail">

</div>