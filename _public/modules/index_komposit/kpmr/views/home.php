<?php
if ($this->session->userdata('result_proses')){
    $info = $this->session->userdata('result_proses');
    $this->session->set_userdata(array('result_proses'=>''));
    $sts_input='info';
}

if ($this->session->userdata('result_proses_error')){
    $info =  $this->session->userdata('result_proses_error');
    $this->session->set_userdata(array('result_proses_error'=>''));
    $sts_input='danger';
}
?>
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;"><?= lang("msg_title") ?></h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Index Komposit</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<section class="x_panel">
    <div class="x_title">

        <apn>Parameter Kualitas Penerapan Manajemen Risiko (KPMR)</apn>
    </div>
    <div class="clearfix"></div>
    <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_ . '/index'); ?>">
        <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-6">
                <label for="filter_periode">Tahun</label>
                <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
                    <?php foreach ($cboPeriod as $key => $value): ?>
                        <option value="<?= ($key == 0) ? '0' : $value; ?>" <?= ($periode == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-2">
                <label for="filter_triwulan">Triwulan <?= $tw ?></label>
                <select name="triwulan" id="filter_triwulan" class="form-control select2" style="width: 80%;">
                    <option value="1" <?= ($tw == 1) ? 'selected' : ''; ?>>Triwulan 1</option>
                    <option value="2" <?= ($tw == 2) ? 'selected' : ''; ?>>Triwulan 2</option>
                    <option value="3" <?= ($tw == 3) ? 'selected' : ''; ?>>Triwulan 3</option>
                    <option value="4" <?= ($tw == 4) ? 'selected' : ''; ?>>Triwulan 4</option>
                </select>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-2 mt-3">
                <button type="submit" class="btn btn-success text-white" style="margin-top: 25px;">
                    <span class="glyphicon glyphicon-search"></span>&nbsp;Filter
                </button>
            </div>
        </div>
    </form>
</section>

<?php
    $hide="hide";
 if($tw && $periode){
    $hide="";
}
?>
<form method="POST" id='form-lost' enctype="multipart/form-data"  action="<?= base_url(_MODULE_NAME_REAL_ . '/simpan');?>">
<input type="hidden" name="owner" value="<?=$owner?>">
<input type="hidden" name="tw" value="<?=$tw?>">
<input type="hidden" name="periode" value="<?=$periode?>">
<div class="rows table-responsive">
<table class="display table table-bordered" id="tbl_event">
    <thead>
        <tr>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">No.</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="15%" colspan="2">Parameter</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Skala</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Hasil Penilaian</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">Realisasi</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="50px">Perhitungan</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="50px">Hasil Penilaian</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Penjelasan</th>
            <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;">Evidence</th>
        </tr>
    </thead>
    
    <tbody class="<?=$hide?>">
        <?php $nc = 1;
        $totalPenilaianCombo = 0;
        foreach ($kompositData as $c) :

            $ss = 1;
            $parentRowspan = 0;

            foreach ($c['parent'] as $pk) {
                $countDetail = $c['detail'][$pk['id']];
                $parentRowspan += count($countDetail) + 1;
                if (count($countDetail) > 0) :
                    $ss = 2;
                endif;
            }
        ?>
            <tr style="background-color:#d5edef;">
                <td class="text-center" width="5%" rowspan="<?= $parentRowspan + $ss ?>"><?= $nc ?></td>
                <td colspan="9"><b><?= $c['data'] ?></b></td>
            </tr>

            <?php foreach ($c['parent'] as $pKey => $pk) :
                $countDetailx = $c['detail'][$pk['id']];

                $resParents = $this->db
                    ->where('id_komposit', $pk['id_combo'])
                    // ->where('owner', $owner)
                    ->where('tw', $tw)
                    ->where('periode', $periode)
                    ->order_by('urut')
                    ->get('bangga_indexkom_realisasi')
                    ->row_array();
            ?>

                <tr>
                    <td rowspan="<?= count($countDetailx) + 1 ?>"><?= $pk['urut']; ?></td>
                    <td width="40%"
                        <?php if (count($countDetailx) > 0) : ?>
                        colspan="8"
                        <?php endif; ?>>
                        <?= $pk['parameter']; ?>
                    </td>
                    <?php if (count($countDetailx) === 0) : ?>
                        <td width="5%"><?= $pk['skala']; ?></td>
                        <td width="5%"><?= $pk['penilaian']; ?></td>
                        <?php if ($pKey === 0) : ?>
                            <td width="5%" rowspan="<?= count($c['parent']) ?>">
                                <select class="form-control skala-dropdown" name="realisasi[]" id="skala-<?= $pk['urut']; ?><?= $pk['id']; ?>" style="width: 110px;"
                                    data-bobot="<?= $pk['bobot']; ?>"
                                    data-id-parent="<?= $pk['id']; ?>"
                                    data-input-id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>"
                                    data-input-rumus-id="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>">
                                    <option selected value="0" data-bobot="0" data-penilaian="0"> -Skala- </option>
                                    <?php foreach ($c['parent'] as $option) : ?>
                                        <option value="<?= $option['skala']; ?>"
                                            data-bobot="<?= $pk['bobot']; ?>"
                                            <?= ($resParents['realisasi'] == $option['skala']) ? 'selected' : ''; ?>
                                            data-penilaian="<?= $option['penilaian']; ?>">
                                            <?= $option['skala']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td rowspan="<?= count($c['parent']) ?>">
                                <input type="hidden" name="id[]" value="<?= $pk['id_combo'] ?>">
                                <input type="hidden" name="urut[]" value="<?= $pk['urut'] ?>">

                                <center>
                                    <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                </center>
                            </td>
                            <td rowspan="<?= count($c['parent']) ?>">
                                <center>
                                    <input class="form-control perhitungan" style="width: 100px; text-align: center;" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                </center>
                            </td>

                            <td rowspan="<?= count($c['parent']) ?>"><textarea name="penjelasan[]" id="penjelasan"><?= $resParents['penjelasan'] ?></textarea></td>
                            <td rowspan="<?= count($c['parent']) ?>">
                                <?php if (isset($resParents['evidence'])): ?>
                                    <!-- Preview Link -->
                                    <a href="<?= base_url('themes/upload/evidence/'.$resParents['evidence']) ?>" target="_blank" class="btn btn-info btn-xs" style="text-align: center;">
                                        <i class="fa fa-eye"></i> Pdf Preview
                                    </a>
                                <?php endif; ?>
                                <input class="form-control" style="min-width:200px;" type="file" name="evidence[]" id="evidence" multiple>
                            </td>

                        <?php endif; ?>
                    <?php endif; ?>
                </tr>

                <?php
                $totalPenilaian = 0;
                $totalPenilaianCombo = 0;
                $n = 1;
                foreach ($countDetailx as $dKey => $d) :
                    $totalPenilaian += $d['penilaian'];
                    $totalPenilaianCombo += $d['penilaian'];
                    $resDetail = $this->db
                        ->where('id_komposit', $d['id_param'])
                        ->where('urut', $pk['urut'])
                        // ->where('owner', $owner)
                        ->where('tw', $tw)
                        ->where('periode', $periode)
                        ->order_by('urut')
                        ->get('bangga_indexkom_realisasi')
                        ->row_array();
                ?>
                    <tr>
                        <td width="40%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                        <td width="5%"><?= $d['skala']; ?></td>
                        <td width="5%"><?= $d['penilaian']; ?></td>

                        <?php if ($dKey === 0) : ?>
                            <td width="5%" rowspan="<?= count($countDetailx) ?>">
                                <select class="form-control skala-dropdown" name="realisasi[]" id="skala-<?= $pk['urut']; ?><?= $d['id']; ?>" style="width: 110px;"
                                    data-bobot="<?= $pk['bobot']; ?>"
                                    data-urut="<?= $d['urut']; ?>"
                                    data-nc="<?= $nc; ?>"
                                    data-id-parent="<?= $d['id_param']; ?>"
                                    data-input-id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>"
                                    data-input-rumus-id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>">
                                    <option selected value="0" data-bobot="0" data-penilaian="0"> -Skala- </option>
                                    <?php foreach ($countDetailx as $option) : ?>
                                        <option value="<?= $option['skala']; ?>"
                                            <?= ($resDetail['realisasi'] == $option['skala']) ? 'selected' : ''; ?>
                                            data-bobot="<?= $pk['bobot']; ?>"
                                            data-penilaian="<?= $option['penilaian']; ?>">
                                            <?= $option['skala']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td rowspan="<?= count($countDetailx) ?>">
                                <input type="hidden" name="id[]" value="<?= $d['id_param'] ?>">
                                <input type="hidden" name="urut[]" value="<?= $d['urut'] ?>">

                                <center>
                                    <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                </center>
                            </td>
                            <td rowspan="<?= count($countDetailx) ?>">

                                <center>
                                    <input class="form-control subTotalDetail-<?= $nc; ?>" style="width: 100px; text-align: center" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                </center>
                            </td>
                            <td rowspan="<?= count($countDetailx) ?>">
                                <textarea name="penjelasan[]" id="penjelasan<?= $n; ?>" placeholder="Masukkan penjelasan"><?= $resDetail['penjelasan'] ?></textarea>
                            </td>
                            <td rowspan="<?= count($countDetailx) ?>">
                                <input class="form-control" style="min-width:200px;" type="file" name="evidence[]" id="evidence<?= $n; ?>" placeholder="Masukkan evidence">
                            </td>

                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <?php if ($ss > 1) : ?>
                <tr>
                    <td class="text-center text-right" style="text-align: right;" colspan="6"><strong>Total Point <?= $nc ?>: </strong></td>
                    <td class="text-center">
                        <input class="form-control perhitungan" style="width: 100px; text-align: center" type="text" id="totalDetail-<?= $nc; ?>" name="totalDetail-<?= $nc; ?>" readonly>
                    </td>
                </tr>
            <?php endif; ?>
        <?php
            $nc++;
        endforeach; ?>
    </tbody>

    <tr style="position: sticky; bottom: 0; background: #367FA9; color:#fff; z-index: 1;">
        <th class="text-center" style="font-weight:bold; color:#fff;" colspan="7">Hasil Perhitungan Indikator KPMR : </th>
        <th class="text-center" style="background:yellow; color:#000;">
            <span id="totalPerhitunganText">0</span>
            <input class="form-control " type="hidden" id="totalPerhitungan" name="totalPerhitungan" readonly>
        </th>
        <th class="text-center" colspan="2">
            <button class="btn btn-save <?=$hide?>" id="simpan">
                <i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan
            </button>
        </th>
    </tr>
</table>
</form>

</div>
<style>
    .btn-save {
        background-color: #fff;
        color: #367FA9;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .btn-save:hover {
        background-color: #28597A;
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3);
    }

    .btn-save:active {
        background-color: #204562;
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.4);
    }
</style>