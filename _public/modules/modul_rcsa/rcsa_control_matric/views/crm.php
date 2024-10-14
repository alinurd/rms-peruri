<style>
    .upload-icon-wrapper {
        position: relative;
        display: inline-block;
    }
    .upload-icon-wrapper input[type="file"] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .upload-icon {
        font-size: 1.5em;
        color: #007bff;
        cursor: pointer;
    }
</style>
<?php
$cboPengujian = [
    '1' => 'Inquery',
    '2' => 'Observasi',
    '3' => 'Inspeksi',
    '4' => 'Rekonsiliasi',
    '5' => 'Tracing',
    '6' => 'Vouching',
    '7' => 'Prosedur Analysis'
];
$cboPenilaian = [
    '1' => 'Cukup & Efektif',
    '2' => 'Sebagian',
    '3' => 'Cukup & Tidak Efektif',
    '4' => 'Tidak Cukup & Efektif Sebagian',
    '5' => 'Tracing',
    '6' => 'Vouching',
    '7' => 'Tidak Cukup & Tidak Efektif'
];
?>

<table class="table table-bordered" id="tbl_sasaran_new">
    <thead class="sticky-thead">
        <tr>
            <th width="5%" style="text-align:center;">No.</th>
            <th width="10%" style="text-align:center;">Bussines Process</th>
            <th width="10%" style="text-align:center;">Existing Control</th>
            <th width="10%" style="text-align:center;">Metode Pengujian</th>
            <th width="10%" style="text-align:center;">Penilaian Internal Control</th>
            <th width="10%" style="text-align:center;">Kelemahan Control</th>
            <th width="10%" style="text-align:center;">Rencana Tindak Lanjut</th>
            <th width="10%" style="text-align:center;">Upload Dokumen</th>
            <th width="10%" style="text-align:center;">Aksi</th>
        </tr>
    </thead>
    <tbody id="rcm_body">
        <?php $i = 0; ?>
        <?php foreach ($field as $key => $row): $i++; ?>
            <tr id="rcm_<?= $i; ?>">
                <td style="text-align:center;"><?= $i; ?></td>
                <td>
                    <?= form_textarea('bisnisProses[]', $row['bisnisProses'], [
                        'maxlength' => '10000',
                        'class' => 'form-control',
                        'rows' => '2',
                        'style' => 'overflow: hidden; height: 104px;'
                    ]); ?>
                </td>
                <td colspan="6">
                    <table class="table table-border">
                        <tbody id="metode_<?= $i; ?>">
                            <tr>
                                <td width="19%">
                                    <?= form_textarea("exixtingControl[{$i}][]", $row['exixtingControl'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;'
                                    ]); ?>
                                </td>
                                <td width="19%" style="vertical-align: middle;">
                                    <?= form_dropdown("metodePengujian[{$i}][]", $cboPengujian, $row['metodePengujian'], [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%;'
                                    ]); ?>
                                </td>
                                <td width="19%" style="vertical-align: middle;">
                                    <?= form_dropdown("penilaianControl[{$i}][]", $cboPenilaian, $row['penilaianControl'], [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%;'
                                    ]); ?>
                                </td>
                                <td width="19%">
                                    <?= form_textarea("kelemahanControl[{$i}][]", $row['kelemahanControl'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;'
                                    ]); ?>
                                </td>
                                <td width="19%">
                                    <?= form_textarea("tindakLanjut[{$i}][]", $row['tindakLanjut'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;'
                                    ]); ?>
                                </td>
                                <td width="2.5%" style="vertical-align: middle;">
                                  <div class="upload-icon-wrapper">
                                      <label class="upload-icon">
                                          <i class="fa fa-upload"></i>
                                          <input type="file" name="fileupload[<?= $i; ?>][]" id="userfile_<?= $i; ?>" required />
                                      </label>
                                  </div>
                                </td>
                                <td width="2.5%" class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-danger btn-xs" type="button" onclick="removeMetode(this);">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center>
                        <button class="btn btn-info" type="button" onclick="addMetode(<?= $i; ?>);">
                            <i class="fa fa-plus"></i> Metode & Control
                        </button>
                    </center>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <button class="btn btn-danger" type="button" onclick="removeRCM(<?= $i; ?>);">
                        <i class="fa fa-trash"></i> RCM
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<center>
    <button id="addRCM" class="btn btn-primary" type="button">
        <i class="fa fa-plus"></i> Add RCM
    </button>
