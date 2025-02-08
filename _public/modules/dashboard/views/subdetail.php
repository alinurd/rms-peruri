<style type="text/css">
    ol{
        padding: 10px;
    }
</style>

<div class="table-responsive" >
    <strong>List Risk Context</strong><br/>
    <table class="table table-bordered table-hover">
		<tbody>
			<tr><td width="25%">Sasaran</td><td><?=$data['sasaran'];?></td></tr>
			<tr><td>Peristiwa</td><td><?=$data['event_name'];?></td></tr>
			<tr><td>Penyebab</td><td><?=$data['couse'];?></td></tr>
			<tr><td>Dampak</td><td><?=$data['impact'];?></td></tr>
			<tr>
                <td>Existing Control</td>
                <?php 
                    $arrCouse =json_decode($data['note_control'], true);
                    $name_control = implode('### ', $arrCouse);
                 ?>                 
                <td><?= format_list($name_control, "### "); ?></td>
            </tr>
			<tr><td>Risk Control Assessment</td><td><?=$data['risk_control'];?></td></tr>
			<tr><td>Risk Treatment</td><td><?=$data['treatment'];?></td></tr>
		</tbody>
	</table>

    <br>
    <strong>List Risk Treatment</strong><br/>
    <table class="table table-bordered table-hover" style="table-layout: fixed; width: 100%;">
    <thead>
        <tr>
            <th class="text-center" width="5%">No</th>
            <th width="25%"  class="text-center">Mitigasi / Treatment</th>
            <th width="15%"  class="text-center">Kategori</th>
            <th width="10%" class="text-center">Target Progress</th>
            <th width="15%"  class="text-center">Treatment Lost</th>
            <th width="10%" class="text-center">Target Waktu</th>
            <th width="10%"  class="text-center">Realisasi</th>
            <th width="10%"  class="text-center">Damp Lost</th>
            <th width="10%" class="text-center">Tanggal Monitoring</th>
            <th width="15%"  class="text-center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        foreach ($mitigasi as $row):
            $rows = $this->db->where('id_rcsa_action', $row['id'])->order_by('bulan', 'ASC')->get(_TBL_RCSA_TREATMENT)->result_array();
        ?>
            <!-- Parent Row -->
            <tr data-toggle="collapse" data-target="#collapse<?= $row['id']; ?>" class="accordion-toggle" style="cursor: pointer;">
                <td colspan="10" style="background-color:#d5edef;">
                    <?php
                    if (!empty($row['proaktif'])) {
                        echo $row['proaktif'];
                    } elseif (!empty($row['reaktif'])) {
                        echo $row['reaktif'];
                    }
                    ?>
                </td>
            </tr>
            <!-- Child Rows -->
            <tr>
                <td colspan="10" class="hiddenRow" style="margin: 0px; padding:0px;">
                    <div class="collapse" id="collapse<?= $row['id']; ?>">
                        <table class="table table-bordered table-hover" style="table-layout: fixed; width: 100%;">
                            <tbody>
                                <?php
                                $no_b = 1;
                                foreach ($rows as $sub_row):
                                    $periode = $this->db->select('periode_name')->where('id', $row['period_no'])->get(_TBL_PERIOD)->row_array();
                                    $realisasi = $this->db->select('progress_detail,target_progress_detail,create_date as tanggal_monitoring')->where('rcsa_action_no', $sub_row['id_rcsa_action'])->where('bulan', $sub_row['bulan'])->get(_TBL_RCSA_MONITORING_TREATMENT)->row_array();  
                                    $periode_name = isset($periode['periode_name']) ? $periode['periode_name'] : '-';
                                ?>
                                    <tr>
                                        <td class="text-center" width="5%"><?= $no_b++; ?></td>
                                        <td width="25%">
                                            <?php
                                            if (!empty($row['proaktif'])) {
                                                echo $row['proaktif'];
                                            } elseif (!empty($row['reaktif'])) {
                                                echo $row['reaktif'];
                                            }
                                            ?>
                                        </td>
                                        <td width="15%">
                                            <?php
                                            if (!empty($row['proaktif']) && empty($row['reaktif'])) {
                                                echo 'Proaktif';
                                            } elseif (!empty($row['reaktif']) && empty($row['proaktif'])) {
                                                echo 'Reaktif';
                                            } elseif (!empty($row['proaktif']) && !empty($row['reaktif'])) {
                                                echo 'Keduanya';
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td width="10%"><?= number_format($sub_row['target_progress_detail']) . '%'; ?></td>
                                        <?php 
                                            $a = $sub_row['target_damp_loss'];
                                            if ($a == 0) : 
                                        ?>  
                                        <td width="15%"></td>
                                        <?php else : ?> 
                                        <td width="15%">Rp. <?= number_format($a); ?> </td>  
                                        <?php endif ?>
                                        <td width="10%">
                                            <?php
                                            $tanggal_terakhir_bulan = '';
                                            if (!empty($sub_row['bulan'])) {
                                                $tahun = $periode_name ? $periode_name : date('Y'); 
                                                $date = new DateTime();
                                                $date->setDate($tahun, $sub_row['bulan'], 1);  
                                                $date->modify('last day of this month'); 
                                                $tanggal_terakhir_bulan = $date->format('d/m/Y');
                                            }
                                            echo $tanggal_terakhir_bulan;
                                            ?>
                                        </td>
                                        <td width="10%"><?= ($realisasi['progress_detail']) ? number_format($realisasi['progress_detail']) . '%' : '<span class="text-danger">Belum dimonitoring</span>'; ?></td>
                                        <td width="10%"><?= ($realisasi['target_progress_detail']) ? 'Rp. '.number_format($realisasi['target_progress_detail']) : '<span class="text-danger">Belum dimonitoring</span>'; ?></td>
                                        <td width="10%"><?= ($realisasi['tanggal_monitoring']) ? $realisasi['tanggal_monitoring'] : '<span class="text-danger">belum dimonitoring</span>'; ?></td>
                                        <td width="15%"><?= ($sub_row['target_progress_detail'] == $realisasi['progress_detail'] && $sub_row['target_damp_loss'] == $realisasi['target_progress_detail']) ? '<span class="text-success">Sesuai</span>' : '<span class="text-danger">Tidak Sesuai</span>'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <br>
    <strong>List Level Risiko</strong><br/>
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
                $cek_score1             = $this->data->cek_level_new($target_level_item['target_like'], $target_level_item['target_impact']);
                $target_level_risiko    = $this->data->get_master_level(true, $cek_score1['id']);
                $target_code            = $this->data->level_action($target_level_item['target_like'], $target_level_item['target_impact']);
                $score_tar	            = $this->db->select('score')->where('impact', $target_level_item['target_impact'])->where('likelihood', $target_level_item['target_like'])->get(_TBL_LEVEL_COLOR)->row_array();
                $target                 = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $target_level_risiko['color'] . ';color:' . $target_level_risiko['color_text'] . ';">';
                if ($target_level_risiko['level_mapping']) {
                    $target .= $target_level_risiko['level_mapping'] . '<br>[' . $score_tar['score'] . ']';
                } else {
                    $target .= "<p class='text-danger'>Data Belum diinput</p>";
                }
                $target .= '</span>';

                $realisasi_level        = $this->db->select('*')->where('rcsa_detail', $target_level_item['id_detail'])->where('bulan', $target_level_item['bulan'])->get(_TBL_RCSA_ACTION_DETAIL)->row_array();
                $cek_score2             = $this->data->cek_level_new($realisasi_level['residual_likelihood_action'], $realisasi_level['residual_impact_action']);
                $realisasi_level_risiko = $this->data->get_master_level(true, $cek_score2['id']);
                $realisasi_code         = $this->data->level_action($realisasi_level['residual_likelihood_action'], $realisasi_level['residual_impact_action']);
                $score_res               = $this->db->select('score')->where('impact', $realisasi_level['residual_impact_action'])->where('likelihood', $realisasi_level['residual_likelihood_action'])->get(_TBL_LEVEL_COLOR)->row_array();
                
                // Membuat tampilan realisasi level
                $realisasi = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $realisasi_level_risiko['color'] . ';color:' . $realisasi_level_risiko['color_text'] . ';">';
                if ($realisasi_code['impact']['code']) {
                    $realisasi .= $realisasi_level_risiko['level_mapping'] . '<br>[' .$score_res['score'] . ']';
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
