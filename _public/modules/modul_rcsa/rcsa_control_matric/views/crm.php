<?php
$cboPengujian = ['1' => 'Inquery', '2' => 'Observasi', '3' => 'Inspeksi', '4' => 'Rekonsiliasi', '5' => 'Tracing', '6' => 'Vouching', '7' => 'Prosedur Analysis'];
$cboPenilaian = ['1' => 'Cukup & Efektif', '2' => 'Sebagian', '3' => 'Cukup & Tidak Efektif', '4' => 'Tidak Cukup & Efektif Sebagian', '5' => 'Tracing', '6' => 'Vouching', '7' => 'Tidak Cukup & Tidak Efektif'];
?>
<table class="table table-bordered" id="tbl_sasaran_new" border="1">
  <thead class="sticky-thead">
    <tr>
      <th width="5%" style="text-align:center;">No.</th>
      <th style="text-align:center;">Bussines Process</th>
      <th style="text-align:center;">Exixting Control</th>
      <th style="text-align:center;">Metode Pengujian</th>
      <th style="text-align:center;">Penilaian Internal Control</th>
      <th style="text-align:center;">Kelemahan Control</th>
      <th style="text-align:center;">Rencana Tindak Lanjut</th>
      <th width="10%" style="text-align:center;">Aksi</th>
    </tr>
  </thead>
  <tbody id="rcm_body">
    <?php
    $i = 0;
    foreach ($field as $key => $row) {
      $i++;
    ?>
      <tr id="rcm_<?= $i; ?>">
        <td style="text-align:center;"><?= $i; ?></td>
        <td><?= form_textarea('bisnisProses[]', $row['bisnisProses'], "maxlength='10000' class='form-control' rows='2' style='overflow: hidden; height: 104px;'"); ?></td>
        <td><?= form_textarea('exixtingControl[]', $row['exixtingControl'], "maxlength='10000' class='form-control' rows='2' style='overflow: hidden; height: 104px;'"); ?></td>
        <td colspan="2">
          <table class="table table-border">
            <tbody id="metode_<?= $i; ?>">
              <tr>
                <td>
                  <?= form_dropdown('metodePengujian[' . $i . '][]', $cboPengujian, $row['metodePengujian'], 'class="form-control select2" style="width:100%;"'); ?>
                </td>
                <td>
                  <?= form_dropdown('penilaianControl[' . $i . '][]', $cboPenilaian, $row['penilaianControl'], 'class="form-control select2" style="width:100%;"'); ?>
                </td>
                <td class="text-center">
                  <button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
          <center>
            <button class="btn btn-info" type="button" onclick="addMetode(<?= $i; ?>);"><i class="fa fa-plus"></i> Metode & Control</button>
          </center>
        </td>
        <td><?= form_textarea('kelemahanControl[]', $row['kelemahanControl'], "maxlength='10000' class='form-control' rows='2' style='overflow: hidden; height: 104px;'"); ?></td>
        <td><?= form_textarea('tindakLanjut[]', $row['tindakLanjut'], "maxlength='10000' class='form-control' rows='2' style='overflow: hidden; height: 104px;'"); ?></td>
        <td class="text-center">
          <button class="btn btn-danger" type="button" onclick="removeRCM(<?= $i; ?>);"><i class="fa fa-trash"></i> Hapus RCM</button>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<center>
  <button id="addRCM" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add RCM</button>
</center>

<script type="text/javascript">
  var rcmCount = <?= $i; ?>;

  // Tambah metode pengujian dan penilaian control
  function addMetode(rcmIndex) {
    var metodeTable = document.getElementById('metode_' + rcmIndex);
    var newRow = `
      <tr>
        <td>
          <select name="metodePengujian[${rcmIndex}][]" class="form-control select2" style="width:100%;">
            <?php foreach ($cboPengujian as $key => $value) : ?>
              <option value="<?= $key; ?>"><?= $value; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <select name="penilaianControl[${rcmIndex}][]" class="form-control select2" style="width:100%;">
            <?php foreach ($cboPenilaian as $key => $value) : ?>
              <option value="<?= $key; ?>"><?= $value; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="text-center"><button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button></td>
      </tr>`;
    metodeTable.insertAdjacentHTML('beforeend', newRow);
  }

  // Hapus metode
  function removeMetode(button) {
    var row = button.closest('tr');
    row.remove();
  }

  // Tambah RCM baru
  $("#addRCM").click(function() {
    rcmCount++;
    var newRCM = `
      <tr id="rcm_${rcmCount}">
        <td style="text-align:center;">${rcmCount}</td>
        <td><textarea name="bisnisProses[]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
        <td><textarea name="exixtingControl[]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
        <td colspan="2">
          <table class="table table-borderless">
            <tbody id="metode_${rcmCount}">
              <tr>
                <td>
                  <select name="metodePengujian[${rcmCount}][]" class="form-control select2" style="width:100%;">
                    <?php foreach ($cboPengujian as $key => $value) : ?>
                      <option value="<?= $key; ?>"><?= $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td>
                  <select name="penilaianControl[${rcmCount}][]" class="form-control select2" style="width:100%;">
                    <?php foreach ($cboPenilaian as $key => $value) : ?>
                      <option value="<?= $key; ?>"><?= $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                </td>
                <td class="text-center"><button class="btn btn-danger" type="button" onclick="removeMetode(this);"><i class="fa fa-trash"></i></button></td>
              </tr>
            </tbody>
          </table>
          <center>
            <button class="btn btn-info" type="button" onclick="addMetode(${rcmCount});"><i class="fa fa-plus"></i> Metode & Control</button>
          </center>
        </td>
        <td><textarea name="kelemahanControl[]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
        <td><textarea name="tindakLanjut[]" maxlength="10000" class="form-control" rows="2" style="overflow: hidden; height: 104px;"></textarea></td>
        <td class="text-center"><button class="btn btn-danger" type="button" onclick="removeRCM(${rcmCount});"><i class="fa fa-trash"></i> Hapus RCM</button></td>
      </tr>`;
    $("#rcm_body").append(newRCM);
  });

  // Hapus RCM
  function removeRCM(rcmIndex) {
    $("#rcm_" + rcmIndex).remove();
  }
</script>
