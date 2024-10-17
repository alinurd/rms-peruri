<?php
$hide_edit = '';
$sts_risk = intval($parent['sts_propose']);
if ($detail['sts_propose'] == 5) {
    $hide_edit = '';
    $disable = ' ';
    $readonly = '';
} else {
    if ($detail['sts_propose'] > 0) {
        $hide_edit = ' hide ';
        $disable = 'disabled';
        $readonly = 'readonly="true"';
    }
}


$analysisacthide = 'hide';
$evaluasiacthide = 'hide';
$treatmentacthide = 'hide';
$progresacthide = 'hide';

if ($detail['pi'] >= 2) {
    $analysisacthide = '';
}
if ($detail['pi'] >= 3) {
    $evaluasiacthide = '';
}
if ($detail['pi'] >= 4) {
    $treatmentacthide = '';
}
if ($detail['pi'] >= 5) {
    $progresacthide = 'hide';
}

if ($detail['pi'] == 1 || $detail['pi'] < 1) {
    $identifyact = 'active';
} elseif ($detail['pi'] == 2) {
    $analysisact = 'active';
} elseif ($detail['pi'] == 6) {
    $kriact = 'active';
} elseif ($detail['pi'] == 4) {
    $treatmentact = 'active';
} elseif ($detail['pi'] == 5) {
    $progresact = 'active';
} elseif ($detail['pi'] == 4) {
    $evaluasiacthide = 'active';
} else {
    // $identifyact = 'active';
}

$krion = "hide";

if ($field['iskri'] == 0) {
    $chekya = "checked";
    $treatmentact = 'active';
} else {
    $chekya = "checked";
    $krion = "";
    $treatmentacthide = '';
    $kriact = 'active';
}

// test 
$pb = [
    '' => '- Pilih Proses Bisnis -',
    'proses bisnis 1' => 'Pembelian',
    'penjualan' => 'Penjualan',
    'produksi' => 'Produksi',
    'distribusi' => 'Distribusi',
    'logistik' => 'Logistik',
];
?>




