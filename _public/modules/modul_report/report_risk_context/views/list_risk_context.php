<table width="100%" border="1" style="table-layout:fixed;">
  <thead>
    <tr>
      <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td>
      <td colspan="4" rowspan="3" style="text-align: center;border-left:none;">RISK CONTEXT</td>
      <td>No.</td>
      <td>: 001/RM-FORM/I/<?= $tahun; ?></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td>: 1</td>
    </tr>
    <tr>
      <td>Tanggal Revisi</td>
      <td>: 31 Januari <?= $tahun; ?></td>
    </tr>
    <?php
    if (count($field) == 0)
      echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
    $no = 0;
    $ttl_nil_dampak = 0;
    $ttl_exposure = 0;
    $ttl_exposure_residual = 0;
    $last_id = 0;
    foreach ($field as $key => $row) {
      $not = '';
      $tmp = ['', '', '', '', '', ''];
      if ($last_id != $row['id']) {
        ++$no;
        $last_id = $row['id'];
        $not = $no;
        $tmp[0] = $row['name'];
      }
    ?>
    <?php
    }
    ?>
    <tr>
      <td colspan="3" style="border: none;">Risk Owner</td>
      <td colspan="4" style="border: none;">: <?= $row['name']; ?></td>
    </tr>
    <tr>
      <td colspan="3" style="border: none;">Risk Agent</td>
      <td colspan="4" style="border: none;">: <?= $row['officer_name']; ?></td>
    </tr>
    <tr>
      <td colspan="7" style="border: none;"></td>
    </tr>
    <tr>
      <td colspan="7" style="border: none;">A.Umum</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th style="background-color: #BFBFBF;text-align: center;width: 1px">No</th>
      <th colspan="3" style="background-color: #BFBFBF;text-align: center;">General Information</th>
      <th colspan="4" style="background-color: #BFBFBF;text-align: center;">Konteks</th>
    </tr>
    <tr>
      <td style="text-align: center;">1</td>
      <td colspan="3">Anggaran RKAP</td>
      <td colspan="4"><?= "Rp " . number_format($row['anggaran_rkap']); ?></td>
    </tr>
    <tr>
      <!-- <?php doi::dump($divisi); ?> -->
      <td style="text-align: center;">2</td>
      <td colspan="3">Pemimpin Unit Kerja</td>
      <td colspan="4"><?= $divisi['name']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">3</td>
      <td colspan="3">Anggota Unit Kerja</td>
      <td colspan="4"><?= $row['anggota_pic']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">4</td>
      <td colspan="3">Tugas Pokok Dan Fungsi</td>
      <td colspan="4"><?= $row['tugas_pic']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">5</td>
      <td colspan="3">Pekerjaan Di Luar Tupoksi</td>
      <td colspan="4"><?= $row['tupoksi']; ?></td>
    </tr>
    <tr>
      <td style="height: 10px; border: none;" colspan="8"></td>
    </tr>
    <tr>
      <td rowspan="3" style="text-align: center;">6</td>
      <th rowspan="3" style="background-color: #BFBFBF;text-align: center;">Risk Appetite</th>
      <th rowspan="3" style="background-color: #BFBFBF;text-align: center;">Risk Appetite statement</th>
      <th colspan="5" style="background-color: #BFBFBF;text-align: center;">Threshold</th>
    </tr>
    <tr>
      <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Risk Appetite</th>
      <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Risk Tolerance</th>
      <th rowspan="2" style="background-color: #BFBFBF;text-align: center;">Risk Limit</th>
    </tr>
    <tr>
      <th style="background-color: #BFBFBF;text-align: center;">Max</th>
      <th style="background-color: #BFBFBF;text-align: center;">min</th>
      <th style="background-color: #BFBFBF;text-align: center;">Max</th>
      <th style="background-color: #BFBFBF;text-align: center;">min</th>
    </tr>
    <?php
    if (count($field) == 0)
      echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
    $no = 0;
    $ttl_nil_dampak = 0;
    $ttl_exposure = 0;
    $ttl_exposure_residual = 0;
    $last_id = 0;
    $no = 1;
    foreach ($fields as $key => $rows) {
      $not = '';
      $tmp = ['', '', '', '', '', ''];
      if ($last_id == $row['id']) {
        ++$no;
        $last_id = $row['id'];
        $not = $no;
        $tmp[0] = $row['name'];
      }
    ?>
      <tr>
        <td>6.<?= $no++; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['sasaran']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['statement']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['appetite']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['appetite_max']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['tolerance']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['tolerance_max']; ?></td>
        <td style="text-align: center;" valign="top" colspan=""><?= $rows['limit']; ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<table width="100%" border="1" style="table-layout:fixed;">
  <thead>

    <?php
    if (count($field) == 0)
      echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
    $no = 0;
    $ttl_nil_dampak = 0;
    $ttl_exposure = 0;
    $ttl_exposure_residual = 0;
    $last_id = 0;
    foreach ($field as $key => $row) {
      $not = '';
      $tmp = ['', '', '', '', '', ''];
      if ($last_id != $row['id']) {
        ++$no;
        $last_id = $row['id'];
        $not = $no;
        $tmp[0] = $row['name'];
      }
    ?>
    <?php
    }
    ?>
    <tr>
      <td style="height: 10px; border: none;" colspan="8"></td>
    </tr>

  </thead>
  <tbody>
    <tr>
      <th rowspan="2">7</th>
      <th class="text-center" style="background-color: #BFBFBF;text-align: center;" rowspan="2">Proses Management Risiko</th>
      <th colspan="12" style="background-color: #BFBFBF;text-align: center;" class="text-center">Waktu Implementasi 2023</th>
      <th class="text-center" style="background-color: #BFBFBF;text-align: center;" rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th style="background-color: #BFBFBF;text-align: center;">Jan</th>
      <th style="background-color: #BFBFBF;text-align: center;">Feb</th>
      <th style="background-color: #BFBFBF;text-align: center;">Mar</th>
      <th style="background-color: #BFBFBF;text-align: center;">Apr</th>
      <th style="background-color: #BFBFBF;text-align: center;">Mei</th>
      <th style="background-color: #BFBFBF;text-align: center;">Jun</th>
      <th style="background-color: #BFBFBF;text-align: center;">Jul</th>
      <th style="background-color: #BFBFBF;text-align: center;">Ags</th>
      <th style="background-color: #BFBFBF;text-align: center;">Sep</th>
      <th style="background-color: #BFBFBF;text-align: center;">Okt</th>
      <th style="background-color: #BFBFBF;text-align: center;">Nov</th>
      <th style="background-color: #BFBFBF;text-align: center;">Des</th>
    </tr>
    <?php
    if (count($field) == 0)
      echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
    $no = 0;
    $ttl_nil_dampak = 0;
    $ttl_exposure = 0;
    $ttl_exposure_residual = 0;
    $last_id = 0;
    $no = 1;
    foreach ($combo as $data) {
      $not = '';
      $imp = $this->db
        ->select('jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec,ket')
        ->where('rcsa_no', $id)
        ->where('combo_no', $data['id'])
        ->get(_TBL_RCSA_IMPLEMENTASI)
        ->row_array();
    ?>
      <tr>
        <td width="10px">7.<?= $no++; ?></td>
        <td width="350px" style="" valign="top" colspan=""><?= $data['data']; ?></td>
        <td style="text-align: center; color:#fff; <?= isset($imp['jan']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['feb']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['mar']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['apr']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['may']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['jun']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['jul']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['aug']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['sep']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['oct']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['nov']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>
        <td width="50px" style="text-align: center; <?= isset($imp['dec']) ? 'background-color: blue;' : '' ?>border-right:none;">
          <span style="text-align: center; color:#fff; "><i class="fa fa-check-circle"></i>x</span>
        </td>

        <td style="" width="300px"><?= $imp['ket'] ?></td>
      </tr>
    <?php
    }
    ?>


  </tbody>
</table>

<pagebreak>

  <table width="100%" border="1" style="table-layout:fixed;">
    <thead>
      <tr>
        <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td>
        <td colspan="4" rowspan="3" style="text-align: center;border-left:none;" width="300px">RISK CONTEXT</td>
        <td>No.</td>
        <td>: 001/RM-FORM/I/<?php echo date("Y"); ?></td>
      </tr>
      <tr>
        <td>Revisi</td>
        <td>: 1</td>
      </tr>
      <tr>
        <td>Tanggal Revisi</td>
        <td>: 31 Januari <?php echo date("Y"); ?></td>
      </tr>
      <?php
      if (count($field) == 0)
        echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
      $no = 0;
      $ttl_nil_dampak = 0;
      $ttl_exposure = 0;
      $ttl_exposure_residual = 0;
      $last_id = 0;
      foreach ($field as $key => $row) {
        $not = '';
        $tmp = ['', '', '', '', '', ''];
        if ($last_id != $row['id']) {
          ++$no;
          $last_id = $row['id'];
          $not = $no;
          $tmp[0] = $row['name'];
        }
      ?>
      <?php
      }
      ?>
      <tr>
        <td colspan="4" style="border: none;">Risk Owner</td>
        <td colspan="4" style="border: none;">: <?= $row['name']; ?></td>
      </tr>
      <tr>
        <td colspan="4" style="border: none;">Risk Agent</td>
        <td colspan="4" style="border: none;">: <?= $row['officer_name']; ?></td>
      </tr>
      <tr>
        <td colspan="8" style="border: none;"></td>
      </tr>
      <tr>
        <td colspan="8" style="border: none;">B.Isu</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;" width="1px">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;" width="200px">Isu Internal</th>
        <th colspan="4" style="background-color: #BFBFBF;text-align: center;">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="3">Man</td>
        <td colspan="4"><?= $row['man']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="3">Method</td>
        <td colspan="4"><?= $row['method']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="3">Machine</td>
        <td colspan="4"><?= $row['machine']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="3">Money</td>
        <td colspan="4"><?= $row['money']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="3">Material</td>
        <td colspan="4"><?= $row['material']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">6</td>
        <td colspan="3">Market</td>
        <td colspan="4"><?= $row['market']; ?></td>
      </tr>
    </tbody>
  </table>

  <table width="100%" border="1" style="table-layout:fixed;">
    <thead>

      <?php
      if (count($field) == 0)
        echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
      $no = 0;
      $ttl_nil_dampak = 0;
      $ttl_exposure = 0;
      $ttl_exposure_residual = 0;
      $last_id = 0;
      foreach ($field as $key => $row) {
        $not = '';
        $tmp = ['', '', '', '', '', ''];
        if ($last_id != $row['id']) {
          ++$no;
          $last_id = $row['id'];
          $not = $no;
          $tmp[0] = $row['name'];
        }
      ?>
      <?php
      }
      ?>
      <tr>
        <td style="height: 10px; border: none;" colspan="8"></td>
      </tr>

    </thead>
    <tr>
      <th style="background-color: #BFBFBF;text-align: center;width: 1px">No</th>
      <th colspan="3" style="background-color: #BFBFBF;text-align: center;" width="200px">Isu Eksternal</th>
      <th colspan="4" style="background-color: #BFBFBF;text-align: center;">Konteks</th>
    </tr>
    <tr>
      <td style="text-align: center;">1</td>
      <td colspan="3">Politics</td>
      <td colspan="4"><?= $row['politics']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">2</td>
      <td colspan="3">Economics</td>
      <td colspan="4"><?= $row['economics']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">3</td>
      <td colspan="3">Social</td>
      <td colspan="4"><?= $row['social']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">4</td>
      <td colspan="3">Tecnology</td>
      <td colspan="4"><?= $row['tecnology']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">5</td>
      <td colspan="3">Environment</td>
      <td colspan="4"><?= $row['environment']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">6</td>
      <td colspan="3">Legal</td>
      <td colspan="4"><?= $row['legal']; ?></td>
    </tr>
    </tbody>
  </table>

  <pagebreak>

    <table width="100%" border="1" style="table-layout:fixed;">
      <thead>
        <tr>
          <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td>
          <td colspan="5" rowspan="3" style="text-align: center;border-left:none;" width="300px">RISK CONTEXT</td>
          <td>No.</td>
          <td>: 001/RM-FORM/I/<?php echo date("Y"); ?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td>: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td>: 31 Januari <?php echo date("Y"); ?></td>
        </tr>
        <?php
        if (count($field) == 0)
          echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
        $no = 0;
        $ttl_nil_dampak = 0;
        $ttl_exposure = 0;
        $ttl_exposure_residual = 0;
        $last_id = 0;
        foreach ($field as $key => $row) {
          $not = '';
          $tmp = ['', '', '', '', '', ''];
          if ($last_id != $row['id']) {
            ++$no;
            $last_id = $row['id'];
            $not = $no;
            $tmp[0] = $row['name'];
          }
        ?>
        <?php
        }
        ?>
        <tr>
          <td colspan="4" style="border: none;">Risk Owner</td>
          <td colspan="4" style="border: none;">: <?= $row['name']; ?></td>
        </tr>
        <tr>
          <td colspan="4" style="border: none;">Risk Agent</td>
          <td colspan="4" style="border: none;">: <?= $row['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="8" style="border: none;"></td>
        </tr>
        <tr>
          <td colspan="8" style="border: none;">C.Stakeholder</td>
        </tr>
      </thead>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 1px">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;" width="200px">Stakeholder Internal</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</th>
      </tr>
      <?php
      if (count($field) == 0)
        echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
      $no = 1;
      $ttl_nil_dampak = 0;
      $ttl_exposure = 0;
      $ttl_exposure_residual = 0;
      $last_id = 0;
      foreach ($fields1 as $key => $rows1) {
        $not = '';
        $tmp = ['', '', '', '', '', ''];
        if ($last_id == $row['id']) {
          ++$no;
          $last_id = $row['id'];
          $not = $no;
          $tmp[0] = $row['name'];
        }
      ?>
        <tr>
          <td style="text-align: center;"><?= $no++ ?></td>
          <td colspan="3"><?= $rows1['stakeholder']; ?></td>
          <td colspan="3"><?= $rows1['peran']; ?></td>
          <td colspan="2" valign="top"><?= $rows1['komunikasi']; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
    </td>
    </tr>
    </table>


    <table width="100%" border="1" style="table-layout:fixed;">
      <thead>
        <tr>
          <td style="height: 10px; border: none;" colspan="8"></td>
        </tr>

      </thead>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 1px">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;" width="200px">Stakeholder Internal</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</th>
      </tr>
      <?php
      if (count($field) == 0)
        echo '<tr><td colspan=23 style="text-align:center">No Data</td></tr>';
      $no = 1;
      $ttl_nil_dampak = 0;
      $ttl_exposure = 0;
      $ttl_exposure_residual = 0;
      $last_id = 0;
      foreach ($fields2 as $key => $rows2) {
        $not = '';
        $tmp = ['', '', '', '', '', ''];
        if ($last_id == $row['id']) {
          ++$no;
          $last_id = $row['id'];
          $not = $no;
          $tmp[0] = $row['name'];
        }
      ?>

        <tr>
          <td style="text-align: center;"><?= $no++ ?></td>
          <td colspan="3"><?= $rows2['stakeholder']; ?></td>
          <td colspan="3"><?= $rows2['peran']; ?></td>
          <td colspan="2"><?= $rows2['komunikasi']; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
      <tfoot>

        <tr>
          <?php if ($tgl == NULL) : ?>
            <th colspan="9" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
          <?php else : ?>
            <th colspan="9" style="text-align: right;border: none;font-size: 20px;font-style: normal;">
              Dokumen ini telah disahkan oleh Kepala Divisi
              <?php if ($divisi == NULL) {
                echo $row['name'];
              } else {
                echo $divisi->name;
              } ?>
              Pada
              <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
              foreach ($tgl as $key1 => $row1) {
                echo strftime("%d %B %Y", strtotime($row1['create_date']))
              ?>
              <?php }  ?>
            <?php endif; ?>
            </th>

        </tr>

      </tfoot>
    </table>
    </td>
    </tr>
    </table>