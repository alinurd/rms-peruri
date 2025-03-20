<!-- STYLE CSS -->
<style>
  body {
      font-family: Arial, sans-serif;
      font-size: 10px;
  }

  table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed; 
  }

  thead {
      display: table-header-group; 
  }

  .header th, .header td {
      border: 1px solid black;
      
  }

  .header th {
      background-color: #BFBFBF;
      text-align: center;
  }

  .page-break {
      page-break-after: always;
      margin: 0px !important;
      padding: 0px !important;
  }

  .judul{
    text-align: left;
    font-weight: bold;
    padding-bottom: 0px !important;
    margin-bottom: 0px;
  }

  .context-umum {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed; 
  }

  .context-umum th{
    border: 1px solid black;
  }

  .context-umum td{
    border: 1px solid black; 
    word-wrap: break-word; 
  }





  .sasaran-table {
      width: 100%;
      border: none;
  }

  .sasaran-table td {
      padding: 0px;
      vertical-align: top;
      border: none;
  }

  .sasaran-table .number {
      text-align: right;
      padding-right: 5px;
      width: 5px;
  }

  .sasaran-table .text {
      text-align: left;
      text-indent: 10px;
  }

  .kriteria{
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed; 
  }

  .kriteria th{
    border: 1px solid black;
  }

  .kriteria td{
    border: 1px solid black; 
    word-wrap: break-word; 
  }

  th,td{
    border: 1px solid black; 
    word-wrap: break-word;
  }


</style>


<!-- RISK CONTEXT -->
<?php
if($parent) :
  foreach ($parent as $d) {
?>
    <!-- Table Header -->
    <table class="header">
        <tr>
          <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
            <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
            <h4>RISK CONTEXT</h4>
          </td>
          <td style="width: 10%;">No.</td>
          <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td colspan="3">: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Owner</td>
          <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Agent</td>
          <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>
    </table>

    <table class="context-umum">
      <tr>
        <td colspan="10" style="text-align: left;border: none;font-weight: bold;">A.Umum</td>
      </tr>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 5px;">No</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;width:100px;">Area</th>
        <th colspan="7" style="background-color: #BFBFBF;text-align: center;width:550px">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="2">Anggaran RKAP</td>
        <td colspan="7"><?= "Rp " . number_format($d['anggaran_rkap']); ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="2">Pemimpin Unit Kerja</td>
        <td colspan="7"><?= $d['owner_pic']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="2">Anggota Unit Kerja</td>
        <td colspan="7"><?= $d['anggota_pic']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="2">Tugas Pokok Dan Fungsi</td>
        <td colspan="7"><?=  $d['tugas_pic'];?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="2">Pekerjaan Di Luar Tupoksi</td>
        <td colspan="7"><?= $d['tupoksi']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">6</td>
        <td colspan="2">Sasaran</td>
        <td colspan="7">
          <table class="sasaran-table no-border">
              <?php
              $sasaran = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_SASARAN)->result_array();
              $no = 1;
              foreach ($sasaran as $s) {
              ?>
                  <tr>
                      <td class="number"><?= $no++; ?>.</td>
                      <td class="text"><?= $s['sasaran']; ?></td>
                  </tr>
              <?php
              }
              ?>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="10" style="padding-top: 10px;border: none;"></td>
      </tr>
      <tr>
        <td colspan="10" style="text-align: left;border: none;font-weight: bold;">B.Konteks Internal</td>
      </tr>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 5px;">No</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;width:100px;">Area</th>
        <th colspan="7" style="background-color: #BFBFBF;text-align: center;width:550px;">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="2">Man</td>
        <td colspan="7"><?= $d['man']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="2">Method</td>
        <td colspan="7"><?= $d['method']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="2">Machine</td>
        <td colspan="7"><?= $d['machine']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="2">Money</td>
        <td colspan="7"><?= $d['money']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="2">Material</td>
        <td colspan="7"><?= $d['material']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">6</td>
        <td colspan="2">Market</td>
        <td colspan="7"><?= $d['market']; ?></td>
      </tr>
      <tr>
        <td colspan="10" style="padding-top: 10px;border: none;"></td>
      </tr>
      <tr>
        <td colspan="10" style="text-align: left;border: none;font-weight: bold;">C.Konteks Eksternal</td>
      </tr>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center; width:5px;">No</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;width:100px;">Area</th>
        <th colspan="7" style="background-color: #BFBFBF;text-align: center;width:550px;">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="2">Politics</td>
        <td colspan="7"><?= $d['politics']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="2">Economics</td>
        <td colspan="7"><?= $d['economics']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="2">Social</td>
        <td colspan="7"><?= $d['social']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="2">Tecnology</td>
        <td colspan="7"><?= $d['tecnology']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="2">Environment</td>
        <td colspan="7"><?= $d['environment']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">6</td>
        <td colspan="2">Legal</td>
        <td colspan="7"><?= $d['legal']; ?></td>
      </tr>

      <tr>
        <td colspan="10" style="padding-top: 10px;border: none;"></td>
      </tr>
      <tr>
        <td colspan="10" style="text-align: left;border: none;font-weight: bold;">D.Stakeholder Internal</td>
      </tr>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 5px;">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;">Stakeholder Internal</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Potensi Gangguan / Hambatan</th>
      </tr>

      <?php
      $stakholder_internal  = $this->db->where('rcsa_no', $d['id'])->where('stakeholder_type', 1)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
      $no                   = 1;
      foreach ($stakholder_internal as $key => $rows1) {
      ?>
      <tr>
        <td style="text-align: center;"><?= $no++ ?></td>
        <td colspan="3"><?= $rows1['stakeholder']; ?></td>
        <td colspan="2"><?= $rows1['peran']; ?></td>
        <td colspan="2" valign="top"><?= $rows1['komunikasi']; ?></td>
        <td colspan="2" valign="top"><?= $rows1['potensi']; ?></td>
      </tr>
      <?php
      }
      ?>
      <tr>
        <td colspan="10" style="padding-top: 10px;border: none;"></td>
      </tr>
      <tr>
        <td colspan="10" style="text-align: left;border: none;font-weight: bold;">E.Stakeholder Eksternal</td>
      </tr>

      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 5px;">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;">Stakeholder Internal</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Peran/Fungsi</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Komunikasi Yang dipilih</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;">Potensi Gangguan / Hambatan</th>
      </tr>
      <?php
      $no = 1;
      $stakeholder_eksternal = $this->db->where('rcsa_no', $d['id'])->where('stakeholder_type', 2)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
      foreach ($stakeholder_eksternal as $key => $rows2) {
      ?>
        <tr>
          <td style="text-align: center;"><?= $no++ ?></td>
          <td colspan="3"><?= $rows2['stakeholder']; ?></td>
          <td colspan="2"><?= $rows2['peran']; ?></td>
          <td colspan="2"><?= $rows2['komunikasi']; ?></td>
          <td colspan="2"><?= $rows2['potensi']; ?></td>
        </tr>
      <?php
      }
      ?>
    </table>
    <div class="page-break"></div>
    <?php
  }
