<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Risk Owner</th>
            <th class="text-center">Peristiwa</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Tanggal Validasi</th>
            <th class="text-center">Bulan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($field as $row) : ?>

            <?php 
                // Ambil detail untuk Risk Owner dan Event Name
                $detail = $this->db->where('id', $row['id_detail'])
                                   ->get(_TBL_VIEW_RCSA_DETAIL)
                                   ->row_array();

                // Ambil detail dari tabel action dan analisis
                $data_action_detail = $this->db->where('rcsa_detail', $row['id_detail'])->where('bulan', $row['bulan'])
                                               ->get(_TBL_RCSA_ACTION_DETAIL)
                                               ->row_array();

                $data_analisis = $this->db->where('id_detail', $row['id_detail'])->where('bulan', $row['bulan'])
                                         ->get(_TBL_ANALISIS_RISIKO)
                                         ->row_array();

                // Target risiko untuk analisis
                $target = $this->db->where('id_detail', $row['id_detail'])->where('bulan', $row['bulan'])
                                   ->get('bangga_analisis_risiko')
                                   ->row_array();
                $like = $target['target_like'];
                $impact = $target['target_impact'];
                
                // Level tindakan dan status
                $like_impact = $this->data->level_action($like, $impact);
                $cek_level = $this->data->cek_level_new($like, $impact);
                $progress_detail = $like_impact['like']['code'] . ' x ' . $like_impact['impact']['code'];

                $status = '';
                $class_text = '';
                if ($data_action_detail['residual_likelihood_action'] === $data_analisis['target_like'] && $data_action_detail['residual_impact_action'] === $data_analisis['target_impact']) {
                    $status = 'Sesuai';
                    $class_text = 'text-success';
                } else {
                    $status = 'Tidak Sesuai';
                    $class_text = 'text-danger';
                }

                // Nama bulan untuk ditampilkan
                $bulan_names = [
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

                $bulan = $row['bulan'];  // Misalnya, $row['bulan'] berisi angka bulan
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $detail['name'] ?></td>
                <td><?= $detail['event_name'] ?></td>
                <td><?= $detail['tahun'] ?></td>
                <td><?= $row['tanggal_validasi'] ?></td>
                <td><?= isset($bulan_names[$bulan]) ? $bulan_names[$bulan] : 'Unknown' ?></td>
                <td><span class="<?= $class_text; ?>"><?= $status; ?></span></td>
                <td>
                    <!-- Keterangan dengan warna latar belakang dan teks dinamis -->
                    <span class="btn" style="display: inline-block; width: 100%; background-color: <?= $cek_level['warna_bg']; ?>; color: <?= $cek_level['warna_txt']; ?>; padding: 4px 8px;">
                        <?= $cek_level['tingkat']; ?> [<?= $progress_detail; ?>]
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
