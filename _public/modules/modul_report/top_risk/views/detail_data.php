<style>
    .modal{
        z-index: 2050;
    }
    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        padding: 5px !important;
        text-align: center;
    }
   .w250 {
        width: 250px;
    }

    .w150 {
        width: 150px;
    }

    .w100 {
        width: 100px;
    }

    .w80 {
        width: 80px;
    }

    .w50 {
        width: 50px;
    }

    td ol {
        padding-left: 10px;
        width: 300px;
    }

    td ol li {
        margin-left: 5px;
    }
</style>
<span class="btn btn-warning btn-flat"><a href="#" style="color:#ffffff;" id="downloadPdf"><i class="fa fa-file-pdf-o"></i> Chart </a>
</span>
<span class="btn btn-warning btn-flat">
    <a href="#" id="coba" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> Data </a>
</span>
<input type="hidden" id="owner1" name="owner1" value="<?= $filter['owner'];?>">
<input type="hidden" id="tahun1" name="tahun1" value="<?= $filter['tahun'];?>">
<input type="hidden" id="bulan1" name="bulan1" value="<?= $filter['bulan'];?>">
<input type="hidden" id="bulan2" name="bulan2" value="<?= $filter['bulan2'];?>">
<input type="hidden" id="tahun2" name="tahun2" value="<?= $filter['tahun2'];?>">
<div class="double-scroll">
    <table class="table table-bordered table-sm"  border="1">
        <thead>

            <tr>
            <td colspan="2" rowspan="3" style="text-align: left;border-right:none;" ><img src="<?=img_url('logo.png');?>" width="90"></td>
            <td colspan="2" rowspan="3" style="text-align: center;font-size: 24px;border-left:none;">TOP RISK</td>
            <td colspan="2" style="text-align: left;">No.</td>
            <td style="text-align: left;">: 009/RM-FORM/I/<?= $tahun2;?></td>
          </tr>
          <tr>
            <td colspan="2"  style="text-align: left;">Revisi</td>
            <td style="text-align: left;">: 1</td>
          </tr>
          <tr>
            <td colspan="2"  style="text-align: left;">Tanggal Revisi</td>
            <td style="text-align: left;">: 31 Januari <?= $tahun2;?></td>
          </tr>
<tr>
    <td colspan="2" style="text-align: left;">Risk Owner </td>
    <td colspan="5" style="text-align: left;">: <?= $owner1;?></td>
</tr>
<tr>
    <td colspan="2" style="text-align: left;">Bulan </td>
    <td colspan="5" style="text-align: left;">: <?= $bulan2;?></td>
</tr>
      </thead>
      <tbody>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Risk Owner</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Peristiwa Risiko</th>
                <th class="text-center">Inherent</th>
                <th class="text-center">Residual</th>
                <th class="text-center">Proaktif</th>
            </tr>
            <?php
            $no=0;
            foreach($data['bobo'] as $row):

            ?>
            <tr>
                <td style="text-align: center;"><?=++$no;?></td>
                <td style="text-align: left;"><?=$row['name'];?></td>
                <td style="text-align: center;"><?=$row['kategori'];?></td>
                <td><?=$row['event_name'];?></td>
              <td style="background-color:<?=$row['warna'];?>;color:<?=$row['warna_text'];?>;"><?=$row['inherent_analisis'];?></td>
          
        <?php
       $a = $data['baba'][$row['id']]['inherent_analisis_action'];
       $b = $data['baba'][$row['id']]['warna_action'];
       $c = $data['baba'][$row['id']]['warna_text_action'];
       ?>
       <td style="background-color:<?=$b;?>;color:<?=$c;?>;"><?=$a;?></td>
                  
                <td style="text-align: left;">
                <?php $a = intval($row['id']); ?>
                <?php if (isset($proaktif[$a])) : ?>
                <?php foreach($proaktif[$a] as $row1): ?>
                       <?=$row1;?> 
                <?php endforeach;?>
                <?php else: ?>
                     <?= "";?>
                 <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>  
          </tbody>   
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.double-scroll').doubleScroll({
            resetOnWindowResize: true,
            scrollCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
            contentCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
        });
        $(window).resize();
    });
</script> 
<script>
$("#downloadPdf").on('click', function() {
    var d = new Date();
    var tgl = d.getDate()  + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
    var skillsSelect = document.getElementById("owner_no");
    var owner1 = skillsSelect.options[skillsSelect.selectedIndex].text;
    var owner = owner1.trim()
    $("#golum").show();
        html2canvas(document.querySelector("#diagram")).then(canvas => {
    var doc = new jsPDF('l', 'mm', "a4");

    var canvas_img = canvas.toDataURL("image/png");
    doc.addImage(canvas_img, 'png', 10,10,280,180,"","FAST"); 
  
    doc.save("Top-Risk-"+owner+"-"+tgl+".pdf")
    $("#golum").hide();
   })

    });     
</script>