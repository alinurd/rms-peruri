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
        /* color: #007bff; */
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
        <?php foreach ($bisnis_proses as $key => $row): $i++; 
        
        $exiting_control = $this->db->where('rcm_id', $row['id'])
                                ->get(_TBL_EXISTING_CONTROL)
                                ->result_array();
        ?>
        
            <tr id="rcm_<?= $i; ?>">
                <td style="text-align:center;"><?= $i; ?></td>
                <td>
                    <input type="hidden" name="bisnisProseslama[<?=$i;?>]" value="<?= $row['id']?>">
                    <?= form_textarea("bisnisProses[{$i}]", $row['bussines_process'], [
                        'maxlength' => '10000',
                        'class' => 'form-control',
                        'rows' => '2',
                        'style' => 'overflow: hidden; height: 104px;','required' => 'required'
                    ]); ?>
                </td>
                <td colspan="6">
                    <table class="table table-border">
                        <tbody id="metode_<?= $i; ?>">
                        <?php foreach ($exiting_control as $key => $ex): ?>
                            <tr>
                                <td width="19%">
                                <input type="hidden" name="exixtingControllama[<?=$i;?>][]" value="<?= $ex['id']?>">
                                    <?= form_textarea("exixtingControl[{$i}][]", $ex['component'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;','required' => 'required'
                                    ]); ?>
                                </td>
                                <td width="19%" style="vertical-align: middle;">
                                    <?= form_dropdown("metodePengujian[{$i}][]", $cboPengujian, $ex['metode_pengujian'], [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%;','required' => 'required'
                                    ]); ?>
                                </td>
                                <td width="19%" style="vertical-align: middle;">
                                    <?= form_dropdown("penilaianControl[{$i}][]", $cboPenilaian, $ex['penilaian_intern_control'], [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%;','required' => 'required'
                                    ]); ?>
                                </td>
                                <td width="19%">
                                    <?= form_textarea("kelemahanControl[{$i}][]", $ex['kelemahan_control'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;','required' => 'required'
                                    ]); ?>
                                </td>
                                <td width="19%">
                                    <?= form_textarea("tindakLanjut[{$i}][]", $ex['rencana_tindak_lanjut'], [
                                        'maxlength' => '10000',
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'style' => 'overflow: hidden; height: 104px;','required' => 'required'
                                    ]); ?>
                                </td>
                                <td width="2.5%" style="vertical-align: middle;">
                                <div class="upload-icon-wrapper">
                                    <label class="upload-icon <?= !empty($ex['dokumen']) ? 'text-success' : ''; ?>">
                                        <i class="fa fa-upload"></i>
                                        <input type="hidden" name="fileuploadlama[<?= $i; ?>][]" id="userfilelama_<?= $i; ?>" value="<?=$ex['dokumen']?>" multiple />
                                        <input type="file" name="fileupload[<?= $i; ?>][]"  id="userfile_<?= $i; ?>" multiple <?= !empty($ex['dokumen']) ? "" : "required"; ?> />
                                    </label>
                                </div>
                                
                                </td>
                                <!-- <td class="text-center" style="vertical-align: middle;">
                                    <a href="<?= base_url('theme/upload/crm/').$ex['dokumen']; ?>" target="_blank">
                                        <span class="badge badge-success bg-success">PDF</span>
                                    </a>
                                </td> -->

                                <td width="2.5%" class="text-center" style="vertical-align: middle;">
                                    <button class="btn btn-danger btn-xs" type="button" onclick="removeMetode(this);">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
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
                <td>
                    <input type="hidden" name="exixtingControllama[${rcmIndex}][]" >
                    <textarea name="exixtingControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea>
                </td>
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
                <td><textarea name="kelemahanControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea></td>
                <td><textarea name="tindakLanjut[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea></td>
                <td style="vertical-align: middle;">
                  <div class="upload-icon-wrapper">
                      <label class="upload-icon">
                          <i class="fa fa-upload"></i>
                          <input type="hidden" name="fileuploadlama[${rcmIndex}][]" id="userfile_${rcmIndex}" multiple />
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
                
                <td><input type="hidden" name="bisnisProseslama[${rcmCount}]"><textarea name="bisnisProses[${rcmCount}]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea></td>
                <td colspan="6">
                    <table class="table table-border">
                        <tbody id="metode_${rcmCount}">
                            <tr>
                            <td>
                                <input type="hidden" name="exixtingControllama[${rcmCount}][]" >
                                <textarea name="exixtingControl[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea>
                            </td>
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
                                <td><textarea name="kelemahanControl[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea></td>
                                <td><textarea name="tindakLanjut[${rcmCount}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea></td>
                               <td style="vertical-align: middle;">
                                  <div class="upload-icon-wrapper">
                                      <label class="upload-icon">
                                          <i class="fa fa-upload"></i>
                                          <input type="hidden" name="fileuploadlama[${rcmCount}][]" id="userfile_${rcmCount}" multiple />
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
