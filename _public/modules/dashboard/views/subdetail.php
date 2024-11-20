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
                 ?>
                <!-- <td><?= $hasil; ?></td> -->
                <td><?=$data['note_control'];?></td>
            </tr>
            <tr><td>Note Control</td><td><?=$data['note_control'];?></td></tr>
			<tr><td>Risk Control Assessment</td><td><?=$data['risk_control'];?></td></tr>
			<tr><td>Risk Treatment</td><td><?=$data['treatment'];?></td></tr>
		</tbody>
	</table>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" rowspan="2" width="2%">No</th>
                <th colspan="2">Mitigasi / Treatment</th>
                <th rowspan="2">Unit Penanggung Jawab</th>
                <th rowspan="2">Biaya</th>
                <th rowspan="2">Target Waktu</th>
            </tr>
            <tr>
                <th>Proaktif</th>
                <th>Reaktif</th>
            </tr>
        </thead>
		<tbody>
            <?php
            $no=0;
            foreach($mitigasi as $row):?>
			<tr>
                <td class="text-center"><?=++$no;?></td>
                <td><?=$row['proaktif'];?></td>
                <td><?=$row['reaktif'];?></td>
                <td><?=$row['penanggung_jawab'];?></td>            
                <?php 
                $a = $row['amount'];
                if ($a == 0) : ?>
                   <td>  </td>
                <?php else : ?> 
                <td>Rp. <?=number_format($a);?> </span></td>  
                <?php endif ?>
                <td><?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');?><?=strftime("%d %B %Y", strtotime($row['target_waktu']));?></td>
         
            </tr>
            <?php
            endforeach;?>
        </tbody>
	</table>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" width="2%">No</th>
                <th>Treatment</th>
                <th>Realisasi</th>
                <th>Risk Level</th>
                <th class="text-center">Tanggal Monitoring</th>
                <th class="text-center">Short Report</th>
                <th>Keterangan</th>
            </tr>
        </thead>
		<tbody>
            <?php
            $no=0;
            foreach($realisasi as $row):?>
			<tr>
                <td class="text-center"><?=++$no;?></td>
                <td><?=$row['type_name'];?></td>
                <td><?=$row['realisasi'];?></td>
                <td style="background-color:<?=$row['warna_action'];?>;color:<?=$row['warna_text_action'];?>;"><?=$row['inherent_analisis_action'];?></td>
                <td class="text-center"><?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');?><?=strftime("%d %B %Y %H:%M", strtotime($row['create_date']));?></td>
               
                <td class="text-center">
                        <?php if ($row['status_no'] == 1) : ?>
                            <span style="background-color:blue;color:white;">&nbsp;Close &nbsp;</span>
                        <?php elseif ($row['status_no'] == 2) : ?>
                            <span style="background-color:blue;color:white;">&nbsp;On Progress &nbsp;</span>
                        <?php elseif ($row['status_no'] == 3) : ?>
                                <span style="background-color:red;color:white;">&nbsp;Add &nbsp;</span>
                         <?php else : ?>  
                            <span style="background-color:blue;color:white;">&nbsp;Open &nbsp;</span>
                        <?php endif ?>
                   </td>
                <td><?=$row['keterangan'];?></td>
            </tr>
            <?php
            endforeach;?>
        </tbody>
	</table>
</div>
