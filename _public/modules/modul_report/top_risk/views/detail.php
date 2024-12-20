<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tes1">
		<caption class="text-center" style="font-size:18px;">
			CORPORATE RISK MAP PERUM PERURI<br />
			<!-- 			Level Akibat = <strong><span id="couse">-</span></strong>, Level Probabilitas = <strong><span id="impact">-</span></strong> -->
			<caption>
			<thead>
				<?php if ($kel == "inherent") : ?>
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
			<th class="text-center" rowspan="2">Target</th>
			<th class="text-center" rowspan="2">Realisasi</th>
			<th class="text-center" rowspan="2">Tanggal Monitoring</th>
		</tr>
	<?php endif; ?>
	</thead>
	<tbody>
		<?php if ($kel == "inherent") : ?>
			<?php
			$no = 0;
			foreach ($data as $row) :
				$couse = $row['ket_likelihood'];
				$impact = $row['ket_impact'];
				
				$residual_level = $this->data->get_master_level(true, $row['residual_level']);
				$inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				// var_dump($a);
				if (!$inherent_level) {
					$inherent_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}

				if (!$residual_level) {
					$residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}


				// var_dump($value['rcsa_detail_no']);
				// die();

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
				// doi::dump($rows);
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

		<?php else : ?>

			<?php
			$no = 0;

			foreach ($data['bobo'] as $row1) : ?>
			<?php 
			 $realisasi = $this->db->select('*')->where('rcsa_detail_no', $row1['id_detail'])->where('bulan', $row1['bulan'])
			 ->get("bangga_view_rcsa_action_detail")
			 ->row_array();
			//  echo $this->db->last_query();
			//  doi::dump($realisasi);

				$tlike = $this->db
				->where('id', $row1['target_like'])
					->get('bangga_level')->row_array();
				
				$timpact = $this->db
				->where('id', $row1['target_impact'])
				->get('bangga_level')->row_array();



				$rlike = $this->db
				->where('id', $realisasi['residual_likelihood_action'])
					->get('bangga_level')->row_array();
				
				$rimpact = $this->db
				->where('id', $realisasi['residual_impact_action'])
				->get('bangga_level')->row_array();

				$target  		= $this->db->where('impact_no', $timpact['id'])->where('like_no', $tlike['id'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
				$realisasi1 	= $this->db->where('impact_no', $rimpact['id'])->where('like_no', $rlike['id'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
				// $inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
				// var_dump($a);
				if (!$target) {
					$target = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}
				if (!$realisasi1) {
					$realisasi1 = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
				}

			// doi::dump($target);
			?>
				<tr>
					<td class="text-center"><?= ++$no; ?></td>
					<td><?= $row1['name']; ?></td>
					<td><?= $row1['event_name']; ?></td>
					<td style="text-align: center; background-color:<?= $target['warna_bg']; ?>;color:<?= $target['warna_txt']; ?>;"><?= $target['tingkat']; ?> <br>[&nbsp;<?= $timpact['code']; ?> x <?= $tlike['code']; ?>&nbsp;]</td>
					<td style="text-align: center; background-color:<?= $realisasi1['warna_bg']; ?>;color:<?= $realisasi1['warna_txt']; ?>;"><?= $realisasi1['tingkat']; ?> <br>[&nbsp;<?= $rimpact['code']; ?> x <?= $rlike['code']; ?>&nbsp;]</td>
					<td style=" text-align: center;"><?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English'); ?><?= strftime("%d %B %Y %H:%M", strtotime($row1['create_date'])); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
	</table>
</div>
<div id="sub_detail">

</div>