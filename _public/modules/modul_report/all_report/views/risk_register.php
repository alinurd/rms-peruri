
<?php
if($data){
  foreach ($data as $d) {
?>

  <table class="table table-bordered table-sm test" id="datatables_event" border="1">
    <thead>
    <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;">
                <?php
                    $relative_path = "themes/default/assets/images/logo.png";
                    if (file_exists($relative_path)) {
                        ?><img src="<?= $relative_path ?>" width="100"></td>
                    <?php
                    } else {
                        echo $relative_path.'<br>File does not exist.';
                    }

                ?>
                <td colspan="40" rowspan="6" style="text-align:center;border-left:none;">
                    <h1>RISK REGISTER</h1>
                </td>

                <td colspan="2" rowspan="2" style="text-align:left;">No.</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $d['periode_name']; ?></td>
            </tr>

            <tr>
                <td style="border: none;"></td>
            </tr>
            
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 1</td>
            </tr>

            <tr>
                <td style="border: none;"></td>
            </tr>

            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 31 Januari <?= $d['periode_name']; ?> </td>
            </tr>

            <tr>
                <td style="border: none;"></td>
            </tr>

            <tr>
                <td colspan="22" style="border: none;"></td>
            </tr>

            <tr>
                <td colspan="2" style="border: none;">Risk Owner</td>
                <td colspan="20" style="border: none;">: <?= $d['name']; ?></td>
            </tr>

            <tr>
                <td colspan="2" style="border: none;">Risk Agent</td>
                <td colspan="20" style="border: none;">: <?= $d['officer_name']; ?></td>
            </tr>

            <tr>
                <td colspan="22" style="border: none;"></td>
            </tr>
            <tr>
                <th rowspan="3">No</th>
                <th rowspan="3"><label class="w100">Sasaran (Objective)</label></th>
                <th rowspan="3"><label class="w100">Tema Risiko (Risk Theme) T1</label></th>
                <th rowspan="3"><label class="w100">Kategori Risiko (Risk Category) T2</label></th>
                <th rowspan="3"><label class="w100">Sub Kategori Risiko T3</label></th>
                <th rowspan="3"><label class="w100">Proses Bisnis (Business Process)</label></th>

                <th colspan="6"><label>Identifikasi Risiko (Risk Identification)</label></th>
                <th colspan="6"><label>Analisis Risiko Inheren (Inherent Risk Analysis)</label></th>
                <th colspan="5"><label>Evaluasi Risiko (Risk Evaluation)</label></th>
                <th colspan="6"><label>Analisis Risiko Saat Ini (Current Risk Analysis)</label></th>
                <th colspan="16"><label>Perlakuan Risiko (Risk Treatment)</label></th>
                <th rowspan="3"><label>Urgency</label></th>
            </tr>

            <tr>
                <th rowspan="2"><label class="w250">Peristiwa (Risk Event) T3</label></th>
                <th rowspan="2"><label class="w250">Penyebab (Risk Cause)</label></th>
                <th rowspan="2"><label class="w250">Dampak (Risk Impact)</label></th>
                <th rowspan="2"><label class="w250">Kategori Dampak (Impact Category)</label></th>
                <th rowspan="2"><label class="w250">Asumsi Perhitungan Dampak (Quantitative Impact Assumption)<label></th>
                <th rowspan="2"><label class="w250">PIC<label></th>

                <th colspan="2"><label>Dampak (Impact)</label></th>
                <th colspan="2"><label>Kemungkinan (Likelihood)</label></th>
                <th colspan="2"><label> Risk Level</label></th>

                <th rowspan="2"><label>Pengendalian saat ini (Existing Control)</label></th>
                <th rowspan="2"><label>Anggaran (Budget)</label></th>
                <th rowspan="2"><label>Kode Jasa (Code)</label></th>
                <th rowspan="2"><label>Penilaian Kontrol (Risk Control Assessment)</label></th>
                <th rowspan="2"><label>Opsi Perlakuan Risiko (Risk Treatment Option)</label></th>

                <th colspan="2"><label>Dampak (Impact)</label></th>
                <th colspan="2"><label>Kemungkinan (Likelihood)</label></th>
                <th colspan="2"><label> Risk Level</label></th>
                
                <th rowspan="3"><label class="w250">Program Perlakuan Risiko (Risk Treatment)</label></th>
                <th rowspan="3"><label>Kategori Treatment (Treatment Category)</label></th>
                <th colspan="12"><label> Timeline</label></th>
                <th rowspan="2"><label>Jumlah Biaya Perlakuan Risiko (Total Treatment Cost)</label></th>
                <th rowspan="2"><label>Pelaksana Perlakuan Risiko (Risk Treatment Owner)</label></th>
            </tr>

            <tr>
                <th><label class="w100">Skala</label></th>
                <th><label class="w100">Nilai</label></th>

                <th><label class="w100">Skala</label></th>
                <th><label class="w100">Nilai</label></th>

                <th><label class="w100">Level</label></th>
                <th><label class="w100">Exposure</label></th>

                <th><label class="w100">Skala</label></th>
                <th><label class="w100">Nilai</label></th>

                <th><label class="w100">Skala</label></th>
                <th><label class="w100">Nilai</label></th>

                <th><label class="w100">Level</label></th>
                <th><label class="w100">Exposure</label></th>

                <th><label class="w50">Jan</label></th> <!-- Januari -->
                <th><label class="w50">Feb</label></th> <!-- Februari -->
                <th><label class="w50">Mar</label></th> <!-- Maret -->
                <th><label class="w50">Apr</label></th> <!-- April -->
                <th><label class="w50">Mei</label></th> <!-- Mei -->
                <th><label class="w50">Jun</label></th> <!-- Juni -->
                <th><label class="w50">Jul</label></th> <!-- Juli -->
                <th><label class="w50">Agu</label></th> <!-- Agustus -->
                <th><label class="w50">Sep</label></th> <!-- September -->
                <th><label class="w50">Okt</label></th> <!-- Oktober -->
                <th><label class="w50">Nov</label></th> <!-- November -->
                <th><label class="w50">Des</label></th> <!-- Desember -->
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $groupedRows = array();
			$id_rcsa = $this->input->post('id');
			$owner_no = $this->input->post('owner_no');
			$field = $this->data->get_data_risk_register($d['id']);
			// $data['fieldxx'] = $this->data->get_data_risk_reg_acc($id_rcsa);
			// $data['tgl'] = $this->data->get_data_tanggal($id_rcsa);
			// $data['id_rcsa'] = $id_rcsa; 
			// $data['id'] = $id_rcsa;

			// $parent_no = $this->data->get_data_parent($owner_no);
			// $data['owner'] = $parent_no[0]['parent_no'];
			// $data['divisi'] = $this->data->get_data_divisi($parent_no);
			// $data['fields'] = $this->data->get_data_officer($id_rcsa);
			// $data['tipe'] = 'cetak';
			// $xx = array('field' => $data['field'], 'rcsa' => $data['id_rcsa']);
			// $this->session->set_userdata('result_risk_register', $xx);


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

                <tr style="background-color:#d5edef;">
                    <td colspan="47"><strong><?= strtoupper($sasaranKey); ?></strong></td>
                </tr>

            <?php foreach ($group as $row) : 
                $act        = $this->db
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
                            $treatments[]   = $item['proaktif']; // Tambahkan proaktif ke array
                            $kategori[]     = 'Proaktif'; // Tambahkan proaktif ke array
                            $d_id_action[]  = $item['id']; // Tambahkan ID ke array (gunakan [] untuk menambahkan)
                        } elseif (!empty($item['reaktif']) && empty($item['proaktif'])) {
                            $treatments[]   = $item['reaktif']; // Tambahkan reaktif ke array
                            $kategori[]     = 'Reaktif'; // Tambahkan reaktif ke array
                            $d_id_action[]  = $item['id']; // Tambahkan ID ke array
                        } else {
                            $treatments[]   = $item['proaktif']; // Atau bisa juga $item['reaktif'] jika ingin
                            $kategori[]     = 'Keduanya'; // Atau bisa juga $item['reaktif'] jika ingin
                            $d_id_action[]  = $item['id']; // Tambahkan ID ke array
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

?>
                <tr>
                    <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                    <td valign="top"><?= $row['sasaran']; ?> </td>
                    <td valign="top"><?= $row['tema_risiko']; ?> </td>
                    <td valign="top"><?= $tema['description']; ?></td>
                    <td valign="top"><?= $row['kategori']; ?></td>
                    <!-- <td valign="top"><?= ($row['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td> -->
                    <td valign="top"><?= $row['proses_bisnis']; ?></td>

                    <td valign="top"><?= $row['event_name']; ?></td>
                    <td valign="top"><?= format_list($row['couse'], "### "); ?></td>
                    <td valign="top"><?= format_list($row['impact'], "### "); ?></td>
                    <td valign="top"><?= $row['kategori_dampak']; ?></td> 
                    <td valign="top"><?= $row['risk_asumsi_perhitungan_dampak']; ?></td>
                    <td valign="top"><?= $pic['name']; ?></td>
                  
                    <td valign="top" style="text-align: center;"><?= $impactinherent['code'].' '.$impactinherent['level']; ?></td>
                    <td valign="top" style="text-align: left;">Rp.<?= number_format($row['nilai_in_impact']); ?></td>
                    <td valign="top" style="text-align: center;"><?= $likeinherent['code'].' '. $likeinherent['level'] ; ?></td>
                    <td valign="top" style="text-align: right;"><?= number_format($row['nilai_in_likelihood']); ?>%</td>
                    <td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= intval($likeinherent['code']) * intval($impactinherent['code']).' '.$inherent_level['level_mapping']; ?></td>
                    <td valign="top" style="text-align: left; ">Rp.<?= number_format($row['nilai_in_exposure']); ?></td>

                    <td valign="top"><?= format_list($row['control_name'], "### "); ?></td>
                    <td valign="top"><?= number_format($row['coa'],0,',','.') ?></td>
                    <td valign="top"><?= $row['kode_jasa']; ?></td>
                    <td valign="top"><?= $control_as['data']; ?></td>
                    <td valign="top"><?= $row['treatment']; ?></td>
                    
                    <td valign="top" style="text-align: center;"><?= $impact['code'].' '.$impact['level']; ?></td>
                    <td valign="top" style="text-align: left;">Rp.<?= number_format($row['nilai_res_impact']); ?></td>
                    <td valign="top" style="text-align: center;"><?= $like['code'].' '. $like['level'] ; ?></td>
                    <td valign="top" style="text-align: right;"><?= number_format($row['nilai_res_likelihood']); ?>%</td>
                    <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= intval($like['code']) * intval($impact['code']).' '.$residual_level['level_mapping']; ?></td>
                    <td valign="top" style="text-align: left; ">Rp.<?= number_format($row['nilai_res_exposure']); ?></td>
                    <td valign="top" width="100">
                        <?php if (!empty($treatments)): ?>
                            <table style="width: 100%; border-collapse: collapse;">
                                    <?php foreach ($treatments as $index => $treatment): ?>
                                        <tr>
                                            <td width="2%" style="border: none;"><?= $index + 1 .'.'; ?></td>
                                            <td style="border: none;"><?= $treatment; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </table>
                                <?php else: ?>
                            <?= '-';?>
                        <?php endif; ?>
                    </td>

                    <td valign="top" width="100">
                        <?php if (!empty($kategori)): ?>
                            <table style="width: 100%; border-collapse: collapse;">
                                <?php foreach ($kategori as $index => $kat): ?>
                                    <tr>
                                        <td style="border: none;"><?= $index + 1 .'.'; ?></td>
                                        <td style="border: none;"><?= $kat; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                                <?php else: ?>
                                <?= '-';?>
                        <?php endif; ?>
                    </td>
                    <?php 
                        for ($i = 1; $i <= 12; $i++) { 
                            
                    ?>
                        <td valign="top">
                            <?php if (!empty($d_id_action)): ?>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <?php foreach ($d_id_action as $index => $treat): 
                                        // Ambil data treatment berdasarkan id action dan bulan
                                        $data_treatment = $this->db->where('id_rcsa_action', $treat)
                                                                ->where('bulan', $i)  // Pastikan bulan adalah variabel yang tepat
                                                                ->get('bangga_rcsa_treatment')
                                                                ->row_array();  // Ambil satu baris data saja
                                        // Cek apakah bulan valid dan ambil tanggal terakhir bulan tersebut
                                        $tanggal_terakhir_bulan = '';
                                        if (!empty($i)) {
                                            // Dapatkan tanggal terakhir bulan menggunakan DateTime
                                            $date = new DateTime();
                                            $date->setDate(date('Y'), $i, 1);  // Set bulan dan tahun sesuai
                                            $date->modify('last day of this month');  // Modify menjadi tanggal terakhir bulan tersebut
                                            $tanggal_terakhir_bulan = $date->format('d/m/y');  // Format tanggal
                                        }
                                    ?>
                                        <tr>
                                            <td style="border: none;"><?= $index + 1 .'.'; ?></td>
                                            <td style="border: none;"><?= $tanggal_terakhir_bulan; ?></td>  <!-- Menampilkan tanggal terakhir bulan -->
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php else: ?>
                                <?= '-'; ?>
                            <?php endif; ?>
                        </td>

                    <?php
                        }
                    ?>
                    <td valign="top">
                        <?php 
                        if (!empty($d_id_action)): ?>
                            <table style="width: 100%; border-collapse: collapse;">
                                <?php foreach ($d_id_action as $index => $treat): 
                                    $data_treatment = $this->db->select('target_damp_loss')->where('id_rcsa_action', $treat)
                                                                ->get('bangga_rcsa_treatment')
                                                                ->result_array(); 
                                    $total_target_damp_loss = 0;
                                    foreach ($data_treatment as $j => $dt){
                                        $total_target_damp_loss += $data_treatment[$j]['target_damp_loss'];
                                    }
                                    
                                ?>
                                    <tr>
                                        <td style="border: none;"><?= $index + 1 .'.'; ?></td>
                                        <td style="border: none;"><?= !empty($total_target_damp_loss) ? number_format($total_target_damp_loss, 2) : '-'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <?= '-'; ?>
                        <?php endif; ?>
                    </td>

                    <?php
                    $control_as = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_rcsa_treatment')->row_array();
                    ?>
                    <?php
                    $owner_no = $row['owner_no'];

                    if ($owner_no !== null) {
                        $owners = ''; 
                        $Accountable = $this->db->where('id', $owner_no)->get('bangga_owner')->row_array();
                        $owners = $Accountable['name'];
                    } else {
                        $owners = '-';
                    }
                    ?>

                    <td valign="top"><?= $owners; ?></td>
                    <td valign="top"><?= $row['urgensi_no']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="22" style="border: none;">&nbsp;</th>
            </tr>
        </tbody>
    </table>
<?php
  }
}