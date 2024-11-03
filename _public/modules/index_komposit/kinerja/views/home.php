<div class="table-responsive">
    <table class="display table table-bordered" id="tbl_event">
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th class="text-center" width="15%" colspan="2">Parameter</th>
                <th class="text-center" width="5%">Skala</th>
                <th class="text-center" width="5%">Hasil Penilaian</th>
                <th class="text-center" width="5%">Target RKAP 2023 </th>
                <th class="text-center" width="5%">Realisasi Tw 1 2024</th>
                <th class="text-center" width="10%">%</th>
                <th class="text-center" width="5%">Skala</th>
                <th class="text-center" width="10%">Hasil</th>
            </tr>
        </thead>
        <tbody>
            <?php $nc = 1; ?>
            <?php foreach ($kompositData as $c) : ?>
                <?php
                 $parentRowspan = 0;
                foreach ($c['parent'] as $pk) {
                    $parentRowspan += count($pk['detail']) + 1; 
                }
                ?>
                <tr style="background-color:#d5edef;">
                    <td class="text-center" width="5%" rowspan="<?= $parentRowspan + 1 ?>"><?= $nc++ ?></td>
                    <td colspan="9"><b><?= $c['data'] ?></b></td>
                </tr>
                
                <?php foreach ($c['parent'] as $pk) : ?>
                    <tr>
                        <td rowspan="<?= count($pk['detail']) + 1 ?>"><?= $pk['urut']; ?></td>
                        <td width="40%"
                            <?php if (count($pk['detail']) > 0) : ?>
                                colspan="8"
                            <?php endif; ?>>
                            <?= $pk['parameter']; ?>
                        </td>

                        <?php if (count($pk['detail']) === 0) : ?>
                            <td width="5%"><?= $pk['skala']; ?></td>
                            <td width="5%"><?= $pk['penilaian']; ?></td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td class="text-center" width="10%">%</td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td width="5%">hasil</td>
                        <?php endif; ?>
                    </tr>
                    
                    <?php $n = 1; foreach ($pk['detail'] as $d) : ?>
                        <tr>
                            <td width="40%"><?= $n++; ?>.&nbsp; <?= $d['parameter']; ?></td>
                            <td width="5%"><?= $d['skala']; ?></td>
                            <td width="5%"><?= $d['penilaian']; ?></td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td class="text-center" width="10%">%</td>
                            <td width="5%"><input type="text" style="width: 110px;"></td>
                            <td width="5%">hasil</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
