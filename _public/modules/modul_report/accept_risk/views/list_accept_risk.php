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
    <table class="table table-bordered table-sm" id="datatables_event" border="1" cellpadding="0" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="100"></td>
                <td colspan="4" rowspan="6" style="text-align:center;border-left:none;">
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
        <?php foreach ($row['sasaran'] as $key1 => $value1) : ?>
            <tr>
                <?php if ($key1 == 0) : ?>
                    <!-- Kolom No dan Judul hanya dicetak pada baris pertama -->
                    <td rowspan="<?= count($row['sasaran']); ?>" valign="top" style="text-align: center;">
                        <?= ++$no; ?>
                    </td>
                    <td rowspan="<?= count($row['sasaran']); ?>" valign="top"><?= $row['judul']; ?></td>
                <?php endif; ?>

                <!-- Kolom Sasaran -->
                <td valign="top"><?= $value1; ?></td>

                <!-- Kolom Tema Risiko -->
                <td valign="top">
                    <?php foreach ($row['event'] as $event) : ?>
                        <?php if ($event['sasaran'] == $value1) : ?>
                            <?= $event['tema_risiko']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>

                <!-- Kolom Kategori Risiko -->
                <td valign="top">
                    <?php foreach ($row['event'] as $event) : ?>
                        <?php if ($event['sasaran'] == $value1) : ?>
                            <?= $event['kategori']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>

                <!-- Kolom Peristiwa -->
                <td valign="top">
                    <?php foreach ($row['event'] as $event) : ?>
                        <?php if ($event['sasaran'] == $value1) : ?>
                            <?= $event['risiko']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>

                <!-- Kolom Penyebab -->
                <td valign="top">
                    <?php foreach ($row['event'] as $event) : ?>
                        <?php if ($event['sasaran'] == $value1) : ?>
                            <?= format_list($event['couse'], "### "); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>

                <!-- Kolom Dampak -->
                <td valign="top">
                    <?php foreach ($row['event'] as $event) : ?>
                        <?php if ($event['sasaran'] == $value1) : ?>
                            <?= format_list($event['impact'], "### "); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
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