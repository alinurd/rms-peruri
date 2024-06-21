

<div id="coba"> 
<table class="table table-bordered table-sm"  id="golum" border="5" style="display: none;">
    <!-- <table class="table table-bordered table-sm"  id="golum" border="5" > -->
<thead>
<tr>
<td colspan="3" rowspan="3" style="text-align: left;border-right:none;" ><img src="<?=img_url('logo.png');?>" width="90"></td>
<td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle !important;"> RISK CATEGORIES</td>
<td style="text-align: left;">No.</td>
<td style="text-align: left;">: 014/RM-FORM/I/<?= $post['tahun']; ?></td>
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
<!-- <tr>
<td colspan="2" style="text-align: left;">Bulan </td>
<td colspan="9" style="text-align: left;">: <?= $post['bulan2']; ?></td>
</tr> -->
</thead>
</table>
<div class="col-md-12 col-sm-6 col-xs-6">
    <canvas id="mybarChart"></canvas>
    <br/>&nbsp;<hr>
     <table class="table" width="90%">
        <thead>
            <tr>
                <th width="70%">Level Risiko</th>
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
   <table class="table" width="90%">
        <thead>
            <tr>
                <th width="70%">Total</th>
                <th class="text-center"><?= $sum; ?></th>
            </tr>
       </thead>
    </table>
</div>
<div class="hide">
    <canvas id="mybarChart2"></canvas>
    <br/>&nbsp;<hr>
    <table class="table" width="90%">
        <thead>
            <tr>
                <th width="70%">Level Risiko</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sum = 0;
            foreach($master2 as $row):?>
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
    <table class="table" width="90%">
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
    $data['judul']=[$post['title_text'], 'Periode - '.$periode[$post['periode_no']]];
    $data = json_encode($data);

    $labels=[];
    $nils=[];
    $colors=[];
    foreach ($master2 as $key=>$row){
        $labels[]=$row['name'];
        $nils[]=$row['jml'];
    }
    $data2['data'] = [
            'labels'=>$labels,
            'datasets'=>
            [
                [
                'label'=>'Total ',
                'data'=> $nils,
                ]
            ]
            ];
    $data2['judul']=[$post['title_text'], 'Periode - '.$periode[$post['periode_no']]];
    $data2 = json_encode($data2);

    // $option=['title'=>$post['title'], 'legend'=>$post['label'], 'position'=>$post['position_label'], 'type'=>$post['type_chart']];
    $option=['title'=>$post['title'], 'legend'=>$post['label'], 'position'=>$post['position_label']];

    $option=json_encode($option);
?>
<!-- <script src="https://cdn.jsdelivr.net/npm/jspdf@1.5.3/dist/jspdf.min.js"></script> -->
<!-- <script src="https://unpkg.com/jspdf@2.1.1/dist/jspdf.es.min.js"></script> -->
<!-- <script src="https://unpkg.com/jspdf-autotable@3.5.12/dist/jspdf.plugin.autotable.js"></script> -->

<script>
    var data = <?=$data;?>;
    var data2 = <?=$data2;?>;
    var option=<?=$option;?>;
    graph (data, 'mybarChart');
    graph (data2, 'mybarChart2');
//     var skillsSelect = document.getElementById("owner_no");
//     var owner1 = skillsSelect.options[skillsSelect.selectedIndex].text;
//     var owner = owner1.trim()
//     // console.log(owner)
//  $('#downloadPdf').on('click', function() {
// html2canvas(document.querySelector("#coba")).then(canvas => {
//     var doc = new jsPDF('l', 'mm', "a4");
//     var canvas_img = canvas.toDataURL("image/png");
//     doc.addImage(canvas_img, 'png', 10,10,280,180,"","FAST"); 
//     // doc.save('Risk-Categories.pdf')
//     doc.save("Risk-Categories-"+owner+".pdf")
// });
// });   

</script>


