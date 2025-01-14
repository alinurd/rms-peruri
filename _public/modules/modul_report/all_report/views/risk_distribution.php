
<div id="coba"> 
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart"></canvas>
    <center>Grafik Saat Menilai Level Risiko </center>
    <br/>&nbsp;<hr>
    <table class="table table_grafik" width="90%">
        <thead>
            <tr>
                <th width="70%">Level Risiko</th>
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
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart2"></canvas>
    <center>Grafik Risiko Perbulan terhadap Progress Treatment</center>
    <br/>&nbsp;<hr>
    <table class="table table_grafik" width="90%">
        <thead>
            <tr>
                <th width="70%">Level Risiko</th>
                <th>Jumlah</th>
            </tr>
        <thead>
        <tbody>
            <?php

            foreach($master2 as $row):?>
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
    $data['judul']=['Risk Distribution', 'Periode - '.$periode_name];
    $data = json_encode($data);

    $labels=[];
    $nils=[];
    $colors=[];
    foreach ($master2 as $key=>$row){
        $labels[]=$row['name'];
        $nils[]=$row['jml'];
        $colors[]=$row['color'];
    }
    $data2['data'] = [
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
    $data2['judul']=['Risk Distribution', 'Periode - '.$periode_name];
    $data2 = json_encode($data2);

    $option=['title'=>true, 'legend'=>true, 'position'=>'bottom', 'type'=>'doughnut'];
    $option=json_encode($option);
?>

<script>
    var data = <?=$data;?>;
    var data2 = <?=$data2;?>;
    var option=<?=$option;?>;
    graph (data, 'mybarChart');
    graph (data2, 'mybarChart2');
</script>