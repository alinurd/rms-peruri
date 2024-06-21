
<div id="coba"> 
<table class="table table-bordered table-sm"  id="golum" border="5" style="display: none;">
    <!-- <table class="table table-bordered table-sm"  id="golum" border="5" > -->
<thead>
<tr>
<td colspan="3" rowspan="3" style="text-align: left;border-right:none;" ><img src="<?=img_url('logo.png');?>" width="90"></td>
<td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle !important;"> RISK DISTRIBUTION</td>
<td style="text-align: left;">No.</td>
<td style="text-align: left;">: 011/RM-FORM/I/<?= $post['tahun']; ?></td>
</tr>
<tr>
<td style="text-align: left;">Revisi</td>
<td style="text-align: left;">: 1</td>
</tr>
<tr>
<td style="text-align: left;">Tanggal Revisi</td>
<td style="text-align: left;">: 31 Januari <?= $post['tahun']; ?></td>
</tr>
<tr>
<td colspan="2" style="text-align: left;">Risk Owner </td>
<td colspan="9" style="text-align: left;">: <?= $post['owner_name']; ?></td>
</tr>
<tr>
<td colspan="2" style="text-align: left;">Bulan </td>
<td colspan="9" style="text-align: left;">: <?= $post['bulan2']; ?></td>
</tr>
</thead>
</table>
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart"></canvas>
    <center>Grafik Saat Menilai Level Risiko </center>
    <br/>&nbsp;<hr>
    <table class="table" width="90%">
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
    <table class="table" width="90%">
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
    $data['judul']=[$post['title_text'], 'Periode - '.$periode[$post['periode_no']]];
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
    $data2['judul']=[$post['title_text'], $bulan[$post['bulan']].' '.$periode[$post['periode_no']]];
    $data2 = json_encode($data2);

    $option=['title'=>true, 'legend'=>true, 'position'=>$post['position_label'], 'type'=>$post['type_chart']];
    $option=json_encode($option);
?>

<script>
    var data = <?=$data;?>;
    var data2 = <?=$data2;?>;
    var option=<?=$option;?>;
    graph (data, 'mybarChart');
    graph (data2, 'mybarChart2');
</script>