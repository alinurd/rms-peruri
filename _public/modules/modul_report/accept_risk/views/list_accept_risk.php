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
<!-- <span class="btn btn-primary btn-flat">
    <a href="<?= base_url('accept-risk/cetak-register/excel/' . $id); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a>
</span> -->
<span class="btn btn-warning btn-flat">
    <a href="<?= base_url('accept-risk/cetak-register/pdf/' . $id); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<?php foreach ($fields as $key1 => $row1) : ?>
<?php endforeach; ?>
<div class="double-scroll" style='height:550px;'>
    <table class="table table-bordered table-sm" id="datatables_event" border="1" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="100"></td>
                <td colspan="2" rowspan="6" style="text-align:center;border-left:none;">
                    <h1>ACCEPT RISK</h1>
                </td>

                <td rowspan="2" style="text-align:left;">No.</td>
                <td rowspan="2" style="text-align:left;">: 006/RM-FORM/I/<?= $row1['periode_name']; ?></td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Revisi</td>
                <td rowspan="2" style="text-align:left;">: 1</td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td rowspan="2" style="text-align:left;">: 31 Januari <?= $row1['periode_name']; ?> </td>
            </tr>
            <tr>
                <td style="border: none;padding: 0;margin: 0;"></td>
            </tr>

            <tr>
                <td colspan="2" style="border: none;">Risk Owner</td>
                <td colspan="4" style="border: none;">: <?= $row1['name']; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;">Risk Agent</td>
                <td colspan="4" style="border: none;">: <?= $row1['officer_name']; ?></td>
            </tr>
            <tr>
                <td colspan="6" style="border: none;"></td>
            </tr>
            <tr>
                <th>No</th>
                <th><label class="w250">Judul Assesment</label></th>
                <th><label class="w250">Sasaran</label></th>
                <th><label class="w250">Tema Risiko (T1)</label></th>
                <th><label class="w250">Kategori Risiko (T2)</label></th>
                <th><label class="w250">Peristiwa (T3)</label></th>
                <th><label class="w250">Penyebab</label></th>
                <th><label class="w250">Dampak</label></th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($field as $key => $row) : ?>
                <tr>
                    <td rowspan="<?= count($row['sasaran']); ?>" valign="top" style="text-align: center;vertical-align: text-top;">
                        <?= ++$no; ?></td>
                    <td rowspan="<?= count($row['sasaran']); ?>" valign="top"><?= $row['judul']; ?></td>
                    <td valign="top"><?= $row['sasaran'][0]; ?></td>
                     <td valign="top">
                        <ol>
                            <?php foreach ($row['event'] as $key2 => $value2) : ?>
                                <?php if ($value2['sasaran'] == $row['sasaran'][0]) :
                                    $combo = $this->db->where('id', $value2['sub_kategori'])->get('bangga_data_combo')->row_array();
                                ?>
                                    
                                    <li> <?= $combo['data']; ?> </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                     <td valign="top">
                        <ol>
                            <?php foreach ($row['event'] as $key2 => $value2) : ?>
                                <?php if ($value2['sasaran'] == $row['sasaran'][0]) : ?>
                                    <li> <?= $value2['kategori']; ?> </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                     <td valign="top">
                        <ol>
                            <?php foreach ($row['event'] as $key2 => $value2) : ?>
                                <?php if ($value2['sasaran'] == $row['sasaran'][0]) : ?>
                                    <li> <?= $value2['risiko']; ?> </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td valign="top">
                        <ol>
                            <?php foreach ($row['event'] as $key2 => $value2) : ?>
                                <?php if ($value2['sasaran'] == $row['sasaran'][0]) : ?>
                                    <li> <?= format_list($value2['couse'], "### "); ?> </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td valign="top">
                        <ol>
                            <?php foreach ($row['event'] as $key2 => $value2) : ?>
                                <?php if ($value2['sasaran'] == $row['sasaran'][0]) : ?>
                                    <li> <?= format_list($value2['impact'], "### "); ?> </li>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </ol>
                    </td>



                </tr>
                <?php foreach ($row['sasaran'] as $key1 => $value1) : ?>
                    <?php if ($key1 != 0) : ?>
                        <tr>
                            <td valign="top"><?= $value1; ?></td>
                            <td valign="top">
                                <ol>
                                    <?php foreach ($row['event'] as $key3 => $value3) : ?>
                                        <?php if ($value3['sasaran'] == $value1) : ?>
                                            <li> <?= $value3['risiko']; ?> </li>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                            <td valign="top">
                                <ol>
                                    <?php foreach ($row['event'] as $key3 => $value3) : ?>
                                        <?php if ($value3['sasaran'] == $value1) : ?>

                                            <li> <?= format_list($value3['couse'], "### "); ?> </li>
                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                            <td valign="top">
                                <ol>
                                    <?php
                                    foreach ($row['event'] as $key3 => $value3) : ?>
                                        <?php if ($value3['sasaran'] == $value1) : ?>

                                            <li> <?= format_list($value3['impact'], "### "); ?> </li>

                                        <?php endif ?>
                                    <?php endforeach; ?>
                                </ol>
                            </td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>

        </tbody>


    </table>
</div>

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