</center>

<script type="text/javascript">
    var rcmCount = <?= $i; ?>;

    // Add new Metode row
    function addMetode(rcmIndex) {
        var metodeTable = document.getElementById('metode_' + rcmIndex);
        var newRow = `
            <tr>
                <td><textarea name="exixtingControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                <td style="vertical-align: middle;">
                    <select name="metodePengujian[${rcmIndex}][]" class="form-control select2" style="width:100%;">
                        <?php foreach ($cboPengujian as $key => $value): ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td style="vertical-align: middle;">
                    <select name="penilaianControl[${rcmIndex}][]" class="form-control select2" style="width:100%;">
                        <?php foreach ($cboPenilaian as $key => $value): ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><textarea name="kelemahanControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                <td><textarea name="tindakLanjut[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                <td style="vertical-align: middle;">
                  <div class="upload-icon-wrapper">
                      <label class="upload-icon">
                          <i class="fa fa-upload"></i>
                          <input type="file" name="fileupload[${rcmIndex}][]" id="userfile_${rcmIndex}" required />
                      </label>
                  </div>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <button class="btn btn-danger btn-xs" type="button" onclick="removeMetode(this);">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>`;
        metodeTable.insertAdjacentHTML('beforeend', newRow);
    }

    // Remove specific Metode row
    function removeMetode(button) {
        button.closest('tr').remove();
    }

    // Add new RCM row
    $("#addRCM").click(function() {
        rcmCount++;
        var newRCM = `
            <tr id="rcm_${rcmCount}">
                <td style="text-align:center;">${rcmCount}</td>
                <td><textarea name="bisnisProses[]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                <td colspan="6">
                    <table class="table table-border">
                        <tbody id="metode_${rcmCount}">
                            <tr>
                                <td><textarea name="exixtingControl[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                                <td style="vertical-align: middle;">
                                    <select name="metodePengujian[${rcmCount}][]" class="form-control select2" style="width:100%;">
                                        <?php foreach ($cboPengujian as $key => $value): ?>
                                            <option value="<?= $key; ?>"><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="vertical-align: middle;">
                                    <select name="penilaianControl[${rcmCount}][]" class="form-control select2" style="width:100%;">
                                        <?php foreach ($cboPenilaian as $key => $value): ?>
                                            <option value="<?= $key; ?>"><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><textarea name="kelemahanControl[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                                <td><textarea name="tindakLanjut[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
                               <td style="vertical-align: middle;">
                                  <div class="upload-icon-wrapper">
                                      <label class="upload-icon">
                                          <i class="fa fa-upload"></i>
                                          <input type="file" name="fileupload[${rcmCount}][]" id="userfile_${rcmCount}" required />
                                      </label>
                                  </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-danger btn-xs" type="button" onclick="removeMetode(this);">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <center>
                        <button class="btn btn-info" type="button" onclick="addMetode(${rcmCount});"><i class="fa fa-plus"></i> Metode & Control</button>
                    </center>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <button class="btn btn-danger" type="button" onclick="removeRCM(${rcmCount});">
                        <i class="fa fa-trash"></i> RCM
                    </button>
                </td>
            </tr>`;
        $("#rcm_body").append(newRCM);
    });

    // Remove specific RCM row
    function removeRCM(rcmIndex) {
        $("#rcm_" + rcmIndex).remove();
    }
</script>
