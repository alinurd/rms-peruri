<style type="text/css">
    ol{
padding: 10px;
}
</style>
<div class="table-responsive" >
    <strong>Link Risk Context</strong><br/>
    <table class="table table-bordered table-hover">
		<tbody>
			<tr><td width="20%">Sasaran</td><td><?=$data['sasaran'];?></td></tr>
			<tr><td>Peristiwa</td><td><?=$data['event_name'];?></td></tr>
			<tr><td>Penyebab</td><td><?=$data['couse'];?></td></tr>
			<tr><td>Dampak</td><td><?=$data['impact'];?></td></tr>
			<tr>
                <td>Existing Control</td>
                <?php 
                // $a = $data['control_no'];
        
                // $b = str_replace("\/",',', $a);
                // $b = str_replace("[",'', $b);
                // $b = str_replace("]",'', $b);
                // $b = explode(",", $b);
                // $hasil='';
                // $hasil.='<ol>';
                // foreach ($b as $key => $control) {
                //     $id = str_replace('"','', $control);
                //     if ($control == "") {
                //         $hasil.="";
                //     }else{
                //     $hasil.='<li>'.$id.'</li>';
                //     }
                // }
                // $hasil.='</ol>';
                    $arrCouse =json_decode($data['note_control'], true);
                    $name_control = implode('### ', $arrCouse);
                 ?>
                <!-- <td><?= $hasil; ?></td> -->
                 
                <td><?= format_list($name_control, "### "); ?></td>
            </tr>
            <!-- <tr><td>Note Control</td><td><?=$data['note_control'];?></td></tr> -->
			<tr><td>Risk Control Assessment</td><td><?=$data['risk_control'];?></td></tr>
			<tr><td>Risk Treatment</td><td><?=$data['treatment'];?></td></tr>
		</tbody>
	</table>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
            <!-- <tr>
                <th class="text-center" rowspan="2" width="2%">No</th>
                <th colspan="2">Mitigasi / Treatment</th>
                <th rowspan="2">Unit Penanggung Jawab</th>
                <th rowspan="2">Biaya</th>
                <th rowspan="2">Target Waktu</th>
            </tr>
            <tr>
                <th>Proaktif</th>
                <th>Reaktif</th>
            </tr> -->
            <tr>
                <th class="text-center" width="2%">No</th>
                <th>Mitigasi / Treatment</th>
                <th>Kategori</th>
                <th>Target Progress</th>
                <th>Treatment Lost</th>
                <th>Target Waktu</th>
                <th>Realisasi</th>
                <th>Damp Lost</th>
                <th>Tanggal Monitoring</th>
                <th>Keterangan</th>
            </tr>
        

        </thead>
		<tbody>
        <?php
$no = 0;
foreach ($mitigasi as $row):
    // Query untuk mendapatkan rows yang sesuai
    $rows = $this->db->where('id_rcsa_action', $row['id'])
                     ->order_by('bulan', 'ASC')  // Ganti 'bulan' dengan nama kolom yang sesuai
                     ->get(_TBL_RCSA_TREATMENT)
                     ->result_array();
                     
    // Looping untuk setiap row yang didapat dari query
    foreach ($rows as $sub_row):
        // Ambil periode berdasarkan period_no
        $periode = $this->db->select('periode_name')
                            ->where('id', $row['period_no'])
                            ->get(_TBL_PERIOD)
                            ->row_array(); // Menggunakan row_array() untuk mengambil 1 hasil sebagai array

        $realisasi = $this->db->select('progress_detail,target_progress_detail,create_date as tanggal_monitoring')->where('rcsa_action_no', $sub_row['id_rcsa_action'])->where('bulan', $sub_row['bulan'])
    ->get(_TBL_RCSA_MONITORING_TREATMENT)
    ->row_array();
        
        // Pastikan ada data periode
        $periode_name = isset($periode['periode_name']) ? $periode['periode_name'] : '-';
    ?>
        <tr>
            <td class="text-center"><?= ++$no; ?></td>
            <td>
                <?php
                // Menampilkan nilai proaktif atau reaktif berdasarkan kondisi
                if (!empty($row['proaktif'])) {
                    echo $row['proaktif'];
                } elseif (!empty($row['reaktif'])) {
                    echo $row['reaktif'];
                }
                ?>
            </td>

            <td>
                <?php
                // Menentukan jenis status: Proaktif, Reaktif, atau Keduanya
                if (!empty($row['proaktif']) && empty($row['reaktif'])) {
                    echo 'Proaktif';
                } elseif (!empty($row['reaktif']) && empty($row['proaktif'])) {
                    echo 'Reaktif';
                } elseif (!empty($row['proaktif']) && !empty($row['reaktif'])) {
                    echo 'Keduanya';
                } else {
                    echo '-';
                }
                ?>
            </td>

            <td><?= $sub_row['target_progress_detail']; ?></td>
            
            <?php 
            // Menampilkan nilai target_damp_loss jika ada
            $a = $sub_row['target_damp_loss'];
            if ($a == 0) : ?>
                <td></td>
            <?php else : ?> 
                <td>Rp. <?= number_format($a); ?> </td>  
            <?php endif ?>
            
            <td>
            <?php
                // Menampilkan tanggal terakhir bulan berdasarkan bulan yang ada di $sub_row
                setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');

                $tanggal_terakhir_bulan = '';
                if (!empty($sub_row['bulan'])) {
                    // Tentukan tahun yang sesuai dengan periode atau data yang ada
                    $tahun = $periode_name ? $periode_name : date('Y'); // Gunakan tahun yang ada atau default ke tahun sekarang
                    
                    // Dapatkan tanggal terakhir bulan menggunakan DateTime
                    $date = new DateTime();
                    $date->setDate($tahun, $sub_row['bulan'], 1);  // Set bulan dan tahun sesuai
                    $date->modify('last day of this month');  // Modify menjadi tanggal terakhir bulan tersebut
                    $tanggal_terakhir_bulan = $date->format('d/m/Y');  // Format tanggal
                }

                // Menampilkan tanggal terakhir bulan
                echo $tanggal_terakhir_bulan;
            ?>
            </td>
            <td><?= ($realisasi['progress_detail']) ? $realisasi['progress_detail'] : '<span class="text-danger">Data belum diinput</span>'; ?></td>
            <td><?= ($realisasi['target_progress_detail']) ? $realisasi['target_progress_detail'] : '<span class="text-danger">Data belum diinput</span>'; ?></td>
            <td><?= $realisasi['tanggal_monitoring']; ?></td>
            <td><?= ($sub_row['target_progress_detail'] == $realisasi['progress_detail'] && $sub_row['target_damp_loss'] == $realisasi['target_progress_detail']) ? '<span class="text-success">Sesuai</span>' : '<span class="text-danger">Tidak Sesuai</span>'; ?></td>
        </tr>
    <?php endforeach; endforeach; ?>

</tbody>

	</table>
    <br>
    
</div>