endif;
?>



<!-- RISK KRITERIA  -->
<?php
  if($parent) :
  foreach ($parent as $d) {
?>
    <table class="header">
        <tr>
          <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
            <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
            <h4>RISK CRITERIA</h4>
          </td>
          <td style="width: 10%;">No.</td>
          <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td colspan="3">: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Owner</td>
          <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Agent</td>
          <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>
    </table>
    <table class="kriteria">
        <!-- Kriteria Kemungkinan -->
        <tr>
          <td colspan="10" style="text-align: left;border: none;font-weight: bold;">A.Kriteria Kemungkinan</td>
        </tr>
        <?php
        $kriteriaData   = $this->db->where('category', 'likelihood')->get(_TBL_LEVEL)->result_array();
        $defaultColors 	= [1 => 'green',2 => 'lightgreen',3 => 'yellow',4 => 'orange',5 => 'red'];
        $kriteria_kem   = [];
        foreach ($kriteriaData as $item) {
          $level                = (int)$item['code'];
          $kriteria_kem[$level] = [ 'name' => $item['level'],'color' => $defaultColors[$level] ?? 'gray'];
        }
        $kemungkinan            = $this->db->where('kelompok', 'kriteria-kemungkinan')->where('param1', $d['id'])->get(_TBL_DATA_COMBO)->result_array();
    
        if (empty($kemungkinan)) {
          $kemungkinan          = $this->db->where('kelompok', 'kriteria-kemungkinan')->where('param1', NULL)->or_where('param1', '')->get(_TBL_DATA_COMBO)->result_array();
        }
        ?>
        <tr>
          <th colspan="3">Kemungkinan</th>
          <?php
          foreach ($kriteria_kem as $k) {
          ?>
            <td bgcolor="<?= $k['color'] ?>" style="color: #000;text-align: center;">
              <?= $k['name'] ?>
            </td>
          <?php 
          }
          ?>
        </tr>

        <?php foreach ($kemungkinan as $kem) { ?>
        <tr>
          <td colspan="3"><?= $kem['data'] ?></td>
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
        <?php } ?>

        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>

        <tr>
          <td colspan="10" style="text-align: left;border: none;font-weight: bold;">B.Kriteria Dampak</td>
        </tr>

        <?php
        $kriteriaData     = $this->db->where('category', 'impact')->get(_TBL_LEVEL)->result_array();
        $defaultColors    = [1 => 'green',2 => 'lightgreen',3 => 'yellow',4 => 'orange',5 => 'red'];
        $kriteria_dampak  = [];
        foreach ($kriteriaData as $item) {
          $level                    = (int)$item['code']; 
          $kriteria_dampak[$level]  = ['name' => $item['level'],'color' => $defaultColors[$level] ?? 'gray'];
        }
    
        $dampak                     = $this->db->where('kelompok', 'kriteria-dampak')->where('param1', $d['id'])->get(_TBL_DATA_COMBO)->result_array();
    

        if (empty($dampak)) {
          $dampak                   = $this->db->where('kelompok', 'kriteria-dampak')->group_start()->where('param1', NULL)->or_where('param1', '')->group_end()->get(_TBL_DATA_COMBO)->result_array();
        }
        ?>
        <tr>
          <th>Kategori</th>
          <th colspan="2">Dampak</th>
          <?php foreach ($kriteria_dampak as $k): ?>
            <td bgcolor="<?= $k['color'] ?>" style="color: #000;text-align: center;">
              <?= $k['name'] ?>
            </td>
          <?php endforeach; ?>
        </tr>
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
                <td colspan="2"><?= $subd['data'] ?></td>
                <?php foreach ($kriteria_dampak as $kee => $k): ?>
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
    </table>
    <div class="page-break"></div>
  <?php
    }
  endif;
  ?>
  


<!-- APPETITE -->
<?php
if($parent) :
  foreach ($parent as $d) {
?>
    <table class="header">
        <tr>
          <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
            <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
            <h4>RISK APPETITE</h4>
          </td>
          <td style="width: 10%;">No.</td>
          <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td colspan="3">: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Owner</td>
          <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Agent</td>
          <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>
    </table>
<table class="kriteria">
    <thead>
        <tr>
            <th rowspan="3" style="width: 5px;">No.</th>
            <th rowspan="3">Sasaran</th>
            <th rowspan="3">Risk Appetite Statement</th>
            <th colspan="6">Threshold</th>
            <th rowspan="3">Risk Limit</th>
        </tr>
        <tr>
            <th colspan="3">Risk Appetite</th>
            <th colspan="3">Risk Tolerance</th>
        </tr>
        <tr>
            <th>Min</th>
            <th>-</th>
            <th>Max</th>
            <th>Min</th>
            <th>-</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $field = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_SASARAN)->result_array();
        $i = 0;
        foreach ($field as $key => $row) {
            $edit = form_hidden('id_edit[]', $row['id']);
            ++$i;
        ?>
            <tr>
                <td style="text-align: center;"><?= $i . $edit; ?></td>
                <td><?= $row['sasaran']; ?></td>
                <td><?= $row['statement']; ?></td>
                <td style="text-align: center;"><?= $row['appetite']; ?></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;"><?= $row['appetite_max']; ?></td>
                <td style="text-align: center;"><?= $row['tolerance']; ?></td>
                <td style="text-align: center;">-</td>
                <td style="text-align: center;"><?= $row['tolerance_max']; ?></td>
                <td style="text-align: center;"><?= $row['limit']; ?></td>
            </tr>
        <?php } ?>
        <tr>
          <td colspan="8" style="padding-top: 20px;border: none;"></td>
        </tr>
    </tbody>
</table>
<div class="page-break"></div>
<?php
}
endif;
?>


