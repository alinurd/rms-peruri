<!-- <span class="btn btn-warning btn-flat"><a href="<?= base_url('risk-categories/cetak-graph/pdf/'); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
    </span> -->
    <div>
<a href="#" id="downloadPdf">Print Chart</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart"></canvas>
    <br/>&nbsp;<hr>
</div>
<div class="col-md-6 col-sm-6 col-xs-6">
    <canvas id="mybarChart2"></canvas>
    <br/>&nbsp;<hr>
</div>
<table class="table" width="100%" id="table-categories">
        <thead>
            <tr>
                <th width="25%">Level Risiko 1</th>
                <th>Jumlah</th>
                <th width="25%"></th>
                <th width="25%">Level Risiko 2</th>
                <th>Jumlah</th>
            </tr>
        <thead>
        <tbody>
            <?php
            foreach($master as $row):?>
            <?php
            foreach($master2 as $row1):?>
            <tr>
                <td><?=$row['name']?></td>
                <td class="text-center"><?=$row['jml']?></td>
                <td></td>
                <td><?=$row1['name']?></td>
                <td class="text-center"><?=$row1['jml']?></td>
            </tr>
            <?php endforeach;?>
            <?php endforeach;?>
            
        </tbody>
</table>
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
    $data2['judul']=[$post['title_text'], $bulan[$post['bulan']].' '.$periode[$post['periode_no']]];
    $data2 = json_encode($data2);

    // $option=['title'=>$post['title'], 'legend'=>$post['label'], 'position'=>$post['position_label'], 'type'=>$post['type_chart']];
    $option=['title'=>$post['title'], 'legend'=>$post['label'], 'position'=>$post['position_label']];

    $option=json_encode($option);
?>
<script src="https://cdn.jsdelivr.net/npm/jspdf@1.5.3/dist/jspdf.min.js"></script>
<!-- <script src="https://unpkg.com/jspdf@2.1.1/dist/jspdf.es.min.js"></script> -->
<script src="https://unpkg.com/jspdf-autotable@3.5.12/dist/jspdf.plugin.autotable.js"></script>

<script>
    var data = <?=$data;?>;
    var data2 = <?=$data2;?>;
    var option=<?=$option;?>;
    graph (data, 'mybarChart');
    graph (data2, 'mybarChart2');
 $('#downloadPdf').on('click', function() {
      var doc = new jsPDF()
    var canvas = document.querySelector("#mybarChart");
    var canvas_img = canvas.toDataURL("image/png",1.0);
  doc.addImage(canvas_img, 'png', 10, 50); 
  doc.autoTable({ html: '#table-categories' })
  doc.save('Risk-Categories.pdf')
    // var canvas = document.querySelector("#mybarChart");
    // var canvas_img = canvas.toDataURL("image/png",1.0); //JPEG will not match background color
    // var canvas1 = document.querySelector("#mybarChart2");
    // var canvas_img1 = canvas1.toDataURL("image/png",1.0); //JPEG will not match background color
    // var pdf = new jsPDF('landscape','in', 'letter'); //orientation, units, page size
    // pdf.addImage(canvas_img, 'png', 1,1, 10, 5);
    // htmlsource = $('#content_detail')[0];
    // console.log(htmlsource);
    // specialElementHandlers = {
    //     // element with id of "bypass" - jQuery style selector
    //     '#bypassme': function (element, renderer) {
    //         // true = "handled elsewhere, bypass text extraction"
    //         return true
    //     }
    // };
    //  margins = {
    //     top: 80,
    //     bottom: 60,
    //     left: 40,
    //     width: 522
    // };
    // pdf.fromHTML(
    // htmlsource, // HTML string or DOM elem ref.
    // margins.left, // x coord
    // margins.top, { // y coord
    //     'width': margins.width, // max width of content on PDF
    //     'elementHandlers': specialElementHandlers
    // });

    // // pdf.cellAddPage('contoh');
    // // pdf.addImage(canvas_img1, 'png', .20, 1.75, 10, 5); //image, type, padding left, padding top, width, height
    // // pdf.autoPrint(); //print window automatically opened with pdf
    // var blob = pdf.output("bloburl");
    // window.open(blob);

});   

</script>


