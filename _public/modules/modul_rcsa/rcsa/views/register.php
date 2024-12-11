<style>
	.double-scroll {
		width: 100%;
	}

	thead th,
	tfoot th {
		font-size: 12px;
		padding: 5px !important;
		text-align: center;
	}

	.w250 {
		width: 250px;
	}

	.w150 {
		width: 150px;
	}

	.w100 {
		width: 100px;
	}

	.w80 {
		width: 80px;
	}

	.w50 {
		width: 50px;
	}

	td ol {
		padding-left: 10px;
		width: 300px;
	}

	td ol li {
		margin-left: 5px;
	}
</style>

<?php echo form_open(base_url('rcsa/simpan-propose'), array('id' => 'form_input_library', 'role' => 'form"'), ['id_rcsa' => $id_rcsa]); ?>
<?php
if ($status) : ?>
	<div class="well well-sm text-centre text-danger" style="font-size:18px;">
		<?= $field; ?>
	</div>
<?php else : ?>
	<table class="table table-bordered  ">
		<tr style="background:#0B2161 !important; color: white">
			<td colspan="3">
				<h4><b>Log Approval</b></h4>
			</td>
		</tr>
		<tr style="background:#0B2161 !important; color: white">
			<?php
			$user = $this->db->where('id', $field[0]['owner_no'])->get('bangga_owner')->row_array();

			//reviwer
			// $officer1 = $this->db->where('owner_no', 1435)->get('bangga_officer')->row_array();
			$own_rev = $this->db->where('id', 1435)->get('bangga_owner')->row_array();

			$off_rev = $this->db->where('owner_no', $own_rev['id'])->get('bangga_officer')->result_array();



			// $group = $this->db
			// ->select('bangga_groups.group_name, bangga_group_user.*')
			// ->from('bangga_group_user')
			// ->join('bangga_groups', 'bangga_group_user.group_no = bangga_groups.id')
			// ->where('bangga_group_user.user_no', $x['user_no'])
			// // ->where('bangga_group_user.group_no', 1)
			// ->get()
			// ->row_array()
			?>


			<!-- inisiator -->
			<td width="33%">
				<span><b>Inisiator:</b></span><br>
				<span> <?= $user['name'] ?><br><br>
				</span>
				<span><b>Petugas:</b></span><br>
				<span> by: </span> <br>
				<span>
					<?php
					$no = 1;
					$createdUsers = array();
					foreach ($field as $rowxx) {
						$created = $this->db
							->where('id', $rowxx['id_rcsa_detail'])
							->get('bangga_rcsa_detail')
							->row_array();
						$createUser = $created['create_user'];
						if (!in_array($createUser, $createdUsers)) {
							$createdUsers[] = $createUser; // Tambahkan create_user ke array
					?>
							-<span><?= $createUser ?></span><br>
					<?php
						}
					}
					?>
					<span> -<?= $submiter = $this->authentication->get_info_user('username'); ?> (Inisiator)</span>
				</span>
			</td>


			<td width="33%">
				<span><b>Reviewer:</b></span><br>
				<span> <?= $own_rev['name'] ?><br><br>
				</span>
				<span><b>Petugas:</b></span><br>
				<span> by: <br>
					<?php
					foreach ($off_rev as $dt) {
						// cari user yang grup nya 1 => admin aplikasi
						$group = $this->db
							->where('user_no', $dt['user_no'])
							->where('group_no', 1)
							->get('bangga_group_user')
							->row_array();

						if (!empty($group) && array_key_exists('group_no', $group)) {
							$resoff_rev = $this->db->where('user_no', $group['user_no'])->get('bangga_officer')->row_array();
							$resgrup_rev = $this->db->where('id', $group['group_no'])->get('bangga_groups')->row_array();
					?>

							-<?= $resoff_rev['officer_name'] ?> (<?= $resgrup_rev['group_name'] ?>) <br>

					<?php
						}
					}
					?>
				</span>

			</td>
			<td width="33%">
				<span><b>Approve:</b></span><br>

				<span> Risk Owner <br><?= form_dropdown('approve_owner', $cbo_owner, '',  'class="select2 form-control" style="width:100%;" id="approve_owner"' . $readonly); ?> </span><br><br>
				<span><b>Petugas:</b></span><br>
				<span class="usergas"><i>Pilih owner terlebih dahulu</i></span><br>
				<span class="approve_userrrr"> User <br><?= form_dropdown('approve_user', $cbo_user, '', 'class="select2 form-control " style="width:100%;" id="approve_user"' . $readonly); ?> </span><br>
				<br>
			</td>
		</tr>
	</table>
	<div class="col-12 hide" style="overflow-x: auto">
		<table class="table table-bordered table-sm table-top-ten hide" id="datatables_event">
			<thead>
				<tr>
					<th rowspan="2">Nox</th>
					<th rowspan="2">Unselect</th>
					<th rowspan="2"><label class="w150">Area</label></th>
					<th rowspan="2"><label>Kategori</label></th>
					<th rowspan="2"><label>Sub Kategori</label></th>
					<th rowspan="2"><label class="w250">Risiko</label></th>
					<th rowspan="2"><label class="w250">Penyebab</label></th>
					<th rowspan="2"><label class="w250">Dampak Kualitatif</label></th>
					<th rowspan="2"><label class="w250">Dampak Kuantitatif</label></th>
					<th rowspan="2"><label>Urgency</label></th>
					<th rowspan="1" colspan="6"><label>Analisis</label></th>
					<th rowspan="1" colspan="3"><label>Evaluasi</label></th>
					<th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
					<th rowspan="2"><label class="w100">Accountable Unit</label></th>
					<th rowspan="2"><label class="w80">Sumber Daya</label></th>
					<th rowspan="2"><label class="w80">Deadline</label></th>
				</tr>
				<tr>
					<th colspan="2">Probabilitas</th>
					<th colspan="2">Impact</th>
					<th colspan="2">Risk Level</th>
					<th><label class="w150">PIC</label></th>
					<th>Existing Control</th>
					<th>Risk Control<br>Assessment</th>
					<th><label class="w150">Proaktif</label></th>
					<th><label class="w150">Reaktif</label></th>
				</tr>
			</thead>
			<tbody id="risk-top-ten">

			</tbody>
			<tfoot>
				<tr>
					<th colspan=22>&nbsp;</th>
				</tr>
			</tfoot>
		</table>
	</div>

	<table class="table table-bordered">
		<tr style="background:#0B2161 !important; color: white">
			<td colspan="22">
				<h4><b>Risk Register</b></h4>
			</td>
			<td>
				<button class="btn btn-sm btn-info disabled simpangas pull-right" style="right:10px; top:13px;">PROPOSE</button>
				<button class="btn btn-sm btn-info simpan_propose pull-right" style="right:10px; top:13px;">PROPOSE</button>
			</td>
		</tr>
		<tr>
			<td colspan="23">
				Catatan<br />
				<?= form_textarea('note', '', " id='note' maxlength='1000' size=1000  class='form-control ' rows='5' cols='5' style='overflow: hidden; width: 1000 !important; height: 104px;' "); ?>
			</td>
		</tr>
	</table>

	<div class="double-scroll" style='height:550px;'>
	<table class="table table-bordered table-sm test" id="datatables_event" border="1">
    <thead>
            

            <tr>
                <th rowspan="3">No</th>
                <th rowspan="3"><label class="w100">Sasaran (Objective)</label></th>
                <th rowspan="3"><label class="w100">Tema Risiko (Risk Theme) T1</label></th>
                <th rowspan="3"><label class="w100">Kategori Risiko (Risk Category) T2</label></th>
                <th rowspan="3"><label class="w100">Sub Kategori Risiko</label></th>
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
                    <td valign="top"><?= $tema['description']; ?></td>
                    <td valign="top"><?= $row['kategori']; ?></td>
                    <td valign="top"><?= ($row['subrisiko'] == 1) ? 'negatif' : 'positif' ?></td>
                    <td valign="top"><?= $row['proses_bisnis']; ?></td>

                    <td valign="top"><?= $row['event_name']; ?></td>
                    <td valign="top"><?= format_list($row['couse'], "### "); ?></td>
                    <td valign="top"><?= format_list($row['impact'], "### "); ?></td>
                    <td valign="top"><?= $row['kategori_dampak']; ?></td> 
                    <td valign="top"><?= $row['risk_asumsi_perhitungan_dampak']; ?></td>
                    <td valign="top"><?= $pic['name']; ?></td>
                  
                    <td valign="top" style="text-align: center;"><?= $impactinherent['code'].' '.$impactinherent['level']; ?></td>
                    <td valign="top" style="text-align: left;"><?= 'Rp.....'; ?></td>
                    <td valign="top" style="text-align: center;"><?= $likeinherent['code'].' '. $likeinherent['level'] ; ?></td>
                    <td valign="top" style="text-align: right;"><?=  '.....%'; ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;"><?= intval($likeinherent['code']) * intval($impactinherent['code']).' '.$inherent_level['level_mapping']; ?></td>
                    <td valign="top" style="text-align: left; "><?= 'Rp....'; ?></td>

                    <td valign="top"><?= format_list($row['control_name'], "### "); ?></td>
                    <td valign="top"><?= number_format($row['anggaran'],0,',','.') ?></td>
                    <td valign="top"><?= $row['kode_jasa']; ?></td>
                    <td valign="top"><?= $control_as['data']; ?></td>
                    <td valign="top"><?= $row['treatment']; ?></td>
                    
                    <td valign="top" style="text-align: center;"><?= $impact['code'].' '.$impact['level']; ?></td>
                    <td valign="top" style="text-align: left;"><?= 'Rp.....'; ?></td>
                    <td valign="top" style="text-align: center;"><?= $like['code'].' '. $like['level'] ; ?></td>
                    <td valign="top" style="text-align: right;"><?=  '.....%'; ?></td>
                    <td valign="top" style="text-align: center; background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;"><?= intval($like['code']) * intval($impact['code']).' '.$residual_level['level_mapping']; ?></td>
                    <td valign="top" style="text-align: left; "><?= 'Rp....'; ?></td>
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
            <tr>
            <?php if ($tgl == NULL) : ?>
                <th colspan="43" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
            <?php else : ?>
                <th colspan="43" style="text-align: center;border: none;font-size: 20px;font-style: normal;">
                    Dokumen ini telah disahkan oleh Kepala Divisi
                    <?php if ($divisi == NULL) {
                        echo $row1['name'];
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
        </tbody>
    </table>
	</div>

<?php endif;
echo form_close();
?>
<script type="text/javascript">
	var note = '<?php echo $note; ?>';
	$(document).ready(function() {
		var parent = $(this).parent();
		var nilai = $("#approve_owner").val();
		if (!nilai) {
			nilai = 0;
		}
		var data = {
			'id': nilai,
			'kelompok': 'approve_owner'
		};
		var usergas = $(".usergas");
		var approve_user = $(".approve_userrrr");

		var btnSimpan = $(".simpan_propose"); // Select the button with class "simpan_propose"
		var simpangas = $(".simpangas"); // Select the button with class "simpan_propose"

		btnSimpan.hide(); // Hide the button
		approve_user.hide(); // Hide the button
		$("#approve_owner").change(function() {
			approve_user.show(); // Show the button
			usergas.hide(); // Show the button

			var parent = 0;
			var nilai = $(this).val();
			if (!nilai) {
				nilai = 0;
			}
			var data = {
				'id': nilai,
				'kelompok': 'approve_owner'
			};
			btnSimpan.hide(); // Hide the button

			var target_combo = $("#approve_user");
			var url = "ajax/get_approve_owner";
			cari_ajax_combo("post", parent, data, target_combo, url);
		})


		$("#approve_user").change(function() {
			var nilai = $(this).val();
			console.log(nilai);

			if (nilai > 0) {
				btnSimpan.show(); // Show the button
				simpangas.hide(); // Hide the button
			} else {
				simpangas.show(); // Show the button
				btnSimpan.hide(); // Hide the button
			}
		});



		$('.double-scroll').doubleScroll({
			resetOnWindowResize: true,
			scrollCss: {
				'overflow-x': 'auto',
				'overflow-y': 'auto'
			},
			contentCss: {
				'overflow-x': 'auto',
				'overflow-y': 'auto'
			},
		});
		$(window).resize();
		$('#note').text(note);
	});
	var arr_row = [];
	var total_row = <?php echo count($field); ?>;

	for (var i = 0; i < total_row; i++) {
		arr_row[i] = i;
	}
</script>