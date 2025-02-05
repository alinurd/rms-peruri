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
				$residual_level = $this->data->get_master_level(true, $row['residual_level']);
				$inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				if (!$inherent_level) {
					$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}

				if (!$residual_level) {
					$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}

				$like = $this->db
				->where('id', $residual_level['likelihood'])
					->get('bangga_level')->row_array();
				
				$impactx = $this->db
				->where('id', $residual_level['impact'])
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
					<td style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?> <br>[&nbsp;<?= $likeinherent['code']; ?> x <?= $impactinherent['code']; ?>&nbsp;]</td>
					<td style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= $residual_level['level_mapping']; ?> <br>[&nbsp;<?= $like['code']; ?> x <?= $impactx['code']; ?>&nbsp;]</td>
				</tr>
			<?php endforeach; ?>

		<?php endif; ?>
	</tbody>
	</table>
</div>


<div id="sub_detail">

</div>