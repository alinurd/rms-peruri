<?php
// doi::dump($label_res);
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Kejadian Risiko</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Nama Kejadian (Event)</th>
                        <th><input style="background-color: #367FA9; color: white; border: none;" type="text" class="form-control" id="nm_event" name="nm_event" value="<?= $action_detail['event_name']?>" readonly></th>
                    </tr>
                    <tr>
                        <th width="20%">Identifikasi Kejadian</th>
                        <td>
                            <textarea class="form-control" id="identifikasi_kejadian" cols="30" rows="5" required><?= $lost_event['identifikasi_kejadian'];?></textarea>
                            <div class="text-danger" id="error-identifikasi_kejadian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Kategori Kejadian</th>
                        <td>
                            <input type="text" class="form-control" id="kategori" name="kategori" required value="<?= $lost_event['kategori'];?>">
                            <div class="text-danger" id="error-kategori"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Sumber Penyebab</th>
                        <td>
                            <input type="text" class="form-control" id="sumber_penyebab" name="sumber_penyebab" required value="<?= $lost_event['sumber_penyebab'];?>">
                            <div class="text-danger" id="error-sumber_penyebab"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Penyebab Kejadian</th>
                        <td>
                            <textarea class="form-control" id="penyebab_kejadian" cols="30" rows="5" required><?= $lost_event['penyebab_kejadian'];?></textarea>
                            <div class="text-danger" id="error-penyebab_kejadian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Penanganan Saat Kejadian</th>
                        <td>
                            <textarea class="form-control" id="penanganan" cols="30" rows="5" required><?= $lost_event['penanganan'];?></textarea>
                            <div class="text-danger" id="error-penanganan"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <br>
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
            <h5 class="text-center" style="color: #343a40;">Hubungan Kejadian Risiko Dengan Risk Event</h5>
            <table class="table table-bordered" style="background-color: white;">
                <thead class="thead-light">
                    <tr>
                        <th width="20%">Kategori Risiko</th>
                        <td colspan="3">
                            <input type="text" class="form-control" id="kat_risiko" name="kat_risiko" required value="<?= $lost_event['kat_risiko'];?>">
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
        <br>

        <!-- Asuransi -->
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
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
                                <input type="text" class="form-control" id="nilai_premi" name="nilai_premi" value="<?= $lost_event['nilai_premi'];?>" required>
                            </div>
                            <div class="text-danger" id="error-nilai_premi"></div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">Rp.</span>
                                <input type="text" class="form-control" id="nilai_klaim" name="nilai_klaim" value="<?= $lost_event['nilai_klaim'];?>" required>
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
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
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
                            <input type="text" class="form-control" id="mitigasi_rencana" name="mitigasi_rencana" value="<?= $lost_event['mitigasi_rencana'];?>" required>
                            <div class="text-danger" id="error-mitigasi_rencana"></div>
                        </td>
                        <td>
                            <input type="text" class="form-control" id="mitigasi_realisasi" name="mitigasi_realisasi" value="<?= $lost_event['mitigasi_realisasi'];?>" required>
                            <div class="text-danger" id="error-mitigasi_realisasi"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>

        <!-- Perbaikan Mendatang -->
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
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
        <br>
        <!-- Kerugian -->
        <div class="mb-2" style="background-color: white; padding: 10px; border-radius: 10px;">
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
                                <input type="text" class="form-control" id="nilai_kerugian" name="nilai_kerugian" value="<?= $lost_event['nilai_kerugian'];?>" required>
                            </div>
                            <div class="text-danger" id="error-nilai_kerugian"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Kejadian Berulang</th>
                        <td>
                            <input type="text" class="form-control" id="kejadian_berulang" name="kejadian_berulang" value="<?= $lost_event['kejadian_berulang'];?>" required>
                            <div class="text-danger" id="error-kejadian_berulang"></div>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Frekuensi Kejadian</th>
                        <td>
                            <input type="text" class="form-control" id="frekuensi_kejadian" name="frekuensi_kejadian" value="<?= $lost_event['frekuensi_kejadian'];?>" required>
                            <div class="text-danger" id="error-frekuensi_kejadian"></div>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="row text-center">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <a href="#" id="btn-simpan" class="btn btn-primary" data-edit="<?= ($type != 'add') ? $lost_event['id'] : '';?>" data-id="<?= $action_detail['rcsa_detail_no'];?>" data-month="<?= ($type != 'add') ? $lost_event['bulan'] : $action_detail['bulan'];?>" data-type = "<?= $type;?>" >Simpan</a>
</div>
