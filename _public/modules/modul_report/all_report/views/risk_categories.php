

<div id="coba"> 
<div class="col-md-12 col-sm-6 col-xs-6">
    <canvas id="mybarChart_categories"></canvas>
    <br/>&nbsp;<hr>
     <table class="table table_grafik" width="90%">
        <thead>
            <tr>
                <th width="70%">Risk Categories</th>
                <th class="text-center">Jumlah</th>
            </tr>
       </thead>
        <tbody>
            <?php
            $sum = 0;
            foreach($master as $row):?>
            <?php 
              $sum+= $row['jml'];
            ?>
            <tr>
                <td><?=$row['name']?></td>
                <td class="text-center"><?=$row['jml']?></td>
            </tr>
                <?php endforeach;?>
        </tbody>
    </table>
   <table class="table table_grafik" width="90%">
        <thead>
            <tr>
                <th width="70%">Total</th>
                <th class="text-center"><?= $sum; ?></th>
            </tr>
       </thead>
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
    }
    $data['data'] = [
            'labels'=>$labels,
            'datasets'=>
            [
                [
                'label'=>'Total ',
                'data'=> $nils,
                ]
            ]
            ];
    $data['judul']=['Risk Categories', 'Periode - '.$periode_name];
    $data = json_encode($data);

    // $option=['title'=>$post['title'], 'legend'=>$post['label'], 'position'=>$post['position_label'], 'type'=>$post['type_chart']];
    $option=['title'=>true, 'legend'=>true, 'position'=>'bottom'];

    $option=json_encode($option);
?>

<script>
    var data = <?=$data;?>;
    var option=<?=$option;?>;
    graph_categories (data, 'mybarChart_categories');

</script>


