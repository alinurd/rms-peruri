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
<!-- <span class="btn btn-primary btn-flat">
    <a href="<?= base_url('risk-breakdown-structure/cetak-register/excel/' . $id); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a>
</span> -->
<span class="btn btn-warning btn-flat">
    <a href="<?= base_url('risk-breakdown-structure/cetak-register/pdf/' . $id.'/'.$owner); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<?php  foreach ($fields as $key1 => $row1) : ?>
<?php endforeach; ?>
<div class="double-scroll" style='height:550px;'>
    <table class="table table-bordered table-sm" id="datatables_event" border="1">
        <thead>
       <tr>
            <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="100"></td>
            <td colspan="4" rowspan="6" style="text-align:center;border-left:none;"><h1>RISK BREAKDOWN STRUCTURE</h1></td>

            <td rowspan="2" style="text-align:left;">No.</td>
            <td rowspan="2" style="text-align:left;">: 003/RM-FORM/I/<?= $row1['periode_name']; ?></td>
</tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td rowspan="2"  style="text-align:left;">Revisi</td>
                <td rowspan="2"  style="text-align:left;">: 1</td>
            </tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td rowspan="2" style="text-align:left;">: 31 Januari <?= $row1['periode_name']; ?> </td>
             </tr>
            <tr><td style="border: none;"></td></tr>

  <tr>
    <td colspan="2" style="border: none;">Risk Owner</td>
    <td colspan="6" style="border: none;">: <?= $row1['name']; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="border: none;">Risk Agent</td>
    <td colspan="6" style="border: none;">: <?= $row1['officer_name']; ?></td>
  </tr>
  <tr>
    <td colspan="8" style="border: none;"></td>
  </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2"><label class="w250">Judul Assesment</label></th>   
                <th rowspan="2"><label class="w250">Sasaran</label></th>
                <th colspan="5"><label>Kategori</label></th>
          
            </tr>
            <tr>
                <th><label class="w250">Bisnis</label></th>
                <th><label class="w250">Hukum</label></th>
                <th><label class="w250">Finansial</label></th>
                <th><label class="w250">Strategis</label></th>
                <th><label class="w250">Operasional</label></th>
            </tr>

        </thead>
        <tbody>

            <?php
            $no = 0;
            foreach ($field as $key => $row) : ?> 
            <tr>
                <td rowspan="<?= count($row['sasaran']);?>" style="text-align: center;vertical-align: text-top;">
                    <?= ++$no; ?></td>
                <td rowspan="<?= count($row['sasaran']);?>" valign="top"><?= $row['judul'];?></td>

                <td valign="top"><?= $row['sasaran'][0];?></td>
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key2 => $value2) : ?>
                <?php if ($value2['kategori'] == "Bisnis" && $value2['sasaran'] == $row['sasaran'][0]): ?>
                     <li>   <?= $value2['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td>
                 <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key2 => $value2) : ?>
                <?php if ($value2['kategori'] == "Hukum Kepatuhan" && $value2['sasaran'] == $row['sasaran'][0]): ?>
                     <li>   <?= $value2['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                 <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key2 => $value2) : ?>
                <?php if ($value2['kategori'] == "Finansial" && $value2['sasaran'] == $row['sasaran'][0]): ?>
                     <li>   <?= $value2['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                 <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key2 => $value2) : ?>
                <?php if ($value2['kategori'] == "Strategis" && $value2['sasaran'] == $row['sasaran'][0]): ?>
                     <li>   <?= $value2['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                 <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key2 => $value2) : ?>
                <?php if ($value2['kategori'] == "Operasional" && $value2['sasaran'] == $row['sasaran'][0]): ?>
                     <li>   <?= $value2['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td>  

            </tr>     
                    
                <?php foreach ($row['sasaran'] as $key1 => $value1) : ?>  
                    <?php if ($key1 != 0) : ?>
                <tr>  
                 <td valign="top"><?= $value1;?></td>
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key3 => $value3) : ?>
                <?php if ($value3['kategori'] == "Bisnis" && $value3['sasaran'] == $value1): ?>
                     <li>   <?= $value3['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td>
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key3 => $value3) : ?>
                <?php if ($value3['kategori'] == "Hukum Kepatuhan" && $value3['sasaran'] == $value1): ?>
                     <li>   <?= $value3['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key3 => $value3) : ?>
                <?php if ($value3['kategori'] == "Finansial" && $value3['sasaran'] == $value1): ?>
                     <li>   <?= $value3['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key3 => $value3) : ?>
                <?php if ($value3['kategori'] == "Strategis" && $value3['sasaran'] == $value1): ?>
                     <li>   <?= $value3['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td> 
                <td valign="top">
                <ol>
                <?php foreach ($row['event'] as $key3 => $value3) : ?>
                <?php if ($value3['kategori'] == "Operasional" && $value3['sasaran'] == $value1): ?>
                     <li>   <?= $value3['risiko'];?> </li>
                    <?php endif ?>  
                <?php endforeach; ?>
               </ol>
                </td>  
                </tr>
                    <?php endif; ?>

                <?php endforeach;?>        
                    
            <?php endforeach;?>

        </tbody>
      <tr>
<?php if ($tgl == NULL): ?>
    <th colspan="9" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
<?php else : ?>
  <th colspan="9" style="text-align: right;border: none;font-size: 20px;font-style: normal;">
    Dokumen ini telah disahkan oleh Kepala Divisi
<?php if ($divisi == NULL) {
    echo $row['name'];
    }else{
    echo $divisi->name;
    } ?>
     Pada
<?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
foreach ($tgl as $key1 => $row1) {
  echo strftime("%d %B %Y", strtotime($row1['create_date']))
?>
<?php }  ?>
<?php endif; ?>
</th>

</tr>

</tfoot>

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