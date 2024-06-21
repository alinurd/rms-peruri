<?php
//    doi::dump($parent);
$sts_name = '';
if ($parent['sts_propose'] != 4) {
    $hide_edit = 'hide';
    $sts_name = $parent['sts_propose_text'];
} else {

    $ok = 'hide';
}

?>
<div class="<?= $ok ?>">
    <span>note:</span><br><strong class="text-info">selesaikan proses approval untuk mengisi Progress Treatment</strong> <br>
    <i class="text-warning">status: <?= $sts_name ?></i> <br><br>
    <div class="clearfix"></div>
</div>
<div class="<?= $hide_edit ?>">
    List Realisasi : <?= $sts_name ?> <br /><br />
    <!-- <ul class="nav navbar-right panel_toolbox ">
        <li><span class="btn btn-primary pointer" id="add_realisasi" data-id="0" data-parent="<?= $detail['id']; ?>" data-rcsa="<?= $parent['id']; ?>"> <i class="fa fa-plus"></i> Tambah </span></li>
        <li><span class="btn btn-warning pointer" id="close_realisasi" data-id="0" data-parent="<?= $detail['id']; ?>" data-rcsa="<?= $parent['id']; ?>"> <i class="fa fa-close"></i> Close </span></li>  
    </ul> -->
    <div class="clearfix"></div>

    <table class="display table table-bordered table-striped table-hover" id="tbl_mitigasi">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Bulan</th>
                <th>Treatment</th>
                <th>Realisasi</th>
                <th width="10%">Tanggal Pelaksanaan</th>
                <th width="10%">Risk Level</th>
                <th width="10%">Progress</th>
                <th width="10%">Short Report</th>
                <th width="5%">Realisasi KRI</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            if ($realisasi) :
                foreach ($realisasi as $key => $row) :
                    $bulan = $row['bulan'];
                    $blnname = date('F', strtotime("2023-$bulan"));
                    $kridata = $this->db
                        ->where('action_detail', $row['id'])
                        ->where('bulan', $bulan)
                        ->get(_TBL_KRI_DETAIL)->row_array();
            ?>

                    <tr>
                        <td><?= ++$no; ?></td>
                        <td><?= $blnname; ?></td>
                        <td><?= $row['type_name']; ?></td>
                        <td><?= $row['realisasi']; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['progress_date'])); ?></td>
                        <td class="text-center">
                            <span style="background-color:<?= $row['warna_action']; ?>;color:<?= $row['warna_text_action']; ?>;">&nbsp;<?= $row['inherent_analisis_action']; ?>&nbsp;</span>
                        </td>
                        <td class="text-center"><?= $row['progress_detail']; ?></td>

                        <td class="text-center">
                            <?php if ($row['status_no'] == 1) : ?>
                                <span style="background-color:blue;color:white;">&nbsp;Close &nbsp;</span>
                            <?php elseif ($row['status_no'] == 2) : ?>
                                <span style="background-color:blue;color:white;">&nbsp;On Progress &nbsp;</span>
                            <?php elseif ($row['status_no'] == 3) : ?>
                                <span style="background-color:red;color:white;">&nbsp;Add &nbsp;</span>
                            <?php else : ?>
                                <span style="background-color:blue;color:white;">&nbsp;Open &nbsp;</span>
                            <?php endif ?>
                        </td>
                        <td><?= $kridata['realisasi']; ?></td>

                        <!-- <td class="text-center"><?= $row['status_action_detail']; ?></td>
                    <td class="text-center"> -->

                        <!-- <td class="text-center">
                            <span class="pointer edit_realisasi <?= $hide_edit; ?>" data-id="<?= $row['id']; ?>" data-parent="<?= $detail['id']; ?>" data-rcsa="<?= $parent['id']; ?>"> <i class="fa fa-pencil"></i></span>
                            <span class="pointer del_realisasi <?= $hide_edit; ?>" data-id="<?= $row['id']; ?>">
                                | <i class="fa fa-trash pointer text-danger" data-id="<?= $row['id']; ?>"></i>
                            </span>
                        </td> -->
                    </tr>
            <?php
                endforeach;
            endif; ?>
        </tbody>
    </table>
</div>