
<?php
if($data){
  foreach ($data as $d) {
?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <!-- <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td> -->
        <td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle;"><h4>RISK CONTEXT</h4></td>
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

  <h5 style="font-weight: bolder;">A.Umum</h5>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 2% !important;vertical-align: middle !important;color:white;">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center; width:49%;color:white;">Area</th>
        <th colspan="4" style="background-color: #BFBFBF;text-align: center; width:49%;color:white;">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="3">Anggaran RKAP</td>
        <td colspan="4"><?= "Rp " . number_format($d['anggaran_rkap']); ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="3">Pemimpin Unit Kerja</td>
        <td colspan="4"><?= $d['owner_pic']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="3">Anggota Unit Kerja</td>
        <td colspan="4"><?= $d['anggota_pic']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="3">Tugas Pokok Dan Fungsi</td>
        <td colspan="4"><?= $d['tugas_pic']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="3">Pekerjaan Di Luar Tupoksi</td>
        <td colspan="4"><?= $d['tupoksi']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;vertical-align: middle !important;">6</td>
        <td colspan="3">Sasaran</td>
        <td colspan="4">
          <table>
          <?php
            $sasaran =$this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_SASARAN)->result_array();
            $no = 1;
            foreach ($sasaran as $s) {

          ?>  
            <tr>
            <td class="text-center" style="vertical-align: middle !important;"><?= $no++; ?>.</td>
            <td style="text-align: left;" valign="top" colspan=""><?= $s['sasaran']; ?></td>
            </tr>
            <?php
            }
          ?>
          </table>
        </td>
      </tr>
      
    </tbody>
  </table>
  

  <h5 style="font-weight: bolder;">B.Konteks Internal</h5>
  <table width="100%" class="table table-bordered">
    <tbody>
      <tr>
        <th style="background-color: #BFBFBF;text-align: center; width:2%;color:white;">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;  width:49%;color:white;">Area</th>
        <th colspan="4" style="background-color: #BFBFBF;text-align: center;  width:49%;color:white;">Konteks</th>
      </tr>
      <tr>
        <td style="text-align: center;">1</td>
        <td colspan="3">Man</td>
        <td colspan="4"><?= $d['man']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">2</td>
        <td colspan="3">Method</td>
        <td colspan="4"><?= $d['method']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">3</td>
        <td colspan="3">Machine</td>
        <td colspan="4"><?= $d['machine']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">4</td>
        <td colspan="3">Money</td>
        <td colspan="4"><?= $d['money']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">5</td>
        <td colspan="3">Material</td>
        <td colspan="4"><?= $d['material']; ?></td>
      </tr>
      <tr>
        <td style="text-align: center;">6</td>
        <td colspan="3">Market</td>
        <td colspan="4"><?= $d['market']; ?></td>
      </tr>
    </tbody>
  </table>

  <h5 style="font-weight: bolder;">C.Konteks Eksternal</h5>
  <table width="100%" class="table table-bordered">
    <tr>
      <th style="background-color: #BFBFBF;text-align: center; width:2%;color:white;">No</th>
      <th colspan="3" style="background-color: #BFBFBF;text-align: center; width:49%;color:white;">Area</th>
      <th colspan="4" style="background-color: #BFBFBF;text-align: center; width:49%;color:white;">Konteks</th>
    </tr>
    <tr>
      <td style="text-align: center;">1</td>
      <td colspan="3">Politics</td>
      <td colspan="4"><?= $d['politics']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">2</td>
      <td colspan="3">Economics</td>
      <td colspan="4"><?= $d['economics']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">3</td>
      <td colspan="3">Social</td>
      <td colspan="4"><?= $d['social']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">4</td>
      <td colspan="3">Tecnology</td>
      <td colspan="4"><?= $d['tecnology']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">5</td>
      <td colspan="3">Environment</td>
      <td colspan="4"><?= $d['environment']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center;">6</td>
      <td colspan="3">Legal</td>
      <td colspan="4"><?= $d['legal']; ?></td>
    </tr>
    </tbody>
  </table>

  <h5 style="font-weight: bolder;">D.Stakeholder Internal</h5>
  <table width="100%" class="table table-bordered">
      <tr>
        <th style="background-color: #BFBFBF;text-align: center;width: 2%;color:white;">No</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Stakeholder Internal</th>
        <th colspan="3" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Peran/Fungsi</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Komunikasi Yang dipilih</th>
        <th colspan="2" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Potensi Gangguan / Hambatan</th>
      </tr>
      <?php
      $stakholder_internal =$this->db->where('rcsa_no', $d['id'])->where('stakeholder_type', 1)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
      $no = 1;
      foreach ($stakholder_internal as $key => $rows1) {
       
      ?>
        <tr>
          <td style="text-align: center;"><?= $no++ ?></td>
          <td colspan="3"><?= $rows1['stakeholder']; ?></td>
          <td colspan="3"><?= $rows1['peran']; ?></td>
          <td colspan="2" valign="top"><?= $rows1['komunikasi']; ?></td>
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


  <h5 style="font-weight: bolder;">E.Stakeholder Eksternal</h5>
  <table width="100%" class="table table-bordered">
    <tbody>
    <tr>
      <th style="background-color: #BFBFBF;text-align: center;width: 2%;color:white;">No</th>
      <th colspan="3" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;" width="200px">Stakeholder Internal</th>
      <th colspan="3" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Peran/Fungsi</th>
      <th colspan="2" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Komunikasi Yang dipilih</th>
      <th colspan="2" style="background-color: #BFBFBF;text-align: center;color:white;width:24.5%;">Potensi Gangguan / Hambatan</th>
    </tr>
    <?php
    $no = 1;
		$stakeholder_eksternal = $this->db->where('rcsa_no', $d['id'])->where('stakeholder_type', 2)->get(_TBL_RCSA_STAKEHOLDER)->result_array();
    foreach ($stakeholder_eksternal as $key => $rows2) {
    ?>
      <tr>
        <td style="text-align: center;"><?= $no++ ?></td>
        <td colspan="3"><?= $rows2['stakeholder']; ?></td>
        <td colspan="3"><?= $rows2['peran']; ?></td>
        <td colspan="2"><?= $rows2['komunikasi']; ?></td>
        <td colspan="2"><?= $rows2['komunikasi']; ?></td>
      </tr>
    <?php
    }
    ?>
    </tbody>
  </table>
<?php
  }
}