
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

if($data){
  foreach ($data as $d) {
?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <!-- <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td> -->
        <td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle;"><h4>RISK EFEKTIFITAS CONTROL</h4></td>
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

  <table class="table table-bordered">
    <thead class="sticky-thead">
        <tr>
            <th rowspan="2" width="3%">No.</th>
            <th rowspan="2" width="20%" class="text-center">Business Process</th>
            <th colspan="6" width="75%" class="text-center">Metode & Control</th>
        </tr>
        <tr>
            <th width="19%" class="text-center">Existing Control</th>
            <th width="19%" class="text-center">Metode Pengujian</th>
            <th width="19%" class="text-center">Penilaian Internal Control</th>
            <th width="19%" class="text-center">Kelemahan Control</th>
            <th width="19%" class="text-center">Rencana Tindak Lanjut</th>
            <th width="2%" class="text-center">Dokumen</th>
        </tr>
    </thead>
    <tbody>
        <?php        
            $bisnis_proses = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCM)->result_array(); 
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
            $i = 0;
            
            foreach ($bisnis_proses as $key => $row): $i++; 
                $exiting_control = $this->db->where('rcm_id', $row['id'])->get(_TBL_EXISTING_CONTROL)->result_array();
        ?>
        
        <tr>

            <td style="text-align:center;"><?= $i; ?></td>

            <td>

                 <?= $row['bussines_process']; ?>
                
            </td>
            
            <td colspan="6">

                <table class="table table-borderless">    
                    <tbody>
                    <?php 
                        $j = 0;
                        foreach ($exiting_control as $ex): 
                            $j++; 
                        
                    ?>
                        <tr>
                            <td width="20%">
                                <?= $ex['component']; ?>
                            </td>

                            <td width="20%">
                                <?= $cboPengujian[$ex['metode_pengujian']]; ?>
                            </td>

                            <td width="20%">
                                <span style="font-size: 12px;background-color: <?= $comboColor[$ex['penilaian_intern_control']]; ?>;color:<?= ($comboColor[$ex['penilaian_intern_control']] == '#00712D' || $comboColor[$ex['penilaian_intern_control']] == '#B8001F') ? '#FFFFFF' : '#000000'; ?>;"><?= $cboPenilaian[$ex['penilaian_intern_control']]; ?></span>
                            </td>

                            <td width="20%">
                                <?= $ex['kelemahan_control']; ?>
                            </td>

                            <td width="8%">
                                <?= $ex['rencana_tindak_lanjut']; ?>
                            </td>

                            <td width="9.5%" style="vertical-align: middle; text-align: center;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px; width: 100%;">
                                    <?php $filePath = './themes/upload/crm/' . htmlspecialchars($ex['dokumen']); ?>
                                                                    
                                    <!-- Tombol Preview (Jika File Ada) -->
                                    <div style="display: flex; justify-content: center; width: 100%; gap: 10px;">
                                        <?php if (isset($ex['dokumen']) && file_exists($filePath)): ?>
                                            <!-- Preview Link -->
                                            <a href="<?= base_url('themes/upload/crm/'.$ex['dokumen']) ?>" target="_blank" class="btn btn-info btn-xs" style="text-align: center;">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

        
                            </td>


                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
  </table>
  

<?php
  }
}
?>