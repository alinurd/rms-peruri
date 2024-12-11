<table width="100%" border="1">
  <thead>
    <tr>
      <td colspan="2" rowspan="3" style="text-align: left; border-right:none;">
        <img src="<?= img_url('logo.png'); ?>" width="90">
      </td>
      <td colspan="3" rowspan="3" style="text-align: center; border-left:none;">
        RISK CRITERIA
      </td>
      <td>No.</td>
      <td>: 002/RM-FORM/I/<?= $tahun; ?></td>
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
    <?php } ?>
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
      <td colspan="7" style="border: none;">A. Kriteria Probabilitas</td>
    </tr>
    <tr>
      <td style="background-color: #BFBFBF; text-align: center;" colspan="2">
        <h3><strong>Skor</strong></h3>
      </td>
      <?php
      foreach ($kriteria as $index => $k) {
      ?>
        <td style="background-color: #BFBFBF; text-align: center;">
          <?= $index; ?>
        </td>
      <?php 
      }
      ?>
      <!-- <td style="background-color: #BFBFBF; text-align: center;">
        <h3><strong>4</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center;">
        <h3><strong>3</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center;">
        <h3><strong>2</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center;">
        <h3><strong>1</strong></h3>
      </td> -->
    </tr>
    <!-- <tr>
      <td style="background-color: #BFBFBF; text-align: center;" colspan="3">
        <h3><strong>Deskripsi</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center; width: 250px;">
        <h3><strong>Sangat Besar</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center; width: 250px;">
        <h3><strong>Besar</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center; width: 250px;">
        <h3><strong>Sedang</strong></h3>
      </td>
      <td style="background-color: #BFBFBF; text-align: center; width: 250px;">
        <h3><strong>Kecil</strong></h3>
      </td>
    </tr> -->
    <tr>
      <th style="background-color: #BFBFBF; text-align: center;width: 250px;" colspan="2">Kemungkinan</th>
      <?php
      foreach ($kriteria as $k) {
      ?>
        <td style="background-color: #BFBFBF; text-align: center; width: 250px;">
          <?= $k['name'] ?>
        </td>
      <?php 
      }
      ?>
    </tr>
  </thead>
  <tbody>
        <?php foreach ($kemungkinan as $kem) { ?>
          <tr>
            <td colspan="2"><?= $kem['data'] ?></td>
            <?php
            foreach ($kriteria as $kee => $k) {
            ?>
              <td>
                <?php
                $kemu = $this->db->where('km_id', $kem['id'])->where('criteria_risiko', $kee)->order_by('criteria_risiko')->get(_TBL_AREA_KM)->row_array();
                ?>
                <?php if ($kemu) : ?>
                  <?= $kemu['area'] ?>
                <?php endif ?>
              </td>
            <?php
            }
            ?>
          </tr>
        <?php
        } ?>
  </tbody>
</table>

<pagebreak>

<table width="100%" border="1">
  <thead>
    <tr>
      <td colspan="2" rowspan="3" style="text-align: left; border-right:none;">
        <img src="<?= img_url('logo.png'); ?>" width="90">
      </td>
      <td colspan="3" rowspan="3" style="text-align: center; border-left:none;">
        RISK CRITERIA
      </td>
      <td>No.</td>
      <td>: 002/RM-FORM/I/<?= date("Y"); ?></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td>: 1</td>
    </tr>
    <tr>
      <td>Tanggal Revisi</td>
      <td>: 31 Januari <?= date("Y"); ?></td>
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
    <?php } ?>
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
      <td colspan="7" style="border: none;">B. Kriteria Dampak</td>
    </tr>
    <tr>
      <td style="background-color: #BFBFBF; text-align: center;" colspan="2">
        <h3><strong>Skor</strong></h3>
      </td>
      <?php
      foreach ($kriteria as $index => $k) {
      ?>
        <td style="background-color: #BFBFBF; text-align: center;">
          <?= $index; ?>
        </td>
      <?php 
      }
      ?>
    </tr>
    <tr>
      <th>Kategori</th>
      <th>Dampak</th>
      <?php foreach ($kriteria as $k): ?>
        <td style="background-color: #BFBFBF; text-align: center;">
          <?= $k['name'] ?>
        </td>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($dampak as $dam): 
      $subDampak = $this->db->where('kelompok', 'sub-kriteria-dampak')
                ->where('pid', $dam['id'])
                ->get(_TBL_DATA_COMBO)
                ->result_array();
    ?>
      <?php foreach ($subDampak as $key => $subd): ?>
        <tr>
          <?php if ($key + 1 == 1): ?>
            <td rowspan="<?= count($subDampak) ?>"><?= $dam['data'] ?></td>
          <?php endif; ?>
          <td><?= $subd['data'] ?></td>
          <?php foreach ($kriteria as $kee => $k): ?>
            <td>
              <?php
              $damp = $this->db->where('sub_dampak_id', $subd['id'])
                ->where('criteria_risiko', $kee)
                ->order_by('criteria_risiko')
                ->get(_TBL_AREA)
                ->row_array();
              ?>
              <?php if ($damp): ?>
                <?= $damp['area'] ?>
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <?php if ($tgl == NULL): ?>
        <th colspan="7" style="text-align: right; border: none; font-size: 20px; font-style: normal;"></th>
      <?php else: ?>
        <th colspan="7" style="text-align: right; border: none; font-size: 20px; font-style: normal;">
          Dokumen ini telah disahkan oleh Kepala Divisi
          <?php if ($divisi == NULL) {
            echo $row['name'];
          } else {
            echo $divisi->name;
          } ?>
          Pada
          <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
          foreach ($tgl as $key1 => $row1) {
            echo strftime("%d %B %Y", strtotime($row1['create_date']));
          }
          ?>
        </th>
      <?php endif; ?>
    </tr>
  </tfoot>
</table>
