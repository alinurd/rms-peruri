
<?php
if($data){
  foreach ($data as $d) {
    $data_event = $this->db->where('rcsa_no', $d['id'])->get(_TBL_VIEW_RCSA_LOST_EVENT)->row_array();
    $lost_event = $this->db->where('rcsa_no', $d['id'])->get(_TBL_RCSA_LOST_EVENT)->row_array();
    if($lost_event){
      $row_in     = $this->db->where('impact_no', $lost_event['skal_prob_in'])->where('like_no', $lost_event['skal_dampak_in'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
      $row_res    = $this->db->where('impact_no', $lost_event['target_res_prob'])->where('like_no', $lost_event['target_res_dampak'])->get(_TBL_VIEW_MATRIK_RCSA)->row_array();
      $label_in   = "<span style='background-color:" . $row_in['warna_bg'] . ";color:" . $row_in['warna_txt'] . ";'>&nbsp;" . $row_in['tingkat'] . "&nbsp;</span>";
      $label_res  = "<span style='background-color:" . $row_res['warna_bg'] . ";color:" . $row_res['warna_txt'] . ";'>&nbsp;" . $row_res['tingkat'] . "&nbsp;</span>";
?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <!-- <td colspan="2" rowspan="3" style="text-align: center;border-right:none;"><img src="<?= img_url('logo.png'); ?>" width="90"></td> -->
        <td colspan="6" rowspan="3" style="text-align: center;border-left:none;vertical-align: middle;"><h4>LOSS EVENT DATABASE</h4></td>
        <td style="width: 24.5%;">No.</td>
        <td style="width: 24.5%;">: 001/RM-FORM/I/<?= $tahun; ?></td>
      </tr>
      <tr>
        <td>Revisi</td>
        <td>: 1</td>
      </tr>
      <tr>
        <td>Tanggal Revisi</td>
        <td>: 31 Januari <?= $tahun; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Owner</td>
        <td colspan="4" style="border: none;">: <?= $d['name']; ?></td>
      </tr>
      <tr>
        <td colspan="3" style="border: none;">Risk Agent</td>
        <td colspan="4" style="border: none;">: <?= $d['officer_name']; ?></td>
      </tr>
    </thead>
  </table>

  <div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Kejadian Risiko</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
            <tr>
                <th width="20%">Nama Kejadian (Event)</th>
                <td colspan="2">
                    <?= $data_event['event_name']?>
                </td>               
            </tr>

                <tr>
                    <th width="20%">Identifikasi Kejadian</th>
                    <td colspan="2">
                      <?= $lost_event['identifikasi_kejadian'];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Kategori Kejadian</th>
                    <td colspan="2">
                        <?= $kategori_kejadian[$lost_event['kategori']];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Sumber Penyebab</th>
                    <td colspan="2">
                      <?= $lost_event['sumber_penyebab'];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Penyebab Kejadian</th>
                    <td colspan="2">
                      <?= $lost_event['penyebab_kejadian'];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Penanganan Saat Kejadian</th>
                    <td colspan="2">
                      <?= $lost_event['penanganan'];?>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- ================ HUBUNGAN KEJADIAN RISIKO DENGAN RISK EVENT ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Hubungan Kejadian Risiko Dengan Risk Event</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th width="20%">Kategori Risiko</th>
                    <td colspan="3">
                      <?= $kat_risiko[$lost_event['kat_risiko']];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Hubungan Kejadian Risk Event</th>
                    <td colspan="3">
                      <?= $lost_event['hub_kejadian_risk_event'];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Analisis Risiko</th>
                    <td class="text-center" style="background-color: #e9ecef;">Skala Dampak</td>
                    <td class="text-center" style="background-color: #e9ecef;">Skala Probabilitas</td>
                    <td class="text-center" style="background-color: #e9ecef;">Level Risiko</td>
                </tr>
                <tr>
                    <th width="20%">Inheren</th>
                    <td>
                      <?= $cboLike[$lost_event['skal_dampak_in']];?>
                    </td>
                    <td>
                      <?= $cboImpact[$lost_event['skal_prob_in']];?>
                    </td>
                    <td align="center">
                        <span id="level_risiko_inher_label" class="text-center">
                            <?php
                                echo $label_in;
                            ?>
                        </span>
                        <span id="spinner-inherent" class="spinner"></span>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Target Residual</th>
                    <td>
                      <?= $cboLike[$lost_event['target_res_dampak']];?>
                    </td>
                    <td>
                      <?= $cboImpact[$lost_event['target_res_prob']];?>
                    </td>
                    <td align="center">
                        <span id="level_risiko_res_label" class="text-center">
                        <?php
                                echo $label_res;
                            ?>
                        </span>
                        <span id="spinner-inherent" class="spinner"></span>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



<!-- ================ RENCANA DAN REALISASI PERLAKUAN RISIKO ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Rencana dan Realisasi Perlakuan Risiko</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Mitigasi Yang Direncanakan</th>
                </tr>
                <tr>
                    <td>
                      <?= $lost_event['mitigasi_rencana'] ;?>
                    </td>
                </tr>
                <tr>
                    <th class="text-center">Realisasi Mitigasi</th>
                </tr>
                <tr>
                    <td>
                      <?= $lost_event['mitigasi_realisasi'] ;?>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- ================ ASURANSI ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Asuransi</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Status Asuransi</th>
                    <th class="text-center">Nilai Premi</th>
                    <th class="text-center">Nilai Klaim</th>
                </tr>
                <tr>
                    <td>
                      <?= $lost_event['status_asuransi'];?>
                    </td>
                    <td>
                      <?= ($lost_event['nilai_premi']) ? "Rp. ".number_format($lost_event['nilai_premi'],0,',',',') : "";?>
                    </td>
                    <td>
                      <?= ($lost_event['nilai_klaim']) ? "Rp. ".number_format($lost_event['nilai_klaim'],0,',',',') : "";?>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<div class="row">
     <!-- Perbaikan Mendatang -->
     <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Perbaikan Mendatang</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Rencana Perbaikan Mendatang</th>
                    <th width="20%" class="text-center">Pihak Terkait</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                      <?= $lost_event['rencana_perbaikan_mendatang'];?>
                    </td>
                    <td>
                      <?= $lost_event['pihak_terkait'];?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ================ KERUGIAN ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Kerugian</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th width="20%">Penjelasan Kerugian</th>
                    <td>
                      <?= $lost_event['penjelasan_kerugian'];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Nilai Kerugian</th>
                    <td>
                    <?= ($lost_event['nilai_kerugian']) ? "Rp. ".number_format($lost_event['nilai_kerugian'],0,',',',') : "";?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Kejadian Berulang</th>
                    <td>
                      <?php 
                         if ($lost_event['kejadian_berulang'] == 1) {
                            echo "Ya";
                        } else {
                            echo "Tidak";
                        }
                      ?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Frekuensi Kejadian</th>
                    <td>
                      <?= $frekuensi_kejadian[$lost_event['frekuensi_kejadian']];?>
                    </td>
                </tr>
                <tr>
                    <th width="20%">File</th>
                    <td>
                      <a href="<?= base_url('themes/upload/lost_event/'.$lost_event['file_path']) ?>" target="_blank"><?=$lost_event['file_path'];?></a>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php
    }
  }
}