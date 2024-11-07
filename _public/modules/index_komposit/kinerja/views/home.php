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
            <span>Parameter Penentuan Hasil Penilaian Pencapaian Kinerja</span>
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
                <div class="col-md-6 col-sm-8 col-xs-6">
                    <label for="filter_owner">Risk Owner</label>
                    <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboOwner as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($owner == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
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
 if($owner && $tw && $periode){
    $hide="";
}
?> 
<input type="hidden" name="owner" value="<?=$owner?>">
<input type="hidden" name="tw" value="<?=$tw?>">
<input type="hidden" name="periode" value="<?=$periode?>">
 <table class="display table table-bordered" id="tbl_event">
     <thead>
         <tr>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">No.</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="15%" colspan="2">Parameter</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Skala</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Hasil Penilaian</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">Target RKAP 2023</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">Realisasi Tw 1 2024</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">%</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="5%">Skala</th>
             <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">Hasil</th>
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
                    ->where('owner', $owner)
                    ->where('tw', $tw)
                    ->where('periode', $periode)
                    ->order_by('urut')
                    ->get('bangga_indexkom_realisasi')
                    ->row_array();
                ?>
                 <tr>
                     <td rowspan="<?= count($countDetailx) + 1 ?>"><?= $pk['urut']; ?></td>
                     <td width="30%"
                         <?php if (count($countDetailx) > 0) : ?>
                         colspan="8"
                         <?php endif; ?>>
                         <?= $pk['parameter']; ?>
                     </td>

                     <?php if (count($countDetailx) === 0) : ?>
                         <td width="5%"><?= $pk['skala']; ?></td>
                         <td width="5%"><?= $pk['penilaian']; ?></td>
                         <?php if ($pKey === 0) : ?>
                             <td>
                                 <input type="text" id="target-<?= $pk['id']; ?>" value="<?=$resParents['target']?>" data-absolut="0" style="width: 150px; text-align:right;" name="target[]" oninput="updatePercentage(<?= $pk['id']; ?>)">
                             </td>
                             <td>
                                 <input type="text" id="realisasitw-<?= $pk['id']; ?>" data-absolut="0" value="<?=$resParents['realisasitw']?>"  style="width: 150px; text-align:right;" name="realisasitw[]" oninput="updatePercentage(<?= $pk['id']; ?>)" >
                             </td>
                             <td class="text-center" width="10%">
                             <input type="hidden" name="idx[]" value="<?= $pk['id'] ?>">
                             <input type="checkbox" id="isAbsolute-<?= $pk['id']; ?>-1" name="absolut[]" value="1" <?= $resParents['absolut'] > 0 ? 'checked' : '' ?> onclick="updatePercentage(<?= $pk['id']; ?>)">
                             <label for="isAbsolute-<?= $pk['id']; ?>-1">Absolute</label>
                                 <br><span class="badge" id="persentase-<?= $pk['id']; ?>">0 %</span>
                             </td>
                             <td>
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
                                     <input class="form-control perhitungan" style="width: 100px; text-align: center;" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                 </center>
                             </td>
                         <?php endif; ?>

                     <?php endif; ?>
                 </tr>

                 <?php
                    $totalPenilaian = 0;
                    $n = 1;
                    foreach ($countDetailx as $dKey => $d) :
                        $totalPenilaian += $d['penilaian'];
                        $totalPenilaianCombo += $d['penilaian'];
                        $resDetail = $this->db
                            ->where('id_komposit', $d['id_param'])
                            ->where('urut', $pk['urut'])
                            ->where('owner', $owner)
                            ->where('tw', $tw)
                            ->where('periode', $periode)
                            ->order_by('urut')
                            ->get('bangga_indexkom_realisasi')
                            ->row_array();
                    ?>
                     <tr>
                         <td width="30%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                         <td width="5%"><?= $d['skala']; ?></td>
                         <td width="5%"><?= $d['penilaian']; ?></td>
                         <?php if ($dKey === 0) : ?>
                             <td>
                                 <input type="text" class="form-control" id="target-<?= $d['id']; ?>" value="<?=$resDetail['target']?>" data-absolut="0" style="width: 150px; text-align:right;" name="target[]" oninput="updatePercentage(<?= $d['id']; ?>)">
                             </td>
                             <td>
                                 <input type="text" class="form-control" id="realisasitw-<?= $d['id']; ?>" value="<?=$resDetail['realisasitw']?>" data-absolut="0" style="width: 150px; text-align:right;" name="realisasitw[]" oninput="updatePercentage(<?= $d['id']; ?>)">
                             </td>
                             <td class="text-center" width="10%">
                                 <input type="hidden" name="idx[]" value="<?= $d['id'] ?>">
                                 <input type="checkbox" id="isAbsolute-<?= $d['id']; ?>-1" name="absolut[]" value="1" onclick="updatePercentage(<?= $d['id']; ?>)" <?= $resDetail['absolut'] > 0 ? 'checked' : '' ?> >
                                 <label for="isAbsolute-<?= $d['id']; ?>-1">Absolute</label> 
                                 <br><span class="badge" id="persentase-<?= $d['id']; ?>">0 %ff</span>
                             </td>
                             <td width="5%" rowspan="<?= count($countDetailx) ?>">
                                 <input type="hidden" name="id[]" value="<?= $d['id_param'] ?>">
                                 <input type="hidden" name="urut[]" value="<?= $d['urut'] ?>">
                                 <select class="form-control skala-dropdown" name="realisasi[]" id="skala-<?= $pk['urut']; ?><?= $d['id']; ?>" style="width: 110px;"
                                     data-bobot="<?= $pk['bobot']; ?>"
                                     data-idx="<?= $d['id']; ?>"
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

                                 <center>
                                     <input class="form-control subTotalDetail-<?= $nc; ?>" style="width: 100px; text-align: center" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                 </center>
                             </td> <?php endif; ?>

                     </tr>
                 <?php endforeach; ?>
             <?php endforeach; ?>
             <?php if ($ss > 1) : ?>

                 <tr>
                     <td class="text-center text-right" style="text-align: right;" colspan="8"><strong>Total Point <?= $nc ?>: </strong></td>
                     <td class="text-center">
                         <input class="form-control perhitungan" style="width: 100px; text-align: center" type="text" id="totalDetail-<?= $nc; ?>" name="totalDetail-<?= $nc; ?>" readonly>
                     </td>
                 </tr>
             <?php endif; ?>

         <?php
                $nc++;
            endforeach; ?>
     </tbody>

     <tr style="position: sticky; bottom: 0;  background: #367FA9; color:#fff; z-index: 1;">
         <th class="text-center" style="text-align:end" colspan="7">
             <button class="btn btn-save <?=$hide?>" id="simpan">
                 <i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan
             </button>
         </th>
         <th class="" style="font-weight:bold; color:#fff; text-align:center" colspan="2">Hasil Perhitungan Indikator: </th>
         <th class="text-center" style="background:yellow; color:#000;">
             <span id="totalPerhitunganText">0</span>
             <input class="form-control " type="hidden" id="totalPerhitungan" name="totalPerhitungan" readonly>
             <!-- <br><br>
                <button class="btn btn-save" id="simpan">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan
                </button> -->
         </th>
     </tr>
 </table>
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