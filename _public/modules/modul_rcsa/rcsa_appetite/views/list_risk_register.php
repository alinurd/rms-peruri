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
<span class="btn btn-primary btn-flat">
    <a href="<?= base_url('rcsa/cetak-register/excel/' . $id.'/'.$owner); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a>
</span>
<span class="btn btn-warning btn-flat">
    <a href="<?= base_url('rcsa/cetak-register/pdf/' . $id.'/'.$owner); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<!-- <h1>Risk Register</h1> -->
<?php  foreach ($fields as $key1 => $row1) : ?>
<?php endforeach; ?>
<div class="double-scroll" style='height:550px;'>
    <table class="table table-bordered table-sm" id="datatables_event" border="1">
        <thead>     
<tr>
            <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="100"></td>
            <td colspan="15" rowspan="6" style="text-align:center;border-left:none;"><h1>RISK REGISTER</h1></td>

            <td colspan="2" rowspan="2" style="text-align:left;">No.</td>
            <td colspan="3" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $row1['periode_name']; ?></td>
</tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td colspan="2" rowspan="2"  style="text-align:left;">Revisi</td>
                <td colspan="3" rowspan="2"  style="text-align:left;">: 1</td>
            </tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="3" rowspan="2" style="text-align:left;">: 31 Januari <?= $row1['periode_name']; ?> </td>
             </tr>
            <tr><td style="border: none;"></td></tr>
  <tr>
    <td colspan="22" style="border: none;"></td>
  </tr>

  <tr>
    <td colspan="2" style="border: none;">Risk Owner</td>
    <td colspan="20" style="border: none;">: <?= $row1['name']; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="border: none;">Risk Agent</td>
    <td colspan="20" style="border: none;">: <?= $row1['officer_name']; ?></td>
  </tr>
  <tr>
    <td colspan="22" style="border: none;"></td>
  </tr>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2"><label>Kategori</label></th>
                <th rowspan="2"><label>Sub Kategori</label></th>
                <th colspan="4"><label>Identifikasi Risiko</label></th>
                <th colspan="6"><label>Analisis Risiko</label></th>
                <th colspan="4"><label>Evaluasi Risiko</label></th>
                <th colspan="6"><label>Treatment Risiko</label></th>
            </tr>
            <tr>
                <th><label class="w250">Risiko</label></th>
                <th><label class="w250">Penyebab</label></th>
                <th><label class="w250">Dampak Kualitatif</label></th>
                <th><label class="w250">Dampak Kuantitatif</label></th>
                <th colspan="2"><label>Probabilitas</label></th>
                <th colspan="2"><label>Impact</label></th>
                <th colspan="2"><label>Risk Level</label></th>             
                <th><label>Urgency</label></th>
                <th><label>Existing Control</label></th>
                <th><label>RCA</label></th>
                <th><label>Hasil Evaluasi</label></th>
                <th><label>Proaktif</label></th>
                <th><label>Reaktif</label></th>
                <th><label>Accountable Unit</label></th>
                <th><label>PIC</label></th>
                
                <th><label>Sumber Daya</label></th>
                <th><label>Deadline</label></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($field as $key => $row) : ?>
            <tr>
                <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                <td valign="top"><?= $row['kategori']; ?></td>
                <td valign="top"><?= $row['sub_kategori']; ?></td>
                <td valign="top"><?= $row['event_name']; ?></td>
                <td valign="top"><?= format_list($row['couse'], "### ");?></td>
                <td valign="top"><?= format_list($row['impact'], "### ");?></td>
                <td valign="top"><?= $row['risk_impact_kuantitatif'] ?></td>
                <td valign="top" style="text-align: center;"><?= $row['level_like']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row['like_ket']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row['level_impact']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row['impact_ket']; ?></td>
                <td valign="top" style="text-align: center;"><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
                <td valign="top" style="text-align: center;"><?= $row['level_mapping']; ?></td>          
                <td valign="top" style="text-align: center;"><?= $row['urgensi_no_kadiv']; ?></td>
                <td valign="top"><?= format_list($row['control_name'],"###"); ?></td>
                <td valign="top"><?= $row['control_ass']; ?></td>
                <td valign="top"><?= $row['treatment']; ?></td>
                <td valign="top"><?= $row['proaktif']; ?></td>
                <td valign="top"><?= $row['reaktif']; ?></td>
           
                <td valign="top"><?=format_list($row['penanggung_jawab'], "### ");?></td>
                <td valign="top"><?= format_list($row['accountable_unit_name'], "### "); ?></td>
                <td valign="top"><?= $row['sumber_daya']; ?></td>
               <?php $originalDate = $row['target_waktu']; ?>
                <td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php
         
      
            foreach ($fieldxx as $key1 => $row1) : ?>
                <?php if ($row1['sts_next'] < 1 ) : ?>
            <tr>
                <td valign="top" style="text-align: center;"><?= $no++; ?></td>
                <td valign="top"><?= $row1['kategori']; ?></td> 
                <td valign="top"><?= $row1['sub_kategori']; ?></td> 
                <td valign="top"><?= $row1['event_name']; ?></td>
                <td valign="top"><?= format_list($row1['couse'], "### ");?></td>
                <td valign="top"><?= format_list($row1['impact'], "### ");?></td>
                <td valign="top" style="text-align: center;"><?= $row1['inherent_likelihood']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['ket_likelihood']; ?></td>
                <td valign="top" style="text-align: center;"><?= ($row1['code_impact'])?$row1['code_impact'][0]:0; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['ket_impact']; ?></td>
                <td valign="top" style="text-align: center;"><?= ($row1['code_impact'])?intval($row1['inherent_likelihood']) * intval($row1['code_impact'][0]):0; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['inherent_analisis']; ?></td>  
                <td valign="top" style="text-align: center;"><?= $row1['urgensi_no_kadiv']; ?></td>
                <td valign="top"><?= format_list($row1['control_name'],"###"); ?></td>
                <td valign="top"><?= $row1['risk_control']; ?></td>
                <td valign="top"><?= $row1['treatment']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="22" style="border: none;">&nbsp;</th>
            </tr>
        </tbody>
        <!-- <tfoot> -->


            <tr>
            <?php if ($tgl == NULL): ?>
                <th colspan="22" style="text-align: right;border: none;font-size: 20px;font-style: normal;"></th>
            <?php else : ?>
              <th colspan="22" style="text-align: right;border: none;font-size: 20px;font-style: normal;">
                Dokumen ini telah disahkan oleh Kepala Divisi 
                <?php if ($divisi == NULL) {
                   echo $row1['name'];
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
      
        <!-- </tfoot> -->
    </table>
</div>

<?php
if (isset($log)) : ?>
<div class="row">
    <br />
    Log Aktifitas<br />
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="25%" class="text-left"> Status</th>
                    <th class="text-left">Keterangan</th>
                    <th width="10%">Tanggal</th>
                    <th width="15%">Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                foreach ($log as $row) : ?>
                <tr>
                    <td><?= ++$no; ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td><?= $row['note']; ?></td>
                    <td><?= $row['create_date']; ?></td>
                    <td><?= $row['create_user']; ?></td>
                </tr>
                <?php 
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
endif; ?>

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