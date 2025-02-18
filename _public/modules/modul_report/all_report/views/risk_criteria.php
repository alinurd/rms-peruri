
<?php
if($data){
  foreach ($data as $d) {
?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <!-- <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td> -->
        <td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle;"><h4>RISK CRITERIA</h4></td>
        <td style="width: 24.5%;">No.</td>
        <td style="width: 24.5%;">: 001/RM-FORM/I/<?= $tahun; ?></td>
      </tr>
      <tr>
        <td>Revisi</td>
        <td>: 1</td>
      </tr>
      <tr>
        <td>Tanggal Revisi</td>
        <td>: 31 Januari <?= $tahun; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Owner</td>
        <td colspan="4" style="border: none;">: <?= $d['name']; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Agent</td>
        <td colspan="4" style="border: none;">: <?= $d['officer_name']; ?></td>
      </tr>
    </thead>
  </table>
  <?php
    $kriteriaData = $this->db->where('category', 'likelihood')->get(_TBL_LEVEL)->result_array();
    $defaultColors 	= [
      1 => 'green',
      2 => 'lightgreen',
      3 => 'yellow',
      4 => 'orange',
      5 => 'red'
    ];

    $kriteria_kem = [];
    foreach ($kriteriaData as $item) {
      $level = (int)$item['code']; // Pastikan level berupa integer
      $kriteria_kem[$level] = [
        'name' => $item['level'], // Nama diambil dari database
        'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
      ];
    }
    $kemungkinan = $this->db
    ->where('kelompok', 'kriteria-kemungkinan')
    ->where('param1', $d['id'])  // Menambahkan kondisi untuk field param1
    ->get(_TBL_DATA_COMBO)
    ->result_array();

    // Jika data `kemungkinan` kosong, ambil data dengan `param1` kosong
    if (empty($kemungkinan)) {
      $kemungkinan = $this->db
        ->where('kelompok', 'kriteria-kemungkinan')
        ->where('param1', NULL)  // Menambahkan kondisi untuk field param1 kosong
        ->or_where('param1', '') // Jika kosong bisa berupa NULL atau string kosong
        ->get(_TBL_DATA_COMBO)
        ->result_array();
    }

  ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Kemungkinan</th>
        <?php
        foreach ($kriteria_kem as $k) {
        ?>
          <td width="15%" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
            <?= $k['name'] ?>
          </td>
        <?php 
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($kemungkinan as $kem) {
      ?>
        <tr>
          <td><?= $kem['data'] ?></td>
          <?php
          foreach ($kriteria_kem as $kee => $k) {
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

  <?php
    $kriteriaData = $this->db->where('category', 'impact')->get(_TBL_LEVEL)->result_array();
    $defaultColors = [
      1 => 'green',
      2 => 'lightgreen',
      3 => 'yellow',
      4 => 'orange',
      5 => 'red'
    ];

    // Tambahkan warna ke data kriteria berdasarkan level
    $kriteria_dampak = [];
    foreach ($kriteriaData as $item) {
      $level = (int)$item['code']; // Pastikan level berupa integer
      $kriteria_dampak[$level] = [
        'name' => $item['level'], // Nama diambil dari database
        'color' => $defaultColors[$level] ?? 'gray' // Warna berdasarkan defaultColors
      ];
    }

    $dampak = $this->db
    ->where('kelompok', 'kriteria-dampak')
    ->where('param1', $d['id'])  
    ->get(_TBL_DATA_COMBO)
    ->result_array();

    // Jika data `dampak` kosong, ambil data dengan `param1` kosong
    if (empty($dampak)) {
    $dampak = $this->db
      ->where('kelompok', 'kriteria-dampak')
      ->group_start()               
        ->where('param1', NULL)
        ->or_where('param1', '')  // Jika kosong bisa berupa NULL atau string kosong
      ->group_end()                 // Mengakhiri grouping kondisi
      ->get(_TBL_DATA_COMBO)
      ->result_array();
    }
  ?>
  <table class="table table-bordered" style="width: 100%; table-layout: fixed;">
    <thead>
      <tr>
        <th>Kategori</th>
        <th>Dampak</th>
        <?php foreach ($kriteria_dampak as $k): ?>
          <td width="15%" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
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
            <?php foreach ($kriteria_dampak as $kee => $k): ?>
              <td style="word-wrap: break-word;">
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
  </table>

<?php
  }
}