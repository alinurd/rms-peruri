<?php
        $kali=1;
    if ($post['level_no']==0){
        $kali=3;
    }elseif ($post['level_no']==1){
        $ket ='RISIKO AWAL [BK1]';
    }elseif ($post['level_no']==2){
        $ket ='RENCANA MITIGASI [BK2]';
    }elseif ($post['level_no']==3){
        $ket ='SETELAH MITIGASI [BK3]';
    }
    $jml1 = count($mapping);
    $jml2 = ($jml1*$kali)-1;
    for ($x=0;$x<$jml2;++$x){
        $total[$x]=0;
    }
?>
<br/>
<strong>KELOMPOK BISNIS : <?=$post['bisnis_text'];?></strong>
<br/>
<hr>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs " role="tablist">
        <li role="presentation" class="active">
            <a href="#tab_bk1" id="identifikasi" role="tab" data-toggle="tab" aria-expanded="true"> Rangking Risiko </a>
        </li>
        <li role="presentation" class="">
            <a href="#tab_bk2" role="tab" id="level" data-toggle="tab" aria-expanded="false"> Chart Rangking Risiko </a>
        </li>
        <li role="presentation" class="">
            <a href="#tab_bk3" role="tab" id="level" data-toggle="tab" aria-expanded="false"> Cost Rangking Risiko </a>
        </li>
        <li role="presentation" class="">
            <a href="#tab_bk4" role="tab" id="level" data-toggle="tab" aria-expanded="false"> Detail Realisasi Mitigasi </a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_bk1" aria-labelledby="home-tab">
            <table class="table table-bordered" width="85%" cellpadding="3" cellspacing="4">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th rowspan="3"  valign="middle" class="text-center" width="3%"><strong>No.</strong></th>
                        <th rowspan="3"  valign="middle" class="text-center" width="4%"><strong>KODE</strong></th>
                        <th rowspan="3"  valign="middle" class="text-center"><strong>KELOMPOK BISNIS</strong></th>
                        <th class="text-center" colspan="<?=$jml2+1;?>" ><strong>JUMLAH RISIKO</strong></th>
                    </tr>
                    <tr style="background-color:#f2f2f2;">
                        <?php
                        if ($post['level_no']==0):?>
                            <th class="text-center" colspan="<?=$jml1;?>"><strong>RISIKO AWAL [BK1]</strong></th>
                            <th class="text-center" colspan="<?=$jml1;?>"><strong>RENCANA MITIGASI [BK2]</strong></th>
                            <th class="text-center" colspan="<?=$jml1;?>"><strong>SETELAH MITIGASI [BK3]</strong></th>
                        <?php
                        else:?>
                            <th class="text-center" colspan="<?=$jml1;?>"><strong><?=$ket;?></strong></th>
                        <?php
                        endif;?>
                    </tr>
                    <tr style="background-color:#f2f2f2;">
                        <?php
                        if ($post['level_no']==0){
                            foreach ($mapping as $row):?>
                            <th class="text-center" width="4%"><?=$row;?></th>
                            <?php endforeach;
                            foreach ($mapping as $row):?>
                            <th class="text-center" width="4%"><?=$row;?></th>
                            <?php endforeach;
                            foreach ($mapping as $row):?>
                            <th class="text-center" width="4%"><?=$row;?></th>
                            <?php endforeach;
                        }else{
                            foreach ($mapping as $row):?>
                            <th class="text-center" width="4%"><?=$row;?></th>
                            <?php endforeach;
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nourut=0;
                    if ($post['level_no']==0){
                        foreach($master as $key=>$rows):
                            $no=0;
                            ?>
                        <tr>
                            <td><?=++$nourut;?></td>
                            <td class="text-center"><?=$rows['code'];?></td>
                            <td><?=$rows['nama'];?></td>
                            <?php
                            $no=-1;
                            
                            $nil1='';
                            $nil2='';
                            $nil3='';
                            $nil4='';
                            $color='';
                            if (array_key_exists($key, $awal)){
                                $nil1=number_format($awal[$key][0],2);
                                $nil2=number_format($awal[$key][1],2);
                                $nil3=number_format($awal[$key][2],2);
                                $nil4=($awal[$key][3])?substr($awal[$key][3]['level_mapping'],0,1):'';
                                $color=($awal[$key][3])?'background-color:'.$awal[$key][3]['color'].';color:'.$awal[$key][3]['color_text']:'';
                            }
                            ?>
                            <td class="text-center"><?=$nil1;?></td>
                            <td class="text-center"><?=$nil2;?></td>
                            <td class="text-center"><?=$nil3;?></td>
                            <td class="text-center" style="<?=$color;?>"><?=$nil4;?></td>
                            <?php
                            $nil1='';
                            $nil2='';
                            $nil3='';
                            $nil4='';
                            $color='';
                            if (array_key_exists($key, $before)){
                                $nil1=number_format($before[$key][0],2);
                                $nil2=number_format($before[$key][1],2);
                                $nil3=number_format($before[$key][2],2);
                                $nil4=($before[$key][3])?substr($before[$key][3]['level_mapping'],0,1):'';
                                $color=($before[$key][3])?'background-color:'.$before[$key][3]['color'].';color:'.$before[$key][3]['color_text']:'';
                            }
                            ?>
                            <td class="text-center"><?=$nil1;?></td>
                            <td class="text-center"><?=$nil2;?></td>
                            <td class="text-center"><?=$nil3;?></td>
                            <td class="text-center" style="<?=$color;?>"><?=$nil4;?></td>
                            <?php
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
                        <?php endforeach;
                    }else{
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
                        <?php endforeach;
                    }
                        ?>
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_bk2" aria-labelledby="home-tab">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_content">
                    <canvas id="mybarChart"></canvas>
                </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_bk3" aria-labelledby="home-tab">
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
        </div>
        <div role="tabpanel" class="tab-pane fade" id="tab_bk4" aria-labelledby="home-tab">
            <div class="x_panel">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <a class="btn btn-primary" href="<?=base_url('lap-toprisk/cetak-excel');?>" target="_blank"> Export to Excel</a><br/>
                    <table class="table table-bordered">
                        <thead>
                            <th width="4%">No</th>
                            <th>Jenis Risiko</th>
                            <th>Owner Name</th>
                            <th width="4%">No</th>
                            <th>Nama Risiko</th>
                            <th width="4%">No</th>
                            <th>Realisasi Mitigasi</th>
                            <th>Level [K/D]</th>
                            <th>Tingkat Eksposur</th>
                        </thead>
                        <tbody>
                            <?php
                            $nama_tmp='';
                            $event_tmp='';
                            $no=0;
                            $no1=0;
                            $no2=0;
                            $nil_bg=0;
                            foreach($event as $row):
                            ?>
                                <?php
                                $rowspan='';
                                if (intval($master[$row['risiko_no']][4])>0){
                                    $rowspan=' rowspan="'.$master[$row['risiko_no']][4].'"';
                                }
                                $nama_risiko_tmp='';
                                $owner_name='';
                                $bg='';
                                $bg='bg-info';
                                if ($row['risiko_no']!==$nama_tmp):
                                    $nama_tmp=$row['risiko_no'];
                                    $nama_risiko_tmp=$row['nama'];
                                    $owner_name=$row['owner_name'];
                                    $no2=0;
                                    $no=0;
                                    ++$nil_bg;
                                    ?>
                                <?php endif;
                                $nama_event_tmp='';
                                $nama_event_tmp=$row['event_name']. ' ['.$row['score_kemungkinan'].'/'.$row['score_dampak'].' ]';
                                if ($row['risk_event_no']!==$event_tmp):
                                    $event_tmp=$row['risk_event_no'];
                                    // $nama_event_tmp=$row['event_name']. ' ['.$row['score_kemungkinan'].'/'.$row['score_dampak'].' ]';
                                    // $no=0
                                    ?>
                                <?php endif; 
                                 if ($nil_bg%2==1)
                                    $bg='bg-info';
                                else
                                    $bg='';
                                ?>
                                <tr class="<?=$bg;?>">
                                    <td class='text-center'><?=(!empty($nama_risiko_tmp))?++$no1:'';?></td>
                                    <td><?=$nama_risiko_tmp;?></td>
                                    <td><?=$row['owner_name'];?></td>
                                    <td class='text-center'><?=(!empty($nama_event_tmp))?++$no2:'';?></td>
                                    <td><?=$nama_event_tmp;?></td>
                                    <td class='text-center'><?=++$no;?></td>
                                    <td><?=$row['realisasi_mitigasi'];?></td>
                                    <td class='text-center'><?=' ['.$row['score_kemungkinan'].'/'.$row['score_dampak'].' ]';?></td>
                                <?php
                                if(array_key_exists($row['risiko_no'], $master)):
                                ?>
                                    <td class='text-center' style=<?=(!empty($nama_risiko_tmp))?($master[$row['risiko_no']][3])?'background-color:'.$master[$row['risiko_no']][3]['color'].';color:'.$master[$row['risiko_no']][3]['color_text']:'':'';?>>
                                        <?=($master[$row['risiko_no']][3])?substr($master[$row['risiko_no']][3]['level_mapping'],0,1):'';?>
                                    </td>
                                <?php
                                endif;?>
                                </tr>
                            <?php
                            endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
