<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            background: white;
        }
        th {
            text-align: center;
            background: #f2f2f2; /* Warna latar belakang untuk header */
        }
        .no-col {
            text-align: center;
            min-width: 50px;
        }
        .risk-owner-col {
            min-width: 150px;
        }
        .peristiwa-risiko-col, .treatment-col {
            min-width: 200px;
        }
        .tahun-col {
            text-align: center;
            min-width: 100px;
        }
        .month-col {
            text-align: center;
        }
        .target-col, .realisasi-col {
            text-align: center;
        }
    </style>
</head>
<body>
<table border="1">
    <thead>
        <tr>
            <td height="80" colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                <img src="<?= img_url('logo.png'); ?>" width="70">
            </td>
            <td colspan="19" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                <h4>PROGRESS TREATMENT</h4>
            </td>
            <td colspan="4" style="width: 12%;">No.</td>
            <td colspan="4" style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="width: 12%;">Revisi</td>
            <td colspan="4" style="width: 12%;">: 1</td>
        </tr>
        <tr>
            <td colspan="4" style="width: 12%;">Tanggal Revisi</td>
            <td colspan="4" style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">Risk Owner</td>
            <td colspan="4" style="border: none;">: <?= $parent[0]['name']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">Risk Agent</td>
            <td colspan="4" style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
        </tr>
        <tr>
            <td colspan="20" style="padding-top: 20px; border: none;"></td>
        </tr>
        <tr>
            <th class="no-col" rowspan="2">No</th>
            <th class="risk-owner-col" style="text-align: center !important;" rowspan="2">Risk Owner</th>
            <th class="peristiwa-risiko-col" style="text-align: center !important;" rowspan="2">Peristiwa Risiko</th>
            <th class="treatment-col" style="text-align: center !important;" rowspan="2">Treatment</th>
            <th class="tahun-col" style="text-align: center !important;" rowspan="2">Tahun</th>
            <th class="month-col" colspan="2">Januari</th>
            <th class="month-col" colspan="2">Februari</th>
            <th class="month-col" colspan="2">Maret</th>
            <th class="month-col" colspan="2">April</th>
            <th class="month-col" colspan="2">Mei</th>
            <th class="month-col" colspan="2">Juni</th>
            <th class="month-col" colspan="2">Juli</th>
            <th class="month-col" colspan="2">Agustus</th>
            <th class="month-col" colspan="2">September</th>
            <th class="month-col" colspan="2">Oktober</th>
            <th class="month-col" colspan="2">November</th>
            <th class="month-col" colspan="2">Desember</th>
        </tr>
        <tr>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
            <th class="target-col">Target</th>
            <th class="realisasi-col">Realisasi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($progress_treatment as $d) {
        ?>
            <tr>
                <td class="no-col" rowspan="2"><?= $no++ ?></td>
                <td class="risk-owner-col" rowspan="2"><?= $d['name'] ?></td>
                <td class="peristiwa-ris iko-col" rowspan="2"><?= $d['event_name'] ?></td>
                <td class="treatment-col" rowspan="2"><?= ($d['proaktif']) ? $d['proaktif'] : $d['reaktif']; ?></td>
                <td class="tahun-col" rowspan="2"><?= $d['periode_name'] ?></td>
                <?php
                for ($i = 1; $i <= 12; $i++):
                    $id                 = $d['id'];
                    $id_action          = $d['id_action'];
                    $monitoring         = $this->db
                                                ->where('rcsa_action_no', $id_action)
                                                ->where('bulan', $i)
                                                ->get('bangga_rcsa_monitoring_treatment')->row_array();

                    $target_monitoring  = $this->db
                                                ->where('id_rcsa_action', $id_action)
                                                ->where('bulan', $i)
                                                ->get('bangga_rcsa_treatment')->row_array();

                    $target_monitoring = $target_monitoring;
                    ?>
                    <td class="target-col"><?=$target_monitoring['target_progress_detail'].'%';?></td>
                    <td class="realisasi-col"><?=$monitoring['progress_detail'].'%';?></td>
                    
                <?php
                endfor;
                ?>
            </tr>
            <tr>
                <?php
                for ($i = 1; $i <= 12; $i++):
                    $id                 = $d['id'];
                    $id_action          = $d['id_action'];
                    $monitoring         = $this->db
                                                ->where('rcsa_action_no', $id_action)
                                                ->where('bulan', $i)
                                                ->get('bangga_rcsa_monitoring_treatment')->row_array();

                    $target_monitoring  = $this->db
                                                ->where('id_rcsa_action', $id_action)
                                                ->where('bulan', $i)
                                                ->get('bangga_rcsa_treatment')->row_array();

                    ?>
                    
                        <td class="realisasi-col"><?= 'Rp.'. number_format($target_monitoring['target_damp_loss'], 0, ',', ',');?></td>
                        <td class="realisasi-col"><?= 'Rp.'. number_format($monitoring['target_progress_detail'], 0, ',', ',');?></td>
                <?php
                endfor;
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>