    <div>
        <span class="btn btn-primary btn-sm" style="bottom: 30px; right: 15px; cursor:pointer; position: fixed; padding: 5px 15px; z-index: 1000;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan </span>
    </div>
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
                    <td class="text-center" width="5%" rowspan="<?= $parentRowspan + $ss ?>"><?= $nc++ ?></td>
                    <td colspan="9"><b><?= $c['data'] ?></b></td>
                </tr>

                <?php foreach ($c['parent'] as $pKey => $pk) : ?>
                    <tr>
                        <td rowspan="<?= count($countDetail) + 1 ?>"><?= $pk['urut']; ?></td>
                        <td width="40%"
                            <?php if (count($countDetail) > 0) : ?>
                            colspan="8"
                            <?php endif; ?>>
                           id:<?= $pk['id']; ?>- BOBOT: <?= $pk['bobot']; ?>
                        </td>

                        <?php if (count($countDetail) === 0) : ?>
                            <td width="5%"><?= $pk['skala']; ?></td>
                            <td width="5%"><?= $pk['penilaian']; ?></td>
                            <?php if ($pKey === 0) : ?>
                                <td width="5%" rowspan="<?= count($c['parent']) ?>">
                                    <select class="form-control skala-dropdown" id="skala-<?= $pk['urut']; ?><?= $pk['id']; ?>"  style="width: 110px;"
                                        data-bobot="<?= $pk['bobot']; ?>"
                                         data-input-id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" 
                                        data-input-rumus-id="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>"
                                        >
                                        <?php foreach ($c['parent'] as $option) : ?>
                                            <option value="<?= $option['skala']; ?>"
                                                data-bobot="<?= $pk['bobot']; ?>"
                                                data-penilaian="<?= $option['penilaian']; ?>">
                                                <?= $option['skala']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td  rowspan="<?= count($c['parent']) ?>">
                                   <center>
                                   <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                   </center>
                                </td>
                                <td  rowspan="<?= count($c['parent']) ?>">
                                    <center>
                                        <input class="form-control" style="width: 100px; text-align: center;" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                    </center>
                                </td>
                            <?php endif; ?>

                             <td width="5%"><textarea name="penjelasan" id="penjelasan"></textarea></td>
                            <td width="5%"><textarea name="evidence" id="evidence"></textarea></td>
                        <?php endif; ?>
                    </tr>

                    <?php
                    $totalPenilaian = 0;
                    $totalPenilaianCombo = 0;
                    $n = 1;
                     foreach ($countDetail as $dKey => $d) :
                         $totalPenilaian += $d['penilaian'];
                        $totalPenilaianCombo += $d['penilaian'];
                    ?>
                        <tr>
                            <td width="40%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                            <td width="5%"><?= $d['skala']; ?></td>
                            <td width="5%"><?= $d['penilaian']; ?></td>
                            
                            <?php if ($dKey === 0) : ?>
                                <td width="5%" rowspan="<?= count($countDetail) ?>">
                                    <select class="form-control skala-dropdown" id="skala-<?= $pk['urut']; ?><?= $d['id']; ?>"style="width: 110px;"
                                        data-bobot="<?= $pk['bobot']; ?>"
                                        data-id-parent="<?= $d['parent']; ?>"
                                        data-input-id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>"
                                         data-input-rumus-id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>">>
                                        <?php foreach ($countDetail as $option) : ?>
                                            <option value="<?= $option['skala']; ?>"
                                                data-bobot="<?= $pk['bobot']; ?>"
                                                data-penilaian="<?= $option['penilaian']; ?>">
                                                <?= $option['skala']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td  rowspan="<?= count($countDetail) ?>">
                                <center>
                                   <input class="form-control" style="width: 100px; text-align: center" type="text" id="rumus-<?= $pk['urut']; ?><?= $d['id']; ?>" name="rumus-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                   </center>
                                </td>
                                <td  rowspan="<?= count($countDetail) ?>">

                                <center>
                                   <input class="form-control" style="width: 100px; text-align: center" type="text" id="perhitungan-<?= $pk['urut']; ?><?= $d['id']; ?>" name="perhitungan-<?= $pk['urut']; ?><?= $pk['id']; ?>" readonly>
                                   </center>
                                </td>
                            <?php endif; ?>
                    
                             <td width="5%">
                                <textarea name="penjelasan[]" id="penjelasan<?= $n; ?>" placeholder="Masukkan penjelasan"></textarea>
                            </td>
                            <td width="5%">
                                <textarea name="evidence[]" id="evidence<?= $n; ?>" placeholder="Masukkan evidence"></textarea>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php if (count($countDetail) > 0) : ?>
                    <tr>
                        <td class="text-center text-right" style="text-align: right;" colspan="6"><strong>Total Point: </strong></td>
                        <td class="text-center">
                            <input class="form-control" style="width: 100px; text-align: center" type="text" id="totalDetail-<?= $pk['id']; ?>" name="totalDetail-<?= $pk['id']; ?>" readonly>
                        </td>
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