    <div>
        <span class="btn btn-primary btn-sm" style="bottom: 30px; right: 15px; cursor:pointer; position: fixed; padding: 5px 15px; z-index: 1000;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan </span>
    </div>
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
                    <td class="text-center" width="5%" rowspan="<?= $parentRowspan + $ss ?>"><?= $nc++ ?></td>
                    <td colspan="9"><b><?= $c['data'] ?></b></td>
                </tr>

                <?php foreach ($c['parent'] as $pKey=> $pk) :
                    $countDetailx = $c['detail'][$pk['id']];
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

                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td class="text-center" width="10%">%</td>
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
                                </td>                            <td width="5%">hasil</td>
                            <?php endif; ?>

                        <?php endif; ?>
                    </tr>

                    <?php
                    $totalPenilaian = 0;
                    $n = 1;
                    foreach ($countDetailx as $dKey=> $d) :
                        $totalPenilaian += $d['penilaian'];
                        $totalPenilaianCombo += $d['penilaian'];
                    ?>
                        <tr>
                            <td width="40%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                            <td width="5%"><?= $d['skala']; ?></td>
                            <td width="5%"><?= $d['penilaian']; ?></td>
                            <?php if ($dKey === 0) : ?>
                                <td width="5%"><input type="text" style="width: 110px;"></td>
                                <td width="5%"><input type="text" style="width: 110px;"></td>
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
                                <td width="5%">hasil</td>
                            <?php endif; ?>

                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php if ($ss>1) : ?>

                     <tr>
                        <td class="text-center text-right" style="text-align: right;" colspan="8"><strong>Total Point: </strong></td>
                        <td class="text-center"><strong><?= $ss; ?></strong></td>
                    </tr>
                    <?php endif; ?>

            <?php endforeach; ?>
        </tbody>

        <tr style="position: sticky; bottom: 0; background: #367FA9; color:#fff; z-index: 1;">
            <th class="text-center" style="font-weight:bold; color:#fff;" colspan="9">Hasil Perhitungan Indikator: </th>
            <th class="text-center" style="background:yellow; color:#000;"><?= $totalPenilaianCombo; ?></th>
        </tr>
    </table>
    </div>