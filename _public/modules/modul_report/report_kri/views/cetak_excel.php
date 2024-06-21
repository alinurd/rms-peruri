 
<?php foreach ($fields as $key1 => $row1) :

?>
<?php endforeach; ?>

<table class="table table-bordered table-sm" id="reportKRI" style="border-color: #000; border-width: 1px; " border="1">
    <thead>
        <tr>
            <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="" width="100"></td>
            <td colspan="9" rowspan="6" style="text-align:center;border-left:none;">
                <h1>RISK REGISTER [KEY RISK INDIKATOR]</h1>
            </td>

            <td colspan="2" rowspan="2" style="text-align:left;">No.</td>
            <td colspan="12" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $row1['periode_name']; ?></td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td colspan="2" rowspan="2" style="text-align:left;">Revisi</td>
            <td colspan="12" rowspan="2" style="text-align:left;">: 1</td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td colspan="2" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
            <td colspan="12" rowspan="2" style="text-align:left;">: 31 Januari <?= $row1['periode_name']; ?> </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td colspan="23" style="border: none;"></td>
        </tr>

        <tr>
            <td colspan="2" style="border: none;">Risk Owner</td>
            <td colspan="23" style="border: none;">: <?= $row1['name']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">Risk Agent</td>
            <td colspan="23" style="border: none;">: <?= $row1['officer_name']; ?></td>
        </tr>
        <tr>
            <td colspan="23" style="border: none;"></td>
        </tr>
        <tr>
        <th style="background-color: #f6c111; color:#000;" rowspan="2">No</th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Sasaran</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Tema Risiko (T1)</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Kategori Risiko (T2)</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Sub Kategori Risiko</label></th>

                <th  style="background-color: #8cc881; color:#000;" colspan="4"><label>Identifikasi Risiko</label></th>

                <th style="background-color: #bababa; color:#000;" rowspan="2"><label>Key Risk Indicators</label></th>
                <th style="background-color: #bababa; color:#000;" rowspan="2"><label>Unit Satuan KRI</label></th>
                <th style="background-color: #bababa; color:#000;" colspan="3"><label>Kategori Threshold KRI</label></th>

                <?php
                $bln = 13;
                if ($bulan) {
                    $blnname = date('F', strtotime("2024-$bulan")); ?>

                    <th rowspan="2" style="background-color: #81eaff; color:#000;"><label class="w100">Realisasi KRI <br> [<?= $blnname ?>]</label></th>
                    <?php
                    // $bln = $bulan + 1;

                } else {
                    for ($i = 1; $i < $bln; $i++) {
                        # code...
                        // $blnname = "All Bulan";

                        $blnname = date('F', strtotime("2024-$i"));
                    ?>
                        <th rowspan="2" style="background-color: #81eaff; color:#000;"><label class="w100">Realisasi KRI <br> [<?= $blnname ?>]</label></th>
                <?php }
                }
                ?>
        </tr>
        <tr>

        <th style="background-color: #8cc881; color:#000;"><label class="w250">Peristiwa (T3)</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Penyebab</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Dampak Kualitatif</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Dampak Kuantitatif</label></th>

                <th style="background-color: #7FFF00;color: #000;"><label class="w80">Aman</label></th>
                <th style="background-color: #FFFF00;color:#000;"><label class="w80">Hati-Hati</label></th>
                <th style="background-color: #fd0202; color: #000;"><label class="w80">Bahaya</label></th>




        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($field as $key => $row) :
            $actDetail = $this->db->where('rcsa_detail_no', $row['id_rcsa_detail'])->order_by('bulan')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
            $actDetail = $this->db->where('rcsa_detail_no', $row['id_rcsa_detail'])->order_by('bulan')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
            foreach ($actDetail as   $xx) :
                if (!isset($processedDetails[$row['id_rcsa_detail']])) {
                    $processedDetails[$row['id_rcsa_detail']] = true; // Mark as processed

                    $residual_impact_action = $xx['residual_impact_action'];
                    $residual_likelihood_action = $xx['residual_likelihood_action'];
                    $data_kri = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->get('bangga_kri')->row_array();


                    $kri = $this->db->where('id', $data_kri['kri_no'])->get('bangga_data_combo')->row_array();
                    $kri_stuan = $this->db->where('id', $data_kri['satuan'])->get('bangga_data_combo')->row_array();

                    $sasaran = $this->db->where('rcsa_no', $row['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
                    $tema = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();

                    $act = $this->db->where('id', $row['id_rcsa_action'])->get('bangga_rcsa_action')->row_array();


                    if ($kri) {
        ?>
                        <tr>
                            <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                            <td valign="top"><?= $sasaran['sasaran']; ?> </td>
                            <td valign="top"><?= $tema['description']; ?></td>
                            <td valign="top"><?= $row['id_rcsa_detail']; ?></td>
                            <td valign="top"><?= ($row['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td>
                            <td valign="top"><?= $row['event_name']; ?></td>
                            <td valign="top"><?= format_list($row['couse'], "### "); ?></td>
                            <td valign="top"><?= format_list($row['impact'], "### "); ?></td>
                            <td valign="top"><?= $row['risk_impact_kuantitatif'] ?></td>

                            <!-- kri -->
                            <td><?= $kri['data'] ?></td>
                            <td valign="top">
                                <?php
                                if ($kri_stuan['data'] == "%") {
                                    echo "persen [%]";
                                } else {
                                    echo $kri_stuan['data'];
                                }
                                ?>
                            </td>
                            <td style="background-color: #fff;color: #000;">
                                <center><?= $data_kri['min_rendah'] ?>&nbsp;-&nbsp; <?= $data_kri['max_rendah'] ?>
                                </center>
                            </td>
                            <td style="background-color: #fff;color:#000;">
                                <center>
                                    <?= $data_kri['min_menengah'] ?> &nbsp;-&nbsp; <?= $data_kri['max_menengah'] ?> <br>
                                </center>
                            </td>
                            <td style="background-color: #fff; color:#000;">
                                <center>
                                    <?= $data_kri['min_tinggi'] ?> &nbsp;-&nbsp; <?= $data_kri['max_tinggi'] ?>
                                </center>
                            </td>

                            <?php

                                $bln = 13;
                                if ($bulan) {
                                    $kri_detail = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->where('bulan', $bulan)->get('bangga_kri_detail')->row_array();
                                    $kriVal = $kri_detail['realisasi'];

                                    if ($kriVal >= $data_kri['min_rendah'] && $kriVal <= $data_kri['max_rendah']) {
                                        $kriVal = $kriVal;
                                        $bc = "7FFF00";
                                    } elseif ($kriVal >= $data_kri['min_menengah'] && $kriVal <= $data_kri['max_menengah']) {
                                        $kriVal = $kriVal;
                                        $bc = "FFFF00";
                                    } elseif ($kriVal >= $data_kri['min_tinggi'] && $kriVal <= $data_kri['max_tinggi']) {
                                        $kriVal = $kriVal;
                                        $bc = "fd0202";
                                    } else {
                                        $bc = "";
                                        $kriVal = "<i class='fa fa-times-circle text-danger'></i>";
                                    }
                                    ?>
                                    <td class="" style="background-color:#<?= $bc ?>;color: #000;">
                                        <center><b><?= $kriVal ?></b></center>
                                    </td>
                                    <?php
                                }else{
                                    for ($i = 1; $i < $bln; $i++) {
                                    //     $blAwal=1;
                                    // $blahir=1;
                                    $kri_detail = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->where('bulan', $i)->get('bangga_kri_detail')->row_array();
                                    $kriVal = $kri_detail['realisasi'];

                                    if ($kriVal >= $data_kri['min_rendah'] && $kriVal <= $data_kri['max_rendah']) {
                                        $kriVal = $kriVal;
                                        $bc = "7FFF00";
                                    } elseif ($kriVal >= $data_kri['min_menengah'] && $kriVal <= $data_kri['max_menengah']) {
                                        $kriVal = $kriVal;
                                        $bc = "FFFF00";
                                    } elseif ($kriVal >= $data_kri['min_tinggi'] && $kriVal <= $data_kri['max_tinggi']) {
                                        $kriVal = $kriVal;
                                        $bc = "fd0202";
                                    } else {
                                        $bc = "";
                                        $kriVal = "<i class='fa fa-times-circle text-danger'></i>";
                                    }

                                ?>
                                    <td class="" style="background-color:#<?= $bc ?>;color: #000;">
                                        <center><b><?= $kriVal ?></b></center>
                                    </td>
                                <?php }
                                }
                                ?>
                        </tr>
        <?php
                    }
                }
            endforeach;
        endforeach;
        ?>


    </tbody>
    <!-- <tfoot> -->




    <!-- </tfoot> -->
</table>