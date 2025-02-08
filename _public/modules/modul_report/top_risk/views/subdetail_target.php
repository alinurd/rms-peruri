<style type="text/css">
    ol{
        padding: 10px;
    }
</style>

<div class="table-responsive" >
    <strong>List Risk Context</strong><br/>
    <table class="table table-bordered table-hover">
		<tbody>
			<tr><td width="20%">Sasaran</td><td><?=$data['sasaran'];?></td></tr>
			<tr><td>Peristiwa</td><td><?=$data['event_name'];?></td></tr>
			<tr><td>Penyebab</td><td><?=$data['couse'];?></td></tr>
			<tr><td>Dampak</td><td><?=$data['impact'];?></td></tr>
			<tr>
                <td>Existing Control</td>
                <?php 
                    $arrCouse =json_decode($data['note_control'], true);
                    $name_control = implode('### ', $arrCouse);
                 ?>
                <!-- <td><?= $hasil; ?></td> -->
                 
                <td><?= format_list($name_control, "### "); ?></td>
            </tr>
            <!-- <tr><td>Note Control</td><td><?=$data['note_control'];?></td></tr> -->
			<tr><td>Risk Control Assessment</td><td><?=$data['risk_control'];?></td></tr>
			<tr><td>Risk Treatment</td><td><?=$data['treatment'];?></td></tr>
		</tbody>
	</table>
    
    <br>
        <strong>Realisasi Level Risiko</strong><br/>
    <?php
        // Array untuk mapping angka bulan ke nama bulan
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
    ?>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" width="2%">No</th>
            <th class="text-center" width="10%">Bulan</th>
            <th class="text-center" width="20%">Target Level Risiko</th>
            <th class="text-center" width="20%">Realisasi Level Risiko</th>
            <th class="text-center" width="20%">Tanggal Monitoring</th>
            <th class="text-center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $sub_no = 1;
        foreach ($target_level as $target_level_item) {
            // Cek skor untuk target level
            $cek_score1 = $this->data->cek_level_new($target_level_item['target_like'], $target_level_item['target_impact']);
            $target_level_risiko = $this->data->get_master_level(true, $cek_score1['id']);
            $target_code = $this->data->level_action($target_level_item['target_like'], $target_level_item['target_impact']);
            $score_target				= $this->db->select('score')->where('impact', $target_level_item['target_impact'])->where('likelihood', $target_level_item['target_like'])->get(_TBL_LEVEL_COLOR)->row_array();
            // Membuat tampilan target level
            $target = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $target_level_risiko['color'] . ';color:' . $target_level_risiko['color_text'] . ';">';
            if ($target_level_risiko['level_mapping']) {
                $target .= $target_level_risiko['level_mapping'] . '<br>[' . $score_target['score'] . ']';
            } else {
                $target .= "<p class='text-danger'>Data Belum diinput</p>";
            }
            $target .= '</span>';

            // Cek realisasi level
            $realisasi_level = $this->db->select('*')
                ->where('rcsa_detail', $target_level_item['id_detail'])
                ->where('bulan', $target_level_item['bulan'])
                ->get(_TBL_RCSA_ACTION_DETAIL)
                ->row_array();

            $cek_score2 = $this->data->cek_level_new($realisasi_level['residual_likelihood_action'], $realisasi_level['residual_impact_action']);
            $realisasi_level_risiko = $this->data->get_master_level(true, $cek_score2['id']);
            $realisasi_code = $this->data->level_action($realisasi_level['residual_likelihood_action'], $realisasi_level['residual_impact_action']);
            $score_res				= $this->db->select('score')->where('impact', $realisasi_level['residual_impact_action'])->where('likelihood', $realisasi_level['residual_likelihood_action'])->get(_TBL_LEVEL_COLOR)->row_array();
            // Membuat tampilan realisasi level
            $realisasi = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $realisasi_level_risiko['color'] . ';color:' . $realisasi_level_risiko['color_text'] . ';">';
            if ($realisasi_code['impact']['code']) {
                $realisasi .= $realisasi_level_risiko['level_mapping'] . '<br>[' . $score_res['score'] . ']';
            } else {
                $realisasi .= "<p class='text-danger'>Data Belum dimonitoring</p>";
            }
            $realisasi .= '</span>';

            // Konversi angka bulan ke nama bulan
            $bulan = $target_level_item['bulan'];
            $nama_bulan_display = isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : 'Bulan Tidak Valid';

            if ($realisasi_level['residual_likelihood_action'] === $target_level_item['target_like'] && $realisasi_level['residual_impact_action'] === $target_level_item['target_impact']) {
                $status = 'Sesuai';
                $class_text = 'text-success';
            } else {
                $status = 'Tidak Sesuai';
                $class_text = 'text-danger';
            }

            // Tampilkan data dalam tabel
            ?>
            <tr>
                <td class="text-center"><?= $sub_no++; ?></td>
                <td class="text-center"><?= $nama_bulan_display; ?></td>
                <td><?= $target; ?></td>
                <td><?= $realisasi; ?></td>
                <td class="text-center"><?= ($realisasi_level['create_date']) ? date('d-m-Y', strtotime($realisasi_level['create_date'])) : "<p class='text-danger'>Data Belum dimonitoring</p>"; ?></td>
                <td class="text-center"><span class="<?= $class_text; ?>"><?= $status; ?></span></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
    
</div>