<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-6 panel-heading">
                <h3 style="padding-left:10px;"><?= lang('msg_title'); ?></h3>
            </div>
            <div class="col-sm-6" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="<?= base_url(); ?>"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="<?= base_url(_MODULE_NAME_REAL_); ?>"><?= _MODULE_NAME_; ?></a></li>
                    <li><a><?= lang('msg_title'); ?></a></li>
                    <li><a><?= $detail['pi'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="x_title">
                <strong>Assesment : <?= strtoupper($parent['name']); ?></strong>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="overflow-x: auto;">
                <table class="table">
                    <tr>
                        <td width="20%"><em>Risk Owner</em></td>
                        <td><?= $parent['name']; ?></td>
                    </tr>
                    <tr>
                        <td><em>Risk Agent</em></td>
                        <td><?= $parent['officer_name']; ?></td>
                    </tr>
                    <tr>
                        <td><em>Periode</em></td>
                        <td><?= $parent['periode_name']; ?></td>
                    </tr>
                    <tr>
                        <td><em>Anggaran RKAP</em></td>
                        <td><?= number_format($parent['anggaran_rkap']); ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <a href="<?= base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/add/' . $parent['owner_no'] . '/' . $parent['id']) ?>" class="btn btn-primary <?= $hide_edit ?>"> <?= lang('msg_tombol_add'); ?> </a>
            <a href="<?= base_url(_MODULE_NAME_REAL_ . '/risk_event/' . $parent['owner_no'] . '/' . $parent['id']); ?>" class="btn btn-default"> Kembali ke List </a>
            <div class="clearfix"></div>
        </section>
        <h4><?= lang('msg_sub_title'); ?></h4>
    </div>
    <aside class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="x_content" id="list_peristiwa">
                <ul class="nav nav-tabs">
                    <li role="presentation" class="<?= $identifyact ?>"><a href="#identify" data-toggle="tab">Risk Identification</a></li>
                    <li role="presentation" class="<?= $analysisact ?> <?= $analysisacthide ?>"><a href="#analysis" data-toggle="tab">Risk Analysis</a></li>
                    <li role="presentation" class="<?= $evaluasiact ?> <?= $evaluasiacthide ?>"><a href="#evaluasi" data-toggle="tab">Risk Evaluation</a></li>
                    <li role="presentation" class="<?= $treatmentact ?> <?= $treatmentacthide ?>"><a href="#treatment" data-toggle="tab">Risk Treatment</a></li>
                    <li role="presentation" class="<?= $progresact ?> <?= $progresacthide ?>"><a href="#progres" data-toggle="tab">Risk Treatment</a></li>
                    <li role="presentation" class="<?= $kriact ?> <?= $krion  ?>"><a href="#iskri" data-toggle="tab">Key Risk Indikator</a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
            <div class="tab-content">
                <div id="identify" class="tab-pane fade in  <?= $identifyact ?>">
                    <!-- <?php doi::dump($detail['pi']); ?>     -->
                    <div class="clearfix"> </div>

                    <?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_peristiwa'), ['id_edit' => $id_edit, 'rcsa_no' => $rcsa_no]); ?>
                    <?= form_hidden('tab', 'identify', 'class="form-control text-right" id="tab"'); ?>
                    <?= form_hidden('pi', ($detail) ? ($detail['pi']) : '0', 'class="form-control text-right" id="pi"'); ?>
                    <?= form_hidden('id_edit_baru', ($id_edit) ? ($id_edit) : '0', 'class="form-control text-right" id="id_edit"'); ?>

                    <div class="col-md-12 col-sm-12 col-xs-12" id="input_peristiwa">
                        <section class="x_panel">
                            <div class="x_content">
                                <table class="table table-borderless" id="tbl_peristiwa">
                                    <tbody>
                                        <tr>
                                            <td width="20%">Sasaran</td>
                                            <td colspan="2"><?= form_dropdown('sasaran', $sasaran, ($detail) ? $detail['sasaran_no'] : '', 'class="select2 form-control" style="width:100%;" id="sasaran"' . $disable); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Tema Risiko (T1)</td>
                                            <td colspan="2"><?= form_dropdown('tema', $tema, ($detail) ? $detail['tema'] : '', 'class="select2 form-control" style="width:100%;" id="tema"' . $disable); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="20%">Kategori Risiko(T2)</td>
                                            <td colspan="2"><?= form_dropdown('kategori', $kategori, ($detail) ? $detail['kategori_no'] : '', 'class="select2 form-control" style="width:100%;" id="kategori"' . $disable); ?></td>
                                        </tr>
                                        <!-- <tr class="hide">
                                            <td width="20%">Subkategori risiko (T3)</td>
                                            <td colspan="2"><?= form_dropdown('sub_kategori', $subkategori, ($detail) ? $detail['sub_kategori'] : '', 'class="select2 form-control" style="width:100%;" id="sub_kategori"' . $disable); ?></td>

                                        </tr> -->
                                        <tr>
                                            <td width="20%">Subkategori Risiko</td>
                                            <td colspan="2"><?= form_dropdown('subrisiko', $np, ($detail) ? $detail['subrisiko'] : '', 'class="select2 form-control" style="width:100%;" id="subrisiko"' . $disable); ?></td>
                                        </tr>


                                        <tr>
                                            <td width="20%">Proses Bisnis</td>
                                            <td colspan="2"><?= form_dropdown('proses_bisnis', $pb, ($detail) ? $detail['proses_bisnis'] : '', 'class="select2 form-control" style="width:100%;" id="proses_bisnis"' . $disable); ?></td>
                                        </tr>

                                        <tr>
                                            <td width="20%">Tampilkan di Heatmap</td>
                                            <td colspan="2"><?= form_checkbox('sts_heatmap', 'sts_heatmap', 1, ($detail) ? $detail['sts_heatmap'] : '', 'class="select2 form-control form-check-input" style="width:100%;"' . $disable); ?></td>
                                        </tr>


                                        <tr>
                                            <td width="20%" rowspan="3">Peristiwa (T3)</td>
                                        </tr>
                                        <tr class="peristiwa_lib">
                                            <td>
                                                <?= form_dropdown('event_no', $cboper, ($detail) ? $detail['event_no'] : '', 'class="eventcombo select2 form-control" style="width:100%;" id="event_no"' . $disable); ?>
                                                <?php if ($detail) {
                                                    // echo form_hidden('event_no', $detail['event_no']);
                                                } ?>
                                            </td>
                                            <td>

                                                <span class="btn btn-info <?= $hide_edit ?>" id="peristiwa_baru">New</span>
                                            </td>
                                        </tr>
                                        <tr class="peristiwa_baru">
                                            <td>
                                                <?= form_input('peristiwabaru', ($detail) ? ($detail['peristiwabaru']) : '', 'class="form-control" placeholder="Input Peristiwa Baru" id="peristiwabaru"'); ?>
                                            </td>
                                            <td>
                                                <span class="btn btn-info" id="peristiwa_lib">Library</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <table class="table instlmt_cause" id="instlmt_cause">
                                                <thead>
                                                    <tr>
                                                        <td colspan="3">Penyebab</td>
                                                    </tr>
                                                    <tr>
                                                        <!-- <th width="10%" style="text-align:center;">No.</th> -->
                                                        <th style="text-align:center;">Risk Cause</th>
                                                        <th width="10%" style="text-align:center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $risk_couseno_array = explode(',', $risk_couseno1);

                                                    // Menghapus spasi di sekitar angka
                                                    $risk_couseno_array = array_map('trim', $risk_couseno_array);
                                                    $no = 1;


                                                    $edit = form_hidden('id_edit[]', '0');
                                                    $cbn = $inp_couse;
                                                    $cbbo = form_dropdown('risk_couse_no[]', $cbogroup, '', 'class="select2 form-control" style="width:100%;" id="risk_couseno' . $no++ . '"');
                                                    foreach ($risk_couseno_array as $couseno) {
                                                        // doi::dump($couseno);


                                                    ?>

                                                        <tr class="couse_lib">
                                                            <!-- <td style="text-align:center;width:10%;"> <?= $no++ ?></td> -->
                                                            <td>
                                                                <?= form_dropdown('risk_couse_no[]', $cbogroup, ($couseno) ? $couseno : '', 'class="select2 form-control" style="width:100%;" id="risk_cousenox"' . $disable); ?>
                                                            </td>
                                                            <td style="text-align:center;width:10%;">
                                                                <span data-edit="<?php echo $id_edit; ?>" data-couseno="<?php echo $couseno; ?>" class="btn" id="couse_delete">
                                                                    <i class="fa fa-cut <?= $hide_edit ?>" title="menghapus data"></i>

                                                                </span>

                                                            </td>
                                                        </tr>
                                                        <tr class="couse_text">
                                                            <!-- <td style="text-align:center;width:10%;"> <?= $no++ ?></td> -->
                                                            <td>
                                                                <?= $inp_couse ?>
                                                            </td>
                                                            <td style="text-align:center;width:10%;">
                                                                <a data-nilai="<?php echo $edit_no; ?>" style="cursor:pointer;" id="couse_delete">
                                                                    <i class="fa fa-cut" title="menghapus data"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    <?php
                                                    }


                                                    ?>
                                                </tbody>
                                            </table>
                                            <center>
                                                <span class="btn btn-warning  " id="add_cause_newsx"> Library Cause </span>
                                                <span class="btn btn-info <?= $hide_edit ?>" id="add_cause_news"> Library Cause </span>
                                                <span class="btn btn-info <?= $hide_edit ?>" id="add_new_cause"> New Cause </span>
                                            </center>

                                        </tr>

                                        <tr>
                                            <table class="table" id="instlmt_impact">
                                                <thead>
                                                    <tr>
                                                        <td colspan="3">Dampak</td>
                                                    </tr>
                                                    <tr>
                                                        <!-- <th width="10%" style="text-align:center;">No.</th> -->
                                                        <th style="text-align:center;">Risk Impact</th>
                                                        <th width="10%" style="text-align:center;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    $risk_impactno = explode(',', $risk_impectno1);

                                                    // Menghapus spasi di sekitar angka
                                                    $risk_impactno = array_map('trim', $risk_impactno);

                                                    // Menghapus nilai duplikat
                                                    $risk_impactno_unique = array_unique($risk_impactno);

                                                    $no = 1;

                                                    $cbbi = form_dropdown('risk_impact_no[]', $cbogroup1,  '', 'class="select2 form-control" style="width:100%;" id="impactno"');

                                                    $edit = form_hidden('id_edit[]', '0');
                                                    $cbni = $inp_impact;

                                                    foreach ($risk_impactno_unique as $impactno) {
                                                        // doi::dump($impactno);
                                                    ?>

                                                        <tr class="impect_lib">
                                                            <!-- <td style="text-align:center;width:10%;"> <?= $no++ ?></td> -->
                                                            <td><?= form_dropdown('risk_impact_no[]', $cbogroup1, ($impactno) ? $impactno : '', 'class="select2 form-control" style="width:100%;" id="impactnox"' . $disable); ?>
                                                            </td>
                                                            <td style="text-align:center;width:10%;">
                                                                <span data-edit="<?php echo $id_edit; ?>" data-impactno="<?php echo $impactno; ?>" class="btn" id="impct_delete">
                                                                    <i class="fa fa-cut <?= $hide_edit ?>" title="menghapus data"></i>

                                                                </span>
                                                            </td>
                                                        </tr>

                                                        <tr class="impect_text">
                                                            <!-- <td style="text-align:center;width:10%;"> <?= $no++ ?></td> -->
                                                            <td><?= $inp_impact ?>
                                                            </td>
                                                            <td style="text-align:center;width:10%;">
                                                                <a nilai="<?php echo $edit_no; ?>" style="cursor:pointer;" onclick="remove_install_impact(this,<?php echo $edit_no; ?>)">
                                                                    <i class="fa fa-cut " title="menghapus data"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <center>
                                                <input id="add_impactx" class="btn btn-warning" type="button" value="Library Impact " name="add_impact">
                                                <!-- <input id="add_impact" class="btn btn-info <?= $hide_edit ?>" type="button" onclick="add_install_impact()" value="Library Impact " name="add_impact"> -->
                                                <span class="btn btn-info <?= $hide_edit ?>" id="add_impact_news"> Library Impact </span>

                                                <button id="add_new_impact" class="btn btn-info <?= $hide_edit ?>" type="button" onclick="add_new_install_impact()" value="Impact New" name="add_new_impact"> New Impact </button>
                                            </center>
                                        </tr>
                                        <tr>
                                            <hr>
                                        </tr>
                                        <tr>
                                            <table class="table table-borderless" id="">
                                                <thead>
                                                    <tr>
                                                        <td width="25%">Asumsi Perhitungan Dampak </td>
                                                        <td>
                                                            <div id="risk_asumsi_perhitungan_dampak" class="input-group">
                                                                <?= form_input('risk_asumsi_perhitungan_dampak', ($detail) ? ($detail['risk_asumsi_perhitungan_dampak']) : '', 'class="form-control text-right" style="width:100%; id="risk_asumsi_perhitungan_dampak"' . $disable); ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </tr>
                                        <tr>
                                            <table class="table table-borderless" id="">
                                                <thead>
                                                    <tr>
                                                        <td width="25%">Dampak Kuantitatif </td>
                                                        <td>
                                                            <div id="l_risk_impact_kuantitatif_parent" class="input-group">
                                                                <span id="span_l_amoun" class="input-group-addon"> Rp </span>
                                                                <?= form_input('risk_impact_kuantitatif', ($detail) ? ($detail['risk_impact_kuantitatif']) : '', 'class="form-control text-right" id="risk_impact_kuantitatif"' . $disable); ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </tr>
                                        <tr>
                                            <table class="table table-borderless" id="">
                                                <thead>
                                                    <tr>
                                                        <td width="25%">PIC </td>
                                                        <td><?= form_dropdown('pic', $area, ($detail) ? $detail['pic'] : '', 'class="select2 form-control" style="width:100%;" id="pic"' . $disable); ?></td>

                                                </thead>
                                            </table>
                                        </tr>




                            </div>
                            </tbody>
                            </table>
                            <div class="x_footer">
                                <ul class="nav navbar-right panel_toolbox">

                                    <li><span class="btn btn-primary pointer <?= $hide_edit ?>" data-tab="identify" id="simpan_peristiwa"> Simpan </span></li>
                                    <!-- <li><span class="btn btn-default pointer " id="cancel_peristiwa" data-dismiss="modal"> Kembali </span></li> -->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </section>
                    </div>
                    <?= form_close(); ?>
                </div>

                <div id="analysis" class="tab-pane fade in <?= $analysisact ?> ">

                    <?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_level'), ['id_edit' => $id_edit, 'rcsa_no' => $rcsa_no]); ?>
                    <?= form_hidden('id_edit_baru', ($id_edit) ? ($id_edit) : '0', 'class="form-control text-right" id="id_edit"'); ?>

                    <?= form_hidden('pi', ($detail) ? ($detail['pi']) : '0', 'class="form-control text-right" id="pi"'); ?>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="input_level">
                        <section class="x_panel">
                            <div class="x_content table-responsive" style="overflow-x: auto;">
                                <table class="table table-striped  table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <!-- Kolom Analisis Risiko Inhern -->
                                            <th style="position: sticky; left: 0; background: white; z-index: 99;" class="text-center" colspan="3">Analisis Risiko Inhern</th>
                                            <!-- Kolom Analisis Risiko Residual -->
                                            <th style="position: sticky; left: 300px; background: white; z-index: 99;" class="text-center" colspan="3">Analisis Risiko Residual</th>
                                            <?php
                                            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                            for ($i = 1; $i < 13; $i++) { ?>
                                                <!-- Kolom Target Risiko Residual untuk bulan-bulan -->
                                                <th class="text-center" colspan="3">Target Risiko Residual <br><?= $bulan[$i - 1] ?></th>
                                                <!-- <th class="text-center" colspan="3">Target Risiko Residual <br> Bulan <?= $i ?></th> -->
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <!-- Kolom Detail Risiko Inhern -->
                                            <th style="position: sticky; left: 0; background: white; z-index: 99;" class="text-center">Skala Dampak</th>
                                            <th style="position: sticky; left: 140px; background: white; z-index: 99;" class="text-center">Skala Probabilitas</th>
                                            <th style="position: sticky; left: 270px; background: white; z-index: 99;" class="text-center">Level Risiko</th>

                                            <!-- Kolom Detail Risiko Residual -->
                                            <th style="position: sticky; left: 320px; background: white; z-index: 99;" class="text-center">Skala Dampak</th>
                                            <th style="position: sticky; left: 430px; background: white; z-index: 99;" class="text-center">Skala Probabilitas</th>
                                            <th style="position: sticky; left: 540px; background: white; z-index: 99;" class="text-center">Level Risiko</th>

                                            <!-- Kolom untuk Target Risiko Residual (Bulan-bulan) -->
                                            <?php for ($i = 1; $i < 13; $i++) { ?>
                                                <th class="text-center">Skala Dampak</th>
                                                <th class="text-center">Skala Probabilitas</th>
                                                <th class="text-center">Level Risiko</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                             <input type="hidden" id="id_detail" value="<?=$detail['id']?>">
                                            <!-- Kolom Detail Risiko Inhern -->
                                            <td style="position: sticky; left: 0; background: white; z-index: 99;" class="text-center">
                                                <?php echo form_dropdown('analisis_like_inherent', $cboLike, (empty($analisiData['analisis_like_inherent'])) ? '' : $analisiData['analisis_like_inherent'], 'class="form-control" data-mode="1" data-month="0" style="width:150px" id="likeAnalisisInheren"'); ?>
                                            </td>
                                            <td style="position: sticky; left: 140px; background: white; z-index: 99;" class="text-center">
                                                <?php echo form_dropdown('analisis_impact_inherent', $cboImpact, (empty($analisiData['analisis_impact_inherent'])) ? '' : $analisiData['analisis_impact_inherent'], 'class="form-control" id="impactAnalisisInheren" style="width:150px"'); ?>
                                            </td>
                                            <td style="position: sticky; left: 270px; background: white; z-index: 99;" class="text-center">
                                                <span id="likeAnalisisInherenLabel">
                                                    <span style="background-color:<?php echo (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color'] : '#fff'; ?>;color:<?php echo (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color_text'] : '#000'; ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper((count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['level_mapping'] : ''); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                </span><span id="spinner-inherent"></span>
                                            </td>

                                            <!-- Kolom Detail Risiko Residual -->
                                            <td style="position: sticky; left: 320px; background: white; z-index: 99;" class="text-center">
                                                <?php echo form_dropdown('analisis_like_residual', $cboLike, (empty($analisiData['analisis_like_residual'])) ? '' : $analisiData['analisis_like_residual'], 'class="form-control" data-mode="2" data-month="0" style="width:150px" id="likeAnalisisResidual"'); ?>
                                            </td>
                                            <td style="position: sticky; left: 430px; background: white; z-index: 99;" class="text-center">
                                                <?php echo form_dropdown('analisis_impact_residual', $cboImpact, (empty($analisiData['analisis_impact_residual'])) ? '' : $analisiData['analisis_impact_residual'], 'class="form-control" id="impactAnalisisResidual" style="width:150px"'); ?>
                                            </td>
                                            <td style="position: sticky; left: 540px; background: white; z-index: 99;" class="text-center">
                                                <span id="likeAnalisisResidualLabel">
                                                    <span style="background-color:<?php echo (count($analisiData['residual_level_text']) > 0) ? $analisiData['residual_level_text'][0]['color'] : '#fff'; ?>;color:<?php echo (count($analisiData['residual_level_text']) > 0) ? $analisiData['residual_level_text'][0]['color_text'] : '#000'; ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper((count($analisiData['residual_level_text']) > 0) ? $analisiData['residual_level_text'][0]['level_mapping'] : ''); ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                </span><span id="spinner-residual"></span>
                                            </td>
                                            <!-- Kolom untuk Target Risiko Residual (Bulan-bulan) -->
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                <input type="hidden" name="month" id="month">
                                                <td class="text-center">
                                                <?php echo form_dropdown('target_like', $cboLike, (empty($target_like[$i-1])) ? '' : $target_like[$i-1], 'class="form-control" data-mode="3" data-month="' . $i . '" style="width:150px" id="likeTargetResidual'.$i.'"'); ?>
                                                </td>
                                                <td class="text-center">
                                                <?php echo form_dropdown('target_impact', $cboImpact, (empty($target_impact[$i-1])) ? '' : $target_impact[$i-1], 'class="form-control" data-mode="3" data-month="' . $i . '" style="width:150px" id="impactTargetResidual'.$i.'"'); ?>                                                </td>
                                                <td class="text-center">
                                                    <span id="targetResidualLabel<?= $i ?>">
                                                        <span style="background-color:<?php echo (count($data['residual_level_text']) > 0) ? $data['residual_level_text'][0]['color'] : '#fff'; ?>;color:<?php echo (count($data['residual_level_text']) > 0) ? $data['residual_level_text'][0]['color_text'] : '#000'; ?>;">
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper((count($data['residual_level_text']) > 0) ? $data['residual_level_text'][0]['level_mapping'] : ''); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                    </span>
                                                    <span id="spinner-residual<?= $i ?>"></span>
                                                </td>
                                            <?php } ?>

                                        </tr>
                                    </tbody>


                                </table>

                            </div>

                            <div class="x_footer <?= $analysisacthide ?>">
                                <ul class="nav navbar-right panel_toolbox ">
                                    <li><span class="btn btn-primary pointer <?= $hide_edit ?>" id="simpan_analisis"> Simpan </span></li>
                                    <!-- <li><span class="btn btn-default pointer" id="cancel_level" data-dismiss="modal"> Kembali </span></li> -->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </section>
                    </div>
                    <?= form_close(); ?>
                </div>

                <div id="evaluasi" class="tab-pane fade in <?= $evaluasiact ?> ">

                    <?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_level'), ['id_edit' => $id_edit, 'rcsa_no' => $rcsa_no]); ?>
                    <?= form_hidden('id_edit_baru', ($id_edit) ? ($id_edit) : '0', 'class="form-control text-right" id="id_edit"'); ?>

                    <?= form_hidden('pi', ($detail) ? ($detail['pi']) : '0', 'class="form-control text-right" id="pi"'); ?>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="input_level">
                        <section class="x_panel">
                            <div class="x_content">
                                <div class="table-responsive">
                                    <?php
                                    foreach ($level_resiko as $row) { ?>
                                        <div class="col-md-3 col-sm-3 col-xs-3"><?= $row['label'] ?></div>
                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                            <div class="form-group form-inline"><?= $row['isi'] ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="x_footer <?= $evaluasiacthide ?>">
                                <ul class="nav navbar-right panel_toolbox ">
                                    <li><span class="btn btn-primary pointer <?= $hide_edit ?>" id="simpan_level"> Simpan </span></li>
                                    <!-- <li><span class="btn btn-default pointer" id="cancel_level" data-dismiss="modal"> Kembali </span></li> -->
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </section>
                    </div>
                    <?= form_close(); ?>
                </div>

                <div id="treatment" class="tab-pane fade in <?= $treatmentact ?> <?= $treatmentacthide ?> ">

                    <div id="list_mitigasi">
                        <?php
                        if ($field) {
                            $isi_owner_no_action = json_decode($field['owner_no'], true);
                            $isi_owner_no_action_accountable = json_decode($field['accountable_unit'], true);
                        } else {
                            $isi_owner_no_action = [];
                            $isi_owner_no_action_accountable = [];
                        }

                        if (!$isi_owner_no_action_accountable) {
                            $isi_owner_no_action_accountable[] = $owner['rcsa_owner_no'];
                        }

                        ?>

                        <?= form_open_multipart(base_url('rcsa/simpan_mitigasi'), array('id' => 'form_mitigasi'), ['id_detail' => $id_edit, 'id_edit_mitigasi' => $id_edit_mitigasi, 'rcsa_no' => $rcsa_no, 'rcsa_no_1' => $rcsa_no_1]); ?>
                        <?= form_hidden('pi', ($detail) ? ($detail['pi']) : '0', 'class="form-control text-right" id="pi"'); ?>
                        <section class="x_panel">
                            <div class="row">
                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_proaktif'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_textarea('proaktif', ($field) ? $field['proaktif'] : '', " id='proaktif' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'" . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_reaktif'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_textarea('reaktif', ($field) ? $field['reaktif'] : '', " id='reaktif' maxlength='500' size=500 class='form-control' rows='2' cols='5' style='overflow: hidden; width: 500 !important; height: 104px;'" . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix  ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_owner_perlakuan'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_dropdown('owner_no_action[]', $cbo_owner, $isi_owner_no_action, 'multiple="multiple" class="select2 form-control" style="width:100%;" id="owner_no_action"' . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix hide">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_responsible_unit'); ?>ddd</label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_dropdown('owner_no_action_accountable[]', $cbo_owner, $isi_owner_no_action_accountable, 'multiple="multiple" class="select2 form-control" style="width:100%;" id="owner_no_action_accountable"' . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_schedule'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_input('sumber_daya', ($field) ? $field['sumber_daya'] : '', 'class="form-control" style="width:100%;" id="sumber_daya"' . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_biaya_penangan'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                        <div id="l_amount_parent" class="input-group">
                                            <span id="span_l_amoun" class="input-group-addon"> Rp </span>
                                            <?= form_input('amount', ($field) ? number_format($field['amount']) : '', 'class="form-control text-right rupiah" id="amount"' . $readonly); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_target_waktu'); ?><sup><span class="required"></span></sup></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_input('target_waktu', ($field) ? $field['target_waktu'] : date('d-m-Y'), " id='target_waktu' size='20' class='form-control datepicker' style='width:130px;'" . $readonly); ?></div>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="col-sm-3 control-label text-left">apakah termasuk risiko KRI ?</label>
                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                        <input type="radio" name="iskri" id="ya" value="1" <?= $disable ?> <?= $chekya ?>> <label for="ya">Ya</label> &nbsp; &nbsp; &nbsp;
                                        <input type="radio" name="iskri" value="0" id="tidak" <?= $disable ?> <?= $chektdk ?>> <label for="tidak">Tidak</label>
                                    </div>
                                </div>

                                <div class="form-group clearfix ">
                                    <label class="col-sm-3 control-label text-left"><?= lang('msg_field_risk_attacment'); ?></label>
                                    <div class="col-md-9 col-sm-9 col-xs-9"><?= form_upload("lampiran", ""); ?></div>
                                    <br>
                                    <?php
                                    if (!empty($field['lampiran'])) {
                                        $l = json_decode($field['lampiran'], true);
                                        foreach ($l as $lk) { ?>
                                            <!-- <img src="<?= base_url('themes/file/rcsa/' . $lk['name']); ?>" width="100" height="50" title=""> -->

                                            <!-- <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="<?php echo base_url(_MODULE_NAME_REAL_ . '/downloadfile/' . $lk['name']); ?>">
                                                <span style="display: inline-block; text-align: center;">
                                                    <i class="glyphicon glyphicon-eye-open"></i>
                                                </span>
                                            </a> -->
                                            <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="<?php echo base_url(_MODULE_NAME_REAL_ . '/downloadfile/' . $lk['name']); ?>">
                                                <span style="display: inline-block; text-align: center;">
                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                </span>
                                            </a>
                                            <span><?= $lk['name'] ?></span>

                                    <?php }
                                    } ?>
                                </div>
                                <div class="x_footer">
                                    <ul class="nav navbar-right panel_toolbox">
                                        <input class="btn btn-primary pointer <?= $hide_edit ?>" id="simpan_mitigasi" value="Simpan" />

                                        <!-- <li><span class="btn btn-primary pointer <?= $hide_edit ?>" id="simpan_mitigasi"> Simpan </span></li> -->
                                        <!-- <li><span class="btn btn-default pointer" id="close_input_mitigasi" data-dismiss="modal"> Kembali </span></li> -->
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <?= form_close(); ?>

                            </div>
                        </section>
                    </div>
                </div>

                <div id="iskri" class="tab-pane fade in <?= $kriact ?><?= $krion ?> ">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="input_level">
                        <section class="x_panel">
                            <div class="x_content">
                                <div class="table-responsive">

                                    <?= $inptkri; ?>
                                </div>
                            </div>
                        </section>
                    </div>
                    <?= form_close(); ?>
                </div>

                <div id="progres" class="tab-pane fade in <?= $progresact ?> <?= $progresacthide ?> ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <section class="x_panel">
                                <div class="x_title">
                                    <strong>Progress Treatment</strong>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li class="pull-right"><a class="collapse-link pull-right">Lihat Peristiwa &nbsp;<i class="fa fa-chevron-up"></i></a></li>

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow-x: auto;">

                                    <div class="col-md-12 col-sm-12 col-xs-12" style="background-color:#c0d5e5;">
                                        <table class="table">
                                            <tr>
                                                <td colspan="2" class="text-center">PERISTIWA</td>
                                            </tr>
                                            <tr>
                                                <td width="20%"><em>Tema Risiko (T1)</em></td>
                                                <td><?= $detail['kategori']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><em>Kategori Risiko (T2)</em></td>
                                                <?php $combo = $this->db->where('id', $detail['sub_kategori'])->get('bangga_data_combo')->row_array(); ?>
                                                <td><?= $combo['data']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><em>Peristiwa</em></td>
                                                <td><?= $detail['event_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><em>Risk Level</em></td>
                                                <?php
                                                $like = $this->db
                                                    ->where('id', $residual_level['likelihood'])
                                                    ->get('bangga_level')->row_array();

                                                $impact = $this->db
                                                    ->where('id', $residual_level['impact'])
                                                    ->get('bangga_level')->row_array();
                                                $likeinherent = $this->db
                                                    ->where('id', $inherent_level['likelihood'])
                                                    ->get('bangga_level')->row_array();

                                                $impactinherent = $this->db
                                                    ->where('id', $inherent_level['impact'])
                                                    ->get('bangga_level')->row_array();

                                                ?>
                                                <td>

                                                    <span id="inherent_level_label">
                                                        <span style="background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;">&nbsp; <?= $likeinherent['code']; ?> x <?= $impactinherent['code']; ?>&nbsp;<?= $inherent_level['level_mapping']; ?>&nbsp;</span>
                                                    </span>

                                                    &nbsp;&nbsp;&nbsp; => &nbsp;&nbsp;

                                                    <span id="residual_level_label">
                                                        <span style="background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;">&nbsp; <?= $like['code']; ?> x <?= $impact['code']; ?>&nbsp;<?= $residual_level['level_mapping']; ?>&nbsp;</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <?= form_open_multipart(base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/save'), array('id' => 'form_realisasi'), ['id_edit' => $edit_no, 'rcsa_no' => $rcsa_no, 'detail_rcsa_no' => $rcsa_detail_no]); ?>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="input_realisasi">

                    </div>
                    <?= form_close(); ?>

                    <div id="list_realisasi">
                        <?= $list_realisasi; ?>
                    </div>
                </div>

            </div>
        </section>
    </aside>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var collapsible = document.getElementsByClassName("collapse-link");
        var i;

        for (i = 0; i < collapsible.length; i++) {
            collapsible[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });

            // Trigger click event
            collapsible[i].click();
        }
    });
</script>
<script>
    $(function() {



        $("#kategori").change(function() {
            var parent = $(this).parent();
            var nilai = $(this).val();
            var data = {
                'id': nilai,
            };
            var target_combo = $(".eventcombo");
            var url = "ajax/get_ajax_kelevent";
            cari_ajax_combo("post", parent, data, target_combo, url);
        })

    });
</script>
<script type="text/javascript">
    var no_urut = 1;
    var cbiImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbni)); ?>';
    var cboImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbi)); ?>';
    var editImpact = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';


    var cbnCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbn)); ?>';
    var cboCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $cbbo)); ?>';
    var editCouse = '<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi", "", $edit)); ?>';
