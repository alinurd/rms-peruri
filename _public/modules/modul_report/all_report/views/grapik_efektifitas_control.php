
<div id="coba" style="display: flex; justify-content: center; align-items: center; height: 100%;"> 
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart_efektifitas"></canvas>
    <br/>&nbsp;<hr>
    <table class="table" width="100%">
        <thead>
            <tr>
                <th width="70%">Efektifitas Control</th>
                <th>Jumlah</th>
            </tr>
        <thead>
        <tbody>
            <?php
            foreach($master as $row):?>
            <tr>
                <td><?=$row['name']?></td>
                <td class="text-center"><?=$row['jml']?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
</div>
<?php
    $labels=[];
    $nils=[];
    $colors=[];
    foreach ($master as $key=>$row){
        $labels[]=$row['name'];
        $nils[]=$row['jml'];
        $colors[]=$row['color'];
    }
    $data['data'] = [
            'labels'=>$labels,
            'datasets'=>
            [
                [
                'label'=>'Top Score',
                'data'=> $nils,
                'backgroundColor'=> $colors,
                ]
            ]
            ];
    $data['judul']=['Risk Efektifitas Control', 'Periode - '.$periode_name];
    $data = json_encode($data);
    $option=['title'=>true, 'legend'=>true, 'position'=>'bottom', 'type'=>'pie'];
    $option=json_encode($option);
?>

<script>
    var data = <?=$data;?>;
    var option=<?=$option;?>;
    graph(data, 'mybarChart_efektifitas');
</script>