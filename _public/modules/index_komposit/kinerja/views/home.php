 
    <h3>Parameter Penentuan Hasil Penilaian Pencapaian Kinerja</h3>
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
        <tbody>
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

                                <td><input type="number" style="width: 150px;"></td>
                                <td><input type="number" style="width: 150px;"></td>
                                <td class="text-center" width="10%">target/realisasi</td>
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
                    ?>
                        <tr>
                            <td width="30%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                            <td width="5%"><?= $d['skala']; ?></td>
                            <td width="5%"><?= $d['penilaian']; ?></td>
                            <?php if ($dKey === 0) : ?>
                                <td><input type="text" style="width: 150px;"></td>
                                <td><input type="text" style="width: 150px;"></td>
                                <td class="text-center" width="10%">%</td>
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
                        <input class="form-control perhitungan" style="width: 100px; text-align: center" type="text" id="totalDetail-<?= $nc; ?>" name="totalDetail-<?= $nc; ?>" readonly></td>
                    </tr>
                <?php endif; ?>

            <?php 
                        $nc++;
                    endforeach; ?>
        </tbody>

        <tr style="position: sticky; bottom: 0;  background: #367FA9; color:#fff; z-index: 1;">
            <th class="text-center" style="text-align:end" colspan="7">
                <button class="btn btn-save" id="simpan">
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
