<style>
    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        padding: 5px !important;
        text-align: center;
    }

    td ol {
        padding-left: 10px;
        width: 300px;
    }

    td ol li {
        margin-left: 5px;
    }
</style>
<span class="btn btn-warning btn-flat">
    <a href="#" id="coba" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<div class="double-scroll">
    <table class="table table-bordered table-sm" border="1" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="100"></td>
                <td colspan="3" rowspan="6" style="text-align:left;border-left:none;">
                    <h1>RISK MONITORING</h1>
                </td>

                <td rowspan="2" style="text-align:left;">No.</td>
                <td colspan="2" rowspan="2" style="text-align:left;">: 005/RM-FORM/I/ <?= $post['tahun']; ?></span></td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Revisi</td>
                <td colspan="2" rowspan="2" style="text-align:left;">: 1</td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="2" rowspan="2" style="text-align:left;">: 31 Januari <?= $post['tahun']; ?> </td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none;text-align: left;">Risk Owner : <?= $post['unit']; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none;text-align: left;">Bulan : <?= $post['bulan2']; ?></td>
            </tr>
            <tr>
                <td colspan="7" style="border: none;padding: 0;"></td>
            </tr>
            <tr>
                <th>No</th>
                <th>Risk Owner</th>
                <th>Tema Risiko (T1)</th>
                <th>Kategori Risiko (T2)</th>
                <th style="width: 300px">Peristiwa (T3)</th>
                <th>Risk Level Inherent</th>
                <th>Pelaksanaan Treatment</th>
                <th>Risk Level Residual</th>
                <th>Loss Event</th>
                <th>Risk Level Bulanan</th>
                <th>Progress</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
                 // doi::dump($coba['bobo']);

            foreach ($coba['bobo'] as $key1 => $value1) :

                $residual_mont = $this->data->get_master_level(true, $value1['risk_level']);
                $residual_level = $this->data->get_master_level(true, $value1['residual_level']);
                $inherent_level = $this->data->get_master_level(true, $value1['inherent_level']);


                $like_mont = $this->db
                    ->where('id', $residual_mont['likelihood'])
                    ->get('bangga_level')->row_array();

                $impact_mont = $this->db
                    ->where('id', $residual_mont['impact'])
                    ->get('bangga_level')->row_array();

                $like = $this->db
                    ->where('id', $residual_level['likelihood'])
                    ->get('bangga_level')->row_array();

                $impact = $this->db
                    ->where('id', $residual_level['impact'])
                    ->get('bangga_level')->row_array();
                // doi::dump($impact['level']);
                $likeinherent = $this->db
                    ->where('id', $inherent_level['likelihood'])
                    ->get('bangga_level')->row_array();

                $impactinherent = $this->db
                    ->where('id', $inherent_level['impact'])
                    ->get('bangga_level')->row_array();

                $act = $this->db
                    ->where('rcsa_detail_no', $value1['id'])
                    ->get('bangga_rcsa_action')->row_array();
                $combo = $this->db->where('id', $value1['sub_kategori'])->get('bangga_data_combo')->row_array();

            ?>

                <tr>
                    <td style="text-align: center;"><?= $no++; ?></td>
                    <td><?= $value1['name']; ?></td>
                    <td><?= $combo['data']; ?></td>
                    <td><?= $value1['kategori']; ?></td>

                    <td><?= $value1['event_name']; ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;">[ <?= $likeinherent['code']; ?> x <?= $impactinherent['code']; ?>] <br><strong><?= $inherent_level['level_mapping']; ?></strong></td>


                    <td style="text-align: center;">
                        <?php $hoho = $coba['baba'][$value1['id']]['status_action_detail']; ?>
                        <?php if ($hoho == "Add") : ?>
                            <span style="background-color:red;color:white;"><?= $hoho; ?></span>
                        <?php else : ?>
                            <span style="background-color:blue;color:white;"><?= $hoho; ?></span>
                        <?php endif; ?>


                    </td>

                    <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"> [ <?= $like['code']; ?> x <?= $impact['code']; ?> ] <br><strong><?= $residual_level['level_mapping']; ?></strong>
                    </td>




                    <?php if ($coba['baba'][$value1['id']]['type_name'] == "Reaktif") : ?>
                        <td style="text-align: center;"> Ya</td>
                    <?php elseif ($coba['baba'][$value1['id']]['type_name'] == "Proaktif") : ?>
                        <td style="text-align: center;"> Tidak</td>
                    <?php else : ?>
                        <td style="text-align: center;"></td>
                    <?php endif; ?>


                    <td valign="top" style="text-align: center; background-color:<?= $residual_mont['color']; ?>;color:<?= $residual_mont['color_text']; ?>;"> [ <?= $like_mont['code']; ?> x <?= $impact_mont['code']; ?> ] <br><strong><?= $residual_mont['level_mapping']; ?></strong>
                    </td>
                    <?php
                    $a = $coba['baba'][$value1['id']]['progress_detail'];
                    if ($a <= 30) : $warna = "danger"; ?>
                    <?php elseif ($a <= 50) : $warna = "warning"; ?>
                    <?php elseif ($a <= 75) : $warna = "success"; ?>
                    <?php else : $warna = "primary"; ?>
                    <?php endif; ?>

                    <td style="text-align: center;">
                        <?php if ($a == 0) : ?>
                            <div></div>
                        <?php else : ?>
                            <div class="progress progress-sl">
                                <div class="progress-bar progress-bar-<?= $warna; ?>" role="progressbar" aria-valuenow="<?= $a; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a; ?>%;"><?= number_format($a); ?>% Complete
                                </div>
                            </div>
                        <?php endif; ?>
                    </td>





                </tr>

            <?php endforeach; ?>

        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>