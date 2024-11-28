<!-- START CSS -->
<style>
    .table {
        table-layout: fixed;
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .form-control {
        resize: none;
        overflow: hidden;
    }

    .file_upload > input {
        display: none;
    }

    input[type=text] {
        width: 50px;
        height: auto;
    }

    .bs-container.dropdown.bootstrap-select.open {
        margin-top: -50px;
    }

    .bootstrap-select {
        height: 40px !important;
    }

    .bootstrap-select .popover {
        display: none !important;
    }
</style>
<!-- END STYLE CSS -->
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
        '2' => 'Cukup & Efektif Sebagian',
        '3' => 'Cukup & Tidak Efektif',
        '4' => 'Tidak Cukup & Efektif Sebagian',
        '5' => 'Tidak Cukup & Tidak Efektif'
    ];
    
    $comboColor = [
        '1' => '#00712D',    // Cukup & Efektif
        '2' => '#06D001',    // Sebagian
        '3' => '#FEEC37',    // Cukup & Tidak Efektif
        '4' => '#ffa000',    // Tidak Cukup & Efektif Sebagian
        '5' => '#B8001F'     // Tidak Cukup & Tidak Efektif
    ];
?>

<table class="table table-bordered" id="tbl_sasaran_new">
    <thead class="sticky-thead">
        <tr>
            <th rowspan="2" width="3%">No.</th>
            <th rowspan="2" width="20%">Business Process</th>
            <th colspan="6" width="75%">Metode & Control</th>
            <th rowspan="2" width="5%">Aksi</th>
        </tr>
        <tr>
            <th width="19%">Existing Control</th>
            <th width="19%">Metode Pengujian</th>
            <th width="19%">Penilaian Internal Control</th>
            <th width="19%">Kelemahan Control</th>
            <th width="19%">Rencana Tindak Lanjut</th>
            <th width="2%">Dokumen</th>
        </tr>
    </thead>
    
    <tbody id="rcm_body">
        
        <?php            
            // Populate dropdown options for Business Process
            $options = [];
            foreach ($test as $row) {
                $options[$row['proses_bisnis']] = $row['proses_bisnis'];
            }
            $i = 0;

            foreach ($bisnis_proses as $key => $row): $i++; 
                $exiting_control = $this->db->where('rcm_id', $row['id'])->get(_TBL_EXISTING_CONTROL)->result_array();
        ?>
        
        <tr id="rcm_<?= $i; ?>">

            <td style="text-align:center;"><?= $i; ?></td>

            <td>
                <input type="hidden" name="bisnisProseslama[<?=$i;?>]" value="<?= $row['id']?>">
                <?= form_dropdown("bisnisProses[{$i}]", $options, $row['bussines_process'], [
                    'class'     => 'form-control',
                    'required'  => 'required'
                ]); ?>
            </td>
            
            <td colspan="6" style="padding: 0px;">

                <table class="table table-borderless">    
                    <tbody id="metode_<?= $i; ?>">
                    <?php foreach ($exiting_control as $ex): ?>
                        <tr>
                            <td>
                                <input type="hidden" name="exixtingControllama[<?=$i;?>][]" value="<?= $ex['id']?>">
                                <?= form_textarea("exixtingControl[{$i}][]", $ex['component'], [
                                    'maxlength' => '10000',
                                    'class'     => 'form-control',
                                    'rows'      => '2',
                                    'style'     => 'overflow: hidden; height: 104px;', 'required' => 'required'
                                ]); ?>
                            </td>

                            <td style="vertical-align: middle;">
                                <?= form_dropdown("metodePengujian[{$i}][]", $cboPengujian, $ex['metode_pengujian'], [
                                    'class'     => 'form-control selectpicker',
                                    'data-style' => 'btn btn-light',
                                    'data-size' => '7',
                                    'data-container' => 'body',
                                    'style'     => 'width:100%;',
                                    'required'  => 'required'
                                ]); ?>
                            </td>

                            <td style="vertical-align: middle;">
                                <select name="penilaianControl[<?= $i; ?>][]" class="selectpicker form-control" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                                    <?php foreach ($cboPenilaian as $key => $value): ?>
                                        <option value="<?= $key; ?>"
                                                data-content="<span class='badge' style='background-color: <?= htmlspecialchars($comboColor[$key], ENT_QUOTES); ?>; color: <?= ($comboColor[$key] == '#00712D' || $comboColor[$key] == '#B8001F') ? '#FFFFFF' : '#000000'; ?>;'><?= htmlspecialchars($value, ENT_QUOTES); ?></span>"
                                                <?= ($ex['penilaian_intern_control'] == $key) ? 'selected' : ''; ?>>
                                            <?= $value; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <td>
                                <?= form_textarea("kelemahanControl[{$i}][]", $ex['kelemahan_control'], [
                                    'maxlength' => '10000',
                                    'class'     => 'form-control',
                                    'rows'      => '2',
                                    'style'     => 'overflow: hidden; height: 104px;', 'required' => 'required'
                                ]); ?>
                            </td>

                            <td>
                                <?= form_textarea("tindakLanjut[{$i}][]", $ex['rencana_tindak_lanjut'], [
                                    'maxlength' => '10000',
                                    'class'     => 'form-control',
                                    'rows'      => '2',
                                    'style'     => 'overflow: hidden; height: 104px;', 'required' => 'required'
                                ]); ?>
                            </td>

                            <td style="vertical-align: middle; text-align: center;">
                                <input type="hidden" name="fileuploadlama[<?= $i; ?>][]" id="userfilelama_<?= $i; ?>" value="<?= $ex['dokumen'] ?>" multiple />
                                
                                <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                    <?php $filePath = './themes/upload/crm/' . htmlspecialchars($ex['dokumen']);?>
                                    <?php if (empty($ex['dokumen']) || !file_exists($filePath)) : ?>
                                        <label class="file_upload" style="margin: 0;">
                                            <input type="file" name="fileupload[<?= $i; ?>][]" id="userfile_<?= $i; ?>" style="display: none;" accept=".pdf"/>
                                            <a class="btn btn-warning btn-xs" rel="nofollow">
                                                <i class="fa fa-upload"></i>
                                            </a>
                                        </label>
                                    <?php else : ?>
                                        <a href="<?= base_url('rcsa_control_matric/download/'.$ex['dokumen']) ?>" class="btn btn-success btn-xs" rel="nofollow">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
            <td class="text-center" style="vertical-align: middle;">
                <button class="btn btn-danger btn-sm" type="button" onclick="removeRCM(<?= $i; ?>);">
                    <i class="fa fa-trash"></i>
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
    $("#addRCM").click(function () {
        var options = <?php echo json_encode($test); ?>;

        // Generating dropdown options dynamically
        var optionsHTML = '';
        options.forEach(function (row) {
            let noteControlArray = [];
            try {
                noteControlArray = JSON.parse(row.note_control); 
            } catch (error) {
                noteControlArray = row.note_control ? row.note_control.split(',').map(item => item.trim()) : [];
            }

            const noteCount = noteControlArray.length;

            optionsHTML += `
                <option value="${row.proses_bisnis}" 
                        data-note="${noteControlArray.join(',')}" 
                        data-note-count="${noteCount}">
                    ${row.proses_bisnis}
                </option>`;
        });

        rcmCount++;
        var newRCM = `
            <tr id="rcm_${rcmCount}">
                <td style="text-align:center;">${rcmCount}</td>
                <td>
                    <input type="hidden" name="bisnisProseslama[${rcmCount}]">
                    <select name="bisnisProses[${rcmCount}]" class="form-control" required="required" onchange="updateNoteControl(${rcmCount});">
                        ${optionsHTML}
                    </select>
                </td>
                <td colspan="6">
                    <table class="table table-border" id="metode_${rcmCount}"></table>
                </td>
                <td class="text-center" style="vertical-align: middle;">
                    <button class="btn btn-danger btn-sm" type="button" onclick="removeRCM(${rcmCount});">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>`;

        $("#rcm_body").append(newRCM); // Append new RCM row to the table
        $('.selectpicker').selectpicker(); // Reinitialize selectpicker
    });

    // Update control notes dynamically based on selected option
    function updateNoteControl(rcmIndex) {
        var selectedOption = $(`select[name="bisnisProses[${rcmIndex}]"] option:selected`);
        var noteControlValue = selectedOption.data('note');
        var noteCount = selectedOption.data('note-count');

        if (!noteControlValue || noteCount <= 0) {
            $(`#metode_${rcmIndex}`).empty();
            return;
        }

        var noteControlArray = noteControlValue.split(',').map(function (item) {
            return item.trim();
        });

        $(`#metode_${rcmIndex}`).empty();

        noteControlArray.forEach(function (item, index) {
            var newRow = `
                <tr>
                    <td style="padding-bottom:10px;padding-right:10px;">
                        <input type="hidden" name="exixtingControllama[${rcmIndex}][]">
                        <textarea name="exixtingControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="5" style="overflow: hidden; height: 104px;" required="required">${item}</textarea>
                    </td>
                    <td style="vertical-align: middle; padding-bottom:10px;padding-right:10px;">
                        <select name="metodePengujian[${rcmIndex}][]" class="form-control selectpicker" style="width:100%;" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                            <?php foreach ($cboPengujian as $key => $value): ?>
                                <option value="<?= $key; ?>"><?= $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td style="vertical-align: middle; padding-bottom:10px;padding-right:10px;">
                        <select name="penilaianControl[${rcmIndex}][]" class="selectpicker form-control" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                            <?php foreach ($cboPenilaian as $key => $value): ?>
                                <option value="<?= $key; ?>" data-content="<span class='badge' style='background-color: <?= htmlspecialchars($comboColor[$key], ENT_QUOTES); ?>; color: <?= ($comboColor[$key] == '#00712D' || $comboColor[$key] == '#B8001F') ? '#FFFFFF' : '#000000'; ?>;'><?= $value; ?></span>">
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td style="padding-bottom:10px;padding-right:10px;">
                        <textarea name="kelemahanControl[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea>
                    </td>
                    <td style="padding-bottom:10px;padding-right:10px;">
                        <textarea name="tindakLanjut[${rcmIndex}][]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;" required="required"></textarea>
                    </td>
                    <td style="vertical-align: middle;padding-bottom:10px;padding-right:10px;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                            <label class="file_upload" style="margin: 0;">
                                <input type="file" name="fileupload[${rcmIndex}][]" id="userfile_${rcmIndex}" style="display: none;" accept=".pdf" />
                                <a class="btn btn-warning btn-xs" rel="nofollow">
                                    <i class="fa fa-upload"></i>
                                </a>
                            </label>
                        </div>
                    </td>
                </tr>
            `;
            $(`#metode_${rcmIndex}`).append(newRow);
        });

        $('.selectpicker').selectpicker();
    }

    // Function to remove RCM row
    function removeRCM(rcmIndex) {
        $(`#rcm_${rcmIndex}`).remove();
    }

    // Initialize selectpicker
    $(document).ready(function () {
        $('.selectpicker').selectpicker();
    });
</script>
