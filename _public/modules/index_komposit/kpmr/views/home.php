    <h3>Parameter Kualitas Penerapan Manajemen Risiko (KPMR)</h3>
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
                <th class="text-center" style="position: sticky; top: 0; background: #fff; z-index: 1;" width="10%">Evidence</th>
            </tr>
        </thead>
        <tbody>
            <?php $nc = 1;
            $totalPenilaianCombo = 0;
            foreach ($kompositData as $c) :
                $parentRowspan = 0;
                $ss = 1;
                foreach ($c['parent'] as $pk) {
                    $countDetail = $pk['detail']; 
                    if (count($countDetail) > 0) :
                        $ss = 2;
                    endif;
                    $parentRowspan += count($countDetail) + 1;
                }
            ?>
                <tr style="background-color:#d5edef;">
                    <td class="text-center" width="5%" rowspan="<?= $parentRowspan + $ss ?>"><?= $nc ?></td>
                    <td colspan="9"><b><?= $c['data'] ?></b></td>
                </tr>

                <?php foreach ($c['parent'] as $pKey => $pk) : 
                     $resParents = $this->db
                     ->where('id_komposit', $pk['id_combo'])
                    //  ->where('urut', $pk['urut'])
                     ->order_by('urut')
                     ->get('bangga_indexkom_realisasi')
                     ->row_array(); 
                    ?>

                    <tr>
                        <td rowspan="<?= count($countDetail) + 1 ?>"><?= $pk['parameter']; ?></td>
                        <td width="40%"
                            <?php if (count($countDetail) > 0) : ?>
                            colspan="8"
                            <?php endif; ?>>
                            <?= $pk['parameter']; ?>
                        </td>
                        <?php if (count($countDetail) === 0) : ?>
                            <td width="5%"><?= $pk['skala']; ?></td>
                            <td width="5%"><?= $pk['penilaian']; ?></td>
                            <?php if ($pKey === 0) : ?>
                                <td width="5%" rowspan="<?= count($c['parent']) ?>">
                                    <select class="form-control skala-dropdown" name="realisasi[]"  id="skala-<?= $pk['urut']; ?><?= $pk['id']; ?>" style="width: 110px;"
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
                                <input type="hidden" name="id[]" value="<?=$pk['id_combo']?>">
                                <input type="hidden" name="urut[]" value="<?=$pk['urut']?>">

                                    <center>
                                        <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                    </center>
                                </td>
                                <td rowspan="<?= count($c['parent']) ?>">
                                    <center>
                                        <input class="form-control perhitungan" style="width: 100px; text-align: center;" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                    </center>
                                </td>
                            
                            <td rowspan="<?= count($c['parent']) ?>"><textarea name="penjelasan[]" id="penjelasan"><?=$resParents['penjelasan']?></textarea></td>
                            <td rowspan="<?= count($c['parent']) ?>"><textarea name="evidence[]" id="evidence"><?=$resParents['evidence']?></textarea></td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tr>

                    <?php
                    $totalPenilaian = 0;
                    $totalPenilaianCombo = 0;
                    $n = 1;
                    foreach ($countDetail as $dKey => $d) :
                        $totalPenilaian += $d['penilaian'];
                        $totalPenilaianCombo += $d['penilaian'];
                        $resDetail = $this->db
                        ->where('id_komposit', $d['parent'])
                        ->where('urut', $pk['urut'])
                        ->order_by('urut')
                        ->get('bangga_indexkom_realisasi')
                        ->row_array(); 
                     ?>
                        <tr>
                            <td width="40%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                            <td width="5%"><?= $d['skala']; ?></td>
                            <td width="5%"><?= $d['penilaian']; ?></td>

                            <?php if ($dKey === 0) : ?>
                                <td width="5%" rowspan="<?= count($countDetail) ?>">
                                    <select class="form-control skala-dropdown" name="realisasi[]" id="skala-<?= $pk['urut']; ?><?= $d['id']; ?>" style="width: 110px;"
                                        data-bobot="<?= $pk['bobot']; ?>"
                                        data-urut="<?= $d['urut']; ?>"
                                        data-id-parent="<?= $d['parent']; ?>"
                                        data-input-id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>"
                                        data-input-rumus-id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>">
                                        <option selected value="0" data-bobot="0" data-penilaian="0"> -Skala- </option>
                                        <?php foreach ($countDetail as $option) : ?>
                                            <option  value="<?= $option['skala']; ?>"
                                            <?= ($resDetail['realisasi'] == $option['skala']) ? 'selected' : ''; ?>
                                                data-bobot="<?= $pk['bobot']; ?>"
                                                data-penilaian="<?= $option['penilaian']; ?>">
                                                <?= $option['skala']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td rowspan="<?= count($countDetail) ?>">
                                <input type="hidden" name="id[]" value="<?=$d['parent']?>">
                                <input type="hidden" name="urut[]" value="<?=$pk['urut']?>">

                                    <center>
                                        <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                    </center>
                                </td>
                                <td rowspan="<?= count($countDetail) ?>">

                                    <center>
                                        <input class="form-control subTotalDetail-<?= $d['parent']; ?>" style="width: 100px; text-align: center" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                    </center>
                                </td>
                                <td rowspan="<?= count($countDetail) ?>">
                                <textarea name="penjelasan[]" id="penjelasan<?= $n; ?>" placeholder="Masukkan penjelasan"><?=$resDetail['penjelasan']?></textarea>
                            </td>
                            <td rowspan="<?= count($countDetail) ?>">
                            <textarea name="evidence[]" id="evidence<?= $n; ?>" placeholder="Masukkan evidence"><?=$resDetail['evidence']?></textarea>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php if (count($countDetail) > 0) : ?>
                    <tr>
                        <td class="text-center text-right" style="text-align: right;" colspan="6"><strong>Total Point <?= $nc ?>: </strong></td>
                        <td class="text-center">
                            <input class="form-control perhitungan" style="width: 100px; text-align: center" type="text" id="totalDetail-<?= $pk['id']; ?>" name="totalDetail-<?= $pk['id']; ?>" readonly>
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
        <button class="btn btn-save" id="simpan">
            <i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan
        </button>
    </th>
</tr>
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

    </table>
    </div>

    