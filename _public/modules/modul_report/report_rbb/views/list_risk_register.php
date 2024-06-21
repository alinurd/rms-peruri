<style>
    .modal {
        z-index: 2050;
    }

    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        padding: 5px !important;
        text-align: center;
    }

    .w250 {
        width: 250px;
    }

    .w150 {
        width: 150px;
    }

    .w100 {
        width: 100px;
    }

    .w80 {
        width: 80px;
    }

    .w50 {
        width: 50px;
    }

    td ol {
        padding-left: 10px;
        width: 300px;
    }

    td ol li {
        margin-left: 5px;
    }
</style>
<span class="btn btn-primary btn-flat">
    <a href="<?= base_url('rcsa/cetak-rbb/excel/' . $id . '/' . $owner); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a>
</span>
<span class="btn btn-warning btn-flat">
    <a href="<?= base_url('rcsa/cetak-rbb/pdf/' . $id . '/' . $owner); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<!-- <h1>Risk Register</h1> -->
<?php foreach ($fields as $key1 => $row1) : ?>
<?php endforeach; ?>
<div class="double-scroll" style='height:550px;'>
    <table class="table table-bordered table-sm" id="datatables_event" border="1">
        <thead>
            <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="100"></td>
                <td colspan="21" rowspan="6" style="text-align:center;border-left:none;">
                    <h1>RISK BASED BUDGETING</h1>
                </td>

                <td colspan="2" rowspan="2" style="text-align:left;">No.</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $row1['periode_name']; ?></td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 1</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 31 Januari <?= $row1['periode_name']; ?> </td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="22" style="border: none;"></td>
            </tr>

            <tr>
                <td colspan="2" style="border: none;">Risk Owner</td>
                <td colspan="20" style="border: none;">: <?= $row1['name']; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;">Risk Agent</td>
                <td colspan="20" style="border: none;">: <?= $row1['officer_name']; ?></td>
            </tr>
            <tr>
                <td colspan="22" style="border: none;"></td>
            </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2"><label>Sasaran</label></th>
                <th rowspan="2"><label>Tema Risiko (T1)</label></th>
                <th rowspan="2"><label>Kategori Risiko (T2)</label></th>
                <th rowspan="2"><label>Sub Kategori Risiko</label></th>

                <th colspan="4"><label>Identifikasi Risiko</label></th>
                <th colspan="6"><label>Analisis Risiko Inheren</label></th>
                <th colspan="4"><label>Evaluasi Risiko</label></th>
                <th colspan="6"><label>Analisis Risiko Residual</label></th>
                <th colspan="6"><label>Perlakuan Risiko</label></th>
            </tr>
            <tr>
                <th><label class="w250">Peristiwa (T3)</label></th>
                <th><label class="w250">Penyebab</label></th>
                <th><label class="w250">Dampak Kualitatif</label></th>
                <th><label class="w250">Dampak Kuantitatif</label></th>

                <th colspan="2"><label>Kemungkinan</label></th>
                <th colspan="2"><label>Dampak</label></th>
                <th colspan="2"><label> Level</label></th>

                <th><label>Urgency</label></th>
                <th><label>Control</label></th>
                <th><label>Risk Control Assessment</label></th>
                <th><label>PIC</label></th>

                <th colspan="2"><label>Kemungkinan</label></th>
                <th colspan="2"><label>Dampak</label></th>
                <th colspan="2"><label> Level</label></th>

                <th><label>Rencana Proaktif</label></th>
                <th><label>Rencana Reaktif</label></th>
                <th><label>Target Waktu</label></th>
                <th><label>Risk Treatment Owner</label></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($field as $key => $row) :
                // doi::dump($row['tema']);
                $sasaran = $this->db->where('rcsa_no', $row['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
                $tema = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();
                $control_as = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
                $pic = $this->db->where('id', $row['pic'])->get('bangga_owner')->row_array();

                $residual_level = $this->data->get_master_level(true, $row['residual_level']);
                $inherent_level = $this->data->get_master_level(true, $row['inherent_level']);


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
                    ->where('id', $row['id_rcsa_action'])
                    ->get('bangga_rcsa_action')->row_array();
//doi::dump($act);

            ?>
                <tr>
                    <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                    <td valign="top"><?= $sasaran['sasaran']; ?> </td>
                    <td valign="top"><?= $tema['description']; ?></td>
                    <td valign="top"><?= $row['kategori']; ?></td>
                    <td valign="top"><?= ($row['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td>
                    <td valign="top"><?= $row['event_name']; ?></td>
                    <td valign="top"><?= format_list($row['couse'], "### "); ?></td>
                    <td valign="top"><?= format_list($row['impact'], "### "); ?></td>
                    <td valign="top"><?= $row['risk_impact_kuantitatif'] ?></td>
                    <!-- inheren -->
                    <!-- <td valign="top" style="text-align: center;"><?= $row['level_like']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row['like_ket']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row['level_impact']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row['impact_ket']; ?></td>
                    <td valign="top" style="text-align: center;"><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
                    
                    <td valign="top" style="text-align: center; background-color:<?= $row['color']; ?>;color:<?= $row['color_text'] ?>;"><?= $row['level_mapping']; ?></td> -->

                    <td valign="top" style="text-align: center;"><?= $likeinherent['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $likeinherent['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impactinherent['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impactinherent['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= intval($likeinherent['code']) * intval($impactinherent['code']); ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= $inherent_level['level_mapping']; ?></td>

                    <td valign="top" style="text-align: center;"><?= $row['urgensi_no_kadiv']; ?></td>
                    <td valign="top"><?= format_list($row['control_name'], "###"); ?></td>
                    <td valign="top"><?= $control_as['data']; ?></td>
                    <td valign="top"><?= $pic['name']; ?></td>
                    <!-- residual -->

                    <td valign="top" style="text-align: center;"><?= $like['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $like['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impact['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impact['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= intval($like['code']) * intval($impact['code']); ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= $residual_level['level_mapping']; ?></td>

                    <td valign="top"><?= $act['proaktif']; ?></td>
                    <td valign="top"><?= $act['reaktif']; ?></td>
                    <?php
                    $originalDate = $act['target_waktu'];

                    // Check if the date is empty or equal to "01-01-1970"
                    if (empty($originalDate) || $originalDate === "01-01-1970") {
                        $formattedDate = "";
                    } else {
                        $formattedDate = date("d-m-Y", strtotime($originalDate));
                    }
                    ?>

                    <td valign="top"><?= $formattedDate; ?></td>
                    <?php

                    $arrayData = json_decode($act['owner_no'], true);
                    // doi::dump($act['owner_no']);

                    if ($arrayData !== null) {
                        $owners = array(); // Membuat array kosong untuk menyimpan data owner
                        foreach ($arrayData as $element) {
                            $element = strval($element);
                            $Accountable = $this->db->where('id', $element)->get('bangga_owner')->row_array();
                            if ($Accountable) {
                                $owners[] = $Accountable['name']; // Menyimpan nama owner ke dalam array
                            }
                        }

                        // Menggabungkan data owner menjadi satu string dengan pemisah koma
                        $ownersString = implode(", ", $owners);
                    } else {
                        $ownersString = '-'; // Setel string menjadi kosong jika $arrayData null
                    }
                    ?>

                    <td valign="top"><?= format_list($ownersString); ?></td>


                </tr>
            <?php endforeach; ?>
            <?php


            foreach ($fieldxx as $key1 => $row1) : ?>
                <?php if ($row1['sts_next'] < 1) :
                    $sasaran = $this->db->where('rcsa_no', $row1['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
                    $combo = $this->db->where('id', $row1['sub_kategori'])->get('bangga_data_combo')->row_array();
                    $pic = $this->db->where('id', $row1['pic'])->get('bangga_owner')->row_array();

                    $like = $this->db
                        ->where('id', $residual_level['likelihood'])
                        ->get('bangga_level')->row_array();

                    $impact = $this->db
                        ->where('id', $residual_level['impact'])
                        ->get('bangga_level')->row_array();
                    // doi::dump($impact['level']);


                ?>
                    <!--  <tr>
                        <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                        <td valign="top"><?= $sasaran['sasaran']; ?> </td>
                        <td valign="top"><?= $row1['kategori']; ?></td>
                        <td valign="top"><?= $combo['data']; ?></td>
                        <td valign="top"><?= ($row1['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td>
                        <td valign="top"><?= $row1['event_name']; ?></td>
                        <td valign="top"><?= format_list($row1['couse'], "### "); ?></td>
                        <td valign="top"><?= format_list($row1['impact'], "### "); ?></td>
                        <td valign="top"><?= $row1['risk_impact_kuantitatif'] ?></td>
                        inheren 
                    <td valign="top" style="text-align: center;"><?= $row1['level_like']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row1['like_ket']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row1['level_impact']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row1['impact_ket']; ?></td>
                    <td valign="top" style="text-align: center;"><?= intval($row1['level_like']) * intval($row1['level_impact']); ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $row1['color']; ?>;color:<?= $row1['color_text'] ?>;"><?= $row1['level_mapping']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $row1['urgensi_no_kadiv']; ?></td>
                    <td valign="top"><?= format_list($row1['control_name'], "###"); ?></td>
                    <td valign="top"><?= $row1['control_ass']; ?></td>
                    <td valign="top"><?= $pic['name']; ?></td>
                    residual  

                    <td valign="top" style="text-align: center;"><?= $like['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $like['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impact['code']; ?></td>
                    <td valign="top" style="text-align: center;"><?= $impact['level']; ?></td>
                    <td valign="top" style="text-align: center;"><?= intval($like['code']) * intval($impact['code']); ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= $residual_level['level_mapping']; ?></td>

                    <td valign="top"><?= $row1['proaktif']; ?></td>
                    <td valign="top"><?= $row1['reaktif']; ?></td>
                    <?php $originalDate = $row1['target_waktu']; ?>
                    <td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td>
                    <td valign="top"><?= format_list($row['penanggung_jawab'], "### "); ?></td>

                    </tr>-->
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="22" style="border: none;">&nbsp;</th>
            </tr>
        </tbody>
        <!-- <tfoot> -->


        <tr>
            <?php if ($tgl == NULL) : ?>
                <th colspan="22" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
            <?php else : ?>
                <th colspan="22" style="text-align: right;border: none;font-size: 20px;font-style: normal;">
                    Dokumen ini telah disahkan oleh Kepala Divisi
                    <?php if ($divisi == NULL) {
                        echo $row1['name'];
                    } else {
                        echo $divisi->name;
                    } ?>
                    Pada
                    <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
                    foreach ($tgl as $key1 => $row1) {
                        echo strftime("%d %B %Y", strtotime($row1['create_date']))
                    ?>
                    <?php }  ?>
                <?php endif; ?>
                </th>

        </tr>

        <!-- </tfoot> -->
    </table>
</div>

<?php
if (isset($log)) : ?>
    <div class="row">
        <br />
        Log Aktifitas<br />
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="25%" class="text-left"> Status</th>
                        <th class="text-left">Keterangan</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($log as $row) : ?>
                        <tr>
                            <td><?= ++$no; ?></td>
                            <td><?= $row['keterangan']; ?></td>
                            <td><?= $row['note']; ?></td>
                            <td><?= $row['create_date']; ?></td>
                            <td><?= $row['create_user']; ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
endif; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.double-scroll').doubleScroll({
            resetOnWindowResize: true,
            scrollCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
            contentCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
        });
        $(window).resize();
    });
</script>