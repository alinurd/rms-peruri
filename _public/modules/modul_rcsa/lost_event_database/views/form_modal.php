<?php
// doi::dump($label_res);
if(!$lost_event){
    $chekya = "checked";
}else{
    if ($lost_event['kejadian_berulang'] == 1) {
        $chekya = "checked";
    } else {
        $chektdk = "checked";
    }
}



?>
<div class="row">
    <div class="col-md-6">
        <div style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Kejadian Risiko</h5>
            <table class="table table-bordered" style="background-color: white;">
                <input type="hidden" name="rcsa_no_e" id="rcsa_no_e" value="<?=$lost_event ? $lost_event['rcsa_no'] : $rcsa_no ?>">
                <input type="hidden" name="event_no" id="event_no" >
                <thead class="thead-light">
                <tr>
                    <th width="20%">Nama Kejadian (Event)</th>
                    <?php if($type === "edit") : ?>
                        <td colspan="2">
                            <?= $data_event['event_name']?>
                        </td>
                    <?php endif;?>

                    <?php if($type === "add") : ?>
                        <td width="70%" id="td_peristiwa">
                        <?= form_dropdown(
                            'id_detail',
                            $cboper,
                            $lost_event ? $lost_event['rcsa_detail_id'] : '',
                            'class="eventcombo select2 form-control" style="width:450px !important;" id="id_detail"' . $disable
                        ); ?>
                        <div class="text-danger" id="error-id_detail"></div>
                    </td>
                    <td width="10%" id="td_peristiwa_new">
                        <button type="button" class="btn btn-info <?= $hide_edit ?>" id="peristiwa_baru">New</button>
                    </td>
                    <td id="td_peristiwabaru">
                        <?= form_input(
                            'peristiwabaru',
                            $detail ? $detail['peristiwabaru'] : '',
                            'class="form-control" placeholder="Input Peristiwa Baru" id="peristiwabaru"'
                        ); ?>
                    </td>
                    <td id="td_peristiwa_lib" width="10%">
                        <button type="button" class="btn btn-info" id="peristiwa_lib">Library</button>
                    </td>
                    <?php endif;?>

                    
                </tr>

                    <tr>
                        <th width="20%">Identifikasi Kejadian</th>
                        <td colspan="2">
                            <textarea class="form-control" id="identifikasi_kejadian" cols="30" rows="5" required><?= $lost_event['identifikasi_kejadian'];?></textarea>
                            <div class="text-danger" id="error-identifikasi_kejadian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Kategori Kejadian</th>
                        <td colspan="2">
                            <?= form_dropdown('kategori', $kategori_kejadian, ($lost_event) ? $lost_event['kategori'] : '', 'class="select2 form-control" style="width:100%;" id="kategori"' . $disable); ?>
                            <div class="text-danger" id="error-kategori"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Sumber Penyebab</th>
                        <td colspan="2">
                            <input type="text" class="form-control" id="sumber_penyebab" name="sumber_penyebab" required value="<?= $lost_event['sumber_penyebab'];?>">
                            <div class="text-danger" id="error-sumber_penyebab"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Penyebab Kejadian</th>
                        <td colspan="2">
                            <textarea class="form-control" id="penyebab_kejadian" cols="30" rows="5" required><?= $lost_event['penyebab_kejadian'];?></textarea>
                            <div class="text-danger" id="error-penyebab_kejadian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Penanganan Saat Kejadian</th>
                        <td colspan="2">
                            <textarea class="form-control" id="penanganan" cols="30" rows="5" required><?= $lost_event['penanganan'];?></textarea>
                            <div class="text-danger" id="error-penanganan"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Hubungan Kejadian Risiko Dengan Risk Event</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Kategori Risiko</th>
                        <td colspan="3">
                        <?= form_dropdown('kat_risiko', $kat_risiko, ($lost_event) ? $lost_event['kat_risiko'] : '', 'class="select2 form-control" style="width:100%;" id="kat_risiko"' . $disable); ?>
                            <div class="text-danger" id="error-kat_risiko"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Hubungan Kejadian Risk Event</th>
                        <td colspan="3">
                            <input type="text" class="form-control" id="hub_kejadian_risk_event" name="hub_kejadian_risk_event" required value="<?= $lost_event['hub_kejadian_risk_event'];?>">
                            <div class="text-danger" id="error-hub_kejadian_risk_event"></div>
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
                            <?= form_dropdown('skal_dampak_in', $cboLike, (empty($lost_event['skal_dampak_in'])) ? '' : $lost_event['skal_dampak_in'], 'class="form-control" id="skal_dampak_in"'); ?>
                            <div class="text-danger" id="error-skal_dampak_in"></div>
                        </td>
                        <td>
                            <?= form_dropdown('skal_prob_in', $cboImpact, (empty($lost_event['skal_prob_in'])) ? '' : $lost_event['skal_prob_in'], 'class="form-control" id="skal_prob_in"'); ?>
                            <div class="text-danger" id="error-skal_prob_in"></div>
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
                            <?= form_dropdown('Target_Res_dampak', $cboLike, (empty($lost_event['target_res_dampak'])) ? '' : $lost_event['target_res_dampak'], 'class="form-control" id="Target_Res_dampak"'); ?>
                            <div class="text-danger" id="error-Target_Res_dampak"></div>
                        </td>
                        <td>
                            <?= form_dropdown('Target_Res_prob', $cboImpact, (empty($lost_event['target_res_prob'])) ? '' : $lost_event['target_res_prob'], 'class="form-control" id="Target_Res_prob"'); ?>
                            <div class="text-danger" id="error-Target_Res_prob"></div>
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
                <!-- Asuransi -->
        <div style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Asuransi</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th>Status Asuransi</th>
                        <th>Nilai Premi</th>
                        <th>Nilai Klaim</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control" id="status_asuransi" name="status_asuransi" value="<?= $lost_event['status_asuransi'];?>" required>
                            <div class="text-danger" id="error-status_asuransi"></div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="text" class="form-control rupiah" id="nilai_premi" name="nilai_premi" value="<?= number_format($lost_event['nilai_premi'],0,',',',');?>" required>
                            </div>
                            <div class="text-danger" id="error-nilai_premi"></div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="text" class="form-control rupiah" id="nilai_klaim" name="nilai_klaim" value="<?= number_format($lost_event['nilai_klaim'],0,',',',');?>" required>
                            </div>
                            <div class="text-danger" id="error-nilai_klaim"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Rencana dan Realisasi Perlakuan Risiko -->
    <div class="col-md-6">
        <div style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Rencana dan Realisasi Perlakuan Risiko</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Mitigasi Yang Direncanakan</th>
                        <th width="20%" class="text-center">Realisasi Mitigasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea class="form-control" id="mitigasi_rencana" name="mitigasi_rencana" readonly style="height: auto !important;"><?= $lost_event['mitigasi_rencana'] ;?></textarea>
                            <!-- <input type="text" class="form-control" id="mitigasi_rencana" name="mitigasi_rencana"readonly> -->
                            <div class="text-danger" id="error-mitigasi_rencana"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="mitigasi_realisasi" name="mitigasi_realisasi" value="-" readonly>
                            <div class="text-danger" id="error-mitigasi_realisasi"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
                            <textarea class="form-control" id="rencana_perbaikan_mendatang" cols="30" rows="5" required><?= $lost_event['rencana_perbaikan_mendatang'];?></textarea>
                            <div class="text-danger" id="error-rencana_perbaikan_mendatang"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="pihak_terkait" name="pihak_terkait" value="<?= $lost_event['pihak_terkait'];?>"  required>
                            <div class="text-danger" id="error-pihak_terkait"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
               <!-- Kerugian -->
        <div style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Kerugian</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Penjelasan Kerugian</th>
                        <td>
                            <textarea class="form-control" id="penjelasan_kerugian" cols="30" rows="5" required><?= $lost_event['penjelasan_kerugian'];?></textarea>
                            <div class="text-danger" id="error-penjelasan_kerugian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Nilai Kerugian</th>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="text" class="form-control rupiah" id="nilai_kerugian" name="nilai_kerugian" value="<?= number_format($lost_event['nilai_kerugian'],0,',',',');?>" required>
                            </div>
                            <div class="text-danger" id="error-nilai_kerugian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Kejadian Berulang</th>
                        <td>
                            <input type="radio" name="kejadian_berulang" id="ya" value="1" <?= $disable ?> <?= $chekya ?>> <label for="ya">Ya</label> &nbsp; &nbsp; &nbsp;
                            <input type="radio" name="kejadian_berulang" value="0" id="tidak" <?= $disable ?> <?= $chektdk ?>> <label for="tidak">Tidak</label>
                            <div class="text-danger" id="error-kejadian_berulang"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Frekuensi Kejadian</th>
                        <td>
                        <?= form_dropdown('frekuensi_kejadian', $frekuensi_kejadian, ($lost_event) ? $lost_event['frekuensi_kejadian'] : '', 'class="select2 form-control" style="width:100%;" id="frekuensi_kejadian"' . $disable); ?>
                            <div class="text-danger" id="error-frekuensi_kejadian"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="row text-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <a href="#" id="btn-simpan" class="btn btn-primary" data-edit="<?= ($type != 'add') ? $lost_event['id'] : '';?>"  data-type = "<?= $type;?>" >Simpan</a>
</div>
<!-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    $(document).ready(function() {
        // Hide the "Input Peristiwa Baru" and "Library" elements by default
        $('#td_peristiwabaru').hide();
        $('#td_peristiwa_lib').hide();

        // Optional: Show elements when "New" button is clicked
        $('#peristiwa_baru').on('click', function() {
            $('#td_peristiwa').hide();
            $('#td_peristiwa_new').hide();
            $('#td_peristiwabaru').show();
            $('#td_peristiwa_lib').show();
            $('#mitigasi_rencana').removeAttr('readonly');
        });

        // Optional: Show "Library" when a certain event occurs
        $('#peristiwa_lib').on('click', function() {
            $('#td_peristiwa').show();
            $('#td_peristiwa_new').show();
            $('#td_peristiwabaru').hide();
            $('#td_peristiwa_lib').hide();
            $('#mitigasi_rencana').attr('readonly', true);
        });
    });
</script>