</script>

<script>
    // Wait for the page to finish loading
    // Wait for the page to finish loading
    document.addEventListener("DOMContentLoaded", function() {
        // Hide the "peristiwa_baru" row
        var peristiwaBaruRow = document.querySelector(".peristiwa_baru");
        peristiwaBaruRow.style.display = "none";
        var couseText = document.querySelector(".couse_text");
        var impectText = document.querySelector(".impect_text");
        couseText.style.display = "none";
        impectText.style.display = "none";

        // Get the required elements
        var peristiwaBaruBtn = document.getElementById("peristiwa_baru");
        var peristiwaLibRow = document.querySelector(".peristiwa_lib");
        var couseLibRow = document.querySelector(".couse_lib");
        var impectLibRow = document.querySelector(".impect_lib");

        // Add a click event listener to the "peristiwa_baru" button
        peristiwaBaruBtn.addEventListener("click", function() {
            // Show the "peristiwa_baru" row
            peristiwaBaruRow.style.display = "table-row";
            couseText.style.display = "table-row";
            impectText.style.display = "table-row";
            // Hide the "peristiwa_lib" row
            peristiwaLibRow.style.display = "none";
            couseLibRow.style.display = "none";
            impectLibRow.style.display = "none";
        });
        // Get the required elements
        var peristiwaLibBtn = document.getElementById("peristiwa_lib");
        var peristiwaLibRow = document.querySelector(".peristiwa_lib");
        var couseLibRow = document.querySelector(".couse_lib");
        var impectLibRow = document.querySelector(".impect_lib");
        var peristiwaBaruRow = document.querySelector(".peristiwa_baru");
        var couseText = document.querySelector(".couse_text");
        var impectText = document.querySelector(".impect_text");

        // Add a click event listener to the "peristiwa_lib" button
        peristiwaLibBtn.addEventListener("click", function() {
            // Show the "peristiwa_lib" row
            peristiwaLibRow.style.display = "table-row";
            couseLibRow.style.display = "table-row";
            impectLibRow.style.display = "table-row";
            // Hide the "peristiwa_baru" row
            peristiwaBaruRow.style.display = "none";
            couseText.style.display = "none";
            impectText.style.display = "none";
        });

    });
</script>