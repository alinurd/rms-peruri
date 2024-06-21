<style>
    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        padding: 5px !important;
        text-align: center;
    }

    td ol {
        padding-left: 10px;
        width: 300px;
    }

    td ol li {
        margin-left: 5px;
    }
</style>

<span class="btn btn-warning btn-flat">
    <a href="#" id="coba" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> Data </a>
</span>
<div class="double-scroll">
    <table class="table table-bordered table-sm"  border="1">
    <thead>
      <tr>
            <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="100"></td>
            <td colspan="3" rowspan="6" style="text-align:center;border-left:none;"><h1>ACCOUNTABLE UNIT MAPPING</h1></td>

            <td rowspan="2" style="text-align:left;">No.</td>
            <td rowspan="2" style="text-align:left;">: 007/RM-FORM/I/ <?= $post['tahun']; ?></span></td>
</tr>
            <tr><td style="border: none;padding: 0;margin: 0;"></td></tr>
            <tr>
                <td rowspan="2"  style="text-align:left;">Revisi</td>
                <td rowspan="2"  style="text-align:left;">: 1</td>
            </tr>
            <tr><td style="border: none;padding: 0;margin: 0;"></td></tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td rowspan="2" style="text-align:left;">: 31 Januari <?= $post['tahun']; ?> </td>
             </tr>
            <tr><td style="border: none;padding: 0;margin: 0;"></td></tr>
<tr>
    <td colspan="7" style="border: none;text-align: left;">Accountable Unit : <?= $post['unit']; ?></td>
</tr>
<tr>
    <td colspan="7" style="border: none;"></td>
</tr>
    <tr>
        <th>No</th>
        <th>Risk Owner</th>
        <th>Judul Assesment</th>
        <th>Sasaran</th>
        <th>Peristiwa Risiko</th>
        <th colspan="2">Accountable Unit</th>

    </tr>
    </thead>
    <tbody>
       <?php $no=1;
     
        foreach ($coba as $key1 => $value1) : ?>
 
<tr>
       <td style="text-align: center;"><?=$no++;?></td>
       <td><?=$value1['area_name'];?></td>
       <td><?=$value1['judul_assesment']; ?></td>

       <td><?=$value1['sasaran'];?></td>
       <td><?=$value1['event_name'];?></td>
        <td valign="TOP" colspan="2">
           <?=format_list($value1['owner'], "###");?>
        </td>


</tr>

<?php endforeach;?>

        </tbody>
<tfoot>

</tfoot>
</table>
</div>