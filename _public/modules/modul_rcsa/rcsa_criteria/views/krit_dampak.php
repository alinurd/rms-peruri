<style>
    .dampak-header {
        min-width: 130px; /* Sesuaikan dengan kebutuhan */
        word-wrap: break-word;
    }

    .kategori-cell {
        min-width: 150px; /* Lebar kategori agar cukup besar */
        word-wrap: break-word;
    }

    .table th, .table td {
        vertical-align: middle; /* Posisi tengah konten */
        text-align: center;
    }

    /* .card {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    } */

    /* .btn-sm {
        padding: 5px 10px;
    } */

    .form-control {
        resize: none; /* Mencegah pengguna mengubah ukuran textarea */
    }
</style>

<section class="wrapper site-min-height">
    <div class="x_panel">
        <div class="row">
            <div class="col-md-12">
                <div class="x_content">
                    <section class="profile-info col-md-12">
                        <div class="card">
                            <div class="card-body" style="overflow-x:auto;">
                                <input type="hidden" name="krit_dampak" value="krit_dampak">
                                <table class="table table-bordered table-striped" style="width: 100%; table-layout: fixed;">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th class="text-center kategori-cell">Kategori</th>
                                            <th class="text-center dampak-header">Dampak</th>
                                            <?php foreach ($kriteria as $key => $k): ?>
                                                <td class="text-center dampak-header" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
                                                    <?= $k['name'] ?>
                                                    
                                                </td>
                                            <?php endforeach; ?>
                                            <th width="4.5%"></th>
                                            <th width="5%" class="text-center">Aksi</th>
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
                                                        <td rowspan="<?= count($subDampak) ?>" class="kategori-cell align-middle" style="word-wrap: break-word;" >
                                                            <?= form_textarea('kategori['.$i.']', $dam['data'], "maxlength='10000' class='form-control' rows='2'"); ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    <td colspan="7" style="padding: 0px !important;">
                                                        <table id="table-kedua-<?= $i; ?>-<?= $key ?>" class="table table-borderless" cellpadding="0" cellspacing="0" style="width: 100%; table-layout: fixed;">
                                                            <tbody id="metode_<?= $i; ?>_<?= $key ?>">
                                                                <tr>
                                                                    <td style="width: 15%;"> 
                                                                        <textarea name="dampak[<?=$i?>][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"><?= html_entity_decode($subd['data']) ?></textarea>
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
                                                                            <textarea name="area_dampak[<?=$i?>][<?=$kee;?>][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"><?= $damp ? html_entity_decode($damp['area']) : '' ?></textarea>
                                                                        </td>
                                                                    <?php endforeach; ?>
                                                                    <td width="5%" class="text-center" style="vertical-align: middle;">
                                                                        <button class="btn btn-outline-danger btn-xs" type="button" onclick="removeMetode(this);" ><i class="fa fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <?php if ($key === count($subDampak) - 1): ?>
                                                            <center>
                                                                <button class="btn btn-info btn-sm" type="button" onclick="addMetode(<?= $i; ?>, <?= $key ?>);"><i class="fa fa-plus"></i> Tambah Dampak</button>
                                                            </center>
                                                        <?php endif; ?>
                                                    </td>
                                                    <?php if ($key === 0): ?>
                                                        <td class="text-center" rowspan="<?= count($subDampak) ?>" style="vertical-align: middle;">
                                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRCM(<?= $i; ?>);"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <center>
                                    <button type="button" class="btn btn-primary btn-sm" id="addkategori"><i class="fa fa-plus"></i> Tambah Kategori</button>
                                </center>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var rcmCount = <?= $i; ?>;

    function addMetode(rcmIndex, key) {
        const metodeTable = $('#metode_' + rcmIndex + '_' + key);
        const newRow = `
            <tr>
                <td style="width: 15%;">
                    <textarea name="dampak[${rcmIndex}][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"></textarea>
                </td>
                <?php foreach ($kriteria as $kee => $k): ?>
                    <td style="width: 15%; word-wrap: break-word;">
                    <input type="hidden" name="kriteria_dampak[<?= $kee ?>][name]" value="<?= $kee ?>">
                        <textarea name="area_dampak[${rcmIndex}][<?=$kee;?>][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"></textarea>
                    </td>
                <?php endforeach; ?>
                <td class="text-center" width="5%" style="vertical-align: middle;">
                    <button  class="btn btn-outline-danger btn-xs" type="button" onclick="removeMetode(this);" title="Hapus Metode"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        metodeTable.append(newRow);
       
    }

    function removeMetode(button) {
        const row = $(button).closest('tr');
        row.remove();
    }

    $("#addkategori").click(function() {
        rcmCount++;
        const newRCM = `
            <tr class="dampak-row-${rcmCount}" id="dampak_${rcmCount}">
                <td rowspan="1" class="kategori-cell align-middle">
                    <textarea name="kategori[${rcmCount}]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 200px;"></textarea>
                </td>
                <td colspan="7"  style="padding: 0px !important;">
                    <table id="table-kedua-${rcmCount}-0" class="table table-borderless" style="width: 100%; table-layout: fixed;">
                        <tbody id="metode_${rcmCount}_0">
                            <tr>
                                <td style="width: 15%;">
                                    <textarea name="dampak[${rcmCount}][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"></textarea>
                                </td>
                                <?php foreach ($kriteria as $kee => $k): ?>
                                    <td style="width: 15%; word-wrap: break-word;">
                                        <input type="hidden" name="kriteria_dampak[<?= $kee ?>][name]" value="<?= $kee ?>">
                                        <textarea name="area_dampak[${rcmCount}][<?=$kee;?>][]" class="form-control" rows="2" style="overflow: hidden; height: 120px;"></textarea>
                                    </td>
                                <?php endforeach; ?>
                                <td class="text-center" width="5%" style="vertical-align: middle;">
                                    <button class="btn btn-outline-danger btn-xs" type="button" onclick="removeMetode(this);" title="Hapus Metode"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center>
                        <button class="btn btn-info btn-sm" type="button" onclick="addMetode(${rcmCount}, 0);"><i class="fa fa-plus"></i> Tambah Dampak</button>
                    </center>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" type="button" onclick="removeRCM(${rcmCount});" title="Hapus Kategori"><i class="fa fa-trash"></i></button>
                </td>
            </tr>`;
        $("#dampak_body").append(newRCM);
    });

    function removeRCM(rcmIndex) {
        $(`.dampak-row-${rcmIndex}`).remove();
    }
</script>
