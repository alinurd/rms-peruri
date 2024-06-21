<?php
    $jml1 = count($mapping);
    $jml2 = ($jml1)-1;
    for ($x=0;$x<$jml2;++$x){
        $total[$x]=0;
    }

?>
<br/>
<strong>KELOMPOK BISNIS : <?=$post['bisnis_text'];?></strong>
<br/>
<table class="table table-bordered" width="85%" cellpadding="3" cellspacing="4">
    <tr style="background-color:#f2f2f2;">
        <td rowspan="3"  valign="middle" class="text-center" width="3%"><strong>No.</strong></td>
        <td rowspan="3"  valign="middle" class="text-center" width="4%"><strong>KODE</strong></td>
        <td rowspan="3"  valign="middle" class="text-center"><strong>KELOMPOK BISNIS</strong></td>
        <td class="text-center" colspan="<?=$jml2+1;?>" ><strong>JUMLAH RISIKO</strong></td>
    </tr>
    <tr style="background-color:#f2f2f2;">
        <td class="text-center" colspan="<?=$jml1;?>"><strong>SETELAH MITIGASI [BK3]</strong></td>
    </tr>
    <tr style="background-color:#f2f2f2;">
        <?php
        foreach ($mapping as $row):?>
        <td class="text-center" width="4%"><?=$row;?></td>
        <?php endforeach;?>
    </tr>
    <?php
    $nourut=0;
    foreach($master as $key=>$rows):
        $no=0;
        ?>
    <tr>
        <td><?=++$nourut;?></td>
        <td class="text-center"><?=$rows['code'];?></td>
        <td><?=$rows['nama'];?></td>
        <?php
        $no=-1;

        $nil1=number_format($rows[0],2);
        $nil2=number_format($rows[1],2);
        $nil3=number_format($rows[2],2);
        $nil4=($rows[3])?substr($rows[3]['level_mapping'],0,1):'';
        $color=($rows[3])?'background-color:'.$rows[3]['color'].';color:'.$rows[3]['color_text']:'';

        ?>
        <td class="text-center"><?=$nil1;?></td>
        <td class="text-center"><?=$nil2;?></td>
        <td class="text-center"><?=$nil3;?></td>
        <td class="text-center" style="<?=$color;?>"><?=$nil4;?></td>
    </tr>
    <?php endforeach;?>
</table>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <canvas id="mybarChart"></canvas>
    </div>
    </div>
</div>

<div class="x_panel">
    <div class="x_content">
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2" colspan="2">Keterangan</th>
                    <th class="text-center" colspan="<?=$post['limit_no'];?>">TOP <?=$post['limit_no'];?> RISK<br/>KELOMPOK BISNIS : <?=strtoupper($post['bisnis_text']);?></th>
                </tr>
                <tr>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <th class="text-center"><?=$rows['code'];?></th>
                    <?php endforeach;?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>TOTAL COST (biaya mitigasi)</td><td class="text-center" width="3%">[A]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td width="10%" class="text-right"><?=number_format(floatval($angka['A'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <td>RISIKO SEBELUM MITIGASI</td><td class="text-center" width="3%">[B]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td class="text-right"><?=number_format(floatval($angka['B'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <td>RISIKO SETELAH MITIGASI</td><td class="text-center" width="3%">[C]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td class="text-right"><?=number_format(floatval($angka['C'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <td>TOTAL BENEFIT D=B-C</td><td class="text-center" width="3%">[D]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td class="text-right"><?=number_format(floatval($angka['D'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <td>BENEFIT COST E=D/A</td><td class="text-center" width="3%">[E]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td class="text-right"><?=number_format(floatval($angka['E'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
                <tr>
                    <td>NET BENEFIT E=D-A</td><td class="text-center" width="3%">[F]</td>
                    <?php
                    foreach($master as $key=>$rows):?>
                    <td class="text-right"><?=number_format(floatval($angka['F'][$key]));?></td>
                    <?php endforeach;?>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <table class="table">
            <thead>
                <th width="4%">No</th>
                <th>Jenis Risiko</th>
                <th width="4%">No</th>
                <th>Nama Risiko</th>
                <th width="4%">No</th>
                <th>Realisasi Mitigasi</th>
                <th>Tingkat Eksposur</th>
            </thead>
            <tbody>
                <?php
                $nama_tmp='';
                $event_tmp='';
                $no=0;
                $no1=0;
                $no2=0;
                foreach($event as $row):?>
                    <tr>
                    <?php
                    $rowspan='';
                    if (intval($master[$row['risk_type_no']][4])>0){
                        $rowspan=' rowspan="'.$master[$row['risk_type_no']][4].'"';
                    }
                    $nama_risiko_tmp='';
                    if ($row['risk_type_no']!==$nama_tmp):
                        $nama_tmp=$row['risk_type_no'];
                        $nama_risiko_tmp=$row['nama'];
                        //$no1=0;
                    ?>
                    <?php endif;
                    $nama_event_tmp='';
                    if ($row['risk_event_no']!==$event_tmp):
                        $event_tmp=$row['risk_event_no'];
                        $nama_event_tmp=$row['event_name'];
                        //$no2=0
                    ?>
                    <?php endif; ?>
                        <td class='text-center'><?=(!empty($nama_risiko_tmp))?++$no1:'';?></td>
                        <td><?=$nama_risiko_tmp;?></td>
                        <td class='text-center'><?=(!empty($nama_event_tmp))?++$no2:'';?></td>
                        <td ><?=$nama_event_tmp;?></td>
                        <td class='text-center'><?=++$no;?></td>
                        <td><?=$row['rencana_mitigasi'];?></td>
                    <?php
                    if(array_key_exists($row['risk_type_no'], $master)):
                    ?>
                        <td class='text-center' style=<?=(!empty($nama_risiko_tmp))?($master[$row['risk_type_no']][3])?'background-color:'.$master[$row['risk_type_no']][3]['color'].';color:'.$master[$row['risk_type_no']][3]['color_text']:'':'';?>><?=(!empty($nama_risiko_tmp))?($master[$row['risk_type_no']][3])?substr($master[$row['risk_type_no']][3]['level_mapping'],0,1):'':'';?></td>
                    <?php
                    endif;?>
                    </tr>
                <?php
                endforeach?>
            </tbody>
        </table>
    </div>
</div>

<?php
    $labels=[];
    $nils=[];
    foreach ($master as $key=>$row){
        $labels[]=$row['code'];
        $nils[]=$row[2];
    }
    $data['data'] = [
            'labels'=>$labels,
            'datasets'=>
            [
                [
                'label'=>'Top Score',
                'backgroundColor'=>"#26B99A",
                'data'=> $nils
                ]
            ]
            ];
    $data['judul']=['TOP '.$post['limit_no'].' KELOMPOK BISNIS', 'KELOMPOK : '.strtoupper($post['bisnis_text'])];
    $data = json_encode($data);
?>

<script>
    var data = <?=$data;?>;
    graph (data);
</script>
