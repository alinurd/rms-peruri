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
		<?php if ($data) : ?>

			<?php
			$no = 0;
			foreach ($data as $row) :
				$couse 			= $row['ket_likelihood'];
				$impact 		= $row['ket_impact'];
				$inherent_level = $this->data->get_master_level(true, $row['residual_level']);
				// $residual_level = $this->data->get_master_level(true, $row['residual_level']);
				if (!$inherent_level) {
					$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}
				
				$residual_level = $this->db->select('*')->where('rcsa_detail', $row['id'])->where('bulan', $bulan)->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
				
				$cek_score 				= $this->data->cek_level_new($residual_level['residual_likelihood_action'], $residual_level['residual_impact_action']);
				$residual_level_risiko  = $this->data->get_master_level(true, $cek_score['id']);
				$residual_code 			= $this->data->level_action($residual_level['residual_likelihood_action'], $residual_level['residual_impact_action']);
				$score_inh				= $this->db->select('score')->where('impact', $row['residual_impact'])->where('likelihood', $row['residual_likelihood'])->get(_TBL_LEVEL_COLOR)->row_array();
				$score_res				= $this->db->select('score')->where('impact', $residual_level['residual_impact_action'])->where('likelihood', $residual_level['residual_likelihood_action'])->get(_TBL_LEVEL_COLOR)->row_array();
				// doi::dump($residual_level_risiko);
				// doi::dump($row);
				if (!$residual_level_risiko) {
					$residual_level_risiko = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}
				$like = $this->db
				->where('id', $residual_level_risiko['likelihood'])
					->get('bangga_level')->row_array();
				
				$impactx = $this->db
				->where('id', $residual_level_risiko['impact'])
				->get('bangga_level')->row_array();

				$likeinherent = $this->db
				->where('id', $inherent_level['likelihood'])
				->get('bangga_level')->row_array();
				
				$impactinherent = $this->db
				->where('id', $inherent_level['impact'])
				->get('bangga_level')->row_array();
			?>
				<tr class="pointer sub_detail" title="klik untuk melihat detail" data-id="<?= $row['id']; ?>">
					<td class="text-center"><?= ++$no; ?></td>
					<td><?= $row['name']; ?></td>
					<td><?= $row['kategori']; ?></td>
					<td><?= $row['event_name']; ?></td>
					<td style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?> <br>[&nbsp;<?= $score_inh['score']; ?>&nbsp;]</td>
					<td style="text-align: center; background-color:<?= $residual_level_risiko['color']; ?>;color:<?= $residual_level_risiko['color_text']; ?>;"><?= $residual_level_risiko['level_mapping']; ?> <br>[&nbsp;<?= $score_res['score']; ?>&nbsp;]</td>
				</tr>
			<?php endforeach; ?>

		<?php endif; ?>
	</tbody>
	</table>
</div>


<div id="sub_detail">

</div>