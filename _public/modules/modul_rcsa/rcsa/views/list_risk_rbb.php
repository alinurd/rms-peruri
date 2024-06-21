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
                <td colspan="7" rowspan="6" style="text-align:center;border-left:none;">
                    <h1>RISK BASED BUDGETING</h1>
                </td>

                <td colspan="1" rowspan="2" style="text-align:left;">No.</td>
                <td colspan="3" rowspan="2" style="text-align:left;">: </td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="1" rowspan="2" style="text-align:left;">Revisi</td>
                <td colspan="3" rowspan="2" style="text-align:left;">: </td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="1" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="3" rowspan="2" style="text-align:left;">:</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="12" style="border: none;"></td>
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
                <td colspan="12" style="border: none;"></td>
            </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2"><label>Sasaran</label></th>
                <th rowspan="2"><label>Peristiwa (T3)</label></th>
                <th colspan="4"><label>Anggran Program Kerja </label></th>
                <th colspan="4"><label>Anggran penangan Risiko</label></th>
                <th rowspan="2"><label>Total Anggaran <br> (Anggran RKAP)</label></th>
            </tr>
            <tr>
                <!-- Anggran Program Kerja -->
                <th><label style="text-align:center;" class="w250">Existing Control</label></th>
                <th><label class="w250">Anggaran <br> Rp.</label></th>
                <th><label style="text-align:center;" class="w250"> Kode Jasa</label></th>
                <th><label class="w250">Keterangan</label></th>


                <!-- Anggran penangan Risiko -->
                <th><label class="w250">Treatment</label></th>
                <th><label class="w250">Anggaran <br> Rp.</label></th>
                <th><label style="text-align:center;" class="w250"> Kode Jasa</label></th>
                <th><label class="w250">Keterangan</label></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            foreach ($field as $key => $row) :
                $control_as = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
                $sasaran = $this->db->where('rcsa_no', $row['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
                $act = $this->db->where('rcsa_detail_no', $row['id'])->get('bangga_rcsa_action')->row_array();

            ?>
                <tr>
                    <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                    <td valign="top"><?= $sasaran['sasaran']; ?> </td>
                    <td valign="top"><?= $row['event_name']; ?></td>
                    <td valign="top">[ <?= $control_as['data']; ?> ]
                        <br>
                        <?= format_list($row['control_name'], "###"); ?>
                    </td>
                    <td valign="top" style="text-align:right;"><?= number_format($row['risk_impact_kuantitatif']); ?></td>
                    <td valign="top" style="text-align:center;"><?= $row['kode_jasa'] ?></td>
                    <td valign="top" style="text-align:center;"><?= $row['keterangan_coa']; ?></td>
                    <td valign="top" style=""> <u>proaktif:</u> <br><?php if (!empty($act['proaktif'])) {
                                                                        echo $act['proaktif'];
                                                                    } else {
                                                                        echo "-";
                                                                    } ?>
                        <hr> <u>reaktif:</u> <br><?php if (!empty($act['reaktif'])) {
                                                        echo $act['reaktif'];
                                                    } else {
                                                        echo "-";
                                                    } ?>
                    </td>
                    <td valign="top" style="text-align:right;"><?= number_format($act['amount']); ?></td>
                    <td valign="top" style="text-align:center;"><?= $row['kode_jasa'] ?></td>
                    <td valign="top" style="text-align:center;"><?= $act['sumber_daya'] ?></td>
                    <td valign="top" style="text-align:right;"><?= number_format($act['amount'] + $row['risk_impact_kuantitatif']); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="12" style="border: none;">&nbsp;</th>
            </tr>
        </tbody>


        <tr>
            <?php if ($tgl == NULL) : ?>
                <th colspan="12" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
            <?php else : ?>
                <th colspan="12" style="text-align: center;border: none;font-size: 20px;font-style: normal;">
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