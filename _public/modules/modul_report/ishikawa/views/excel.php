
<table class="table table-bordered" border='1'>
    <thead>
        <th width="4%">No</th>
        <th>Owner Name</th>
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
            if ($row['risk_event_no']!==$event_tmp):
                $event_tmp=$row['risk_event_no'];
                $nama_event_tmp=$row['event_name'];
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
                <td><?=$owner_name;?></td>
                <td><?=$nama_risiko_tmp;?></td>
                <td class='text-center'><?=(!empty($nama_event_tmp))?++$no2:'';?></td>
                <td ><?=$nama_event_tmp;?></td>
                <td class='text-center'><?=++$no;?></td>
                <td><?=$row['realisasi_mitigasi'];?></td>
            <?php
            if(array_key_exists($row['risiko_no'], $master)):
            ?>
                <td class='text-center' style=<?=(!empty($nama_risiko_tmp))?($master[$row['risiko_no']][3])?'background-color:'.$master[$row['risiko_no']][3]['color'].';color:'.$master[$row['risiko_no']][3]['color_text']:'':'';?>><?=(!empty($nama_risiko_tmp))?($master[$row['risiko_no']][3])?substr($master[$row['risiko_no']][3]['level_mapping'],0,1):'':'';?></td>
            <?php
            endif;?>
            </tr>
        <?php
        endforeach?>
    </tbody>
</table>