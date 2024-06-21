<style>
    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        padding: 5px !important;
        text-align: center;
    }

    .w150 {
        width: 150px;
    }
    .w250 {
        width: 250px;
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
    <a href="<?= base_url('rcsa/cetak-register/excel/' . $id); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-excel-o"></i> Ms-Excel </a>
</span>
<span class="btn btn-warning btn-flat">
    <a href="<?= base_url('rcsa/cetak-register/pdf/' . $id); ?>" target="_blank" style="color:#ffffff;"><i class="fa fa-file-pdf-o"></i> PDF </a>
</span>
<div class="double-scroll" style='height:550px;'>
    <?php
	if ($tipe == 'pdf') : ?>
    <table class="table table-bordered table-sm" id="datatables_event" border="1" style="font-size:22pt !important;">
        <thead>
            <tr>
              <td colspan="23">Tanggal: <?php setlocale(LC_ALL, 'IND'); echo strftime('%A, %d %B %Y, %H:%M'); ?></td>
            </tr>
            <tr style="font-size:22pt !important;">
                <th rowspan="2">No</th>
                <th rowspan="2"><label class="w150">Area</label></th>
                <th rowspan="2"><label>Kategori</label></th>
                <th rowspan="2"><label>Risk Type</label></th>
                <th rowspan="2"><label class="w250">Risiko</label></th>
                <th rowspan="2"><label class="w250">Penyebab</label></th>
                <th rowspan="2"><label class="w250">Dampak Kualitatif</label></th>
                <th rowspan="1" colspan="6"><label>Analisis</label></th>
                <th rowspan="1" colspan="4"><label>Evaluasi</label></th>
            </tr>
            <tr style="font-size:22pt !important;">
                <th colspan="2">Probabilitas</th>
                <th colspan="2">Impact</th>
                <th colspan="2">Risk Level</th>
                <th><label class="w150">PIC</label></th>
                <th>Urgency</th>
                <th>Existing Control</th>
                <th>Risk Control<br>Assessment</th>
            </tr>
        </thead>
        <tbody>

            <?php
			if (count($field) == 0)
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$no = 0;
			$ttl_nil_dampak = 0;
			$ttl_exposure = 0;
			$ttl_exposure_residual = 0;
			$last_id = 0;
			foreach ($field as $key => $row) {
				$not = '';
				$tmp = ['', '', '', '', '', ''];
				if ($last_id != $row['id_rcsa_detail']) {
					++$no;
					$last_id = $row['id_rcsa_detail'];
					$not = $no;
					$tmp[0] = $row['area_name'];
					$tmp[1] = $row['kategori'];
					$tmp[2] = $row['sub_kategori'];
					$tmp[3] = $row['event_name'];
					$tmp[4] = format_list($row['couse'], "### ");
					$tmp[5] = $row['impact'];
				}
				?>
            <tr>
                <td><?= $not; ?></td>
                <td valign="top" style="width: 30%"><?= $tmp[0]; ?></td>
                <td valign="top"><?= $tmp[1]; ?></td>
                <td valign="top"><?= $tmp[2]; ?></td>
                <td valign="top"><?= $tmp[3]; ?></td>
                <td valign="top"><?= $tmp[4]; ?></td>
                <td valign="top"><?= $tmp[5]; ?></td>
                <td valign="top"><?= $row['level_like']; ?></td>
                <td valign="top"><?= $row['like_ket']; ?></td>
                <td valign="top"><?= $row['level_impact']; ?></td>
                <td valign="top"><?= $row['impact_ket']; ?></td>
                <td valign="top"><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
                <td valign="top"><?= $row['level_mapping']; ?></td>
                <td valign="top"><?= $row['penanggung_jawab']; ?></td>
                <td valign="top"><?= $row['urgensi_no']; ?></td>
                <td valign="top"><?= format_list($row['control_name']); ?></td>
                <td valign="top"><?= $row['control_ass']; ?></td>
            </tr>
            <?php 
		}
		?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="18">&nbsp;</th>
            </tr>
        </tfoot>
    </table>
    <br />
    <table class="table table-bordered table-sm" id="datatables_event" border="1" style="font-size:22pt !important;">
        <thead>
            <tr>
              <td colspan="23">Tanggal: <?php setlocale(LC_ALL, 'IND'); echo strftime('%A, %d %B %Y, %H:%M'); ?></td>
            </tr>
            <tr style="font-size:22pt !important;">
                <th rowspan="2">No</th>
                <th rowspan="2"><label class="w150">Area</label></th>
                <th rowspan="2"><label>Kategori</label></th>
                <th rowspan="2"><label>Risk Type</label></th>
                <th rowspan="2"><label class="w250">Risiko</label></th>
                <th rowspan="2"><label class="w250">Penyebab</label></th>
                <th rowspan="2"><label class="w250">Dampak Kualitatif</label></th>
                <th rowspan="2"><label class="w250">Dampak Kuantitatif</label></th>
                <th rowspan="1" colspan="2"><label>Risk Treatment Options</label></th>
                <th rowspan="2"><label class="w100">Accountabel Unit</label></th>
                <th rowspan="2"><label class="w80">Sumber Daya</label></th>
                <th rowspan="2"><label class="w80">Deadline</label></th>
            </tr>
            <tr style="font-size:22pt !important;">
                <th><label class="w150">Proaktif</label></th>
                <th><label class="w150">Reaktif</label></th>
            </tr>
        </thead>
        <tbody>

            <?php
			if (count($field) == 0)
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$no = 0;
			$ttl_nil_dampak = 0;
			$ttl_exposure = 0;
			$ttl_exposure_residual = 0;
			$last_id = 0;
			foreach ($field as $key => $row) {
				$not = '';
				$tmp = ['', '', '', '', '', ''];
				if ($last_id != $row['id_rcsa_detail']) {
					++$no;
					$last_id = $row['id_rcsa_detail'];
					$not = $no;
					$tmp[0] = $row['area_name'];
					$tmp[1] = $row['kategori'];
					$tmp[2] = $row['sub_kategori'];
					$tmp[3] = $row['event_name'];
					$tmp[4] = format_list($row['couse'], "### ");
					$tmp[5] = $row['impact'];
				}
				?>
            <tr>
                <td valign="top"><?= $not; ?></td>
                <td valign="top" style="width: 30%"><?= $tmp[0]; ?></td>
                <td valign="top"><?= $tmp[1]; ?></td>
                <td valign="top"><?= $tmp[2]; ?></td>
                <td valign="top"><?= $tmp[3]; ?></td>
                <td valign="top"><?= $tmp[4]; ?></td>
                <td valign="top"><?= $tmp[5]; ?></td>
                <td valign="top"><?= $row['risk_impact_kuantitatif'] ?></td>
                <td valign="top"><?= $row['proaktif']; ?></td>
                <td valign="top"><?= $row['reaktif']; ?></td>
                <td valign="top"><?= format_list($row['accountable_unit_name'], "### "); ?></td>
                <td valign="top"><?= $row['sumber_daya']; ?></td>
               <?php $originalDate = $row['target_waktu']; ?>
                <td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td>
            </tr>
            <?php 
		}
		?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=22>&nbsp;</th>
            </tr>
        </tfoot>
    </table>
    <?php
else : ?>
        <?php  foreach ($fields as $key1 => $row1) : ?>
<?php endforeach; ?>
    <table class="table table-bordered table-sm" id="datatables_event" border="1">
        <thead>
          <tr>
            <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="<?=img_url('logo.png');?>" width="100"></td>
            <td colspan="15" rowspan="6" style="text-align:center;border-left:none;"><h1>RISK REGISTER</h1></td>

            <td  rowspan="2" style="text-align:left;">No.</td>
            <td colspan="3" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $row1['periode_name']; ?></td>
</tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td rowspan="2"  style="text-align:left;">Revisi</td>
                <td colspan="3" rowspan="2"  style="text-align:left;">: 1</td>
            </tr>
            <tr><td style="border: none;"></td></tr>
            <tr>
                <td rowspan="2" style="text-align:left;">Tanggal Revisi</td>
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
                <th colspan="3"><label>Evaluasi Risiko</label></th>
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
                <!-- <th><label>Urgency</label></th> -->
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
			if (count($field) == 0)
				echo '<tr><td colspan=22 style="text-align:center">No Data</td></tr>';
			$no = 0;
            $num = 1;
			$ttl_nil_dampak = 0;
			$ttl_exposure = 0;
			$ttl_exposure_residual = 0;
			$last_id = 0;
			foreach ($field as $key => $row) {
				$not = '';
				$tmp = ['', '', '', '', '', ''];
				if ($last_id != $row['id_rcsa_detail']) {
					++$no;
					$last_id = $row['id_rcsa_detail'];
					$not = $no;
					$tmp[0] = $row['area_name'];
					$tmp[1] = $row['kategori'];
					$tmp[2] = $row['sub_kategori'];
					$tmp[3] = $row['event_name'];
                    $a = $row['couse'];
                    if (!empty($a)) {
                        $tmp[4] = format_list($a, "### ");
                    } else {
                        $tmp[4] = $a;
                    }
                    $b = $row['impact'];
                    if (!empty($b)) {
                        $tmp[5] = format_list($b, "### ");
                    } else {
                        $tmp[5] = $b;
                    }
                    $c = $row['penanggung_jawab'];
                    if (!empty($c)) {
                        $tmp[6] = format_list($c, "### ");
                    } else {
                        $tmp[6] = $c;
                    }
				}
				$urgensi = '';
				if (intval($row['urgensi_no']) > 0)
					$urgensi = '<span class="badge bg-green">' . $row['urgensi_no'] . '</span>';
				?>
            <tr>
                <td><?= $num++; ?></td>
                <!-- <td style="width: 50%"><?= $tmp[0]; ?></td> -->
                <td><?= $tmp[1]; ?></td>
                <td><?= $tmp[2]; ?></td>
                <td><?= $tmp[3]; ?></td>
                <td><?= $tmp[4]; ?></td>
                <td><?= $tmp[5]; ?></td>
                <td valign="top"><?= $row['risk_impact_kuantitatif'] ?></td>
                <td><?= $row['level_like']; ?></td>
                <td><?= $row['like_ket']; ?></td>
                <td><?= $row['level_impact']; ?></td>
                <td><?= $row['impact_ket']; ?></td>
                <td><?= intval($row['level_like']) * intval($row['level_impact']); ?></td>
                <td><?= $row['level_mapping']; ?></td>
                <!-- <td class="text-center"><?= $urgensi; ?></td> -->
                 <?php 
                $cn = $row['control_name'];
                if (!empty($cn)) : ?>
                    <td><?= format_list($cn); ?></td>
                 
                <?php else : ?>
                 <td><?= $cn; ?></td> 
                 <?php endif; ?>
                <!-- <td><?= format_list($row['control_name'], "### "); ?></td> -->
                <td><?= $row['control_ass']; ?></td>
                <td valign="top"><?= $row['treatment']; ?></td>
                <td><?= $row['proaktif']; ?></td>
                <td><?= $row['reaktif']; ?></td>
                <td><?= $tmp[6]; ?></td>
                <td><?= format_list($row['accountable_unit_name'], "### "); ?></td>
                <td><?= $row['sumber_daya']; ?></td>
               <?php $originalDate = $row['target_waktu']; ?>
                <td valign="top"><?= date("d-m-Y", strtotime($originalDate)); ?></td>
            </tr>
            <?php 
		}
		?>
        <?php
         
      
            foreach ($fieldxx as $key1 => $row1) : ?>
                <?php if ($row1['sts_next'] < 1 ) : ?>
            <tr>
                <td valign="top" style="text-align: center;"><?= $num++; ?></td>
                <td valign="top"><?= $row1['kategori']; ?></td> 
                <td valign="top"><?= $row1['sub_kategori']; ?></td> 
                <td valign="top"><?= $row1['event_name']; ?></td>
                <td valign="top"><?= format_list($row1['couse'], "### ");?></td>
                <td valign="top"><?= format_list($row1['impact'], "### ");?></td>
                <td valign="top" style="text-align: center;"><?= $row1['inherent_likelihood']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['ket_likelihood']; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['code_impact'][0]; ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['ket_impact']; ?></td>
                <td valign="top" style="text-align: center;"><?= intval($row1['inherent_likelihood']) * intval($row1['code_impact'][0]); ?></td>
                <td valign="top" style="text-align: center;"><?= $row1['inherent_analisis']; ?></td>  
                <!-- <td valign="top" style="text-align: center;"><?= $row1['urgensi_no']; ?></td> -->
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
        </tbody>
        <tfoot>
            <tr>
                <th colspan=22>&nbsp;</th>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
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
                    <th width="5%">N o.</th>
                    <th width="25%" class="text-left"> St atus</th>
                    <th class="text-left">K e t er angan</th>
                    <th width="10%">T anggal</th>
                    <th width="15%"> Petugas</th>
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