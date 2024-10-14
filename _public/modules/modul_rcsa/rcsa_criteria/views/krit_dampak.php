<section class="wrapper site-min-height">
    <div class="x_panel">
        <div class="row">
            <div class="col-md-12">
                <div class="x_content">
                    <section class="profile-info col-md-12">
                        <div class="x_content" style="overflow-x:auto;">
                            <input type="hidden" name="krit_dampak" value="krit_dampak">
                            <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="13%">Kategori</th>
                                        <th class="text-center" width="13%">Dampak</th>
                                        <?php foreach ($kriteria as $k): ?>
                                            <td width="13.5%" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
                                                <?= $k['name'] ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dampak_body">
                                    <?php $i = 0; ?>
                                    <?php foreach ($dampak as $dam): 
                                        $i++;
                                        $subDampak = $this->db->where('kelompok', 'sub-kriteria-dampak')
                                            ->where('pid', $dam['id'])
                                            ->get(_TBL_DATA_COMBO)
                                            ->result_array();
                                    ?>
                                        <?php foreach ($subDampak as $key => $subd): ?>
                                            <tr class="dampak-row-<?= $i; ?>" id="dampak_<?= $i; ?>">
                                                <?php if ($key === 0): ?>
                                                    <td rowspan="<?= count($subDampak) ?>" class="kategori-cell" style="word-wrap: break-word;">
                                                        <?= form_textarea('kategori['.$i.']', $dam['data'], "maxlength='10000' class='form-control' rows='2'"); ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td colspan="6">
                                                    <table id="table-kedua-<?= $i; ?>-<?= $key ?>" class="table table-border" style="width: 100%; table-layout: fixed;">
                                                        <tbody id="metode_<?= $i; ?>_<?= $key ?>">
                                                            <tr>
                                                                <td style="width: 15%;">
                                                                    <textarea name="dampak[<?=$i?>][]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"><?= $subd['data'] ?></textarea>
                                                                </td>
                                                                <?php foreach ($kriteria as $kee => $k): ?>
                                                                    <td style="width: 15%; word-wrap: break-word;">
                                                                        <?php
                                                                        $damp = $this->db->where('sub_dampak_id', $subd['id'])
                                                                            ->where('criteria_risiko', $kee)
                                                                            ->order_by('criteria_risiko')
                                                                            ->get(_TBL_AREA)
                                                                            ->row_array();
                                                                        ?>
                                                                        <input type="hidden" name="kriteria_dampak[<?= $kee ?>][name]" value="<?= $kee ?>">
                                                                        <textarea name="area_dampak[<?=$i?>][<?=$key?>][<?=$kee;?>]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"><?= $damp ? $damp['area'] : '' ?></textarea>
                                                                    </td>
                                                                <?php endforeach; ?>
                                                                <td class="text-center">
                                                                    <button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <?php if ($key === count($subDampak) - 1): ?>
                                                        <center>
                                                            <button class="btn btn-info" type="button" onclick="addMetode(<?= $i; ?>, <?= $key ?>);"><i class="fa fa-plus"></i> Add Dampak</button>
                                                        </center>
                                                    <?php endif; ?>
                                                </td>
                                                <?php if ($key === 0): ?>
                                                    <td class="text-center" rowspan="<?= count($subDampak) ?>">
                                                        <button type="button" class="btn btn-danger" onclick="removeRCM(<?= $i; ?>);"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <center>
                                <button type="button" class="btn btn-primary" id="addkategori"><i class="fa fa-plus"></i> Kategori</button>
                            </center>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var rcmCount = <?= $i; ?>;

    // Add metode row specific to a subDampak based on rcmIndex and key
    function addMetode(rcmIndex, key) {
        const metodeTable = $('#metode_' + rcmIndex + '_' + key);
        const newRow = `
            <tr>
                <td style="width: 15%;">
                    <textarea name="dampak[${rcmIndex}][]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"></textarea>
                </td>
                <?php foreach ($kriteria as $kee => $k): ?>
                    <td style="width: 15%; word-wrap: break-word;">
                    <input type="hidden" name="kriteria_dampak[<?= $kee ?>][name]" value="<?= $kee ?>">
                        <textarea name="area_dampak[${rcmIndex}][${key}][<?=$kee;?>]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"></textarea>
                    </td>
                <?php endforeach; ?>
                <td class="text-center">
                    <button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        metodeTable.append(newRow);
    }

   // Remove metode row
    function removeMetode(button) {
        const row = $(button).closest('tr');
        row.remove(); // Remove the row directly
    }

    // Add new kategori row
    $("#addkategori").click(function() {
        rcmCount++;
        const newRCM = `
            <tr class="dampak-row-${rcmCount}" id="dampak_${rcmCount}">
                <td rowspan="1" class="kategori-cell" style="word-wrap: break-word;">
                    <textarea name="kategori[${rcmCount}]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea>
                </td>
                <td colspan="6">
                    <table id="table-kedua-${rcmCount}-0" class="table table-borderless" style="width: 100%; table-layout: fixed;">
                        <tbody id="metode_${rcmCount}_0">
                            <tr>
                                <td style="width: 15%;">
                                    <textarea name="dampak[${rcmCount}][]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"></textarea>
                                </td>
                                <?php foreach ($kriteria as $kee => $k): ?>
                                    <td style="width: 15%; word-wrap: break-word;">
                                    <input type="hidden" name="kriteria_dampak[<?= $kee ?>][name]" value="<?= $kee ?>">
                                        <textarea name="area_dampak[${rcmCount}][0][<?=$kee;?>]" class="form-control" rows="2" style="overflow: hidden; height: 52px;"></textarea>
                                    </td>
                                <?php endforeach; ?>
                                <td class="text-center">
                                    <button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center>
                        <button class="btn btn-info" type="button" onclick="addMetode(${rcmCount}, 0);"><i class="fa fa-plus"></i> Metode</button>
                    </center>
                </td>
                <td class="text-center"><button class="btn btn-danger" type="button" onclick="removeRCM(${rcmCount});"><i class="fa fa-trash"></i></button></td>
            </tr>`;
        $("#dampak_body").append(newRCM);
    });

    // Remove entire kategori row and associated rows in the category
    function removeRCM(rcmIndex) {
        $(`.dampak-row-${rcmIndex}`).remove();
    }
</script>