<!-- RISK REGISTER -->
<?php
if($parent) :
  foreach ($parent as $d) {
    $field        = $this->data->get_data_risk_register($d['id']);
    if(!empty($field)) :
?>
    <table class="header">
        <tr>
          <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
            <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
            <h4>RISK REGISTER</h4>
          </td>
          <td style="width: 10%;">No.</td>
          <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td colspan="3">: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Owner</td>
          <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Agent</td>
          <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>
    </table>
<table class="kriteria" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;">
  <thead>
    <tr style="background-color: #f2f2f2;">
        <th rowspan="2" style="width: 5%; border: 1px solid #000; padding: 5px;">No.</th>
        <th colspan="3" style="width: 30%; border: 1px solid #000; padding: 5px;">Inheren</th>
        <th rowspan="2" style="width: 20%; border: 1px solid #000; padding: 5px;">Identifikasi Risiko</th>
        <th rowspan="2" style="width: 20%; border: 1px solid #000; padding: 5px;">Rencana Perlakuan Risiko</th>
        <th colspan="3" style="width: 25%; border: 1px solid #000; padding: 5px;">Residual</th>
    </tr>
    <tr style="background-color: #f2f2f2;">
        <th style="width: 10%; border: 1px solid #000; padding: 5px;">Skala Dampak</th>
        <th style="width: 10%; border: 1px solid #000; padding: 5px;">Skala Likelihood</th>
        <th style="width: 10%; border: 1px solid #000; padding: 5px;">Level Risiko</th>
        <th style="width: 8.33%; border: 1px solid #000; padding: 5px;">Skala Dampak</th>
        <th style="width: 8.33%; border: 1px solid #000; padding: 5px;">Skala Likelihood</th>
        <th style="width: 8.33%; border: 1px solid #000; padding: 5px;">Level Risiko</th>
    </tr>
  </thead>
    
    <tbody>
    <?php
      $no           = 1;
      $groupedRows  = array();
			$id_rcsa      = $this->input->post('id');
			$owner_no     = $this->input->post('owner_no');
			
			

      foreach ($field as $key => $row) :

          $sasaranKey = $row['sasaran'];
          if (!isset($groupedRows[$sasaranKey])) {
              $groupedRows[$sasaranKey] = array();
          }
          $sasaran        = $this->db->where('rcsa_no', $row['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
          $tema           = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();
          $control_as     = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
          $pic            = $this->db->where('id', $row['pic'])->get('bangga_owner')->row_array();
          $residual_level = $this->data->get_master_level(true, $row['residual_level']);
          $inherent_level = $this->data->get_master_level(true, $row['inherent_level']);
          $like           = $this->db
                                  ->where('id', $residual_level['likelihood'])
                                  ->get('bangga_level')->row_array();
          $impact         = $this->db
                                  ->where('id', $residual_level['impact'])
                                  ->get('bangga_level')->row_array();
          $likeinherent   = $this->db
                                  ->where('id', $inherent_level['likelihood'])
                                  ->get('bangga_level')->row_array();

          $impactinherent = $this->db
                                  ->where('id', $inherent_level['impact'])
                                  ->get('bangga_level')->row_array();
          $groupedRows[$sasaranKey][] = $row;
      endforeach;
      
      foreach ($groupedRows as $sasaranKey => $group) : ?>
        <!-- <tr style="background-color:#d5edef;">
            <td colspan="9"><strong><?= strtoupper($sasaranKey); ?></strong></td>
        </tr> -->
      <?php foreach ($group as $row) : 
        $act          = $this->db
                        ->where('rcsa_detail_no', $row['id'])
                        ->get('bangga_rcsa_action')->result_array();
        $treatments  = [];
        $kategori    = [];
        $d_id_action = []; 
           
        // Pastikan $act tidak kosong
        if (!empty($act)) {
            foreach ($act as $item) {
                // Cek kondisi untuk proaktif dan reaktif
                if (!empty($item['proaktif']) && empty($item['reaktif'])) {
                    $treatments[]   = $item['proaktif']; 
                    $kategori[]     = 'Proaktif'; 
                    $d_id_action[]  = $item['id'];
                } elseif (!empty($item['reaktif']) && empty($item['proaktif'])) {
                    $treatments[]   = $item['reaktif']; 
                    $kategori[]     = 'Reaktif';
                    $d_id_action[]  = $item['id'];
                } else {
                    $treatments[]   = $item['proaktif']; 
                    $kategori[]     = 'Keduanya'; 
                    $d_id_action[]  = $item['id']; 
                }
            }
        } else {
            $treatments     = ''; // Atau nilai default lainnya jika tidak ada hasil
            $kategori       = ''; // Set kategori ke string kosong atau nilai default
            $d_id_action    = ''; // Set ID action ke string kosong atau nilai default
        }


        $tema               = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();
        $control_as         = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
        $pic                = $this->db->where('id', $row['pic'])->get('bangga_owner')->row_array();
        $residual_level     = $this->data->get_master_level(true, $row['residual_level']);
        $inherent_level     = $this->data->get_master_level(true, $row['inherent_level']);
        

        $like               = $this->db
                                    ->where('id', $residual_level['likelihood'])
                                    ->get('bangga_level')->row_array();

        $impact             = $this->db
                                    ->where('id', $residual_level['impact'])
                                    ->get('bangga_level')->row_array();

        $likeinherent       = $this->db
                                    ->where('id', $inherent_level['likelihood'])
                                    ->get('bangga_level')->row_array();

        $impactinherent     = $this->db
                                    ->where('id', $inherent_level['impact'])
                                    ->get('bangga_level')->row_array();
        $act                = $this->db
                                    ->where('rcsa_detail_no', $row['id'])
                                    ->get('bangga_rcsa_action')->row_array();


        $score              = $this->db->select('score')->where('likelihood', $inherent_level['likelihood'])->where('impact', $inherent_level['impact'])->get('bangga_level_color')->row_array();
        $score1             = $this->db->select('score')->where('likelihood', $residual_level['likelihood'])->where('impact', $residual_level['impact'])->get('bangga_level_color')->row_array();
        $mapping_like_in    = $this->db->where('urut', $likeinherent['code'])->get('bangga_level_mapping')->row_array();
        $mapping_impact_in  = $this->db->where('urut', $impactinherent['code'])->get('bangga_level_mapping')->row_array();
        $mapping_like_res   = $this->db->where('urut', $like['code'])->get('bangga_level_mapping')->row_array();
        $mapping_impact_res = $this->db->where('urut', $impact['code'])->get('bangga_level_mapping')->row_array();
      ?>
      <tr>
        <td valign="top" style="text-align: center;"><?= $no++; ?></td>
        <td valign="top" style="text-align: center;background-color:<?=$mapping_impact_in['color'];?>;color:<?= $mapping_impact_in['color_text']; ?>;">
          <?= $impactinherent['code']." ".$impactinherent['level']; ?>
        </td>

        <td valign="top" style="text-align: center; background-color:<?=$mapping_like_in['color'];?>;color:<?= $mapping_like_in['color_text']; ?>;"><?= $likeinherent['code']." ".$likeinherent['level']; ?></td>
        <td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= intval($score['score']).' '.$inherent_level['level_mapping']; ?></td>
        <td valign="top" >
          <ul style="list-style-type: square;">
            <li><strong>Sasaran</strong></li>
            <?= strtoupper($sasaranKey); ?>
            <li><strong>Peristiwa Risiko</strong></li>
            <?= $row['event_name']; ?>
            <li><strong>Penyebab Risiko</strong></li>
            <?= format_list($row['couse'], "### "); ?>
            <li><strong>Dampak Risiko</strong></li>
            <?= format_list($row['impact'], "### "); ?>
            <li><strong>Nilai Exposure Inheren</strong></li>
            Rp.<?= number_format($row['nilai_in_exposure']); ?>
            <li><strong>Nilai Exposure Residual</strong></li>
            Rp.<?= number_format($row['nilai_res_exposure']); ?>
          </ul>
        </td>
        <td valign="top" >
          <ul style="list-style-type: square;">
            <li><strong>Opsi Perlakuan Risiko</strong></li>
            <?= $row['treatment']; ?>
            <li><strong>Rencana Perlakuan Risiko</strong></li>
            <?php if (!empty($treatments)): ?>
                <table style="width: 100%; border-collapse: collapse;">
                        <?php foreach ($treatments as $index => $treatment): ?>
                            <tr>
                                <td style="border: none;"><?= $index + 1 .'.'; ?><?= $treatment; ?></td>
                            </tr>
                        <?php endforeach; ?>
                </table>
                    <?php else: ?>
                <?= '-';?>
            <?php endif; ?>
            <li><strong>Biaya Perlakuan Risiko</strong></li>
            <?php 
            if (!empty($d_id_action)): ?>
                <table style="width: 100%; border-collapse: collapse; border-spacing: 0; padding: 0;">
                    <?php foreach ($d_id_action as $index => $treat): 
                        $data_treatment = $this->db->select('target_damp_loss')->where('id_rcsa_action', $treat)
                                                    ->get('bangga_rcsa_treatment')
                                                    ->result_array(); 
                        $total_target_damp_loss = 0;
                        foreach ($data_treatment as $j => $dt) {
                            $total_target_damp_loss += $data_treatment[$j]['target_damp_loss'];
                        }
                    ?>
                        <tr>
                            <td style="border: none; padding: 0;"><?= $index + 1 . '.'; ?><?= !empty($total_target_damp_loss) ? "Rp.".number_format($total_target_damp_loss, 2) : '-'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php else: ?>
                <?= '-'; ?>
            <?php endif; ?>
          </ul>
        </td>
        <td valign="top" style="text-align: center;background-color:<?=$mapping_impact_res['color'];?>;color:<?= $mapping_impact_res['color_text']; ?>;">
          <?= $impact['code']." ".$impact['level']; ?>
        </td>

        <td valign="top" style="text-align: center;background-color:<?=$mapping_like_res['color'];?>;color:<?= $mapping_like_res['color_text']; ?>;"><?= $like['code']." ".$like['level']; ?></td>
        <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= intval($score1['score']).' '.$residual_level['level_mapping']; ?></td>
      </tr>

      <?php endforeach; ?>
      <?php endforeach; ?>
      <tr>
          <td colspan="9" style="padding-top: 20px; border: none;"></td>
      </tr>
    </tbody>
</table>
<div class="page-break"></div>
<?php endif;?>
<?php
  }
endif;
?>

<!--RISK EFEKTIFITAS CONTROL -->
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

  if($parent) :
  foreach ($parent as $d) {
      $bisnis_proses = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCM)->result_array(); 
      if(!empty($bisnis_proses)):
        $test = $this->db->select([
            'proses_bisnis',
            'note_control',
            'JSON_LENGTH(note_control) as note_count'  
        ])
        ->where('rcsa_no', $d['id'])  
        ->get(_TBL_RCSA_DETAIL)
        ->result_array();
      $options = [];
      foreach ($test as $row) {
          $options[$row['proses_bisnis']] = $row['proses_bisnis'];
      }
    ;?>
    <table class="header">
        <tr>
          <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
            <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
            <h4>RISK EFEKTIFITAS CONTROL</h4>
          </td>
          <td style="width: 10%;">No.</td>
          <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td>Revisi</td>
          <td colspan="3">: 1</td>
        </tr>
        <tr>
          <td>Tanggal Revisi</td>
          <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Owner</td>
          <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
          <td colspan="6" style="border: none;">Risk Agent</td>
          <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="10" style="padding-top: 10px;border: none;"></td>
        </tr>
    </table>
  
    <table class="kriteria" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;">
      <thead>
          <tr>
              <th rowspan="2" style="width: 5px;" class="text-center">No.</th>
              <th colspan="4" rowspan="2" style="width: 20%;" class="text-center">Business Process</th>
              <th colspan="5" style="width: 75%;" class="text-center">Metode & Control</th>
          </tr>
          <tr>
              <th style="width: 15%;" class="text-center">Existing Control</th>
              <th style="width: 15%;" class="text-center">Metode Pengujian</th>
              <th style="width: 15%;" class="text-center">Penilaian Internal Control</th>
              <th style="width: 15%;" class="text-center">Kelemahan Control</th>
              <th style="width: 15%;" class="text-center">Rencana Tindak Lanjut</th>
          </tr>
      </thead>
      <tbody>
          <?php        
              $i = 0;
              foreach ($bisnis_proses as $key => $row): $i++; 
                  $exiting_control = $this->db->where('rcm_id', $row['id'])->get(_TBL_EXISTING_CONTROL)->result_array();
          ?>
          
          <tr>
              <td style="text-align:center;"><?= $i; ?></td>
              <td colspan="4"><?= $row['bussines_process']; ?></td>
              <td colspan="5" style="padding: 0; margin: 0;">
                  <table style="width: 100%; border-collapse: collapse; margin: 0;">
                      <tbody>
                          <?php 
                              $j = 0;
                              foreach ($exiting_control as $ex): 
                                  $j++; 
                          ?>
                              <tr>
                                  <td style="width: 189px; padding:5px ; margin: 0; min-width: 16%;"><?= $ex['component']; ?></td>
                                  <td style="width: 190px; padding:5px ; margin: 0;"><?= $cboPengujian[$ex['metode_pengujian']]; ?></td>
                                  <td style="width: 190px; padding:5px ; margin: 0;">
                                      <span style="font-size: 12px; background-color: <?= $comboColor[$ex['penilaian_intern_control']]; ?>; color: <?= ($comboColor[$ex['penilaian_intern_control']] == '#00712D' || $comboColor[$ex['penilaian_intern_control']] == '#B8001F') ? '#FFFFFF' : '#000000'; ?>;">
                                          <?= $cboPenilaian[$ex['penilaian_intern_control']]; ?>
                                      </span>
                                  </td>
                                  <td style="width: 190px; padding:5px ; margin: 0;"><?= $ex['kelemahan_control']; ?></td>
                                  <td style=" padding:5px ; margin: 0;"><?= $ex['rencana_tindak_lanjut']; ?></td>
                              </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              </td>
          </tr>
          <?php endforeach; ?>
          <tr>
              <td colspan="10" style="padding-top: 10px; border: none;"></td>
          </tr>
      </tbody>  
    </table>

    <div class="page-break"></div>
    <?php endif;?>

<?php
  }
endif;

?>

<!-- LOST EVENT -->
<?php
  foreach ($parent as $d) {
    $data_event   = $this->db->where('rcsa_no', $d['id'])->get(_TBL_VIEW_RCSA_LOST_EVENT)->row_array();
    $lost_event   = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_LOST_EVENT)->row_array();
    if($lost_event){
      $row_in     = $this->db->where('impact_no', $lost_event['skal_dampak_in'])->where('like_no', $lost_event['skal_prob_in'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
      $row_res    = $this->db->where('impact_no', $lost_event['target_res_dampak'])->where('like_no', $lost_event['target_res_prob'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
      $label_in   = "<span style='background-color:" . $row_in['warna_bg'] . ";color:" . $row_in['warna_txt'] . ";'>&nbsp;" . $row_in['tingkat'] . "&nbsp;</span>";
      $label_res  = "<span style='background-color:" . $row_res['warna_bg'] . ";color:" . $row_res['warna_txt'] . ";'>&nbsp;" . $row_res['tingkat'] . "&nbsp;</span>";
?>
<table class="kriteria" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;">
    <thead>
        <tr>
            <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                <img src="<?= img_url('logo.png'); ?>" width="90">
            </td>
            <td colspan="8" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                <h4>LOSS EVENT DATABASE</h4>
            </td>
            <td style="width: 12%;">No.</td>
            <td style="width: 12%;">: 001/RM-FORM/I/<?= $d['periode_name']; ?></td>
        </tr>
        <tr>
            <td style="width: 12%;">Revisi</td>
            <td style="width: 12%;">: 1</td>
        </tr>
        <tr>
            <td style="width: 12%;">Tanggal Revisi</td>
            <td style="width: 12%;">: 31 Januari <?= $d['periode_name']; ?></td>
        </tr>
        <tr>
            <td colspan="10" style="border: none;">Risk Owner</td>
            <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
        </tr>
        <tr>
            <td colspan="10" style="border: none;">Risk Agent</td>
            <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>
    </thead>
    <tbody>
        <!-- Bagian A -->
        <tr>
            <td colspan="12" style="border: none;"><strong>A. Kejadian Risiko</strong></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Nama Kejadian (Event)</th>
            <td colspan="9"><?= $data_event['event_name']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Identifikasi Kejadian</th>
            <td colspan="9"><?= $lost_event['identifikasi_kejadian']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Kategori Kejadian</th>
            <td colspan="9"><?= $kategori_kejadian[$lost_event['kategori']]; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Sumber Penyebab</th>
            <td colspan="9"><?= $lost_event['sumber_penyebab']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Penyebab Kejadian</th>
            <td colspan="9"><?= $lost_event['penyebab_kejadian']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Penanganan Saat Kejadian</th>
            <td colspan="9"><?= $lost_event['penanganan']; ?></td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>

        <!-- Bagian B -->
        <tr>
            <td colspan="12" style="border: none;"><strong>B. Hubungan Kejadian Risiko Dengan Risk Event</strong></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Kategori Risiko</th>
            <td colspan="9"><?= $kat_risiko[$lost_event['kat_risiko']]; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Hubungan Kejadian Risk Event</th>
            <td colspan="9"><?= $lost_event['hub_kejadian_risk_event']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Analisis Risiko</th>
            <td colspan="3" style="background-color: #e9ecef; text-align: center;">Skala Dampak</td>
            <td colspan="3" style="background-color: #e9ecef; text-align: center;">Skala Probabilitas</td>
            <td colspan="3" style="background-color: #e9ecef; text-align: center;">Level Risiko</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Inheren</th>
            <td colspan="3">
              <?= $cboImpact[$lost_event['skal_dampak_in']];?>
              </td>
              <td colspan="3">
                <?= $cboLike[$lost_event['skal_prob_in']];?>
            </td>
            <td colspan="3" align="center">
                <span id="level_risiko_inher_label"><?= $label_in; ?></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Target Residual</th>
            <td colspan="3">
              <?= $cboImpact[$lost_event['target_res_dampak']];?>
              </td>
              <td colspan="3">
                <?= $cboLike[$lost_event['target_res_prob']];?>
            </td>
            <td colspan="3" align="center">
                <span id="level_risiko_res_label"><?= $label_res; ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>

        <!-- Bagian C -->
        <tr>
            <td colspan="12" style="border: none;"><strong>C. Rencana dan Realisasi Perlakuan Risiko</strong></td>
        </tr>
        <tr>
            <th colspan="12" class="text-center">Mitigasi Yang Direncanakan</th>
        </tr>
        <tr>
            <td colspan="12"><?= $lost_event['mitigasi_rencana']; ?></td>
        </tr>
        <tr>
            <th colspan="12" class="text-center">Realisasi Mitigasi</th>
        </tr>
        <tr>
            <td colspan="12"><?= $lost_event['mitigasi_realisasi']; ?></td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>

        <!-- Bagian D -->
        <tr>
            <td colspan="12" style="border: none;"><strong>D. Asuransi</strong></td>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center;">Status Asuransi</th>
            <th colspan="4" style="text-align: center;">Nilai Premi</th>
            <th colspan="4" style="text-align: center;">Nilai Klaim</th>
        </tr>
        <tr>
            <td colspan="4"><?= $lost_event['status_asuransi']; ?></td>
            <td colspan="4"><?= ($lost_event['nilai_premi']) ? "Rp. ".number_format($lost_event['nilai_premi'], 0, ',', ',') : ""; ?></td>
            <td colspan="4"><?= ($lost_event['nilai_klaim']) ? "Rp. ".number_format($lost_event['nilai_klaim'], 0, ',', ',') : ""; ?></td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>

        <!-- Bagian E -->
        <tr>
            <td colspan="12" style="border: none;"><strong>E. Perbaikan Mendatang</strong></td>
        </tr>
        <tr>
            <th colspan="6" class="text-center">Rencana Perbaikan Mendatang</th>
            <th colspan="6" class="text-center">Pihak Terkait</th>
        </tr>
        <tr>
            <td colspan="6"><?= $lost_event['rencana_perbaikan_mendatang']; ?></td>
            <td colspan="6"><?= $lost_event['pihak_terkait']; ?></td>
        </tr>
        <tr>
            <td colspan="12" style="padding-top: 20px; border: none;"></td>
        </tr>

        <!-- Bagian F -->
        <tr>
            <td colspan="12" style="border: none;"><strong>F. Kerugian</strong></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Penjelasan Kerugian</th>
            <td colspan="9"><?= $lost_event['penjelasan_kerugian']; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Nilai Kerugian</th>
            <td colspan="9"><?= ($lost_event['nilai_kerugian']) ? "Rp. ".number_format($lost_event['nilai_kerugian'], 0, ',', ',') : ""; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Kejadian Berulang</th>
            <td colspan="9"><?= $lost_event['kejadian_berulang'] == 1 ? "Ya" : "Tidak"; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">Frekuensi Kejadian</th>
            <td colspan="9"><?= $frekuensi_kejadian[$lost_event['frekuensi_kejadian']]; ?></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: left;">File</th>
            <td colspan="9">
                <a href="<?= base_url('themes/upload/lost_event/'.$lost_event['file_path']) ?>" target="_blank"><?= $lost_event['file_path']; ?></a>
            </td>
        </tr>
    </tbody>
</table>

<div class="page-break"></div>
<?php
    }
  }
?>


<!-- EARLY WARNING -->
<table class="header">
    <tr>
      <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
        <img src="<?= img_url('logo.png'); ?>" width="90">
      </td>
      <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
        <h4>EARLY WARNING</h4>
      </td>
      <td style="width: 10%;">No.</td>
      <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td colspan="3">: 1</td>
    </tr>
    <tr>
      <td>Tanggal Revisi</td>
      <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
    </tr>
    <tr>
      <td colspan="6" style="border: none;">Risk Owner</td>
      <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
    </tr>
    <tr>
      <td colspan="6" style="border: none;">Risk Agent</td>
      <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
    </tr>
    <tr>
      <td colspan="10" style="padding-top: 10px;border: none;"></td>
    </tr>
</table>
<table class="kriteria">
<thead>
    <tr>
        <th style="text-align:center;" rowspan="2" width="4%">No</th>
        <th style="text-align:center;" rowspan="2" width="8%">Risk Owner</th>
        <th style="text-align:center;" rowspan="2" width="12%">Peristiwa Risiko</th>
        <th style="text-align:center;" rowspan="2" width="8%">Indikator</th>
        <th style="text-align:center;" rowspan="2" width="8%">Satuan</th>
        <th colspan="3" style="text-align:center;" width="20%">Threshold</th>
        <th colspan="12" style="text-align:center;" width="40%">Realisasi</th>
    </tr>
    <tr style="text-align:center;">
        <td style="text-align:center; background-color: #7FFF00; color: #000;" width="6%">Aman</td>
        <td style="text-align:center; background-color: #FFFF00; color: #000;" width="6%">Hati-Hati</td>
        <td style="text-align:center; background-color: #FF0000; color: #000;" width="6%">Bahaya</td>
        <th style="text-align:center;" width="3%">Jan</th>
        <th style="text-align:center;" width="3%">Feb</th>
        <th style="text-align:center;" width="3%">Mar</th>
        <th style="text-align:center;" width="3%">Apr</th>
        <th style="text-align:center;" width="3%">Mei</th>
        <th style="text-align:center;" width="3%">Jun</th>
        <th style="text-align:center;" width="3%">Jul</th>
        <th style="text-align:center;" width="3%">Agu</th>
        <th style="text-align:center;" width="3%">Sep</th>
        <th style="text-align:center;" width="3%">Okt</th>
        <th style="text-align:center;" width="3%">Nov</th>
        <th style="text-align:center;" width="3%">Des</th>
    </tr>
</thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($early_warning as $q) {
            if ($q['kri']) {
                $act            = $this->db->where('rcsa_detail_no', $q['id'])->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
                $combo          = $this->db->where('id', $q['kri'])->get('bangga_data_combo')->row_array();
                $combo_stuan    = $this->db->where('id', $q['satuan'])->get('bangga_data_combo')->row_array();

                $level_1        = range($q['min_rendah'], $q['max_rendah']);
                $level_2        = range($q['min_menengah'], $q['max_menengah']);
                $level_3        = range($q['min_tinggi'], $q['max_tinggi']);

                if (in_array($data, $level_1)) {
                    $bgres = 'style="background-color: #7FFF00; color: #000;"';
                } elseif (in_array($data, $level_2)) {
                    $bgres = 'style="background-color: #FFFF00; color: #000;"';
                } elseif (in_array($data, $level_3)) {
                    $bgres = 'style="background-color: #FF0000; color: #000;"';
                } else {
                    $bgres = '';
                }
        ?>
        <tr>
            <td style="text-align:center; background-color: #fff;"><?= $no++ ?></td>
            <td style="background-color: #fff;"><?= $q['name'] ?></td>
            <td style="background-color: #fff; "><?= $act['event_name'] ?></td>
            <td style="background-color: #fff;"><?= $combo['data'] ?></td>
            <td style="background-color: #fff; ">
                <center><?= $combo_stuan['data'] == "%" ? "persentase [%]" : $combo_stuan['data'] ?></center>
            </td>
            <td style="text-align:center; background-color: #7FFF00; color: #000;"><?= $q['min_rendah'] ?> - <?= $q['max_rendah'] ?></td>
            <td style="text-align:center; background-color: #FFFF00; color: #000;"><?= $q['min_menengah'] ?> - <?= $q['max_menengah'] ?></td>
            <td style="text-align:center; background-color: #FF0000; color: #000;"><?= $q['min_tinggi'] ?> - <?= $q['max_tinggi'] ?></td>
            <?php
            $start  = 1;
            $end    = 12;
            for ($i = $start; $i <= $end; $i++): 
                $data['id']         = $q['id'];
                $data['rcsa_no']    = $q['rcsa_no'];
                $res = $this->data->getMonthlyMonitoringGlobal_Early($data, $i);
            ?>
            <td <?= $res['bgres'] ?> id="kri-<?= $q['id'] ?><?= $i ?>">
                <center><?= $res['data'] ?></center>
            </td>
            <?php endfor; ?>
        </tr>
        <?php } else { ?>
        <tr>
            <td style="text-align:center;" colspan="11">Tidak ada data Key Risk Indikator</td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>


<div class="page-break"></div>
<?php
$bulanName = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
?>


<table class="header">
    <tr>
      <td colspan="2" rowspan="3" style="width:20%;text-align: center;border-right:none;padding-left: 10px;">
        <img src="<?= img_url('logo.png'); ?>" width="90">
      </td>
      <td colspan="4" rowspan="3" style="width:40%;border-left: none; text-align: center;vertical-align: middle;">
        <h4>IHTISAR PERUBAHAN LEVEL</h4>
      </td>
      <td style="width: 10%;">No.</td>
      <td colspan="3" style="width: 30%;">: 001/RM-FORM/I/<?= $d['periode_name'];?></td>
    </tr>
    <tr>
      <td>Revisi</td>
      <td colspan="3">: 1</td>
    </tr>
    <tr>
      <td>Tanggal Revisi</td>
      <td colspan="3">: 31 Januari <?= $d['periode_name'];?></td>
    </tr>
    <tr>
      <td colspan="6" style="border: none;">Risk Owner</td>
      <td colspan="2" style="border: none;">: <?= $d['name']; ?></td>
    </tr>
    <tr>
      <td colspan="6" style="border: none;">Risk Agent</td>
      <td colspan="2" style="border: none;">: <?= $d['officer_name']; ?></td>
    </tr>
    <tr>
      <td colspan="10" style="padding-top: 10px;border: none;"></td>
    </tr>
</table>
<?php foreach ($bulanName as $keyB => $bulanheader) {?>

  <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 12px;">
  <thead>
    <tr>
      <td colspan="8" style="border: none;"></td>
    </tr>
    <tr>
      <th width="5%" style="text-align: center; background-color: #f2f2f2;">No</th>
      <th width="15%" style="text-align: left; background-color: #f2f2f2;">Risk Owner</th>
      <th width="20%" style="text-align: left; background-color: #f2f2f2;">Peristiwa Risiko</th>
      <th width="8%" style="text-align: center; background-color: #f2f2f2;">Tahun</th>
      <th width="10%" style="text-align: center; background-color: #f2f2f2;">Inh</th>
      <th width="10%" style="text-align: center; background-color: #f2f2f2;">Res</th>
      <th width="10%" style="text-align: center; background-color: #f2f2f2;">PL</th>
      <th width="22%" style="text-align: left; background-color: #f2f2f2;">Keterangan Pergerakan Level Bulan: <?= $bulanheader; ?></th>
    </tr>
  </thead> 
  <tbody>
    <?php
    $data['owner_no']     = $id_owner;
    $data['periode_no']   = $periode_no;
    $data['bulan']        = $keyB;
    $field                = $this->data->perubahan_level($data);
    $no                   = 1;

    foreach ($field as $q) {
        $inherent_level = $this->data->get_master_level(true, $q['inherent_level']);
        $getKode        = $this->data->level_action($inherent_level['likelihood'], $inherent_level['impact']);
        $reKod          = $getKode['like']['code'] . ' x ' . $getKode['impact']['code'];
        $inherent       = $reKod . '<br>' . $inherent_level['level_mapping'];
        $pl             = '';
        $act            = $this->db->select('id')->where('rcsa_detail_no', $q['id'])->get('bangga_rcsa_action')->row_array();
        $monitoring     = $this->db->where('rcsa_action_no', $act['id'])->where('bulan', $keyB)->get('bangga_view_rcsa_action_detail')->row_array();
        $l              = $this->data->level_action($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
        $cek_score1     = $this->data->cek_level_new($monitoring['residual_likelihood_action'], $monitoring['residual_impact_action']);
        $residual_level = $this->data->get_master_level(true, $cek_score1['id']);
        $resLv          = $l['like']['code'] . ' x ' . $l['impact']['code'];
        $keterangan_pl  = $monitoring['keterangan_pl'];
        $lv             = $resLv . '<br>' . $residual_level['level_mapping'];
        $r              = 0;

        if ($residual_level['level_mapping'] == "High") {
            $r = 5;
        } elseif ($residual_level['level_mapping'] == "Moderate to High") {
            $r = 4;
        } elseif ($residual_level['level_mapping'] == "Moderate") {
            $r = 3;
        } elseif ($residual_level['level_mapping'] == "Low to Moderate") {
            $r = 2;
        } elseif ($residual_level['level_mapping'] == "Low") {
            $r = 1;
        }

        if ($inherent_level['level_mapping'] == "High") {
            $Inh = 5;
        } elseif ($inherent_level['level_mapping'] == "Moderate to High") {
            $Inh = 4;
        } elseif ($inherent_level['level_mapping'] == "Moderate") {
            $Inh = 3;
        } elseif ($inherent_level['level_mapping'] == "Low to Moderate") {
            $Inh = 2;
        } elseif ($inherent_level['level_mapping'] == "Low") {
            $Inh = 1;
        }


        $bg_color;
        if ($r == $Inh) {
            $pl       = '<img src="'. img_url('tengah.png').'"'.'>';
            // <!-- $pl       = 'residual anda tidak penurunan dan kenaikan dari risiko inherent'; -->
        } elseif ($r > $Inh) {
            $pl       = '<img src="'. img_url('up.png').'"'.'>';
        } elseif ($r < $Inh) {
          $pl         = '<img src="'. img_url('down.png').'"'.'>';
        } else {
          $bg_color   = '#dc3545';
            $pl       = 'x';
        }

        if (!$monitoring || empty($l['impact']) || empty($l['like'])) {
            $lv       = '<center>-</center>';
            $bg_color = '#dc3545';
            $pl       = 'x';
            $ket      = 'x';
        } else {
            $lv       = $lv;
            $pl       = $pl;
            $ket      = ($keterangan_pl) ? $keterangan_pl : "<span style='color:red;'>Belum Di Monitoring</span>";
        }
    ?>
    <tr>
      <td width="5%" style="text-align: center;"><?= $no++ ?></td>
      <td width="15%" style="text-align: left;"><?= $q['owner_name'] ?></td>
      <td width="20%" style="text-align: left;"><?= $q['event_name'] ?></td>
      <td width="8%" style="text-align: center;"><?= $q['tahun'] ?></td>
      <td width="10%" style="text-align: center; background: <?= $inherent_level['color']; ?>; color: <?= $inherent_level['color_text']; ?>"><?= $inherent ?></td>
      <td width="10%" style="text-align: center; background-color: <?= $residual_level['color']; ?>; color: <?= $residual_level['color_text']; ?>"><?= $lv; ?></td>
      <td width="10%" style="text-align: center;"><?= $pl ?></td>
      <td width="22%" style="text-align: left;"><?= $ket ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php
}
?>
<div class="page-break"></div>


<div style="width: 100%; text-align: center;">
  <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
      <thead>
      <tr>
            <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                <img src="<?= img_url('logo.png'); ?>" width="90">
            </td>
            <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                <h4>GRAFIK HEATMAP</h4>
            </td>
            <td style="width: 12%;">No.</td>
            <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
        </tr>
        <tr>
            <td style="width: 12%;">Revisi</td>
            <td style="width: 12%;">: 1</td>
        </tr>
        <tr>
            <td style="width: 12%;">Tanggal Revisi</td>
            <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">Risk Owner</td>
            <td style="border: none;">: <?= $parent[0]['name']; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;">Risk Agent</td>
            <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
        </tr>
        <tr>
          <td colspan="8" style="padding-top: 20px; border: none;"></td>
      </tr>
      </thead>
    </table>
    <?php if (isset($heatmap)): ?>
        <img style="display: block; margin: 0 auto;" src="<?= base_url() . $heatmap; ?>" alt="Heatmap" />
    <?php endif; ?>
</div>

<div class="page-break"></div>

<div style="width: 100%; text-align: center;">
<table style="width: 100%; border-collapse: collapse; font-size: 12px;">
    <thead>
    <tr>
          <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
              <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
              <h4>GRAFIK RISK DISTRIBUTION</h4>
          </td>
          <td style="width: 12%;">No.</td>
          <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
      </tr>
      <tr>
          <td style="width: 12%;">Revisi</td>
          <td style="width: 12%;">: 1</td>
      </tr>
      <tr>
          <td style="width: 12%;">Tanggal Revisi</td>
          <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
      </tr>
      <tr>
          <td colspan="2" style="border: none;">Risk Owner</td>
          <td style="border: none;">: <?= $parent[0]['name']; ?></td>
      </tr>
      <tr>
          <td colspan="2" style="border: none;">Risk Agent</td>
          <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
      </tr>
      <tr>
          <td colspan="8" style="padding-top: 20px; border: none;"></td>
      </tr>
    </thead>
  </table>
      <br>
    <?php if (isset($risk_distribution)): ?>
        <img style="width:80%;display: block; margin: 0 auto;" src="<?= base_url() . $risk_distribution; ?>" alt="Risk Distribution" />
    <?php endif; ?>
</div>

<div class="page-break"></div>

<div style="width: 100%; text-align: center;">
    <?php if (isset($risk_category)): ?>
      <table style="border-collapse: collapse; font-size: 12px;">
        <thead>
        <tr>
              <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                  <img src="<?= img_url('logo.png'); ?>" width="90">
              </td>
              <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                  <h4>GRAFIK RISK CATEGORIES</h4>
              </td>
              <td style="width: 12%;">No.</td>
              <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
          </tr>
          <tr>
              <td style="width: 12%;">Revisi</td>
              <td style="width: 12%;">: 1</td>
          </tr>
          <tr>
              <td style="width: 12%;">Tanggal Revisi</td>
              <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
          </tr>
          <tr>
              <td colspan="2" style="border: none;">Risk Owner</td>
              <td style="border: none;">: <?= $parent[0]['name']; ?></td>
          </tr>
          <tr>
              <td colspan="2" style="border: none;">Risk Agent</td>
              <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
          </tr>
          <tr>
          <td colspan="8" style="padding-top: 20px; border: none;"></td>
      </tr>
        </thead>
      </table>
        <img style="width:80%;display: block; margin: 0 auto;" src="<?= base_url() . $risk_category; ?>" alt="Risk Distribution" />
    <?php endif; ?>
</div>

<div class="page-break"></div>

<div style="width: 100%; text-align: center;">
    <?php if (isset($tasktonomi)): ?>
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
          <thead>
          <tr>
                <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                    <img src="<?= img_url('logo.png'); ?>" width="90">
                </td>
                <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                    <h4>GRAFIK TASKTONOMI</h4>
                </td>
                <td style="width: 12%;">No.</td>
                <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
            </tr>
            <tr>
                <td style="width: 12%;">Revisi</td>
                <td style="width: 12%;">: 1</td>
            </tr>
            <tr>
                <td style="width: 12%;">Tanggal Revisi</td>
                <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;">Risk Owner</td>
                <td style="border: none;">: <?= $parent[0]['name']; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;">Risk Agent</td>
                <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
            </tr>
          </thead>
        </table>
        <table>
          <thead>
              <tr>
                  <th style=" min-width: 50px;">No</th>
                  <th style="  min-width: 200px;">Sasaran</th>
                  <th style="  min-width: 200px;">T1</th>
                  <th style="  min-width: 200px;">T2</th>
                  <th style="  min-width: 200px;">T3</th>
              </tr>
              <?php
              // doi::dump($data);
              $no = 1;
              foreach ($tasktonomi as $d) {
              ?>
                  <tr>
                      <td style="text-align:center; background: white; min-width: 50px;"><?= $no++ ?></td>
                      <td style=" background: white; min-width: 150px;"><?= $d['sasaran'] ?></td>
                      <td style=" background: white; min-width: 150px;"><?= $d['tema_risiko'] ?></td>
                      <td style=" background: white; min-width: 150px;"><?= $d['t2'] ?></td>
                      <td style=" background: white; min-width: 150px;"><?= $d['data_t3'] ?></td>
                  </tr>
              <?php
              }
              ?>
          </thead>
      </table>

    <?php endif; ?>
</div>

<div class="page-break"></div>

<div style="width: 100%; text-align: center;">
    <?php if (isset($risk_efektifitas_control)): ?>
      <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <thead>
        <tr>
              <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
                  <img src="<?= img_url('logo.png'); ?>" width="90">
              </td>
              <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
                  <h4>GRAFIK EFEKTIFITAS CONTROL</h4>
              </td>
              <td style="width: 12%;">No.</td>
              <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
          </tr>
          <tr>
              <td style="width: 12%;">Revisi</td>
              <td style="width: 12%;">: 1</td>
          </tr>
          <tr>
              <td style="width: 12%;">Tanggal Revisi</td>
              <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
          </tr>
          <tr>
              <td colspan="2" style="border: none;">Risk Owner</td>
              <td style="border: none;">: <?= $parent[0]['name']; ?></td>
          </tr>
          <tr>
              <td colspan="2" style="border: none;">Risk Agent</td>
              <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
          </tr>
          <tr>
          <td colspan="8" style="padding-top: 20px; border: none;"></td>
      </tr>
        </thead>
      </table>
        <img style="width:80%;display: block; margin: 0 auto;" src="<?= base_url() . $risk_efektifitas_control; ?>" alt="Risk Distribution" />
    <?php endif; ?>
</div>

<div class="page-break"></div>

<div style="width: 100%; text-align: center;">
    <?php if (isset($risk_progress_treatment)): ?>
      <table style=" border-collapse: collapse; font-size: 12px;">
    <thead>
    <tr>
          <td colspan="2" rowspan="3" style="text-align: center; border-right: none;">
              <img src="<?= img_url('logo.png'); ?>" width="90">
          </td>
          <td colspan="4" rowspan="3" style="text-align: center; border-left: none; vertical-align: middle;">
              <h4>GRAFIK PROGRESS TREATMENT</h4>
          </td>
          <td style="width: 12%;">No.</td>
          <td style="width: 12%;">: 001/RM-FORM/I/<?= $parent[0]['periode_name']; ?></td>
      </tr>
      <tr>
          <td style="width: 12%;">Revisi</td>
          <td style="width: 12%;">: 1</td>
      </tr>
      <tr>
          <td style="width: 12%;">Tanggal Revisi</td>
          <td style="width: 12%;">: 31 Januari <?= $parent[0]['periode_name']; ?></td>
      </tr>
      <tr>
          <td colspan="2" style="border: none;">Risk Owner</td>
          <td style="border: none;">: <?= $parent[0]['name']; ?></td>
      </tr>
      <tr>
          <td colspan="2" style="border: none;">Risk Agent</td>
          <td style="border: none;">: <?= $parent[0]['officer_name']; ?></td>
      </tr>
      <tr>
          <td colspan="8" style="padding-top: 20px; border: none;"></td>
      </tr>
    </thead>
  </table>
        <img style="width:80%;display: block; margin: 0 auto;" src="<?= base_url() . $risk_progress_treatment; ?>" alt="Risk Distribution" />
    <?php endif; ?>
</div>
