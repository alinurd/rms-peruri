<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tes1">
		<caption class="text-center" style="font-size:18px;">
			CORPORATE RISK MAP PERUM PERURI<br />
        <caption>
			
        <thead>
		<tr>
			<th class="text-center" rowspan="2" width="2%">No.</th>
			<th class="text-center" rowspan="2">Risk Owner</th>
			<th class="text-center" rowspan="2">Peristiwa Risiko</th>
			<th class="text-center" rowspan="2">Bulan</th>
			<th class="text-center" rowspan="2">Target Risk</th>
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
 
			foreach ($data as $row1) :
                
                $cek_score2 			= $this->data->cek_level_new($row1['target_like'], $row1['target_impact']);
            	$target_level_risiko    = $this->data->get_master_level(true, $cek_score2['id']);
				$target_code            = $this->data->level_action($row1['target_like'], $row1['target_impact']);
				$score_inh				= $this->db->select('score')->where('impact', $row1['target_impact'])->where('likelihood', $row1['target_like'])->get(_TBL_LEVEL_COLOR)->row_array();
				if ($target_code['impact']['code']) {
					$target 	        = $target_level_risiko['level_mapping'] . '<br>[ ' . $score_inh['score'] . ' ]';
				} else {
					$target 	        = "<p class='text-danger'>-</p>";
				}

                $bulan = $row1['bulan_target'];
                $nama_bulan_display = isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : 'Bulan Tidak Valid';
            ?>
				<tr class="pointer sub_detail" title="klik untuk melihat detail" data-id="<?=$row1['id'];?>" data-bulan="<?=$row1['bulan_target'];?>" data-kel="Target">
					<td class="text-center"><?= ++$no; ?></td>
					<td><?= $row1['name']; ?></td>
					<td><?= $row1['event_name']; ?></td>
					<td class="text-center"><?=$nama_bulan_display; ?></td>
					<td style="text-align: center; background-color:<?= $target_level_risiko['color']; ?>;color:<?= $target_level_risiko['color_text']; ?>;"><?= $target; ?></td>
				</tr>
			<?php endforeach; ?>
	</tbody>
	</table>
</div>


<div id="sub_detail_target">

</div>